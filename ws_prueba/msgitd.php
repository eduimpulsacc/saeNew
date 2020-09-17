<?php include_once 'lib/nusoap.php';


	
	$client = new nusoap_client('http://ida.itdchile.cl/services/smsApiService?wsdl','wsdl');
	$error = $client->getError();
	if ($error) {
		$mensajes =  "<h2>Error constructor:</h2><pre>" . $error . "</pre>";
	}
	$result = $client->call("smsStatus", array(
							"in0" => "cinteractivo",
							"in1" => "cin123",
							"in2" => "8ca287d8-1c65-453a-b031-f4ffbf6e1814"
							));
		
	if ($client->fault) {
		$mensaje = "<h2>Falla:</h2><pre>" . print_r($result) . "</pre>";
	}else{
		$error = $client->getError();
		if ($error) {
			$mensaje = "<h2>Error:</h2><pre>" . $error . "</pre>";
		}else{
			/*echo "mensaje enviado";*/
			echo "<pre>";
			print_r($result);
			echo "</pre>";
			echo "a->".$entrega = $result['out']['entry'][0]['value'];
			/*$recscar = $result['out']['entry'][1]['value']."_".$result['out']['entry'][3]['value'];
			
			return $recscar;*/
			
			
	
		}
	}

?>