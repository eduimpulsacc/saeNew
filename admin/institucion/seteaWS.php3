<?php 
	require('../../util/header.inc');
	$pag="webScout.php3";

	if($caso==1){//MOSTRAR 
		$_FRMMODO	=	"mostrar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	if($caso==3){//MODIFICAR 
		$_FRMMODO	=	"modificar";
		if(!session_is_registered('_FRMMODO')){
			session_register('_FRMMODO');
		};
	};
	echo "<script>window.location = '".$pag."'</script>";
	exit;
?>