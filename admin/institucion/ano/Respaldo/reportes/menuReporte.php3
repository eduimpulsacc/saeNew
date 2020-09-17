<?php 
	require('../../../../util/header.inc');

	$_FRMMODO	=	"mostrar";
	if(!session_is_registered('_FRMMODO')){
		session_register('_FRMMODO');
	};

	if($_ANO!=""){
		echo "<script>window.location = 'listados.php3'</script>";
		}else{
			if($_INSTIT!=""){
				echo "<script>window.location = '../listarAno.php3'</script>";
				}else{
					echo "<script>window.location = '../../menuInstitucion.php3'</script>";
				}
		}
?>