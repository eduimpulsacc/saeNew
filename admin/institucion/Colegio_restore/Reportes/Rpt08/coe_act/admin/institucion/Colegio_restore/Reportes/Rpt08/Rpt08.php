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
	//**************************************************
	
	$sql = " select institucion.rdb, institucion.dig_rdb, ano_escolar.id_ano ";
	$sql = $sql . " from institucion, ano_escolar ";
	$sql = $sql . " where institucion.rdb = ano_escolar.id_institucion ";
	$sql = $sql . " and institucion.rdb = $ls_institucion ";
	$sql = $sql . " and ano_escolar.nro_ano = $li_ano; ";
	$resultado_query_cab= pg_exec($conexion,$sql);
	$total_filas_cab= pg_numrows($resultado_query_cab);
	
	if ($total_filas_cab>0){
		$li_rdb 		= pg_result($resultado_query_cab, 0, 0);
		$li_drdb 	= pg_result($resultado_query_cab, 0, 1);
		$li_ano__ 	= pg_result($resultado_query_cab, 0, 2);	
	}else{
		$li_rdb 		= 0;
		$li_drdb 	= 0;
		$li_ano__ 	= 0;
	}
		
	$sql = " select distinct subsector.cod_subsector, subsector.nombre from ramo, curso, subsector where curso.id_curso = ramo.id_curso ";
	$sql = $sql . " and ramo.cod_subsector = subsector.cod_subsector and curso.id_ano = $li_ano__ order by cod_subsector;";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);

	

	$sql = " select distinct a.rdb, c.nombre_instit, b.* from tipo_ense_inst a, tipo_ensenanza b, institucion c";
	$sql = $sql . " where a.cod_tipo = b.cod_tipo ";
	$sql = $sql . " and a.rdb = c.rdb and a.rdb = $ls_institucion and a.estado < 2";

	$resultado_query_cabecera= pg_exec($conexion,$sql);
	$total_filas_cabecera= pg_numrows($resultado_query_cabecera);
		
	pg_close($conexion);

?>

<html>
<head>
<title>rpt8</title>
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

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="textosgrande"> 
    <td class="titulos"><font size="3"><strong>Subsectores, Asignaturas o M&Oacute;dulos<br>
      <br>
      </strong></font></td>
    <td width="10%" valign="top"> 
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
  <tr class="textosgrande"> 
    <td width="90%">Establecimiento : <?print pg_result($resultado_query_cabecera, 0, 1);?></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr class="textosgrande"> 
    <td colspan="2">tipo ense&ntilde;anza :<span class="textosmediano"> 
      <?
		For ($j=0; $j < $total_filas_cabecera; $j++)
			{
				$li_cod = pg_result($resultado_query_cabecera, $j, 2);
				$ls_nom = pg_result($resultado_query_cabecera, $j, 3);				
				echo "$ls_nom ($li_cod)     ";
			}
		?>
      </span></td>
  </tr>
  <tr class="textosgrande"> 
    <td colspan="2">A&ntilde;o Escolar : 
      <?=($li_ano)?>
    </td>
  </tr>
</table>
<br>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="titulos"> 
    <td>C&Oacute;digo Asignatura</td>
    <td>Descripci&oacute;n Asignatura</td>
  </tr>
  <?
For ($j=0; $j < $total_filas; $j++)
{
?>
  <tr class="textosmediano"> 
    <td ><?print pg_result($resultado_query, $j, 0);?></td>
    <td><?print pg_result($resultado_query, $j, 1);?></td>
  </tr>
  <?
}
}
?>
</table>
</body>
</html>
