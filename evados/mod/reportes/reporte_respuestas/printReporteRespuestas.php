<? 
header( 'Content-type: text/html; charset=iso-8859-1' );


session_start();

require "../class_reporte/class_reporte.php";

$ano = explode("-",$cmbANO);
$nacional = $_NACIONAL;

$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

$fila_instit = $ob_reporte->Membrete($_INSTIT);

$fila_direc= $ob_reporte->Director($_INSTIT);

$fila_empleado = $ob_reporte->Empleado($cmbEMPLEADO,$ano[0]);

$result_dimension = $ob_reporte->Dimension($cmbPAUTA,$cmbEMPLEADO,$ano[0]);


$periodo 	= explode("-", $cmbPERIODO);
$cargo		= explode(",", $cmbCARGO);

$cantidad_evaluaciones = $ob_reporte->CantidadEvaluaciones($ano[0],$periodo[0],$cmbEMPLEADO,$cargo[0]);

$cantidad_evaluacionesSI = $ob_reporte->CantidadEvaluacionesSI($ano[0],$periodo[0],$cmbEMPLEADO,$cargo[0]);

$fila_evaluacion = $ob_reporte->PuntajeObtenido($ano[0],$periodo[0],$cmbPAUTA,$cmbEMPLEADO);

$rs_concepto = $ob_reporte->Concepto($nacional);
$area =  $ob_reporte->listaAreas($cmbPAUTA,$nacional,$ano[0],$periodo[0]);

$area = $ob_reporte->dimension2($cmbPAUTA,$cmbEMPLEADO,$ano[0],$nacional);
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
<style>
H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
</style>
<body>
<div id="capa0">
<table width="650" border="0" align="center">
  <tr>
    <td><input name="button" type="submit" class="report" id="button" value="CERRAR" onClick="cerrar()" /></td>
    <td align="right"><input name="button2" type="submit" class="report" id="button2" value="IMPRIMIR"  onClick="imprimir();"/></td>
  </tr>
</table>
</div>
<?php 
if(pg_numrows($result_dimension)>0){
for($e=0;$e<pg_numrows($cantidad_evaluaciones);$e++){
	$fila_ev= pg_fetch_array($cantidad_evaluaciones,$e);
	$reva = $ob_reporte->empleadoNom($fila_ev['rut_evaluador']);
	$feva = pg_fetch_array($reva,0);
	?>
<table width="650" border="0" align="center">
  <tr>
    <td  align="center" valign="middle">
    <?php include('../cabecera/cabecera.php');?>
    <table width="100%" border="0">
      <tr>
        <td class="textonegrita">&nbsp;</td>
        <td class="textonegrita">&nbsp;</td>
        <td class="textosimple">&nbsp;</td>
      </tr>
      <tr>
        <td width="20%" class="textonegrita"> Evaluado</td>
        <td width="2%" class="textonegrita">:</td>
        <td width="78%" class="textosimple">&nbsp;
          <b><?=strtoupper($cargo['1']);?></b> -
          <?=$fila_empleado['empleado'];?></td>
      </tr>
      <tr>
        <td width="20%" class="textonegrita"> Evaluador</td>
        <td width="2%" class="textonegrita">:</td>
        <td width="78%" class="textosimple">&nbsp;
          <b><?php 
		$car = $ob_reporte->cargo1($fila_ev['id_cargo']);
		echo strtoupper(pg_result($car,0)) ?></b>
          -		 <?php echo $feva['empleado']?><?php //echo $fila_ev['rut_evaluador'] ?></td>
      </tr>
     
    </table></td>
  </tr>
  <tr>
    <td colspan="3">
    <?php if($fila_ev['fecha_evaluacion']==''){
		?><br />
<br />
<br />

        <div align="center" class="textonegrita">EVALUACI&Oacute;N NO REALIZADA</div>
        <?
    }else{
		?>
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
            <?php  for($a=0;$a<pg_numrows($area);$a++){
				$fila = pg_fetch_array($area,$a);
				$nombre_area = $fila['nombre'];
				$id_area = $fila['id_area'];
				$id_plantilla = $fila['id_plantilla'];
				?>
           <tr>
             <td colspan="5" class="textonegrita"><b><?php echo strtoupper($nombre_area) ?><b>
               <?php //echo $id_area ?>
             </b></td></tr>
            <?php  $subarea= $ob_reporte->listaSubAreas($cmbPAUTA,$id_area,$nacional,$ano[0],$periodo[0]);
		    for($s=0;$s<pg_numrows($subarea);$s++){
				$fila = pg_fetch_array($subarea,$s);
				$nombre_subarea = $fila['nombre'];
				$id_area = $fila['id_area'];
				$id_subarea = $fila['id_subarea'];
				$id_plantilla = $fila['id_plantilla'];
				
				$item = $ob_reporte->listaItems($id_plantilla,$id_area,$id_subarea,$nacional,$ano[0],$periodo[0]);
				
		   ?>
          <?php  if(pg_numrows($item)>0){?>
           <tr><td colspan="5"  class="textosimple"><b>&nbsp;&nbsp;<?php echo $nombre_subarea ?><?php //echo $id_subarea ?></b></td></tr>
            <?php 
		  
          for($it=0;$it<pg_numrows($item);$it++){
				$fila = pg_fetch_array($item,$it);
				$nombre_item = $fila['nombre'];
				$id_area = $fila['id_area'];
				$id_subarea = $fila['id_subarea'];
				$id_item = $fila['id_item'];
				$id_plantilla = $fila['id_plantilla'];
				
				$rs_respuesta=$ob_reporte->respuestaEvaluadorInd($ano[0],$periodo[0],$id_area,$id_subarea,$id_item,$cmbEMPLEADO,$fila_ev['rut_evaluador'],$cargo[0]);
				$respuesta = pg_result($rs_respuesta,0);
				?>
           <tr  class="textosimple"><td><?php echo $nombre_item ?><?php //echo $id_item ?><?php //echo $respueta ?></td>
           <? for($i=0;$i<pg_numrows($rs_concepto);$i++){
					  	$fila_concepto = pg_fetch_array($rs_concepto,$i);
						
					
					?>
				    <td align="center"><div align="center"><?php echo ($fila_concepto['id_concepto']==$respuesta)?"X":"" ?></div></td>
                    <? } ?>
           </tr>
          
          	<?php  } //item?>
          <?php  } //item visible?>
           <?php } //subarea?>
          <?php  } //area?>
            </table>
        <?
    }?>
    </td>
  </tr>

</table>
<H1 class=SaltoDePagina></H1>
<?php }?>
<p>&nbsp;</p>
<table width="650" border="0" align="center">
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td width="20%" class="textonegrita">Nombre Evaluado</td>
        <td width="2%" class="textonegrita">:</td>
        <td width="78%" class="textosimple">&nbsp;
          <?=$fila_empleado['empleado'];?></td>
      </tr>
      <tr>
        <td class="textonegrita">Cargo Evaluado</td>
        <td class="textonegrita">:</td>
        <td class="textosimple">&nbsp;
          <?=strtoupper($cargo['1']);?>
          </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
<table width="50%" border="1" style="border-collapse:collapse">
                      <tr class="tableindex">
                        <td colspan="3" align="center">Cuadro Resumen</td>
                        </tr>
                      <tr>
                        <td width="62%" class="textosimple">Cantidad de Evaluadores</td>
                        <td width="3%" class="textosimple">:</td>
                        <td width="35%" align="center" class="textosimple">&nbsp;<?=pg_numrows($cantidad_evaluaciones);?></td>
                      </tr>
                      <tr>
                        <td class="textosimple">Evaluadores que realizaron la evaluaci&oacute;n</td>
                        <td class="textosimple">&nbsp;</td>
                        <td align="center" class="textosimple"><?=pg_numrows($cantidad_evaluacionesSI);?></td>
                      </tr>
                      <tr>
                        <td class="textosimple">Evaluadores que no realizaron la evaluaci&oacute;n</td>
                        <td class="textosimple">&nbsp;</td>
                        <td align="center" class="textosimple"><?=pg_numrows($cantidad_evaluaciones)-pg_numrows($cantidad_evaluacionesSI);?></td>
                      </tr>
                      <tr>
                        <td class="textosimple">Porcentaje Evaluaciones</td>
                        <td class="textosimple">:</td>
                        <td align="center" class="textosimple">&nbsp;
                          <?=$fila_evaluacion['porcentaje'];?>
                          %</td>
                      </tr>
    </table>
    </td></tr></table>
    <?php }?>
</body>
</html>