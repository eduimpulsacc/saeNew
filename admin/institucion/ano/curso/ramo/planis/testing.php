<?php
	require('../../../../../../util/header.inc');

	$id_ramo=115054;
	$rut_emp=6482062;
/*
	$sql_rut = "	SELECT rut_emp
					FROM dicta
					WHERE id_ramo = ".$id_ramo;
	$result_rut	= @pg_Exec($conn, $sql_rut);
	if ($fila_rut = @pg_fetch_array($result_rut, 0)){
		$rut_emp_ramo =	$fila_rut['0'];
	}

	$sql_profe = "	SELECT nombre_emp,
							ape_pat,
							ape_mat,
							id_usuario
					FROM empleado
					WHERE rut_emp = ".$rut_emp_ramo;	
	$result_profe = @pg_Exec($conn, $sql_profe);
	if ($fila_profe = @pg_fetch_array($result_profe, 0, PGSQL_ASSOC)){
		$id_usuario = $fila_profe['id_usuario'];
	}
	
	echo "<br> Rut real del profe: ".$rut_emp;			
	echo "<br> Id usuario tomado de la variable \$_USUARIO: ".$_USUARIO;
	echo "<br> Rut profe tomado de la tabla dicta (usando el id del ramo): ".$rut_emp_ramo;
	echo "<br> id usuario del profe tomado de la tabla empleado: ".$id_usuario;
*/

	$sql_rut_ramo = "SELECT rut_emp FROM dicta WHERE id_ramo = '{$id_ramo}' LIMIT 1 ";
	echo "<br>".$sql_rut_ramo;
	$result_rut_ramo = @pg_Exec($conn, $sql_rut_ramo);
	echo "<br>".$result_rut_ramo;
	echo "<br>".pg_last_error();
	if (pg_numrows($result_rut_ramo) == 1){
		$rut_ramo = @pg_fetch_array($result_rut_ramo, 0);
		$rut_ramo = $rut_ramo[0];
	}
	echo "<br>".$rut_ramo
?>