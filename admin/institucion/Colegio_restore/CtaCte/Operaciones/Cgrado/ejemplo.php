<?include"../../../Coneccion/conexion.php"?>
<?
$li_id_grupo = $_GET["ai_grupo"];
?>
<?
	if($_POST["cb_go"] != '')
	{	

	$ls_campos = Trim($_POST["campos_2"]);
	
	if($ls_campos =='')
	{?>
	<Script>
	window.location.href="update.php?ai_grupo=<?=($li_id_grupo)?>"
	</Script>
	<?}
	
	$sql= "Select * From grupocolegios Where id_grupo = $li_id_grupo and id_institucion = $ls_campos;";
	$resultado_query_val= pg_exec($conexion_colegio,$sql);
	$total_filas_val= pg_numrows($resultado_query_val);
	
		If($total_filas_val <= 0)
		{
		//echo("Grabe");
		
		$sql= "INSERT INTO grupocolegios VALUES($li_id_grupo, $ls_campos);";
		$resultado_query= pg_exec($conexion_colegio,$sql);
		}

	}
?>

<?
	if($_POST["cb_back"] != '')
	{	

	$ls_campos = Trim($_POST["campos"]);
	
	if($ls_campos =='')
	{?>
	<Script>
	window.location.href="update.php?ai_grupo=<?=($li_id_grupo)?>"
	</Script>
	<?}
	
	$sql= "Delete From grupocolegios Where id_grupo = $li_id_grupo and id_institucion = $ls_campos;";
	$resultado_query= pg_exec($conexion_colegio,$sql);
	
	}
?>

<?
	
	$sql= "Select * From institucion ORDER By rdb";
	$resultado_query_inst= pg_exec($conexion,$sql);
	$total_filas_inst= pg_numrows($resultado_query_inst);
	
	$sql= "Select * From grupocolegios Where id_grupo = $li_id_grupo";
	$resultado_query_selec= pg_exec($conexion_colegio,$sql);
	$total_filas_selec= pg_numrows($resultado_query_selec);
	
	$sql= "Select * From grupo_colegios Where id_grupo = $li_id_grupo";
	$resultado_query_mostrar= pg_exec($conexion_colegio,$sql);
	$total_filas_mostrar= pg_numrows($resultado_query_mostrar);
	
	//pg_close($conexion);
	pg_close($conexion_colegio);
?>
<html>
<head>
<title>Untitled Document</title>
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
  <table width="75%" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr> 
      <td class="membrete_datos"> 
        <div align="center">ID :</div>
      </td>
      <td class="membrete_datos" colspan="2">&nbsp;<?=pg_result($resultado_query_mostrar, 0, 0);?> </td>
    </tr>
    <tr> 
      <td class="membrete_datos"> 
        <div align="center">NOMBRE :</div>
      </td>
      <td class="membrete_datos" colspan="2">&nbsp;<?=Trim(pg_result($resultado_query_mostrar, 0, 1));?> </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" colspan="3">
        <div align="right">&nbsp; 
          <input type="button" name="cb_go" value="Volver" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'main\']','resultado.php');return document.MM_returnValue" >
        </div>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_05"> 
        <div align="center">COLEGIOS</div>
      </td>
      <td class="linea_datos_05"> 
        <div align="center">&nbsp;</div>
      </td>
      <td class="linea_datos_05"> 
        <div align="center">COLEGIOS SELECCIONADOS</div>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_05" rowspan="4"> 
        <div align="center"> 
          <select name="campos_2" size="12" multiple class="ddlb_9_x_300">
            <?
			For ($j=0; $j < $total_filas_inst; $j++)
			{
		  ?>
            <option value="<?=pg_result($resultado_query_inst, $j, 0);?>"> 
            <?=Trim(pg_result($resultado_query_inst, $j, 2));?>
            </option>
            <?
		  }
		  ?>
          </select>
        </div>
      </td>
      <td class="linea_datos_05"> 
        <div align="center">&nbsp;</div>
      </td>
      <td class="linea_datos_05" rowspan="4"> 
        <div align="center"> 
          <select name="campos" size="12" multiple class="ddlb_9_x_300">
            <?
			For ($j=0; $j < $total_filas_selec; $j++)
			{
			$li_id = pg_result($resultado_query_selec, $j, 1);
			
			$sql= "Select rdb, nombre_instit From institucion Where rdb = $li_id;";
			//echo("Dentro $sql <BR>")
			$resultado_query_name= pg_exec($conexion,$sql);
		    ?>
            <option value="<?=pg_result($resultado_query_name, 0, 0);?>"><?=pg_result($resultado_query_name, 0, 1);?></option>
			<?
			}
			?>
          </select>
        </div>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_05"> 
        <div align="center"> 
          <input type="submit" name="cb_go" value="&gt;&gt;" class="cb_submit_9_25x17" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>
        </div>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_05"> 
        <div align="center"> 
          <input type="submit" name="cb_back" value="&lt;&lt;" class="cb_submit_9_25x17" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>
        </div>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_05">&nbsp;</td>
    </tr>
  </table>  
</form>
</body>
</html>
<?
pg_close($conexion);
?>