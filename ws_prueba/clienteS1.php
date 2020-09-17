<?php
/*
Cliente de prueba para el servicio web getListaAplicaciones que ofrece Edugestor.
*/

error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once "lib/nusoap.php";

$base = "http://app.edugestor.com/ws/";

$mostrar = 0;

if (!empty($_POST)) {
/*	$xml = '<?xml version="1.0" encoding="utf-8"?>
    <soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:applications">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:getListaAplicaciones soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <rbd xsi:type="xsd:string">'.$_POST["rbd"].'</rbd>
         <anio xsi:type="xsd:string">'.$_POST["anio"].'</anio>
         <asignatura xsi:type="xsd:string">'.$_POST["asignatura"].'</asignatura>
         <nivel xsi:type="xsd:string">'.$_POST["nivel"].'</nivel>
         <curso xsi:type="xsd:string">'.$_POST["curso"].'</curso>
         <tipo_ensenanza xsi:type="xsd:string">'.$_POST["tipo_ensenanza"].'</tipo_ensenanza>
         <tipo_evaluacion xsi:type="xsd:string">'.$_POST["tipo_evaluacion"].'</tipo_evaluacion>
         <periodo xsi:type="xsd:string">'.$_POST["periodo"].'</periodo>
      </urn:getListaAplicaciones>
   </soapenv:Body>
</soapenv:Envelope>';

$url = $base . "api/applications.php";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

$headers = array();
array_push($headers, "Content-Type: text/xml; charset=utf-8");
array_push($headers, "Accept: text/xml");
array_push($headers, "Cache-Control: no-cache");
array_push($headers, "Pragma: no-cache");
//array_push($headers, "SOAPAction: http://api.soap.website.com/WSDL_SERVICE/GetShirtInfo");
if($xml != null) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
    array_push($headers, "Content-Length: " . strlen($xml));
}
//curl_setopt($ch, CURLOPT_USERPWD, "user_name:password"); // If required 
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);*/

/*var_dump($headers);
echo "--<br>";*/
//var_dump($response);
/*if (file_put_contents ('./data.xml', $response) !== false) {
     echo 'Success!';
} else {
     echo 'Failed';
}
*/
	
    $client = new nusoap_client($base . "api/applications.php");

    $error = $client->getError();
    if ($error) {
        $mensaje =  "<h2>Error constructor:</h2><pre>" . $error . "</pre>";
    }

    $result = $client->call("getListaAplicaciones", array(
        "rbd" => $_POST["rbd"],
        "anio" => $_POST["anio"],
        "asignatura" => $_POST["asignatura"],
        "nivel" => $_POST["nivel"],
		"curso" => $_POST["curso"],
        "tipo_ensenanza" => $_POST["tipo_ensenanza"],
        "tipo_evaluacion" => $_POST["tipo_evaluacion"],
        "periodo" => $_POST["periodo"]
    ));

    if ($client->fault) {
        $mensaje = "<h2>Falla:</h2><pre>" . print_r($result) . "</pre>";
    }
    else {
        $error = $client->getError();
        if ($error) {
            $mensaje = "<h2>Error:</h2><pre>" . $error . "</pre>";
        }
        else {
            $mostrar = 1;
			if (file_put_contents ('./data3.xml', $result) !== false) {
     echo 'Success!';
} else {
     echo 'Failed';
}

        }
    }
}
?>

<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title>Cliente SOAP - GetListaAplicaciones</title>
    </head>
    <body>
        <form method="post" action="clienteS1.php">
            <div>RBD</div>
            <div><input id='' class='' type='text' name='rbd' /></div>
            <div>Año</div>
            <div><input id='' class='' type='text' name='anio' /></div>
            <div>Asignatura</div>
            <div><input id='' class='' type='text' name='asignatura' /></div>
            <div>Nivel</div>
            <div><input id='' class='' type='text' name='nivel' /></div>
            <div>Curso</div>
            <div><input id='' class='' type='text' name='curso' /></div>
            <div>Tipo de enseñanza</div>
            <div><input id='' class='' type='text' name='tipo_ensenanza' /></div>
            <div>Tipo de evaluacion</div>
            <div><input id='' class='' type='text' name='tipo_evaluacion' /></div>
            <div>Período</div>
            <div><input id='' class='' type='text' name='periodo' /></div>
            <input type="submit" value="Buscar" id="boton"/>
        </form>
        <?php
if ($mostrar==1) {

?>
    <br/><br/><div id="aplicaciones">
        Código - Nombre <br/>
          <select name="plica" id="plica">
    <option value="0">Seleccione</option>  
    
	   <?php
            foreach ($result as $aplicacion => $val) {
				
				echo $aplicacion."-".$val;
				?>
                <option value="<?php echo $aplicacion['cod_aplicacion'] ?>"><?php echo $aplicacion['nombre'] ?></option> 
                <?
               // echo $aplicacion['cod_aplicacion'] . " - " . $aplicacion['nombre'] . ' (<a href="clienteS2.php?cod=' . $aplicacion['cod_aplicacion'] . "\">Ver calificacion</a>)<br/>";
            }
        ?>
   </select>
    </div>

<?php
} elseif (!empty($_POST)) {
   // echo $mensaje;
}
?>
   <!-- </body>
</html>-->
