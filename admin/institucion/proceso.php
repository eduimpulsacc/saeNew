<?php
	require('../../util/header.inc');
	require('prueba.php');
	

$institucion	=$_INSTIT;

	$nombre_xml = " ";
	$qry="SELECT TRIM(nombre_instit) FROM INSTITUCION WHERE RDB=".trim($institucion);
	$result=pg_exec($conn,$qry);
	$num=pg_numrows($result);
	for ($i=0;$i<$num;$i++){
		$row=pg_fetch_array($result);
		$nombre_xml = (string)$row[0];
		 
	}

if(!empty($_POST['ano'])){

		$xml = new XmlWriter();
		
		$mes_xml = (int)$mes;
		list($id_ano,$ano_xml)= split('-',$ano);
		
		
		
		if($mes == 1){
			$dias = 31;
			
		}
		
		if($mes == 2){
			$dias = 28;
			if (($ano_xml % 4 == 0) && (($ano_xml % 100 != 0) || ($ano_xml % 400 == 0)) ){
				$dias = 29;		
			}			
		}
		if($mes == 3){
			$dias = '31';

			$mes_anterior = '02';
			$dias_anterior  = '28';
			if (($ano_xml % 4 == 0) && (($ano_xml % 100 != 0) || ($ano_xml % 400 == 0)) ){
				$dias_anterior = '29';		
			}				
		}
		if($mes == 4){
			$dias = '30';
			$mes_anterior = '03';
			$dias_anterior  = '31';
		}
		if($mes == 5){
			$dias = '31';
			$mes_anterior = '04';
			$dias_anterior  = '30';
		}
		if($mes == 6){
			$dias = '30';
			$mes_anterior = '05';
			$dias_anterior  = '31';
			
		}
		if($mes == 7){
			$dias = '31';
			$mes_anterior = '06';
			$dias_anterior  = '30';
		}
		if($mes == 8){
			$dias = '31';
			$mes_anterior = '07';
			$dias_anterior  = '31';
			
		}
		if($mes == 9){
			$dias = '30';
			$mes_anterior = '08';
			$dias_anterior  = '31';
		}
		if($mes == 10){
			$dias = '31';
			$mes_anterior = '09';
			$dias_anterior  = '30';
		}
		if($mes == 11){
			$dias = '30';
			$mes_anterior = '10';
			$dias_anterior  = '31';
		}
		if($mes == 12){
			$dias = '31';
			$mes_anterior = '11';
			$dias_anterior  = '30';
		}	
		
		$bool = 0;
		if($mes == 4 || $mes == 6 || $mes == 9 || $mes == 11){
			$bool = 1;
		}		
		
		$cont_feriados = 0;
		//Para cada dia buscamos los fines de semana
		for($j=1;$j<=31;$j++){
			$dia = (date("w", mktime(0,0,0,$mes,$j,$ano_xml)));
			
			if($dia == 6 || $dia == 0){
				$cont_feriados++;	
			}
			else{
				if ($j == 31 && $bool == 1){
					$cont_feriados++;	
				}
			}
		}		
			
	
		
		//Seleccionamos los feriados
		$fecha_ini = $mes."-01-".$ano_xml;
		$fecha_fin = $mes."-".$dias."-".$ano_xml;
		
		
		$qry="SELECT fecha_inicio,fecha_fin FROM feriado WHERE id_ano = $id_ano   order by fecha_inicio";
		$result=pg_exec($conn,$qry);
		$num=pg_numrows($result);	
		
		$dias_feriados = array();
	    
		
		for ($i=0;$i<$num;$i++){
			$row=pg_fetch_array($result);
			$fecha_inicial = $row[fecha_inicio];
			$fecha_final = $row[fecha_fin];
			
			
		    list($ano_ini,$mes_ini,$dia_ini) = split("-",$fecha_inicial);
		    list($ano_fin,$mes_fin,$dia_fin) = split("-",$fecha_final);
		    
		    if($mes_ini == $mes){
			
				if( ($fecha_inicial == $fecha_final) || ($fecha_final == "") ){
					
					$dia = (date("w", mktime(0,0,0,$mes,(int)$dia_ini,$ano_xml)));
			
					if($dia == 6 || $dia == 0){
						
					}
					else{
						if ($dia_ini == 31 && $bool == 1){
							
						}
						else{
							$cont_feriados++;
							$dias_feriados[]=(int)$dia_ini;
						}
					}					
					
				}
				else{
					
					$dia = (date("w", mktime(0,0,0,$mes,(int)$dia_ini,$ano_xml)));
			
					if($dia == 6 || $dia == 0){
						
					}
					else{
						if ($dia_ini == 31 && $bool == 1){
							
						}
						else{
							$cont_feriados++;
							$dias_feriados[]=(int)$dia_ini;
						}
					}
					
					$dif = (int)$dia_fin-(int)$dia_ini;
				
					
					for($x=0;$x<$dif;$x++){
						
						$dia_paso = (int)$dia_ini+1;
						
						$dia = (date("w", mktime(0,0,0,$mes,(int)$dia_paso,$ano_xml)));
				
						if($dia == 6 || $dia == 0){
							
						}
						else{
							if ($dia_ini == 31 && $bool == 1){
								
							}
							else{
								$dias_feriados[]=(int)$dia_paso;
								$cont_feriados++;
							}
						}						
						
						
					}
					 
				}
		    }
			
		}
		
		
		
		$dias_habiles = 31-$cont_feriados;
		
		//print_r($dias_feriados);
		

		
		$xml->push('asistencia');
			$xml->push('establecimiento', array('rbd_establecimiento' =>$institucion));
				$xml->element('nombre', $nombre_xml);
				$xml->push('fecha_asistencia');
					$xml->element('mes_asistencia', $mes_xml);
					$xml->element('ano_asistencia', $ano_xml);
				$xml->pop();
				
				//Seleccionamos los cursos
				$qry="SELECT * FROM curso WHERE id_ano= $id_ano order by ensenanza,grado_curso,letra_curso";
				$result=pg_exec($conn,$qry);
				$num=pg_numrows($result);
				
				//Para cada curso
				for ($i=0;$i<$num;$i++){
					$row=pg_fetch_array($result);
					$id_curso = $row[id_curso];
					
					$grado_curso = trim($row[grado_curso]);
					$letra_curso = trim($row[letra_curso]);
					$ensenanza = trim($row[ensenanza]);
					
					
					if ( ($row['grado_curso']==1) and (($row['cod_decreto']==771982) or ($row['cod_decreto']==461987)) ){

						

					}else if ( ($row['grado_curso']==1) and (($row['cod_decreto']==121987) or ($row['cod_decreto']==1521989)) ){

						

					}else if ( ($row['grado_curso']==1) and ($row['cod_decreto']==1000)){

						

					}else if ( ($row['grado_curso']==2) and (($row['cod_decreto']==771982) or ($row['cod_decreto']==461987)) ){

						

					}//else if ( ($row['grado_curso']==2) and ($row['cod_decreto']==121987) ){

						//echo "SEGUNDO CICLO";

					else if ( ($row['grado_curso']==2) and ($row['cod_decreto']==1000)){

						

					}else if ( ($row['grado_curso']==3) and (($row['cod_decreto']==771982) or ($row['cod_decreto']==461987)) ){

						
						
					}else if ( ($row['grado_curso']==3) and (($row['cod_decreto']==121987)) ){

							

					}else if ( ($row['grado_curso']==3) and ($row['cod_decreto']==1000)){

						

					}else if ( ($row['grado_curso']==4) and ($row['cod_decreto']==1000)){

						$grado_curso = 1;
						$xml->push('curso', array('tipo_boletin' =>1,'tipo_ensenanza' =>$ensenanza));
						$xml->element('nivel', $grado_curso);
						$xml->element('letra', $letra_curso);
						$xml->element('declarar', "NO");
						
						
						//Calculamos matricula inicial mensual
						$fecha_inicial = $mes_anterior."-".$dias_anterior."-".$ano_xml;
						$sql_consulta =  "select 1 from matricula where id_curso = ".$id_curso." and fecha <= '".$fecha_inicial."' and bool_ar = 0 ";
						$result_consulta =pg_Exec($conn,$sql_consulta);
						$num_inicial=pg_numrows($result_consulta);						
						$xml->element('matricula_inicial_mensual', $num_inicial);
						
						//Calculamos la cantidad de alumnos incorporados ese mes
						$fecha_inicial = $mes."-01-".$ano_xml;
						$fecha_final = $mes."-".$dias."-".$ano_xml;
						$sql_consulta =  "select 1 from matricula where id_curso = ".$id_curso." and fecha >= '".$fecha_inicial."' and fecha <= '".$fecha_final."'   and bool_ar = 0 ";
						$result_consulta =pg_Exec($conn,$sql_consulta);
						$num_alta=pg_numrows($result_consulta);						
						$xml->element('numero_alumnos_alta', $num_alta);
						
						//calculamos la cantidad de alumnos retirados del mes
						$fecha_inicial = $mes."-01-".$ano_xml;
						$fecha_final = $mes."-".$dias."-".$ano_xml;
						$sql_consulta =  "select 1 from matricula where id_curso = ".$id_curso." and fecha >= '".$fecha_inicial."' and fecha <= '".$fecha_final."'   and bool_ar = 1 ";
						$result_consulta =pg_Exec($conn,$sql_consulta);
						$num_baja=pg_numrows($result_consulta);											
						$xml->element('numero_alumnos_baja', $num_baja);
						
						$xml->element('sede', 0);
						
						//calculamos los dias habiles
						$xml->element('dias_trabajados_asistencia', $dias_habiles);
						
						
						$xml->element('derecho_escolaridad', 0);
						
						
						//Para cada dia
						for($j=1;$j<=31;$j++){
							$dia = (date("w", mktime(0,0,0,$mes,$j,$ano_xml)));
							
							if($dia == 6 || $dia == 0){
								$xml->element('dia'.$j.'_asistencia', -1);	
							}
							else{
								
								if ($j == 31 && $bool == 1){
									$xml->element('dia'.$j.'_asistencia', -1);	
								}
								else{
										$bandera = 0;
										for($p=0;$p<count($dias_feriados);$p++){
											if($j == $dias_feriados[$p]){
												$bandera = 1;
											}
										}
										if($bandera == 0){								
									
											$dia_temp =$j.""; 
											if($j<10){
												$dia_temp = "0".$j;
											}
											
											$fecha_temp = $mes."-".$dia_temp."-".$ano_xml;
											$sql_consulta =  "select rut_alumno from asistencia where id_curso = ".$id_curso." and fecha = '".$fecha_temp."'  and ano = $id_ano";
											$result_consulta =pg_Exec($conn,$sql_consulta);
											$num_con=pg_numrows($result_consulta);						
					
											$sql_consulta2 =  "select 1 from matricula where id_curso = ".$id_curso." and fecha <= '".$fecha_temp."' and bool_ar = 0 ";
											$result_consulta2 =pg_Exec($conn,$sql_consulta2);
											$num_con2=pg_numrows($result_consulta2);							
											
											$num_asistencia = $num_con2-$num_con;
										
				
											$xml->element('dia'.$j.'_asistencia', $num_asistencia);	
									
										}
										else{
											$xml->element('dia'.$j.'_asistencia', -1);	
										}
																
									
								}
	
							
							}
							
						}
						$xml->pop();

					 						

					}else if ( ($row['grado_curso']==5) and ($row['cod_decreto']==1000)){

						$grado_curso = 2;
						
						$xml->push('curso', array('tipo_boletin' =>1,'tipo_ensenanza' =>$ensenanza));
						$xml->element('nivel', $grado_curso);
						$xml->element('letra', $letra_curso);
						$xml->element('declarar', "NO");
						
						
						//Calculamos matricula inicial mensual
						$fecha_inicial = $mes_anterior."-".$dias_anterior."-".$ano_xml;
						$sql_consulta =  "select 1 from matricula where id_curso = ".$id_curso." and fecha <= '".$fecha_inicial."' and bool_ar = 0 ";
						$result_consulta =pg_Exec($conn,$sql_consulta);
						$num_inicial=pg_numrows($result_consulta);						
						$xml->element('matricula_inicial_mensual', $num_inicial);
						
						//Calculamos la cantidad de alumnos incorporados ese mes
						$fecha_inicial = $mes."-01-".$ano_xml;
						$fecha_final = $mes."-".$dias."-".$ano_xml;
						$sql_consulta =  "select 1 from matricula where id_curso = ".$id_curso." and fecha >= '".$fecha_inicial."' and fecha <= '".$fecha_final."'   and bool_ar = 0 ";
						$result_consulta =pg_Exec($conn,$sql_consulta);
						$num_alta=pg_numrows($result_consulta);						
						$xml->element('numero_alumnos_alta', $num_alta);
						
						//calculamos la cantidad de alumnos retirados del mes
						$fecha_inicial = $mes."-01-".$ano_xml;
						$fecha_final = $mes."-".$dias."-".$ano_xml;
						$sql_consulta =  "select 1 from matricula where id_curso = ".$id_curso." and fecha >= '".$fecha_inicial."' and fecha <= '".$fecha_final."'   and bool_ar = 1 ";
						$result_consulta =pg_Exec($conn,$sql_consulta);
						$num_baja=pg_numrows($result_consulta);											
						$xml->element('numero_alumnos_baja', $num_baja);
						
						$xml->element('sede', 0);
						
						//calculamos los dias habiles
						$xml->element('dias_trabajados_asistencia', $dias_habiles);
						
						
						$xml->element('derecho_escolaridad', 0);
						
						
						//Para cada dia
						for($j=1;$j<=31;$j++){
							$dia = (date("w", mktime(0,0,0,$mes,$j,$ano_xml)));
							
							if($dia == 6 || $dia == 0){
								$xml->element('dia'.$j.'_asistencia', -1);	
							}
							else{
								
								if ($j == 31 && $bool == 1){
									$xml->element('dia'.$j.'_asistencia', -1);	
								}
								else{
										$bandera = 0;
										for($p=0;$p<count($dias_feriados);$p++){
											if($j == $dias_feriados[$p]){
												$bandera = 1;
											}
										}
										if($bandera == 0){								
									
											$dia_temp =$j.""; 
											if($j<10){
												$dia_temp = "0".$j;
											}
											
											$fecha_temp = $mes."-".$dia_temp."-".$ano_xml;
											$sql_consulta =  "select rut_alumno from asistencia where id_curso = ".$id_curso." and fecha = '".$fecha_temp."'  and ano = $id_ano";
											$result_consulta =pg_Exec($conn,$sql_consulta);
											$num_con=pg_numrows($result_consulta);						
					
											$sql_consulta2 =  "select 1 from matricula where id_curso = ".$id_curso." and fecha <= '".$fecha_temp."' and bool_ar = 0 ";
											$result_consulta2 =pg_Exec($conn,$sql_consulta2);
											$num_con2=pg_numrows($result_consulta2);							
											
											$num_asistencia = $num_con2-$num_con;
										
				
											$xml->element('dia'.$j.'_asistencia', $num_asistencia);	
									
										}
										else{
											$xml->element('dia'.$j.'_asistencia', -1);	
										}
																
									
								}
	
							
							}
							
						}
						$xml->pop();						

						
					}else if ( ($row['grado_curso']==4) and ($row['cod_decreto']==771982)){

						


					}else{

						$xml->push('curso', array('tipo_boletin' =>1,'tipo_ensenanza' =>$ensenanza));
						$xml->element('nivel', $grado_curso);
						$xml->element('letra', $letra_curso);
						$xml->element('declarar', "NO");
						
						
						//Calculamos matricula inicial mensual
						$fecha_inicial = $mes_anterior."-".$dias_anterior."-".$ano_xml;
						$sql_consulta =  "select 1 from matricula where id_curso = ".$id_curso." and fecha <= '".$fecha_inicial."' and bool_ar = 0 ";
						$result_consulta =pg_Exec($conn,$sql_consulta);
						$num_inicial=pg_numrows($result_consulta);						
						$xml->element('matricula_inicial_mensual', $num_inicial);
						
						//Calculamos la cantidad de alumnos incorporados ese mes
						$fecha_inicial = $mes."-01-".$ano_xml;
						$fecha_final = $mes."-".$dias."-".$ano_xml;
						$sql_consulta =  "select 1 from matricula where id_curso = ".$id_curso." and fecha >= '".$fecha_inicial."' and fecha <= '".$fecha_final."'   and bool_ar = 0 ";
						$result_consulta =pg_Exec($conn,$sql_consulta);
						$num_alta=pg_numrows($result_consulta);						
						$xml->element('numero_alumnos_alta', $num_alta);
						
						//calculamos la cantidad de alumnos retirados del mes
						$fecha_inicial = $mes."-01-".$ano_xml;
						$fecha_final = $mes."-".$dias."-".$ano_xml;
						$sql_consulta =  "select 1 from matricula where id_curso = ".$id_curso." and fecha >= '".$fecha_inicial."' and fecha <= '".$fecha_final."'   and bool_ar = 1 ";
						$result_consulta =pg_Exec($conn,$sql_consulta);
						$num_baja=pg_numrows($result_consulta);											
						$xml->element('numero_alumnos_baja', $num_baja);
						
						$xml->element('sede', 0);
						
						//calculamos los dias habiles
						$xml->element('dias_trabajados_asistencia', $dias_habiles);
						
						
						$xml->element('derecho_escolaridad', 0);
						
						
						//Para cada dia
						for($j=1;$j<=31;$j++){
							$dia = (date("w", mktime(0,0,0,$mes,$j,$ano_xml)));
							
							if($dia == 6 || $dia == 0){
								$xml->element('dia'.$j.'_asistencia', -1);	
							}
							else{
								
								if ($j == 31 && $bool == 1){
									$xml->element('dia'.$j.'_asistencia', -1);	
								}
								else{
										$bandera = 0;
										for($p=0;$p<count($dias_feriados);$p++){
											if($j == $dias_feriados[$p]){
												$bandera = 1;
											}
										}
										if($bandera == 0){								
									
											$dia_temp =$j.""; 
											if($j<10){
												$dia_temp = "0".$j;
											}
											
											$fecha_temp = $mes."-".$dia_temp."-".$ano_xml;
											$sql_consulta =  "select rut_alumno from asistencia where id_curso = ".$id_curso." and fecha = '".$fecha_temp."'  and ano = $id_ano";
											$result_consulta =pg_Exec($conn,$sql_consulta);
											$num_con=pg_numrows($result_consulta);						
					
											$sql_consulta2 =  "select 1 from matricula where id_curso = ".$id_curso." and fecha <= '".$fecha_temp."' and bool_ar = 0 ";
											$result_consulta2 =pg_Exec($conn,$sql_consulta2);
											$num_con2=pg_numrows($result_consulta2);							
											
											$num_asistencia = $num_con2-$num_con;
										
				
											$xml->element('dia'.$j.'_asistencia', $num_asistencia);	
									
										}
										else{
											$xml->element('dia'.$j.'_asistencia', -1);	
										}
																
									
								}
	
							
							}
							
						}
						$xml->pop();						
					}					
					

				}					
			
			$xml->pop();
			
		$xml->pop();
		
		
		$archivo=fopen("ano/curso/informe_educacional/archivos/documento.xml" , "w");
		if ($archivo) {
			fputs ($archivo, $xml->getXml()."");
		}
		fclose ($archivo); 		
		echo '<br><br><a href="ano/curso/informe_educacional/archivos/documento.xml">Ver archivo</a>';		
	}
	
	?>