<? require('../../../../../util/header.inc');
	
	$qry ="";
	$qry = "UPDATE comunicacion SET autorizacion=2 WHERE id_comun=".$comunicacion;
	$Rs_Comun = @pg_exec($conn,$qry);
	echo "<script>window.location = 'ListaComunicacionAdm.php'</script>";

?>