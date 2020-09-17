<? 
$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final");

$sql="SELECT * FROM temporal_dav";
$result = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($result);$i++){
	$fila=pg_fetch_array($result,$i);

	$sql="DELETE FROM trabaja WHERE rut_emp=".$fila['campo1']." AND rdb=22559";
	$rs_delete = pg_exec($conn,$sql);

	$sql="INSERT INTO trabaja (rdb,rut_emp,cargo) VALUES (31392,".$fila['campo1'].",5)";
	$rs_insert= pg_exec($conn,$sql);

}
																									
echo "FIN PROCESO";

?>
