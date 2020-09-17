<?php 
	require('../../../../../util/header.inc');
	session_unregister('_ANOTACION');		//LIBERA LA ANOTACION
	session_unregister('_APODERADO');		//LIBERA EL APODERADO
	$_FRMMODO	=	"mostrar";
	if(!session_is_registered('_FRMMODO')){
		session_register('_FRMMODO');
	};
	if($_ALUMNO!=""){
		echo "<script>window.location = 'alumno.php3'</script>";
		}else{
			if($_CURSO!=""){
				echo "<script>window.location = 'listarAlumnos.php3'</script>";
				}else{
					if($_ANO!=""){
						echo "<script>window.location = '../listarCursos.php3'</script>";
						}else{
							if($_INSTIT!="")
								echo "<script>window.location = '../../listarAno.php3'</script>";
								else
									echo "<script>window.location = '../../../menuInstitucion.php3'</script>";
						}
				}
		}