<?php 
	require('../../../util/header.inc');
	session_unregister('_ANOTACION');			//LIBERA EL CURSO
	
	$_FRMMODO	=	"mostrar";
	if(!session_is_registered('_FRMMODO')){
		session_register('_FRMMODO');
	};

	if($_EMPLEADO!=""){
		echo "<script>window.location = 'empleado.php3'</script>";
		}else{
			if($_INSTIT!="")
				echo "<script>window.location = 'listarEmpleado.php3'</script>";
				else
					echo "<script>window.location = '../menuInstitucion.php3'</script>";
	}
?>