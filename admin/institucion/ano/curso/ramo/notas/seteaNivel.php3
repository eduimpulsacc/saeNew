<?php require('../../../../../../util/header.inc');
$pag="../listarRamos.php3";

	if($caso==1){//MOSTRAR PRUEBA NIVEL
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR PRUEBA NIVEL
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR PRUEBA NIVEL
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	echo "<script>window.location = '".$pag."' </script>";
?>
