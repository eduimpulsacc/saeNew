<?php 
	require('../../../../../../util/header.inc');
	$pag="apoderado.php";
	if($caso==1){//MOSTRAR APODERADO
		$_APODERADO	=	$apoderado;
		if(!session_is_registered('_APODERADO')){
			session_register('_APODERADO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR APODERADO
		if(session_is_registered('_APODERADO')){
			session_unregister('_APODERADO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR ALUMNO
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
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
		$pag="procesoApoderado.php";
	};
    pg_close($conn);
	echo "<script>window.location = '".$pag."' </script>";
?>