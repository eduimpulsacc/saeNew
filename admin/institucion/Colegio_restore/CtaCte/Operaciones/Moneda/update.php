<?include"../../../Coneccion/conexion.php"?>
<?
	if($_POST["MM_update"] != '')
	{
		$li_id = $_POST["MM_update"];
		$ls_nombre = Trim($_POST["tf_nombre"]);
		$ls_sigla  = Trim($_POST["tf_sigla"]);
	
		$sql_update = "Update con_moneda set nombre = '$ls_nombre', sigla = '$ls_sigla' Where id_moneda = $li_id;";
		$res_update = pg_exec($conexion,$sql_update);
	
	}
?>
<?
	$li_id = $_GET["ai_id"];
	//echo "Valor ::: $li_id  <br>";

	$sql= "Select * From con_moneda Where id_moneda = $li_id;";
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas= pg_numrows($resultado_query);

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

<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post" action="">
  <table width="50%" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center">ID :</div>
      </td>
      <td class="membrete_datos">&nbsp; 
        <?=pg_result($resultado_query, $j, 0);?>
        <input type="hidden" name="hf_id" value="<?=pg_result($resultado_query, 0, 0);?>">
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center">NOMBRE :</div>
      </td>
      <td class="membrete_datos"> 
        <input type="text" name="tf_nombre" class="text_9_x_300" value=" <?=Trim(pg_result($resultado_query, 0, 1));?>">
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center">SIGLA :</div>
      </td>
      <td class="membrete_datos"> 
        <input type="text" name="tf_sigla" class="text_9_x_300" value=" <?=Trim(pg_result($resultado_query, 0, 2));?>">
      </td>
    </tr>
  </table>
  <br>
  <table width="50%" border="0" align="center" cellspacing="0" cellpadding="0">
    <tr>
      <td> 
        <div align="center">
          <input type="button" name="cb_go" value="Volver" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'main\']','resultado.php');return document.MM_returnValue" >
          <input type="button" name="cb_update" value="Grabar &gt;&gt;" class="cb_none_9_x_70" onClick="{MM_update.value = hf_id.value;this.form.submit()}" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>
        </div>
      </td>
    </tr>
  </table>
    <input type="hidden" name="MM_update">
</form>
</body>
</html>
