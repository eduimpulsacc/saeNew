<?php 
require('../../../../../../util/header.inc');

foreach($_POST as $nombre_campo => $valor){
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion);
}


$sql="update archivo_alumno set visto=1 where id_carga=$ida";
$result = pg_exec($conn,$sql);
?>
