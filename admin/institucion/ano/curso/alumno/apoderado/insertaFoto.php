<?php require('../../../../../../util/header.inc');?>
<?
	chmod($upload_file,"700");
	$query = "update APODERADO set foto=lo_import('$upload_file') where rut_apo='$rut'";
	$result = pg_exec($conn, $query);

	if (!$result){
		printf ("ERROR"); 
		}else{ 
		   printf("<title>IMAGEN INSERTADA...</title>LA IMAGEN HA SIDO INSERTADA CON EXITO </p><input type=button value=ACEPTAR onClick=window.close()>"); 
	}
	pg_close($conn);
?>