<?php
require('../../../../util/header.inc');

	
	$_POSP = 4;
	$_bot = 8;	
	"<br>".$institucion	= $_INSTIT;
	"<br>".$ano			= $_ANO;
	"<br>".$curso			= $cmb_curso;
	$reporte		= $c_reporte;
	"<br>".$cmb_opcion;
	"<br>".$contador;
	"<br>".$chk0;
	"<br>".$chk1;
	"<br>".$chk2;
	"<br>".$chk3;
	"<br>".$chk4;
	


	
if($cb_ok2 =="Exportar"){
	$fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_puntajes_SIMCE_$fecha.xls"); 
	
}	
	?>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link href="../../../../cortes/12086/estilos.css" rel="stylesheet" type="text/css">
<script>
function enviapag(form){
		//form.target="_blank";
/*		form.action='print_informe_simce.php?cmb_curso=<?=$curso?>&cmb_opcion=<?=$cmb_opcion?>&chk0=<?=$chk0?>&chk1=<?=$chk1?>&chk2=<?=$chk2?>&chk3=<?=$chk3?>&chk4=<?=$chk4?>&contador=<?=$contador?>&cb_ok2=Exportar';
		form.submit(true);*/
}

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){ 
window.close() 
} 
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
</script></head>

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
<body>


<form method="post" name="form" action="print_comprobante_postulacion.php">

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div id="capa0">
      <table width="100%">
        <tr>
          <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
          <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
          </td>
          <td align="right"><input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" onClick="enviapag(this.form);"  value="EXPORTAR"></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</br>
<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0">
<tr>
<td colspan="2" class="cuadro02"><div align="center">Beca</div></td>
<td width="49%" class="cuadro02"><div align="center">Fecha de Postulaci&oacute;n </div></td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
<td width="49%">&nbsp;</td>
</tr>
<tr>
<td colspan="2">&nbsp;</td>
<td width="49%">&nbsp;</td>
</tr>
<tr>
  <td width="20%">Beca</td>
  <td width="31%"><div align="center">
    <select name="select2" id="select2" onchange="enviapag(this.form)" class="ddlb_9_x">
      <option value="0" selected="selected">Todas</option>
    </select>
  </div></td>
<td width="49%">&nbsp;</td>
</tr>
</table>
</form>
</body>
</html>
<? pg_close($conn);?>