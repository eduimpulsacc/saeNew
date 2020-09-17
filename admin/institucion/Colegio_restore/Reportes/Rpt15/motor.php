<?include"../Coneccion/conexion.php"?>
<?
$li_institucion = $_GET["ai_institucion"];
	
$sql= "select  distinct(alumno.rut_alumno), alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat from alumno, matricula where ";
$sql = $sql . " alumno.rut_alumno = matricula.rut_alumno and matricula.rdb = $li_institucion order by alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat;";
$resultado_query_cue = pg_exec($conexion,$sql);
$total_filas_cue     = pg_numrows($resultado_query_cue);

	$sql = " select distinct b.* from tipo_ense_inst a, tipo_ensenanza b, institucion c";
	$sql = $sql . " where a.cod_tipo = b.cod_tipo ";
	$sql = $sql . " and a.rdb = c.rdb and a.rdb = $li_institucion and a.estado < 2";
	
	//echo "SQL : $sql";
	$resultado_query_te= pg_exec($conexion,$sql);
	$total_filas_te= pg_numrows($resultado_query_te);
	
	pg_close($conexion);
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
  <table width="53%" border="1" align="center" cellpadding="1" cellspacing="0">
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
              </select>
              <!--select name="ddlb_tipo_ense" class="ddlb_9_x_150">
                <!?
		For ($j=0; $j < $total_filas_te; $j++)
		{
   	  ?>
                <option value="<?print Trim(pg_result($resultado_query_te, $j, 0));?>"> 
                <?print Trim(pg_result($resultado_query_te, $j, 1));?> </option>
                <!?
		}	  
	  ?>
              </select--> 
              <input name="cb_ok" type="button" class="cb_submit_9_x_75" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' id="cb_ok" onClick="MM_goToURL('parent.frames[\'result\']','Rpt15.php?as_institucion=<?=($li_institucion)?>&as_alumno='+ddlb_alumno.options[ddlb_alumno.selectedIndex].value);return document.MM_returnValue" value="Buscar">
            </td>
          </tr>
        </table>
  </td>
  </tr>

</table>
</form>
</body>
</html>
