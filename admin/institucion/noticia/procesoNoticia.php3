<?php require('../../../util/header.inc');?>
<?php
 	$frmModo	= $_FRMMODO;
	$agrupacion	= $_AGRUPACION;

if ($frmModo=="ingresar") {
	$qry="SELECT MAX(ID_NOTICIA) AS CANT FROM NOTICIA";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}else{
		$fila = @pg_fetch_array($result,0);	
		if (!$fila){
			error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
			exit();
		}
		$newID =  $fila['cant'];
		$newID++;
		$qry="INSERT INTO NOTICIA (ID_NOTICIA,TITULAR,RESUMEN, CONTENIDO,FECHA_PUB,RDB,ESTADO,AGRUPACION) VALUES (".$newID.",'".$txtTITULAR."','".$txtRESUMEN."','".$txtCONTENIDO."',to_date('" . $txtFECHA . "','DD MM YYYY'),".$rdb.",".$cmbESTADO.",".$agrupacion.")";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)');
		}else{
			echo "<script>window.location = 'listarNoticia.php3'</script>";
		}
	}
}
if ($frmModo=="modificar"){
		$qry="UPDATE noticia SET titular = '".$txtTITULAR."', resumen = '".$txtRESUMEN."', contenido = '".$txtCONTENIDO."', ESTADO = '".$cmbESTADO."', fecha_pub = to_date('" . $txtFECHA . "','DD MM YYYY') WHERE (((id_noticia)=".$_NOTICIA."))";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
		}else{
			echo "<script>window.location = 'seteaNoticia.php3?caso=1&noticia=".$_NOTICIA."'</script>";
		}

}
if ($frmModo=="eliminar"){
	$qry="DELETE FROM NOTICIA WHERE ID_NOTICIA=".$_NOTICIA;
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al eliminar.'.$qry);
	}else{
		echo "<script>window.location = 'listarNoticia.php3'</script>";
	}
}
?>