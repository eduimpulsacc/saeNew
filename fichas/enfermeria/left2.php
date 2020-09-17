<?php require('../../util/header.inc');?>

<?php 

	$institucion	=$_INSTIT;

	$ano			=$_ANO;

	$alumno			=$_ALUMNO;

	$curso			=$_CURSO;

	$frmModo		="mostrar";

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



<body bgcolor="003b85" background="imag/fondopag.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('imag/ficha2.gif','imag/fmed2.gif','imag/fdeport2.gif','imag/docente2.gif','imag/notic2.gif','imag/calend2.gif','imag/mat2.gif','imag/fapod2.gif','imag/coleg2.gif','imag/trans2.gif','imag/salir2.gif','imag/biblioteca2.gif','imag/horario2.gif','imag/lista2.gif','imag/personal2.gif','imag/informes2.jpg','imag/listado_alumnos2.jpg','imag/listado_cursos2.jpg','imag/aacademico2.gif')">
<table width="161" border="0" cellpadding="0" cellspacing="0">
  <tr> 

    <td width="161" height="34" valign="top"><font color="yellow" size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>

  </tr>

  <tr> 

    <td width="161" height="28" valign="top"><a href="../../admin/institucion/ano/listarAno.php3" target="mainFrame"><img src="imag/aacademico.gif" name="Image2" width="161" height="27" border="0" id="Image2" onMouseOver="MM_swapImage('Image2','','imag/aacademico2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

  </tr>

 

   <tr>

  	<td valign="top" height="28"><a href="../../admin/institucion/ano/curso/listarCursos.php3" target="mainFrame" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','imag/listado_cursos2.jpg',1)"><img src="imag/listado_cursos.jpg" name="Image6" width="161" height="27" border="0"></a></td>

  </tr>

  

  <tr>

  	<td width="161" height="25"><a href="../../admin/institucion/ano/matricula/listarMatricula.php3" target="mainFrame" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','imag/listado_alumnos2.jpg',1)"><img src="imag/listado_alumnos.jpg" name="Image5" width="161" height="27" border="0"></a></td>

  </tr>

  <tr>

    <td width="161" height="23"><a href="../../menu/salida.php" target="_parent"><img src="imag/salir.gif" name="Image15" width="161" height="23" border="0" id="Image15" onMouseOver="MM_swapImage('Image15','','imag/salir2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

  </tr>



</table>

</body>

</html>

