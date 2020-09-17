<?php require('../../../../util/header.inc'); ?>
<?php

	

$empleado = $_GET['empleado'];
"<br>".$txtPW1 = $_GET['pw1'];
"<br>".$txtPW2 = $_GET['pw2'];
"<br>".$servidor = $_GET['servidor'];
"<br>".$usuario1 = $_GET['user'];
"<br>".$_PERFIL = $_GET['perfil'];


	//$usuario	=$_ID_USER;

	/*if($_PERFIL==0 || $_PERFIL==14){
		$empleado		=$empleados;	
	}
	else{
		$empleado		=$_EMPLEADO;
	}
	*/
		
	if($usuario!=''){
	$qry="SELECT * FROM USUARIO WHERE ID_USUARIO_ORIGEN=".$usuario1;
	}else{
	$qry="SELECT * FROM USUARIO WHERE nombre_usuario='".$empleado."' and pw='".$txtPW1."'";
	}
	$result =@pg_Exec($conn2,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD.(soporte)');
	}else{
		if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
			$fila = @pg_fetch_array($result,0);	
			
			if($usuario==''){
				//$usuario =trim($fila['id_usuario']);
			}
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (soporte)</B>');
				exit();
			}else{
				if (strcmp(trim($fila['pw']),trim($txtPW1))){
					echo "<script>alert('Clave actual no corresponde.')</script>";
					if($servidor=="antofagasta"){
					echo "<script>window.location = 'http://www.cmds.cl/admin/institucion/empleado/usuario/claveAcceso.php3'</script>";
					}
					if($servidor=="zapallar"){
					echo "<script>window.location = 'http://200.29.22.36/admin/institucion/empleado/usuario/claveAcceso.php3'</script>";
					}
					if($servidor=="murialdo"){
					echo "<script>window.location = 'http://190.162.116.194/admin/institucion/empleado/usuario/claveAcceso.php3'</script>";
					}
					
				}else{
					$qry_upd="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO_ORIGEN=".$usuario1." AND PW=".$fila['pw'];
					$result =@pg_Exec($conn2,$qry_upd);
					if (!$result){
						error('<b> ERROR :</b>Error al acceder a la BD.(soporte)');
					};
					echo "<script>alert('Clave actual modificada exitosamente..')</script>";
					if($_PERFIL==0 || $_PERFIL==14){
						if($servidor=="antofagasta"){
						echo "<script>window.location = 'http://www.cmds.cl/admin/institucion/empleado/claves.php3'</script>";
						}
						if($servidor=="zapallar"){
						echo "<script>window.location = 'http://200.29.22.36/admin/institucion/empleado/claves.php3'</script>";
						}
						if($servidor=="murialdo"){
						echo "<script>window.location = 'http://190.162.116.194/admin/institucion/empleado/claves.php3'</script>";
						}
					}else{
						if($servidor=="antofagasta"){
						echo "<script>window.location = 'http://www.cmds.cl/admin/institucion/empleado/empleado.php3?pesta=4'</script>";
						}
						
						if($servidor=="zapallar"){
						echo "<script>window.location = 'http://200.29.22.36/admin/institucion/empleado/empleado.php3?pesta=4'</script>";
						}
						
						if($servidor=="murialdo"){
						echo "<script>window.location = 'http://190.162.116.194/admin/institucion/empleado/empleado.php3?pesta=4'</script>";
						}
					}
				}
			}
		}
	}
?> 