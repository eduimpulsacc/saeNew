<?php  
$url="http://www.colegiointeractivo.cl/sae3.0/admin/institucion/ano/reportes/printInformePlanillaNotasFinales_C.php"; // url de la pagina que queremos obtener  
$url_content = '';  
$file = @fopen($url, 'r');  
if($file){  
  while(!feof($file)) {  
    $url_content .= @fgets($file, 4096);  
  }  
  echo  $url_content;
  fclose ($file); 
  echo "si"; 
}  
?> 