<?php require('../../../../util/header.inc');?>
<?
	$institucion	=$_INSTIT;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<? 
	$sql = "delete from archivo04 where rdb = $institucion";
	$resultado_query= pg_exec($conn,$sql);
	pg_close($conn);	
	?><script>window.location='Menu_Actas.php?'</script><?	
?>
</body>
</html>
