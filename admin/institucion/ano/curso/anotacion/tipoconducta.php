<?php 
require('../../../../../util/header.inc');
//var_dump($_POST);
 $q400= "select tipo
from detalle_anotaciones da, tipos_anotacion tp 
where 
tp.id_tipo = da.id_tipo
and codigo='".strtoupper($codigo)."'";

$r400 = @pg_Exec($conn,$q400);
$n400 = @pg_numrows($r400);
$f400 = pg_fetch_array($r400,0);


echo $f400['tipo'];
?>