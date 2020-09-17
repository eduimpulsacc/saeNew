<?php
	require('../../../../../../util/header.inc');
	
	foreach($_POST as $nombre_campo => $valor)
   { 
      
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	//echo "asignacion=$asignacion<br>";
	
   }
   
    foreach($_GET as $nombre_campo => $valor)
   { 
   
   
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	//echo "asignacion=$asignacion<br>";
   }
	
function salida_abrupta($mensaje){
//  echo "<script>window.location = 'http://intranet.colegiointeractivo.com/sae3.0/session/finSession.php'</script>";
	echo "<script language=\"javascript\" type=\"text/javascript\">
						alert(\"{$mensaje}\");
						</script>";	
	echo "<script>window.location = \"planificacion.php?id_ramo=".$_POST['id_ramo']."\"</script>";
	exit;
}
	//------------------------
	// verificar doble post
	//------------------------
/*	if (isset($_SESSION['postid'])) {
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
		salida_abrupta("Error 100");
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
	// actualizar fechas de la planificacion
	//------------------------
	if ( ($dia_inicio = pg_escape_string($_POST['text_dia_inicio'])) != "" &&
			($mes_inicio = pg_escape_string($_POST['text_mes_inicio'])) != "" &&
			($ano_inicio = pg_escape_string($_POST['text_ano_inicio'])) != ""){
		if (is_numeric($dia_inicio) && is_numeric($mes_inicio) && is_numeric($ano_inicio)){
			if (checkdate($mes_inicio, $dia_inicio, $ano_inicio)){
				$update_plani .= "fecha_inicio = '$dia_inicio/$mes_inicio/$ano_inicio', ";
			}
		}
	}
	
	if ( ($dia_fin = pg_escape_string($_POST['text_dia_fin'])) != "" &&
			($mes_fin = pg_escape_string($_POST['text_mes_fin'])) != "" &&
			($ano_fin = pg_escape_string($_POST['text_ano_fin'])) != ""){
		if (is_numeric($dia_fin) && is_numeric($mes_fin) && is_numeric($ano_fin)){
			if (checkdate($mes_fin, $dia_fin, $ano_fin)){
				$update_plani .= "fecha_fin = '$dia_fin/$mes_fin/$ano_fin', ";
			}
		}
	}
	
	if ( ($dia_abor = pg_escape_string($_POST['text_dia_abor'])) != "" &&
			($mes_abor = pg_escape_string($_POST['text_mes_abor'])) != "" &&
			($ano_abor = pg_escape_string($_POST['text_ano_abor'])) != ""){
		if (is_numeric($dia_abor) && is_numeric($mes_abor) && is_numeric($ano_abor)){
			if (checkdate($mes_abor, $dia_abor, $ano_abor)){
				$update_plani .= "fecha_abordaje = '$dia_abor/$mes_abor/$ano_abor', ";
			}
		}
	}
	
	// actualizar fechas en plani
	if ($update_plani != ""){
		$sql_update_plani = "SET DateStyle TO 'SQL, dmy'; UPDATE plani SET $update_plani fecha_modificacion = 'now' WHERE id_plani = $id_plani";
		$result_update = @pg_Exec($conn, $sql_update_plani) or salida_abrupta ("Error 200");
	}

	//------------------------
	// ingresar datos a plani_tipo_*
	//------------------------

	// obtener tipo de plani
	$sql_select_tipo= "SELECT tipo, momento FROM plani WHERE id_plani=$id_plani";
	$result_select_tipo = @pg_Exec($conn, $sql_select_tipo) or salida_abrupta ("Error 300");
	if (pg_numrows($result_select_tipo) == 1){
		$plani_datos = @pg_fetch_array($result_select_tipo);
		$plani_tipo = $plani_datos['tipo'];
		$momento = $plani_datos['momento'];
	} else salida_abrupta("No se encontró la planificación");

	
	// determinar si tiene detalle ingresado
	switch ($plani_tipo){
		case 10:
			$sql_tiene_detalle = "SELECT id_plani FROM Plani_V WHERE id_plani=$id_plani";
			$result_tiene_detalle = @pg_Exec($conn, $sql_tiene_detalle) or salida_abrupta("Error 400");
			if (pg_numrows($result_tiene_detalle) == 0){
				$tiene_detalle = false;	
			} else $tiene_detalle = true;
			break;
		case 20:
			$sql_tiene_detalle = "SELECT id_plani FROM Plani_T WHERE id_plani=$id_plani";
			$result_tiene_detalle = @pg_Exec($conn, $sql_tiene_detalle) or salida_abrupta("Error 500");
			if (pg_numrows($result_tiene_detalle) == 0){
				$tiene_detalle = false;	
			} else $tiene_detalle = true;
			break;
		case 30:
			if ($momento == 20){
				$sql_tiene_detalle = "SELECT id_plani FROM Plani_Trayecto_Unidad WHERE id_plani=$id_plani";
				$result_tiene_detalle = @pg_Exec($conn, $sql_tiene_detalle) or salida_abrupta("Error 600");
				if (pg_numrows($result_tiene_detalle) == 0){
					$tiene_detalle = false;	
				} else $tiene_detalle = true;
			} elseif ($momento == 30){
				$sql_tiene_detalle = "SELECT id_plani FROM Plani_Trayecto_Clase WHERE id_plani=$id_plani";
				$result_tiene_detalle = @pg_Exec($conn, $sql_tiene_detalle) or salida_abrupta("Error 700");
				if (pg_numrows($result_tiene_detalle) == 0){
					$tiene_detalle = false;	
				} else $tiene_detalle = true;
			}
			break;
	}
	
	// caso 1: si tiene ingresado detalle de plani
	if ($tiene_detalle == true){
		switch ($plani_tipo){
			case 10:
				// plani tipo v heurística
				$preguntas = pg_escape_string($_POST['editor_preguntas']);
				$conceptual = pg_escape_string($_POST['editor_conceptual']);
				$metodologia = pg_escape_string($_POST['editor_metodologia']);
				$acontecimientos = pg_escape_string($_POST['editor_acontecimientos']);
				
				$update_plani_v = "preguntas = '{$preguntas}', conceptual = '{$conceptual}', metodologia = '{$metodologia}', acontecimientos = '{$acontecimientos}'";
				$sql_update_v = "UPDATE Plani_V SET $update_plani_v WHERE id_plani = $id_plani";
				$result_update_v = @pg_Exec($conn, $sql_update_v) or salida_abrupta("Error 800");
				break;
			case 20:
				// plani tipo t
				$contenidos = pg_escape_string($_POST['editor_contenidos']);
				$procedimientos = pg_escape_string($_POST['editor_procedimientos']);
				$capacidades = pg_escape_string($_POST['editor_capacidades']);
				$valores = pg_escape_string($_POST['editor_valores']);
				
				$update_plani_t = "contenidos = '{$contenidos}', procedimientos = '{$procedimientos}', capacidades = '{$capacidades}', valores = '{$valores}'";
				$sql_update_t = "UPDATE Plani_T SET $update_plani_t WHERE id_plani = $id_plani";
				$result_insert_t = @pg_Exec($conn, $sql_update_t) or salida_abrupta("Error 900");
				break;
			case 30:
					// trayecto unidad
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
					
					$update_plani_t = "unidad_t = '{$unidad_t}',
										ofv = '{$ofv}',
										oft = '{$oft}',
										cmo = '{$cmo}',
										meta_a = '{$meta_a}',
										matriz = '{$matriz}',
										temas_f = '{$temas_f}',
										conceptos_i = '{$conceptos_i}',
										ideas_c = '{$ideas_c}',
										bibliografia = '{$bibliografia}',
										matriz_ev = '{$matriz_ev}',
										modalidad_e = '{$modalidad_e}',
										actividad_e = '{$actividad_e}',
										instancia_e = '{$instancia_e}',
										prodedimientos = '{$procedimientos}',
										instrumentos = '{$instrumentos}',
										agentes = '{$agentes}'";
					$sql_update_t = "UPDATE Plani_Trayecto_Unidad SET $update_plani_t WHERE id_plani = $id_plani";
					$result_insert_t = @pg_Exec($conn, $sql_update_t) or salida_abrupta("Error 1001");
				}
					// trayecto clase
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
					
					$update_plani_t = "unidad = '{$unidad}',
										sesion = '{$sesion}',
										hh = '{$hh}',
										mm = '{$mm}',
										metas_a = '{$metas_a}',
										objetivo_d = '{$objetivo_d}',
										c_conceptuales = '{$c_conceptuales}',
										c_procedimentales = '{$c_procedimentales}',
										c_actitudinales = '{$c_actitudinales}',
										matriz = '{$matriz}',
										modificaciones = '{$modificaciones}',
										fundamentaciones = '{$fundamentaciones}'";
					$sql_update_t = "UPDATE Plani_Trayecto_Clase SET $update_plani_t WHERE id_plani = $id_plani";
					$result_insert_t = @pg_Exec($conn, $sql_update_t) or salida_abrupta("Error 1100");
				}
				break;		
		}
	} 
	// caso 2: no tiene ingresado detalle de plani
	else {
		switch ($plani_tipo){
			case 10:
				// plani tipo v heurística
				$preguntas = pg_escape_string($_POST['editor_preguntas']);
				$conceptual = pg_escape_string($_POST['editor_conceptual']);
				$metodologia = pg_escape_string($_POST['editor_metodologia']);
				$acontecimientos = pg_escape_string($_POST['editor_acontecimientos']);

				$sql_insert_v = "INSERT INTO Plani_V (id_plani, preguntas, conceptual, metodologia, acontecimientos) VALUES ($id_plani, '$preguntas', '$conceptual', '$metodologia', '$acontecimientos')";
				$result_insert_v = @pg_Exec($conn, $sql_insert_v) or salida_abrupta("Error 1200");
				break;
			case 20:
				// plani tipo t
				$contenidos = pg_escape_string($_POST['editor_contenidos']);
				$procedimientos = pg_escape_string($_POST['editor_procedimientos']);
				$capacidades = pg_escape_string($_POST['editor_capacidades']);
				$valores = pg_escape_string($_POST['editor_valores']);

				$sql_insert_t = "INSERT INTO Plani_T (id_plani, contenidos, procedimientos, capacidades, valores) VALUES ($id_plani, '$contenidos', '$procedimientos', '$capacidades', '$valores')";
				$result_insert_t = @pg_Exec($conn, $sql_insert_t) or salida_abrupta ("Error 1300");
				break;
			case 30:
					// trayecto unidad
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
										matriz_ev, modalidad_e, actividad_e, instancia_e, prodedimientos, instrumentos, agentes )
									VALUES ($id_plani, '$unidad_t', '$ofv', '$oft', '$cmo', '$meta_a', '$matriz', '$temas_f', '$conceptos_i', '$ideas_c', '$bibliografia',
										'$matriz_ev', '$modalidad_e', '$actividad_e', '$instancia_e', '$prodedimientos', '$instrumentos', '$agentes ')";
					$result_insert_trayecto_unidad = @pg_Exec($conn, $sql_insert_trayecto_unidad) or salida_abrupta ("Error 1400");
				}
				elseif ($momento == 30){
					// trayecto clase
					$unidad = pg_escape_string($_POST['editor_unidad']);
					$sesion = pg_escape_string($_POST['editor_sesion']);	
					$hh = pg_escape_string($_POST['select_hh']);
					if (!is_numeric($hh) || 8 >= $hh || $hh >= 18)
						$hh = 8;
					$mm = pg_escape_string($_POST['select_mm']);
					if (!is_numeric($mm) || 0 >= $mm || $mm >= 60)
						$mm = 8;
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
					$result_insert_trayecto_clase = @pg_Exec($conn, $sql_insert_trayecto_clase) or salida_abrupta ("Error 1500");
				}
				break;
		}
	}

	echo "<script language=\"javascript\" type=\"text/javascript\">
			alert('Se completó exitosamente la operación');
			window.location = 'planificacion.php?id_ramo=$id_ramo';
			</script>";
?>

<?php pg_close($conn);
?>
