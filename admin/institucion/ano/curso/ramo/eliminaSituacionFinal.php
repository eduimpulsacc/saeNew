<?php require('../../../../../util/header.inc');
 
 $ramo		=	$_RAMO;
 
  $qry5="delete from situacion_final where id_ramo=$ramo ";
 
 $result5=@pg_Exec($conn,$qry5);
 
 if($result5)
 echo 1;
 else
 echo 0;
 ?>