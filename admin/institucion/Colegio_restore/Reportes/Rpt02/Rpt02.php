<?include"../Coneccion/conexion.php"?>
<?
	$ls_criterio = $_GET["as_criterio"];
	$ls_input    = $_GET["as_input"];
	$ls_institucion    = $_GET["as_institucion"];
	$li_ano = $_GET["ai_ano"];
		
	//echo " --->  $ls_institucion  -- > $ls_input";
	
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
		$li_ano  = 0;
	}
	
	if(Trim($ls_criterio)!= '')
		{
			$ls_crit_busqueda = " and $ls_criterio like '%$ls_input%'";
		}
	else
		{
			$ls_crit_busqueda = "";
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
$sql = $sql . " $ls_crit_busqueda ";
//$sql = $sql . " group by institucion.rdb, institucion.dig_rdb, tipo_ense_inst.cod_tipo, ";
//$sql = $sql . " curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, plan_estudio.cod_decreto, ";
//$sql = $sql . " evaluacion.cod_eval, plan_estudio.cod_decreto, empleado.rut_emp, empleado.dig_rut, ";
//$sql = $sql . " empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat ";
$sql = $sql . " order by ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso ";


	
	//echo "SQL : $sql <br>";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);
	
	$sql = " select distinct a.rdb, c.nombre_instit, b.* from tipo_ense_inst a, tipo_ensenanza b, institucion c";
	$sql = $sql . " where a.cod_tipo = b.cod_tipo ";
	$sql = $sql . " and a.rdb = c.rdb and a.rdb = $ls_institucion and a.estado < 2";
//	$sql = $sql . " group by a.rdb, b.cod_tipo, b.nombre_tipo, c.nombre_instit order by 1,2;";
	
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

<table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
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
    <td width="93%" class="textosmediano">Establecimiento : <?print pg_result($resultado_query_cabecera, 0, 1);?> 
    </td>
    <td width="7%" class="textosgrande">&nbsp;</td>
  </tr>
  <tr> 
    <td class="textosmediano">Tipo Ense&ntilde;anza : 
      <?
		
	  
		For ($j=0; $j < $total_filas_cabecera; $j++)
			{
				$li_cod = pg_result($resultado_query_cabecera, $j, 2);
				$ls_nom = pg_result($resultado_query_cabecera, $j, 3);				
				echo "$ls_nom ($li_cod)     ";
			}
		?>
      <font size="2">&nbsp;</font> </td>
  </tr>
</table>
<br>
<table width="670" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="texto8px">
    <td>te</td>
    <td> <div align="center"><strong>Curso</strong></div></td>
    <td> <div align="center"><strong>Letra</strong></div></td>
    <td> <div align="center"><strong>A&ntilde;o <br>
        Escolar</strong></div></td>
    <td> <div align="center"><strong>Cod. <br>
        Decreto</strong></div></td>
    <td> <div align="center"><strong>Cod. <br>
        Evaluaci&Oacute;n</strong></div></td>
    <td> <div align="center"><strong>Run <br>
        Profesor</strong></div></td>
    <td> <div align="center"><strong>Nombre y apellidos Profesor</strong></div></td>
  </tr>
  <?
For ($j=0; $j < $total_filas; $j++)
{
?>
  <tr class="texto8px">
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 2));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 3));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 4));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 5));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 6));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 7));?></td>
    <td><?print Trim(pg_result($resultado_query, $j, 9));?>-<?print Trim(pg_result($resultado_query, $j, 10));?></td>
    <td> <?print Trim(pg_result($resultado_query, $j, 11));?>&nbsp;<?print Trim(pg_result($resultado_query, $j, 12));?>&nbsp;<?print Trim(pg_result($resultado_query, $j, 13));?> 
    </td>
  </tr>
  <?
}
}
?>
</table>
</body>
</html>
