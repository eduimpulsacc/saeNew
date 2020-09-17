<?php 
	require('../../../../../util/header.inc');
	$pag="situacionFinal.php3";
	
	if($caso==1){//MOSTRAR SITUACION FINAL
		
		$_FRMMODO	=	"mostrar";
		$_CURSO     =    $curso;
		
		if(!session_is_registered('_CURSO')){
			session_unregister('_CURSO');
		};
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR SITUACION FINAL
		
		$_FRMMODO	=	"ingresar";
		$_CURSO     =    $curso;
		
		if(!ssession_is_registered('_CURSO')){
			session_unregister('_CURSO');
		};
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		
	};
	if($caso==3){//MODIFICAR SITUACION FINAL
        
		$_FRMMODO	=	"modificar";
		$_CURSO     =    $curso;
		
		if(!session_is_registered('_CURSO')){
			session_unregister('_CURSO');
		};
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

	if($caso==9){//ELIMINAR ?
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoSituacionFinal.php3";
	};
	echo "<script>window.location = '".$pag."' </script>";
?>