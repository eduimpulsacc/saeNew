<?php
include('soap/lib/nusoap.php');

$server = new soap_server();
$server->configureWSDL('Servidor', 'urn:Servidor');

$server->register('MetodoPrueba',											// method name
    array('tcParametroA' => 'xsd:string','tcParametroB' => 'xsd:string'),	// input parameters
    array('return' => 'xsd:string'),										// output parameters
    'urn:MetodoPruebawsdl',													// namespace
    'urn:MetodoPruebawsdl#MetodoPrueba',									// soapaction
    'rpc',																	// style
    'encoded',																// use
    'Retorna el datos'														// documentation
);

function MetodoPrueba($tcParametroA,$tcParametroB) {
	return "SERVIDOR=".$_SERVER['PHP_SELF']."\n"."tcParametroA=".strtoupper($tcParametroA)."\n"."tcParametroB=".strtoupper($tcParametroB);
}

$HTTP_RAW_POST_DATA = isset($HTTP_RAW_POST_DATA) ? $HTTP_RAW_POST_DATA : '';
$server->service($HTTP_RAW_POST_DATA);
?>
