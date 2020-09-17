<?php
	require('../util/header.inc');

		$_INSTIT=$institucion;
		session_register('_INSTIT');
        
		
		echo "<HTML><HEAD><script>window.location = '../index.php'</script></HEAD><BODY></BODY></HTML>";
		
		/*echo "<HTML><HEAD><script>window.location = '../../admin/institucion/ano/listarAno.php3'</script></HEAD><BODY></BODY></HTML>";*/
		exit;
?>