<?
	require('../../../../util/header.inc');

	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$Flag_23 = 0;
	$Flag_25 = 0;
	 
	$sql_ano = "SELECT * FROM ano_escolar WHERE id_ano=".$ano;
	$result_ano = pg_exec($conn,$sql_ano);
	$fil = pg_fetch_array($result_ano,0);
	$nro_ano = $fil['nro_ano'] ;
	
	// BUSCA LOS ARCHIVOS QUE EXISTEN PARA DISTRIBUIRLOS EN LAS RESPECTIVAS TABLAS
	$sql = "SELECT * FROM archivo_rech ar WHERE ar.rdb=".$institucion." AND ar.estado_archivo=1";
	$result = pg_exec($conn,$sql);		
 
	for($j=0;$j<pg_numrows($result);$j++){
			$fila = pg_fetch_array($result,$j);
			$archivo = trim($fila['numero']);
			// ARCHIVO 23			ALUMNO				
		//  preguntar por alumno y archivo 0 para finalmente insertar en alumno
		// rut de alumnos que tengo k agregar en tabla alumno
	
			if($archivo==23){
				$sql_archivo = "SELECT a23.* FROM archivo_23 a23 WHERE a23.rut_alumno NOT IN (SELECT rut_alumno FROM alumno)";
				$result_archivo = pg_exec($conn,$sql_archivo);	
//				$fichero = fopen("Log/log_".$institucion."_alumno_".$ano.".txt", "w+"); 
			
				for($i=0;$i<pg_numrows($result_archivo);$i++){
					$fila_alumno = pg_fetch_array($result_archivo,$i);
					$com = $fila_alumno['cod_comuna'];
					$largo = strlen($com);
					$sexo = 0;
					if($largo==4){
						$region = substr($com,0,1);
						$provincia = substr($com,1,1);
						$comuna = substr($com,2,2);
					}
					else if($largo==5){
						$region = substr($com,0,2);
						$provincia = substr($com,2,1);
						$comuna = substr($com,3,2);
					}
					
					if($fila_alumno['sexo']==1){	// masculino RECH
						$sexo = 2;	// masculino SAE
					}
					else if($fila_alumno['sexo']==2){
						$sexo = 1;
					}
					
					$sql_alumno = "INSERT INTO alumno (rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat,region,ciudad,comuna,sexo,fecha_nac,nacionalidad) VALUES(".$fila_alumno['rut_alumno'].",'".$fila_alumno['dig_rut']."','".$fila_alumno['nombre_alumno']."','".$fila_alumno['ape_pat']."','".$fila_alumno['ape_mat']."',".$region.",".$provincia.",".$comuna.",".$sexo.",to_date('".$fila_alumno['fecha_nacimiento']."','YYYY MM DD'),".$fila_alumno['extranjero_sin_rut'].")";
					$result_alumno = pg_exec($conn,$sql_alumno);	

					if(!pg_exec($conn,$sql_alumno)){
						$salto = "\r\n"; 	 
						$ls_espacio= "\t";
						$ls_string = trim($institucion)."$ls_espacio";
						$ls_string = $ls_string . trim($ano) . "$ls_espacio";
						$ls_string = $ls_string . trim($sql_alumno) . "$salto";
						@ fwrite($fichero,"$ls_string"); 
					}					
				}
//				fclose($fichero); 
				$Flag_23=1;
			}
			
			//  ARCHIVO 01			ALUMNO	
			if($archivo==1 && $Flag_23==0){
				$sql_archivo = "SELECT * FROM archivo_01 a1 where a1.rdb=".$institucion." AND a1.rut_alumno not in(SELECT rut_alumno FROM alumno)";				

				$result_archivo = pg_exec($conn,$sql_archivo);	
//				$fichero = fopen("Log/log_".$institucion."_alumno_".$ano.".txt", "w+"); 
			
				for($i=0;$i<pg_numrows($result_archivo);$i++){
					$fila_alumno = pg_fetch_array($result_archivo,$i);
					$sexo = 0;
					
					if($fila_alumno['sexo']==1){	// masculino RECH
						$sexo = 2;	// masculino SAE
					}
					else if($fila_alumno['sexo']==2){
						$sexo = 1;
					}

					$sql_alumno = "INSERT INTO alumno (rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat,sexo,fecha_nac,nacionalidad) VALUES(".$fila_alumno['rut_alumno'].",'".$fila_alumno['dig_rut']."','".$fila_alumno['nombre_alumno']."','".$fila_alumno['ape_pat']."','".$fila_alumno['ape_mat']."',".$sexo.",to_date('".trim($fila_alumno['fecha_nacimiento'])."','YYYY MM DD'),".$fila_alumno['extranjero_sin_rut'].")";
					$result_alumno = pg_exec($conn,$sql_alumno);	
					
					if(!pg_exec($conn,$sql_alumno)){
						$salto = "\r\n"; 	 
						$ls_espacio= "\t";
						$ls_string = trim($institucion)."$ls_espacio";
						$ls_string = $ls_string . trim($ano) . "$ls_espacio";
						$ls_string = $ls_string . trim($sql_alumno) . "$salto";
						@ fwrite($fichero,"$ls_string"); 
					}					
				}
//				fclose($fichero); 
			}
			
			
			//ARCHIVO 25			MATRICULA		insertar fecha_matricula= 01/03/2005 por defecto
			if($archivo==25){
				// insertar el id_curso a la tabla 25, para trabajar mas facil las consultas
				$sql_curso = "SELECT * FROM curso WHERE id_ano=".$ano."";
				$result_curso = pg_exec($conn,$sql_curso);	
				for($i=0;$i<pg_numrows($result_curso);$i++){
					$fila_curso = pg_fetch_array($result_curso,$i);
					$sql_a_curso = "UPDATE archivo_25 SET id_ano=".$ano.",id_curso=".$fila_curso['id_curso']." WHERE grado=".$fila_curso['grado_curso']." AND letra='".trim($fila_curso['letra_curso'])."' AND cod_tipo_ense=".$fila_curso['ensenanza'];
					$result_a_curso = pg_exec($conn,$sql_a_curso);	
				}
	
				// ir a buscar el curso y luego consultar sobre el rut, rdb, ano, curso  y los que no esten se ingresen en matricula.
				$sql_no_repetidos = "SELECT distinct rut_alumno, * FROM archivo_25 WHERE rdb=".$institucion." AND id_ano=".$ano;
				$result_no_repetidos = pg_exec($conn,$sql_no_repetidos);
//				$fichero = fopen("Log/log_".$institucion."_matricula_".$ano.".txt", "w+"); 
	
				for($k=0;$k<pg_numrows($result_no_repetidos);$k++){
					$fila_matricula = pg_fetch_array($result_no_repetidos,$k);
					$sql_i_matricula = "INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,fecha,bool_i,bool_gd,bool_ar) VALUES(".$fila_matricula['rut_alumno'].",".$fila_matricula['rdb'].",".$fila_matricula['id_ano'].",".$fila_matricula['id_curso'].",to_date('".$nro_ano."/03/01','YYYY MM DD'),".$fila_matricula['integrado'].",".$fila_matricula['grupo_diferencial'].",0)";
					$result_i_matricula = pg_exec($conn,$sql_i_matricula);	
					
					if(!pg_exec($conn,$sql_i_matricula)){
						$salto = "\r\n"; 	 
						$ls_espacio= "\t";
						$ls_string = trim($institucion)."$ls_espacio";
						$ls_string = $ls_string . trim($ano) . "$ls_espacio";
						$ls_string = $ls_string . trim($sql_i_matricula) . "$salto";
						@ fwrite($fichero,"$ls_string"); 
					}					

					// inscribir alumnos
					$sql_ramo = "SELECT * FROM ramo WHERE id_curso=".$fila_matricula['id_curso'];			
					$result_ramo = @pg_exec($conn,$sql_ramo);
					
					for($h=0;$h<@pg_numrows($result_ramo);$h++){
						$fila_ramo = pg_fetch_array($result_ramo,$h);					
						$sql_i_tiene = "INSERT INTO tiene$nro_ano (rut_alumno,id_ramo,id_curso) VALUES (".$fila_matricula['rut_alumno'].",".$fila_ramo['id_ramo'].",".$fila_matricula['id_curso'].") ";
						$result_i_tiene = @pg_exec($conn,$sql_i_tiene);
					}	

				}	
//				fclose($fichero); 

				$Flag_25 = 1;
			}
			

	// trabajar con el archivo 3 en lugar del 4, ya que el 3 tiene a todos los alumnos del curso, sin importar k no tengan notas
			if($archivo==3 && $Flag_25==0){
				$sql_curso = "SELECT * FROM curso WHERE id_ano=".$ano;
				$result_curso = pg_exec($conn,$sql_curso);	
				for($i=0;$i<pg_numrows($result_curso);$i++){
					$fila_curso = pg_fetch_array($result_curso,$i);
					$sql_a_curso = "UPDATE archivo_03 SET id_ano=".$fila_curso['id_ano'].", id_curso=".$fila_curso['id_curso']." WHERE grado=".$fila_curso['grado_curso']." AND letra='".trim($fila_curso['letra_curso'])."' AND cod_ens=".$fila_curso['ensenanza'];
					$result_a_curso = @pg_exec($conn,$sql_a_curso);	
				}
				// ir a buscar el curso y luego consultar sobre el rut, rdb, ano, curso  y los que no esten se ingresen en matricula.
				$sql_no_repetidos = "SELECT distinct rut_alumno, * FROM archivo_03 WHERE rdb=".$institucion." AND id_ano=".$ano;
				$result_no_repetidos = pg_exec($conn,$sql_no_repetidos);
//				$fichero = fopen("Log/log_".$institucion."_matricula_".$ano.".txt", "w+"); 

				for($k=0;$k<pg_numrows($result_no_repetidos);$k++){
					$fila_matricula = pg_fetch_array($result_no_repetidos,$k);
//					$sql_i_matricula = "INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,fecha) VALUES(".$fila_matricula['rut_alumno'].",".$fila_matricula['rdb'].",".$fila_matricula['id_ano'].",".$fila_matricula['id_curso'].",to_date('01/03/".$nro_ano."','DD MM YYYY'))";

					$sql_i_matricula = "INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,fecha) VALUES(".$fila_matricula['rut_alumno'].",".$fila_matricula['rdb'].",".$fila_matricula['id_ano'].",".$fila_matricula['id_curso'].",to_date('".$nro_ano."/03/01','YYYY MM DD'))";
					$result_i_matricula = @pg_exec($conn,$sql_i_matricula);	
					
					if(!pg_exec($conn,$sql_i_matricula)){
						$salto = "\r\n"; 	 
						$ls_espacio= "\t";
						$ls_string = trim($institucion)."$ls_espacio";
						$ls_string = $ls_string . trim($ano) . "$ls_espacio";
						$ls_string = $ls_string . trim($sql_i_matricula) . "$salto";
						@ fwrite($fichero,"$ls_string"); 
					}					
				}	
//				fclose($fichero); 
				
				// insertar comuna en Alumno
				$sql_comuna = "SELECT * FROM archivo_03 WHERE rdb=".$institucion;
				$result_comuna = pg_exec($conn,$sql_comuna);
				for($m=0;$m<pg_numrows($result_comuna);$m++){
					$fila_comuna = pg_fetch_array($result_comuna,$m);				
					$com = $fila_comuna['comuna'];
					$largo = strlen($com);
					if($largo==4){
						$region = substr($com,0,1);
						$provincia = substr($com,1,1);
						$comuna = substr($com,2,2);
					}
					else if($largo==5){
						$region = substr($com,0,2);
						$provincia = substr($com,2,1);
						$comuna = substr($com,3,2);
					}
					
					$sql_up_alumno = "UPDATE alumno SET region=".$region.", ciudad=".$provincia.", comuna=".$comuna." WHERE rut_alumno=".$fila_comuna['rut_alumno'];
					$result_up_alumno = @pg_exec($conn,$sql_up_alumno);	
				}

			}			
	

	} // fin for j	
	
	$sql_borra_01 = "DELETE FROM archivo_01";
	$sql_borra_03 = "DELETE FROM archivo_03";
	$sql_borra_23 = "DELETE FROM archivo_23";
	$sql_borra_25 = "DELETE FROM archivo_25";

	$result_borra_01 = pg_exec($conn,$sql_borra_01);								
	$result_borra_03 = pg_exec($conn,$sql_borra_03);								
	$result_borra_23 = pg_exec($conn,$sql_borra_23);								
	$result_borra_25 = pg_exec($conn,$sql_borra_25);	

	if($Flag_25==1 || Flag_23==1){
	    echo "<script>alert('paso1');</script>";
		echo "<script>window.location = 'ArchRech.php?caso=5'</script>";
	}
	else{
	    echo "<script>alert('paso2');</script>";
		echo "<script>window.location = 'ArchRech.php?caso=4'</script>";
	}
								
?>