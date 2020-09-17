<?php 
require('../../../../../../util/header.inc');

$sql="select * from plani where fecha_abordaje between '06/01/2009' and '06/30'2009' and id_ramo =119651";
$res=@pg_exec($conn,$sql);
if (pg_numrows($res)>0)
echo "ok"
else
{
	;

}

?>