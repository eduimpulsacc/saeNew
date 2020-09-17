<?php
	require('../../../../../../util/header.inc');
	

function salida_abrupta($mensaje){
	echo "<script language=\"javascript\" type=\"text/javascript\">
						alert(\"{$mensaje}\");
						</script>";	
	echo "<script>window.location = \"planificacion.php?id_ramo=".$_GET['id_ramo']."\"</script>";
	exit;
}
/*	//------------------------
	// verificar doble post
	//------------------------
 	if (isset($_SESSION['postid'])) {
		if ($_POST['postID'] == $_SESSION['postid']){
			unset($_SESSION['postid']);
		} else{
			unset($_SESSION['postid']);
			salida_abrupta("Puede que ud. esté usando la sesión de otra persona, por favor vuelva a iniciar su sesión");
		}
	} else salida_abrupta("Para evitar duplicar las planificaciones, por favor vuelva a la página anterior");
*/
	//------------------------
	// verificar variables
	//------------------------
	if (!($_RAMO && $_CURSO && $_ANO && $_INSTIT && $_USUARIO)){
		salida_abrupta("No se ingresaron correctamente los parámetros");
	} else {
		$id_ramo		= $_RAMO;
		$curso			= $_CURSO;
		$ano			= $_ANO;
		$institucion	= $_INSTIT;
		$usuario		= $_USUARIO;
	}
	
	if (!is_numeric(($_POST["id_plani"]))){
		salida_abrupta("No se transmitió correctamente la información desde la página anterior. Por favor vuelva a intentarlo");
	} else
		$id_plani = $_POST["id_plani"];
	
	
	
	
	//------------------------
	// insertar fechas de la planificacion
	//------------------------
	if ( ($dia_inicio = pg_escape_string($_POST['text_dia_inicio'])) != "" &&
			($mes_inicio = pg_escape_string($_POST['text_mes_inicio'])) != "" &&
			($ano_inicio = pg_escape_string($_POST['text_ano_inicio'])) != ""){
		if (is_numeric($dia_inicio) && is_numeric($mes_inicio) && is_numeric($ano_inicio)){
			if (checkdate($mes_inicio, $dia_inicio, $ano_inicio)){
				$fecha_inicio = "$ano_inicio/$mes_inicio/$dia_inicio";
			}
		}
	}
	
	if ( ($dia_fin = pg_escape_string($_POST['text_dia_fin'])) != "" &&
			($mes_fin = pg_escape_string($_POST['text_mes_fin'])) != "" &&
			($ano_fin = pg_escape_string($_POST['text_ano_fin'])) != ""){
		if (is_numeric($dia_fin) && is_numeric($mes_fin) && is_numeric($ano_fin)){
			if (checkdate($mes_fin, $dia_fin, $ano_fin)){
				$fecha_fin = "$ano_fin/$mes_fin/$dia_fin";
			}
		}
	}
	
	//------------------------------------
	//actualizar fechas
	//------------------------------------
	if ((is_numeric($dia_fin) && is_numeric($mes_fin) && is_numeric($ano_fin)) and (is_numeric($dia_inicio) && is_numeric($mes_inicio) && is_numeric($ano_inicio)))
	{
	 $sql_fechas="update plani set fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin' where id_plani=$id_plani";
	$result_fechas = @pg_Exec($conn, $sql_fechas) ;
	
	}
	//------------------------
	// ingresar relacion unidad_has_clase
	//------------------------
	if (is_numeric($unidad_plani = pg_escape_string($_POST['select_unidad_plani'])) && $unidad_plani!='0'){
		// que la primera plani sea efectivamente de unidad
		$sql_select_unidad = "SELECT momento FROM plani WHERE id_plani=$unidad_plani";
		$result_select_unidad = @pg_Exec($conn, $sql_select_unidad) or salida_abrupta ("Error 100");
		if (pg_numrows($result_select_unidad) == 1){
			$plani_momento = @pg_fetch_array($result_select_unidad, 0);
			$plani_momento = $plani_momento[0];
		} else salida_abrupta("No se encontró la planificación de unidad");
		if ($plani_momento != 20){
			salida_abrupta("La planificación de unidad no es tal");
		}
		// que la otra plani sea efectivamente de clase
		$sql_select_clase= "SELECT momento FROM plani WHERE id_plani=$id_plani";
		$result_select_clase = @pg_Exec($conn, $sql_select_clase) or salida_abrupta ("Error 200");
		if (pg_numrows($result_select_clase) == 1){
			$plani_momento = @pg_fetch_array($result_select_clase, 0);
			$plani_momento = $plani_momento[0];
		} else salida_abrupta("No se encontró la planificación de clase");
		if ($plani_momento != 30){
			salida_abrupta("La planificación de clase no es tal");
		}
		// insertar relacion
		$sql_insert_has = "INSERT INTO plani_unidad_has_clase (clase_id_plani, unidad_id_plani) VALUES ($id_plani,$unidad_plani)";
//		echo  "<br>".$sql_insert_has;
		$result_update = @pg_Exec($conn, $sql_insert_has) or salida_abrupta ("Error 300");
//		echo "<br>".$result_update;
	}

	//------------------------
	// ingresar datos a plani_tipo_*
	//------------------------
	$sql_select_tipo= "SELECT tipo,momento FROM plani WHERE id_plani=$id_plani";
	$result_select_tipo = @pg_Exec($conn, $sql_select_tipo) or salida_abrupta ("Error 400");
	if (pg_numrows($result_select_tipo) == 1){
		$plani_datos = @pg_fetch_array($result_select_tipo, 0, PGSQL_ASSOC);
		$plani_tipo = $plani_datos['tipo'];
		$momento = $plani_datos['momento'];
	} else salida_abrupta("No se encontró la planificación");

	if ($plani_tipo == 10){
		// plani tipo v heurística
		$preguntas = pg_escape_string($_POST['editor_preguntas']);
		$conceptual = pg_escape_string($_POST['editor_conceptual']);
		$metodologia = pg_escape_string($_POST['editor_metodologia']);
		$acontecimientos = pg_escape_string($_POST['editor_acontecimientos']);
	
		$sql_insert_v = "INSERT INTO Plani_V (id_plani, preguntas, conceptual, metodologia, acontecimientos) VALUES ($id_plani, '$preguntas', '$conceptual', '$metodologia', '$acontecimientos')";
		$result_insert_v = @pg_Exec($conn, $sql_insert_v) or salida_abrupta ("Error 500");

	}
	
	else if ($plani_tipo == 20){
		// plani tipo t
		$contenidos = pg_escape_string($_POST['editor_contenidos']);
		$procedimientos = pg_escape_string($_POST['editor_procedimientos']);
		$capacidades = pg_escape_string($_POST['editor_capacidades']);
		$valores = pg_escape_string($_POST['editor_valores']);

		$sql_insert_t = "INSERT INTO Plani_T (id_plani, contenidos, procedimientos, capacidades, valores) VALUES ($id_plani, '$contenidos', '$procedimientos', '$capacidades', '$valores')";
		$result_insert_t = @pg_Exec($conn, $sql_insert_t) or salida_abrupta ("Error 600");
	}
	
	else if ($plani_tipo == 30){
		// plani trayecto
			// unidad
		if ($momento == 20){
				// parte 1
			$unidad_t = pg_escape_string($_POST['editor_unidad_t']);
			$ofv = pg_escape_string($_POST['editor_ofv']);
			$oft = pg_escape_string($_POST['editor_oft']);
			$cmo = pg_escape_string($_POST['editor_cmo']);
			$meta_a = pg_escape_string($_POST['editor_meta_a']);
			$matriz = pg_escape_string($_POST['editor_matriz']);
			$temas_f = pg_escape_string($_POST['editor_temas_f']);
			$conceptos_i = pg_escape_string($_POST['editor_conceptos_i']);
			$ideas_c = pg_escape_string($_POST['editor_ideas_c']);
			$bibliografia = pg_escape_string($_POST['editor_bibliografia']);
				// parte 2
			$matriz_ev = pg_escape_string($_POST['editor_matriz_ev']);			
			$modalidad_e = pg_escape_string($_POST['editor_modalidad_e']);
			$actividad_e = pg_escape_string($_POST['editor_actividad_e']);
			$instancia_e = pg_escape_string($_POST['editor_instancia_e']);
			$procedimientos = pg_escape_string($_POST['editor_procedimientos']);
			$instrumentos = pg_escape_string($_POST['editor_instrumentos']);
			$agentes = pg_escape_string($_POST['editor_agentes']);
	
			$sql_insert_trayecto_unidad = "INSERT INTO Plani_Trayecto_Unidad (id_plani, unidad_t, ofv, oft, cmo, meta_a, matriz, temas_f, conceptos_i, ideas_c, bibliografia,
								matriz_ev, modalidad_e, actividad_e, instancia_e, prodedimientos, instrumentos, agentes)
							VALUES ($id_plani, '$unidad_t', '$ofv', '$oft', '$cmo', '$meta_a', '$matriz', '$temas_f', '$conceptos_i', '$ideas_c', '$bibliografia',
								'$matriz_ev', '$modalidad_e', '$actividad_e', '$instancia_e', '$prodedimientos', '$instrumentos', '$agentes');";
//			echo $sql_insert_trayecto_unidad;
			$result_insert_trayecto_unidad = @pg_Exec($conn, $sql_insert_trayecto_unidad) or salida_abrupta ("Error 700");	
		}		
			// clase 
		elseif ($momento == 30){
			$unidad = pg_escape_string($_POST['editor_unidad']);
			$sesion = pg_escape_string($_POST['editor_sesion']);
			$hh = pg_escape_string($_POST['select_hh']);
			if (!is_numeric($hh) || 8 >= $hh || $hh >= 18)
				$hh = 8;
			$mm = pg_escape_string($_POST['select_mm']);
			if (!is_numeric($mm) || 0 >= $mm || $mm >= 60)
				$mm = 0;
			$metas_a = pg_escape_string($_POST['editor_metas_a']);
			$objetivo_d = pg_escape_string($_POST['editor_objetivo_d']);
			$c_conceptuales = pg_escape_string($_POST['editor_c_conceptuales']);
			$c_procedimentales = pg_escape_string($_POST['editor_c_procedimentales']);
			$c_actitudinales = pg_escape_string($_POST['editor_c_actitudinales']);
			$matriz = pg_escape_string($_POST['editor_matriz']);
			$modificaciones = pg_escape_string($_POST['editor_modificaciones']);
			$fundamentaciones = pg_escape_string($_POST['editor_fundamentaciones']);

			$sql_insert_trayecto_clase = "INSERT INTO Plani_Trayecto_Clase (id_plani, unidad, sesion, hh, mm, metas_a, objetivo_d,
								 c_conceptuales, c_procedimentales, c_actitudinales, matriz, modificaciones, fundamentaciones)
							VALUES ($id_plani, '$unidad', '$sesion', '$hh', '$mm', '$metas_a', '$objetivo_d',
								 '$c_conceptuales', '$c_procedimentales', '$c_actitudinales', '$matriz', '$modificaciones', '$fundamentaciones')";
			$result_insert_trayecto_clase = @pg_Exec($conn, $sql_insert_trayecto_clase) or salida_abrupta ("Error 800");
			
		}
	}
	else salida_abrupta("Problemas al enviar los datos... reintente");
	
	echo "<script language=\"javascript\" type=\"text/javascript\">
			alert('Se completó exitosamente la operación');
			window.location = 'planificacion.php?id_ramo=$id_ramo';
			</script>";
?>

<?php pg_close($conn);
?>
