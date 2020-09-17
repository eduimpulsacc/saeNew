<? 
$conn=@pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");
//$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");   


$sql="SELECT id_curso FROM curso WHERE id_ano=1550"; //and id_curso<>27748
$rs_curso = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_curso);$i++){
	$fila_curso = pg_fetch_array($rs_curso,$i);
	
	$sql="SELECT id_ramo FROM ramo WHERE id_curso=".$fila_curso['id_curso'];
	$rs_ramo = pg_exec($conn,$sql);
	
	for($j=0;$j<pg_numrows($rs_ramo);$j++){
		$fila_ramo = pg_fetch_array($rs_ramo,$j);
		
		$sql="SELECT rut_emp FROM dicta WHERE id_ramo=".$fila_ramo['id_ramo'];
		$rs_dicta = pg_exec($conn,$sql);
		$rut_emp = pg_result($rs_dicta,0);
		
		echo "<br>".$sql="INSERT INTO plani_archivos (rut_emp, id_ramo, id_curso, fecha, ruta_archivo, observ)
			  VALUES (".$rut_emp.", ".$fila_ramo['id_ramo'].", ".$fila_curso['id_curso'].", '2015-04-23', 'Planificacion Anual.doc', 'Cambiar nombre de archivo, una vez modificado')";
		$rs_insert= pg_exec($conn,$sql);
	
	}
}

echo "PROCESO TERMINADO";
?>







