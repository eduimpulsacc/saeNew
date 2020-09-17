<?php require('../util/header.inc');
//print_r($_POST);
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$frmModo		="modificar";
	
	$pag="ficha_apoderado.php3";
	if(!isset($chkSOS)){$chkSOS=0;}
	if(!isset($cmbRELACION)){$cmbRELACION=0;}
	
	if(!isset($Provincia)){$Provincia=0;}
	if(!isset($Comuna)){$Comuna=0;}
	
	
	
	
	
$qry="Update apoderado set nombre_apo ='".trim($nombres)."', ape_pat='".trim($apellido_pat)."',ape_mat='".trim($apellido_mat)."',
	nivel_edu='".trim($nivel_edu)."',telefono='".trim($telefono)."',celular='".trim($celular)."',calle='".trim($direccion)."',
	nro='".trim($numero)."',region='".trim($Region)."',ciudad='".trim($Provincia)."',Comuna='".trim($Comuna)."',profesion='".trim(    $profesion)."',cargo='".trim($cargo)."',lugar_trabajo='".trim($lugar_trabajo)."',email='".trim($email)."',relacion='".trim(    $cmbRELACION)."'
	WHERE (((rut_apo)='".trim($rut_apo)."'))";
	
	$result =pg_Exec($conn,$qry)or die("Fallo Update ".$qry );
	if (!$result) {
	echo "$qry <br>";
	error('<b> ERROR :</b>Error al acceder a la BD. (323)');
	}else{
	$qry="UPDATE TIENE2 SET SOSTENEDOR=".$chkSOS.", RESPONSABLE=".$cmbRELACION." WHERE RUT_ALUMNO='".trim($_ALUMNO)."' AND RUT_APO='".trim($rut_apo)."'";
	$result =@pg_Exec($conn,$qry)or die("Fallo 2".$qry);
	
	echo "<script>window.location = 'fichaApoderados.php3'</script>";
	
}
	
	?>


