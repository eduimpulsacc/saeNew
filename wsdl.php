<?php

$wsdl_url =
  "http://soap.amazon.com/schemas3/AmazonWebServices.wsdl";
$client     = new SoapClient($wsdl_url);
var_dump($client->__getFunctions());

?>