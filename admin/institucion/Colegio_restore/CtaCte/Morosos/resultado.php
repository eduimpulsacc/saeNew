<? include"../../Coneccion/conexion.php"?>
<?
	$li_criterio   = $_GET["ai_criterio"];
	$ls_input      = Trim($_GET["as_input"]);
	$li_mostrar    = $_GET["ai_mostrar"];
	$li_id_colegio = $_GET["ai_colegio"];

	$hoy		 = getdate();
	$dia_actual  = $hoy["mday"];
	$mes_actual  = date(m);	
	$year_actual = $hoy["year"];
	$ldt_periodo = $year_actual.$mes_actual;


	If($li_mostrar == 1)
	{ //Despliegue


	if ($li_criterio  == 1)
	{
		$ls_criterio = "'$ls_input%'";
	}else{
		$ls_criterio = "'%$ls_input%'";
	}
	$sql= "select Distinct a1.rut_apoderado, b.nombre_instit, b2.rut_apo, b2.nombre_apo, c.monto, b2.ape_pat, b2.ape_mat From con_apoderado_ctacte a1, institucion b, apoderado b2, con_estado_pago c Where Upper(b2.nombre_apo || b2.ape_pat || b2.ape_mat) like Upper($ls_criterio) and b2.rut_apo = a1.rut_apoderado And a1.rdb = $li_id_colegio And a1.rdb = b.rdb And a1.id_ctacte = c.id_ctacte And c.periodo = '$ldt_periodo' And c.vigente = 'S' Order by 5,6,3";		
	//echo("SQL : $sql ");
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas    = pg_numrows($resultado_query);
	
	
	}//Cierra Despliegue

?>
<html>
<head>
<title>MODULOS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../css/objeto.css" type="text/css">
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
<?
	If($li_mostrar == 1)
	{ //Despliegue
	
		If($total_filas <= 0)
		{
		echo("<BR><Center><Font size='1'><b> No se encontraron Apoderados con Saldo al mes Actual.</b></Center>");
		}else
		{
?>
  <table width="90%" border="1" align="center" cellspacing="0" cellpadding="0">
    <tr> 
      <td class="linea_datos_02" colspan="4"> <div align="center"><b><font size="2">INFORME 
          DE APODERADOS MOROSOS.</font></b></div></td>
    </tr>
    <tr> 
      <td class="linea_datos_02" > <div align="right">NOMBRE INSTITUCI&Oacute;N 
          :</div></td>
      <td class="linea_datos_02" colspan="3" >&nbsp; <b> 
        <?=pg_result($resultado_query, 0, 1);?>
        </b></td>
    </tr>
    <tr> 
      <td class="linea_datos_01_sr" colspan="4" >&nbsp;</td>
    </tr>
    <tr> 
      <td class="linea_datos_02" > <div align="center">NOMBRE APODERADO</div></td>
      <td class="linea_datos_02" > <div align="center">SALDO ANTERIOR</div></td>
      <td class="linea_datos_02" > <div align="center">CUOTA del MES+Saldo</div></td>
      <td class="linea_datos_02" > <div align="center">Total</div></td>
    </tr>
    <?
	$li_cancela_mes			= 0;
	$li_monto_saldo 		= 0;
	$li_monto_apagar_fila_2 = 0;
	$li_monto_apagar_fila_3	= 0;
	$li_monto_cancela_mes   = 0;
	
	For ($j=0; $j < $total_filas; $j++)
	{
		
		$ls_rut_apoderado  = pg_result($resultado_query, $j, 0);
		
		$sql_datos_cuentas= "SELECT a.rdb, a.id_cuenta, b.rut_apoderado, c.id_ctacte, c.cuenta_nombre, c.monto, c.rut_alumno, c.monto_saldo FROM con_categoria_cuenta a, con_apoderado_ctacte b, con_estado_pago_detalle c where a.rdb = $li_id_colegio and a.rdb = b.rdb and b.rut_apoderado = '$ls_rut_apoderado' and c.periodo = '$ldt_periodo' and b.id_ctacte = c.id_ctacte and a.id_cuenta = c.cuenta_id ORDER BY 5";
		$resultado__datos_cuentas = pg_exec($conexion,$sql_datos_cuentas);
		$total_filas__cuentas     = pg_numrows($resultado__datos_cuentas);

			$li_total_saldo = 0;
			For ($x=0; $x < $total_filas__cuentas; $x++)
			{
			
			$li_monto_saldo = pg_result($resultado__datos_cuentas, $x, 7);
			$li_total_saldo = $li_total_saldo + $li_monto_saldo;
			
			}

	?>
    <tr> 
		<!-- CAMBIE EL ORDEN DE PRESENTACION DEL NOMBRE DE NOMBRE, APE_PAT, APE_MAT A APE_PAT,APE_MAT,NOMBRE -->
	
      <td class="membrete_datos" > <div align="left">&nbsp; <?print Trim(pg_result($resultado_query, $j, 5));?> 
          <?print Trim(pg_result($resultado_query, $j, 6));?> <?print Trim(pg_result($resultado_query, $j, 3));?></div></td>
      <td class="membrete_datos" > 
        <div align="right">&nbsp; 
          <?=number_format($li_total_saldo,2)?>
        </div></td>
      <td class="membrete_datos" > 
        <?
	  $li_cuota_mes = pg_result($resultado_query, $j, 4);
	  ?>
        <div align="right">&nbsp; 
          <?=number_format($li_cuota_mes,2);?>
        </div></td>
      <td class="membrete_datos" > 
        <?
	  $li_cancela_mes = ($li_total_saldo + $li_cuota_mes);
	  ?>
        <div align="right">&nbsp; 
          <?=number_format($li_cancela_mes,2)?>
        </div></td>
    </tr>
    <?
	$li_monto_saldo_anterior = $li_monto_saldo_anterior + $li_total_saldo;
	$li_monto_apagar_fila_3	 = $li_monto_apagar_fila_3 + $li_cuota_mes;
	$li_monto_cancela_mes	 = $li_monto_cancela_mes + $li_cancela_mes;
	}
	?>
    <tr class="linea_datos_02"> 
      <td > <div align="right"><b>TOTALES Mes Apoderados $ </b></div></td>
      <td ><div align="right">&nbsp; 
          <?=number_format($li_monto_saldo_anterior,2)?>
        </div></td>
      <td ><div align="right">&nbsp; 
          <?=number_format($li_monto_apagar_fila_3,2)?>
        </div></td>
      <td ><div align="right">&nbsp; 
          <?=number_format($li_monto_cancela_mes,2)?>
        </div></td>
    </tr>
  </table>
  <br>
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><div align="center" id="capa0">
          <input name="cmdimprimiroriginal" type="button" class="cb_none_9_x_100" id="cmdimprimiroriginal" onclick="imprimir();" value="Imprimir">
        </div></td>
    </tr>
  </table>
  <?
		}

	}else
	{
	echo("<BR><Center><Font size='2'>Ingrese Criterios para la Busqueda...</Font></Center>");
	}
?>
</form>
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
<?
pg_close($conexion);
?>