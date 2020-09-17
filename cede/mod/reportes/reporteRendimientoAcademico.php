<? 

header( 'Content-type: text/html; charset=iso-8859-1' ); 
session_start(); 

$institucion 	= $_INSTIT;
$ano 			=$_REQUEST['ano'];
$curso 			= $_REQUEST['curso'];
$alumno 		= $_REQUEST['alumno'];

require "../../Class/Membrete.php";	
require "../../Class/Reporte.php";	

$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

$fila_instit = $ob_membrete->institucion($_INSTIT);

$fila_ano =$ob_reporte->AnoEscolarSeteado($ano);

$nro_ano = $fila_ano['nro_ano'];
$cerrado = $fila_ano['situacion'];

$rs_curso = $ob_reporte->Curso($curso);
$fila_curso = pg_fetch_array($rs_curso,0);

$ob_reporte->ano=$ano;
$ob_reporte->curso=$curso;
$ob_reporte->alumno=$alumno;
$rs_periodos = $ob_reporte->TotalPeriodo($ano);
$num_periodos= pg_numrows($rs_periodos);

if ($num_periodos==2) $tipo_per = "SE";
if ($num_periodos==3) $tipo_per = "TR";	
		
function CambioFD($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m."/".$a;
	else
		$retorno="";
	return $retorno;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso8859-1" />
<link rel="stylesheet" type="text/css" href="../../../cortes/25269/estilos.css"/>
<title>REPORTE CEDE:::::: COLEGIO INTERACTIVO</title>
</head>
<style>
table{ font-size:12px}
</style>
<body>
<table width="650" border="0" align="center">
  <tr>
    <td width="172" align="center" valign="middle"> <? echo "<img src='../../../tmp/".$institucion."insignia". "' >";?></td>
    <td width="25" align="center" valign="middle"><hr align="center" width="1" size="100" /></td>
    <td width="439"><table width="100%" border="0">
      <tr>
        <td align="center" class="textonegrita"><? echo strtoupper($fila_instit['nombre_instit']);?></td>
      </tr>
      <tr>
        <td align="center" class="textosimple"><? echo $fila_instit['direc']." / ".$fila_instit['nom_reg'];?></td>
      </tr>
      <tr>
        <td align="center" class="textosimple"><? echo htmlentities("Telefóno",ENT_QUOTES,'UTF-8')."  ".$fila_instit['telefono'];?></td>
      </tr>
      <tr>
        <td align="center" class="textosesion">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3" class="textosimple"><table width="95%" border="0" align="center" cellpadding="0">
      <tr>
        <td colspan="2" align="center" class="textonegrita"><p><u>INFORME DE DE CONDUCTA CON SEGUIMIENTO</u></p></td>
        </tr>
      <tr>
        <td width="27%">&nbsp;</td>
        <td width="73%">&nbsp;</td>
      </tr>
      <tr>
        <td><strong>Curso</strong></td>
        <td><? echo $ob_reporte->CursoPalabra($curso,0);?></td>
      </tr>
      <tr>
        <td><strong>Alumno</strong></td>
        <td><? echo $ob_reporte->nombreAlumno($alumno);?></td>
      </tr>
      <tr>
        <td><strong>Profesor Jefe</strong></td>
        <td><? echo $ob_reporte->ProfesorJefe($curso);?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2"><table width="650" border="1">
          <tr class="tableindex">
            <td>Asignatura</td>
            <?php for($p=1;$p<=pg_numrows($rs_periodos);$p++){?>
            <td align="center"> <?=$p?>
				  &ordm;<? echo $tipo_per ?></td>
            <td align="center">CONC.</td>
           <?php  }?>
            <td align="center">PROM.<br />
FINAL</td>
            <td align="center">CONC.</td>
          </tr>
          
          <?php  $rs_ramos = $ob_reporte->RamoAlumno($nro_ano,$curso,$alumno); ?>
          
         <?php for($r=0;$r<pg_numrows($rs_ramos);$r++){
			 $fila_ramo = pg_fetch_array($rs_ramos,$r);
			 $ramo =$fila_ramo['id_ramo'];
			 $promedio_nota=0;
			 $con_promedio=0;
			 $prom_ramo_final=0;
			 
			 ?>
          
          <tr class="textosimple">
            <td><?php echo $fila_ramo['nombre'] ?></td>
             <?php for($p=1;$p<=pg_numrows($rs_periodos);$p++){
				 $fila_periodo =pg_fetch_array($rs_periodos,($p-1));
				 $periodo=$fila_periodo['id_periodo'];
				
				 $prom_periodo = $ob_reporte->PromediosPeriodo($nro_ano,$periodo,$ramo,$alumno);
				 
				 if($fila_ramo['modo_eval']==1 && intval($prom_periodo)>0){
				$logro =$ob_reporte->LogroNota($prom_periodo,$ano);
				}else{
					$logro ="";
				}
				
				if($fila_ramo['modo_eval']==2){
				$pr = $ob_reporte->Conceptual($prom_periodo,2);
				if($pr){
				$con_promedio++;
				$promedio_nota=$promedio_nota+$pr;
				}
				}
				
				//calculo promedio lineal
				if(intval($prom_periodo)>0){
					$promedio_nota=$promedio_nota+$prom_periodo;
			 		$con_promedio++;
				}
				 
				 ?>
            <td align="center"><?php echo $prom_periodo ?></td>
            <td align="center"><?php echo $logro ?></td>
            <?php  } ?>
            <td align="center"><?php 
			if($cerrado==0){
			$prom_ramo_final = $ob_reporte->PromedioSubFinal($alumno,$ramo);
			}else{
				
			if($fila_ramo['modo_eval']==1){	
			$prf = $promedio_nota/$con_promedio;
			$prom_ramo_final = ($fila_curso['truncado_per']==1)?round($prf):intval($prf);
			
			$prom_general = $prom_general+$prom_ramo_final;
			$cont_general++;
			}
			
			if($fila_ramo['modo_eval']==2){	
			$prf = $promedio_nota/$con_promedio;
			$prom_ramo_final = ($fila_curso['truncado_per']==1)?round($prf):intval($prf);
			
			$prom_ramo_final = $ob_reporte->Conceptual($prom_ramo_final,1);
			
			}
			
			}
			
			
			
			//muestro el promedio final
			echo $prom_ramo_final;
			
			?>         
            </td>
            <td align="center"><?php  if($fila_ramo['modo_eval']==1 && intval($prom_ramo_final)>0){
				$logro_final =$ob_reporte->LogroNota($prom_ramo_final,$ano);
				}else{
					$logro_final ="";
				} 
            echo $logro_final;?>
            </td>
          </tr>
          <?php }?>
          <tr class="textonegrita">
            <td colspan="<?php echo (pg_numrows($rs_periodos)*2)+1 ?>" align="right">PROMEDIO</td>
            <td align="center">
            <?php  if($cerrado==0){
			$prom_final = $ob_reporte->PromedioAnoFinal($alumno,$ano,$curso);
			} 
			else{
			$prom_final=$prom_general/$cont_general;
			
			$prom_final = ($fila_curso['truncado_final']==1)?round($prom_final):intval($prom_final);
			
			}
			echo $prom_final;
			?>
           <?php   if( intval($prom_final)>0){
				$logro_final =$ob_reporte->LogroNota($prom_final,$ano);
				}else{
					$logro_final ="";
				}
				
				
				?>
            </td>
            <td align="center"><?php echo $logro_final?></td>
          </tr>
        </table></td>
      
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class=" textosesion">&nbsp;</td>
  </tr>
</table>
</body>
</html>
