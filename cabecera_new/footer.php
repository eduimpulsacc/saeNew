<?
$fecha=date("m-d-Y");
$sql="select count(*) from control_users WHERE rdb_users=".$_INSTIT." and fecha='".$fecha."'";
$rs_visitas = pg_Exec($connection,$sql);
$cant_visitas = pg_result($rs_visitas,0);

for($i=0;$i<$_POSP;$i++){
	$url.="../";	
}

?>

	<div id="footer"><img src="<?php echo $url ?>cabecera_new/img/abajo.jpg" width="1155" height="89" border="0" /></div> 
		<!--cierre head-->


