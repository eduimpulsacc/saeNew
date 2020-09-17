<?php
	require('../../../util/header.inc');
	$institucion=$_INSTIT;
	$qry="UPDATE INSTITUCION SET ACTIVIDADES_ESPECIALES ='".trim($txtCONT)."' WHERE RDB=".$institucion;
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD.(1)');
	}else{
		echo "<script>window.location = 'seteaActividadesEspeciales.php3?caso=1'</script>";
	}
?> 