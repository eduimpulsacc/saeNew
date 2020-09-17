<? 
$conn1=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos origen");

$conn2=@pg_connect("dbname=murialdo host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino 1");


$sql ="select * from anotacion where tipo=2 and id_periodo =1621";
$rs_atrasos_m = pg_exec($conn2,$sql) or die(pg_last_error($conn2));

for($i=0;$i<pg_numrows($rs_atrasos_m);$i++){
	$fila =pg_fetch_array($rs_atrasos_m,$i);
	 
	if($fila['hora']=='') $hora=NULL;
	if($fila['causal']=='') $causal=NULL;
	if($fila['tratamiento']=='') $tratamiento=NULL;
	if($fila['tipo_conducta']=='') $tipo_conducta=NULL;
	if($fila['codigo_anotacion']=='') $codigo_anotacion=NULL;
	if($fila['codigo_tipo_anotacion']=='') $codigo_tipo_anotacion=NULL;
	if($fila['sigla']=='') $sigla=NULL;
	if($fila['tipo_responsable']=='') $tipo_responsable=NULL;
	
	echo "<br>".$sql ="INSERT INTO anotacion (tipo,fecha,observacion,rut_alumno,rut_emp, id_periodo,rdb) VALUES(".$fila['tipo'].", '".$fila['fecha']."', '".$fila['observacion']."', '".$fila['rut_alumno']."', '".$fila['rut_emp']."',2563,1604)";
	$rs_anotacion_c = pg_exec($conn1,$sql) or die(pg_last_error($conn1));
		
}
echo "<BR><BR>FIN PROCESO";
pg_close($conn1);
pg_close($conn2);
?>