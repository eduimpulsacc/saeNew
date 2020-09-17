<? include"../../../Coneccion/conexion.php"?>
<?
$hoy = getdate();
$year_actual = $hoy["year"];
$mes_actual  = date(m); //Numero del mes Rango 01 al 12
$dia_actual  = $hoy["mday"];

$ldt_periodo = $year_actual.$mes_actual;
$ls_rut_apoderado = $_GET["as_rut_apoderado"];
$li_id_colegio    = $_GET["ai_id_colegio"];

?>
<?
	$sql_datos_cuentas= "SELECT a.rdb, a.id_cuenta, b.rut_apoderado, c.id_ctacte, c.cuenta_nombre, c.monto, c.rut_alumno, c.monto_saldo, (c.monto + c.monto_saldo) as Total_apagarconsaldo FROM con_categoria_cuenta a, con_apoderado_ctacte b, con_estado_pago_detalle c where a.rdb = $li_id_colegio and a.rdb = b.rdb and b.rut_apoderado = '$ls_rut_apoderado' and c.periodo = '$ldt_periodo' and b.id_ctacte = c.id_ctacte and a.id_cuenta = c.cuenta_id ORDER BY 5";
	//echo("SQL SACA VALORES (3) : <BR> $sql_datos_cuentas <br>");			
	$resultado_query_datos_cuentas = pg_exec($conexion,$sql_datos_cuentas);
	$total_filas_datos_cuentas     = pg_numrows($resultado_query_datos_cuentas);

?>
<html>
<head>
<title>Verificar Saldos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../css/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="form1" method="post" action="">
  <table width="400" border="1" align="center" cellpadding="0" cellspacing="1">
    <tr class="linea_datos_02"> 
      <td colspan="2"><div align="center">Saldos Mes Anterior</div></td>
    </tr>
    <tr class="linea_datos_02"> 
      <td colspan="2"><div align="center">*** Los siguientes Valores han sido 
          calculados<br>
          en base a Intereses por parte de la instituci&oacute;n.</div></td>
    </tr>
    <tr> 
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr class="linea_datos_02"> 
      <td>Nombre Cuenta</td>
      <td><div align="center">Valor</div></td>
    </tr>
    <?
	$li_total_saldo = 0;
	$ls_mensaje		= "";
	For ($x=0; $x < $total_filas_datos_cuentas; $x++)
	{
	
	$li_monto_saldo = pg_result($resultado_query_datos_cuentas, $x, 7);
	$li_total_saldo = $li_total_saldo + $li_monto_saldo;

		if($li_monto_saldo != 0)
		{
		
			if($li_monto_saldo < 0)
			{ $ls_mensaje = "(Saldo a Favor)";}else{ $ls_mensaje = "";}
	?>
    <tr class="membrete_datos"> 
      <td>&nbsp; 
        <?=pg_result($resultado_query_datos_cuentas, $x, 4);?> <?=($ls_mensaje)?>
      </td>
      <td><div align="right">&nbsp; 
          <?=number_format($li_monto_saldo,2)?>
        </div></td>
    </tr>
    <?
		}
	}
	?>	
    <tr class="linea_datos_02"> 
      <td><div align="right">tOTAL :</div></td>
      <td><div align="right">&nbsp; 
          <?=number_format($li_total_saldo,2)?>
        </div></td>
    </tr>

  </table>
</form>
</body>
</html>
