<?include"../Coneccion/conexion.php"?>
<?
/*
$sql = " SELECT institucion.rdb, institucion.dig_rdb, curso.ensenanza, curso.grado_curso, curso.letra_curso,";
$sql = $sql . " ano_escolar.nro_ano, alumno.rut_alumno, alumno.dig_rut, curso.cod_decreto AS coddecreto1, curso.cod_decreto ";
$sql = $sql . " AS coddecreto2, ramo.cod_subsector, ramo.id_ramo, ramo.modo_eval FROM institucion, ramo, matricula, alumno, ";
$sql = $sql . " ano_escolar, curso where institucion.rdb = matricula.rdb and institucion.rdb = ano_escolar.id_institucion and ";
$sql = $sql . " matricula.rut_alumno = alumno.rut_alumno and matricula.id_curso = curso.id_curso and matricula.id_ano = ";
$sql = $sql . " ano_escolar.id_ano and curso.id_curso = ramo.id_curso and institucion.rdb = 10237 and ano_escolar.nro_ano = 2003 ";
$sql = $sql . " and id_ramo not in( select tiene3.id_ramo where tiene3.rut_alumno = alumno.rut_alumno and tiene3.id_ramo = ramo.id_ramo";
$sql = $sql . " and tiene3.id_curso = curso.id_curso )";
$sql = $sql . " order by curso.ensenanza, curso.grado_curso, curso.letra_curso, alumno.rut_alumno  ; ";
	
//	echo "$sql";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);
	
$sql = " SELECT institucion.rdb, institucion.dig_rdb, curso.ensenanza, ";
$sql = $sql . " curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, ";
$sql = $sql . " alumno.rut_alumno, alumno.dig_rut, curso.cod_decreto AS coddecreto1,  ";
$sql = $sql . " curso.cod_decreto AS coddecreto2, ramo.cod_subsector, ramo.id_ramo, ramo.modo_eval  ";
$sql = $sql . " FROM institucion, ramo, matricula, alumno, ano_escolar, curso, tiene3  ";
$sql = $sql . " where institucion.rdb = matricula.rdb and institucion.rdb = ano_escolar.id_institucion ";
$sql = $sql . " and matricula.rut_alumno = alumno.rut_alumno and matricula.id_curso = curso.id_curso ";
$sql = $sql . " and matricula.id_ano = ano_escolar.id_ano and curso.id_curso = ramo.id_curso ";
$sql = $sql . " and institucion.rdb = 10237 and ano_escolar.nro_ano = 2004 ";
$sql = $sql . " and tiene3.rut_alumno = alumno.rut_alumno and tiene3.rut_alumno = matricula.rut_alumno ";
$sql = $sql . " and tiene3.id_ramo = ramo.id_ramo and tiene3.id_curso = curso.id_curso ";
$sql = $sql . " and tiene3.id_curso = ramo.id_curso order by curso.ensenanza, curso.grado_curso, curso.letra_curso, alumno.rut_alumno ;";

	$resultado_query2= pg_exec($conexion,$sql);
	$total_filas2= pg_numrows($resultado_query2);
*/	
$sql = " SELECT distinct institucion.rdb, institucion.dig_rdb, curso.ensenanza, ";
$sql = $sql . " curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano,  ";
$sql = $sql . " alumno.rut_alumno, alumno.dig_rut, curso.cod_decreto AS coddecreto1,  ";
$sql = $sql . " curso.cod_decreto AS coddecreto2, ramo.cod_subsector, ramo.id_ramo, ramo.modo_eval ";
//$sql = $sql . " ,(sum(case notas.promedio when 'MB' then 70 when 'B' then 60 when 'S' then 50 when 'I' then 30 when ' ' then 0 ";
//$sql = $sql . " else to_number(notas.promedio, 99) end)) / (count(notas.id_periodo)) as tpromedio  ";
//$sql = $sql . " FROM institucion, ramo, matricula, alumno, ano_escolar, curso, notas  ";
$sql = $sql . " FROM institucion, ramo, matricula, alumno, ano_escolar, curso ";
$sql = $sql . " where institucion.rdb = matricula.rdb and institucion.rdb = ano_escolar.id_institucion ";
$sql = $sql . " and matricula.rut_alumno = alumno.rut_alumno and matricula.id_curso = curso.id_curso ";
$sql = $sql . " and matricula.id_ano = ano_escolar.id_ano and curso.id_curso = ramo.id_curso ";
//$sql = $sql . " and alumno.rut_alumno = notas.rut_alumno and ramo.id_ramo = notas.id_ramo and institucion.rdb = 10237 ";
$sql = $sql . " and institucion.rdb = 10237 ";
$sql = $sql . " and ano_escolar.nro_ano = 2003 and ramo.id_ramo not in( select tiene3.id_ramo where tiene3.rut_alumno =  ";
$sql = $sql . " alumno.rut_alumno and tiene3.id_ramo = ramo.id_ramo and tiene3.id_curso = curso.id_curso ";
$sql = $sql . " ) group by institucion.rdb, institucion.dig_rdb, curso.ensenanza,   ";
$sql = $sql . " curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, alumno.rut_alumno, alumno.dig_rut, curso.cod_decreto, ";
$sql = $sql . " curso.cod_decreto, ramo.cod_subsector, ramo.id_ramo, ramo.modo_eval ";
$sql = $sql . " order by curso.ensenanza, curso.grado_curso, curso.letra_curso, alumno.rut_alumno ; ";

	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);

?>
<html>
<head>
<title>Untitled Document</title>
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
    <td><?print Trim(pg_result($resultado_query, $j, 2));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 3));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 4));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 5));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 6));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 7));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 8));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 9));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 10));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 11));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 12));?></td>
	<!--td><?print Trim(pg_result($resultado_query, $j, 13));?></td-->
  </tr>
<?
}
?>
</table>

</body>
</html>
