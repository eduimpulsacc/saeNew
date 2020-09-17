<? include"../../../Coneccion/conexion.php"?>
<?
	if($_POST["cb_update"] != '')
	{
		$li_id_colegio= $_POST["hf_id_colegio"];
		$li_id_extra  = $_POST["hf_id_extra"];
		$ls_nombre    = Trim($_POST["tf_nombre"]);
		$ls_descri    = Trim($_POST["tf_obs"]);
		$ls_tipo      = Trim($_POST["ddlb_tipo"]);
		$ls_signo     = Trim($_POST["ddlb_signo"]);
		$ls_signo_saldo = Trim($_POST["ddlb_saldo"]);
		
	
		$sql_update = "Update con_extra set nombre = '$ls_nombre', descripcion = '$ls_descri', tipo = '$ls_tipo', signo = '$ls_signo', saldo = '$ls_signo_saldo' Where rdb = $li_id_colegio and id_extra = $li_id_extra;";
		$res_update = pg_exec($conexion,$sql_update);
	}
?>
<?
	$li_id_colegio = $_GET["ai_id_colegio"];
	$li_id_extra   = $_GET["ai_id_extra"];

	$sql= "Select a.rdb, a.nombre_instit, b.rdb, b.id_extra, b.nombre, b.descripcion, b.tipo, b.signo, b.saldo From institucion a, con_extra b Where a.rdb = $li_id_colegio and b.id_extra = $li_id_extra and a.rdb = b.rdb Order by b.id_extra;";
	//echo(" $sql <br>");
	$resultado_query = pg_exec($conexion,$sql);
	$total_filas     = pg_numrows($resultado_query);

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
      <td class="linea_datos_02"> <div align="center">INSTITUCION :</div></td>
      <td class="membrete_datos">&nbsp; 
        <?=pg_result($resultado_query, $j, 0);?>
        <input type="hidden" name="hf_id_colegio" value="<?=Trim(pg_result($resultado_query, 0, 0));?>"> 
        <input type="hidden" name="hf_id_extra" value="<?=Trim(pg_result($resultado_query, 0, 3));?>"> 
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="center">NOMBRE :</div></td>
      <td class="membrete_datos"> <input type="text" name="tf_nombre" class="text_9_x_300" value=" <?=Trim(pg_result($resultado_query, 0, 4));?>"> 
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="center">DESCRIPCION :</div></td>
      <td class="membrete_datos"> <input type="text" name="tf_obs" class="text_9_x_300" value=" <?=Trim(pg_result($resultado_query, 0, 5));?>"> 
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="center">TIPO :</div></td>
      <td class="membrete_datos"> 
        <?
	  $li_tipo =Trim(pg_result($resultado_query, 0, 6));	  
	  ?>
        <select name="ddlb_tipo" class="ddlb_9_x_100">
          <option value="$" <?if($li_tipo=="$") {echo("Selected");}?>>Valor</option>
          <option value="%" <?if($li_tipo=="%") {echo("Selected");}?>>Porcentaje</option>
        </select> </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="center">SIGNO :</div></td>
      <td class="membrete_datos"> 
        <?
	  $li_signo =Trim(pg_result($resultado_query, 0, 7));	  
	  ?>
        <select name="ddlb_signo" class="text_9_x_100">
          <option value="+" <?if($li_signo=="+") {echo("Selected");}?>>Agrega</option>
          <option value="-" <?if($li_signo=="-") {echo("Selected");}?>>Descuenta</option>
        </select> </td>
    </tr>
    <tr>
      <td class="linea_datos_02"><div align="center">aplica al saldo</div></td>
      <td class="membrete_datos">
	<?
		  $li_signo_saldo = Trim(pg_result($resultado_query, 0, 8));	  
		  ?>	  
	  <select name="ddlb_saldo" class="text_9_x_100">
          <option value="S" <?if($li_signo_saldo=="S") {echo("Selected");}?>>SI</option>
          <option value="N" <?if($li_signo_saldo=="N") {echo("Selected");}?>>NO</option>
        </select></td>
    </tr>
  </table>
  <br>
  <table width="50%" border="0" align="center" cellspacing="0" cellpadding="0">
    <tr>
      <td> 
        <div align="center">
          <input type="button" name="cb_go" value="Volver" class="cb_none_9_x_70" onClick="MM_goToURL('parent.frames[\'main\']','resultado.php?ai_mostrar=1&ai_criterio=1&ai_colegio='+<?=($li_id_colegio)?>);return document.MM_returnValue" >
          <input type="submit" name="cb_update" value="Grabar &gt;&gt;" class="cb_none_9_x_70">
        </div>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
