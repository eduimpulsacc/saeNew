<?php 
	require('../../../../util/header.inc');
	$pag="periodo.php3";
	if($caso==1){//MOSTRAR PERIODO
		$_PERIODO	=	$periodo;
		if(!session_is_registered('_PERIODO')){
			session_register('_PERIODO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR AÑO ESCOLAR
		if(session_is_registered('_PERIODO')){
			session_unregister('_PERIODO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="creaPeriodo.php";
	};
	if($caso==3){//MODIFICAR AÑO ESCOLAR
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==4){//CERRAR PERIODO ESCOLAR
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="periodo.php3?cerrarp=1&opc=$opc";
	};
	
	if($caso==9){//ELIMINAR INSTITUCION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoPeriodo.php3";
	};
	echo "<script>window.location = '".$pag."' </script>";

?>