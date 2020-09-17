<?php 
	require('../../../util/header.inc');
	$pag="ano_escolar.php";
//	$pag="main_ano_escolar.php";
	if($caso==1){//MOSTRAR AÑO ESCOLAR
		$_ANO	=	$ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
		};

		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');  
		};
	};
	if($caso==2){//INGRESAR AÑO ESCOLAR
		if(session_is_registered('_ANO')){
			session_unregister('_ANO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR AÑO ESCOLAR
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==4){//MOSTRAR AÑO 
		session_unregister('_CURSO');			//LIBERA EL CURSO
		session_unregister('_MATRICULA');		//LIBERA EL MATRICULA
		session_unregister('_PERIODO');			//LIBERA EL PERIODO
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
		$pag="procesoAno.php";
	};
	if($caso==10){//informe de personaidad
		$_ANO	=	$ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
	  	};
		$pag="curso/informe_educacional/listarAlumnos.php";
	}
	if($caso==11){//informe de personaidad
		$_ANO	=	$ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
	  	};
		$pag="curso/ramo/taller.php3";
	}
	if($from!=1){
	echo $pag;
	/*	echo "<script>alert('entro');window.location = '".$pag."' </script>";*/
	}else{
		switch ($_PERFIL){
			case 19:
				echo "<script>parent.location.href = '../../../fichas/inspector/index2.html' </script>";
				break;
			case 20:
				echo "<script>alert ('hola');parent.location.href = '../../../fichas/orientador/index.php' </script>";
				break;
			case 21:
				echo "<script>parent.location.href = '../../../index.php' </script>";
				break;
			case 22:
				echo "<script>parent.location.href = '../../../fichas/psicopedagogo/index2.html' </script>";
				break;
			case 6:
				echo "<script>parent.location.href = '../../../fichas/enfermeria/index2.html' </script>";
				break;
			case 2:
				echo "<script>parent.location.href = '../../../fichas/utp/index2.html' </script>";
				break;
		}
		
	}
    pg_close($conn);
	pg_close($connection);
    
    ?>