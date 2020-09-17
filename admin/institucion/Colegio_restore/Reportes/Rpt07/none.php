<?include"../Coneccion/conexion.php"?>
<?
/*
$sql = " select curso.id_curso, curso.grado_curso, curso.letra_curso  from promocion, curso where promocion.id_CURSO = curso.id_curso and promocion.id_ano =curso.id_ano and promocion.rdb=10237  and promocion.id_ano = 76 order by curso.id_curso;";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);

$sql = " select curso.id_curso, curso.grado_curso, curso.letra_curso, to_char(matricula.fecha,'yyyymmdd')  from matricula, curso where matricula.id_CURSO = curso.id_curso and matricula.id_ano =curso.id_ano and matricula.rdb=10237  and matricula.id_ano = 76 order by curso.id_curso, matricula.fecha"; 
	$resultado_query2= pg_exec($conexion,$sql);
	$total_filas2= pg_numrows($resultado_query2);

$sql = " select * from ano_escolar where id_institucion=12086 ;";
	$resultado_query3= pg_exec($conexion,$sql);
	$total_filas3= pg_numrows($resultado_query3);
*/

$ls_sql = "select letra_curso, grado_curso, ensenanza, id_ano, id_curso from curso where id_ano = 12 and ensenanza > 100 ";
$ls_sql = $ls_sql . "order by ensenanza, grado_curso, letra_curso;";

	$resultado_query= pg_exec($conexion,$ls_sql);
	$total_filas= pg_numrows($resultado_query);
	

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
año 2003<br>
<br>
<br>
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
    <td><?print Trim(pg_result($resultado_query, $j, 4));?></td>
  </tr>
<?
}
?>
</table>



<!--
<table width="600" border="1" cellspacing="0" cellpadding="0">
  <!?
 For ($j=0; $j < $total_filas; $j++)
	{
 ?>
  <tr>
    <td><?print Trim(pg_result($resultado_query, $j, 0));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 1));?><?print Trim(pg_result($resultado_query, $j, 2));?></td>
  </tr>
<!?
}
?>
</table><br>
<br>

Matricula
<table width="600" border="1" cellspacing="0" cellpadding="0">
  <!?
 For ($j=0; $j < $total_filas2; $j++)
	{
 ?>
  <tr>
    <td><?print Trim(pg_result($resultado_query2, $j, 0));?></td>
    <td><?print Trim(pg_result($resultado_query2, $j, 1));?></td>
	<td><?print Trim(pg_result($resultado_query2, $j, 2));?></td>
	<td><?print Trim(pg_result($resultado_query2, $j, 3));?></td>

  </tr>
<!?
}
?>
</table>
<br>
<br>
Años
<table width="600" border="1" cellspacing="0" cellpadding="0">
  <!?
 For ($j=0; $j < $total_filas3; $j++)
	{
 ?>
  <tr>
    <td><?print Trim(pg_result($resultado_query3, $j, 0));?></td>
    <td><?print Trim(pg_result($resultado_query3, $j, 1));?></td>
  </tr>
<!?
}
?>
</table>
-->


</body>
</html>
