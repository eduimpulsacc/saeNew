<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	//------------------
	for ($j=0; $j < $NumeroSubsectores; $j++)
	{
		$sqlConsulta = "select * from horas_subsectores where id_ano = $ano and cod_subsector = $subsector[$j]";
		$resultado_horas = pg_exec($conn,$sqlConsulta);
		$total= pg_numrows($resultado_horas);
		if ($total==1){
			$sqlUpdate = "update horas_subsectores set horas = $horas[$j] where cod_subsector = $subsector[$j] and id_ano = $ano";
			$resultado_horas = pg_exec($conn,$sqlUpdate);			
			if (!$resultado_horas){ echo "ERROR: $sqlUpdate"; exit;}
		}
		else
		{
			$sqlInsert = "insert into horas_subsectores (id_ano, cod_subsector, horas) values ($ano, $subsector[$j], $horas[$j])";
			$resultado_horas = pg_exec($conn,$sqlInsert);			
			if (!$resultado_horas){ echo "ERROR: $sqlInsert"; exit;}			
		}

	}
	pg_close($conn);
	echo "<script>window.location = 'NumeroHorasSemanales.php?accion=1'</script>";		
?>
