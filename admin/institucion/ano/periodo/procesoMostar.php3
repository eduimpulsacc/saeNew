<?php require('../../../../util/header.inc');?> 
<?php
	if ($caso==1) {
		$qry="UPDATE periodo SET mostrar_notas = 0 where id_periodo=".$_PERIODO;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
		}else{
			echo "<script>window.location = 'seteaPeriodo.php3?caso=1&periodo=".$_PERIODO."'</script>";
		}
	}else{
		$qry="UPDATE periodo SET mostrar_notas = 1 where id_periodo=".$_PERIODO;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
		}else{
			echo "<script>window.location = 'seteaPeriodo.php3?caso=1&periodo=".$_PERIODO."'</script>";
		}
	}

?>