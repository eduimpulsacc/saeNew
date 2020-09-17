<? include"../../../Coneccion/conexion.php"?>
<?
if($_POST["MM_delete"] != '')
{
	$li_id_colegio = $_POST["MM_delete"];
	$li_id_extra   = $_POST["MM_delete_02"];

	$sql_delete = "Delete From con_extra Where rdb = $li_id_colegio and id_extra = $li_id_extra;";
	$res_delete = pg_exec($conexion,$sql_delete);

}
?>

<?	
	$li_mostrar_tabla = Trim($_GET["ai_mostrar"]);
	$li_criterio   = $_GET["ai_criterio"];
	$ls_input      = Trim($_GET["as_input"]);
	if($li_mostrar_tabla==1)
	{
	
	$li_id_colegio = $_GET["ai_colegio"];
	
		if ($li_criterio  == 1)
	
		{

	
	//*** ESTE SELECT NO PERMITE MOSTRAR LA CUENTA EXTRA 0, -1 (GENERAL PARA EL DESPLIEGUE, BECA GENERAL)
	$sql= "Select a.rdb, a.nombre_instit, b.rdb, b.id_extra, b.nombre, b.descripcion, b.tipo, b.signo From institucion a, con_extra b Where a.rdb = $li_id_colegio And Upper(b.nombre) LIKE Upper('$ls_input%') and a.rdb = b.rdb and b.id_extra > 0 Order by b.id_extra;";
		
		}else{
		
	$sql= "Select a.rdb, a.nombre_instit, b.rdb, b.id_extra, b.nombre, b.descripcion, b.tipo, b.signo From institucion a, con_extra b Where a.rdb = $li_id_colegio And Upper(b.nombre) LIKE Upper('$%ls_input%') and a.rdb = b.rdb and b.id_extra > 0 Order by b.id_extra;";


		}
//		echo(" $sql ");
	$resultado_query = pg_exec($conexion,$sql);
	$total_filas     = pg_numrows($resultado_query);
	
	pg_close($conexion);
	}
?>


<html>
<head>
<title>MODULOS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../../css/objeto.css" type="text/css">
</head>
<script language="JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>

<body bgcolor="#FFFFFF" text="#000000">
<?
	if($li_mostrar_tabla==1)
	{
?>
<form name="form1" method="post" action="">
  <table width="80%" border="1" align="center" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="linea_datos_02" colspan="6">RESULTADOS : 
        <?echo $total_filas?>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="10%" height="13"> 
        <div align="center">ID</div>
      </td>
      <td class="linea_datos_02" height="13" width="28%"> 
        <div align="center">NOMBRE</div>
      </td>
      <td class="linea_datos_02" height="13" width="26%"> 
        <div align="center">DESCRIPCION</div>
      </td>
      <td class="linea_datos_02" width="12%" height="13"> 
        <div align="center">TIPO</div>
      </td>
      <td class="linea_datos_02"  height="13"> 
        <div align="center">OPCION</div>
      </td>
      <td class="linea_datos_02" width="12%" height="13">&nbsp;</td>
    </tr>
    <?
	For ($j=0; $j < $total_filas; $j++)
	{
	?>
    <tr> 
      <td class="membrete_datos" width="10%"> 
        <div align="center">&nbsp; 
          <?print pg_result($resultado_query, $j, 3);?>
        </div>
      </td>
      <td class="membrete_datos" width="28%"> 
        <div align="center">&nbsp; 
          <?print pg_result($resultado_query, $j, 4);?>
        </div>
      </td>
      <td class="membrete_datos" width="26%"> 
        <div align="center"> 
          <?print pg_result($resultado_query, $j, 5);?>
        </div>
      </td>
      <td class="membrete_datos" width="12%"> 
        <div align="center">
          <?
		  $ls_name_tipo = Trim(pg_result($resultado_query, $j, 6));
		  if($ls_name_tipo == '%')
		  {
		  	echo("Porcentaje");
		  }else{
		  	echo("Valor");
		  }
		  ?>
        </div>
      </td>
      <td class="membrete_datos" > 
        <div align="center">
          <?
		  $li_signo = Trim(pg_result($resultado_query, $j, 7));
		  if($li_signo=="+")
		  {
		  $ls_signo_name = "Agrega";
		  }else
		  {
		  $ls_signo_name = "Descuenta";
		  }
		  ?><?=$ls_signo_name?>
        </div>
      </td>
      <td class="membrete_datos" width="12%"> 
        <div align="center"> 
          <input type="hidden" name="hf_id_<?=($j)?>" value="<?=pg_result($resultado_query, $j, 0)?>">
          <input type="hidden" name="hf_id_extra_<?=($j)?>" value="<?=pg_result($resultado_query, $j, 3)?>">
          <input type="button" name="cb_update" value="M" class="cb_submit_9_20x17"  onClick="MM_goToURL('parent.frames[\'main\']','update.php?ai_id_colegio='+hf_id_<?=($j)?>.value+'&ai_id_extra='+hf_id_extra_<?=($j)?>.value);return document.MM_returnValue" >
          <input type="button" name="cb_delete" value="E" class="cb_submit_9_20x17" onClick="if (confirm('¿Esta seguro que desea eliminar ?')){MM_delete.value = hf_id_<?=($j)?>.value;MM_delete_02.value = hf_id_extra_<?=($j)?>.value;this.form.submit()}">
        </div>
      </td>
    </tr>
    <?
	}
	pg_freeresult($resultado_query);
	?>
  </table>
  <input type="hidden" name="MM_delete">
  <input type="hidden" name="MM_delete_02">
</form>
<?
	}else
	{
	echo("<Center><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><BR>Ingrese Criterios para la Busqueda...</font></Center>");
	}
?>
</body>
</html>
