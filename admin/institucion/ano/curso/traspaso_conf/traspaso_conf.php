<?php require('../../../../../util/header.inc');

//busco los años
 $sql_ano_ant="select * from ano_escolar where id_ano=$ano";
$rs_ano_ant=pg_exec($conn,$sql_ano_ant);
$fila_ano_ant = pg_fetch_array($rs_ano_ant,0);

//echo pg_numrows($rs_ano_ant);
//cursos año anterior 
//$sql_cur_ant="select * from id_curso where id_ano=".$fila_ano_ant['ano_anterior'];
//$rs_cur_ant=pg_exec($conn,$sql_cur_ant);


//cursos año actual 
 $sql_cur_act="select * from curso where id_ano=".$ano;
$rs_cur_act=pg_exec($conn,$sql_cur_act);

//a recorrer los cursos
for($cac=0;$cac<pg_numrows($rs_cur_act);$cac++){
$fila_cac = pg_fetch_array($rs_cur_act,$cac);

//buscar si el curso existía en año pasado
$sql_cur_ant="select * from curso where id_ano=".$fila_ano_ant['ano_anterior']." and grado_curso=".$fila_cac['grado_curso']." and letra_curso='".trim($fila_cac['letra_curso'])."' and ensenanza=".$fila_cac['ensenanza'];
$rs_cur_ant=pg_exec($conn,$sql_cur_ant);
if(pg_numrows($rs_cur_ant)>0){
	$fila_ant= pg_fetch_array($rs_cur_ant,0);
	
	if((strlen($fila_ant['fecha_inicio'])>0) && $fila_ant['fecha_inicio']!='1111-11-11'){
		//$fi=date($fila_ant['fecha_inicio']);
	$fecha_inicio = "'".date('Y-m-d',strtotime('+1 year', strtotime($fila_ant['fecha_inicio'])))."'";
	}
	else{
		$fecha_inicio="null";
	}
	
	if((strlen($fila_ant['fecha_termino'])>0) && $fila_ant['fecha_termino']!='1111-11-11'){
	$fecha_termino = "'".date('Y-m-d',strtotime('+1 year', strtotime($fila_ant['fecha_termino'])))."'";
	}
	else{
		$fecha_termino="null";
	}
	
	
	
 //cambio datos del curso
  $sql_upcur="update curso set acta=".intval($fila_ant['acta']).",truncado_per=".intval($fila_ant['truncado_per']).",truncado_final=".intval($fila_ant['truncado_final']).",bool_psemestral=".intval($fila_ant['bool_psemestral']).",bloq_ramos=".intval($fila_ant['bloq_ramos']).",fecha_inicio=".$fecha_inicio.",fecha_termino=".$fecha_termino.",bool_jor=".intval($fila_ant['bool_jor'])." where id_curso=".$fila_cac['id_curso'];
  $rs_upcur = pg_exec($conn,$sql_upcur);
 
 //asigno profesor jefe si no tiene
 $sql_supervisa="select * from supervisa where id_curso=".$fila_cac['id_curso'];
 $rs_supervisa=pg_exec($conn,$sql_supervisa);
 
 //revisar profesor jefe año anterios
   $sql_antsupervisa="select * from supervisa where id_curso=".$fila_ant['id_curso'];
 $rs_antsupervisa=pg_exec($conn,$sql_antsupervisa);
 
 if(pg_numrows($rs_supervisa)==0 && pg_numrows($rs_antsupervisa)>0){
	
  $sql_ins_supervisa="insert into supervisa(rut_emp,id_curso) values(".pg_result($rs_antsupervisa,0).",".$fila_cac['id_curso'].")";
 $rs_ins_supervisa=pg_exec($conn,$sql_ins_supervisa);
 }
}

	
}
echo 1;

?>