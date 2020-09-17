<?include"../Coneccion/conexion.php"?>
<?
$aa = $_GET["aa"];

$sql = "select rut_alumno, promedio from notas  order by rut_alumno,id_ramo";

	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);

?>
<html>
<head>
<title>none</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

<?=($total_filas)?>
<table width="800" border="1" cellspacing="0" cellpadding="0">
  <?
 For ($j=0; $j < $total_filas; $j++)
	{
 ?>
  <tr>
    <td><?print Trim(pg_result($resultado_query, $j, 0));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 1));?></td>
	<td>

	</td>
  </tr>
<?
}
?>
</table>

</body>
</html>
