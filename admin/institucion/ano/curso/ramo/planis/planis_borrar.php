<?php
	require('../../../../../../util/header.inc');

	function salida_abrupta($mensaje){

	
		echo "<script language=\"javascript\" type=\"text/javascript\">
						alert(\"{$mensaje}\");
						</script>";	
	"<script>window.location = \"planificacion.php?id_ramo=".$_GET['id_ramo']."\"</script>";
	exit;
	
}
/*
	function salida_abrupta($mensaje){
//    echo "<script>window.location = 'http://intranet.colegiointeractivo.com/sae3.0/session/finSession.php'</script>";
	echo $mensaje;
	exit();
}
*/
	//------------------------
	// verificar variables
	//------------------------
	if (!($id_plani && $_CURSO && $_ANO && $_INSTIT && $_USUARIO)){
		salida_abrupta("Error 100");
		return;
	} else {
		$_RAMO=$_GET['id_ramo'];
		$id_ramo		= $_RAMO;
		$curso			= $_CURSO;
		$ano			= $_ANO;
		$institucion	= $_INSTIT;
		$usuario		= $_USUARIO;
		echo"--->".$rut_usuario	= $_NOMBREUSUARIO;
	}
	
	//------------------------
	// validacion rut usuario match rut ramo
	//------------------------
		// rut empleado
	
	
	
	if (isset($rut_usuario)){
		
		$rut_usuario= $rut_usuario;
	} else{  salida_abrupta('no se encontró run empleado');
	}
		// rut ramo
	$sql_rut_ramo = "SELECT rut_emp FROM dicta WHERE id_ramo = '{$id_ramo}' LIMIT 1 ";
	$result_rut_ramo = @pg_Exec($conn, $sql_rut_ramo) or  salida_abrupta ("Fallo en la consulta linea 37");
	if (pg_numrows($result_rut_ramo) == 1){
		$rut_ramo = @pg_fetch_array($result_rut_ramo, 0);
		$rut_ramo = $rut_ramo[0];
	} else  salida_abrupta("Usuario: no se encontró rut ramo");
		// comparar
	if ($rut_usuario != $rut_ramo)
		 salida_abrupta("Run en ramo no concuerda con usuario de la sesion");
		
	//------------------------
	// validacion rut usuario match rut plani
	//------------------------
	$sql_rut_plani = "SELECT rut_emp FROM plani WHERE id_plani = '{$id_plani}' LIMIT 1 ";
	$result_rut_plani = @pg_Exec($conn, $sql_rut_plani) or  salida_abrupta("Fallo en la consulta linea 50");
	if (pg_numrows($result_rut_plani) == 1){
		$rut_plani = @pg_fetch_array($result_rut_plani, 0);
		$rut_plani = $rut_plani[0];
	} else  salida_abrupta("Usuario: no se encontró run en plani");
		// comparar
	if ($rut_usuario != $rut_plani)
		 salida_abrupta("Dueño de la planificacion no concuerda con usuario de la sesion");
	
	//------------------------
	// setear plani como oculta
	//------------------------
	$sql_borrar_plani = "UPDATE plani SET esta_oculta = TRUE, fecha_modificacion = 'now' WHERE id_plani = '{$id_plani}'";
	if (@pg_Exec($conn, $sql_borrar_plani)){
		echo utf8_encode("<script language=\"javascript\" type=\"text/javascript\">
					alert(\"La planificación fue borrada\");
					history.go(0);
					</script>");
	} else {
		echo utf8_encode("<script language=\"javascript\" type=\"text/javascript\">
			alert(\"No se completó la operación. Revise e intente nuevamente\");
			history.go(0);
			</script>");
	}
	
	
	//------------------------
	// cerrar conexion a la bd
	//------------------------	
	pg_close($conn);
?>
