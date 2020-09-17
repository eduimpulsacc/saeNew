<?include"../Coneccion/conexion.php"?>
<?
	//$li_curso = $_GET["ai_curso"];
	//$ls_letra = $_GET["as_letra"];
	//$li_tipo_ense = $_GET["ai_tipo_ense"];
	$li_ano = $_GET["ai_ano"];
	$ls_institucion    = $_GET["as_institucion"];
	
	//echo "--> $ls_criterio <br> --> $ls_input <br> --> $ls_institucion  <br> --> ";
	//**************************************************
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
		//$li_curso = 0;
		//$ls_letra = 0;
		//$li_tipo_ense = 0;
		$li_ano = 0;
	}
	
	$ls_sql = "select distinct institucion.rdb, institucion.dig_rdb, tipo_ensenanza.cod_tipo, curso.grado_curso, ";
	$ls_sql = $ls_sql . " curso.letra_curso, ano_escolar.nro_ano, plan_estudio.cod_decreto, curso.cod_eval, ";
	$ls_sql = $ls_sql . " subsector.cod_subsector, empleado.rut_emp, empleado.dig_rut, empleado.ape_pat,  ";
	$ls_sql = $ls_sql . " empleado.ape_mat, empleado.nombre_emp ";
	$ls_sql = $ls_sql . " from matricula, institucion, curso, tipo_ensenanza, ano_escolar, ramo, dicta,  ";
	$ls_sql = $ls_sql . " empleado, subsector, plan_estudio  ";
	$ls_sql = $ls_sql . " where institucion.rdb = matricula.rdb  ";
	$ls_sql = $ls_sql . " and matricula.id_curso = curso.id_curso  ";
	$ls_sql = $ls_sql . " and matricula.id_ano = ano_escolar.id_ano  ";
	$ls_sql = $ls_sql . " and curso.ensenanza = tipo_ensenanza.cod_tipo  ";
	$ls_sql = $ls_sql . " and curso.id_ano = ano_escolar.id_ano  ";
	$ls_sql = $ls_sql . " and curso.id_curso = ramo.id_curso  ";
	$ls_sql = $ls_sql . " and ramo.id_ramo = dicta.id_ramo  ";
	$ls_sql = $ls_sql . " and dicta.rut_emp = empleado.rut_emp  ";
	$ls_sql = $ls_sql . " and subsector.cod_subsector = ramo.cod_subsector  ";
	$ls_sql = $ls_sql . " and curso.cod_decreto = plan_estudio.cod_decreto ";
	//$ls_sql = $ls_sql . " and tipo_ensenanza.cod_tipo = $li_tipo_ense  ";
	//$ls_sql = $ls_sql . " and curso.grado_curso = $li_curso  ";
	//$ls_sql = $ls_sql . " and curso.letra_curso = '$ls_letra'  ";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano  ";
	$ls_sql = $ls_sql . " and matricula.rdb = $ls_institucion  ";
	/*$ls_sql = $ls_sql . " group by institucion.rdb, institucion.dig_rdb, tipo_ensenanza.cod_tipo, curso.grado_curso, ";
	$ls_sql = $ls_sql . " curso.letra_curso, ano_escolar.nro_ano, plan_estudio.cod_decreto, plan_estudio.cod_plan, ";
	$ls_sql = $ls_sql . " subsector.cod_subsector, empleado.rut_emp, empleado.dig_rut, empleado.ape_pat,  ";
	$ls_sql = $ls_sql . " empleado.ape_mat, empleado.nombre_emp; ";	 */
	
	//echo " <br> $ls_sql" ;
	 
	$resultado_query= pg_exec($conexion,$ls_sql);
	$total_filas= pg_numrows($resultado_query);

	pg_close($conexion);

	$fichero = fopen("../Archivos/archivo06.txt", "w"); 
	
For ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\n"; 	 
 $ls_espacio= chr(9);
 
 $li_rdb =  pg_result($resultado_query, $j, 0);
 $li_dig_rdb = pg_result($resultado_query, $j, 1);
 $li_cod_tipo = pg_result($resultado_query, $j, 2);
 $li_grado_curso = pg_result($resultado_query, $j, 3);
 $ls_letra_curso = pg_result($resultado_query, $j, 4);
 $li_ano_escolar = pg_result($resultado_query, $j, 5); 
 $li_cod_decreto = pg_result($resultado_query, $j, 6);
 $li_cod_plan = pg_result($resultado_query, $j, 7);
 $li_cod_subsector = pg_result($resultado_query, $j, 8);
 $li_rut = pg_result($resultado_query, $j, 9);
 $ls_dig_rut = pg_result($resultado_query, $j, 10);
 $ls_apellido_pat = pg_result($resultado_query, $j, 11);
 $ls_apellido_mat = pg_result($resultado_query, $j, 12);
 $ls_nombres = pg_result($resultado_query, $j, 13);
 
 $ls_string = "6".chr(9).$li_rdb."$ls_espacio".$li_dig_rdb."$ls_espacio"; 
 $ls_string = $ls_string . $li_cod_tipo."$ls_espacio".$li_grado_curso."$ls_espacio"; 
 $ls_string = $ls_string . $ls_letra_curso."$ls_espacio".$li_ano_escolar."$ls_espacio"; 
 $ls_string = $ls_string . $li_cod_decreto."$ls_espacio".$li_cod_plan ."$ls_espacio".$li_cod_subsector."$ls_espacio"; 
 $ls_string = $ls_string . $li_rut."$ls_espacio".$ls_dig_rut ."$ls_espacio".$ls_apellido_pat."$ls_espacio"; 
 $ls_string = $ls_string . $ls_apellido_mat."$ls_espacio".$ls_nombres ."$salto"; 
 
 @ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 
?>

<html>
<head>
<title>genera 06</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<br>
<br>
<br>
<br>
<table width="60%" height="27" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
        archivo ha sido creado con el nombre de <a href='../Archivos/archivo06.txt'> 
        &quot; 
        archivo06.txt
        &quot;</a> , en total se encontraron 
        <?=($total_filas)?>
        registros para el a&ntilde;o <b> 
        <?=($li_ano)?>
        </b>.<br>
        <br>
        </strong></font></div></td>
  </tr>
  <tr> 
    <td><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Para 
        guardar el archivo en su PC Solo debe clickear con el boton derecho sobre 
        el Link que esta en el nombre del archivo y elegir la opcion guardar archivo 
        como(Save Target As)</font></div></td>
  </tr>
</table>

</body>
</html>
