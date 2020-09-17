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
			echo "Apoderado: ".$fila['nombre_apoderado']." celular: ".$fila['celular'];
			echo "<br>";
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
	for($i=0;$i<pg_numrows($rs_apoderado);$i++){
			$fila = pg_Fetch_array($rs_apoderado,$i);
	$xml = '<?xml version="1.0" encoding="utf-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tel="telecochile">
			   <soapenv:Header/>
			   <soapenv:Body>
				  <tel:submitMsg>
					 <tel:clientid>clsms</tel:clientid>
					 <tel:clientpassword>col20inter16</tel:clientpassword>
					 <tel:ani>56442143535</tel:ani>
					 <tel:dnis>569'.$fila['celular'].'</tel:dnis>
					 <tel:message>Estimado(a) '.$fila['nombre_apoderado'].' esta es una prueba de mensaje masivo de sistema coi con ITD, favor confirmar al whatsapp que llego bien</tel:message>
				  </tel:submitMsg>
			   </soapenv:Body>
			</soapenv:Envelope>';

$url = "http://smpp2.telecochile.cl:4046/?wsdl";

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
array_push($headers, "SOAPAction: http://api.soap.website.com/WSDL_SERVICE/GetShirtInfo");
if($xml != null) {
    curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml");
    array_push($headers, "Content-Length: " . strlen($xml));
}

//curl_setopt($ch, CURLOPT_USERPWD, "user_name:password"); /* If required */
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);

$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

	}// FIN FOR
}

}
?>

