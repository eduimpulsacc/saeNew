<? echo $_URLBASE; 
	session_start();	

	if(!($_CHK_ID==session_id())){//CHEQUEA QUE EL NRO DE LA SESSION ASIGNADO AL LOGONEARSE CORRESPONDE AL ID ACTUAL DE LA SESSION

		echo "ERROR DE ACCESO, SESSION INVALIDA.";

		session_unset();

		session_destroy();

		exit;

	};



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



<body bgcolor="003b85" background="imag/fondopag.gif" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('imag/aacademico2.gif','imag/sweb2.gif','imag/personal2.gif','imag/colegiatura2.gif','imag/salir2.gif','imag/datosinst2.gif','imag/soporte2.jpg')">
<table width="161" border="0" cellpadding="0" cellspacing="0">

  <?php if(($_PERFIL!=3)and ($_PERFIL!=5)){ ?>  

  <tr> 

    <td width="161" height="28" valign="bottom"><a href="<?php echo trim($_URLBASE)?>" target="content"><img src="imag/datosinst.gif" name="Image8" width="161" height="25" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','imag/datosinst2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

  </tr>

  <?php }?>

 <?php if($_PERFIL!=0){ ?> 

  <?php if(($_PERFIL!=3)and ($_PERFIL!=5)){ ?>  

  <tr> 

    <td width="161" height="28" valign="bottom"><a href="../admin/institucion/ano/listarAno.php3" target="content"><img src="imag/aacademico.gif" name="Image4" width="161" height="25" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','imag/aacademico2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

  </tr>

   <?php    }?>

     <?php if(($_PERFIL!=3)and ($_PERFIL!=5)){ ?>  

  <tr> 

    <td width="161" height="28" valign="bottom"><a href="../admin/institucion/empleado/listarEmpleado.php3" target="content"><img src="imag/personal.gif" name="Image6" width="161" height="25" border="0" id="Image6" onMouseOver="MM_swapImage('Image6','','imag/personal2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

  </tr>

    <?php }?>

	<?php if (($_INSTIT==10237)|| ($_INSTIT==25478)||($_INSTIT==24977)||($_PERFIL==0)){ ?>

  <tr> 

    <td width="161" height="28" valign="bottom"><a href="../admin/institucion/Colegio_restore/main.php" target="content"><img src="imag/colegiatura.gif" name="Image7" width="161" height="25" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','imag/colegiatura2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

  </tr>

  <?php } ?>

  <?php }?>

    <tr> 

    <td width="161" height="28" valign="bottom"> 
      <div align="center"><font color="#FFFFFF" size="2" face="arial, geneva, helvetica"> 
        <? if($_PERFIL==0){?>
        <a href="../admin/institucion/soporte/main_soporte.php3" target="content" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image9','','imag/soporte2.jpg',1)"><img src="imag/soporte.jpg" name="Image9" width="161" height="25" border="0"></a></font></div></td>

    <? }else{?>

 		<a href="../admin/institucion/soporte/Man_Soporte.php" target="content" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image10','','imag/soporte2.jpg',1)"><img src="imag/soporte.jpg" name="Image10" width="161" height="23" border="0"></a></td>

    <? } ?>

  </tr>

  <tr>

    <td width="161" height="28" valign="bottom"><a href="../util/logout.php3" target="_parent"><img src="imag/salir.gif" name="Image15" width="161" height="23" border="0" id="Image15" onMouseOver="MM_swapImage('Image15','','imag/salir2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

  </tr>

</table>

</body>

</html>

