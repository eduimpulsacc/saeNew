<?include"../Coneccion/conexion.php"?>
<?
	$li_curso = $_GET["ai_curso"];
	$ls_letra = $_GET["as_letra"];
	$li_tipo_ense = $_GET["ai_tipo_ense"];
	$li_ano = $_GET["ai_ano"];
	$ls_criterio = $_GET["as_criterio"];
	$ls_input    = $_GET["as_input"];
	$ls_institucion    = $_GET["as_institucion"];
	$li_id    = $_GET["ai_id"];
	
	//echo "ID:  $li_id";
	//**************************************************
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
		$li_curso = 0;
		$ls_letra = 'Z';
		$li_tipo_ense = 0;
		$li_ano = 0;
		$ls_institucion    = 0;
	}
	
	$ls_sql = "select 5 as n_predef, institucion.rdb, institucion.dig_rdb, ";
	$ls_sql = $ls_sql . " tipo_ensenanza.cod_tipo, curso.grado_curso, curso.letra_curso, ";
	$ls_sql = $ls_sql . " ano_escolar.nro_ano, alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat,";
	$ls_sql = $ls_sql . " promocion.promedio, promocion.asistencia, promocion.situacion_final, tipo_ensenanza.nombre_tipo ";
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
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano ";
if ($li_id == 0){
	$ls_sql = $ls_sql . " and curso.grado_curso = $li_curso ";
	$ls_sql = $ls_sql . " and curso.letra_curso = '$ls_letra' ";
	$ls_sql = $ls_sql . " and tipo_ensenanza.cod_tipo = $li_tipo_ense ";
}	
	
	$resultado_query= pg_exec($conexion,$ls_sql);
	$total_filas= pg_numrows($resultado_query);

	$ls_sql ="select nombre_instit from institucion where rdb = $ls_institucion;";
	 
	//echo " <br> $sql" ;
	 
	$resultado_query_inst= pg_exec($conexion,$ls_sql);
	$total_filas_inst= pg_numrows($resultado_query_inst);
		
	pg_close($conexion);

?>

<html>
<head>
<title>rpt5</title>
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
    <td class="titulos"><font size="3">situaci&Oacute;n de promoci&Oacute;n de 
      los estudiantes<br>
      <br>
      </font></td>
    <td width="75" valign="top" class="textosgrande"> 
      <div id="capa0"> 
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
    <td width="675" class="textosgrande">Establecimiento : <?print pg_result($resultado_query_inst, 0, 0);?></td>
    <td width="75" class="textosgrande">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2" class="textosgrande">Tipo Ense&ntilde;anza : (<?print Trim(pg_result($resultado_query, 0, 3));?>) 
      <?print Trim(pg_result($resultado_query, 0, 15));?></td>
  </tr>
  <tr> 
    <td colspan="2" class="textosgrande">A&ntilde;o Escolar : 
      <?=($li_ano)?>
    </td>
  </tr>
  <tr> 
    <!--td colspan="2" class="textosgrande">Curso: 
      <?=($li_curso)?>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Letra 
      : 
      <?=($ls_letra)?>
    </td-->
  </tr>
</table>
<br>
<table width="670" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="texto8px"> 
    <td> 
      <div align="center"><strong>Run <br>
        Estudiante</strong></div></td>
    <td> 
      <div align="center"><strong>Apellido <br>
        paterno</strong></div></td>
    <td> 
      <div align="center"><strong>Apellido <br>
        Materno</strong></div></td>
    <td> 
      <div align="center"><strong>Nombres</strong></div></td>
    <td> 
      <div align="center"><strong>Prom.</strong></div></td>
    <td> 
      <div align="center"><strong>% Asis.</strong></div></td>
    <td> 
      <div align="center"><strong>Situacion <br>
        Final</strong></div></td>
  </tr>
  <?
For ($j=0; $j < $total_filas; $j++)
{
?>
  <tr class="texto8px"> 
    <td >&nbsp;<?print pg_result($resultado_query, $j, 7);?>-<?print pg_result($resultado_query, $j, 8);?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 10));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 11));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 9));?></td>
    <td>&nbsp;<?print number_format(pg_result($resultado_query, $j, 12)/10,1);?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 13));?></td>
    <td>&nbsp; 
      <?
	if (pg_result($resultado_query, $j, 14)==1)
		{echo "Promovido";}
	elseif (pg_result($resultado_query, $j, 14)==2)
		{echo "Reprobado";}
	elseif (pg_result($resultado_query, $j, 14)==3)
		{echo "Retirado";}?>
    </td>
  </tr>
  <?
}
}
?>
</table>
</body>
</html>
