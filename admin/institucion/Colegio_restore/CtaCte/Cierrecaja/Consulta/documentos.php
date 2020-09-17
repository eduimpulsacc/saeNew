<? include"../../../Coneccion/conexion.php"?>
<?
	$li_id_comprobante = $_POST["MM_delete"];
?>
<?
	$sql_DOC = "Select Distinct c.ep_id_ctacte , d.rut_apoderado, d1.dig_rut,d1.nombre_apo, d1.ape_pat, d1.ape_mat, e.id_comprobante, e.id_tipo_documento, e.numero, e.monto, f.nombre From con_comprobante c, con_apoderado_ctacte d, apoderado d1, con_documento e, con_tipo_documento f Where c.id_comprobante = $li_id_comprobante And c.id_comprobante = e.id_comprobante And c.ep_id_ctacte = d.id_ctacte And c.ep_correlativo = d.correlativo And d.rut_apoderado = d1.rut_apo And e.id_tipo_documento = f.id_tipo_documento ORDER BY 1,2,4,5,6,7 ";
	$resultado_query = pg_exec($conexion,$sql_DOC);
	$total_filas     = pg_numrows($resultado_query);
?>
<html>
<head>
<title>DOC</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<br>
  <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td class="linea_datos_02"> <div align="center">Ctacte</div></td>
      <td colspan="2" class="membrete_datos">&nbsp;<?print (pg_result($resultado_query, 0, 0));?></td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="center">Apoderado</div></td>
      <td colspan="2" class="membrete_datos">&nbsp;<?print (pg_result($resultado_query, 0, 3));?> 
        <?print (pg_result($resultado_query, 0, 4));?> <?print (pg_result($resultado_query, 0, 5));?></td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="center">rut</div></td>
      <td colspan="2" class="membrete_datos">&nbsp;<?print (pg_result($resultado_query, 0, 1));?> 
        - <?print (pg_result($resultado_query, 0, 2));?></td>
    </tr>
    <tr class="linea_datos_02"> 
      <td><div align="center">documento</div></td>
      <td><div align="center">id-serie</div></td>
      <td><div align="center">monto</div></td>
    </tr>
    <?
	$li_suma = 0;
	For ($x=0; $x < $total_filas; $x++)
	{
	?>
    <tr class="membrete_datos"> 
      <td>&nbsp;<?print (pg_result($resultado_query, $x, 10));?></td>
      <td>&nbsp;<?print (pg_result($resultado_query, $x, 8));?></td>
      <td><div align="right">&nbsp;<?print number_format(pg_result($resultado_query, $x, 9),2);?></div></td>
	  <?
	  $li_monto= pg_result($resultado_query, $x, 9);
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
  <br>
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><div align="center" id="capa0">
          <input name="cmdimprimiroriginal" type="button" class="cb_none_9_x_100" id="cmdimprimiroriginal" onclick="imprimir();" value="Imprimir">
        </div></td>
    </tr>
  </table>
</body>
</html>
<script>
function imprimir() 

{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
