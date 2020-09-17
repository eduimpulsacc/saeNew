<? 

$conn=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	


$sql="SELECT id_cierre FROM evados.eva_cierre WHERE estado=1";
$rs_cierre = pg_exec($conn,$sql);
$cierre= pg_result($rs_cierre,0);


$sql="update evados.eva_cierre_dimension_final set valor_final=100, evaluacion_final='DESTACADO' where id_cierre=".$cierre." AND valor_final>100";
$rs_actualiza = pg_exec($conn,$sql);

$sql="SELECT id_plantilla FROM evados.eva_plantilla";
$rs_plantilla = pg_exec($conn,$sql);

for($j=0;$j<pg_numrows($rs_plantilla);$j++){
	$fila_pla = pg_fetch_array($rs_plantilla,$j);
	
	$sql="select * from evados.eva_cierre_Evaluado_final where id_cierre=$cierre and id_plantilla=".$fila_pla['id_plantilla'];
	$rs_evaluado = pg_exec($conn,$sql);
	
	for($i=0;$i<pg_numrows($rs_evaluado);$i++){
		$fila = pg_fetch_array($rs_evaluado,$i);
		
		echo "\t".$sql="SELECT sum(valor_final), COUNT(*) as cantidad FROM evados.eva_cierre_dimension_final WHERE id_cierre=$cierre and id_plantilla=".$fila['id_plantilla']." AND rut_Evaluado=".$fila['rut_evaluado']." AND id_periodo=".$fila['id_periodo']." AND id_area<>22";
	$rs_dimension = pg_exec($conn,$sql);	
		echo "suma-->".$suma = pg_result($rs_dimension,0);
		echo "contador-->".$contador = pg_result($rs_dimension,1);
		
		echo "porcentaje--> ".$porcentaje = round(($suma) / $contador)."\n";
		
		echo "concepto-->" .$new_concepto = round($fila['sumatoria'] * 100 / $porcentaje)."\n";
		
		$sql="SELECT concepto FROM evados.eva_escala WHERE desde<=".$porcentaje." AND hasta>=".$porcentaje;
		$rs_escala = pg_exec($conn,$sql);
		echo $resultado = pg_Result($rs_escala,0);
		
		echo "<br>".$sql="UPDATE evados.eva_cierre_evaluado_final SET total_concepto=".$new_concepto.", valor_final=".$porcentaje.", evaluacion_final='".$resultado."' WHERE id_cierre=$cierre AND id_plantilla=".$fila['id_plantilla']." AND rut_Evaluado=".$fila['rut_evaluado']." AND id_periodo=".$fila['id_periodo'];
		$result = pg_exec($conn,$sql);
		
		echo "FINNNNN";
	}
}



?>