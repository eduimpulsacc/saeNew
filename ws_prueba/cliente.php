<?php 
include_once '../lib/nusoap.php';
$cliente = new nusoap_client("http://app.colegiointeractivo.cl/sae3.0/ws_prueba/basico/servicio.php",false);
$num1=4;
$num2=5;
$parametros = array('num1'=>$num1,'num2'=>$num2);
$respuesta = $cliente->call('MiFuncion',$parametros);
print_r($respuesta);


?>