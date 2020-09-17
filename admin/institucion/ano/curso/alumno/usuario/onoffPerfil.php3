 <?php require('../../../../../../util/header.inc'); ?>
<?php
	if($estado==0){
		$qry="UPDATE ACCEDE SET ESTADO=1 WHERE ID_USUARIO=".$usuario." AND ID_PERFIL=".$perfil." AND RDB=".$_INSTIT;
		$result =@pg_Exec($conn,$qry);
	}

	if($estado==1){
		$qry="UPDATE ACCEDE SET ESTADO=0 WHERE ID_USUARIO=".$usuario." AND ID_PERFIL=".$perfil." AND RDB=".$_INSTIT;
		$result =@pg_Exec($conn,$qry);
	}
	pg_close($conn);
	echo "<script>window.location = 'usuario.php3'</script>";
?>