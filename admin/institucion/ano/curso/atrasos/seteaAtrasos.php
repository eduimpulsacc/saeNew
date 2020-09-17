<?php 
	require('../../../../../util/header.inc');
	$pag="atrasos.php";


	if($caso==1){//INGRESAR ASISTENCIA

		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};

		$pag="atrasos.php?cmbMes=".$mes;
	};
	
	if($caso==2){//MOSTRAR ASISTENCIA

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	
	pg_close();

	echo "<script>window.location = '".$pag."' </script>";	
	
?>