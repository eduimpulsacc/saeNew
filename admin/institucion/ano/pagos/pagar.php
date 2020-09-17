<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$pago			=$_PAGOS;
	$frmModo		=$_FRMMODO;
	$agrupacion		=$_AGRUPACION;	//	1:CP	2:CA	3:WS	4:CP
	$agrupacion		=1;
	$ano			=$_ANO;

$db = pg_connect("dbname=coe_traspaso user=postgres port=1550 password=cole#newaccess");
echo $query="insert into fechaxalumno values ('$fechas',$id,".trim($rt).",'$monto')";


echo "<br><br>Actualizando...";

$result = @pg_exec($db, $query);
if (!$result) 
	echo "ERROR ".$result; 
else
    printf("<script>window.location='pagos.php3'</script>"); 
?>