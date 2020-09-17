<?php

$client = new SoapClient('http://dido.mineduc.cl:9080/WsApiCertificados/wsdl/SemillaSoapPort.wsdl');
$clienteID=3;
$convenioID=4;
$token="TESTSIGE";
$aParametros=
$aRespuesta = $client->call("getSemillaServicios", $aParametros);
$client->getSemillaServicios('3','4','TESTSIGE');

?>
