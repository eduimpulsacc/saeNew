<?php require('../../../../../../../util/header.inc'); ?>
<?php

	$usuario	=$_ID_USER;
		if ($_ID_USER==""){
	$usuario	=$_USUARIO;
		};
	echo $qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
	$result =@pg_Exec($connection,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD.(1)');
	}else{
		if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
			$fila = @pg_fetch_array($result,0);	
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}else{
				
				if(strcmp(trim($fila['pw']),trim($txtPW1))){
					echo "<script>alert('Clave actual no corresponde.')</script>";
					echo "<script>window.location = 'claveAcceso.php3'</script>";
				}else{
				
				///NUEVO CODIGO, CAMBIA CLAVE EN COI_VINA o Corporaciones SI ES QUE EXISTE //
					/*$conn_vina_aux=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres 
					password=cole#newaccess") or die ("Error de conexión.");
					
					$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$result_vina_aux =@pg_Exec($conn_vina_aux,$qry_aux);
					
					$conn_corp_aux=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres 
					password=cole#newaccess") or die ("Error de conexión.");
					
					$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$result_corp_aux =@pg_Exec($conn_corp_aux,$qry_aux);
					
					$conn_final=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres 
					password=cole#newaccess");
					
					$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$result_final_aux =@pg_Exec($conn_final,$qry_aux);*/
					
					/////// FIN NUEVO CODIGO
					$qry="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$result =@pg_Exec($connection,$qry);
					if (!$result){
						error('<b> ERROR :</b>Error al acceder a la BD.(3)');
					};
					echo "<script>alert('Clave actual modificada exitosamente..')</script>";
					if ($_PERFIL!=15){
					echo "<script>window.location = 'usuario.php3'</script>";
					}
					else
					{		
					echo "<script>window.location = 'claveAcceso.php3'</script>";
				    }
				}
			}
		}
	}
?> 