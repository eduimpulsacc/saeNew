<?php 

include_once('mod_ficha_alumno.php');
?>
<html>
	<head>
		<title>Agregar Imagen</title>
	
<link href="../../../../../../<?=$estilo?>" rel="stylesheet" type="text/css">
</head>
	<body bgcolor="#ffffff" onResize="0">
<form action="insertaFoto.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="swfoto" value="<?=$swfoto ?>">
		<table border="0" cellpadding="0" cellspacing="1" width="352" bgcolor="#000033" align="center">
			<tr><td>
				<table border="0" cellpadding="0" cellspacing="1" width="350" bgcolor="white">
						<tr>
							<td class="tableindex" colspan="2">Ingresar&nbsp;Foto</td>
						</tr>
						<tr>
							<td align="center" class="cuadro02">Imagen: </td>
							<td class="cuadro01"><input name="upload_file" type="file" id="upload_file"></td>
						</tr>
						<tr>
							<td class="cuadro01" colspan="2"><center>
								<input  type=hidden name=rut value=<?php echo $rut ?> ><br>
								<input class="botonXX"  type=submit value=ENVIAR>
								<input class="botonXX"  type=BUTTON value=CANCELAR onClick="window.close()">
								</center>
							</td>
						</tr>
			</table>
		</td>
	</tr></table>	</form>
<p></p>
<? pg_close($conn); ?>
</body></html>