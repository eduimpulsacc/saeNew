<?	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$curso			=$c_curso	;
	$alumno			=$c_alumno	;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<style type="text/css">
<!--
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo5 {font-size: 14px}
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; }
.Estilo8 {font-size: 10px}
-->
</style>
</head>

<body>
<table width="650" border="0" align="center">
  <tr>
    <td><input type="button" name="Submit" value="CERRAR" onclick="window.close()" class="botonXX"/></td>
    <td><div align="right">
      <input name="button3" type="button" class="botonXX" onclick="imprimir();"  value="IMPRIMIR" />
    </div></td>
    <? if($_PERFIL == 0){?>
    <td align="right"><input name="button32" type="button" class="botonXX" onclick="javascript:exportar();"  value="EXPORTAR" /></td>
    <? }?>
  </tr>
</table>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="tableindex Estilo4 Estilo5"><div align="center">CORPORACI&Oacute;N DE XXXX </div></td>
  </tr>
  <tr>
    <td align="center" class="tableindex"><div align="center" class="Estilo7">DOTACI&Oacute;N DOCENTE </div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo7"><strong><? echo trim(strtoupper("AÑO ".$ob_membrete->nro_ano)) ;?></strong></span></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><span class="Estilo3">INSTITUCION</span></td>
    <td><span class="Estilo3">HORAS<br />
    CONTRATO</span></td>
    <td><span class="Estilo3">ART.69</span></td>
    <td><span class="Estilo3">HORAS<br />
      AMPLIACI&Oacute;N<br />
      SIMPLES</span></td>
    <td><span class="Estilo3">HORAS<br />
      AMPLIACI&Oacute;N <br />
      JEC </span></td>
    <td><span class="Estilo3">TOTAL<br />
      HORAS<br />
      AULA</span></td>
  </tr>
  <tr>
    <td><span class="Estilo8"></span></td>
    <td><span class="Estilo8"></span></td>
    <td><span class="Estilo8"></span></td>
    <td><span class="Estilo8"></span></td>
    <td><span class="Estilo8"></span></td>
    <td><span class="Estilo8"></span></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>
