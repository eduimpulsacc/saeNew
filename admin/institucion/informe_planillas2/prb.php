<?php require('../../../util/header.inc');
$institucion=$_INSTIT;
$_POSP = 4;
$_bot = 7;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../estilos.css" rel="stylesheet" type="text/css">
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
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> <td>
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			<?   //include("../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
					<?   include("../../../cabecera/menu_superior.php");?>
					</td></tr></table>
					
					</td>
                  
                  </tr>
               
					<!-- FIN DE COPIA DE CABECERA -->
                 
                </table></td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table><tr><td><?
						 include("../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%">
                              <tr><td valign="top"><form method="post" >
                              <? $cont_radio=0;?>
                              <table border="1">
                                <? 	$query_cat="select * from informe_area_item where id_plantilla='$plantilla' and id_padre=0";
	$result_cat=pg_exec($conn,$query_cat);
	$num_cat=pg_numrows($result_cat);
	?>
                                <tr>
                                  <td rowspan="2" valign="bottom">glosa-nombre</td>
                                  <td colspan="2">concepto Evaluativo</td>
                                </tr>
                                <tr>
                                  <td>con </td>
                                  <td>sin</td>
                                </tr>
                                <? for ($i=0;$i<$num_cat;$i++){
	$row_cat=pg_fetch_array($result_cat);
?>
                                <tr>
                                  <td><? echo $row_cat['glosa'];?></td>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <? 	$query_sub="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_cat[id]";
			$result_sub=pg_exec($conn,$query_sub);
			$num_sub=pg_numrows($result_sub);?>
                                <? for ($j=0;$j<$num_sub;$j++){
				$row_sub=pg_fetch_array($result_sub);
			?>
                                <tr>
                                  <td><img src="../../../cortes/p.gif" width="10" height="1" border="0"><? echo $row_sub['glosa'];?> </td>
                                  <? 	
					$query_total="select count(*) as total from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id]";
					$result_total=pg_exec($conn,$query_total);
					$row_total=pg_fetch_array($result_total);
					
					?>
                                  <? if ($row_total[total]==0){?>
                                  <td><input name="id_item[<? echo $cont_radio;?>]" value="<? echo $row_sub[id];?>" type="hidden">
                                      <input  name="concepto[<? echo $cont_radio;?>]" type="radio" value="1" checked>
                                  </td>
                                  <td><input type="radio"  name="concepto[<? echo $cont_radio;?>]" value="0"></td>
                                  <? $cont_radio++;?>
                                  <? }else{?>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <? }?>
                                </tr>
                                <? 	 $query_item="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id]";
					$result_item=pg_exec($conn,$query_item);
					$num_item=pg_numrows($result_item);?>
                                <? for ($z=0;$z<$num_item;$z++){
						$row_item=pg_fetch_array($result_item);
					?>
                                <tr>
                                  <td><img src="../../../cortes/p.gif" width="20" height="1" border="0"><? echo $row_item['glosa'];?></td>
                                  <td><input name="id_item[<? echo $cont_radio;?>]" value="<? echo $row_item[id];?>" type="hidden">
                                      <input  name="concepto[<? echo $cont_radio;?>]" type="radio" value="1" checked></td>
                                  <td><input type="radio"  name="concepto[<? echo $cont_radio;?>]" value="0"></td>
                                  <? $cont_radio++;?>
                                </tr>
                                <? }?>
                                <? }?>
                                <? }?>
                                <tr>
                                  <td colspan="3" align="center"><input name="submit" type="submit" value="Guardar"></td>
                                </tr>
                              </table>
                            </form></td></tr></table>                         </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
