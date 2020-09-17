
<?
 require("../../util/header.php");
 require("mod_menu.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_menu = new Menu();
 
 if($funcion==1){
	 $rs_menu = $ob_menu->ListadoMenu($conn,$perfil,$rdb);
?>
<table width="90%" border="1" align="center" class="tablaredonda" >
	<tr class="tablaredonda">
		<td width="12%" class="tablaredonda cuadro01">&nbsp; ESTADO</td>
		<td width="88%" class="tablaredonda cuadro01">&nbsp;MEN&Uacute;</td>
	</tr>
    <? for($i=0;$i<pg_numrows($rs_menu);$i++){
			$fila =pg_fetch_array($rs_menu,$i);
			if(($i % 2)==0){
				$estilo="detalleoff";	
			}else{
				$estilo="detalleon";
			}
			
			if($fila['rdb']==""){
				$imagen="<img title='AGREGAR' src='../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png' onClick='Agregar(".$fila['id_categoria'].",".$fila['id_menu'].")' border=0>";
			}else{
				$imagen="<img title='ELIMINAR' src='../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Delete.png' onClick='Eliminar(".$fila['id_categoria'].",".$fila['id_menu'].")' border=0>";
			}
	?>
	<tr class="tablaredonda">
		<td class="tablaredonda" align="center">&nbsp;<a href="#"><?=$imagen;?></a></td>
		<td class="tablaredonda textosimple">&nbsp;<?="<b>".$fila['nombre_menu']."</b>--><i>".$fila['nombre_categoria']."</i>";?></td>
	</tr>
	
    <? } ?>
  
</table>
 <img src="../reportes/img/sombra.png" width="885" height="32">                      
<br>

<?	 
	 
 }
 
 if($funcion==2){
	$rs_insert = $ob_menu->AgregarMenu($conn,$perfil,$rdb,$categoria,$menu);
	
	if($rs_insert){
		echo 1;
	}else{
		echo 0;	
	}
 }

 if($funcion==3){
	$rs_delete = $ob_menu->EliminaMenu($conn,$perfil,$rdb,$categoria,$menu);
	
	if($rs_delete){
		echo 1;
	}else{
		echo 0;	
	}
 }

?>

