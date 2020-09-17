<?include"../Coneccion/conexion.php"?>
<?
set_time_limit(1000);
	$li_ano = $_GET["ai_ano"];
	$ls_institucion    = $_GET["as_institucion"];
	
	If(Trim($ls_institucion) == ''){
		$ls_institucion=0;
		$li_ano = 0;
	}

$sql = " SELECT institucion.rdb, institucion.dig_rdb, curso.ensenanza, curso.grado_curso, curso.letra_curso,";
$sql = $sql . " ano_escolar.nro_ano, alumno.rut_alumno, alumno.dig_rut, curso.cod_decreto AS coddecreto1, curso.cod_decreto ";
$sql = $sql . " AS coddecreto2, ramo.cod_subsector, ramo.id_ramo, ramo.modo_eval FROM institucion, ramo, matricula, alumno, ";
$sql = $sql . " ano_escolar, curso where institucion.rdb = matricula.rdb and institucion.rdb = ano_escolar.id_institucion and ";
$sql = $sql . " matricula.rut_alumno = alumno.rut_alumno and matricula.id_curso = curso.id_curso and matricula.id_ano = ";
$sql = $sql . " ano_escolar.id_ano and curso.id_curso = ramo.id_curso and institucion.rdb = $ls_institucion and ano_escolar.nro_ano = $li_ano ";
$sql = $sql . " order by curso.ensenanza, curso.grado_curso, curso.letra_curso, alumno.rut_alumno  ; ";
	
	//echo "$sql";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);
$fichero = fopen("../Archivos/archivo04.txt", "w"); 
 For ($j=0; $j < $total_filas; $j++)
	{
		//Alumnos Eximidos
		$li_cant_notas =0;
		$li_cant_notas_c = 0;
		$li_promedio = "";
		$li_promedio_c = "";
		$ls_exim = "";
		
		$ls_sql = "select * from tiene3 where rut_alumno = '". pg_result($resultado_query, $j, 6) ."'";  
		$ls_sql = $ls_sql . " and id_ramo = ". pg_result($resultado_query, $j, 11);

		$resultado_query_TEMP2 = pg_exec($conexion,$ls_sql);
		$total_filas_TEMP2 = pg_numrows($resultado_query_TEMP2);
		
		if($total_filas_TEMP2 > 0){
			$ls_exim = "EX";
			$li_promedio = "  ";
			$li_promedio_c = "  "; 
		}else{		
			$ls_sql = "select promedio from notas where id_ramo =  ". pg_result($resultado_query, $j, 11);
			$ls_sql = $ls_sql . " and rut_alumno = '". pg_result($resultado_query, $j, 6) ."'";
			
			$resultado_query_TEMP = pg_exec($conexion,$ls_sql);
			$total_filas_TEMP = pg_numrows($resultado_query_TEMP);
			
			if($total_filas_TEMP > 0){
				for ($i=0;$i<$total_filas_TEMP;$i++){
					if (pg_result($resultado_query, $j, 12)==1){
						$li_promedio = $li_promedio + pg_result($resultado_query_TEMP, $i, 0);
						$ls_exim = "  ";
						$li_promedio_c = "  "; 					
					}else{
						if (Trim(pg_result($resultado_query_TEMP, $i, 0))== "MB") {
							$li_promedio_c = $li_promedio_c + 60;
							$ls_exim = "  ";
							$li_promedio = "   ";
						}elseif(Trim(pg_result($resultado_query_TEMP, $i, 0))== "B"){
							$li_promedio_c = $li_promedio_c + 50;
							$ls_exim = "  ";
							$li_promedio = "   ";
						}elseif(Trim(pg_result($resultado_query_TEMP, $i, 0))== "S"){
							$li_promedio_c = $li_promedio_c + 40;
							$ls_exim = "  ";
							$li_promedio = "   ";
						}elseif(Trim(pg_result($resultado_query_TEMP, $i, 0))== "I"){
							$li_promedio_c = $li_promedio_c + 30;
							$ls_exim = "  ";
							$li_promedio = "   ";
						}				
					}
				}
				
				if(pg_result($resultado_query, $j, 12)==1){
					if (is_numeric($li_promedio) != true){
					$li_promedio = 0;}
					
					$li_promedio = $li_promedio/$total_filas_TEMP;
					$li_promedio_c = "";
					$ls_exim = "";
				}else{
					if (is_numeric($li_promedio_c) != true){
						$li_promedio_c = 0;
						}
					$li_promedio_c = $li_promedio_c/$total_filas_TEMP;
					$li_promedio = "";
					$ls_exim = "";
					if ($li_promedio_c >59){
						$li_promedio_c = "MB";
					}elseif($li_promedio_c >49){
						$li_promedio_c = "B";
					}elseif($li_promedio_c >39){
						$li_promedio_c = "S";
					}elseif($li_promedio_c <40){
						$li_promedio_c = "I";
					}	
				}	
			}
		}
 $ls_string = "";
 $salto = "\n"; 	 
 $ls_espacio= chr(9);
 

	
	 $ls_string = "4".chr(9).pg_result($resultado_query, $j, 0)."$ls_espacio".pg_result($resultado_query, $j, 1)."$ls_espacio"; 
	 $ls_string = $ls_string . pg_result($resultado_query, $j, 2)."$ls_espacio".pg_result($resultado_query, $j, 3)."$ls_espacio"; 
	 $ls_string = $ls_string . pg_result($resultado_query, $j, 4)."$ls_espacio".pg_result($resultado_query, $j, 5)."$ls_espacio"; 
	 $ls_string = $ls_string . pg_result($resultado_query, $j, 6)."$ls_espacio".pg_result($resultado_query, $j, 7)."$ls_espacio"; 
	 $ls_string = $ls_string . pg_result($resultado_query, $j, 8)."$ls_espacio".pg_result($resultado_query, $j, 9)."$ls_espacio"; 
	 $ls_string = $ls_string . pg_result($resultado_query, $j, 10)."$ls_espacio".$li_promedio."$ls_espacio".$li_promedio_c."$ls_espacio"; 
	 $ls_string = $ls_string . $ls_exim."$salto"; 
	 
	 @ fwrite($fichero,"$ls_string"); 
 
	}
fclose($fichero); 
pg_close($conexion);
?>
<html>
<head>
<title>rpt4</title>
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
        archivo ha sido creado con el nombre de <a href='../Archivos/archivo04.txt'> 
        &quot; archivo04.txt &quot;</a> , en total se encontraron 
        <?=($total_filas)?>
        registros para el a&ntilde;o <b><?=($li_ano)?></b>.<br>
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
