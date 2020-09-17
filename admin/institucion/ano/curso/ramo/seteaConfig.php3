<?php 

    require('../../../../../util/header.inc');
	 $pag="configuraRamos.php";


	
	if($caso==1){//MOSTRAR CONFIGURACION
		$_CURSO	=	$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		};
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR CONFIGURACION
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR CONFIGURACION
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	

	if($caso==9){//ELIMINAR INSTITUCION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoConfiguracion.php3";
	};
	
	  echo "<script>window.location = '".$pag."' </script>";
	
?>