<?

$conn2=pg_connect("dbname=coi_usuario host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Corporacion.");	
				

$sql="SELECT rut_alumno FROM matricula WHERE id_ano=1265";
$rs_matricula = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_matricula);$i++){
	$fila = pg_fetch_array($rs_matricula,$i);

	$rut_apo="";
	$sql="SELECT rut_apo FROM tiene2 WHERE rut_alumno=".$fila['rut_alumno'];
	$rs_tiene = pg_exec($conn,$sql);
	

	if(pg_numrows($rs_tiene)>1){

		for($j=0;$j<pg_numrows($rs_tiene);$j++){
			$fila_apo = pg_fetch_array($rs_tiene,$j);
			$rut_apo = $fila_apo['rut_apo'];
			$sql="DELETE FROM accede WHERE id_usuario in (SELECT id_usuario FROM usuario WHERE nombre_usuario='".$rut_apo."')";
			$rs_accede = pg_exec($conn2,$sql);

			$sql="DELETE FROM usuario WHERE nombre_usuario='".$rut_apo."'";
			$rs_usuario = pg_exec($conn2,$sql);
		}
	}else{
		$rut_apo = pg_result($rs_tiene,0);
		$sql="DELETE FROM accede WHERE id_usuario in (SELECT id_usuario FROM usuario WHERE nombre_usuario='".$rut_apo."')";
		$rs_accede = pg_exec($conn2,$sql);

		$sql="DELETE FROM usuario WHERE nombre_usuario='".$rut_apo."'";
		$rs_usuario = pg_exec($conn2,$sql);
	}
}

echo "FIN PROCESO CURSO";

?>