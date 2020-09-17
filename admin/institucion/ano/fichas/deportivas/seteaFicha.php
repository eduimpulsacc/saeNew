<?php 
	require('../../../../../util/header.inc');

	$pag="fichaDeportiva.php";
if ($curso){
$_CURSO=$curso;
	if(!session_is_registered('_CURSO')){
		session_register('_CURSO');
	};
}
	if($caso==1){//MOSTRAR FICHA
	
		$_ALUMNO	=	$alumno;
		if(!session_is_registered('_ALUMNO')){
			session_register('_ALUMNO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==2){//INGRESAR FICHA
		
		if(session_is_registered('_ALUMNO')){
			session_unregister('_ALUMNO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==3){//MODIFICAR FICHA
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	


//	echo "<script>window.location = '".$pag."' </script>";
?>