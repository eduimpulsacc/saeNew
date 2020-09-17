<?php require('../../../../util/header.inc'); ?>
<?php
	$usuario	=$_ID_USER;
//	$empleado	=$_EMPLEADO;
	if($_PERFIL==0 || $_PERFIL==14){
		$empleado		=$empleados;	
	}
	else{
		$empleado		=$_EMPLEADO;
	}

		
	/*if($usuario!=''){
		$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
		$nombre_usuario=$_NOMBREUSUARIO;
	}else{*/
		$qry="SELECT * FROM USUARIO WHERE nombre_usuario='".$empleado."'";
		$nombre_usuario=$empleado;
		
	//}
	
	
	$result =@pg_Exec($connection,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD.(1) o BD.(soporte)');
	}else{
		if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
			$fila = @pg_fetch_array($result,0);	
			if($usuario==''){
				$usuario =trim($fila['id_usuario']);
			}
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}else{
				if (strcmp(trim($fila['pw']),trim($txtPW1))){
					echo "<script>alert('Clave actual no corresponde.')</script>";
					echo "<script>window.location = 'claveAcceso.php3'</script>";
				}else{
					$qry="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE NOMBRE_USUARIO='".$nombre_usuario."'";
					$result =@pg_Exec($connection,$qry);
				
					
					///NUEVO CODIGO, CAMBIA CLAVE EN COI_VINA o Corporaciones SI ES QUE EXISTE //
					$conn_vina_aux=pg_connect("dbname=coi_final_vina host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión.");
					$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE NOMBRE_USUARIO='".$nombre_usuario."'";
					$result_vina_aux =@pg_Exec($conn_vina_aux,$qry_aux);
					
					
					$conn_corp_aux=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión.");
					
					$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE NOMBRE_USUARIO='".$nombre_usuario."'";
					$result_corp_aux =@pg_Exec($conn_corp_aux,$qry_aux);
					
					$conn_final=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j");
					
					//$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE NOMBRE_USUARIO='".$nombre_usuario."'";
					$result_final_aux =@pg_Exec($conn_final,$qry_aux);
					
					/////// FIN NUEVO CODIGO
					
					
					
					
					
					
			//**************ACTUALIZA EN BD. SOPORTE ************//		
			
					  $qry_sop="SELECT * FROM USUARIO WHERE nombre_usuario='".$empleado."'";
					 $result_sop =@pg_Exec($conn2,$qry_sop); 
					
					if (@pg_numrows($result_sop)!=0){
						$fila_sop = @pg_fetch_array($result_sop,0);	
					$qry="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO_ORIGEN=".$usuario." AND NOMBRE_USUARIO=".$empleado."";
						#se quito este trozo a la qry (AND ID_USUARIO='".$fila_sop['id_usuario']."')
						
						
						$result_sop =@pg_Exec($conn2,$qry);
						
						if (!$result_sop){
						error('<b> ERROR :</b>Error al acceder a la BD.(soporte)');
					    };
						
						}
						
			//****************************************************//			
					if (!$result){
						error('<b> ERROR :</b>Error al acceder a la BD.(3)');
					};
					
						echo "<script>alert('Clave actual modificada exitosamente..')</script>";
					if($_PERFIL==0 || $_PERFIL==14){
						echo "<script>window.location = '../claves.php3'</script>";
					}
					else{
						echo "<script>window.location = 'usuario_cambio_clave.php?pesta=4'</script>";
					}
				}
			}
		}
	}
?> 