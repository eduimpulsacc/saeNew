<?include"../../../Coneccion/conexion.php"?>
<?
if($_POST["MM_delete"] != '')
{
	$li_id = $_POST["MM_delete"];
	//echo "<BR> Eliminando id : ($li_id) ";

	$sql_delete = "Delete From con_moneda Where id_moneda = $li_id;";
	$res_delete = pg_exec($conexion,$sql_delete);

}
?>

<?
$li_criterio = $_GET["ai_criterio"];
$ls_input    = $_GET["as_input"];

//echo "Criterio ::: $li_criterio  <br>";
//echo "Input    ::: $ls_input";

	if ($li_criterio  == 1)
	
	{
	$sql= "Select * From con_moneda Where Upper(nombre) like Upper('$ls_input%') Order by id_moneda;";
	}else
	{
	$sql= "Select * From con_moneda Where Upper(nombre) like Upper('%$ls_input%') Order by id_moneda;";
	}
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);
	
	pg_close($conexion);

?>


<html>
<head>

<title>MODULOS</title>
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

<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post" action="">
  <table width="60%" border="0" align="center" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="linea_datos_02" colspan="4">RESULTADOS : 
        <?echo $total_filas?>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="21%"> 
        <div align="center">ID</div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center">NOMBRE</div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center">SIGLA</div>
      </td>
      <td class="linea_datos_02" width="12%">&nbsp;</td>
    </tr>
    <?
	For ($j=0; $j < $total_filas; $j++)
	{
	?>
    <tr width="12%" onMouseOver="this.style.backgroundColor='yellow'; this.style.cursor='hand'" onMouseOut="this.style.backgroundColor='#FFFFFF';">
      <td class="membrete_datos" width="21%"> 
        <div align="center">&nbsp; 
          <?print pg_result($resultado_query, $j, 0);?>
        </div>
      </td>
      <td class="membrete_datos"> 
        <div align="center">&nbsp; 
          <?print pg_result($resultado_query, $j, 1);?>
        </div>
      </td>
      <td class="membrete_datos"> 
        <div align="center"> 
          <?print pg_result($resultado_query, $j, 2);?>
        </div>
      </td>
      <td class="membrete_datos"> 
        <div align="center"> 
          <input type="hidden" name="hf_id_<?=($j)?>" value="<?=pg_result($resultado_query, $j, 0)?>">
          <input type="button" name="cb_update" value="M" class="cb_submit_9_20x17" onClick="MM_goToURL('parent.frames[\'main\']','update.php?ai_id='+hf_id_<?=($j)?>.value);return document.MM_returnValue" >
          <input type="button" name="cb_delete" value="E" class="cb_submit_9_20x17" onClick="if (confirm('¿Esta seguro que desea eliminar ?')){MM_delete.value = hf_id_<?=($j)?>.value;this.form.submit()}">
        </div>
      </td>
    </tr>
    <?
	}
	pg_freeresult($resultado_query);
	?>
  </table>
  <input type="hidden" name="MM_delete">
</form>
</body>
</html>
