<?php 
	require('../../../util/header.inc');
	
	$pag="agenda.php3";

	if($caso==1){//MOSTRAR AGENDA
		$_NOTA_AGENDA	=	$notaAgenda;
		if(!session_is_registered('_NOTA_AGENDA')){
			session_register('_NOTA_AGENDA');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	
	if($caso==2){//INGRESAR AGENDA
		if(session_is_registered('_NOTA_AGENDA')){
			session_unregister('_NOTA_AGENDA');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==3){//MODIFICAR AGENDA
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
		$pag="procesoAgenda.php3";
	};
	pg_close($conn);
	echo "<script>window.location = '".$pag."' </script>";
?>