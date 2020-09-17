<? 
require("../../../util/header.php");
require("../clases.php");

$ano		 =	$cmbANO;
$institucion = $_INSTIT;
$periodo	 = $cmbPERIODO;
$curso		 = $cmbCURSO;

$ob_reporte = new Reporte();

$fila_membrete = $ob_reporte->Membrete($conn,$institucion);
$rs_periodo = $ob_reporte->Periodo($conn,$ano,$periodo);
$fila_ano = $ob_reporte->Ano($conn,$ano);
$nro_ano = $fila_ano['nro_ano'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=LATIN1" />
<link href="../../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<title>Documento sin t&iacute;tulo</title>
</head>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

function cerrar(){ 
window.close() 
} 
</script>
<body>

<div id="capa0">
<table width="650" align="center">
  <tr><td>
   <input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
        <font size="1" face="Arial, Helvetica, sans-serif"></font>
   <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td></tr>
</table>
</div>
<table width="690" border="0" align="center">
  <tr>
    <td><?php include("../cabecera/cabecera.php"); ?><br><br>
    
    <table width="100%" border="0">
  <tr>
    <td colspan="2" class="tableindex">REPORTE NOTAS POR CURSO</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td width="19%" class="textonegrita">CURSO</td>
    <td width="81%" class="textosimple">:&nbsp;<?=CursoPalabra($curso,1,$conn);?></td>
  </tr>
  <tr>
    <td class="textonegrita">PROFESOR JEFE</td>
    <td class="textosimple">:&nbsp;<?=$ob_reporte->Supervisa($conn,$curso);?></td>
  </tr>
  <tr>
    <td class="textonegrita">PERIODO</td>
    <td class="textosimple">:&nbsp;<?=pg_result($rs_periodo,1);?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;<table width="100%" border="0" class="cajaborde">
  <tr class="tableindexredondo">
    <td>&nbsp;ASIGNATURA</td>
    <td>&nbsp;DOCENTE</td>
    <td>&nbsp;PROMEDIO</td>
    <td>&nbsp;ESCALA</td>
  <!--  <td>&nbsp;MODA</td>
    <td>&nbsp;MEDIA</td>-->
  </tr>
  <? $rs_ramo = $ob_reporte->traeRamo($conn,$curso,0);
  		for($i=0;$i<pg_numrows($rs_ramo);$i++){
			
			$fila = pg_fetch_array($rs_ramo,$i);
			$fila_emp = pg_fetch_array($ob_reporte->DictaRamo($conn,$fila['id_ramo']),0);
			$promedio = $ob_reporte->PromedioRamo($conn,$periodo,$fila['id_ramo'],$nro_ano);
			$fila_escala = pg_fetch_array($ob_reporte->rangoEscala($conn,$ano,$promedio),0); 
			
			
			if(($i % 2)==0){
				$clase="detalleoff";
			}else{
				$clase="detalleon";
			}
	?>
  <tr class="<?=$clase;?>">
    <td>&nbsp;<?=$fila['nombre'];?></td>
    <td>&nbsp;<?=$fila_emp['nombre_emp']." ".$fila_emp['ape_pat'];?></td>
    <td align="center">&nbsp;<?=$promedio;?></td>
    <td>&nbsp;<?=$fila_escala['nombre'];?></td>
   <!-- <td>&nbsp;</td>
    <td>&nbsp;</td>-->
  </tr>
  <? } ?>
</table>
</td>
  </tr>
</table>

    
</td>
</tr>
</table>

</body>
</html>
