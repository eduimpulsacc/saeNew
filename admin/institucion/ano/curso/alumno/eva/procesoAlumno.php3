<?php require('../../../../../util/header.inc');?>
<?php
	$frmModo		=$_FRMMODO;

if ($frmModo=="modificar"){
		$qry="UPDATE alumno SET nombre_alu = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$txtREG.", ciudad = ".$txtCIU.", comuna = ".$txtCOM.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", email = '".trim($txtEMAIL)."', fecha_nac = '".fEs2En($txtNAC)."' WHERE (((rut_alumno)=".$_ALUMNO."));";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
		}else{
		    pg_close($conn);
			echo "<script>window.location = 'seteaAlumno.php3?caso=1&alumno=".$_ALUMNO."'</script>";
		}
}

if ($frmModo=="eliminar") {//SE DEBE ELIMINAR DE LA MATRICULA PARA ESE AÑO
	$qry="DELETE FROM MATRICULA RUT_ALUMNO= AND RDB= AND ID_ANO= AND ID_CURSO=";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al eliminar.'.$qry);
	}else{
	    pg_close($conn);
		echo "<script>window.location = 'listarApoderado.php3'</script>";
	}
}
?>