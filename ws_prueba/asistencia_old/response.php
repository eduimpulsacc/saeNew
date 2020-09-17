<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

?>
<?php 
include_once '../../admin/clases/soap/lib/nusoap.php';

$cliente = new nusoap_client('http://190.196.143.174/sae3.0/ws_prueba/asistencia/ws.php?wsdl' , 'wsdl'); 
echo "<pre>";
print_r($cliente);
echo "</pre>";     
    $datos_persona_entrada = array( "datos_persona_entrada" => array(    
                                                                    'nombre'    => "claudia.",
                                                                    'email'     => "ealpizar@ticosoftweb.com",
                                                                    'telefono'  => "8700-5455",
                                                                    'ano_nac'   => 1980)
                                                                    );
 
    $resultado = $cliente->call('calculo_edad',$datos_persona_entrada);
     
    print_r($resultado);

//echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
//echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
?>