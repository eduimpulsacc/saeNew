<?php 

require('../../../../../../util/header.inc');


//datos de año para sacar el año anterior
$sql_ano_ant="select * from ano_escolar where id_ano=$ano";
$rs_ano_ant=pg_exec($conn,$sql_ano_ant);
$fila_ano_ant = pg_fetch_array($rs_ano_ant,0);

//datos del curso actual
$sql_cur_act = "select * from curso where id_curso=".$curso;
$rs_curso_act = pg_exec($conn,$sql_cur_act);
$fila_cur_act = pg_fetch_array($rs_curso_act,0);

//buscar curso anterior equivalente
$sql_cur_ant="select * from curso where id_ano=".$fila_ano_ant['ano_anterior']." and grado_curso=".$fila_cur_act['grado_curso']." and letra_curso='".trim($fila_cur_act['letra_curso'])."' and ensenanza=".$fila_cur_act['ensenanza'];
$rs_curso_ant = pg_exec($conn,$sql_cur_ant); 

if(pg_numrows($rs_curso_ant)>0){
	
 $sql_deldictaActual ="delete from dicta where id_ramo
in(select id_ramo from ramo where id_curso = $curso)";
//pg_exec($conn,$sql_deldictaActual);	  
	
$fila_curso_ant= pg_fetch_array($rs_curso_ant,0);	

//ramos año actual
$sql_ramo_act="select * from ramo where id_curso=".$curso." order by id_orden";
$rs_ramo_act=pg_exec($conn,$sql_ramo_act);

if(pg_numrows($rs_ramo_act)>0){
for($r=0;$r<pg_numrows($rs_ramo_act);$r++){
$fila_ramo_act = pg_fetch_array($rs_ramo_act,$r);
//busco el equivalente en el año anterior
$sql_ramo_ant="select * from ramo where id_curso=".$fila_curso_ant['id_curso']." and cod_subsector=".$fila_ramo_act['cod_subsector'];	
$rs_ramo_ant=pg_exec($conn,$sql_ramo_ant);

	//si tengo ramo equivalente, lo voy a actualizar
	if(pg_numrows($rs_ramo_ant)>0){
		$fila_ramo_ant=pg_fetch_array($rs_ramo_ant,0);
		//actualizar 
		$sql_iguala="update ramo set 
		sub_obli=".intval($fila_ramo_ant['sub_obli']).",
		sub_elect=".intval($fila_ramo_ant['sub_elect']).",
		bool_ip=".intval($fila_ramo_ant['bool_ip']).",
		bool_sar=".intval($fila_ramo_ant['bool_sar']).",
		conex=".intval($fila_ramo_ant['conex']).",
		pct_examen=".intval($fila_ramo_ant['pct_examen']).",
		nota_exim=".intval($fila_ramo_ant['nota_exim']).",
		truncado=".intval($fila_ramo_ant['truncado']).",
		id_orden=".intval($fila_ramo_ant['id_orden']).",
		truncado_per=".intval($fila_ramo_ant['truncado_per']).",
		prueba_nivel=".intval($fila_ramo_ant['prueba_nivel']).",
		pct_nivel=".intval($fila_ramo_ant['pct_nivel']).",
		modo_eval_pnivel=".intval($fila_ramo_ant['modo_eval_pnivel']).",
		pct_ex_escrito=".intval($fila_ramo_ant['pct_ex_escrito']).",
		pct_ex_oral=".intval($fila_ramo_ant['pct_ex_oral']).",
		id_padre=".intval($fila_ramo_ant['id_padre']).",
		nombre_hijo='".$fila_ramo_ant['nombre_hijo']."',
		porcentaje=".intval($fila_ramo_ant['porcentaje']).",
		truncado_pnivel=".intval($fila_ramo_ant['truncado_pnivel']).",
		eee=".intval($fila_ramo_ant['eee']).",
		bool_artis=".intval($fila_ramo_ant['bool_artis']).",
		porc_examen=".intval($fila_ramo_ant['porc_examen']).",
		aprox_entero=".intval($fila_ramo_ant['aprox_entero']).",
		hrs_jec=".intval($fila_ramo_ant['hrs_jec']).",
		hrs_plan=".intval($fila_ramo_ant['hrs_plan']).",
		apreciacion=".intval($fila_ramo_ant['apreciacion']).",
		minima1=".intval($fila_ramo_ant['minima1']).",
		maxima1=".intval($fila_ramo_ant['maxima1']).",
		bonifica1=".intval($fila_ramo_ant['bonifica1']).",
		minima2=".intval($fila_ramo_ant['minima2']).",
		maxima2=".intval($fila_ramo_ant['maxima2']).",
		bonifica2=".intval($fila_ramo_ant['bonifica2']).",
		minima3=".intval($fila_ramo_ant['minima3']).",
		maxima3=".intval($fila_ramo_ant['maxima3']).",
		bonifica3=".intval($fila_ramo_ant['bonifica3']).",
		minima4=".intval($fila_ramo_ant['minima4']).",
		maxima4=".intval($fila_ramo_ant['maxima4']).",
		formacion=".intval($fila_ramo_ant['formacion']).",
		tipo_aproximacion=".intval($fila_ramo_ant['tipo_aproximacion']).",
		bool_bloq=".intval($fila_ramo_ant['bool_bloq']).",
		conexper=".intval($fila_ramo_ant['conexper']).",
		truncado_ex_semestral=".intval($fila_ramo_ant['truncado_ex_semestral']).",
		truncado_ex_final=".intval($fila_ramo_ant['truncado_ex_final']).",
		nota_ex_semestral=".intval($fila_ramo_ant['nota_ex_semestral']).",
		pct_ex_semestral=".intval($fila_ramo_ant['pct_ex_semestral']).",
		prueba_especial=".intval($fila_ramo_ant['prueba_especial']).",
		bool_nquiz=".intval($fila_ramo_ant['bool_nquiz']).",
		porc_examen_quiz=".intval($fila_ramo_ant['porc_examen_quiz']).",
		nota_exim_quiz=".intval($fila_ramo_ant['nota_exim_quiz']).",
		aprox_entero_quiz=".intval($fila_ramo_ant['aprox_entero_quiz']).",
		truncado_examen_quiz=".intval($fila_ramo_ant['truncado_examen_quiz']).",
		coef2=".intval($fila_ramo_ant['coef2']).",
		aprox_coef2=".intval($fila_ramo_ant['aprox_coef2']).",
		nota_exim_coef=".intval($fila_ramo_ant['nota_exim_coef']).",
		bool_pu=".intval($fila_ramo_ant['bool_pu']).",
		truncado_pu=".intval($fila_ramo_ant['truncado_pu']).",
		porc_nota_pu=".intval($fila_ramo_ant['porc_nota_pu']).",
		bool_pgeneral=".intval($fila_ramo_ant['bool_pgeneral']).",
		bool_psintesis=".intval($fila_ramo_ant['bool_psintesis']).",
		porc_psintesis=".intval($fila_ramo_ant['porc_psintesis']).",
		notagrupo=".intval($fila_ramo_ant['notagrupo'])."
		where id_ramo=".$fila_ramo_act['id_ramo'];
		
		$rs_iguala= pg_exec($conn,$sql_iguala);
		
		//buscar profesor de asignatura
		// eliminar los docentes del curso acrual
		
		
		//asigno docente ramo año actual
 $sql_dicta_act="select * from dicta where id_ramo=".$fila_ramo_act['id_ramo'];
 $rs_dicta_act=pg_exec($conn,$sql_dicta_act);
		
		//revisar profesor jefe año anterios
    $sql_dicta_ant="select * from dicta where id_ramo=".$fila_ramo_ant['id_ramo'];
 $rs_dicta_ant=pg_exec($conn,$sql_dicta_ant);
 
 if(pg_numrows($rs_dicta_act)==0 && pg_numrows($rs_dicta_ant)>0){
	
    $sql_ins_dicta="insert into dicta(rut_emp,id_ramo) values(".pg_result($rs_dicta_ant,0).",".$fila_ramo_act['id_ramo'].")";
 //$rs_ins_dicta=pg_exec($conn,$sql_ins_dicta);
 }

		
	}
	
}
}
//si no hay ramos vamos a insertar
else {
	
	 $sql_inram  = "INSERT INTO RAMO (ID_CURSO, TIPO_RAMO, COD_SUBSECTOR, MODO_EVAL, SUB_OBLI, BOOL_IP, BOOL_SAR, CONEX, PCT_EXAMEN, NOTA_EXIM, TRUNCADO, ID_ORDEN, PRUEBA_NIVEL, PCT_NIVEL, MODO_EVAL_PNIVEL, PCT_EX_ESCRITO, PCT_EX_ORAL, FORMACION, bool_bloq, bool_nquiz, truncado_examen_quiz,conexquiz,porc_examen_quiz,nota_exim_quiz,coef2,aprox_coef2,bool_pu, truncado_pu,porc_nota_pu,bool_pgeneral,aprox_entero,sub_elect,bool_psintesis,porc_psintesis,notagrupo,bool_aprgrp) select $curso, TIPO_RAMO, COD_SUBSECTOR, MODO_EVAL, SUB_OBLI, BOOL_IP, BOOL_SAR, CONEX, PCT_EXAMEN, NOTA_EXIM, TRUNCADO, ID_ORDEN, PRUEBA_NIVEL, PCT_NIVEL, MODO_EVAL_PNIVEL, PCT_EX_ESCRITO, PCT_EX_ORAL, FORMACION, bool_bloq, bool_nquiz, truncado_examen_quiz,conexquiz,porc_examen_quiz,nota_exim_quiz,coef2,aprox_coef2,bool_pu, truncado_pu,porc_nota_pu,bool_pgeneral,aprox_entero,sub_elect,bool_psintesis,porc_psintesis,notagrupo,bool_aprgrp from ramo where id_curso =".$fila_curso_ant['id_curso'];
	 
 pg_exec($conn,$sql_inram);
	
$rs_ramo_act=pg_exec($conn,$sql_ramo_act);

for($r=0;$r<pg_numrows($rs_ramo_act);$r++){
$fila_ramo_act = pg_fetch_array($rs_ramo_act,$r);

//busco el equivalente en el año anterior
 $sql_ramo_ant="select * from ramo where id_curso=".$fila_curso_ant['id_curso']." and cod_subsector=".$fila_ramo_act['cod_subsector'];	
$rs_ramo_ant=pg_exec($conn,$sql_ramo_ant);

$fila_ramo_ant=pg_fetch_array($rs_ramo_ant,0);
//revisar profesor jefe año anterios
    $sql_dicta_ant="select * from dicta where id_ramo=".$fila_ramo_ant['id_ramo'];
 $rs_dicta_ant=pg_exec($conn,$sql_dicta_ant);

    $sql_ins_dicta="insert into dicta(rut_emp,id_ramo) values(".pg_result($rs_dicta_ant,0).",".$fila_ramo_act['id_ramo'].")";
// $rs_ins_dicta=pg_exec($conn,$sql_ins_dicta);
 
}
	
	} 
echo 1;
}else{
	echo 0;
}
?>