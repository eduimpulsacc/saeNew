<?
// Rutina para varias cosas
//$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=@pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("No pude conectar a la base de datos destino");
 $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");
				
echo $sql="SELECT DISTINCT apo.rut_apo, apo.nombre_apo ||' '||apo.ape_pat as nombre_apoderado, celular, telefono FROM apoderado apo INNER JOIN tiene2 t ON t.rut_apo=apo.rut_apo INNER JOIN matricula m ON m.rut_alumno=t.rut_alumno WHERE m.id_ano=1828 ORDER BY nombre_apoderado ASC";
$result = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($result);$i++){
	$fila = pg_fetch_array($result,$i);
	/*echo "<br> inicio-->".$inicio =substr($fila['telefono'],0,1);
	echo "....largo-->".$largo = strlen(trim($fila['telefono']));
	if($inicio==9 && $largo==9){
		echo "<br>".$sql="UPDATE apoderado SET celular='".trim($fila['celular'])."' WHERE rut_apo=".$fila['rut_apo'];
		$rs_update = pg_exec($conn,$sql);
		$cont++;
	}*/
	
	if(strlen($fila['celular'])==10){
		//$celular_limpio = substr($fila['celular'],1,8);
		$celular="9".$fila['celular'];
		echo "<br>".$sql="UPDATE apoderado SET celular='".trim($celular)."' WHERE  rut_apo=".$fila['rut_apo'];
		$rs_celular = pg_exec($conn,$sql);
		$cont++;
	}

	
}



echo "<br><br>Modificacion de numeros celular terminado. cantidad de registros modificados: ".$cont; 	

?>
