<? $conn=@pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");

$sql ="select * from alumno
inner join matricula on alumno.rut_alumno=matricula.rut_alumno
where matricula.rdb=1604";

$result = pg_Exec($conn,$sql);

for($i=0;$i<pg_numrows($result);$i++){
	$fila = pg_fetch_array($result,$i);
	$nombre = trim($fila['nombre_alu']);
	$ape_pat = trim($fila['ape_pat']);
	$ape_mat = trim($fila['ape_mat']);
	$rut_alumno = $fila['rut_alumno'];
	$nombre = ucwords(strtolower($nombre)); 
	$ape_pat = ucwords(strtolower($ape_pat));
	$ape_mat = ucwords(strtolower($ape_mat));
	
	echo "<br>".$nombre;
	echo "&nbsp;".$ape_pat;
	echo "&nbsp;".$ape_mat;
	echo"&nbsp;"."<br>".$rut_alumno;
	
	echo "<br>".$qry = "UPDATE alumno SET nombre_alu='".$nombre."',
	ape_pat='".$ape_pat."',ape_mat='".$ape_mat."'
	 WHERE rut_alumno=".$fila['rut_alumno'];

	$rs_datos = @pg_exec($conn,$qry);
	 
}
 

?>
