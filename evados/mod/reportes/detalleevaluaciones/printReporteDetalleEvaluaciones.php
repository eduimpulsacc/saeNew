<? 
header( 'Content-type: text/html; charset=iso-8859-1' );


session_start();

require "../class_reporte/class_reporte.php";


$ano = explode("-",$cmbANO);
$periodo = explode("-",$cmbPERIODO);
$cargo = explode("-",$cmbCARGO);

$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

$fila_instit = $ob_reporte->Membrete($_INSTIT);

$fila_direc= $ob_reporte->Director($_INSTIT);

$nacional = $_NACIONAL;

$fila_empleado = $ob_reporte->Empleado($cmbEMPLEADO,$ano[0]);

$result_dimension = $ob_reporte->Dimension($cmbPAUTA,$cmbEMPLEADO,$ano[0]);

//$resultados = $ob_reporte->resultados_dimension($cmbPAUTA);

$periodo 	= explode("-", $cmbPERIODO);
$cargo		= explode(",", $cmbCARGO);

$rs_valida = $ob_reporte->valida_reporte_evaluacion($ano[0],$cmbEMPLEADO,$periodo[0]);
$realizadas = pg_fetch_array($rs_valida,0);
$pendientes = pg_fetch_array($rs_valida,1);

$rs_concepto = $ob_reporte->Concepto($nacional);

//$area =  $ob_reporte->listaAreas($cmbPAUTA,$nacional,$ano[0],$periodo[0]);

$area = $ob_reporte->Dimension($cmbPAUTA,$cmbEMPLEADO,$ano[0]);

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
    <td  align="center" valign="middle">
    <?php include('../cabecera/cabecera.php');?>
    </td>
  </tr>
  <tr>
    <td colspan="3"><table width="95%" border="0" align="center" cellpadding="0">
      <tr>
        <td colspan="2" align="center" class="textonegrita"><u>EVALUACION DESEMPEÑO DOCENTE - <?=$periodo[1]."&nbsp;".$ano[1];?> </u> </td>
        </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr>
        <td width="11%" class="listadetalleoff">NOMBRE:</td>
        <td width="89%" class="textosimple">&nbsp;<?=$fila_empleado['empleado'];?></td>
      </tr>
      <!--<tr>
        <td class="listadetalleoff">EVALUACIONES PROYECTADAS:</td>
        <td class="textosimple">&nbsp;<?=$pendientes['primera'];?></td>
      </tr>
      <tr>
        <td class="listadetalleoff">EVALUACIONES REALIZADAS:</td>
        <td class="textosimple">&nbsp;<?=$realizadas['primera'];?></td>
      </tr>-->
      <tr>
        <td class="listadetalleoff">&nbsp;</td>
        <td class="textosimple">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="listadetalleoff">La presente evaluación corresponde a su gestión como <?php echo $cargo[1] ?>, en el <?php echo $periodo[1] ?> del año <?php echo $ano[1] ?>. Los resultados obtenidos son los siguientes:</td>
        </tr>
      <tr>
        <td colspan="2">
       
        <table width="100%" border="1" style="border-collapse:collapse">
          <tr class="tabla01">
            <td rowspan="2">INDICADOR</td>
            <td colspan="<?php echo pg_numrows($rs_concepto) ?>">CONCEPTOS</td>
            </tr>
            <? for($i=0;$i<pg_numrows($rs_concepto);$i++){
					  	$fila_concepto = pg_fetch_array($rs_concepto,$i);
					?>
				    <td class="tabla01" align="center"><div align="center"><?=$fila_concepto['sigla'];?></div></td>
                    <? } ?>
          
            </tr>
        <?php 
		
		  if($area){
			 
			  for($e=0;$e<pg_numrows($area);$e++){
			  
				$fila = pg_fetch_array($area,$e);
				$nombre_area = $fila['nombre'];
				$id_area = $fila['id_area'];
				$id_plantilla = $fila['id_plantilla'];
				
				?>
          <tr>
            <td colspan="6" class="textosimple"><b><?php echo strtoupper($nombre_area) ?></b> <?php //echo $id_area ?></td>
            </tr>
           <?php  $subarea= $ob_reporte->listaSubAreas($cmbPAUTA,$id_area,$nacional,$ano[0],$periodo[0]);
		    for($s=0;$s<pg_numrows($subarea);$s++){
				$fila = pg_fetch_array($subarea,$s);
				$nombre_subarea = $fila['nombre'];
				$id_area = $fila['id_area'];
				$id_subarea = $fila['id_subarea'];
				$id_plantilla = $fila['id_plantilla'];
		   ?>
          <tr>
            <td colspan="6" class="textosimple"><b>&nbsp;&nbsp;<?php echo $nombre_subarea ?><?php //echo $id_subarea ?></b></td>
          </tr>
          <?php $item = $ob_reporte->listaItems($id_plantilla,$id_area,$id_subarea,$nacional,$ano[0],$periodo[0]);
		  
          for($it=0;$it<pg_numrows($item);$it++){
				$fila = pg_fetch_array($item,$it);
				$nombre_item = $fila['nombre'];
				$id_area = $fila['id_area'];
				$id_subarea = $fila['id_subarea'];
				$id_item = $fila['id_item'];
				$id_plantilla = $fila['id_plantilla'];
				
				$destacado=0;
				$competente =0;
				$basico =0;
				$insatisfactorio =0;
				$no_observado =0;
				$total = 0;
				
				
				
			?>
          <tr>
            <td class="textosimple">&nbsp;&nbsp;&nbsp;<?php echo $nombre_item ?><?php //echo $id_item ?></td>
            <? for($i=0;$i<pg_numrows($rs_concepto);$i++){
			$fila_concepto = pg_fetch_array($rs_concepto,$i);
			
						
					?>
			    <td align="center" class="textosimple">
				<?php $rs_totales = $ob_reporte->total_por_concepto_global($cmbPAUTA,$ano[0],$periodo[0],$cmbEMPLEADO,$id_item,$fila_concepto['id_concepto'],$id_area,$id_subarea);?>
				
				<?php echo pg_result($rs_totales,0);  ?></td>
                    <? } ?>
          </tr>
            <?php } //item?>
            <?php } //subarea?>
          <?php } //area
		  }?>
        </table>
       
        </td>
       
      </tr>
    </table></td>
  </tr>
</table>

<body>
</body>
</html>
