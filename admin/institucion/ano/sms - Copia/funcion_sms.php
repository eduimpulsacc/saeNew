<?
require_once "../../../clases/soap/lib/nusoap.php";

function Envio_SMS($celular,$mensaje){
			
	$client = new nusoap_client('http://ida.itdchile.cl/services/smsApiService?wsdl','wsdl');
	$error = $client->getError();
	if ($error) {
		$mensajes =  "<h2>Error constructor:</h2><pre>" . $error . "</pre>";
	}
	$result = $client->call("sendSms", array(
							"in0" => "cinteractivo",
							"in1" => "cin123",
							"in2" => "56".trim($celular),
							"in3" => $mensaje
							));
		
	if ($client->fault) {
		$mensaje = "<h2>Falla:</h2><pre>" . print_r($result) . "</pre>";
	}else{
		$error = $client->getError();
		if ($error) {
			$mensaje = "<h2>Error:</h2><pre>" . $error . "</pre>";
		}else{
			/*echo '<script>alert("Mensaje enviado")</script>';*/
			/*echo "<pre>";
			print_r($result);
			echo "</pre>";*/
			$recscar = $result['out']['entry'][1]['value']."_".$result['out']['entry'][2]['value'];
			return $recscar;
			
	
		}
	}
}

function EstadoMsg($id){
	
	$client = new nusoap_client('http://ida.itdchile.cl/services/smsApiService?wsdl','wsdl');
	$error = $client->getError();
	if ($error) {
		$mensajes =  "<h2>Error constructor:</h2><pre>" . $error . "</pre>";
	}
	$result = $client->call("smsStatus", array(
							"in0" => "cinteractivo",
							"in1" => "cin123",
							"in2" => $id
							));
		
	if ($client->fault) {
		$mensaje = "<h2>Falla:</h2><pre>" . print_r($result) . "</pre>";
	}else{
		$error = $client->getError();
		if ($error) {
			$mensaje = "<h2>Error:</h2><pre>" . $error . "</pre>";
		}else{
			/*echo "mensaje enviado";
			echo "<pre>";
			print_r($result);
			echo "</pre>";
			echo "a->".*///$entrega = substr($result['out']['entry'][1]['value'], 0, -2);
			$recscar = $result['out']['entry'][1]['value']."_".$result['out']['entry'][3]['value'];
			
			return $recscar;
			
			
	
		}
	}
}
?>