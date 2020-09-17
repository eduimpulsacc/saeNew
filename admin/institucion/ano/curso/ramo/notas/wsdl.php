<?php


echo "INICIO";
require_once('../../../../../clases/nusoap-0.9.5/lib/nusoap.php');
echo "paso 2";

$client = new nusoap_client('http://dido.mineduc.cl:80/WsApiCertificados/wsdl/SemillaServiciosSoapPort.wsdl','wsdl');


$strXML = '<EntradaSemillaServicios xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
		  xsi:schemaLocation="http://wwwfs.mineduc.cl/Archivos/Schema/
		  EntradaSemillaServicios.xds" xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/">
		  <ClienteId></ClienteId>
		  <ConvenioId></ConvenioId>
		  <ConvenioToken></ConvenioToken>
		  </EntradaSemillaServicios>'; 


$result = $client->call('getSemillaServicios',$strXML);


print_r($result);
 
 
 
 ?>