<? 

$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");	


$sql ="SELECT campo1 FROM temporal_dav";
$result = @pg_exec($conn,$sql);

for($i=0;$i<@pg_numrows($result);$i++){
	$fila = @pg_fetch_array($result,$i);
	
	echo "<br>".$sql ="UPDATE matricula SET alum_prio=1 WHERE id_ano=1624 AND rut_alumno=".$fila['campo1'];
	$rs_alumno = @pg_exec($conn,$sql);
	
}
echo "datos modificados";

?>