<?php

$conn=@pg_connect("dbname=cft_coi host=localhost port=1550 user=postgres password=300600");
	if (!$conn) {
	 error('<b>ERROR:</b>No se puede conectar a la base de datos.(1)');
	 exit;
	}
	
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


 $id_carrera = $_POST['id_carrera'];
 $nombre_carrera = $_POST['nombre_carrera'];

$strXML = "";

$sql = "SELECT
cr.id_carrera,
cr.nombre as nombre_carrera,
c.id_curso,
c.nombre as nombre_curso,
round(sum(cast(n.promedio as INTEGER)) / count( case when n.promedio is not null then 1 end )) as promedio_curso
FROM carrera cr 
INNER JOIN curso c ON c.id_carrera = cr.id_carrera 
INNER JOIN tiene2010 t ON t.id_curso = c.id_curso 
INNER JOIN alumno a ON a.rut_alumno = t.rut_alumno 
INNER JOIN matricula m ON m.rut_alumno = a.rut_alumno AND m.id_curso = t.id_curso
INNER JOIN ramo r ON r.id_ramo = t.id_ramo 
INNER JOIN incluye i ON i.id_subsector = r.cod_subsector --AND i.semestre = 1 
INNER JOIN notas2010 n ON n.rut_alumno = a.rut_alumno AND n.id_ramo = t.id_ramo 
LEFT JOIN promedio_sub_alumno p ON p.rut_alumno = a.rut_alumno AND p.id_ramo = r.id_ramo
where cr.id_carrera = $id_carrera group by 1,2,3,4 order by 1";

$r = @pg_exec($conn,$sql);

$fila = @pg_fetch_array($r,0); 

$strXML = "<chart palette='3' shownames='1' showvalues='0' decimals='0' lineThickness='2'
rotateNames='1' slantLabels='1'   
caption = 'Grafico Secciones de la Carrera :".InicialesSubsector(trim($fila['nombre_carrera']))." ' 
xAxisName='Secciones' 
yAxisName='Notas' 
showValues='1' decimals='0' formatNumberScale='0' yAxisMaxValue='70' chartRightMargin='30' >";

for( $i=0 ; $i < @pg_numrows($r) ; $i++ ){

$fila = @pg_fetch_array($r,$i); 

//$link = urlencode("\"javascript:detalleAnios('".$fila['id_curso']."','".$fila['nombre_curso']."');\"");

$strXML .= "<set label ='".trim($fila['nombre_curso'])."' value = '".$fila['promedio_curso']."' />";

  }

$strXML .= "</chart>";

echo renderChartHTML("graficos/swf_charts/Column2D.swf","",$strXML,"detalle",500,400,false);

 ?>
