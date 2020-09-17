<? 

$conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	


$sql="SELECT id_cierre FROM evados.eva_cierre WHERE estado=1 and id_nacional=7";
$rs_cierre = pg_exec($conn,$sql);
$cierre= pg_result($rs_cierre,0);


$sql="SELECT id_plantilla FROM evados.eva_plantilla where id_nacional=7";
$rs_plantilla = pg_exec($conn,$sql);

for($j=0;$j<pg_numrows($rs_plantilla);$j++){
	$fila_pla = pg_fetch_array($rs_plantilla,$j);
	
	$sql="select * from evados.eva_cierre_Evaluado_final where id_cierre=$cierre and id_plantilla=".$fila_pla['id_plantilla'];
	$rs_evaluado = pg_exec($conn,$sql);
	
	for($i=0;$i<pg_numrows($rs_evaluado);$i++){
		$fila = pg_fetch_array($rs_evaluado,$i);
		
		$sql="SELECT count(*)
				FROM evados.eva_plantilla_evaluacion
				WHERE id_ano=".$fila['id_ano']." and ip_periodo=".$fila['id_periodo']."
				AND rut_evaluado=".$fila['rut_evaluado']." AND id_plantilla=".$fila_pla['id_plantilla'];
		$rs_cantidad_indicadores = pg_exec($conn,$sql);
		$cantidad_indicadores = pg_result($rs_cantidad_indicadores,0);
		
		$optimo = $cantidad_indicadores * 4;
		
		$valor_final = round(($fila['sumatoria'] / $optimo ) * 100);
		
		$sql="SELECT concepto FROM evados.eva_escala WHERE desde<=".$valor_final." AND hasta>=".$valor_final;
		$rs_escala = pg_exec($conn,$sql);
		$resultado = pg_Result($rs_escala,0);
		
		echo "<br>".$sql="UPDATE evados.eva_cierre_evaluado_final SET total_concepto=".$optimo.", valor_final=".$valor_final.", evaluacion_final='".$resultado."' WHERE id_cierre=$cierre AND id_plantilla=".$fila['id_plantilla']." AND rut_Evaluado=".$fila['rut_evaluado']." AND id_periodo=".$fila['id_periodo'];
		//$result = pg_exec($conn,$sql);
		
	}
	echo "<br><br><br><br><br><br>FINAL PRIMERA ETAPA<br><br><br><br><br>";
		for($i=0;$i<pg_numrows($rs_evaluado);$i++){
			$fila = pg_fetch_array($rs_evaluado,$i);
		
		$sql="SELECT count(*) * 4 as optimo,epa.id_area,epa.nombre
				FROM evados.eva_plantilla_evaluacion epe
				INNER JOIN evados.eva_plantilla_area epa ON epe.id_area=epa.id_area
				WHERE id_ano=".$fila['id_ano']." AND id_plantilla=".$fila_pla['id_plantilla']." AND rut_evaluado=".$fila['rut_evaluado']."
				group by 2,3";
		$rs_optimo_dimension = pg_exec($conn,$sql);
		
		for($x=0;$x<pg_numrows($rs_optimo_dimension);$x++){
			$fila_dim = pg_fetch_array($rs_optimo_dimension,$x);
			
			$sql="	SELECT COUNT(*) as cantidad, id_area, ec.categoria,peso,orden
					FROM evados.eva_plantilla_evaluacion epe
					INNER JOIN evados.eva_concepto ec ON epe.id_concepto=ec.id_concepto
					WHERE id_ano=".$fila['id_ano']." AND id_plantilla=".$fila_pla['id_plantilla']." AND rut_evaluado=".$fila['rut_evaluado']." and id_area=".$fila_dim['id_area']."
					group by 2,3,4,5
					order by id_area,orden ASC";
			$rs_dimension = pg_exec($conn,$sql);
			
			$suma_concepto=0;
			
			for($v=0;$v<pg_numrows($rs_dimension);$v++){
				$fila_area = pg_fetch_array($rs_dimension);
				$suma_concepto=$suma_concepto + ($fila_area['cantidad'] * $fila_area['peso']);	
			}
			$total_concepto = round($suma_concepto/$fila_dim['optimo']*100);
			
			$sql="SELECT concepto FROM evados.eva_escala WHERE desde<=".$total_concepto." AND hasta>=".$total_concepto;
			$rs_escala = pg_exec($conn,$sql);
			$evaluacion_final = pg_result($rs_escala,0);
			
			echo "<br>".$sql="UPDATE evados.eva_cierre_dimension_final SET sumatoria=".$fila_dim['optimo'].", total_concepto=".$suma_concepto.",valor_final=".$total_concepto.", evaluacion_final='".$evaluacion_final."' WHERE id_cierre=".$cierre." AND id_ano=".$fila['id_ano']." AND id_plantilla=".$fila_pla['id_plantilla']." AND rut_evaluado=".$fila['rut_evaluado']." and id_area=".$fila_dim['id_area']."";
			//$result=pg_exec($conn,$sql);
		}
		
		

		}
}



?>