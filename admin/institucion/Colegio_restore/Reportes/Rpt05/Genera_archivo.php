<?include"../Coneccion/conexion.php"?>
<?
	$li_curso = $_GET["ai_curso"];
	$ls_letra = $_GET["as_letra"];
	$li_tipo_ense = $_GET["ai_tipo_ense"];
	$li_ano = $_GET["ai_ano"];
	$ls_criterio = $_GET["as_criterio"];
	$ls_input    = $_GET["as_input"];
	$ls_institucion    = $_GET["as_institucion"];
	
	//echo "--> $ls_criterio <br> --> $ls_input <br> --> $ls_institucion  <br> --> ";
	//**************************************************
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
		$li_curso = 0;
		$ls_letra = 'Z';
		$li_tipo_ense = 0;
		$li_ano = 0;
		//$ls_institucion    = 0;
	}
	
	
	$ls_sql = "select  institucion.rdb, institucion.dig_rdb, ";
	$ls_sql = $ls_sql . " tipo_ensenanza.cod_tipo, curso.grado_curso, curso.letra_curso, ";
	$ls_sql = $ls_sql . " ano_escolar.nro_ano, alumno.rut_alumno, alumno.dig_rut, ";
	$ls_sql = $ls_sql . " promocion.promedio, promocion.asistencia, promocion.situacion_final, promocion.fecha_retiro";
	$ls_sql = $ls_sql . " from institucion, matricula, curso, tipo_ensenanza, ano_escolar, alumno, promocion ";
	$ls_sql = $ls_sql . " where institucion.rdb = matricula.rdb ";
	$ls_sql = $ls_sql . " and matricula.id_curso = curso.id_curso ";
	$ls_sql = $ls_sql . " and curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$ls_sql = $ls_sql . " and matricula.id_ano = ano_escolar.id_ano ";
	$ls_sql = $ls_sql . " and matricula.rut_alumno = alumno.rut_alumno ";
	$ls_sql = $ls_sql . " and institucion.rdb = promocion.rdb ";
	$ls_sql = $ls_sql . " and alumno.rut_alumno = promocion.rut_alumno  ";
	$ls_sql = $ls_sql . " and ano_escolar.id_ano = promocion.id_ano  ";
	$ls_sql = $ls_sql . " and curso.id_curso = promocion.id_curso ";
	$ls_sql = $ls_sql . " and institucion.rdb = $ls_institucion ";
	//$ls_sql = $ls_sql . " and curso.grado_curso = $li_curso ";
	//$ls_sql = $ls_sql . " and curso.letra_curso = '$ls_letra' ";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano ";
	//$ls_sql = $ls_sql . " and tipo_ensenanza.cod_tipo = $li_tipo_ense ";
	
	//echo "$ls_sql";
	$resultado_query= pg_exec($conexion,$ls_sql);
	$total_filas= pg_numrows($resultado_query);

	pg_close($conexion);


	$fichero = fopen("../Archivos/archivo05.txt", "w"); 
	
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
 $li_rut_estud  = pg_result($resultado_query, $j, 6);
 $li_dig_verif  = pg_result($resultado_query, $j, 7); 
 $li_promedio = number_format(pg_result($resultado_query, $j, 8)/10,1); 
 $li_promedio = str_replace(".",",",$li_promedio);
 
 $li_asistencia = trim(pg_result($resultado_query, $j, 9)); 
 
 if (pg_result($resultado_query, $j, 10)==1){
 	$li_situacion = "P";	
 }elseif (pg_result($resultado_query, $j, 10)==2){
 	$li_situacion = "R";
 }elseif (pg_result($resultado_query, $j, 10)==3){
 	$li_situacion = "Y";
 }

 
 if (trim(pg_result($resultado_query, $j, 11)) == ''){
 	$ls_obs = "             ";
 }else{
  $ls_obs = "RET: ".pg_result($resultado_query, $j, 11);
 }

 $ls_string = "5".chr(9).$li_rdb."$ls_espacio".$li_dig_rdb."$ls_espacio"; 
 $ls_string = $ls_string . $li_cod_tipo."$ls_espacio".$li_grado_curso."$ls_espacio"; 
 $ls_string = $ls_string . $ls_letra_curso."$ls_espacio".$li_ano_escolar."$ls_espacio"; 
 $ls_string = $ls_string . $li_rut_estud."$ls_espacio".$li_dig_verif ."$ls_espacio".$li_promedio."$ls_espacio"; 
 $ls_string = $ls_string . $li_asistencia."$ls_espacio".$ls_obs."$ls_espacio".$li_situacion ."$ls_espacio"."1"."$salto"; 
 
 @ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 


?>

<html>
<head>
<title>Untitled Document</title>
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
        archivo ha sido creado con el nombre de <a href="../Archivos/archivo05.txt"> 
        &quot; archivo05.txt &quot;</a> , en total se encontraron 
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
