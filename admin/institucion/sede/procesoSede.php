<?php require('../../../util/header.inc');?>
<?php print_r($_POST);
 	$frmModo		=$_FRMMODO;
	if ($frmModo=="ingresar"){
		$qry="SELECT MAX(ID_SEDE) AS CANT FROM SEDE";
		$result = @pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			$fila = @pg_fetch_array($result,0);	
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			};
			$newID =  $fila['cant'];
			$newID++;
			$qry = "INSERT INTO SEDE (ID_SEDE, ID_INSTITUCION, NOMBRE, CALLE, NRO, DEPTO, BLOCK, VILLA, REGION, CIUDAD, COMUNA) VALUES (" . $newID . "," . intval($rdb) . ",'" . trim($txtNOMBRE) . "','" . trim($txtCALLE) . "'," . intval($txtNUMERO) . ",'" . trim($txtDEPARTAMENTO) . "','" . trim($txtBLOCK) . "','" . trim($txtVILLA) . "'," . $select_region . "," . $select_provincias . "," . $select_comuna . ")";

			//$newANO=$newID;
			$result =@pg_Exec($conn,$qry);
			if (!$result)
				error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
			else{
				echo "<script>window.location = 'listarSede.php'</script>";
			};
		};
	};

	if ($frmModo=="modificar"){
		$qry = "UPDATE sede SET nombre = '" . trim($txtNOMBRE) . "', calle = '" . trim($txtCALLE) . "', nro = " . intval($txtNUMERO) . ", depto = '" . trim($txtDEPARTAMENTO) . "', block = '" . trim($txtBLOCK) . "', villa = '" . trim($txtVILLA) . "', region = " . intval($select_region) . ", ciudad = " . intval($select_provincias) . ", comuna = " . intval($select_comuna) . " WHERE (((id_sede)=" . $_SEDE . ") AND ((id_institucion)=" . $_INSTIT . "))";
		$result = @pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (4)' . $qry);
		}else{
			echo "<script>window.location = 'seteaSede.php?caso=1&sede=".$_SEDE."'</script>";
		};
	};

	if ($frmModo=="eliminar") {
		$qry = "DELETE FROM SEDE WHERE ID_SEDE=".$_SEDE." AND ID_INSTITUCION=" . $_INSTIT . "";
		$result = @pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al eliminar.' . $qry);
		}else{
			echo "<script>window.location = 'listarSede.php'</script>";
		};
	};
?>