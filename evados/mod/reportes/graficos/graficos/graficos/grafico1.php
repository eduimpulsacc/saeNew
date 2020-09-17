<?php
// archivos incluidos. Librer�as PHP para poder graficar.
include ("funciones_php/FusionCharts.php");
// Gr�fico de Barras. 4 Variables, 4 barras.
// Estas variables ser�n usadas para representar los valores de cada unas de las 4 barras.
// Inicializo las variables a utilizar.
$intTotalAnio1 = 310;
$intTotalAnio2 = 440;
$intTotalAnio3 = 118;
$intTotalAnio4 = 145;
// $strXML: Para concatenar los par�metros finales para el gr�fico.
$strXML = "";
// Armo los par�metros para el gr�fico. Todos estos datos se concatenan en una variable.
// Encabezado de la variable XML. Comienza con la etiqueta "Chart".
// caption: define el t�tulo del gr�fico.
// bgColor: define el color de fondo que tendr� el gr�fico.
// baseFontSize: Tama�o de la fuente que se usar� en el gr�fico.
// showValues: = 1 indica que se mostrar�n los valores de cada barra. = 0 No mostrar� los valores en el gr�fico.
// xAxisName: define el texto que ir� sobre el eje X. Abajo del gr�fico. Tambi�n est� xAxisName.
$strXML = "<chart caption = 'Grafico 1: Maestro' bgColor='#CDDEE5' baseFontSize='12' showValues='1' xAxisName='Anios' >";
// Genero los enlaces que ir� en cada barra del gr�fico.
// Llamo a una funci�n javascript llamado "detalleAnios". Tambi�n envio par�metros como el t�tulo, total en semestre 1 y total en semestre 2
// La suma de las variables total de los semestres, enviados como par�metros, es igual al total del A�o en cuesti�n.
// La funci�n javascript que recibe estos datos se encuentra en el archivo "js/ajax.js"
// La funci�n javascript, lo que hace es enviar los par�metros a un archivo llamado "grafico2.php" para que genere el gr�fico detalle.
// Una vez generado el gr�fico detalle, se desplegar� en el DIV "detalle_chart". Haci�ndose ahora visible.
$linkAnio1 = urlencode("\"javascript:detalleAnios('Anio 1','210','100');\"");
$linkAnio2 = urlencode("\"javascript:detalleAnios('Anio 2','175','265');\"");
$linkAnio3 = urlencode("\"javascript:detalleAnios('Anio 3','74','44');\"");
$linkAnio4 = urlencode("\"javascript:detalleAnios('Anio 4','50','95');\"");
// Armado de cada barra.
// set label: asigno el nombre de cada barra.
// value: asigno el valor para cada barra.
// color: color que tendr� cada barra. Si no lo defino, tomar� colores por defecto.
// Asigno los enlaces para cada barra.
$strXML .= "<set label = 'Anio 1' value ='".$intTotalAnio1."' color = 'EA1000' link = ".$linkAnio1." />";
$strXML .= "<set label = 'Anio 2' value ='".$intTotalAnio2."' color = '6D8D16' link = ".$linkAnio2." />";
$strXML .= "<set label = 'Anio 3' value ='".$intTotalAnio3."' color = 'FFBA00' link = ".$linkAnio3." />";
$strXML .= "<set label = 'Anio 4' value ='".$intTotalAnio4."' color = '0000FF' link = ".$linkAnio4." />";
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
echo renderChartHTML("swf_charts/Column3D.swf", "",$strXML, "maestro", 350, 350, false);
?>