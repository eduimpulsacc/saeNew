<?php require('../../../../../util/header.php'); ?>
<html>
	<head>
		<title>Ejemplo Grafico Estadistico II: PHP + FusionCharts </title>
		<script language="JavaScript" type="text/javascript" src="js/ajax.js"></script>		
	</head>
	<body>
		<table>
			<tr>
				<td>
					<div id="maestro_chart">
						<?php include("graficos/grafico1.php"); ?>
					</div>
				</td>
				<td>
					<div id="detalle_chart" style="display:none;"></div>
				</td>
			</tr>
			<tr>
				<td>
					Click en el gráfico 1 para ver el detalle.<br>
					Los datos del Grafico detalle dependeran de la barra<br>
					seleccionada en el grafico maestro.
				</td>
			</tr>
		</table>	
	</body>
</html>