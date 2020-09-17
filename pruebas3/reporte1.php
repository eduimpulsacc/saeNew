<? require('../util/header.inc');

$corporacion	=$_CORPORACION;

$sql ="SELECT * FROM corporacion WHERE num_corp=".$corporacion;
$rs_corp = @pg_exec($conn,$sql);
$nombre = @pg_result($rs_corp,1);
$direc	= @pg_result($rs_corp,2);
$fono	= @pg_result($rs_corp,3);
$logo	= @pg_result($rs_corp,4);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style></head>

<body>
<table width="750" height="843" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="113" valign="top">
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="../linea2.jpg" width="730" height="4" /></td>
        </tr>
        <tr>
          <td rowspan="5"> <?  echo "<img src='../tmp/".$logo. "' >"; ?></td>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?="Corporación ".$nombre;?></div></td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$direc;?></div></td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$fono;?></div></td>
        </tr>
        <tr>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><img src="../linea.jpg" width="730" height="4" /></td>
        </tr>
      </table>
      <br />
      <br />
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td class="titulo1">TOTAL DE MATRICULA TODOS LOS ESTABLECIMIENTOS </td>
        </tr>
      </table>
    <br />
    <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" class="tabla2">
      <tr>
        <td rowspan="2" class="celdas1">ESTABLECIMIENTO</td>
        <td colspan="11" class="celdas1">2010</td>
        <td rowspan="2" class="celdas1">TOTAL</td>
      </tr>
      <tr>
        <td class="celdas1">FEB</td>
        <td class="celdas1">MAR</td>
        <td class="celdas1">ABR</td>
        <td class="celdas1">MAY</td>
        <td class="celdas1">JUN</td>
        <td class="celdas1">JUL</td>
        <td class="celdas1">AGO</td>
        <td class="celdas1">SEP</td>
        <td class="celdas1">OCT</td>
        <td class="celdas1">NOV</td>
        <td class="celdas1">DIC</td>
      </tr>
      <tr>
        <td class="text">&nbsp;colegio 1 </td>
        <td class="text2">500&nbsp;</td>
        <td class="text2">501&nbsp;</td>
        <td class="text2">502&nbsp;</td>
        <td class="text2">503&nbsp;</td>
        <td class="text2">504&nbsp;</td>
        <td class="text2">505&nbsp;</td>
        <td class="text2">506&nbsp;</td>
        <td class="text2">507&nbsp;</td>
        <td class="text2">508&nbsp;</td>
        <td class="text2">509&nbsp;</td>
        <td class="text2">510&nbsp;</td>
        <td class="text2">5590&nbsp;</td>
      </tr>
      <tr>
        <td class="text">&nbsp;colegio 2 </td>
        <td class="text2">600&nbsp;</td>
        <td class="text2">601&nbsp;</td>
        <td class="text2">602&nbsp;</td>
        <td class="text2">603&nbsp;</td>
        <td class="text2">604&nbsp;</td>
        <td class="text2">605&nbsp;</td>
        <td class="text2">606&nbsp;</td>
        <td class="text2">607&nbsp;</td>
        <td class="text2">608&nbsp;</td>
        <td class="text2">609&nbsp;</td>
        <td class="text2">610&nbsp;</td>
        <td class="text2">6690&nbsp;</td>
      </tr>
      <tr>
        <td class="text">&nbsp;colegio 3 </td>
        <td class="text2">1500&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
        <td class="text2">1520&nbsp;</td>
      </tr>
      <tr>
        <td class="text">&nbsp;colegio 4 </td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">8600&nbsp;</td>
        <td class="text2">26000&nbsp;</td>
      </tr>
      <tr>
        <td class="text">&nbsp;colegio 5 </td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
      </tr>
      <tr>
        <td class="text">&nbsp;colegio 6 </td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
        <td class="text2">&nbsp;</td>
      </tr>
      <tr>
        <td class="celdas2">TOTALES</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">50000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">25000&nbsp;</td>
        <td class="celdas2">1500000&nbsp;</td>
      </tr>
    </table>
    <br />
    <br />
    <br /></td>
  </tr>
  
  <tr>
    <td valign="baseline"><HR />
<div align="right" class="fecha">Valparaiso,30 de Abril 2010 </div></td>
  </tr>
</table>
</body>
</html>
