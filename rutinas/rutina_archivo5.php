<? 

$conn=@pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");

///$ano=535;

$sql="SELECT * FROM temporal_dav";
$rs_temporal = pg_exec($conn,$sql);
$nro_ano = pg_result($rs_temporal,7);
$rdb= pg_result($rs_temporal,2);

$sql="SELECT id_ano FROM ano_escolar WHERE id_institucion=".$rdb." AND nro_ano=".$nro_ano;
$rs_ano = pg_exec($conn,$sql);
$ano =pg_result($rs_ano,0);

$sql="DELETE FROM matricula WHERE id_ano=".$ano;
$rs_matricula = pg_exec($conn,$sql);

$sql="DELETE FROM tiene$nro_ano WHERE id_curso in (SELECT id_curso FROM curso WHERE id_ano=".$ano.")";
$rs_delete_incluye =pg_exec($conn,$sql);


for($i=0;$i<pg_numrows($rs_temporal);$i++){
	$fila = pg_fetch_array($rs_temporal,$i);

	$sql="SELECT id_curso FROM curso WHERE ensenanza=".$fila['campo4']." AND grado_curso=".$fila['campo5']." AND letra_curso='".$fila['campo6']."' AND id_ano=".$ano;
	$rs_curso = pg_exec($conn,$sql);
	$curso = pg_result($rs_curso,0);

	$sql="INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,fecha,bool_ar) VALUES (".$fila['campo8'].",".$fila['campo2'].", ".$ano.",".$curso.",'01-01-2008',0)";
	$rs_inst_matricula = pg_exec($conn,$sql);
	
	
	
	$sql="SELECT id_ramo FROM ramo WHERE id_curso=".$curso;
	$rs_ramo =pg_exec($conn,$sql);
	
	for($j=0;$j<pg_numrows($rs_ramo);$j++){
		$fila_r = pg_fetch_array($rs_ramo,$j);
		
		$sql="INSERT INTO tiene$nro_ano (rut_alumno,id_ramo,id_curso) VALUES (".$fila['campo8'].",".$fila_r['id_ramo'].",".$curso.")";
		$rs_incluye = pg_exec($conn,$sql);		
	}

	if($fila['campo13']=="P"){ $sf=1; $tipo="NULL"; }
	if($fila['campo13']=="R"){ $sf=2; $tipo=2; } 
	if($fila['campo13']=="Y"){ $sf=3; $tipo="NULL"; } 
	$promedio = str_replace(".","",$fila['campo10']); 

	
	echo "<br>".$sql="INSERT INTO promocion (rdb,id_ano,id_curso,rut_alumno,promedio,asistencia,situacion_final,tipo_reprova,observacion) VALUES (".$fila['campo2'].",".$ano.",".$curso.",".$fila['campo8'].",".$promedio.",".$fila['campo11'].",".$sf.",".$tipo.",'".$fila['campo12']."')";
	$rs_promocion = pg_Exec($conn,$sql);

}
echo "FIN DE PROCESO";
?>