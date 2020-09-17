<?php
	require('../../../../../../util/header.inc');

function salida_abrupta($mensaje){
//  echo "<script>window.location = 'http://intranet.colegiointeractivo.com/sae3.0/session/finSession.php'";
	echo "<script language=\"javascript\" type=\"text/javascript\">
						alert(\"{$mensaje}\");
						</script>";	
	echo "<script>window.close()</script>";
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
	if (!($id_plani && $_CURSO && $_ANO && $_INSTIT && $_USUARIO)){
		salida_abrupta("Llame al servicio técnico");
	} else {
		$curso			= $_CURSO;
		$ano			= $_ANO;
		$institucion	= $_INSTIT;
		$usuario		= $_USUARIO;
	}

	/*
	TO DO: verificar permisos de lectura de las planis	
	*/
		
	//------------------------
	// obtener tipo de plani
	//------------------------
	$sql_plani = "SELECT nombre,
					       descripcion,
					       to_char(fecha_inicio, 'DD') as inicio_dia,
					       to_char(fecha_inicio, 'MM') as inicio_mes,
					       to_char(fecha_inicio, 'YYYY') as inicio_ano,
					       to_char(fecha_fin, 'DD') as fin_dia,
					       to_char(fecha_fin, 'MM') as fin_mes,
					       to_char(fecha_fin, 'YYYY') as fin_ano,
						   to_char(fecha_abordaje, 'DD') as abor_dia,
					       to_char(fecha_abordaje, 'MM') as abor_mes,
					       to_char(fecha_abordaje, 'YYYY') as abor_ano,
					       avance,
					       logro
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
			<form method="post" name="form_detalles" id="form_detalles" action="planis_editar.php">
			<p class="titulo1">Editar planificaci&oacute;n</p>
			<p class="titulo2">&nbsp;Paso # 1 - Res&uacute;men de la Planificaci&oacute;n</p>
			<table width="100%" border="0" cellpadding="0" cellspacing="2">
				<tr class="planis">
					<td width="150" height="30">&nbsp;&nbsp;Nombre</td>
					<td><label><input name="text_nombre" id="text_nombre" type="text" size="50" value="<?php echo $plani_a_editar['nombre']; ?>"></label></td>
				</tr>
				<tr class="planis">
					<td height="70">&nbsp;&nbsp;Descripci&oacute;n</td>
					<td><label><textarea name="text_descripcion" id="text_descripcion" cols="50" rows="3"><?php echo $plani_a_editar['descripcion']; ?></textarea></label></td>
				</tr>
			</table>
			<p class="titulo2">&nbsp;Paso # 2 - Detalle de la planificaci&oacute;n</p>
			<table>
              <tr class="planis">
                <td width="35%">&nbsp;&nbsp;Per&iacute;odo de aplicaci&oacute;n:</td>
                <td>desde el&nbsp;</td>
                <td onclick="cal1.showCalendar('text_fecha_inicio'); return false;" name="text_fecha_inicio" id="text_fecha_inicio"><input type="text" name="text_dia_inicio" id="text_dia_inicio" size=1 value="<?php echo $plani_a_editar['inicio_dia'] ?>" />
                    <input type="text" name="text_mes_inicio" id="text_mes_inicio" size=1 value="<?php echo $plani_a_editar['inicio_mes'] ?>" />
                  <input type="text" name="text_ano_inicio" id="text_ano_inicio" size=2 value="<?php echo $plani_a_editar['inicio_ano'] ?>" /></td>
                <td>&nbsp;hasta el&nbsp;</td>
                <td onclick="cal2.showCalendar('text_fecha_fin'); return false;" name="text_fecha_fin" id="text_fecha_fin"><input type="text" name="text_dia_fin" id="text_dia_fin" size=1 value="<?php echo $plani_a_editar['fin_dia'] ?>" />
                    <input type="text" name="text_mes_fin" id="text_mes_fin" size=1 value="<?php echo $plani_a_editar['fin_mes'] ?>" />
                  <input type="text" name="text_ano_fin" id="text_ano_fin" size=2 value="<?php echo $plani_a_editar['fin_ano'] ?>" /></td>
              </tr>
              <tr class="planis">
                <td>Fecha Abordaje </td>
                <td colspan=4 onclick="cal3.showCalendar('text_fecha_abor'); return false;" name="text_fecha_abor" id="text_fecha_abor"><input type="text" name="text_dia_abor" id="text_dia_abor" size=1 value="<?php echo $plani_a_editar['abor_dia'] ?>" />
                    <input type="text" name="text_mes_abor" id="text_mes_abor" size=1 value="<?php echo $plani_a_editar['abor_mes'] ?>" />
                  <input type="text" name="text_ano_abor" id="text_ano_abor" size=2 value="<?php echo $plani_a_editar['abor_ano'] ?>" /></td>
              </tr>
              <!--<tr class="planis">
					<td width="35%">&nbsp;&nbsp;Porcentaje de Avance:</td>
					<td colspan="4"><input type="text" name="text_avance" id="text_avance" size=2 value="<?php echo $plani_a_editar['avance'] ?>">&nbsp;%</td>
				</tr>
				<tr class="planis">
					<td width="35%">&nbsp;&nbsp;Porcentaje de Logro:</td>
					<td colspan="4"><input type="text" name="text_logro" id="text_logro" size=2 value="<?php echo $plani_a_editar['logro'] ?>">&nbsp;%</td>
				</tr>-->
            </table>
			<p class="titulo2">&nbsp;Ir al paso # 3: Completar esquema de planificaci&oacute;n <input type="submit" value="Continuar"/></p>
				<input type='hidden' name='id_plani' id='id_plani' value='<?php echo $id_plani; ?>'>
				<input type='hidden' name='id_ramo' id='id_ramo' value='<?php echo $id_ramo; ?>'>
			</form>		</td>
	</tr>
</table>
