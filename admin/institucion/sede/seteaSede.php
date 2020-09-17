<?php 
	require('../../../util/header.inc');
	$pag = "sede.php";
	if($caso==1){//MOSTRAR SEDE
		$_SEDE	=	$sede;
		if(!session_is_registered('_SEDE')){
			session_register('_SEDE');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR SEDE
		if(session_is_registered('_SEDE')){
			session_unregister('_SEDE');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR SEDE
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==4){//MOSTRAR SEDE
		session_unregister('_CURSO');			//LIBERA EL CURSO
		session_unregister('_MATRICULA');		//LIBERA EL MATRICULA
		session_unregister('_PERIODO');			//LIBERA EL PERIODO
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==9){//ELIMINAR ESTANCIA
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag = "procesoSede.php";
	};
	echo "<script>window.location = '".$pag."' </script>";
?>