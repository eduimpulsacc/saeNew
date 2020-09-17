<?php

require('../../../../util/header.inc');

include ("funciones_php/FusionCharts.php");

function InicialesSubsector($Subsector)
{
	$largo = strlen($Subsector);
	
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
	
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
		}
	
		$letra_query = substr($Subsector,$cont_letras,1);
	
		if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
	
		if (strlen($cadena)==6 )
			$cont_letras = $largo;
	
	}	
	
	if (strlen(trim($cadena))==1)
		return trim(strtoupper(substr($Subsector,0,3)));
	else
		return trim($cadena);
}


$strXML = "";


$sql="SELECT 
cr.id_carrera,
initcap(cr.nombre) as nombre_carrera,
round(sum(cast(n.promedio as INTEGER)) / count( case when n.promedio is not null then 1 end )) as promedio_carrera 
FROM carrera cr 
INNER JOIN curso c ON c.id_carrera = cr.id_carrera 
INNER JOIN tiene2010 t ON t.id_curso = c.id_curso 
INNER JOIN alumno a ON a.rut_alumno = t.rut_alumno 
INNER JOIN matricula m ON m.rut_alumno = a.rut_alumno AND m.id_curso = t.id_curso
INNER JOIN ramo r ON r.id_ramo = t.id_ramo 
INNER JOIN incluye i ON i.id_subsector = r.cod_subsector --AND i.semestre = 1 
INNER JOIN notas2010 n ON n.rut_alumno = a.rut_alumno AND n.id_ramo = t.id_ramo 
LEFT JOIN promedio_sub_alumno p ON p.rut_alumno = a.rut_alumno AND p.id_ramo = r.id_ramo 
group by 1,2";
$r = @pg_exec($conn,$sql);


$strXML = "<chart palette='3' caption = 'Grafico Promedios de Carreras' 
rotateNames='1' slantLabels='1' xAxisName='Carreras' yAxisName='Notas' 
showValues='1' decimals='0' formatNumberScale='0' yAxisMaxValue='70' chartRightMargin='30' >";

for( $i=0 ; $i < @pg_numrows($r) ; $i++ ){

$fila = @pg_fetch_array($r,$i); 

$link = urlencode("\"javascript:detalleAnios('".$fila['id_carrera']."','".$fila['nombre_carrera']."');\"");

$strXML .= "<set label ='".InicialesSubsector($fila['nombre_carrera'])."' value = '".$fila['promedio_carrera']."' link = ".$link." />";

   }

$strXML .= "</chart>";

echo renderChartHTML("graficos/swf_charts/Column2D.swf","",$strXML,"maestro_chart",500,400,false);



?>




