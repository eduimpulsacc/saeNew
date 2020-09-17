<?php 

    require('../../../../../util/header.inc');
	 $pag="apreciacion.php";


	
	if($caso==1){//MOSTRAR CONFIGURACION
		$_CURSO	=	$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		};
		$_RAMO	=	$id_ramo;
		if(!session_is_registered('_RAMO')){
			session_register('_RAMO');
		};
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		
	};
	if($caso==2){//INGRESAR CONFIGURACION
		$_PERIODO = $cmbPERIODO;
		if(!session_is_registered('_PERIODO')){
			session_register('_PERIODO');
		};
	};
	if($caso==3){//MODIFICAR CONFIGURACION
		$_PERIODO = $periodo;
		if(!session_is_registered('_PERIODO')){
			session_register('_PERIODO');
		};
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$_CASO =	$caso;
		if(!session_is_registered('_CASO')){
			session_register('_CASO');
		};
	};
	if($caso==4){//MOSTRAR CONFIGURACION
		$_CURSO	=	$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		};
		$_RAMO	=	$id_ramo;
		if(!session_is_registered('_RAMO')){
			session_register('_RAMO');
		};
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$_PERIODO = $cmbPERIODO;
		if(!session_is_registered('_PERIODO')){
			session_register('_PERIODO');
		};
		$_CASO =	$caso;
		if(!session_is_registered('_CASO')){
			session_register('_CASO');
		};
		
	};
	

	if($caso==9){//ELIMINAR INSTITUCION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$_RAMO	=	$id_ramo;
		if(!session_is_registered('_RAMO')){
			session_register('_RAMO');
		};
		$_PERIODO = $cmbPERIODO;
		if(!session_is_registered('_PERIODO')){
			session_register('_PERIODO');
		};
		$pag="procesoApreciacion.php";
		
	};
	
	  echo "<script>window.location = '".$pag."' </script>";
	
?>