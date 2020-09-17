<?php

//if(!define('APPLICATION',true)) exit; 
	
	session_start();
	
	$username_tomado104 = $_POST['nombre_usuario'];
	$password_espera104 = $_POST['password'];
    
	$chkform34rt = $_POST['Enviar'];
	
	function error($error) {
		echo "<html><title>ERROR</title></head>";
		echo "<body><center>";
		echo $error;
		echo "</center></body></html>";
	}
	

if($chkform34rt){

	 $connection=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion usuario");
	 
	



	
/* 	$conectores[] = array("coi_corporaciones","200.29.21.124","5432","postgres","cole#newaccess");
	$conectores[] = array("coi_final_vina","200.29.21.124","5432","postgres","cole#newaccess");
	$conectores[] = array("coi_antofagasta","200.29.70.184","5432","postgres","anto2010");*/

//$conectores[] = array("coi_final","192.168.100.203","5432","postgres","cole#newaccess");

//for($e=0;$e<=count($conectores);$e++){
    
	
	
	//$conn=pg_connect("dbname=$dbname host=$host port=$port user=$user password=$password") or die ("Error db Conector 2.");
	//$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");

	//$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");
	
	
	
	if (!$connection) {
	 error('<b>ERROR:</b>No se puede conectar a la base de datos.');
	 exit;
	}
		
	  $qry="SELECT id_usuario, pw FROM usuario 
	where nombre_usuario='".trim($username_tomado104)."'";
	$result = pg_Exec($connection,$qry) or die ("Error RTGF5656");;
	 $num_usu = @pg_numrows($result); 
	

	if (!$result){
	error("<script>window.location = 'msgError.php?caso=8'</script>");
	session_destroy();
	exit();
	}

	if($num_usu>0){  // usuario encontrado se comprueban permisos de acceso

	    $fila = @pg_fetch_array($result,0);	
		
		if (!$fila){
			
			error('<B> ERROR :</b>Error al acceder a la BD. (3)');
			exit();
			session_destroy();
			
			}else{
				if ($password_espera104==trim($fila["pw"])){
				
				session_name(pg_dbname($conn));
				$_SESSION['_CHK_ID'] = session_id();
				$_SESSION['NAME_CONN'] = pg_dbname($conn);
				$_SESSION['_USUARIO'] = trim($fila["id_usuario"]);
			    $_SESSION['_NOMBREUSUARIO'] = trim($username_tomado104);
					
				//ACCESOS HABILITADOS PARA EL USUARIO
/*				$qry="SELECT usuario.id_usuario,perfil.url, accede.rdb,accede.id_perfil,accede.estado 
						  FROM usuario 
						  INNER JOIN accede ON usuario.id_usuario = accede.id_usuario 
						  INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil 
						  INNER JOIN institucion ON institucion.
						  WHERE usuario.nombre_usuario='".trim($username_tomado104)."' AND accede.estado=1
						  AND ( perfil.id_perfil=15 or perfil.id_perfil=16) ";*/
						  
				     $qry="SELECT distinct(usuario.id_usuario),perfil.url,accede.rdb,
						accede.id_perfil,accede.estado,institucion.nombre_instit,
						institucion.telefono,institucion.email,
						institucion.saemovil, dbname,host,port,base_dato.user,base_dato.password
						FROM usuario 
						INNER JOIN accede ON usuario.id_usuario = accede.id_usuario 
						INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil 
						INNER JOIN institucion ON institucion.rdb = accede.rdb 
						INNER JOIN base_dato ON accede.id_base=base_dato.id_base
						WHERE usuario.nombre_usuario='".trim($username_tomado104)."' AND accede.estado=1
						AND (perfil.id_perfil=15 or perfil.id_perfil=16)";	
							  
						//exit;
				$result = pg_Exec($connection,$qry) or die( pg_last_error($conn) );
														
						if(!$result){
							error('<b>ERROR :</b>No se puede acceder a la base de datos(0).');
							session_destroy();
							exit();
						 }else{
							 if (pg_numrows($result)==1){
								 
								
								$fila = @pg_fetch_array($result,0);
								$dbname = trim($fila['dbname']);
								$host = trim($fila['host']);
								$port = trim($fila['port']);
								$user = trim($fila['user']);
								$password = trim($fila['password']);
								
								$conn=pg_connect("dbname=$dbname host=$host port=$port user=$user password=$password") or die ("Error 
de conexion Coi_final");	

								if($fila["saemovil"]==2){
																
								$_SESSION['_INSTIT_nombre']=$fila["nombre_instit"];
								$_SESSION['_INSTIT_telefono']=$fila["telefono"];
						        $_SESSION['_INSTIT_email']=$fila["email"];
						        $_SESSION['_INSTIT']=$fila["rdb"];
								$_SESSION['_URLBASE']=$fila["url"];
								$_SESSION['_PERFIL']=$fila["id_perfil"];	
								echo "<script>window.location = 'perfilausuario.php'</script>";
								exit();
							   
							   }else{
								   
								  //echo "Este Servicio no Esta Activo para esta Institucion";
								  session_destroy();
								  pg_close($conn);
								  echo "<script>
								  alert('Este Servicio no Esta Activo para esta Institucion');
								  window.location = '../index.php'</script>";
															   
								   }
							   
							   }else{
								   
								  echo "No Tiene Acceso";
								  session_destroy();
								  pg_close($conn);
								  echo "<script>
								  alert('Este Servicio no Esta Activo para esta Institucion');
								  window.location = '../index.php'</script>";
							   
							   }
						   }
		     }
		}
	 }	
 // }
  
  
  }else{
	  
	  session_destroy();
	  pg_close($conn);
	  echo "<script>window.location = 'index.php'</script>";
	  
	  } //fin  
  
?>
