<?
require('../../../../util/header.inc');

$institucion= $_INSTIT;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</head>
<script language="javascript1.1" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
</STYLE>

<body>
<div id="capa0">
<table width="650" align="center">
  <tr>
    <td><input name="button4" type="button" class="botonXX" onclick="window.close()"   value="CERRAR" /></td>
    <td align="right"><input name="button3" type="button" class="botonXX"  value="IMPRIMIR" onclick="javascript:imprimir()" />
        <? if($_PERFIL==0){?>
        <input name="cb_exp" type="button" onclick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR" />
        <? }?>
    </td>
  </tr>
</table>
</div>
<? for($i=1;$i<3;$i++){?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%" rowspan="4"><?
						if($institucion!=""){
							echo "<img src='../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?></td>
    <td width="67%" class="textosimple">&nbsp;</td>
    <td width="13%" class="textosimple">A&ntilde;o Escolar </td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="textosimple">N&ordm; Matricula </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><div align="center">FICHA DE MATRICULA </div></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0" class="tabla04">
  <tr>
    <td colspan="4" class="tabla03"><div align="center">DATOS DEL ALUMNO  </div></td>
  </tr>
  <tr>
    <td width="8%" class="textosimple">RUT</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">NOMBRE</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">SEXO</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">DOMICILIO</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">COMUNA</td>
    <td width="40%">&nbsp;</td>
    <td width="9%" class="textosimple">TELEFONO</td>
    <td width="43%">&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0" class="tabla04">
  <tr>
    <td colspan="4" class="tabla03"><div align="center">DATOS DEL APODERADO </div></td>
  </tr>
  <tr>
    <td width="162" class="textosimple">RUT</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">NOMBRE</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">PROFESION U OFICIO </td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">DOMICILIO</td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">COMUNA</td>
    <td width="149">&nbsp;</td>
    <td width="81" class="textosimple">TELEFONO</td>
    <td width="218">&nbsp;</td>
  </tr>
</table>

<br />
<table width="650" border="1" align="center" cellpadding="1" cellspacing="0" class="tabla04">
  <tr>
    <td colspan="2" class="tabla03"><div align="center">DATOS MADRE </div></td>
  </tr>
  <tr>
    <td width="160" class="textosimple">RUT MADRE </td>
    <td width="464">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">NOMBRE MADRE </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">TELEFONO MADRE </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">ESTUDIOS </td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla04">
  <tr>
    <td><div align="right">______________________________</div></td>
  </tr>
  <tr>
    <td><div align="right">FIRMA APODERADO </div></td>
  </tr>
</table>
<br />

<table width="650" border="0" align="center" cellpadding="2" cellspacing="0" class="tabla04">
  <tr>
    <td width="154">FECHA MATRICULA </td>
    <td width="496">_______________________________</td>
  </tr>
  <tr>
    <td>FECHA RETIRO </td>
    <td>_______________________________</td>
  </tr>
  <tr>
    <td>MOTIVO RETIRO </td>
    <td>_____________________________________________________________</td>
  </tr>
  <tr>
    <td colspan="2">___________________________________________________________________________________</td>
  </tr>
</table>
<br />

<? } ?>
</body>
</html>
