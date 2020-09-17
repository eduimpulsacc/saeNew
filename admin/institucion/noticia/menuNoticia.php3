<?php 
	require('../../../util/header.inc');

	$_FRMMODO	=	"mostrar";
	if(!session_is_registered('_FRMMODO')){
		session_register('_FRMMODO');
	};
	if($_INSTIT!=""){
		echo "<script>window.location = 'listarNoticia.php3?agrupacion=1'</script>";
		}else{
			echo "<script>window.location = '../menuInstitucion.php3'</script>";
	}
?>