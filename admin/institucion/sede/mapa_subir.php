<?php 
	require('../../util/header.inc');
	$institucion	=$_INSTIT;

?>
	<body bgcolor="#ffffff">
	<title>Agregar Mapa</title>
		<table border="0" cellpadding="0" cellspacing="1" width="352" bgcolor="#000033">
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="1" width="350" bgcolor="white">
						<tr>
							<td bgcolor="#003366"><font 
face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" size="1" color="white"><b>INGRESAR&nbsp;MAPA </b></font></td>
						</tr>
						<tr>
							<td align="center">
								<form action="insertamapa.php?rdb_=<?php echo $institucion ?>" method="post" enctype="multipart/form-data">
									Imagen: <input type=file name=upload_file><br>
									<input type=hidden name=rut value=<?php echo $rut ?> ><br>
								<input type=submit value=Enviar>
								<input type=BUTTON value=Cancelar onClick="window.close()">
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