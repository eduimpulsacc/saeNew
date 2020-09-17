<? 

require('../../../../../../util/header.inc');

include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');


$institucion	= $_INSTIT;
$ano			= $select_anos;
$reporte		=$c_reporte;
$curso = $select_cursos;
$alumno  = $cmb_alumno;



$qry_ano="SELECT * FROM ano_escolar WHERE id_ano=".$ano." AND id_institucion=".$institucion;
$result_ano =@pg_Exec($conn,$qry_ano);
$fila_ano = @pg_fetch_array($result_ano,0);
"</br>".$ano_esc = $fila_ano['nro_ano'];

/// tomar nombre de la institucion
$qry_ins="SELECT nombre_instit FROM institucion WHERE rdb = '$_INSTIT'";
$result_ins =@pg_Exec($conn,$qry_ins);
$fila_ins = @pg_fetch_array($result_ins,0);
$nombre_institucion = $fila_ins['nombre_instit'];

//PERIODO
$sql_p="select id_periodo from periodo WHERE id_ano=".$ano." order by id_periodo desc limit 1";
$result_p =@pg_Exec($conn,$sql_p);
$periodo = pg_result($result_p,0);

 $sql_fercur ="select * from feriado_curso where id_curso=".$curso;
$rs_fercur = pg_exec($conn,$sql_fercur);


	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_membrete = new Membrete();
	$ob_config = new Reporte();
	$ob_reporte = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	
		$ob_reporte->periodo=$periodo;
	
		$ob_reporte->rdb=$institucion;
		$ob_reporte->item= $reporte;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
	
	
	$ob_reporte->ano=$ano;
	$ob_reporte->curso=$curso;
	$ob_reporte ->ProfeJefe($conn);

	
	
	if($alumno==0){
		$rs_alumno = $ob_reporte->TraeTodosAlumnos($conn);
	}
	else{
		$ob_reporte->alumno=$alumno;
		$rs_alumno = $ob_reporte->TraeUnAlumno($conn);
	}	


		$ob_membrete->curso = $curso;
		$rs_curso = $ob_membrete->curso($conn);
		if($ob_membrete->grado_curso==1) $gr="pa";
		if($ob_membrete->grado_curso==2) $gr="sa";
		if($ob_membrete->grado_curso==3) $gr="ta";
		if($ob_membrete->grado_curso==4) $gr="cu";
		if($ob_membrete->grado_curso==5) $gr="qu";
		if($ob_membrete->grado_curso==6) $gr="sx";
		if($ob_membrete->grado_curso==7) $gr="sp";
		if($ob_membrete->grado_curso==8) $gr="oc";
		if($ob_membrete->grado_curso==9) $gr="nv";
		if($ob_membrete->grado_curso==10) $gr="dc";
		if($ob_membrete->grado_curso==11) $gr="un";
		if($ob_membrete->grado_curso==12) $gr="duo";
		if($ob_membrete->grado_curso==13) $gr="tre";
		if($ob_membrete->grado_curso==14) $gr="cat";
		if($ob_membrete->grado_curso==15) $gr="quince";
		if($ob_membrete->grado_curso==16) $gr="diezseis";
		
		//echo $gr;
		
		$ob_reporte->ensenanza = $ob_membrete->cod_ensenanza;
		$ob_reporte->grado = @$gr;
		$ob_reporte->institucion=$institucion;
		$ob_reporte->tipop=0;
		$resultPlantilla = $ob_reporte->InformePlantilla($conn);
		$filaPlantilla=pg_fetch_array($resultPlantilla,0);
		$plantilla=$filaPlantilla['id_plantilla'];
		$nuevo_sis=$filaPlantilla['nuevo_sis'];
		
		//conceptos plantilla
		$ob_reporte->plantilla = $plantilla;
		$resultConc = $ob_reporte->InformeConceptoEvalInforme($conn);
		
//echo pg_numrows($rs_alumno);

//--------------------------------
	// CURSO
	  
		  	$sql_curso = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, plan_estudio.nombre_decreto,plan_estudio.cod_decreto, evaluacion.nombre_decreto_eval, institucion.rdb, institucion.dig_rdb, institucion.nu_resolucion, curso.ensenanza, curso.cod_es,curso.truncado_per,curso.fecha_inicio,curso.fecha_termino ";
			$sql_curso = $sql_curso . "FROM institucion, ((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN evaluacion ON curso.cod_eval = evaluacion.cod_eval ";
 			$sql_curso = $sql_curso . "WHERE (((curso.id_curso)=".$curso.") AND ((institucion.rdb)=".$institucion."));";
			/*if($_PERFIL==0) {
				echo $sql_curso;
			}*/
	$result_curso =@pg_Exec($conn,$sql_curso);
	$fila_curso =pg_fetch_array($result_curso,0);
	//$num_consulta = @pg_numrows($result_curso);
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	$grado = $fila_curso['grado_curso'];
	$ensenanza = $fila_curso['ensenanza'];
	$cod_decreto = $fila_curso['cod_decreto'];
	$nombre_decreto = $fila_curso['nombre_decreto'];
	$nombre_decreto_eval = $fila_curso['nombre_decreto_eval'];
	$rolbasededatos  = $fila_curso['rdb']." - ".$fila_curso['dig_rdb'];
	$nu_resolucion = $fila_curso['nu_resolucion'];
	$cod_es = $fila_curso['cod_es'];
	$truncado_per=$fila_curso['truncado_per'];
	$ensenanza_pal = $fila_curso['nombre_tipo'];
	$fecha_incurso = $fila_curso['fecha_inicio'];
	$fecha_tercurso = $fila_curso['fecha_termino'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<style>
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo8 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
</style>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
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

<script> 
function cerrar(){ 
window.close() 
} 
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<body>
<div id="capa0">
<table width="650" align="center">
  <tr><td>
   <input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
        <font size="1" face="Arial, Helvetica, sans-serif"></font>
   <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td></tr>
</table>
</div>
<?php for($a=0;$a<pg_numrows($rs_alumno);$a++){
	//$fila = pg_fetch_array($rs_alumno,$a);
	$fila_alu = @pg_fetch_array($rs_alumno,$a);
	$alumno = $fila_alu['rut_alumno'];
	$fecha_mat = $fila_alu['fecha'];
	$fecha_ret = $fila_alu['fecha_retiro'];
	$bool_ar = $fila_alu['bool_ar'];
	$rut_alumno = $fila_alu['rut_alumno'] . " - " . strtoupper($fila_alu['dig_rut']);
	$feriados_ano=0;
	$fera=0;
	if ($firma==0){
	     $nombre_alu = ucwords(strtoupper(trim($fila_alu['nombre_alu']) . " " . trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat'])));
	}else{
	     $nombre_alu = ucwords(strtoupper(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']))); 
	}
	$curso = $fila_alu['id_curso'];
	?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
	    <td width="150" rowspan="5" align="left" valign="top">
	<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		$fecha_resolucion = $fila_foto['fecha_resolucion'];
		$ano_solo = substr($fecha_resolucion,0,4);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?>
		</td>
		<td width="198" rowspan="5" align="left" valign="top">		
			<div align="center">
				<font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>REP&Uacute;BLICA DE CHILE</strong></font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> MINISTERIO DE EDUCACI&Oacute;N</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> DIVISI&Oacute;N DE EDUCACI&Oacute;N </font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">SECRETARÍA REGIONAL MINISTERIAL</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">DE EDUCACI&Oacute;N </font><BR>
		    </div></td>
 <td width="161" rowspan="5"><? //} ?>
   <?
		//$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		//$arr=@pg_fetch_array($result,0);
		//$fila_foto = @pg_fetch_array($result,0);
		//if 	(!empty($fila_foto['insignia']))
		//{
		//	$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
		//	$retrieve_result = @pg_exec($conn,$output);?></td>			
		<td width="90"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">REGIÓN</font></td>
		<td width="10"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td width="191"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $ob_membrete->region?></strong></font></td>
	   

	  </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">PROVINCIA</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? 
		//echo $institucion;
		if ($institucion==12838){
		echo "CALAMA";
		}else{
		echo $ob_membrete->provincia;
		}
		?></strong></font></td>
	    </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">COMUNA</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $ob_membrete->comuna?></strong></font></td>
	    </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">A&Ntilde;O ESCOLAR</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $nro_ano?></strong></font></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	</table>
<table width="650" border="0" align="center" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
   
  </tr>
  <tr>
    <td><table width="650" border="0" align="center" cellpadding="3" cellspacing="1">
      <tr>
        <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="1">CORPORACI&Oacute;N MUNICIPAL <? echo $ob_membrete->comuna?> PARA EL DESARROLLO SOCIAL</font></td>
        </tr>
      <tr>
        <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="4"><strong>CERTIFICADO ANUAL DE ESTUDIOS</strong></font></td>
        </tr>
      <tr>
        <td align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="3"><?=$ob_membrete->ins_pal;?></font></td>
        </tr>
      <tr >
        <td align="center">
          
          <font face="Verdana, Arial, Helvetica, sans-seri" size="3">EDUCACIÓN ESPECIAL</font>
          
          </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="650" border="0" align="center" cellspacing="0">
      <tr>
        <td align="justify">
          <font face="Verdana, Arial, Helvetica, sans-seri" size="-1"> Reconocido oficialmente por el Ministerio de Educación de la República de Chile según <? if($institucion==12086){ echo "RESOLUCIÓN EXENTA Nº 1379 DE FECHA 16 DE JUNIO DE 1987, MODIFICADA Y AMPLIADA SEGÚN RESOLUCIÓN EXENTA"; }else{ echo "DECRETO ";}?>
            <strong>N&ordm; 
            <? echo $nu_resolucion ?> de  <?=$ano_solo ?></strong> Rol Base de Datos <strong>Nº <? echo $rolbasededatos?></strong> otorga el presente Certificado de Calificaciones  Anuales y Situación Final a 
            DON(A) <strong><? echo $ob_reporte->tildeM($nombre_alu); ?></strong>&nbsp;&nbsp;Run <strong><? echo $rut_alumno ?></strong> del <strong><? echo $Curso_pal . $especialidad ?></strong> de acuerdo al plan de estudios aprobados por el Decreto 
            <strong>Nº <? 
			   if($institucion==253){
				   	echo "5715 de 2001";
			   }else{				   
				   echo $nombre_decreto;
			   }?></strong> Reglamento de Evaluación y Promoción Escolar Decreto exento de Evaluación <strong>Nº <? echo $nombre_decreto_eval ?></strong>
            </font>	
          </td>
        </tr>
      
      
</table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php 
//AREAS PRINCPALES
$ob_reporte->plantilla= $plantilla;
$ob_reporte->nuevo=1;
$rs_padre = $ob_reporte->InformeAreas($conn);
?>
  <table width="650" border="0" align="center" cellspacing="0">
    
    
    <?php for($p=0;$p<pg_numrows($rs_padre);$p++){
	  $fila_padre = pg_fetch_array($rs_padre,$p);
	  //buscar a los hijos
	  $id_padre = $fila_padre['id'];
	  $ob_reporte->id_padre=$id_padre;
	  $rs_hijo = $ob_reporte->InformeSubarea($conn);
	  
	  ?>
    <tr>
      <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-seri" size="2"><strong><?php echo $fila_padre['glosa'] ?></strong></font></td>
      </tr>
    <?php for($h=0;$h<pg_numrows($rs_hijo);$h++){
	  $fila_hijo = pg_fetch_array($rs_hijo,$h);
	  //busco a los nietos
	   $id_hijo = $fila_hijo['id'];
	  $ob_reporte->id_padre=$id_hijo;
	  $rs_nieto = $ob_reporte->InformeItem($conn);
	  $cuenta=0;
	   ?>
    <tr>
      <td colspan="4">&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><?php echo $fila_hijo['glosa'] ?></strong></font></td>
      </tr>
    <tr>
      <?php for($n=0;$n<pg_numrows($rs_nieto);$n++){
	  $fila_nieto = pg_fetch_array($rs_nieto,$n);
	  $cuenta++;
	  ?>
      
      <td width="567">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font face="Verdana, Arial, Helvetica, sans-seri" size="1"><?php echo $fila_nieto['glosa'] ?></font></td>
      <td width="79" align="center"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>
        <?php 
	 
		$ob_reporte->id_item=$fila_nieto['id'];
		$ob_reporte->alumno=$alumno;
		$result_respuesta=$ob_reporte->InformeConcepto($conn);
		$num_respuesta=pg_numrows($result_respuesta);
		
		if ($num_respuesta>0){
		$row_respuesta=pg_fetch_array($result_respuesta);
		
											
			if ($row_respuesta[concepto]==1){
				$ob_reporte->respuesta=$row_respuesta[respuesta];
				$result_con= $ob_reporte->InformeEvaluacion($conn);
				$num_con=pg_numrows($result_con);
				if ($num_con>0){
					$row_con=pg_fetch_array($result_con);
					/*if($ckCONCEPTO==1){
						echo "&nbsp;".strtoupper($row_con[nombre]);
					}else{*/
						echo "&nbsp;".strtoupper($row_con[sigla]);
					//}
				}
			}else{
				echo "&nbsp;".strtoupper($row_respuesta[respuesta]);
				
			}
														
		}
		
	 ?></strong></font></td> 
      <?php   echo ($cuenta%2==1)?"</td>":"</tr><tr>"; ?>
      
      <?php } //fin nieto?>
      </tr>
    <?php }// fin hijo?>
    <?php  } //fin padre?>
    
</table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="630" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
				<tr>
					<td colspan="10" class="subitem"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>ESCALA DE EVALUACI&Oacute;N:</strong></font></td>
				</tr>
				<tr>
               <? for($countConc=0 ; $countConc<@pg_numrows($resultConc) ; $countConc++){
					$filaConc=@pg_fetch_array($resultConc,$countConc);
					 if($countConc==5){?>
						 </tr>
                         <tr>			 
						
					<? } ?>
					<td ><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo $filaConc['sigla'];?>:</strong></font></div></td>
					<td align="left" ><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $filaConc['nombre'];?></font></div></td>
					
			<?	}	?>
				</tr>
                </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <?
		$result_final=$ob_reporte->Promocion($conn);
		
		$fila_final = @pg_fetch_array($result_final,0);
		
			
			$asistencia = $fila_final['asistencia']."%"; 
			$situacion_final = $fila_final['situacion_final'];
			$observacion = $fila_final['observacion'];
			
		
		?>
      
      <table width="650" border="0" cellspacing="0">
        <tr>
          <td width="132"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>D&Iacute;AS TRABAJADOS:</strong></font></td>
          <td width="111">
            <?php 
					
			$sql_dpp="select sum(dias_habiles) from periodo where id_ano=$ano";
			//nuevo calculo de dias trabajados
			//if($_PERFIL==0){
			
			//fecha_matricula
			if($fecha_incurso<$fecha_mat){
				$fecha_parte = $fecha_mat;
			}else{
				$fecha_parte = $fecha_incurso;
			}
				
			if($bool_ar==1){
				$fecha_termina = $fecha_ret;	
			}else{
			 	$fecha_termina = $fecha_tercurso;
			}	
				
			/*	echo CambioFD($fecha_parte);
				echo "-";
				echo CambioFD($fecha_termina);*/
			
			
			 $dia_semana= hbl($fecha_parte,$fecha_termina);
			 
			 //feriados 
			 
			// $sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$ano."  AND (feriado.fecha_inicio>='".$fecha_parte."' and feriado.fecha_fin<='".$fecha_termina."');";
			
			if(pg_numrows($rs_fercur)>0){
	$sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado  inner join feriado_curso on feriado_curso.id_feriado=feriado.id_feriado WHERE id_ano=".$ano." and id_curso =".$curso." AND (feriado.fecha_inicio>='".$fecha_parte."' and feriado.fecha_fin<='".$fecha_termina."');";
	}
else{
  $sql_fano ="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano=".$ano."  AND (feriado.fecha_inicio>='".$fecha_parte."' and feriado.fecha_fin<='".$fecha_termina."');";
}

//if($_PEFIL==0){echo $sql_fano;}
	$rs_feriadosano = @pg_exec($conn,$sql_fano);

for($ff=0;$ff<pg_numrows($rs_feriadosano);$ff++){
		$fila_feriadoano =pg_fetch_array($rs_feriadosano,$ff);
		
		$inciof= $fila_feriadoano['fecha_inicio'];
		
	
		
		if($fila_feriadoano['fecha_fin']==NULL)
		{
			 $finf=$inciof ;
			
		}else{
		
			$finf= $fila_feriadoano['fecha_fin'];
		}
		
		 $fera=$fera+$dif_dias =ddiff($inciof, $finf);
		
		}
		
	 	$feriados_ano=$fera;
		 
		 
		 //calculo final
		 $habiles = $dia_semana- $feriados_ano;
			
			//}
			
			
		//$rs_dpp=pg_exec($conn,$sql_dpp);
		//$habiles = @pg_result($rs_dpp,0);
		
		
		
		  ?>
          <font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><?php echo $habiles ?></strong></font></td>
          <td width="91"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>INASISTENCIAS:</strong></font></td>
          <td width="111">
            <?php  $sql_asi="select count(*) from asistencia where ano=$ano and rut_alumno=$alumno";
		$rs_asi=pg_exec($conn,$sql_asi);
		$asis = @pg_result($rs_asi,0);
		  ?>
          <font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><?php echo $asis ?></strong></font></td>
          <td width="99"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>ASISTENCIA (%):</strong></font></td>
          <td width="94">
          <?php $asistencia=round(100-(($asis*100)/$habiles),1); ?>
          <font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><?php echo $asistencia ?></strong></font></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="650" border="0" cellspacing="0">
      <tr>
        <td width="116"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>EN CONSECUENCIA:</strong></font></td>
        <td width="530"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"> EL ALUMNO ES PROMOVIDO AL NIVEL SUPERIOR
          <? /*
						if (($ensenanza==560) and ($grado==1)) {  
						$grado=$grado+1; 
						} 
						
					if ($_INSTIT==1593 || $_INSTIT==10232){
						 $nuevo_curso = $grado + 1;
						 if ($nuevo_curso==1){
							 $paso_a = "PRIMER";
						 }
						 if ($nuevo_curso==2){
							 $paso_a = "SEGUNDO";
						 }
						 if ($nuevo_curso==3){
							 $paso_a = "TERCER";
						 }
						 if ($nuevo_curso==4){
							 $paso_a = "CUARTO";
						 }
						 if ($nuevo_curso==5){
							 $paso_a = "QUINTO";
						 }
						 if ($nuevo_curso==6){
							 $paso_a = "SEXTO";
						 }
						 if ($nuevo_curso==7){
							 $paso_a = "SEPTIMO";
						 }
						 if ($nuevo_curso==8){
							 $paso_a = "OCTAVO";
						 }

						 $situacion_pal = "ES PROMOVIDO(A) A ".$paso_a." AÑO DE ".strtoupper($ensenanza_pal);
					}else{

						 if($institucion==25182 and ($grado==1 or $grado==2)){
							 $situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A ".($grado+1)."º AÑO DE ENSEÑANZA MEDIA ";
						 }elseif($institucion==283 and $grado==2){
							 $situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A ".($grado+1)."º AÑO DE ENSEÑANZA MEDIA ";				 
						 
						 }else{

							 if($institucion==1676 and ($grado==4)){
								 $situacion_pal = "EL ALUMNO(A) HA EGRESADO DE LA ENSEÑANZA MEDIA ADULTO CIENTIFICO HUMANISTA";
							 }else if($cod_decreto==5842007 and ($grado==3)){

								 $situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A 1ER NIVEL (1° Y 2° MEDIO)  DE EDUCACIÓN MEDIA ADULTOS";
								
							 }else if($cod_decreto==121987 and ($grado==3 or $grado==4) ){
								 $situacion_pal = "EL ALUMNO(A) HA EGRESADO DE LA ENSEÑANZA MEDIA ADULTO CIENTIFICO HUMANISTA";
							}else{
								 $situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A ".($grado+1)."º AÑO DE  ".strtoupper($ensenanza_pal);
							 }
				
							  
						 }
					}
					
					
					if ($grado == 8)
						$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO(A) DE LA ".strtoupper($ensenanza_pal);
		
					if ($grado==4 and $ensenanza>309)
						if($institucion==1436 || $institucion==1676){
							$situacion_pal = "EL ALUMNO(A) EGRESA DE ".strtoupper($ensenanza_pal);
						}else{
							$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO(A) DE LA ".strtoupper($ensenanza_pal);
						}
					
				if  ($ensenanza==361){
					if ($grado == 1)
						$situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A SEGUNDO CICLO DE ".strtoupper($ensenanza_pal);
					if ($grado == 2)
						$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO(A) DE LA ".strtoupper($ensenanza_pal);
				}
				if  ($ensenanza==363){
					if ($grado == 1)
						$situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A SEGUNDO NIVEL  DE ".strtoupper($ensenanza_pal);
					if ($grado == 3)
						$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO(A) DE LA ".strtoupper($ensenanza_pal);
				}
				if  ($ensenanza==663){
					if ($grado == 1)
						$situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A SEGUNDO NIVEL  DE ".strtoupper($ensenanza_pal);
					if ($grado == 3)
						$situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A TERCER NIVEL  DE ".strtoupper($ensenanza_pal);
					if ($grado == 4)
						$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO(A) DE LA ".strtoupper($ensenanza_pal);
				}
				if  ($ensenanza==610){
					if ($grado == 4)
						$situacion_pal = "EL ALUMNO(A) HA SIDO EGRESADO(A) DE LA ".strtoupper($ensenanza_pal);
				}
				if  ($ensenanza==410){
					if ($grado == 4)
						$situacion_pal = "EL ALUMNO(A) HA SIDO EGRESADO(A) DE LA ".strtoupper($ensenanza_pal);
				}		
				if  ($ensenanza==563 or $ensenanza==463){
					if ($grado == 1)
						$situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A SEGUNDO NIVEL  DE ".strtoupper($ensenanza_pal);
					if ($grado == 3)
						$situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A TERCER NIVEL  DE ".strtoupper($ensenanza_pal);
					if ($grado == 4)
						$situacion_pal = "EL ALUMNO(A) HA SIDO LICENCIADO(A) DE LA ".strtoupper($ensenanza_pal);
				}
				
				if  ($ensenanza==110 and $grado == 8){
					  if ($_INSTIT==1593  || $_INSTIT==10232 || $_INSTIT==302){
						   $situacion_pal = "ES PROMOVIDO(A) A PRIMER AÑO DE ENSEÑANZA MEDIA";
					  }else{
						   $situacion_pal = "EL ALUMNO(A) ES PROMOVIDO A PRIMERO DE ENSEÑANZA MEDIA";
					  }	   
				}		

				if ($situacion_final==1)
						echo $situacion_pal;
					if ($situacion_final==2){
						if($_INSTIT==10232){
						 if ($grado==1){
							 $paso_a = "PRIMER";
						 }
						 if ($grado==2){
							 $paso_a = "SEGUNDO";
						 }
						 if ($grado==3){
							 $paso_a = "TERCER";
						 }
						 if ($grado==4){
							 $paso_a = "CUARTO";
						 }
						 if ($grado==5){
							 $paso_a = "QUINTO";
						 }
						 if ($grado==6){
							 $paso_a = "SEXTO";
						 }
						 if ($grado==7){
							 $paso_a = "SEPTIMO";
						 }
						 if ($grado==8){
							 $paso_a = "OCTAVO";
						 }
							echo "REPITE EL ".$paso_a." AÑO DE ".strtoupper($ensenanza_pal);
							
						}elseif($_INSTIT==1914 or  $_INSTIT==40252){
						 if ($grado==1){
							 $paso_a = "PRIMER";
						 }
						 if ($grado==2){
							 $paso_a = "SEGUNDO";
						 }
						 if ($grado==3){
							 $paso_a = "TERCER";
						 }
						 if ($grado==4){
							 $paso_a = "CUARTO";
						 }
						 if ($grado==5){
							 $paso_a = "QUINTO";
						 }
						 if ($grado==6){
							 $paso_a = "SEXTO";
						 }
						 if ($grado==7){
							 $paso_a = "SEPTIMO";
						 }
						 if ($grado==8){
							 $paso_a = "OCTAVO";
						 }
							echo "EL ALUMNO(A) HA REPROBADO EL ".$paso_a." AÑO DE ".strtoupper($ensenanza_pal);
						}else{
							echo "EL ALUMNO(A) HA REPROBADO EL ".$Curso_pal;
						}
					}
					if ($situacion_final==3)
						echo "EL ALUMNO(A) FUE RETIRADO";

				*/?>	</font></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>
      
      
      <table width="650" border="0" cellspacing="0">
        <tr>
          <td width="106"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>OBSERVACIONES:</strong></font></td>
          <td width="540">
            
            <?	
					 $sqlTraeObs="select * from informe_observaciones inner join periodo on informe_observaciones.id_periodo=periodo.id_periodo where informe_observaciones.id_periodo=".$periodo." and informe_observaciones.id_plantilla=".$plantilla." and informe_observaciones.rut_alumno='".$alumno."'";
										$resultObs=@pg_Exec($conn, $sqlTraeObs);
										for($countObs=0 ; $countObs<@pg_numrows($resultObs) ;$countObs++ ){
											$filaObs=@pg_fetch_array($resultObs, $countObs);	?><font size="1" face="Arial, Helvetica, sans-serif">
            <?												echo $filaObs['observaciones'];	?>&nbsp;</font>
            
  <?										}	?>
            
          </td>
        </tr>
    </table></td>
  </tr>
</table>
<br />


<br />

                <br />

             <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 //$concur=0;
		 include("../../firmas/firmas.php");?>
<?php
if  (pg_numrows($rs_alumno) >1){ 
		echo "<H1 class=SaltoDePagina></H1>";
	}
 }?>
</div>
</body>
</html>
