<? 


$conn=@pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");
$conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//$conn2=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña."); 


$sql="SELECT * FROM sigla_subsectoraprendizaje WHERE rdb=1598";
$rs_sigla = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_sigla);$i++){
	$fila = pg_fetch_array($rs_sigla,$i);
	
	$sql="INSERT INTO sigla_subsectoraprendizaje (rdb,sigla,detalle) VALUES (1598,'".$fila['sigla']."','".$fila['detalle']."')";
	$rs_sub = pg_exec($conn2,$sql);
}

$sql="SELECT * FROM tipos_anotacion WHERE rdb=1598";
$result = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($result);$i++){
	$fila = pg_fetch_array($result,$i);
	
	$sql="INSERT INTO tipos_anotacion (rdb, descripcion, cod_tipo, tipo) VALUES (1598,'".$fila['decripcion']."', '".$fila['cod_tipo']."', ".$fila['tipo'].")";
	$rs_tipo = pg_exec($conn2,$sql);
	
	
	$sql="SELECT max(id_tipo) FROM tipos_anotacion";
	$rs_max =pg_exec($conn2,$sql);
	$id_tipo = pg_result($rs_max,0);
	
	$sql="SELECT * FROM detalle_anotaciones WHERE id_tipo=".$fila['id_tipo'];
	$rs_detalle = pg_exec($conn,$sql);
	
	for($j=0;$j<pg_numrows($rs_detalle);$j++){
		$fils = pg_fetch_array($rs_detalle,$j);
		
		$sql="INSERT INTO detalle_anotaciones (id_tipo, codigo, detalle) VALUES (".$id_tipo.",'".$fils['codigo']."','".$fils['detalle']."')";
		$rs_detalle2 = pg_exec($conn2,$sql);
			
		
	}
	
	
		
		
}


echo "<br>fin proceso";

?>







