<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');

include_once '../lib/nusoap.php';
$cliente = new soapclient("http://190.196.143.174/sae3.0/ws_prueba/p2/samples/ppp2.php",true);
$num1=4;
$num2=5;
$parametros = array('num1'=>$num1,'num2'=>$num2);
$respuesta = $cliente->call('MiFuncion',$parametros);
print_r($respuesta);


?>