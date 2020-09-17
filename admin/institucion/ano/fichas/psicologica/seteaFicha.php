<?php 
	require('../../../../../util/header.inc');
	
	$pag="fichaPsicologica.php";

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
	if($caso==4){//INGRESAE FICHA NUEVA
		$_ANO	=	$ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
		};

		$_ALUMNO	=	$alumno;
		if(!session_is_registered('_ALUMNO')){
			session_register('_ALUMNO');
		};
		
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==5){//LISTADO DE FICHAS DE ALUMNO EN ESPECIFICO
		$_ALUMNO	=	$alumno;
		if(!session_is_registered('_ALUMNO')){
			session_register('_ALUMNO');
		};

		$pag ="listaFichaAlumnos.php";
	};
	if($caso==9){//ELIMINAR FICHA
		$_IDFICHA	= $Id_Ficha;
		if(!session_is_registered('_IDFICHA')){
			session_register('_IDFICHA');
		};
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoFicha.php";
	};

	echo "<script>window.location = '".$pag."' </script>";
?>