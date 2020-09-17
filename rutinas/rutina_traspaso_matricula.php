<? 


$conn=@pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_antofagasta host=192.168.1.11 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Antofagasta.");
$conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña.");
//$conn2=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexión Viña."); 


$sql="SELECT id_ano FROM ano_Escolar WHERE id_institucion=1598 AND nro_ano=2014";   
$rs_ano = pg_exec($conn,$sql);  
$ano=pg_result($rs_ano,0); //coi_final

$rs_ano2 = pg_exec($conn2,$sql);
$ano2=pg_result($rs_ano2,0); //coi_final_vina

echo "<br>".$sql="SELECT alumno.rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat, calle, nro, depto,block,villa,region,ciudad, 
		comuna,telefono,sexo,fecha_nac,nacionalidad,religion, ensenanza,grado_curso,letra_curso,rdb,matricula.id_ano,matricula.id_curso, fecha, num_mat,bool_ar, matricula.fecha_retiro, nro_lista FROM matricula  INNER JOIN alumno ON matricula.rut_alumno=alumno.rut_alumno  INNER JOIN curso ON matricula.id_curso=curso.id_curso WHERE matricula.id_ano=".$ano;
$rs_ano = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_ano);$i++){
	$fila = pg_fetch_array($rs_ano,$i);
	
	echo "<br>".$i."-->".$sql="SELECT * FROM matricula WHERE matricula.id_ano=".$ano2." AND rut_alumno=".$fila['rut_alumno'];
	$rs_matricula = pg_exec($conn2,$sql);

	if(pg_numrows($rs_matricula)==0){
		
		
		echo "<br>".$sql="INSERT INTO alumno (rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat, calle, nro, depto,block,villa,region,ciudad, 
		comuna,telefono,sexo,fecha_nac,nacionalidad,religion) 
		VALUES(".$fila['rut_alumno'].", 
		'".$fila['dig_rut']."',
		'".$fila['nombre_alu']."',
		'".$fila['ape_pat']."',
		'".$fila['ape_mat']."',
		'".$fila['calle']."',
		'".$fila['nro']."',
		'".$fila['depto']."','".$fila['block']."','".$fila['villa']."','".$fila['region']."','".$fila['ciudad']."','".$fila['comuna']."','".$fila['telefono']."','".$fila['sexo']."','".$fila['fecha_nac']."','".$fila['nacionalidad']."','".$fila['religion']."')";
		$rs_alumno = pg_exec($conn2,$sql);

		$sql="SELECT id_curso FROM curso WHERE ensenanza=".$fila['ensenanza']." AND grado_curso=".$fila['grado_curso']." AND letra_curso='".$fila['letra_curso']."'";
		$rs_curso = pg_exec($conn2,$sql);
		$curso = pg_result($rs_curso,0);
		if($fila['num_mat']=="") $num_mat=0; else $num_mat=$fila['num_mat'];

		$sql="INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso, fecha, num_mat,bool_ar, fecha_retiro, nro_lista) VALUES (".$fila['rut_alumno'].",".$fila['rdb'].",".$ano2.",".$curso.",'".$fila['fecha']."','".$num_mat."',".$fila['bool_ar'].",";
		if($fila['bool_ar']!=1) {
			$sql.="NULL,"; 
		}elseif($fila['fecha_retiro']==""){
			$sql.="NULL,"; 			
		}else{ 
			$sql.="'".$fila['fecha_retiro']."',";
		}
		if($fila['nro_lista']==""){
			$sql.="NULL)";
		}else{
			$sql.="'".$fila['nro_lista']."')";
		}
		echo "<br>".$sql;
		$rs_nuevo = pg_exec($conn2,$sql);
	}
}

echo "fin proceso";

?>







