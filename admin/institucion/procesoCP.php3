<?php require('../../util/header.inc');?>
<?php
	$qry="UPDATE INSTITUCION SET EMAILCP='".$txtEMAIL."', REPCP='".$txtREP."' where RDB=".$_INSTIT;
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD 2.');
	}else{
		echo "<script>window.location = 'seteaCP.php3?caso=1'</script>";
	}
?>