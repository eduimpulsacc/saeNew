<?	require('../../util/header.inc');
	
	$institucion = $_INSTIT;
																	
	if($caso==1){
		for($i=1;$i <= $contador; $i++){
			$id_item = ${"ck_reporte".$i};
			if($id_item){
				$sql = "SELECT id_reporte FROM item_reporte WHERE id_item=".$id_item;
				$rs_reporte = @pg_exec($connection,$sql);
				$id_reporte = @pg_result($rs_reporte,0);
				
				$sql = "INSERT INTO perfil_reporte (rdb,id_perfil,id_item,id_reporte) VALUES(".$institucion.",".$cmbPERFIL.",".$id_item.",".$id_reporte.")";
				$rs_item = @pg_exec($conn,$sql);
			}
		}
		
	}elseif($caso==2){
		$sql = "DELETE FROM perfil_reporte WHERE rdb=".$institucion." AND id_perfil=".$cmbPERFIL;
		$rs_delete = pg_exec($conn,$sql);
		for($i=1;$i <= $contador; $i++){
			$id_item = ${"ck_reporte".$i};
			if($id_item > 0){
				$sql = "SELECT id_reporte FROM item_reporte WHERE id_item=".$id_item;
				$rs_reporte = @pg_exec($connection,$sql);
				$id_reporte = @pg_result($rs_reporte,0);
				
				echo "<br>".$sql = "INSERT INTO perfil_reporte (rdb,id_perfil,id_item,id_reporte) VALUES(".$institucion.",".$cmbPERFIL.",".$id_item.",".$id_reporte.")";
				$rs_item = @pg_exec($conn,$sql) or die(pg_last_error($conn));
			}
		}
	}

	echo "<script>window.location='perfil_reporte.php?cmbPERFIL=$cmbPERFIL'</script>";
	pg_close();
?>