<?php require('../../../../util/header.inc');
setlocale(LC_ALL,"es_ES");
	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$mes 			= $cmb_meses;	
	$reporte		=$c_reporte;
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
//-->
</script>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: #FF0000;
}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"><?
				include("../../../../cabecera/menu_superior.php");
				?>                </td>
              </tr>
          </table></td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><?
				$menu_lateral=3;
				include("../../../../menus/menu_lateral.php");
			  ?>              </td>
              <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="395" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                        <tr>
                          <td><br>
                              <!-- FIN CODIGO DE BOTONES -->
                              <!-- INICIO CUERPO DE LA PAGINA -->
                              <center>
                                <table width="819" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="839"><br>
                                      <br></td>
                                  </tr>
                                </table>
                                <!-- FIN CUERPO DE LA PAGINA -->
                                <!-- INICIO FORMULARIO DE BUSQUEDA -->
                                <form action="printInformeSubvencion_C.php" method="post" name="form" target="_blank">
								<input type="hidden" name="c_reporte" value="<?=$reporte;?>">
                                <input name="nombre" type="hidden" value="<?=$nombre;?>">
                                <input name="numero" type="hidden" value="<?=$numero;?>">
                                  <center>
                                    <table width="" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width=""><table width="662" height="43" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                              <td width="658" class="tableindex"><div align="center"><? echo $numero.".- Buscador ".$nombre;?></div></td>
                                            </tr>
                                            <tr>
                                              <td height="27"><table width="658" border="0" cellspacing="0" cellpadding="3">
                                                  <tr>
                                                    <td width="105"><font face="Verdana, Arial, Helvetica, sans-serif" size="-2"><strong>Seleccione Mes</strong></font></td>
                                                    <td width="420">
													<select name="cmb_meses" class="ddlb_9_x">
														<option value="1">Enero</option>
														<option value="2">Febrero</option>
														<option value="3">Marzo</option>
														<option value="4">Abril</option>
														<option value="5">Mayo</option>
														<option value="6">Junio</option>
														<option value="7">Julio</option>
														<option value="8">Agosto</option>
														<option value="9">Septiembre</option>
														<option value="10">Octubre</option>
														<option value="11">Noviembre</option>
														<option value="12">Diciembre</option>
                                                    </select></td>
                                                    <td width="33">&nbsp;</td>
                                                    <td width="33">&nbsp;</td>
                                                    <td width="37">&nbsp;</td>
                                                  </tr>
                                                  <tr>
                                                    <td>&nbsp;</td>
                                                    <td><input name="cb_ok" type="submit" class="botonXX"  value="Consultar">
                                                    <? if($_PERFIL == 0){?>
													  <input name="cb_ex" type="submit" class="botonXX"  value="Exportar">
                                                     <? }?>
													  <input name="cb_ok2" type="button" class="botonXX"  value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
													  <br>
                                                      <br>
                                                      <span class="Estilo1">* Para Proyectar Correctamente la Subvenci&oacute;n debe tener ingresada la asistencia en el sistema, en su totalidad. </span></td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                  </tr>
                                              </table></td>
                                            </tr>
                                        </table></td>
                                      </tr>
                                    </table>
                                  </center>
                                </form>
                                <!-- FIN FORMULARIO DE BUSQUEDA -->
                            </center></td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr align="center" valign="middle">
              <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
   </tr>
      </table>
 </td>
  </tr>
</table>
</body>
</html>
