<?php require('../../../../../../../util/header.inc');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="../../../../../../../util/chkform.js"></SCRIPT>
<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
   alert ("No Autorizado");
   window.location="../../../../../../index.php";
</script>
<? } ?>
</head>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style>
.tachado {
    text-decoration: line-through;
}
</style>
<body leftmargin="0"  >
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#006699" align="center">
  <tr>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td width="20%">INSTITUCI&Oacute;N</td>
        <td width="30%">: Instituci&oacute;n de Prueba </td>
        <td width="20%">A&Ntilde;O ESCOLAR </td>
        <td width="30%">: 2010 </td>
      </tr>
      <tr>
        <td>PER&Iacute;ODO</td>
        <td>: Primer Semestre </td>
        <td>CURSO</td>
        <td>: 1 - A Ense&ntilde;anza  B&aacute;sica </td>
      </tr>
      <tr>
        <td>SUBSECTOR</td>
        <td>: Matem&aacute;ticas </td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
  <tr>
    <td align="center">PLANILLA DE NOTAS PARCIALES </td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3">
  <tr>
    <td align="right"><label>
      <input type="submit" name="Submit" value="Enviar">
    </label>
      <label>
      <input type="submit" name="Submit2" value="Enviar">
    </label>
      <label>
      <input type="submit" name="Submit3" value="Enviar">
    </label>
      <label>
      <input type="submit" name="Submit4" value="Enviar">
    </label></td>
  </tr>
</table>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#0033CC">
  <tr>
    <td>
	<table width="100%" border="1"  cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" bgcolor="#FFFFFF" style="border:solid; size:1">
      <tr>
        <td width="1%">Nro.</td>
        <td bgcolor="f5f5f5">Alumnos</td>
        <td width="3%">1&ordm;</td>
        <td width="3%">2&ordm;</td>
        <td width="3%">3&ordm;</td>
        <td width="3%">4&ordm;</td>
        <td width="3%">5&ordm;</td>
        <td width="3%">6&ordm;</td>
        <td width="3%">7&ordm;</td>
        <td width="3%">8&ordm;</td>
        <td width="3%">9&ordm;</td>
        <td width="3%">10&ordm;</td>
        <td width="3%">11&ordm;</td>
        <td width="3%">12&ordm;</td>
        <td width="3%">13&ordm;</td>
        <td width="3%">14&ordm;</td>
        <td width="3%">15&ordm;</td>
        <td width="3%">16&ordm;</td>
        <td width="3%">17&ordm;</td>
        <td width="3%">18&ordm;</td>
        <td width="3%">19&ordm;</td>
        <td width="3%">20&ordm;</td>
        <td width="3%" bgcolor="#FFFF00">PROM.</td>
        <td width="1%">Est.</td>
      </tr>
      <tr>
        <td>1</td>
        <td bgcolor="f5f5f5">aaaaaa</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td>20</td>
        <td bgcolor="#FFFF00">20</td>
        <td align="center"><img src="images/cargando.gif" width="22" height="22"></td>
      </tr>
      <tr>
        <td>2</td>
        <td bgcolor="f5f5f5">bbbbb</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td>30</td>
        <td bgcolor="#FFFF00">&nbsp;</td>
        <td align="center"><img src="images/bueno.gif" width="18" height="22"></td>
      </tr>
      <tr>
        <td>3</td>
        <td bgcolor="f5f5f5">ccccc</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td>40</td>
        <td bgcolor="#FFFF00">&nbsp;</td>
        <td align="center"><img src="images/malo.gif" width="28" height="22"></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
