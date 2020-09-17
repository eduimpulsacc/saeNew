<?
require('../../util/header.inc');

$institucion	=$_INSTIT;
$ano			=$_ANO;
$_POSP = 2;
$_bot = 0;
$_MDINAMICO = 1;

$alumno			=$_ALUMNO;
$curso			=$_CURSO;
$frmModo		="mostrar";
$_POSP =2;


$perfil = $_PERFIL; 
	
$usuarioensesion = $_USUARIOENSESION;
##Selecciono los datos para mostrar en el Diario Mural.

$sqlDiario = "select * from diario_mural where id_ano = $ano order by fecha_publi desc";
$rsDiario  = @pg_Exec($conn,$sqlDiario);
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../estilos.css" rel="stylesheet" type="text/css">
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
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="93" height="722" align="left" valign="top" background="../../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              
			 
			   <tr align="left" valign="top"> 
                <td height="75" valign="top">
				
				    <?
			         include("../../cabecera/menu_superior.php");
			        ?>
				
				</td>
              </tr>
			  
			  </table>
			  
			  
			  
              <tr align="left" valign="top"> 
                <td height="207">
<table width="100%" height="207" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td align="left" valign="bottom" background="../../cortes/foto_top.jpg"><font color="#FFFFFF" size="4" face="Arial, Helvetica, sans-serif">SAE 
                        - Sistema de Administraci&oacute;n Escolar 05.</font></td>
                    </tr>
                  </table></td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="362" align="left" valign="top">
					  
					   <!-- AQUI INSERTO EL MENÚ DINÁMICO -->
					   <?
						include("../../menus/menu_lateral.php");
						?> 
					  
					  
                    </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top">
							<?php
if ($institucion!=24977 and $institucion!=25478){ ?>
							  
<? if($institucion==9035){ ?>
<script language="javascript" type="text/javascript">Abrir_ventana('popup2.htm');</script>							  
								  
<? } ?>
							
							<table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#999999">
                                <tr align="left" valign="top"> 
                                  <td width="37%" height="162" align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr> 
                                        <td height="195" align="center" valign="top"> 
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr> 
                                              <td width="1" height="36" class="tableindex">AGENDA 
                                                MES</td>
                                            </tr>
                                            <tr> 
                                              <td height="149" align="left" valign="top" class="borde"><img src="../../cortes/calendar.jpg" width="153" height="127"></td>
                                            </tr>
                                          </table></td>
                                      </tr>
                                      <tr> 
                                        <td align="center" valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr> 
                                              <td width="1" height="36" class="tableindex">HEADLINES</td>
                                            </tr>
                                            <tr> 
                                              <td height="23" class="borde"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr> 
                                                    <td width="12%" height="39" align="center" valign="top"><img src="../../cortes/i_hoja.jpg" width="11" height="13"></td>
                                                    <td width="88%" height="45" align="left" valign="top"><a href="#" class="textolink">Texto 
                                                      simulado solo para visualizar 
                                                      como queda</a></td>
                                                  </tr>
                                                  <tr> 
                                                    <td align="center" valign="top"><img src="../../cortes/i_hoja.jpg" width="11" height="13"></td>
                                                    <td height="45" align="left" valign="top"><a href="#" class="textolink">kjbv 
                                                      asfhjg kgasf kjhgfs jyhs 
                                                      jhsfjkgas khgf</a></td>
                                                  </tr>
                                                  <tr> 
                                                    <td height="36" align="center" valign="top"><img src="../../cortes/i_hoja.jpg" width="11" height="13"></td>
                                                    <td height="45" align="left" valign="top"><a href="#" class="textolink">kjbv 
                                                      asfhjg kgasf kjhgfs jyhs 
                                                      jhsfjkgas khgf</a></td>
                                                  </tr>
                                                </table></td>
                                            </tr>
                                          </table></td>
                                      </tr>
                                    </table></td>
                                  <td width="63%" align="center">
<table width="97%" border="0" cellspacing="0" cellpadding="0">
                                      <tr> 
                                        <td align="center" valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr> 
                                              <td width="314" height="36" class="tableindex">DIARIO 
                                                MURAL </td>
                                            </tr>
                                            <tr> 
                                              <td height="23" align="left" valign="top" class="borde"> 
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <!-- AQUI LA INFORMACION DEL DIARIO MURAL -->
												  
												  <? 
												  
												  $num = @pg_numrows($rsDiario);
												  if(@pg_numrows($rsDiario)!=0){
	                                                    for($i=0 ; $i < 4 ; $i++)
	                                                       {
		                                                   $fDiario = @pg_fetch_array($rsDiario,$i);
														   $detalle = substr($fDiario['detalle'],0,80);	
														   $id_diario = $fDiario['id_diario'];										   
														   
														   
														   $output= "select lo_export(".$fDiario['foto'].",'/var/www/html/tmp/".trim($fDiario['id_diario'])."Foto');";
			$retrieve_result = @pg_exec($conn,$output);
		  												
														
														if ($detalle != NULL){
                                                             ?>
												     	     <tr> 
                                                            <td width="21%" height="54" align="center" valign="top">
														     <img src=../../../tmp/<?php echo $fDiario['id_diario']."Foto" ?> ALT="FOTO DIARIO MURAL"  width=53 height="50" border="1">														  </td>
                                                             <td width="79%" height="60" align="left" valign="top"><a href="../../detalle_diariomural.php?id_diario=<?=$id_diario ?>" class="textolink"><strong><? echo $fDiario['titulo']?></strong><br>
                                                             <? echo "$detalle..." ?> <img src="../../cortes/i_flechita.jpg" border="0"></a><br><br></td>
                                                            </tr>														 
														     <?
													      }		 
														}
														
														if ($num > 4){
														    ?>
														    <tr> 
                                                            <td colspan="2" align="center" valign="middle"><font face="arial, geneva, helvetica" size="1"><a href="../../all_diariomural.php" class="textolink">Ver diario mural completo.</a></font></td>
                                                            </tr>
														    <? 
												        }			
												    }else{
													     ?>													 
                                                        <tr> 
                                                          <td colspan="2" align="center"><font face="arial, geneva, helvetica" size="1">NO EXISTEN INFORMACIÓN DISPONIBLE</font></td>
                                                        </tr>
														<?
														
													}	
													?>	
                                                </table></td>
                                            </tr>
                                          </table></td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table>
							  
							  <? } else { ?>

  <script>windows.location.href ="../fichaAlumno.php3"</script>
   <!-- <frame src="../fichaAlumno.php3" name="mainFrame"> -->
	
	
<? } ?>	
							  
							  </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 - Desarrolla Colegio 
                        Interactivo</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          <td width="96" align="left" valign="top" background="../../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
