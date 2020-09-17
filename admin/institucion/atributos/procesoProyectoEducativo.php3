<?php
	require('../../../util/header.inc');
	$institucion=$_INSTIT;
	$qry="UPDATE INSTITUCION SET PROYECTO_EDUCATIVO ='".trim($txtCONT)."' WHERE RDB=".$institucion;
	$result =pg_Exec($conn,$qry);
	if (!$result) {
	    exit();
		error('<b> ERROR :</b>Error al acceder a la BD.(1)');
	}else{
		echo "<script>window.location = 'seteaProyectoEducativo.php3?caso=1'</script>";
	}
?> 