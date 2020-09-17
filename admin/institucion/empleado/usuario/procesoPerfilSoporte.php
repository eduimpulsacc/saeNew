<?php require('../../../../util/header.inc'); ?>
<?php

	$_ID_USER = $_GET['id_user'];
	"<br>".$cmbPERFIL = $_GET['cmbperfil'];
	"<br>".$_INSTIT = $_GET['rdb'];
	"<br>".$servidor = $_GET['servidor'];

	$qry="INSERT INTO ACCEDE (ID_USUARIO, ID_PERFIL, RDB, ESTADO) VALUES (".$_ID_USER.",".$cmbPERFIL.",".$_INSTIT.",1)";
	$result =@pg_Exec($conn2,$qry);
	if (!$result) {
	     echo "<script>alert('Se produjo un error al intentar crear un nuevo usuario');</script>";	
		 if($servidor=="murialdo"){
		 echo "<script>window.location = 'http://190.162.116.194/admin/institucion/empleado/empleado.php3?pesta=4'</script>";	
		 }
		 if($servidor=="antofagasta"){
		 echo "<script>window.location = 'http://www.cmds.cl/admin/institucion/empleado/empleado.php3?pesta=4'</script>";	
		 }
		 if($servidor=="zapallar"){
		 echo "<script>window.location = 'http://200.29.22.36/admin/institucion/empleado/empleado.php3?pesta=4'</script>";	
		 }
	}else{
		if($servidor=="murialdo"){
		 echo "<script>window.location = 'http://190.162.116.194/admin/institucion/empleado/empleado.php3?pesta=4'</script>";	
		 }
		 if($servidor=="antofagasta"){
		 echo "<script>window.location = 'http://www.cmds.cl/admin/institucion/empleado/empleado.php3?pesta=4'</script>";
		 }
		 if($servidor=="zapallar"){
		 echo "<script>window.location = 'http://200.29.22.36/admin/institucion/empleado/empleado.php3?pesta=4'</script>";	
		 }
	}
?>