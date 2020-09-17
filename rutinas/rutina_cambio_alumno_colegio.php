<?
$conn=@pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("Error de conexión Antofagasta.");	
//$conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Corporacion.");
//$conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");



$sql="SELECT rut_alumno FROM promocion WHERE id_ano=1205 and situacion_final=1 and id_curso in (SELECT id_curso FROM curso WHERE id_ano=1205 AND ensenanza=110 AND grado_curso=8)";
$rs_alumno = pg_exec($conn,$sql) or die(pg_last_error($conn));

for($i=0;$i<pg_numrows($rs_alumno);$i++){
	$fila =pg_fetch_array($rs_alumno,$i);
	$sql="INSERT INTO matricula (rut_alumno,id_ano,rdb,id_curso,fecha,bool_ar) VALUES (".$fila['rut_alumno'].",1269,4655,21923,'01-03-2013',0)";
	$rs_matricula = pg_exec($conn,$sql) or die (pg_last_error($conn));
}

pg_close($conn);
?>






