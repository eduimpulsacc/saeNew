<?
	require('../../../../util/header.inc');

	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	 
	$sql_ano = "SELECT * FROM ano_escolar WHERE id_ano=".$ano;
	$result_ano = pg_exec($conn,$sql_ano);
	$fil = pg_fetch_array($result_ano,0);
	$nro_ano = $fil['nro_ano'] ;
	
	// BUSCA LOS ARCHIVOS QUE EXISTEN PARA DISTRIBUIRLOS EN LAS RESPECTIVAS TABLAS
	$sql = "SELECT * FROM archivo_rech ar WHERE ar.rdb=".$institucion." AND ar.estado_archivo=1 order by numero desc";
	$result = pg_exec($conn,$sql);		


	for($j=0;$j<pg_numrows($result);$j++){
			$fila = pg_fetch_array($result,$j);
			$archivo = $fila['numero'];
			  
	
			//	NOTAS 2005  y TIENE2005
			if($archivo==4 && $sw!=1){
				$sql_notas = "SELECT r.id_ramo, c.id_curso, r.cod_subsector,c.grado_curso,c.letra_curso,c.ensenanza FROM ramo r INNER JOIN curso c on r.id_curso=c.id_curso WHERE c.id_ano=".$ano." ";
				$result_notas = @pg_exec($conn,$sql_notas);	
				for($i=0;$i<@pg_numrows($result_notas);$i++){
					$fila_notas = pg_fetch_array($result_notas,$i);
					
					$sql_i_notas = "UPDATE archivo_04 SET id_ano=".$ano.",id_curso=".$fila_notas['id_curso'].",id_ramo=".$fila_notas['id_ramo']." WHERE grado=".$fila_notas['grado_curso']." AND letra='".trim($fila_notas['letra_curso'])."' AND ensenanza=".$fila_notas['ensenanza']." AND subsector=".$fila_notas['cod_subsector'];
					$result_i_notas = @pg_exec($conn,$sql_i_notas);	
				}
				
				// insertar en tiene2005
				$sql_tiene = "SELECT alumno, id_ramo, id_curso FROM archivo_04 WHERE (eximido='' OR eximido is null) AND id_ano=".$ano;
				$result_tiene = pg_exec($conn,$sql_tiene);	
				
				for($i=0;$i<pg_numrows($result_tiene);$i++){
					$fila_tiene = pg_fetch_array($result_tiene,$i);
					$sql_a_tiene = "INSERT INTO tiene".$nro_ano." (rut_alumno,id_ramo,id_curso) VALUES(".$fila_tiene['alumno'].",".$fila_tiene['id_ramo'].",".$fila_tiene['id_curso'].")";
					$result_a_tiene = @pg_exec($conn,$sql_a_tiene);	
					
				} 
                ?>
				<script>window.location='insertaNotas.php?w=0&y=1'</script><? 
					

/*		
				// insertar en notas2005
				// primero buscar los periodos
				$sql_periodo = "SELECT id_periodo FROM periodo WHERE id_ano=".$ano;		
				$result_periodo = pg_exec($conn,$sql_periodo);

//				for($k=0;$k<pg_numrows($result_periodo);$k++){
				for($k=$w;$k<$y;$k++){
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
						
						$sql_a_notas = "INSERT INTO notas".$nro_ano." VALUES(".$fila_notas['alumno'].",".$fila_notas['id_ramo'].",".$periodo.",'".trim($promedio1)."".trim($promedio2)."','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','".trim($promedio1)."".trim($fila_notas['promedio2'])."')";
	
						$result_a_notas = pg_exec($conn,$sql_a_notas);	
						
					}

					$w = $w + 1;		
					$y = $w + 1;

echo "<br><br>dentro del for<br>w=".$w." ** y=".$y." ** tot_periodo=".@pg_numrows($result_periodo)." <br>";

					if($y==@pg_numrows($result_periodo)){
/*						echo "<script>window.location = 'Distribuye_Notas.php?sw=1'</script>";*/
?><!--						<script> setTimeout("window.location='Distribuye_Notas.php?sw=1'");</script>--><?
//					}
/*					else{
?>						<script> setTimeout("window.location='Distribuye_Notas.php?w=<? echo $w;?>&y=<? echo $y;?>'");</script><?
					}

				}*/

			}	// FIN NOTAS2005  Y TIENE2005
			

			//PROMOCION
			if($archivo==5 && $sw!=1){
//			if($archivo==5){
				$sql_promocion = "SELECT * FROM curso WHERE id_ano=".$ano." ";
				$result_promocion = pg_exec($conn,$sql_promocion);
				for($i=0;$i<pg_numrows($result_promocion);$i++){
					$fila_promocion = pg_fetch_array($result_promocion,$i);
					$sql_upd_promocion = "UPDATE archivo_05 SET id_ano=".$fila_promocion['id_ano'].",id_curso=".$fila_promocion['id_curso']." WHERE grado=".$fila_promocion['grado_curso']." AND letra='".trim($fila_promocion['letra_curso'])."' AND cod_ens=".$fila_promocion['ensenanza'];
					$result_upd_promocion = pg_exec($conn,$sql_upd_promocion);
	
				}
				// falta la fecha de retiro
				$sql_e_promocion = "SELECT * FROM archivo_05 WHERE id_ano=".$ano;
				$result_e_promocion = pg_exec($conn,$sql_e_promocion);
				$num_e_promocion = @pg_numrows($sql_e_promocion);
				
				echo "<<< Total : $num_e_promocion  >>><br><br>";

				for($k=0;$k<pg_numrows($result_e_promocion);$k++){
					$fila = pg_fetch_array($result_e_promocion,$k);
					if($fila['prom_general']==NULL || $fila['prom_general']==''){
						$fila['prom_general']=0;
					}
					$sql_a_promocion = "INSERT INTO promocion (rdb,id_ano,id_curso,rut_alumno,promedio,asistencia,situacion_final,observacion) VALUES(".$fila['rdb'].",".$fila['id_ano'].",".$fila['id_curso'].",".$fila['rut_alumno'].",".$fila['prom_general'].",".$fila['porc_asistencia'].",".$fila['situacion_final'].",'".$fila['observacion']."')";
					$result_a_promocion = @pg_exec($conn,$sql_a_promocion);
					
					echo "Insertado: $k  de $num_e_promocion <br>";
					
				}
				
				echo "<br><br>";
				
//				fclose($fichero); 

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
				
				echo "<<< Fin for para actualizar matricula.. >>><br><br>";

			}	//	FIN PROMOCION

	} // fin for j	
	
	echo "Fin proceso, distribuye notas....";
	
?>