<?php
	require('../../../util/header.inc');
	$institucion=$_INSTIT;
	$qry="UPDATE INSTITUCION SET PROCESO_ADMISION ='".trim($txtCONT)."' WHERE RDB=".$institucion;
	$result =pg_Exec($conn,$qry);
	if (!$result) {
	
     		echo "<script>window.location = 'seteaProcesoAdmision.php3?caso=1</script>";
	}else{
		echo "<script>window.location = 'seteaProcesoAdmision.php3?caso=1'</script>";
	}
?> 