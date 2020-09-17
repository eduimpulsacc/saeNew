<?
$conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");


$sql = "select campo1, campo2, campo3 from temporal_dav group by campo1, campo2, campo3 ";
$res = pg_Exec($conn, $sql);
$num = pg_numrows($res);

for ($i = 0; $i < $num; $i++){
    $fil = pg_fetch_array($res,$i);
	
	$rut_alumno   = $fil['campo1'];
	$id_ramo      = $fil['campo2'];
	$id_curso     = $fil['campo3'];
	
	// insertamos en tiene2007
	
	$sql_insert = "insert into tiene2007 (rut_alumno, id_ramo, id_curso) values ('".trim($rut_alumno)."','$id_ramo','$id_curso')";
	$res_insert = pg_Exec($conn, $sql_insert);
	

}

echo "Fin proceso 2007 ....  <br>";

?>