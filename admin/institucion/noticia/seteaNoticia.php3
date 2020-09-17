<?php 
	require('../../../util/header.inc');
	$pag="noticia.php3";

	if($caso==1){//MOSTRAR NOTICIA
		$_NOTICIA	=	$noticia;
		if(!session_is_registered('_NOTICIA')){
			session_register('_NOTICIA');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR NOTICIA
		if(session_is_registered('_NOTICIA')){
			session_unregister('_NOTICIA');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR NOTICIA
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	
	if($caso==9){//ELIMINAR INSTITUCION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoNoticia.php3";
	};
	echo "<script>window.location = '".$pag."' </script>";
?>