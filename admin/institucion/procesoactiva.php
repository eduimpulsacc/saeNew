<?	
require('../../util/header.inc');
	
$ma2 = "update accede set estado='1' where rdb='$rbd'";
$ma = "Update institucion set estado_colegio='1' where rdb='$rbd'";
$result =@pg_Exec($conn,$ma2,$ma);

echo "rbd $rbd"
?>

