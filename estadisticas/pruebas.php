<?php

include ("FusionCharts.php");

$valores[0][0]="enero";
$valores[0][1]="febrero";
$valores[0][2]="marzo";
$valores[0][3]="abril";
$valores[0][4]="mayo";

$valores[1][0]=150000;
$valores[1][1]=200000;
$valores[1][2]=900000;
$valores[1][3]=18970;
$valores[1][4]=333666;

$valores[2][0]="111111";
$valores[2][1]="333333";
$valores[2][2]="aaaaaa";
$valores[2][3]="ffffff";
$valores[2][4]="333666";


$strXML = "<graph caption='titulo general' xAxisName='Valores mensuales' yAxisName='Valor Gasto' decimalPrecision='0' formatNumberScale='0'>";
echo  $strXML;





$colorea = "333fff";
$maxgru = 4;
$ancho=800;


for ($abajo=0;$abajo<=($maxgru);$abajo++)
{
     // se grarfica imprime
     $nomest=$valores[0][$abajo];
     $cantid=$valores[1][$abajo];
     $colorea=$valores[2][$abajo];
     $strXML .= "<set name='$nomest' value='$cantid' color='$colorea' />";
}
 $strXML .= "</graph>";
echo  $strXML;

   echo renderChartHTML("FusionCharts/FCF_Column3D.swf", "", $strXML, "myNext", $ancho, 300);

//echo renderChartHTML("../../FusionCharts/FCF_Pie2D.swf", "", $strXML, "myNext", $ancho, 300);

//echo renderChartHTML("FusionCharts/FCF_Column3D.swf", "", $strXML, "myNext", $ancho, 300);

?>