<?php 
	require('../../../util/header.inc');
	$pag="agregar_tipo_ense.php3";
	
	if($caso==1){//MOSTRAR enseñanza
         $_PLAN =$plan;
		if(!session_is_registered('_PLAN')){
			session_register('_PLAN');
		};
		 $_ENSENANZA =$ensenanza;
		if(!session_is_registered('_ENSENANZA')){
			session_register('_ENSENANZA');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR enseñanza
		 $_PLAN = $plan;
          $_INSTIT = $institucion1;
		if(session_is_registered('_ENSENANZA')){
			session_unregister('_ENSENANZA');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR ensenanza
	    $_ENSENANZA = $ensenanza;
		$_PLAN =$plan;
		if(!session_is_registered('_PLAN')){
			session_register('_PLAN');
		};
		if(!session_is_registered('_ENSENANZA')){
			session_register('_ENSENANZA');
		};
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
		$pag="../ensenanza/procesoEnsenanza.php3";
	};
	echo "<script>window.location = '".$pag."' </script>";
?>