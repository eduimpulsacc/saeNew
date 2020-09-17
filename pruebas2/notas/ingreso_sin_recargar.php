<?php
$conn=pg_connect("dbname=coe_traspaso host=200.2.201.33 port=1550 user=postgres password=cole#newaccess") or die ("No puede conectarme");
$sql="select * from notas2007 where id_ramo = '119640' and rut_alumno = '19703862'";
$res_sql = pg_Exec($conn, $sql);
$fil_sql = pg_fetch_array($res_sql,0);

// Capturo los valores de la DB para mostrarlos apenas se carga la pagina
$campo1=$fil_sql['nota1'];
$campo2=$fil_sql['nota2'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>AJAX, Ejemplos: Ingreso a base de datos, codigo fuente - ejemplo</title>
<link rel="stylesheet" type="text/css" href="ingreso_sin_recargar.css">
<script type="text/javascript" src="ingreso_sin_recargar.js"></script>
</head>

<body>
			
<div id="demo" style="width:20px;">
	<div id="demoArr" onclick="creaInput(this.id, 'campo1')"><?=$campo1;?></div>
	<div id="demoAba" onclick="creaInput(this.id, 'campo2')"><?=$campo2;?></div>
	<div class="mensaje" id="error"></div>
</div>
			
</body>
</html>