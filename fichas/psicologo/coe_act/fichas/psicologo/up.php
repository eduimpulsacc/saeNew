<?php require('../../util/header.inc');?>

<?php 

	$institucion	=$_INSTIT;

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



<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('imag/inicio2.gif','imag/n_inst2.gif','imag/regl2.gif','imag/carta2.gif','imag/proceso2.gif','imag/proyecto2.gif')">

<table width="780" height="118" border="0" cellpadding="0" cellspacing="0">

  <tr> 

   <?php						

						$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);

						$arr=@pg_fetch_array($result,0);



						$output= "select lo_export(".$arr[insignia].",'/var/www/html/tmp/".$arr[rdb]."');";

						$retrieve_result = @pg_exec($conn,$output);

					?>

    <td width="161" height="75"><div align="center"><img src=../../../../tmp/<?php echo $arr[rdb] ?> ALT="NO DISPONIBLE"width="60"></div></td>

    <td width="619" height="75"><table width="739" height="75" border="0" cellpadding="0" cellspacing="0">

        <tr> 

          <td width="739" height="48" align="right" valign="top"> <blockquote> 

              <blockquote> 

                <blockquote>

                  <p><font color="#999999" size="1" face="Geneva, Arial, Helvetica, sans-serif">Resoluci&oacute;n 

                    &oacute;ptima 1024 x 768 p&iacute;xeles</font></p>

                </blockquote>

              </blockquote>

            </blockquote></td>

        </tr>

            <tr> 

          <td width="619" height="27"><table width="559" height="27" border="0" cellpadding="0" cellspacing="0">

              <tr> 

                <td width="21" height="27">&nbsp;</td>

                <td width="45" height="27"><a href="index.php" target="_parent"><img src="imag/inicio.gif" name="Image1" width="45" height="27" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','imag/inicio2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

                <td width="74" height="27"><a href="../../admin/institucion/atributos/nuestraInstitucion.php3?botonera=1" target="mainFrame"><img src="imag/n_inst.gif" name="Image2" width="74" height="27" border="0" id="Image2" onMouseOver="MM_swapImage('Image2','','imag/n_inst2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

                <td width="84" height="27"><a href="../../admin/institucion/atributos/reglamentoInterno.php3?botonera=1" target="mainFrame"><img src="imag/regl.gif" name="Image3" width="84" height="27" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','imag/regl2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

                <td width="73" height="27"><a href="../../admin/institucion/atributos/cartaDireccion.php3?botonera=1" target="mainFrame"><img src="imag/carta.gif" name="Image4" width="73" height="27" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','imag/carta2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

                <td width="71" height="27"><a href="../../admin/institucion/atributos/procesoAdmision.php3?botonera=1" target="mainFrame"><img src="imag/proceso.gif" name="Image5" width="71" height="27" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','imag/proceso2.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

              </tr>

            </table></td>

        </tr>

      </table></td>

  </tr>

  <tr> 

    <td width="161" height="43"><img src="imag/fondobandera.gif" width="161" height="43"></td>

    <td width="619" height="43"><img src="imag/intrpsicologo.jpg" width="739" height="43"></td>

  </tr>

</table>

</body>

</html>

