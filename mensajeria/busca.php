<? 
require('../util/header.inc');

$institucion	=$_INSTIT;
$usuarioensesion = $_USUARIOENSESION;

$perfil_user = $_PERFIL;
$idusuario = $_USUARIO;

 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

<script language="JavaScript"> 
function ventanaSecundaria (URL){ 
window.open(URL,"ventana1","width=500, height=350, scrollbars=yes, menubar=no, location=no, resizable=yes") 
} 
</script> 
<script language="JavaScript" type="text/javascript">
<!--
function showSelected()



{
var Obj = document.formulario('selSeaShells');
var len = Obj.length
alert(len);

var i,texto;
texto=""
for (i=0; i<len; i++) {
if (Obj[i].selected) {
texto=texto + ";" + Obj[i].value
}
}

document.formulario('txtIndex').value=texto


}

//-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg','../cortes/b_home_r.jpg')">
<table width="100%" height="680" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="680" align="left" valign="top">
	<table width="100%" height="754" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="677" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="480" colspan="3"><table width="100%" height="1%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="467" align="left" valign="top"> 
                        <? include("../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="389">
								  
						            <div align="center">
						              <!------------------------------------------inicio codigo mensajeria -------------------->
								           
 
					               
				                        <form name="form1" method="POST" action="envio.php?llave=3">
				                          <table width="313">
                                            <tr>
                                              <td colspan="2" class="cuadro02"><strong>Buscar usuario por Apellido </strong></td>
                                            </tr>
                                            <tr>
                                              <td width="25"><input name="opcion" type="radio" value="1"></td>
                                              <td width="272" class="cuadro01">Alumno</td>
                                            </tr>
                                            <tr>
                                              <td><input name="opcion" type="radio" value="2"></td>
                                              <td class="cuadro01">Empleado</td>
                                            </tr>
                                            <tr>
                                              <td colspan="2">&nbsp;</td>
                                            </tr>
                                            <tr>
                                              <td colspan="2"><table width="320" border="1">
                                                <tr>
                                                  <td colspan="2"><!--<input type="text" name="nomb_usuario">--></td>
                                                </tr>
                                                <tr>
                                                  <td width="155" class="cuadro01">Ingrese apellido usuario</td>
                                                  <td width="149"><input type="text" name="Apellido"></td>
                                                </tr>
                                              </table></td>
										    </tr>
                                            <tr>
                                              <td colspan="2"><div align="center">
                                                <input type="submit" name="Submit" value="Busqueda por Apellido" class="botonXX">
                                              </div></td>
                                            </tr>
                                          </table>
                                      </form>

			                          </div></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="12" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
