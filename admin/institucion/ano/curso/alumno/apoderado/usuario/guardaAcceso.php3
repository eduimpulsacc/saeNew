<?php require('../../../../../../../util/header.inc'); ?>
<?php
	$qry="SELECT max(id_usuario) AS CANT FROM USUARIO";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}else{
		$fila = @pg_fetch_array($result,0);	
		if (!$fila){
			error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			exit();
		}
		$newID =  $fila['cant'];
		$newID = $newID + 1;
		$qry="INSERT INTO USUARIO (ID_USUARIO, NOMBRE_USUARIO, PW) VALUES (".$newID.",'".trim($_APODERADO)."','".$txtPW1."')";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)');
		}else{
			$qry="INSERT INTO ACCEDE (ID_USUARIO, ID_PERFIL, RDB,ESTADO) VALUES (".$newID.",".$cmbPERFIL.",".$_INSTIT.",1)";
			$result =@pg_Exec($conn,$qry);
			if (!$result) {
				error('<b> ERROR :</b>Error al acceder a la BD. (4)');
			}else{
				$qry="UPDATE APODERADO SET ID_USUARIO=".$newID." WHERE RUT_APO='".trim($_APODERADO)."'";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<b> ERROR :</b>Error al acceder a la BD. (5)');
				}else{
					echo "<script>window.location = 'usuario.php3'</script>";
				}
			}
		}
	}
?> 