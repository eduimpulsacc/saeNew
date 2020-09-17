<div align="center">

<? 
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

//setlocale("LC_ALL","es_ES");

if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Notas_Semestrales_$Fecha.xls"); 
}	

?>
<SCRIPT>
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
//-->
function exportar(){
			//form.target="_blank";
			window.location='printInformeNotasSemestrales_C.php?cmb_curso=<?=$cmb_curso?>&dia=<?=$dia?>&mes=<?=$mes?>&ano2=<?=$ano2?>&cmb_alumno=<?=$cmb_alumno?>&cmb_periodo=<?=$cmb_periodo?>&c_reporte=<?=$c_reporte?>';
			//document.form.submit(true);
		return false;
}
function cerrar(){ 
	window.close() 
} 
</script>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$alumno		    =$cmb_alumno;
	$reporte		=$c_reporte;
	$periodo		=$cmb_periodo;

	
	
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
	$ob_reporte ->periodo($conn);
	$periodo_pal = $ob_reporte->nombre_periodo . " DEL " . $nro_ano;
	$result1 = $ob_reporte->result;
	$dias_habiles = $ob_reporte->dias_habiles;
	//$fecha_ini = $ob_reporte->fecha_inicio;
	//$fecha_fin = $ob_reporte->fecha_termino;
	$fecha_ini =$ob_membrete->fecha_inicio;
	$fecha_fin = $ob_membrete->fecha_termino;
	$dias_habiles_p = $ob_membrete->dias_habiles;
	
	
	
	
	
	
	
	
	$ob_reporte ->ano = $ano; 
	$resultPeri = $ob_reporte ->TotalPeriodo($conn);
	$num_periodos = @pg_numrows($resultPeri);
	if ($num_periodos==2) $tipo_per = "SE";
	if ($num_periodos==3) $tipo_per = "TR";	
	
	
	// ULTIMO PERIODO PARA HACER COMPARACIONES		
	//---------------------------------
		$rs_ultimo= $ob_reporte ->ultimoPeriodo($conn); 
		$id_ulperiodo=pg_result($rs_ultimo,4);
		$fecha_termino_ulperiodo = pg_result($rs_ultimo,1);
	//---------------------------------

		
	
	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************** CURSO ***********************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	$ob_reporte ->Curso($conn);
	$truncado_final = $ob_reporte->truncado_final;
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	

	$fecha =$dia." de ".$mes." de ".$ano2;

	$sql = "select  * from periodo where id_ano = ".$ano." order by fecha_inicio" ;
	$result1 =@pg_Exec($conn,$sql);
	if (!$result1) 
	{
	  error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
	}
	else
	{
		if (pg_numrows($result1)!=0)
	  {
		  $fila1 = @pg_fetch_array($result1,0);	
		  if (!$fila1)
		  {
			  error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
			  exit();
		  }
	  }
	}
	
	

	function Nombre($paterno,$materno,$nombres){
		$Nombres = strtoupper($nombres." ".$paterno." ".$materno);
		echo $Nombres;
	}
	
	
	
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
		$sql_curso = "SELECT plan_estudio.nombre_decreto, evaluacion.nombre_decreto_eval, curso.truncado_per,curso.fecha_inicio,curso.fecha_termino ";
		$sql_curso = $sql_curso . "FROM (curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
		$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso."));";
		$result_curso = @pg_Exec($conn, $sql_curso);
		$fila_curso = @pg_fetch_array($result_curso ,0);
		$decreto_eval = $fila_curso['nombre_decreto_eval'];
		$planes = $fila_curso['nombre_decreto'];
		$truncado_per = $fila_curso['truncado_per'];
		$finicio_curso = $fila['fecha_inicio'];
		$ftermino_curso = $fila['fecha_termino'];
		
		//----------------------------------------------------------------------------
	}	

				  
				 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>&nbsp;</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }

</style>
<!-- CODIGO DE DISEÑO NUEVO -->
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
								  
<form method="post" target="mainFrame">
<center>
<div id="capa0">

	<table width="650" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td>
		  <table width="100%">
			<tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
			<input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
			</td>
			<? if($_PERFIL == 0){?>
			  <td align="right"><input name="button32" TYPE="button" class="botonXX" onClick="javascript:exportar()"  value="EXPORTAR"></td>
			<? }?>
			</tr></table>
	
	</td>
	  </tr>
	</table> 

</div>

<?
	if (empty($alumno)){
		$ob_reporte->curso = $curso;
		$ob_reporte->ano=$ano;
		$result_alu = $ob_reporte->TraeTodosAlumnos($conn);
	}else{
		$ob_reporte->ano=$ano;
		$ob_reporte->curso=$curso;
		$ob_reporte->alumno=$alumno;
		$result_alu = $ob_reporte->TraeUnAlumno($conn);
	}	
	$cont_alumnos = @pg_numrows($result_alu);

for($cont_paginas=0 ; $cont_paginas < $cont_alumnos ; $cont_paginas++)
{
	$prome_general_pro = 0;
	$cont_general_pro = 0;
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'] ;
	$bool_ed = $fila_alu['bool_ed'];
	$fecha_retiro = $fila_alu['fecha_retiro'];
	$fecha_matricula = $fila_alu['fecha'];

	//---------------------------
	$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.truncado_per, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza,curso.fecha_inicio,curso.fecha_termino  ";
	$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
	$result =@pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);	
	$truncado_per = $fila['truncado_per'];		
	$grado = $fila['grado_curso'];
	$ensenanza = $fila['ensenanza'];
	$ensenanza_pal = $fila['nombre_tipo'];
	$finicio_curso = $fila['fecha_inicio'];
	$ftermino_curso = $fila['fecha_termino'];
	?>
    
    
<table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
	<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
            <td width="100%"><table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
			  <tr>
                <td width="114" class="item"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
                <td width="9"><strong>:</strong></td>
                <td width="361" class="subitem"><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>
                <td width="161" rowspan="7" align="center" valign="top" >
				<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>				</td>
              <tr>
                <td class="item"><div align="left"><strong>AÑO ESCOLAR</strong></div></td>
                <td><strong>:</strong></td>
                <td class="subitem"><div align="left"><? echo trim($nro_ano) ?></div></td>
                </tr>
              <tr>
                <td class="item"><div align="left"><strong>CURSO</strong></div></td>
                <td><strong>:</strong></td>
                <td class="subitem"><div align="left"><? echo $Curso_pal; ?>
				</div></td>
                </tr>	
              <tr>
                <td class="item"><div align="left"><strong>ALUMNO</strong></div></td>
                <td><strong>:</strong></td>
                <td class="subitem"><div align="left"><? $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); echo $ob_reporte->tildeM($nombre_alumno);?></div></td>
                </tr>
              <tr>
                <td class="item"><div align="left"><strong>PROFESOR JEFE</strong></div></td>
                <td><div align="left"><strong>:</strong></div></td>
                <td class="subitem"><div align="left">
                  <?=$ob_reporte->tildeM($ob_reporte->profe_jefe);?>
                </div></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td width="4" rowspan="6" align="center">&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
			  
            </table>
            </td>
      </tr>
        </table></td>
      </tr>
      <tr>
        <td height="20" class="tableindex"><div align="center">INFORME  DE PROMEDIOS SEMESTRALES</div></td>
      </tr>
     
	 
	  <tr>
        <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo "A&Ntilde;O ".$nro_ano?></strong></font></div></td>
      </tr>
	 
   
      <tr>
        <td></td>
      </tr>
      <tr>
        <td>
		<?
		  $promedio_gen = 0;
		  $cont_promgen = 0;
		  $prom_gen_asis = 0;
	      $prom_cont_asis =0;

		   for($i=0 ; $i < @pg_numrows($result1) ; $i++)
			{
			$dias_habiles=0;
			$fila1 = @pg_fetch_array($result1,$i);
				if (empty($fila1['fecha_inicio']) or empty($fila1['fecha_termino']))
				{
					?><div align="center"><?
				    echo ('<b> DEBE INGRESAR FECHAS Y DIAS HÁBILES PARA PERÍODOS </b> <br> Debe <a href="../../ano/periodo/listarPeriodo.php3" target="_parent">ir a Periodos</a>  e ingresar la información requerida...  <br>  <br> ');
				?>
							 	
				</div>	
				<?
				exit;
				}	
				
				$id_periodo = $fila1['id_periodo'];
				 for($i=0 ; $i < @pg_numrows($result1) ; $i++)
			{
				$fila_dias = @pg_fetch_array($result1,$i);
				$dias_habiles = $fila_dias['dias_habiles']+$dias_habiles;
			}	
				/*$fecha_ini = $fila1['fecha_inicio'];
				$fecha_fin = $fila1['fecha_termino'];*/
				//--
				$ob_reporte ->alumno =$alumno;
				$ob_reporte ->ano=$ano;
				$ob_reporte ->fecha_inicio=$fecha_ini;
				$ob_reporte ->fecha_termino =$fecha_fin;
				$ob_reporte ->curso =$curso;
				$result13 =$ob_reporte ->Asistencia($conn);
					

				$inasistencia = @pg_numrows($result13);
				$dias_asistidos = $dias_habiles - @pg_numrows($result13);
				$habil_real_ano=0;
				$feriados_ano=0;
				$fera=0;
				
				//=========== calculo % asistencia nuevo =====
	//************ habiiles (nuevo)
	//fecha inicio -> matricule despues de incio de año, indicar fecha, si no, marcar inicio de año academico
	/*echo "x".$fecha_matricula ;
	echo $finicio_curso;
	echo $fecha_ini;*/
	
	
	if($finicio_curso!=''){	
		$fini=$finicio_curso;
		 
		}
	else
	{
			if($fecha_matricula <= $fecha_ini)
			{
			
				$fini= $fecha_ini;
			
			}else{
			 
			 $fini= $fecha_matricula;
			}
			
		}
		
		//echo "c".$fini;
		
		//fecha termino -> si esta retirado, indicar fecha, si no, marcar fin de año academico
		if($retirado==1){
		 $fter =$fecha_retiro;
		}
		else{
			
		 if($finicio_curso!=''){
			 $fter = $ftermino_curso;
		}else{
			$fter = $fecha_fin;
		}	
		 
		 //$fter = $ftermino_curso;
		 
		 
		}
		
		//conteo dias habiles año (sin feriados)
		 $habiles_ano=hbl($fini,$fter);
		
		
	
//***************fin habikes (nuevo)
//******feriados año
     $sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$ano."  AND (feriado.fecha_inicio>='".$fini."' and feriado.fecha_fin<='".$fter."');";
	
	$rs_feriadosano = @pg_exec($conn,$sql_fano);

for($ff=0;$ff<pg_numrows($rs_feriadosano);$ff++){
		$fila_feriadoano =pg_fetch_array($rs_feriadosano,$ff);
		
		$inciof= $fila_feriadoano['fecha_inicio'];
		
	
		
		if($fila_feriadoano['fecha_fin']=='')
		{
			 $finf=$inciof ;
			
		}else{
		
			$finf= $fila_feriadoano['fecha_fin'];
		}
		
		 $fera=$fera+$dif_dias =ddiff($inciof, $finf);
		
		}
		
	 	$feriados_ano=$fera;


//fin feriados año	
	
	//dias reales año
	 $habil_real_ano = $habiles_ano-$feriados_ano;
	

 //inasistencias
	 $sql_asisano = "SELECT * FROM asistencia WHERE rut_alumno = ".$alumno." and ano = ".$ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$curso;
	
	$r_asisano = @pg_exec($conn,$sql_asisano);
		
	$c_inasistenciaAno = pg_numrows($r_asisano);
	$contador_asis=$c_inasistenciaAno;
	
//justificadas

   $sql_jasisano = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = ".$alumno." and ano = ".$ano."  and (fecha>='".$fini."' and fecha<='".$fter."')  AND id_curso =".$curso;
  	
  $r_justificaano= @pg_exec($conn,$sql_jasisano);
 $justificaano = pg_numrows($r_justificaano);
 
 //resta final
	  $con_total_inano = $habil_real_ano-($c_inasistenciaAno-$justificaano);
	  
	 //porcentaje anual
		 $prc_base = round((100* $con_total_inano)/$habil_real_ano,2);
		 
		;
	
	/*if($_PERFIL==0) {
		echo (100* $con_total_inano); 
		echo "<br> feriados-->".$habil_real_ano;
		echo "<br>rut_alumno-->".$alumno;
		echo "<br> inasistencia--->".$c_inasistenciaAno;
		echo "<br> fecha_retiro-->".$fter;
		echo "<br> justificadas-->".$justificaano;
		echo "<br>-->". $prc_base;
	}*/
//=========== fin calculo % asistencia nuevo =====
				
				
				//--
				$sql8 = "select count(*) as contador from notas$nro_ano where rut_alumno = '" . $alumno."'";
			    $result18 =@pg_Exec($conn,$sql8);
			    if (!$result18) 
			    {
			  	  error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			  	}
			    else
			  	{
				  	if (pg_numrows($result18)!=0)
				    {
				  	  $fila8 = @pg_fetch_array($result18,0);	
				  	  if (!$fila1)
				  	  {
					  	  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  	  exit();
					    }
				    }
			    }
				

				
				if ($fila8['contador']>0){
				?>			
				<br><br>
		  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
		  <tr>
            <td width="231" align="left" class="item">
			  <div align="center"><strong>Subsector del Aprendizaje <br>
			    (Formaci&oacute;n General ) </strong></div></td>
            <? 
			$sql_p = "select  * from periodo where id_ano = ".$ano." order by fecha_inicio asc" ;
			$result_p = pg_Exec($conn,$sql_p);
			$fila_p = pg_num_rows($result_p);
			
			for ($i=1; $i<=$fila_p; $i++) { ?>
				<td align="center" class="item"><strong>
				  <?=$i?>
				  º<? echo $tipo_per ?></strong></td>
			<? }?>
            	<td align="center" class="item"><strong>Prom. Final</strong></td>  
            </tr>  
           
           				
		  <?
		  $ob_reporte ->nro_ano = $nro_ano;
		  $ob_reporte ->alumno = $alumno;
		  $ob_reporte ->curso = $curso;
		  $ob_reporte ->subsector = $ck_subsector;
		  $ob_reporte ->RamoAlumno($conn);
          $res_lista =$ob_reporte ->result;
		  
			  
		  $final_total = 0;
		  $no_ramos = 0;
		  $prom=0;
		  $promedio_nota=0;
		  $fp=0;
		  
		  while ($arr_lista = pg_fetch_array($res_lista)) {?>
		   
           <tr>
           <td class="subitem"><?=$arr_lista['nombre']?></td><?
			      
			$ob_reporte ->rut_alumno = $alumno;
			$ob_reporte ->ramo = $arr_lista['id_ramo'];
			$ob_reporte ->periodo = $periodo;
			$ob_reporte ->ano = $ano;
			$res_promedios = $ob_reporte->Notas($conn);
			                
				$prom_final = 0;
				$con_prom = 0;
				$j = $fila_p;
				
				for ($i=1; $i<=$fila_p; $i++){
				$promedio_nota=0;
				$prom_ex=0;
				
					if ($arr_promedios=pg_fetch_array($res_promedios)) {
				
						$prom = $arr_promedios['promedio'];
				
						if($prom==0){
							$j--;
						}
						$prom_final = $prom_final + $prom;
						if ( ($prom<40) && ($prom>0) ) {
							$color='color="#FF0000"';
						} else {
							$color = 'color="#000000"';
						}
						
						
						if ($arr_lista['cod_subsector']==13 or $arr_lista['cod_subsector']==413 or $arr_lista['cod_subsector']==170) {
							$ppp=conceptual($arr_promedios['promedio'],2);
							if($ppp>0){$fp++;}
							
							$con_prom = conceptual($arr_promedios['promedio'],2)+$con_prom;
							$color = 'color="#000000"';
						}
						
					} else {
						if ($arr_lista['cod_subsector']==13 or $arr_lista['cod_subsector']==413 or $arr_lista['cod_subsector']==170) {
							$prom = "-";
							$j--;
							
							$color = 'color="#000000"';
						} else {
							$prom = "0";
							$j--;
							$color = 'color="#000000"';
							//$prom=70;
							
						}
					}?>
					
                    <td align="center" class="subitem"><font <?=$color?>>
                      <?=$prom;?>
                     
                    </font></td>
					
<?				}

				if ($arr_lista['cod_subsector']==13 or $arr_lista['cod_subsector']==413 or $arr_lista['cod_subsector']==170) {
					if($con_prom>0)
						//$final = $con_prom / $fila_p;
						$final = $con_prom /  $fp;
						
					else
						$final=0;
					
						$color = 'color="#000000"';
					
					//$final = Conceptual($final,1,$institucion,$ano,$conn);
					$final = Conceptual($final,1);
					//echo $fp;
				} else {
					if ($prom_final == 0 || $j == 0) {
						$final = 0;
						$color = 'color="#000000"';
					} else {
					if($ob_reporte->truncado==1){
						$final = round($prom_final/$j);
					}else{
						$final = intval($prom_final/$j);
					}
						if ($final<40) {
							$color='color="#FF0000"';
						} else {
							$color = 'color="#000000"';
						}
					}
				}
				
		$sql_prom_ramo = "SELECT promedio FROM promedio_sub_alumno WHERE rut_alumno=".$alumno." AND id_ramo=".$arr_lista['id_ramo']." ";
		$sql_prom_ramo.="AND id_ano=".$ano;
		$result_prom_ramo = @pg_exec($conn,$sql_prom_ramo);
		$promedio_ramo = @pg_result($result_prom_ramo,0);
		//echo "(".$promedio_ramo.")";
				
				?>
                    <td align="center" class="subitem"><font size="1" face="Arial, Helvetica, sans-serif" <?=$color?>><? if($chk_final==1){ echo $promedio_ramo;}else{ echo $final;}?></font></td>
          	</tr>
          <?	if ($arr_lista['cod_subsector']!=13 and $arr_lista['cod_subsector']!=413 or $arr_lista['cod_subsector']!=170) {
		  			$final_total = $final_total + $final;
					if ($final > 0) {
		  				$no_ramos++;
					}
				}
		  		
		  }
         ?>		  
          <tr>

            <td height="25" colspan="<?=$fila_p+1?>" align="right" class="item"><strong>Promedio &nbsp;&nbsp;&nbsp;</strong></td>
			<? 
			$sql = "SELECT promedio,asistencia FROM promocion WHERE rut_alumno=".$alumno." AND id_ano=".$ano;
			$result = @pg_exec($conn,$sql);
			$final_alumno = @pg_fetch_array($result,0);?>
	            <td align="center" class="item"><? 
													if($chk_final==1){
														echo $final_alumno['promedio'];
													}else{
														if($truncado_final==1){			
															echo round($final_total/$no_ramos);
														}else{
															echo intval($final_total/$no_ramos);
														}	
													}
													?></td>									
				<?
			
			if ($prome_general_pro>0)// ordinarios
				$prome_general_pro = round($fina_total/$no_ramos);

			?>
          </tr>
        </table>
		        
		<? } //for?>
		<? } //if?> 
		
		<!-- ASISTENCIA Y ATRASOS -->
        <? if($chkASISTENCIA==1){?>
		<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
		<? if ($_INSTIT!=12829){ ?>	<td width="153" class="subitem">
		  <? if ($_INSTIT==770){ ?>
		  &nbsp; 
		  <? }else{ ?> 
		  <strong>TOTAL DIAS PERIODO </strong>		  <? } ?>
		</td>
			<td width="237" class="subitem">
			  <? echo /*$dias_habiles;*/ $habil_real_ano ?>			</td>
			<? } ?>
	   <? if ($_INSTIT==12829){ ?>	<td width="153" class="subitem"> <strong>TOTAL HORAS A TRABAJAR </strong></td>
			<td width="237" class="subitem">&nbsp; 1592 </td>
			<? } ?>
			<td width="172"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==14490){ ?>&nbsp; <? }else{ ?><strong class="subitem">TOTAL DIAS INASISTENTES</strong><? } ?></font></td>
			<td width="78"><font size="1" face="Arial, Helvetica, sans-serif"><? if ($_INSTIT==14490){ ?>&nbsp; <? }else{ ?> <? echo $inasistencia ?><? } ?> </font></td>
		  </tr>
		  <tr class="subitem">
			<td>
			  <? if ($_INSTIT==770){ ?>
			  &nbsp; 
			  <? }else{ ?>
			  <strong>TOTAL ASISTENCIAS (%)</strong>			  <? } ?>			</td>
			<td>
	                  <? if ($_INSTIT==770){ ?>
				       &nbsp;
		              <? }else{ ?>			   
				   
						   <? 
						   	if($chk_final==1){
								echo $final_alumno['asistencia']." %";
							}else{
						   
							if ($dias_habiles>0)
							{
								$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
								$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
								$prom_cont_asis = $prom_cont_asis + 1;
							}
							echo $prc_base . "%" ;
							?>                      <? 
							
							//aca va % asistencia
							} 
							}?>			</td>
			<td>
			  <? if ($_INSTIT==14490){ ?>
			  &nbsp; 
			  <? }else{ ?>
			  <strong>TOTAL ATRASOS</strong>			  <? } ?>			</td>
			<td>
			      <? if ($_INSTIT==14490){ ?>
			      &nbsp;
			      <? }else{ ?>	  
			
					<?
					$sql_atraso = "select count(*) as cantidad from anotacion where rut_alumno = '".$alumno."' and tipo = 2 and (fecha >= to_date('" . $fecha_ini ."','YYYY MM DD') and fecha <= to_date('" . $fecha_fin . "','YYYY MM DD'))";
					$result_atraso =@pg_Exec($conn,$sql_atraso);
					$fila_atraso = @pg_fetch_array($result_atraso,0);
					if (empty($fila_atraso['cantidad']))
						echo "0";
					else
						echo $fila_atraso['cantidad'];
					?>			        <? } ?>			</td>
		  </tr>
		</table>
        <? }?>
		<!-- FIN ASISTENCIA Y ATRASOS -->
		
		
		<HR align="center" width="650" color=#003b85>
		
		
		<table width="650" height="38" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td height="16"><div align="left" class="subitem"><strong>Observaciones</strong><font size="1"><strong><font face="Arial, Helvetica, sans-serif">:</font></strong></font></div></td>
		  </tr>
		
			<? 
				$sql_observa = "select * from observa_informe where rut_alumno = '".$alumno."'";
				$result_observa =@pg_Exec($conn,$sql_observa);
				$fila_observa = @pg_fetch_array($result_observa,0);	
				if (!empty($fila_observa['observacion']))
					echo $fila_observa['observacion'];
				else
					echo "&nbsp;";
			
			?>
		</table>
			 
		<table width="650" height="72" border="0" align="center" cellpadding="0" cellspacing="0">
		 <? if($bool_ed==1) { ?>
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif"><? echo "ALUMNO EVALUADO DIFERENCIADAMENTE ";?> 
               </font></strong></font></div></td>
		  </tr>
		  <? }else{ ?>
		  <tr>
			<td height="27"><div align="left"><font size="1"><strong><font face="Arial, Helvetica, sans-serif"> 
                        <!--Academias:-->
                        </font><font size="1"><strong><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font><font face="Arial, Helvetica, sans-serif"></font></strong></font></strong></font></div></td>
		  </tr>
		  <? } ?>
		  <tr>
		    <td height="22"><div align="left"><font size="1"><strong><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font><font face="Arial, Helvetica, sans-serif"></font></strong></font></div></td>
		    </tr>
		  <tr>
		    <td height="23"><div align="left"><font size="2"><strong><font face="Verdana, Arial, Helvetica, sans-seri">________________________________________________________________________</font></strong></font></div></td>
		    </tr>
		</table>		
  <?
if ($_INSTIT==1685){
    $sql_final = "select promedio, asistencia, situacion_final, observacion from promocion where promocion.rut_alumno = '".trim($alumno)."'";
	$sql_final = $sql_final . "and promocion.id_ano = $ano ";
	
	$result_final = @pg_Exec($conn,$sql_final);
	$fila_final = @pg_fetch_array($result_final,0);
	
	if ($fila_final['promedio']>0){
		$situacion_final = $fila_final['situacion_final'];
	}
	
	$grado_palabra = $grado + 1;
	
	if ($grado_palabra=="1"){
		$grado_palabra = "PRIMER";
	}
	if ($grado_palabra=="2"){
		$grado_palabra = "SEGUNDO";
	}
	if ($grado_palabra=="3"){
		$grado_palabra = "TERCER";
	}
	if ($grado_palabra=="4"){
		$grado_palabra = "CUARTO";
	}
	if ($grado_palabra=="5"){
		$grado_palabra = "QUINTO";
	}
	if ($grado_palabra=="6"){
		$grado_palabra = "SEXTO";
	}
	if ($grado_palabra=="7"){
		$grado_palabra = "SEPTIMO";
	}
	if ($grado_palabra=="8"){
		$grado_palabra = "OCTAVO";
	}
	
	$situacion_pal = "ES PROMOVIDO(A) A ".$grado_palabra." AÑO DE  ".strtoupper($ensenanza_pal);

    if  ($ensenanza==110 and $grado == 8){
	    $situacion_pal = "ES PROMOVIDO(A) A PRIMER AÑO DE ENSEÑANZA MEDIA";
	}
	
	if  ($ensenanza==310 and $grado == 4){
	    $situacion_pal = "EGRESA DE ".strtoupper($ensenanza_pal);
	}
    ?>
    <br>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><div align="left"><font face="Arial, Helvetica, sans-serif" size="-2"><strong>SITUACI&Oacute;N FINAL:&nbsp;&nbsp;
		<?
		if ($situacion_final==1)
			echo $situacion_pal;
			  if ($situacion_final==2)
				   echo "REPITE CURSO";
				   if ($situacion_final==3)
						 echo "RETIRADO DEL CURSO";		
		
		?>
		</strong></font></div></td>
	  </tr>
	</table>
<? } ?>
      
        
        	  
		        <br>
                 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
                <table width="100%">
                  <tr>
		<td class="subitem"><? echo ucwords(strtolower($ob_membrete->comuna)).", ".$fecha?></td>
	</tr>
</table>
              
	
    </table>
	</td>
  </tr>
	  <tr>
		  <td>&nbsp;</td>
	  </tr>
		
    </table>
<? if(($institucion!="770") and ($institucion!="11209" ) and ($institucion!="9239")){	?>
<?	}

	if  (($cont_alumnos - $cont_paginas)<>1){ 
		echo "<H1 class=SaltoDePagina></H1>";
	}
}


?>
</center>
</form>

</body>
</html>


</div>
<? pg_close($conn);?>