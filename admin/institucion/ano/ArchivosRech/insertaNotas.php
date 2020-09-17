<?
	require('../../../../util/header.inc');
	
	$ano			= $_ANO;


	$sql_ano = "SELECT * FROM ano_escolar WHERE id_ano=".$ano;
	$result_ano = pg_exec($conn,$sql_ano);
	$fil = pg_fetch_array($result_ano,0);
	$nro_ano = $fil['nro_ano'] ;

	// insertar en notas2005
	// primero buscar los periodos
	$sql_periodo = "SELECT id_periodo FROM periodo WHERE id_ano=".$ano;		
	$result_periodo = pg_exec($conn,$sql_periodo);

	for($k=$w; $k<$y; $k++){

		$fila_periodo = pg_fetch_array($result_periodo,$k);
		$periodo = $fila_periodo['id_periodo'];
		$sql_notas = "SELECT alumno,id_ramo,promedio1,promedio2 FROM archivo_04 WHERE (eximido='' OR eximido is null) AND id_ano=".$ano;
		$result_notas = pg_exec($conn,$sql_notas);
		
		for($m=0;$m<pg_numrows($result_notas);$m++){
			$promedio1 = '';
			$promedio = '';
			$promedio_dos = '';
			$fila_notas = pg_fetch_array($result_notas,$m);
			$promedio = $fila_notas['promedio1'];
			$promedio_dos = $fila_notas['promedio2'];
			
			if(substr($promedio,1,1)==','){
				$promedio1 = str_replace(",","",$promedio);
			}else if(substr($promedio,1,1)=='.'){
				$promedio1 = str_replace(".","",$promedio);
			}	

			if($promedio1=='00' || $promedio1=='0' || $promedio1==''){
				$promedio1 = '';
			}
			if($promedio_dos=='00' || $promedio_dos=='0' || $promedio_dos==''){ 
				$promedio_dos = '';
			}
			if($promedio1=='' && $promedio_dos==''){
				$promedio1 = 0;
			}
			
			$sql_a_notas = "INSERT INTO notas".$nro_ano." VALUES(".$fila_notas['alumno'].",".$fila_notas['id_ramo'].",".$periodo.",'".trim($promedio1)."".trim($promedio_dos)."','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','".trim($promedio1)."".trim($promedio_dos)."')";

			$result_a_notas = pg_exec($conn,$sql_a_notas);	
			
		}
		$w = $w + 1;		
		$y = $w + 1;


		if($y==pg_numrows($result_periodo)){
				?>
				<script>window.location='ArchRech.php?caso=5'</script>
				<?
		}else{
				?>				
				<script>window.location='insertaNotas.php?w=<?=$w?>&y=<?=$y?>'</script>
				<? 
		}

	}

?>