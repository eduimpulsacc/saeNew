<?php 
$cad='<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:urn="urn:wsdlAsistencia">
   <soapenv:Header/>
   <soapenv:Body>
      <urn:arbolAsistencia soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
         <rdb xsi:type="xsd:integer">9105</rdb>
         <ano xsi:type="xsd:integer">2016</ano>
         <ensenanza xsi:type="xsd:integer">110</ensenanza>
         <grado xsi:type="xsd:integer">2</grado>
         <letra xsi:type="xsd:string">B</letra>
         <mes xsi:type="xsd:integer">04</mes>
      </urn:arbolAsistencia>
   </soapenv:Body>
</soapenv:Envelope>';



$p = xml_parser_create();
xml_parse_into_struct($p, $cad, $vals, $index);
xml_parser_free($p);
echo "Index array\n";
print_r($index);
echo "<br><br><br>";
echo "\nVals array\n<pre>";
print_r($vals);
echo "</pre>";
$rdb= $vals[5]['value'];
$ano = $vals[7]['value'];
$ensenanza= $vals[9]['value'];
$grado= $vals[11]['value'];
$letra= $vals[13]['value'];
$mes= $vals[15]['value'];

echo $sql_ins="select * from institucion where rdb=".$rdb." and secret='$secret'";

 ?>