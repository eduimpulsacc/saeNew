<?php 
header ("Location: ../../../solicitud2/index.php");
	require('../../../util/header.inc');
	$pag="Man_Soporte.php3";

	if($caso==1){//MOSTRAR SOPORTE
          
		 $_SOPORTE =$soporte;
		if(!session_is_registered('_SOPORTE')){
			session_register('_SOPORTE');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR SOPORTE
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR SOPORTE
		$_FRMMODO	=	"modificar";         
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$_SOPORTE =$soporte;
		if(!session_is_registered('_SOPORTE')){
			session_register('_SOPORTE');
		};
	};

	
	if($caso==9){//ELIMINAR plan Estudio
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoSoporte.php3";
	};
	echo "<script>window.location = '".$pag."' </script>";
?>