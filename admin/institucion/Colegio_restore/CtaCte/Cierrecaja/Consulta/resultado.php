<? include"../../../Coneccion/conexion.php"?>
<?
if($_GET["MM_delete"] != '')
{
	$li_id_comprobante = $_GET["MM_delete"];
	$li_id_usuario	   = $_GET["hf_usuario"];
	$ldt_fecha_inicio  = $_GET["hf_fecha_ini"];
	$ldt_fecha_fin	   = $_GET["hf_fecha_fin"];

	?>
	<Script>
	window.location.href="resultado.php?ai_id_comprobante=<?=($li_id_comprobante)?>&ai_mostrar=1&ai_mostrar_tabla2=1&ai_usuario=<?=($li_id_usuario)?>&hf_fecha_ini=<?=($ldt_fecha_inicio)?>&hf_fecha_fin=<?=($ldt_fecha_fin)?>";
	</Script>
	<?		

}
?>
<?
	$li_id_usuario= Trim($_GET["ai_usuario"]);
	$li_mostrar	  = Trim($_GET["ai_mostrar"]);
	$li_mostrar_tabla = $_GET["ai_mostrar_tabla2"];

	if($li_mostrar_tabla == 1)
	{
		$ldt_fecha_inicio = $_GET["hf_fecha_ini"];
		$ldt_fecha_fin	  = $_GET["hf_fecha_fin"];
	
	}else{

		$ldt_dia_ini	  = Trim($_GET["ai_dia_i"]);
		$ldt_mes_ini	  = Trim($_GET["ai_mes_i"]);
		$ldt_year_ini	  = Trim($_GET["ai_year_i"]);
		$ldt_fecha_inicio = $ldt_year_ini.$ldt_mes_ini.$ldt_dia_ini;
		
		$ldt_dia_fin	  = Trim($_GET["ai_dia_f"]);
		$ldt_mes_fin	  = Trim($_GET["ai_mes_f"]);
		$ldt_year_fin	  = Trim($_GET["ai_year_f"]);
		$ldt_fecha_fin    = $ldt_year_fin.$ldt_mes_fin.$ldt_dia_fin;	
	}
	
	$sql = "Select Distinct a.*, b.*, c.ep_id_ctacte From con_cierre_caja a, con_cierre_detalle b, con_comprobante c Where a.id_usuario = 21 And a.fecha >= '$ldt_fecha_inicio' And  a.fecha <= '$ldt_fecha_fin' And a.id_cierre = b.id_cierre And b.id_comprobante = c.id_comprobante ORDER BY 5,2,3 ; ";
	//echo(" <br> Pasar : ($li_id_usuario) - ($li_mostrar) - Fecha : ($ldt_fecha_inicio) > Fecha : ($ldt_fecha_fin) <BR><BR> $sql ");	
	$resultado_query = pg_exec($conexion,$sql);
	$total_filas     = pg_numrows($resultado_query);
	
?>
<?
	if($li_mostrar_tabla == 1)
	{
	
	$li_id_comprobante = $_GET["ai_id_comprobante"];
	
	$sql_DOC = "Select Distinct c.ep_id_ctacte , d.rut_apoderado, d1.dig_rut,d1.nombre_apo, d1.ape_pat, d1.ape_mat, e.id_comprobante, e.id_tipo_documento, e.numero, e.monto, f.nombre From con_comprobante c, con_apoderado_ctacte d, apoderado d1, con_documento e, con_tipo_documento f Where c.id_comprobante = $li_id_comprobante And c.id_comprobante = e.id_comprobante And c.ep_id_ctacte = d.id_ctacte And c.ep_correlativo = d.correlativo And d.rut_apoderado = d1.rut_apo And e.id_tipo_documento = f.id_tipo_documento ORDER BY 1,2,4,5,6,7 ";
	//echo("<br> $sql_DOC");
	$resultado_query_DOC = pg_exec($conexion,$sql_DOC);
	$total_filas_DOC     = pg_numrows($resultado_query_DOC);
	
	}

?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../../css/objeto.css" type="text/css">

</head>

<body marginwidth="0" marginheight="0">
<form name="form1" action="">
  <?
If ($li_mostrar == 1)
{

	If ($total_filas > 0)
	{
?>
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr class="linea_datos_02"> 
      <td colspan="5"><div align="center">consulta de cierre de caja.
          <input name="hf_fecha_ini" type="hidden" value="<?=($ldt_fecha_inicio)?>">
          <input name="hf_fecha_fin" type="hidden" value="<?=($ldt_fecha_fin)?>">
          <input name="hf_usuario"   type="hidden" value="<?=($li_id_usuario)?>">
		  
        </div></td>
    </tr>
  </table>
  <table width="650" border="1" align="center" cellpadding="1" cellspacing="1">	
    <tr class="linea_datos_02"> 
      <td width="139"><div align="center">usuario</div></td>
      <td colspan="4">&nbsp; 
        <?=($li_id_usuario)?>
      </td>
    </tr>
    <tr class="linea_datos_02"> 
      <td><div align="center">fecha</div></td>
      <td width="137"><div align="center">hora</div></td>
      <td width="83"><div align="center"> id cierre</div></td>
      <td width="96"><div align="center">n&deg; Documentos</div></td>
      <td width="167"><div align="center">monto</div></td>
    </tr>
    <?
	For ($x=0; $x < $total_filas; $x++)
	{
	?>
    <tr class="membrete_datos"> 
      <td><div align="right">&nbsp; <?print substr(Trim(pg_result($resultado_query, $x, 1)),6,2);?>/<?print substr(Trim(pg_result($resultado_query, $x, 1)),4,2);?>/<?print substr(Trim(pg_result($resultado_query, $x, 1)),0,4);?></div></td>
      <td><div align="right">&nbsp; <?print substr(pg_result($resultado_query, $x, 2),0,2);?>:<?print substr(pg_result($resultado_query, $x, 2),2,2);?>,<?print substr(pg_result($resultado_query, $x, 2),4,2);?></div></td>
      <td><div align="right">&nbsp; <?print (pg_result($resultado_query, $x, 4));?></div></td>
      <td><div align="right"> 
          <?
	$li_comprobante = pg_result($resultado_query, $x, 5);
	$sql_doc = "select count(*) from con_documento where id_comprobante = $li_comprobante ; ";
	$resultado_query_doc = pg_exec($conexion,$sql_doc);
	$total_filas_doc     = pg_numrows($resultado_query_doc);
	
	If($total_filas_doc <= 0)
	{
		$li_total_doc = 0;
	}Else
	{
		$li_total_doc = pg_result($resultado_query_doc, 0, 0);
	}
?>
          <input name="hf_comprobante_<?=($x)?>" type="hidden" value="<?=($li_comprobante)?>">
          <a href="#" onClick="MM_delete.value=hf_comprobante_<?=($x)?>.value;form1.submit()"> 
          <?=($li_total_doc)?>
          </a> </div></td>
      <td><div align="right">&nbsp; <?print number_format(pg_result($resultado_query, $x, 6),2);?></div></td>
      <?
	 }
 	pg_close($conexion);
	 ?>
    </tr>
  </table>
  <?
	  }Else{
	  echo("<Center><Font size='1' face='Verdana, Arial, Helvetica, sans-serif'><strong>No se encontraron Registros.</strong></Font></Center>");
	  }
  
  
  }Else{
  echo("<Center><Font size='1' face='Verdana, Arial, Helvetica, sans-serif'><br>Ingrese Rango de Fechas.</Font></Center>");
  }
  ?>
<input type="hidden" name="MM_delete">  


<br>
<?
If($li_mostrar_tabla == 1)
{
?>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td class="linea_datos_02"> <div align="center">Ctacte</div></td>
      <td colspan="2" class="membrete_datos">&nbsp;<?print (pg_result($resultado_query_DOC, 0, 0));?></td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="center">Apoderado</div></td>
      <td colspan="2" class="membrete_datos">&nbsp;<?print (pg_result($resultado_query_DOC, 0, 3));?> 
        <?print (pg_result($resultado_query_DOC, 0, 4));?> <?print (pg_result($resultado_query_DOC, 0, 5));?></td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="center">rut</div></td>
      <td colspan="2" class="membrete_datos">&nbsp;<?print (pg_result($resultado_query_DOC, 0, 1));?> 
        - <?print (pg_result($resultado_query_DOC, 0, 2));?></td>
    </tr>
    <tr class="linea_datos_02"> 
      <td><div align="center">documento</div></td>
      <td><div align="center">id-serie</div></td>
      <td><div align="center">monto</div></td>
    </tr>
    <?
	$li_suma = 0;
	For ($j=0; $j < $total_filas_DOC; $j++)
	{
	?>
    <tr class="membrete_datos"> 
      <td>&nbsp;<?print (pg_result($resultado_query_DOC, $j, 10));?></td>
      <td>&nbsp;<?print (pg_result($resultado_query_DOC, $j, 8));?></td>
      <td><div align="right">&nbsp;<?print number_format(pg_result($resultado_query_DOC, $j, 9),2);?></div></td>
	  <?
	  $li_monto= pg_result($resultado_query_DOC, $j, 9);
	  $li_suma = $li_suma + $li_monto;
	  ?>
    </tr>
    <?
	}
	?>
    <tr class="membrete_datos"> 
      <td colspan="2"><div align="right">Total :</div></td>
      <td><div align="right">&nbsp;
          <b><?=number_format($li_suma,2)?></b>
        </div></td>
    </tr>
  </table>
  <?
  }
  ?>
</form>
</body>
</html>
