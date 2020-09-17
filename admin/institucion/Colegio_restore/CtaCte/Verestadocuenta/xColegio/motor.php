<?include"../../../Coneccion/conexion.php"?>
<?
	$li_id_nivel   = Trim($_GET["ai_nivel"]);
	$li_id_perfil  = Trim($_GET["ai_perfil"]);
	$li_id_usuario = Trim($_GET["ai_usuario"]);

	IF($li_id_perfil == 0) //Administrador
	{
	
	$sql= "SELECT DISTINCT B.RDB, B.NOMBRE_INSTIT FROM INSTITUCION B ORDER BY B.NOMBRE_INSTIT ;";
	
	}ELSE //Si el Perfil es Distinto de Administrador
	{
	
			IF($li_id_nivel == 1 or $li_id_nivel == 2 or $li_id_nivel == 3 or $li_id_nivel == 4 or $li_id_nivel == 5 or $li_id_nivel == 6) //Sistema Gcolegio colegio
			{
		
			$sql= "SELECT DISTINCT B.RDB, B.NOMBRE_INSTIT FROM ACCEDE A, INSTITUCION B WHERE A.ID_PERFIL = $li_id_perfil AND A.RDB = B.RDB AND A.ID_USUARIO = $li_id_usuario ORDER BY B.NOMBRE_INSTIT ;";
		
			}
	}
	//ECHO("SQL : $sql <br>");
	$resultado_query_col = pg_exec($conexion,$sql);
	$total_filas_col     = pg_numrows($resultado_query_col);
		
	pg_close($conexion);
?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../../css/objeto.css" type="text/css">
<script language="JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body class="pagina">
<form name="form1" method="post" action="">
  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td   width="32%"> 
        <div align="center"><font size="1">Nombre Instituci&oacute;n :</font></div>
      </td>
      <td   width="47%"> <font size="1"> 
        <select name="dblb_colegio" class="text_9_x_300">
          <?
		for ($j=0; $j<$total_filas_col; $j++)
		{
		?>
          <option value="<?=pg_result($resultado_query_col, $j, 0);?>"> 
          <?=Trim(pg_result($resultado_query_col, $j, 1));?>
          </option>
          <?
		 $cuenta=$cuenta+1;
		 }
		?>
        </select>
        </font></td>
      <td   width="21%"> <font size="1"> 
        <input type="button" name="cb_buscar" value="Buscar &gt;&gt;" class="cb_none_9_x_100" onClick="MM_goToURL('parent.frames[\'main\']','resultado.php?ai_mostrar=1&ai_colegio='+dblb_colegio.options[dblb_colegio.selectedIndex].value);return document.MM_returnValue">
        </font></td>
    </tr>
  </table>
</form>
</body>
</html>
