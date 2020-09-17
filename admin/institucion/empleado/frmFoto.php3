<html>
	<head>
		<title>Agregar Imagen</title>
		<link href="../../../estilos.css" rel="stylesheet" type="text/css">
	</head>
	<body bgcolor="#ffffff">
		<table border="0" cellpadding="0" cellspacing="1" width="352" bgcolor="#000033">
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="1" width="350" bgcolor="white">
						<tr>
							<td class="tableindex"><b>Ingresar&nbsp;Foto</b></td>
						</tr>
						<tr>
							<td align="center" class="datosB">
								<form action="insertaFoto.php3" method="post" enctype="multipart/form-data">
									Imagen: <input name=upload_file type=file >
									<br>
									<input type=hidden name=rut value=<?php echo $rut ?> ><br>
								<input type=submit class="botonXX" value=ENVIAR>
								<input type=BUTTON class="botonXX" onClick="window.close()" value=CANCELAR>
								</form>
						  </td>
						</tr>
				  </table>
				</td>
			</tr>
		</table>
		<p></p>
	</body>
</html>