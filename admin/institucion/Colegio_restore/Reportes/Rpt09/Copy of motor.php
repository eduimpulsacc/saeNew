<?include"../Coneccion/conexion.php"?>
<?
$li_institucion = $_GET["ai_institucion"];
	
$sql= "select  distinct(alumno.rut_alumno), alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat from alumno, matricula where ";
$sql = $sql . " alumno.rut_alumno = matricula.rut_alumno and matricula.rdb = $li_institucion order by alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat;";
$resultado_query_cue = pg_exec($conexion,$sql);
$total_filas_cue     = pg_numrows($resultado_query_cue);

pg_close($conexion);

$li_agno_actual = date(Y);
$li_cant_agno = $li_agno_actual - 2000;

?>
<html>
<head>
<title>Motor</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<link href="../css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="4" marginwidth="0" marginheight="0">
<FORM NAME="Listas" METHOD="POST" ACTION="">
  <table width="99%" border="1" align="center" cellpadding="1" cellspacing="0">
    <tr>
    <td>

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr> 
            <td colspan="2" class="titulosMotores">Busqueda Avanzada</td>
          </tr>
          <tr> 
            <td class="textosmediano">Buscar Por </td>
            <td> <select name="ddlb_alumno" class="ddlb_9_x">
                <?
		for ($j=0; $j<$total_filas_cue; $j++)
			{
		?>
                <option value="<?=(Trim(pg_result($resultado_query_cue, $j, 0)));?>"> 
                <?=(Trim(pg_result($resultado_query_cue, $j, 1)));?>
                <?=(Trim(pg_result($resultado_query_cue, $j, 2)));?>
                <?=(Trim(pg_result($resultado_query_cue, $j, 3)));?>
                </option>
                <?
			}
		?>
              </select> <select name="ddlb_ano" class="ddlb_9_x">
                <?
	For ($j=0; $j <= $li_cant_agno; $j++)
	{
		echo "<option value='200$j'";
		$li_agno_paso = "200".$j;
		if($li_agno_paso ==date(Y))
		{
			print "Selected";
		} 
		echo ">200$j</option> ";	
	}
	?>
              </select> <input name="cb_ok" type="button" class="cb_submit_9_x_75" id="cb_ok" onClick="MM_goToURL('parent.frames[\'result\']','Rpt09.php?as_institucion=<?=($li_institucion)?>&as_alumno='+ddlb_alumno.options[ddlb_alumno.selectedIndex].value+'&ai_ano='+ddlb_ano.options[ddlb_ano.selectedIndex].value);return document.MM_returnValue" value="Buscar"> 
            </td>
          </tr>
        </table>
  </td>
  </tr>
</table>
</form>
</body>
</html>
