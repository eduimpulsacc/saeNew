<?php
	require('../../../util/header.inc');
	$institucion=$_INSTIT;
	$qry="UPDATE INSTITUCION SET NUESTRA_INSTITUCION ='".$txtCONT."' WHERE RDB=".$institucion;
	$result =pg_Exec($conn,$qry);
	if (!$result) {
               echo "<script>window.location = 'seteaNuestraInstitucion.php3?caso=1'</script>";
		
	}else{
		echo"<script>window.location = 'seteaNuestraInstitucion.php3?caso=1'</script>";
	}
?> 
 