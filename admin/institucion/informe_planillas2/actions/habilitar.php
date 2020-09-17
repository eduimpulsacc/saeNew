<?	require('../../../../util/header.inc');
	$institucion =$_INSTIT;
	$_POSP = 4;
	$_bot = 7;
	
	
	$activa = $_GET['x'];
	$plantilla = $_GET['y'];
	
	if ($activa == 1) {
		$valor = 0;
	} else {
		$valor = 1;
	}
	
	$sql_activar = "UPDATE informe_plantilla SET activa = ".$valor." WHERE rdb = ".$institucion." AND id_plantilla = ".$plantilla;
	//echo $sql_activar."<br>";
	pg_Exec($conn,$sql_activar);
	
	echo "<script>location.href='../ver_informe.php?plantilla=".$plantilla."&creada=1';</script>";
	
?>