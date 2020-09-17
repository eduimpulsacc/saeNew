<?php 
	require('../../../util/header.inc');
	$pag = "empleado.php3";
	
		
	if ($pesta == 1){
	   $pag = "empleado.php3?pesta=1";
	}
	if ($pesta == 2){
	   $pag = "empleado.php3?pesta=2";
	}
	if ($pesta == 3){
	   $pag = "empleado.php3?pesta=3";
	}
	if ($pesta == 4){
	   $pag = "empleado.php3?pesta=4";
	}   
	
	if($caso==1){//MOSTRAR EMPLEADO
		$_EMPLEADO	=	$empleado;
		if(!session_is_registered('_EMPLEADO')){
			session_register('_EMPLEADO');
		};
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==2){//INGRESAR EMPLEADO
		if(session_is_registered('_EMPLEADO')){
			session_unregister('_EMPLEADO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==3){//MODIFICAR EMPLEADO
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==4){//MOSTRAR EMPLEADO VOLVIENDO DE ANOTACION
		session_unregister('_ANOTACION');		//LIBERA LA ANOTACION
		session_unregister('_ID_USER');			//LIBERA ID_USUARIO DEL EMPLEADO

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==9){//ELIMINAR INSTITUCION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoEmpleado.php3";
	};
	echo "<script>window.location = '".$pag."' </script>";

?>