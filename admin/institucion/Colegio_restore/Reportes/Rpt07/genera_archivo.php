<?include"../Coneccion/conexion.php"?>
<?
//Recoge variables
	$li_ano = $_GET["ai_ano"];
	$ls_institucion    = $_GET["as_institucion"];
	
//valida que las variables tengan informacion
	If(Trim($ls_institucion) == ''){
		$ls_institucion=0;
		$li_ano = 0;
	}
//Recoge RDB, Dig Rdb, id_ano consultado
	$sql = " select institucion.rdb, institucion.dig_rdb, ano_escolar.id_ano, ano_escolar.fecha_inicio ";
	$sql = $sql . " from institucion, ano_escolar ";
	$sql = $sql . " where institucion.rdb = ano_escolar.id_institucion ";
	$sql = $sql . " and institucion.rdb = $ls_institucion ";
	$sql = $sql . " and ano_escolar.nro_ano = $li_ano; ";
	$resultado_query_cab= pg_exec($conexion,$sql);
	$total_filas_cab= pg_numrows($resultado_query_cab);
	
	if ($total_filas_cab>0){
		$li_rdb 			= pg_result($resultado_query_cab, 0, 0);
		$li_drdb 			= pg_result($resultado_query_cab, 0, 1);
		$li_ano__ 			= pg_result($resultado_query_cab, 0, 2);
		$ldt_fecha_inicio 	= pg_result($resultado_query_cab, 0, 3);
	}else{
		$li_rdb 		= 0;
		$li_drdb 	= 0;
		$li_ano__ 	= 0;
	}

//lista de cursos del año y la institucion consultada

	$ls_sql = "select letra_curso, grado_curso, ensenanza, id_ano, id_curso from curso where id_ano = $li_ano__ and ensenanza > 100 ";
	$ls_sql = $ls_sql . "order by ensenanza, grado_curso, letra_curso;";

	$resultado_query_curso = pg_exec($conexion,$ls_sql);
	$total_filas_curso = pg_numrows($resultado_query_curso);

$fichero = fopen("../Archivos/archivo07.txt", "w"); 

for($i=0;$i<$total_filas_curso;$i++){


	//CANTIDAD DE ALUMNOS MATRICULADOS ANTES DEL 30 DE ABRIL
		$ls_sql = " SELECT Count(*) AS cant From matricula 	WHERE (to_char(matricula.fecha,'yyyymmdd') <= '".$li_ano."0501') ";
		$ls_sql = $ls_sql . " AND ((matricula.id_curso)= ". pg_result($resultado_query_curso, $i, 4);
		$ls_sql = $ls_sql . ") and rdb = $ls_institucion and id_ano = $li_ano__ ;";
		
		$resultado_query = pg_exec($conexion,$ls_sql);
		$total_filas= pg_numrows($resultado_query);
		if ($total_filas>0){
			$li_matr_30Abril = pg_result($resultado_query,0,0);
		}
	//CANTIDAD DE ALUMNOS MATRICULADOS ANTES DEL 30 DE NOVIEMBRE
		$ls_sql = " SELECT Count(*) AS cant From matricula 	WHERE (to_char(matricula.fecha,'yyyymmdd') <= '".$li_ano."1201') ";
		$ls_sql = $ls_sql . " AND ((matricula.id_curso)= ". pg_result($resultado_query_curso, $i, 4) .") ";
		$ls_sql = $ls_sql . "and rdb = $ls_institucion and id_ano = $li_ano__ ;";
		
		$resultado_query = pg_exec($conexion,$ls_sql);
		$total_filas= pg_numrows($resultado_query);
		if ($total_filas>0){
			$li_matr_30noviembre = pg_result($resultado_query,0,0);
		}
	//CANTIDAD DE ALUMNOS PROMOVIDOS
		$ls_sql = " select count(*) as cant from promocion where situacion_final = 1 and promocion.id_curso = ";
		$ls_sql = $ls_sql . pg_result($resultado_query_curso, $i, 4) ." and rdb = $ls_institucion and id_ano = $li_ano__";
		
		$resultado_query = pg_exec($conexion,$ls_sql);
		$total_filas= pg_numrows($resultado_query);
		if ($total_filas>0){
			$li_alum_promovidos = pg_result($resultado_query,0,0);
		}
		
	//CANTIDAD DE ALUMNOS REPROBADOS POR INASISTENCIA		
		$ls_sql = " select count(*) as cant from promocion where situacion_final = 2 and asistencia < 85 ";
		$ls_sql = $ls_sql . " and promocion.id_curso = ".  pg_result($resultado_query_curso, $i, 4) ." and ";
		$ls_sql = $ls_sql . " rdb = $ls_institucion and id_ano = $li_ano__";
				
		$resultado_query = pg_exec($conexion,$ls_sql);
		$total_filas= pg_numrows($resultado_query);
		if ($total_filas>0){
			$li_alum_reprob_Inas = pg_result($resultado_query,0,0);
		}
	
	//CANTIDAD DE ALUMNOS REPROBADOS POR RENDIMIENTO
		$ls_sql = " select count(*) as cant from promocion where situacion_final = 2 and promedio < 40 ";
		$ls_sql = $ls_sql . " and promocion.id_curso = ".  pg_result($resultado_query_curso, $i, 4) ." and ";
		$ls_sql = $ls_sql . " rdb = $ls_institucion and id_ano = $li_ano__";
				
		$resultado_query = pg_exec($conexion,$ls_sql);
		$total_filas= pg_numrows($resultado_query);
		if ($total_filas>0){
			$li_alum_reprob_rend = pg_result($resultado_query,0,0);
		}

	//CANTIDAD DE ALUMNOS INGRESADOS ENTRE EL 1 DE MAYO Y EL 29 DE NOVIEMBRE
		$ls_sql = " SELECT Count(*) AS cant From matricula WHERE to_char(matricula.fecha,'yyyymmdd') > '".$li_ano."0430' ";
		$ls_sql = $ls_sql . " and to_char(matricula.fecha,'yyyymmdd') <= '".$li_ano."1130' AND ";
		$ls_sql = $ls_sql . " matricula.id_curso = ". pg_result($resultado_query_curso, $i, 4) ." and rdb = $ls_institucion";
		//$ls_sql = $ls_sql . " and promocion.id_curso = ". pg_result($resultado_query_curso, $i, 4) ."  ";
		$ls_sql = $ls_sql . " and id_ano = $li_ano__ ";
		
		$resultado_query = pg_exec($conexion,$ls_sql);
		$total_filas= pg_numrows($resultado_query);
		if ($total_filas>0){
			$li_matr_01May_29Nov = pg_result($resultado_query,0,0);
		}
	
	//CANTIDAD DE ALUMNOS RETIRADOS ENTRE EL 1 DE MAYO Y EL 29 DE NOVIEMBRE
		$ls_sql = " select count(*) as cant from promocion where situacion_final = 3 and ";
		$ls_sql = $ls_sql . " (to_char(promocion.fecha_retiro,'yyyymmdd') > '".$li_ano."0430' ) ";
		$ls_sql = $ls_sql . " and (to_char(promocion.fecha_retiro,'yyyymmdd') < '".$li_ano."1130' ) ";
		$ls_sql = $ls_sql . " and promocion.id_curso = ". pg_result($resultado_query_curso, $i, 4) ." and rdb = $ls_institucion ";
		$ls_sql = $ls_sql . " and id_ano = $li_ano__ ";
		
		$resultado_query = pg_exec($conexion,$ls_sql);
		$total_filas= pg_numrows($resultado_query);
		if ($total_filas>0){
			$li_Ret_01May_29Nov = pg_result($resultado_query,0,0);
		}
	
	//ENCARGADO DEL ACTA = DIRECTOR DEL ESTABLECIMIENTO
		$ls_sql = " select empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp from empleado, trabaja where ";
		$ls_sql = $ls_sql . " trabaja.rut_emp = empleado.rut_emp and trabaja.cargo = 1 and trabaja.rdb = $ls_institucion; ";
		
		$resultado_query = pg_exec($conexion,$ls_sql);
		$total_filas= pg_numrows($resultado_query);
		if ($total_filas>0){
			$ls_nombre_encar_acta = pg_result($resultado_query,0,0)." ".pg_result($resultado_query,0,1)." ".pg_result($resultado_query,0,2);
		}
	//PROFESOR JEFE
		$ls_sql = " select empleado.ape_mat, empleado.ape_pat, empleado.nombre_emp from empleado, supervisa ";
		$ls_sql = $ls_sql . " where empleado.rut_emp = supervisa.rut_emp and supervisa.id_curso = ";
		$ls_sql = $ls_sql . pg_result($resultado_query_curso, $i, 4);

		$resultado_query = pg_exec($conexion,$ls_sql);
		$total_filas= pg_numrows($resultado_query);
		if ($total_filas>0){
			$ls_nombre_profe_jefe = pg_result($resultado_query,0,0)." ".pg_result($resultado_query,0,1)." ".pg_result($resultado_query,0,2);
		}

 $ls_string = "";
 $salto = "\n"; 	 
 $ls_espacio= chr(9);
 
	
 $ls_string = "7".chr(9).$li_rdb."$ls_espacio".$li_drdb."$ls_espacio"; 
 $ls_string = $ls_string .pg_result($resultado_query_curso,$i,2)."$ls_espacio".pg_result($resultado_query_curso,$i,1)."$ls_espacio"; 
 $ls_string = $ls_string .pg_result($resultado_query_curso,$i,0)."$ls_espacio".$li_ano."$ls_espacio"; 
 $ls_string = $ls_string . $li_matr_30Abril."$ls_espacio".$li_matr_30noviembre ."$ls_espacio".$li_alum_promovidos."$ls_espacio"; 
 $ls_string = $ls_string . $li_alum_reprob_Inas."$ls_espacio".$li_alum_reprob_rend ."$ls_espacio".$li_matr_01May_29Nov."$ls_espacio"; 
 $ls_string = $ls_string . $li_Ret_01May_29Nov."$ls_espacio".$ls_nombre_encar_acta."$ls_espacio".$ldt_fecha_inicio."$ls_espacio";
 $ls_string = $ls_string . $ls_nombre_encar_acta."$ls_espacio".$ls_nombre_profe_jefe."$salto";

 @ fwrite($fichero,"$ls_string"); 

}
fclose($fichero); 


pg_close($conexion);
?>	

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
        <?=($total_filas_curso-1)?>
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
