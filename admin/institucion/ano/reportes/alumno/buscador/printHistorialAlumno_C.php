<?
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_MotorBusqueda.php');
include('../../../../../clases/class_Membrete.php');
include('../../../../../clases/class_Reporte.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$rut			=$txtRUT;
	$reporte		=$c_reporte;
	$_POSP = 6;
	$_bot = 8;

	$ob_reporte = new Reporte();
	
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------		
	$ob_membrete = new Membrete();
	$ob_membrete->institucion=$institucion;
	$ob_membrete->institucion($conn);

	/*************ANO ESCOLAR *********************/
	$ob_reporte ->ano =$ano;
	$ob_reporte ->AnoEscolar($conn);
	$nro_ano = $ob_reporte->nro_ano;
	
	/************* CONFIGURACION REPORTE ********************/
	$ob_config = new Reporte();
	$ob_reporte = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$sql="select a.rut_alumno ||'-'|| a.dig_rut as rut_al, a.nombre_alu, a.ape_pat, a.ape_mat, bool_ar, nro_ano, i.nombre_instit, i.rdb,
grado_curso ||'-'|| letra_curso ||' '|| te.nombre_tipo as cursos, m.id_curso, m.id_ano,
p.promedio, p.asistencia, p.situacion_final, m.fecha, m.fecha_retiro
from alumno a 
INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno
INNER JOIN ano_escolar ae ON ae.id_ano=m.id_ano
INNER JOIN institucion i ON i.rdb=ae.id_institucion
INNER JOIN curso c ON c.id_curso=m.id_curso
INNER JOIN tipo_ensenanza te ON te.cod_tipo=c.ensenanza
LEFT JOIN promocion p ON p.rut_alumno=m.rut_alumno AND p.id_curso=m.id_curso
where a.rut_alumno=".$txtRUT." 
ORDER BY nro_ano ";
	$rs_alumno = pg_exec($conn,$sql);
	$fila_alu = pg_fetch_array($rs_alumno,0);
	


/************** FIRMA ***********************/
		$ob_reporte->rdb=$institucion;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
		$ob_reporte->item=$reporte;
		
	
		
		if($_PERFIL!=0 && $_PERFIL!=14){
			//veo si tiene autorizacion permanente
			$autp=$ob_reporte->checAutReporteTrabaja($conn);
			$aut = pg_result($autp,0);
			//echo "aut->".$aut;
			
		
			if($aut==0){
				//veo si el usuario tiene el reporte
				$ob_reporte->rdb=$institucion;
				$ob_reporte->usuario= $_NOMBREUSUARIO;
				$ob_reporte->item=$reporte;
				$rp = $ob_reporte->checAutReporte($conn);
				$crp= pg_numrows($rp);
				//echo "aut2->".$crp;
			
				}
				else{
				$crp = $aut;
				}
				
				$rs_quita = $ob_reporte->quitaAutReporte($conn);
		}
		else{
		$crp=1;
		}
		

if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Informe_becas_$fecha_actual.xls"); 	 
}	 

?>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){ 
window.close() 
} 


function exportar(form){
		  form.target="_blank";
		  form.action='printInformeBecas_C.php?tipo_ensenanza=<?=$tipo_ensenanza?>&xls=1';
		  form.submit(true);
		  }
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</head>
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
<body>
<div id="capa0">
<form name="form" method="post" action="../../printInformeBecas_C.php" target="_blank">
<table width="100%">
  <tr>
    <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR" /></td>
    <td align="right"><input name="button3" type="button" class="botonXX"  value="IMPRIMIR" onClick="javascript:imprimir()" />
	 <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR">
	<? }?>
	
	</td>
  </tr>
</table>
</div>
<br />
<br />
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="119" rowspan="6"><div align="center"><? echo "<img src='".$d."tmp/".$institucion."insignia". "' >";	?></div></td>
    <td width="404"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>
      <?=$ob_membrete->ins_pal;?>
    </strong></font></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>
      <?=$ob_membrete->direccion;?>
    </strong></font></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong>
      <?=$ob_membrete->telefono;?>
    </strong></font></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="600" border="0" align="center">
  <tr>
    <td class="tableindex">HISTORIAL ALUMNO</td>
  </tr>
</table><br />

<table width="600" border="0" align="center">
  <tr>
    <td width="100" class="textonegrita">ALUMNO</td>
    <td width="490" class="textosimple">&nbsp;<? echo $fila_alu['nombre_alu']." ".$fila_alu['ape_pat']." ".$fila_alu['ape_mat'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">RUT</td>
    <td class="textosimple">&nbsp;<?=$fila_alu['rut_al'];?></td>
  </tr>
</table>
<br />
<? for($i=0;$i<pg_num_rows($rs_alumno);$i++){
		$fila_ano = pg_fetch_array($rs_alumno,$i);
?>
<table width="600" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td width="135" class="textonegrita">A&Ntilde;O</td>
    <td width="455" class="textosimple">&nbsp;<?=$fila_ano['nro_ano'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">MATRICULA EN </td>
    <td class="textosimple">&nbsp;<?=$fila_ano['nombre_instit'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">FECHA MATRICULA</td>
    <td class="textosimple">&nbsp;<?=$fila_ano['fecha'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">CURSO</td>
    <td class="textosimple">&nbsp;<?=$fila_ano['cursos'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">ESTADO</td>
    <td class="textosimple">&nbsp;<? if($fila_ano['bool_ar']==1){ echo "RETIRADO"; }else{ echo "ACTIVO";} ?></td>
  </tr>
  <tr>
    <td class="textonegrita">FECHA RETIRO</td>
    <td class="textosimple">&nbsp;<?=$fila_ano['fecha_retiro'];?></td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" align="center" border="1" style="border-collapse:collapse">
      <tr>
        <td width="84%" class="textonegrita">ASIGNATURA</td>
        <td width="16%" class="textonegrita">PROMEDIO</td>
      </tr>
      <? 	$sql="SELECT s.nombre, psa.promedio
					FROM promedio_sub_alumno psa 
					INNER JOIN ramo r ON psa.id_ramo=r.id_ramo
					INNER JOIN subsector s ON s.cod_subsector=r.cod_subsector
					WHERE rut_alumno=".$txtRUT." and psa.id_curso=".$fila_ano['id_curso']."
					ORDER BY r.id_orden ASC";
			$rs_promedio = pg_Exec($conn,$sql);
	  		for($j=0;$j<pg_num_rows($rs_promedio);$j++){
		  	$fila_prom = pg_fetch_array($rs_promedio,$j);
		?>
      <tr>
        <td class="textosimple">&nbsp;<?=$fila_prom['nombre'];?></td>
        <td class="textosimple">&nbsp;<?=$fila_prom['promedio'];?></td>
      </tr>
      <? } ?>
    </table></td>
    </tr>
  <tr>
    <td class="textonegrita">SITUACION FINAL</td>
    <td class="textosimple">&nbsp;<? if($fila_ano['situacion_final']==1){ echo "PROMOVIDO"; }elseif($fila_ano['situacion_final']==2){ echo "REPROBADO"; }elseif($fila_ano['situacion_final']==3){ echo "RETIRADO"; } ?></td>
  </tr>
  <tr>
    <td class="textonegrita">PROMOCION</td>
    <td class="textosimple">&nbsp;<?=$fila_ano['promedio'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">% ASISTENCIA</td>
    <td class="textosimple">&nbsp;<?=$fila_ano['asistencia'];?></td>
  </tr>
</table><br />

<? } ?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>  <br />
</p>
<p>&nbsp;</p>
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
<!--<table width="100%" border="0">
  <tr>
  <? if($cb_ok!="Buscar"){?>
    <td>&nbsp;</td>
	<? }?>
	<?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg")  && $crp==1){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
                
			<td width="25%" class="item" height="100"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><span class="item"><?=$ob_reporte->nombre_emp;?> </span><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			<? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg")  && $crp==1){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 2 encontrado";
	             }else{
	               "Archivo Firma 2 no existe"; 
		        }
				if(isset($firmadig2)){
				echo $firmadig2;
				}else{
				?>
		    <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"> 
		      <div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg")  && $crp==1){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 3 encontrado";
	             }else{
	               "Archivo Firma 3 no existe"; 
		        }
				if(isset($firmadig3)){
				echo $firmadig3;
				}else{
				
				?>
			<td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file("../../../../empleado/firma_digital/".$rut_emp.".jpg") && $crp==1){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				echo $firmadig4;
				}else{
		?>
		  <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?> </div></td>
			<? }}?>
		  </tr>
		</table>-->
</form>
<p>&nbsp; </p>
</body>
</html>
