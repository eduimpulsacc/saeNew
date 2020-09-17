<? include"../../../Coneccion/conexion.php"?>
<?
	$hoy = getdate();
	$year_actual = $hoy["year"];
	$mes_actual  = date(m); //Numero del mes Rango 01 al 12
	$dia_actual  = $hoy["mday"];
?>
<?
	$li_colegio_selec  = Trim($_GET["ai_colegio_selec"]);
	$li_id_usuario     = Trim($_GET["ai_usuario"]);
	$li_id_perfil      = Trim($_GET["ai_perfil"]);
	$ldt_mes_consulta  = Trim($_GET["ai_mes"]);
	$li_mostrar        = Trim($_GET["ai_mostrar"]);
	$li_criterio       = Trim($_GET["ai_criterio"]);
	$ls_input          = Trim($_GET["as_input"]);
	$ls_campo          = Trim($_GET["ai_campo"]);
	
	$ls_rut_apoderado  = Trim($_GET["as_rut_apo"]);
	//Echo("Perfil : ($li_id_perfil) - Usuario : ($li_id_usuario) - MesCon : ($ldt_mes_consulta) - Col:($li_colegio_selec) <BR> Rut : ($ls_rut_apoderado) <BR>");
			

	$ldt_periodo	  = $year_actual.$ldt_mes_consulta;
	If(strlen($ldt_periodo) <= 4)
	{
	$ldt_periodo = $year_actual.$mes_actual;
	}Else
	{
	$ldt_periodo = $year_actual.$ldt_mes_consulta;
	}

IF($li_mostrar == 1)
{


	If($li_criterio == 1) //Empieze con
	{
		
		$sql_2= "Select distinct a.rdb, a.id_ano, b.rut_apo, c.nombre_apo, c.ape_pat, c.ape_mat, e.nro_ano From matricula a, tiene2 b, apoderado c, ano_escolar e where a.rdb = $li_colegio_selec And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.nro_ano = $year_actual And e.situacion = 1 and a.rut_alumno = b.rut_alumno And (Upper($ls_campo)) Like Upper('$ls_input%') and b.rut_apo = c.rut_apo Order by 5, 6, 4 ;";
	
	}Else //Contenga
	{
		$sql_2= "Select distinct a.rdb, a.id_ano, b.rut_apo, c.nombre_apo, c.ape_pat, c.ape_mat, e.nro_ano From matricula a, tiene2 b, apoderado c, ano_escolar e where a.rdb = $li_colegio_selec And a.rdb = e.id_institucion And a.id_ano = e.id_ano And e.nro_ano = $year_actual And e.situacion = 1 and a.rut_alumno = b.rut_alumno And (Upper($ls_campo)) Like Upper('%$ls_input%') and b.rut_apo = c.rut_apo Order by 5, 6, 4 ;";
	} 
	
		//echo("SQL 2: $sql_2 <BR>");
		$resultado_query_user= pg_exec($conexion,$sql_2);
		$total_filas_user    = pg_numrows($resultado_query_user);

	If($ls_rut_apoderado <> '')
	{
	$ls_rut = $ls_rut_apoderado;
	}Else
	{
	$ls_rut = Trim(pg_result($resultado_query_user, 0, 2));
	}


	If($ldt_mes_consulta == '')
	{
		
	$sql= "SELECT * FROM con_comprobante WHERE id_ctacte LIKE Upper('%$ls_rut%') ";
	}Else
	{
	
		If($ldt_mes_consulta == -1)
		{
		$sql= "SELECT * FROM con_comprobante WHERE id_ctacte LIKE '%$ls_rut%' ";
		}Else
		{
		$sql= "SELECT * FROM con_comprobante WHERE id_ctacte LIKE '%$ls_rut%' And subStr(fecha,1,6) = '$ldt_periodo';";
		}
		
	}
	
	$resultado_query= pg_exec($conexion,$sql);
	$total_filas    = pg_numrows($resultado_query);
	
	
} //Cierra If 1
	
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../../css/objeto.css" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" method="post" action="">
<?
IF($li_mostrar == 1)
{

If($total_filas_user > 0)
{
?>

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
          <input type="hidden" name="hf_id_colegio" value="<?=($li_colegio_selec)?>">
          <input type="hidden" name="hf_criterio" value="<?=($li_criterio)?>">
          <input type="hidden" name="hf_input" value="<?=($ls_input)?>">
          <input type="hidden" name="hf_campo" value="<?=($ls_campo)?>">

		Apoderado : 
		  
			<select name="ddlb_apoderado" class="ddlb_9_x_250" OnChange="parent.main.location.href='resultado.php?ai_mostrar=1&as_rut_apo='+ddlb_apoderado.options[ddlb_apoderado.selectedIndex].value+'&ai_colegio_selec='+hf_id_colegio.value+'&ai_mes='+ddlb_mi.options[ddlb_mi.selectedIndex].value+'&ai_criterio='+hf_criterio.value+'&as_input='+hf_input.value+'&ai_campo='+hf_campo.value+'&ai_usuario='+hf_usuario.value+'&ai_perfil='+hf_perfil.value">
          <?
	For ($i=0; $i < $total_filas_user; $i++)
	{
	?>
	
		<!-- CAMBIE EL ORDEN DE PRESENTACION DEL NOMBRE DE NOMBRE, APE_PAT, APE_MAT A APE_PAT,APE_MAT,NOMBRE -->
	
          <option value="<?=Trim(pg_result($resultado_query_user, $i, 2));?>" <? If(Trim(pg_result($resultado_query_user, $i, 2)) == $ls_rut_apoderado) {echo("selected");}?> >
		  <?=Trim(pg_result($resultado_query_user, $i, 4));?> <?=Trim(pg_result($resultado_query_user, $i, 5));?> <?=Trim(pg_result($resultado_query_user, $i, 3));?>
		 </option>
	<?
	}
	?>
        </select>		  
		  
		  
          Consulte Mes :</font></b> 
          <?
		  If($ldt_mes_consulta == '')
		  {
		  ?>
          <select name="ddlb_mi" class="ddlb_9_x_100" OnChange="parent.main.location.href='resultado.php?ai_mostrar=1&ai_mes='+ddlb_mi.options[ddlb_mi.selectedIndex].value+'&ai_usuario='+hf_usuario.value+'&ai_perfil='+hf_perfil.value+'&as_rut_apo='+ddlb_apoderado.options[ddlb_apoderado.selectedIndex].value+'&ai_colegio_selec='+hf_id_colegio.value+'&ai_criterio='+hf_criterio.value+'&as_input='+hf_input.value+'&ai_campo='+hf_campo.value">
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
          <select name="ddlb_mi" class="ddlb_9_x_100" OnChange="parent.main.location.href='resultado.php?ai_mostrar=1&ai_mes='+ddlb_mi.options[ddlb_mi.selectedIndex].value+'&ai_usuario='+hf_usuario.value+'&ai_perfil='+hf_perfil.value+'&as_rut_apo='+ddlb_apoderado.options[ddlb_apoderado.selectedIndex].value+'&ai_colegio_selec='+hf_id_colegio.value+'&ai_criterio='+hf_criterio.value+'&as_input='+hf_input.value+'&ai_campo='+hf_campo.value">
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
      <td class="linea_datos_02"> 
        <div align="center">Resultados :</div>
      </td>
      <td class="linea_datos_02" colspan="4">&nbsp; 
        <?=($total_filas)?>
        Transacciones</td>
    </tr>
    <tr> 
      <td class="linea_datos_01_sr" colspan="5">&nbsp;</td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center">N&deg; CTACTE</div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center">FECHA</div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center">OPERACION</div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center">MONTO A PAGAR</div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center">CAJERO (A)</div>
      </td>
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
        )&nbsp; 
        <?print Trim(pg_result($resultado_query, $j, 1));?>
      </td>
      <td class="membrete_datos"> 
        <div align="right">&nbsp; 
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
        </div>
      </td>
      <td class="membrete_datos"> &nbsp; 
        <?
		$ls_name_operacion = Trim(pg_result($resultado_query, $j, 5));
		If($ls_name_operacion == 'T')
		{
			$ls_name = "cencela el total";
		}Else
		{
			$ls_name = "Abona a la Cuenta";
		}
		?>
        <?=($ls_name)?>
      </td>
      <td class="membrete_datos"> 
        <div align="right">&nbsp; <strong><?print number_format(pg_result($resultado_query, $j, 9),2);?></strong> 
        </div>
      </td>
      <td class="membrete_datos"> 
        <div align="right">&nbsp; 
          <?print Trim(pg_result($resultado_query, $j, 2));?>
        </div>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_01_sr" colspan="5">&nbsp;</td>
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
		$li_monto_acancelar = 0;
		$li_total			= 0;
		$li_total_acancelar = 0;
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
      <td colspan="5"><div align="center"><b>DOCUMENTOS CANCELADOS.</b></div></td>    <tr> 
      <td class="linea_datos_01"> 
        <div align="center">ITEM</div>
      </td>
      <td class="linea_datos_01"> 
        <div align="center">DOCUMENTO</div>
      </td>
      <td class="linea_datos_01"> 
        <div align="center">NUMERO-SERIE</div>
      </td>
      <td class="linea_datos_01"> 
        <div align="center">MONTO</div>
      </td>
      <td class="linea_datos_01"> 
        <div align="center">OBSERVACION</div>
      </td>
    </tr>
    <?
		$li_id_comprobante = pg_result($resultado_query, $j, 0);
		
		$sql= "Select DISTINCT a.*, b.nombre From con_documento a, con_tipo_documento b Where a.id_comprobante = $li_id_comprobante And a.id_tipo_documento = b.id_tipo_documento ;";
		$resultado_query_doc = pg_exec($conexion,$sql);
		$total_filas_doc     = pg_numrows($resultado_query_doc);
		
		?>
    <?	
		$li_total_cancelado = 0;
		For ($x=0; $x < $total_filas_doc; $x++)
		{
		?>
    <tr> 
      <td class="linea_datos_01">
        <div align="center">&nbsp; 
          <?print pg_result($resultado_query_doc, $x, 1);?>
        </div>
      </td>
      <td class="linea_datos_01">&nbsp; 
        <?print pg_result($resultado_query_doc, $x, 7);?>
      </td>
      <td class="linea_datos_01">
        <div align="right">&nbsp; 
          <?print pg_result($resultado_query_doc, $x, 3);?>
        </div>
      </td>
      <td class="linea_datos_01">
        <div align="right">&nbsp; 
          <?print number_format(pg_result($resultado_query_doc, $x, 4),2);?>
          <?
		$li_total_cancelado = $li_total_cancelado + pg_result($resultado_query_doc, $x, 4);
		?>
        </div>
      </td>
      <td class="linea_datos_01">&nbsp; 
        <?print Trim(pg_result($resultado_query_doc, $x, 5));?>
      </td>
    </tr>  
    <?
		}
		?>
	<tr> 
      <td class="linea_datos_01" colspan="3">
        <div align="right"><b>Total Cancelado $</b> </div>
      </td>
      <td class="linea_datos_01">
        <div align="right">&nbsp; <b> 
          <?=number_format($li_total_cancelado,2)?>
          </b></div>
      </td>
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
Echo("<Center><Font size='2'><b>No Existen Transacciones para el Apoderado... </b></Font></Center>");
}
?>
  <?
  }Else // Datos
  {
	Echo("<Center><Font size='1'><BR><BR><b>No se encontraron Apoderados con los Criterios ingresados.</b></Font></Center>");
  }
  
  
}Else // If = 1
{
Echo("<Center><Font size='2'>Ingrese Criterios de Busqueda.</Font></Center>");
} // Cierra If 1
?>
</form>
</body>
</html>
<?
IF($li_mostrar == 1)
{
pg_close($conexion);
}
?>