<?php require('../../../../util/header.inc'); ?>
<?php

$_EMPLEADO = $_GET['nom_user'];
$_INSTIT = $_GET['rdb'];
$txtPW1 = $_GET['pass'];
$newID = $_GET['id'];
$cmbPERFIL = $_GET['id_perfil'];
	
		
		$qry="INSERT INTO USUARIO (ID_USUARIO_ORIGEN, NOMBRE_USUARIO, PW) VALUES (".$newID.",'".trim($_EMPLEADO)."','".$txtPW1."')";
		$result =@pg_Exec($conn2,$qry);
		if (!$result) {
			echo $qry;
			error('<b> ERROR :</b>Error al acceder a la BD. (Soporte)');
		}else{
			$qry="INSERT INTO ACCEDE (ID_USUARIO, ID_PERFIL, RDB,ESTADO) VALUES (".$newID.",".$cmbPERFIL.",".$_INSTIT.",1)";
			$result =@pg_Exec($conn2,$qry);
			if (!$result) {
				error('<b> ERROR :</b>Error al acceder a la BD. (Soporte)');
			}else{
					if($servidor=="zapallar"){
					echo "<script>window.location = 'http://200.29.22.36/admin/institucion/empleado/usuario/usuario.php3'</script>";
					}
					
						if($servidor=="antofagasta"){
					echo "<script>window.location = 'http://www.cmds.cl/admin/institucion/empleado/usuario/usuario.php3'</script>";
					}
					
							if($servidor=="murialdo"){
					echo "<script>window.location = 'http://190.162.116.194/admin/institucion/empleado/usuario/usuario.php3'</script>";
					}
			}
		}
	
?> 