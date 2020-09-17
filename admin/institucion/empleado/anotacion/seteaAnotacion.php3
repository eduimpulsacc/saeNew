<?php 
	require('../../../../util/header.inc');
	
		/****************VARIABLES HOJA DE VIDA*************/	
		$c_curso = $_GET['c_curso'];
		$c_ano = $_GET['c_ano'];
		$tipo_hoja = $_GET['tipo_hoja'];
		/******************************/
	
	
	if($caso==1){//MOSTRAR ANOTACION
		$_ALUMNO	=	$alumno;
		if(!session_is_registered('_ALUMNO')){
			session_register('_ALUMNO');
		};

		$_DESDE =	$desde;
		if(!session_is_registered('_DESDE')){
			session_register('_DESDE');
		};

		$_ANOTACION	=	$anotacion;
		if(!session_is_registered('_ANOTACION')){
			session_register('_ANOTACION');
		};
		
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		
		if ($old==1){
		    echo "<script>window.location = 'mostrarAnotacion_old.php'</script>";		
		}else{		
		    echo "<script>window.location = 'mostrarAnotacion.php3?tipo_hoja=".$tipo_hoja."&c_ano=".$c_ano."&c_curso=".$c_curso."'</script>";
/*		    echo "<script>window.location = '../../ano/curso/alumno/anotacion/mostrarAnotacion.php3'</script>";*/
	    }
	};
	if($caso==2){//INGRESAR ANOTACION
		if(session_is_registered('_ANOTACION')){
			session_unregister('_ANOTACION');
		};
		
		$_DESDE =	$desde;
		if(!session_is_registered('_DESDE')){
			session_register('_DESDE');
		};
		
		$_ALUMNO	=	$alumno;
		if(!session_is_registered('_ALUMNO')){
			session_register('_ALUMNO');
		};

		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		if ($pag==""){
			echo "<script>window.location = 'anotacion.php3?tipo_hoja=".$tipo_hoja."&c_ano=".$c_ano."&c_curso=".$c_curso."'</script>";
		}else {
			echo "<script>window.location = '".$pag."'</script>";
		}
	};
	if($caso==3){//MODIFICAR ANOTACION
	    $_ANOTACION	=	$anotacion;
		if(!session_is_registered('_ANOTACION')){
			session_register('_ANOTACION');
		};
	
		$_ALUMNO	=	$alumno;
		if(!session_is_registered('_ALUMNO')){
			session_register('_ALUMNO');
		};

		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
				
		echo "<script>window.location = 'anotacion_old.php'</script>";
	};
	
	if($caso==4){//ELIMINAR ANOTACION
	
		$_DESDE =	$desde;
		if(!session_is_registered('_DESDE')){
			session_register('_DESDE');
		};
		
		$_ANOTACION	=	$anotacion;
		if(!session_is_registered('_ANOTACION')){
			session_register('_ANOTACION');
		};
		
		$_ALUMNO	=	$alumno;
		if(!session_is_registered('_ALUMNO')){
			session_register('_ALUMNO');
		};

		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		echo "<script>window.location = 'anotacion.php3'</script>";
	};
?>