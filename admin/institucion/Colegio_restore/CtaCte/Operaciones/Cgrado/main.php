<? include"../../../Coneccion/conexion.php"?>
<?
$li_mostrar      = 1;
$li_id_colegio   = $_GET["ai_colegio_selec"];
$li_id_categoria = $_GET["ai_categoria"];
//echo("BANDERA 1 Categoria : ($li_id_categoria) <BR>");
?>
<?
	if($_POST["cb_go"] != '')
	{	

		$ls_campos       = $_POST["campos_2"];
		$li_id_categoria = Trim($_POST["ddlb_categoria"]);
		$li_split		 = split(",",$ls_campos);
		
		
		if($ls_campos =='')
		{?>
			<Script>
			window.location.href="none.asp";
			</Script>
		<?
		}
	
	$sql= "Select * From con_categoria_grado Where rdb = $li_id_colegio And id_categoria = $li_id_categoria And ensenanza = $li_split[1] And grado = $li_split[0] ";
	$resultado_query_val= pg_exec($conexion,$sql);
	$total_filas_val= pg_numrows($resultado_query_val);
	
		If($total_filas_val <= 0)
		{
		//echo("Grabe");
		
		$sql= "INSERT INTO con_categoria_grado VALUES($li_id_colegio, $li_id_categoria, $li_split[1], $li_split[0]);";
		$resultado_query= pg_exec($conexion,$sql);
		}

	}
?>

<?
	if($_POST["cb_back"] != '')
	{	

	$ls_campos 		 = $_POST["campos"];
	$li_split		 = split(",",$ls_campos);
	$li_id_categoria = Trim($_POST["ddlb_categoria"]);
	
	if($ls_campos =='')
		{?>
			<Script>
			window.location.href="none.asp"
			</Script>
		<?
		}
	
	$sql= "Delete From con_categoria_grado Where rdb = $li_id_colegio And id_categoria = $li_id_categoria And ensenanza = $li_split[1] And grado = $li_split[0] ;";
	//echo("Delete : $sql <br>");
	$resultado_query= pg_exec($conexion,$sql);
	
	}
?>

<?
	if($li_mostrar == 1)
	{


		if($li_id_categoria =='')
		{
			$sql_cat_inicio = "Select id_categoria From con_categoria where rdb = $li_id_colegio Order By nombre;";
			$resultado_query_categoria_inicio = pg_exec($conexion,$sql_cat_inicio);
			$total_filas_categoria_inicio     = pg_numrows($resultado_query_categoria_inicio);
		
			if($total_filas_categoria_inicio<=0)
			{}else{
				$li_id_categoria = pg_result($resultado_query_categoria_inicio, 0, 0);
			}
			
		}else{
				$li_id_categoria = $li_id_categoria;
		}
		//echo("BANDERA 2 Categoria : ($li_id_categoria) <BR>");


		if($li_id_categoria>0)
		{


	//*** QUERY QUE MUESTRA LOS GRADOS 
	$sql_grados = "select distinct (e.grado_curso), e.ensenanza , f.nombre_tipo from matricula b, curso e, tipo_ensenanza f where b.rdb = $li_id_colegio and b.id_curso = e.id_curso and e.ensenanza = f.cod_tipo group by e.grado_curso, e.ensenanza, f.nombre_tipo ";
	//echo( $sql_grados );
	$resultado_query_grados = pg_exec($conexion,$sql_grados);
	$total_filas_grados     = pg_numrows($resultado_query_grados);

	//*** QUERY QUE MUESTRA LOS GRADOS SELECCIONADOS
	$sql_selec= "Select a.*, b.nombre_tipo From con_categoria_grado a, tipo_ensenanza b Where a.rdb = $li_id_colegio And a.id_categoria = $li_id_categoria And a.ensenanza = b.cod_tipo ;";
	$resultado_query_selec = pg_exec($conexion,$sql_selec);
	$total_filas_selec     = pg_numrows($resultado_query_selec);
	
	//*** QUERY QUE MUESTRA EL NOMBRE DE LA INSTITUCION
	$sql= "Select nombre_instit From institucion  where rdb = $li_id_colegio ;";
	$resultado_query_mostrar= pg_exec($conexion,$sql);
	$total_filas_mostrar= pg_numrows($resultado_query_mostrar);

	//*** QUERY QUE MUESTRA LAS CATEGORIAS
	$sql_cat= "Select * From con_categoria where rdb = $li_id_colegio Order By nombre;";
	$resultado_query_categoria = pg_exec($conexion,$sql_cat);
	$total_filas_categoria     = pg_numrows($resultado_query_categoria);
		}
		
	}
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
	if($li_mostrar == 1 AND $li_id_categoria>0)
	{
?>
  <table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="linea_datos_02">
        <div align="center"><font color="#FFFFFF" size="2"><strong>GRADOS DE LOS 
          NIVELES.</strong></font></div>
      </td>
    </tr>
  </table><br>

  <table width="75%" border="1" align="center" cellpadding="2" cellspacing="0">
    <tr> 
      <td class="membrete_datos">
        <div align="center">INSTITUCION :</div>
      </td>
      <td class="membrete_datos" colspan="2">&nbsp; 
        <?=pg_result($resultado_query_mostrar, 0, 0);?>
        <input type="hidden" name="hf_id_colegio" value="<?=($li_id_colegio)?>">
      </td>
    </tr>
    <tr> 
      <td class="membrete_datos"> 
        <div align="center">NIVEL :</div>
      </td>
      <td class="membrete_datos" colspan="2">&nbsp;
        <select name="ddlb_categoria" class="ddlb" OnChange="parent.Cuerpo.location.href='main.php?ai_mostrar=1&ai_colegio_selec='+hf_id_colegio.value+'&ai_categoria='+ddlb_categoria.options[ddlb_categoria.selectedIndex].value">
            <?
			For ($j=0; $j < $total_filas_categoria; $j++)
			{
			?>
          <option value="<?=pg_result($resultado_query_categoria, $j, 1);?>" <? if(pg_result($resultado_query_categoria, $j, 1) == $li_id_categoria) {echo("selected");}?>> <?=Trim(pg_result($resultado_query_categoria, $j, 2));?></option>
			  <?
			  }
		  ?>		  
        </select>
      </td>
    </tr>
    <tr> 
      <td height="19" colspan="3" class="linea_datos_02"> 
        <div align="right">&nbsp; </div>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center">LISTADO DE GRADOS DE INSTITUCION</div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center">&nbsp;</div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center">GRADOS SELECCIONADOS</div>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02" rowspan="4"> 
        <div align="center"> 
          <select name="campos_2" size="12" multiple class="ddlb_9_x_300">
            <?
			For ($j=0; $j < $total_filas_grados; $j++)
			{
		  ?>
            <option value="<?=pg_result($resultado_query_grados, $j, 0)?>,<?=pg_result($resultado_query_grados, $j, 1)?>"> 
            <?=Trim(pg_result($resultado_query_grados, $j, 0));?> [ <?=pg_result($resultado_query_grados, $j, 2);?> ]
            </option>
            <?
		  }
		  ?>
          </select>
        </div>
      </td>
      <td class="linea_datos_02"> 
        <div align="center">&nbsp;</div>
      </td>
      <td class="linea_datos_02" rowspan="4"> 
        <div align="center"> 
          <select name="campos" size="12" multiple class="ddlb_9_x_300">
            <?
			For ($j=0; $j < $total_filas_selec; $j++)
			{
		    ?>
            <option value="<?=pg_result($resultado_query_selec, $j, 3);?>,<?=pg_result($resultado_query_selec, $j, 2);?>"> 
            <?=pg_result($resultado_query_selec, $j, 3);?> [ <?=pg_result($resultado_query_selec, $j, 4);?> ]
            </option>
            <?
			}
			?>
          </select>
        </div>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center"> 
          <input type="submit" name="cb_go" value="&gt;&gt;" class="cb_submit_9_25x17">
        </div>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02"> 
        <div align="center"> 
          <input type="submit" name="cb_back" value="&lt;&lt;" class="cb_submit_9_25x17">
        </div>
      </td>
    </tr>
    <tr> 
      <td class="linea_datos_02">&nbsp;</td>
    </tr>
  </table> 
<?
}Else
{
echo("<Center><br><br><font size='2'><b>Ingrese Niveles a la Institución..</b></font></Center>");
}
?>   
</form>
</body>
</html>
<?
	if($li_mostrar == 1)
	{
pg_close($conexion);
	}
?>