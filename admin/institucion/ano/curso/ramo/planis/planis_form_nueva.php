<?php
	$_RAMO = $GET['id_ramo'];
	session_start(); 	
	$_SESSION['postid'] = md5(uniqid(rand(), true));
	$id_ramo = $_GET['id_ramo'];
?>
<table width="80%" align="center" border="1" cellpadding="0" cellspacing="0" bordercolor="#cccccc">
	<tr>
		<td>
			<form method="post" action="planis_nueva.php">
			<p class="titulo1">Crear nueva planificaci&oacute;n</p>
			<p class="titulo2">&nbsp;Paso # 1 - Res&uacute;men de la Planificaci&oacute;n</p>
			<table width="100%" border="0" cellpadding="0" cellspacing="2">
				<tr class="planis">
					<td height="30">&nbsp;&nbsp;Nombre:</td>
					<td colspan="3"><label><input name="text_nombre" id="text_nombre" type="text" size="50"></label></td>
				</tr>
				<tr class="planis">
					<td height="70">&nbsp;&nbsp;Descripci&oacute;n:</td>
					<td colspan="3"><label><textarea name="text_descripcion" id="text_descripcion" cols="50" rows="3"></textarea></label></td>
				</tr>
				<tr class="planis">
					<td>&nbsp;&nbsp;Tipo de planificaci&oacute;n:&nbsp;&nbsp;</td>
					<td><p><label><select name="select_tipo" id="select_tipo">
						<option value="10">V Heur&iacute;stica</option>
						<option value="20">Tipo T</option>
						<option value="30">de Trayecto</option>
						</select></label></p></td>
					<td align="right">Momento pedag&oacute;gico:&nbsp;</td>
					<td align="left"><p><label><select name="select_momento" id="select_momento">
						<option value="30">Clase</option>
						<option value="20">Unidad</option>
						<option value="10">Anual</option></label>
						</select><label></p></td>
				</tr>
			</table>
			<?php
				// chequea doble post
			    echo "<input type='hidden' name='postID' id='postID' value='".$_SESSION['postid']."'>";
			    // compatibilidad con otros perfiles
			   	echo "<input type='hidden' name='id_ramo' id='id_ramo' value='".$id_ramo."'>";
			?>
		<p class="titulo2">&nbsp;Ir al paso # 2: Detalle de la Planificaci&oacute;n <input type="submit" value="Continuar"/></p>
			</form>
		</td>
	</tr>
</table>