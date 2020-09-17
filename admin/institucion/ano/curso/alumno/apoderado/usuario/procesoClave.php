<?php require('../../../../../../../util/header.inc'); ?>

<?php

	$usuario	=$_ID_USER;

		if ($_ID_USER==""){

	$usuario	=$_USUARIO;

		};

	$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;

	$result =@pg_Exec($conn,$qry);

	if (!$result) {

		error('<b> ERROR :</b>Error al acceder a la BD.(1)');

	}else{

		if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.

			$fila = @pg_fetch_array($result,0);	

			if (!$fila){

				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');

				exit();

			}else{

				if (strcmp(trim($fila['pw']),trim($txtPW1))){

					echo "<script>alert('Clave actual no corresponde.')</script>";

					echo "<script>window.location = 'claveAcceso.php'</script>";

				}else{

					$qry="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;

					$result =@pg_Exec($conn,$qry);

					if (!$result){

						error('<b> ERROR :</b>Error al acceder a la BD.(3)');

					};

					echo "<script>alert('Clave actual modificada exitosamente..')</script>";

					if ($_PERFIL!=15){

					echo "<script>window.location = 'usuario.php'</script>";

					}else{		

					echo "<script>window.location = 'claveAcceso.php'</script>";

				    }

				}

			}

		}

	}

?> 