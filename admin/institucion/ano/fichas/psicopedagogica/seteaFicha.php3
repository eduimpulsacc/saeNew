<?php 
	require('../../../../../util/header.inc');
	$pag="";
	$pag="fichaPsicopedagogica.php?tipo_hoja=".$tipo_hoja."&c_ano=".$c_ano."&c_curso=".$c_curso."&c_alumno=".$alumno."";
	
	if($caso==1){//MOSTRAR FICHA

		$_FICHAM	=	$idFicha;
		if(!session_is_registered('_FICHAM')){
			session_register('_FICHAM');
		};


		$_ALUMNO	=	$alumno;
		if(!session_is_registered('_ALUMNO')){
			session_register('_ALUMNO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==2){//INGRESAR FICHA
		$_ALUMNO	=	$alumno;
		if(!session_is_registered('_ALUMNO')){
			session_register('_ALUMNO');
		};

		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==3){//MODIFICAR FICHA
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	echo "<script>window.location = '".$pag."' </script>";
?>