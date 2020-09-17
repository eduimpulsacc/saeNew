
	<body bgcolor="#ffffff">
	<title>AGREGAR MAPA</title>
		<table border="0" cellpadding="0" cellspacing="1" width="352" bgcolor="#000033">
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="1" width="350" bgcolor="white">
						<tr>
							<td bgcolor="#003366"><font face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" size="1" color="white"><b>INGRESAR&nbsp;FOTO</b></font></td>
						</tr>
						<tr>
							<td>
								<form action="insertafotonoticia.php" method="post" enctype="multipart/form-data">
									IMAGEN: <input type=file name=upload_file><br>
									<input type=hidden name=rut value=<?php echo $rut ?> ><br>
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
