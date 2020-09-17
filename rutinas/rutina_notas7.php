<?
 $conn=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Viña.");


$sql ="select * from notas2010 where id_ramo=321079";
$rs_origen = @pg_exec($conn,$sql);

for($i=0;$i<@pg_numrows($rs_origen);$i++){
	$fila = @pg_fetch_array($rs_origen,$i);
	echo "<br>".$sql ="UPDATE notas2010 SET nota10='".trim($fila['nota1'])."',nota11='".trim($fila['nota2'])."',nota12='".trim($fila['nota3'])."',nota13='".trim($fila['nota4'])."',nota14='".trim($fila['nota5'])."',nota15='".trim($fila['nota6'])."',nota16='".trim($fila['nota7'])."',nota17='".trim($fila['nota8'])."',nota18='".trim($fila['nota9'])."' WHERE id_periodo=".trim($fila['id_periodo'])." AND rut_alumno='".trim($fila['rut_alumno'])."' and id_ramo=301410";
	$rs_destino = @pg_exec($conn,$sql) or die("UPDATE FALLO :".$sql);
}




?>
