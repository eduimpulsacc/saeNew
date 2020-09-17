<?php require('../../../../../../../util/header.inc'); ?>
<?php
	$qry="INSERT INTO ACCEDE (ID_USUARIO, ID_PERFIL, RDB, ESTADO) VALUES (".$_ID_USER.",".$cmbPERFIL.",".$_INSTIT.",1)";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD. (4)');
		}else{
			echo "<script>window.location = 'usuario.php3'</script>";
		}
?>