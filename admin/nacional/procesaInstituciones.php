<?php require('../../util/header.inc');


if($del==1)
{	
	$qry2 = "delete from corp_instit where rdb = '$rdb' and num_corp = '$num_corp'";
	$res2 = @pg_Exec($conn,$qry2);
}
if(($del=="") AND ($variable!=""))
{

	$qry = "insert into corp_instit (num_corp, rdb, estado) values ('$variable','$txt_estab',true)";
	$res = pg_Exec($conn,$qry);
}
echo "<script>window.location = 'admin_instituciones.php?variable=$variable'</script>";


?>