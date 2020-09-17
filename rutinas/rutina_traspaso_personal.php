<? 


$conn=@pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");
$conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//$conn2=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña."); 


$sql="SELECT id_ano FROM ano_Escolar WHERE id_institucion=1598 AND nro_ano=2010";   
$rs_ano = pg_exec($conn,$sql);  
$ano=pg_result($rs_ano,0); //coi_final

$rs_ano2 = pg_exec($conn2,$sql);
$ano2=pg_result($rs_ano2,0); //coi_final_vina

$sql="SELECT rut_emp FROM dicta WHERE id_ramo in (SELECT id_ramo FROM ramo INNER JOIN curso ON ramo.id_curso=curso.id_curso WHERE id_ano=".$ano.")";
$result = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($result);$i++){
	$fila = pg_fetch_array($result,$i);
	
	echo "<br>".$sql="SELECT * FROM empleado WHERE rut_emp=".$fila['rut_emp'];
	$rs_existe = pg_exec($conn2,$sql);
	
	if(pg_numrows($rs_existe)==0){
		$rs_existe2 = pg_exec($conn,$sql);
		$fila_emp = pg_fetch_array($rs_existe2,0);
		
		echo "<br>".$sql="INSERT INTO empleado (rut_emp,dig_rut,nombre_emp, ape_pat, ape_mat, calle, nro, depto, block, villa, region, ciudad, comuna) 
		VALUES (".$fila_emp['rut_emp'].",'".$fila_emp['dig_rut']."','".$fila_emp['nombre_emp']."', '".$fila_emp['ape_pat']."', '".$fila_emp['ape_mat']."', '".$fila_emp['calle']."', '".$fila_emp['nro']."','".$fila_emp['depto']."', '".$fila_emp['block']."', '".$fila_emp['villa']."', '".$fila_emp['region']."', ".$fila_emp['ciudad'].", ".$fila_emp['comuna'].")";
		$rs_empleado =pg_exec($conn2,$sql);	
	}
	
	
}

/*
echo $sql="SELECT * FROM empleado INNER JOIN trabaja ON empleado.rut_emp=trabaja.rut_emp WHERE rdb=1598";
$result = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($result);$i++){
	$fila =pg_fetch_array($result,$i);
	
	$sql="SELECT * FROM empleado INNER JOIN trabaja ON empleado.rut_emp=trabaja.rut_emp WHERE rut_emp=".$fila['rut_emp'];
	$rs_empleado =pg_exec($conn2,$sql);
	
	if(pg_numrows($rs_empleado)==0){
		echo "<br>".$sql="INSERT INTO empleado (rut_emp,dig_rut,nombre_emp,ape_pat,ape_mat,calle,nro,depto,block,villa,region, ciudad, comuna, telefono, sexo) VALUES (".$fila['rut_emp'].", '".$fila['dig_rut']."', '".$fila['nombre_emp']."', '".$fila['ape_pat']."', '".$fila['ape_mat']."', '".$fila['calle']."', '".$fila['nro']."', '".$fila['depto']."', '".$fila['block']."', '".$fila['villa']."',  '".$fila['region']."', '".$fila['ciudad']."',  '".$fila['comuna']."', '".$fila['telefono']."', '".$fila['sexo']."')";
		$rs_empleado_nuevo = pg_exec($conn2,$sql);	
		
		echo "<br>".$sql="INSERT INTO trabaja (rdb,rut_emp,cargo) VALUES(1598,".$fila['rut_emp'].",".$fila['cargo'].")";
		$rs_trabaja =pg_exec($conn2,$sql);
	}
}
*/

echo "fin proceso";

?>







