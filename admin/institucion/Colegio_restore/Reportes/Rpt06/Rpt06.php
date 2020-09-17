<?include"../Coneccion/conexion.php"?>
<?
	$li_curso = $_GET["ai_curso"];
	$ls_letra = $_GET["as_letra"];
	$li_tipo_ense = $_GET["ai_tipo_ense"];
	$li_ano = $_GET["ai_ano"];
	$ls_institucion    = $_GET["as_institucion"];
	$li_id    = $_GET["ai_id"];
	
	//echo "--> $ls_criterio <br> --> $ls_input <br> --> $ls_institucion  <br> --> ";
	//**************************************************
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
		$li_curso = 0;
		$ls_letra = 0;
		$li_tipo_ense = 0;
		$li_ano = 0;
	}
	
	$ls_sql = "select empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat,";
	$ls_sql = $ls_sql . " empleado.ape_mat, subsector.cod_subsector, subsector.nombre,";
	$ls_sql = $ls_sql . " curso.cod_decreto";
	$ls_sql = $ls_sql . " from  matricula, curso, tipo_ensenanza, ano_escolar, ramo, dicta, empleado, subsector";
	$ls_sql = $ls_sql . " where matricula.id_curso = curso.id_curso";
	$ls_sql = $ls_sql . " and matricula.id_ano = ano_escolar.id_ano";
	$ls_sql = $ls_sql . " and curso.ensenanza = tipo_ensenanza.cod_tipo";
	$ls_sql = $ls_sql . " and curso.id_ano = ano_escolar.id_ano";
	$ls_sql = $ls_sql . " and curso.id_curso = ramo.id_curso";
	$ls_sql = $ls_sql . " and ramo.id_ramo = dicta.id_ramo";
	$ls_sql = $ls_sql . " and dicta.rut_emp = empleado.rut_emp";
	$ls_sql = $ls_sql . " and subsector.cod_subsector = ramo.cod_subsector ";
	$ls_sql = $ls_sql . " and matricula.rdb = $ls_institucion";
	$ls_sql = $ls_sql . " and ano_escolar.nro_ano = $li_ano";
if ($li_id == 0){
	$ls_sql = $ls_sql . " and tipo_ensenanza.cod_tipo = $li_tipo_ense";
	$ls_sql = $ls_sql . " and curso.grado_curso = $li_curso";
	$ls_sql = $ls_sql . " and curso.letra_curso = '$ls_letra'";
}
	$ls_sql = $ls_sql . " group by empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat,";
	$ls_sql = $ls_sql . " empleado.ape_mat, subsector.cod_subsector, subsector.nombre,";
	$ls_sql = $ls_sql . " curso.cod_decreto;";
	 
	//echo " <br> $sql" ;
	 
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
<title>rpt06</title>
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
    <td class="titulos"><font size="3">Docentes de los Subsectores, Asignaturas 
      o M&Oacute;dulos<br>
      <br>
      </font></td>
    <td width="72" valign="top"> 
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
  <tr class="textosmediano"> 
    <td width="678">Establecimiento : <?print pg_result($resultado_query_inst, 0, 0);?></td>
    <td width="72">&nbsp;</td>
  </tr>
  <tr class="textosmediano"> 
    <td colspan="2">Tipo Ense&ntilde;anza : </td>
  </tr>
  <tr class="textosmediano"> 
    <td colspan="2">A&ntilde;o Escolar :<font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong> 
      </strong></font> 
      <?=($li_ano)?>
    </td>
  </tr>
  <tr> 
    <!--td colspan="2"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Curso:</font></strong> 
      <?=($li_curso)?>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong> 
      <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Letra :</font></strong>
      <?=($ls_letra)?>
    </td-->
  </tr>
</table>
<br>
<table width="670" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="texto8px"> 
    <td> <div align="center">Run</div></td>
    <td> <div align="center">Apellido <br>
        paterno</div></td>
    <td> <div align="center">Apellido <br>
        Materno</div></td>
    <td> <div align="center">Nombres</div></td>
    <td> <div align="center">descripci&Ograve;n<br>
        Asignatura </div></td>
    <td> <div align="center">c&Oacute;digo decreto<br>
        Plan de estudios</div></td>
  </tr>
  <?
For ($j=0; $j < $total_filas; $j++)
{
?>
  <tr class="texto8px"> 
    <td > <?print pg_result($resultado_query, $j, 0);?>-<?print pg_result($resultado_query, $j, 1);?> 
    </td>
    <td> <?print Trim(pg_result($resultado_query, $j, 3));?> </td>
    <td> <?print Trim(pg_result($resultado_query, $j, 4));?> </td>
    <td> <?print Trim(pg_result($resultado_query, $j, 2));?> </td>
    <td> <?print Trim(pg_result($resultado_query, $j, 6));?> </td>
    <td> <?print Trim(pg_result($resultado_query, $j, 7));?> </td>
  </tr>
  <?
}
}
?>
</table>
</body>
</html>
