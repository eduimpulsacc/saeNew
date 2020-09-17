<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}


</script>
<?
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');

	//setlocale("LC_ALL","es_ES");

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$alumno 		=$cmb_alumno;
	$reporte		=$c_reporte;
	$_POSP = 6;
	$_bot = 8;
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_reporte ->ano = $ano;
	$ob_reporte ->AnoEscolar($conn);
	
	
	$ob_membrete->institucion=$institucion;
	$ob_membrete->institucion($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	/************** FIRMA ***********************/
		$ob_reporte->rdb=$institucion;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
		$ob_reporte->item=$reporte;
		
	
	/// tomar nombre de la institucion
$qry_ins="SELECT nombre_instit FROM institucion WHERE rdb = '$_INSTIT'";
$result_ins =@pg_Exec($conn,$qry_ins);
$fila_ins = @pg_fetch_array($result_ins,0);
$nombre_institucion = $fila_ins['nombre_instit'];
	
		


if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Informe_de_entrevistas_$fecha_actual.xls"); 	 
}	 
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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



function exportar(form){
		form.target="_blank";
		form.action='printInformeEntrevistas_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
		form.submit(true);
}
//-->
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>

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
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">

<!-- AQUÍ EL CONTENIDO CENTRAL DE LA PÁGINA -->
<?
if ($curso != 0){
   ?><br> 
  <form name="form" method="post" action="../../printInformeEntrevistas_C.php" target="_blank">
 
 
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div id="capa0">
	  <tablE width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
           <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		   <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR">
										<? }?>
	    </td></tr></table>
	</div>
	</td>
  </tr>
</table><br>
<?
}

	if ($alumno > 0)
	{
		$ob_reporte->ano = $ano;
		$ob_reporte->alumno = $alumno;
		$result_alumno= $ob_reporte->FichaAlumnoUno($conn);
	}else{
		$ob_reporte->ano = $ano;
		$ob_reporte->curso = $curso;
		$ob_reporte->retirado = 0;
		$result_alumno= $ob_reporte->FichaAlumnoTodos($conn);
	}	

	$cantidad_alumnos = @pg_numrows($result_alumno);
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++){
		$fila_alumno = @pg_fetch_array($result_alumno,$i);
		$ob_reporte ->CambiaDato($fila_alumno);
?> 
<table width="650" align="center">
  <tr><td>
<table width="650" border="0" cellspacing="0" cellpadding="0">
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
</table><br>

<?php $ob_reporte ->ano  = $ano;
$ob_reporte->entrevistado=$fila_alumno['rut_alumno'];
?><table width="650" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td class="tableindex"><div align="center">REGISTRO DE ENTREVISTAS - <?=$ob_reporte->nro_ano?> </div></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="5">
 
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="110" ><strong class="item">Alumno (a) : </strong></td>
    <td width="478" class="subitem"><?=$ob_reporte->tilde($ob_reporte->nombres);?>    </td>
    </tr>
    <tr>
    <td ><strong class="item">Curso : </strong></td>
    <td colspan="2" class="item">      <? $Curso_pal = CursoPalabra($curso,1,$conn); echo "$Curso_pal"; ?>    </td>
    </tr>
     <tr>
    <td class="item"><b>PROFESOR JEFE : </b></td>
    <td class="subitem">      <?php
			$ob_reporte->curso = $curso;
			$ob_reporte ->ProfeJefe($conn);
			echo $ob_reporte->tildeM($ob_reporte ->profe_jefe);
			?>         </td>
  </tr>
</table><br>
<table width="650" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td colspan="2" class="tableindex">Entrevistas Director</td>
    </tr>
    <?php 
	
	$ob_reporte ->tipo  = 5;
	$rs_ent1 = $ob_reporte->reporteTipoAlu($conn);
	?><?php  if(pg_numrows($rs_ent1)==0){?>
  <tr >
    <td colspan="2" align="center" class="item">Sin informaci&oacute;n</td>
    </tr>
  <?php }else{
	  for($f1=0;$f1<pg_numrows($rs_ent1);$f1++){
		  $filla1 = pg_fetch_array($rs_ent1,$f1);
	  ?>
  <tr >
    <td width="148" style="font-size:9px">Entrevistador</font></td>
    <td width="492" class="textosimple" style="font-size:9px"> <?php echo $filla1['entrevistador'] ?></td>
  </tr>
 
  <tr >
    <td class="textonegrita" style="font-size:9px">Fecha</td>
    <td class="textosimple" style="font-size:9px"><?php echo CambioFD($filla1['fecha']) ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Descripci&oacute;n</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla1['descripcion'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Obervaciones</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla1['observaciones'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Acuerdos</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla1['acuerdos'] ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php }?>
  <?php }?>
</table>
<br>

<table width="650" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="tableindex">
    <td colspan="2" >Entrevistas Jefe Utp</td>
    </tr>
    <?php 
	
	$ob_reporte ->tipo  = 2;
	$rs_ent2 = $ob_reporte->reporteTipoAlu($conn);
	?><?php  if(pg_numrows($rs_ent2)==0){?>
  <tr>
    <td colspan="2" align="center" class="item">Sin informaci&oacute;n</td>
    </tr>
  <?php }else{
	  for($f2=0;$f2<pg_numrows($rs_ent2);$f2++){
		  $filla2 = pg_fetch_array($rs_ent2,$f2);
	  ?>
  <tr>
    <td width="148" class="textonegrita" style="font-size:9px">Entrevistador</td>
    <td width="492" class="textosimple" style="font-size:9px"> <?php echo $filla2['entrevistador'] ?></td>
  </tr>
 
  <tr>
    <td class="textonegrita" style="font-size:9px">Fecha</td>
    <td class="textosimple" style="font-size:9px"><?php echo CambioFD($filla2['fecha']) ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Descripci&oacute;n</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla2['descripcion'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Obervaciones</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla2['observaciones'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Acuerdos</td>
    <td  class="textosimple" style="font-size:9px"><?php echo $filla2['acuerdos'] ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php }?>
  <?php }?>
</table>
<br>

<table width="650" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td colspan="2" class="tableindex">Entrevistas Inspector General</td>
    </tr>
    <?php 
	
	$ob_reporte ->tipo  = 6;
	$rs_ent1 = $ob_reporte->reporteTipoAlu($conn);
	?><?php  if(pg_numrows($rs_ent1)==0){?>
  <tr >
    <td colspan="2" align="center" class="item">Sin informaci&oacute;n</td>
    </tr>
  <?php }else{
	  for($f1=0;$f1<pg_numrows($rs_ent1);$f1++){
		  $filla1 = pg_fetch_array($rs_ent1,$f1);
	  ?>
  <tr >
    <td width="148" class="textonegrita"  style="font-size:9px">Entrevistador</td>
    <td width="492" class="textosimple" style="font-size:9px"> <?php echo $filla1['entrevistador'] ?></td>
  </tr>
 
  <tr>
    <td class="textonegrita" style="font-size:9px">Fecha</td>
    <td class="textosimple" style="font-size:9px"><?php echo CambioFD($filla1['fecha']) ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Descripci&oacute;n</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla1['descripcion'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Obervaciones</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla1['observaciones'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Acuerdos</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla1['acuerdos'] ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php }?>
  <?php }?>
</table>
<br>
<table width="650" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="tableindex">
    <td colspan="2">Entrevistas Encargado Convivencia Escolar</td>
    </tr>
    <?php 
	
	$ob_reporte ->tipo  = 7;
	$rs_ent7 = $ob_reporte->reporteTipoAlu($conn);
	?><?php  if(pg_numrows($rs_ent7)==0){?>
  <tr>
    <td colspan="2" align="center" class="item">Sin informaci&oacute;n</td>
    </tr>
  <?php }else{
	  for($f7=0;$f7<pg_numrows($rs_ent7);$f7++){
		  $filla7 = pg_fetch_array($rs_ent7,$f7);
	  ?>
  <tr>
    <td width="148" class="textonegrita" style="font-size:9px">Entrevistador</td>
    <td width="492" class="textosimple" style="font-size:9px"> <?php echo $filla7['entrevistador'] ?></td>
  </tr>
 
  <tr>
    <td class="textonegrita" style="font-size:9px">Fecha</td>
    <td class="textosimple" style="font-size:9px"><?php echo CambioFD($filla7['fecha']) ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Descripci&oacute;n</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla7['descripcion'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Obervaciones</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla7['observaciones'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Acuerdos</td>
    <td  class="textosimple" style="font-size:9px"><?php echo $filla7['acuerdos'] ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php }?>
  <?php }?>
</table>
<br>

<table width="650" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td colspan="2" class="tableindex">Entrevistas Orientador</td>
    </tr>
    <?php 
	
	$ob_reporte ->tipo  = 1;
	$rs_ent1 = $ob_reporte->reporteTipoAlu($conn);
	?><?php  if(pg_numrows($rs_ent1)==0){?>
  <tr >
    <td colspan="2" align="center" class="item">Sin informaci&oacute;n</td>
    </tr>
  <?php }else{
	  for($f1=0;$f1<pg_numrows($rs_ent1);$f1++){
		  $filla1 = pg_fetch_array($rs_ent1,$f1);
	  ?>
  <tr >
    <td width="148" class="textonegrita" style="font-size:9px">Entrevistador</td>
    <td width="492" class="textosimple" style="font-size:9px"> <?php echo $filla1['entrevistador'] ?></td>
  </tr>
 
  <tr>
    <td class="textonegrita" style="font-size:9px">Fecha</td>
    <td class="textosimple" style="font-size:9px"><?php echo CambioFD($filla1['fecha']) ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Descripci&oacute;n</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla1['descripcion'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Obervaciones</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla1['observaciones'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Acuerdos</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla1['acuerdos'] ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php }?>
  <?php }?>
</table>
<br>
<table width="650" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="tableindex">
    <td colspan="2">Entrevistas Profesor Jefe</td>
    </tr>
    <?php 
	
	$ob_reporte ->tipo  = 3;
	$rs_ent3 = $ob_reporte->reporteTipoAlu($conn);
	?><?php  if(pg_numrows($rs_ent3)==0){?>
  <tr>
    <td colspan="2" align="center" class="item">Sin informaci&oacute;n</td>
    </tr>
  <?php }else{
	  for($f3=0;$f3<pg_numrows($rs_ent3);$f3++){
		  $filla3 = pg_fetch_array($rs_ent3,$f3);
	  ?>
  <tr>
    <td width="148" class="textonegrita" style="font-size:9px">Entrevistador</td>
    <td width="492" class="textosimple" style="font-size:9px"> <?php echo $filla3['entrevistador'] ?></td>
  </tr>
 
  <tr>
    <td class="textonegrita" style="font-size:9px">Fecha</td>
    <td class="textosimple" style="font-size:9px"><?php echo CambioFD($filla3['fecha']) ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Descripci&oacute;n</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla3['descripcion'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Obervaciones</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla3['observaciones'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Acuerdos</td>
    <td  class="textosimple" style="font-size:9px"><?php echo $filla3['acuerdos'] ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php }?>
  <?php }?>
</table>
<br>

<table width="650" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="tableindex">
    <td colspan="2">Entrevistas Docente</td>
    </tr>
    <?php 
	
	$ob_reporte ->tipo  = 4;
	$rs_ent4 = $ob_reporte->reporteTipoAlu($conn);
	?><?php  if(pg_numrows($rs_ent4)==0){?>
  <tr>
    <td colspan="2" align="center" class="item">Sin informaci&oacute;n</td>
    </tr>
  <?php }else{
	  for($f4=0;$f4<pg_numrows($rs_ent4);$f4++){
		  $filla4 = pg_fetch_array($rs_ent4,$f4);
	  ?>
  <tr>
    <td width="148" class="textonegrita" style="font-size:9px">Entrevistador</td>
    <td width="492" class="textosimple" style="font-size:9px"> <?php echo $filla4['entrevistador'] ?></td>
  </tr>
 
  <tr>
    <td class="textonegrita" style="font-size:9px">Fecha</td>
    <td class="textosimple" style="font-size:9px"><?php echo CambioFD($filla4['fecha']) ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Descripci&oacute;n</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla4['descripcion'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Obervaciones</td>
    <td class="textosimple" style="font-size:9px"><?php echo $filla4['observaciones'] ?></td>
  </tr>
  <tr>
    <td class="textonegrita" style="font-size:9px">Acuerdos</td>
    <td  class="textosimple" style="font-size:9px"><?php echo $filla4['acuerdos'] ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php }?>
  <?php }?>
</table>


<br>

 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
</td></tr></table>
<br>
<br>


<? 
if  (($cantidad_alumnos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
}

?>
</form>
</body>
</html>
<? pg_close($conn);?>