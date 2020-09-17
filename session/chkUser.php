<?php


  session_start();
  session_destroy();
  session_start();
  


  	/*if($txtNOMBRE=="" or $txtPW==""){
		error("<script>window.location='msgError.php?caso=8'</script>");
		//header('Location: '.$_SERVER["HTTP_REFERER"].'');  //CODIGO ELIMINADO 02-09-2013 E.ROJAS
	}*/

	function error($error) {
	echo "<html><title>ERROR</title></head>";
	echo "<body><center>";
	echo $error;
	echo "</center></body></html>";
	}


	
	//$conn=@pg_connect("dbname=coi_usuario host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j");
	$conn=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j");


/*$sql="SELECT * FROM USUARIO WHERE NOMBRE_USUARIO='admin'";
$rs_usuario = pg_exec($conn,$sql) or die($sql);
echo pg_result($rs_usuario,0);*/

	if (!$conn){
	  error('<b>ERROR:</b>No se puede conectar a la base de datos.(12)');
	  exit;
	}

	// CHEQUEA SI EXISTE EL USUARIO
	$qry="SELECT id_usuario,pw FROM usuario where nombre_usuario='".trim($txtNOMBRE)."'";
	$result = pg_Exec($conn,$qry);
    $num_usu = @pg_numrows($result); 
	
	if (!$result){
		error("<script>window.location='msgError.php?caso=8'</script>");
		session_destroy();
		
	}else{
		if($txtNOMBRE=="130488668"){
				echo "dentro else";	
			}
		if($num_usu > 0){
			$fila = @pg_fetch_array($result,0);	
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (4)');
				exit();
				session_destroy();
			}else{
				
				if($txtPW==trim($fila["pw"])){

					session_name("session_coe");
					
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

					$qry = " SELECT * ";
					$qry = $qry ." FROM ACCEDE ";
					$qry = $qry ." inner join perfil on accede.id_perfil=perfil.id_perfil ";
					$qry = $qry ." WHERE accede.ID_USUARIO=".trim($_USUARIO)." AND accede.estado=1 ";
					$qry = $qry ." and perfil.id_perfil<>3 and perfil.id_perfil<>4 ";
					$qry = $qry ." and perfil.id_perfil<>5 and perfil.id_perfil<>7 ";
					$result = @pg_Exec($conn,$qry);
					$fila = pg_fetch_array($result);
					
					/*if($fila['id_perfil']==15 || $fila['id_perfil']==16){
						session_destroy();
						echo "<script>window.location='http://www.colegiointeractivo.com'</script>";	
					}
					*/
					
					/*$sql="select DISTINCT rdb
						FROM corp_instit 
						WHERE num_corp in(1,22,23,24,25,26,27,28,30,31,32) and rdb=".$fila['rdb'];
					$rs_corte = pg_exec($conn,$sql);
					if(pg_numrows($rs_corte)!=0){
						session_destroy();
						//$aviso=htmlentities( "",ENT_QUOTES,'UTF-8');
						echo "<script>alert('Estimado usuario, lamentamos que no pueda acceder al sistema de gestion escolar, pero la Corporacion Municipal de Vina del Mar nos debe el pago de nuestro servicio por todo el ano 2016 y parte del ano 2015.La gerencia general de Colegio Interactivo en conjunto con su directorio, ha hecho variadas gestiones para poder solucionar esta situacion, sin embargo a la fecha no existe ninguna respuesta concreta, por lo cual se ha determinado realizar el corte del servicio, lamentando todas las molestias que esto pueda causar.Esperamos solucionar prontamente la situacion con la Corporacion Municipal de Vina del Mar a favor de todos ustedes.Atentamente,Gerencia General.');</script>";
						echo "<script>window.location = 'http://www.colegiointeractivo.com'</script>";	
					}*/
					if(!$result){
						error('<b>ERROR :</b>No se puede acceder a la base de datos.');
						session_destroy();
						exit();
					}else{

						if (pg_num_rows($result)!=0){
							
							echo"<script>window.location = 'perfilaUsuario.php'</script>";
						
						}else{
						
							if($_USUARIO==1){//EN CASO DE SER ADMINISTRADOR GRAL COE
								echo "<script>window.location = 'perfilaUsuario.php'</script>";
								pg_close($conn);
							}else{
								echo "<script>window.location = 'msgError.php?caso=1'</script>";
								pg_close($conn);
								exit();
							}
						}
					}
				}else{
				   if (trim($fila["id_usuario"])==1){
					    
				      echo "<script>window.location = 'msgError.php?caso=1'</script>";
				   
				   }else{
					  
					 echo "<script>window.location = 'msgError.php?caso=2'</script>";
					 
					 exit();
					
					}
				}
			}
			
			
		}else{
			echo "<script>window.location = 'msgError.php?caso=9'</script>";
		}
		
	}
		
		pg_close($conn);
		?>
