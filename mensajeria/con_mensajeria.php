<?
require('../util/header.inc');

if($funcion==1){
	
	$sql="SELECT id_perfil, nombre_perfil, imagen FROM perfil WHERE sistema=1 AND id_perfil not in (47,26,24,4,31,44,51) ORDER BY 2";
	$rs_perfil = pg_exec($connection,$sql);
	
	
	?>	<br>
<br>

		<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr class="tablatit2-1">
    <td>PERFIL</td>
    <td>NOMBRE</td>
    <td>ESTADO</td>
  </tr>
  <? for($i=0;$i<pg_numrows($rs_perfil);$i++){
		$fila = pg_fetch_array($rs_perfil,$i);
		
		$sql="SELECT * FROM config_mensajeria WHERE rdb=".$_INSTIT." AND p_".$fila['id_perfil']."=1 AND id_perfil=".$_POST['perfil']."";
		$rs_existe = pg_exec($conn,$sql);
		if(pg_numrows($rs_existe)==0){
			$activo=0;
		}else{
			$activo=1;	
		}
		
		?>
  <tr>
    <td align="center"><img src="<?=$fila['imagen'];?>" width="30" height="30" border="0"></td>
    <td class="textosimple">&nbsp;<?=$fila['nombre_perfil'];?></td>
    <td>&nbsp;<A href="#"><? if($activo!=1){ ?> <img src="../imag/PNG-48/Add.png" width="30" height="30" title="AGREGAR" border="0" onClick="agregar(<?=$fila['id_perfil'];?>)"> <? }else{ ?> <img src="../imag/PNG-48/Delete.png" width="30" height="30" border="0" title="ELIMINAR" onClick="elimina(<?=$fila['id_perfil'];?>)"><? } ?></A></td>
  </tr>
  <?  } ?>
 </table>

	<? 
   
}

if($funcion==2){
	$sql="SELECT * FROM config_mensajeria WHERE rdb=".$_INSTIT." AND id_perfil=".$_POST['id_perfil'];
	$rs_existe = pg_exec($conn,$sql);
	
	$perfil="p_".$_POST['perfil'];
	if(pg_numrows($rs_existe)==0){
		$sql="INSERT INTO config_mensajeria (id_perfil,rdb,est,$perfil)	VALUES (".$_POST['id_perfil'].",".$_INSTIT.",1,1)";
		$result = pg_exec($conn,$sql);
	}else{
		$sql="UPDATE config_mensajeria SET $perfil=1 WHERE rdb=".$_INSTIT." AND id_perfil=".$_POST['id_perfil'];
		$result = pg_exec($conn,$sql);
	}
	if($result){
		echo 1;
	}else{
		echo 0;	
	}
}

if($funcion==3){
	$perfil="p_".$_POST['perfil'];
	$sql="UPDATE config_mensajeria SET $perfil=0 WHERE rdb=".$_INSTIT." AND id_perfil=".$_POST['id_perfil'];
	$result = pg_exec($conn,$sql);
	if($result){
		echo 1;
	}else{
		echo 0;	
	}
}

?>
