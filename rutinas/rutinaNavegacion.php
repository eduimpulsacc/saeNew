<?php 

//Rutina para actualizar tabla navegación

//$conn=@pg_connect("dbname=coi_final_vina host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
$conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");
//$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");  

$conexion=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_Usuario ");

	echo $sql_nave= 'SELECT * FROM navegacion';
	$nave_result = pg_Exec($conn, $sql_nave);

	$numNave = pg_num_rows($nave_result);

	for ($i=0; $i <$numNave ; $i++) { 
		$fila=pg_fetch_array($nave_result, $i);

		echo "<br>".$sql_usuario = "select id_perfil from accede
					join usuario on usuario.id_usuario = accede.id_usuario
						where usuario.nombre_usuario = '".$fila['rut_usuario'] ."' and accede.id_perfil in(15,16) and accede.rdb = ".$fila['rbd'];
		$nave_usuario_result = pg_Exec($conexion, $sql_usuario);

		$fila_usuario=pg_fetch_array($nave_usuario_result, 0);

		echo "<br>".$sql_update_nave = "UPDATE navegacion SET id_perfil = ".$fila_usuario['id_perfil']." where id_usuario = ".$fila['id_usuario'];

		$usuario_final = pg_Exec($conn, $sql_update_nave) or ('error al realizar actualizacion');
	}

echo "INGRESO CORRECTO";


 ?>