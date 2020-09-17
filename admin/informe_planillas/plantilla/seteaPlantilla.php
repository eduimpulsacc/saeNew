<?php require('../../../../util/header.inc');
	$pag="ModificaPlantilla.php";
	if($caso==1){//MOSTRAR AÑO ESCOLAR
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR AÑO ESCOLAR
		if(session_is_registered('_ANO')){
			session_unregister('_ANO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR AÑO ESCOLAR
		$_FRMMODO	=	"modificar";
		$_PLANTILLA =	$plantilla;
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		if(!session_is_registered('_PLANTILLA')){
			session_register('_PLANTILLA');
		};

	};
	if($caso==4){//MOSTRAR AÑO 
		
	};
	if($caso==9){//ELIMINAR INSTITUCION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoPlantilla.php3";
	};
	echo "<script>window.location = '".$pag."' </script>";
?>