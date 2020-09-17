<?	require('../../util/header.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$perfil     	=$_PERFIL;

    if ($perfil==14 or $perfil==0){

		$id_ciclo = $_REQUEST['id_ciclo'];
		 
		$borra_ciclo = "delete from ciclos where id_ano = '$ano' and id_ciclo = '$id_ciclo'";
		$borra_ciclo = @pg_exec($conn, $borra_ciclo);
		
		
		$borra_ciclo2 = "delete from ciclo_conf where id_ano = '$ano' and id_ciclo = '$id_ciclo'";
		$borra_ciclo2 = @pg_exec($conn, $borra_ciclo2);
		
		pg_close($conn);	
	
	}
	
	echo "<script>window.location='asignar_ciclo.php?tipo=1'</script>";
	
?>