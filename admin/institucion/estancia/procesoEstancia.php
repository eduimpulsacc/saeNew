<?php require('../../../util/header.inc');?>
<?php
 	$frmModo		=$_FRMMODO;
	if ($frmModo=="ingresar"){
		$qry="SELECT MAX(ID_ESTANCIA) AS CANT FROM ESTANCIA";
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
			$qry = "INSERT INTO ESTANCIA (ID_ESTANCIA, ID_INSTITUCION, ID_SEDE, ID_TIPOESTANCIA, NOMBRE, CAPACIDAD, DESCRIPCION) VALUES (" . $newID . "," . intval($rdb) . "," . intval($cmbSECTOR) . "," . intval($cmbTIPOESTANCIA) . ",'" . trim($txtNOMBRE) . "'," . intval($txtCAPACIDAD) . ",'" . trim($txtDESCRIPCION) . "')";

			$newANO=$newID;
			$result =@pg_Exec($conn,$qry);
			if (!$result)
				error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
			else{
				echo "<script>window.location = 'listarEstancia.php'</script>";
			};
		};
	};

	if ($frmModo=="modificar"){
		$qry = "UPDATE estancia SET id_sede = " . intval($cmbSECTOR) . ", id_tipoestancia = " . intval($cmbTIPOESTANCIA) . ", nombre = '" . trim($txtNOMBRE) . "', capacidad = " . intval($txtCAPACIDAD) . ", descripcion = '" . trim($txtDESCRIPCION) . "' WHERE (((id_estancia)=" . $_ESTANCIA . ") AND ((id_institucion)=" . $_INSTIT . "))";
		$result = @pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)' . $qry);
		}else{
			echo "<script>window.location = 'seteaEstancia.php?caso=1&estancia=".$_ESTANCIA."'</script>";
		};
	};

	if ($frmModo=="eliminar") {
		$qry = "DELETE FROM ESTANCIA WHERE ID_ESTANCIA=".$_ESTANCIA." AND ID_INSTITUCION=" . $_INSTIT . "";
		$result = @pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al eliminar.' . $qry);
		}else{
			echo "<script>window.location = 'listarEstancia.php'</script>";
		};
	};
?>