<?php 
include_once '../lib/nusoap.php';
$cliente = new nusoap_client("http://34.206.29.44/sae3.0/ws_prueba/basico/servicio.php",false);
$num1=4;
$num2=5;
$parametros = array('num1'=>$num1,'num2'=>$num2);
$respuesta = $cliente->call('MiFuncion',$parametros);
//header("Content-type: text/xml");
//print_r($respuesta);
if ($cliente->fault) {
		$mensaje = "<h2>Falla:</h2><pre>" . print_r($respuesta) . "</pre>";
	}else{
		$error = $cliente->getError();
		if ($error) {
			$mensaje = "<h2>Error:</h2><pre>" . $error . "</pre>";
		}else{
			echo "mensaje enviado";
			echo "<pre>";
			print_r($respuesta);
			echo "</pre>";
			
			
			
	
		}
	}

?>