<script type="text/javascript" src="graficos/js/ajax.js"></script>


<script type="text/javascript">

function detalleAnios(anio,semestre1,semestre2) {
	
	detalleDiv = document.getElementById('detalle_chart');
	detalleDiv.innerHTML = "";
	ajax = objetoAjax();
	ajax.open("POST","graficos/g_rendimientocritico_detalle.php");
	ajax.onreadystatechange = function() {
		
		if(ajax.readyState == 4) {
			
				detalleDiv.innerHTML = ajax.responseText
				detalleDiv.style.display="block";
				
		}
	
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	ajax.send("anio="+anio+"&semestre1="+semestre1+"&semestre2="+semestre2)
}

</script>

<?php
include ("funciones_php/FusionCharts.php");

$intTotalAnio0 = 216;
$intTotalAnio1 = 168;
$intTotalAnio2 = 48;

$strXML = "";

$strXML = "<chart caption = 'Grafico Rendimineto Critico' xAxisName='Week' yAxisName='Sales' >";

$linkAnio1 = urlencode("\"javascript:detalleAnios('Total Alumnos','100','100');\"");
$linkAnio1 = urlencode("\"javascript:detalleAnios('Aprobados','100','100');\"");
$linkAnio2 = urlencode("\"javascript:detalleAnios('Reprobados','200','50');\"");

$strXML .= "<set label = 'Total Alumnos' value ='".$intTotalAnio0."' color = '6D8D16' link = ".$linkAnio1." />";
$strXML .= "<set label = 'Aprobados' value ='".$intTotalAnio1."' color = '0000FF' link = ".$linkAnio1." />";
$strXML .= "<set label = 'Reprobados' value ='".$intTotalAnio2."' color = 'EA1000' link = ".$linkAnio2." />";

$strXML .= "</chart>";

echo renderChartHTML("graficos/swf_charts/Column3D.swf","",$strXML,"maestro_chart",450,400,false);

?>




