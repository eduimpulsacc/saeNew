<?php require('../../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$formula		=$_FORMULA;
	
	/*if($_PERFIL==0){
	show($_POST);
	}
*/
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
	if ($modo==1){
	
		for($i=0;$i<count($Rut);$i++){
			$sql_notas = "select * from notas$nro_ano where rut_alumno=".$Rut[$i]." and id_ramo=".$ramo[$i]." and id_periodo=".$periodo[$i]."";
			$result_notas =@pg_Exec($conn,$sql_notas);
			if(pg_numrows($result_notas)!=0){
				$qry = "UPDATE notas$nro_ano SET nota". $posicion[$i]."=". $nota[$i] ." WHERE id_ramo=" . $ramo[$i] ." AND id_periodo=" . $periodo[$i] ." AND rut_alumno=" . $Rut[$i] ."";
				$Rs_Notas = @pg_exec($conn,$qry);
			}
			else{
				$qry = "INSERT INTO notas$nro_ano(rut_alumno, id_ramo, id_periodo, nota".$posicion[$i].", promedio) VALUES (".$Rut[$i].", ".$ramo[$i].", ".$periodo[$i].", ".$nota[$i].", ".$nota[$i].")";
				$Rs_Notas = @pg_exec($conn,$qry);
			}
		}
	}
	
	
	if ($modo==2){
	    // TENGO LA FORMULA, DEBO QUIEN ES EL PADRE
		$q1 = "select formula.*,truncado from formula INNER JOIN ramo ON formula.id_ramo=ramo.id_ramo where id_formula = '".trim($formula)."'";
		$r1 = @pg_Exec($conn,$q1);
		$n1 = @pg_numrows($r1);
		if ($n1>0){
			$f1 = @pg_fetch_array($r1);
			$id_padre = $f1['id_ramo'];
			$aproximado = $f1['truncado'];
		}	
		
		/// Aqui debo insertar el promedio en el subsector padre	
	    /// por lo tanto debo tomar los subsectores hijos y sacer el promedio y grabar
		$qryalum = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno) WHERE (tiene$nro_ano.id_ramo)=".trim($id_padre)."  ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
	    $Rs_alum = @pg_exec($conn,$qryalum);
	
	    // empiezo ciclo para desplegar a los alumnos
	    $variable = @pg_numrows($Rs_alum);
			
		if ($variable!=0){		    		
			for($i=0;$i<@pg_numrows($Rs_alum);$i++){
			    $fila_alum = @pg_fetch_array($Rs_alum,$i);
				$rut_alumno = $fila_alum['rut_alumno'];
				$cont_prom=0;
				$promedio_cal=0;
							
				$qry1="";
				$qry1 = "SELECT ramo.id_ramo, subsector.nombre, formula_hijo.id_formula, formula_hijo.porcentaje, ramo.truncado FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula_hijo ON formula_hijo.id_hijo=ramo.id_ramo WHERE formula_hijo.id_formula='".trim($formula)."'";
				$Rs_Hijo = @pg_exec($conn,$qry1);
				$progeneral = 0;
				for($ii=0;$ii<@pg_numrows($Rs_Hijo);$ii++){
					$fils = @pg_fetch_array($Rs_Hijo,$ii);
					$id_ramo         = $fils['id_ramo'];
					$porcentaje      = $fils['porcentaje'];
					$Truncado[$ii]   = $fils['truncado'];
					$SumaExamen=0;
					$PromPeriodo=0;
				
					$sql = "SELECT porc_examen FROM ramo WHERE id_ramo='".trim($id_ramo)."'";
					$Rs_examen = @pg_exec($conn,$sql);
					$fila_porc = @pg_fetch_array($Rs_examen,0);
					
					
					$qrynotas  = "select * from notas$nro_ano where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_ramo)."' and id_periodo = '".trim($periodo)."'";
					$resnotas  = @pg_Exec($conn,$qrynotas);
					$filanotas = @pg_fetch_array($resnotas);
					
					if($fila_porc['porc_examen']==100){
						$promedio  = $filanotas['promedio'];
					}else{
						$sql = "SELECT * FROM examen_semestral WHERE id_curso=".$curso." AND id_ramo='".trim($id_ramo)."'";
						$rs_curso = @pg_exec($conn,$sql);
						
						
						for($x=0;$x<@pg_numrows($rs_curso);$x++){
							$fila_ex=@pg_fetch_array($rs_curso,$x);
							$Porc_Examen = 0;
							$sql = "SELECT nota FROM notas_examen WHERE id_examen=".$fila_ex['id_examen']." AND id_curso=".$curso." AND id_ano=".$ano." AND periodo=".$periodo." AND id_ramo='".trim($id_ramo)."' AND rut_alumno=".trim($rut_alumno);
							$rs_notas_alu = @pg_exec($conn,$sql);
							$Notas_alu = @pg_result($rs_notas_alu,0);
							$Porc_Examen = ($Notas_alu * $fila_ex['porc'])/100;
							$SumaExamen = $SumaExamen + $Porc_Examen;
						}
							if($SumaExamen==0){
								$PromPeriodo=$filanotas['promedio'];
							}else{
								$PromPeriodo = ($filanotas['promedio'] * $fila_porc['porc_examen'])/100;
								$PromPeriodo = $PromPeriodo + $SumaExamen;
							}
							if($fila_ex['bool_ap']==1){
								$promedio = round($PromPeriodo);
							}else{
								$promedio=abs($PromPeriodo);
							}
						
				}				
				if($_POST['calc_arm']==1){
				$promedio_cal = $promedio_cal + $promedio;///@pg_numrows($Rs_Hijo)
				if($promedio > 0){
					$cont_prom++;
				}
				
				
				$progeneral=$promedio_cal/$cont_prom;
				//echo $promedio ."--".$promedio_cal."<br>";
				
				}
				else{
				 $promedio = ($promedio * $porcentaje)/100;
				 $progeneral = $progeneral + $promedio;
				}
				
				
				
				}
				
				
				
				

				if($aproximado==1){
					$progeneral = round($progeneral);
				}else{
					$progeneral = intval($progeneral);
				}
				
							
				/// insertar promedio en subsector padre.
				
				/// aqui veo si hay que actualizar o insertar
				if ($progeneral==0){
				    $progeneral = NULL;
				}	
				
				
				 $qry7="SELECT * FROM NOTAS$nro_ano WHERE RUT_ALUMNO=".trim($rut_alumno)." AND ID_RAMO=".trim($id_padre)." AND ID_PERIODO=".trim($periodo);
				$result7 =@pg_Exec($conn,$qry7);
				$notas="";					
				$nn = 0;
				if (@pg_numrows($result7)!=0 and $progeneral>0){
				    // actualizo						
					$qry_update   = "update notas$nro_ano set promedio = '".trim($progeneral)."' where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_padre)."' and id_periodo = '".trim($periodo)."'";   
					$res_update   = @pg_Exec($conn,$qry_update);		
					
			//if($_PERFIL==0){echo "<br>".$qry_update;}
				}else{
					// inserto
					$qry_insertar = "insert into notas$nro_ano (promedio,rut_alumno,id_periodo,id_ramo) values ('".trim($progeneral)."','".trim($rut_alumno)."','".trim($periodo)."','".trim($id_padre)."')";
					
					$res_insertar =  @pg_Exec($conn,$qry_insertar);
					
					//if($_PERFIL==0){echo "<br>".$qry_insertar;}  
			    }	
				   
			}
		}	 
		    			
	}
	
	if ($modo==3){
	    // TENGO LA FORMULA, DEBO QUIEN ES EL PADRE
		$q1 = "select formula.*,truncado from formula INNER JOIN ramo ON formula.id_ramo=ramo.id_ramo where id_formula = '".trim($formula)."'";
		$r1 = @pg_Exec($conn,$q1);
		$n1 = @pg_numrows($r1);
		if ($n1>0){
			$f1 = @pg_fetch_array($r1);
			$id_padre = $f1['id_ramo'];
			$aproximado = $f1['truncado'];
		}	
		
		/// Aqui debo insertar el promedio en el subsector padre	
	    /// por lo tanto debo tomar los subsectores hijos y sacer el promedio y grabar
		$qryalum = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, tiene$nro_ano.id_curso FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno) WHERE (tiene$nro_ano.id_ramo)=".trim($id_padre)."  ORDER BY ape_pat, ape_mat, nombre_alu, rut_alumno asc";
	    $Rs_alum = @pg_exec($conn,$qryalum);
	
	    // empiezo ciclo para desplegar a los alumnos
	    $variable = @pg_numrows($Rs_alum);
			
		if ($variable!=0){		    		
			for($i=0;$i<@pg_numrows($Rs_alum);$i++){
			    $fila_alum = @pg_fetch_array($Rs_alum,$i);
				$rut_alumno = $fila_alum['rut_alumno'];
				$cont_prom=0;
				$promedio_cal=0;
							
				$qry1="";
				$qry1 = "SELECT ramo.id_ramo, subsector.nombre, formula_hijo.id_formula, formula_hijo.porcentaje, ramo.truncado FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector INNER JOIN formula_hijo ON formula_hijo.id_hijo=ramo.id_ramo WHERE formula_hijo.id_formula='".trim($formula)."'";
				$Rs_Hijo = @pg_exec($conn,$qry1);
				$progeneral = 0;
				for($ii=0;$ii<@pg_numrows($Rs_Hijo);$ii++){
					$fils = @pg_fetch_array($Rs_Hijo,$ii);
					$id_ramo         = $fils['id_ramo'];
					$porcentaje      = $fils['porcentaje'];
					$Truncado[$ii]   = $fils['truncado'];
					$SumaExamen=0;
					$PromPeriodo=0;
				
					$sql = "SELECT porc_examen FROM ramo WHERE id_ramo='".trim($id_ramo)."'";
					$Rs_examen = @pg_exec($conn,$sql);
					$fila_porc = @pg_fetch_array($Rs_examen,0);
					
					
					$qrynotas  = "select * from notas$nro_ano where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_ramo)."' and id_periodo = '".trim($periodo)."'";
					$resnotas  = @pg_Exec($conn,$qrynotas);
					$filanotas = @pg_fetch_array($resnotas);
					
					if($fila_porc['porc_examen']==100){
						$promedio  = $filanotas['promedio'];
					}else{
						$sql = "SELECT * FROM examen_semestral WHERE id_curso=".$curso." AND id_ramo='".trim($id_ramo)."'";
						$rs_curso = @pg_exec($conn,$sql);
						
						
						for($x=0;$x<@pg_numrows($rs_curso);$x++){
							$fila_ex=@pg_fetch_array($rs_curso,$x);
							$Porc_Examen = 0;
							$sql = "SELECT nota FROM notas_examen WHERE id_examen=".$fila_ex['id_examen']." AND id_curso=".$curso." AND id_ano=".$ano." AND periodo=".$periodo." AND id_ramo='".trim($id_ramo)."' AND rut_alumno=".trim($rut_alumno);
							$rs_notas_alu = @pg_exec($conn,$sql);
							$Notas_alu = @pg_result($rs_notas_alu,0);
							$Porc_Examen = ($Notas_alu * $fila_ex['porc'])/100;
							$SumaExamen = $SumaExamen + $Porc_Examen;
						}
							if($SumaExamen==0){
								$PromPeriodo=$filanotas['promedio'];
							}else{
								$PromPeriodo = ($filanotas['promedio'] * $fila_porc['porc_examen'])/100;
								$PromPeriodo = $PromPeriodo + $SumaExamen;
							}
							if($fila_ex['bool_ap']==1){
								$promedio = round($PromPeriodo);
							}else{
								$promedio=abs($PromPeriodo);
							}
						
				}				
			
				$promedio_cal = $promedio_cal + $promedio;///@pg_numrows($Rs_Hijo)
				if($promedio > 0){
					$cont_prom++;
				}
				
				//echo $promedio ."--".$promedio_cal."<br>";
				
				}
				
				
				$progeneral = $progeneral + $promedio;
				
				
				
				$progeneral=$promedio_cal/$cont_prom;
				
				

				if($aproximado==1){
					$progeneral = round($progeneral);
				}else{
					$progeneral = intval($progeneral);
				}

				
							
				/// insertar promedio en subsector padre.
				
				/// aqui veo si hay que actualizar o insertar
				if ($progeneral==0){
				    $progeneral = NULL;
				}	
				
				
				$qry7="SELECT * FROM NOTAS$nro_ano WHERE RUT_ALUMNO=".trim($rut_alumno)." AND ID_RAMO=".trim($id_padre)." AND ID_PERIODO=".trim($periodo);
				$result7 =@pg_Exec($conn,$qry7);
				$notas="";					
				$nn = 0;
				if (@pg_numrows($result7)!=0 and $progeneral>0){
				    // actualizo						
					 $qry_update   = "update notas$nro_ano set promedio = '".trim($progeneral)."' where rut_alumno = '".trim($rut_alumno)."' and id_ramo = '".trim($id_padre)."' and id_periodo = '".trim($periodo)."'";   
					$res_update   = @pg_Exec($conn,$qry_update);		
					
					//if($_PERFIL==0){echo "<br>".$qry_update						 ;}
				}else{
					// inserto
					 $qry_insertar = "insert into notas$nro_ano (promedio,rut_alumno,id_periodo,id_ramo) values ('".trim($progeneral)."','".trim($rut_alumno)."','".trim($periodo)."','".trim($id_padre)."')";
					
					$res_insertar =  @pg_Exec($conn,$qry_insertar);  
			    }	
				   
			}
		}	 
		    			
	}
	
		
	pg_close($conn);
	//if($_PERFIL!=0){
	echo "<script>window.location = 'listarFormulas.php3' </script>";
	//}
	
?>