<?include"../Coneccion/conexion.php"?>
<?
	$li_ano = $_GET["ai_ano"];
	$ls_institucion    = $_GET["as_institucion"];
	
	//echo "--> $ls_criterio <br> --> $ls_input <br> --> $ls_institucion  <br> --> ";
	//**************************************************
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
		$li_ano = 0;
	}


    //--------------------------------------------------------------------------------------------------------------------
	//selecciona cuerpo
$ls_sql = " select institucion.rdb, institucion.dig_rdb, curso.ensenanza, curso.grado_curso, ";
$ls_sql = $ls_sql . "curso.letra_curso, ano_escolar.nro_ano,  ";
$ls_sql = $ls_sql . "sum(case when to_char(matricula.fecha,'yyyymmdd') <= '20040430' then 1 else 0 end) as matr30a,  ";
$ls_sql = $ls_sql . "sum(case when (to_char(matricula.fecha,'yyyymmdd') >= '20040501')  ";
$ls_sql = $ls_sql . "and (to_char(matricula.fecha,'yyyymmdd') <= '20041129') then 1 else 0 end) as ing01may29nov,  ";
$ls_sql = $ls_sql . "sum(case when to_char(matricula.fecha,'yyyymmdd') <= '20041130' then 1 else 0 end) as mat30nov,  ";
$ls_sql = $ls_sql . "sum(case when (to_char(promocion.fecha_retiro,'yyyymmdd') >= '20040501')  ";
$ls_sql = $ls_sql . "and (to_char(promocion.fecha_retiro,'yyyymmdd') <= '20041129') then 1 else 0 end) as ret01may29nov,  ";
$ls_sql = $ls_sql . "sum(case when promocion.situacion_final = 1 then 1 else 0 end) as Promovidos,  ";
$ls_sql = $ls_sql . "sum(case when (promocion.situacion_final = 2)  ";
$ls_sql = $ls_sql . "and (promocion.promedio < 40) and (promocion.asistencia >= 85) then 1 else 0 end) as RepRendimi,  ";
$ls_sql = $ls_sql . "sum(case when (promocion.situacion_final = 2)  ";
$ls_sql = $ls_sql . "and (promocion.asistencia < 85) then 1 else 0 end) as RepAsis,  ";
$ls_sql = $ls_sql . "sum(case when promocion.situacion_final = 2 Then 1 else 0 end ) as tot_rep ,  ";
$ls_sql = $ls_sql . "to_char(now(),'dd/mm/yyyy') as fecha_acta, curso.id_curso  ";
$ls_sql = $ls_sql . "from institucion, curso, ano_escolar, matricula, promocion  ";
$ls_sql = $ls_sql . "where (institucion.rdb = matricula.rdb ";
$ls_sql = $ls_sql . "and institucion.rdb = promocion.rdb ";
$ls_sql = $ls_sql . "and institucion.rdb = ano_escolar.id_institucion) ";
$ls_sql = $ls_sql . "and (matricula.rut_alumno = promocion.rut_alumno ";
$ls_sql = $ls_sql . "and matricula.rdb = promocion.rdb ";
$ls_sql = $ls_sql . "and matricula.id_ano = promocion.id_ano ";
$ls_sql = $ls_sql . "and matricula.id_curso = promocion.id_curso ";
$ls_sql = $ls_sql . "and matricula.id_ano = ano_escolar.id_ano ";
$ls_sql = $ls_sql . "and matricula.id_curso = curso.id_curso ";
$ls_sql = $ls_sql . "and matricula.id_ANO = curso.id_ano) ";
$ls_sql = $ls_sql . "and (promocion.id_Ano = ano_escolar.id_ano  ";
$ls_sql = $ls_sql . "and promocion.id_curso = curso.id_curso ";
$ls_sql = $ls_sql . "and promocion.id_ano = curso.id_ano) ";
$ls_sql = $ls_sql . "and institucion.rdb = $ls_institucion ";
$ls_sql = $ls_sql . "and ano_escolar.nro_ano = $li_ano ";
$ls_sql = $ls_sql . "group by institucion.rdb, institucion.dig_rdb, curso.ensenanza, curso.grado_curso,  ";
$ls_sql = $ls_sql . "curso.letra_curso, ano_escolar.nro_ano, curso.id_curso ";  


	echo "$ls_sql";

	$resultado_query= pg_exec($conexion,$ls_sql);
	$total_filas= pg_numrows($resultado_query);

$ls_sql = " select empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat ";
$ls_sql = $ls_sql . " from trabaja, empleado ";
$ls_sql = $ls_sql . " where empleado.rut_emp = trabaja.rut_emp ";
$ls_sql = $ls_sql . " and trabaja.rdb = $ls_institucion ";
$ls_sql = $ls_sql . " and trabaja.cargo = 1; ";

	$resultado_query_dire= pg_exec($conexion,$ls_sql);
	$total_filas_dire= pg_numrows($resultado_query_dire);
//echo "$ls_sql";
	pg_close($conexion);

if ($total_filas_dire > 0){
	$ls_nom_dire = TRIM(pg_result($resultado_query_dire, 0, 0)) . ' ' . TRIM(pg_result($resultado_query_dire, 0, 1)) . ' ' . TRIM(pg_result($resultado_query_dire, 0, 2));
}else{
$ls_nom_dire = " ";
}

	$fichero = fopen("../Archivos/archivo07.txt", "w"); 
	
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

	$li_matr_30_abril = pg_result($resultado_query, $j, 6);
	$li_matr_30_nov = pg_result($resultado_query, $j, 8);
	$li_promovidos = pg_result($resultado_query, $j, 10);
	$li_reprob_inasis = pg_result($resultado_query, $j, 12);
	$li_reprob_rendim = pg_result($resultado_query, $j, 11);
	$li_num_est_ing_01may_29_nov = pg_result($resultado_query, $j, 7);
	$li_num_est_ret_01may_29_nov = pg_result($resultado_query, $j, 9);
	$ls_fecha_ACTA = Trim(pg_result($resultado_query, $j, 14));
	$li_id__CURSO = Trim(pg_result($resultado_query, $j, 15));
//echo "$li_id__CURSO";
$sql = " select empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from empleado, supervisa where empleado.rut_emp = supervisa.rut_emp and supervisa.id_curso = $li_id__CURSO;";
/*	$resultado_query_super= pg_exec($conexion,$sql);
	$total_filas_super= pg_numrows($resultado_query_super);

if ($total_filas_dire > 0){
	$ls_prof_jefe = TRIM(pg_result($resultado_query_super, 0, 0)) . ' ' . TRIM(pg_result($resultado_query_super, 0, 1)) . ' ' . TRIM(pg_result($resultado_query_super, 0, 2));
}else{
$ls_prof_jefe = " ";
}
*/
echo "$sql <br>";
$ls_prof_jefe = " ";

	//$ls_prof_jefe = Trim(pg_result($resultado_query, $j, 14)). ' ' . Trim(pg_result($resultado_query, $j, 15)) . ' ' . Trim(pg_result($resultado_query, $j, 16));
	


 $ls_string = "7".chr(9).$li_rdb."$ls_espacio".$li_dig_rdb."$ls_espacio"; 
 $ls_string = $ls_string . $li_cod_tipo."$ls_espacio".$li_grado_curso."$ls_espacio"; 
 $ls_string = $ls_string . $ls_letra_curso."$ls_espacio".$li_ano_escolar."$ls_espacio"; 
 $ls_string = $ls_string . $li_matr_30_abril."$ls_espacio".$li_matr_30_nov ."$ls_espacio".$li_promovidos."$ls_espacio"; 
 $ls_string = $ls_string . $li_reprob_inasis."$ls_espacio".$li_reprob_rendim ."$ls_espacio".$li_num_est_ing_01may_29_nov."$ls_espacio"; 
 $ls_string = $ls_string . $li_num_est_ret_01may_29_nov."$ls_espacio".$ls_nom_dire."$ls_espacio".$ls_fecha_ACTA."$ls_espacio";
 $ls_string = $ls_string . $ls_nom_dire."$ls_espacio".$ls_prof_jefe."$salto";
 
 @ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

	

?>
<html>
<head>
<title>rpt7</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!--link href="../css/objeto.css" rel="stylesheet" type="text/css"-->
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<br>
<br>
<br>
<br>
<br>
<table width="60%" height="27" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong>El 
        archivo ha sido creado con el nombre de <a href='../Archivos/archivo07.txt'> 
        &quot; archivo07.txt &quot;</a> , en total se encontraron 
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
