<?
require('../util/header.inc');
//print_r($_GET);

$institucion	=$_INSTIT;
"Ensecion->".$usuarioensesion = $_USUARIOENSESION;
$perfil_user = $_PERFIL;
"Id_Usuario->".$idusuario = $_USUARIO;


"rut---->".$rut_usuario=$_NOMBREUSUARIO;
	
echo	$idele = $_GET['idel'];
$_POSP=1;
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

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg','../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral=5;  include("../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="95%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->
                 
								  
								  
								  
								  <table width="100%" border="1" align="center">
  <tr>
    <td width="696" height="38"><table width="100%" border="0" align="center">
      <tr><form name="form"   action="envio.php" method="get">
        <td>
		<? if($ingreso==1){?>
		<input class="botonXX" type="submit" name="submit2" value="Redactar Mensaje">
		<? } 
			if($ver==1){?>
           <label>
		  <input name="Submit" type="button" class="BotonXX" onClick="MM_goToURL('parent','enviados.php');return document.MM_returnValue" value="Ir a Bandeja de enviados">
        </label>
		<? } ?></td>
        <td><img src="images/icono_mensajeria2.png" width="93" height="108"></td>
		</form>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="60"><table width="100%" border="0" align="center">
      <tr class="tablatit2-1">
        <td width="5%"></td>
        <td width="30%">De :</td>
        <td width="40%">Asunto :</td>
        <td width="15%">Fecha :</td>
        <td width="5%"></td>
        <td width="5%"></td>
      </tr>
    </table>
      <table width="100%" border="1" align="center">
        <tr>
          <? 
	
if ($idele != NULL)
{

$qryss="DELETE FROM mensajero where id_mensaje=".$idele;
$results =pg_Exec($conn,$qryss);
}	

  $qry="SELECT * FROM mensajero WHERE user2men='$rut_usuario' Order by fecha"; 

/*."and id_perfil =1";//.$perfil_user;*/
	$result =pg_Exec($conn,$qry);
	$num=pg_numrows($result);
	if (!$result) {
											
	error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}else{
											
											
		 $i = 0; 
	while($row = pg_fetch_array($result)){
												
												
												
$id = $row["id_mensaje"];												
$de = $row["user1men"];
$para = $row["user2men"];
$mensaje = $row["mensaje"];
$asunto = $row["asunto"];
$fecha = $row["fecha"];
$archi = $row["archivos"];
$cram = $row["lee"];
												
?>
        </tr>
        <?  if ($cram == 1) { ?>
        <tr>
          <td width="5%"><div align="center"><img src="images/productoagregado.gif" width="10" height="10" /></div></td>
          <?												
?>
          <td width="30%">
		  	<? if($ver==1){?>
		  <a href="enviorespu.php?id=<? echo $id ?>" class="textonegrita" >
		  	<? } ?>
		  <? echo $de; 	?>
		  <? if($ver==1){?>
		  </a>
		  <? } ?>
		  </td>
          <?
?>
          <td width="40%" class="textonegrita"><a href="enviorespu.php?id=<? echo $id ?>" class="Estilo8"><? echo $asunto; ?></a></td>
          <td width="15%" class="listadetalleoff"><span class="Estilo8"><? echo $fecha ?></span></td>
          <td width="5%"><div align="center"><span class="Estilo8">
		  <? if($elimina==1){?>
		  <a href="mira.php?idel=<? echo $id ?>">
		  <? } ?>
		  <img src="images/b_drop.png" width="16" height="16" border="0" alt="Eliminar" />
		  <? if($elimina==1){?>
		  </a>
		  <? } ?>
		  </span></div></td>
          <?
if ($archi != NULL){?>
          <td width="5%" class="listadetalleoff"><div align="center" class="Estilo13">A</div></td>
          <?		}else{ ?>
		  <td width="5%"><div align="center" class="Estilo13">&nbsp;</div></td>
          <? } ?>
          <?												  
?>
        </tr>
        <?  }else { ?>
        <tr>
          <td width="5%" class="listadetalleon"><div align="center"><img src="images/productonoagregado.gif" width="10" height="10" /></div></td>
          <?												
?>			
          <td width="30%" class="listadetalleon" ><a href="enviorespu.php?id=<? echo $id ?>">
            
            <? echo $de; 	?></a></td>
          <?
?>
          <td width="40%" class="listadetalleon"><a href="enviorespu.php?id=<? echo $id ?>" class="Estilo8"><? echo $asunto; ?></a></td>
          <td width="15%" class="listadetalleon"><span class="Estilo8"><? echo $fecha ?></span></td>
          <td width="5%" class="listadetalleon"><div align="center"><span class="Estilo8"><a href="mira.php?idel=<? echo $id ?>"><img src="images/b_drop.png" width="16" height="16" border="0" alt="Eliminar" /></a></span></div></td>
          <?

   if ($archi != NULL){?>
          <td width="5%" class="listadetalleon"><div align="center" class="Estilo13">A</div></td>
          <?	}else{ ?>
		  <td width="5%" class="listadetalleon"><div align="center" class="Estilo13">&nbsp;</div></td>
          <? } ?>
          <?												  
?>
        </tr>
        <? }?>
        <?													  
?>
        <? } }?>
      </table></td>
  </tr>
</table>
								  
								  
								  
								  
								  <!-- fin codigo antiguo --></td>
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
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../<?=$_IMAGEN_DERECHA?>"></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
