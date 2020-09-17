<?
// Rutina para varias cosas
$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=@pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
				

$ano = 1847 ;    
$rdb = 1914 ;

echo "<br>".$sql="SELECT rut_alumno FROM matricula WHERE id_ano=".$ano;
$rs_matricula = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_matricula);$i++){
	$fila = pg_fetch_array($rs_matricula,$i);
	
	echo "<br>".$sql="SELECT COUNT(*) FROM matricula WHERE id_ano=".$ano." AND rut_alumno=".$fila['rut_alumno']." AND bool_ar=0";
	$rs_cuenta= pg_exec($conn,$sql);
	
	if(pg_result($rs_cuenta,0)==2){
		echo "<br>".$sql="DELETE FROM matricula WHERE id_ano=".$ano." AND rut_alumno=".$fila['rut_alumno']." AND bool_ar=0 AND num_mat=0";
		$rs_delete = pg_exec($conn,$sql);
			
	}
}
 
	
?>
