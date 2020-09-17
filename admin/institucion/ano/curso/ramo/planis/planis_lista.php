<?php
	require('../../../../../../util/header.inc');

function salida_abrupta($mensaje){
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
	<table id="tabla_datos_ramo">
		<tr>
			<th>ano_escolar</th>
			<th>curso</th>
			<th>subsector</th>
			<th>docente</th>
		</tr>
		<tr>
			<td><?php echo $mensaje; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>          
	</table>
	
	<table id="tabla_planis">
		<tr>
			<th>@id_plani</th>
			<th>fecha_creacion</th>
			<th>nombre</th>
			<th>descripcion</th>
			<th>id_momento</th>
			<th>momento</th>
			<th>id_tipo</th>
			<th>tipo</th>
			<th>fecha_inicio</th>
			<th>fecha_fin</th>
			<th>fecha_abordaje</th>
			<th>estado</th>
			<th>avance</th>
			<th>logro</th>
			<th>unidad_id_plani</th>
			
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td><?php echo $mensaje; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</body>
	<?php
	}

	//------------------------
	// verificar variables
	//------------------------
	
	if (!($id_ramo && $_CURSO && $_ANO && $_INSTIT && $_USUARIO)){
		die("Faltan datos de la sesion");
	} else {
		if ($viene_de)
			$_VIENEPAG	= $viene_de;
		$_RAMO	=	$id_ramo;
		$curso			= $_CURSO;
		$ano			= $_ANO;
		$institucion	= $_INSTIT;
		$usuario		= $_USUARIO;
	}

	//------------------------
	// obtener numero del ao 
	//------------------------
	$sql_ano = "SELECT nro_ano
				FROM ano_escolar
				WHERE id_ano = ".$ano;
	if ($result_ano	= @pg_Exec($conn, $sql_ano)){
		if (pg_numrows($result_ano) != 0){
			if ($fila_ano = @pg_fetch_array($result_ano)){
				$nro_ano =	$fila_ano['0'];
				echo "</br>".$nro_ano ;
			}
			else salida_abrupta("Error obteniendo numero del ano");
		}
		else salida_abrupta("Error obteniendo datos del ano");
	}
	else salida_abrupta("Error realizando la consulta a la BD");	

	//------------------------
	// obtener nombre del curso 
	//------------------------
	$sql_curso	= "	SELECT curso.grado_curso,
						curso.letra_curso,
						tipo_ensenanza.nombre_tipo
					FROM curso
						INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo
					WHERE curso.id_curso = ".$curso;
	if ($result_curso = @pg_Exec($conn, $sql_curso)){
		if (pg_numrows($result_curso) != 0){
			if ($fila_curso = @pg_fetch_array($result_curso, 0, PGSQL_ASSOC)){
				$nombre_curso = $fila_curso['grado_curso']."-".$fila_curso['letra_curso']." ".$fila_curso['nombre_tipo'];
			} else salida_abrupta("Error obteniendo nombre del curso");
		} else salida_abrupta("Error obteniendo datos del curso");
	} else salida_abrupta("Error realizando la consulta a la BD");	

	//------------------------
	// obtener nombre del subsector
	//------------------------
	$sql_ramo	= "	SELECT subsector.nombre
					FROM ramo
						INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector
					WHERE ramo.id_ramo= ".$id_ramo;
	if ($result_ramo = @pg_Exec($conn, $sql_ramo)){
		if (pg_numrows($result_ramo) != 0){
			if ($fila_ramo = @pg_fetch_array($result_ramo, 0)){
				$nombre_ramo =	$fila_ramo['0'];
			} else salida_abrupta("Error obteniendo nombre del subsector");
		} else salida_abrupta("Error obteniendo datos del subsector");
	} else salida_abrupta("Error realizando la consulta a la BD");	
	
	//------------------------
	// obtener nombre del profesor
	//------------------------
	$sql_rut = "	SELECT rut_emp
					FROM dicta
					WHERE id_ramo = ".$id_ramo;
	if ($result_rut	= @pg_Exec($conn, $sql_rut)){			
		if (pg_numrows($result_rut) != 0){
			if ($fila_rut = @pg_fetch_array($result_rut, 0)){
				$rut_emp =	$fila_rut['0'];
			} else salida_abrupta("Error obteniendo run del docente");
		} else salida_abrupta("Error obteniendo datos del run del docente");
	} else salida_abrupta("Error realizando la consulta a la BD");	
		
	  $sql_profe = "	SELECT nombre_emp,
							ape_pat,
							ape_mat,
							id_usuario,
							rut_emp
					FROM empleado
					WHERE rut_emp = ".$rut_emp;
	if ($result_profe = @pg_Exec($conn, $sql_profe)){			
		if (pg_numrows($result_profe) != 0){
			if ($fila_profe = @pg_fetch_array($result_profe, 0, PGSQL_ASSOC)){
				$nombre_profe =	$fila_profe['nombre_emp']." ".$fila_profe['ape_pat']." ".$fila_profe['ape_mat'];
				$id_usuario = $fila_profe['id_usuario'];
				$rut_empleado=$fila_profe['rut_emp'];
				if (trim($rut_empleado)!=trim($rut_emp))
					salida_abrupta("RUN del profesor no concuerda con usuario de la sesion  $rut_emp-$rut_empleado");
			} else salida_abrupta("Error obteniendo nombre del docente");
		} else salida_abrupta("Error obteniendo datos del nombre del docente");
	} else salida_abrupta("Error realizando la consulta a la BD");	
	
	//------------------------
	// obtener planis del ramo
	//------------------------
	$sql_planis = "	SET DateStyle TO 'SQL, dmy';
					SELECT id_plani,
						to_char(fecha_creacion, 'YYYY/MM/DD'),
						nombre,
						descripcion,
						momento,
						tipo,
						fecha_inicio,
						fecha_fin,
						fecha_abordaje,
						estado,
						avance,
						logro,
						q.unidad_id_plani
					FROM plani
						LEFT OUTER JOIN plani_unidad_has_clase AS q ON id_plani = clase_id_plani
					WHERE id_ramo = ".$id_ramo." AND
						esta_oculta = FALSE";
	if ($result_planis = @pg_Exec($conn, $sql_planis)){			
		if (($num_planis = pg_numrows($result_planis)) > 0){
			for ($i = 0; $i < $num_planis; $i ++){
				$planis[$i] = @pg_fetch_array($result_planis, $i, PGSQL_ASSOC) or salida_abrupta("Error obteniendo las planificaciones");	
				
					
			}		
		} else if ($num_planis == 0){
			$planis = "No existen planificaciones";
		} else salida_abrupta("Error en la carga de las planificaciones");	
	}
	else salida_abrupta("Error realizando la consulta a la BD");	



/***************************************************************/


	//------------------------
	// cerrar conexion a la bd
	//------------------------	
	unset($fila_ano);
	unset($fila_curso);
	unset($fila_ramo);
	unset($fila_rut);
	unset($fila_profe);
	unset($result_ano);
	unset($result_curso);
	unset($result_ramo);
	unset($result_rut);
	unset($result_profe);
	unset($result_planis);
	unset($sql_ano);
	unset($sql_curso);
	unset($sql_ramo);
	unset($sql_rut);
	unset($sql_profe);
	unset($sql_planis);
	pg_close($conn);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
<table id="tabla_datos_ramo">
	<tr>
		<th>ano_escolar</th>
		<th>curso</th>
		<th>subsector</th>
		<th>docente</th>
	</tr>
	<tr>
		<td><?php echo "$nro_ano"; ?></td>
		<td><?php echo "$nombre_curso"; ?></td>
		<td><?php echo "$nombre_ramo"; ?></td>
		<td><?php echo "$nombre_profe"; ?></td>
	</tr>          
</table>

<table id="tabla_planis">
	<tr>
		<th>@id_plani</th>
		<th>fecha_creacion</th>
		<th>nombre</th>
		<th>descripcion</th>
		<th>id_momento</th>
		<th>momento</th>
		<th>id_tipo</th>
		<th>tipo</th>
		<th>fecha_inicio</th>
		<th>fecha_fin</th>
		<th>fecha_abordaje</th>
		<th>estado</th>
		<th>avance</th>
		<th>logro</th>
		<th>unidad_id_plani</th>
		
	</tr>
<?php
	if (is_array($planis)){
		foreach ($planis as $plani_i){
		echo "\t<tr align=\"left\" valign=\"top\">\n\t";
			foreach ($plani_i as $key => $i_columna){
				if ($key == "momento"){
					echo "\t<td>$i_columna</td>\n\t";
					switch ($i_columna) {
						case 10:
							echo "\t<td>Anual</td>\n\t";
						    break;
						case 20:
						    echo "\t<td>Unidad</td>\n\t";
						    break;
						case 30:
						    echo "\t<td>Clase</td>\n\t";
						    break;
					}
				} else if ($key == "tipo"){
					echo "\t<td>$i_columna</td>\n\t";
					switch ($i_columna) {
						case 10:
							echo "\t<td>V Heur&iacute;stica</td>\n\t";
						    break;
						case 20:
						    echo "\t<td>Tipo T</td>\n\t";
						    break;
						case 30:
						    echo "\t<td>de Trayecto</td>\n\t";
						    break;
					}
					
						
				} else echo "\t<td>$i_columna</td>\n\t";
				
			}
			echo "</tr>\n";
		}
	} else{
?>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>no se han ingresado planificaciones</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
<?php
	}
?>
</table>
</body>
</html>
