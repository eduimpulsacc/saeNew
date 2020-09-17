<? 
session_start();
require "../../../class/Membrete.class.php";
require "../class_reporte/class_sql.php";

$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
$ob_membrete->estilosae($_INSTIT);
$fila_inst=$ob_membrete->institucion($_INSTIT);
$fila_ano = $ob_membrete->anoescolar($_INSTIT);


$bloque		= $_POST['cmbGRUPO'];
$dimension	= $_POST['cmbDIMENSION'];
$funcion	= $_POST['cmbFUNCION'];
$pauta		= $_POST['cmbPAUTA'];
$tipo		= $_POST['tipo_dato'];
$nacional	= $_NACIONAL;

$ob_reporte = new SQL($_IPDB,$_ID_BASE);

$rs_bloque = $ob_reporte->GrupoHomogenio($bloque);
$nombre_bloque = pg_result($rs_bloque,0);
$porcentaje_bloque = pg_result($rs_bloque,1);

$rs_pauta = $ob_reporte->PautaEvaluacion($pauta);
$nombre_pauta = pg_result($rs_pauta,3);

$rs_dimension = $ob_reporte->Dimension($dimension);
$nombre_dimension = pg_result($rs_dimension,2);

$rs_funcion = $ob_reporte->Funcion($funcion);
$nombre_funcion = pg_result($rs_funcion,1);

$rs_concepto = $ob_reporte->Conceptos($nacional);

$rs_personal = $ob_reporte->PersonalBloque($bloque);
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
      <input type="submit" name="Submit2" value="CERRAR" class="botonXX" onclick="window.close()"/>
    </div></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>

    <td width="114" class="textonegrita"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
    <td width="9" class="textonegrita"><strong>:</strong></td>
    <td width="361" class="textonegrita"><div align="left"><? echo strtoupper(trim($fila_inst['nombre_instit'])) ?></div></td>
    <td width="161" rowspan="9" align="center" valign="top" ><img src="../../../../cortes/<?=$_INSTIT?>/insignia.jpg" width="100" height="100" /></td>
  </tr>
  <tr>
    <td class="textonegrita"><div align="left"><strong>A&Ntilde;O ESCOLAR</strong></div></td>
    <td class="textonegrita"><strong>:</strong></td>
    <td class="textonegrita"><div align="left"><? echo trim($fila_ano['nro_ano']) ?></div></td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;</td>
    <td class="textonegrita">&nbsp;</td>
    <td class="textonegrita">&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;</td>
    <td class="textonegrita">&nbsp;</td>
    <td class="textonegrita">&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="cuadro02"><div align="center">REPORTE POR GRUPO HOMOGENIO </div></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td width="149" class="textonegrita">Grupo Homogenio </td>
    <td width="24" class="textonegrita"><div align="center">:</div></td>
    <td width="463" class="textosimple">&nbsp;<?=$nombre_bloque;?></td>
  </tr>
  <tr>
    <td class="textonegrita">Pauta de Evaluaci&oacute;n </td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<?=$nombre_pauta;?></td>
  </tr>
  <tr>
    <td class="textonegrita">Dimension</td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<?=$nombre_dimension;?></td>
  </tr>
  <tr>
    <td class="textonegrita">Funci&oacute;n</td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<?=$nombre_funcion;?></td>
  </tr>
  <tr>
    <td class="textonegrita">Cantidad de Indicadores </td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita">Datos</td>
    <td class="textonegrita"><div align="center">:</div></td>
    <td class="textosimple">&nbsp;<? echo ($tipo==1)?"Ponderados":"Sin Ponderar";?></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="3" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td width="164" class="tablatit3">&nbsp;</td>
   	<? for($i=0;$i<pg_numrows($rs_concepto);$i++){
			$fila_con = pg_fetch_array($rs_concepto,$i);
	?>
    <td width="36" class="tablatit3"><div align="center"><?=$fila_con['sigla'];?></div></td>
<? } // for conceptos ?>
  </tr>
<? for($x=0;$x<pg_numrows($rs_personal);$x++){
 		$fila_per = pg_fetch_array($rs_personal,$x);
?>
  <tr>
    <td class="textosimple"><? echo $fila_per['rut']."&nbsp;".$fila_pers['nombre'];?></td>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
<? } ?>

  <tr>
    <td class="tablatit3">Total</td>
    <td class="tablatit3">&nbsp;</td>
    <td class="tablatit3">&nbsp;</td>
    <td class="tablatit3">&nbsp;</td>
    <td class="tablatit3">&nbsp;</td>
    <td class="tablatit3">&nbsp;</td>
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
