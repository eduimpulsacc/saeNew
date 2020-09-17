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

<body text="#000000" class="pagina">
<form name="form1" method="post" action="">
  <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td   width="28%"> 
        <div align="center"><font size="1">Nombre Moneda:</font></div>
      </td>
      <td   width="40%"> <font size="1"> 
        <select name="dblb_criterio" class="ddlb_9_x_100">
          <option value="1">Empieze con</option>
          <option value="2">Contenga</option>
        </select>
        <input type="text" name="tf_input" class="input_150">
        </font></td>
      <td   width="32%"> <font size="1"> 
        <input type="button" name="cb_buscar" value="Buscar &gt;&gt;" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'main\']','resultado.php?ai_criterio='+dblb_criterio.options[dblb_criterio.selectedIndex].value+'&as_input='+tf_input.value);return document.MM_returnValue">
        <input type="button" name="cb_new" value="Nuevo" class="cb_none_9_x_70" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'main\']','nuevo.php');return document.MM_returnValue">
        </font></td>
    </tr>
  </table>
</form>
</body>
</html>
