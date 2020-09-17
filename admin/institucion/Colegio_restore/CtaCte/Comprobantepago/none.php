<? include"../../Coneccion/conexion.php"?>
<?
		$li_id_usuario	   = Trim($_GET["ai_usuario"]);
		$ls_ctacte		   = Trim($_GET["as_ctacte"]);
		//Echo("ls_ctacte : $ls_ctacte <BR>");
		$li_id_comprobante = Trim($_GET["ai_comprobante"]);
		$ls_comprobante	   = Trim($_GET["as_comprobante"]);

?>

<?
	
		$sql_mostrar_com = "Select * From con_comprobante Where id_comprobante = $li_id_comprobante and id_ctacte = Trim('$ls_ctacte') ;";
		//Echo("SQL : $sql_mostrar_com <BR>");
		$resultado_query_mostrar_com = pg_exec($conexion,$sql_mostrar_com);
		$total_filas_mostrar_com     = pg_numrows($resultado_query_mostrar_com);
			

		$sql_muestra_doc = "Select a.*, b.nombre From con_documento a, con_tipo_documento b Where a.id_comprobante = $li_id_comprobante And a.id_tipo_documento = b.id_tipo_documento ;";
		$resultado_query_muestra_doc = pg_exec($conexion,$sql_muestra_doc);
		$total_filas_muestra_doc     = pg_numrows($resultado_query_muestra_doc);

		
			$sql_verifica = "Select rut_apoderado From con_apoderado_ctacte Where id_ctacte = '$ls_ctacte' ;";
			$resultado_query_verifica = pg_exec($conexion,$sql_verifica);
			$total_filas_verifica     = pg_numrows($resultado_query_verifica);
			
				If($total_filas_verifica > 0)
				{
				$ls_rut_apoderado = Trim(pg_result($resultado_query_verifica, 0, 0));
				}

		$sql_dato = "Select rut_apo, dig_rut, nombre_apo, ape_pat, ape_mat From apoderado b Where rut_apo = Trim('$ls_rut_apoderado') ;";
		//Echo( $sql_dato );
		$resultado_query_dato = pg_exec($conexion,$sql_dato);

		pg_close($conexion);

?>
<?


	//$hoy = getdate();
	$year_actual = substr(pg_result($resultado_query_mostrar_com, 0, 3),0,4);
	$mes_actual  = substr(pg_result($resultado_query_mostrar_com, 0, 3),4,2);
	$dia_actual  = substr(pg_result($resultado_query_mostrar_com, 0, 3),6,2);

	  If($mes_actual == 1)
	  {
	  $li_nombre_mes = "ENERO";
	  }Else If($mes_actual == 2) 
	  {
	  $li_nombre_mes = "FEBRERO";
	  }Else If($mes_actual == 3) 
	  {
	  $li_nombre_mes = "MARZO";
	  }Else If($mes_actual == 4) 
	  {
	  $li_nombre_mes = "ABRIL";
	  }Else If($mes_actual == 5) 
	  {
	  $li_nombre_mes = "MAYO";
	  }Else If($mes_actual == 6) 
	  {
	  $li_nombre_mes = "JUNIO";
	  }Else If($mes_actual == 7) 
	  {
	  $li_nombre_mes = "JULIO";
	  }Else If($mes_actual == 8) 
	  {
	  $li_nombre_mes = "AGOSTO";
	  }Else If($mes_actual == 9) 
	  {
	  $li_nombre_mes = "SEPTIEMBRE";
	  }Else If($mes_actual == 10) 
	  {
	  $li_nombre_mes = "OCTUBRE";
	  }Else If($mes_actual == 11) 
	  {
	  $li_nombre_mes = "NOVIEMBRE";
	  }Else If($mes_actual == 12) 
	  {
	  $li_nombre_mes = "DICIEMBRE";
	  }

	$ldt_fecha_actual = $dia_actual." de ".$li_nombre_mes." de ".$year_actual
	
?>
<html>
<head>
<title>Comprobante de Pago</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../css/objeto.css" type="text/css">
<script language="JavaScript">
<!--
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post" action="">
  <br>
  <br>
  <table width="600" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td colspan="2" class="linea_datos_02"> 
        <div align="center"><b><font size="2">COMPROBANTE DE PAGO. 
          </font></b></div>
      </td>
    </tr>
    <tr> 
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="37%"> 
        <div align="right">NOMBRE APODERADO :</div>
      </td>
      <td class="membrete_datos" width="63%">&nbsp; 
        <?=Trim(pg_result($resultado_query_dato, 0, 2));?>
        <?=Trim(pg_result($resultado_query_dato, 0, 3));?>
        <?=Trim(pg_result($resultado_query_dato, 0, 4));?>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="37%"> 
        <div align="right">RUT APODERADO :</div>
      </td>
      <td class="membrete_datos" width="63%">&nbsp; 
        <?=Trim(pg_result($resultado_query_dato, 0, 0));?>
        - 
        <?=pg_result($resultado_query_dato, 0, 1);?>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="37%"> 
        <div align="right">N&deg; CTACTE :</div>
      </td>
      <td class="membrete_datos" width="63%"> &nbsp; 
        <?=pg_result($resultado_query_mostrar_com, 0, 1);?>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="37%"> 
        <div align="right"> N&deg; ESTADO PAGO :</div>
      </td>
      <td class="membrete_datos" width="63%">&nbsp; 
        <?=($ls_comprobante)?>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="37%"> 
        <div align="right">TOTAL A PAGAR :</div>
      </td>
      <td class="membrete_datos" width="63%">&nbsp; 
        <?=number_format(pg_result($resultado_query_mostrar_com, 0, 9),2);?>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="37%"> 
        <div align="right">FECHA CANCELACION :</div>
      </td>
      <td class="membrete_datos" width="63%">&nbsp; 
        <?=($ldt_fecha_actual)?>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="37%"> 
        <div align="right">OBSERVACIONES 1 :</div>
      </td>
      <td class="membrete_datos" width="63%"> &nbsp; 
        <?=pg_result($resultado_query_mostrar_com, 0, 10);?>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="37%" > 
        <div align="right">OBSERVACIONES 2 :</div>
      </td>
      <td class="membrete_datos" width="63%" > &nbsp; 
        <?=pg_result($resultado_query_mostrar_com, 0, 11);?>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="37%"> 
        <div align="right">CANCELA :</div>
      </td>
      <td class="membrete_datos" width="63%"> &nbsp; 
        <?
	  $ls_cancela = Trim(pg_result($resultado_query_mostrar_com, 0, 5));
	  	If($ls_cancela == 'T')
		{
		$ls_cancela_name = "TOTAL";
		}Else
		{
		$ls_cancela_name = "ABONO";
		}
	  ?>
        <?=($ls_cancela_name)?>
      </td>
    </tr>
  </table>  
  <br>
  <table width="600" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td class="linea_datos_02" colspan="5"> 
        <div align="center"><b><font size="2">DETALLE DE DOCUMENTOS CANCELADOS.</font></b></div>
      </td>
    </tr>
    <tr> 
      <td  colspan="5">&nbsp;</td>
    </tr>
    <tr> 
      <td class="linea_datos_05" width="99"> 
        <div align="center">TIPO DOCUMENTO</div>
      </td>
      <td class="linea_datos_05" width="151"> 
        <div align="center">NUMERO - SERIE</div>
      </td>
      <td class="linea_datos_05" width="150"> 
        <div align="center">MONTO $</div>
      </td>
      <td class="linea_datos_05" width="184"> 
        <div align="center">OBSERVACION 1</div>
      </td>
      <td class="linea_datos_05"> 
        <div align="center">OBSERVACION 2</div>
      </td>
    </tr>
    <?
	$li_suma_monto = 0;
	For ($j=0; $j < $total_filas_muestra_doc; $j++)
	{
	?>
    <tr> 
      <td class="membrete_datos" width="99">&nbsp; 
        <?print Trim(pg_result($resultado_query_muestra_doc, $j, 7));?>
      </td>
      <td class="membrete_datos" width="151">&nbsp; 
        <?print Trim(pg_result($resultado_query_muestra_doc, $j, 3));?>
      </td>
      <td class="membrete_datos" width="150">&nbsp; 
        <?=number_format(pg_result($resultado_query_muestra_doc, $j, 4),2);?>
        <?
		$li_suma_monto = $li_suma_monto + pg_result($resultado_query_muestra_doc, $j, 4);
		?>
      </td>
      <td class="membrete_datos" width="184">&nbsp; 
        <?print Trim(pg_result($resultado_query_muestra_doc, $j, 5));?>
      </td>
      <td class="membrete_datos">&nbsp; 
        <?print Trim(pg_result($resultado_query_muestra_doc, $j, 6));?>
      </td>
    </tr>
    <?
	}
	?>
    <tr> 
      <td class="membrete_datos" colspan="2"> 
        <div align="right"><b>TOTAL $</b></div>
      </td>
      <td class="membrete_datos" width="150">&nbsp; 
        <?=number_format(($li_suma_monto),2)?>
      </td>
      <td class="membrete_datos" colspan="2">&nbsp;</td>
    </tr>
  </table>
  <br>
  <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td> 
        <div align="center" id="capa0"> 
  		<input 	name="cmdimprimiroriginal" type="button" class="cb_none_9_x_100" id="cmdimprimiroriginal" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onclick="imprimir();" value="Imprimir">		  
        </div>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
