<?
	require('../../../../util/header.inc');
	include('../../../clases/class_Reporte.php');
	include('../../../clases/class_Membrete.php');
	
	/*if($_PERFIL==0){
		echo "<pre>";
		print_r($_GET);
		echo "<pre>";
		}*/

	

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno		    =$c_alumno;
	$reporte		=$c_reporte;
	//$periodo		=$cmb_periodos;
	$taller			=$opc_Taller;
	$estadistica	=$opc_estadistica;
	$obs			=$opc_obs;
	$tipo_rep		=$tipo_rep;
	$anotacion		=$opc_Anotacion;
	$colilla		=$opc_Colilla;
	$muestra_notas	=$Mnotas;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	/****************DATOS PERIODO************/
	$ob_reporte ->ano=$ano;
	$ob_reporte ->periodo=$periodo;
	$ob_reporte ->Periodo($conn);
	$periodo_pal = $ob_reporte->nombre_periodo . " DEL " . $nro_ano;
	$result1 = $ob_reporte->result;
	$dias_habiles = $ob_reporte->dias_habiles;
	$fecha_ini = $ob_reporte->fecha_inicio;
	$fecha_fin = $ob_reporte->fecha_termino;
	
	$ob_reporte ->ano = $ano; 
	$resultPeri = $ob_reporte ->TotalPeriodo($conn);
	$num_periodos = @pg_numrows($resultPeri);
	if ($num_periodos==2) $tipo_per = "SE";
	if ($num_periodos==3) $tipo_per = "TR";		
	
	//***todos los periodos
	$pp= $ob_membrete ->periodoALL($conn);  
	$d_per=pg_numrows($pp);
	$siglap=($d_per==3)?"TR":"S";
	$palp=($d_per==3)?"TRIMESTRE":"SEMESTRE";

	
	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************** CURSO ***********************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if($institucion == 770){		

		$sqlInstit="select * from institucion where rdb=".$institucion;
		$resultInstit=@pg_Exec($conn, $sqlInstit);
		$filaInstit=@pg_fetch_array($resultInstit);
		
		$sql_reg="select nom_reg from region where cod_reg =". $filaInstit['region'];
		$res_reg = pg_exec($conn, $sql_reg);
		$fila_reg = pg_fetch_array($res_reg);
		
		$sql_pro="select nom_pro from provincia where cod_reg=".$filaInstit['region']." and cor_pro =".$filaInstit['ciudad'];
		$res_pro=pg_exec($conn, $sql_pro);
		$fila_pro = pg_fetch_array($res_pro);
		
		$sql_com="select nom_com from comuna where cod_reg=". $filaInstit['region'] ." and cor_pro =".$filaInstit['ciudad']." and cor_com=".$filaInstit['comuna'];
		$res_com=pg_exec($conn, $sql_com);
		$fila_com = pg_fetch_array($res_com);	 

		$fecha = strftime("%d %m %Y");		
}				  


   if ($institucion==770){
	    // DATOS CURSO //
		//--------------------------------------------------------------------------	
		$sql_curso = "SELECT plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.truncado_per, curso.truncado_final ";
		$sql_curso = $sql_curso . "FROM (curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
		$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso."));";
		$result_curso = @pg_Exec($conn, $sql_curso);
		$fila_curso = @pg_fetch_array($result_curso ,0);
		$decreto_eval = $fila_curso['nombre_decreto_eval'];
		$planes = $fila_curso['nombre_decreto'];
		 $truncado_per = $fila_curso['truncado_per'];
		$truncado_final = $fila_curso['truncado_final'];
		//----------------------------------------------------------------------------
	}	

				  

	if($cb_ok!="Buscar"){
		$xls=1;
	}
		 
	if($xls==1){	 
	$fecha_actual = date('d/m/Y-H:i:s');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Parciales_alumno_$fecha_actual.xls"); 	 
	}

$arr_promedio_periodo=array();
$arr_pf_final=array();
$arr_pf_final_conceptual=array();


function to_roman($num) {
if ($num <0 || $num >9999) {return -1;}
$r_ones = array(1=>"I", 2=>"II", 3=>"III", 4=>"IV", 5=>"V", 6=>"VI", 7=>"VII", 8=>"VIII",
9=>"IX");
$r_tens = array(1=>"X", 2=>"XX", 3=>"XXX", 4=>"XL", 5=>"L", 6=>"LX", 7=>"LXX",
8=>"LXXX", 9=>"XC");
$r_hund = array(1=>"C", 2=>"CC", 3=>"CCC", 4=>"CD", 5=>"D", 6=>"DC", 7=>"DCC",
8=>"DCCC", 9=>"CM");
$r_thou = array(1=>"M", 2=>"MM", 3=>"MMM", 4=>"MMMM", 5=>"MMMMM", 6=>"MMMMMM",
7=>"MMMMMMM", 8=>"MMMMMMMM", 9=>"MMMMMMMMM");
$ones = $num % 10;
$tens = ($num - $ones) % 100;
$hundreds = ($num - $tens - $ones) % 1000;
$thou = ($num - $hundreds - $tens - $ones) % 10000;
$tens = $tens / 10;
$hundreds = $hundreds / 100;
$thou = $thou / 1000;
if ($thou) {$rnum .= $r_thou[$thou];}
if ($hundreds) {$rnum .= $r_hund[$hundreds];}
if ($tens) {$rnum .= $r_tens[$tens];}
if ($ones) {$rnum .= $r_ones[$ones];}
return $rnum;
}

?>
<script language="javascript" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
//-->

function cerrar(){ 
	window.close() 
} 
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>INFORME DE NOTAS PARCIALES</title>
<STYLE>
body{
font-family:Verdana, Arial, Helvetica, sans-serif;
}
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
 .titulo
 {
 font-family:Verdana, Arial, Helvetica, sans-serif;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:Verdana, Arial, Helvetica, sans-serif;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:Verdana, Arial, Helvetica, sans-serif;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
 .nota
 {font-size:11px;}
 
 .rojo
 {color:red;}
 
  .azul
 {color:black;}

</style>
</head>
<!---->
<body >
<div id="capa0" align="center">
*Este reporte debe imprimirse en hoja tama&ntilde;o oficio y de manera horizontal
<table width="650" align="center">
  <tr>
    <td width="188"><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR" /></td>
    <td width="367" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></td>
    <td width="79" align="right"><input name="cb_exp" type="button" onClick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR" /></td>
  </tr>
</table>
</div>
<?
	if (empty($alumno)){
	
		$ob_reporte ->curso = $curso;
		$ob_reporte ->ano = $ano;
		$ob_reporte ->retirado =0;
		$ob_reporte ->orden =$ck_orden;
		$result_alu =$ob_reporte ->TraeTodosAlumnos($conn);
	}else{
		$ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano = $ano;
		$ob_reporte ->curso = $curso;
		$result_alu =$ob_reporte ->TraeUnAlumno($conn);
	}	
	$cont_alumnos = @pg_numrows($result_alu);

	
	
	for($cont_paginas=0 ; $cont_paginas < $cont_alumnos; $cont_paginas++)
{
	$suma_prom_gral=0;
	$cont_prom_gral=0;
	$prome_general_pro = 0;
	$cont_general_pro = 0;
	$suma_prom_curso = 0;
	$cont_prom_curso = 0;
	$prome_semestral_coef=0;
	$cuenta_semestral_coef=0;
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	$bool_ed = $fila_alu['bool_ed'];
	
	/******************** CON ESTADISTICA ******************************/
	
		
	$ob_reporte ->alumno = $alumno;
	$ob_reporte ->ano = $ano;
	$ob_reporte ->fecha_inicio=$fecha_ini;
	$ob_reporte ->fecha_termino = $fecha_fin;
	$result13 = $ob_reporte ->Asistencia($conn);
	if (!$result13){
		  error('<B> ERROR :</b>Error al acceder a la BD. (ASISTENCIA)</B>');
	}else{
		if (pg_numrows($result13)!=0){
		  $fila13 = @pg_fetch_array($result13,0);	
		  if (!$fila13){
			  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			  exit();
		  }
		}
	}
	$sql = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = ".$alumno." and ano = ".$ano." and (fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."') AND id_curso =".$curso." ORDER BY fecha ASC";
	$rs_justifica = @pg_exec($conn,$sql);
	//if($Just_Asis==1){
	$justifica = @pg_numrows($rs_justifica);
	//}else{
	//	$justifica=0;
	//}
	$cantidad = @pg_numrows($result13);
	if($Just_Asis==1){
	$inasistencia = @pg_numrows($result13) - $justifica;
	}else{
	$inasistencia=	@pg_numrows($result13);
	}
	$dias_asistidos = $dias_habiles - ($cantidad - $justifica);
	//if($_PERFIL==0) echo "dias justif.--> ".$justifica."  dias habiles -->".$dias_habiles."  inasistencia-->".$cantidad."  dias asistidos -->".$dias_asistidos;

	//---------------------------
	$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.truncado_per, curso.truncado_final, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza  ";
	$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
	$result =@pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);	
	$truncado_per = $fila['truncado_per'];
	$truncado_final = $fila['truncado_final'];
	
	//promedio_general
		  $prom_general=0;
		  $count_general=0;
	
?>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="125" align="center">
		<?
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			## código para tomar la insignia
	
			  if($institucion!=""){
				   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }
		?>	  		</td>
		 </tr>
     </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="487" class="item"><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></td>
          <td width="11">&nbsp;</td>
          
        </tr>
        <tr>
          <td class="item"><? echo ucwords(strtolower($ob_membrete->direccion));?></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="item">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="41">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>  
  </table>
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <th width="53%" align="left">curso: <? echo $Curso_pal; ?></th>
          <th width="4%" align="left">&nbsp;</th>
          <th width="4%" align="left">&nbsp;</th>
          <th width="9%" align="left">Alumno:</th>
          <th align="left"><div align="left">
      <? $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));
	  echo $ob_reporte->tildeM($nombre_alumno);  ?>
    </div></th>
        </tr>
        <tr>
          <td align="left">Profesor(a)jefe: <?
				    if($institucion==770){
		                 echo $ob_reporte->profe_nombre;
					}else{
		                 echo $ob_reporte->tildeM($ob_reporte->profe_jefe);
					}				
					?></td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left">Fecha:</td>
          <td align="left"><?php echo date("d-m-Y") ?></td>
        </tr>
    </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="tableindex"><div align="center">INFORME DE NOTAS </div></td>
      </tr>
    <tr>
      <td ></td>
      </tr>
</table>
      
  <br>
  <table border="1" cellpadding="0" cellspacing="0">
    <tr class="t nota">
      <th>Asignatura</th>
     <?php  for($dp=0;$dp<$d_per;$dp++)
      {
		  //$pf_sem=0;
		  ?>
      <th colspan="10">Pruebas Unidad</th>
      <th colspan="20" >Notas Parciales</th>
      <th>P.U <br />
        40%</th>
      <th>N.P<br />
60%</th>
      <th>p <br />
        100%</th>
      <th>N.<br />
P.S</th>
      <th>P. <br />
        70%</th>
      <th>P.S<br />
30%</th>
      <th>P.<?php echo $dp+1 ?></th>
      <?php }?>
      <th>P.<br />F.</th>
      </tr>
      
      <?php $ob_reporte ->nro_ano = $nro_ano;
		  $ob_reporte ->alumno = $alumno;
		  $ob_reporte ->curso = $curso;
		   $ob_reporte ->formacion=1;
		  $ob_reporte ->meval=1;
		  $ob_reporte ->RamoFormacion($conn);
		  
		  $result =$ob_reporte ->result;
      for($a=0;$a<pg_numrows($result);$a++){
		  $fila_r=pg_fetch_array($result,$a);
		  
		   $porc_npu=intval($fila_r['porc_nota_pu'])/100; 
		  
		 $porc_reales=intval(100-intval($fila_r['porc_nota_pu']))/100;
		
		 $truncado_ex_semestral=$fila_r['truncado_ex_semestral'];
		 
		//poorcentaje examen semestral
		 $pct_ex_semestral=(100-$fila_r['pct_ex_semestral'])/100;
		 
		 //porcentaje notas
		  $pct_pu_semestral=($fila_r['pct_ex_semestral'])/100;
		  
		  
		  $pf_sem=0;
		  $pf_final=0;
		  $cont_pf=0;
		  
		  $pper=0;
		  
		  
		
	  ?>
    <tr class="nota">
      <td style="width:150px"><?php echo $fila_r['nombre']?></td>
      <?php  for($dp=0;$dp<$d_per;$dp++)
      {
		  $fila_per= pg_fetch_array($pp,$dp);
		  $id_periodo=$fila_per['id_periodo'];
      for($n=1;$n<=10;$n++)
      {
		  
		  //notas pu
		 $sql_npu="select nota$n from pu_notas where rut_alumno=$alumno and id_ramo=".$fila_r['id_ramo']." and id_periodo=$id_periodo";
		 
		 $rs_npu=pg_exec($conn,$sql_npu);
		 if(pg_result($rs_npu,0)!=0){
		$notapu=pg_result($rs_npu,0); 
		}
		else{
		$notapu="&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		  ?>
      <td align="center" ><?php echo $notapu ?></td>
      <?php }
      for($m=1;$m<=20;$m++)
      {
		  //notas parciales reales
		  
		 $sql_nre="select nota$m from notas$nro_ano where rut_alumno=$alumno and id_ramo=".$fila_r['id_ramo']." and id_periodo=$id_periodo";
		 
		 $rs_nre=pg_exec($conn,$sql_nre);
		 $nota =pg_result($rs_nre,0); 
		 
		 if(trim($nota)=="0"){
			$notare="&nbsp;&nbsp;&nbsp;&nbsp;";
		 }else{
			 $notare=$nota ;
			}
		
		  ?>
      <td ><?php echo $notare ?></td>
      <?php }?>
      <td align="center">
      <?php 
      //promedio pu
	   $sql_ppu="select promedio from pu_notas where rut_alumno=$alumno and id_ramo=".$fila_r['id_ramo']." and id_periodo=$id_periodo";
	   
	   $rs_ppu=pg_exec($conn,$sql_ppu);
	   
	   /*if(trim(pg_result($rs_ppu,0))!="0" && $id_periodo != 3040){
		   $ppu=pg_result($rs_ppu,0)*$porc_npu;
		}else{
		$ppu="&nbsp;&nbsp;&nbsp;&nbsp;";
		}*/
		
		if($id_periodo == 3040){
		$ppu="&nbsp;&nbsp;&nbsp;&nbsp;";
		}else{
			if($fila_r['bool_pu']==1){
				 $ppu=pg_result($rs_ppu,0)*$porc_npu;
			}else{
			 $ppu="&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			
		}
		
		
		/*if($id_periodo==3040){
			$ppu="&nbsp;&nbsp;&nbsp;&nbsp;";}
		else{
			$ppu=$ppu;
		}*/
	  
	         ?>
             <?php echo  $ppu?>
      </td>
      <td align="center">
       <?php 
      //promedio real
	   $sql_pr="select promedio from notas$nro_ano where rut_alumno=$alumno and id_ramo=".$fila_r['id_ramo']." and id_periodo=$id_periodo";
	   $rs_pr=pg_exec($conn,$sql_pr);
	   $prom_re = pg_result($rs_pr,0);
	  /*  if(intval(pg_result($rs_pr,0))>0){
		   $pr=pg_result($rs_pr,0)*$porc_reales;
		}else{
		$pr="&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	   
	  
	   if($id_periodo==3040){
		  // $pr=$prom_re;
		  $pr="&nbsp;&nbsp;&nbsp;&nbsp;";
		   }else{
			  $pr=$pr; 
			  }
			  
			 $pr=($fila_r['bool_pu']==1)?$pr:"&nbsp;&nbsp;&nbsp;&nbsp;";*/
			 
			 
			 if($id_periodo == 3040){
		$pr="&nbsp;&nbsp;&nbsp;&nbsp;";
		}else{
			if($fila_r['bool_pu']==1){
				$pr=pg_result($rs_pr,0)*$porc_reales;
			}else{
			 $pr="&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			
		}
		
			 
	         ?>
             <?php echo $pr?>
      
      </td>
      <td align="center">
      <?php 
	  //nota pruebas de unidad
	   
	   $sql_nn="select notapu from notas$nro_ano where rut_alumno=$alumno and id_ramo=".$fila_r['id_ramo']." and id_periodo=$id_periodo";
	   $rs_nn=pg_exec($conn,$sql_nn);
				  
			   if($id_periodo == 3040){
		$nn="&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		else{
			if($fila_r['bool_pu']==1){
				 $nn=pg_result($rs_nn,0);
			}else{
			 $nn=pg_result($rs_pr,0);
			}
			
		}
			  
             ?>
             <?php echo $nn?>
      
      </td>
     
      <?php //nota examen
	   $qry9="SELECT * FROM situacion_periodo WHERE situacion_periodo.rut_alumno='".$alumno."' AND situacion_periodo.id_ramo=".$fila_r['id_ramo']." AND situacion_periodo.id_periodo=".$id_periodo.";";
	$result9 =pg_Exec($conn,$qry9)or die("Fallo :".$qry9);
	if (pg_numrows($result9)!=0){
		$fila9 = pg_fetch_array($result9,0);
		
		$nexamen=$fila9['nota_examen'];
		
		if(intval($nexamen)==0){
			$nexamen="&nbsp;&nbsp;&nbsp;&nbsp;";
		}
	
	}else{
		$nexamen="&nbsp;&nbsp;&nbsp;&nbsp;";
		}
      
      ?> 
      <td align="center" > 
       <?php echo $nexamen ?></td>
      <td align="center">
    <?php 
	  //porcentaje notas semestral
	  
	 if($fila_r['conexper']==1){
	 $porc_notas=$nn*$pct_ex_semestral;
	 echo ($porc_notas>0)?$porc_notas:"&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	else{
		$porc_notas="&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	 
	  ?>
      </td>
      <td align="center">
     <?php  
	 //porcentaje examen semestral
	   /*$porc_nexamen=$nexamen*$pct_pu_semestral;
	    echo ($porc_nexamen>0)?$porc_nexamen:"&nbsp;&nbsp;&nbsp;&nbsp;";*/
      
	   if($fila_r['conexper']==1){
	$porc_nexamen=$nexamen*$pct_pu_semestral;
	    echo ($porc_nexamen>0)?$porc_nexamen:"&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	else{
		$porc_nexamen="&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	  
       ?>
      </td>
      
      <?php 
	 
	  if($id_periodo==3040){
		
		  $pf_sem=$prom_re;
		 if($fila_r['modo_eval']==1)
			 {
				
			 if($pf_sem>0){
				  $arr_promedio_periodo[$alumno][$id_periodo][$fila_r['id_ramo']]=$pf_sem;
				  
				  $arr_pf_final[$fila_r['id_ramo']][$alumno][]=$pf_sem;
				}
			
			 }
			 //notas conceptuales
			 else{
				  $arr_pf_final_conceptual[$fila_r['id_ramo']][$alumno][]=Conceptual($pf_sem,2);
			}
		 
		 
		 
		 
		 }
		 else
		 {
			 
			 if($fila_r['modo_eval']==1)
			 {
				 $pf_sem=($truncado_ex_semestral==1)?round($porc_notas+$porc_nexamen):intval($porc_notas+$porc_nexamen); 
				 
				 if($fila_r['conexper']==1){
			  $pf_sem= $pf_sem;
			  }else{
			  $pf_sem=$prom_re;
			}
				 
				if($pf_sem>0){
				  $arr_promedio_periodo[$alumno][$id_periodo][$fila_r['id_ramo']]=$pf_sem;
				  
				  $arr_pf_final[$fila_r['id_ramo']][$alumno][]=$pf_sem;
				}
			 }
			 
			 else{
			 $pf_sem=$prom_re; 
			  $pf_conc = Conceptual($prom_re,2);
			 
			 if($pf_conc>0){
			 $arr_pf_final_conceptual[$fila_r['id_ramo']][$alumno][]=$pf_conc;
			 }
			
			}
			
			 }
	  ?>
      
     <td align="center"><strong><?php echo $pf_sem ?></strong> </td>
      <?php }?>
       <th align="center">
      <?php //promedio anual ramo
	 if($fila_r['modo_eval']!=1){
		/* $pf_final="xx";
		 var_dump($arr_pf_final_conceptual[$fila_r['id_ramo']][$alumno]);*/
		 
		  $n_final= array_sum($arr_pf_final_conceptual[$fila_r['id_ramo']][$alumno])/count($arr_pf_final_conceptual[$fila_r['id_ramo']][$alumno]);
		  
		  $pf_final= Conceptual($n_final,1);
		
					}else{
	 $pf_final= array_sum($arr_pf_final[$fila_r['id_ramo']][$alumno])/count($arr_pf_final[$fila_r['id_ramo']][$alumno]);
	 
	 $pf_final=($truncado_per==1)?round($pf_final):intval($pf_final);
	 
	 $pf_final=($pf_final!=0)?$pf_final:"&nbsp;&nbsp;&nbsp;&nbsp;";
	  }
	 //suma promedios generales
	 if($pf_final>0){
	 $prom_general=$prom_general+$pf_final;
	$count_general++;
	 }
	 
	  ?>
      <strong ><?php echo $pf_final ?></strong></th>
      </tr>
      <?php }?>
      <tr class="nota">
      <th align="left">Promedios</th><?php  for($dp=0;$dp<$d_per;$dp++)
      {
		  
		  $fila_per= pg_fetch_array($pp,$dp);
		  $id_periodo=$fila_per['id_periodo'];
		  ?>
      <th colspan="36" align="right">Promedio <?php echo $siglap ?><?php echo $dp+1 ?></th>
      <th align="center">
      <?php  $promedio_per= array_sum($arr_promedio_periodo[$alumno][$id_periodo])/count($arr_promedio_periodo[$alumno][$id_periodo]);
	   $promedio_per=($truncado_per==1)?round($promedio_per):intval($promedio_per);
	  
	 $promedio_per=($promedio_per>0)?$promedio_per:"&nbsp;&nbsp;&nbsp;&nbsp;";
	  
       ?>
       <strong ><?php echo $promedio_per ?></strong>
      </th>
      <?php }?>
       <th align="center">
	  <?php 
	   $prom_general = $prom_general/$count_general;
	   $prom_general =($truncado_final==1)?round($prom_general):intval($prom_general);
	   
	   ?>
	   
	   <span ><?php echo $prom_general ?></span></th>
      </tr>
  </table></td>
  </tr>
</table>
<br>
<?php
  $tot_trab=0;
  $tot_asis=0;
  $tot_inasis=0;
  $tot_atra=0;
  $tot_posi=0;
  $tot_nega=0;
?>
<table  border="0">
  <tr>
    <td width="50%">
    <table width="100%" border="1" cellpadding="0" cellspacing="0" class="nota" style="border-collapse:collapse; border-color:black; border-width:3px">
  <tr>
    <th colspan="<?php echo (2+$d_per) ?>" scope="col"><span class="t nota">CUADRO ASISTENCIA</span></th>
    </tr>
  <tr class="c">
    <td width="113" nowrap="nowrap"><strong><span class="t">DIAS</span></strong></td>
    <?php  for($dp=0;$dp<$d_per;$dp++)
      {
		  $fila_per= pg_fetch_array($pp,$dp);
		  
		  ?>
    <td  nowrap="nowrap"><strong>&nbsp;&nbsp;<span class="t"><?php echo $palp ?> <?php echo to_roman($dp+1) ?>&nbsp;&nbsp;</span></strong></td>
   <?php }?>
    <td nowrap="nowrap"><strong><span class="t">&nbsp;&nbsp;TOTAL ANUAL&nbsp;&nbsp;</span></strong></td>
  </tr>
  <tr>
    <td><strong><span class="t">TRABAJADOS</span></strong></td>
    <?php  for($dp=0;$dp<$d_per;$dp++)
      {
		  $fila_per= pg_fetch_array($pp,$dp);
		 $tot_trab=$tot_trab+$fila_per['dias_habiles'];
		  ?>
    <td align="center"><?php echo $fila_per['dias_habiles']?></td>
    <?php }?>
    <td align="center"><?php echo  $tot_trab ?></td>
  </tr>
  <tr>
    <td><strong><span class="t">ASISTIDOS</span></strong></td>
     <?php  
	 
	 for($dp=0;$dp<$d_per;$dp++)
      {
		  $fila_per= pg_fetch_array($pp,$dp);
		   $dias_trabajados=0;
		  $dias_inasistencia=0;
		  //cuento inasistencias
		  $fecha_ini= $fila_per['fecha_inicio'];
	      $fecha_fin= $fila_per['fecha_termino'];
	
	$ob_reporte ->alumno = $alumno;
	$ob_reporte ->ano = $ano;
	$ob_reporte ->fecha_inicio=$fecha_ini;
	$ob_reporte ->fecha_termino = $fecha_fin;
	$result13 = $ob_reporte ->Asistencia($conn);
	if (!$result13){
		  error('<B> ERROR :</b>Error al acceder a la BD. (ASISTENCIA)</B>');
	}else{
		if (pg_numrows($result13)!=0){
		  $fila13 = @pg_fetch_array($result13,0);	
		  if (!$fila13){
			  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			  exit();
		  }
		}
	}
		  
		  $inasistencia=pg_numrows($result13);
		  
		  //justificadas
		  $ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano =$ano;
		$ob_reporte ->fecha1 = $fecha_ini;
		$ob_reporte ->fecha2 = $fecha_fin;
		$res_justifica = $ob_reporte->JustificaAsistencia($conn);
		
		$justificadas = pg_numrows($res_justifica);	
		 $dias_inasistencia = $inasistencia- $justificadas;
		  
		  $dias_trabajados = $fila_per['dias_habiles']-$dias_inasistencia;
		  $tot_asis=$tot_asis+$dias_trabajados;
		  
		  ?>
    <td align="center"><?php echo $dias_trabajados ?> </td>
    <?php }?>
    <td align="center"><?php echo $tot_asis ?></td>
  </tr>
  <tr>
    <td><strong><span class="t">INASISTIDOS</span></strong></td>
     <?php  
	 $dias_inasistencia=0;
	 for($dp=0;$dp<$d_per;$dp++)
      {
		  $fila_per= pg_fetch_array($pp,$dp);
		  
		  //cuento inasistencias
		  $fecha_ini= $fila_per['fecha_inicio'];
	      $fecha_fin= $fila_per['fecha_termino'];
	
	$ob_reporte ->alumno = $alumno;
	$ob_reporte ->ano = $ano;
	$ob_reporte ->fecha_inicio=$fecha_ini;
	$ob_reporte ->fecha_termino = $fecha_fin;
	$result13 = $ob_reporte ->Asistencia($conn);
	if (!$result13){
		  error('<B> ERROR :</b>Error al acceder a la BD. (ASISTENCIA)</B>');
	}else{
		if (pg_numrows($result13)!=0){
		  $fila13 = @pg_fetch_array($result13,0);	
		  if (!$fila13){
			  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			  exit();
		  }
		}
	}
		  
		  $inasistencia=pg_numrows($result13);
		  
		  //justificadas
		  $ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano =$ano;
		$ob_reporte ->fecha1 = $fecha_ini;
		$ob_reporte ->fecha2 = $fecha_fin;
		$res_justifica = $ob_reporte->JustificaAsistencia($conn);
		
		$justificadas = pg_numrows($res_justifica);	
		 $dias_inasistencia = $inasistencia- $justificadas;
		  $tot_inasis=$tot_inasis+$dias_inasistencia;
		  ?>
    <td align="center"><?php echo $dias_inasistencia  ?></td>
    <?php }?>
    <td align="center"><?php echo  $tot_inasis ?></td>
  </tr>
  <tr>
    <td><strong><span class="t">ATRASOS</span></strong></td>
    <?php  for($dp=0;$dp<$d_per;$dp++)
      {
		    $fila_per= pg_fetch_array($pp,$dp);
		  ?>
    <td align="center">
    <?
	$fecha_ini= $fila_per['fecha_inicio'];
	$fecha_fin= $fila_per['fecha_termino'];
	
				$ob_reporte ->alumno = $alumno;
				$ob_reporte ->tipo =2;
				$ob_reporte ->fecha_inicio = $fecha_ini;
				$ob_reporte ->fecha_termino = $fecha_fin;
				$result_atraso =$ob_reporte ->Anotaciones($conn);
				$fila_atraso = @pg_fetch_array($result_atraso,0);
				echo @pg_numrows($result_atraso);
				
				$tot_atra=$tot_atra+ @pg_numrows($result_atraso);
		?>
    
    
    </td>
    <?php }?>
    <td align="center"><?php echo $tot_atra ?></td>
  </tr>
  <tr>
    <td colspan="<?php echo (2+$d_per) ?>" align="center"><strong><span class="t">CUADRO ANOTACIONES</span></strong></td>
    </tr>
  <tr>
    <td><strong><span class="t">POSITIVAS</span></strong></td>
     <?php  for($dp=0;$dp<$d_per;$dp++)
      {
		  //$tot_pos=0;
		  $fila_per= pg_fetch_array($pp,$dp);
		  $fecha_ini= $fila_per['fecha_inicio'];
	      $fecha_fin= $fila_per['fecha_termino'];
		  ?>
    <td align="center">
    <?php  
	 $sql_an="select * from anotacion where rut_alumno=$alumno and tipo=1 and tipo_conducta=1 and(fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
	  	 $rs_an =pg_exec($conn,$sql_an);
		 $tot_sql_an = @pg_numrows($rs_an);
         
         $tot_sql_an1 = @pg_numrows($rs_an1);
		 echo $tot_pos = $tot_sql_an+$tot_sql_an1;
		 
		 $tot_posi=$tot_posi+$tot_pos;
    ?>
    </td>
    <?php }?>
    
    <td align="center"><?php echo $tot_posi ?></td>
  </tr>
  <tr>
    <td><strong><span class="t">NEGATIVAS</span></strong></td>
    <?php  for($dp=0;$dp<$d_per;$dp++)
      {
		    $fila_per= pg_fetch_array($pp,$dp);
		  $fecha_ini= $fila_per['fecha_inicio'];
	      $fecha_fin= $fila_per['fecha_termino'];
		  ?>
    <td align="center"> <?php $sql_anotneg="select * from anotacion where rut_alumno=$alumno and tipo=1 and tipo_conducta=2 and(fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
	  	 $rs_anotneg =pg_exec($conn,$sql_anotneg);
		 $tot_sql_anotneg = @pg_numrows($rs_anotneg);
		 
		 echo $tot_neg = $tot_sql_anotneg+$tot_sql_anotneg2;	
		 
		 $tot_nega=$tot_nega+$tot_neg;
		 ?></td>
    <?php }?>
    <td align="center"><?php echo $tot_nega ?></td>
  </tr>
</table>
    
    </td>
    <td width="2%">&nbsp;</td>
     <?php  for($dp=0;$dp<$d_per;$dp++)
      {
		  $fila_per= pg_fetch_array($pp,$dp);
		  
		  ?>
    <td valign="top"><table width="406" border="1" cellpadding="0" cellspacing="0" class="nota" style="border-collapse:collapse; border-color:black; border-width:3px">
      <tr>
        <th width="398" style="font-size: 10px" scope="col"><span class="TX"><?php echo strtoupper($fila_per['nombre_periodo']); ?></span></th>
        </tr>
      <tr>
        <th style="font-size: 10px" scope="col"><table width="388" border="0" cellpadding="0" cellspacing="0" class="nota">
          <tr>
            <td colspan="3" align="center"><strong>OBSERVACIONES</strong>___________________________________</td>
            </tr>
          <tr>
            <td colspan="3" align="center">__________________________________________________</td>
            </tr>
          <tr>
            <td colspan="3" align="center">__________________________________________________</td>
            </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">__________________</td>
            <td align="center">&nbsp;</td>
            <td align="center">________________</td>
          </tr>
          <tr>
            <td align="center">Firma Profesor Jefe</td>
            <td align="center">&nbsp;</td>
            <td align="center">Firma Apoderado</td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">___________________</td>
            <td align="center">&nbsp;</td>
          </tr>
          <tr>
            <td align="center">&nbsp;</td>
            <td align="center">Firma Director</td>
            <td align="center">&nbsp;</td>
          </tr>
        </table></th>
      </tr>
    </table></td>
    <td width="2%">&nbsp;</td>
    <?php }?>
  </tr>
</table>

<br>
<table width="770" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
<br />
<?php

	if  (($cont_alumnos - $cont_paginas)<>1){ 
		echo "<H1 class=SaltoDePagina></H1>";
	}
 ?>
	<? //} // FIN FOR ALUMNOS
} ?>
</body>
</html>
