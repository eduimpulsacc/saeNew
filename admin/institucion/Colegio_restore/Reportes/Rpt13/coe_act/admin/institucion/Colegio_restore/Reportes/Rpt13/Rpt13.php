<?include"../Coneccion/conexion.php"?>
<?
	$li_curso = $_GET["ai_curso"];
	$ls_letra = $_GET["as_letra"];
	$li_tipo_ense = $_GET["ai_tipo_ense"];
	$li_ano = $_GET["ai_ano"];
	$ls_criterio = $_GET["as_criterio"];
	$ls_input    = $_GET["as_input"];
	$ls_institucion    = $_GET["as_institucion"];
	$li_periodo    = $_GET["ai_periodo"];
	///echo "$li_periodo";
	//echo "--> $ls_criterio <br> --> $ls_input <br> --> $ls_institucion  <br> --> ";
	//**************************************************
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
		$li_curso = 0;
		$ls_letra = 0;
		$li_tipo_ense = 0;
		$li_ano = 0;
		$li_periodo = 0;
	}	

	$ls_sql = " select alumno.rut_alumno , alumno.dig_rut as rut, alumno.ape_pat, ";
	$ls_sql = $ls_sql . " alumno.ape_mat, alumno.nombre_alu, matricula.id_curso, ano_escolar.id_ano , periodo.dias_habiles, ";
	$ls_sql = $ls_sql . " periodo.fecha_inicio, periodo.fecha_termino from alumno, matricula, ano_escolar, periodo, curso  ";
	$ls_sql = $ls_sql . " where matricula.rut_alumno = alumno.rut_alumno ";
	$ls_sql = $ls_sql . " and matricula.id_ano = ANO_escolar.id_ano ";
	$ls_sql = $ls_sql . " and ano_escolar.id_ano = periodo.id_ano ";
	$ls_sql = $ls_sql . " and curso.id_curso = matricula.id_curso ";
	$ls_sql = $ls_sql . " and curso.grado_curso = $li_curso ";
	$ls_sql = $ls_sql . " and curso.letra_curso = '$ls_letra' and ano_escolar.nro_ano = $li_ano";
	$ls_sql = $ls_sql . " and matricula.rdb = $ls_institucion and curso.ensenanza = $li_tipo_ense and periodo.id_periodo = $li_periodo";
	$ls_sql = $ls_sql . " group by alumno.rut_alumno , alumno.dig_rut, alumno.ape_pat, ";
	$ls_sql = $ls_sql . " alumno.ape_mat, alumno.nombre_alu,matricula.id_curso, ano_escolar.id_ano, ";
	$ls_sql = $ls_sql . " periodo.dias_habiles, periodo.fecha_inicio, periodo.fecha_termino ";

	//echo "$ls_sql";
	$resultado_query= pg_exec($conexion,$ls_sql);
	$total_filas= pg_numrows($resultado_query);
	
	$ls_sql ="select institucion.nombre_instit, tipo_ensenanza.nombre_tipo  ";
	$ls_sql = $ls_sql . " from institucion, matricula, curso, tipo_ensenanza, ano_escolar ";
	$ls_sql = $ls_sql . " where institucion.rdb = matricula.rdb ";
	$ls_sql = $ls_sql . " and curso.id_curso = matricula.id_curso ";
	$ls_sql = $ls_sql . " and ano_escolar.id_ano = matricula.id_ano ";
	$ls_sql = $ls_sql . " and curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$ls_sql = $ls_sql . " and institucion.rdb = $ls_institucion ";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano ";
	$ls_sql = $ls_sql . " and curso.grado_curso = $li_curso ";
	$ls_sql = $ls_sql . " and curso.letra_curso = '$ls_letra' ";
	$ls_sql = $ls_sql . " and tipo_ensenanza.cod_tipo = $li_tipo_ense ";
	$ls_sql = $ls_sql . " group by institucion.nombre_instit, tipo_ensenanza.nombre_tipo ;";
	 
	$resultado_query_inst= pg_exec($conexion,$ls_sql);
	$total_filas_inst= pg_numrows($resultado_query_inst);
	
//	pg_close($conexion);

?>
<html>
<head>
<title>Untitled Document</title>
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
<div align="center">
<?
if ($total_filas > 0){
if ($total_filas_inst > 0){
?>
  <table width="670" border="0" cellspacing="0" cellpadding="0">
    <tr class="textosgrande"> 
      <td class="titulos"><font size="3">Informe de asistencia<br>
        <br>
        </font></td>
      <td width="75" valign="top"> 
        <div id="capa0" align="right"> 
          <input 
		name="cmdimprimiroriginal" 
		type="button" 
		class="cb_submit_9_x_75" 
		id="cmdimprimiroriginal" 
		onclick="imprimir();" 
		value="Imprimir">
        </div></td>
    </tr>
    <tr class="textosgrande"> 
      <td width="675">Establecimiento : <?print pg_result($resultado_query_inst, 0, 0);?></td>
      <td width="75">&nbsp;</td>
    </tr>
    <tr class="textosgrande"> 
      <td colspan="2">Tipo de Ense&ntilde;anza : <?print pg_result($resultado_query_inst, 0, 1);?></td>
    </tr>
    <tr class="textosgrande"> 
      <td colspan="2">A&ntilde;o Escolar : 
        <?=($li_ano)?>
      </td>
    </tr>
    <tr class="textosgrande"> 
      <td colspan="2">Curso : 
        <?=($li_curso)?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Letra 
        : 
        <?=($ls_letra)?>
        : </td>
    </tr>
  </table>
 <?
 }
 ?>
  <br>
  <table width="670" border="1" cellspacing="0" cellpadding="0">
    <tr class="textosmediano"> 
      <td><div align="center"><strong>Run <br>
          Estudiante</strong></div></td>
      <td><div align="center"><strong>Apellido <br>
          Paterno</strong></div></td>
      <td><div align="center"><strong>Apellido <br>
          Materno</strong></div></td>
      <td><div align="center"><strong>Nombres</strong></div></td>
      <td><div align="center"><strong>N&ordm; <br>
          inasistencias</strong></div></td>
      <td><div align="center"><strong>Total dias <br>
          de Clase</strong></div></td>
      <td><div align="center"><strong>% Asist.<br>
          a la fecha</strong></div></td>
    </tr>
    <?
	For ($j=0; $j < $total_filas; $j++)
	{
	?>
    <tr class="texto8px"> 
      <td><?print pg_result($resultado_query, $j, 0);?>-<?print pg_result($resultado_query, $j, 1);?></td>
      <td><?print pg_result($resultado_query, $j, 2);?></td>
      <td><?print pg_result($resultado_query, $j, 3);?></td>
      <td><?print pg_result($resultado_query, $j, 4);?></td>
      <td>&nbsp;</td>
      <td><?print pg_result($resultado_query, $j, 7);?></td>
      <td> 
        <?
	  $ls_sql = "select count(*) from asistencia where rut_alumno = ". pg_result($resultado_query, $j, 0) . "and ";
	  $ls_sql = $ls_sql . " ano = ". pg_result($resultado_query, $j, 6) . " and id_curso = ";
	  $ls_sql = $ls_sql . pg_result($resultado_query, $j, 5);
	  $ls_sql = $ls_sql . " and fecha between '".pg_result($resultado_query, $j, 8)."' and '".pg_result($resultado_query, $j, 9)."'";
		
		//echo "$ls_sql <br>";
		$resultado_= pg_exec($conexion,$ls_sql);
		$total_= pg_numrows($resultado_);
		if (pg_result($resultado_, 0, 0) <= 0)
		{
			echo "0";
		}
		else
		{
			print number_format((pg_result($resultado_, 0, 0)/pg_result($resultado_query, $j, 7))*100,0);
		}
	  ?>
        % </td>
    </tr>
    <?
	}
	?>
  </table>
  <?
  }
  ?>
</div>
</body>
</html>
