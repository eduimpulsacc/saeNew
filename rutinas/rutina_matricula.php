<?
// Rutina para varias cosas
//$conn=pg_connect("dbname=coi_final host=200.2.201.19 port=5432 user=postgres password=cole#newaccess") or die ("No pude conectar a la base de datos destino");
$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("No pude conectar a la base de datos destino");
//$conn_anto=pg_connect("dbname=coe host=200.29.20.214 port=1550 user=postgres password=post2005") or die ("No pude conectar a la base de datos destino");
//$conn=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión Corporacion.");	
				


$ano2015=1513;
$ano2016=1592;


echo $sql="SELECT id_curso,grado_curso, letra_curso FROM curso WHERE id_ano=".$ano2016." and ensenanza=110 and grado_curso=2 AND letra_curso='D'";
$rs_curso16 = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_curso16);$i++){
	$fila16 = pg_fetch_array($rs_curso16,$i);
	
	$sql="SELECT * FROM matricula WHERE id_ano=".$ano2015." AND id_curso in (SELECT id_curso FROM curso WHERE id_ano=".$ano2015." and ensenanza=110 and grado_curso=1 AND letra_curso='".$fila16['letra_curso']."')";
	$rs_mat2015 = pg_exec($conn,$sql);	
	
	for($j=0;$j<pg_numrows($rs_mat2015);$j++){
		$fila15 = pg_fetch_array($rs_mat2015,$j);
		
		echo "<br>".$sql="INSERT INTO matricula (rut_alumno,id_ano,rdb,id_curso, fecha,bool_ar) VALUES(".$fila15['rut_alumno'].",".$ano2016.",".$fila15['rdb'].",".$fila16['id_curso'].",'01/01/2016',0)";	
		$rs_insert = pg_exec($conn,$sql);
	}
	
	
}
echo "	FIN DE PROCESO ";





/*
$qry_1 = "select * from temporal_dav";
$res_1 = @pg_Exec($conn,$qry_1);
$num_1 = @pg_numrows($res_1);


for ($i=0; $i < $num_1; $i++){
    $fil_1 = @pg_fetch_array($res_1,$i);
    $rut_alumno    = $fil_1['campo1'];
    $rdb           = $fil_1['campo2'];
	$ano	       = $fil_1['campo3'];
    $id_curso      = $fil_1['campo4'];
	$fecha_mat     = $fil_1['campo5'];
	$bool_ar       = $fil_1['campo6'];
	
	$sql_2 = "select * from matricula where rut_alumno = '".trim($rut_alumno)."' and id_ano=".$ano;
	$res_2 = @pg_Exec($conn,$sql_2);
	$num_2 = @pg_numrows($res_2);
	
	if ($num_2==0){  // no inserto
	
		$sql ="INSERT INTO matricula (rdb,rut_alumno,id_ano,id_curso,bool_ar,fecha) VALUES(".$rdb.",".$rut_alumno.",".$ano.",".$id_curso.",".$bool_ar.",'".$fecha_mat."')";
		$rs_matricula = @pg_exec($conn,$sql) or die(pg_last_error($conn));
		
		$contador++;
	}
}	


echo "<br><br>ok...alumnos insertados..." .$contador. " segunda vuelta, alumnos insertados ";

*/	
?>
