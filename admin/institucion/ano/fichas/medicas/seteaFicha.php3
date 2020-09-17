<?php 
	require('../../../../../util/header.inc');
	$pag="";
	
	if($tipo==1){
	$pag="fichaMedica.php?tipo_hoja=".$tipo_hoja."&c_ano=".$c_ano."&c_curso=".$_CURSO."&c_alumno=".$alumno."";}
	elseif($tipo==2){
	$pag="fichaMedica3.php?tipo_hoja=".$tipo_hoja."&c_ano=".$c_ano."&c_curso=".$_CURSO."&c_alumno=".$alumno."&id_ficha=".$idFicha;
	}
	
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