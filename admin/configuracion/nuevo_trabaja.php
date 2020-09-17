<?php require('../../util/header.inc');








/////////////////////////TABLA TRABAJA/////////////////////////////////////////////////////////
	$conn2=pg_connect("dbname=soporte host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");
	
	if(!$conn2){
		if($_PERFIL==0){
		echo "No se puede conectar a la base de datos.";
		//error('<b>ERROR:</b>No se puede conectar a la base de datos.');
		}
	}

/*
	$sql = "SELECT rdb, rut_emp, fecha_ingreso, fecha_retiro, cargo, identificador FROM trabaja ";
		$resp 	= pg_exec($conn,$sql);
		$num 	= pg_numrows($resp);
		for ($i=0;$i<$num;$i++){
			$fila=pg_fetch_array($resp,$i);
			 echo "<br />".$sql_ex ="SELECT rut_emp FROM trabaja WHERE rut_emp =".$fila['rut_emp']." AND cargo=".$fila['cargo']." AND rdb=".$fila['rdb'];			 
			 $resp_2 = pg_exec($conn2,$sql_ex);
			 $num_2 = pg_numrows($resp_2);
			 if($num_2<1){
			 	$sql_insert = "INSERT INTO trabaja (rdb, rut_emp,cargo) ";
				$sql_insert.= "VALUES (".$fila['rdb'].",".$fila['rut_emp'].",".$fila['cargo'].")";
				echo "<br />".$sql_insert;
				$resp_insert = pg_exec($conn2,$sql_insert);
			 }
		
		}*/
/////////////////////////////FIN TABLA TRABAJA///////////////////////////////////////////////////////		

	
	
	$sql = "SELECT * FROM usuario";
	$resp = pg_exec($conn,$sql);
	$num = pg_numrows($resp);
	for ($i=0;$i<$num;$i++){
		$fila = pg_fetch_array($resp,$i);
			 echo "<br />".$sql_ex = "SELECT * FROM usuario WHERE id_usuario=".$fila['id_usuario']." AND nombre_usuario='".$fila['nombre_usuario']."' AND pw='".$fila['pw']."'";
		 $resp_2 = pg_exec($conn2,$sql_ex);
			 $num_2 = pg_numrows($resp_2);
			 if($num_2<1){
			 	$sql_insert = "INSERT INTO usuario (id_usuario,nombre_usuario,pw,ip_con) ";
				$sql_insert.= "VALUES (".$fila['id_usuario'].",'".$fila['nombre_usuario']."','".$fila['pw']."','".$fila['ip_con']."')";
				echo "<br />".$sql_insert;
				$resp_insert = pg_exec($conn2,$sql_insert);
			 }	
	} 


?>