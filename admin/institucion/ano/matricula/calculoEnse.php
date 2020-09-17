<?php 
require('../../../../util/header.inc');
//var_dump($_POST);
$curso=$_POST['curso'];
$funcion=$_POST['funcion'];

if($funcion==1){
 $qry="select count(*) from matricula where id_curso=$curso and bool_ar=0";
$rs_ense = pg_exec($conn,$qry);
echo pg_result($rs_ense,0);

}

if($funcion==0){
$qry="select ensenanza from curso where id_curso=$curso";
$rs_ense = pg_exec($conn,$qry);
echo pg_result($rs_ense,0);

}

?>