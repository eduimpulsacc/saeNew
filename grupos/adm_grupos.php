<?
require('../util/header.inc');

$institucion	=$_INSTIT;
$ano			=$_ANO;
$ano3			=$_ANO;
$curso          =$_CURSO;
$_POSP = 2;
$_bot = 0;


$sql="select situacion from ano_escolar where id_ano=$ano";
$result =pg_exec($conn,$sql);
$situacion=pg_result($result,0);


/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;
}else{
	if($nw==1){
		$_MENU =$menu;
		session_register('_MENU');
		$_CATEGORIA = $categoria;
		session_register('_CATEGORIA');
	}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}

if ($ano > 0){
   $_MDINAMICO = 1;
}else{
   $_MDINAMICO = 0;
}
      
$perfil = $_PERFIL; 	
$usuarioensesion = $_USUARIOENSESION;


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              
			 
			   <tr align="left" valign="top"> 
                <td height="75" valign="top">
				
				    <?
			         include("../cabecera/menu_superior.php");
			        ?>
				
				</td>
              </tr>
			  
			  </table>
			  
			  
			  
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="362" align="left" valign="top">
					  
					   <!-- AQUI INSERTO EL MENÚ DINÁMICO -->
					   <?
					    $menu_lateral=5;
						include("../menus/menu_lateral.php");
						?> 
					  
					  
                    </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
                                <tr align="center" valign="top"> 
                                  <td height="162" align="center">
								  <?
								  // Selecciono los grupos de la institucion
								  $q1 = "select * from grupos where rdb = '".trim($institucion)."' order by nombre";
								  $r1 = pg_Exec($conn,$q1);
								  $n1 = pg_numrows($r1);
								  
								  ?>			  
								  
								  
								  <table width="100%" border="0" cellspacing="1" cellpadding="2">
                                    <tr>
                                      <td colspan="4" class="tableindex"><div align="center">ADMINISTRADOR DE GRUPOS <br>
                                        <br>
                                      </div></td>
                                      </tr>
                                    <tr>
                                      <td colspan="4"><div align="right">
                                        <label>
										<? 
										if ($situacion !=0){
										if($ingreso==1){?>
                                        <input name="Submit" type="button" onClick="MM_goToURL('parent','form_grupo.php');return document.MM_returnValue" value="AGREGAR" class="botonXX">
										<? } 
										}//cierre if año escolar?>
                                        </label>
                                      </div></td>
                                      </tr>
                                    <tr>
                                      <td class="cuadro02"><div align="center">NOMBRE</div></td>
                                      <td class="cuadro02"><div align="center">DESCRIPCION</div></td>
                                      <td class="cuadro02"><div align="center">EDITAR</div></td>
                                      <td class="cuadro02"><div align="center">BORRAR</div></td>
                                    </tr>
                                    
									<?
									$i = 0;
									while ($i < $n1){
									     $f1 = pg_fetch_array($r1,$i);
										 $nombre      = $f1['nombre'];
										 $descripcion = $f1['descripcion'];
										 $id_grupo    = $f1['id_grupo'];
										 
										 ?>
										<tr>
										  <td class="cuadro01"><?=$nombre ?></td>
										  <td class="cuadro01"><?=$descripcion ?></td>
										  <td class="cuadro01"><div align="center">
											<label>
											<? if($modifica==1){?>
											<input name="Submit2" type="button" onClick="MM_goToURL('parent','form_grupo.php?id_grupo=<?=$id_grupo ?>');return document.MM_returnValue" value="E" class="botonXX">
											<? } ?>
											</label>
										  </div></td>
										  <td class="cuadro01"><div align="center">
											<label>
											<? if($elimina==1){?>
											<input name="Submit3" type="button" onClick="MM_goToURL('parent','proceso_grupo.php?id_grupo=<?=$id_grupo ?>&borra_g=1');return document.MM_returnValue" value="B" class="botonXX">
											<? } ?>
											</label>
										  </div></td>
										</tr>
									    <?
										$i++;
									} ?>	
									
									
                                  </table></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          <td width="53" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
