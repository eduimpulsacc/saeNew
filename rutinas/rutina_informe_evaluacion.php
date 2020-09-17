<? 

$conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

$conn2=pg_connect("dbname=corporacion2009 host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

echo $sql ="SELECT * FROM informe_plantilla WHERE rdb=1311 and id_plantilla=1104";
$rs_plantilla =pg_exec($conn2,$sql) or die(pg_last_error($sql));

for($i=0;$i<pg_numrows($rs_plantilla);$i++){ 
	$fila_p = pg_fetch_array($rs_plantilla,$i);
	
	echo "<br>".$sql = "INSERT INTO informe_plantilla (id_plantilla,rdb,nombre,tipo_ensenanza,fecha_creacion,pa,sa,ta,cu, qu,sx,sp,oc,activa,titulo_informe1,titulo_informe2,nuevo_sis) VALUES ('".$fila_p['id_plantilla']."', '".$fila_p['rdb']."', '".$fila_p['nombre']."', '".$fila_p['tipo_ensenanza']."', '".$fila_p['fecha_creacion']."', '".$fila_p['pa']."', '".$fila_p['sa']."', '".$fila_p['ta']."', '".$fila_p['cu']."', '".$fila_p['qu']."', '".$fila_p['sx']."', '".$fila_p['sp']."', '".$fila_p['oc']."', '".$fila_p['activa']."', '".$fila_p['titulo_informe1']."', '".$fila_p['titulo_informe2']."', '".$fila_p['nuevo_sis']."')";
	$rs_insert = pg_exec($conn,$sql) or die(pg_last_error($sql));
	
	$sql ="SELECT * FROM informe_evaluacion2 WHERE id_plantilla=".$fila_p['id_plantilla'];
	$rs_evaluacion = pg_exec($conn2,$sql);
	
	for($x=0;$x<pg_numrows($rs_evaluacion);$x++){
		$fila_e =pg_fetch_array($rs_evaluacion,$x);
		
		$sql = "INSERT INTO informe_evaluacion2 (id,id_ano,id_periodo,id_curso,id_plantilla,id_informe_area_item,respuesta,concepto,fecha,rut_alumno) VALUES('".$fila_e['id']."','".$fila_e['id_ano']."','".$fila_e['id_periodo']."','".$fila_e['id_curso']."','".$fila_e['id_plantilla']."','".$fila_e['id_informe_area_item']."','".$fila_e['respuesta']."','".$fila_e['concepto']."','".$fila_e['fecha']."','".$fila_e['rut_alumno']."')";	
		$result =pg_exec($conn,$sql);
	}
	
	
}
echo "PROCESO TERMINADO";

?> 