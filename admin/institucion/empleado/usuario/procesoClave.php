<?php require('../../../../util/header.inc');

	$usuario	=$_ID_USER;
//	$empleado	=$_EMPLEADO;
	
	$empleado		=$_EMPLEADO;

	$conn_vina_aux=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");	
	$conn_corp_aux=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");
	
	
		
	if($usuario!=''){
		echo $qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
	}else{
		echo $qry="SELECT * FROM USUARIO WHERE nombre_usuario='$_NOMBREUSUARIO'";
	}
	exit;
	$result =@pg_Exec($conn,$qry);

	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD.(1)');
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
					echo "<script>window.location = 'claveAcceso.php?cram=1&modoseguro=1'</script>";
				}
				else{
				
				///NUEVO CODIGO, CAMBIA CLAVE EN COI_VINA o Corporaciones SI ES QUE EXISTE //
					
					
					$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE NOMBRE_USUARIO='$_NOMBREUSUARIO'";
					$qry_122="UPDATE USUARIO SET IP_CON='$ip2' WHERE ID_USUARIO=".$usuario;
					$result_vina_aux =@pg_Exec($conn_vina_aux,$qry_aux);
					$result_1 =pg_Exec($conn_vina_aux,$qry_122);

					
					
					
					$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$qry_122="UPDATE USUARIO SET IP_CON='$ip2' WHERE ID_USUARIO=".$usuario;
					$result_corp_aux =@pg_Exec($conn_corp_aux,$qry_aux);
					$result_1 =pg_Exec($conn_corp_aux,$qry_122);
					
					$conn_final=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");
					
					/*echo "<br>final-->".$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$qry_122="UPDATE USUARIO SET IP_CON='$ip2' WHERE ID_USUARIO=".$usuario;
					$result_final_aux =@pg_Exec($conn_final,$qry_aux);
					$result_1 =pg_Exec($conn_final,$qry_122);*/
					
					/////// FIN NUEVO CODIGO
					/*$qry="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$qry_122="UPDATE USUARIO SET IP_CON='$ip2' WHERE ID_USUARIO=".$usuario;
					
					$result =pg_Exec($conn,$qry);
			   	    $result_1 =pg_Exec($conn,$qry_122);
					if (!$result){
						error('<b> ERROR :</b>Error al acceder a la BD.(3)');
					};*/
					echo "<script>alert('Clave actual modificada exitosamente..')</script>";
					if($_PERFIL==0 || $_PERFIL==14){
						echo "<script>window.location = '../../../../session/perfilaUsuario.php'</script>";
					}
					else{
						echo "<script>window.location = '../../../../session/perfilaUsuario.php'</script>";
					}
				}
			}
		}else{
			$qry="SELECT * FROM USUARIO WHERE nombre_usuario='$_NOMBREUSUARIO'";
			$rs_usuario =@pg_Exec($conn_vina_aux,$qry);
			
			if(@pg_numrows($rs_usuario)!=0){
				$fila = @pg_fetch_array($rs_usuario,0);
				$id_usuario = $fila['id_usuario'];
				$sql = "SELECT * FROM accede WHERE id_usuario=".$id_usuario;
				$rs_usuario_final = @pg_exec($conn_vina_aux,$sql);
				$fila_accede = @pg_fetch_array($rs_usuario_final,0);
				
				$sql ="SELECT MAX(id_usuario) FROM usuario";
				$rs_max= @pg_exec($conn,$sql);
				$maximo = @pg_result($rs_max) + 1;
				
				$sql = "INSERT INTO usuario (id_usuario,nombre_usuario,pw) VALUES(".$maximo.",'".$fila['nombre_usuario']."',".$txtPW2.")";
				$rs_insert = @pg_exec($conn,$sql);
				
				$sql = "INSERT INTO accede (id_usuario,id_perfil,rdb,estado) VALUES (".$maximo.",".$fila_accede['id_perfil'].",".$fila_accede['rdb'].",1)";
				$rs_accede = @pg_exec($conn,$sql);
				
				$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE NOMBRE_USUARIO='$_NOMBREUSUARIO'";
				$qry_122="UPDATE USUARIO SET IP_CON='$ip2' WHERE ID_USUARIO=".$usuario;
				$result_vina_aux =@pg_Exec($conn_vina_aux,$qry_aux);
				$result_1 =pg_Exec($conn_vina_aux,$qry_122);

			}else{
				$qry="SELECT * FROM USUARIO WHERE nombre_usuario='$_NOMBREUSUARIO'";
				$rs_usuario =@pg_Exec($conn_corp_aux,$qry);
				
				if(@pg_numrows($rs_usuario)!=0){
					$fila = @pg_fetch_array($rs_usuario,0);
					$id_usuario = $fila['id_usuario'];
					$sql = "SELECT * FROM accede WHERE id_usuario=".$id_usuario;
					$rs_usuario_final = @pg_exec($conn_corp_aux,$sql);
					$fila_accede = @pg_fetch_array($rs_usuario_final,0);
					
					$sql ="SELECT MAX(id_usuario) FROM usuario";
					$rs_max= @pg_exec($conn,$sql);
					$maximo = @pg_result($rs_max) + 1;
					
					$sql = "INSERT INTO usuario (id_usuario,nombre_usuario,pw) VALUES(".$maximo.",'".$fila['nombre_usuario']."',".$txtPW2.")";
					$rs_insert = @pg_exec($conn,$sql);
					
					$sql = "INSERT INTO accede (id_usuario,id_perfil,rdb,estado) VALUES (".$maximo.",".$fila_accede['id_perfil'].",".$fila_accede['rdb'].",1)";
					$rs_accede = @pg_exec($conn,$sql);
					
					$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$qry_122="UPDATE USUARIO SET IP_CON='$ip2' WHERE ID_USUARIO=".$usuario;
					$result_corp_aux =@pg_Exec($conn_corp_aux,$qry_aux);
					$result_1 =pg_Exec($conn_corp_aux,$qry_122);
				}
			}
					echo "<script>alert('Clave actual modificada exitosamente..')</script>";
					if($_PERFIL==0 || $_PERFIL==14){
						echo "<script>window.location = '../../../../session/perfilaUsuario.php'</script>";
					}
					else{
						echo "<script>window.location = '../../../../session/perfilaUsuario.php'</script>";
					}
		}
	}
?> 