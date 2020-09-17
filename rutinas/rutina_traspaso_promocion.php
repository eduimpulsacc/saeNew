<? 


$conn=@pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");
$conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//$conn2=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña."); 


$sql="SELECT id_ano FROM ano_Escolar WHERE id_institucion=1598 AND nro_ano=2007";    
$rs_ano = pg_exec($conn,$sql);  
$ano=pg_result($rs_ano,0); //coi_final

$rs_ano2 = pg_exec($conn2,$sql);
$ano2=pg_result($rs_ano2,0); //coi_final_vina

echo $sql="SELECT promocion.*, ensenanza, grado_curso, letra_curso FROM promocion INNER JOIN curso ON promocion.id_curso=curso.id_curso WHERE rdb=1598 AND curso.id_ano=".$ano;
$result = pg_exec($conn,$sql);

for($i;$i<pg_numrows($result);$i++){
	$fila = pg_fetch_array($result,$i);
	
	echo "<br>".$sql="SELECT id_curso FROM curso WHERE id_ano=".$ano2." AND ensenanza=".$fila['ensenanza']." AND grado_curso=".$fila['grado_curso']." AND letra_curso='".$fila['letra_curso']."'";
	$rs_nuevo_curso = pg_exec($conn2,$sql);
	$curso = pg_result($rs_nuevo_curso,0);
	
	$sql="SELECT * FROM promocion WHERE rdb=1598 AND id_ano=".$ano2." AND id_curso=".$curso." AND rut_alumno=".$fila['rut_alumno'];
	$rs_existe = pg_exec($conn2,$sql);
	
	if(pg_numrows($rs_existe)==0){	
		$sql="INSERT INTO promocion (rdb,id_ano, id_curso, rut_alumno, promedio,asistencia, situacion_final, fecha_retiro, 
		cod_esp, cod_sector,cod_rama, tipo_reprova, observacion, usuario, fecha_prom, hora_prom) 
		VALUES (1598, ".$ano2.", ".$curso.", ".$fila['rut_alumno'].",".$fila['promedio'].",".$fila['asistencia'].",".$fila['situacion_final'].",";
		if($fila['fecha_retiro']==""){
			$sql.="NULL,";	
		}else{
			$sql.="'".$fila['fecha_retiro']."',";
		}
		$sql.="NULL,NULL,NULL,";
		if($fila['tipo_reprova']==""){
			$sql.="NULL,";	
		}else{
			$sql.="".$fila['tipo_reprova'].",";
		}
		
		if($fila['observacion']==""){
			$sql.="' '";
		}else{
			$sql.="'".$fila['observacion']."',";
		}
		echo "<br>".$sql.="'".$fila['usuario']."','".$fila['fecha_prom']."','".$fila['hora_prom']."')";
			
	}else{
		$sql="UPDATE promocion SET
			  promedio=".$fila['promedio'].",
			  asistencia=".$fila['asistencia'].",
			  situacion_final = ".$fila['situacion_final'].",";
		if($fila['fecha_retiro']==""){
			$sql.="fecha_retiro=NULL,";
		}else{
			$sql.="fecha_retiro='".$fila['fecha_retiro']."',";		
		}
		$sql.="cod_esp=".$fila['cod_esp'].",
			   cod_sector = ".$fila['cod_sector'].",
			   cod_rama = ".$fila['cod_rama'].",
			   tipo_reprova = ".$fila['tipo_reprova'].",";
		if($fila['observacion']==""){
			$sql.="observacion=NULL,";	
		}else{
			$sql.="obsercacion='".$fila['observacion']."',";
		}
		echo "<br>".$sql.="usuario='".$fila['usuario']."',
			   fecha_prom='".$fila['fecha_prom']."',
			   hora_prom='".$fila['hora_prom']."' 
			   WHERE rdb=1598 AND id_ano=".$ano2." AND id_curso=".$curso." AND rut_alumno=".$fila['rut_alumno']."";  
		
	}
	$rs_promocion = pg_Exec($conn2,$sql);
}


	$sql="SELECT psa.*, ensenanza, grado_curso, letra_curso, ramo.cod_subsector
			FROM promedio_sub_alumno psa
			INNER JOIN curso ON psa.id_curso=curso.id_curso 
			INNER JOIN ramo ON psa.id_ramo=ramo.id_ramo
			WHERE rdb=1598 AND curso.id_ano=".$ano;
	$result = pg_exec($conn,$sql);
	
	for($i=0;$i<pg_numrows($result);$i++){
		$fila=pg_fetch_array($result,$i);
		
		$sql="SELECT id_curso FROM curso WHERE id_ano=".$ano2." AND ensenanza=".$fila['ensenanza']." AND grado_curso=".$fila['grado_curso']." AND letra_curso='".$fila['letra_curso']."'";
		$rs_nuevo_curso = pg_exec($conn2,$sql);
		$curso = pg_result($rs_nuevo_curso,0);
		
		$sql="SELECT  id_ramo FROM ramo WHERE id_curso=".$curso." AND cod_subsector=".$fila['cod_subsector'];
		$rs_ramo = pg_exec($conn2,$sql);
		$ramo = pg_result($rs_ramo,0);	
		
		$sql="INSERT INTO promedio_sub_alumno (rdb,id_ano,id_curso,id_ramo,rut_alumno, promedio) VALUES(1598,".$ano2.",".$curso.",".$ramo.",".$fila['rut_alumno'].",'".$fila['promedio']."')";
		$rs_promedio = pg_exec($conn2,$sql);
	}


echo "<br>fin proceso";

?>







