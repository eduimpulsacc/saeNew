<?php require('../../../util/header.inc');?>
<?php
 	$frmModo	= $_FRMMODO;
	$agrupacion	= $_AGRUPACION;

if ($frmModo=="ingresar") {
	$qry="SELECT MAX(ID_NOTA) AS CANT FROM NOTA_AGENDA";
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
		$qry="INSERT INTO NOTA_AGENDA (ID_NOTA, CONTENIDO_NOTA, FECHA, HORA, AGRUPACION, RDB,BOOL_AE,ESTADO) VALUES (".$newID.",'".trim($txtCONTENIDO)."','".$txtFECHA."','".$txtHORA."',".$agrupacion.",".$rdb.",".$cmbTIPO.",".$cmbESTADO.")";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)');
		}else{
		    pg_close($conn);
			echo "<script>window.location = 'listarAgenda.php3'</script>";
		}
	}
}
if ($frmModo=="modificar"){
	$qry="UPDATE nota_agenda SET contenido_nota = '".trim($txtCONTENIDO)."', fecha = '".$txtFECHA."', hora = '".$txtHORA."', bool_ae=".$cmbTIPO." , estado=".$cmbESTADO." WHERE (((id_nota)=".$_NOTA_AGENDA."))";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD. (3)');
	}else{
	    pg_close($conn);
		echo "<script>window.location = 'seteaAgenda.php3?notaAgenda=".$_NOTA_AGENDA."&caso=1'</script>";
	}
}
if ($frmModo=="eliminar") {
	$qry="DELETE FROM NOTA_AGENDA WHERE ID_NOTA=".$_NOTA_AGENDA;
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al eliminar.'.$qry);
	}else{
	    pg_close($conn);
		echo "<script>window.location = 'listarAgenda.php3'</script>";
	}

}

?>