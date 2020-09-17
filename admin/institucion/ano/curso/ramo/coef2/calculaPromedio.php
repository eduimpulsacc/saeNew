<?php require('../../../../../../util/header.inc');?>
<?php 

foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
 // echo $asignacion;
}

$nota2=$examen;


$prom_final = ($promedio+$examen+$nota2)/3;

if($aprox_coef2==0 || $aprox_coef2== null)
{
	echo intval($prom_final);
}
else{
	echo round($prom_final);
}




?>