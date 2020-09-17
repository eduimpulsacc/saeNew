<?php 
include_once "lib/nusoap.php";
$cliente = new nusoap_client("http://www.colegiointeractivo.com/sae3.0/ws_prueba/servicio.php",false);
//Obtener error
$error = $cliente->getError();
if ($error) {
// Muestra Error
echo "<h2>Error</h2><pre>" . $error . "</pre>";
}
$num1=10;
$num2=4;
$parametros = array('num1'=>$num1,'num2'=>$num2);
$respuesta = $cliente->call('MiFuncion',$parametros);
print_r($respuesta);
?>