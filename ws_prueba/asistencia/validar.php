<?php

 
$rdb=$_POST['rdb'];
$ano=$_POST['ano'];
$ensenanza=$_POST['ensenanza'];
$grado=$_POST['grado'];
$letra=$_POST['letra'];
$mes=$_POST["mes"];



$url = "http://190.196.143.174/sae3.0/ws_prueba/asistencia/ws.php?wsdl";

/*$cad='<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:wsdlAsistencia">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:arbolAsistencia soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <rdb xsi:type="xsd:integer">'.$rdb.'</rdb>
         <ano xsi:type="xsd:integer">'.$ano.'</ano>
         <ensenanza xsi:type="xsd:integer">'.$ensenanza.'</ensenanza>
         <grado xsi:type="xsd:integer">'.$grado.'</grado>
         <letra xsi:type="xsd:string">'.$letra.'</letra>
         <mes xsi:type="xsd:integer">'.$mes.'</mes>
      </urn:arbolAsistencia>
   </soapenv:Body>
</soapenv:Envelope>';
*/
 
include_once '../lib/nusoap.php';
$cliente = new nusoap_client($url,'wsdl');

//$parametros = array('cad'=>$cad);
$parametros = array('rdb'=>$rdb,'ano'=>$ano,'ensenanza'=>$ensenanza,'grado'=>$grado,'letra'=>$letra,'mes'=>$mes);
$arbol = $cliente->call('arbolAsistencia',$parametros);
$cliente->call('arbolAsistencia',$parametros);
/*$file=fopen(date("Y-m-d_H-i-s").'asistencia_consulta.xml',"w+"); 
  fwrite ($file,$cliente->responseData); 
  fclose($file); */
 /* if (file_put_contents ('./datadd.xml', $cliente->responseData) !== false) {
     echo 'Success!';
} else {
     echo 'Failed';
}*/

//header("Content-Type: text/xml\r\n "); 
header("Content-type: text/xml");
echo $cliente->responseData;
//echo "pase";





?>

