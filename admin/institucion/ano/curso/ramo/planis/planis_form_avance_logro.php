<?php
	require('../../../../../../util/header.inc');

function salida_abrupta($mensaje){
//  echo "<script>window.location = 'http://intranet.colegiointeractivo.com/sae3.0/session/finSession.php'</script>";
	echo "<script language=\"javascript\" type=\"text/javascript\">
						alert(\"{$mensaje}\");
						</script>";	
	exit;
}
	//------------------------
	// verificar variables
	//------------------------
	if ($id_ramo){
		$_RAMO = $id_ramo;
		$_FRMMODO = "mostrar";
	} else {
		$id_ramo = $_GET['id_ramo'];
	}
	$id_plani = $_GET['id_plani'];
	if (!(is_numeric($id_plani) && $_CURSO && $_ANO && $_INSTIT && $_USUARIO)){
		salida_abrupta("Llame al servicio técnico");
	} else {
		$curso			= $_CURSO;
		$ano			= $_ANO;
		$institucion	= $_INSTIT;
		$usuario		= $_USUARIO;
	}

	if (isset($_GET['avance']) && isset($_GET['logro']) && isset($id_plani)) {

		if (($avance = pg_escape_string($_GET['avance'])) != "" ){
				if (is_numeric($avance)){
					if ($avance > 100)
							$avance = 100;
						$update_plani .= "avance = '$avance', ";	
				}
		}
		
		if (($logro = pg_escape_string($_GET['logro'])) != "" ){
				if (is_numeric($logro)){
					if ($logro > 100)
						$logro = 100;
					$update_plani .= "logro = '$logro', ";	
				}
		}
				
		if ($update_plani != ""){
			$sql_update_plani = "UPDATE plani SET $update_plani fecha_modificacion = 'now' WHERE id_plani = $id_plani";
			$result_update = @pg_Exec($conn, $sql_update_plani) or salida_abrupta("No se pudo actualizar la información");
		}
		
		echo "<script language=\"javascript\" type=\"text/javascript\">
			alert(\"La planificación fue actualizada\");
			history.go(0);
			</script>";
		
	}
	else {
		//------------------------
		// obtener tipo de plani
		//------------------------
		$sql_plani = "SELECT avance, logro
					FROM plani
					WHERE id_plani = $id_plani AND
					      esta_oculta = FALSE;";
		if ($result_plani = @pg_Exec($conn, $sql_plani)){
			if (pg_numrows($result_plani) != 0){
				if ($plani_a_editar = @pg_fetch_array($result_plani, 0, PGSQL_ASSOC)){
				}
				else salida_abrupta("Error 100");
			}
			else salida_abrupta("Error 200");
		}
		else salida_abrupta("Error 300");
		?>
		<table width="80%" align="center" border="1" cellpadding="0" cellspacing="0" bordercolor="#cccccc">
			<tr>
				<td>
					<form name="form_avance" id="form_avance">
					<p class="titulo2">Editar Avance/Logro</p>
					<table>
						<tr class="planis">
							<td width="35%">&nbsp;&nbsp;Porcentaje de Avance:</td>
							<td><input type="text" name="text_avance" id="text_avance" size=2 value="<?php echo $plani_a_editar['avance'] ?>">&nbsp;%</td>
						</tr>
						<tr class="planis">
							<td width="35%">&nbsp;&nbsp;Porcentaje de Logro:</td>
							<td><input type="text" name="text_logro" id="text_logro" size=2 value="<?php echo $plani_a_editar['logro'] ?>">&nbsp;%</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type='hidden' name='id_plani' id='id_plani' value='<?php echo $id_plani; ?>'>
								<input type='hidden' name='id_ramo' id='id_ramo' value='<?php echo $id_ramo; ?>'>
								&nbsp;&nbsp;<input type="submit" value="Actualizar valores" onclick="fadeIt('div_plani','planis_form_avance_logro.php?id_plani=<?php echo $id_plani; ?>&avance='+document.form_avance.text_avance.value+'&logro='+document.form_avance.text_logro.value); return false;"/>
							</td>
						</tr>
					</table>
					</form>
				</td>
			</tr>
		</table>
		<?php
	}
	pg_close($conn);
?>
