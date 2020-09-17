<?php 
	require('../../../../util/header.inc');
	if($caso==1){//MOSTRAR NOTICIA
		$_PAGOS	=	$pago;
		if(!session_is_registered('_PAGOS')){
			session_register('_PAGOS');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR NOTICIA
		if(session_is_registered('_PAGOS')){
			session_unregister('_PAGOS');
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
	echo "<script>window.location = 'pagos.php3'</script>";
?>