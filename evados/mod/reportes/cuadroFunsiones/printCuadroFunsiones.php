<? 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "../class_reporte/class_reporte.php";

$ano = explode("-",$cmbANO);
$periodo 	= explode("-", $cmbPERIODO);
$cargo		= explode(",", $cmbCARGO);


$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

$fila_instit = $ob_reporte->Membrete($_INSTIT);

$fila_direc= $ob_reporte->Director($_INSTIT);

$rs_subarea =$ob_reporte->Subarea($_NACIONAL);

$rs_concepto = $ob_reporte->Concepto();

$rs_bloque = $ob_reporte->Bloque();

$rs_empleado = $ob_reporte->carga_empleado($cargo[0],$_INSTIT,$ano[0],$periodo[0]);



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
        <td align="center" class="textosimple"><? echo "Telefóno ".$fila_instit['telefono'];?></td>
      </tr>
      <tr>
        <td align="center" class="textosesion">www.educacionadventista.cl</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3"><table width="95%" border="0" align="center" cellpadding="0">
      <tr>
        <td align="center" class="textonegrita"><u>CUADRO DE DISTRIBUCI&Oacute;N DE RESPUESTAS<br>
          POR FUNSIONES
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
                    <td width="20%" class="textonegrita">Cargo Evaluado</td>
                    <td width="2%" class="textonegrita">:</td>
                    <td width="78%" class="textosimple">&nbsp;<?=strtoupper($cargo['1']);?><?/*
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
                <td><table width="100%" border="1" align="center" style="border-collapse:collapse">
                  <tr>
                    <td rowspan="3" class="textonegrita">NOMBRE</td>
                    <td colspan="<?=pg_numrows($rs_subarea) * 3;?>" align="center" class="textonegrita">FUNSIONES</td>
                    </tr>
                
                  <tr>
                 <? for($i=0;$i<pg_numrows($rs_subarea);$i++){
					 	$fila_sub =pg_fetch_array($rs_subarea,$i);
				?>
                    <td colspan="3" class="textonegrita" align="center"><?=$ob_reporte->Iniciales($fila_sub['nombre']);?></td>
                   <? } ?>
                    </tr>
                  <tr>
                  <? for($i=0;$i<pg_numrows($rs_subarea);$i++){
					 	$fila_sub =pg_fetch_array($rs_subarea,$i);
				?>
                    <td class="textonegrita" align="center">Op</td>
                    <td class="textonegrita" align="center">Ob</td>
                    <td class="textonegrita" align="center">Es</td>
                     <? } ?>
                  </tr>
                <? for($j=0;$j<pg_numrows($rs_empleado);$j++){
						$fila_emp = pg_fetch_array($rs_empleado,$j);
						
				?>
                  <tr>
                    <td class="textosimple">&nbsp;<?=$fila_emp['nombre'];?></td>
                     <? for($i=0;$i<pg_numrows($rs_subarea);$i++){
					 	$fila_sub =pg_fetch_array($rs_subarea,$i);
						$rs_funsion = $ob_reporte->Detalle_Funsion($ano[0],$periodo[0],$fila_emp['rut_emp'],$fila_sub['id_subarea']);
						$fila_fun = pg_fetch_array($rs_funsion,0);
				?>
                    <td class="textosimple">&nbsp;<?=$fila_fun['total_concepto'];?></td>
                    <td class="textosimple">&nbsp;<?=$fila_fun['sumatoria'];?></td>
                    <td class="textosimple" bgcolor="#CCCCCC">&nbsp;<?=$ob_reporte->Iniciales($fila_fun['evaluacion_final']);?></td>
                    <? } ?>
                  </tr>
                  <? } ?>
                </table></td>
              </tr>
               <tr><td>&nbsp;</td></tr>  
              <tr>
                <td><table width="100%" border="0">
                  <tr>
                    <td valign="top" width="50%">&nbsp;</td>
                    <td width="50%" valign="top">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
              <tr><td>&nbsp;</td></tr>
              <tr>
                <td class="textosimple">&nbsp;</td>
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
