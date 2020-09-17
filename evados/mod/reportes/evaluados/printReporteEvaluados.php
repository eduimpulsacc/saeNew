<? 
header( 'Content-type: text/html; charset=iso-8859-1' );


session_start();

require "../class_reporte/class_reporte.php";

$periodo 	= $_POST['cmbPERIODO'];
$ano		= $_POST['cmbANO'];

$ob_reporte = new Reporte($_IPDB,$_ID_BASE);
$fila_instit= $ob_reporte->Membrete($_INSTIT);
$fila_direc	= $ob_reporte->Director($_INSTIT);

$rs_evaluadores = $ob_reporte->Evaluados($ano,$periodo);


?>
<script> 
function cerrar(){ 
window.close() 
} 

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<link href="../../../css/estilos.css" rel="stylesheet" type="text/css">
<title>SISTEMA EVALUACI&Oacute;N DOCENTE</title>
</head>

<body>
<div id="capa0">
<table width="650" border="0" align="center">
  <tr>
    <td><input name="button" type="submit" class="report" id="button" value="CERRAR" onClick="cerrar()" /></td>
    <td align="right"><input name="button2" type="submit" class="report" id="button2" value="IMPRIMIR"  onClick="imprimir();"/></td>
  </tr>
</table>
</div>
<table width="650" border="0" align="center">
  <tr>
    <td  align="center" valign="middle">
    <?php include('../cabecera/cabecera.php');?>
    </td>
  </tr>
  <tr>
    <td colspan="3"><table width="95%" border="0" align="center" cellpadding="0">
      <tr>
        <td align="center" class="textonegrita"><u>LISTADO DE EVALUADOS</u></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="1" style="border-collapse:collapse">
          <tr class="tabla01">
            <td>RUT</td>
            <td>CARGO</td>
            <td>NOMBRE</td>
          </tr>
          <? for($i=0;$i<pg_numrows($rs_evaluadores);$i++){
			  	$fila = pg_fetch_array($rs_evaluadores,$i);
			?>
          <tr>
            <td class="textosesion" align="right"><?=$fila['rut_evaluado']."-".$fila['dig_rut'];?>&nbsp;</td>
            <td class="textosesion">&nbsp;<?=$fila['nombre_cargo'];?></td>
            <td class="textosesion">&nbsp;<?=$fila['nombres'];?></td>
          </tr>
          <? } ?>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
  </table></td>
  </tr>
 
</table>
</body>
</html>