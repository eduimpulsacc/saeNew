<?php require('../../../../../../../util/header.inc');

	$ramo			=$_RAMO;
	$ano			=$_ANO;
	$institucion	=$_INSTIT;
	$periodo		=$_PERIODORAMO;
	
	$sql="";
	$sql="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
	$Rs_Ano = @pg_exec($conn,$sql);
	$fils_Ano = @pg_fetch_array($Rs_Ano,0);
	$nro_ano = trim($fils_Ano['nro_ano']);
	
	$sql="SELECT id_curso FROM ramo WHERE id_ramo=".$ramo;
	$Rs_Curso = @pg_exec($conn,$sql);
	$fils_Curso = @pg_fetch_array($Rs_Curso,0);
	$curso = $fils_Curso['id_curso'];
	
	$sql_aprox = "SELECT * FROM aproximacion WHERE rdb=".$institucion." AND id_ano=".$ano;
	$Rs_Aprox = @pg_exec($conn,$sql_aprox);
	$fils_aprox = @pg_fetch_array($Rs_Aprox,0);
	
	$sql="";
	$sql="SELECT rut_alumno FROM matricula WHERE id_curso=".$fils_Curso['id_curso'];
	$Rs_Matricula = @pg_exec($conn,$sql);
	
	for($i=0;$i<@pg_numrows($Rs_Matricula);$i++){
		$fils_Matricula = @pg_fetch_array($Rs_Matricula,$i);

		// ---------------------------  POR PERIODO   ---------------------------------
		$sql_1="";
		$sql_1="SELECT to_number(promedio,999999) as prom FROM notas$nro_ano WHERE rut_alumno=".$fils_Matricula['rut_alumno']." AND id_ramo=".$ramo." AND id_periodo=".$periodo;

		$Rs_Notas_Per = @pg_exec($conn,$sql_1);
		$fils_Promedio = @pg_fetch_array($Rs_Notas_Per,0);
		$PromedioSubAlum_periodo = $fils_Promedio['prom'];

		$sql="";
		$sql="SELECT * FROM promedio_sub_alum_periodo WHERE rut_alumno=".$fils_Matricula['rut_alumno']." AND id_ramo=".$ramo." AND id_periodo=".$periodo;
		$Rs_Consulta_per = @pg_exec($conn,$sql);
	
		if(@pg_numrows($Rs_Consulta_per)==0){
			$sql="";
			$sql="INSERT INTO promedio_sub_alum_periodo VALUES(".$institucion.",".$ano.",".$fils_Curso['id_curso'].",".$ramo.",".$fils_Matricula['rut_alumno'].",".$periodo.",".$PromedioSubAlum_periodo.")";
		}else{
			$sql="";
			$sql="UPDATE promedio_sub_alum_periodo SET promedio=".$PromedioSubAlum_periodo." WHERE rut_alumno=".$fils_Matricula['rut_alumno']." AND id_ramo=".$ramo." AND id_periodo=".$periodo;
		}
		$Rs_PromedioSubAlumPer = @pg_exec($conn,$sql);
		
		
		// ---------------------------  PROMEDIO DE PERIODOS   ---------------------------------		
		$sql_2="";
		$sql_2="SELECT sum(to_number(promedio,999999)) as suma, count(promedio) as total FROM notas$nro_ano WHERE rut_alumno=".$fils_Matricula['rut_alumno']." AND id_ramo=".$ramo;
		$Rs_Notas = @pg_exec($conn,$sql_2);
		$fils_Promedio = @pg_fetch_array($Rs_Notas,0);
		$PromedioSubAlum=0;
	
		if($fils_aprox['alum_prom_periodo']==0){
			$PromedioSubAlum = @round($fils_Promedio['suma']/$fils_Promedio['total']);
		}else{
			$PromedioSubAlum = @intval($fils_Promedio['suma']/$fils_Promedio['total']);
		}

		$sql="";
		$sql="SELECT * FROM promedio_sub_alumno WHERE rut_alumno=".$fils_Matricula['rut_alumno']." AND id_ramo=".$ramo;
		$Rs_Consulta = @pg_exec($conn,$sql);
	
		if(@pg_numrows($Rs_Consulta)==0){
			$sql="";
			$sql="INSERT INTO promedio_sub_alumno VALUES(".$institucion.",".$ano.",".$fils_Curso['id_curso'].",".$ramo.",".$fils_Matricula['rut_alumno'].",".$PromedioSubAlum.")";
		}else{
			$sql="";
			$sql="UPDATE promedio_sub_alumno SET promedio=".$PromedioSubAlum." WHERE rut_alumno=".$fils_Matricula['rut_alumno']." AND id_ramo=".$ramo;
		}
		$Rs_PromedioSubAlum = @pg_exec($conn,$sql);
		
	}

//------------------- PROMEDIO SUBSECTOR ------------------

	// ---------------------------  POR PERIODO   ---------------------------------
	$sql_3="SELECT sum(promedio) as suma, count(promedio) as total FROM promedio_sub_alum_periodo WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND id_ramo=".$ramo." AND id_periodo=".$periodo;
	$Rs_Subsector = @pg_exec($conn,$sql_3);
	$fils_Subsector_per = @pg_fetch_array($Rs_Subsector,0);	 
	
	if($fils_aprox['sub_periodo']==0){
		$Promedio_Subsector_per = @round($fils_Subsector_per['suma']/$fils_Subsector_per['total']);
	}else{
		$Promedio_Subsector_per = intval($fils_Subsector_per['suma']/$fils_Subsector_per['total']);
	}

	$sql="";
	$sql="SELECT * FROM promedio_sub_periodo WHERE id_ramo=".$ramo." AND id_periodo=".$periodo;
	$Rs_Sub = @pg_exec($conn,$sql);
	
	if(@pg_numrows($Rs_Sub)==0){
		$sql="";
		$sql="INSERT INTO promedio_sub_periodo VALUES(".$institucion.",".$ano.",".$curso.",".$ramo.",".$periodo.",".$Promedio_Subsector_per.")";
	}else{
		$sql="";
		$sql="UPDATE promedio_sub_periodo SET promedio=".$Promedio_Subsector_per." WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND id_ramo=".$ramo." AND id_periodo=".$periodo;
	}
	$Rs_Prom_Subsector_per = @pg_exec($conn,$sql);


	// ---------------------------  PROMEDIO DE PERIODOS   ---------------------------------		
	$sql_4="SELECT sum(promedio) as suma, count(promedio) as total FROM promedio_sub_alumno WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND id_ramo=".$ramo;
	$Rs_Subsector = @pg_exec($conn,$sql_4);
	$fils_Subsector = @pg_fetch_array($Rs_Subsector,0);	 
	
	if($fils_aprox['sub_prom_periodo']==0){
		$Promedio_Subsector = round($fils_Subsector['suma']/$fils_Subsector['total']);
	}else{
		$Promedio_Subsector = intval($fils_Subsector['suma']/$fils_Subsector['total']);
	}

	$sql="";
	$sql="SELECT * FROM promedio_subsector WHERE id_ramo=".$ramo;
	$Rs_Sub = @pg_exec($conn,$sql);
	
	if(@pg_numrows($Rs_Sub)==0){
		$sql="";
		$sql="INSERT INTO promedio_subsector VALUES(".$institucion.",".$ano.",".$curso.",".$ramo.",".$Promedio_Subsector.")";
	}else{
		$sql="";
		$sql="UPDATE promedio_subsector SET promedio=".$Promedio_Subsector." WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND id_ramo=".$ramo."";
	}
	$Rs_Prom_Subsector = @pg_exec($conn,$sql);


//---------------- PROMEDIO ALUMNO -------------------------
	for($i=0;$i<@pg_numrows($Rs_Matricula);$i++){
		$fils_Matricula = @pg_fetch_array($Rs_Matricula,$i);

		// ---------------------------  POR PERIODO   ---------------------------------
		$sql_5="SELECT sum(promedio) as suma, count(promedio) as total FROM promedio_sub_alum_periodo WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno=".$fils_Matricula['rut_alumno']." AND id_periodo=".$periodo;
		$Rs_Alumno_per = @pg_exec($conn,$sql_5);
		$fils_Alumno = @pg_fetch_array($Rs_Alumno_per,0);
		$Promedio_Alum_per = 0;
			
		if($fils_aprox['alum_periodo']==0){
			$Promedio_Alum_per = @round($fils_Alumno['suma']/$fils_Alumno['total']);
		}else{
			$Promedio_Alum_per = intval($fils_Alumno['suma']/$fils_Alumno['total']);
		}

		$sql="";
		$sql="SELECT * FROM promedio_alumno_periodo WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno=".$fils_Matricula['rut_alumno']." AND id_periodo=".$periodo;
		$Rs_Alum = @pg_exec($conn,$sql);
		
		if(@pg_numrows($Rs_Alum)==0){
			$sql="";
			$sql="INSERT INTO promedio_alumno_periodo VALUES (".$institucion.",".$ano.",".$curso.",".$fils_Matricula['rut_alumno'].",".$periodo.",".$Promedio_Alum_per.")";
		}else{
			$sql="";
			$sql="UPDATE promedio_alumno_periodo SET promedio=".$Promedio_Alum_per." WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno=".$fils_Matricula['rut_alumno']." AND id_periodo=".$periodo;
		}
		$Rs_PromAlumno = @pg_exec($conn,$sql);
	

		// ---------------------------  PROMEDIO DE PERIODOS   ---------------------------------			
		$sql_6="SELECT sum(promedio) as suma, count(promedio) as total FROM promedio_sub_alumno WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno=".$fils_Matricula['rut_alumno'];
		$Rs_Alumno = @pg_exec($conn,$sql_6);
		$Promedio_Alum=0;
		$fils_Alumno = @pg_fetch_array($Rs_Alumno,0);
	
		if($fils_aprox['alum_prom_periodo']==0){
			$Promedio_Alum = round($fils_Alumno['suma']/$fils_Alumno['total']);
		}else{
			$Promedio_Alum = intval($fils_Alumno['suma']/$fils_Alumno['total']);
		}

		$sql="";
		$sql="SELECT * FROM promedio_alumno WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno=".$fils_Matricula['rut_alumno']."";
		$Rs_Alum = @pg_exec($conn,$sql);
		
		if(@pg_numrows($Rs_Alum)==0){
			$sql="";
			$sql="INSERT INTO promedio_alumno VALUES (".$institucion.",".$ano.",".$curso.",".$fils_Matricula['rut_alumno'].",".$Promedio_Alum.")";
		}else{
			$sql="";
			$sql="UPDATE promedio_alumno SET promedio=".$Promedio_Alum." WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND rut_alumno=".$fils_Matricula['rut_alumno']."";
		}
		$Rs_PromAlumno = @pg_exec($conn,$sql);
	
	}

//------------------ PROMEDIO CURSO ----------------------------

		// ---------------------------  POR PERIODO   ---------------------------------
		$sql_7="";
		$sql_7="SELECT sum(promedio) as suma, count(promedio) as total FROM promedio_sub_periodo WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND id_periodo=".$periodo;
		$Rs_PromCurso_Per = @pg_exec($conn,$sql_7);
		$fils_Curso_per = @pg_fetch_array($Rs_PromCurso_Per,0);
	
		if($fils_Curso_per['curso_periodo']==0){
			$Promedio_GralCurso_per = @round($fils_Curso_per['suma']/$fils_Curso_per['total']);
		}else{
			$Promedio_GralCurso_per = intval($fils_Curso_per['suma']/$fils_Curso_per['total']);
		}
		
		$sql="";
		$sql="SELECT * FROM promedio_curso_periodo WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND id_periodo=".$periodo;
		$Rs_Curso1 = @pg_exec($conn,$sql);
		
		if(@pg_numrows($Rs_Curso1)==0){
			$sql="";
			$sql="INSERT INTO promedio_curso_periodo VALUES (".$institucion.",".$ano.",".$curso.",".$periodo.",".$Promedio_GralCurso_per.")";
		}else{
			$sql="";
			$sql="UPDATE promedio_curso_periodo SET promedio=".$Promedio_GralCurso_per." WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso." AND id_periodo=".$periodo;
		}
		$Rs_PromedioCurso = @pg_exec($conn,$sql);


		// ---------------------------  PROMEDIO DE PERIODOS   ---------------------------------			
		$sql_8="";
		$sql_8="SELECT sum(promedio) as suma, count(promedio) as total FROM promedio_subsector WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso;
		$Rs_PromCurso = @pg_exec($conn,$sql_8);
		$fils_Curso = @pg_fetch_array($Rs_PromCurso,0);
	
		if($fils_Curso['curso_prom_periodo']==0){
			$Promedio_GralCurso = @round($fils_Curso['suma']/$fils_Curso['total']);
		}else{
			$Promedio_GralCurso = intval($fils_Curso['suma']/$fils_Curso['total']);
		}
		
		$sql="";
		$sql="SELECT * FROM promedio_curso WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso;
		$Rs_Curso1 = @pg_exec($conn,$sql);
		
		if(@pg_numrows($Rs_Curso1)==0){
			$sql="";
			$sql="INSERT INTO promedio_curso VALUES (".$institucion.",".$ano.",".$curso.",".$Promedio_GralCurso.")";
		}else{
			$sql="";
			$sql="UPDATE promedio_curso SET promedio=".$Promedio_GralCurso." WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_curso=".$curso;
		}
		$Rs_PromedioCurso = @pg_exec($conn,$sql);



//------------------ PROMEDIO COLEGIO ---------------------------
		// ---------------------------  POR PERIODO   ---------------------------------
		$sql="";
		$sql_9="SELECT sum(promedio) as suma, count(promedio) as total FROM promedio_curso_periodo WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_periodo=".$periodo;
		$Rs_PromColegio_per = @pg_exec($conn,$sql_9);
		$fils_PromColegio_per = @pg_fetch_array($Rs_PromColegio_per,0);
	
		if($fils_PromColegio_per['colegio_periodo']==0){
			$Promedio_Colegio_per = @round($fils_PromColegio_per['suma']/$fils_PromColegio_per['total']);
		}else{
			$Promedio_Colegio_per = intval($fils_PromColegio_per['suma']/$fils_PromColegio_per['total']);
		}
		
		$sql="";
		$sql="SELECT promedio FROM promedio_colegio_periodo WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_periodo=".$periodo;
		$Rs_Colegio1 = @pg_exec($conn,$sql);
		
		if(@pg_numrows($Rs_Colegio1)==0){
			$sql="";
			$sql="INSERT INTO promedio_colegio_periodo VALUES (".$institucion.",".$ano.",".$periodo.",".$Promedio_Colegio_per.")";
		}else{
			$sql="";
			$sql="UPDATE promedio_colegio_periodo SET promedio=".$Promedio_Colegio_per." WHERE rdb=".$institucion." AND id_ano=".$ano." AND id_periodo=".$periodo;
		}
		
		$Rs_Colegio = @pg_exec($conn,$sql);
		

		// ---------------------------  PROMEDIO DE PERIODOS   ---------------------------------			
		$sql="";
		$sql_10="SELECT sum(promedio) as suma, count(promedio) as total FROM promedio_curso WHERE rdb=".$institucion." AND id_ano=".$ano;
		$Rs_PromColegio = @pg_exec($conn,$sql_10);
		$fils_PromColegio = @pg_fetch_array($Rs_PromColegio,0);
	
		if($fils_PromColegio['colegio_prom_periodo']==0){
			$Promedio_GralColegio = @round($fils_PromColegio['suma']/$fils_PromColegio['total']);
		}else{
			$Promedio_GralColegio = intval($fils_PromColegio['suma']/$fils_PromColegio['total']);
		}
		
		$sql="";
		$sql="SELECT promedio FROM promedio_colegio WHERE rdb=".$institucion." AND id_ano=".$ano;
		$Rs_Colegio1 = @pg_exec($conn,$sql);
		
		if(@pg_numrows($Rs_Colegio1)==0){
			$sql="";
			$sql="INSERT INTO promedio_colegio VALUES (".$institucion.",".$ano.",".$Promedio_GralColegio.")";
		}else{
			$sql="";
			$sql="UPDATE promedio_colegio SET promedio=".$Promedio_GralColegio." WHERE rdb=".$institucion." AND id_ano=".$ano;
		}
		
		$Rs_Colegio = @pg_exec($conn,$sql);



echo "<script>window.location = '../new_mostrarNotas.php3?periodo=".trim($periodo)."'</script>";
?>