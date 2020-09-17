<?php 
	require('../../../../../../util/header.inc');
	$pag="InscribirAlumnos.php";
	
	if($caso==1){//MOSTRAR EXAMEN
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};	
		$_RAMO		= $id_ramo;
		if(!session_is_registered('_RAMO')){
			session_register('_RAMO');
		};	
		$_PERIODO 	=	$cmbPERIODO;
		if(!session_is_registered('_PERIODO')){
			session_register('_PERIODO');
		};		
		
	};
	if($caso==2){//INGRESAR EXAMEN
		
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		
	};
	if($caso==3){//MODIFICAR EXAMEN
        
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$_PERIODO 	=	$cmbPERIODO;
		if(!session_is_registered('_PERIODO')){
			session_register('_PERIODO');
		};
	};
	echo "<script>parent.location.href = 'examen.php' </script>";	
	
?>