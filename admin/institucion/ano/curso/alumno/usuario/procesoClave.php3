<?php require('../../../../../../util/header.inc'); ?>
<?php
	$alumno	=$_ALUMNO;
	$qry="SELECT * FROM USUARIO WHERE NOMBRE_USUARIO='".$alumno."'";
	$result =@pg_Exec($connection,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD.(1)');
	}else{
		if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
			$fila = @pg_fetch_array($result,0);	
			$usuario =trim($fila['id_usuario']);
			
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}else{
				if (strcmp(trim($fila['pw']),trim($txtPW1))){
					echo "<script>alert('Clave Actual No Corresponde. Digítela nuevamente')</script>";
					echo "<script>window.location = 'claveAcceso.php3'</script>";
				}else{
				
				///NUEVO CODIGO, CAMBIA CLAVE EN COI_VINA o Corporaciones SI ES QUE EXISTE //
					/*$conn_vina_aux=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión.");
					
					$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$result_vina_aux =@pg_Exec($conn_vina_aux,$qry_aux);
					
					
					$conn_corp_aux=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión.");
					
					$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$result_corp_aux =@pg_Exec($conn_corp_aux,$qry_aux);
					
					$conn_final=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j");
					
					$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$result_final_aux =@pg_Exec($conn_final,$qry_aux);

					$conn_anto=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j");
					
					$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$result_final_aux =@pg_Exec($conn_final,$qry_aux);*/
					
					/////// FIN NUEVO CODIGO
					
					$qry="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$result =@pg_Exec($connection,$qry);
					if (!$result){
						error('<b> ERROR :</b>Error al acceder a la BD.(3)');
					};
					echo "<script>alert('Clave Actual Modificada Exitosamente!!..')</script>";
					echo "<script>window.location = 'usuario.php3'</script>";
				}
			}
		}
	}
?> 