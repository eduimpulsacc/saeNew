<? include"../../../Coneccion/conexion.php"?>

<?
if($_POST["cb_save"] != '')
{
	$li_id_colegio    = $_POST["ddlb_colegio"];
	$li_id_cuenta     = $_POST["ddlb_cuenta"];
	$li_id_categoria  = $_POST["ddlb_categoria"];	
	$li_id_moneda     = $_POST["ddlb_moneda"];
	$li_monto	      = Trim($_POST["tf_monto"]);
	
		if($li_monto == '')
		{
			$li_monto=0;
		}
		if($li_id_cuenta == '')
		{
			$li_id_cuenta=0;
		}
		if($li_id_categoria == '')
		{
			$li_id_categoria=0;
		}
		if($li_id_moneda == '')
		{
			$li_id_moneda=0;
		}

	$sql_insert = "INSERT INTO con_categoria_cuenta VALUES ($li_id_colegio, $li_id_categoria, $li_id_cuenta, $li_id_moneda, $li_monto) ";
	//echo("$sql_insert <br> Nivel : ($li_id_categoria) <br>");
	$res_insert = pg_exec($conexion,$sql_insert);


	
	// *** BUSCA SI EXISTE EL ID CERO PARA LOS PLANES_EXTRA *** SINO LO GUARDA ****
	$sql_del_cero= "Select * From con_categoria_extra where rdb = $li_id_colegio and id_categoria = $li_id_categoria and id_cuenta = $li_id_cuenta and id_extra = 0;";
	$resultado_query_cero = pg_exec($conexion,$sql_del_cero);
	$total_filas_cero     = pg_numrows($resultado_query_cero);
	
					if($total_filas_cero<=0)
					{
					//echo("No existe CERO");
					$sql_new = "INSERT INTO con_categoria_extra VALUES ($li_id_colegio, $li_id_categoria, $li_id_cuenta, 0, 0, 0);";
					$res_new = pg_exec($conexion,$sql_new);
					}else
					{
					//echo("existe CERO");
					}
					
	// *** BUSCA SI EXISTE EL ID -1 PARA LOS PLANES_EXTRA (BECA GENERAL) *** SINO LO GUARDA ****
	
	$sql_beca= "Select * From con_categoria_extra where rdb = $li_id_colegio and id_categoria = $li_id_categoria and id_cuenta = $li_id_cuenta and id_extra = -1;";
	$resultado_query_beca = pg_exec($conexion,$sql_beca);
	$total_filas_beca     = pg_numrows($resultado_query_beca);
	
					if($total_filas_beca<=0)
					{
					//echo("No existe CERO");
					$sql_new = "INSERT INTO con_categoria_extra VALUES ($li_id_colegio, $li_id_categoria, $li_id_cuenta, -1, 0, 0);";
					$res_new = pg_exec($conexion,$sql_new);
					}else
					{
					//echo("existe CERO");
					}
	?>
	<Script>
	parent.main.location.href="resultado_down.php?ai_mostrar=1&ai_colegio=<?=($li_id_colegio)?>&ai_categoria=<?=($li_id_categoria)?>&ai_cuenta=<?=($li_id_cuenta)?>"
	</Script>
	<?
}
?>

<?
	$li_id_nivel   = Trim($_GET["ai_nivel"]);
	$li_id_perfil  = Trim($_GET["ai_perfil"]);
	$li_id_usuario = Trim($_GET["ai_usuario"]);
	$li_id_colegio_selec  = Trim($_GET["ai_colegio_selec"]);

		
	$sql= "Select * From con_cuenta where rdb = $li_id_colegio_selec Order by nombre;";
	$resultado_query_cue = pg_exec($conexion,$sql);
	$total_filas_cue     = pg_numrows($resultado_query_cue);
	
	$sql= "Select * From con_categoria where rdb = $li_id_colegio_selec Order by nombre;";
	$resultado_query_cat = pg_exec($conexion,$sql);
	$total_filas_cat     = pg_numrows($resultado_query_cat);
	
	$sql= "Select * From con_moneda Order by nombre;";
	$resultado_query_mon = pg_exec($conexion,$sql);
	$total_filas_mon     = pg_numrows($resultado_query_mon);
?>
<html>
<head>
<title>Untitled Document</title>
<link rel="stylesheet" href="../../../css/objeto.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<FORM NAME="Listas" METHOD="POST" ACTION="">
  <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="linea_datos_02"> <div align="center"><font color="#FFFFFF" size="2"><strong>INGRESO 
          DE CUENTAS.</strong></font></div></td>
    </tr>
  </table>
  <table width="95%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center">NIVEL</div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center">CUENTAS</div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center">MONEDA</div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center">MONTO</div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center">&nbsp;</div>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02">
        <div align="center">
		<input type="hidden" name="ddlb_colegio" value="<?=($li_id_colegio_selec)?>"> 
          <select name="ddlb_categoria" class="text_9_x_100">
            <?
		for ($j=0; $j<$total_filas_cat; $j++)
		{
		?>
            <option value="<?=pg_result($resultado_query_cat, $j, 1);?>"> 
            <?=pg_result($resultado_query_cat, $j, 2);?>
            </option>
            <?
		}
		?>
          </select>
        </div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center"> 
          <select name="ddlb_cuenta" class="text_9_x_100">
            <?
			For ($x=0; $x<$total_filas_cue; $x++)
			{
		  ?>
            <option value="<?=Trim(pg_result($resultado_query_cue, $x, 1));?>"> 
            <?=Trim(pg_result($resultado_query_cue, $x, 2));?>
            </option>
            <?
		  }
		  ?>
          </select>
        </div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center"> 
          <select name="ddlb_moneda" class="text_9_x_100">
            <?
		for ($j=0; $j<$total_filas_mon; $j++)
		{
		?>
            <option value="<?=pg_result($resultado_query_mon, $j, 0);?>"> 
            <?=Trim(pg_result($resultado_query_mon, $j, 2));?>
            </option>
            <?
		}
		?>
          </select>
        </div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center"> 
          <input type="text" name="tf_monto" class="text_9_x_100">
        </div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center"> 
          <input type="submit" name="cb_save" value="+" class="cb_submit_9_20x17">
        </div>
      </td>
    </tr>
  </table> 
    
</form>
</body>
</html>
<?
pg_close($conexion);
?>