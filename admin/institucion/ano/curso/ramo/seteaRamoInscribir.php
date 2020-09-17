<?php 
	require('../../../../../util/header.inc');
	$pag="InscribirAlumnos.php";
	
	if($caso==1){//MOSTRAR RAMO
		$_RAMO	=	$ramo;
		$_PLAN	=	$plan;
		if(!session_is_registered('_PLAN')){
			session_register('_PLAN');
		};
		if(!session_is_registered('_RAMO')){
			session_register('_RAMO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};	
		
		
	};
	if($caso==2){//INGRESAR RAMO
		if(session_is_registered('_RAMO')){
			session_unregister('_RAMO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$_PLAN	=	$plan;
		if(!session_is_registered('_PLAN')){
			session_register('_PLAN');
		};
	};
	if($caso==3){//MODIFICAR RAMO
        
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==4){//MOSTRAR RAMO
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==9){//ELIMINAR INSTITUCION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoRamoInscribir.php3";
	};
	if($from!=1){
		echo "<script>window.location = '".$pag."' </script>";
	}else{
		echo "<script>parent.location.href = '../../../../../fichas/docente/index3.html' </script>";	
	}
?>