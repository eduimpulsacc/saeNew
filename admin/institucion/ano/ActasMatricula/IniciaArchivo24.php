<?php require('../../../../util/header.inc');?>
<?
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$con			=0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?
	$sql="delete from archivo24 where rbd = $institucion";
	$rsBorra = pg_exec($conn,$sql);	
	
	pg_close($conn);
?>
<script>window.location='procesoArchivo24.php?num=0'</script>
</body>
</html>
