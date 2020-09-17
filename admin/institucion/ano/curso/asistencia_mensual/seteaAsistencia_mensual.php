<?php 
	require('../../../../../util/header.inc');
	$pag="asistencia_mensual.php";


	if($caso==1){//INGRESAR ASISTENCIA

		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};

		$pag="asistencia.php3?cmbMes=".$mes;
	};

	if($caso==2){//MOSTRAR ASISTENCIA
	/************ PERMISOS DEL PERFIL *************************/
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
			$_ITEM = $item;
			session_register('_ITEM');
		}
		$_FRMMODO	=	"mostrar";
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

	if($caso==5){//MOSTRAR ASISTENCIA

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="asistencia_curso.php?dia=".$dia."&cmbMes=".$cmbMes."&nro_ano=".$nro_ano."";  
	};

	if($caso==6){//MOSTRAR ASISTENCIA

		session_unregister('_FRMMODO');		//LIBERA EL MODO
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="../curso.php3";  
	};

	if($caso==9){//ELIMINAR INSTITUCION
		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="procesoCurso.php3";
	};
	if($caso==10){//Justificar Inasistencia

		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};

		$pag="justifica_inasistencia.php?cmbMes=".$mes;
	};
	
	if($caso==11){//Justificar Inasistencia

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};	
		$pag="justifica_inasistencia.php?cmbMes=".$mes;
	};	
	
	if($caso==12){//INGRESAR ASISTENCIA  DE APODERADOS

		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};

		$pag="asistencia_apo.php?cmbMes=".$mes;
	};
	
	if($caso==13){//MOSTRAR ASISTENCIA

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
			$_ITEM = $item;
			session_register('_ITEM');
		}
		$pag="asistencia_apo.php";
	};
	
	if($caso==14){//INGRESAR ASISTENCIA

		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};

		$pag="asistencia_new.php?cmbMes=".$mes;
	}; 
	if($caso==15){//INGRESAR ASISTENCIA

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};

		$pag="asistencia_new.php?cmbMes=".$mes;
	};
	
	
	echo "<script>window.location = '".$pag."' </script>";
?>