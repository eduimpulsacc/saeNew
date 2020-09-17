<?
require('../../../../util/header.php');

$funcion=$_POST['funcion'];

require "mod_sms.php";
$ob_sms = new Sms();


if($funcion==1){
	$rs_curso = $ob_sms->Curso($conn,$_ANO);
	?>
   <select name="cmbCURSO" id="cmbCURSO" onChange="BuscaApoderado()">
        <option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_curso);$i++){
                $fila_c=pg_fetch_array($rs_curso,$i);
        ?>
        <option value="<?=$fila_c['id_curso'];?>"><?=CursoPalabra($fila_c['id_curso'],0,$conn);?></option>
        <? } ?>
</select>
<?	
}
if($funcion==2){
	$rs_apoderado = $ob_sms->BuscaApoderado($conn,$curso);
?>
<select name="cmbAPODERADO" id="cmbAPODERADO" onchange="Listado()">
<option value="0">seleccione...</option>
<? for($i=0;$i<pg_numrows($rs_apoderado);$i++){
		$fila=pg_Fetch_array($rs_apoderado,$i);
?>
	<option value="<?=$fila['rut_apo'];?>"><?=$fila['nombre_apoderado'];?></option>
<? } ?>
</select>
<? for($i=0;$i<pg_numrows($rs_apoderado);$i++){
			$fila = pg_Fetch_array($rs_apoderado,$i);
			echo "<br>";
			echo "Apoderado: ".$fila['nombre_apoderado']." celular: ".$fila['celular'];
			
	}

}

if($funcion==4){
	echo $nro_ano = $ob_sms->Ano($conn,$_ANO);
}
if($funcion==5){
$rs_apoderado = $ob_sms->BuscaApoderado($conn,$curso);
/*
Cliente de prueba para el servicio web getListaAplicaciones que ofrece Edugestor.
*/
//require_once "../../../../ws_prueba/lib/nusoap.php";
require_once "../../../clases/soap/lib/nusoap.php";
$mostrar = 0;

if (!empty($_POST)) {
	show($_POST);
	
    //$client = new nusoap_client('http://smpp2.telecochile.cl:4046/?wsdl','wsdl');
	 $client = new nusoap_client('http://ida.itdchile.cl/services/smsApiService?wsdl','wsdl');

    $error = $client->getError();
    if ($error) {
        $mensaje =  "<h2>Error constructor:</h2><pre>" . $error . "</pre>";
    }

	/*$xmlSms='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tel="telecochile">
			   <soapenv:Header/>
			   <soapenv:Body>
				  <tel:submitMsg>
					 <tel:clientid>clsms</tel:clientid>
					 <tel:clientpassword>col20inter16</tel:clientpassword>
					 <tel:ani>56973331374</tel:ani>
					 <tel:dnis>56973331374</tel:dnis>
					 <tel:message>hola mensaje</tel:message>
				  </tel:submitMsg>
			   </soapenv:Body>
			</soapenv:Envelope>';

		$result = $client->call('submitMsg',$xmlSms,'http://smpp2.telecochile.cl:4046/?wsdl','http://smpp2.telecochile.cl:4046/?wsdl');*/

   /* $result = $client->call("submitMsg", array(
        "clientid" => "clsms",
        "clientpassword" => "col20inter16",
        "ani" => "56973331374",
        "dnis" => "56973331374",
        "message" => "prueba de mensaje de sistema coi"
       
    ));
	*/
	for($i=0;$i<pg_numrows($rs_apoderado);$i++){
		$fila=pg_Fetch_array($rs_apoderado,$i);
	 	$result = $client->call("sendSms", array(
        "in0" => "cinteractivo",
        "in1" => "cin123",
        "in2" => "569".$fila['celular'],
        "in3" => "Estimado(a) ".$fila['nombre_apoderado']." esta es una prueba de mensaje masivo de sistema coi con ITD, favor confirmar al whatsapp que llego bien"
       
    ));
	}

    if ($client->fault) {
        $mensaje = "<h2>Falla:</h2><pre>" . print_r($result) . "</pre>";
    }
    else {
        $error = $client->getError();
        if ($error) {
            $mensaje = "<h2>Error:</h2><pre>" . $error . "</pre>";
        }
        else {
            echo "se supone que pase<br>";
			print_r($result);
        }
    }
	if ($client->fault) {
			echo '<pre>';
			echo '<h2>Fault 1</h2><pre>';
			print_r($result);
			echo '</pre>';
		
		} else {
		
			$err = $client->getError();
			
			if ($err) {
				echo '<h2>Error2</h2><pre>'.$err.'</pre>';
			} else {
				echo '<h2>Result</h2><pre>';
				print_r($result);
				
			
			}
		
		}
}

}
?>

