<?
require('util/header.php');
$institucion	=$_INSTIT;
$ano			=$_ANO;
$_POSP = 2;
$_bot = 0;

if ($ano == NULL){
   $_MDINAMICO = 0;
}else{
   $_MDINAMICO = 1;
}      

$id=$_GET["id"];
$perfil = $_PERFIL; 
	
$usuarioensesion = $_USUARIOENSESION;
##Selecciono los datos para mostrar en el Diario Mural.
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

<script type="text/JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>


</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('cortes/b_ayuda_r.jpg','cortes/b_info_r.jpg','cortes/b_mapa_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              
			 
			   <tr align="left" valign="top"> 
                <td height="75" valign="top">
				
				    <?
			         include("cabecera/menu_superior5.php");
			        ?>				</td>
              </tr>			  
			  </table>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="362" align="left" valign="top">
					  
					   <!-- AQUI INSERTO EL MENÚ DINÁMICO -->
					   <?
						include("menus/menu_lateral.php");
						?>                    </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top"><table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#999999">
                                <tr align="left" valign="top"> 
                                  <td height="162" align="center">
                                    <table width="97%" border="0" cellspacing="0" cellpadding="0">
                                      <tr> 
                                        <td align="center" valign="top"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr> 
                                              <td width="314" height="36" class="tableindex">&nbsp;</td>
                                            </tr>
                                            <tr> 
                                              <td height="23" align="left" valign="top" class="borde"> 
                                                <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                                  <!-- AQUI LA INFORMACION DEL DIARIO MURAL -->
												  
												  <? 
														$sqlDiario = "SELECT * FROM din_noticias where id_noticia = '$id'";
														//echo $sqlDiario;
														//return;
														$rsDiario  = @pg_Exec($connection,$sqlDiario);
												  	if(@pg_numrows($rsDiario)!=0){
	                                                    for($i=0 ; $i < @pg_numrows($rsDiario); $i++)
	                                                       {
		                                                   $fDiario = @pg_fetch_array($rsDiario,$i);			   													   
														  ?>
												     	  <tr> 
                                                          <td height="10" align="center" valign="top" bgcolor="#666666"><font face="arial, geneva, helvetica" size="3" color="#FFFFFF"><b><? echo $fDiario['tx_titulo']?></b></font></td>
                                                        </tr>
														<tr>
														<td width="10" height="10" align="left" valign="top">&nbsp;</td>
     													</tr>
														<tr>
														<td><font face="arial, geneva, helvetica" size="2"><? echo nl2br($fDiario['tx_detalle']) ?></font><br></td>
                                                         </tr>														 
														 <?
														}
														 ?>
														 <tr> 
                                                          <td colspan="2" align="center"><br><a href="#" onClick="window.location='index.php'">Volver</a></td>
                                                        </tr>
														
														 <? 
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
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          <td width="53" align="left" valign="top" background="cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
