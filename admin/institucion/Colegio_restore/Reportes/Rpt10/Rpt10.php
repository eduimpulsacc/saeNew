<?include"../Coneccion/conexion.php"?>
<?
	$ls_institucion = $_GET["as_institucion"];
	$ls_alumno = $_GET["as_alumno"];
	$li_ano = $_GET["ai_ano"];
	$li_periodo = $_GET["ai_periodo"];
	
	
	if ($ls_institucion=='')
		{
		$ls_institucion = 0;
		$ls_alumno = 0;
		$li_ano = 0;
		$li_periodo = 0;
		}
//	echo "$li_ano  <br> $li_periodo <br>";

	$ls_sql = "select anotacion.fecha, anotacion.causal, anotacion.observacion, anotacion.tipo, ";
	$ls_sql = $ls_sql . " anotacion.hora, empleado.nombre_emp, empleado.ape_pat, ape_mat  ";
	$ls_sql = $ls_sql . " from anotacion, empleado, matricula, ano_escolar, periodo  ";
	$ls_sql = $ls_sql . " where anotacion.rut_alumno = matricula.rut_alumno ";
	$ls_sql = $ls_sql . " and ano_escolar.id_ano = matricula.id_ano  ";
	$ls_sql = $ls_sql . " and ano_escolar.id_ano = periodo.id_ano ";
	$ls_sql = $ls_sql . " and anotacion.rut_emp = empleado.rut_emp  ";
	$ls_sql = $ls_sql . " and anotacion.fecha between periodo.fecha_inicio and periodo.fecha_termino ";
	$ls_sql = $ls_sql . " and periodo.id_periodo = $li_periodo ";
	$ls_sql = $ls_sql . " and anotacion.rut_alumno = $ls_alumno ";
	$ls_sql = $ls_sql . " and matricula.rdb = $ls_institucion  ";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano ";
	
	//echo "$ls_sql";
	
	$resultado_query= pg_exec($conexion,$ls_sql);
	$total_filas= pg_numrows($resultado_query);
	
	//-----------------------------------------------------------------------------------------------------------------
	//CABECERA
	
	$ls_sql = "select institucion.nombre_instit, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, ";
	$ls_sql = $ls_sql . "curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo ";
	$ls_sql = $ls_sql . "from matricula, institucion, tipo_ensenanza, alumno, curso ";
	$ls_sql = $ls_sql . "where matricula.rdb = institucion.rdb ";
	$ls_sql = $ls_sql . "and matricula.rut_alumno = alumno.rut_alumno ";
	$ls_sql = $ls_sql . "and matricula.id_curso = curso.id_curso ";
	$ls_sql = $ls_sql . "and curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$ls_sql = $ls_sql . "and institucion.rdb = $ls_institucion ";
	$ls_sql = $ls_sql . "and alumno.rut_alumno = $ls_alumno ";
	
	//echo " $ls_sql  ";
	
	$resultado_query_cabecera= pg_exec($conexion,$ls_sql);
	$total_filas_cabecera= pg_numrows($resultado_query_cabecera);
	
	
	pg_close($conexion);



?>
<html>
<head>
<title>Rpt09</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<br>
<?
if ($total_filas > 0)  
{
?>
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="titulos">
	<div id="capa0" align="right"> 
        <input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="cb_submit_9_x_75" 
		id="cmdimprimiroriginal" 
		onclick="imprimir();" 
		value="Imprimir">
      </div>
	</td>
  </tr>
  <tr> 
    <td class="titulos"> <div align="center"><font size="3"><?print Trim(pg_result($resultado_query_cabecera, 0, 0));?><br>
        <br>
        </font></div></td>
  </tr>
  <tr> 
    <td class="titulos">LISTADO DE ANOTACIONES POR ALUMNO<br>
      <br> </td>
  </tr>
  <tr> 
    <td class="textos"><strong>NOMBRE ALUMNO:</strong> <?print Trim(pg_result($resultado_query_cabecera, 0, 1));?> 
      <?print Trim(pg_result($resultado_query_cabecera, 0, 2));?> <?print Trim(pg_result($resultado_query_cabecera, 0, 3));?> 
    </td>
  </tr>
  <tr> 
    <td class="textos"><strong>CURSO ALUMNO:</strong> <?print Trim(pg_result($resultado_query_cabecera, 0, 4));?> 
      - <?print Trim(pg_result($resultado_query_cabecera, 0, 5));?> <?print Trim(pg_result($resultado_query_cabecera, 0, 6));?></td>
  </tr>
</table>
<br>
<table width="670" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="textosmediano"> 
    <td height="20"><div align="center"><strong>FECHA</strong></div></td>
    <td><div align="center"><strong>MOTIVO</strong></div></td>
    <td><div align="center"><strong>OBSERVACIONES</strong></div></td>
    <td><div align="center"><strong>HORA</strong></div></td>
    <td><div align="center"><strong>DOCENTE/EMPLEADO</strong></div></td>
  </tr>
  <?
For ($j=0; $j < $total_filas; $j++)
{
?>
  <tr class="textos"> 
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 0));?></td>
    <td>
	<?
	if(pg_result($resultado_query, $j, 3)==1){
		echo "Conducta";
	}elseif(pg_result($resultado_query, $j, 3)==2){
		echo "Atraso";
	}elseif(pg_result($resultado_query, $j, 3)==3){
		echo "Asistencia";
	}elseif(pg_result($resultado_query, $j, 3)==4){
		echo "Enfermeria";
	}
	
	?>
	</td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 2));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 4));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 5));?> <?print Trim(pg_result($resultado_query, $j, 6));?> 
      <?print Trim(pg_result($resultado_query, $j, 7));?> </td>
  </tr>
  <?
}
}
?>
</table>
</body>
</html>
