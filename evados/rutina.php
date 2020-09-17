<? 	 
$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conex Coi_Usuario");


$rut_evaluado = 9235020;
$ano = 1516 ;
$periodo = 2738;
$plantilla = 31;
$cargo =101; 


/*echo "<br>".$sql="select distinct rut_Evaluador, epe.id_cargo_evaluador
from evados.eva_plantilla_evaluacion  epe 
where epe.id_ano=".$ano." AND epe.id_plantilla=".$plantilla." AND epe.ip_periodo=".$periodo." 
AND epe.rut_evaluado=".$rut_evaluado." AND epe.id_cargo_evaluador=".$cargo;*/
echo "<br>".$sql=" SELECT *
 FROM evados.eva_relacion_evaluacion ere
 WHERE ere.id_ano=".$ano." AND ere.id_periodo=".$periodo." AND ere.rut_evaluado=".$rut_evaluado."  and ere.id_cargo=".$cargo;
$rs_rut = pg_exec($conn,$sql) or die(pg_last_error($conn));


for($i=0;$i<pg_numrows($rs_rut);$i++){
	$fila = pg_fetch_array($rs_rut,$i);

	echo "<br>1-->".$sql="SELECT *
FROM evados.eva_plantilla_evaluacion epe
WHERE epe.id_ano=".$ano." AND epe.id_plantilla=".$plantilla." AND epe.ip_periodo=".$periodo." AND 
epe.rut_evaluado=".$rut_evaluado." AND rut_evaluador=".$fila['rut_evaluador'];
	$rs_existe = pg_exec($conn,$sql) or die(pg_last_error($conn));

	if(pg_numrows($rs_existe)!=0){
		$rut_valido = $fila['rut_evaluador'];
		break;
	}
}

for($i=0;$i<pg_numrows($rs_rut);$i++){
	$fila = pg_fetch_array($rs_rut,$i);

	echo "<br>2-->".$sql="SELECT *
FROM evados.eva_plantilla_evaluacion epe
WHERE epe.id_ano=".$ano." AND epe.id_plantilla=".$plantilla." AND epe.ip_periodo=".$periodo." AND 
epe.rut_evaluado=".$rut_evaluado." AND rut_evaluador=".$fila['rut_evaluador'];
	$rs_existe = pg_exec($conn,$sql) or die(pg_last_error($conn));

	if(pg_numrows($rs_existe)==0){
		echo "<br>".$sql="INSERT INTO evados.eva_plantilla_evaluacion  (id_plantilla,id_area,id_subarea,id_item,id_concepto,
rut_evaluador,rut_evaluado,id_ano,
id_cargo_evaluado,id_cargo_evaluador,ip_periodo) (SELECT id_plantilla,id_area,id_subarea,id_item,
id_concepto,".$fila['rut_evaluador'].",rut_evaluado,id_ano,
id_cargo_evaluado,id_cargo_evaluador,ip_periodo FROM evados.eva_plantilla_evaluacion epe
WHERE epe.id_ano=".$ano." AND epe.id_plantilla=".$plantilla." AND epe.ip_periodo=".$periodo." AND epe.rut_evaluado=".$rut_evaluado."
AND rut_evaluador=".$rut_valido.")";
		$rs_insert =pg_exec($conn,$sql)  or die(pg_last_error($conn));

		
	}
}

	


?>