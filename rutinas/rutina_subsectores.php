<?

//$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
//$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	

$sql="SELECT * FROM temporal_dav";
$rs_temporal = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_temporal);$i++){
	$fila = pg_fetch_array($rs_temporal,$i);
	
	$sql="SELECT * FROM subsector WHERE cod_subsector=".$fila['campo1'];
	$rs_existe = pg_exec($conn,$sql);
	
	if(pg_numrows($rs_existe)==0){
		echo "<br>".$sql="INSERT INTO subsector (cod_subsector,nombre) VALUES (".$fila['campo1'].",'".$fila['campo2']."')";
		$result = pg_exec($conn,$sql);	
	}else{
		echo "<br> existe";	
	}
	
}

echo "FIN PROCESO";
?>