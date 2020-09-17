<?php
/*
Cliente de prueba para el servicio web getCalificaciones que ofrece Edugestor.
*/



$xmlstr =
'<?xml version="1.0" encoding="utf-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<soapenv:Body><SalidaGetReporteEnvioAsistenciaSige xmlns="http://dido.mineduc.cl/Archivos/Schemas/">
<CodigoRespuestaReporteEnvioAsistencia>2</CodigoRespuestaReporteEnvioAsistencia><ListadoMensajes><Titulo>LISTADO DE OBSERVACIONES</Titulo>
    <Mensaje xsi:type="xsd:string">LETRA CURSO (A) RUN 21563051 RETIRADO O NO MATRICULADO.</Mensaje>
    </ListadoMensajes></SalidaGetReporteEnvioAsistenciaSige></soapenv:Body></soapenv:Envelope>';

$xml_parser = xml_parser_create();
xml_parse_into_struct($xml_parser, $xmlstr, $vals, $index);
xml_parser_free($xml_parser);




/* echo $semilla = $vals[3]['value'];*/
echo "<pre>";
var_dump($vals);
echo "</pre>";

$arm=array();
for($x=0;$x<count($vals);$x++){
if($vals[$x]['tag']=='MENSAJE'){
	$arm[]=$vals[$x]['value'];
	}
}
var_dump($arm);
?>


