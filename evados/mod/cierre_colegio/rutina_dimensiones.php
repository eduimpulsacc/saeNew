<? 

$conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	


$sql="SELECT id_cierre FROM evados.eva_cierre WHERE estado=1 and id_nacional=7";
$rs_cierre = pg_exec($conn,$sql);
$cierre= pg_result($rs_cierre,0);

echo $sql="SELECT * FROM evados.eva_cierre_dimension_final WHERE id_cierre=".$cierre." AND valor_final=100  AND id_ano=1786";
$rs_sobre100 = pg_exec($conn,$sql);

for($i=0;$i<pg_numrows($rs_sobre100);$i++){
	$fila =pg_fetch_array($rs_sobre100,$i);
	$porcentaje = round(($fila['sumatoria'] * 100) / $fila['total_concepto']);	
	
	$sql="SELECT concepto FROM evados.eva_escala WHERE desde<=".$porcentaje." AND hasta>=".$porcentaje;
	$rs_escala = pg_exec($conn,$sql);
	$escala = pg_result($rs_escala,0);
	
	echo "<br>".$sql="UPDATE evados.eva_cierre_dimension_final SET valor_final=".$porcentaje.", total_concepto=".$fila['sumatoria'].", sumatoria=".$fila['total_concepto'].", evaluacion_final='".$escala."' 
	WHERE id_cierre=".$cierre." AND id_plantilla=".$fila['id_plantilla']." AND id_area=".$fila['id_area']." AND id_ano=".$fila['id_ano']." AND id_periodo=".$fila['id_periodo']."  AND rut_evaluado=".$fila['rut_evaluado']."";
	$rs_update = pg_exec($conn,$sql);
	
}
echo "FIN PROCESO";



?>