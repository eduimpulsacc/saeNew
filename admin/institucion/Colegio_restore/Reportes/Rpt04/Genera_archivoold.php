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
			$ls_crit_curso 		= " ";
			$ls_crit_letra 		= " ";
			$ls_crit_tipo_ense  = " ";


	$ls_sql = "select distinct 0 as eximido, institucion.rdb, institucion.dig_rdb, tipo_ensenanza.cod_tipo, ";
	$ls_sql = $ls_sql . " curso.grado_curso,  ";
	$ls_sql = $ls_sql . " curso.letra_curso, ano_escolar.nro_ano, alumno.rut_alumno,  ";
	$ls_sql = $ls_sql . " alumno.dig_rut,  ";
	$ls_sql = $ls_sql . " plan_estudio.cod_decreto, plan_estudio.cod_plan,  ";
	$ls_sql = $ls_sql . " subsector.cod_subsector,  ";
	$ls_sql = $ls_sql . " subsector.nombre, 0 as tpromedio, 1000 as tipo ";
	$ls_sql = $ls_sql . " from institucion, curso, tipo_ensenanza, ano_escolar, matricula, alumno, plan_estudio, ";
	$ls_sql = $ls_sql . " ramo, subsector ";
	$ls_sql = $ls_sql . " where curso.ensenanza = tipo_ensenanza.cod_tipo  ";
	$ls_sql = $ls_sql . " and curso.id_ano = ano_escolar.id_ano  ";
	$ls_sql = $ls_sql . " and curso.id_ano = matricula.id_ano  ";
	$ls_sql = $ls_sql . " and curso.id_curso = matricula.id_curso  ";
	$ls_sql = $ls_sql . " and matricula.rut_alumno = alumno.rut_alumno  ";
	$ls_sql = $ls_sql . " and institucion.rdb = matricula.rdb  ";
	$ls_sql = $ls_sql . " and curso.cod_decreto = plan_estudio.cod_decreto  ";
	$ls_sql = $ls_sql . " and curso.id_curso = ramo.id_curso ";
	$ls_sql = $ls_sql . " and ramo.cod_subsector = subsector.cod_subsector ";
	$ls_sql = $ls_sql . " and matricula.rdb = $ls_institucion  ";
	//$ls_sql = $ls_sql . " $ls_crit_curso $ls_crit_letra	$ls_crit_tipo_ense ";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano and tipo_ensenanza.cod_tipo > 100 and ";
	$ls_sql = $ls_sql . " ramo.id_ramo not in  ";
	$ls_sql = $ls_sql . " ( ";
	$ls_sql = $ls_sql . " select id_ramo from  ";
	$ls_sql = $ls_sql . " tiene3 where  ";
	$ls_sql = $ls_sql . " rut_alumno = alumno.rut_alumno and id_ramo = ramo.id_ramo ";
	$ls_sql = $ls_sql . "  and tiene3.id_curso = curso.id_curso ";
	$ls_sql = $ls_sql . " )  ";
	$ls_sql = $ls_sql . " group by institucion.rdb, institucion.dig_rdb, tipo_ensenanza.cod_tipo, curso.grado_curso,  ";
	$ls_sql = $ls_sql . " curso.letra_curso, ano_escolar.nro_ano, alumno.rut_alumno, alumno.dig_rut,  ";
	$ls_sql = $ls_sql . " plan_estudio.cod_decreto, plan_estudio.cod_plan,  subsector.cod_subsector,  ";
	$ls_sql = $ls_sql . " subsector.nombre ";
	//$ls_sql = $ls_sql . " //order by alumno.rut_alumno ";
	$ls_sql = $ls_sql . " union ";
	$ls_sql = $ls_sql . " select distinct 1 as eximido, institucion.rdb, institucion.dig_rdb, tipo_ensenanza.cod_tipo,  ";
	$ls_sql = $ls_sql . " curso.grado_curso,  ";
	$ls_sql = $ls_sql . " curso.letra_curso, ano_escolar.nro_ano, alumno.rut_alumno,  ";
	$ls_sql = $ls_sql . " alumno.dig_rut,  ";
	$ls_sql = $ls_sql . " plan_estudio.cod_decreto, plan_estudio.cod_plan,  ";
	$ls_sql = $ls_sql . " subsector.cod_subsector,  ";
	$ls_sql = $ls_sql . " subsector.nombre, ";
	$ls_sql = $ls_sql . " (sum(case promedio ";
	$ls_sql = $ls_sql . " when 'MB' then 70 ";
	$ls_sql = $ls_sql . " when 'B' then 60 ";
	$ls_sql = $ls_sql . " when 'S' then 50 ";
	$ls_sql = $ls_sql . " when 'I' then 30 ";
	$ls_sql = $ls_sql . " when ' ' then 0 ";
	$ls_sql = $ls_sql . " else ";
	$ls_sql = $ls_sql . " to_number(promedio, 99) ";
	$ls_sql = $ls_sql . " end)) / (count(id_periodo)) as tpromedio,sum(case promedio ";
	$ls_sql = $ls_sql . " when 'MB' then 100 ";
	$ls_sql = $ls_sql . " when 'B' then 100 ";
	$ls_sql = $ls_sql . " when 'S' then 100 ";
	$ls_sql = $ls_sql . " when 'I' then 100 ";
	$ls_sql = $ls_sql . " when ' ' then 100 ";
	$ls_sql = $ls_sql . " else 10 end) as tipo ";
	$ls_sql = $ls_sql . " from institucion, curso, tipo_ensenanza, ano_escolar, matricula, alumno, plan_estudio, ";
	$ls_sql = $ls_sql . " ramo, subsector, notas ";
	$ls_sql = $ls_sql . " where curso.ensenanza = tipo_ensenanza.cod_tipo  ";
	$ls_sql = $ls_sql . " and curso.id_ano = ano_escolar.id_ano  ";
	$ls_sql = $ls_sql . " and curso.id_ano = matricula.id_ano  ";
	$ls_sql = $ls_sql . " and curso.id_curso = matricula.id_curso "; 
	$ls_sql = $ls_sql . " and matricula.rut_alumno = alumno.rut_alumno  ";
	$ls_sql = $ls_sql . " and institucion.rdb = matricula.rdb  ";
	$ls_sql = $ls_sql . " and curso.cod_decreto = plan_estudio.cod_decreto  ";
	$ls_sql = $ls_sql . " and curso.id_curso = ramo.id_curso ";
	$ls_sql = $ls_sql . " and ramo.cod_subsector = subsector.cod_subsector ";
	$ls_sql = $ls_sql . " and alumno.rut_alumno = notas.rut_alumno ";
	$ls_sql = $ls_sql . " and matricula.rut_alumno = notas.rut_alumno ";
	$ls_sql = $ls_sql . " and ramo.id_ramo = notas.id_ramo ";
	$ls_sql = $ls_sql . " and matricula.rdb = $ls_institucion  ";
	//$ls_sql = $ls_sql . " $ls_crit_curso $ls_crit_letra	$ls_crit_tipo_ense ";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano and tipo_ensenanza.cod_tipo > 100 and ";
	$ls_sql = $ls_sql . " ramo.id_ramo  in  ";
	$ls_sql = $ls_sql . " ( ";
	$ls_sql = $ls_sql . " select id_ramo from  ";
	$ls_sql = $ls_sql . " tiene3 where  ";
	$ls_sql = $ls_sql . " rut_alumno = alumno.rut_alumno and id_ramo = ramo.id_ramo ";
	$ls_sql = $ls_sql . "  and tiene3.id_curso = curso.id_curso ";
	$ls_sql = $ls_sql . " )  ";
	$ls_sql = $ls_sql . " group by institucion.rdb, institucion.dig_rdb, tipo_ensenanza.cod_tipo, curso.grado_curso,  ";
	$ls_sql = $ls_sql . " curso.letra_curso, ano_escolar.nro_ano, alumno.rut_alumno, alumno.dig_rut,  ";
	$ls_sql = $ls_sql . " plan_estudio.cod_decreto, plan_estudio.cod_plan,  subsector.cod_subsector,  ";
	$ls_sql = $ls_sql . " subsector.nombre, notas.promedio ";

	 
	//echo " <br> $ls_sql" ;
	 
	$resultado_query= pg_exec($conexion,$ls_sql);
	$total_filas= pg_numrows($resultado_query);

	pg_close($conexion);
	
		$fichero = fopen("../Archivos/archivo04.txt", "w"); 
	
For ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\n"; 	 
 $ls_espacio= chr(9);
 
 $li_rdb =  pg_result($resultado_query, $j, 1);
 $li_dig_rdb = pg_result($resultado_query, $j, 2);
 $li_cod_tipo = pg_result($resultado_query, $j, 3);
 $li_grado_curso = pg_result($resultado_query, $j, 4);
 $ls_letra_curso = pg_result($resultado_query, $j, 5);
 $li_ano_escolar = pg_result($resultado_query, $j, 6); 
 $li_rut_estud  = pg_result($resultado_query, $j, 7);
 $li_dig_verif  = pg_result($resultado_query, $j, 8); 
// $li_cod_comuna = substr("00000",1,5-strlen(pg_result($resultado_query, $j, 12))).pg_result($resultado_query, $j, 12); 
 $li_cod_decreto = pg_result($resultado_query, $j, 9);
 $li_cod_plan = pg_result($resultado_query, $j, 10);
 $li_cod_subsector = pg_result($resultado_query, $j, 11);

	if (pg_result($resultado_query, $j, 0)==1){
		//$ls_eximido = "  ";
		//$ls_prom = pg_result($resultado_query, $j, 13); 		
		if(pg_result($resultado_query, $j, 14)>999){
			$ls_prom = "  ";
			$ls_eximido = "Ex";
			$ls_prom_conc = "  ";
		}elseif (pg_result($resultado_query, $j, 14) < 100 ){
			$ls_prom = pg_result($resultado_query, $j, 13);
			$ls_eximido = "  ";
			$ls_prom_conc = "  ";
		}elseif((pg_result($resultado_query, $j, 14) > 99) and (pg_result($resultado_query, $j, 14) < 1000)){
			$ls_prom = "  ";
			$ls_eximido = "  ";
			//$ls_prom_conc = "  ";
			if(pg_result($resultado_query, $j, 13) <40){
				$ls_prom_conc = " I";
			}elseif((pg_result($resultado_query, $j, 13) >=40) and (pg_result($resultado_query, $j, 13) <50)){
				$ls_prom_conc = " S";
			}elseif((pg_result($resultado_query, $j, 13) >=50) and (pg_result($resultado_query, $j, 13) <60)){
				$ls_prom_conc = " B";
			}elseif((pg_result($resultado_query, $j, 13) >=60) and (pg_result($resultado_query, $j, 13) <=70)){
				$ls_prom_conc = "MB";
			}
		}
			
	}else{
		$ls_prom_conc = "  ";
		$ls_eximido = "Ex";
		$ls_prom = "  ";
	}
	if (trim($ls_prom)!=''){
		$ls_prom2 = number_format($ls_prom,0);
	}else{
		$ls_prom2 = "  ";
	}
 $ls_string = "4".chr(9).$li_rdb."$ls_espacio".$li_dig_rdb."$ls_espacio"; 
 $ls_string = $ls_string . $li_cod_tipo."$ls_espacio".$li_grado_curso."$ls_espacio"; 
 $ls_string = $ls_string . $ls_letra_curso."$ls_espacio".$li_ano_escolar."$ls_espacio"; 
 $ls_string = $ls_string . $li_rut_estud."$ls_espacio".$li_dig_verif ."$ls_espacio".$li_cod_decreto."$ls_espacio"; 
 $ls_string = $ls_string . $li_cod_plan."$ls_espacio".$li_cod_subsector ."$ls_espacio".$ls_prom2."$ls_espacio"; 
 $ls_string = $ls_string . $ls_prom_conc."$ls_espacio".$ls_eximido."$salto"; 
 
 @ fwrite($fichero,"$ls_string"); 
 
}
fclose($fichero); 

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
