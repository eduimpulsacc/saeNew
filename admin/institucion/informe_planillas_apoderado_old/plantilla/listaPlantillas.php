<?php require('../../../../util/header.inc');
$institucion=$_INSTIT;
$_POSP = 4;
$_bot = 7;

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


if(session_is_registered('_PLANTILLA')){
			session_unregister('_PLANTILLA');
		};
if(session_is_registered('_AREA')){
			session_unregister('_AREA');
		};
if(session_is_registered('_SUBAREA')){
			session_unregister('_SUBAREA');
		};		

	//$sqlTraePlantillas="SELECT * FROM informe_plantilla where tipo_ensenanza=".$tipoEns;
	 $sqlTraePlantillas="SELECT * FROM plantilla_apo where rbd=".$institucion." order by fecha asc";
	$resultTraePlantillas=pg_Exec($conn, $sqlTraePlantillas);
	if (!$resultTraePlantillas) {
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlTraePlantillas);
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
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

<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
    					 $menu_lateral=2;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  <br>
								  <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
								  

<table width="520" border="0" align="center">
  <tr>
    <td><table width="100%" border="0">
        <tr> 
          <td width="69%">&nbsp;</td>
          <td width="15%">
		  <? if($ingreso==1){ ?>
		  <input class="botonXX"  type="button" name="Submit2" value="AGREGAR" onClick="window.location='../../informe_planillas_apoderado2/crea_informe_1.php'"></td>
		  <? } ?>
          <td width="16%">&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td colspan="4" align="center"  class="tableindex">PLANTILLAS 
            PARA EVALUACION</td>
        </tr>
        <tr align="center"> 
          <td class="tablatit2-1">NOMBRE</td>
          <td class="tablatit2-1">TIPO DE ENSE&Ntilde;ANZA</td>
          <td class="tablatit2-1">FECHA DE CREACI&Oacute;N</td>
          <!--<td class="tablatit2-1">HABILITADO</td>-->
        </tr>
		<?php for ($countP=0 ; $countP<pg_numrows($resultTraePlantillas) ; $countP++){
				$filaP=pg_fetch_array($resultTraePlantillas);
				$fecha=$filaP['fecha_creacion'];
				
				$qryEnse="select nombre_tipo from tipo_ensenanza where cod_tipo=".$filaP['tipo_ensenanza'];
				$resultEnse=pg_exec($conn, $qryEnse);
					if (!$resultEnse) {
						error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>'.$qryEnse);
					}
				
				$filaE=@pg_fetch_array($resultEnse,0);
				
				if ($filaP['activa'] == 1) {
					$font_color = 'color="#336633"';
				} else {
					$font_color = 'color="#990000"';
				}
		?>
        <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=window.location='<? if ($filaP[nuevo_sis]!=1){ echo "modPlantilla.php";}else{echo "../../informe_planillas2/ver_informe.php";}?>?plantilla=<?php echo $filaP["id_plantilla"];?>&creada=1'> 
          <td><font size="1" face="Arial, Helvetica, sans-serif" <?=$font_color?>><?php echo $filaP['nombre']?>&nbsp;</font></td>
          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif" <?=$font_color?>><?php echo $filaE['nombre_tipo']?>&nbsp;</font></td>
          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif" <?=$font_color?>><?php impF ($fecha)?>&nbsp;</font></td>
         <!--<td align="center"><input type="checkbox" name="<?=$filaP["id_plantilla"]?>" value="<?=$filaP["id_plantilla"]?>"></td>
        </tr>-->
		<?php } ?>
      </table></td>
  </tr>
</table>

   								  <!-- FIN DEL NUEVO CÓDIGO -->
	 							  </td>
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
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
