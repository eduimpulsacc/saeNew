 <?php require('../../../util/header.inc');

 

 	$ano =$_ANO;

	

	

	$sql = "select nro_ano from ano_escolar where id_ano=" . $ano;

	$Rs_ano = @pg_exec($conn,$sql);

	$filano = @pg_fetch_array($Rs_ano,0);

	$fecha = "01-01-".$filano['nro_ano'];



	$sqlNuevo="select max(id_ano) as anonuevo from ano_escolar where id_institucion =".$_INSTIT;

	$resultNuevo=@pg_Exec($conn,$sqlNuevo);

	if (!$resultNuevo){

		error('<B> ERROR :</b>Error al acceder a la BD. (101)</B>'.$sqlNuevo);

		exit;

	}

		$filaNuevo = @pg_fetch_array($resultNuevo,0);

		$ano = $filaNuevo['anonuevo'];



	$sql="select id_ano from ano_escolar where id_institucion=".$_INSTIT."order by nro_ano desc";

	$resultSql=@pg_Exec($conn,$sql);

	if (!$resultSql){

		error('<B> ERROR :</b>Error al acceder a la BD. (102)</B>'.$sql);

	}else{

		

			$max = pg_numrows($resultSql);

			if($max > 1){

			$ant = ($max -2);

			$filaSql = @pg_fetch_array($resultSql,$ant);

			$anterior =  $filaSql['id_ano'];

			$filaSql1 = @pg_fetch_array($resultSql,1);

			$actual	= $filaSql1['id_ano'];

		} 

	echo	$sqlProm = "select distinct(matricula.rut_alumno), matricula.id_curso, situacion_final FROM matricula INNER JOIN promocion ON matricula.rut_alumno=promocion.rut_alumno WHERE matricula.id_ano=".$filaSql1['id_ano']." and promocion.rdb=".$_INSTIT." and bool_ar<>1";

		$resultProm = @pg_Exec($conn,$sqlProm);

		for ($i=0 ; $i<pg_numrows($resultProm) ; $i++){

			$filaProm = @pg_fetch_array($resultProm,$i);

			 $cursoOld= $filaProm['id_curso'];

			

		echo		$sqlCurso= "select * from curso where id_curso=".$cursoOld;

					 $resultCurso= @pg_Exec($conn,$sqlCurso);

					  $filaCurso = @pg_fetch_array($resultCurso,0);

					   $curso=0;

						$var=0;

					 if ((($filaCurso['ensenanza']==310)or($filaCurso['ensenanza']==410)or($filaCurso['ensenanza']==510)or($filaCurso['ensenanza']==610)or($filaCurso['ensenanza']==710)or($filaCurso['ensenanza']==810)) and ($filaCurso['grado_curso']==4) and ($filaProm['situacion_final']==1)) {

						$var=1;

						}

						

					   if (($filaCurso['ensenanza']==110) and ($filaCurso['grado_curso']==8) and ($filaProm['situacion_final']==1)) {

						 $letra= $filaCurso['letra_curso'];

						  $ense= $filaCurso['ensenanza'];

						   $grado=1;

							$sqlCursoNuevo= "select id_curso from curso where grado_curso=".$grado." and letra_curso='".$letra."' and ensenanza=310 and id_ano=".$ano;

							  $resultCursoNuevo= @pg_Exec($conn,$sqlCursoNuevo);

								if(@pg_numrows($resultCursoNuevo)!=0){

								$filaCursoNuevo = @pg_fetch_array($resultCursoNuevo,0);

								 $curso= $filaCursoNuevo['id_curso']; 

								 }	

						 }



						

					    if (($filaCurso['ensenanza']==110) and ($filaCurso['grado_curso']<8) and ($filaProm['situacion_final']==1)) {

						 $letra= $filaCurso['letra_curso'];

						  $ense= $filaCurso['ensenanza'];

						   $grado= $filaCurso['grado_curso']+1;

						   

							$sqlCursoNuevo= "select id_curso from curso where grado_curso=".$grado." and letra_curso='".$letra."' and ensenanza=".$ense." and id_ano=".$ano;

							

							  $resultCursoNuevo= @pg_Exec($conn,$sqlCursoNuevo);

								if(@pg_numrows($resultCursoNuevo)!=0){

								$filaCursoNuevo = @pg_fetch_array($resultCursoNuevo,0);

								 $curso= $filaCursoNuevo['id_curso']; 

								 }	

						 }

					

						 

					 if ((($filaCurso['ensenanza']==310)or($filaCurso['ensenanza']==360)or($filaCurso['ensenanza']==410)or($filaCurso['ensenanza']==510)or($filaCurso['ensenanza']==610)or($filaCurso['ensenanza']==710)or($filaCurso['ensenanza']==810)) and ($filaCurso['grado_curso']<4) and ($filaProm['situacion_final']==1)) {

						 $letra= $filaCurso['letra_curso'];

						  $ense= $filaCurso['ensenanza'];

						   $grado= $filaCurso['grado_curso']+1;

							$sqlCursoNuevo= "select id_curso from curso where grado_curso=".$grado." and letra_curso='".$letra."' and ensenanza=".$ense." and id_ano=".$ano;

							

							 $resultCursoNuevo= @pg_Exec($conn,$sqlCursoNuevo);

								if(@pg_numrows($resultCursoNuevo)!=0){

								$filaCursoNuevo = @pg_fetch_array($resultCursoNuevo,0);

								  $curso= $filaCursoNuevo['id_curso'];

								 }  	

						 }

							

							$sqlMat = "select rut_alumno from matricula where rut_alumno=".$filaProm['rut_alumno']." and id_ano=".$ano;

							  $resultMat = @pg_Exec($conn,$sqlMat);

								 if(@pg_numrows($resultMat)==0){

							 

							  if($var==0){

							  $qryI="INSERT INTO MATRICULA (RUT_ALUMNO,RDB,ID_ANO,ID_CURSO,FECHA,NUM_MAT,BOOL_BAJ,BOOL_BCHS,BOOL_AOI,BOOL_RG,BOOL_AE,BOOL_I,BOOL_GD,BOOL_AR) VALUES (".$filaProm['rut_alumno'].",".trim($_INSTIT).",".$ano.",$curso,to_date('".$fecha."','DD MM YYYY'),0,0,0,0,0,0,0,0,0)";

								$resultI =@pg_Exec($conn,$qryI);

								  if (!$resultI) {

									error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qryI);

								   }

							  	 }

							   }				

						    }

						 	

							$sqlS = "SELECT * FROM matriculatpsincurso WHERE id_ano=".$anterior." and estado<>3";

							$resultS = @pg_Exec($conn,$sqlS);

								for ($i=0 ; $i<pg_numrows($resultS) ; $i++){

								 $filaS = @pg_fetch_array($resultS,$i);

			

			         		$sqlMatS = "SELECT rut_alumno FROM matriculatpsincurso WHERE id_ano=".$ano;

							$resultMatS = @pg_Exec($conn,$sqlMatS);

							 if(@pg_numrows($resultMatS)==0){

							 $fecha = ($filaS['fecha']);

							

							  $qrySin="INSERT INTO MATRICULATPSINCURSO (RUT_ALUMNO,RDB,ID_ANO,FECHA,INTEGRADO,INDIGENA,ESTADO,TITULO,COD_TIPO,COD_SECTOR,COD_ESP) VALUES ('".$filaS['rut_alumno']."',".trim($_INSTIT).",".$ano.",".$fecha."',".$filaS['integrado'].",".$filaS['indigena'].",".$filaS['estado'].",".$filaS['titulo'].",".$filaS['cod_tipo'].",".$filaS['cod_sector'].",".$filaS['cod_esp'].")";

								$resultSin =@pg_Exec($conn,$qrySin);

								  if (!$resultSin) {

									error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qrySin);

								  }

							   }				

						    }

						}

		//------------------------ INGRESO DE PRE-BASICA -------------------------------------------------

		$sqlAlum="SELECT  DISTINCT(matricula.rut_alumno), matricula.id_curso FROM matricula INNER JOIN curso ON matricula.id_curso=curso.id_curso WHERE ensenanza=10 AND matricula.id_ano=".$filaSql1['id_ano']."  ORDER BY id_curso";

		$Rs_Alum =@pg_exec($conn,$sqlAlum);

		for ($j=0 ; $j<pg_numrows($Rs_Alum) ; $j++){

			$fila_Alum = @pg_fetch_array($Rs_Alum,$j);

			 $cursoOld= $fila_Alum['id_curso'];

			

				$sqlCurso= "select * from curso where id_curso=".$cursoOld;

					 $resultCurso= @pg_Exec($conn,$sqlCurso);

					  $filaCurso = @pg_fetch_array($resultCurso,0);

					   $curso=0;

						$var=0;

		

				   if (($filaCurso['ensenanza']==10) and ($filaCurso['grado_curso']<5)) {

						 $letra= $filaCurso['letra_curso'];

						  $ense= $filaCurso['ensenanza'];

						   $grado= $filaCurso['grado_curso']+1;

						   

							$sqlCursoNuevo= "select id_curso from curso where grado_curso=".$grado." and letra_curso='".$letra."' and ensenanza=".$ense." and id_ano=".$ano;

							 $resultCursoNuevo= @pg_Exec($conn,$sqlCursoNuevo);

							   if(@pg_numrows($resultCursoNuevo)!=0){

								$filaCursoNuevo = @pg_fetch_array($resultCursoNuevo,0);

								 $curso= $filaCursoNuevo['id_curso']; 

								 }	

						 }



						 

					    if (($filaCurso['ensenanza']==10) and ($filaCurso['grado_curso']==5)) {

						 $letra= $filaCurso['letra_curso'];

						  $ense= $filaCurso['ensenanza'];

						   $grado=1;

							$sqlCursoNuevo= "select id_curso from curso where grado_curso=".$grado." and letra_curso='".$letra."' and ensenanza=110 and id_ano=".$ano;

							  $resultCursoNuevo= @pg_Exec($conn,$sqlCursoNuevo);

								if(@pg_numrows($resultCursoNuevo)!=0){

								$filaCursoNuevo = @pg_fetch_array($resultCursoNuevo,0);

								 $curso= $filaCursoNuevo['id_curso']; 

								 }	

						 }

							$sqlMat = "select rut_alumno from matricula where rut_alumno=".$fila_Alum['rut_alumno']." and id_ano=".$ano;

							$resultMat = @pg_Exec($conn,$sqlMat);

								if(@pg_numrows($resultMat)==0){

							 	  if($var==0){

							 		 $qryI="INSERT INTO MATRICULA (RUT_ALUMNO,RDB,ID_ANO,ID_CURSO,FECHA,NUM_MAT,BOOL_BAJ,BOOL_BCHS,BOOL_AOI,BOOL_RG,BOOL_AE,BOOL_I,BOOL_GD,BOOL_AR) VALUES (".$fila_Alum['rut_alumno'].",".trim($_INSTIT).",".$ano.",$curso,to_date('".$fecha."','DD MM YYYY'),0,0,0,0,0,0,0,0,0)";

									  $resultI =@pg_Exec($conn,$qryI);

								  		if (!$resultI) {

											error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qryI);

								   		}

							  	 	}

							   	}				

				}

            pg_close($conn);
			echo "<script>window.location = 'listarAno.php3'</script>";

?>

