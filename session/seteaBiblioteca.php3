<?php
	require('../util/header.inc');

		$_INSTIT=$institucion;
		session_register('_INSTIT');

		echo "<HTML><HEAD><script>window.location = '../admin/institucion/biblioteca/listarLibros.php'</script></HEAD><BODY></BODY></HTML>";
		exit;
?>