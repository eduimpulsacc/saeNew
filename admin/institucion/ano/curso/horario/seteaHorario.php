<?php 
	require('../../../../../util/header.inc');
	$pag = "horario.php";
	if($caso==1){//MOSTRAR ALUMNO
		$_HORARIO	=	$horario;
		if(!session_is_registered('_HORARIO')){
			session_register('_HORARIO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR HORARIO
		if(session_is_registered('_HORARIO')){
			session_unregister('_HORARIO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR HORARIO
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==4){//MOSTRAR ALUMNO VOLVIENDO DE ANOTACION O APODERADO
		session_unregister('_ANOTACION');		//LIBERA LA ANOTACION
		session_unregister('_APODERADO');		//LIBERA EL APODERADO

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==5){//MOSTRAR HORARIO
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==9){//ELIMINA HORARIO
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag = "procesoHorario.php";
	};

	echo "<script>window.location = '".$pag."' </script>";
?>