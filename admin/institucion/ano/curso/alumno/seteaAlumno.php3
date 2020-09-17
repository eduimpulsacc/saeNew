<?php 
	require('../../../../../util/header.inc');
	$pag="alumno.php3";
	if($caso==1){//MOSTRAR ALUMNO
		$_ALUMNO	=	$alumno;
		if(!session_is_registered('_ALUMNO')){
			session_register('_ALUMNO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		
	    $_APODERADO	=	"";
		if(!session_is_registered('_APODERADO')){
			session_register('_APODERADO');
		};

		if ($sw == 1){
		   // lo mandamos a una pagina de confirmacion para borrar al alumno retirado
		   
		   $pag="retiro_alumno.php";
		}
		
		if ($pesta == 3){
		   $pag = "alumno.php3?pesta=3";
		}
		if ($pesta == 5){
		   $pag = "alumno.php3?pesta=5";
		} 
		if ($pesta == 2){
		   $pag = "alumno.php3?pesta=2";
		}  
		if ($pesta == 4){
		   $pag = "alumno.php3?pesta=4";
		}
		
		if ($cmb_curso > 0 ){
		   $_CURSO = $cmb_curso;
		   session_register('_CURSO');
		}       
		
		
	};
	if($caso==2){//INGRESAR ALUMNO
	
		if(session_is_registered('_ALUMNO')){
			session_unregister('_ALUMNO');
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
		
		if ($pesta == 3){
		   $pag="alumno.php3?pesta=3";
		}
		if ($pesta == 5){
		   		
		   $pag="alumno.php3?pesta=5";
		}   
	};

	if($caso==4){//MOSTRAR ALUMNO VOLVIENDO DE ANOTACION O APODERADO
	
		session_unregister('_ANOTACION');		//LIBERA LA ANOTACION
		session_unregister('_APODERADO');		//LIBERA EL APODERADO

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==5){//MOSTRAR ALUMNO
	
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};

	if($caso==6){//MODIFICAR NRO_LISTA
	
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="listarAlumnos.php3";
	};

	if($caso==7){//MOSTRAR LISTA DE ALUMNOS
	//-------------------------------------------------------------------------------------------------------------------------------------------------
	$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="listarAlumnos.php3";
	};
	
	if($caso==8){//MOSTRAR LISTA DE ALUMNOS
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
		$pag="listarAlumnos.php3?om=1";
	};


	if($_url==1){//IR A EVALUACION
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	$_ALUMNO	=	$alumno;
	$pag="eva/evaluando.php?caso=2";
	};

    pg_close($conn);
	echo "<script>window.location = '".$pag."' </script>";
?>