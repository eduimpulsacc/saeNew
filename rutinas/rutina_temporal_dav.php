<? 

$conn_origen=@pg_connect("dbname=coi_final host=190.196.32.147 port=1550 user=postgres password=300600") or die ("No pude conectar a la base de datos destino");

$conn_destino=@pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("No pude conectar a la base de datos destino");

//$conn_origen=@pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("No pude conectar a la base de datos destino");


$sql ="SELECT * FROM temporal_dav";
$rs_origen= pg_exec($conn_origen,$sql);


for($i=0;$i<pg_numrows($rs_origen);$i++){
	$fila = pg_fetch_array($rs_origen,$i);
	
	$sql ="INSERT INTO temporal_dav (campo1,campo2,campo3,campo4,campo5,campo6,campo7,campo8,campo9,campo10,campo11,campo12,campo13,campo14,campo15,campo16,campo17)VALUES ('".$fila['campo1']."','".$fila['campo2']."','".$fila['campo3']."','".$fila['campo4']."','".$fila['campo5']."','".$fila['campo6']."','".$fila['campo7']."','".$fila['campo8']."','".$fila['campo9']."','".$fila['campo10']."','".$fila['campo11']."','".$fila['campo12']."','".$fila['campo13']."','".$fila['campo14']."','".$fila['campo15']."','".$fila['campo16']."','".$fila['campo17']."')";
	$rs_vina = pg_exec($conn_destino,$sql);
	
	
}
$sql ="SELECT count(*) FROM temporal_dav";
$rs_cantidad = pg_exec($conn_destino,$sql);
$cantidad = pg_result($rs_cantidad,0);

echo "CANTIDAD REGISTRO DESTINO -->".pg_numrows($rs_anto);
echo "<br> CANTIDAD REGISTRO ORIGEN --->".$cantidad;

?>