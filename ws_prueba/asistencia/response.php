<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

?>
<?php 
include_once '../lib/nusoap.php';
$cliente = new nusoap_client("http://192.168.100.91/sae3.0/ws_prueba/asistencia/ws.php?wsdl",'wsdl');
$rdb=$_POST['rdb'];
$ano=$_POST['ano'];
$curso=$_POST['curso'];
$mes=$_POST['mes'];
$parametros = array('rdb'=>$rdb,'ano'=>$ano,'mes'=>$mes,'curso'=>$curso);
$respuesta = $cliente->call('arbolAsistencia',$parametros);
/*echo "<pre>";
print_r($respuesta);
echo "</pre>";*/
header("Content-Type: text/xml\r\n "); 
echo $cliente->responseData;

?>