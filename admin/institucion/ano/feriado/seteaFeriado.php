<?php 
	require('../../../../util/header.inc');
	$pag="index.php";
	
	if($caso==1){//MOSTRAR AÑO ESCOLAR
		$_ANO	=	$ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	
	if($caso==2){//INGRESAR FERIADO
		$_FRMMODO	=	"ingresar";
		//if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		//};
	};
	
	if($caso==3){//MODIFICAR AÑO ESCOLAR
		$_FRMMODO	=	"modificar";
		$_IDFERIADO =	$id_feriado;
		$_BOOLFER	  = $bool_fer;
		
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		if(!session_is_registered('_IDFERIADO')){
			session_register('_IDFERIADO');
		};
		if(!session_is_registered('_BOOLFER')){
			session_register('_BOOLFER');
		};
		
	};
	if($caso==4){ 
		session_unregister('_IDFERIADO');
		session_unregister('_BOOLFER');
		
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="listaFeriado.php";
	};
	
	if($caso==9){//ELIMINAR feriado
		$_FRMMODO	=	"eliminar";
		$_IDFERIADO =	$id_feriado;
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		if(!session_is_registered('_IDFERIADO')){
			session_register('_IDFERIADO');
		};
		$pag="procesoFeriado.php";
	};
	echo "<script>window.location = '".$pag."' </script>";
?>