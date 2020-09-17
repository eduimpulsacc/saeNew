<? 

$conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");


$conn2=@pg_connect("dbname=murialdo host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");


$sql = "select * from alumno where rut_alumno in (select rut_alumno from matricula where rdb=14275)";
$rs_alumno = pg_exec($conn2,$sql);

for($i=0;$i<pg_numrows($rs_alumno);$i++){
	$fila = pg_fetch_array($rs_alumno,$i);
	$sql ="SELECT * FROM alumno WHERE rut_alumno=".$fila['rut_alumno'];
	$rs_existe= pg_exec($conn,$sql);
	
	if(pg_numrows($rs_existe)==0){
		echo "<br>".$sql ="INSERT INTO alumno (rut_alumno,dig_rut, nombre_alu, ape_pat, ape_mat, calle, nro, depto, block, villa, region, ciudad, comuna, telefono, sexo, email, fecha_nac, salud, religion) VALUES('".$fila['rut_alumno']."','".$fila['dig_rut']."','".$fila['nombre_alu']."','".$fila['ape_pat']."','".$fila['ape_mat']."','".$fila['calle']."','".$fila['nro']."','".$fila['depto']."','".$fila['block']."','".$fila['villa']."','".$fila['region']."','".$fila['ciudad']."','".$fila['comuna']."','".$fila['telefono']."','".$fila['sexo']."','".$fila['email']."','".$fila['fecha_nac']."','".$fila['salud']."','".$fila['religion']."')";
		$rs_insert = pg_exec($conn,$sql);
	}
}




