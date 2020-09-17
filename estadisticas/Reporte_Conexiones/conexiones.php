<?php  require('../../util/header.inc');


	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$_POSP = 4;
	$_bot = 8;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="682" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td width="682" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="350" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  <form action="printReporteConexiones2.php" method="post" target="_blank">
								<center>
                                        <table width="100%" border="1" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="550">
                                            <table width="550" height="43" border="0" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td width="500" class="tableindex" align="center">Buscador</td>
                                          </tr>
                                          <tr>
                                            <td height="27"><table width="100%" border="0" align="center">
                                              <tr>
                                                <td width="22%" class="textonegrita">INSTITUCION</td>
                                                <td width="4%" align="center" class="textonegrita">:</td>
                                                <td width="74%">
                                                <? 	$sql="SELECT rdb, nombre_instit FROM institucion WHERE estado_colegio=1 ORDER BY nombre_instit ASC";
                                                    $rs_rdb = pg_exec($connection,$sql);
                                                ?>
                                                <select name="cmbINSTITUCION" id="cmbINSTITUCION" onChange="AnoEscolar()">
                                                    <option value="0">seleccione...</option>
                                                <? for($i=0;$i<pg_numrows($rs_rdb);$i++){
                                                        $fila=pg_fetch_array($rs_rdb,$i);?>
                                                     <option value="<?=$fila['rdb'];?>"><?=$fila['nombre_instit'];?></option>
                                                 <? } ?>	
                                                 </select>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td class="textonegrita">A&Ntilde;O</td>
                                                <td align="center" class="textonegrita">:</td>
                                                <td>
                                                    <select name="cmbANO" id="cmbANO">
                                                        <option value="0">seleccione...</option>
                                                        <option value="2015">2015</option>
                                                        <option value="2014">2014</option>
                                                        <option value="2013">2013</option>
                                                    </select>
                                                </td>
                                              </tr>
                                              <tr>
                                                <td class="textonegrita">&nbsp;</td>
                                                <td align="center" class="textonegrita">&nbsp;</td>
                                                <td align="right"><input type="submit" name="BUSCAR" id="BUSCAR" value="BUSCAR" class="botonXX"></td>
                                              </tr>
                                            </table></td>
                                          </tr>
                                        </table>
                                        
                                            </td>
                                          </tr>
                                        </table>
                                        </center>
										</form>

<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>