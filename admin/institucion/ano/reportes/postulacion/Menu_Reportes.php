<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$_POSP = 5;
	$_bot = 8;

	
	if (trim($_url)=="") $_url=0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>

<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--


function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
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

function enviapag(form){
	if (form.cmb_insti.value!=0){
		form.cmb_insti.target="self";
		form.target="_parent";
		form.action = 'Rprt1.php';
		form.submit(true);
	}	
}
//-->
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../../cabecera/menu_superior.php");
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
						include("../../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><form name="form" method="post" action="guardar_postulacion.php">
                          <p>&nbsp;</p>
                          <table width="798" height="138" border="0" cellspacing="0" cellpadding="0">
                            <tr class="tableindex">
                              
                              <td width="739">Instituci&oacute;n   <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
                              <?php if(($_PERFIL!=17) &&  ($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
                              <?
include("../../../../cabecera/menu_inferior.php");
?>
                              <? } ?>
                              <form method=post name="frm">
                                <table width=600 border=0 cellspacing=0 cellpadding=0 align=center>
                                  <tr height=15>
                                    <td><table border=0 cellspacing=1 cellpadding=1>
                                        <tr>
                                          <td width="597" align=left><div align="right">
                                              <!--input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name="button" type="button" onClick=document.location="../ano_escolar.php3"  value="VOLVER"-->
                                          </div></td>
                                        </tr>
                                      </table>
                                        <table border=0 cellspacing=1 cellpadding=1 align="center">
                                          <tr class="tableindex">
                                            <td align=left>AÑO ESCOLAR </td>
                                            <td>:</td>
                                            <td>
                                              <?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila['nro_ano']);
												}
											}
										?> </td>
                                          </tr>
                                      </table></td>
                                  </tr>
                                </table>
                            </form></td>
                            </tr>
                            <tr>
                              <td colspan="8">&nbsp;<table width="100%" border="0" cellspacing="0" cellpadding="5">
                                    <tr>
                                      <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
                                          <tr align="left" valign="top">
                                            <td width="52%" height="582"><table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                <tr>
                                                  <td class="fondo"><strong>Alumnos</strong></td>
                                                </tr>
                                                <tr>
                                                  <td align="left" valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
													    <tr>
                                                        <td width="8%" align="center" valign="middle"><img src="../../../../../cortes/arrow.png" width="9" height="9"></td>
                                                        <td width="92%" class="cuadro01"><a href="Rprt3.php">01 Reporte Formulario Postulación </a></td>
                                                      </tr>
													  <tr>
                                                        <td width="8%" align="center" valign="middle"><img src="../../../../../cortes/arrow.png" width="9" height="9"></td>
                                                        <td width="92%" class="cuadro01"><a href="Rprt1.php">03 Total de Postulaciones a un Establecimiento</a></td>
                                                      </tr>
													   <!-- <tr>
                                                        <td width="8%" align="center" valign="middle"><img src="../../../../../cortes/arrow.png" width="9" height="9"></td>
                                                        <td width="92%" class="cuadro01"><a href="Rprt2.php">03 Reporte Postulación </a></td>
                                                      </tr>-->
													   <tr>
                                                        <td width="8%" align="center" valign="middle"><img src="../../../../../cortes/arrow.png" width="9" height="9"></td>
                                                        <td width="92%" class="cuadro01"><a href="Rprt4.php">04 Total de postulaciones a un establecimiento por alumno</a></td>
                                                      </tr>
													   <tr>
                                                        <td width="8%" align="center" valign="middle"><img src="../../../../../cortes/arrow.png" width="9" height="9"></td>
                                                        <td width="92%" class="cuadro01"><a href="Rprt10.php">05 Total de Alumno por Nivel</a></td>
                                                      </tr>
													     <tr>
                                                        <td width="8%" align="center" valign="middle"><img src="../../../../../cortes/arrow.png" width="9" height="9"></td>
                                                        <td width="92%" class="cuadro01"><a href="Rprt5.php">06 Total de Alumnos Establecimiento por Curso</a></td>
                                                      </tr>
													    <!--   <tr>
                                                        <td width="8%" align="center" valign="middle"><img src="../../../../../cortes/arrow.png" width="9" height="9"></td>
                                                        <td width="92%" class="cuadro01"><a href="Rprt6.php">07 Total de Postulaciones de Todos los Establecimientos</a></td>
                                                      </tr>
													       <tr>
                                                        <td width="8%" align="center" valign="middle"><img src="../../../../../cortes/arrow.png" width="9" height="9"></td>
                                                        <td width="92%" class="cuadro01"><a href="Rprt7.php">08 Total de Postulaciones a Establecimientos Corporación</a></td>
                                                      </tr>
													  </tr>
													       <tr>
                                                        <td width="8%" align="center" valign="middle"><img src="../../../../../cortes/arrow.png" width="9" height="9"></td>
                                                        <td width="92%" class="cuadro01"><a href="Rprt8.php">09 Total de Postulaciones de Todos Los Establecimientos</a></td>
                                                      </tr>
													  <tr>
                                                        <td width="8%" align="center" valign="middle"><img src="../../../../../cortes/arrow.png" width="9" height="9"></td>
                                                        <td width="92%" class="cuadro01"><a href="Rprt9.php">10 Total Aceptados de Todos Los Establecimientos</a></td>
                                                      </tr>-->
													  <? if($_PERFIL==0){ ?>
													  <? }?>
                                                  </table></td>
                                                </tr>
                                            </table></td>
                                            <td width="50%">&nbsp;</td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                    <tr>
                                      <td align="center" valign="top">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td height="44" align="center" valign="middle"><table width="40%" border="0" cellpadding="0" cellspacing="0" class="boton02">
                                          <tr align="center" valign="middle">
                                            <td height="23"><img src="../../../../../cortes/atras.gif" width="11" height="11"> Volver</td>
                                            <td><img src="../../../../../cortes/subir.gif" width="11" height="11"> Subir</td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                  </table></td>
                            </tr>
							
                          </table>
                          <p>&nbsp;                          </p>
                        </form>&nbsp;</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
