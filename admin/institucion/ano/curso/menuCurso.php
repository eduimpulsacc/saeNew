<?php 
	require('../../../../util/header.inc');
	session_unregister('_ALUMNO');		//LIBERA EL ALUMNO
	session_unregister('_RAMO');		//LIBERA EL RAMO

	$_FRMMODO	=	"mostrar";
	if(!session_is_registered('_FRMMODO')){
		session_register('_FRMMODO');
	};
	if($_CURSO!=""){
		echo "<script>window.location = 'curso.php'</script>";
		}else{
			if($_ANO!=""){
				echo "<script>window.location = 'listarCursos.php'</script>";
				}else{
					if($_INSTIT!="")
						echo "<script>window.location = '../listarAno.php'</script>";
						else
							echo "<script>window.location = '../../menuInstitucion.php'</script>";
				}
		}
?>