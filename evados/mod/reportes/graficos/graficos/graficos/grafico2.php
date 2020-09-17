<?php
// archivos incluidos. Librerías PHP para poder graficar.
include ("../funciones_php/FusionCharts.php");
// Gráfico detalle: gráfico de Torta o Círculo.
// Obtengo los parámetros enviados por javascript.
// anio, valor del semestre 1, y valor del semestre 2
$titulo = $_POST['anio'];
$semestre1 = $_POST['semestre1'];
$semestre2 = $_POST['semestre2'];
// $strXML: Para concatenar los parámetros finales para el gráfico.
$strXML = "";
// Armo los parámetros para el gráfico. Todos estos datos se concatenan en una variable.
// Encabezado de la variable XML. Comienza con la etiqueta "Chart".
// caption: define el título del gráfico. Asgno de titulo el Año que fue seleccionado en la barra.
// bgColor: define el color de fondo que tendrá el gráfico.
// baseFontSize: Tamaño de la fuente que se usará en el gráfico.
$strXML = "<chart caption = 'Grafico 2: Detalle ".$titulo."' bgColor='#CDDEE5' baseFontSize='12' >";
// Armado de cada porción del gráfico en círculo.
// set label: asigno el nombre de cada porción.
// value: asigno el valor para cada porción.
$strXML .= "<set label = 'Semestre 1' value ='".$semestre1."' />";
$strXML .= "<set label = 'Semestre 2' value ='".$semestre2."' />";
// Cerramos la etiqueta "chart".
$strXML .= "</chart>";
// Por último imprimo el gráfico.
// renderChartHTML: función que se encuentra en el archivo FusionCharts.php
// Envía varios parámetros.
// 1er parámetro: indica la ruta y nombre del archivo "swf" que contiene el gráfico. En este caso Columnas ( barras) 3D
// 2do parámetro: indica el archivo "xml" a usarse para graficar. En este caso queda vacío "", ya que los parámetros lo pasamos por PHP.
// 3er parámetro: $strXML, es el archivo parámetro para el gráfico. 
// 4to parámetro: "ejemplo". Es el identificador del gráfico. Puede ser cualquier nombre.
// 5to y 6to parámetro: indica ancho y alto que tendrá el gráfico.
// 7mo parámetro: "false". Trata del "modo debug". No es im,portante en nuestro caso, pero pueden ponerlo a true ara probarlo.
echo renderChartHTML("swf_charts/Pie3D.swf", "",$strXML, "detalle", 350, 350, false);
?>