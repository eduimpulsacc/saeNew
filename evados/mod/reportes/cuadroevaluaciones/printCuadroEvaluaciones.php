<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "../class_reporte/class_reporte.php";

$ano = explode("-",$cmbANO);

$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

$fila_instit = $ob_reporte->Membrete($_INSTIT);

$fila_direc= $ob_reporte->Director($_INSTIT);

$fila_empleado = $ob_reporte->Empleado($cmbEMPLEADO,$ano[0]);

$result_dimension = $ob_reporte->Dimension($cmbPAUTA,$fila_empleado['docente'],$ano[0]);

$rs_concepto = $ob_reporte->Concepto($_NACIONAL);

$rs_bloque = $ob_reporte->Bloque();

$periodo 	= explode("-", $cmbPERIODO);
$cargo		= explode(",", $cmbCARGO);

$fila_evaluacion = $ob_reporte->PuntajeObtenido($ano[0],$periodo[0],$cmbPAUTA,$cmbEMPLEADO);

$cantidad_evaluaciones = $ob_reporte->CantidadEvaluaciones($ano[0],$periodo[0],$cmbEMPLEADO,$cargo[0]);


if($fila_evaluacion['valor_final']<90){
?>
<script>
//alert("Pauta invalida");
//window.close();
</script>
<?
}

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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../css/estilos.css" rel="stylesheet" type="text/css">
<title>SISTEMA EVALUACI&Oacute;N DOCENTE: CUADRO DE EVALUACIONES</title>
</head>

<body>
<div id="capa0">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><input type="button" name="Submit2" value="CERRAR" class="report" onClick="window.close()"/></td>
    <td><div align="right">
      <input type="button" name="Submit" value="IMPRIMIR"  class="report" onClick="imprimir()"/>
    </div></td>
  </tr>
</table>
</div>
<br />
<table width="650" border="0" align="center">
   <tr>
    <td  align="center" valign="middle">
    <?php include('../cabecera/cabecera.php');?>
    </td>
  </tr>
  <tr>
    <td colspan="3"><table width="95%" border="0" align="center" cellpadding="0">
      <tr>
        <td align="center" class="textonegrita"><u>CUADRO DE DISTRIBUCI&Oacute;N DE RESPUESTAS<br>
          POR BLOQUE DE EVALUADORES
          <?="&nbsp;".$ano[1];?>
        </u></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td class="textosimple" align="justify"><table width="100%" border="0">
              <tr>
                <td><table width="100%" border="0">
                  <tr>
                    <td width="20%" class="textonegrita">Nombre Evaluado</td>
                    <td width="2%" class="textonegrita">:</td>
                    <td width="78%" class="textosimple">&nbsp;<?=$fila_empleado['empleado'];?></td>
                  </tr>
                  <tr>
                    <td class="textonegrita">Cargo Evaluado</td>
                    <td class="textonegrita">:</td>
                    <td class="textosimple">&nbsp;<?=strtoupper($cargo['1']);?><?/*
                    if($fila_empleado['docente']==0){
						echo "Directivo";	
					}elseif($fila_empleado['empleado']==1){
						echo "Docente de Aula";
					}else{
						echo "Profesor Jefe";
					}*/?></td>
                  </tr>
                </table></td>
              </tr>
              <tr><td>&nbsp;</td></tr>              
              <tr>
                <td><table width="100%" border="1" style="border-collapse:collapse">
                  <tr class="tableindex">
                    <td rowspan="2">Bloque</td>
                    <td colspan="<?=pg_numrows($rs_concepto);?>" align="center">Conceptos</td>
                    <td rowspan="2" align="center">Total</td>
                  </tr>
                  <tr class="tableindex">
                  <? for($i=0;$i<pg_numrows($rs_concepto);$i++){
					  	$fila_concepto = pg_fetch_array($rs_concepto,$i);
					?>
				    <td>&nbsp;<?=$fila_concepto['sigla'];?></td>
                    <? } ?>
                    </tr>
                    <? for($i=0;$i<pg_numrows($rs_bloque);$i++){
							$fila_bloque = pg_fetch_array($rs_bloque,$i);
					?>					
                  <tr>
                    <td class="textosimple">&nbsp;<?=$fila_bloque['nombre'];?></td>
                   <? 	$suma_bloque=0;
				   for($j=0;$j<pg_numrows($rs_concepto);$j++){
					   	$fila_concepto = pg_fetch_array($rs_concepto,$j);
				   		$resultado_concepto = $ob_reporte->ResultadoConcepto($ano[0],$periodo[0],$cmbPAUTA,$cmbEMPLEADO,$fila_bloque['id_bloque'],$fila_concepto['id_concepto'],$_NACIONAL);
				   		
              		
						$fila_res = pg_fetch_array($resultado_concepto,0);
					?>     
                    <td align="right" class="textosimple"><?=$fila_res['valor'];?>&nbsp;</td>
                    <? $suma_bloque = $suma_bloque + $fila_res['valor'];
					} ?>
                    <td align="right" class="textosimple"><?=$suma_bloque;?>&nbsp;</td>
                  </tr>
                  <? $suma_total = $suma_total + $suma_bloque;
				  } ?>
                  <tr>
                    <td class="tableindex">Total Evaluado</td>
                    <td colspan="<?=pg_numrows($rs_concepto);?>" class="tableindex">&nbsp;</td>
                    <td align="right" class="textosimple"><?=$suma_total;?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
               <tr><td>&nbsp;</td></tr>  
              <tr>
                <td><table width="100%" border="0">
                  <tr>
                    <td valign="top" width="50%"><table width="100%" border="1" style="border-collapse:collapse">
                      <tr class="tableindex">
                        <td colspan="3" align="center">Cuadro Resultado</td>
                        </tr>
                      <tr>
                        <td width="62%" class="textosimple">Puntaje Optimo</td>
                        <td width="3%" class="textosimple">:</td>
                        <td width="35%" align="center" class="textosimple">&nbsp;<?=$fila_evaluacion['total_concepto'];?></td>
                      </tr>
                      <tr>
                        <td class="textosimple">Puntaje Obtenido</td>
                        <td class="textosimple">:</td>
                        <td align="center" class="textosimple">&nbsp;<?=$fila_evaluacion['sumatoria'];?></td>
                      </tr>
                      <tr>
                        <td class="textosimple">Porcentaje</td>
                        <td class="textosimple">:</td>
                        <td align="center" class="textosimple">&nbsp;<?=$fila_evaluacion['valor_final'];?>%</td>
                      </tr>
                      <tr>
                        <td class="textosimple">Porcentaje Evaluaciones</td>
                        <td class="textosimple">:</td>
                        <td align="center" class="textosimple">&nbsp;<?=$fila_evaluacion['porcentaje'];?>%</td>
                      </tr>
                      <tr>
                        <td class="textosimple">Cantidad de Evaluadores</td>
                        <td class="textosimple">:</td>
                        <td align="center" class="textosimple">&nbsp;<?=pg_numrows($cantidad_evaluaciones);?></td>
                      </tr>
                    </table></td>
                    <td width="50%" valign="top"><table width="100%" border="1" style="border-collapse:collapse">
                      <tr class="tableindex">
                        <td colspan="3" align="center">Escala</td>
                        </tr>
                      <tr>
                        <td class="textosimple">Destacado</td>
                        <td align="center" class="textosimple">90</td>
                        <td align="center" class="textosimple">100</td>
                      </tr>
                      <tr>
                        <td class="textosimple">Competente</td>
                        <td align="center" class="textosimple">75</td>
                        <td align="center" class="textosimple">89</td>
                      </tr>
                      <tr>
                        <td class="textosimple">Basico</td>
                        <td align="center" class="textosimple">60</td>
                        <td align="center" class="textosimple">74</td>
                      </tr>
                      <tr>
                        <td class="textosimple">Insatisfactorio</td>
                        <td colspan="2" align="center" class="textosimple">Menos de 60</td>
                        </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td class="textosimple">El resultado de su evaluaci&oacute;n para este periodo es:<b><?=$fila_evaluacion['evaluacion_final'];?></b> </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
</table>
<br />
<p>&nbsp;</p>
</body>
</html>
