<?php 
	require('../../../../../util/header.inc');

	//$_INSTIT = $institucion;
	//$_ANO	 = $ano;
	//$_CURSO  = $curso;
	$pag = "promocion.php";

	if($caso==1){//MOSTRAR PROMOCION
		$_INSTIT = $institucion;
		if(!session_is_registered('_INSTIT')){
			session_register('_INSTIT');
		};
		$_ANO	 = $ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
		};
		$_CURSO	=	$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		};
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==2){//INGRESAR PROMOCION
		$_INSTIT = $institucion;
		if(!session_is_registered('_INSTIT')){
			session_register('_INSTIT');
		};
		$_ANO	 = $ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
		};
		$_CURSO  = $curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		};
		$_FRMMODO	=	"ingresar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		}; 
		//echo ("inti:".$_INSTIT." ANO:".$_ANO. " curso:".$_CURSO);
		//exit();
	};

	echo "<script>window.location = '".$pag."' </script>";
?>