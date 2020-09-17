<html>

<head>

<title>Untitled Document</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript">

<!--

function MM_swapImgRestore() { //v3.0

  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;

}



function MM_preloadImages() { //v3.0

  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();

    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)

    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}

}



function MM_findObj(n, d) { //v4.0

  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {

    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}

  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];

  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);

  if(!x && document.getElementById) x=document.getElementById(n); return x;

}



function MM_swapImage() { //v3.0

  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)

   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}

}

//-->

</script>

</head>



<body bgcolor="#333399" text="#333399" onLoad="MM_preloadImages('../Chile/imagenes/ingresorol.jpg','../Chile/imagenes/correo.jpg')" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="172" border="0" cellspacing="0" cellpadding="0" height="109">

  <tr> 

    <td height="3"> 

      <table width="172" border="0" cellspacing="0" cellpadding="0" background="../Chile/imagenes/fecha.jpg" height="40">

        <tr> 

          <td> 

            <div align="center"><font color="#FFFFFF" size="1"><b><font face="Verdana, Arial, Helvetica, sans-serif"> 

              <?php $now = getdate();

					switch (date("m")){

						case 01:

							$mes="Enero";

							break;

						case 02: 

							$mes="Febrero";

							break;

						case 03:

							$mes="Marzo";

							break;

						case 04:

							$mes="Abril";

							break;

						case 05:

							$mes="Mayo";

							break;

						case 06:

							$mes="Junio";

							break;

						case 07:

							$mes="Julio";

							break;

						case 08:

							$mes="Agosto";

							break;

						case 09:

							$mes="Septiembre";

							break;

						case 10:

							$mes="Octubre";

							break;

						case 11:

							$mes="Noviembre";

							break;

						case 12:

							$mes="Diciembre";

							break;

					};

					echo (date("d") . " de " . $mes . " de " . $now['year']);

			?>

              </font></b></font></div>

          </td>

        </tr>

      </table>

    </td>

  </tr>

  <tr> 

    <td height="2"><a href="http://www.colegioelectronico.cl" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image19','','../Chile/imagenes/correo.jpg',1)" target="_blank"><img name="Image19" border="0" src="../Chile/imagenes/correorol.jpg" width="172" height="51"></a></td>

  </tr>

  <tr> 

    <td height="48"> <form name="frm" action="../session/chkUser.php3" method="post" target="_parent"> 

      <table width="172" border="0" cellspacing="0" cellpadding="0" background="../Chile/imagenes/ingresofon.jpg" height="74%">

        <tr> 

          <td width="37%" height="128" rowspan="2">&nbsp;</td>

          <td width="63%" height="98">&nbsp;</td>

        </tr>

        <tr> 

          <td width="63%" height="26"> 

            <input type="text" name="txtNOMBRE" size="10" maxlength="10">

          </td>

        </tr>

        <tr> 

          <td width="37%" height="31">&nbsp;</td>

          <td width="63%" height="31"> 

            <p> 

              <input type="password" name="txtPW" size="10" maxlength="10">

            </p>

          </td>

        </tr>

      </table>

    </td>

  </tr>

  <tr> 

    <td height="2"> 

      <div align="left"> 

        <input type="image" src="../Chile/imagenes/ingreso.jpg" width="172" height="37">

      </div>

    </td>

  </tr>

  <tr> 

    <td height="2"><img src="../Chile/imagenes/registro.jpg" width="172" height="74" border="0"></td>

  </tr>

  <tr>

    <td height="2">

      <div align="right"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0" width="173" height="69">

          <param name=movie value="../Chile/logosotro.swf">

          <param name=quality value=high>

          <embed src="../Chile/logosotro.swf" quality=high pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="173" height="69">

          </embed> 

        </object></div>

    </td>

  </tr>

</table>

</form>

</body>

</html>

