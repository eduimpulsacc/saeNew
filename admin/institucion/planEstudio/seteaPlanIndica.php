<?php 

	require('../../../util/header.inc');
	$pag="PlanIndica.php";

	if($caso==1){//MOSTRAR plan Estudio
          
		 $_PLAN =$plan;
		if(!session_is_registered('_PLAN')){
			session_register('_PLAN');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR plan Estudio
          $_INSTIT = $institucion1;
		if(session_is_registered('_ENSENANZA')){
			session_unregister('_ENSENANZA');
		};
		$_FRMMODO	=	"ingresar1";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR plan Estudio
		$_FRMMODO	=	"modificar";         
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	
	if($caso==9){//ELIMINAR plan Estudio
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoPlanEstudio.php";
	};
	echo "<script>window.location = '".$pag."' </script>";
?>