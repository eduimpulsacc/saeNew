<? require('../../../util/header.inc');
 
	$ano = $_ANO;
	$institucion = $_INSTIT;
	
	$sql_nro = "SELECT * FROM ano_escolar WHERE id_ano=".$ano;	
	$result_nro = pg_exec($conn,$sql_nro);
	$fil_nro = @pg_fetch_array($result_nro,0);
	$nro_ano = $fil_nro['nro_ano'];	
	$nro_ano_ant = $nro_ano - 1;	
	$tipo_regimen = $fil_nro['tipo_regimen'];		


		$sql = "SELECT * FROM ano_escolar a INNER JOIN periodo p ON a.id_ano=p.id_ano WHERE a.nro_ano=".$nro_ano_ant." AND a.id_institucion=".$institucion." AND a.tipo_regimen=".$tipo_regimen;
		$result = pg_exec($conn,$sql);	
		if(pg_num_rows($result)=="")
		{
			$sql2 = "SELECT * FROM ano_escolar a INNER JOIN periodo p ON a.id_ano=p.id_ano WHERE a.nro_ano=".$nro_ano_ant." AND a.id_institucion=".$institucion;
			$result = pg_exec($conn,$sql2);	
		}
		$filano = @pg_fetch_array($result,0);
		$anterior = $filano['id_ano'];
		$actual = $ano;


		pg_close($conn);
		
        echo "<script>window.location = 'procesoMatAuto.php3?caso=2&anterior=".$anterior."&actual=".$actual."&nro_ano=".$nro_ano."'</script>";	


?>