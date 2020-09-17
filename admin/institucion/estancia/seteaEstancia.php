<?php 
	require('../../../util/header.inc');
	$pag="estancia.php";
	if($caso==1){//MOSTRAR ESTANCIA
		$_ESTANCIA	=	$estancia;
		if(!session_is_registered('_ESTANCIA')){
			session_register('_ESTANCIA');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR ESTANCIA
		if(session_is_registered('_ESTANCIA')){
			session_unregister('_ESTANCIA');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR ESTANCIA
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==4){//MOSTRAR ESTANCIA
		session_unregister('_CURSO');			//LIBERA EL CURSO
		session_unregister('_MATRICULA');		//LIBERA EL MATRICULA
		session_unregister('_PERIODO');			//LIBERA EL PERIODO
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==9){//ELIMINAR ESTANCIA
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoEstancia.php";
	};
	echo "<script>window.location = '".$pag."' </script>";
?>