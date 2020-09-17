<?php 
	require('../../../util/header.inc');
	$pag="remate.php3";

	if($caso==1){//MOSTRAR REMATE
		if ($remate!=""){
			$_REMATE	=	$remate;
			if(!session_is_registered('_REMATE')){
				session_register('_REMATE');
			};
		}

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==2){//INGRESAR REMATE 
		if(session_is_registered('_REMATE')){
			session_unregister('_REMATE');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==3){//MODIFICAR REMATE
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==9){//ELIMINAR REMATE
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoRemate.php3";
	};
	echo "<script>window.location = '".$pag."'</script>";
?>