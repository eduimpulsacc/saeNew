<?include"../../../Coneccion/conexion.php"?>

<?

	$li_id_nivel   = Trim($_GET["ai_nivel"]);

	$li_id_perfil  = Trim($_GET["ai_perfil"]);

	$li_id_usuario = Trim($_GET["ai_usuario"]);

	$li_id_colegio_selec  = Trim($_GET["ai_colegio_selec"]);



	

	$sql= "Select * From con_categoria where rdb = $li_id_colegio_selec Order by nombre;";

	$resultado_query_cue = pg_exec($conexion,$sql);

	$total_filas_cue     = pg_numrows($resultado_query_cue);

		

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



function MM_openBrWindow(theURL,winName,features) { //v2.0

  window.open(theURL,winName,features);

}

//-->

</script>

</head>



<body class="pagina" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">

<FORM NAME="Listas" METHOD="POST" ACTION="">

  <table width="700" border="0" cellpadding="0" cellspacing="0">

    <tr> 

      <td width="49%"> 

        <div align="right"><font size="1">Nivel :</font> 

          <select name="ddlb_cuenta" class="text_9_x_100">

		  <?

			for ($j=0; $j<$total_filas_cue; $j++)

			{

		  ?>

              <option value="<?=Trim(pg_result($resultado_query_cue, $j, 1));?>"><?=Trim(pg_result($resultado_query_cue, $j, 2));?></option>

		  <?

		  }

		  ?>

          </select>

          <input type="hidden" name="ddlb_colegio" value="<?=($li_id_colegio_selec)?>">

          &nbsp; </div>

      </td>

      <td   width="51%"> <font size="1"> 

        <input type="button" name="cb_buscar" value="Buscar &gt;&gt;" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'main\']','resultado_down.php?ai_mostrar=2&ai_colegio='+ddlb_colegio.value+'&ai_categoria='+ddlb_cuenta.options[ddlb_cuenta.selectedIndex].value);return document.MM_returnValue">

        <input type="button" name="cb_go" value="Ayuda" class="cb_none_9_x_70" onClick="MM_openBrWindow('ayuda.php','','status=yes,menubar=yes,scrollbars=yes,width=550,height=390')" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>

        </font></td>

    </tr>

  </table>

</form>

</body>

</html>

<?

pg_close($conexion);

?>