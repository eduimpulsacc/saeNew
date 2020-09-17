<?php
	require('../../../../../../util/header.inc');

function salida_abrupta($mensaje){
//  echo "<script>window.location = 'http://intranet.colegiointeractivo.com/sae3.0/session/finSession.php'</script>";
	echo "<script language=\"javascript\" type=\"text/javascript\">
						alert(\"{$mensaje}\");
						</script>";	
	echo "<script>window.close()</script>";
	exit;
}

	//------------------------
	// verificar variables
	//------------------------
	$id_plani = $_GET['id_plani'];
	if (!($id_plani && $_CURSO && $_ANO && $_INSTIT && $_USUARIO)){
		salida_abrupta("No se encontraron los datos de la sesión");
	} else {
		$id_ramo		= $_RAMO;
		$curso			= $_CURSO;
		$ano			= $_ANO;
		$institucion	= $_INSTIT;
		$usuario		= $_USUARIO;
	}

	// ENCABEZADO SUBSECTOR
	
	//------------------------
	// obtener numero del año 
	//------------------------
	$sql_ano = "SELECT nro_ano
				FROM ano_escolar
				WHERE id_ano = ".$ano;
	if ($result_ano	= @pg_Exec($conn, $sql_ano)){
		if (pg_numrows($result_ano) != 0){
			if ($fila_ano = @pg_fetch_array($result_ano)){
				$nro_ano =	$fila_ano['0'];
//				echo "</br>".$nro_ano ;
			}
			else salida_abrupta("Error obteniendo número del año");
		}
		else salida_abrupta("Error obteniendo datos del año");
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
			} else salida_abrupta("Error obteniendo rut del docente");
		} else salida_abrupta("Error obteniendo datos del rut del docente");
	} else salida_abrupta("Error realizando la consulta a la BD");	
		
	$sql_profe = "	SELECT nombre_emp,
							ape_pat,
							ape_mat,
							id_usuario
					FROM empleado
					WHERE rut_emp = ".trim($rut_emp);
	if ($result_profe = @pg_Exec($conn, $sql_profe)){			
		if (pg_numrows($result_profe) != 0){
			if ($fila_profe = @pg_fetch_array($result_profe, 0, PGSQL_ASSOC)){
				$nombre_profe =	$fila_profe['nombre_emp']." ".$fila_profe['ape_pat']." ".$fila_profe['ape_mat'];
				$id_usuario = $fila_profe['id_usuario'];
				if ($id_usuario != $usuario)
					salida_abrupta("RUN del profesor no concuerda con usuario de la sesión, rut_prof :".$rut_emp." id_usuario:".$id_usuario);
			} else salida_abrupta("Error obteniendo nombre del docente");
		} else salida_abrupta("Error obteniendo datos del nombre del docente");
	} else salida_abrupta("Error realizando la consulta a la BD");	
	
	
	// RESUMEN PLANI

	//------------------------
	// obtener datos basicos de plani
	//------------------------
	$sql_plani = "SET DateStyle TO 'SQL, dmy';
				SELECT nombre,
						descripcion,
						tipo,
						momento,
						fecha_inicio,
						fecha_fin,
						avance,
						logro,
						fecha_abordaje
				FROM plani
				WHERE id_plani = ".$id_plani;
	if ($result_plani	= @pg_Exec($conn, $sql_plani)){
		if (pg_numrows($result_plani) == 1){
			if ($resumen_plani = @pg_fetch_array($result_plani)){
				$tipo_plani = $resumen_plani['tipo'];
				$momento = $resumen_plani['momento'];
			}
			else salida_abrupta("Error 100");
		}
		else salida_abrupta("Error 200");
	}
	else salida_abrupta("Error 300");


	
	// DETALLE PLANI
		
	//------------------------
	// obtener detalle de plani
	//------------------------
	switch ($tipo_plani) {
			// v heuristica
		case 10:
		    $sql_plani_v = "SELECT preguntas,
								conceptual,
								metodologia,
								acontecimientos
							FROM plani_v
							WHERE id_plani = ".$id_plani;
			if ($result_plani_v	= @pg_Exec($conn, $sql_plani_v)){
				if (pg_numrows($result_plani_v) != 0){
					if ($fila_plani_v = @pg_fetch_array($result_plani_v)){
						$plani_preguntas	=	$fila_plani_v['preguntas'];
						$plani_conceptual	=	$fila_plani_v['conceptual'];
						$plani_metodologia	=	$fila_plani_v['metodologia'];
						$plani_acontecimientos = $fila_plani_v['acontecimientos'];
					} else salida_abrupta("Error 400");
				} else{
					echo "<script language=\"javascript\" type=\"text/javascript\">
						alert(\"No existe el detalle de la planificación seleccionada\");
						</script>";
				}
			} else salida_abrupta("Error 500");
			break;
			
			// tipo t
		case 20:
			$sql_plani_t = "SELECT contenidos,
								procedimientos,
								capacidades,
								valores
							FROM plani_t
							WHERE id_plani = ".$id_plani;
			if ($result_plani_t	= @pg_Exec($conn, $sql_plani_t)){
				if (pg_numrows($result_plani_t) != 0){
					if ($fila_plani_t = @pg_fetch_array($result_plani_t)){
						$plani_contenidos 		= $fila_plani_t['contenidos'];
						$plani_procedimientos	= $fila_plani_t['procedimientos'];
						$plani_capacidades		= $fila_plani_t['capacidades'];
						$plani_valores			= $fila_plani_t['valores'];
					} else salida_abrupta("Error 600");
				} else{
					echo "<script language=\"javascript\" type=\"text/javascript\">
						alert(\"No existe el detalle de la planificación seleccionada\");
						</script>";
				}
			} else salida_abrupta("Error 700");
			break;
			
			// trayecto
		case 30:
				// trayecto unidad
			if ($momento == 20){
				$sql_plani_t = "SELECT unidad_t,
										ofv,
										oft,
										cmo,
										meta_a,
										matriz,
										temas_f,
										conceptos_i,
										ideas_c,
										bibliografia,
										matriz_ev,
										modalidad_e,
										actividad_e,
										instancia_e,
										prodedimientos,
										instrumentos,
										agentes
							FROM Plani_Trayecto_Unidad
							WHERE id_plani = ".$id_plani;
				if ($result_plani_t	= @pg_Exec($conn, $sql_plani_t)){
					if (pg_numrows($result_plani_t) != 0){
						if ($result_t = @pg_fetch_array($result_plani_t)){
							$unidad_t = $result_t['unidad_t'];
							$ofv = $result_t['ofv'];
							$oft = $result_t['oft'];
							$cmo = $result_t['cmo'];
							$meta_a = $result_t['meta_a'];
							$matriz = $result_t['matriz'];
							$temas_f = $result_t['temas_f'];
							$conceptos_i = $result_t['conceptos_i'];
							$ideas_c = $result_t['ideas_c'];
							$bibliografia = $result_t['bibliografia'];
							$matriz_ev = $result_t['matriz_ev'];
							$modalidad_e = $result_t['modalidad_e'];
							$actividad_e = $result_t['actividad_e'];
							$instancia_e = $result_t['instancia_e'];
							$prodedimientos = $result_t['prodedimientos'];
							$instrumentos = $result_t['instrumentos'];
							$agentes = $result_t['agentes'];
						} else salida_abrupta("Error 800");
					} else{
						echo "<script language=\"javascript\" type=\"text/javascript\">
							alert(\"No existe el detalle de la planificación seleccionada\");
							</script>";
					}
				} else salida_abrupta("Error 1001");	
			}
				// trayecto clase
			elseif ($momento == 30){
				$sql_plani_t = "SELECT unidad,
										sesion,
										hh,
										mm,
										metas_a,
										objetivo_d,
										c_conceptuales,
										c_procedimentales,
										c_actitudinales,
										matriz,
										modificaciones,
										fundamentaciones
								FROM Plani_Trayecto_Clase
								WHERE id_plani = ".$id_plani;
				if ($result_plani_t	= @pg_Exec($conn, $sql_plani_t)){
					if (pg_numrows($result_plani_t) != 0){
						if ($result_t = @pg_fetch_array($result_plani_t)){
							$unidad =	$result_t['unidad'];
							$sesion = 	$result_t['sesion'];
							$hh = 		$result_t['hh'];
							$mm =		$result_t['mm'];
							$metas_a =	$result_t['metas_a'];
							$objetivo_d =		$result_t['objetivo_d'];
							$c_conceptuales =	$result_t['c_conceptuales'];
							$c_procedimentales =$result_t['c_procedimentales'];
							$c_actitudinales =	$result_t['c_actitudinales'];
							$matriz =	$result_t['matriz'];
							$modificaciones =	$result_t['modificaciones'];
							$fundamentaciones =	$result_t['fundamentaciones'];
						} else salida_abrupta("Error 1100");
					} else{
						echo "<script language=\"javascript\" type=\"text/javascript\">
							alert(\"No existe el detalle de la planificación seleccionada\");
							</script>";
					}
				} else salida_abrupta("Error 1200");	
			}
			break;
	}
?>
<html>
<head>
<link href="./scripts/SpryData.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript">
	function printPage() {
		var numDivs = 2;
		for (i = 1; i < numDivs; i++) {
			if(document.all['divNoPrint'+i]){
		    	document.all['divNoPrint'+i].style.display = 'none';
			}
		}
		window.print();
		for(i = 1; i < numDivs; i++) {
			if(document.all['divNoPrint'+i]){
		    	document.all['divNoPrint'+i].style.display = '';
			}
		} 
	}
</script>
</head>

<body>

<!-- Inicio Nueva Planificacion -->

<?php		
	//------------------------
	//generar tabla datos subramo
	//------------------------
?>
	<p align="center" valign="top" class="titulo1">Planificaci&oacute;n Docente</p>
	<table id="tabla_datos">
		<tr>
			<td class="titulo2">A&ntilde;o Escolar:</td>
			<td class="texto2"><?php echo $nro_ano; ?></td>
		</tr>
		<tr>
			<td class="titulo2">Curso:</td>
			<td class="texto2"><?php echo $nombre_curso; ?></td>
		</tr>
		<tr>
			<td class="titulo2">Subsector:</td>
			<td class="texto2"><?php echo $nombre_ramo; ?></td>
		</tr> 
		<tr>
			<td class="titulo2">Docente:</td>
			<td class="texto2"><?php echo $nombre_profe; ?></td>
		</tr>  
	</table>
	<hr>
	<?php
	
	//------------------------
	//generar tabla resumen
	//------------------------
	?>
	<table>
		<tr>
			<td class="titulo2">Planificaci&oacute;n:</td>
			<td colspan="3" class="texto2"><?php echo $resumen_plani['nombre'] ?></td>
		</tr>
		<tr>
			<td width="30%" class="titulo2">Descripci&oacute;n:</td>
			<td colspan="3" class="texto2"><?php echo $resumen_plani['descripcion'] ?></td>
		</tr>
		<tr>
			<td width="30%" class="titulo2">Momento Pedag&oacute;gico:</td>
			<td class="texto2"><?php 
				switch ($momento) {
					case 10:
						echo "Anual";
						break;
					case 20:
						echo "Unidad";
						break;
					case 30:
						echo "Clase";
						break;
				} ?></td>
			<td width="30%" class="titulo2">Tipo de Planificaci&oacute;n:</td>
			<td class="texto2"><?php 
				switch ($tipo_plani) {
					case 10:
						echo "V Heurística";
						break;
					case 20:
						echo "Tipo T";
						break;
					case 30:
						echo "de Trayecto";
						break;
				} ?></td>
		</tr>
		<tr>
			<td width="30%" class="titulo2">Avance:</td>
			<td class="texto2"><?php echo $resumen_plani['avance'] ?> %</td>
			<td width="30%" class="titulo2">Logro:</td>
			<td class="texto2"><?php echo $resumen_plani['logro'] ?> %</td>
		</tr>
		<tr>
			<td width="30%" class="titulo2">Per&iacute;odo de aplicaci&oacute;n:</td>
			<td class="texto2">desde <?php echo $resumen_plani['fecha_inicio'] ?></td>
			<td colspan="2" class="texto2">hasta <?php echo $resumen_plani['fecha_fin']?></td>
		</tr>
	</table>
	<hr>
	<?php
	
	//------------------------
	//generar tabla detalle
	//------------------------
	switch ($tipo_plani) {
			// V heuristica
		case 10:
			?>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tabla_plani_v">
				<tr align="center" valign="top">
				    <td colspan="3" valign="bottom">
				    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
					      <tr>
					        <td width="20%">&nbsp;</td>
					        <td width="60%">
					        	<div align="center"><p class="titulo1">Preguntas Centrales</strong></p>
				    			<div align="justify" class="texto3"><?php echo $plani_preguntas; ?></div></td>
					        <td width="20%">&nbsp;</td>
					      </tr>
				    	</table></td>
				</tr>
				<tr align="center" valign="top">
					<td width="30%" valign="bottom">
						<img src="images/bar_v_side.png" width="100%" height="10" /></td>
				    <td width="40%" valign="bottom">
						<img src="images/bar_v_top.png" width="100%" height="10" /></td>
				    <td width="30%" valign="bottom">
				    	<img src="images/bar_v_side.png" width="100%" height="10" /></td>
				</tr>
				<tr align="center" valign="top">
					<td width="30%" valign="top">
				    	<div align="center"><p class="titulo1">Dominio Conceptual</strong></p>
				    	<div align="justify" class="texto3"><?php echo $plani_conceptual; ?></div></td>
				    <td width="40%" valign="top">
				    	<img src="images/bar_v_down.png" width="100%" align="top" /></td>
				    <td width="30%" valign="top">
				    	<div align="center" class="texto3"><p class="titulo1">Dominio Metodol&oacute;gico</p></div>
				    	<div align="justify"><?php echo $plani_metodologia; ?></div></td>
				</tr>
				<tr align="center" valign="top">
				    <td colspan="3" valign="bottom">
				    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
					      <tr>
					        <td width="20%">&nbsp;</td>
					        <td width="60%">
					        	<div align="center"><p class="titulo1">Acontecimientos - Objetos</p></div>
				    			<div align="justify" class="texto3"><?php echo $plani_acontecimientos; ?></div></td>
					        <td width="20%">&nbsp;</td>
					      </tr>
				    	</table></td>
				</tr>
			</table>
			<?php
			break;
			
			// tipo T
		case 20:
			?>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr bgcolor="#E0DFE3">
					<td colspan="3" bgcolor="#000000">&nbsp;</td>
				</tr>
				<tr>
			        <td width="49%">
			            <div align="center"><p class="titulo1">Contenidos Conceptuales</p></div>
			            <div align="justify" class="texto3"><?php echo $plani_contenidos; ?></div></td>
			        <td width="2%" bgcolor="#000000"></td>
			        <td width="49%">
			            <div align="center"><p class="titulo1">Procedimientos - Estrategias</p></div>
			            <div align="justify" class="texto3"><?php echo $plani_procedimientos; ?></div></td>
				</tr>
				<tr>
			        <td height="1" colspan="3" bgcolor="#000000">&nbsp;</td>
				</tr>
			    <tr>
			        <td>
			            <div align="center"><p class="titulo1">Capacidades - Destrezas</p></div>
			            <div align="justify" class="texto3"><?php echo $plani_capacidades; ?></div></td>
			        <td bgcolor="#000000">&nbsp;</td>
			        <td>
			            <div align="center"><p class="titulo1">Valores - Actitudes</p></div>
			            <div align="justify" class="texto3"><?php echo $plani_valores; ?></div></td>
			    </tr>
				<tr bgcolor="#000000">
					<td colspan="3">&nbsp;</td>
				</tr>
			</table>
			<?php
			break;

			// plani trayecto
		case 30:
			// trayecto unidad
			if ($momento == 20){
			?>
			
			<p class="titulo1">Matriz Metas de Aprendizaje</p>
			<p class="titulo2">A. Organizaci&oacute;n de las Metas y su Evaluaci&oacute;n</p>
			<table width="55%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			    <td height="30" class="texto1"><label>Unidad tem&aacute;tica:</label></td>
			    <td width="75%" class="texto2"><?php echo $unidad_t; ?></td>
			  </tr>
			  <tr>
			    <td height="60" class="texto1"><label>OFV:</label></td>
			    <td class="texto2"><?php echo $ofv; ?></td>
			  </tr>
			  <tr>
			    <td height="60" class="texto1"><label>OFT:</label></td>
			    <td class="texto2"><?php echo $oft; ?></td>
			  </tr>
			  <tr>
			    <td height="60" class="texto1"><label>CMO:</label></td>
			    <td class="texto2"><?php echo $cmo; ?></td>
			  </tr>
			  <tr>
			    <td width="30%" height="60" class="texto1"><label>Meta de aprendizaje u objetivo de la unidad:</label></td>
			    <td class="texto2"><?php echo $meta_a; ?></td>
			  </tr>
			  <tr><td colspan="2">&nbsp;</td></tr>
			  <tr>
			    <td height="90" colspan="2" class="texto3"><?php echo $matriz; ?></td>
			  </tr>
			</table>
			
			<p class="titulo2">B. Red de Contenidos Conceptuales</p>
			    <table width="55%" border="0" cellpadding="0" cellspacing="0">
			      <tr>
			        <td height="60" class="texto1">Temas fundamentales de la unidad:</td>
			        <td class="texto2"><?php echo $temas_f; ?></td>
			      </tr>
			      <tr>
			        <td width="45%" height="60" class="texto1">Conceptos importantes tratados en cada una de las sesiones:</td>
			        <td class="texto2"><?php echo $conceptos_i; ?></td>
			      </tr>
			      <tr>
			        <td height="60" class="texto1"><label>Ideas claves extra&iacute;das de los textos:</label></td>
			        <td class="texto2"><?php echo $ideas_c; ?></td>
			      </tr>
			      <tr>
			        <td height="60" class="texto1"><label>Bibliograf&iacute;a consultada:</label></td>
			        <td class="texto2"><?php echo $bibliografia; ?></td>
			      </tr>
			    </table>
			<hr>
			<p class="titulo1">Matriz Plan de Evaluaci&oacute;n de la Unidad</p>
			<p class="titulo2">A. Modalidad de Evaluaci&oacute;n de cada Meta u Objetivo de Clase</p>
			<table class="texto3"><tr><td><?php echo $matriz_ev; ?></td></tr></table>

			<p class="titulo2">B. Evaluaci&oacuten de la meta de Unidad u Objetivo de Unidad</p>
		    <table width="55%" border="0" cellpadding="0" cellspacing="0">
		      <tr>
		        <td width="25%" height="60" class="texto1"><label>Modalidad de evaluaci&oacute;n:</label></td>
		        <td width="75%" class="texto2"><?php echo $modalidad_e; ?></td>
		      </tr>
		      <tr>
		        <td width="25%" height="60" class="texto1"><label>Actividad de evaluaci&oacute;n:</label></td>
		        <td width="75%" class="texto2"><?php echo $actividad_e; ?></td>
		      </tr>
		      <tr>
		        <td width="25%" height="60" class="texto1"><label>Instancia evaluativa:</label></td>
		        <td width="75%" class="texto2"><?php echo $instancia_e; ?></td>
		      </tr>
		      <tr>
		        <td width="25%" height="60" class="texto1"><label>Procedimientos:</label></td>
		        <td width="75%" class="texto2"><?php echo $prodedimientos; ?></td>
		      </tr>
		      <tr>
		        <td width="25%" height="60" class="texto1"><label>Instrumentos:</label></td>
		        <td width="75%" class="texto2"><?php echo $instrumentos; ?></td>
		      </tr>
		      <tr>
		        <td width="25%" height="60" class="texto1">Agentes:</td>
		        <td width="75%" class="texto2"><?php echo $agentes; ?></td>
		      </tr>
		    </table>	
				
			<?php
			}
				// trayecto clase
			elseif ($momento == 30){
			?>
			
			<p class="titulo2">A. Preparaci&oacute;n de la Ense&ntilde;anza</p>
			<table width="60%" border="0" cellpadding="0" cellspacing="0">
				<tr>
			      <td height="30" colspan="2" class="texto1"><label>Unidad </label>
			         <?php echo $unidad; ?></td>
			    </tr>
			    <tr>
			      <td colspan="2">
			      	<table width="100%" border="0" cellspacing="0" cellpadding="0">
			        	<tr>
			                <td width="40%" height="30" class="texto1"><label>Sesi&oacute;n </label>
			                   <?php echo $sesion; ?></td>
			                <td width="30%" height="30" class="texto1"><label>Hora </label>
			                    <label><?php echo $hh; ?></label>
			                    <label>:</label>
			                    <label><?php echo $mm; ?></label></td>
			         	 </tr>
			      	</table></td>
			    </tr>
			    <tr>
			      <td width="30%" height="60" class="texto1"><label>Metas de aprendizaje u objetivos de la unidad:</label></td>
			      <td height="45" class="texto2"><?php echo $metas_a; ?></td>
			    </tr>
			    <tr>
			      <td height="60" class="texto1"><label>Objetivo did&aacute;ctico de la sesi&oacute;n:</label></td>
			      <td height="40" class="texto2"><?php echo $objetivo_d; ?></td>
			    </tr>
			    <tr>
			      <td height="20" colspan="2" class="texto1"><label>Contenidos:</label></td>
			    </tr>
			    <tr>
			      <td colspan="2">
			      <table border="0" cellspacing="0" cellpadding="0">
			          <tr>
			            <td>&nbsp;</td>
			            <td height="60" class="texto1"><label>Conceptuales:</label></td>
			            <td class="texto2"><?php echo $c_conceptuales; ?></td>
			          </tr>
			          <tr>
			            <td width="1%">&nbsp;</td>
			            <td width="30%" height="60" class="texto1"><label>Procedimentales:</label></td>
			            <td width="69%" class="texto2"><?php echo $c_procedimentales; ?></td>
			          </tr>
			          <tr>
			            <td>&nbsp;</td>
			            <td height="60" class="texto1"><label>Actitudinales:</label></td>
			            <td class="texto2"><?php echo $c_actitudinales; ?></td>
			          </tr>
			      </table></td>
			    </tr>
			  <tr>
			      <td colspan="2" class="texto3"><?php echo $matriz; ?></td>
			  </tr>
		  </table>
			<p class="titulo2">B. An&aacute;lisis de la Ense&ntilde;anza</p>
		    <table width="55%" border="0" cellpadding="0" cellspacing="0">
		      <tr>
		        <td width="30%" height="60" class="texto1">Modificaciones realizadas durante la clase:</td>
		        <td class="texto2"><?php echo $modificaciones; ?></td>
		      </tr>
		      <tr>
		        <td height="60" class="texto1"><label>Fundamentaci&oacute;n de las modificaciones:</label></td>
		        <td class="texto2"><?php echo $fundamentaciones; ?></td>
		      </tr>
		    </table>

			<?php	
			}
			break;	
	}
?>

<div align="center" id="divNoPrint1">
	<form>
		<input type="button" value="Imprimir la Planificación" onClick="printPage()"/>
		<input type="button" value="Cerrar" onClick="window.close()"/>
	</form>
</div>

<!-- Fin Planificaciones -->
	<hr>                              					
	<table align="center">
		<tr>
			<td height="45" align="center" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2008</td>
		</tr>
	</table>

</body>
</html>
<?php pg_close($conn);
?>
