<?php require('../../../util/header.inc');?>
<?php
if ($id=="") {
	 $id=0;
}
$qry_del="DELETE FROM LIBRO WHERE id=".$id;
$result =@pg_Exec($conn,$qry_del);
if (!$result)
			error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry_del);
	else
		echo "<script>window.location = 'listarLibros.php'</script>";
?>