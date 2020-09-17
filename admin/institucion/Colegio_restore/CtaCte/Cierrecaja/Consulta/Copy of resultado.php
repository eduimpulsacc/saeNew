<? include"../../../Coneccion/conexion.php"?>
<?
	$li_id_usuario= Trim($_GET["ai_usuario"]);
	$li_mostrar	  = Trim($_GET["ai_mostrar"]);

	$ldt_dia_ini	  = Trim($_GET["ai_dia_i"]);
	$ldt_mes_ini	  = Trim($_GET["ai_mes_i"]);
	$ldt_year_ini	  = Trim($_GET["ai_year_i"]);
	$ldt_fecha_inicio = $ldt_year_ini.$ldt_mes_ini.$ldt_dia_ini;
	
	$ldt_dia_fin	  = Trim($_GET["ai_dia_f"]);
	$ldt_mes_fin	  = Trim($_GET["ai_mes_f"]);
	$ldt_year_fin	  = Trim($_GET["ai_year_f"]);
	$ldt_fecha_fin    = $ldt_year_fin.$ldt_mes_fin.$ldt_dia_fin;	
	
	$sql = "Select Distinct a.*, b.*, c.ep_id_ctacte , d.rut_apoderado, d1.nombre_apo, d1.ape_pat, d1.ape_mat From con_cierre_caja a, con_cierre_detalle b, con_comprobante c, con_apoderado_ctacte d, apoderado d1 Where a.id_usuario = $li_id_usuario And a.fecha >= '$ldt_fecha_inicio' And  a.fecha <= '$ldt_fecha_fin' And a.id_cierre = b.id_cierre And b.id_comprobante = c.id_comprobante And c.ep_id_ctacte = d.id_ctacte And c.ep_correlativo = d.correlativo And d.rut_apoderado = d1.rut_apo ORDER BY 10,11,12 ;";
	echo(" Pasar : ($li_id_usuario) - ($li_mostrar) - Fecha : ($ldt_fecha_inicio) > Fecha : ($ldt_fecha_fin) <BR><BR> $sql ");	
	$resultado_query = pg_exec($conexion,$sql);
	$total_filas     = pg_numrows($resultado_query);
	
	pg_close($conexion);
?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../../css/objeto.css" type="text/css">

</head>

<body>
<form name="form1" method="post" action="">
<?
If ($li_mostrar == 1)
{

	If ($total_filas > 0)
	{
?>
  <table width="650" border="1" align="center" cellpadding="1" cellspacing="1">
    <tr class="linea_datos_02"> 
      <td><div align="center">usuario</div></td>
      <td colspan="5">&nbsp; 
        <?=($li_id_usuario)?>
      </td>
    </tr>
    <tr class="linea_datos_02"> 
      <td><div align="center">fecha</div></td>
      <td><div align="center">hora</div></td>
      <td><div align="center"> comprobante</div></td>
      <td><div align="center">Ctacte</div></td>
      <td><div align="center">monto</div></td>
      <td><div align="center">nombre apoderado</div></td>
    </tr>
    <?
	For ($x=0; $x < $total_filas; $x++)
	{
	?>
    <tr class="membrete_datos"> 
      <td><div align="right">&nbsp; <?print substr(Trim(pg_result($resultado_query, $x, 1)),6,2);?>/<?print substr(Trim(pg_result($resultado_query, $x, 1)),4,2);?>/<?print substr(Trim(pg_result($resultado_query, $x, 1)),0,4);?></div></td>
      <td><div align="right">&nbsp; <?print substr(pg_result($resultado_query, $x, 2),0,2);?>:<?print substr(pg_result($resultado_query, $x, 2),2,2);?>,<?print substr(pg_result($resultado_query, $x, 2),4,2);?></div></td>
      <td><div align="right">&nbsp; <?print (pg_result($resultado_query, $x, 5));?></div></td>
      <td><div align="right">&nbsp; <?print (pg_result($resultado_query, $x, 7));?></div></td>
      <td><div align="right">&nbsp; <?print number_format(pg_result($resultado_query, $x, 6),2);?></div></td>
      <td>&nbsp; <?print Trim(pg_result($resultado_query, $x, 9));?> <?print Trim(pg_result($resultado_query, $x, 10));?> <?print Trim(pg_result($resultado_query, $x, 11));?></td>
      <?
	 }
	 ?>
    </tr>
  </table>
  <?
	  }Else{
	  echo("<Center><Font size='1' face='Verdana, Arial, Helvetica, sans-serif'><strong>No se encontraron Registros.</strong></Font></Center>");
	  }
  
  
  }Else{
  echo("<Center><Font size='1' face='Verdana, Arial, Helvetica, sans-serif'><br>Seleccione Fecha.</Font></Center>");
  }
  ?>
</form>
</body>
</html>
