<?php 	require('../../util/header.inc');
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
//-->
</script>
</head>

<body bgcolor="003b85" background="imag/fondopag.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('imag/salir2.gif','imag/alumnos2.gif','imag/subsectores2.gif','imag/horario2.gif','imag/asistencia2.gif')">
<table width="161" height="150" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="161" height="30"><a href="../../admin/institucion/ano/curso/alumno/listarAlumnos.php3" target="mainFrame"><img src="imag/alumnos.gif" name="Image8" width="161" height="18" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','imag/alumnos2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
  <tr> 
    <td width="161" height="30"><a href="../../admin/institucion/ano/curso/ramo/listarRamos.php3" target="mainFrame"><img src="imag/subsectores.gif" name="Image9" width="161" height="21" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','imag/subsectores2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
  <tr> 
    <td width="161" height="30"><a href="../../admin/institucion/ano/curso/horario/listarHorario.php" target="mainFrame"><img src="imag/horario.gif" name="Image10" width="161" height="25" border="0" id="Image10" onMouseOver="MM_swapImage('Image10','','imag/horario2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>


  <?php  $sqlFer="select * from feriado where id_ano=".$ano;
		$resultFer=@pg_Exec($conn,$sqlFer);
		if((@pg_numrows($resultFer)!=0)and ($frmModo=="mostrar")){	?>
			  <tr> 
				<td width="161" height="30"><a href="../../admin/institucion/ano/curso/asistencia/asistencia.php3" target="mainFrame"><img src="imag/asistencia.gif" name="Image11" width="161" height="24" border="0" id="Image11" onMouseOver="MM_swapImage('Image11','','imag/asistencia2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
			  </tr>

  <?php } ?>

  <tr> 
    <td width="161" height="30"><a href="../../admin/institucion/soporte/seteaSoporte.php3?caso=2" target="mainFrame" onMouseOver="MM_swapImage('Image13','','imag/soporte2.jpg',1)" onMouseOut="MM_swapImgRestore()"><img src="imag/soporte.jpg" name="Image13" width="161" height="25" border="0"></a></td>
  </tr>  
  <tr> 
    <td width="161" height="30"><a href="../docente/infoprofe.php" target="mainFrame"><img src="imag/info.gif" name="Image12" width="161" height="25" border="0" id="Image12" onMouseOver="MM_swapImage('Image12','','imag/info2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>  
  <tr>
    <td width="161" height="30"><a href="../diario/ListadoNoticias.php" target="mainFrame"><img src="imag/diario_mural.jpg" name="Image15" width="161" height="23" border="0" id="Image15" onMouseOver="MM_swapImage('Image15','','imag/diario_mural2.jpg',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
     <tr> 
    <td width="161" height="30"><a href="../../admin/institucion/empleado/usuario/claveAcceso.php3" target="mainFrame"><img src="imag/clave.gif" name="Image12" width="161" height="25" border="0" id="Image12" onMouseOver="MM_swapImage('Image12','','imag/clave2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>  
  <tr> 
    <td width="161" height="30"><a href="../../menu/salida.php" target="_parent"><img src="imag/salir.gif" name="Image15" width="161" height="23" border="0" id="Image15" onMouseOver="MM_swapImage('Image15','','imag/salir2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
  </tr>
  
</table>
</body>
</html>
