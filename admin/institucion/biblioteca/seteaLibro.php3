<?php 
	require('../../../util/header.inc');
	if($caso==1){//MOSTRAR NOTICIA
		$_LIBRO	=	$libro;
		if(!session_is_registered('_LIBRO')){
			session_register('_LIBRO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR NOTICIA
		if(session_is_registered('_LIBRO')){
			session_unregister('_LIBRO');
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
	echo "<script>window.location = 'libro.php3'</script>";
?>