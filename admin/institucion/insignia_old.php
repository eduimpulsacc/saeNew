<?php 
	require('../../util/header.inc');
	$institucion	=$_INSTIT;

?>
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
	<body bgcolor="#ffffff">
	<title>Agregar Insignia</title>
		<table border="0" cellpadding="0" cellspacing="1" width="352" bgcolor="#000033">
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="1" width="350" bgcolor="white">
						<tr>
							<td class="tableindex">INGRESAR&nbsp;INSIGNIA</td>
						</tr>
						<tr>
							<td align="center" class="cuadro01">
								<form action="insertainsginst.php?rdb_=<?php echo $institucion ?>" method="post" enctype="multipart/form-data">
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