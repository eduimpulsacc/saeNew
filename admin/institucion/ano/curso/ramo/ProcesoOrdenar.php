<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	
	
?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?
for ($i=0;$i<$cantidad;$i++)
{
	$sqlUpdate = "update ramo set id_orden = ".$order[$i]." where id_ramo = ".$id_ramo[$i];
	$rsUpdate =@pg_Exec($conn,$sqlUpdate);


}
pg_close($conn);
echo "<script>window.location = 'listarRamos.php3'</script>";
?>
</body>
</html>
