<?include"../../../Coneccion/conexion.php"?>



<?

if($_POST["MM_delete"] != '')

{

	$li_id_colegio    = $_POST["MM_delete"];

	$li_id_categoria  = $_POST["MM_delete_02"];

	//echo "<BR> Eliminando id : ($li_id) ";



	$sql_delete = "Delete From con_categoria Where rdb = $li_id_colegio and id_categoria = $li_id_categoria;";

	$res_delete = pg_exec($conexion,$sql_delete);

	

	$sql_delete_02 = "Delete From con_categoria_grado Where rdb = $li_id_colegio and id_categoria = $li_id_categoria;";

	$res_delete_02 = pg_exec($conexion,$sql_delete_02);



}

?>



<?

$li_criterio   = Trim($_GET["ai_criterio"]);

$ls_input      = Trim($_GET["as_input"]);

$li_mostrar    = $_GET["ai_mostrar"];

$li_id_colegio = $_GET["ai_colegio"];



	If($li_mostrar == 1)

	{ //Despliegue



	if ($li_criterio  == 1)

	

	{

	$sql= "select a.rdb, a.id_categoria, a.nombre, b.rdb, b.nombre_instit from con_categoria a, institucion b where Upper(a.nombre) like Upper('$ls_input%') and a.rdb = $li_id_colegio and a.rdb = b.rdb Order by 1,2;";	

	}else

	{

	$sql= "select a.rdb, a.id_categoria, a.nombre, b.rdb, b.nombre_instit from con_categoria a, institucion b where Upper(a.nombre) like Upper('%$ls_input%') and a.rdb = $li_id_colegio and a.rdb = b.rdb Order by 1,2;";	

	}

	//echo("Cri : $li_criterio - <BR> $sql");

	$resultado_query = pg_exec($conexion,$sql);

	$total_filas     = pg_numrows($resultado_query);

	

	}//Cierra el Despligue

	

	pg_close($conexion);



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

If($li_mostrar == 1)

{ //Despliegue

?>



<?

If($total_filas <=0)

{

echo("<Center><br><br><font size='2'><b>No se encontraron Registros...</b></font></Center>");

}Else

{

?>

  <table width="85%" border="0" align="center" cellspacing="1" cellpadding="0">
    <tr> 

      <td class="linea_datos_02" colspan="4">RESULTADOS : 

        <?echo $total_filas?>

      </td>

    </tr>

    <tr> 

      <td class="linea_datos_05" width="47%"> 

        <div align="center">NOMBRE COLEGIO</div>

      </td>

      <td class="linea_datos_05" width="8%"> 

        <div align="center">ID</div>

      </td>

      <td class="linea_datos_05" width="33%"> 

        <div align="center">NOMBRE CATEGORIA</div>

      </td>

      <td class="linea_datos_05" width="12%">&nbsp;</td>

    </tr>

    <?

	For ($j=0; $j < $total_filas; $j++)

	{

	?>

    <tr> 

      <td class="membrete_datos" width="47%"> 

        <div align="left">&nbsp; 

          <?print Trim(pg_result($resultado_query, $j, 4));?>

        </div>

      </td>

      <td class="membrete_datos" width="8%">&nbsp; 

        <?print pg_result($resultado_query, $j, 1);?>

      </td>

      <td class="membrete_datos" width="33%">&nbsp; 

        <?print Trim(pg_result($resultado_query, $j, 2));?>

      </td>

      <td class="membrete_datos" width="12%"> 

        <div align="center"> 

          <input type="hidden" name="hf_id_colegio_<?=($j)?>" value="<?=pg_result($resultado_query, $j, 0)?>">

          <input type="hidden" name="hf_id_categoria_<?=($j)?>" value="<?=pg_result($resultado_query, $j, 1)?>">

          <input type="button" name="cb_update" value="M" class="cb_submit_9_20x17" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'main\']','update.php?ai_id='+hf_id_colegio_<?=($j)?>.value+'&ai_id_categoria='+hf_id_categoria_<?=($j)?>.value);return document.MM_returnValue" >

          <input type="button" name="cb_delete" value="E" class="cb_submit_9_20x17" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="if (confirm('�Esta seguro que desea eliminar esta Categoria ...Se eliminara de todo el Sistema?')){MM_delete.value = hf_id_colegio_<?=($j)?>.value;MM_delete_02.value = hf_id_categoria_<?=($j)?>.value;this.form.submit()}">

        </div>

      </td>

    </tr>

    <?

	}

	pg_freeresult($resultado_query);

	?>

  </table>

  <input type="hidden" name="MM_delete">

  <input type="hidden" name="MM_delete_02">

<?

}

?>







<?

}Else

{

ECHO("<BR><Center><Font size='2'>Ingrese Criterios para la Busqueda...</font></Center>");}

?>  

</form>

</body>

</html>

