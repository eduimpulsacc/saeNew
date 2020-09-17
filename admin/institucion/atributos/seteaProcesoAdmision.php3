<?php 
	require('../../../util/header.inc');
	if($caso==1){//MOSTRAR CARTA DIRECCION
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR CARTA DIRECCION
		if(session_is_registered('_INSTIT')){
			session_unregister('_INSTIT');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR CARTA DIRECCION
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	echo "<script>window.location = 'procesoAdmision.php3'</script>";
?>