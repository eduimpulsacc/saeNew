<?php 
	require('../../../../../util/header.inc');
	$pag="formulas.php3?modo=$modo";

	if($caso==1){//MOSTRAR FORMULA
		$_RAMO	=	$ramo;
		if(!session_is_registered('_RAMO')){
			session_register('_RAMO');
		};
		$_FORMULA	=	$formula;
		if(!session_is_registered('_FORMULA')){
			session_register('_FORMULA');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR FORMULA
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR FORMULA
        $_FORMULA	=	$formula;
		if(!session_is_registered('_FORMULA')){
			session_register('_FORMULA');
		};
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==4){//MOSTRAR FORMULA
		
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="listarFormulas.php3";
	};
	if($caso==9){//ELIMINAR FORMULA
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoFormula.php3";
	};
		echo "<script>window.location = '".$pag."' </script>";
?>