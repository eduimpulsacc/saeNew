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
	$periodo		=$cmb_periodos;
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


  	

		
	
				  

	if($cb_ok!="Buscar"){
		$xls=1;
	}
		 
	if($xls==1){	 
	$fecha_actual = date('d/m/Y-H:i:s');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Parciales_alumno_$fecha_actual.xls"); 	 
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
<meta http-equiv="Content-Type" content="text/html; charset=charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>INFORME DE NOTAS PARCIALES</title>
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
</head>
<!---->
<body onLoad="window.print()">
<div id="capa0">
<!--<table width="650" align="center">
  <tr>
    <td width="188"><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR" /></td>
    <td width="367" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></td>
    <td width="79" align="right"><input name="cb_exp" type="button" onClick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR" /></td>
  </tr>
</table>-->
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
	
	

	//---------------------------
	$sql = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.truncado_per, curso.truncado_final, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.cod_decreto, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit, curso.ensenanza,curso.fecha_inicio,curso.fecha_termino,curso.bool_psemestral  ";
	$sql = $sql . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
	$result =@pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($result,0);	
	$truncado_per = $fila['truncado_per'];
	$truncado_final = $fila['truncado_final'];
	$finicio_curso = $fila['fecha_inicio'];
	$ftermino_curso = $fila['fecha_termino'];
	$truncado_sem = $fila['bool_psemestral'];
	
	if($id_ulperiodo==$periodo){
		if($ftermino_curso!=''){
			$fecha_fin = $ftermino_curso;
		}else{
			$fecha_fin = $fecha_fin;
		}
		
	
	}else{
	$fecha_fin = $fecha_fin;
	}
	
	//echo "->".$fecha_fin;
	
	
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
	
?>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <? if ($institucion!="770"){ ?>
    <td width="114" class="item"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
    <td width="9" class="item"><strong>:</strong></td>
    <td width="361" class="item"><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>
    <td width="161" rowspan="7" align="center" valign="top" ><?
					$result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto  = @pg_fetch_array($result,0);
					## c&oacute;digo para tomar la insignia
			
				  if($institucion!=""){
					   echo "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?>    </td>
    <? } ?>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>A&Ntilde;O ESCOLAR</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left"><? echo trim($nro_ano) ?></div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>CURSO</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left"><? echo $Curso_pal; ?></div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>ALUMNO</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left">
      <? $nombre_alumno = ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu'])));
	  echo $ob_reporte->tildeM($nombre_alumno);  ?>
    </div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>PROFESOR(A) JEFE</strong></div></td>
    <td class="item"><div align="left"><strong>:</strong></div></td>
    <td class="item"><div align="left">
      <?
				    if($institucion==770){
		                 echo $ob_reporte->profe_nombre;
					}else{
		                 echo $ob_reporte->tildeM($ob_reporte->profe_jefe);
					}				
					?>
    </div></td>
  </tr>
  
</table>
<table width="650" border="0" align="center">
  <tr>
    <td class=""><div align="center"><strong>INFORME DE NOTAS</strong> </div></td>
  </tr>
     <?
	  if ($institucion==770){
	      ?>
		  <tr>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Decreto Evaluación Nº : ".$decreto_eval?></strong></font></div></td>
          </tr>
          <tr>
            <td><div align="center"><font face="Arial, Helvetica, sans-serif" size="-2"><strong><? echo "Planes y Programas Nº : ".$planes?></strong></font></div></td>
          </tr>
   <? } ?>
      <tr>
        <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><? echo ucwords(strtoupper($periodo_pal))?></strong></font></div></td>
      </tr>
  
 
</table>
<br />
<?
		  $promedio_gen = 0;
		  $cont_promgen = 0;
		  $prom_gen_asis = 0;
	      $prom_cont_asis =0;
		  $prome_semestral_ap=0;
		   for($i=0 ; $i < @pg_numrows($result1) ; $i++)
			{
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

				$sql8 = "select count(*) as contador from notas$nro_ano where id_periodo = ". $id_periodo . " and rut_alumno = '" . $alumno."'";
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
				if ($fila8['contador']>0)
				{
				$ob_reporte ->ano = $ano;
				$resultPer = $ob_reporte ->TotalPeriodo($conn);
				for($m=0;$m<@pg_numrows($resultPer);$m++){
					$fila_per = @pg_fetch_array($resultPer,$m);
					if($m==0){
					$primer_periodo = $fila_per['id_periodo'];
					}
				}
				
				?>	
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="279" class="item">Subsector del Aprendizaje <br />
    (Formaci&oacute;n General)</td>
    <td colspan="20" class="subitem"><div align="center">Notas</div></td>
     <? 
	 		if($tipo_rep!=4){
			if((trim($fila1['nombre_periodo'])=="PRIMER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="PRIMER SEMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){			
			$tot_periodo = 1;
			
			if($institucion==1914 OR $institucion==40251){
				if($primer_periodo==$periodo){
			?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1&ordm;<? echo $tipo_per ?></strong></font></td>
					
            <?	}
			}else{?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>1&ordm;<? echo $tipo_per ?></strong></font></td>
			<? } 
			if($chk_coef2==1){?> 
			
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Ex.<br /> C2</strong></font></td>
               <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>
                 Final<br />1&ordm;<? echo $tipo_per ?></strong></font></td>
			
			<?php }
			if($tipo_eval==2){ ?>
				    <td align="center"  bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom.<br>Aprec &nbsp;1&ordm;<? echo $tipo_per ?></strong></font></td>
			<? }
				if($tipo_rep==2){ 
					if($institucion==1914 OR $institucion==40251){	
						if($primer_periodo==$periodo){?>					
					    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>Curso</strong></font></td>
			<? 			}
					}else{ ?>
					   <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>Curso</strong></font></td>
			<?		}	
				}
			}	
			
			$tri = 2;
			if((trim($fila1['nombre_periodo'])=="SEGUNDO TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE") OR (trim($fila1['nombre_periodo'])=="SEGUNDO SEMESTRE")){ 
			$tot_periodo = 2;
		
			?>
                    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>2&ordm;<? echo $tipo_per ?></strong></font></td>
         	<? if($chk_coef2==1){?> 
			
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Ex.<br /> C2</strong></font></td>
               <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>
                 Final<br />2&ordm;<? echo $tipo_per ?></strong></font></td>
			
			<?php } if($tipo_eval==2){ ?>
				    <td align="center"  bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom.<br>
				      Aprec &nbsp;2&ordm;<? echo $tipo_per ?></strong></font></td>
			        <? }	
				if($tipo_rep==2){ ?>
				    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>
				      Curso</strong></font></td>
		<? 		}
			

			}

			if ($num_periodos==3){$tri = 3;
			if(trim($fila1['nombre_periodo'])=="TERCER TRIMESTRE"){ 
			$tot_periodo = 3;
			?>
               <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>3&ordm;<? echo $tipo_per ?></strong></font></td>	
               
               <? if($chk_coef2==1){?> 
			
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Ex.<br /> C2</strong></font></td>
               <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>
                 Final<br />2&ordm;<? echo $tipo_per ?></strong></font></td>
			
			<?php }
            if($tipo_eval==2){ ?>
			   <td align="center"  bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom.<br>
			     Aprec</strong></font></td>
			<? }
			if($tipo_rep==2){ ?>
				    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>Curso</strong></font></td>
			        <? }
			if($tipo_rep==5){ ?>
				    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>Prom <br>Anual</strong></font></td>
			        <? }
             } 
			
			}
			
			} // fin tipo_rep?>
  </tr>
  <?
		  $cont_prom = 0;
		  $promedio = 0;
		  
		  $ob_reporte ->nro_ano = $nro_ano;
		  $ob_reporte ->alumno = $alumno;
		  $ob_reporte ->curso = $curso;
		  $ob_reporte ->subsector=$rb_subsector; 
		  $ob_reporte ->formacion=1;
		  $ob_reporte ->incide=1;
		  
		  $ob_reporte ->todos = 2;
		  
			  $ob_reporte ->RamoFormacion($conn);
		  
		  
          $result =$ob_reporte ->result;
		  if (!$result){
			  error('<B> ERROR :</b>Error al acceder a la BD. (SUBSECTOR)</B>');
    	  }else{
    			if (pg_numrows($result)!=0){
				  $fila = @pg_fetch_array($result,0);	
				  if (!$fila){
					  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					  exit();
				  }
			  }
		  }
		  $num_subsec = pg_numrows($result);
		  $prome_semestral = 0;
		  $cuenta_semestral =0;	
		  for($e=0 ; $e < @pg_numrows($result) ; $e++)
			{
			$fila = @pg_fetch_array($result,$e);
				$id_ramo = $fila['id_ramo'];
				$modo_eval = $fila['modo_eval'];
				$incide_promo = $fila['bool_ip'];
				$artistico = $fila['bool_artis'];
				
			

				
				/////////////////////////PORCENTAJES//////////////
				$sql_pocentaje = "SELECT pos21 FROM nota_porcentaje$nro_ano WHERE id_periodo=".$periodo." AND id_ramo=".$fila['id_ramo'];
			    $resp = @pg_exec($conn,$sql_pocentaje);
			    $pos21=@pg_result($resp,0);
			    ////////////////////////FIN PORCENTAJES///////////
				
			?>
                  <tr>
                    <?
		  	$ob_reporte ->rut_alumno = $alumno;
			$ob_reporte ->ramo = $id_ramo;
			$ob_reporte ->periodo = $id_periodo;
			$result2 = $ob_reporte->Notas($conn);
		  	if (!$result2) 
		  	{
				  error('<B> ERROR :</b>Error al acceder a la BD. (99)</B>');
    			}
			  else
    			{
	    			if (pg_numrows($result2)!=0)
				  {
					  $fila2 = @pg_fetch_array($result2,0);	
					  if (!$fila2)
					  {
						  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						  exit();
					  }
				  }
			  }
				$fila2 = @pg_fetch_array($result2,$f);
				$ob_reporte ->modo_eval =$modo_eval;
				$ob_reporte ->CambiaNota($fila2);
			?>
    <td height="25" class="subitem"><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">
                      <? if((trim($fila['nombre'])=="RELIGION") && ($institucion==9239)){ echo $fila['nombre']."(optativo)"; }else{ echo $fila['nombre']; if($fila['bool_ip']==0) echo "(no incide en promoción)"; }?>
                    </font></div></td>
   <? if($tipo_eval==1){?>
					
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos1 = porcentaje($periodo,$fila['id_ramo'],'pos1',$ob_reporte->nota1,$conn,$ano); 	}else{ if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font><? } else { echo $ob_reporte->nota1; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos2 = porcentaje($periodo,$fila['id_ramo'],'pos2',$ob_reporte->nota2,$conn,$ano);	}else{ if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?><? } else { echo $ob_reporte->nota2; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos3 = porcentaje($periodo,$fila['id_ramo'],'pos3',$ob_reporte->nota3,$conn,$ano);	}else{ if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?><? } else { echo $ob_reporte->nota3; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos4 = porcentaje($periodo,$fila['id_ramo'],'pos4',$ob_reporte->nota4,$conn,$ano);	}else{ if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font><? } else { echo $ob_reporte->nota4; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos5 = porcentaje($periodo,$fila['id_ramo'],'pos5',$ob_reporte->nota5,$conn,$ano);	}else{ if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font><? } else { echo $ob_reporte->nota5; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos6 = porcentaje($periodo,$fila['id_ramo'],'pos6',$ob_reporte->nota6,$conn,$ano);	}else{ if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font><? } else { echo $ob_reporte->nota6; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos7 = porcentaje($periodo,$fila['id_ramo'],'pos7',$ob_reporte->nota7,$conn,$ano);	}else{ if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font><? } else { echo $ob_reporte->nota7; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos8 = porcentaje($periodo,$fila['id_ramo'],'pos8',$ob_reporte->nota8,$conn,$ano);	}else{ if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font><? } else { echo $ob_reporte->nota8; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos9 = porcentaje($periodo,$fila['id_ramo'],'pos9',$ob_reporte->nota9,$conn,$ano);	}else{ if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font><? } else { echo $ob_reporte->nota9; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos10 = porcentaje($periodo,$fila['id_ramo'],'pos10',$ob_reporte->nota10,$conn,$ano); }else{ if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font><? } else { echo $ob_reporte->nota10; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos11 = porcentaje($periodo,$fila['id_ramo'],'pos11',$ob_reporte->nota11,$conn,$ano); }else{ if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font><? } else { echo $ob_reporte->nota11; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos12 = porcentaje($periodo,$fila['id_ramo'],'pos12',$ob_reporte->nota12,$conn,$ano); }else{ if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font><? } else { echo $ob_reporte->nota12; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos13 = porcentaje($periodo,$fila['id_ramo'],'pos13',$ob_reporte->nota13,$conn,$ano); }else{ if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font><? } else { echo $ob_reporte->nota13; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos14 = porcentaje($periodo,$fila['id_ramo'],'pos14',$ob_reporte->nota14,$conn,$ano); }else{ if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font><? } else { echo $ob_reporte->nota14; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos15 = porcentaje($periodo,$fila['id_ramo'],'pos15',$ob_reporte->nota15,$conn,$ano); }else{ if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font><? } else { echo $ob_reporte->nota15; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos16 = porcentaje($periodo,$fila['id_ramo'],'pos16',$ob_reporte->nota16,$conn,$ano); }else{ if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font><? } else { echo $ob_reporte->nota16; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos17 = porcentaje($periodo,$fila['id_ramo'],'pos17',$ob_reporte->nota17,$conn,$ano); }else{ if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font><? } else { echo $ob_reporte->nota17; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos18 = porcentaje($periodo,$fila['id_ramo'],'pos18',$ob_reporte->nota18,$conn,$ano); }else{ if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font><? } else { echo $ob_reporte->nota18; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos19 = porcentaje($periodo,$fila['id_ramo'],'pos19',$ob_reporte->nota19,$conn,$ano); }else{ if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font><? } else { echo $ob_reporte->nota19; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos20 = porcentaje($periodo,$fila['id_ramo'],'pos20',$ob_reporte->nota20,$conn,$ano); }else{ if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font><? } else { echo $ob_reporte->nota20; } ?></strong><? }?></div></td>
                   
				   <? }else{?>
				   
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0 && $institucion!=5661){ ?>
                      <strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font><? } else { echo $ob_reporte->nota1; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?><? } else { echo $ob_reporte->nota2; } ?></strong></div></td>
                  
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?><? } else { echo $ob_reporte->nota3; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font><? } else { echo $ob_reporte->nota4; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font><? } else { echo $ob_reporte->nota5; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font><? } else { echo $ob_reporte->nota6; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font><? } else { echo $ob_reporte->nota7; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font><? } else { echo $ob_reporte->nota8; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font><? } else { echo $ob_reporte->nota9; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font><? } else { echo $ob_reporte->nota10; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota11<40 && $ob_reporte->nota11>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font><? } else { echo $ob_reporte->nota11; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota12<40 && $ob_reporte->nota12>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font><? } else { echo $ob_reporte->nota12; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota13<40 && $ob_reporte->nota13>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font><? } else { echo $ob_reporte->nota13; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota14<40 && $ob_reporte->nota14>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font><? } else { echo $ob_reporte->nota14; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota15<40 && $ob_reporte->nota15>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font><? } else { echo $ob_reporte->nota15; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota16<40 && $ob_reporte->nota16>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font><? } else { echo $ob_reporte->nota16; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota17<40 && $ob_reporte->nota17>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font><? } else { echo $ob_reporte->nota17; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota18<40 && $ob_reporte->nota18>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font><? } else { echo $ob_reporte->nota18; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota19<40 && $ob_reporte->nota19>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font><? } else { echo $ob_reporte->nota19; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota20<40 && $ob_reporte->nota20>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font><? } else { echo $ob_reporte->nota20; } ?></strong></div></td>
				
				 <? } ?>	
				 <?
				////aucmulo promedio////
				$prom_pos = $pos1+$pos2+$pos3+$pos4+$pos5+$pos6+$pos7+$pos8+$pos9+$pos10+$pos11+$pos12+$pos13+$pos14+$pos15+$pos16+$pos17+$pos18+$pos19+$pos20;					
				/////fin//////	
				
				
				$ob_reporte ->ano =$ano;
				$resultPer =$ob_reporte ->TotalPeriodo($conn);
				//$prome_semestral_ap=0;
				
				for($per=0 ; $per < $tot_periodo ; $per++){				
					$filaperi = @pg_fetch_array($resultPer,$per);			
					$periodos = $filaperi['id_periodo'];
					//if($_PERFIL==0) echo "<br>".$periodos;
					$prome_ap=0;	
					$prome_abajo_ap=0;	
																																																				//-------			
																																																						
					/*$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->ano=$ano;
					$ob_reporte ->institucion=$institucion;
					$ob_reporte ->bool_ar=0; 
					$result_tiene = $ob_reporte->AlumnosTiene($conn);*/
					
					$rs_notas =0;
					$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->periodo = $periodos;								 																																					
					$XUXA =$ob_reporte->Notas($conn);
					pg_dbname($conn);
					if (pg_numrows($XUXA)>0){ 
						$fila_peri = @pg_fetch_array($XUXA,0);
						$fila_peri['promedio'];
						if($tipo_eval==2){
							if($fila_peri['notaap']=="0" or trim($fila_peri['notaap'])==""){
								if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim($fila_peri['promedio'])==""){
									$prome_1 = "&nbsp;";
									$prome_ap="&nbsp;";
								} else {																																																										
									if ($fila_peri['promedio']>0){
										$prome_1 = round($fila_peri['promedio'],0);
										$prome_ap = round($fila_peri['notaap'],0);										
									} else {
										$prome_1 = $fila_peri['promedio'];
										$prome_ap = $fila_peri['notaap'];										
									}
								}
							}else{
								$prome_1=$fila_peri['promedio'];
								$prome_ap = $fila_peri['notaap'];										
							}
						}else{
								if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim($fila_peri['promedio'])=="" or ($fila['bool_ip']==0 and $chk_prom_taller==1)){
									$prome_1 = "&nbsp;";
								} else {																																																										
									if ($fila_peri['promedio']>0){
										$prome_1 = round($fila_peri['promedio'],0);					
									} else {
										$prome_1 = $fila_peri['promedio'];					
									}
								}
								
						}
					} else {
						$ob_reporte->nro_ano=$nro_ano;
						$ob_reporte ->alumno =$alumno;
						$ob_reporte ->ramo = $id_ramo;
						$rs_eximido = $ob_reporte->AlumnoEximido1($conn);
						@pg_numrows($rs_eximido);
						if(@pg_numrows($rs_eximido)==0 and $artistico!=1){
							$prome_1="EX";
						}else{
							$prome_1 = "&nbsp;";
						}
						
						
						//$prome_1="&nbsp;";
						
					}
					
					if($tipo_eval==1){
					  	if($pos21=="100"){
					  		$prome_1 = $prom_pos;
					  	}
					}					
					 ///// acomulo promedio para mostrar al final ///
					if ($prome_1>0){
						
						$prome_semestral = $prome_semestral + $prome_1;
						$cuenta_semestral = $cuenta_semestral + 1;
						$prome_semestral_ap = $prome_semestral_ap + $prome_ap;
						
					}	
							
					
					/*if($_PERFIL==0){
						echo "<br> promedios Apreciacion-->".$prome_semestral_ap;
						echo "contador -->".$cuenta_semestral;
					}*/
					if($institucion==1914 OR $institucion==40251){
						if($periodos==$periodo){ ?>
						<td align="center" class="subitem"><? if($prome_1<40 && $prome_1>0  && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $prome_1 ?></font><? } else { echo $prome_1; } ?></strong></td>
					<? 	}
					
					}else{?>
					<td align="center" class="subitem"><? if($prome_1<40 && $prome_1>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? 
echo $prome_1 ?></font><? } else { echo $prome_1; } ?></strong></td>
 <? if($chk_coef2==1){
	  $sq_pcoef ="select nota1,promedio from notacoef where rut_alumno=$alumno and id_ramo=$id_ramo and id_periodo=".$filaperi['id_periodo'];
	 $res_reg = pg_exec($conn, $sq_pcoef);
		$notacoef = pg_result($res_reg,0);
		$promcoef = pg_result($res_reg,1);
		
		if(pg_numrows($res_reg)==0){
			$promcoef= $prome_1;	
		}

		if ($promcoef>0){
			
			$prome_semestral_coef= $prome_semestral_coef + $promcoef;
			$cuenta_semestral_coef = $cuenta_semestral_coef + 1;
			//$prome_semestral_ap = $prome_semestral_ap + $prome_ap;
			
		}	


	 ?> 
                   <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $notacoef; ?></strong></font></td>
               <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $promcoef;?></strong></font></td>
                   <?php }?>
					                  
					<? }
					if($tipo_eval==2){
					?>
					<td align="center" bgcolor="#CCCCCC"><font  size="1" face="Arial, Helvetica, sans-serif"><strong><i><?=$prome_ap;?></i></strong></font></td>
					<? } 
					 if($tipo_rep==2){
					  	/*	$ob_reporte ->periodo=$periodos;
							$ob_reporte	->ramo=$id_ramo;
							$ob_reporte ->PromedioRamoCurso($conn);*/
							
							$sql ="SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador FROM notas$nro_ano WHERE id_ramo=".$id_ramo." AND promedio NOT IN('0','MB','B','S','I',' ','x')  ";
							if($periodos!=""){
								$sql.="AND id_periodo=".$periodos."";
							}
							$rs_prom_curso = pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);
							$suma_curso = pg_result($rs_prom_curso,0);
							$contador_curso = pg_result($rs_prom_curso,1);
							$prom_curso = intval($suma_curso / $contador_curso);
							//if($_PERFIL==0) echo $suma_curso."---".$contador_curso;
							if($prom_curso==0){
								$prom_curso="&nbsp;";
							}
							if ($prom_curso>0){
							    $suma_prom_curso = $suma_prom_curso + $prom_curso;
								$cont_prom_curso++;
							}	
							if($institucion==1914 OR $institucion==40251){
								if($periodos==$periodo){ ?>
									<td  align="center" class="subitem"><?=$prom_curso;?></td>
							<? 	}
							}else{?>
							  <td  align="center" class="subitem"><?=$prom_curso;?></td>
					  
                    <?		}
						}
						
					
				} 
				if($tipo_rep==5){
						$sql="SELECT promedio,id_periodo FROM notas$nro_ano WHERE id_ramo=".$id_ramo." AND rut_alumno=".$alumno;
						
						$rs_prom_anual = pg_exec($conn,$sql);
						$suma_anual = 0;
						$suma_anual1 = 0;
						$cont_anual = 0;
						$cont_conceptual=0;
						for($xx=0;$xx<pg_numrows($rs_prom_anual);$xx++){		
							$fila_anual =pg_fetch_array($rs_prom_anual,$xx);
							if($fila_anual['id_periodo'] <= $periodo){
								$suma_anual = $suma_anual + $fila_anual['promedio'];
								$cont_anual++;
								if($modo_eval==2 || $modo_eval==3){
									$suma_anual1=$suma_anual1 + Conceptual($fila_anual['promedio'],2);
									$cont_conceptual++;
									
								}
							}
							if($modo_eval==2 || $modo_eval==3){
									$prom_anual = Conceptual((round($suma_anual1 / $cont_conceptual)),1);
							}else{
								$prom_anual = round($suma_anual / $cont_anual);
							}
						}
							if($incide_promo==1){ 
								$suma_prom_gral = $suma_prom_gral + $prom_anual;
							
							if($modo_eval==1) $cont_prom_gral++;
							}
						?>
							<td  align="center" class="subitem"><? echo $prom_anual;?></td>
					<? }
						/*if($_PERFIL==0){
							echo "suma-->".$suma_prom_gral;
							echo "<br> contador-->".$cont_prom_gral;
						}*/
						?>
                 
  </tr>
  
  
  
  <? 
  //prueba for ramos hijo
  	 $sql_hijos ="select * from relacion_ramo where id_ramo_padre=".$id_ramo;
				
	$resp_hijos = @pg_exec($conn,$sql_hijos);
 // echo"->".pg_numrows($resp_hijos); 
  for($rh=0;$rh<pg_numrows($resp_hijos);$rh++){
	  $filhijo=pg_fetch_array($resp_hijos,$rh);
	  
	   $r_hijo = $filhijo['id_ramo_hijo'];
	  //nombre ramo
	  $qrh ="select ramo.id_ramo,subsector.nombre from ramo inner join subsector on subsector.cod_subsector = ramo.cod_subsector where ramo.id_ramo =".$r_hijo;
	  $srh = @pg_exec($conn,$qrh);
	  $n_hijo = pg_result($srh,1);
	  
	  
	  //ver si ramo tiene notas
	  $stn="select count (promedio) from notas$nro_ano where id_periodo=$periodo and id_ramo=$r_hijo and rut_alumno= $alumno AND promedio NOT IN ('0',' ')";
	 $rtn=  @pg_exec($conn,$stn);
	 $tn = pg_result($rtn,0);
	 if($tn>0){
	  ?>
	<tr><td>-->&nbsp;&nbsp;&nbsp;&nbsp;<font size="1" face="Arial, Helvetica, sans-serif"><?php echo $n_hijo ?></font></td>
    
     <?
		  	$ob_reporte ->rut_alumno = $alumno;
			$ob_reporte ->ramo = $r_hijo;
			$ob_reporte ->periodo = $id_periodo;
			$result2 = $ob_reporte->Notas($conn);
		  	if (!$result2) 
		  	{
				  error('<B> ERROR :</b>Error al acceder a la BD. (99)</B>');
    			}
			  else
    			{
	    			if (pg_numrows($result2)!=0)
				  {
					  $fila2 = @pg_fetch_array($result2,0);	
					  if (!$fila2)
					  {
						  error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						  exit();
					  }
				  }
			  }
				$fila2 = @pg_fetch_array($result2,$f);
				$ob_reporte ->modo_eval =$modo_eval;
				$ob_reporte ->CambiaNota($fila2);
			?>
   
   <? if($tipo_eval==1){?>
					
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos1 = porcentaje($periodo,$fila['id_ramo'],'pos1',$ob_reporte->nota1,$conn,$ano); 	}else{ if($ob_reporte->nota1<40 && $ob_reporte->nota1>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font><? } else { echo $ob_reporte->nota1; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos2 = porcentaje($periodo,$fila['id_ramo'],'pos2',$ob_reporte->nota2,$conn,$ano);	}else{ if($ob_reporte->nota2<40 && $ob_reporte->nota2>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?><? } else { echo $ob_reporte->nota2; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos3 = porcentaje($periodo,$fila['id_ramo'],'pos3',$ob_reporte->nota3,$conn,$ano);	}else{ if($ob_reporte->nota3<40 && $ob_reporte->nota3>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?><? } else { echo $ob_reporte->nota3; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos4 = porcentaje($periodo,$fila['id_ramo'],'pos4',$ob_reporte->nota4,$conn,$ano);	}else{ if($ob_reporte->nota4<40 && $ob_reporte->nota4>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font><? } else { echo $ob_reporte->nota4; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos5 = porcentaje($periodo,$fila['id_ramo'],'pos5',$ob_reporte->nota5,$conn,$ano);	}else{ if($ob_reporte->nota5<40 && $ob_reporte->nota5>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font><? } else { echo $ob_reporte->nota5; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos6 = porcentaje($periodo,$fila['id_ramo'],'pos6',$ob_reporte->nota6,$conn,$ano);	}else{ if($ob_reporte->nota6<40 && $ob_reporte->nota6>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font><? } else { echo $ob_reporte->nota6; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos7 = porcentaje($periodo,$fila['id_ramo'],'pos7',$ob_reporte->nota7,$conn,$ano);	}else{ if($ob_reporte->nota7<40 && $ob_reporte->nota7>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font><? } else { echo $ob_reporte->nota7; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos8 = porcentaje($periodo,$fila['id_ramo'],'pos8',$ob_reporte->nota8,$conn,$ano);	}else{ if($ob_reporte->nota8<40 && $ob_reporte->nota8>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font><? } else { echo $ob_reporte->nota8; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos9 = porcentaje($periodo,$fila['id_ramo'],'pos9',$ob_reporte->nota9,$conn,$ano);	}else{ if($ob_reporte->nota9<40 && $ob_reporte->nota9>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font><? } else { echo $ob_reporte->nota9; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos10 = porcentaje($periodo,$fila['id_ramo'],'pos10',$ob_reporte->nota10,$conn,$ano); }else{ if($ob_reporte->nota10<40 && $ob_reporte->nota10>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font><? } else { echo $ob_reporte->nota10; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos11 = porcentaje($periodo,$fila['id_ramo'],'pos11',$ob_reporte->nota11,$conn,$ano); }else{ if($ob_reporte->nota11<40 && $ob_reporte->nota11>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font><? } else { echo $ob_reporte->nota11; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos12 = porcentaje($periodo,$fila['id_ramo'],'pos12',$ob_reporte->nota12,$conn,$ano); }else{ if($ob_reporte->nota12<40 && $ob_reporte->nota12>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font><? } else { echo $ob_reporte->nota12; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos13 = porcentaje($periodo,$fila['id_ramo'],'pos13',$ob_reporte->nota13,$conn,$ano); }else{ if($ob_reporte->nota13<40 && $ob_reporte->nota13>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font><? } else { echo $ob_reporte->nota13; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos14 = porcentaje($periodo,$fila['id_ramo'],'pos14',$ob_reporte->nota14,$conn,$ano); }else{ if($ob_reporte->nota14<40 && $ob_reporte->nota14>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font><? } else { echo $ob_reporte->nota14; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos15 = porcentaje($periodo,$fila['id_ramo'],'pos15',$ob_reporte->nota15,$conn,$ano); }else{ if($ob_reporte->nota15<40 && $ob_reporte->nota15>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font><? } else { echo $ob_reporte->nota15; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos16 = porcentaje($periodo,$fila['id_ramo'],'pos16',$ob_reporte->nota16,$conn,$ano); }else{ if($ob_reporte->nota16<40 && $ob_reporte->nota16>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font><? } else { echo $ob_reporte->nota16; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos17 = porcentaje($periodo,$fila['id_ramo'],'pos17',$ob_reporte->nota17,$conn,$ano); }else{ if($ob_reporte->nota17<40 && $ob_reporte->nota17>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font><? } else { echo $ob_reporte->nota17; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos18 = porcentaje($periodo,$fila['id_ramo'],'pos18',$ob_reporte->nota18,$conn,$ano); }else{ if($ob_reporte->nota18<40 && $ob_reporte->nota18>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font><? } else { echo $ob_reporte->nota18; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos19 = porcentaje($periodo,$fila['id_ramo'],'pos19',$ob_reporte->nota19,$conn,$ano); }else{ if($ob_reporte->nota19<40 && $ob_reporte->nota19>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font><? } else { echo $ob_reporte->nota19; } ?></strong><? }?></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($pos21=="100"){ echo $pos20 = porcentaje($periodo,$fila['id_ramo'],'pos20',$ob_reporte->nota20,$conn,$ano); }else{ if($ob_reporte->nota20<40 && $ob_reporte->nota20>0){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font><? } else { echo $ob_reporte->nota20; } ?></strong><? }?></div></td>
                   
				   <? }else{?>
				   
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota1<40 && $ob_reporte->nota1>0 && $institucion!=5661){ ?>
                      <strong><font color="#FF0000"><? echo $ob_reporte->nota1 ?></font><? } else { echo $ob_reporte->nota1; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota2<40 && $ob_reporte->nota2>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota2 ?><? } else { echo $ob_reporte->nota2; } ?></strong></div></td>
                  
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota3<40 && $ob_reporte->nota3>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota3 ?><? } else { echo $ob_reporte->nota3; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota4<40 && $ob_reporte->nota4>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota4 ?></font><? } else { echo $ob_reporte->nota4; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota5<40 && $ob_reporte->nota5>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota5 ?></font><? } else { echo $ob_reporte->nota5; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota6<40 && $ob_reporte->nota6>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota6 ?></font><? } else { echo $ob_reporte->nota6; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota7<40 && $ob_reporte->nota7>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota7 ?></font><? } else { echo $ob_reporte->nota7; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota8<40 && $ob_reporte->nota8>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota8 ?></font><? } else { echo $ob_reporte->nota8; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota9<40 && $ob_reporte->nota9>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota9 ?></font><? } else { echo $ob_reporte->nota9; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota10<40 && $ob_reporte->nota10>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota10 ?></font><? } else { echo $ob_reporte->nota10; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota11<40 && $ob_reporte->nota11>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota11 ?></font><? } else { echo $ob_reporte->nota11; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota12<40 && $ob_reporte->nota12>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota12 ?></font><? } else { echo $ob_reporte->nota12; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota13<40 && $ob_reporte->nota13>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota13 ?></font><? } else { echo $ob_reporte->nota13; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota14<40 && $ob_reporte->nota14>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota14 ?></font><? } else { echo $ob_reporte->nota14; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota15<40 && $ob_reporte->nota15>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota15 ?></font><? } else { echo $ob_reporte->nota15; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota16<40 && $ob_reporte->nota16>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota16 ?></font><? } else { echo $ob_reporte->nota16; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota17<40 && $ob_reporte->nota17>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota17 ?></font><? } else { echo $ob_reporte->nota17; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota18<40 && $ob_reporte->nota18>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota18 ?></font><? } else { echo $ob_reporte->nota18; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota19<40 && $ob_reporte->nota19>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota19 ?></font><? } else { echo $ob_reporte->nota19; } ?></strong></div></td>
                    <td width="17" class="subitem"><div align="center"><? if($ob_reporte->nota20<40 && $ob_reporte->nota20>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $ob_reporte->nota20 ?></font><? } else { echo $ob_reporte->nota20; } ?></strong></div></td>
				
				 <? } ?>	
				 <?
				////aucmulo promedio////
				$prom_pos = $pos1+$pos2+$pos3+$pos4+$pos5+$pos6+$pos7+$pos8+$pos9+$pos10+$pos11+$pos12+$pos13+$pos14+$pos15+$pos16+$pos17+$pos18+$pos19+$pos20;					
				/////fin//////	
				
				
				$ob_reporte ->ano =$ano;
				$resultPer =$ob_reporte ->TotalPeriodo($conn);
				//$prome_semestral_ap=0;
				
				for($per=0 ; $per < $tot_periodo ; $per++){				
					$filaperi = @pg_fetch_array($resultPer,$per);			
					$periodos = $filaperi['id_periodo'];
					//if($_PERFIL==0) echo "<br>".$periodos;
					$prome_ap=0;	
					$prome_abajo_ap=0;	
																																																				//-------			
																																																						
					/*$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $id_ramo;
					$ob_reporte ->ano=$ano;
					$ob_reporte ->institucion=$institucion;
					$ob_reporte ->bool_ar=0; 
					$result_tiene = $ob_reporte->AlumnosTiene($conn);*/
					
					$rs_notas =0;
					$ob_reporte ->rut_alumno =$alumno;
					$ob_reporte ->ramo = $r_hijo;
					$ob_reporte ->periodo = $periodos;								 																																					
					$XUXA =$ob_reporte->Notas($conn);
					pg_dbname($conn);
					if (pg_numrows($XUXA)>0){ 
						$fila_peri = @pg_fetch_array($XUXA,0);
						$fila_peri['promedio'];
						if($tipo_eval==2){
							if($fila_peri['notaap']=="0" or trim($fila_peri['notaap'])==""){
								if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim($fila_peri['promedio'])==""){
									$prome_1 = "&nbsp;";
									$prome_ap="&nbsp;";
								} else {																																																										
									if ($fila_peri['promedio']>0){
										$prome_1 = round($fila_peri['promedio'],0);
										$prome_ap = round($fila_peri['notaap'],0);										
									} else {
										$prome_1 = $fila_peri['promedio'];
										$prome_ap = $fila_peri['notaap'];										
									}
								}
							}else{
								$prome_1=$fila_peri['promedio'];
								$prome_ap = $fila_peri['notaap'];										
							}
						}else{
								if (chop($fila_peri['promedio'])=="0" or empty($fila_peri['promedio']) or trim($fila_peri['promedio'])=="" or ($fila['bool_ip']==0 and $chk_prom_taller==1)){
									$prome_1 = "&nbsp;";
								} else {																																																										
									if ($fila_peri['promedio']>0){
										$prome_1 = round($fila_peri['promedio'],0);					
									} else {
										$prome_1 = $fila_peri['promedio'];					
									}
								}
								
						}
					} else {
						$ob_reporte->nro_ano=$nro_ano;
						$ob_reporte ->alumno =$alumno;
						$ob_reporte ->ramo = $r_hijo;
						$rs_eximido = $ob_reporte->AlumnoEximido1($conn);
						@pg_numrows($rs_eximido);
						if(@pg_numrows($rs_eximido)==0 and $artistico!=1){
							$prome_1="EX";
						}else{
							$prome_1 = "&nbsp;";
						}
						
						
						//$prome_1="&nbsp;";
						
					}
					
					if($tipo_eval==1){
					  	if($pos21=="100"){
					  		$prome_1 = $prom_pos;
					  	}
					}					
					 ///// acomulo promedio para mostrar al final ///
					if ($prome_1>0){
						
						$prome_semestral = $prome_semestral + $prome_1;
						$cuenta_semestral = $cuenta_semestral + 1;
						$prome_semestral_ap = $prome_semestral_ap + $prome_ap;
						
					}	
							
					
					/*if($_PERFIL==0){
						echo "<br> promedios Apreciacion-->".$prome_semestral_ap;
						echo "contador -->".$cuenta_semestral;
					}*/
					if($institucion==1914 OR $institucion==40251){
						if($periodos==$periodo){ ?>
						<td align="center" class="subitem"><? if($prome_1<40 && $prome_1>0  && $institucion!=5661){ ?><strong><font color="#FF0000"><? echo $prome_1 ?></font><? } else { echo $prome_1; } ?></strong></td>
					<? 	}
					
					}else{?>
					<td align="center" class="subitem"><? if($prome_1<40 && $prome_1>0 && $institucion!=5661){ ?><strong><font color="#FF0000"><? 
echo $prome_1 ?></font><? } else { echo $prome_1; } ?></strong></td>
 <? if($chk_coef2==1){
	  $sq_pcoef ="select nota1,promedio from notacoef where rut_alumno=$alumno and id_ramo=$id_ramo and id_periodo=".$filaperi['id_periodo'];
	 $res_reg = pg_exec($conn, $sq_pcoef);
		$notacoef = pg_result($res_reg,0);
		$promcoef = pg_result($res_reg,1);
		
		if(pg_numrows($res_reg)==0){
			$promcoef= $prome_1;	
		}

		if ($promcoef>0){
			
			$prome_semestral_coef= $prome_semestral_coef + $promcoef;
			$cuenta_semestral_coef = $cuenta_semestral_coef + 1;
			//$prome_semestral_ap = $prome_semestral_ap + $prome_ap;
			
		}	


	 ?> 
                   <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $notacoef; ?></strong></font></td>
               <td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $promcoef;?></strong></font></td>
                   <?php }?>
					                  
					<? }
					if($tipo_eval==2){
					?>
					<td align="center" bgcolor="#CCCCCC"><font  size="1" face="Arial, Helvetica, sans-serif"><strong><i><?=$prome_ap;?></i></strong></font></td>
					<? } 
					 if($tipo_rep==2){
					  	/*	$ob_reporte ->periodo=$periodos;
							$ob_reporte	->ramo=$id_ramo;
							$ob_reporte ->PromedioRamoCurso($conn);*/
							
							$sql ="SELECT sum(cast (promedio as INTEGER)) as suma, count(*) as contador FROM notas$nro_ano WHERE id_ramo=".$id_ramo." AND promedio NOT IN('0','MB','B','S','I',' ','x')  ";
							if($periodos!=""){
								$sql.="AND id_periodo=".$periodos."";
							}
							$rs_prom_curso = pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);
							$suma_curso = pg_result($rs_prom_curso,0);
							$contador_curso = pg_result($rs_prom_curso,1);
							$prom_curso = intval($suma_curso / $contador_curso);
							//if($_PERFIL==0) echo $suma_curso."---".$contador_curso;
							if($prom_curso==0){
								$prom_curso="&nbsp;";
							}
							if ($prom_curso>0){
							    $suma_prom_curso = $suma_prom_curso + $prom_curso;

								$cont_prom_curso++;
							}	
							if($institucion==1914 OR $institucion==40251){
								if($periodos==$periodo){ ?>
									<td  align="center" class="subitem"><?=$prom_curso;?></td>
							<? 	}
							}else{?>
							  <td  align="center" class="subitem"><?=$prom_curso;?></td>
					  
                    <?		}
						}
						
					
				} 
				if($tipo_rep==5){
						$sql="SELECT promedio,id_periodo FROM notas$nro_ano WHERE id_ramo=".$r_hijo." AND rut_alumno=".$alumno;
						
						$rs_prom_anual = pg_exec($conn,$sql);
						$suma_anual = 0;
						$suma_anual1 = 0;
						$cont_anual = 0;
						$cont_conceptual=0;
						for($xx=0;$xx<pg_numrows($rs_prom_anual);$xx++){		
							$fila_anual =pg_fetch_array($rs_prom_anual,$xx);
							if($fila_anual['id_periodo'] <= $periodo){
								$suma_anual = $suma_anual + $fila_anual['promedio'];
								$cont_anual++;
								if($modo_eval==2 || $modo_eval==3){
									$suma_anual1=$suma_anual1 + Conceptual($fila_anual['promedio'],2);
									$cont_conceptual++;
									
								}
							}
							if($modo_eval==2 || $modo_eval==3){
									$prom_anual = Conceptual((round($suma_anual1 / $cont_conceptual)),1);
							}else{
								$prom_anual = round($suma_anual / $cont_anual);
							}
						}
							if($incide_promo==1){ 
								$suma_prom_gral = $suma_prom_gral + $prom_anual;
							
							if($modo_eval==1) $cont_prom_gral++;
							}
						?>
							<td  align="center" class="subitem"><? echo $prom_anual;?></td>
					<? }
						/*if($_PERFIL==0){
							echo "suma-->".$suma_prom_gral;
							echo "<br> contador-->".$cont_prom_gral;
						}*/
						
	}
						?>
  
    
    
    
    
    
    </tr>
	<?php
	}
  
  }  

	 
		 
  if($tipo_rep!=3 && $tipo_rep!=4){
  ?>
<TR height="25">
	<TD colspan="21" align="right"v> Promedio&nbsp;&nbsp;&nbsp;</TD>
	<? 
	$ob_reporte ->ano =$ano;
	$resultPer =$ob_reporte ->TotalPeriodo($conn);
	for($per=0 ; $per < $tot_periodo ; $per++){	
		$prome_abajo_ap=0;			
		$filaperi = @pg_fetch_array($resultPer,$per);	
		$periodos = $filaperi['id_periodo'];
		$ob_reporte ->nro_ano 	= $nro_ano;
		$ob_reporte ->periodos 	= $filaperi['id_periodo'];
		$ob_reporte ->alumno 	= $alumno;
		if($rb_subsector==0){
			$ob_reporte ->PromedioAlumno($conn);
		}else{
			$ob_reporte ->PromedioAlumnoSubNoValido($conn);
		}
		//if($_PERFIL==0) echo "<br>".$ob_reporte->sql;
		if($$truncado_sem==0){
			$prome_abajo = @intval($ob_reporte->suma / $ob_reporte->contador);
			//$prome_abajo = intval($prome_semestral / $cuenta_semestral);
			@$prome_abajo_ap = intval($ob_reporte->sumaAP / $cuenta_semestral_ap);
		}else{
			$prome_abajo = @round($ob_reporte->suma / $ob_reporte->contador,0);
			//$prome_abajo = round($prome_semestral / $cuenta_semestral);
			$prome_abajo_ap = @round($ob_reporte->sumaAP / $cuenta_semestral_ap);
		}
		if($_PERFIL==0) {
			echo $ob_reporte->suma;
			echo "<br>".$ob_reporte->contador;
			echo "<br>".$ob_reporte->sql;
			}
		/*$ob_reporte->curso=$curso;
		$ob_reporte->suma=$ob_reporte->suma;
		$ob_reporte->contador=$ob_reporte->contador;
		$ob_reporte->tipo=2;
		$ob_reporte->ConfigPromedios($conn);
		$prome_abajo = $ob_reporte->promedio;*/
		$prome_colilla = $prome_abajo;
	
	if($institucion==1914 OR $institucion==40251){
		if($periodos==$periodo){?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($prome_abajo>0) echo $prome_abajo; else  echo "&nbsp;"; ?></font></td>
	<? }
	}else{ ?>
	<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? if($prome_abajo>0) echo $prome_abajo; else  echo "&nbsp;"; ?></font></td>	
      <?php if($chk_coef2==1){?>
    <td>&nbsp;</td>
    <td class="subitem" align="center">
    <? 
			echo $prome_final_coef= intval($prome_semestral_coef / $cuenta_semestral_coef);
		?>    
    </td>
    <?php }?>
	<? }
	
		if($tipo_eval==2){
			if($truncado_final==0){
			$prome_abajo_ap = intval($ob_reporte->sumaAP / $ob_reporte->contador );
			}else{
			$prome_abajo_ap = round($ob_reporte->sumaAP / $ob_reporte->contador,0);
			} 
?>
<td align="center"  bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif"><?=$prome_abajo_ap?></font></td>
	<?	} // FIN PROMEDIO DE APRECIACION
	if($tipo_rep==2){
	
	//	$prom_curso = intval($suma_prom_curso/$cont_prom_curso);				
	$sql = "SELECT avg(cast (promedio as INTEGER)) as suma FROM notas$nro_ano WHERE id_ramo in (select id_ramo from ramo where id_curso=".$curso.") AND promedio NOT IN('0','MB','B','S','I',' ','x') AND id_periodo=".$periodos."";
		$rs_prom_curso =@pg_exec($conn,$sql);
		$prom_curso = intval(@pg_result($rs_prom_curso,0));
		if($institucion==1914 OR $institucion==40251){
			if($periodos==$periodo){?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?=$prom_curso?></font></td>					
		<?	}
		}else{?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?=$prom_curso?></font></td>
		<? }?>
		
<? 	}// FIN PROMEDIO CURSO 
	}
	if($tipo_rep==5){ 
			$prom_gral_anual = round($suma_prom_gral / $cont_prom_gral);?>
			<td align="center"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $prom_gral_anual;?></font></td>
	<? 	}
	// FIN FOR PERIODO DE PROMEDIOS ?>
  
</TR>
<? } ?>
</table>
<? 	}
  } ?>
  

<BR />
<table width="650" border="1" cellspacing="0" cellpadding="0" align="center">
	  <tr>
  
		<td width="175"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS PERIODO </strong></font></td>
		<td width="206"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $dias_habiles ?></font></td>
       
     
		<td width="172"><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL DIAS INASISTENTES</strong></font></td>
		<td width="97"><font size="1" face="Arial, Helvetica, sans-serif"><?=$inasistencia ?></font></td>
        
	  </tr>
	  <tr>
      
		<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ASISTENCIAS (%)</strong></font></td>
		<td><font size="1" face="Arial, Helvetica, sans-serif">
		  <? 
				if ($dias_habiles>0){
					$promedio_asistencia = round(($dias_asistidos*100) / $dias_habiles,2);
					$prom_gen_asis = $prom_gen_asis + $promedio_asistencia; 
					$prom_cont_asis = $prom_cont_asis + 1;
				}
				echo $promedio_asistencia . "%" ;
		  ?>
			</font>
		</td>
        
        
		<td><font size="1" face="Arial, Helvetica, sans-serif"><strong>TOTAL ATRASOS</strong></font></td>
		<td><font size="1" face="Arial, Helvetica, sans-serif">
		<?
				$ob_reporte ->alumno = $alumno;
				$ob_reporte ->tipo =2;
				$ob_reporte ->fecha_inicio = $fecha_ini;
				$ob_reporte ->fecha_termino = $fecha_fin;
				$result_atraso =$ob_reporte ->Anotaciones($conn);
				$fila_atraso = @pg_fetch_array($result_atraso,0);
				echo @pg_numrows($result_atraso);
		?>
		</font></td>
      
	  </tr>
      <tr>
      <? if($det_anot==1) {?>
      <td><font size="1" face="Arial, Helvetica, sans-serif"><strong>
         <?php echo "ANOTACIONES POSITIVAS"; ?>
      </strong></font></td>
      <td><font size="1" face="Arial, Helvetica, sans-serif">
      <?
		 
		 $sql_an="select * from anotacion where rut_alumno=$alumno and tipo=1 and tipo_conducta=1 and(fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
	  	 $rs_an =pg_exec($conn,$sql_an);
		 $tot_sql_an = @pg_numrows($rs_an);
		 

		 /* $sql_an1="select * from anotacion an
					inner join tipos_anotacion ta on CAST(an.codigo_tipo_anotacion as INTEGER)=ta.id_tipo
					where rut_alumno = $alumno and ta.tipo='1'
					and (fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
					$rs_an1=pg_exec($conn,$sql_an1)or die("fallo sql");*/
					$tot_sql_an1 = @pg_numrows($rs_an1);
		 echo $tot_pos = $tot_sql_an+$tot_sql_an1;	
		 
?>
      </font>&nbsp;
      </td>
  <?  }?>
    
     	<td><div align="left"><strong><font size="1" face="Arial, Helvetica, sans-serif">INASISTENCIAS JUSTIFICADAS</font></strong></div></td>
    	<td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif"><? echo $justifica ?></font></div></td>
    
      
      </tr>
      <tr>
       
        <td><strong><font size="1" face="Arial, Helvetica, sans-serif"><? if($det_anot==1) { ECHO "ANOTACIONES NEGATIVAS"; ?></font></strong></td>
        <td><font size="1" face="Arial, Helvetica, sans-serif">
          <?
		 $sql_anotneg="select * from anotacion where rut_alumno=$alumno and tipo=1 and tipo_conducta=2 and(fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
	  	 $rs_anotneg =pg_exec($conn,$sql_anotneg);
		 $tot_sql_anotneg = @pg_numrows($rs_anotneg);
		 
		  /*$sql_anotneg2="select * from anotacion an
					inner join tipos_anotacion ta on CAST(an.codigo_tipo_anotacion as INTEGER)=ta.id_tipo
					where rut_alumno = $alumno and ta.tipo='2' and tipo_conducta=2
					and (fecha>='".$fecha_ini."' and fecha<='".$fecha_fin."')";
					$rs_anotnet2=pg_exec($conn,$sql_anotneg2)or die("fallo sql");
					$tot_sql_anotneg2 = @pg_numrows($rs_anotnet2);*/
		 echo $tot_neg = $tot_sql_anotneg+$tot_sql_anotneg2;	
		 }
	  ?>
        </font>
        </td>
       
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
	</table>

<br />

	
	 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>

<? if ($_INSTIT!=770){ ?>
	<table width="650" align="center">
	<tr>
	<td>
   <? $fecha = $txtFECHA;?>
	  <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"><? echo ucwords(strtolower($ob_membrete->comuna)).", ". fecha_espanol($fecha) ?></font>
	</td>
	</tr>
	</table>
<? } ?>
<? 
 
	if  (($cont_alumnos - $cont_paginas)<>1){ 
		echo "<H1 class=SaltoDePagina></H1>";
	}
 ?>
	<? //} // FIN FOR ALUMNOS
} ?>
</body>
</html>
