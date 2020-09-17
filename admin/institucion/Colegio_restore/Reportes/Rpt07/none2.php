<?include"../Coneccion/conexion.php"?>
<?
$sql = " select id_curso, count(id_curso) from promocion where rdb=10237 and id_ano = 76 group by id_curso;";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);

$sql = " select id_curso, count(id_curso) from matricula where rdb=10237 and id_ano = 76 group by id_curso;";
	$resultado_query2= pg_exec($conexion,$sql);
	$total_filas2= pg_numrows($resultado_query2);

$sql = " select * from ano_escolar where id_institucion=10237 ;";
	$resultado_query3= pg_exec($conexion,$sql);
	$total_filas3= pg_numrows($resultado_query3);

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

Promocion
<table width="600" border="1" cellspacing="0" cellpadding="0">
  <?
 For ($j=0; $j < $total_filas; $j++)
	{
 ?>
  <tr>
    <td><?print Trim(pg_result($resultado_query, $j, 0));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 1));?></td>
  </tr>
<?
}
?>
</table><br>
<br>

Matricula
<table width="600" border="1" cellspacing="0" cellpadding="0">
  <?
 For ($j=0; $j < $total_filas2; $j++)
	{
 ?>
  <tr>
    <td><?print Trim(pg_result($resultado_query2, $j, 0));?></td>
    <td><?print Trim(pg_result($resultado_query2, $j, 1));?></td>
  </tr>
<?
}
?>
</table>
<br>
<br>
Años
<table width="600" border="1" cellspacing="0" cellpadding="0">
  <?
 For ($j=0; $j < $total_filas3; $j++)
	{
 ?>
  <tr>
    <td><?print Trim(pg_result($resultado_query3, $j, 0));?></td>
    <td><?print Trim(pg_result($resultado_query3, $j, 1));?></td>
  </tr>
<?
}
?>
</table>



</body>
</html>
