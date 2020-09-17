<?
	require('../../../../util/header.inc');
 
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$Flag_23 = 0;
	$Flag_25 = 0;
	
echo	$sql_ano = "SELECT * FROM ano_escolar WHERE id_ano=".$ano;
	$result_ano = pg_exec($conn,$sql_ano);
	$fil = pg_fetch_array($result_ano,0);
	$nro_ano = $fil['nro_ano'] ;
	
	// BUSCA LOS ARCHIVOS QUE EXISTEN PARA DISTRIBUIRLOS EN LAS RESPECTIVAS TABLAS
echo "<br>";
echo	$sql = "SELECT * FROM archivo_rech ar WHERE ar.rdb=".$institucion." AND ar.estado_archivo=1";
	$result = pg_exec($conn,$sql);		

	for($j=0;$j<pg_numrows($result);$j++){
			$fila = pg_fetch_array($result,$j);
			$archivo = $fila['numero'];
	
			// ARCHIVO 23			ALUMNO				
		//  preguntar por alumno y archivo 0 para finalmente insertar en alumno
		// rut de alumnos que tengo k agregar en tabla alumno
	
			if($archivo==23){
				$sql_archivo = "SELECT a23.* FROM archivo_23 a23 WHERE a23.rut_alumno NOT IN (SELECT a.rut_alumno FROM alumno a INNER JOIN matricula m on a.rut_alumno=m.rut_alumno WHERE m.rdb=".$institucion." AND m.id_ano=".$ano.")";
				$result_archivo = pg_exec($conn,$sql_archivo);	
//				$fichero = fopen("Log/log_".$institucion."_alumno_".$ano.".txt", "w+"); 
			
				for($i=0;$i<pg_numrows($result_archivo);$i++){
					$fila_alumno = pg_fetch_array($result_archivo,$i);
					$com = $fila_alumno['comuna'];
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
		
					$sql_alumno = "INSERT INTO alumno (rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat,region,ciudad,comuna,sexo,fecha_nacimiento,nacionalidad) VALUES(".$fila_alumno['rut_alumno'].",'".$fila_alumno['dig_rut']."','".$fila_alumno['nombre_alumno']."','".$fila_alumno['ape_pat']."','".$fila_alumno['ape_mat']."',".$region.",".$provincia.",".$comuna.",".$fila_alumno['sexo'].",to_date('".$fila_alumno['fecha_nacimiento']."','YYYY MM DD'),".$fila_alumno['extranjero_sin_rut'].")";
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
				fclose($fichero); 
				$Flag_23=1;
//				$sql_borra_23 = "DELETE FROM archivo_23 WHERE rdb=".$institucion;
			}
			
			//  ARCHIVO 01			ALUMNO	
			if($archivo==1 && $Flag_23==0){
echo "<br>01=";
//echo				$sql_archivo = "SELECT a01.* FROM archivo_01 a01 WHERE a01.rut_alumno NOT IN (SELECT a.rut_alumno FROM alumno a INNER JOIN matricula m on a.rut_alumno=m.rut_alumno WHERE m.rdb=".$institucion." AND m.id_ano=".$ano.")";
//echo				$sql_archivo = "SELECT a01.* FROM archivo_01 a01 WHERE a01.rut_alumno NOT IN (SELECT rut_alumno FROM alumno)";

//echo			$sql_archivo = "SELECT * FROM archivo_01 where rdb= $institucion";
echo				$sql_archivo = "SELECT * FROM archivo_01 a1 where a1.rdb=".$institucion." AND a1.rut_alumno not in(SELECT rut_alumno FROM alumno)";				

				$result_archivo = pg_exec($conn,$sql_archivo);	
//				$fichero = fopen("Log/log_".$institucion."_alumno_".$ano.".txt", "w+"); 
			
				for($i=0;$i<pg_numrows($result_archivo);$i++){
					$fila_alumno = pg_fetch_array($result_archivo,$i);
echo "<br>";
echo					$sql_alumno = "INSERT INTO alumno (rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat,sexo,fecha_nac,nacionalidad) VALUES(".$fila_alumno['rut_alumno'].",'".$fila_alumno['dig_rut']."','".$fila_alumno['nombre_alumno']."','".$fila_alumno['ape_pat']."','".$fila_alumno['ape_mat']."',".$fila_alumno['sexo'].",to_date('".trim($fila_alumno['fecha_nacimiento'])."','YYYY MM DD'),".$fila_alumno['extranjero_sin_rut'].")";
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
				fclose($fichero); 
//				$sql_borra_01 = "DELETE FROM archivo_01 WHERE rdb=".$institucion;
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
//					$sql_i_matricula = "INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,fecha,bool_i,bool_gd,bool_ar) VALUES(".$fila_matricula['rut_alumno'].",".$fila_matricula['rdb'].",".$fila_matricula['id_ano'].",".$fila_matricula['id_curso'].",to_date('01/03/".$nro_ano."','DD MM YYYY'),".$fila_matricula['integrado'].",".$fila_matricula['grupo_diferencial'].",".$fila_matricula['repitente'].")";

					$sql_i_matricula = "INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,fecha,bool_i,bool_gd,bool_ar) VALUES(".$fila_matricula['rut_alumno'].",".$fila_matricula['rdb'].",".$fila_matricula['id_ano'].",".$fila_matricula['id_curso'].",to_date('".$nro_ano."/03/01','YYYY MM DD'),".$fila_matricula['integrado'].",".$fila_matricula['grupo_diferencial'].",".$fila_matricula['repitente'].")";
					$result_i_matricula = pg_exec($conn,$sql_i_matricula);	
					
					if(!pg_exec($conn,$sql_i_matricula)){
						$salto = "\r\n"; 	 
						$ls_espacio= "\t";
						$ls_string = trim($institucion)."$ls_espacio";
						$ls_string = $ls_string . trim($ano) . "$ls_espacio";
						$ls_string = $ls_string . trim($sql_i_matricula) . "$salto";
						@ fwrite($fichero,"$ls_string"); 
					}					
				}	
				fclose($fichero); 
				$Flag_25 = 1;
//				$sql_borra_25 = "DELETE FROM archivo_25 WHERE rdb=".$institucion." AND id_ano=".$ano;			
			}
			

	// trabajar con el archivo 3 en lugar del 4, ya que el 3 tiene a todos los alumnos del curso, sin importar k no tengan notas
			if($archivo==3 && $Flag_25==0){
echo "<br>03=";
echo				$sql_curso = "SELECT * FROM curso WHERE id_ano=".$ano;
				$result_curso = pg_exec($conn,$sql_curso);	
				for($i=0;$i<pg_numrows($result_curso);$i++){
					$fila_curso = pg_fetch_array($result_curso,$i);
echo "<br>";
echo					$sql_a_curso = "UPDATE archivo_03 SET id_ano=".$fila_curso['id_ano'].", id_curso=".$fila_curso['id_curso']." WHERE grado=".$fila_curso['grado_curso']." AND letra='".trim($fila_curso['letra_curso'])."' AND cod_ens=".$fila_curso['ensenanza'];
					$result_a_curso = @pg_exec($conn,$sql_a_curso);	
				}
				// ir a buscar el curso y luego consultar sobre el rut, rdb, ano, curso  y los que no esten se ingresen en matricula.
echo "<br>select=";
echo				$sql_no_repetidos = "SELECT distinct rut_alumno, * FROM archivo_03 WHERE rdb=".$institucion." AND id_ano=".$ano;
				$result_no_repetidos = pg_exec($conn,$sql_no_repetidos);
//				$fichero = fopen("Log/log_".$institucion."_matricula_".$ano.".txt", "w+"); 

				for($k=0;$k<pg_numrows($result_no_repetidos);$k++){
					$fila_matricula = pg_fetch_array($result_no_repetidos,$k);
//					$sql_i_matricula = "INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,fecha) VALUES(".$fila_matricula['rut_alumno'].",".$fila_matricula['rdb'].",".$fila_matricula['id_ano'].",".$fila_matricula['id_curso'].",to_date('01/03/".$nro_ano."','DD MM YYYY'))";

echo "<br>";
echo					$sql_i_matricula = "INSERT INTO matricula (rut_alumno,rdb,id_ano,id_curso,fecha) VALUES(".$fila_matricula['rut_alumno'].",".$fila_matricula['rdb'].",".$fila_matricula['id_ano'].",".$fila_matricula['id_curso'].",to_date('".$nro_ano."/03/01','YYYY MM DD'))";
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
				fclose($fichero); 
				
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

//				$sql_borra_03 = "DELETE FROM archivo_03 WHERE rdb=".$institucion;
			}			
	
			//	NOTAS 2005  y TIENE2005
			if($archivo==4){
echo "<br>";
echo				$sql_notas = "SELECT r.id_ramo, c.id_curso, r.cod_subsector,c.grado_curso,c.letra_curso,c.ensenanza FROM ramo r INNER JOIN curso c on r.id_curso=c.id_curso WHERE c.id_ano=".$ano." ";
				$result_notas = @pg_exec($conn,$sql_notas);	
				for($i=0;$i<@pg_numrows($result_notas);$i++){
					$fila_notas = pg_fetch_array($result_notas,$i);
echo "<br>";
echo					$sql_i_notas = "UPDATE archivo_04 SET id_ano=".$ano.",id_curso=".$fila_notas['id_curso'].",id_ramo=".$fila_notas['id_ramo']." WHERE grado=".$fila_notas['grado_curso']." AND letra='".trim($fila_notas['letra_curso'])."' AND ensenanza=".$fila_notas['ensenanza']." AND subsector=".$fila_notas['cod_subsector'];
					$result_i_notas = @pg_exec($conn,$sql_i_notas);	
				}
				
				// insertar en tiene2005
echo "<br>tiene=";
echo				$sql_tiene = "SELECT alumno, id_ramo, id_curso FROM archivo_04 WHERE (eximido='' OR eximido is null) AND id_ano=".$ano;
				$result_tiene = pg_exec($conn,$sql_tiene);	
//				$fichero = fopen("Log/log_".$institucion."_tiene".$nro_ano."_".$ano.".txt", "w+"); 
				
				for($i=0;$i<pg_numrows($result_tiene);$i++){
					$fila_tiene = pg_fetch_array($result_tiene,$i);
echo "<br>";
echo					$sql_a_tiene = "INSERT INTO tiene".$nro_ano." (rut_alumno,id_ramo,id_curso) VALUES(".$fila_tiene['alumno'].",".$fila_tiene['id_ramo'].",".$fila_tiene['id_curso'].")";
					$result_a_tiene = pg_exec($conn,$sql_a_tiene);	
					
					if(!pg_exec($conn,$sql_a_tiene)){
						$salto = "\r\n"; 	 
						$ls_espacio= "\t";
						$ls_string = trim($institucion)."$ls_espacio";
						$ls_string = $ls_string . trim($ano) . "$ls_espacio";
						$ls_string = $ls_string . trim($sql_a_tiene) . "$salto";
						@ fwrite($fichero,"$ls_string"); 
					}					
				}
				fclose($fichero); 

				
				// insertar en notas2005
				// primero buscar los periodos
				/*
echo "<br>periodo=";
echo				$sql_periodo = "SELECT id_periodo FROM periodo WHERE id_ano=".$ano;		
				$result_periodo = pg_exec($conn,$sql_periodo);
				$fichero = fopen("Log/log_".$institucion."_notas".$nro_ano."_".$ano.".txt", "w+"); 

				for($k=0;$k<pg_numrows($result_periodo);$k++){
					$fila_periodo = pg_fetch_array($result_periodo,$k);
					$periodo = $fila_periodo['id_periodo'];
					$sql_notas = "SELECT alumno,id_ramo,promedio1,promedio2 FROM archivo_04 WHERE (eximido='' OR eximido is null) AND id_ano=".$ano;
					$result_notas = pg_exec($conn,$sql_notas);
					
					for($m=0;$m<pg_numrows($result_notas);$m++){
						$fila_notas = pg_fetch_array($result_notas,$m);
						$promedio = $fila_notas['promedio1'];
						$promedio_dos = $fila_notas['promedio2'];
						if(substr($promedio,1,1)==','){
							$promedio1 = str_replace(",","",$promedio);
						}else if(substr($promedio,1,1)=='.'){
							$promedio1 = str_replace(".","",$promedio);
						}	
						if(substr($promedio_dos,1,1)==','){
							$promedio2 = str_replace(",","",$promedio_dos);
						}else if(substr($promedio_dos,1,1)=='.'){
							$promedio2 = str_replace(".","",$promedio_dos);
						}
						if($promedio1=='00'){
							$promedio1 = '';
						}
						if($promedio2=='00'){ 
							$promedio2 = '';
						}
						if($promedio1=='' && $promedio2==''){
							$promedio1 = 0;
						}
						
//						$sql_a_notas = "INSERT INTO notas".$nro_ano." VALUES(".$fila_notas['alumno'].",".$fila_notas['id_ramo'].",".$periodo.",'".trim(str_replace(".","",$fila_notas['promedio1']))."".trim($fila_notas['promedio2'])."','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','".trim(str_replace(".","",$fila_notas['promedio1']))."".trim($fila_notas['promedio2'])."')";
echo "<br>notas=";
echo						$sql_a_notas = "INSERT INTO notas".$nro_ano." VALUES(".$fila_notas['alumno'].",".$fila_notas['id_ramo'].",".$periodo.",'".trim($promedio1)."".trim($promedio2)."','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','".trim($promedio1)."".trim($fila_notas['promedio2'])."')";
	
						$result_a_notas = pg_exec($conn,$sql_a_notas);	
						
						if(!pg_exec($conn,$sql_a_notas)){
							$salto = "\r\n"; 	 
							$ls_espacio= "\t";
							$ls_string = trim($institucion)."$ls_espacio";
							$ls_string = $ls_string . trim($ano) . "$ls_espacio";
							$ls_string = $ls_string . trim($sql_a_notas) . "$salto";
							@ fwrite($fichero,"$ls_string"); 
						}					
					}		
				}
				*/
				fclose($fichero); 
//				$sql_borra_04 = "DELETE FROM archivo_04 WHERE rdb=".$institucion." AND id_ano=".$ano;			
			}	// FIN NOTAS2005  Y TIENE2005
			
			//PROMOCION
			if($archivo==5){
echo "<br>05=";			
echo				$sql_promocion = "SELECT * FROM curso WHERE id_ano=".$ano." ";
				$result_promocion = pg_exec($conn,$sql_promocion);
				for($i=0;$i<pg_numrows($result_promocion);$i++){
					$fila_promocion = pg_fetch_array($result_promocion,$i);
echo "<br>";
echo					$sql_upd_promocion = "UPDATE archivo_05 SET id_ano=".$fila_promocion['id_ano'].",id_curso=".$fila_promocion['id_curso']." WHERE grado=".$fila_promocion['grado_curso']." AND letra='".trim($fila_promocion['letra_curso'])."' AND cod_ens=".$fila_promocion['ensenanza'];
					$result_upd_promocion = pg_exec($conn,$sql_upd_promocion);
	
				}
				// falta la fecha de retiro
				$sql_e_promocion = "SELECT * FROM archivo_05 WHERE id_ano=".$ano;
				$result_e_promocion = pg_exec($conn,$sql_e_promocion);
//				$fichero = fopen("Log/log_".$institucion."_promocion_".$ano.".txt", "w+"); 

				for($k=0;$k<pg_numrows($result_e_promocion);$k++){
					$fila = pg_fetch_array($result_e_promocion,$k);
					if($fila['prom_general']==NULL || $fila['prom_general']==''){
						$fila['prom_general']=0;
					}
echo "<br>promocion=";
echo					$sql_a_promocion = "INSERT INTO promocion (rdb,id_ano,id_curso,rut_alumno,promedio,asistencia,situacion_final,observacion) VALUES(".$fila['rdb'].",".$fila['id_ano'].",".$fila['id_curso'].",".$fila['rut_alumno'].",".$fila['prom_general'].",".$fila['porc_asistencia'].",".$fila['situacion_final'].",'".$fila['observacion']."')";
					$result_a_promocion = pg_exec($conn,$sql_a_promocion);
					
					if(!pg_exec($conn,$sql_a_promocion)){
						// insert la sql en un archivo de errores, en un txt
						$salto = "\r\n"; 	 
						$ls_espacio= "\t";
						$rdb = $fila['rdb'];
						$id_ano = $fila['id_ano'];
						$ls_string = trim($rdb)."$ls_espacio";
						$ls_string = $ls_string . trim($id_ano) . "$ls_espacio";
						$ls_string = $ls_string . trim($sql_a_promocion) . "$salto";
						@ fwrite($fichero,"$ls_string"); 
					}					
				}
				fclose($fichero); 
			}	//	FIN PROMOCION


			// cambiar el estado del alumno en matricula cuando viene retirado en promocion
			$sql_retirados = "SELECT * FROM archivo_05 WHERE id_ano=".$ano;
			$result_retirados = pg_exec($conn,$sql_retirados);
			for($i=0;$i<pg_numrows($result_retirados);$i++){
				$fila_retirados = pg_fetch_array($result_retirados,$i);
				if($fila_retirados['situacion_final']==3){
					$sql_u_matricula = "UPDATE matricula SET bool_ar=1 WHERE rut_alumno=".$fila_retirados['rut_alumno']." AND id_curso=".$fila_retirados['id_curso']." AND id_ano=".$ano;
				}
				else{
					$sql_u_matricula = "UPDATE matricula SET bool_ar=0 WHERE rut_alumno=".$fila_retirados['rut_alumno']." AND id_curso=".$fila_retirados['id_curso']." AND id_ano=".$ano;
				}
				$result_u_matricula = pg_exec($conn,$sql_u_matricula);								
			}

	} // fin for j	
	
	$sql_borra_01 = "DELETE FROM archivo_01";
	$sql_borra_03 = "DELETE FROM archivo_03";
	$sql_borra_04 = "DELETE FROM archivo_04" ;
	$sql_borra_05 = "DELETE FROM archivo_05";
	$sql_borra_23 = "DELETE FROM archivo_23";
	$sql_borra_25 = "DELETE FROM archivo_25";

/*	$result_borra_01 = pg_exec($conn,$sql_borra_01);								
	$result_borra_03 = pg_exec($conn,$sql_borra_03);								
	$result_borra_04 = pg_exec($conn,$sql_borra_04);										
	$result_borra_05 = pg_exec($conn,$sql_borra_05);								
	$result_borra_23 = pg_exec($conn,$sql_borra_23);								
	$result_borra_25 = pg_exec($conn,$sql_borra_25);	
*/
/*	echo "<script>window.location = 'ArchRech.php?caso=4'</script>";*/

pg_close($conn);
								
?>