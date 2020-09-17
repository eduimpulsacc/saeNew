	<?php
	require_once "lib/nusoap.php";
	
	
			
	$client = new nusoap_client('http://ida.itdchile.cl/services/smsApiService?wsdl','wsdl');
	$error = $client->getError();
	if ($error) {
		$mensajes =  "<h2>Error constructor:</h2><pre>" . $error . "</pre>";
	}
	$result = $client->call("smsStatus", array(
							"in0" => "cinteractivo",
							"in1" => "cin123",
							"in2" => "c43bd33c-548d-4ddd-9002-c44f9ab289b1",
							
							));
		
	if ($client->fault) {
		$mensaje = "<h2>Falla:</h2><pre>" . print_r($result) . "</pre>";
	}else{
		$error = $client->getError();
		if ($error) {
			$mensaje = "<h2>Error:</h2><pre>" . $error . "</pre>";
		}else{
			echo "mensaje enviado";
			echo "<pre>";
			print_r($result);
			echo "</pre>";
			echo "a->".$entrega = substr($result['out']['entry'][1]['value'], 0, -2);
			
			
	
		}
	}

/*Array ( [out] => 
			Array ( [entry] => 
				Array ( 
					[0] => Array ( [key] => MESSAGE [value] => MESSAGE QUEUED ) 
					[1] => Array ( [key] => ID [value] => 1585fdb2-db54-4a89-887e-48151e89d7aa ) 
					[2] => Array ( [key] => CODE [value] => 0 ) 
					)
				
				 ) 
	 )*/

?>