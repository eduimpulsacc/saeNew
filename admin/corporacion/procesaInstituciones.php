<?php require('../../util/header.inc');


if($del==1)
{	
	echo "<br>".$qry2 = "delete from corp_instit where rdb = '$rdb' and num_corp = '$num_corp'";
	$res2 = @pg_Exec($conn,$qry2);
	$variable = $num_corp;
}
if(($del=="") AND ($variable!=""))
{

	echo "<br>".$qry = "insert into corp_instit (num_corp, rdb, estado) values ('$variable','$txt_estab',true)";
	$res = pg_Exec($conn,$qry);
}
echo "<script>window.location = 'admin_instituciones.php?variable=$variable'</script>";


?>