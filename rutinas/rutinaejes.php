<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<? 

//base de datos antigua
$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");

$sub_fuente = 249;
$sub_destino = 38;

//trigo los ejes
$sql_ejes_fuente = "select * from planificacion.ejes where cod_subsector=$sub_fuente";
$rs_ejes_fuente = pg_exec($conn,$sql_ejes_fuente);

for($ef=0;$ef<pg_numrows($rs_ejes_fuente);$ef++){
$ejes_fuente = pg_fetch_array($rs_ejes_fuente,$ef);
$id_ef = $ejes_fuente['id_eje'];

// tengo que ir a buscar los objetivos
$sql_obj = "select * from planificacion.obj_hab where id_eje = $id_ef";
$rs_obj = pg_exec($conn,$sql_obj);

//guardo el eje nuevo
$sql_insje = "insert into planificacion.ejes(rdb,texto,tipo,cod_subsector) values (0,'".$ejes_fuente['texto']."','".$ejes_fuente['tipo']."',$sub_destino)";
$rs_inseje = pg_exec($conn,$sql_insje) or die("no agregue ejes");
//echo "<br>";


//voy a buscar el ultimo que inserte
$sql_ul="select id_eje from planificacion.ejes order by id_eje desc limit 1";
$rs_ejed = pg_exec($conn,$sql_ul);
$ejed = pg_result($rs_ejed,0);
 

//busco todos los del objetivo fuente para insertarlos en el eje destino;
	for($od=0;$od<pg_numrows($rs_obj);$od++){
	$fila_obj  = pg_fetch_array($rs_obj,$od);
	$sql_insobj = "insert into planificacion.obj_hab (id_eje,rdb,codigo,texto,tipo,tipo_ense,grado) values($ejed,0,'".$fila_obj['codigo']."','".$fila_obj['texto']."',".$fila_obj['tipo'].",".$fila_obj['tipo_ense'].",".$fila_obj['grado'].")";	
	$rs_objd = pg_exec($conn,$sql_insobj);
	
	}

}


?>
