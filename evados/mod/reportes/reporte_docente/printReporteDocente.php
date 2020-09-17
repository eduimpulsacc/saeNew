<? 
header( 'Content-type: text/html; charset=iso-8859-1' );


session_start();

require "../class_reporte/class_reporte.php";

$ano = explode("-",$cmbANO);

$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

$fila_instit = $ob_reporte->Membrete($_INSTIT);

$fila_direc= $ob_reporte->Director($_INSTIT);

$fila_empleado = $ob_reporte->Empleado($cmbEMPLEADO,$ano[0]);

$result_dimension = $ob_reporte->Dimension($cmbPAUTA,$cmbEMPLEADO,$ano[0]);


$periodo 	= explode("-", $cmbPERIODO);
$cargo		= explode(",", $cmbCARGO);
/*echo "<br> RUT empleado-->".$cmbEMPLEADO;
echo "<BR> PAUTA-->".$cmbPAUTA;*/


//echo $cmbEMPLEADO;


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
        <td align="center" class="textonegrita"><u>EVALUACION DOCENTE - <?="&nbsp;".$ano[1];?> </u></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td class="textosimple" align="justify"><p>Profesor(a)<br />
              <?=$fila_empleado['empleado'];?><br />
              
              <u>Presente</u><br />
            </p>
              <blockquote>

                <p>La presente evaluaci&oacute;n corresponde a su gesti&oacute;n como <?=strtoupper($cargo['1']);?>, en el <?=$periodo['1'];?> del a&ntilde;o <?=$ano[1];?>. Los resultados obtenidos son los siguientes:</p>
                <p>A) Percepci&oacute;n de miembros de la comunidad educativa para cada Dimension establecida en el Sistema de Evaluaci&oacute;n Docente:<br />
                </p>
              </blockquote>
              <table width="90%" border="1" align="center" cellpadding="3" cellspacing="3" style="border-collapse:collapse" >
              <tr>
                <td align="center" class="textosimple"><strong>N&ordm;</strong></td>
                <td align="center" class="textosimple"><strong>DIMENSION</strong></td>
                <td align="center" class="textosimple"><strong>ESCALA</strong></td>
                
              </tr>
               <? for($i=0;$i<pg_numrows($result_dimension);$i++){
				  	$fila = pg_fetch_array($result_dimension,$i);
					$cont = $i + 1;
					
			?>
             
              <tr>
    <td width="5%" align="center" class="textosimple"><?=$cont;?></td>
    <td width="84%" class="textosimple"><?=$fila['nombre'];?></td>
    <td width="11%" class="textosimple"><? $fila_escala = $ob_reporte->Escala2($cmbEMPLEADO,$cmbPAUTA,$ano[0],$periodo['0'],$fila['id_area']);?></td>
    
              </tr>
  <? } ?>

              </table>
              <blockquote>
                <p>                B) Indicadores m&aacute;s destacados y aquellos Insatisfactorios
                  <br />
                </p>
              </blockquote>
              <table width="90%" border="0" align="center" >
                <tr>
                  <td class="textosimple">1.- Destacados</td>
                  </tr>
                <tr>
                  <td><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                  	<? 
					
						$re_valida_pauta = $ob_reporte->valida_reporte_evaluacion($ano[0],$cmbEMPLEADO,$periodo['0']);
						for($j=0;$j<pg_numrows($re_valida_pauta);$j++){
							$fila_vp = pg_fetch_array($re_valida_pauta,$j);
							
							$faltantes1=$fila_vp['primera'];
							$losdos=$faltantes1.','.$losdos;
							//echo $ok=$fila_vp['0'];
						}
						$separa_losdos=explode(',',$losdos);
						$faltantes=$separa_losdos[1];
						$totales=$separa_losdos[0];
						
						$total_t=100-(round(($faltantes*100)/$totales));
						 $total_t." %";
						
						/*if($total_t<90){
							echo "<script type=\"text/javascript\">alert(\"Total minimo de pauta no completada\");</script>";
							echo "<script type=\"text/javascript\">window.close();</script>";
							
							}*/
						
						
					$rs_destacado = $ob_reporte->Dimension_Destacada($cmbEMPLEADO,$cmbPAUTA,$ano[0],$periodo['0'],$_NACIONAL);
						for($i=0;$i<pg_numrows($rs_destacado);$i++){
							$fila_des = pg_fetch_array($rs_destacado,$i);
					?>
                    <tr>
                      <td class="textosimple"><?=$fila_des['nombre'];?></td>
                      </tr>
                     <? } ?>
                    </table></td>
                  </tr>
                <tr>
                  <td class="textosimple">2.- Insatisfactorios</td>
                  </tr>
                <tr>
                  <td><table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                    	<? $rs_insatisfactorio = $ob_reporte->Dimension_Insatisfactoria($cmbEMPLEADO,$cmbPAUTA,$ano[0],$periodo['0'],$_NACIONAL);
						for($i=0;$i<pg_numrows($rs_insatisfactorio);$i++){
							$fila_des = pg_fetch_array($rs_insatisfactorio,$i);
					?>
                    <tr>
                      <td class="textosimple"><?=$fila_des['nombre'];?></td>
                      </tr>
                     <? } ?>
                    </table></td>
                  </tr>
                <tr>
                  <td>&nbsp;</td>
                  </tr>
                <tr>
                  <td class="textosimple">C) Resultado de la Evaluaci&oacute;n para el periodo<strong></strong></td>
                  </tr>
                <tr>
                  <td class="textosimple"><blockquote>El resultado de su evaluaci&oacute;n para este periodo es: <b><? $resultado = $ob_reporte->Evaluacion_Final_New($cmbEMPLEADO,$cmbPAUTA,$ano[0],$periodo['0']);
				  echo pg_result($resultado,3);
				  ?></b>(<? $resultado_e = $ob_reporte->DescripcionEvaluacion(pg_result($resultado,3));
				  echo pg_result($resultado_e,0);
				  ?>)</blockquote></td>
                </tr>
               
              </table>
              <br />
              <br />
              <table width="100%" border="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td align="center">______________________________</td>
                </tr>
                <tr>
                  <td align="center" class="textonegrita"><?=$fila_direc['director'];?><br />
Director(a)</td>
                </tr>
          </table>
             </td>
          </tr>
        </table></td>
      </tr>
      
  </table></td>
  </tr>
  
</table>
<p>&nbsp;</p>
</body>
</html>