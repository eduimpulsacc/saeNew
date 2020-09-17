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

$sql="SELECT id_periodo FROM periodo WHERE id_ano=".$ano;
$rs_periodo = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_temporal);$i++){
	$fila = pg_fetch_array($rs_temporal,$i);
	
	 $sql="SELECT id_ramo,id_curso FROM ramo WHERE cod_subsector=".$fila['campo12']." AND id_curso in (SELECT id_curso FROM curso WHERE id_ano=".$ano." AND ensenanza=".$fila['campo4']." AND grado_curso=".$fila['campo5']." AND letra_curso='".$fila['campo6']."')";
	$rs_ramo = pg_exec($conn,$sql);
	
	$ramo = pg_result($rs_ramo,0);
	$curso = pg_result($rs_ramo,1);
	$promedio = str_replace(".","",$fila['campo13']); 
	
	for($j=0;$j<pg_numrows($rs_periodo);$j++){
		$fila_p = pg_fetch_array($rs_periodo,$j);
		
		/*$sql= "INSERT INTO notas$nro_ano (rut_alumno,id_ramo, id_periodo, nota1, promedio) VALUES(".$fila['campo8'].",".$ramo.",".$fila_p['id_periodo'].",'".$promdio."','".$promedio."')";	*/
		echo "<br> notas-->".$sql="UPDATE notas$nro_ano SET nota1='".$promedio."' WHERE rut_alumno=".$fila['campo8']." AND id_periodo=".$fila_p['id_periodo']." AND id_ramo=".$ramo;
		$rs_notas = pg_exec($conn,$sql);
	}
	
	//echo "<br> promedio-->".$sql="INSERT INTO promedio_sub_alumno (rdb,id_ano,id_curso,id_ramo,rut_alumno,promedio) VALUES (".$rdb.",".$ano.",".$curso.",".$ramo.",".$fila['campo8'].",'".$promedio."')";
//	$rs_promedio =pg_exec($conn,$sql);
	
}



echo "FIN DE PROCESO";
?>