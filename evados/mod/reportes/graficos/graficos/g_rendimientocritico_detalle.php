<?php

include ("funciones_php/FusionCharts.php");

$titulo = $_POST['anio'];
$semestre1 = $_POST['semestre1'];
$semestre2 = $_POST['semestre2'];

$strXML = "";

$strXML = "<chart caption = 'Grafico Detalle ".$titulo."' 
 baseFontSize='12'>";

$strXML .= "<set label = 'No Aprobados' value ='".$semestre1."' />";
$strXML .= "<set label = 'Aprobados' value ='".$semestre2."' isSliced='1' />";


$strXML .= "</chart>";

echo renderChartHTML("graficos/swf_charts/Pie3D.swf","",$strXML,"detalle",450,400,false);

?>