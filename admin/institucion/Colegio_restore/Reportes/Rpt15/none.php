<?include"../Coneccion/conexion.php"?>
<?
	/* $ls_sql = " select tipo_ense_inst.cod_tipo, curso.id_curso, curso.grado_curso, curso.letra_curso, 
	ano_escolar.nro_ano, plan_estudio.cod_decreto, evaluacion.cod_eval, empleado.nombre_emp";
	$ls_sql = $ls_sql . " from tipo_ense_inst, curso, ano_escolar, plan_estudio, evaluacion, supervisa, empleado";
	$ls_sql = $ls_sql . " where tipo_ense_inst.rdb = 10237";
	$ls_sql = $ls_sql . " and tipo_ense_inst.estado < 2 ";
	$ls_sql = $ls_sql . " and curso.ensenanza = tipo_ense_inst.cod_tipo and curso.id_ano = ano_escolar.id_ano"; 
	$ls_sql = $ls_sql . " and curso.cod_decreto = plan_estudio.cod_decreto and curso.cod_eval = evaluacion.cod_eval and curso.id_curso = supervisa.id_curso and empleado.rut_emp = supervisa.rut_emp and ano_escolar.nro_ano = 2003";  */

	$ls_sql = "select * from supervisa order by id_curso";
	$resultado_query= pg_exec($conexion,$ls_sql);
	$total_filas= pg_numrows($resultado_query);




echo "[$total_filas]";	

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<?
For ($j=0; $j < $total_filas; $j++)
{
print pg_result($resultado_query, $j, 0); 
echo "  //----//   ";
print pg_result($resultado_query, $j, 1);
/* echo "  //----//   ";
print pg_result($resultado_query, $j, 2);
echo "  //----//   ";
print pg_result($resultado_query, $j, 3);
echo "  //----//   ";
print pg_result($resultado_query, $j, 4);
echo "  //----//   ";
print pg_result($resultado_query, $j, 5);
echo "  //----//   ";
print pg_result($resultado_query, $j, 6);
echo "  //----//   ";
print pg_result($resultado_query, $j, 7);
 */



echo "<br>";
}
?>
</body>
</html>