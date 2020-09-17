<?	require('../../util/header.inc');

$institucion = $_INSTIT;

if($caso==1){
	$sql = "DELETE FROM diagnostico WHERE id_dignos=".$id_dig;
	$result = @pg_exec($conn,$sql);	
}else if($caso==2){
	$sql = "UPDATE diagnostico SET nombre='".strtoupper($txtNOMBRE)."', tipo=".$tipo." WHERE id_dignos=".$id_dig;
	$result = @pg_exec($conn,$sql);
}elseif($caso==3){
	$sql = "INSERT INTO diagnostico (nombre,tipo,rdb) VALUES ('".strtoupper($txtNOMBRE)."',".$tipo.",".$_INSTIT.")";
	$result = @pg_exec($conn,$sql);
}

echo "<script>window.location='diagnostico.php?caso=3'</script>";

pg_close($conn);?>