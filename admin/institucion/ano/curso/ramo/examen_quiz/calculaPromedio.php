<?php require('../../../../../../util/header.inc');?>
<?php 

foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
  
}

$porc_restante = intval(100-$porc_examen_quiz);
if(intval($examen)==0)
{$examen=$promedio;}

$prom_final = ($promedio*($porc_restante/100))+($examen*($porc_examen_quiz/100));

if($truncado_examen_quiz==0 || $truncado_examen_quiz== null)
{
	echo intval($prom_final);
}
else{
	echo round($prom_final);
}




?>