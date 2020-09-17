<?php 
	require('../../util/header.inc');
	session_unregister('_ANO');				//LIBERA EL AÑO
	session_unregister('_EMPLEADO');		//LIBERA EL EMPLEADO
	session_unregister('_NOTA_AGENDA');		//LIBERA LA NOTA DE LA AGENDA
	session_unregister('_NOTICIA');			//LIBERA LA NOTICIA

	$_FRMMODO	=	"mostrar";
	if(!session_is_registered('_FRMMODO')){
		session_register('_FRMMODO');
	};

	if($_INSTIT!="")
		echo "<script>window.location = 'institucion.php3'</script>";
		else
			echo "<script>window.location = 'listarInstituciones.php'</script>";
?>