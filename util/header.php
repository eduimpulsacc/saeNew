<?	require_once('funciones_utiles.php');
	
	
	/*if($_INSTIT==24730 || $_INSTIT==22019 || $_INSTIT==11678 || $_INSTIT==253 || $_INSTIT==11678){
		echo "<script>window.location = 'http://www.colegiointeractivo.cl/sae3.0/session/finSession.php'</script></HEAD><BODY></BODY></HTML>";
		session_unset();
		session_destroy();
		exit;
	}*/

/////////////////
 //INICIO SESSION
/////////////////

 ///////////////////////////////
 //CONECCION A LA BASE DE DATOS
 /////////////////////////////

 if(!empty($_GET['_ID_BASE'])){
   $_SESSION['_ID_BASE'] = $_GET['_ID_BASE'];
   }
   
   
     $id_base = $_ID_BASE;
	 
	/* if($_PERFIL==15 || $_PERFIL==16){
		session_destroy(); 
	 }*/
 
@pg_close($connection);
 // Primero abrimos CONEXION en coi_usuario	
 $connection=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_Usuario ");
//	$connection=pg_connect("dbname=coi_usuario host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_Usuario ");

  if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	  $conn=pg_connect("dbname=coi_final_vina host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vina");	
	//$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi�a");	
	}

  if($id_base==3){
	$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Antofagasta.");	
	//$conn=pg_connect("dbname=coi_antofagasta host=190.196.32.148 port=5432 user=postgres password=300600") or die ("Error de conexion Antofagasta.");	
	 }
	 
  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";
	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");	*/
	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");
	 }


	//echo pg_dbname($conn);
	
	/******************* MODIFICACION DE PID DE POSTGRES ***************/
	if(isset($_PID)){
		
		$sql ="UPDATE control_users SET pid=".pg_get_pid($conn)." WHERE rdb_users=".$_INSTIT." and id_perfil=".$_PERFIL."  and pid=".$_PID;
		$result = @pg_exec($connection,$sql);
		
		$_PID = pg_get_pid($conn);
		session_register('_PID');
	}else{
		$_PID = pg_get_pid($conn);
		session_register('_PID');
		
		$hora = date("H:i:s");
		$fecha =date("m-d-Y");
		$sql="INSERT INTO control_users (rut_users,fecha,hora,ip_users,rdb_users,base_datos_users,pid,id_perfil) VALUES('$_NOMBREUSUARIO','$fecha','$hora','".$_SERVER['REMOTE_ADDR']."','$_INSTIT',$id_base,$_PID,$_PERFIL)";
		$result = pg_exec($connection,$sql) or die (pg_last_error($connection));
	}
	/***************** FIN *******************************************/
	
	//    LUEGO SACA ESTE IF DE ABAJO   //
	





?>


