<?php

 
$rdb=$_POST['rdb'];
$ano=$_POST['ano'];
$ensenanza=$_POST['tense'];
$grado=$_POST['tgrado'];
$letra=$_POST['tletra'];
$mes=$_POST["mes"];
$secret = base64_encode("semilla".$_POST['rdb']);


$url = "http://192.168.100.91/sae3.0/ws_prueba/asistencia/ws.php?wsdl";
$urls = "http://192.168.100.91/sae3.0/ws_prueba/asistencia/validasemilla.php";


 
include_once '../lib/nusoap.php';
$cliente = new nusoap_client($url,'wsdl');
$semilla = new nusoap_client($urls,false);

$parametrosSemilla = array('rdb'=>$rdb,'url'=>$urls,'secret'=>$secret);


 $respuesta = $semilla->call('ValSemilla',$parametrosSemilla);
//echo $respuesta;

if($respuesta!='0'){
	
$parametros = array('rdb'=>$rdb,'ano'=>$ano,'ensenanza'=>$ensenanza,'grado'=>$grado,'letra'=>$letra,'mes'=>$mes);
$arbol = $cliente->call('arbolAsistencia',$parametros);
$file=fopen(date("Y-m-d_H-i-s").'asistencia_consulta.xml',"w+"); 
  fwrite ($file,$cliente->responseData); 
  fclose($file); 
 /* if (file_put_contents ('./datadd.xml', $cliente->responseData) !== false) {
     echo 'Success!';
} else {
     echo 'Failed';
}*/

header("Content-Type: text/xml\r\n "); 
echo $cliente->responseData;
//echo "pase";

}else{
echo "Acceso Inv&aacute;lido";

}



?>

