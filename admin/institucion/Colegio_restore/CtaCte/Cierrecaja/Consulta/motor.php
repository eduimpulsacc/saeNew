<?
	$li_id_usuario = Trim($_GET["ai_usuario"]);
?>
<?
$li_agno_actual = date(Y);
$li_agno_actual = $li_agno_actual + 2;
$li_cant_agno   = $li_agno_actual - 2003;
?>
<html>
<head>
<title>Motor</title>
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
<form name="form1" action="">
  <table width="650" border="0" cellpadding="0" cellspacing="0">
    <tr> 
      <td width="28%"> <div align="right"><font size="1"> Desde : </font></div></td>
      <td   width="72%"><font size="1"> 
        <select name="tf_dia_ini" class="text_9_x_50" >
          <?

	For ($j=1; $j <= 31; $j++)

	{

		echo "<option value='$j'";

		if($j==date(j))

		{

			print "Selected";

		}

		echo ">".substr('00',1,2-strlen($j))."$j</option> ";

	}

	?>
        </select>
        <select name="tf_mes_ini" class="text_9_x_80" >
          <option value="01"

	  <? If(date(n)==1)

	  {echo "selected";}

	  ?>>Enero </option>
          <option value="02"

  	  <? If(date(n)==2)

	  {echo "selected";}

	  ?>>Febrero </option>
          <option value="03"

   	  <? If(date(n)==3)

	  {echo "selected";}

	  ?>>Marzo </option>
          <option value="04"

   	  <? If(date(n)==4)

	  {echo "selected";}

	  ?>>Abril </option>
          <option value="05"

   	  <? If(date(n)==5)

	  {echo "selected";}

	  ?>>Mayo </option>
          <option value="06"

   	  <? If(date(n)==6)

	  {echo "selected";}

	  ?>>Junio </option>
          <option value="07"

   	  <? If(date(n)==7)

	  {echo "selected";}

	  ?>>Julio </option>
          <option value="08"

  	  <? If(date(n)==8)

	  {echo "selected";}

	  ?>>Agosto </option>
          <option value="09"

      <? If(date(n)==9)

	  {echo "selected";}

	  ?>>Septiembre </option>
          <option value="10"

   	  <? If(date(n)==10)

	  {echo "selected";}

	  ?>>Octubre </option>
          <option value="11"

   	  <? If(date(n)==11)

	  {echo "selected";}

	  ?>>Noviembre </option>
          <option value="12"

   	  <? If(date(n)==12)

	  {echo "selected";}

	  ?>>Diciembre </option>
        </select>
        <select name="tf_year_ini" class="text_9_x_50" >
          <?

	$li_x = 2;

	For ($j=0; $j <= $li_cant_agno; $j++)

	{

		$li_x = $li_x + 1;

		echo "<option value='200$li_x'";

		$li_agno_paso = "200".$li_x;

		if($li_agno_paso == date(Y))

		{

			print "Selected";

		} 

		echo ">200$li_x</option> ";	

	}

	?>
        </select>
        </font></td>
    </tr>
    <tr>
      <td><div align="right"><font size="1">Hasta :</font></div></td>
      <td>
        <select name="tf_dia_fin" class="text_9_x_50" >
          <?

	For ($j=1; $j <= 31; $j++)

	{

		echo "<option value='$j'";

		if($j==date(j))

		{

			print "Selected";

		}

		echo ">".substr('00',1,2-strlen($j))."$j</option> ";

	}

	?>
        </select>
        <select name="tf_mes_fin" class="text_9_x_80" >
          <option value="01"

	  <? If(date(n)==1)

	  {echo "selected";}

	  ?>>Enero </option>
          <option value="02"

  	  <? If(date(n)==2)

	  {echo "selected";}

	  ?>>Febrero </option>
          <option value="03"

   	  <? If(date(n)==3)

	  {echo "selected";}

	  ?>>Marzo </option>
          <option value="04"

   	  <? If(date(n)==4)

	  {echo "selected";}

	  ?>>Abril </option>
          <option value="05"

   	  <? If(date(n)==5)

	  {echo "selected";}

	  ?>>Mayo </option>
          <option value="06"

   	  <? If(date(n)==6)

	  {echo "selected";}

	  ?>>Junio </option>
          <option value="07"

   	  <? If(date(n)==7)

	  {echo "selected";}

	  ?>>Julio </option>
          <option value="08"

  	  <? If(date(n)==8)

	  {echo "selected";}

	  ?>>Agosto </option>
          <option value="09"

      <? If(date(n)==9)

	  {echo "selected";}

	  ?>>Septiembre </option>
          <option value="10"

   	  <? If(date(n)==10)

	  {echo "selected";}

	  ?>>Octubre </option>
          <option value="11"

   	  <? If(date(n)==11)

	  {echo "selected";}

	  ?>>Noviembre </option>
          <option value="12"

   	  <? If(date(n)==12)

	  {echo "selected";}

	  ?>>Diciembre </option>
        </select>
        <select name="tf_year_fin" class="text_9_x_50" >
          <?

	$li_x = 2;

	For ($j=0; $j <= $li_cant_agno; $j++)

	{

		$li_x = $li_x + 1;

		echo "<option value='200$li_x'";

		$li_agno_paso = "200".$li_x;

		if($li_agno_paso == date(Y))

		{

			print "Selected";

		} 

		echo ">200$li_x</option> ";	

	}

	?>
        </select>
        <font size="1"> 
        <input name="hf_usuario" type="hidden" id="hf_usuario" value="<?=($li_id_usuario)?>">
        <input type="button" name="cb_buscar" value="Buscar &gt;&gt;" class="cb_none_9_x_70" onClick="MM_goToURL('parent.frames[\'main\']','resultado.php?ai_mostrar=1&ai_usuario='+hf_usuario.value+'&ai_dia_i='+tf_dia_ini.options[tf_dia_ini.selectedIndex].value+'&ai_mes_i='+tf_mes_ini.options[tf_mes_ini.selectedIndex].value+'&ai_year_i='+tf_year_ini.options[tf_year_ini.selectedIndex].value+'&ai_dia_f='+tf_dia_fin.options[tf_dia_fin.selectedIndex].value+'&ai_mes_f='+tf_mes_fin.options[tf_mes_fin.selectedIndex].value+'&ai_year_f='+tf_year_fin.options[tf_year_fin.selectedIndex].value);return document.MM_returnValue">
        </font> </td>
    </tr>
  </table>
</form>
</body>
</html>
