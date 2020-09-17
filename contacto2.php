<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<?php
	$msg=" Nombre :".$nombre."\n";
	$msg.=" Apellido :".$apellido."\n";
	$msg.=" Ciudad :".$ciudad."\n";
	$msg.=" Teléfono :".$telefono."\n";
	$msg.=" e mail :".$mail."\n";
	$msg.=" Consulta :".$consulta."\n";
?>
<?php
	$recipient	= "info@colegiointeractivo.com";
	$subject	= "Contacto desde sitio Colegio Interactivo.";
	mail($recipient,$subject,$msg,$de);
?>
<title>Colegio Interactivo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
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
<link href="stilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:hover {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight: bold;
	color: #999999;
	text-decoration: none;
}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('cortes/i_flash1.gif','cortes/i_adobe1.gif','cortes/i_firefox1.gif','cortes/i_quicktime1.gif','cortes/m_empresa_r.gif','cortes/m_servicios_r.gif','cortes/m_alianzas_r.gif','cortes/m_noticias_r.gif','cortes/m_revista_r.gif','cortes/m_destacados_r.jpg','cortes/m_seminarios_r.jpg')">
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="778" height="537" align="center" valign="top"> 
      <table width="757" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="757" height="19" align="left" valign="top"><table width="757" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="180" align="left" valign="top"><img src="cortes/logo_ok.gif" width="180" height="77"></td>
                <td align="left" valign="bottom">
<table width="100%" height="41" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="10%"><img src="cortes/m_01.gif" width="60" height="13"></td>
                    <td width="10%"><img src="cortes/m_02.gif" width="60" height="13"></td>
                    <td width="10%"><img src="cortes/m_03.gif" width="60" height="13"></td>
                    <td width="10%"><img src="cortes/m_04.gif" width="60" height="13"></td>
                    <td width="5%"><img src="cortes/m_05.gif" width="60" height="13"></td>
                    <td width="55%"><img src="cortes/top_01.gif" width="277" height="13"></td>
                  </tr>
                  <tr align="left" valign="top">
                    <td height="20"><a href="empresa.htm" target="_parent" onMouseOver="MM_swapImage('Image6','','cortes/m_empresa_r.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="cortes/m_empresa_n.gif" name="Image6" width="60" height="20" border="0"></a></td>
                    <td height="20"><a href="servicios.htm" target="_parent" onMouseOver="MM_swapImage('Image9','','cortes/m_servicios_r.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="cortes/m_servicios_n.gif" name="Image9" width="60" height="20" border="0"></a></td>
                    <td height="20"><a href="alianzas.htm" target="_parent" onMouseOver="MM_swapImage('Image11','','cortes/m_alianzas_r.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="cortes/m_alianzas_n.gif" name="Image11" width="60" height="20" border="0"></a></td>
                    <td height="20"><a href="noticias.htm" target="_parent" onMouseOver="MM_swapImage('Image13','','cortes/m_noticias_r.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="cortes/m_noticias_n.gif" name="Image13" width="60" height="20" border="0"></a></td>
                    <td height="20"><a href="revista.htm" target="_parent" onMouseOver="MM_swapImage('Image15','','cortes/m_revista_r.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="cortes/m_revista_n.gif" name="Image15" width="60" height="20" border="0"></a></td>
                      <td><img src="cortes/menu_top.gif" width="277" height="20" border="0" usemap="#Map3Map"></td>
                  </tr>
                  <tr align="left" valign="top">
                    <td height="8"><img src="cortes/1.gif" width="60" height="8"></td>
                    <td><img src="cortes/2.gif" width="60" height="8"></td>
                    <td><img src="cortes/3.gif" width="60" height="8"></td>
                    <td><img src="cortes/4.gif" width="60" height="8"></td>
                    <td><img src="cortes/5.gif" width="60" height="8"></td>
                    <td><img src="cortes/botom_01.gif" width="277" height="8"></td>
                  </tr>
                </table>                </td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td align="left" valign="top"><table width="100%" height="130" border="0" cellpadding="0" cellspacing="0">
              <tr> 
                <td width="660" height="130" align="left" valign="top"><img src="cortes/top_mapa.jpg" width="635" height="123"></td>
                <td width="97" align="left" valign="top"><table width="100%" height="50" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td><img src="cortes/caja_ingreso.jpg" width="110" height="23"></td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
                              <tr>
                                <td align="left" valign="top" bgcolor="ffffff"><form name="frm" action="session/chkUser.php3" method="post" target="_self" onSubmit="return anulas();">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="9%">&nbsp;</td>
                                        <td width="91%"><font color="#666666" size="1" face="Arial, Helvetica, sans-serif">Usuario</font></td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td><input name="txtNOMBRE" type="text" id="txtNOMBRE7" size="11"></td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td><font color="#666666" size="1" face="Arial, Helvetica, sans-serif">Clave</font></td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td><input name="txtPW" type="password" id="txtPW" size="11"></td>
                                      </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td height="12"><input name="image" type="image" src="cortes/b_entrar.gif" width="94" height="12" border="0"></td>
                                      </tr>
                                    </table>
                                </form></td>
                              </tr>
                            </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td height="327" align="center" valign="top"> <table width="757" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="164" height="8"></td>
                <td width="18"></td>
                <td width="216"></td>
                <td width="19"></td>
                <td width="215"></td>
                <td width="15"></td>
                <td width="110"></td>
              </tr>
              <tr> 
                <td height="366" align="left" valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td align="left" valign="top"><img src="cortes/caja_noticias.jpg" width="164" height="23"></td>
                    </tr>
                    <tr> 
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td height="130" align="left" valign="top"> 
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td><a href="destacados.htm" target="_parent" onMouseOver="MM_swapImage('Image42','','cortes/m_destacados_r.jpg',1)" onMouseOut="MM_swapImgRestore()"><img src="cortes/m_destacados_n.jpg" name="Image42" width="164" height="23" border="0"></a></td>
                                      </tr>
                                      <tr>
                                        <td align="left" valign="top"><a href="seminarios.htm" target="_parent" onMouseOver="MM_swapImage('Image43','','cortes/m_seminarios_r.jpg',1)" onMouseOut="MM_swapImgRestore()"><img src="cortes/m_seminarios_n.jpg" name="Image43" width="164" height="24" border="0"></a></td>
                                      </tr>
                                      <tr>
                                        <td><img src="cortes/m_pelado.jpg" width="164" height="25"></td>
                                      </tr>
                                      <tr>
                                        <td height="39" align="left" valign="top"><img src="cortes/m_final.jpg" width="164" height="38"></td>
                                      </tr>
                                    </table></td>
                                </tr>
                                <tr> 
                                  <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr> 
                                        <td align="left" valign="top"><img src="cortes/caja_descarga.jpg" width="164" height="26"></td>
                                      </tr>
                                      <tr> 
                                        <td height="19" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr> 
                                              <td align="left" valign="top"><img src="cortes/desc_01.gif" width="164" height="5"></td>
                                            </tr>
                                            <tr> 
                                              <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr align="left" valign="top"> 
                                                    <td width="5%"><img src="cortes/desc_02.gif" width="8" height="34"></td>
                                                    <td width="23%"><a href="http://www.macromedia.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash&P2_Platform=Win32&P3_Browser_Version=MSIE&P5_Language=Spanish&Lang=Spanish" target="_blank" onMouseOver="MM_swapImage('Image63','','cortes/i_flash1.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="cortes/i_flash.gif" name="Image63" width="38" height="34" border="0"></a></td>
                                                    <td width="21%"><a href="http://www.adobe.es/products/acrobat/readstep2.html" target="_blank" onMouseOver="MM_swapImage('Image64','','cortes/i_adobe1.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="cortes/i_adobe.gif" name="Image64" width="34" height="34" border="0"></a></td>
                                                    <td width="18%"><a href="http://www.mozilla-europe.org/es/products/firefox/" target="_blank" onMouseOver="MM_swapImage('Image65','','cortes/i_firefox1.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="cortes/i_firefox.gif" name="Image65" width="36" height="34" border="0"></a></td>
                                                    <td width="23%"><a href="http://www.apple.com/es/quicktime/download/win.html" target="_blank" onMouseOver="MM_swapImage('Image66','','cortes/i_quicktime1.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="cortes/i_quicktime.gif" name="Image66" width="39" height="34" border="0"></a></td>
                                                    <td width="10%"><img src="cortes/desc_03.gif" width="9" height="34"></td>
                                                  </tr>
                                              </table></td>
                                            </tr>
                                            <tr> 
                                              
                                            </tr>
                                            <tr> 
                                              <td align="left" valign="top"></td>
                                            </tr>
                                            <tr> 
                                              <td align="left" valign="top"></td>
                                            </tr>
                                          </table></td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
                <td align="left" valign="top">&nbsp;</td>
                <td colspan="3" align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td><img src="cortes/f_contacto.gif" width="446" height="24"></td>
                    </tr>
                    <tr> 
                      <td height="19" align="right"> <p align="center" class="texto">&nbsp;</p>
                        <p align="center" class="texto"><font color="#000033">Gracias 
                          por contactarse con nosotros. A la brevedad nos comunicaremos 
                          con usted.</font></p>
                        <p align="center"><span class="texto"><font color="#000033">Atentamente, 
                          Colegio Interactivo.</font></span></p>
                        <p align="center"><span class="texto"><br>
                          </span> </p>
                        </td>
                    </tr>
                    <tr> 
                      <td align="left" valign="top" class="justy"> 
                        <p class="texto">&nbsp;</p>                      </td>
                    </tr>
                    <tr> 
                      <td height="57" align="center" valign="middle" class="justy"> 
                        <div align="center"> 
                          <table width="50%" border="0" cellspacing="0" cellpadding="0">
                            <tr align="center" valign="middle">
                              <td><img src="cortes/i_bajada.gif" width="131" height="15" border="0" usemap="#Map" href="#"></td>
                              <td>&nbsp;</td>
                            </tr>
                          </table>
                          <map name="Map">
                            <area shape="rect" coords="1,2,51,14" href="javascript:history.back();" target="_parent">
                            <area shape="rect" coords="71,3,130,18" href="javascript:window.print();">
                          </map>
                        </div></td>
                    </tr>
                  </table></td>
                <td>&nbsp;</td>
                <td align="left" valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td align="left" valign="top"><img src="cortes/caja_seminarios.jpg" width="110" height="23"></td>
                    </tr>
                    <tr> 
                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#cccccc">
                                <tr> 
                                  <td align="left" valign="top" bgcolor="ffffff"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr> 
                                        <td width="9%" height="45" align="center" valign="middle">&nbsp;</td>
                                        <td width="91%" height="60" valign="bottom" class="texto"> 
                                          <div align="left"><img src="cortes/video.gif" width="40" height="22"><br>
                                            &quot;Liderando los Cambios&quot;</div></td>
                                      </tr>
                                      <tr> 
                                        <td height="40" align="center" valign="middle">&nbsp;</td>
                                        <td class="texto"><div align="left">1.<a href="http://www.chileteve.cl/colegiointeractivo.html" target="_blank"> 
                                            Vi&ntilde;a del Mar</a></div></td>
                                      </tr>
                                      <tr> 
                                        <td height="40" align="center" valign="middle">&nbsp;</td>
                                        <td class="texto"><div align="left">2.<font size="2"> 
                                            </font><a href="http://www.chileteve.cl/colegiointeractivo2.html" target="_blank">Rancagua</a></div></td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
            <font color="#999999" size="1" face="Arial, Helvetica, sans-serif">Copyright 
            2005 &copy; Colegio Interactivo - Todos los derechos reservados</font></td>
        </tr>
      </table></td>
  </tr>
</table>

<map name="Map2">
  <area shape="rect" coords="26,3,81,21" href="#">
  <area shape="rect" coords="93,5,149,19" href="#">
  <area shape="rect" coords="159,4,204,20" href="#">
  <area shape="rect" coords="212,4,273,21" href="#">
</map>
<map name="Map2Map">
  <area shape="rect" coords="34,2,82,18" href="#">
  <area shape="rect" coords="88,2,147,17" href="#">
  <area shape="rect" coords="156,2,206,17" href="#">
  <area shape="rect" coords="212,0,270,17" href="#">
</map>
<map name="Map3">
  <area shape="rect" coords="36,3,82,19" href="index.html" target="_parent">
  <area shape="rect" coords="89,5,148,21" href="contacto.htm" target="_parent">
  <area shape="rect" coords="156,4,206,22" href="mapa.htm" target="_parent">
  <area shape="rect" coords="212,4,271,21" href="http://www.colegiointeractivo.com/sae3.0/Bienvenidos_a_Web_Mail.htm" target="_blank">
</map>
<map name="Map3Map">
  <area shape="rect" coords="33,3,80,20" href="index.html" target="_parent">
  <area shape="rect" coords="86,3,148,21" href="contacto.htm" target="_parent">
  <area shape="rect" coords="153,4,206,19" href="mapa.htm" target="_parent">
  <area shape="rect" coords="212,3,272,24" href="http://www.colegiointeractivo.com/sae3.0/Bienvenidos_a_Web_Mail.htm" target="_blank">
</map>
</body>
</html>
