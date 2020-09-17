<?php require('../../../../../util/header.inc');
	$institucion	= $_INSTIT;
	$frmModo	 	= $_FRMMODO;
	$empleado		= $_EMPLEADO;
	$comunicacion 	= $_COMUNICACION;
	$apoderado		= $_APODERADO;
	$alumno			= $_ALUMNO;
 		
if($cmbDocente!=""){
	$empleado = $cmbDocente;
}

if($empleado==NULL){
	$empleado = $_NOMBREUSUARIO;
}

if ($frmModo=="ingresar"){
	$qry = "";
	$qry = "INSERT INTO comunicacion (rdb,rut_emp, tipo_comun, fecha, nota, titulo ";
	if($cmbDocente!=""){
		$qry = $qry. ", rut_apo";
	}
	if($institucion==25452 && $cmbDocente==""){
		$qry = $qry.", autorizacion";
	}
	$qry = $qry. ") VALUES (";
	$qry = $qry. "". $institucion .",";
	$qry = $qry. "". $empleado .",";
	$qry = $qry. "". $tipo . ",";
	$qry = $qry. "to_date('" . trim($fecha) . "','DD MM YYYY'),";
	$qry = $qry. "'". $memo . "',";
	$qry = $qry. "'" . $titulo . "'";
	if($cmbDocente!=""){
		$qry = $qry. "," . $apoderado . "";
	}
	if($institucion==25452 && $cmbDocente==""){ // SI ES EL COLEGIO TREBULCO SE INGRESA SIN AUTORIZACION
		$qry = $qry. ",1";
	}
	$qry = $qry. ")";
	$Rs_comun = @pg_exec($conn,$qry);

	$qry_id = "SELECT max(id_comun) as llave FROM comunicacion";
	$Rs_Id = @pg_exec($conn,$qry_id);
	$fila = @pg_fetch_array($Rs_Id,0);
	$Id_Comun = trim($fila['llave']);
	
	for ($i=0;$i<count($_POST['alumno']);$i++) { 
		$qry_alum = "INSERT INTO comun_alumno (id_comun, rut_alum) VALUES (". $Id_Comun . " ,".$_POST['alumno'][$i].")";
		$Rs_Alum = @pg_exec($conn,$qry_alum);
	}
}
if ($frmModo=="modificar"){
	$qry = "";
	$qry = "UPDATE comunicacion SET fecha=to_date('" . trim($fecha) . "','DD MM YYYY'), titulo='". $titulo . "', tipo_comun=" . $tipo .", nota='" . $memo ."' where id_comun=". $comunicacion;
	$Rs_comun = @pg_exec($conn,$qry);
	$qry = "";
	$qry = "DELETE FROM comun_alumno WHERE id_comun=" . $comunicacion;
	$Rs_delete = @pg_exec($conn,$qry);

	for ($i=0;$i<count($_POST['alumno']);$i++) { 
		$qry_alum = "INSERT INTO comun_alumno (id_comun, rut_alum) VALUES (". $comunicacion . " ,".$_POST['alumno'][$i].")";
		$Rs_Alum = @pg_exec($conn,$qry_alum);
	}
}
if ($frmModo=="eliminar"){
	$qry = "";
	$qry = "DELETE FROM comunicacion WHERE id_comun = " . $comunicacion;
	$Rs_Delete = @pg_exec($conn,$qry);
}
echo "<script>window.location = 'ListaComunicacion.php'</script>";
?>