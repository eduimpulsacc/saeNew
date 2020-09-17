<?
	$hoy		 = getdate();
	$dia_actual  = $hoy["mday"];
	$mes_actual  = date(m);	
	$year_actual = $hoy["year"];
	$ldt_fecha   = $dia_actual." - ".$mes_actual." - ".$year_actual;
	
	$li_id_usuario	  = Trim($_GET["ai_usuario"]);
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../../css/objeto.css" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body bgcolor="#FFFFFF" text="#000000">
<form name="form1" action="">
  <br>
  <br>
  <br>
  <table width="50%" border="1" align="center" cellspacing="0" cellpadding="0">
    <tr> 
      <td colspan="2" class="linea_datos_02"> 
        <div align="center">CIERRE DE CAJA.</div>
      </td>
    </tr>
    <tr> 
      <td class="membrete_datos"> 
        <div align="center">USUARIO ENCARGADO:</div>
      </td>
      <td class="membrete_datos">&nbsp;<?=($li_id_usuario)?>
        <input type="hidden" name="hf_usuario" value="<?=($li_id_usuario)?>">
      </td>
    </tr>
    <tr> 
      <td class="membrete_datos"> 
        <div align="center">FECHA ACTUAL:</div>
      </td>
      <td class="membrete_datos">&nbsp; 
        <?=($ldt_fecha)?>
      </td>
    </tr>
  </table>
  <div align="center"><br>
    <input type="button" name="cb_cerrar" value="Cerrar CAJA" class="cb_none_9_x_200" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick="MM_goToURL('parent.frames[\'Cuerpo\']','procesar.php?ai_usuario='+hf_usuario.value);return document.MM_returnValue">

    <input name="cb_consultas" type="button" class="cb_none_9_x_200" onClick="MM_goToURL('parent.frames[\'Cuerpo\']','Consulta/main.php?ai_usuario='+hf_usuario.value);return document.MM_returnValue" value="Consultas &gt;&gt;">
	
  </div>
</form>
</body>
</html>
