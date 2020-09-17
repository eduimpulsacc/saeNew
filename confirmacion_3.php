<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<?php
	$msg=" Nombre :".$nombre."\n";
	$msg.=" Dirección :".$direccion."\n";
	$msg.=" Comuna :".$comuna."\n";	
	$msg.=" Teléfono :".$telefono."\n";	
	$msg.=" Cargo u Ocupación :".$cargo."\n";
	$msg.=" Institución :".$institucion."\n";
?>
<?php
	$recipient	= "ccontreras@colegioelectronico.net";
	$subject	= "Confirmación Asistencia Seminario vía Sitio Web";
	//$de = "From: jramos@coelectronico.com\r\n";
//	mail($recipient,$subject,$msg,$de);
	mail($recipient,$subject,$msg);
?>
<title>Suscripciones</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #fffbef;
}
.style5 {font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #000066; }
.style8 {font-size: 9px; font-family: Verdana, Arial, Helvetica, sans-serif; color: #000066; font-weight: bold; }
-->
</style></head>

<body>
<table width="380" border="0" cellpadding="2" cellspacing="2" bgcolor="fffbef">
  <tr>
    <td align="center"><span class="style8">CONFIRMACI&Oacute;N ASISTENCIA SEMINARIO </span></td>
  </tr>
  <tr>
    <td><p align="justify" class="style5">&nbsp;</p>
    <p align="justify" class="style5">&nbsp;</p>
    <p align="center" class="style5">Hemos recibido sus datos satisfactoriamente. </p></td>
  </tr>
  <tr>
    <td>

  </tr>
</table>
</body>
</html>
