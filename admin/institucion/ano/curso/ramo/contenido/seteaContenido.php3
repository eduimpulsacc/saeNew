<?php 
	require('../../../../../../util/header.inc');
	$pag="contenido.php3";

	if($caso==1){//MOSTRAR CONTENIDO
		$_ARCHIVO	=	$archivo;
		if(!session_is_registered('_ARCHIVO')){
			session_register('_ARCHIVO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR CONTENIDO
		if(session_is_registered('_ARCHIVO')){
			session_unregister('_ARCHIVO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR CONTENIDO
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==9){//ELIMINAR CONTENIDO
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoContenido.php3";
	};
	echo "<script>window.location = '".$pag."' </script>";
?>