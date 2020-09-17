<?php require('../../../../util/header.inc');?>
<?php

if (trim($modo)=="ingresar") {
    if (trim($id_tipo=="")) $id=0;

	$qry="DELETE from pagos where id_tipo=".$id;
	$result =@pg_Exec($conn,$qry);
	if (!$result)
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');

	$qry="INSERT INTO pagos VALUES (nextval('pagos_id_tipo_seq'),".$rdb.",'".$descripcion."',".$monto.",".$ano.")";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$qry);
		}else{
			echo "<script>window.location = 'listarPagos.php'</script>";
		}
};
if (trim($modo)=="modificar") {
	$qry="UPDATE pagos SET monto=".$monto." , descripcion='".$descripcion."' where id_tipo=".$id;
	$result =@pg_Exec($conn,$qry);
	if (!$result)
		error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
	else
			echo "<script>window.location = 'listarPagos.php'</script>";
};
if (trim($modo)=="eliminar") {
    
	$qry="DELETE from pagos where id_tipo=".$id;
	$result =@pg_Exec($conn,$qry);
	if (!$result)
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	else
		echo "<script>window.location = 'listarPagos.php'</script>";
};

?>