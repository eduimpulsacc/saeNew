<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$pago			=$_PAGOS;
	$frmModo		=$_FRMMODO;
	$agrupacion		=$_AGRUPACION;	//	1:CP	2:CA	3:WS	4:CP
	$agrupacion		=1;
	$ano			=$_ANO;
$db = pg_connect("dbname=coe_traspaso user=postgres port=1550 password=cole#newaccess");
$query="select * from fecha_vencimiento where fecha_venc='".$fecha."' and id_tipo=".$id_tipo;
$result = pg_exec($db, $query);

if (pg_numrows($result)==0) {
	$query="insert into fecha_vencimiento values('".$fecha."',".$id_tipo.")";
	$result = pg_exec($db, $query);
	if (!$result) {
		printf ("ERROR"); 
	} else { 
	     printf("<script>window.location='pagos.php3'</script>"); 
	}
} else {
	pg_close($db);
        printf("<script>window.location='pagos.php3'</script>"); 
}



?>


