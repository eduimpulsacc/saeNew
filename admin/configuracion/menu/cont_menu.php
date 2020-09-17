<?php 
require('../../../util/header.inc');
require('mod_menu.php');

$ob_menu = new Menu();

$funcion = $_POST['funcion'];
if($funcion==1){
$rs_menu_alu = $ob_menu->cargamenu($conn);?>
<table width="95%" border="0" align="center" class="cajaborde">
                  <tr class="tableindexredondo">
                    <td>ESTADO</td>
                    <td>MEN&Uacute;</td>
                  </tr>
                  <? for($i=0;$i<pg_numrows($rs_menu_alu);$i++){
					  	$fila = pg_fetch_array($rs_menu_alu,$i);
						//ver que perfil tiene que ccosa
						$tp = $ob_menu->tengoPerfil($conn,$_INSTIT,$tipo,$fila['id_menu']);
						
						if(($i % 2)==0){
							$class = "detalleoff";	
						}else{
							$class = "detalleon";
						}
						
						$marca = (pg_numrows($tp)>0)?"Delete":"Add";
						$action= (pg_numrows($tp)>0)?0:1;
				?>
                  <tr>
                    <td class="<?=$class;?>"><img src="../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/<?php echo $marca ?>.png" width="24" height="24" onClick="accion(<?php echo $tipo ?>,<?php echo $action ?>,<?php echo $fila['id_menu'] ?>)"></td>
                    <td class="<?=$class;?>">&nbsp;<?=$fila['menu'];?></td>
                  </tr>
                 <? } ?>
                </table>

<?
}
if($funcion==2){
show($_POST);

if($acc==0){
$rs_acc =$ob_menu->quitaPerfil($conn,$_INSTIT,$prf,$mn);
}
if($acc==1){
$rs_acc =$ob_menu->ponPerfil($conn,$_INSTIT,$prf,$mn);
}
}
?>