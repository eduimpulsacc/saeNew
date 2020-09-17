<? include"../../../Coneccion/conexion.php"?>
<?
if($_POST["MM_delete"] != '')
{
	$li_id_colegio    = $_POST["MM_delete"];
	$li_id_cuenta     = $_POST["MM_delete_02"];
	$li_id_categoria  = $_POST["MM_delete_04"];
	$li_id_moneda     = $_POST["MM_delete_03"]; 
	
	
	$sql_delete_01 = "Delete From con_categoria_extra Where rdb = $li_id_colegio And id_categoria = $li_id_categoria And id_cuenta = $li_id_cuenta;";
	$res_delete_01 = pg_exec($conexion,$sql_delete_01);

	$sql_delete_02 = "Delete From con_categoria_cuenta_periodo Where rdb = $li_id_colegio And id_categoria = $li_id_categoria And id_cuenta = $li_id_cuenta ";
	$res_delete_02 = pg_exec($conexion,$sql_delete_02);

	$sql_delete = "Delete From con_categoria_cuenta Where rdb = $li_id_colegio And id_categoria = $li_id_categoria And id_cuenta = $li_id_cuenta ";
	$res_delete = pg_exec($conexion,$sql_delete);
		
	$li_mostrar_tabla = 1;
}
?>

<?
if($_POST["cb_save"] != '')
{
	$li_total_colum  = $_POST["hf_total_columnas"];
	$li_total_filas  = $_POST["hf_total_filas"];

	$li_id_colegio_del    = Trim($_POST["hf_id_colegio_del"]);
	$li_id_categoria_del  = Trim($_POST["hf_id_categoria_del"]);	
	$sql_delete_02 = "Delete From con_categoria_extra Where rdb = $li_id_colegio_del AND id_categoria = $li_id_categoria_del AND id_extra <> 0;";
	$res_delete_02 = pg_exec($conexion,$sql_delete_02);
	
	For ($j=0; $j<$li_total_filas; $j++)
	{		
	$li_id_colegio    = $_POST["hf_id_colegio_".$j];
	$li_id_cuenta     = $_POST["hf_id_cuenta_".$j];
	$li_id_categoria  = $_POST["hf_id_categoria_".$j];

		For ($x=0; $x<$li_total_colum; $x++)
		{			
	
		$li_valor      = Trim($_POST["tf_valor_".$j."_".$x]);
		$li_id_extra   = Trim($_POST["hf_id_extra_".$j."_".$x]);
		
		if($li_valor=='')
		{
		$li_valor = 0;
		}
	
				if($_POST["cbx_aplica_".$j."_".$x]!= '')
				{
				$sql_insert = "INSERT INTO con_categoria_extra VALUES ($li_id_colegio, $li_id_categoria, $li_id_cuenta, $li_id_extra, 'S', $li_valor);";
				//echo("<BR> SQL INSERT : $sql_insert <BR>");
				$res_insert = pg_exec($conexion,$sql_insert);
				}
		}
	}
	$li_mostrar_tabla = 1;
}
?>



<?
	//*** COMIENZA EL DESPLIEGUE 
	
	$li_mostrar_tabla = Trim($_GET["ai_mostrar"]);

	if($li_mostrar_tabla == 1)
	{

	$li_id_colegio    = $_GET["ai_colegio"];
	$li_id_cuenta     = $_GET["ai_cuenta"];
	$li_id_categoria  = $_GET["ai_categoria"];
	//echo("Id Categ 1: $li_id_categoria <BR>");

	$sql= "Select a.rdb, a.id_categoria, a.id_cuenta, a.id_moneda, a.monto, e.nombre as nombre_cat, b.nombre, c.nombre, d.rdb , d.nombre_instit From con_categoria_cuenta a, con_cuenta b, con_moneda c, institucion d, con_categoria e  where a.rdb = $li_id_colegio and a.id_categoria = $li_id_categoria and a.id_categoria = e.id_categoria and a.id_cuenta = b.id_cuenta and a.id_moneda = c.id_moneda and a.rdb = d.rdb order by 1,2,3;";
	//echo(" SQL : $sql <BR>");
	$resultado_query = pg_exec($conexion,$sql);
	$total_filas     = pg_numrows($resultado_query);

	//***** Para Desplegar CON_EXTRA hacia el Lado *****
	
	$sql_extra= "Select * from con_extra Where rdb = $li_id_colegio and id_extra <> 0;";
	$resultado_query_extra = pg_exec($conexion,$sql_extra);
	$total_filas_extra     = pg_numrows($resultado_query_extra);
	
			$ls_sql_perfil = "";
			For ($x=0; $x < $total_filas_extra; $x++)
			{
			$ls_sql_perfil = $ls_sql_perfil . ",SUM(CASE WHEN (B.id_extra) = '".TRIM(pg_result($resultado_query_extra, $x, 1))."' then 1 else 0 end),SUM(CASE WHEN (B.id_extra) = '".TRIM(pg_result($resultado_query_extra, $x, 1))."' then B.valor else 0 end)   ";
					
			}
			
			$ls_sql = $ls_sql . "SELECT A.rdb, A.id_cuenta, A.id_moneda, A.monto, c.nombre, e.nombre ";
			$ls_sql = $ls_sql . $ls_sql_perfil;
			$ls_sql = $ls_sql . "FROM con_categoria_cuenta A,  ";
			$ls_sql = $ls_sql . "con_categoria_extra B, con_cuenta c, con_moneda e, con_categoria d ";
			$ls_sql = $ls_sql . "WHERE A.rdb = $li_id_colegio and A.rdb = B.rdb and A.id_categoria = $li_id_categoria and A.id_categoria = B.id_categoria and A.id_categoria = d.id_categoria and A.id_cuenta = B.id_cuenta and A.id_cuenta = c.id_cuenta and a.id_moneda = e.id_moneda ";
			$ls_sql = $ls_sql . "GROUP BY A.rdb, A.id_cuenta, A.id_moneda, A.monto, c.nombre, e.nombre ";
			$ls_sql = $ls_sql . "ORDER BY 1,2,3;";
			//ECHO("<BR> EXTRAS : $ls_sql <BR>");
			$resultado_query_seleccion= pg_exec($conexion,$ls_sql);
			$total_filas_seleccion = pg_numrows($resultado_query_seleccion);
	
	}
		
	if($li_mostrar_tabla == 2)
	{
		$li_criterio      = Trim($_GET["ai_criterio"]);
		$ls_input         = Trim($_GET["as_input"]);
		$li_id_colegio    = Trim($_GET["ai_colegio"]);
		$li_id_categoria  = Trim($_GET["ai_categoria"]);
		//echo("Id Categ 2 : $li_id_categoria <BR>");
		
		
		$sql= "Select a.rdb, a.id_categoria, a.id_cuenta, a.id_moneda, a.monto, e.nombre as nombre_cat, b.nombre, c.nombre, d.rdb , d.nombre_instit From con_categoria_cuenta a, con_cuenta b, con_moneda c, institucion d, con_categoria e  where a.rdb = $li_id_colegio and a.id_categoria = $li_id_categoria and a.id_categoria = e.id_categoria and a.id_cuenta = b.id_cuenta and a.id_moneda = c.id_moneda and a.rdb = d.rdb order by 1,2,3;";
		//echo(" Mostrar : $li_mostrar_tabla <BR> SQL : $sql <BR>");
		$resultado_query = pg_exec($conexion,$sql);
		$total_filas     = pg_numrows($resultado_query);
	
		//***** Para Desplegar CON_EXTRA hacia el Lado*****
		
	$sql_extra= "Select * from con_extra Where rdb = $li_id_colegio and id_extra <> 0;";
	$resultado_query_extra = pg_exec($conexion,$sql_extra);
	$total_filas_extra     = pg_numrows($resultado_query_extra);
	
			$ls_sql_perfil = "";
			For ($x=0; $x < $total_filas_extra; $x++)
			{
			$ls_sql_perfil = $ls_sql_perfil . ",SUM(CASE WHEN (B.id_extra) = '".TRIM(pg_result($resultado_query_extra, $x, 1))."' then 1 else 0 end),SUM(CASE WHEN (B.id_extra) = '".TRIM(pg_result($resultado_query_extra, $x, 1))."' then B.valor else 0 end)   ";
					
			}
			
			$ls_sql = $ls_sql . "SELECT A.rdb, A.id_cuenta, A.id_moneda, A.monto, c.nombre, e.nombre ";
			$ls_sql = $ls_sql . $ls_sql_perfil;
			$ls_sql = $ls_sql . "FROM con_categoria_cuenta A,  ";
			$ls_sql = $ls_sql . "con_categoria_extra B, con_cuenta c, con_moneda e, con_categoria d ";
			$ls_sql = $ls_sql . "WHERE A.rdb = $li_id_colegio and A.rdb = B.rdb and A.id_categoria = $li_id_categoria and A.id_categoria = B.id_categoria and A.id_categoria = d.id_categoria and A.id_cuenta = B.id_cuenta and A.id_cuenta = c.id_cuenta and a.id_moneda = e.id_moneda ";
			$ls_sql = $ls_sql . "GROUP BY A.rdb, A.id_cuenta, A.id_moneda, A.monto, c.nombre, e.nombre ";
			$ls_sql = $ls_sql . "ORDER BY 1,2,3;";
			//ECHO("EXTRAS : $ls_sql <BR>");
			$resultado_query_seleccion= pg_exec($conexion,$ls_sql);
			$total_filas_seleccion = pg_numrows($resultado_query_seleccion);
	}
	pg_close($conexion);
?>


<html>
<head>
<title>MODULOS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../../css/objeto.css" type="text/css">
<script language="JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000">
<?	
	if($total_filas<=0)
	{
	echo("<Center><font size='2' face='Verdana, Arial, Helvetica, sans-serif'><BR>No existen Datos...<BR> <b>Seleccione un nivel.</b></font></Center>");
	}Else
	{
	
	if($li_mostrar_tabla ==1 or $li_mostrar_tabla ==2 and $total_filas>0)
	{
?>
 
<form name="form1" method="post" action="">
  <table width="99%" border="1" align="center" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="linea_datos_02" colspan="2"> <div align="center"><strong><font color="#FFFFFF" size="2">LISTADO 
          DE NIVELES Y CUENTAS AL PLAN </font></strong> </div></td>
    </tr>
    <tr> 
      <td class="linea_datos_02" colspan="2"><div align="center">RESULTADOS : 
          <?echo $total_filas?> Categorias </div></td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="right">INSTITUCION :</div></td>
      <td class="linea_datos_02">&nbsp;<b> <?print Trim(pg_result($resultado_query, 0, 9));?> 
        <input type="hidden" name="hf_id_colegio_del" value="<?=Trim($li_id_colegio)?>">
        <input type="hidden" name="hf_id_categoria_del" value="<?=Trim($li_id_categoria)?>">
        </b></td>
    </tr>
  </table>
  <table width="99%" border="1" align="center" cellspacing="0" cellpadding="0">	
    <tr> 
      <td class="linea_datos_02" > CATEGORIA</td>
      <td class="linea_datos_02" > CUENTA</td>
      <td class="linea_datos_02" > MONEDA</td>
      <td class="linea_datos_02" > MONTO</td>
      <td class="linea_datos_02" >&nbsp; </td>
      <?
	  For ($j=0; $j<$total_filas_extra; $j++)
	  {
	  
	  $ls_signo_saldo = pg_result($resultado_query_extra, $j, 6);
	  if($ls_signo_saldo == 'S')
	  {
	  	$ls_color_column = "linea_datos_01_2";
	  }else{
	  	$ls_color_column = "linea_datos_01";
	  }
	  ?>
      <td colspan="2" class="<?=($ls_color_column)?>"> 
        <div align="center"> <b> 
          <?=Trim(pg_result($resultado_query_extra, $j, 2));?>
          ( 
          <?=Trim(pg_result($resultado_query_extra, $j, 5));?>
          ) ( 
          <?=Trim(pg_result($resultado_query_extra, $j, 4));?>
          ) </b></div>
      </td>
      <?
	  }
	  ?>
    </tr>
    <?
	For ($j=0; $j < $total_filas_seleccion; $j++)
	{
	?>
    <tr> 
      <td class="membrete_datos" > 
        <div align="left">&nbsp; 
          <?print pg_result($resultado_query, $j, 5);?>
        </div>
      </td>
      <td class="membrete_datos" >&nbsp;
		  <?print pg_result($resultado_query, $j, 6);?>
<input type="button" name="cb_fecha" value="F" class="cb_submit_9_20x17" onClick="ven=window.open('fechas.php?ai_cuenta=<?=(pg_result($resultado_query, $j, 2))?>&ai_categoria=<?=(pg_result($resultado_query, $j, 1))?>&ai_colegio=<?=($li_id_colegio)?>','','status=yes,menubar=yes,scrollbars=yes,width=300,height=300')">		  
	  </td>
      <td class="membrete_datos" > 
        <div align="left">&nbsp; 
          <?print pg_result($resultado_query, $j, 7);?>
        </div>
      </td>
      <td class="membrete_datos" > &nbsp; 
        <?=number_format(pg_result($resultado_query, $j, 4),2);?>
      </td>
      <td class="membrete_datos" > 
        <div align="center"> 
          <input type="hidden" name="hf_id_colegio_<?=($j)?>" value="<?=pg_result($resultado_query, $j, 0)?>">
          <input type="hidden" name="hf_id_cuenta_<?=($j)?>" value="<?=pg_result($resultado_query, $j, 2)?>">
          <input type="hidden" name="hf_id_categoria_<?=($j)?>" value="<?=pg_result($resultado_query, $j, 1)?>">
          <input type="hidden" name="hf_id_moneda_<?=($j)?>" value="<?=pg_result($resultado_query, $j, 3)?>">
          <input type="button" name="cb_delete" value="E" class="cb_submit_9_20x17" onClick="if (confirm('¿Esta seguro que desea eliminar el PLAN?')){MM_delete.value = hf_id_colegio_<?=($j)?>.value;MM_delete_02.value = hf_id_cuenta_<?=($j)?>.value;MM_delete_04.value = hf_id_categoria_<?=($j)?>.value;MM_delete_03.value = hf_id_moneda_<?=($j)?>.value;this.form.submit()}">
        </div>
      </td>
      <?
	  $li_salto   = 6;
	  $li_salto_v = 7;
	  For ($x=0; $x<$total_filas_extra; $x++)
	  {
	  ?>
      <td class="linea_datos_01"> 
        <div align="center">Aplica<br>
          <input type="hidden" name="hf_id_extra_<?=($j)?>_<?=($x)?>" value="<?=Trim(pg_result($resultado_query_extra, $x, 1));?>">
          <input type="checkbox" name="cbx_aplica_<?=($j)?>_<?=($x)?>" value="checkbox" <? IF (pg_result($resultado_query_seleccion, $j, $li_salto) == 1) {echo "Checked"; }  ?>>
        </div>
      </td>
      <td class="linea_datos_01" > 
        <div align="left">Valor<br>
		<?
		$li_id_signo = Trim(pg_result($resultado_query_extra, $x, 4));
		?>
		<?
		If($li_id_signo == '%')
		{
		$ls_largo_campo = 3;
		}Else
		{
		$ls_largo_campo = 10;
		}
		?>
          <input type="text" name="tf_valor_<?=($j)?>_<?=($x)?>" class="text_9_x_50" value="<?=Trim(pg_result($resultado_query_seleccion, $j, $li_salto_v))?>" maxlength="<?=($ls_largo_campo)?>" onKeyPress="Numero()">
        </div>
      </td>
      <?
	  $li_salto_v = $li_salto_v + 2;
	  $li_salto   = $li_salto + 2;
	  }
	  ?>
    </tr>
    <?
	}
	pg_freeresult($resultado_query);
	?>
  </table>
  <br>
  <table width="99%" border="0" align="center" cellspacing="0" cellpadding="0">
    <tr> 
      <td> 
        <div align="center">
          <input type="submit" name="cb_save" value="Grabar &gt;&gt;" class="cb_none_9_x_70">
        </div>
      </td>
    </tr>
  </table>
  <input type="hidden" name="hf_total_filas" value="<?=($total_filas_seleccion)?>">
  <input type="hidden" name="hf_total_columnas" value="<?=($total_filas_extra)?>">
  <input type="hidden" name="MM_delete">
  <input type="hidden" name="MM_delete_02">
  <input type="hidden" name="MM_delete_03">
  <input type="hidden" name="MM_delete_04">
</form>
<?
	}
	}
?>
</body>
</html>
<Script>
function Numero()
{
var key = window.event.keyCode;
	if (key < 40 || key > 57)
	{
	window.event.keyCode=0;
	}
}
</Script>