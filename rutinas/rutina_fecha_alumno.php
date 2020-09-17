<? 
$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final");


$id_ano=1270;

$sql="SELECT rut_alumno FROM matricula WHERE id_ano=1270";
$rs_matricula  = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_matricula);$i++){
	$fila = pg_Fetch_array($rs_matricula,$i);
	
	$sql="select campo2 FROM temporal_dav WHERE campo1='".$fila['rut_alumno']."'";
	$rs_temporal = pg_exec($conn,$sql);
	$fecha = pg_result($rs_temporal,0);
	$dia = substr($fecha,0,2);
	$mes = substr($fecha,3,2);
	$ano = substr($fecha,6,4);
	$fecha_final = $mes."-".$dia."-".$ano;
	
	$sql="UPDATE alumno SET fecha_nac='".$fecha_final."'	WHERE rut_alumno=".$fila['rut_alumno']."";
	$rs_alumno = pg_exec($conn,$sql);
	
}
echo "FIN PROCESO";

?>
