<?php 
 require('../../../../../util/header.inc');
$q_fl = "  select max(folio) from declaracion_accidente where id_ano=$ano";
$r_fl = pg_exec($conn,$q_fl);
$fl = intval(pg_result($r_fl,0))+1;
 echo $fl;
?>