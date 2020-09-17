<?php 
	 require('../../../../../util/header.inc');
	$pag="Man_Comunicacion.php";
	
	if($caso==1){//MOSTRAR COMUNICACION
		$_COMUNICACION = $comunicacion;
		if(!session_is_registered('_COMUNICACION')){
			session_register('_COMUNICACION');
		};
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR COMUNICACION
	
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR COMUNICACION
        $_COMUNICACION = $comunicacion;
		if(!session_is_registered('_COMUNICACION')){
			session_register('_COMUNICACION');
		};
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==4){//MOSTRAR COMUNICACION
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==9){//ELIMINAR COMUNICACION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoComunicacion.php";
	};
	if($caso!=9){
		echo "<script>window.location = '".$pag."' </script>";
	}else{
		echo "<script>window.location = '".$pag."' </script>";
//		echo "<script>parent.location.href = '../../../../../fichas/docente/index3.html' </script>";	
	}
?>