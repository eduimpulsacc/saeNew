<?include"../../../Coneccion/conexion.php"?>
<?
if($_POST["MM_delete"] != '')
{
	$li_id_colegio = $_POST["MM_delete"];
	$li_id_cuenta  = $_POST["MM_delete_02"];
	$li_id_extra   = $_POST["MM_delete_03"];
	
	$sql_delete = "Delete From con_plan_cuenta_extra Where rdb = $li_id_colegio And id_cuenta = $li_id_cuenta And id_extra = $li_id_extra;";
	$res_delete = pg_query($conexion,$sql_delete);
}
?>

<?
if($_POST["cb_save"] != '')
{
	$li_id_colegio = $_POST["hf_colegio"];
	$li_id_cuenta    = $_POST["hf_cuenta"];
	$li_id_cextra = $_POST["ddlb_cextra"];
	$ls_aplica    = $_POST["ddlb_aplica"];
	$ls_tipo      = $_POST["ddlb_tipo"];
	$ls_signo     = $_POST["ddlb_signo"];
	$li_valor     = Trim($_POST["tf_valor"]);
	
	$sql = "INSERT INTO con_plan_cuenta_extra VALUES($li_id_colegio, $li_id_cuenta, $li_id_cextra, '$ls_aplica', '$ls_tipo', '$ls_signo', $li_valor);";
	//echo("SQL : $sql <BR>");
	$res_insert = pg_query($conexion,$sql);
	?>
	<Script>
	parent.main.location.href="extra.php?ai_mostrar=1&ai_colegio=<?=($li_id_colegio)?>&ai_cuenta=<?=($li_id_cuenta)?>"
	</Script>
	<?
}
?>

<?

	$li_id_colegio = $_GET["ai_colegio"];
	$li_id_cuenta  = $_GET["ai_cuenta"];

	$sql= "Select a.*, b.id_extra, b.nombre, b.descripcion From con_plan_cuenta_extra a, con_extra b where a.rdb = $li_id_colegio and a.id_cuenta = $li_id_cuenta and a.id_extra = b.id_extra order by 1,2,3;";
	$resultado_query = pg_query($conexion,$sql);
	$total_filas     = pg_num_rows($resultado_query);

	$sql= "Select rdb, nombre_instit From institucion where rdb = $li_id_colegio order by 1,2;";
	$resultado_query_instit = pg_query($conexion,$sql);
	$total_filas_instit     = pg_num_rows($resultado_query_instit);

	$sql_cue= "Select nombre From con_cuenta where rdb = $li_id_colegio and id_cuenta = $li_id_cuenta;";
	$resultado_query_cue = pg_query($conexion,$sql_cue);
	$total_filas_cue     = pg_num_rows($resultado_query_cue);

	$sql_cue_extra= "Select * From con_extra where rdb = $li_id_colegio;";
	$resultado_query_cue_extra = pg_query($conexion,$sql_cue_extra);
	$total_filas_cue_extra     = pg_num_rows($resultado_query_cue_extra);
		
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
<form name="form1" method="post" action="">
  <br>
  <table width="60%" border="1" align="center" cellspacing="0" cellpadding="1">
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center">INSTITUCION :</div>
      </td>
      <td class="membrete_datos">&nbsp;<b> 
        <?=Trim(pg_result($resultado_query_instit, 0, 1));?>
        <input type="hidden" name="hf_colegio" value="<?=($li_id_colegio)?>">
        </b></td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center">CUENTA :</div>
      </td>
      <td class="membrete_datos">&nbsp;<b> 
        <?=Trim(pg_result($resultado_query_cue, 0, 0));?>
        <input type="hidden" name="hf_cuenta" value="<?=($li_id_cuenta)?>">
        </b></td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center">CUENTA EXTRA :</div>
      </td>
      <td class="membrete_datos">
        <select name="ddlb_cextra" class="ddlb_9_x_100">
          <?
		For ($j=0; $j < $total_filas_cue_extra; $j++)
		{
		?>
          <option value="<?=pg_result($resultado_query_cue_extra, $j, 1);?>"><?=Trim(pg_result($resultado_query_cue_extra, $j, 2));?>
          </option>
		<?
		}
		?>
        </select>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center">APLICA :</div>
      </td>
      <td class="membrete_datos">
        <select name="ddlb_aplica" class="ddlb_9_x">
          <option value="S">SI</option>
          <option value="N">NO</option>
        </select>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02">
        <div align="center">TIPO :</div>
      </td>
      <td class="membrete_datos">
        <select name="ddlb_tipo" class="ddlb_9_x_100">
          <option value="V">VALOR</option>
          <option value="P">PORCENTAJE</option>
        </select>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center">SIGNO :</div>
      </td>
      <td class="membrete_datos">
        <select name="ddlb_signo" class="ddlb_9_x_100">
          <option value="+">AGREGA</option>
          <option value="-">DESCUENTA</option>
        </select>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center">VALOR :</div>
      </td>
      <td class="membrete_datos">
        <input type="text" name="tf_valor" class="text_9_x_100">
      </td>
    </tr>
  </table>
  <table width="60%" border="0" align="center">
    <tr>
      <td>
        <div align="center">
          <input type="button" name="cb_go" value="Volver" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'main\']','resultado_down.php?ai_mostrar=1&ai_colegio='+<?=($li_id_colegio)?>+'&ai_cuenta='+<?=($li_id_cuenta)?>);return document.MM_returnValue" >
          <input type="submit" name="cb_save" value="Grabar" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>
        </div>
      </td>
    </tr>
  </table>
  <br>
  <?
  If($total_filas<=0)
  {
  }else
  {
  ?>
  <table width="90%" border="1" align="center" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="linea_datos_02" colspan="6">
        <div align="center"><b><font size="2">CUENTAS EXTRAS.</font></b></div>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_05" width="31%"> 
        <div align="center">EXTRA</div>
      </td>
      <td class="linea_datos_05" width="12%"> 
        <div align="center">APLICA</div>
      </td>
      <td class="linea_datos_05" width="14%"> 
        <div align="center">TIPO</div>
      </td>
      <td class="linea_datos_05" width="15%"> 
        <div align="center">SIGNO</div>
      </td>
      <td class="linea_datos_05" width="19%"> 
        <div align="center">VALOR</div>
      </td>
      <td class="linea_datos_05" width="9%">&nbsp;</td>
    </tr>
    <?
	For ($j=0; $j < $total_filas; $j++)
	{
	?>
    <tr> 
      <td class="membrete_datos" width="31%"> 
        <div align="left">&nbsp; (<?=Trim(pg_result($resultado_query, $j, 8));?>) <?=Trim(pg_result($resultado_query, $j, 9));?></div>
      </td>
      <td class="membrete_datos" width="12%"> 
        <div align="center">&nbsp; 
          <?
		  $li_id_aplica =Trim(pg_result($resultado_query, $j, 3));
		  if($li_id_aplica=="S")
		  {
		  $ls_aplica_name = "SI";
		  }else
		  {
		  $ls_aplica_name = "NO";
		  }
		  ?><?=($ls_aplica_name)?>
        </div>
      </td>
      <td class="membrete_datos" width="14%"> 
        <div align="center">&nbsp;
          <?
		  $li_id_tipo = Trim(pg_result($resultado_query, $j, 4));
		  if($li_id_tipo=="V")
		  {
		  $ls_tipo_name = "Valor";
		  }else
		  {
		  $ls_tipo_name = "Porcentaje";
		  }
		  ?><?=($ls_tipo_name)?>	  
        </div>
      </td>
      <td class="membrete_datos" width="15%"> 
        <div align="center">
          <?
		  $li_id_signo = Trim(pg_result($resultado_query, $j, 5));
		  if($li_id_signo=="+")
		  {
		  $ls_signo_name = "agrega";
		  }else
		  {
		  $ls_signo_name = "descuenta";
		  }
		  ?><?=($ls_signo_name)?>	  
        </div>
      </td>
      <td class="membrete_datos" width="19%"> 
        <?=Trim(pg_result($resultado_query, $j, 6));?>
      </td>
      <td class="membrete_datos" width="9%"> 
        <input type="hidden" name="hf_id_colegio_<?=($j)?>" value="<?=($li_id_colegio)?>">
        <input type="hidden" name="hf_id_cuenta_<?=($j)?>" value="<?=($li_id_cuenta)?>">
        <input type="hidden" name="hf_id_extra_<?=($j)?>" value="<?=pg_result($resultado_query, $j, 2)?>">
        <input type="button" name="cb_delete" value="E" class="cb_submit_9_20x17" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="if (confirm('¿Esta seguro que desea eliminar PLAN EXTRA ?')){MM_delete.value = hf_id_colegio_<?=($j)?>.value;MM_delete_02.value = hf_id_cuenta_<?=($j)?>.value;MM_delete_03.value = hf_id_extra_<?=($j)?>.value;this.form.submit()}">
      </td>
    </tr>
	<?
	}
	?>
  </table>
  <?
  }
  ?>
  <input type="hidden" name="MM_delete">
  <input type="hidden" name="MM_delete_02">
  <input type="hidden" name="MM_delete_03">
</form>
</body>
</html>
<?
pg_close($conexion);
?>