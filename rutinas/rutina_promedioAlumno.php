<?
// Rutina para varias cosas
$conn=@pg_connect("dbname=coi_antofagasta host=200.29.70.184 port=5432 user=postgres password=anto2010") or die ("No pude conectar a la base de datos destino");
//$conn_anto=pg_connect("dbname=coe host=200.29.20.214 port=1550 user=postgres password=post2005") or die ("No pude conectar a la base de datos destino");

$rdb=280;
$nro_ano=2010;
$id_ano=1100;

$qry_1 = "select * from temporal_dav";
$res_1 = @pg_Exec($conn,$qry_1);
$num_1 = @pg_numrows($res_1);


for ($i=0; $i < $num_1; $i++){
    $fil_1 = @pg_fetch_array($res_1,$i);
	$ensenanza		= $fil_1['campo1'];
	$grado			= $fil_1['campo2'];
	$letra			= $fil_1['campo3'];
	$ano			= $fil_1['campo4'];
    $rut_alumno  	= $fil_1['campo5'];
	$cod_subsector 	= $fil_1['campo6'];
	$nota 			= $fil_1['campo7'];
	$concepto		= $fil_1['campo8'];
	
	
	$sql ="SELECT id_curso FROM curso WHERE ensenanza=".$ensenanza." AND grado_curso=".$grado." AND letra_curso='".$letra."' AND id_ano=".$id_ano."";
	$rs_curso = pg_exec($conn,$sql);
	$curso = pg_result($rs_curso,0);
	
	$sql ="SELECT id_ramo FROM ramo WHERE id_curso=".$curso." AND cod_subsector=".$cod_subsector."";
	$rs_ramo = pg_exec($conn,$sql);
	$ramo = pg_result($rs_ramo,0);
	
	if($cod_subsector!=13){
		$promedio = $nota;
	}
	if($cod_subsector==13){
		$promedio = $fil_1['campo8'];	
	}
		
	
	
	

	/*$sql = "SELECT id_ramo,a.id_curso FROM matricula a INNER JOIN ramo b ON a.id_curso=b.id_curso WHERE rut_alumno=".$rut_alumno." AND id_ano=".$id_ano." AND cod_subsector=".$cod_subsector;
	$rs_ramo = @pg_exec($conn,$sql);
	$ramo 	= @pg_result($rs_ramo,0);
	$curso 	= @pg_result($rs_ramo,1);*/
	
	echo "<br>".$sql = "INSERT INTO promedio_sub_alumno (rdb,id_ano,id_curso,id_ramo,rut_alumno,promedio) VALUES(".$rdb.",".$id_ano.",".$curso.",".$ramo.",".$rut_alumno.",'".$promedio."')";
	$rs_promedio = @pg_exec($conn,$sql);
	

	
	/*$rut =  $fil_1['campo1'];
	if($rut_alumno!=$rut){
		exit;
	}
	*/
	
}	

echo "<br><br>ok...actualizacion de datos.... "; 	
?>
