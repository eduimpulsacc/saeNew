<?php 
	require('../../../../util/header.inc');
	$pag="atrasos.php";
echo $mes;
//exit();
	if($caso==1){//INGRESAR ATRASOS

		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};

		$pag="atrasos.php?cmbMes=".$mes;
	};
	
	if($caso==2){//MOSTRAR ATRASOS

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	pg_close($conn);
	echo "<script>window.location = '".$pag."' </script>";	
	
?>