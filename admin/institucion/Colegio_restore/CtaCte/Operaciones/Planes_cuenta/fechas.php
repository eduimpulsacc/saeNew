<? include"../../../Coneccion/conexion.php"?>

<?

$li_id_colegio    = $_GET["ai_colegio"];

$li_id_cuenta     = $_GET["ai_cuenta"];

$li_id_categoria  = $_GET["ai_categoria"];

?>

<?

	$sql= "select 'checked' as estado, a.id_mes as periodo, b.nombre from con_categoria_cuenta_periodo a, con_periodo_fecha b where a.id_mes = b.id_fecha and a.rdb = $li_id_colegio and a.id_categoria = $li_id_categoria and a.id_cuenta = $li_id_cuenta union select 'unchecked' as estado, id_fecha as periodo, nombre from con_periodo_fecha where id_fecha not in ( select id_mes from con_categoria_cuenta_periodo where rdb = $li_id_colegio and id_categoria = $li_id_categoria and id_cuenta = $li_id_cuenta ) order by periodo ;";

	//echo(" Mostrar : $li_mostrar_tabla <BR> SQL : $sql <BR>");

	$resultado_query = pg_exec($conexion,$sql);

	$total_filas     = pg_numrows($resultado_query);

?>

<html>

<head>

<title>Seleccion del MES</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="stylesheet" href="../../../css/objeto.css" type="text/css">

</head>



<body bgcolor="#FFFFFF" text="#000000">

<form name="form1" method="post" action="procesar.php">

  <table width="40%" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr> 

      <td colspan="2" class="linea_datos_02">

        <div align="center"><b>PERIODO DE CUENTA.</b></div>

      </td>

    </tr>

    <tr> 

      <td colspan="2" class="linea_datos_05"> 

        <div align="center">MES 

          <input type="hidden" name="hf_id_colegio" value="<?=($li_id_colegio)?>">

          <input type="hidden" name="hf_id_categoria" value="<?=($li_id_categoria)?>">

          <input type="hidden" name="hf_id_cuenta" value="<?=($li_id_cuenta)?>">

        </div>

      </td>

    </tr>

    <?

	For ($j=0; $j<$total_filas; $j++)

	{	

	?>

    <tr> 

      <td class="linea_datos_template"> 

        <div align="center"> 

          <?

		$ls_estado = Trim(pg_result($resultado_query, $j, 0));

		

		If($ls_estado == 'checked')

		{

		?>

          <input type="checkbox" name="cbx_mes_<?=($j)?>" value="<?=pg_result($resultado_query, $j, 1)?>" checked>

          <?

		}Else{

		?>

          <input type="checkbox" name="cbx_mes_<?=($j)?>" value="<?=pg_result($resultado_query, $j, 1)?>" >

          <?

		}

		?>

        </div>

      </td>

      <td class="linea_datos_template"> 

        <?

	  If($j == 0)

	  {

	  $li_nombre_mes = "ENERO";

	  }Else If($j == 1) 

	  {

	  $li_nombre_mes = "FEBRERO";

	  }Else If($j == 2) 

	  {

	  $li_nombre_mes = "MARZO";

	  }Else If($j == 3) 

	  {

	  $li_nombre_mes = "ABRIL";

	  }Else If($j == 4) 

	  {

	  $li_nombre_mes = "MAYO";

	  }Else If($j == 5) 

	  {

	  $li_nombre_mes = "JUNIO";

	  }Else If($j == 6) 

	  {

	  $li_nombre_mes = "JULIO";

	  }Else If($j == 7) 

	  {

	  $li_nombre_mes = "AGOSTO";

	  }Else If($j == 8) 

	  {

	  $li_nombre_mes = "SEPTIEMBRE";

	  }Else If($j == 9) 

	  {

	  $li_nombre_mes = "OCTUBRE";

	  }Else If($j == 10) 

	  {

	  $li_nombre_mes = "NOVIEMBRE";

	  }Else If($j == 11) 

	  {

	  $li_nombre_mes = "DICIEMBRE";

	  }

	  ?>

        <?=($li_nombre_mes)?>

      </td>

    </tr>

    <?

	}

	?>

    <tr> 

      <td class="linea_datos_template" colspan="2"> 

        <div align="center"> 

          <input type="submit" name="cb_save" value="Grabar" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>

        </div>

      </td>

    </tr>

  </table>

  <input type="hidden" name="hf_total" value="<?=($total_filas)?>">

</form>

</body>

</html>

