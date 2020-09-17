<?include"../Coneccion/conexion.php"?>
<?
	$li_ano = $_GET["ai_ano"];
	//$ls_input    = $_GET["as_input"];
	$ls_institucion    = $_GET["as_institucion"];
		
	//echo " --->  $ls_institucion  -- > $ls_input";
	
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
		$li_ano = 0;
	}
	

$sql = " select distinct institucion.rdb, institucion.dig_rdb, tipo_ense_inst.cod_tipo, ";
$sql = $sql . " curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, plan_estudio.cod_decreto, ";
$sql = $sql . " evaluacion.cod_eval, plan_estudio.cod_decreto, empleado.rut_emp, empleado.dig_rut, ";
$sql = $sql . " empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat ";
$sql = $sql . " from institucion, tipo_ense_inst, curso, ano_escolar, plan_estudio, evaluacion, ";
$sql = $sql . " supervisa, empleado ";
$sql = $sql . " where institucion.rdb = tipo_ense_inst.rdb  ";
$sql = $sql . " and curso.ensenanza = tipo_ense_inst.cod_tipo ";
$sql = $sql . " and ano_escolar.id_ano = curso.id_ano ";
$sql = $sql . " and plan_estudio.cod_decreto = curso.cod_decreto ";
$sql = $sql . " and ano_escolar.id_institucion = institucion.rdb ";
$sql = $sql . " and evaluacion.cod_eval = curso.cod_eval ";
$sql = $sql . " and tipo_ense_inst.cod_tipo > 100 ";
$sql = $sql . " and curso.id_curso = supervisa.id_curso ";
$sql = $sql . " and supervisa.rut_emp = empleado.rut_emp ";
$sql = $sql . " and ano_escolar.nro_ano = $li_ano ";
$sql = $sql . " and institucion.rdb = $ls_institucion ";
//$sql = $sql . " $ls_crit_busqueda ";
//$sql = $sql . " group by institucion.rdb, institucion.dig_rdb, tipo_ense_inst.cod_tipo, ";
//$sql = $sql . " curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, plan_estudio.cod_decreto, ";
//$sql = $sql . " evaluacion.cod_eval, plan_estudio.cod_decreto, empleado.rut_emp, empleado.dig_rut, ";
//$sql = $sql . " empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat ";
$sql = $sql . " order by ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso ";
	//echo "SQL : $sql";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);
	
	pg_close($conexion);

	$fichero = fopen("../Archivos/archivo02.txt", "w"); 
	
For ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\n"; 	 
 $ls_espacio= chr(9);
 
 $li_rdb =  pg_result($resultado_query, $j, 0);
 $li_dig_rdb = pg_result($resultado_query, $j, 1);
 $li_tipo_ense = pg_result($resultado_query, $j, 2);
 $li_grado_curso = pg_result($resultado_query, $j, 3);
 $ls_letra_curso = pg_result($resultado_query, $j, 4);
 $li_ano_escolar = pg_result($resultado_query, $j, 5); 
 $li_cod_decreto_eva = pg_result($resultado_query, $j, 7);
 $li_cod_decreto = pg_result($resultado_query, $j, 8);
 $li_cod_plan = pg_result($resultado_query, $j, 6);
 $li_rut_profe = pg_result($resultado_query, $j, 9); 
 $ls_dig_verif = pg_result($resultado_query, $j, 10);

 $ls_string = "2".chr(9).$li_rdb."$ls_espacio".$li_dig_rdb."$ls_espacio"; 
 $ls_string = $ls_string . $li_tipo_ense."$ls_espacio".$li_grado_curso."$ls_espacio"; 
 $ls_string = $ls_string . $ls_letra_curso."$ls_espacio".$li_ano_escolar."$ls_espacio"; 
 $ls_string = $ls_string . $li_cod_decreto_eva."$ls_espacio".$li_cod_decreto ."$ls_espacio".$li_cod_plan."$ls_espacio"; 
 $ls_string = $ls_string . $li_rut_profe."$ls_espacio".$ls_dig_verif."$salto";
 
 @ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

?>
<html>
<head>
<title>Genera</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<br><br>
<br>
<br>
<table width="60%" height="27" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
        archivo ha sido creado con el nombre de <a href='../Archivos/archivo02.txt'> 
        &quot; 
        archivo02.txt
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