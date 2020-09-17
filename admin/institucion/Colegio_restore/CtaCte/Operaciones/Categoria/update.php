<? include"../../../Coneccion/conexion.php"?>

<?

	if($_POST["cb_update"] != '')

	{

		$li_id_colegio    = $_POST["hf_id_colegio"];

		$li_id_categoria  = $_POST["hf_id_categoria"];

		$ls_nombre        = Trim($_POST["tf_nombre"]);

	

		//echo "<BR> Actualizando id : ($li_id) Nombre : $ls_nombre ";

	

		$sql_update = "Update con_categoria set nombre = '$ls_nombre' Where rdb = $li_id_colegio and id_categoria = $li_id_categoria;";

		$res_update = pg_exec($conexion,$sql_update);

		

	?>

	<Script>

	window.location.href="update.php?ai_id=<?=($li_id_colegio)?>&ai_id_categoria=<?=($li_id_categoria)?>"

	</Script>

	<?}

?>

<?

	$li_id           = $_GET["ai_id"];

	$li_id_categoria = $_GET["ai_id_categoria"];



	$sql= "Select * From con_categoria Where rdb = $li_id and id_categoria = $li_id_categoria;";

	$resultado_query = pg_exec($conexion,$sql);

	$total_filas     = pg_numrows($resultado_query);

	

	$sql= "Select rdb, nombre_instit From institucion Order By nombre_instit;";

	$resultado_query_instit = pg_exec($conexion,$sql);

	$total_filas_instit     = pg_numrows($resultado_query_instit);

	

	pg_close($conexion);



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

  <table width="50%" border="1" align="center" cellpadding="2" cellspacing="0">

    <tr> 

      <td class="linea_datos_02"> 

        <div align="center">ID :</div>

      </td>

      <td class="membrete_datos">&nbsp; 

        <?=pg_result($resultado_query, $j, 1);?>

        <input type="hidden" name="hf_id_colegio" value="<?=pg_result($resultado_query, $j, 0);?>">

        <input type="hidden" name="hf_id_categoria" value="<?=pg_result($resultado_query, $j, 1);?>">

      </td>

    </tr>

    <tr> 

      <td class="linea_datos_02"> 

        <div align="center">NOMBRE :</div>

      </td>

      <td class="membrete_datos"> 

        <input type="text" name="tf_nombre" value="<?=Trim(pg_result($resultado_query, 0, 2));?>" class="text_9_x_300">

      </td>

    </tr>

  </table>  

  <br>

  <table width="50%" border="0" align="center" cellspacing="0" cellpadding="0">

    <tr>

      <td> 

        <div align="center">

          <input type="button" name="cb_go" value="Volver" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'main\']','resultado.php?ai_mostrar=1&ai_colegio=<?=($li_id)?>');return document.MM_returnValue" >

          <input type="submit" name="cb_update" value="Grabar &gt;&gt;" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>

        </div>

      </td>

    </tr>

  </table>

    <input type="hidden" name="MM_update">

</form>

</body>

</html>

