<?include"../Coneccion/conexion.php"?>
<?
	$ls_criterio = $_GET["as_criterio"];
	$ls_input    = $_GET["as_input"];
	$ls_institucion    = $_GET["as_institucion"];
		
	//echo " --->  $ls_institucion  -- > $ls_input";
	
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
	}
	
	if(Trim($ls_criterio)!= '')
		{
			$ls_crit_busqueda = " and $ls_criterio like '%$ls_input%'";
		}
	else
		{
			$ls_crit_busqueda = "";
		}

$sql = " select institucion.rdb, institucion.dig_rdb,  curso.grado_curso, ";
$sql = $sql . " curso.letra_curso, ano_escolar.id_ano, ano_escolar.nro_ano, ano_escolar.id_institucion,  ";
$sql = $sql . " evaluacion.cod_eval, plan_estudio.cod_decreto, plan_estudio.cod_plan, empleado.rut_emp, ";
$sql = $sql . " empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat  ";
$sql = $sql . " from institucion, curso, ano_escolar, plan_estudio, supervisa, empleado, evaluacion, matricula  ";
$sql = $sql . " where matricula.rdb = institucion.rdb ";
$sql = $sql . " and matricula.id_ano = ano_escolar.id_ano  ";
$sql = $sql . " and matricula.id_curso = curso.id_curso ";
$sql = $sql . " and curso.id_ano = ano_escolar.id_ano  ";
$sql = $sql . " and curso.cod_decreto = plan_estudio.cod_decreto  ";
$sql = $sql . " and curso.id_curso = supervisa.id_curso  ";
$sql = $sql . " and empleado.rut_emp = supervisa.rut_emp  ";
$sql = $sql . " and curso.cod_decreto = plan_estudio.cod_decreto  ";
$sql = $sql . " and curso.cod_eval = evaluacion.cod_eval  ";
$sql = $sql . " and ano_escolar.id_institucion = $ls_institucion  ";
$sql = $sql . " $ls_crit_busqueda  ";
$sql = $sql . " group by institucion.rdb, institucion.dig_rdb,  curso.grado_curso,  ";
$sql = $sql . " curso.letra_curso, ano_escolar.id_ano, ano_escolar.nro_ano, ano_escolar.id_institucion,  ";
$sql = $sql . " evaluacion.cod_eval, plan_estudio.cod_decreto, plan_estudio.cod_plan, empleado.rut_emp, ";
$sql = $sql . " empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat ";
$sql = $sql . " order by id_institucion, nro_ano, grado_curso, letra_curso;  ";

	
	//echo "SQL : $sql";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);
	
	$sql = " select a.rdb, b.*, c.nombre_instit from tipo_ense_inst a, tipo_ensenanza b, institucion c";
	$sql = $sql . " where a.cod_tipo = b.cod_tipo ";
	$sql = $sql . " and a.rdb = c.rdb and a.rdb = $ls_institucion and a.estado < 2";
	$sql = $sql . " group by a.rdb, b.cod_tipo, b.nombre_tipo, c.nombre_instit order by 1,2;";
	
	//echo "SQL : $sql";
	$resultado_query_cabecera= pg_exec($conexion,$sql);
	$total_filas_cabecera= pg_numrows($resultado_query_cabecera);
	
	pg_close($conexion);

?>

<html>
<head>
<title>Rpt02</title>
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
If($total_filas!='')
	{
?>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="titulos"><font size="3"><strong>informaci&oacute;n del curso<br>
      <br>
      </strong></font></td>
    <td class="textosgrande"><div id="capa0"> 
        <input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="cb_submit_9_x_75" 
		id="cmdimprimiroriginal" 
		onclick="imprimir();" 
		value="Imprimir">
      </div></td>
  </tr>
  <tr> 
    <td width="93%" class="textosmediano">Establecimiento : <?print pg_result($resultado_query_cabecera, 0, 3);?> 
    </td>
    <td width="7%" class="textosgrande">&nbsp;</td>
  </tr>
  <tr> 
    <td class="textosmediano">Tipo Ense&ntilde;anza : 
      <?
		
	  
		For ($j=0; $j < $total_filas_cabecera; $j++)
			{
				$li_cod = pg_result($resultado_query_cabecera, $j, 1);
				$ls_nom = pg_result($resultado_query_cabecera, $j, 2);				
				echo "$ls_nom ($li_cod)     ";
			}
		?>
      <font size="2">&nbsp;</font> </td>
  </tr>
</table>
<br>
<table width="750" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="textosmediano"> 
    <td><div align="center"><strong>Curso</strong></div></td>
    <td><div align="center"><strong>Letra</strong></div></td>
    <td><div align="center"><strong>A&ntilde;o Escolar</strong></div></td>
    <td><div align="center"><strong>Cod. Decreto</strong></div></td>
    <td><div align="center"><strong>Cod plan De estudios</strong></div></td>
    <td><div align="center"><strong>Run Profesor</strong></div></td>
    <td><div align="center"><strong>Nombre y apellidos Profesor</strong></div></td>
  </tr>
  <?
For ($j=0; $j < $total_filas; $j++)
{
?>
  <tr class="textosmediano"> 
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 2));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 3));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 5));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 7));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 9));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 10));?>-<?print Trim(pg_result($resultado_query, $j, 11));?></td>
    <td>&nbsp; <?print Trim(pg_result($resultado_query, $j, 12));?>&nbsp;<?print Trim(pg_result($resultado_query, $j, 13));?>&nbsp;<?print Trim(pg_result($resultado_query, $j, 14));?> 
    </td>
  </tr>
  <?
}
}
?>
</table>
</body>
</html>
