<? 
session_start();
require "../../../class/Membrete.class.php";
require "../class_reporte/class_sql.php";

$ob_membrete = new Membrete($_IPDB,$_DBNAME);
$ob_membrete->estilosae($_INSTIT);
$fila_inst=$ob_membrete->institucion($_INSTIT);
$fila_ano = $ob_membrete->anoescolar($_INSTIT);




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SISTEMA EVALUACI&Oacute;N DOCENTES</title>
</head>

<body>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="right">
      <input type="submit" name="Submit" value="IMPRIMIR"  class="botonXX"/>
      <input type="button" name="close" value="CERRAR" class="botonXX" onclick="window.close()"/>
    </div></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>

    <td width="114" class="textonegrita"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
    <td width="9" class="textonegrita"><strong>:</strong></td>
    <td width="361" class="textonegrita"><div align="left"><? echo strtoupper(trim($fila_inst['nombre_instit'])) ?></div></td>
    <td width="161" rowspan="7" align="center" valign="top" ><img src="../../../../cortes/<?=$_INSTIT?>/insignia.jpg" width="100" height="100" /></td>
  
  </tr>
  <tr>
    <td class="textonegrita"><div align="left"><strong>A&Ntilde;O ESCOLAR</strong></div></td>
    <td class="textonegrita"><strong>:</strong></td>
    <td class="textonegrita"><div align="left"><? echo trim($fila_ano['nro_ano']) ?>-</div></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="cuadro02"><div align="center">PAUTA DE EVALUACI&Oacute;N </div></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td width="149" class="textonegrita">Grupo Homogenio </td>
    <td width="24" class="textonegrita"><div align="center">:</div></td>
    <td width="463" class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita">Pauta de Evaluaci&oacute;n </td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita">Nombre Evaluado</td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td colspan="3">&nbsp;</td>
    <td width="35" class="textosimple"><div align="center">D</div></td>
    <td width="39" class="textosimple"><div align="center">C</div></td>
    <td width="32" class="textosimple"><div align="center">B</div></td>
    <td width="36" class="textosimple"><div align="center">I</div></td>
    <td width="40" class="textosimple"><div align="center">NO</div></td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple">DIMENSION</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="20">&nbsp;</td>
    <td colspan="2" class="textosimple">FUNCION</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="10">&nbsp;</td>
    <td width="372" class="detalle">INDICADOR</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="detalle">INDICADOR</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="detalle">INDICADOR</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="detalle">INDICADOR</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="detalle">INDICADOR</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="detalle">INDICADOR</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple">DIMENSION</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="textosimple">FUNCION</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="detalle">INDICADOR</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="detalle">INDICADOR</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="detalle">INDICADOR</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="detalle">INDICADOR</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="detalle">INDICADOR</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="detalle">INDICADOR</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Total</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="textosimple">Observaciones:________________________________________________________________________________</td>
  </tr>
  <tr>
    <td>_________________________________________________________________________________</td>
  </tr>
  <tr>
    <td>_________________________________________________________________________________</td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="textosimple"><div align="right"><? echo $fecha=date("d-m-Y");?></div></td>
  </tr>
</table>
</body>
</html>
