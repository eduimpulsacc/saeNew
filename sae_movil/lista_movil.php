<?
session_start();
require('../util/header.inc');

$institucion	=$_INSTIT;
$ano			=$_ANO;
$ano3			=$_ANO;
$curso          =$_CURSO;
$_POSP = 1;
$_bot = 0;

if ($ano > 0){
   $_MDINAMICO = 1;
}else{
   $_MDINAMICO = 0;
}
      
$perfil = $_PERFIL; 


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
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$perfil." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
}

$sw=1;
	
$usuarioensesion = $_USUARIOENSESION;

//Tomo todos los datos de la agenda
if ($sw == 1){
   $sqlagenda="select * from agenda  where rdb = '$institucion'";
   $rsagenda= @pg_Exec($conn,$sqlagenda);
}else{
   $dia  = substr($fecha,8,2);
   $mes  = substr($fecha,5,2);
   $ano2 = substr($fecha,0,4);
   $sqlagenda="select * from agenda where fecha = '$fecha' and rdb = '$institucion'";
   $rsagenda= @pg_Exec($conn,$sqlagenda);
}

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
//-->
</script>
<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
<style type="text/css">
.ali {
	text-align: left;
}
.ali {
	text-align: left;
}
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
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
                            <td align="left" valign="top"><table width="100%" border="1" cellpadding="5" cellspacing="0" bordercolor="#999999">
                                <tr align="center" valign="top"> 
                                  <td height="162" align="center">
							        <table width="100%">
						            <tr><td class="tableindex"><div align="center">
						              <h3>SAE MOVIL. Sistema de Gesti&oacute;n y Administraci&oacute;n Escolar para m&oacute;viles</h3>
						            </div></td></tr></table>
						            <h3>Caracter&iacute;sticas Principales<br></h3>
						            <p class="ali"><span class="ali">&bull; Conjuga el uso vital que hoy le entregamos a nuestros tel&eacute;fonos celulares con la informaci&oacute;n de sus hijos (as).</span></p>
<p class="ali"><span class="ali">&bull; Se visualizan las notas, asistencia y anotaciones de sus hijos (as).</span></p>
                                    <p class="ali"><span class="ali">&bull; El padre y apoderado tiene acceso directo para comunicarse con el establecimeinto.</span></p>
                                    <p class="ali"><span class="ali">&bull; La aplicaci&oacute;n funciona para tel&eacute;fonos celulares con internet y smartphone.</span><br>
                                    </p>
                                    <p class="ali">&bull; Ruta de acceso: http://www.colegiointeractivo.com/sae3.0/sm</p>
                                    <table width="100%" border="0" cellpadding="0" cellspacing="5">
                                      <tr>
                                        <th valign="top"><img src="<?=$c;?>sae_movil/image_sae_movil1.jpg" width="247" height="281"></th>
                                        <th valign="top"><img src="<?=$c;?>sae_movil/image_sae_movil2.2.jpg" width="247" height="281"></th>
                                        <th valign="top"><img src="<?=$c;?>sae_movil/image_sae_movil3.jpg" width="247" height="281"></th>
                                      </tr>
                                      <tr>
                                        <td align="center" valign="top"><img src="<?=$c;?>sae_movil/image_sae_movil4.jpg" width="247" height="281"></td>
                                        <td align="center" valign="top"><img src="<?=$c;?>sae_movil/image_sae_movil5.jpg" width="247" height="281"></td>
                                        <td align="center" valign="top"><img src="<?=$c;?>sae_movil/image_sae_movil6.jpg" width="247" height="281"></td>
                                      </tr>
                                  </table></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"> <?
						 include("../cabecera/menu_inferior.php");
						 ?>
	  
	  
	  </td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
          <td width="53" align="left" valign="top" background="../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
