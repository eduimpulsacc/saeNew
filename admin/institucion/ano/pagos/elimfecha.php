<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$pago			=$_PAGOS;
	$frmModo		=$_FRMMODO;
	$agrupacion		=$_AGRUPACION;	//	1:CP	2:CA	3:WS	4:CP
	$agrupacion		=1;
	$ano			=$_ANO;

$db = pg_connect("dbname=coe user=postgres port=1550");
$query_verif="select * from fechaxalumno where fecha_venc='".$fecha."' and id_tipo=".$id_tipo;
$result = pg_exec($db, $query_verif);
if (pg_numrows($result)==0) {
	$query="delete from fecha_vencimiento where fecha_venc='".$fecha."' and id_tipo=".$id_tipo;
	$result = pg_exec($db, $query);
	if (!$result) {
		printf ("ERROR"); 
	} else { 
		pg_close($db);
		printf("<script>window.location='pagos.php3'</script>"); 
	}
}else{
	
    echo "<center><table border=0 cellpadding=0 cellspacing=1 width=293 bgcolor=black><tr><td bgcolor=white><center><b>No se puede eliminar la cuota, existen pagos relacionados a esta </b></td><tr><td bgcolor=white>";
    echo "<center><a href=# onclick=window.location='pagos.php3'>VOLVER</a></td></tr></table>";

}
?>

