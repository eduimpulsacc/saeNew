<?include"../Coneccion/conexion.php"?>
<?
$sql = " select distinct subsector.cod_subsector, subsector.nombre from ramo, curso, subsector where curso.id_curso = ramo.id_curso ";
$sql = $sql . " and ramo.cod_subsector = subsector.cod_subsector and curso.id_ano = 554 order by cod_subsector;";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);
	
$sql = " select distinct subsector.cod_subsector, subsector.nombre from ramo, curso, subsector where curso.id_curso = ramo.id_curso ";
$sql = $sql . " and ramo.cod_subsector = subsector.cod_subsector and curso.id_ano = 77 order by cod_subsector;";
	$resultado_query2= pg_exec($conexion,$sql);
	$total_filas2= pg_numrows($resultado_query2);


?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

Resultados 2004
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
</table>
<br>
<br>
Resultados 2003
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

</body>
</html>
