<?php require('../../../util/header.inc');
$plantilla	=$_PLANTILLA;
$area		=$_AREA;
$concepto	=$_CONCEPTO;
$_POSP = 3;
$_bot = 6;

$query_plantilla="select * from informe_plantilla where id_plantilla='$plantilla'";
$result_planilla=pg_exec($conn,$query_plantilla);
$num_planilla=pg_numrows($result_planilla);

if ($num_planilla>0){
	$row_planilla=pg_fetch_array($result_planilla);
	 $query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla";
	$result_concep=pg_exec($conn,$query_concep);
	 $num_concep=pg_numrows($result_concep);		
}



?>
<? if ($siguiente){
$concepto=$_POST[concepto];
//	imprime_array($concepto);
	$largo=count($id_item);
	for ($i=0;$i<$largo;$i++){
		$query_update ="update informe_area_item set con_concepto='$concepto[$i]' where id='$id_item[$i]'";
		//echo "$query_update<br>";
		$result_update=pg_exec($conn,$query_update);
		
	}
echo "vhs";
header ("Location: ver_informe.php?plantilla=$plantilla&creada=1");
exit;

}?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
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
					  $menu_lateral = 2;
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
							<tr>
							  <td class="fondo">4to.- Configuracion de Sub Categorias - items(<? echo $row_planilla['nombre'];?>) </td>
							</tr>
                              <tr><td valign="top" align="center"><form method="post"  name="form"	>
							  
                                <? $cont_radio=0;?>
								
                                <table border="1" width="60%">
                                  <? 	$query_cat="select * from informe_area_item where id_plantilla='$plantilla' and id_padre=0";
	$result_cat=pg_exec($conn,$query_cat);
	$num_cat=pg_numrows($result_cat);
	?>
                                  <tr>
                                    <td>&nbsp;</td>
                                    <td colspan="2" class="tabla02">concepto Evaluativo</td>
                                  </tr>
                                  <tr>
								  	<td rowspan="1" valign="bottom"  class="tabla02">glosa-nombre</td>
                                    <td class="tablatit2-1" align="center">Con </td>
                                    <td align="center" class="tablatit2-1">Sin</td>
                                  </tr>
                                  <? for ($i=0;$i<$num_cat;$i++){
	$row_cat=pg_fetch_array($result_cat);
?>
                                  <tr>
                                    <td class="tablatit2-1"><? echo $row_cat['glosa'];?></td>
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
                                    <td class="tablatit2-1"><img src="../../../cortes/p.gif" width="10" height="1" border="0"><? echo $row_sub['glosa'];?></td>
                                    <? 	
					$query_total="select count(*) as total from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id]";
					$result_total=pg_exec($conn,$query_total);
					$row_total=pg_fetch_array($result_total);
					
					?>
                                    <? if ($row_total[total]==0){?>
                                    <td><input name="id_item[<? echo $cont_radio;?>]" value="<? echo $row_sub[id];?>" type="hidden">
                                        <input  name="concepto[<? echo $cont_radio;?>]" type="radio" value="1"  <? if ($num_concep==0){ echo " disabled    ";$sw=1;}?>  <? if ((!$row_sub[con_concepto])||($row_sub[con_concepto]=="1")){ echo "checked";}?>>                                          </td>
                                    <td><input type="radio"  name="concepto[<? echo $cont_radio;?>]" value="0" <? if (($sw=="1")){ echo "checked";}?> ></td>
                                    <? $cont_radio++;?>
                                    <? }else{?>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <? }?>
                                  </tr>
                                  <? 	
								  $query_item="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id]";
									$result_item=pg_exec($conn,$query_item);
									$num_item=pg_numrows($result_item);?>
                                  <? for ($z=0;$z<$num_item;$z++){
						$row_item=pg_fetch_array($result_item);
					?>
                                  <tr>
                                    <td class="tablatit2-1"><img src="../../../cortes/p.gif" width="20" height="1" border="0"><? echo $row_item['glosa'];?></td>
                                    <td><input name="id_item[<? echo $cont_radio;?>]" value="<? echo $row_item[id];?>" type="hidden">
                                        <input  name="concepto[<? echo $cont_radio;?>]" type="radio" value="1"  <? if ($num_concep==0){ echo " disabled    ";$sw=1;}?>     <? if ((!$row_item[con_concepto])||($row_item[con_concepto]=="1")){ echo " checked";}?> ></td>
                                    <td><input type="radio"  name="concepto[<? echo $cont_radio;?>]" value="0"  <? if (($sw==1)){ echo "checked";}?>></td>
                                    <? $cont_radio++;?>
                                  </tr>
                                  <? }?>	
                                  <? }?>
                                  <? }?>
                                  <tr>
                                    <td colspan="3" align="center"><input name="siguiente" type="submit" value="Terminar" class="botonXX"></td>
                                  </tr>
                                </table>
                              </form>
							</td>
                              </tr></table>                         </td>

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
