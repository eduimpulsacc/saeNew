<?php 
	//require('../../../../../util/header.inc');
	
		/****************VARIABLES HOJA DE VIDA*************/	
		$c_curso = $_REQUEST['c_curso'];
		$c_ano = $_REQUEST['c_ano'];
		$tipo_hoja = $_REQUEST['tipo_hoja'];
		$alumno = $_REQUEST['alumno'];
		/******************************/
		$activo = $_REQUEST['activo'];
		$mod = $_REQUEST['mod'];
		
	
	if($caso==1){//INGRESAR ANOTACION
	
		if(session_is_registered('_ANOTACION1')){
			session_unregister('_ANOTACION1');
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
		
		$_CURSO =	$c_curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		};
		
		$_ANO =	$c_ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
		};
		
		
		if ($pag==""){
			echo "<script>window.location = 'anotacion.php?tipo_hoja=".$tipo_hoja."&ano=".$c_ano.
			"&curso=".$c_curso."&activo=".$activo."&c_alumno=".$alumno."'</script>";
		}else {
			echo "<script>window.location = '".$pag."'</script>";
		}
		
	};
	
	if($caso==2){//MODIFICAR ANOTACION
	    
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$_ANOTACION1	=	$anotacion;
		if(!session_is_registered('_ANOTACION1')){
			session_register('_ANOTACION1');
		};
	
		$_ALUMNO	=	$alumno;
		if(!session_is_registered('_ALUMNO')){
			session_register('_ALUMNO');
		};

		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	
		
		if ($old==1){
		    echo "<script>window.location = 'anotacion.php?opcion=1'</script>";		
		}else{		
		    echo "<script>window.location = 'anotacion.php?opcion=2'</script>";
          /*echo "<script>window.location = '../../ano/curso/alumno/anotacion/mostrarAnotacion.php3'
		  </script>";*/
	    }
		
		/*echo "<script>window.location = 'anotacion_old.php'</script>";*/
	};
	
	if($caso==3){//ELIMINAR ANOTACION
	
		$_DESDE =	$desde;
		if(!session_is_registered('_DESDE')){
			session_register('_DESDE');
		};
		
		$_ANOTACION1	=	$anotacion;
		if(!session_is_registered('_ANOTACION1')){
			session_register('_ANOTACION1');
		};
		
		$_ALUMNO	=	$alumno;
		if(!session_is_registered('_ALUMNO')){
			session_register('_ALUMNO');
		};

		$_FRMMODO	=	"eliminar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};	
		
		echo "<script>window.location = 'anotacion.php'</script>";
	};
	
	
		if($caso==4){//MOSTRAR ANOTACION
		$_ALUMNO	=	$alumno;
		if(!session_is_registered('_ALUMNO')){
			session_register('_ALUMNO');
		};

		$_DESDE =	$desde;
		if(!session_is_registered('_DESDE')){
			session_register('_DESDE');
		};

		$_ANOTACION1	=	$anotacion;
		if(!session_is_registered('_ANOTACION1')){
			session_register('_ANOTACION1');
		};
		
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};	
		
		if ($old==1){
		    echo "<script>window.location = 'anotacion.php?opcion=1'</script>";		
		}else{		
		    echo "<script>window.location = 'mostrarAnotacion.php?opcion=2&actualiza=0'</script>";
			

	    }
	};
?>