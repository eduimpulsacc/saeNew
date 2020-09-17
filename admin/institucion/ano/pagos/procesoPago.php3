<?php require('../../../../util/header.inc');?>
<?php

if (trim($modo)=="ingresar") {
    if (trim($id_tipo=="")) $id=0;

	$qry="DELETE from pagos where id_tipo=".$id;
	$result =@pg_Exec($conn,$qry);
	if (!$result)
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');

	$qry="INSERT INTO pagos VALUES (nextval('pagos_id_tipo_seq'),$rdb,'$descripcion',$monto,$ano,$cdp)";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$qry);
		}else{
			echo "<script>window.location = 'listarPagos.php'</script>";
		}
};
if (trim($modo)=="modificar") {
	$qry="UPDATE pagos SET monto= $monto, descripcion='$descripcion' , condicion_pago=$cdp where id_tipo=$id ";
	$result =@pg_Exec($conn,$qry);
	if (!$result)
		error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
	else
			echo "<script>window.location = 'listarPagos.php'</script>";
};
if (trim($modo)=="eliminar") {
    $query_verif="select * from fechaxalumno where id_tipo=".$id;
	$result = pg_exec($conn, $query_verif);
	if (pg_numrows($result)==0) {
		$qry="DELETE from pagos where id_tipo=".$id;
		$result =@pg_Exec($conn,$qry);
		if (!$result)
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		else
			echo "<script>window.location = 'listarPagos.php'</script>";
	}else {
    echo "<b>No se puede eliminar un tipo de pago que contenga pagos validos </b>";
    echo "<a href=# onclick=window.location='pagos.php3'>VOLVER</a>";

}
};

?>