<?include"../Coneccion/conexion.php"?>
<?
$sql = " select * from asistencia";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

Asistencia año 2002
<table width="600" border="1" cellspacing="0" cellpadding="0">
  <?
 For ($j=0; $j < $total_filas; $j++)
	{
 ?>
  <tr>
    <td><?print Trim(pg_result($resultado_query, $j, 0));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 1));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 2));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 3));?></td>
  </tr>
<?
}
?>
</table>
</body>
</html>
