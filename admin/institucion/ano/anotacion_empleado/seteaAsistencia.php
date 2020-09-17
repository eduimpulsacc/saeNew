<?php 
	require('../../../../util/header.inc');
	$pag="asistencia.php";
echo $mes;
//exit();
	if($caso==1){//INGRESAR ASISTENCIA

		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};

		$pag="asistencia.php?cmbMes=".$mes;
	};
	
	if($caso==2){//MOSTRAR ASISTENCIA

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	pg_close($conn);
	echo "<script>window.location = '".$pag."' </script>";	
	
?>