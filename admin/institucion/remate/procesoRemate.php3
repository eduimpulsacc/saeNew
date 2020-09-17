<?php require('../../../util/header.inc');?>
<?php
 	$frmModo		=$_FRMMODO;
	if ($frmModo=="ingresar") {
		$qry="SELECT MAX(ID_REMATE) AS CANT FROM REMATE";
		$result =@pg_Exec($conn,$qry);
		$fila = @pg_fetch_array($result,0);	
		$newID =  $fila['cant'];
		$newID++;

		$qry="INSERT INTO REMATE (ID_REMATE, FECHA_I, FECHA_T,TITULAR,DETALLE,RDB) VALUES (".$newID.",'".trim($txtFECHAINI)."','".trim($txtFECHATER)."','".trim($txtTITULAR)."','".trim($txtDETALLE)."',".trim($_INSTIT).")";
		$result =@pg_Exec($conn,$qry);

		echo "<script>window.location = 'listarRemates.php3'</script>";
	}

	if ($frmModo=="modificar"){
		$qry="UPDATE REMATE SET FECHA_I='".trim($txtFECHAINI)."', FECHA_T='".trim($txtFECHATER)."', TITULAR='".trim($txtTITULAR)."', DETALLE='".trim($txtDETALLE)."' WHERE ID_REMATE=".$_REMATE;
		$result =@pg_Exec($conn,$qry);

		echo "<script>window.location = 'seteaRemate.php3?caso=1'</script>";
	}

	if ($frmModo=="eliminar"){
		$qry="DELETE FROM REMATE WHERE ID_REMATE=".$_REMATE;
		$result =@pg_Exec($conn,$qry);

		echo "<script>window.location = 'listarRemates.php3'</script>";
	}
?>
