<?php 
	require('../../../../../../util/header.inc');
	if($caso==1){//MOSTRAR ALUMNO
		$_ALUMNO	=	$alumno;
		if(!session_is_registered('_ALUMNO')){
			session_register('_ALUMNO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
/*	if($caso==2){//INGRESAR ALUMNO
		if(session_is_registered('_ALUMNO')){
			session_unregister('_ALUMNO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR ALUMNO
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
	if($caso==5){//MOSTRAR ALUMNO
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	*/
	pg_close($conn);
	echo "<script>window.location = 'evalua_alumno.php3'</script>";
?>