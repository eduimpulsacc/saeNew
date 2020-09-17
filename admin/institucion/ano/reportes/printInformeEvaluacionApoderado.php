<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
?>
<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$cmb_ano;
	//$curso			=$c_curso;
	//$alumno			=$c_alumno;
	//$periodo		=$c_periodos;
	$reporte		=$c_reporte;	
	$_POSP = 4;
	$_bot = 8;
	
	
	//var_dump($_POST);

?>		

<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?	

 $ob_reporte= new Reporte();

	//-------------- INSTITUCION -------------------------------------------------------------
	$ob_institucion = new Membrete();
	$ob_institucion -> ano =$ano;
	$ob_institucion -> institucion =$institucion;
	$ob_institucion -> institucion($conn);
	//--------------- Curso ------------------//
	//$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	
	
	
	/********** AÑO ESCOLAR*****************/
	$ob_membrete = new Membrete();
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	//------------------FECHAS DE PERIODOS -----------------------
	$sql="";
	$sql_peri = "select * from periodo where id_ano = ".$ano."  order by id_periodo,fecha_inicio";
		$result_peri = pg_exec($conn,$sql_peri);
		
	$tp=(pg_numrows($result_peri)==2)?"SE":"TR";
	
 
 //consultas por tipo de planilla
 if($cmbPlantilla==1){
	 //apo
	 if($cmb_apo!=0){
	 $ob_reporte->entrevistado=$cmb_apo;
	 }else{
	 $ob_reporte->entrevistado=0;
	}
}
elseif($cmbPlantilla==2){
	//alumno
	
	 if($cmb_alu!=0){
	 $ob_reporte->entrevistado=$cmb_alu;
	 }else{
	 $ob_reporte->entrevistado=0;
	}
	
}elseif($cmbPlantilla==3){
	//entrevistado
	if($cmb_emp!=0){
	$ob_reporte->entrevistado=$cmb_emp;
	 }else{
	 $ob_reporte->entrevistado=0;
	}
}
 
 $ob_reporte->evaluacion=$tip;
 $ob_reporte->ano=$cmb_ano;
 
 $rs_plantilla=$ob_reporte->evaluacionApo($conn);
 
 //dato plantilla
 //$rs_plantilla=$ob_reporte->PlantillaevaluacionApo($conn);
// $fila_plantilla = pg_fetch_array($rs_plantilla,0);

$cont_entrevistados = @pg_numrows($rs_plantilla);
  
  ////// FIN RESUMEN CURSO /////////  
	if($cb_ok!="Buscar"){
	$xls=1;
	}
		 
	if($xls==1){	 
	$fecha_actual = date('d/m/Y-H:i:s');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=InformeEvaluacionApoderado$fecha_actual.xls"); 	 
	}	

?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<script language="javascript" type="text/javascript">

function exportar(){
	window.location='printInformeAnotaciones_C.php?c_curso=<?=$curso?>&c_alumno=<?=$alumno?>&xls=1';
	return false;
  }
  
  
  
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:Verdana, Geneva, sans-serif;
 font-size:18px;
 }
 .item
 {
 font-family:Verdana, Geneva, sans-serif;
 font-size:14px;

 }
 .subitem
 {
 font-family:Verdana, Geneva, sans-serif;
 font-size:12px;
 }
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">


           <!-- INSERTO CUERPO DE LA PÁGINA -->
		   
<?
//if ($curso != 0){
   ?>
   <form name="form" action="printInformeAnotaciones_C.php" method="post" target="_blank">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
      <td><div id="capa0">
	<tablE width="100%">
	  <tr>
	  	<td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
           	<input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  	<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
	    </td>
	  </tr>
	</tablE>
     
      </div></td>
     </tr>
   </table>
   <?
//}
?>   
<br>
<?
	for($cont_paginas=0 ; $cont_paginas < $cont_entrevistados; $cont_paginas++)
{
	$fila_plantilla = pg_fetch_array($rs_plantilla,$cont_paginas);
	
	$ob_reporte->plantilla=$fila_plantilla['id_plantilla'];
	
	$rs_area = $ob_reporte->getAreas($conn);
	
	?>


	<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><?=$ob_institucion->ins_pal;?></strong></font></td>
		<td width="11">&nbsp;</td>
		<td width="152" rowspan="4" align="center"><? echo "<img src='".$d."tmp/".$institucion."insignia". "' >";	?></td>
	  </tr>
	  <tr>
		<td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><?=$ob_institucion->direccion;?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">Fono:<?=$ob_institucion->telefono;?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td height="41">&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
	




<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="titulo"><div align="center"><strong><?php echo $fila_plantilla['titulo'] ?></strong></div></td>
    </tr>
  <tr>
    <td class="">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="item"><strong><?php echo $fila_plantilla['descripcion'] ?></strong></td>
  </tr>
  <tr>
</table>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr >
    <td class="item">
    <?php   //consultas por tipo de planilla
 if($cmbPlantilla==1){
	 //apo
	 $ob_reporte->rut=$fila_plantilla['rut'];
	 
	 $result_apo=$ob_reporte->Apoderado_uno($conn);
	 $fila = @pg_fetch_array($result_apo,$cont_paginas);
	 
	 $n_ent= ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_apo'])));
	
}
elseif($cmbPlantilla==2){
	//alumno
	
	 //$ob_reporte->entrevistado=$cmb_alu;
	 $ob_reporte ->alumno =$fila_plantilla['rut'];
	 $result_alu =$ob_reporte ->TraeUnAlumno($conn);
	 $fila = @pg_fetch_array($result_alu,$cont_paginas);
	 
	 $n_ent= ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_alu']))); 
	
	
}elseif($cmbPlantilla==3){
	
	
	 //$ob_reporte->entrevistado=$cmb_alu;
	 $ob_reporte ->Empleado =$fila_plantilla['rut'];
	 $ob_reporte ->institucion =$institucion;
	 $result_emp =$ob_reporte ->Empleado($conn);
	 $fila = @pg_fetch_array($result_emp,$cont_paginas);
	 
	 $n_ent= ucwords(strtoupper(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_emp']))); 
	
} ?>
    <div align="left"><strong>Entrevistado: 
      <? echo $n_ent; ?>
    </strong></div></td>
    </tr>
  <tr>
    <td class="item"><strong>A&ntilde;o acad&eacute;mico: <? echo trim($nro_ano) ?></strong></td>
  </tr>
  <tr>
</table><br>

<table width="650"  align="center" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td class=""><div align="left"></div></td>
   
    <td  width="80" align="center" colspan="<?php echo pg_numrows($result_peri) ?>" class="item"><strong>Evaluaci&oacute;n</strong></td>
    
    </tr>
    <?php 
	  for($a=0;$a<pg_numrows($rs_area);$a++){
		  $fila_area = pg_fetch_array($rs_area,$a);
		  
		  $ob_reporte->area=$fila_area['id_area'];
		  $rs_item=$ob_reporte->getConceptoApo($conn);		
		  
	  ?>
  <tr class="item">
    <td ><strong><?= utf8_decode($fila_area['nombre']);?></strong></td>
    <?php  for($i=0;$i<pg_numrows($result_peri);$i++)
		{
       
		 
	
		?>
    <td  width="80" align="center" class="item"><strong><?php echo $i+1 ?> <?php echo $tp?></strong></td>
    <?php }?>
  </tr>
   <?php 
	  for($ii=0;$ii<pg_numrows($rs_item);$ii++){
			$fil_item = pg_fetch_array($rs_item,$ii);?>
<tr class="subitem" >
  <td width="545" class="te" ><?php echo utf8_decode($fil_item['nombre']) ?></td>
   <?php  for($k=0;$k<pg_numrows($result_peri);$k++)
		{
			
        $fila_per = pg_fetch_array($result_peri,$k);
		
		 
	$ob_reporte->ano=$ano;
	 $ob_reporte->periodo=$fila_per['id_periodo'];
	 $ob_reporte->entrevistado=$fila_plantilla['rut'];
	 
	 $ob_reporte->item=$fil_item['id_item'];
	 $ob_reporte->evaluacion=$fil_item['id_item'];
	 
	 $rs_obs = $ob_reporte->selEvaluacionPeriodo($conn);
	 
	 $fila_obs = pg_fetch_array($rs_obs,0);
	
	
	$pun="";
		if(pg_numrows($rs_obs)>0){
			$ob_reporte->evaluacion= $fila_obs['id_evaluacion'];
			$rs_pun = $ob_reporte->selItemEvaluacionApo($conn);
			$fil_pun=pg_fetch_array($rs_pun,0);
			$pun=$fil_pun['nombre'];
		}
	
		?>
    <td  width="80" align="center"><?php echo  $pun?></td>
    <?php }?>
  </tr>
<?php }?>
  <?php }?>
  <tr>
</table>
<br>
<table width="650" align="center" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr class="item"><td colspan="3"><div align="center" class="tt"><strong>METODOS DE EVALUACION</strong></div></td>
  </tr>
<tr>
  <td colspan="3">&nbsp;</td>
  </tr>
<tr class="item">
  <td><strong>NOMBRE</strong></td>
  <td><strong>SIGLA</strong></td>
  <td><strong>GLOSA</strong></td>
  </tr>
  <?php $rs_con = $ob_reporte->ListaConceptoApo($conn);
  ?>
    <?php
		for($j=0;$j<pg_numrows($rs_con);$j++){
			$fila_con = pg_fetch_array($rs_con,$j);
		?>
<tr class="subitem" >
  <td align="center" class="te2"><?php echo utf8_decode($fila_con['nombre']) ?></td>
  <td align="center" class="te2"><?php echo utf8_decode($fila_con['sigla']) ?></td>
  <td class="te">&nbsp;<?php echo utf8_decode($fila_con['glosa']) ?></td>
</tr>
<?php }?>
</table>
<br>
<br>

<table width="650" align="center" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr class="item"><td><strong>OBSERVACIONES</strong></td></tr>
 <?php  for($i=0;$i<pg_numrows($result_peri);$i++){
	 $fil_per=pg_fetch_array($result_peri,$i);
	 
	 $ob_reporte->ano=$ano;
	 $ob_reporte->periodo=$fil_per['id_periodo'];
	 $ob_reporte->entrevistado=$fila_plantilla['rut'];
	 
	 $rs_obs = $ob_reporte->selEvaluacionPeriodo($conn);
	 
	 $fila_obs = pg_fetch_array($rs_obs,0);
	 
	 ?>
<tr class="subitem">
  <td><?php echo $i+1 ?> <?php echo $tp?>: <?php echo $fila_obs['observacion']; ?></td>
</tr>
<?php }?>
</table>
<br>
<br>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 $concur=0;
		 include("firmas/firmas.php");?><br>
<br>
<table width="650" align="center" border="0" cellspacing="0" cellpadding="0">
		<tr><? $fecha = date("d-m-Y") ?>
		 <td width="%" align="left"><font face="Arial, Helvetica, sans-serif" size="1"><? echo ($ob_institucion->comuna .", " . fecha_espanol($fecha))?></font></td>
	  </tr>
	</table>
  <?
  if  (($cont_entrevistados - $cont_paginas)<>1){ 
	echo "<H1 class=SaltoDePagina></H1>";
}
 }
   ?>
</form>
<br>
</center>

</body>
</html>
<? pg_close($conn);?>