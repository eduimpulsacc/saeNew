<?

	$li_id_nivel  = Trim($_GET["ai_nivel"]);

	$li_id_perfil = Trim($_GET["ai_perfil"]);

	$li_id_usuario = Trim($_GET["ai_usuario"]);

	$li_id_colegio_selec  = Trim($_GET["ai_colegio_selec"]);

	

	//echo("Nivel : ($li_id_nivel) - Perfil : ($li_id_perfil) <BR>");

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



<body class="pagina">

<form name="form1" method="post" action="">

  <table width="700" border="0" cellpadding="0" cellspacing="0">

    <tr> 

      <td width="56%"> 

        <div align="right">

        <input type="hidden" name="ddlb_colegio" value="<?=($li_id_colegio_selec)?>">

          <font size="1"> 

          <select name="dblb_criterio" class="ddlb_9_x_100">

            <option value="1">Empieze con</option>

            <option value="2">Contenga</option>

          </select>

          <input type="text" name="tf_input" class="input_150">

          &nbsp; </font> </div>

      </td>

      <td   width="44%"> <font size="1"> 

        <input type="button" name="cb_buscar" value="Buscar &gt;&gt;" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'main\']','resultado.php?ai_mostrar=1&ai_criterio='+dblb_criterio.options[dblb_criterio.selectedIndex].value+'&as_input='+tf_input.value+'&ai_colegio='+ddlb_colegio.value);return document.MM_returnValue">

        <input type="button" name="cb_new" value="Nueva Cuenta" class="cb_none_9_x_100" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'main\']','nuevo.php?ai_colegio='+ddlb_colegio.value+'&ai_nivel='+hf_nivel.value+'&ai_perfil='+hf_perfil.value);return document.MM_returnValue">

        <input type="hidden" name="hf_nivel" value="<?=($li_id_nivel)?>">

        <input type="hidden" name="hf_perfil" value="<?=($li_id_perfil)?>">

        </font></td>

    </tr>

  </table>

</form>

</body>

</html>

