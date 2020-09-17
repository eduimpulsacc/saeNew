<? include"../../../Coneccion/conexion.php"?>
<?
	$hoy = getdate();
	$year_actual = $hoy["year"];
	$mes_actual  = date(m); //Numero del mes Rango 01 al 12
	$dia_actual  = $hoy["mday"];
?>
<?
	$li_id_usuario = Trim($_GET["ai_usuario"]);
	$li_id_perfil  = Trim($_GET["ai_perfil"]);
	$ldt_mes_consulta = Trim($_GET["ai_mes"]);
	//Echo("Perfil : ($li_id_perfil) - Usuario : ($li_id_usuario) - MesCon : ($ldt_mes_consulta) <BR>");
			

	$ldt_periodo	  = $year_actual.$ldt_mes_consulta;
	If(strlen($ldt_periodo) <= 4)
	{
		$ldt_periodo = $year_actual.$mes_actual;
	}Else
	{
		$ldt_periodo = $year_actual.$ldt_mes_consulta;
	}


		$sql= "Select nombre_usuario From usuario Where id_usuario = $li_id_usuario ";
		$resultado_query_user= pg_exec($conexion,$sql);
		$total_filas_user    = pg_numrows($resultado_query_user);
	
		If($total_filas_user <= 0)
		{
			$ls_rut = 0;
		}Else
		{
			$ls_rut = pg_result($resultado_query_user, 0, 0);	
		}
	
	
	If($ldt_mes_consulta == '')
	{
		
	$sql= "SELECT * FROM con_comprobante WHERE id_ctacte LIKE Upper('%$ls_rut%') ";
	}Else
	{
	
		If($ldt_mes_consulta == -1)
		{
			$sql= "SELECT * FROM con_comprobante WHERE id_ctacte LIKE '%$ls_rut%' ";
		}else{
			$sql= "SELECT * FROM con_comprobante WHERE id_ctacte LIKE '%$ls_rut%' And subStr(fecha,1,6) = '$ldt_periodo' ";
		}
		
	}
	//echo(" SQL $sql <br>");
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas    = pg_numrows($resultado_query);
	
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../../css/objeto.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post" action="">
  <table width="600" border="0" cellspacing="1" cellpadding="1" align="center">
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center"><font size="2">DETALLE DE TRANSACCIONES.</font></div>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_01_sr"> 
        <div align="right"><b><font color="#FF0000"> 
          <input type="hidden" name="hf_usuario" value="<?=($li_id_usuario)?>">
          <input type="hidden" name="hf_perfil" value="<?=($li_id_perfil)?>">
          Consulte Mes :</font></b> 
          <?
		  If($ldt_mes_consulta == '')
		  {
		  ?>
          <select name="ddlb_mi" class="ddlb_9_x_100" OnChange="parent.Cuerpo.location.href='main.php?ai_mes='+ddlb_mi.options[ddlb_mi.selectedIndex].value+'&ai_usuario='+hf_usuario.value+'&ai_perfil='+hf_perfil.value">
            <option value="-1" selected>Todos</option>
            <option value="01">Enero</option>
            <option value="02">Febrero</option>
            <option value="03">Marzo</option>
            <option value="04">Abril</option>
            <option value="05">Mayo</option>
            <option value="06">Junio</option>
            <option value="07">Julio</option>
            <option value="08">Agosto</option>
            <option value="09">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
          </select>
          <?
		  }Else
		  {
		  ?>
          <select name="ddlb_mi" class="ddlb_9_x_100" OnChange="parent.Cuerpo.location.href='main.php?ai_mes='+ddlb_mi.options[ddlb_mi.selectedIndex].value+'&ai_usuario='+hf_usuario.value+'&ai_perfil='+hf_perfil.value">
            <option value="-1" <? If($ldt_mes_consulta==-1) {echo("Selected"); }?>>Todos</option>
            <option value="01" <? If($ldt_mes_consulta==1) {echo("Selected"); }?>>Enero</option>
            <option value="02" <? If($ldt_mes_consulta==2) {echo("Selected"); }?>>Febrero</option>
            <option value="03" <? If($ldt_mes_consulta==3) {echo("Selected"); }?>>Marzo</option>
            <option value="04" <? If($ldt_mes_consulta==4) {echo("Selected"); }?>>Abril</option>
            <option value="05" <? If($ldt_mes_consulta==5) {echo("Selected"); }?>>Mayo</option>
            <option value="06" <? If($ldt_mes_consulta==6) {echo("Selected"); }?>>Junio</option>
            <option value="07" <? If($ldt_mes_consulta==7) {echo("Selected"); }?>>Julio</option>
            <option value="08" <? If($ldt_mes_consulta==8) {echo("Selected"); }?>>Agosto</option>
            <option value="09" <? If($ldt_mes_consulta==9) {echo("Selected"); }?>>Septiembre</option>
            <option value="10" <? If($ldt_mes_consulta==10) {echo("Selected"); }?>>Octubre</option>
            <option value="11" <? If($ldt_mes_consulta==11) {echo("Selected"); }?>>Noviembre</option>
            <option value="12" <? If($ldt_mes_consulta==12) {echo("Selected"); }?>>Diciembre</option>
          </select>
          <?
		 }
		 ?>
        </div>
      </td>
    </tr>
  </table>
  <br>
<?
If($total_filas > 0)
{
?>  
  <table width="650" border="1" cellspacing="0" cellpadding="0" align="center">
    <tr> 
      <td class="linea_datos_02"> <div align="center">Resultados :</div></td>
      <td class="linea_datos_02" colspan="4">&nbsp; 
        <?=($total_filas)?>
        Transacciones</td>
    </tr>
    <tr> 
      <td class="linea_datos_01_sr" colspan="5">&nbsp;</td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> <div align="center">N&deg; CTACTE</div></td>
      <td class="linea_datos_02"> <div align="center">FECHA</div></td>
      <td class="linea_datos_02"> <div align="center">OPERACION</div></td>
      <td class="linea_datos_02"> <div align="center">MONTO A PAGAR</div></td>
      <td class="linea_datos_02"> <div align="center">CAJERO (A)</div></td>
    </tr>
    <?
	$numero = 0;
	$ldt_periodos = "";
	For ($j=0; $j < $total_filas; $j++)
	{

		$numero = $numero + 1;
		$li_id_comprobante = pg_result($resultado_query, $j, 0);
		$ldt_periodos 	   = pg_result($resultado_query, $j, 7);

	?>
    <tr> 
      <td class="membrete_datos"> 
        <?=($numero)?>
        )&nbsp; <?print Trim(pg_result($resultado_query, $j, 1));?> </td>
      <td class="membrete_datos"> <div align="right">&nbsp; 
          <?
		$ldt_fecha = Trim(pg_result($resultado_query, $j, 3));
		$ldt_dia_fecha 	   = substr($ldt_fecha,6,2);
		$ldt_mes_fecha 	   = substr($ldt_fecha,4,2);
		$ldt_year_fecha    = substr($ldt_fecha,0,4);
		?>
          <?=($ldt_dia_fecha)?>
          / 
          <?=($ldt_mes_fecha)?>
          / 
          <?=($ldt_year_fecha)?>
        </div></td>
      <td class="membrete_datos"> &nbsp; 
        <?
		$ls_name_operacion = Trim(pg_result($resultado_query, $j, 5));
		If($ls_name_operacion == 'T')
		{
			$ls_name = "cencela el total";
		}else
		{
			$ls_name = "Abona a la Cuenta";
		}
		?>
        <?=($ls_name)?>
      </td>
      <td class="membrete_datos"> <div align="right">&nbsp; <strong><?print number_format(pg_result($resultado_query, $j, 9),2);?></strong> 
        </div></td>
      <td class="membrete_datos"> <div align="right">&nbsp; <?print Trim(pg_result($resultado_query, $j, 2));?> 
        </div></td>
    </tr>
    <tr> 
      <td class="linea_datos_01_sr" colspan="5">&nbsp;</td>
    </tr>
    <tr> 
      <td class="linea_datos_01" colspan="5"> <div align="center"><b>cuentas CANCELADaS.</b></div></td>
    </tr>
    <tr class="linea_datos_01"> 
      <td colspan="5"><div align="center"><em>Por rut ALumno</em></div></td>
    </tr>
    <tr class="linea_datos_01"> 
      <td colspan="2"><div align="center">Cuenta</div></td>
      <td><div align="center">rut</div></td>
      <td><div align="center">Monto a cancelar</div></td>
      <td><div align="center">Monto Cancelado</div></td>
    </tr>
    <?
		$sql= "SELECT a.*, b.nombre, c.monto FROM con_comprobante_pago a, con_cuenta b, con_estado_pago_detalle c WHERE a.id_comprobante = $li_id_comprobante AND a.id_cuenta = b.id_cuenta AND a.rut_alumno = c.rut_alumno AND a.id_cuenta = c.cuenta_id and c.periodo = '$ldt_periodos' order by 2";
		$resultado_cuentas 	 = pg_exec($conexion,$sql);
		$total_filas_cuentas = pg_numrows($resultado_cuentas);
		
		?>
    <?	
		$li_monto_cancelado = 0;
		For ($x=0; $x < $total_filas_cuentas; $x++)
		{
		?>
    <tr class="linea_datos_01"> 
      <td colspan="2">&nbsp; 
        <?=pg_result($resultado_cuentas, $x, 4);?>
      </td>
      <td>&nbsp; 
        <?=pg_result($resultado_cuentas, $x, 1);?>
      </td>
      <?
	  	$li_monto_cancelado = pg_result($resultado_cuentas, $x, 3);
	  	$li_monto_acancelar = pg_result($resultado_cuentas, $x, 5);
		
		$li_total = ($li_total + $li_monto_cancelado);
		$li_total_acancelar = ($li_total_acancelar + $li_monto_acancelar);
		
	  ?>
      <td><div align="right"><?=number_format($li_monto_acancelar,2)?></div></td>
      <td><div align="right"><?=number_format($li_monto_cancelado,2)?></div></td>
    </tr>
    <?
		}
	?>
    <tr class="linea_datos_01"> 
      <td colspan="3"> <div align="right"><b>Total Cancelado $</b></div></td>
      <td><div align="right"><strong><?=number_format($li_total_acancelar,2)?></strong></div></td>
      <td><div align="right"><strong><?=number_format($li_total,2)?></strong></div></td>
    </tr>
    <tr class="linea_datos_01_sr"> 
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr class="linea_datos_01"> 
      <td colspan="5"><div align="center"><b>DOCUMENTOS CANCELADOS.</b></div></td>
    </tr>
    <tr class="linea_datos_01"> 
      <td> <div align="center">Item</div></td>
      <td> <div align="center">DOCUMENTO</div></td>
      <td> <div align="center">NUMERO-SERIE</div></td>
      <td> <div align="center">MONTO</div></td>
      <td> <div align="center">OBSERVACION</div></td>
    </tr>
    <?
		$sql= "Select DISTINCT a.*, b.nombre From con_documento a, con_tipo_documento b Where a.id_comprobante = $li_id_comprobante And a.id_tipo_documento = b.id_tipo_documento ";
		$resultado_query_doc = pg_exec($conexion,$sql);
		$total_filas_doc     = pg_numrows($resultado_query_doc);
		
		?>
    <?	
		$li_total_cancelado = 0;
		For ($x=0; $x < $total_filas_doc; $x++)
		{
		?>
    <tr> 
      <td class="linea_datos_01">&nbsp; <?print pg_result($resultado_query_doc, $x, 1);?> 
      </td>
      <td class="linea_datos_01">&nbsp; <?print pg_result($resultado_query_doc, $x, 7);?> 
      </td>
      <td class="linea_datos_01"> <div align="right">&nbsp; <?print pg_result($resultado_query_doc, $x, 3);?> 
        </div></td>
      <td class="linea_datos_01"> <div align="right">&nbsp; <?print number_format(pg_result($resultado_query_doc, $x, 4),2);?> 
          <?
		$li_total_cancelado = $li_total_cancelado + pg_result($resultado_query_doc, $x, 4);
		?>
        </div></td>
      <td class="linea_datos_01">&nbsp; <?print Trim(pg_result($resultado_query_doc, $x, 5));?> 
      </td>
    </tr>
    <?
		}
		?>
    <tr> 
      <td class="linea_datos_01" colspan="3"> <div align="right"><b>Total Cancelado 
          $</b> </div></td>
      <td class="linea_datos_01"> <div align="right">&nbsp; <b> 
          <?=number_format($li_total_cancelado,2)?>
          </b></div></td>
      <td class="linea_datos_01">&nbsp;</td>
    </tr>
    <tr> 
      <td class="linea_datos_01_sr" colspan="5">&nbsp;</td>
    </tr>
    <?
	}
	?>
  </table>
<?
}Else
{
Echo("<Center><Font size='2'><b>No Existen Transacciones ... </b></Font></Center>");
}
?>  
</form>
</body>
</html>
<?
pg_close($conexion);
s?>