<? include"../../../Coneccion/conexion.php"?>
<?
	if($_POST["cb_save"] != '')
	{
		$li_id_colegio     = Trim($_POST["hf_id"]);
		$ldt_dia_emision   = Trim($_POST["ddlb_de"]);
		$ldt_dia_vencimi   = Trim($_POST["ddlb_dv"]);
		$ldt_dia_cierre    = Trim($_POST["ddlb_dc"]);
		$li_opcion	       = Trim($_POST["hf_opcion"]);
		$li_id_interes     = $_POST["dldb_interes"];
		
		If($li_opcion == 0)
		{

		$sql_insert = "INSERT INTO con_parametro VALUES($li_id_colegio, $ldt_dia_emision, $ldt_dia_vencimi, $ldt_dia_cierre, $li_id_interes) ;";
		$res_insert = pg_exec($conexion,$sql_insert);
		
		}Else{
	
		$sql_update = "Update con_parametro set dia_emision = $ldt_dia_emision, dia_vencimiento = $ldt_dia_vencimi, dia_cierre = $ldt_dia_cierre, tipo_interes = $li_id_interes Where rdb = $li_id_colegio ;";
		$res_update = pg_exec($conexion,$sql_update);
		
		}
	
	}
?>
<?
	$li_id_colegio = $_GET["ai_colegio_selec"];


	$sql= "select * From con_parametro Where rdb = $li_id_colegio ;";	
	$resultado_query = pg_exec($conexion,$sql);
	$total_filas     = pg_numrows($resultado_query);
	
	$sql= "select nombre_instit From institucion Where rdb = $li_id_colegio ;";	
	$resultado_query_instit = pg_exec($conexion,$sql);
	$total_filas_instit     = pg_numrows($resultado_query_instit);

	pg_close($conexion);
?>
<?
	$li_agno_actual = date(Y);
	$li_agno_actual = $li_agno_actual + 2;
	$li_cant_agno   = $li_agno_actual - 2003;
?>
<html>
<head>
<title>MODULOS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../../css/objeto.css" type="text/css">
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

	If($total_filas<=0)
	{
	$li_opcion = 0; //Nuevo
		echo("<Center><br><br><font size='2'><b>No se encontró una Configuración de Fechas...</b></font></Center>");
	}else
	{
		$li_opcion = 1; //Existe
	}
?>
<br><br>
  <table width="60%" border="1" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td colspan="2" class="linea_datos_02"> <div align="center">PARAMETRO DE 
          DATOS.</div></td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="37%"> <div align="center">Instituci&oacute;n 
          :</div></td>
      <td class="membrete_datos" width="63%">&nbsp; 
        <?=pg_result($resultado_query_instit, 0 ,0)?>
        <input type="hidden" name="hf_id" value="<?=($li_id_colegio)?>"> <input type="hidden" name="hf_opcion" value="<?=($li_opcion)?>"> 
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="37%"> <div align="center">Dia Emisi&oacute;n 
          :</div></td>
      <td class="membrete_datos" width="63%"> 
        <?
	If($total_filas<=0)
	{
		$ldt_dia_emision = 0;
	}else{
		$ldt_dia_emision = pg_result($resultado_query, 0, 1);
	}
	  ?>
        <select name="ddlb_de" class="ddlb_9_x">
          <?
	For ($j=1; $j <= 31; $j++)
	{
		echo "<option value='".substr('00',1,2-strlen($j)) ."$j' ";
			
			if($ldt_dia_emision == 0)
			{
				if($j==date(j))
				{
					print "Selected";
				}
			
			}else{
			
				if($j==$ldt_dia_emision)
				{
					print "Selected";
				}			
			}
				
		echo ">".substr('00',1,2-strlen($j))."$j</option> ";
	}
	?>
        </select> </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="37%"> <div align="center">Dia Vencimiento 
          :</div></td>
      <td class="membrete_datos" width="63%"> 
        <?
		If($total_filas<=0)
		{
		$ldt_dia_venci = 0;
		}Else{
		$ldt_dia_venci = pg_result($resultado_query, 0, 2);
		}
		?>
        <select name="ddlb_dv" class="ddlb_9_x">
          <?
	For ($j=1; $j <= 31; $j++)
	{
		echo "<option value='".substr('00',1,2-strlen($j)) ."$j' ";
			if($ldt_dia_venci == 0)
			{
				if($j==date(j))
				{
					print "Selected";
				}
			
			}Else{
			
				if($j==$ldt_dia_venci)
				{
					print "Selected";
				}			
			}
		echo ">".substr('00',1,2-strlen($j))."$j</option> ";
	}
	?>
        </select> </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" width="37%"> <div align="center">Dia Cierre :</div></td>
      <td class="membrete_datos" width="63%"> 
        <?
		If($total_filas<=0)
		{
		$ldt_dia_cierre = 0;
		}Else{
		$ldt_dia_cierre = pg_result($resultado_query, 0, 3);
		}
		?>
        <select name="ddlb_dc" class="ddlb_9_x">
          <?
	For ($j=1; $j <= 31; $j++)
	{
		echo "<option value='".substr('00',1,2-strlen($j)) ."$j' ";
			if($ldt_dia_cierre == 0)
			{
				if($j==date(j))
				{
					print "Selected";
				}
			
			}Else{
			
				if($j==$ldt_dia_cierre)
				{
					print "Selected";
				}			
			}
		echo ">".substr('00',1,2-strlen($j))."$j</option> ";
	}
	?>
        </select> </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"><div align="center">inter&eacute;s aplicable</div></td>
      <td class="membrete_datos">
	    <?
		If($total_filas<=0)
		{
			$li_interes = 0;
		}else{
			$li_interes = pg_result($resultado_query, 0, 4);
		}
		?>

	  <select name="dldb_interes" class="ddlb_9_x_100" id="dldb_interes">
          <option value="1" <? if($li_interes == 1){ echo("selected");}?>>Simple</option>
          <option value="2" <? if($li_interes == 2){ echo("selected");}?>>Compuesto</option>
        </select></td>
    </tr>
  </table>
  <br>
  <table width="60%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td> 
        <div align="center">
          <input type="submit" name="cb_save" value="Grabar" class="cb_none_9_x_70">
        </div>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
