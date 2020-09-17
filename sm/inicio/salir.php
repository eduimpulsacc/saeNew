<?php 
	session_start();
	session_unset();
	session_destroy();
    echo "<HTML><HEAD><script>window.location = '../index.php'</script></HEAD><BODY></BODY></HTML>";
	exit;
?>