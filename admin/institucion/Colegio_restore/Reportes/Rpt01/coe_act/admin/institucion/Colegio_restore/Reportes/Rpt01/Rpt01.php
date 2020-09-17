<?include"../Coneccion/conexion.php"?>
<?
	$ls_criterio = $_GET["as_criterio"];
	$ls_input    = $_GET["as_input"];
	$ls_institucion    = $_GET["as_institucion"];
	$li_ano    = $_GET["ai_ano"];
		
	//echo " --->  $ls_institucion  -- > $ls_input";
	
	If(Trim($ls_institucion) == '')
	{
		$ls_institucion=0;
		$li_ano  = 0;
	}
	
	if(Trim($ls_criterio)!= '')
		{
			$ls_crit_busqueda = " and Upper($ls_criterio) like Upper('$ls_input%')";
		}
	else
		{
			$ls_crit_busqueda = "";
		}
	
	$sql = "select institucion.nombre_instit,  ";
	$sql = $sql . " alumno.rut_alumno, alumno.dig_rut, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, ";
	$sql = $sql . " alumno.sexo, alumno.fecha_nac, alumno.nacionalidad, institucion.rdb,institucion.dig_rdb ";
	$sql = $sql . " from alumno, matricula, institucion, ano_escolar ";
	$sql = $sql . " where alumno.rut_alumno = matricula.rut_alumno and matricula.id_ANO = ano_escolar.id_ano ";
	$sql = $sql . " and institucion.rdb = matricula.rdb and institucion.rdb = $ls_institucion  and ano_escolar.nro_ano = $li_ano";
	$sql = $sql . " $ls_crit_busqueda group by institucion.nombre_instit, alumno.rut_alumno, alumno.dig_rut,   ";
	$sql = $sql . " alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, alumno.sexo, alumno.fecha_nac,   ";
	$sql = $sql . " alumno.nacionalidad, institucion.rdb,institucion.dig_rdb order by alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu"; 
	 //echo "--> $sql";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);
	
	pg_close($conexion);

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
<?
If($total_filas!='')
	{
?>
<table width="670" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td class="titulos"> <div align="center"><font size="3">N&Oacute;mina de estudiantes</font></div></td>
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
    <td width="88%" class="textosgrande"><br>
      <br>
      Establecimiento: <?print pg_result($resultado_query, 0, 0);?><font face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="12%" class="textosgrande">&nbsp; </td>
  </tr>
</table>
<br>
<table width="670" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="textosmediano"> 
    <td><div align="center"><strong>Rut alumno</strong></div></td>
    <td><div align="center"><strong>Apellido<br>
        paterno</strong></div></td>
    <td><div align="center"><strong>Apellido <br>
        Materno</strong></div></td>
    <td><div align="center"><strong>Nombres </strong></div></td>
    <td><div align="center"><strong>Sexo</strong></div></td>
    <td><div align="center"><strong>Fecha Nac.</strong></div></td>
    <td><div align="center"><strong>Indicador<br>
        Alumno Ext.</strong></div></td>
  </tr>
  <?
For ($j=0; $j < $total_filas; $j++)
{
?>
  <tr class="textosmediano"> 
    <td >&nbsp;<?print pg_result($resultado_query, $j, 1);?>-<?print pg_result($resultado_query, $j, 2);?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 3));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 4));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 5));?> <?print Trim(pg_result($resultado_query, $j, 3));?> 
      <?print Trim(pg_result($resultado_query, $j, 4));?> </td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 6));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 7));?></td>
    <td>&nbsp;<?print Trim(pg_result($resultado_query, $j, 8));?></td>
  </tr>
  <?
}
}
?>
</table>
</body>
</html>
