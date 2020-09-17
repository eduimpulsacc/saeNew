<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$reporte		=$c_reporte;
	$curso=1;	
	$_POSP = 4;
	$_bot = 8;
	
	
	

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

	//-------------- INSTITUCION -------------------------------------------------------------
	$ob_institucion = new Membrete();
	$ob_institucion -> ano =$ano;
	$ob_institucion -> institucion =$institucion;
	$ob_institucion -> institucion($conn);
	
	$ob_curso = new MotorBusqueda();
	$ob_curso -> ano = $ano;
	$rs_curso = $ob_curso ->curso($conn);
	//--------------- Curso ------------------//
	$Curso_pal = CursoPalabra($curso, 0, $conn);

	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$subsector = split(",",$cmbSUBSECTOR);
	
  
  ////// FIN RESUMEN CURSO /////////  
	if($cb_ok!="Buscar"){
	$xls=1;
	}
		 
	if($xls==1){	 
	$fecha_actual = date('d/m/Y-H:i:s');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=InformeAnotaciones$fecha_actual.xls"); 	 
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">


           <!-- INSERTO CUERPO DE LA PÁGINA -->
		   

<div id="capa0">
<table width="650" border="0" align="center">
             <tr>
               <td><input type="submit" name="button2" id="button2" value="CERRAR" class="botonXX" onClick="cerrar();"></td>
               <td align="right"><input type="submit" name="button" id="button" value="IMPRIMIR" class="botonXX" onClick="imprimir()"></td>
             </tr>
</table>
</div>
<p><br>
</p>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong>
      <?=$ob_institucion->ins_pal;?>
    </strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center" valign="top"><? echo "<img src='".$d."tmp/".$institucion."insignia". "' >";	?></td>
  </tr>
  <tr>
    <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">
      <?=$ob_institucion->direccion;?>
    </font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">Fono:
      <?=$ob_institucion->telefono;?>
    </font></td>
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
    <td class=""><div align="center"><strong>REPORTE PROMEDIOS SUBSECTORES POR A&Ntilde;O</strong></div></td>
  </tr>
  <tr>  
</table>
<br>
<br>

<? 	$ob_reporte = new Reporte();
	$ob_reporte ->rdb = $institucion;
	$rs_rdb = $ob_reporte->AnoInstitucion($conn);
	



?>
<table width="650" border="0" align="center">
  <tr>
    <td width="115" class="titulo">&nbsp;ASIGNATURA :</td>
    <td width="525" align="left" class="item">&nbsp;<?=$subsector[1];?></td>
  </tr>
</table>

<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr class="titulo" bgcolor="#CCCCCC">
    <td rowspan="2">CURSO</td>
    <td colspan="<?=pg_numrows($rs_rdb);?>" align="center">A&Ntilde;OS</td>
  </tr>
  <tr class="titulo" bgcolor="#CCCCCC">
  <? for($j=0;$j<pg_numrows($rs_rdb);$j++){
			$fila_ano = pg_fetch_array($rs_rdb,$j);
	?>
    <td>&nbsp;<?=$fila_ano['nro_ano'];?></td>
     <? } ?>
  </tr>
  <? for($i=0;$i<pg_numrows($rs_curso);$i++){
	  	$fila = pg_fetch_array($rs_curso,$i);
		
		if($fila['ensenanza']>10){
		
	?> 
  <tr>
    <td class="item">&nbsp;<?=$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'];?></td>
     <? for($j=0;$j<pg_numrows($rs_rdb);$j++){
			$fila_ano = pg_fetch_array($rs_rdb,$j);
			
			$ob_reporte->ensenanza = $fila['ensenanza'];
			$ob_reporte->ano = $fila_ano['id_ano'];
			$ob_reporte->grado_curso = $fila['grado_curso'];
			$ob_reporte->letra_curso = $fila['letra_curso'];
			$ob_reporte->subsector = $subsector[0] ;
			$rs_promedio = $ob_reporte->PromedioSubsectorAno($conn);
			$promedio = round(pg_result($rs_promedio,0));
/*			$sql="SELECT avg(cast(promedio as INTEGER)) FROM promedio_sub_alumno psa INNER JOIN ramo r ON psa.id_ramo=r.id_ramo
INNER JOIN curso c ON c.id_curso=r.id_curso AND psa.id_curso=c.id_curso AND c.id_ano=".$fila_ano['id_ano']." WHERE cod_subsector=".$subsector[0]." and ensenanza=".$fila['ensenanza']." AND grado_curso=".$fila['grado_curso']." AND letra_curso='".$fila['letra_curso']."'";
	*/		

	?>
    <td class="item" align="center">&nbsp;<?=$promedio;?></td>
  <? } ?>
  </tr>
  <? 	}
  } ?>
</table>
<br>
<br>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 $concur=0;
		 include("firmas/firmas.php");?>
<p>&nbsp;</p>
</body>
</html>
<? pg_close($conn);?>