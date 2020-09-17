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
		$li_ano = 0;
	}
	//**************************************************
	if(Trim($ls_criterio)!= '')
		{
			$ls_crit_busqueda = " and $ls_criterio like '%$ls_input%'";
		}
	else
		{
			$ls_crit_busqueda = "";
		}
	//**************************************************
	if(Trim($li_curso)!= '')
		{
			$ls_crit_curso 		= " and curso.grado_curso = $li_curso";
			$ls_crit_letra 		= " and curso.letra_curso = '$ls_letra'";
			$ls_crit_tipo_ense  = " and tipo_ensenanza.cod_tipo = $li_tipo_ense";
			//$ls_crit_ano 		= " and ano_escolar.nro_ano = $li_ano";
			
		}
	else
		{
			$ls_crit_curso 		= " ";
			$ls_crit_letra 		= " ";
			$ls_crit_tipo_ense  = " ";
			//$ls_crit_ano 		= " ";
		}
	
	
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
	$ls_sql = $ls_sql . " $ls_crit_curso $ls_crit_letra	$ls_crit_tipo_ense $ls_crit_busqueda";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano and ";
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
	$ls_sql = $ls_sql . " $ls_crit_curso $ls_crit_letra	$ls_crit_tipo_ense $ls_crit_busqueda";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano and ";
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
	 
	echo " <br> $ls_sql" ;
	 
	$resultado_query= pg_exec($conexion,$ls_sql);
	$total_filas= pg_numrows($resultado_query);

	$sql ="select nombre_instit from institucion where rdb = $ls_institucion;";
	 
	//echo " <br> $sql" ;
	 
	$resultado_query_inst= pg_exec($conexion,$sql);
	$total_filas_inst= pg_numrows($resultado_query_inst);
		
	pg_close($conexion);

?>

<html>
<head>
<title>rpt4</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
if($total_filas!='')
{ 
?>

<table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="titulos"><font size="3">Antecedentes Acad&eacute;micos de los Estudiantes<br>
      <br>
      </font></td>
    <td valign="top" class="textosmediano" > <div align="right" id="capa0"> 
        <input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="cb_submit_9_x_75" 
		id="cmdimprimiroriginal" 
		onclick="imprimir();" 
		value="Imprimir">
      </div></td>
  </tr>
  <tr class="textosmediano"> 
    <td width="84%">Establecimiento : <?print pg_result($resultado_query_inst, 0, 0);?></td>
    <td valign="top" >&nbsp;</td>
  </tr>
  <tr class="textosmediano"> 
    <td colspan="2">A&ntilde;o Escolar :<strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
      </font></strong> 
      <?=($li_ano)?>
    </td>
  </tr>
  <tr class="textosmediano"> 
    <td colspan="2">Curso: 
      <?=($li_curso)?>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Letra 
      : 
      <?=($ls_letra)?>
    </td>
  </tr>
</table>
<br>
<table width="670" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="texto8px"> 
    <td> <div align="center"><strong>Run <br>
        Estudiante</strong></div></td>
    <td> <div align="center"><strong>A&ntilde;o <br>
        escolar</strong></div></td>
    <td> <div align="center"><strong>Subsector</strong></div></td>
    <td> <div align="center"><strong>Calificaci&oacute;n</strong></div></td>
  </tr>
  <?
For ($j=0; $j < $total_filas; $j++)
{
?>
  <tr class="texto8px"> 
    <td >&nbsp;<?print pg_result($resultado_query, $j, 7);?>-<?print pg_result($resultado_query, $j, 8);?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 6));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 12));?></td>
    <td>&nbsp; 
      <?
		if (pg_result($resultado_query, $j, 0)==1){
		//$ls_eximido = "  ";
		//$ls_prom = pg_result($resultado_query, $j, 13); 		
		if(pg_result($resultado_query, $j, 14)>999){
			//$ls_prom = "  ";
			echo "Ex";
			//$ls_prom_conc = "  ";
		}elseif (pg_result($resultado_query, $j, 14) < 100 ){
			print number_format(pg_result($resultado_query, $j, 13),0);
			//$ls_eximido = "  ";
			//$ls_prom_conc = "  ";
		}elseif((pg_result($resultado_query, $j, 14) > 99) and (pg_result($resultado_query, $j, 14) < 1000)){
			//$ls_prom = "  ";
			//$ls_eximido = "  ";
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
			echo "$ls_prom_conc";
		}
			
	}else{
		//$ls_prom_conc = "  ";
		echo "Ex";
		//$ls_prom = "  ";
	}

	?>
    </td>
  </tr>
  <?
}
}
?>
</table>
</body>
</html>
