<?php 
	require('../../../../util/header.inc');
	$pag="listarAlumnos.php3";

	if($caso==1){//MOSTRAR CURSO
		$_PLANTILLA	=	$plantilla;
		if(!session_is_registered('_PLANTILLA')){
			session_register('_PLANTILLA');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR CURSO
		if(session_is_registered('_PLANTILLA')){
			session_unregister('_CURSO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR CURSO
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==4){//MOSTRAR CURSO VOLVIENDO DE ALUMNO O RAMO
		session_unregister('_ALUMNO');		//LIBERA EL ALUMNO
		session_unregister('_RAMO');		//LIBERA EL RAMO

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
		$pag="procesoCurso.php3";
	};

	if($from!=1){
	echo "<script>window.location = '".$pag."' </script>";
	}else{
	echo "<script>parent.location.href = '../../../../fichas/docente/index2.html' </script>";	
	}
?>