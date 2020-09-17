<?php 
	require('../../../../../../util/header.inc');
	if($caso==1){//MOSTRAR ANOTACION
		$_EMPLEADO	=	$empleado;
		if(!session_is_registered('_EMPLEADO')){
			session_register('_EMPLEADO');
		};

		$_ANOTACION	=	$anotacion;
		if(!session_is_registered('_ANOTACION')){
			session_register('_ANOTACION');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		pg_close($conn);
		echo "<script>window.location = 'mostrarAnotacion.php3'</script>";
	};
	if($caso==2){//INGRESAR ANOTACION
		if(session_is_registered('_ANOTACION')){
			session_unregister('_ANOTACION');
		};

		$_EMPLEADO	=	$empleado;
		if(!session_is_registered('_EMPLEADO')){
			session_register('_EMPLEADO');
		};

		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		pg_close($conn);
		echo "<script>window.location = 'anotacion.php3'</script>";
	};
?>