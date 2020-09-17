<? 
header( 'Content-type: text/html; charset=iso-8859-1' );


session_start();

require "../class_reporte/class_reporte.php";

$ano = explode("-",$cmbANO);

//$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

//$fila_instit = $ob_reporte->Membrete($_INSTIT);

//$fila_direc= $ob_reporte->Director($_INSTIT);

//$fila_empleado = $ob_reporte->Empleado($cmbEMPLEADO,$ano[0]);

//$result_dimension = $ob_reporte->Dimension($cmbPAUTA,$fila_empleado['docente']);

//$resultados = $ob_reporte->resultados_dimension($cmbPAUTA);

$periodo 	= explode("-", $cmbPERIODO);
$cargo		= explode(",", $cmbCARGO);

//$rs_valida = $ob_reporte->valida_reporte_evaluacion($ano[0],$cmbEMPLEADO,$periodo[0]);
//$realizadas = pg_fetch_array($rs_valida,0);
//$pendientes = pg_fetch_array($rs_valida,1);




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
</div><br />
<table width="790" border="0" align="center">
  <tr>
    <td width="172" align="center" valign="middle"><img src="../../../insignia.jpg" width="97" height="117" /></td>
    <td width="25" align="center" valign="middle"><hr align="center" width="1" size="100" /></td>
    <td width="439"><table width="100%" border="0">
      <tr>
        <td align="center" class="textonegrita"><? echo strtoupper($fila_instit['nombre_instit']);?></td>
      </tr>
      <tr>
        <td align="center" class="textosimple"><? echo $fila_instit['direc']." / ".$fila_instit['nom_reg'];?></td>
      </tr>
      <tr>
        <td align="center" class="textosimple"> <? echo "Telefóno ".$fila_instit['telefono'];?></td>
      </tr>
      <tr>
        <td align="center" class="textosesion">www.educacionadventista.cl</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3" align="center" valign="middle"><table width="100%" border="0">
      <tr>
        <td colspan="2" align="center" class="textonegrita"><u>EVALUACION DOCENTE - <?=$periodo[1]."&nbsp;".$ano[1];?> </u> </td>
        </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td width="34%" class="listadetalleoff">NOMBRE:</td>
        <td width="66%" class="textosimple">&nbsp;<?=$fila_empleado['empleado'];?></td>
      </tr>
      <tr>
        <td class="listadetalleoff">EVALUACIONES PROYECTADAS:</td>
        <td class="textosimple">&nbsp;<?=$pendientes['primera'];?></td>
      </tr>
      <tr>
        <td class="listadetalleoff">EVALUACIONES REALIZADAS:</td>
        <td class="textosimple">&nbsp;<?=$realizadas['primera'];?></td>
      </tr>
      <tr>
        <td class="listadetalleoff">&nbsp;</td>
        <td class="textosimple">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">
       
        <table width="100%" border="1" style="border-collapse:collapse">
          <tr class="tabla01">
            <td rowspan="2">DIMENSION</td>
            <td rowspan="2">FUNCION</td>
            <td rowspan="2">INDICADOR</td>
            <td rowspan="2">CANT.</td>
            <td colspan="5">CONCEPTOS</td>
            </tr>
          <tr class="tabla01">
            <td>D</td>
            <td>C</td>
            <td>B</td>
            <td>I</td>
            <td>NO</td>
            </tr>
            <? /*for($i=0;$i<pg_numrows($resultados);$i++){
					$fila_d= pg_fetch_array($resultados,$i);
					$destacado=0;
					$competente =0;
					$basico =0;
					$insatisfactorio =0;
					$no_observado =0;
					$total = 0;
					$rs_totales = $ob_reporte->total_por_concepto($cmnPLANTILLA,$ano[0],$periodo[0],$cmbEMPLEADO,$fila_d['id_item']);
					for($j=0;$j<pg_numrows($rs_totales);$j++){
						$fila_t = pg_fetch_array($rs_totales,$j);
						if($fila_t['id_concepto']==4){
							$destacado = $fila_t['cantidad'];
						}
						if($fila_t['id_concepto']==5){
							$competente = $fila_t['cantidad'];
						}
						if($fila_t['id_concepto']==6){
							$basico = $fila_t['cantidad'];
						}
						if($fila_t['id_concepto']==8){
							$insatisfactorio = $fila_t['cantidad'];
						}
						if($fila_t['id_concepto']==9){
							$no_observado = $fila_t['cantidad'];
						}
						
					}
					$total =$destacado + $competente + $basico + $insatisfactorio + $no_observado;*/
			?>
          <tr>
            <td class="textosimple">&nbsp;<? echo $ob_reporte->Iniciales($fila_d['dimension']);?></td>
            <td class="textosimple">&nbsp;<? echo $ob_reporte->Iniciales($fila_d['funcion']);?></td>
            <td class="textosimple">&nbsp;<?=$fila_d['indicador'];?></td>
            <td class="textosimple">&nbsp;<?=$total;?></td>
            <td class="textosimple">&nbsp;<?=$destacado;?></td>
            <td class="textosimple">&nbsp;<?=$competente;?></td>
            <td class="textosimple">&nbsp;<?=$basico;?></td>
            <td class="textosimple">&nbsp;<?=$insatisfactorio;?></td>
            <td class="textosimple">&nbsp;<?=$no_observado;?></td>
            </tr>
          <? //} ?>
        </table>
       
        </td>
       
      </tr>
    </table></td>
  </tr>
</table>

<body>
</body>
</html>
