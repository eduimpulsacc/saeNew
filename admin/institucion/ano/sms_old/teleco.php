<?php

function SmsTeleco($celular,$mensaje){
$xml = '<?xml version="1.0" encoding="utf-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tel="telecochile">
			   <soapenv:Header/>
			   <soapenv:Body>
				  <tel:submitMsg>
					 <tel:clientid>clsms</tel:clientid>
					 <tel:clientpassword>col20inter16</tel:clientpassword>
					 <tel:ani>56442143535</tel:ani>
					 <tel:dnis>'.trim($celular).'</tel:dnis>
					 <tel:message>'.$mensaje.'</tel:message>
				  </tel:submitMsg>
			   </soapenv:Body>
			</soapenv:Envelope>';

$url = "http://smpp2.telecochile.cl:4046/?wsdl";

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

return $response;
var_dump($response);
}

function CheckNumero($celular){
	$xml = '<?xml version="1.0" encoding="utf-8"?>
					<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tel="telecochile">
				   <soapenv:Header/>
				   <soapenv:Body>
					  <tel:checkNumber>
						 <!--Optional:-->
						 <tel:number>'.trim($celular).'</tel:number>
						 <!--Optional:-->
						 <tel:user>clsms</tel:user>
						 <!--Optional:-->
						 <tel:password>col20inter16</tel:password>
					  </tel:checkNumber>
				   </soapenv:Body>
				</soapenv:Envelope>';
	
	$url = "http://smpp2.telecochile.cl:4046/?wsdl";
	
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
	
	var_dump($headers);
	echo "--<br>";
	var_dump($response);		
}

function EstadoMsg($id){
	$xml = '<?xml version="1.0" encoding="utf-8"?>
				   <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tel="telecochile">
				   <soapenv:Header/>
				   <soapenv:Body>
					  <tel:enquireMsgStatus>
						 <!--Optional:-->
						 <tel:clientid>clsms</tel:clientid>
						 <!--Optional:-->
						 <tel:clientpassword>col20inter16</tel:clientpassword>
						 <!--Optional:-->
						 <tel:messageId>'.trim($id).'</tel:messageId>
					  </tel:enquireMsgStatus>
				   </soapenv:Body>
				</soapenv:Envelope>';
	
	$url = "http://smpp2.telecochile.cl:4046/?wsdl";
	
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
	
	var_dump($headers);
	echo "--<br>";
	var_dump($response);	
}

function Creditos(){
	$xml = '<?xml version="1.0" encoding="utf-8"?>
				   <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tel="telecochile">
				   <soapenv:Header/>
				   <soapenv:Body>
					  <tel:getMyCredits>
						 <!--Optional:-->
						 <tel:clientid>clsms</tel:clientid>
						 <!--Optional:-->
						 <tel:clientpassword>col20inter16</tel:clientpassword>
					  </tel:getMyCredits>
				   </soapenv:Body>
				</soapenv:Envelope>';
	
	$url = "http://smpp2.telecochile.cl:4046/?wsdl";
	
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
	
	var_dump($headers);
	echo "--<br>";
	var_dump($response);
}
?>