<?
	require('../../../util/header.inc');
	
	$sql_ano = "select * from ano_escolar where id_ano=".$_ANO;
	$resultAno = @pg_Exec($conn,$sql_ano);
	$filaAno = @pg_fetch_array($resultAno,0);
	$nro_ano = $filaAno['nro_ano'];
	$tipo_regimen = $filaAno['tipo_regimen'];	
	$nro_ano_ant = $nro_ano - 1;	
/* VEL ****** Elimino todos los ramos del nuevo año si existen*/ 
	echo $sql_elimina = "delete from ramo where id_curso in(select id_curso from curso where id_ano = '$_ANO')";
	$res_elimina = pg_Exec($conn, $sql_elimina);


/* VEL ********** */
	echo "<br>".$sql = "SELECT a.id_ano FROM ano_escolar a INNER JOIN periodo p ON a.id_ano=p.id_ano WHERE a.nro_ano=".$nro_ano_ant." AND a.id_institucion=".$_INSTIT." AND a.tipo_regimen=".$tipo_regimen;
$result = pg_exec($conn,$sql);	
		if(pg_num_rows($result)=="")
	{
		$sql2 = "SELECT a.id_ano FROM ano_escolar a INNER JOIN periodo p ON a.id_ano=p.id_ano WHERE a.nro_ano=".$nro_ano_ant." AND a.id_institucion=".$_INSTIT;
		$result = pg_exec($conn,$sql2);	
	}
	$filano = @pg_fetch_array($result,0);
	$anterior = $filano['id_ano'];
	$actual = $ano;


 // crear los subsectores del año anterior
 	echo "<br>".$sql_curso_ant = "SELECT c.ensenanza, c.grado_curso, c.letra_curso, r.sub_obli,r.sub_elect, r.tipo_ramo, r.modo_eval, r.id_orden, r.conex,
	r.bool_nquiz,r.porc_examen_quiz,r.nota_exim_quiz,
r.aprox_entero_quiz,r.nota_exim_quiz,r.truncado_examen_quiz,r.conexquiz,r.coef2,r.aprox_coef2,r.nota_exim_coef,r.bool_pu,r.truncado_pu,r.porc_nota_pu,r.bool_pgeneral,
	r.modo_eval, r.cod_subsector FROM ramo r INNER JOIN curso c ON r.id_curso=c.id_curso WHERE c.id_ano=".$anterior." ORDER BY c.ensenanza, c.grado_curso, c.letra_curso, r.id_curso, r.cod_subsector";
	$resultCurso_ant = @pg_Exec($conn,$sql_curso_ant);

	 $cont = 0;
	for($m=0;$m<pg_numrows($resultCurso_ant);$m++){
		$n = $m+1;// vel
		$filaCurso_ant = @pg_fetch_array($resultCurso_ant,$m);
		$filaCurso_sig = @pg_fetch_array($resultCurso_ant,$n); //vel
		
		echo "<br>".$sql_busca_curso = "SELECT c.id_curso FROM curso c WHERE c.ensenanza=".$filaCurso_ant['ensenanza']." AND c.grado_curso=".$filaCurso_ant['grado_curso']." AND c.letra_curso='".trim($filaCurso_ant['letra_curso'])."' AND id_ano=".$_ANO;
		$result_busca_curso = @pg_Exec($conn,$sql_busca_curso);	
			

		$fila_busca = @pg_fetch_array($result_busca_curso,0);
		$curso_actual = $fila_busca['id_curso'];

	if($filaCurso_ant['sub_obli']=='' || $filaCurso_ant['sub_obli']==NULL){
			$filaCurso_ant['sub_obli'] = 0;
		}
		if($filaCurso_ant['sub_elect']=='' || $filaCurso_ant['sub_elect']==NULL){
			$filaCurso_ant['sub_elect'] = 0;
		}
		if($filaCurso_ant['tipo_ramo']=='' || $filaCurso_ant['tipo_ramo']==NULL){
			$filaCurso_ant['tipo_ramo'] = 0;
		}
		if($filaCurso_ant['modo_eval']=='' || $filaCurso_ant['modo_eval']==NULL){
			$filaCurso_ant['modo_eval'] = 0;
		}
		if($filaCurso_ant['id_orden']=='' || $filaCurso_ant['id_orden']==NULL){
			$filaCurso_ant['id_orden'] = 0;
		}
		if($filaCurso_ant['conex']=='' || $filaCurso_ant['conex']==NULL){
			$filaCurso_ant['conex'] = 0;
		}
		if($filaCurso_ant['modo_eval']=='' || $filaCurso_ant['modo_eval']==NULL){
			$filaCurso_ant['modo_eval'] = 0;
		}
		
		if($filaCurso_ant['bool_nquiz']=='' || $filaCurso_ant['bool_nquiz']==NULL){
			$filaCurso_ant['bool_nquiz'] = 0;
		}
		
		if($filaCurso_ant['porc_examen_quiz']=='' || $filaCurso_ant['porc_examen_quiz']==NULL){
			$filaCurso_ant['porc_examen_quiz'] = 0;
		}
		
		if($filaCurso_ant['nota_exim_quiz']=='' || $filaCurso_ant['nota_exim_quiz']==NULL){
			$filaCurso_ant['nota_exim_quiz'] = 0;
		}
		
		if($filaCurso_ant['aprox_entero_quiz']=='' || $filaCurso_ant['aprox_entero_quiz']==NULL){
			$filaCurso_ant['aprox_entero_quiz'] = 0;
		}
	
	if($filaCurso_ant['nota_exim_quiz']=='' || $filaCurso_ant['nota_exim_quiz']==NULL){
			$filaCurso_ant['nota_exim_quiz'] = 0;
		}
		
		if($filaCurso_ant['truncado_examen_quiz']=='' || $filaCurso_ant['truncado_examen_quiz']==NULL){
			$filaCurso_ant['truncado_examen_quiz'] = 0;
		}
		
		if($filaCurso_ant['conexquiz']=='' || $filaCurso_ant['conexquiz']==NULL){
			$filaCurso_ant['conexquiz'] = 0;
		}
		
		if($filaCurso_ant['coef2']=='' || $filaCurso_ant['coef2']==NULL){
			$filaCurso_ant['coef2'] = 0;
		}
		
		if($filaCurso_ant['aprox_coef2']=='' || $filaCurso_ant['aprox_coef2']==NULL){
			$filaCurso_ant['aprox_coef2'] = 0;
		}
		
		if($filaCurso_ant['nota_exim_coef']=='' || $filaCurso_ant['nota_exim_coef']==NULL){
			$filaCurso_ant['nota_exim_coef'] = 0;
		}
		
		if($filaCurso_ant['bool_pu']=='' || $filaCurso_ant['bool_pu']==NULL){
			$filaCurso_ant['bool_pu'] = 0;
		}
		
		if($filaCurso_ant['truncado_pu']=='' || $filaCurso_ant['truncado_pu']==NULL){
			$filaCurso_ant['truncado_pu'] = 0;
		}
		
		if($filaCurso_ant['porc_nota_pu']=='' || $filaCurso_ant['truncado_pu']==NULL){
			$filaCurso_ant['porc_nota_pu'] = 0;
		}
		
		if($filaCurso_ant['bool_pgeneral']=='' || $filaCurso_ant['bool_pgeneral']==NULL){
			$filaCurso_ant['bool_pgeneral'] = 0;
		}
			
		
//Vel		
echo "-".$filaCurso_ant['cod_subsector']." ".$filaCurso_sig['cod_subsector']."<br>";
		if($filaCurso_ant['cod_subsector'] == $filaCurso_sig['cod_subsector'])
		{
			//No hago nada :p
		}else{
		$sql_insert_ramo = "INSERT INTO ramo (modo_eval,tipo_ramo,id_curso,cod_subsector,sub_obli,sub_elect,id_orden,bool_ip,conex,truncado,bool_nquiz,porc_examen_quiz,nota_exim_quiz,truncado_examen_quiz,conexquiz,coef2,aprox_coef2,nota_exim_coef,bool_pu,truncado_pu,bool_pgeneral,porc_nota_pu) VALUES(".$filaCurso_ant['modo_eval'].",".$filaCurso_ant['tipo_ramo'].",".$curso_actual.",".$filaCurso_ant['cod_subsector'].",".$filaCurso_ant['sub_obli'].",".$filaCurso_ant['sub_elect'].",".$filaCurso_ant['id_orden'].",1,".$filaCurso_ant['conex'].",1,".$filaCurso_ant['bool_nquiz'].",".$filaCurso_ant['porc_examen_quiz'].",".$filaCurso_ant['porc_examen_quiz'].",".$filaCurso_ant['truncado_examen_quiz'].",".$filaCurso_ant['conexquiz'].",".$filaCurso_ant['coef2'].",".$filaCurso_ant['aprox_coef2'].",".$filaCurso_ant['nota_exim_coef'].",".$filaCurso_ant['bool_pu'].",".$filaCurso_ant['truncado_pu'].",".$filaCurso_ant['bool_pgeneral'].",".$filaCurso_ant['porc_nota_pu'].")";
		$result_insert_ramo = @pg_Exec($conn,$sql_insert_ramo);
		//echo $sql_insert_ramo."<br>";
		}
	}

// Vel	
/*********** */

	$sql_curso = "select id_curso from curso where id_ano=".$_ANO;
	$resultCurso = @pg_Exec($conn,$sql_curso);
	
	for ($i=0 ; $i<pg_numrows($resultCurso) ; $i++){
		$filaCurso = @pg_fetch_array($resultCurso,$i);
		$curso = $filaCurso['id_curso'];

		$sql_alumnos = "select rut_alumno from matricula where id_curso=".$curso." and id_ano=".$_ANO;
		$resultAlumnos = @pg_Exec($conn,$sql_alumnos);

		$sql_ramo = "select id_ramo from ramo where id_curso=".$curso;
		$resultRamo = @pg_Exec($conn,$sql_ramo);
		
		for($j=0;$j<pg_numrows($resultRamo);$j++){
			$filaRamo = @pg_fetch_array($resultRamo,$j);
			$ramo = $filaRamo['id_ramo'];
			
			for($k=0;$k<pg_numrows($resultAlumnos);$k++){
				$filaAlumno = @pg_fetch_array($resultAlumnos,$k);			
				$alum = $filaAlumno['rut_alumno'];
				
				//echo "<br>".
				$sql_insert = "insert into tiene$nro_ano (rut_alumno, id_ramo, id_curso) values(".$alum.",".$ramo.",".$curso.")";
				$result = @pg_Exec($conn,$sql_insert);
			}
		}
	}
	
	
	
if($PERFIL==0){

        pg_close($conn);
		echo "<script>window.location = 'procesomigrarprofes.php'</script>"; 
		
}else{
        pg_close($conn);
		echo "<script>window.location = 'listarAno.php3'</script>"; 
}


?>