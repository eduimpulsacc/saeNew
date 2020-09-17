 <?php require('../../../../util/header.inc'); ?>
<?php
	if($estado==0){
		$qry="UPDATE ACCEDE SET ESTADO=1 WHERE ID_USUARIO=".$usuario." AND ID_PERFIL=".$perfil." AND RDB=".$_INSTIT;
		$result =@pg_Exec($connection,$qry);
		$result2 =@pg_Exec($conn2,$qry);
	}

	if($estado==1){
		$qry="UPDATE ACCEDE SET ESTADO=0 WHERE ID_USUARIO=".$usuario." AND ID_PERFIL=".$perfil." AND RDB=".$_INSTIT;
		$result =@pg_Exec($connection,$qry);
		$result2 =@pg_Exec($conn2,$qry);
	}
	
	if($accion==3){
		$qry = "DELETE FROM accede WHERE id_usuario=".$usuario." AND id_perfil=".$perfil." AND rdb=".$_INSTIT."";
		$result = @pg_Exec($connection,$qry);
		$result2 = @pg_Exec($conn2,$qry);
	}
	
	echo "<script>window.location = '../empleado.php3?pesta=4'</script>";
?>