<?php require('../../../../util/header.inc');
$Modo = $_FRMMODO;
echo "_PLANTILLA= ", $_PLANTILLA;
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="creaArea.php" method="post">
  <font size="2" face="Arial, Helvetica, sans-serif">Cantidad de Areas a crear:</font> 
  <input name="txtCant" type="text" size="2" maxlength="2"><td></td>
  <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="submit" name="enviar" value="OK">
  <? if($Modo=="modificar"){?>  
  <TABLE>
  <TR>
  	<TD><font size="2" face="Arial, Helvetica, sans-serif">Agregar</font></TD>
  	<TD><font size="2" face="Arial, Helvetica, sans-serif">Si <INPUT TYPE="radio" NAME="option" value="1"></font></TD>
  	<TD><font size="2" face="Arial, Helvetica, sans-serif">No <INPUT TYPE="radio" NAME="option" value="2"></font></TD>
  </TR>
  </TABLE>
  <? } ?>
</form>
</body>
</html>
