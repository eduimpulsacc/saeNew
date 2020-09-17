<?

$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi?a");     
//$conn=@pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("Error de conexión Antofagasta.");	
//$conn1=pg_connect("dbname=respaldo_corporacion host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Corporacion.");
//$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");


/*$sql="select * from alumno a INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno WHERE id_ano=1222";
$rs_alumno = pg_exec($conn1,$sql);

for($i=0;$i<pg_numrows($rs_alumno);$i++){
	$fila = pg_fetch_array($rs_alumno,$i);
	
	echo "<br>".$sql="UPDATE alumno SET calle='".$fila['calle']."',nro='".$fila['nro']."',depto='".$fila['depto']."',block='".$fila['block']."', villa='".$fila['villa']."', telefono='".$fila['telefono']."', email='".$fila['email']."' WHERE rut_alumno=".$fila['rut_alumno'];
	$rs_modificacion=pg_exec($conn,$sql);
	
}

echo "<br>cantidad modificados".$i;*/



$sql="SELECT * FROM temporal_dav";
$rs_temporal = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_temporal);$i++){
	$fila = pg_fetch_array($rs_temporal,$i);
	
	echo "<br>".$sql="UPDATE alumno SET calle='".$fila['campo2']."' WHERE rut_alumno ='".$fila['campo1']."'";
	$rs_alumno = pg_exec($conn,$sql);
		//, nro='".$fila['campo3']."',depto='".$fila['campo4']."', block='-', villa='".$fila['campo5']."', region='".$fila['campo6']."',ciudad='".$fila['campo7']."', comuna='".$fila['campo8']."'
}

echo "PROCESO TERMINADO"; 
pg_close($conn);
?>






