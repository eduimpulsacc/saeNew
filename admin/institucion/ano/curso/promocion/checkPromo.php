<?php require('../../../../../util/header.inc');?>
<?php 

$curso			=$curso; 

 $sql_prom ="select count(*) as conteo from promocion where id_curso=".$curso;
 $result =pg_exec($conn,$sql_prom);
$fil = pg_fetch_array($result,0);

echo ($fil['conteo']>0)?1:0;
?>