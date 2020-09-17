<?php 
$xml = '<?xml version="1.0" encoding="utf-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:sch="http://wwwfs.mineduc.cl/Archivos/Schemas/">
   <soapenv:Header/>
   <soapenv:Body>
      <sch:EntradaSemillaServicios>
         <sch:ClienteId>213</sch:ClienteId>
         <sch:ConvenioId>237</sch:ConvenioId>
         <sch:ConvenioToken>1VWizqfJYiLr</sch:ConvenioToken>
      </sch:EntradaSemillaServicios>
   </soapenv:Body>
</soapenv:Envelope>';

$url = "http://w7app.mineduc.cl/WsApiAutorizacion/services/SemillaServiciosSoapPort";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

$headers = array();
array_push($headers, "Content-Type: text/xml; charset=utf-8");
array_push($headers, "Accept: text/xml");
array_push($headers, "Cache-Control: no-cache");
array_push($headers, "Pragma: no-cache");
array_push($headers, "SOAPAction: http://api.soap.website.com/WSDL_SERVICE/GetShirtInfo");
if($xml != null) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
    array_push($headers, "Content-Length: " . strlen($xml));
}
//curl_setopt($ch, CURLOPT_USERPWD, "user_name:password"); /* If required */
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);

$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);


$xml_parser = xml_parser_create();
xml_parse_into_struct($xml_parser, $response, $vals, $index);
xml_parser_free($xml_parser);

echo "<pre>";
var_dump($vals[3]['value']);
echo "</pre>";
if (file_put_contents ('./data.xml', $response) !== false) {
     echo 'Success!';
} else {
     echo 'Failed';
}

?>