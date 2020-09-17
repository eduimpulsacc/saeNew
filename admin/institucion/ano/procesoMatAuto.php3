 <?    require('../../../util/header.inc');

if($caso==2){

	$ano_act = $nro_ano;
	$fecha = "01-01-".$ano_act;
	$ano = $actual;
	$institucion = $_INSTIT;

if($_PERFIL==0)//vel 
{
/*	$sql_existe =  "select distinct(m.id_curso), c.grado_curso, c.letra_curso, c.ensenanza 
					from matricula m,curso c
					where m.id_curso = c.id_curso and m.rdb = '$institucion' and m.id_ano ='$ano'
					order by c.ensenanza, m.id_curso";
	$res_existe = pg_Exec($conn,$sql_existe);*/
//echo $tot_fil = pg_numrows($res_existe);
}	//fin_vel

/*vel*/ //COMPLETAR PARA LOS DEMAS TIPOS DE ENSEÑANZA
$sql_tipo_ense = "select distinct(cod_tipo) from tipo_ense_inst where rdb = '$institucion' order by cod_tipo";
$res_tipo_ense = pg_Exec($sql_tipo_ense);
$tipo_ense = 0;
for($x=0;$x<pg_numrows($res_tipo_ense);$x++){	 
$fila_tipo_ense = pg_fetch_array($res_tipo_ense,$x); 
//ENSEÑANZA BASICA	
	if($fila_tipo_ense['cod_tipo'] == 110){ 
		$tipo_ense = 1;
	}
//ENSEÑANZA MEDIA	
	if(($fila_tipo_ense['cod_tipo'] == 310)or($fila_tipo_ense['cod_tipo'] == 410)or($fila_tipo_ense['cod_tipo'] == 510)or($fila_tipo_ense['cod_tipo'] == 610)or($fila_tipo_ense['cod_tipo'] == 710)or($fila_tipo_ense['cod_tipo'] == 810)){
			$tipo_ense = 2;  //Si el $tipo_ense da como resultado 2, significa q existe 1ero medio en la institucion
	}
}
//echo $tipo_ense;
/*vel*/

//------------------------ INGRESO DE PRE-BASICA -------------------------------------------------

		$sqlAlum="SELECT  DISTINCT(matricula.rut_alumno), matricula.id_curso FROM matricula INNER JOIN curso ON matricula.id_curso=curso.id_curso WHERE matricula.bool_ar <> 1 and ensenanza=10 AND matricula.id_ano=".$anterior."  ORDER BY id_curso";
		
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
						 
				$sqlnumMat = "select max(nro_lista)as nro from matricula where id_curso=".$curso;
				$resultnumMat = @pg_Exec($conn,$sqlnumMat);
				
				$filanumMat = @pg_fetch_array($resultnumMat,0);
				$numero=$filanumMat['nro'];
				$num = $numero + 1;

				$sqlMat = "select rut_alumno from matricula where rut_alumno=".$fila_Alum['rut_alumno']." and id_ano=".$ano;
				$resultMat = @pg_exec($conn,$sqlMat);
				//echo "<br>paso6.5->".pg_numrows($resultMat);
				if(pg_numrows($resultMat)==0){
					//if($var==0){
						
					
						$qryI="INSERT INTO MATRICULA (RUT_ALUMNO,RDB,ID_ANO,ID_CURSO,FECHA,BOOL_AR) VALUES (".$fila_Alum['rut_alumno'].",".trim($_INSTIT).",".$ano.",$curso,'$fecha',0)";
						$resultI =@pg_Exec($conn,$qryI);

						if (!$resultI) {
							error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qryI);
						}
					//}
				}				

		}				

//		$sqlProm = "select distinct(matricula.rut_alumno), matricula.id_curso, situacion_final FROM matricula INNER JOIN promocion ON matricula.rut_alumno=promocion.rut_alumno WHERE matricula.id_ano=".$filaSql1['id_ano']." and promocion.rdb=".$_INSTIT." and bool_ar<>1";
//SELECCIONA A TODOS LOS ALUMNOS NO REPITENTES DEL AÑO ANTERIOR
		 $sqlProm = "select distinct(matricula.rut_alumno), matricula.id_curso, situacion_final,tipo_reprova FROM matricula INNER JOIN promocion ON matricula.rut_alumno=promocion.rut_alumno and promocion.id_ano=matricula.id_ano WHERE matricula.id_ano=".$anterior." and promocion.rdb=".$_INSTIT." and bool_ar<>1";
		$resultProm = @pg_Exec($conn,$sqlProm);

		if (!$resultProm){
			error('<B> ERROR :</b>Error al acceder a la BD. (911)</B>'.$sqlProm);
		}else{
//HACE UN CICLO ALUMNO POR ALUMNO
				for ($i=0 ; $i<pg_numrows($resultProm) ; $i++){ 
					$filaProm = @pg_fetch_array($resultProm,$i);  
					$cursoOld= $filaProm['id_curso'];
//CONSULTA EL CURSO AL CUAL PERTENECIA					
					$sqlCurso= "select * from curso where id_curso=".$cursoOld;
					$resultCurso= @pg_Exec($conn,$sqlCurso);
					$filaCurso = @pg_fetch_array($resultCurso,0);
					$curso=0;
					$var=0;
//Entra solo si el alumno esta en 4to medio y su situacion final es Aprobado
					if ((($filaCurso['ensenanza']==310)or($filaCurso['ensenanza']==410)or($filaCurso['ensenanza']==510)or($filaCurso['ensenanza']==610)or($filaCurso['ensenanza']==710)or($filaCurso['ensenanza']==810)) and ($filaCurso['grado_curso']==4) and ($filaProm['situacion_final']==1)) 		
					{
						$var=1;
					}


					
//Entra solo si es de basica, y el alumno esta en 8vo basico, y se encuentra Aprobado
					
					if (($filaCurso['ensenanza']==110) and ($filaCurso['grado_curso']==8) and ($filaProm['situacion_final']==1)) {
					if($tipo_ense==2){	//vel	
							$letra= $filaCurso['letra_curso'];
							$ense= $filaCurso['ensenanza'];
							$grado=1;														
//SACA EL ID_CURSO DE TODOS LOS ALUMNOS QUE PASARON DE 8VO A 1ERO MEDIO	
							$sqlCursoNuevo= "select id_curso from curso where grado_curso=".$grado." and letra_curso='".$letra."' and ensenanza=310 and id_ano=".$ano;
							$resultCursoNuevo= @pg_Exec($conn,$sqlCursoNuevo);
							if(@pg_numrows($resultCursoNuevo)!=0){
								$filaCursoNuevo = @pg_fetch_array($resultCursoNuevo,0);
								$curso= $filaCursoNuevo['id_curso']; 
							}				
						}//fin_vel

						if($tipo_ense==1){
							$var=1;
						}	
					}
//ENTRA SI EL CUSRO ES MENOR K 8º Y SU SITUACION SEA APROBADO	
					if (($filaCurso['ensenanza']==110) and ($filaCurso['grado_curso']<8) and ($filaProm['situacion_final']==1 and $filaProm['tipo_reprova']!=1)) {
							$letra= $filaCurso['letra_curso'];
							$ense= $filaCurso['ensenanza'];
							$grado= $filaCurso['grado_curso']+1;
							
							$sqlCursoNuevo= "select id_curso from curso where grado_curso=".$grado." and letra_curso='".$letra."' and ensenanza=".$ense." and id_ano=".$ano;
							$resultCursoNuevo= @pg_Exec($conn,$sqlCursoNuevo);
//SACA EL ID_CURSO DE TODOS LOS ALUMNOS DE 7º HACIA ABAJO
							if(@pg_numrows($resultCursoNuevo)!=0){
									$filaCursoNuevo = @pg_fetch_array($resultCursoNuevo,0);
									$curso= $filaCursoNuevo['id_curso']; 
							}

//si el curso siguiente no esta, el numero de filas = 0; si el curso esta numero de filas = 1																			
/*vel*/
							$sql_existe = "select distinct(grado_curso) from curso where grado_curso = '$grado' and id_ano = '$ano' and ensenanza = '$ense'";
							$res_existe = pg_Exec($conn,$sql_existe);
							$num_existe = pg_numrows($res_existe);			
							if($num_existe == "0"){
 								$var="1";
							}
							
							
					}
//ENTRA SI EL ALUMNO ESTA APROBADO Y EL CURSO ES MENOR K 4 MEDIO 	
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
/*vel*/						
							$sql_existe = "select distinct(grado_curso) from curso where grado_curso = '$grado' and id_ano = '$ano' and ensenanza = '$ense'";
							$res_existe = pg_Exec($conn,$sql_existe);
							$num_existe = pg_numrows($res_existe);
//SI NO EXISTE EL NIVEL DE CURSO SIGUIENTE, NO SE MATRICULA.
							if($num_existe == "0"){
							$var="1";
							}							 	
					}
					
					$sqlMat = "select rut_alumno from matricula where rut_alumno=".$filaProm['rut_alumno']." and id_ano=".$ano;
					$resultMat = @pg_Exec($conn,$sqlMat);
					
					if(@pg_numrows($resultMat)==0){
							$sqlnumMat = "select max(nro_lista)as nro from matricula where id_curso=".$curso;
							$resultnumMat = @pg_Exec($conn,$sqlnumMat);
							
							$filanumMat = @pg_fetch_array($resultnumMat,0);
							$numero=$filanumMat['nro'];
							$num = $numero + 1;
							if($var==0){

								$qryI="INSERT INTO MATRICULA (RUT_ALUMNO,RDB,ID_ANO,ID_CURSO,FECHA,NUM_MAT,BOOL_BAJ,BOOL_BCHS,BOOL_AOI,BOOL_RG,BOOL_AE,BOOL_I,BOOL_GD,BOOL_AR) VALUES (".$filaProm['rut_alumno'].",".trim($_INSTIT).",".$ano.",'$curso','$fecha',0,0,0,0,0,0,0,0,0)";
								$resultI =@pg_Exec($conn,$qryI);
								
								if (!$resultI) {
										error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qryI);
								}
								
	
	


/*								$qryC="select * from ramo where id_curso=".$curso;
								$resultC =@pg_Exec($conn,$qryC);
								if (!$resultC) {
										error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qryC);
								}
								if (@pg_numrows($resultC)!=0){ 
									for($j=0 ; $j < @pg_numrows($resultC) ; $j++){
										$filaC = @pg_fetch_array($resultC,$j);
										$ramo=$filaC['id_ramo'];
										
										$qryE="INSERT INTO tiene$ano_act (RUT_ALUMNO,ID_RAMO,ID_CURSO)VALUES(".$filaProm['rut_alumno'].",$ramo,$curso)"; 
										$resultE =@pg_Exec($conn,$qryE);
									}
								}   
*/	
							} 	// if var==0
					}
					
									
	
			} // fin for
			
			


	
	
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
			}		// fin for
//TERMINO NORMAL DE TRASPASO MATRICULA.
		echo "<script>window.location = 'inscribir_alumnos.php'</script>";

}	// fin else

		

}

if($caso==1){

 exit();
  	$ano =$_ANO;

	$sql = "select nro_ano from ano_escolar where id_ano=" . $ano;
	$Rs_ano = pg_exec($conn,$sql);

	$filano = pg_fetch_array($Rs_ano,0);
	$fecha = "01-01-".$filano['nro_ano'];

	$sqlNuevo="select max(nro_ano) as anonuevo from ano_escolar where id_institucion =".$_INSTIT;
	$resultNuevo=pg_Exec($conn,$sqlNuevo);

	if (!$resultNuevo){
		error('<B> ERROR :</b>Error al acceder a la BD. (101)</B>'.$sqlNuevo);
		exit;
	}

		$filaNuevo = pg_fetch_array($resultNuevo,0);
//		$ano = $filaNuevo['anonuevo'];

	 $sql="select id_ano from ano_escolar where id_institucion=".$_INSTIT." order by nro_ano desc";
	$resultSql=pg_Exec($conn,$sql);

	if (!$resultSql){
		error('<B> ERROR :</b>Error al acceder a la BD. (102)</B>'.$sql);
	}else{
			$max = pg_numrows($resultSql);
			if($max > 1){
				$ant = ($max -2);
				$filaSql = pg_fetch_array($resultSql,$ant);
				$anterior =  $filaSql['id_ano'];
				$filaSql1 = pg_fetch_array($resultSql,1);
				$actual	= $filaSql1['id_ano'];
			} 

	 		$sqlProm = "select distinct(matricula.rut_alumno), matricula.id_curso, situacion_final FROM matricula INNER JOIN promocion ON matricula.rut_alumno=promocion.rut_alumno WHERE matricula.id_ano=".$filaSql1['id_ano']." and promocion.rdb=".$_INSTIT." and bool_ar<>1";
			$resultProm = pg_Exec($conn,$sqlProm);
	
			for ($i=0 ; $i<pg_numrows($resultProm) ; $i++){
				$filaProm = pg_fetch_array($resultProm,$i);
				 $cursoOld= $filaProm['id_curso'];
	
				$sqlCurso= "select * from curso where id_curso=".$cursoOld;
				$resultCurso= pg_Exec($conn,$sqlCurso);
				$filaCurso = pg_fetch_array($resultCurso,0);
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
					$resultCursoNuevo= pg_Exec($conn,$sqlCursoNuevo);
					
					if(pg_numrows($resultCursoNuevo)!=0){
						$filaCursoNuevo = pg_fetch_array($resultCursoNuevo,0);
						$curso= $filaCursoNuevo['id_curso']; 
					}	
					
				}
	
				if (($filaCurso['ensenanza']==110) and ($filaCurso['grado_curso']<8) and ($filaProm['situacion_final']==1)) {
						$letra= $filaCurso['letra_curso'];
						$ense= $filaCurso['ensenanza'];
						$grado= $filaCurso['grado_curso']+1;
						
						$sqlCursoNuevo= "select id_curso from curso where grado_curso=".$grado." and letra_curso='".$letra."' and ensenanza=".$ense." and id_ano=".$ano;
						$resultCursoNuevo= pg_Exec($conn,$sqlCursoNuevo);
						
						if(pg_numrows($resultCursoNuevo)!=0){
							$filaCursoNuevo = pg_fetch_array($resultCursoNuevo,0);
							$curso= $filaCursoNuevo['id_curso']; 
						}	
				}
	
				if ((($filaCurso['ensenanza']==310)or($filaCurso['ensenanza']==360)or($filaCurso['ensenanza']==410)or($filaCurso['ensenanza']==510)or($filaCurso['ensenanza']==610)or($filaCurso['ensenanza']==710)or($filaCurso['ensenanza']==810)) and ($filaCurso['grado_curso']<4) and ($filaProm['situacion_final']==1)) {
						$letra= $filaCurso['letra_curso'];
						$ense= $filaCurso['ensenanza'];
						$grado= $filaCurso['grado_curso']+1;
						
						$sqlCursoNuevo= "select id_curso from curso where grado_curso=".$grado." and letra_curso='".$letra."' and ensenanza=".$ense." and id_ano=".$ano;
						$resultCursoNuevo= pg_Exec($conn,$sqlCursoNuevo);
						
						if(pg_numrows($resultCursoNuevo)!=0){
							$filaCursoNuevo = pg_fetch_array($resultCursoNuevo,0);
							$curso= $filaCursoNuevo['id_curso'];
						}  	
				}
	
				$sqlMat = "select rut_alumno from matricula where rut_alumno=".$filaProm['rut_alumno']." and id_ano=".$ano;
				$resultMat = pg_Exec($conn,$sqlMat);
				
				if(pg_numrows($resultMat)==0){
						  if($var==0){
								  $qryI="INSERT INTO MATRICULA (RUT_ALUMNO,RDB,ID_ANO,ID_CURSO,FECHA,NUM_MAT,BOOL_BAJ,BOOL_BCHS,BOOL_AOI,BOOL_RG,BOOL_AE,BOOL_I,BOOL_GD,BOOL_AR) VALUES (".$filaProm['rut_alumno'].",".trim($_INSTIT).",".$ano.",'$curso','$fecha',0,0,0,0,0,0,0,0,0)";
									$resultI =pg_Exec($conn,$qryI);
									
									if (!$resultI) {
										error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qryI);
									}
	/* aki*/
									$nnn = $filano['nro_ano'];
									$qryC="select * from ramo where id_curso=".$curso;
									$resultC =@pg_Exec($conn,$qryC);
									if (!$resultC) {
											error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qryC);
									}
									if (@pg_numrows($resultC)!=0){ 
										for($i=0 ; $i < @pg_numrows($resultC) ; $i++){
											$filaC = @pg_fetch_array($resultC,$i);
											$ramo=$filaC['id_ramo'];
											

												$qryE="INSERT INTO tiene$nnn (RUT_ALUMNO,ID_RAMO,ID_CURSO)VALUES(".$filaProm['rut_alumno'].",$ramo,$curso)"; 
											$resultE =@pg_Exec($conn,$qryE);
										}
									}   
	/* hasta aki */
	
							 }
	
				   }				
	
			}		// fin for
	
	
	
			$sqlS = "SELECT * FROM matriculatpsincurso WHERE id_ano=".$anterior." and estado<>3";
			$resultS = pg_Exec($conn,$sqlS);
			
			for ($i=0 ; $i<pg_numrows($resultS) ; $i++){
				$filaS = pg_fetch_array($resultS,$i);
		
				$sqlMatS = "SELECT rut_alumno FROM matriculatpsincurso WHERE id_ano=".$ano;
				$resultMatS = pg_Exec($conn,$sqlMatS);
				
				if(pg_numrows($resultMatS)==0){
					$fecha = ($filaS['fecha']);
	
					$qrySin="INSERT INTO MATRICULATPSINCURSO (RUT_ALUMNO,RDB,ID_ANO,FECHA,INTEGRADO,INDIGENA,ESTADO,TITULO,COD_TIPO,COD_SECTOR,COD_ESP) VALUES ('".$filaS['rut_alumno']."',".trim($_INSTIT).",".$ano.",".$fecha."',".$filaS['integrado'].",".$filaS['indigena'].",".$filaS['estado'].",".$filaS['titulo'].",".$filaS['cod_tipo'].",".$filaS['cod_sector'].",".$filaS['cod_esp'].")";
					$resultSin =pg_Exec($conn,$qrySin);
	
					if (!$resultSin) {
						error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qrySin);
					}
				}				
			}

		 }		// fin else

		//------------------------ INGRESO DE PRE-BASICA -------------------------------------------------

		$sqlAlum="SELECT  DISTINCT(matricula.rut_alumno), matricula.id_curso FROM matricula INNER JOIN curso ON matricula.id_curso=curso.id_curso WHERE ensenanza=10 AND matricula.id_ano=".$filaSql1['id_ano']."  ORDER BY id_curso";
		$Rs_Alum =pg_exec($conn,$sqlAlum);

		for ($j=0 ; $j<pg_numrows($Rs_Alum) ; $j++){
			$fila_Alum = pg_fetch_array($Rs_Alum,$j);
			$cursoOld= $fila_Alum['id_curso'];
			
			$sqlCurso= "select * from curso where id_curso=".$cursoOld;
			$resultCurso= pg_Exec($conn,$sqlCurso);
			
			$filaCurso = pg_fetch_array($resultCurso,0);
			$curso=0;
			$var=0;

			if (($filaCurso['ensenanza']==10) and ($filaCurso['grado_curso']<5)) {
					$letra= $filaCurso['letra_curso'];
					$ense= $filaCurso['ensenanza'];
					$grado= $filaCurso['grado_curso']+1;
					
					$sqlCursoNuevo= "select id_curso from curso where grado_curso=".$grado." and letra_curso='".$letra."' and ensenanza=".$ense." and id_ano=".$ano;
					$resultCursoNuevo= pg_Exec($conn,$sqlCursoNuevo);
					
					if(pg_numrows($resultCursoNuevo)!=0){
						$filaCursoNuevo = pg_fetch_array($resultCursoNuevo,0);
						$curso= $filaCursoNuevo['id_curso']; 
					}	
			}

		    if (($filaCurso['ensenanza']==10) and ($filaCurso['grado_curso']==5)) {
					$letra= $filaCurso['letra_curso'];
					$ense= $filaCurso['ensenanza'];
					$grado=1;
					
					$sqlCursoNuevo= "select id_curso from curso where grado_curso=".$grado." and letra_curso='".$letra."' and ensenanza=110 and id_ano=".$ano;
					$resultCursoNuevo= pg_Exec($conn,$sqlCursoNuevo);
					
					if(pg_numrows($resultCursoNuevo)!=0){
						$filaCursoNuevo = pg_fetch_array($resultCursoNuevo,0);
						$curso= $filaCursoNuevo['id_curso']; 
					}	
			}

			$sqlMat = "select rut_alumno from matricula where rut_alumno=".$fila_Alum['rut_alumno']." and id_ano=".$ano;
			$resultMat = pg_Exec($conn,$sqlMat);
			
			if(pg_numrows($resultMat)==0){
					//if($var==0){
						echo "<br>Prebasica2->".$qryI="INSERT INTO MATRICULA (RUT_ALUMNO,RDB,ID_ANO,ID_CURSO,FECHA,NUM_MAT,BOOL_BAJ,BOOL_BCHS,BOOL_AOI,BOOL_RG,BOOL_AE,BOOL_I,BOOL_GD,BOOL_AR) VALUES (".$fila_Alum['rut_alumno'].",".trim($_INSTIT).",".$ano.",'$curso','$fecha',0,0,0,0,0,0,0,0,0)";
						$resultI =pg_Exec($conn,$qryI);
						
						if (!$resultI) {
							error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qryI);
						}
					//}
		   	}				

		}		// fin for
				
				
}				
if($PERFIL==0){

        pg_close($conn);
		echo "<script>window.location = 'procesomigrarprofes.php'</script>"; 
		
}else{
        pg_close($conn);
		echo "<script>window.location = 'listarAno.php3'</script>"; 
}

?>