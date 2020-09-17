<? $conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");
$cont=0;

$sql ="SELECT alumno.ape_pat,alumno.ape_mat, alumno.nombre_alu, alumno.rut_alumno FROM matricula INNER JOIN alumno ON matricula.rut_alumno=alumno.rut_alumno WHERE id_ano=1239";
$result = @pg_exec($conn,$sql);

for($i=0;$i<@pg_numrows($result);$i++){
	$fila = @pg_fetch_array($result,$i);
	$nombre = ucfirst(strtolower(trim($fila['nombre_alu'])));
	$paterno = ucfirst(strtolower(trim($fila['ape_pat'])));
	$materno = ucfirst(strtolower(trim($fila['ape_mat'])));
	$sql ="UPDATE alumno SET nombre_alu='".$nombre."', ape_pat='".$paterno."', ape_mat='".$materno."' WHERE rut_alumno=".$fila['rut_alumno'];
	$rs_alumno = @pg_exec($conn,$sql) or die("update fallo:".$sql);
	
}
echo "datos modificados";

?>