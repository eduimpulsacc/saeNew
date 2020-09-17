<?php
	echo time();echo " ";
        session_start();
  	echo time();echo " ";
        session_destroy();
	echo time();echo " ";
        session_start();echo " ";
        $txtNOMBRE='13658172';
	$txtPW='121212';
	echo time();
	$conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgresi password=cole#newaccess");

	
	if (!$conn) {
	 error('<b>ERROR:</b>No se puede conectar a la base de datos.(1)');
	 exit;
	}

	function error($error) {
		echo "<html><title>ERROR</title></head>";
		echo "<body><center>";
		echo $error;
		echo "</center></body></html>";
	}
	//CHEQUEA SI EXISTE EL USUARIO
	$qry="SELECT * FROM usuario where nombre_usuario='".trim($txtNOMBRE)."'";
	$result = @pg_Exec($conn,$qry);


	if (!$result){
		error("<script>window.location = 'msgError.php?caso=8'</script>");
		session_destroy();
		exit();
	}else{
		if (pg_numrows($result)!=0){
			$fila = @pg_fetch_array($result,0);	
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (3)');
				exit();
				session_destroy();
			}else{
				if ($txtPW==trim($fila["pw"])){
					session_name("session_coe");
				        echo date();
					$_CHK_ID=session_id();
					session_register('_CHK_ID');

					$_USUARIO=trim($fila["id_usuario"]);
					session_register('_USUARIO');

					$_NOMBREUSUARIO=$txtNOMBRE;
					session_register('_NOMBREUSUARIO');
					
					$_NOMBREUSUARIO2=$txtNOMBRE;
					session_register('_NOMBREUSUARIO2');
					
					global $REMOTE_ADDR;
					$remoteipcon = $_SERVER ['REMOTE_ADDR']; 
					
					
					//setlocale ("LC_TIME", "es_ES"); 
					$fecha = (strftime("%d/%m/%Y")); 
					$hora  = (strftime("%H:%M:%S"));
					$qryI="insert into control(usuario,dia,hora,ip_conex)values ('".trim($txtNOMBRE)."',to_date ('".$fecha."' , 'DD MM YYYY'),'".$hora."','$remoteipcon')";
				
					$resultI = pg_Exec($conn,$qryI);
					

					//PERFILES DE ACCESO HABILITADOS PARA EL USUARIO
//					$qry="SELECT * FROM ACCEDE WHERE ID_USUARIO=".$_USUARIO." AND ESTADO=1";
					$qry = " SELECT * ";
					$qry = $qry ." FROM ACCEDE ";
					$qry = $qry ." inner join perfil on accede.id_perfil=perfil.id_perfil ";
					$qry = $qry ." WHERE accede.ID_USUARIO=".trim($_USUARIO)." AND accede.ESTADO=1 ";
					$qry = $qry ." and perfil.id_perfil<>3 and perfil.id_perfil<>4 ";
					$qry = $qry ." and perfil.id_perfil<>5 and perfil.id_perfil<>7 ";
					$qry = $qry ." and perfil.id_perfil<>22 ";


					$result = @pg_Exec($conn,$qry);
					$fila = pg_fetch_array($result);					
					if(!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.');
						session_destroy();
						exit();
					}else{
/*						if(($fila["rdb"] == 25478) OR ($fila["rdb"] == 24977))
						{
						//echo "<script>window.location.target = 'perfilaUsuario.php3',_blank'</script>";
						}else{	*/
						if (pg_numrows($result)!=0){
						//Obligo al cambio de una clave Logica
						
				 	       $cristian = substr($txtNOMBRE,0,5);
						   $cristian2 = substr($txtNOMBRE,0,4);
						   if ($txtPW==$cristian or  $txtPW==$cristian2 or $txtPW==11111 or $txtPW==1 or $txtPW==1212){ echo "<script>window.location = '../admin/institucion/empleado/usuario/claveAcceso.php?cram=1&modoseguro=1'</script>";}
						
							//El permiso de acceso que tiene el usuario esta dado por el perfil que le corresponde.
							//si tiene mas de un perfil debe ser direccionado a una pantalla de  seleccion de "perfil/institucion"
						   //	echo "<script>window.location = 'perfilaUsuario.php'</script>";
						}else{
							if($_USUARIO==1){//EN CASO DE SER ADMINISTRADOR GRAL COE
								//echo "<script>window.location = 'perfilaUsuario.php'</script>";
								pg_close($conn);
							}else{
								//echo "<script>window.location = 'msgError.php?caso=1'</script>";
								pg_close($conn);
								exit();
							}
//						}
						}
					}
				}
				else{
				if (trim($fila["id_usuario"])==1){ 
				
				echo "<script>window.location = 'msgError.php?caso=1'</script>";
				      }
				else {
				
					echo "<script>window.location = 'msgError.php?caso=2'</script>";
					exit();
					}
				}
			}
		}else{
			echo "<script>window.location = 'msgError.php?caso=3'</script>";
			exit();
		}
	}
?>
