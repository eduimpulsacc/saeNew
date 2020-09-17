<?php 
	session_start();
	session_unset();
	session_destroy();
    /*echo "<script>window.close()</script>";  */
   echo "<script>window.location = '../../web/index.html'</script>";
	exit;
?>
