<?php require('../../../../../../util/header.inc');

if($funcion==1){
	
$sql="select bool_psemestral from curso where id_curso=$curso";	
$rs=pg_exec($conn,$sql);
echo pg_result($rs,0);

	
}
?>