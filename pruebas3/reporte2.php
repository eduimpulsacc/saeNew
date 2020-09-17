<? require('../util/header.inc');

$corporacion	=$_CORPORACION;

$sql ="SELECT * FROM corporacion WHERE num_corp=".$corporacion;
$rs_corp = @pg_exec($conn,$sql);
$nombre = @pg_result($rs_corp,1);
$direc	= @pg_result($rs_corp,2);
$fono	= @pg_result($rs_corp,3);
$logo	= @pg_result($rs_corp,4);


$qry = "select matricula_corp()";
$rs = @pg_exec($conn,$qry);
echo @pg_result($rs,0);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="estilo1.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="750" height="750" border="1" align="center" cellpadding="0" cellspacing="0" class="tabla1">
  <tr>
    <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="10" rowspan="7" valign="top">&nbsp;</td>
        <td valign="top" height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td  class="membrete">&nbsp;</td>
                  <td>&nbsp;</td>
                  <td>
                    <div align="right"></div></td>
                </tr>
              <tr>
            <td  class="membrete"><?=$nombre;?>&nbsp;</td>
            <td>&nbsp;</td>
            <td rowspan="4"><div align="right">
              <?  echo "<img src='../tmp/".$logo. "' >"; ?>
            </div></td>
              </tr>
          <tr>
            <td  class="membrete"><?=$direc;?>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td  class="membrete"><?=$fono;?>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td  class="membrete">&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
          <tr>
            <td  class="membrete">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td width="10" rowspan="7" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="5" valign="middle" class="titulo1" width="600">TOTAL DE MATRICULAS TODOS LOS ESTABLECIMIENTOS </td>
        </tr>
      <tr>
        <td height="10" valign="baseline" class="text3">&nbsp;</td>
        </tr>
      <tr>
        <td height="350" valign="top"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" class="tabla2">
          <tr>
            <td rowspan="2" class="celdas1">ESTABLECIMIENTO</td>
            <td colspan="11" class="celdas1">2010</td>
            <td rowspan="2" class="celdas1">TOTAL</td>
          </tr>
          <tr>
            <td class="celdas1">FEB.</td>
            <td class="celdas1">MAR.</td>
            <td class="celdas1">ABR.</td>
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
            <td class="text">colegio 1 </td>
            <td class="text2">500</td>
            <td class="text2">501</td>
            <td class="text2">502</td>
            <td class="text2">503</td>
            <td class="text2">504</td>
            <td class="text2">505</td>
            <td class="text2">506</td>
            <td class="text2">507</td>
            <td class="text2">508</td>
            <td class="text2">509</td>
            <td class="text2">510</td>
            <td class="text2">5590</td>
          </tr>
          <tr>
            <td class="text">colegio 2 </td>
            <td class="text2">600</td>
            <td class="text2">601</td>
            <td class="text2">602</td>
            <td class="text2">603</td>
            <td class="text2">604</td>
            <td class="text2">605</td>
            <td class="text2">606</td>
            <td class="text2">607</td>
            <td class="text2">608</td>
            <td class="text2">609</td>
            <td class="text2">610</td>
            <td class="text2">6690</td>
          </tr>
          <tr>
            <td class="text">colegio 3 </td>
            <td class="text2">1500</td>
            <td class="text2">1520</td>
            <td class="text2">1520</td>
            <td class="text2">1520</td>
            <td class="text2">1520</td>
            <td class="text2">1520</td>
            <td class="text2">1520</td>
            <td class="text2">1520</td>
            <td class="text2">1520</td>
            <td class="text2">1520</td>
            <td class="text2">1520</td>
            <td class="text2">1520</td>
          </tr>
          <tr>
            <td class="text">colegio 4 </td>
            <td class="text2">8600</td>
            <td class="text2">8600</td>
            <td class="text2">8600</td>
            <td class="text2">8600</td>
            <td class="text2">8600</td>
            <td class="text2">8600</td>
            <td class="text2">8600</td>
            <td class="text2">8600</td>
            <td class="text2">8600</td>
            <td class="text2">8600</td>
            <td class="text2">8600</td>
            <td class="text2">26000</td>
          </tr>
          <tr>
            <td class="text">colegio 5 </td>
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
            <td class="text">colegio 6 </td>
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
            <td class="celdas1">TOTALES</td>
            <td class="celdas1">25000</td>
            <td class="celdas1">50000</td>
            <td class="celdas1">25000</td>
            <td class="celdas1">25000</td>
            <td class="celdas1">25000</td>
            <td class="celdas1">25000</td>
            <td class="celdas1">25000</td>
            <td class="celdas1">25000</td>
            <td class="celdas1">25000</td>
            <td class="celdas1">25000</td>
            <td class="celdas1">25000</td>
            <td class="celdas1">1500000</td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td height="10" valign="bottom"><hr  align="center"  width="250"/></td>
      </tr>
      <tr>
        <td height="10" valign="top" class="text3">Nombre y Firma </td>
      </tr>
      <tr>
        <td height="10" class="fecha">Valparaiso,30 de Abril 2010 </td>
        </tr>
    </table>
     
    <br /></td>
  </tr>
</table>
</body>
</html>
