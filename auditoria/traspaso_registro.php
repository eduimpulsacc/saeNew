<?

$conn0 =pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Coi_Final.");	
$conn1 =pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Coi_Final_vina.");	
$conn2 =pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Coi_corporaciones.");	
$connection =pg_connect("dbname=auditoria host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión auditoria.");		



for($i=0;$i<3;$i++){
	$conn=${"conn".$i};	
	$sql="SELECT * FROM regis.registro";
	$rs_registro = pg_exec($conn,$sql);
	
	for($j=0;$j<pg_numrows($rs_registro);$j++){
		$fila = pg_fetch_array($rs_registro,$j);	
		
		$sql="INSERT INTO auditoria.registro (id_actividad,fecha_registro,usuario_actividad,id_perfil,rdb,id_sae,id_tabla) VALUES(".$fila['id_actividad'].",'".$fila['fecha_registro']."','".$fila['usuario_actividad']."',".$fila['id_perfil'].",".$fila['rdb'].",'".$fila['id_sae']."','".$fila['id_tabla']."');";
		$rs_conexion = pg_exec($connection,$sql) or die((pg_last_error($connection))."--->".$sql);
				
		
	}
}

echo "fin proceso";

?>