
	<body bgcolor="#ffffff">
	<title>Agregar Fotografía</title>
		<table border="0" cellpadding="0" cellspacing="1" width="352" bgcolor="#000033">
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="1" width="350" bgcolor="white">
						<tr>
							<td bgcolor="#003366"><font face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" size="1" color="white"><b>Ingresar&nbsp;Foto</b></font></td>
						</tr>
						<tr>
							<td align="center">
								<form action="insertafotonoticia.php" method="post" enctype="multipart/form-data">
									Imagen: <input type=file name=upload_file><br>
									<input type=hidden name=rut value=<?php echo $rut ?> >
									<input type=hidden name=agrup value=<?php echo $agrup ?> ><br>
									<input type=hidden name=id value=<?php echo $id ?> ><br>
								<input type=submit value=ENVIAR>
								<input type=BUTTON value=CANCELAR onClick="window.close()">
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