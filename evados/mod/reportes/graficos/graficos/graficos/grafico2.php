<?php
// archivos incluidos. Librer�as PHP para poder graficar.
include ("../funciones_php/FusionCharts.php");
// Gr�fico detalle: gr�fico de Torta o C�rculo.
// Obtengo los par�metros enviados por javascript.
// anio, valor del semestre 1, y valor del semestre 2
$titulo = $_POST['anio'];
$semestre1 = $_POST['semestre1'];
$semestre2 = $_POST['semestre2'];
// $strXML: Para concatenar los par�metros finales para el gr�fico.
$strXML = "";
// Armo los par�metros para el gr�fico. Todos estos datos se concatenan en una variable.
// Encabezado de la variable XML. Comienza con la etiqueta "Chart".
// caption: define el t�tulo del gr�fico. Asgno de titulo el A�o que fue seleccionado en la barra.
// bgColor: define el color de fondo que tendr� el gr�fico.
// baseFontSize: Tama�o de la fuente que se usar� en el gr�fico.
$strXML = "<chart caption = 'Grafico 2: Detalle ".$titulo."' bgColor='#CDDEE5' baseFontSize='12' >";
// Armado de cada porci�n del gr�fico en c�rculo.
// set label: asigno el nombre de cada porci�n.
// value: asigno el valor para cada porci�n.
$strXML .= "<set label = 'Semestre 1' value ='".$semestre1."' />";
$strXML .= "<set label = 'Semestre 2' value ='".$semestre2."' />";
// Cerramos la etiqueta "chart".
$strXML .= "</chart>";
// Por �ltimo imprimo el gr�fico.
// renderChartHTML: funci�n que se encuentra en el archivo FusionCharts.php
// Env�a varios par�metros.
// 1er par�metro: indica la ruta y nombre del archivo "swf" que contiene el gr�fico. En este caso Columnas ( barras) 3D
// 2do par�metro: indica el archivo "xml" a usarse para graficar. En este caso queda vac�o "", ya que los par�metros lo pasamos por PHP.
// 3er par�metro: $strXML, es el archivo par�metro para el gr�fico. 
// 4to par�metro: "ejemplo". Es el identificador del gr�fico. Puede ser cualquier nombre.
// 5to y 6to par�metro: indica ancho y alto que tendr� el gr�fico.
// 7mo par�metro: "false". Trata del "modo debug". No es im,portante en nuestro caso, pero pueden ponerlo a true ara probarlo.
echo renderChartHTML("swf_charts/Pie3D.swf", "",$strXML, "detalle", 350, 350, false);
?>