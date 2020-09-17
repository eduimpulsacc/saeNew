<?include"../Coneccion/conexion.php"?>
<?
	$li_curso = $_GET["ai_curso"];
	$ls_letra = $_GET["as_letra"];
	$li_tipo_ense = $_GET["ai_tipo_ense"];
	$li_ano = $_GET["ai_ano"];
	$ls_criterio = $_GET["as_criterio"];
	$ls_input    = $_GET["as_input"];
	$ls_institucion    = $_GET["as_institucion"];
	$li_id = $_GET["ai_id"];
	
	//echo "ID : $li_id";
	//echo "--> $ls_criterio <br> --> $ls_input <br> --> $ls_institucion  <br> --> ";
	//**************************************************
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
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
			$ls_crit_ano 		= " and ano_escolar.nro_ano = $li_ano";
			
		}
	else
		{
			$ls_crit_curso 		= " ";
			$ls_crit_letra 		= " ";
			$ls_crit_tipo_ense  = " ";
			$ls_crit_ano 		= " ";
		}
	
	
	
	$sql = "select institucion.rdb, institucion.dig_rdb,"; 
	$sql = $sql . " tipo_ensenanza.cod_tipo, curso.grado_curso, curso.letra_curso,";
	$sql = $sql . " ano_escolar.id_ano, ano_escolar.nro_ano, alumno.rut_alumno, alumno.dig_rut, alumno.ape_pat, ";
	$sql = $sql . " alumno.ape_mat, alumno.nombre_alu, comuna.cor_com, comuna.nom_com, tipo_ensenanza.nombre_tipo";
	$sql = $sql . " from institucion, curso, tipo_ensenanza, ano_escolar, matricula, alumno, comuna";
	$sql = $sql . " where curso.ensenanza = tipo_ensenanza.cod_tipo	and curso.id_ano = ano_escolar.id_ano";
	$sql = $sql . " and curso.id_ano = matricula.id_ano	and curso.id_curso = matricula.id_curso";
	$sql = $sql . " and matricula.rut_alumno = alumno.rut_alumno and institucion.rdb = matricula.rdb and alumno.region = comuna.cod_reg";
	$sql = $sql . " and alumno.ciudad = comuna.cor_pro and alumno.comuna = comuna.cor_com and matricula.rdb = $ls_institucion";
	$sql = $sql . " and tipo_ensenanza.cod_tipo > 100 ";
if ($li_id == 0){
	$sql = $sql . " $ls_crit_busqueda $ls_crit_curso $ls_crit_letra $ls_crit_tipo_ense $ls_crit_ano  ";
}	
	$sql = $sql . " order by alumno.ape_pat,alumno.ape_mat, alumno.nombre_alu;";
	 
	//echo " <br> $sql" ;
	 
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);

	$sql ="select nombre_instit from institucion where rdb = $ls_institucion;";
	 
	//echo " <br> $sql" ;
	 
	$resultado_query_inst= pg_exec($conexion,$sql);
	$total_filas_inst= pg_numrows($resultado_query_inst);
		
	pg_close($conexion);

?>

<html>
<head>
<title>rpt3</title>
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
  <tr class="textosmediano"> 
    <td class="titulos" ><font size="3">estudiantes del curso<br>
      <br>
      </font></td>
    <td valign="top" >
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
    <td width="675" >Establecimiento : <?print pg_result($resultado_query_inst, 0, 0);?></td>
    <td width="75" > </td>
  </tr>
  <tr class="textosmediano"> 
    <td colspan="2">Tipo Ense&ntilde;anza : (<?print Trim(pg_result($resultado_query, 0, 2));?>) 
      <?print Trim(pg_result($resultado_query, 0, 14));?></td>
  </tr>
  <tr class="textosmediano"> 
    <td colspan="2">A&ntilde;o Escolar : 
      <?=($li_ano)?>
    </td>
  </tr>
  <tr class="textosmediano"> 
    <!--td colspan="2">Curso: 
      <?=($li_curso)?>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Letra 
      : 
      <?=($ls_letra)?>
    </td-->
  </tr>
</table>
<br>
<table width="670" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="textosdiminuto"> 
    <td class="textosdiminuto"> <div align="center"><strong>Run<br>
        Estudiante</strong></div></td>
    <td class="textosdiminuto"> <div align="center"><strong>Apellido<br>
        paterno</strong></div></td>
    <td class="textosdiminuto"> <div align="center"><strong>Apellido<br>
        Materno</strong></div></td>
    <td> <div align="center"><strong>Nombres</strong></div></td>
    <td> <div align="center"><strong>Comuna</strong></div></td>
  </tr>
  <?
For ($j=0; $j < $total_filas; $j++)
{
?>
  <tr class="texto8px"> 
    <td >&nbsp;<?print pg_result($resultado_query, $j, 7);?>-<?print pg_result($resultado_query, $j, 8);?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 9));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 10));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 11));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 13));?></td>
  </tr>
  <?
}
}
?>
</table>
</body>
</html>
