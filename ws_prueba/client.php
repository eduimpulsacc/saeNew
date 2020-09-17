<?php
include('soap/lib/nusoap.php');
$client = new nusoap_client('http://190.196.143.174/sae3.0/ws_prueba/server.php?wsdl','wsdl');
$err = $client->getError();
//$client->use_curl = TRUE;
if ($err) {
	echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
}

$param = array('tcParametroA' => 'ParametroA','tcParametroB' => 'ParametroB');
$result = $client->call('MetodoPrueba', $param);

if ($client->fault) {
	echo '<h2>Fault</h2><pre>';
	print_r($result);
	echo '</pre>';
} else {
	// Check for errors
	$err = $client->getError();
	if ($err) {
		// Display the error
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} else {
		// Display the result
		echo '<h2>Result</h2><pre>';
		print($result);
		echo '</pre>';
	}
}

echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
?>
