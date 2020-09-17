<?php 

    require('../../../../util/header.inc');
	 $pag="ModificaConfigCurso.php";


	
	if($caso==1){//MOSTRAR CONFIGURACION
		$_CURSO	=	$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
		};
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	
	if($caso==2){//MODIFICAR CONFIGURACION
		//$_ANO=$ano;
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	
	
	  echo "<script>window.location = '".$pag."' </script>";
	
?>