<?php 
	require('../../../../util/header.inc');
	session_unregister('_ALUMNO');		//LIBERA EL ALUMNO
	session_unregister('_RAMO');		//LIBERA EL RAMO

	$_FRMMODO	=	"mostrar";
	if(!session_is_registered('_FRMMODO')){
		session_register('_FRMMODO');
	};
	if($_CURSO!=""){
		echo "<script>window.location = 'curso.php3'</script>";
		}else{
			if($_ANO!=""){
				echo "<script>window.location = 'listarCursos.php3'</script>";
				}else{
					if($_INSTIT!="")
						echo "<script>window.location = '../listarAno.php3'</script>";
						else
							echo "<script>window.location = '../../menuInstitucion.php3'</script>";
				}
		}
?>