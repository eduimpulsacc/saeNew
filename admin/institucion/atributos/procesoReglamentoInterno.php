<?php
	require('../../../util/header.inc');
	$institucion=$_INSTIT;
	$qry="UPDATE INSTITUCION SET REGLAMENTO_INTERNO ='".(trim($txtCONT))."' WHERE RDB=".$institucion;
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		echo ('<b> ERROR :</b>Error al acceder a la BD.(1)');
	}else{
		echo "<script>window.location = 'seteaReglamentoInterno.php?caso=1'</script>";
	}
?> 