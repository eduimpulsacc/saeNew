<? 
//base de datos antigua

$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
//if($conn)echo "conecte final";
//
////voy a buscar a los alumno 
$sql_a="select * from temporal_dav";
$rs_a = pg_exec($conn,$sql_a);

for($a=0;$a<pg_numrows($rs_a);$a++){
$fila = pg_fetch_array($rs_a,$a);
$rut = $fila['campo1'];
$fecha_nac = $fila['campo2'];
$region = $fila['campo3'];
$ciudad = $fila['campo4'];
$comuna = $fila['campo5'];
$direccion = $fila['campo6'];

//hago update
echo $sql_u = "update alumno set fecha_nac='$fecha_nac', region=$region, ciudad=$ciudad, comuna=$comuna, calle='$direccion' where rut_alumno=$rut";
echo "<br>";
$rs_u = pg_exec($conn,$sql_u);

}


?>
