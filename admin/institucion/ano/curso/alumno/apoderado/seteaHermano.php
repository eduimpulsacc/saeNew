<?php 
	require('../../../../../../util/header.inc');
	$pag="../alumno.php3?pesta=2";
	if($caso==1){//MOSTRAR APODERADO
		$_HERMANO	=	$hermano;
		if(!session_is_registered('_HERMANO')){
			session_register('_HERMANO');
		};

		$_FRMMODOH	=	"mostrar";
		if(!session_is_registered('_FRMMODOH')){
			session_register('_FRMMODOH');
		};
	};
	if($caso==2){//INGRESAR APODERADO
		if(session_is_registered('_HERMANO')){
			session_unregister('_HERMANO');
		};
		$_FRMMODOH	=	"ingresar";
		if(!session_is_registered('_FRMMODOH')){
			session_register('_FRMMODOH');
		};
	};
	if($caso==3){//MODIFICAR ALUMNO
		$_FRMMODOH	=	"modificar";
		if(!session_is_registered('_FRMMODOH')){
			session_register('_FRMMODOH');
		};
		$_HERMANOMOD	=	"$hermanomod";
		if(!session_is_registered('_HERMANOMOD')){
			session_register('_HERMANOMOD');
		};	
		
	};

	
	if($caso==5){//MOSTRAR APODERADO
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
		
		$_HERMANOMOD	=	"$hermanoelim";
		if(!session_is_registered('_HERMANOMOD')){
			session_register('_HERMANOMOD');
		};
		$pag="procesoApoderado.php3?caso=9";
	};
    pg_close($conn); 
	echo "<script>window.location = '".$pag."' </script>";
?>