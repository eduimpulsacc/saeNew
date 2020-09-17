<? require('../../../util/header.inc');

$qry = "";
$qry = "select * from fecha_naci ";
$Rs_Temp = pg_exec($conn,$qry);
	for($i=0;$i<pg_numrows($Rs_Temp);$i++){
		$fila = pg_fetch_array($Rs_Temp,$i);
		$rut	= trim($fila['rut_alumno']);
		$fecha	= trim($fila['fecha']);

		$sql = "UPDATE alumno SET fecha_nac=to_date('" . $fecha . "','YYYY MM DD') WHERE rut_alumno=" . $rut ."";
		$Rs_Alumno = pg_exec($conn,$sql);
		echo $i."  ".$sql."<br>";
	}
pg_close($conn);	
?>