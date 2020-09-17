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



$ob_reporte->ano=$ano;
$ob_reporte->curso=$curso;
$ob_reporte->alumno=$alumno;

$rs_atrasos = $ob_reporte->getAtrasos($ano,$alumno);

//atrasos

$rs_anotaciones = $ob_reporte->getAnotaciones($ano,$alumno);

//inasistencias
$rs_asistencia = $ob_reporte->getAsistencia($ano,$alumno,$curso);


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
<body onload="window.print()">
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
        <td colspan="2">
        <table width="100%" border="0">
        <?php  if(pg_numrows($rs_anotaciones)>0){ 
		for($a=0;$a<pg_numrows($rs_anotaciones);$a++){
			$fila_anotacion = pg_fetch_array($rs_anotaciones,$a);
			
			 $rut_emp = $fila_anotacion['rut_emp'];
			$ob_reporte->Empleado($rut_emp);
			
		?>
        
          <tr>
            <td colspan="6">
          
            <table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; border-color:black">
             <tr>
            <td width="26%" height="25"><strong>Fecha</strong></td>
            <td width="45%"><?php echo CambioFD($fila_anotacion['fecha']) ?></td>
            <td width="14%"><strong>Tipo Conducta</strong></td>
            <td width="15%" colspan="3">&nbsp;<?php echo ($fila_anotacion['tipo_conducta']==1)?"POSITIVA":"NEGATIVA" ?></td>
            </tr>
          <tr>
            <td><strong>Profesor Responsable<br />
            </strong></td>
            <td><?php echo strtoupper($ob_reporte->Empleado($rut_emp)); ?></td>
            <td><strong>Hora</strong></td>
            <td colspan="3">&nbsp;<?php echo $fila_anotacion['hora'] ?></td>
            </tr>
          <tr>
            <td><strong>Observaci&oacute;n</strong></td>
            <td colspan="5"><?php echo $fila_anotacion['observacion'] ?></td>
            </tr>
             <?	if($fila_anotacion["sigla"]!=""){	?>
          <tr>
            <td><strong>Asignatura</strong></td>
            <td colspan="5">
            <?php 
			$sigla_aux = $fila_anotacion['sigla'];
			echo $ob_reporte->SiglaSubsector($sigla_aux);			 
			 ?>
            </td>
            </tr>
            <?php }?>
          <tr>
            <td><strong>Tipo de Anotaci&oacute;n </strong></td>
            <td colspan="5"><?php 
			
			echo $ob_reporte->TipoAnotacion($institucion,$fila_anotacion["codigo_tipo_anotacion"]); ?></td>
            </tr>
          <tr>
            <td><strong>Sub-Tipo</strong></td>
            <td colspan="5">
           <?php 
		    
		//echo $id_tipo = $ob_reporte->idTipoAnotacion($institucion,$fila_anotacion["codigo_tipo_anotacion"]);
		   
		   $cod_tipo = $ob_reporte->codigoAnotacion($institucion,$fila_anotacion["codigo_tipo_anotacion"]);
		
		if($cod_tipo=='L'){
		$suma_leves++;
		$suma_nega++;
		}
		if($cod_tipo=='M'){
		$suma_medias++;
		$suma_nega++;
		}
		if($cod_tipo=='G'){
		$suma_graves++;
		$suma_nega++;
		}
		if($cod_tipo=='P'){
		$suma_positivas++;
		}
		
		
		
		 
		   echo $ob_reporte->DetalleAnotaciones($fila_anotacion["codigo_anotacion"],$fila_anotacion["codigo_tipo_anotacion"]); ?>
            </td>
            </tr></table></td>
            </tr>
              <tr>
            <td colspan="6">&nbsp;</td>
          </tr>
           <?php } 
		   }
		   
		   else{?>
            <tr>
            <td colspan="6">Alumno sin anotaciones</td>
          </tr>
           <?php  }?>
          <tr>
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="6" align="center"><strong>RESUMEN DE ATRASOS E INASISTENCIAS </strong></td>
          </tr>
          <tr>
            <td colspan="6"><table width="300"  border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; border-color:black">
              <tr>
                <td><strong>ATRASOS:</strong> <?php echo pg_numrows($rs_atrasos) ?></td>
                <td><strong>INASISTENCIAS:</strong> <?php echo pg_numrows($rs_asistencia) ?></td>
              </tr>
            </table>
            </td>
          </tr>
          <tr>
            <td colspan="6" align="center">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="6" align="center"><strong>ATRASOS E INASISTENCIAS</strong></td>
          </tr>
          <tr>
            <td colspan="2" valign="top">
            <table width="300" border="0">
            <?php if(pg_numrows($rs_atrasos)>0){
				for($at=0;$at<pg_numrows($rs_atrasos);$at++){
				$fila_atraso = pg_fetch_array($rs_atrasos,$at);	
					?>
                <tr>
                  <td><strong>Atraso el d&iacute;a:</strong> <?php echo CambioFD($fila_atraso['fecha']) ?></td>
                </tr>
               <?php
				}}else{?>
               tr>
                    <td>Alumno no registra atrasos</td>
                </tr>
              <?php  }?>
              </table></td>
            <td colspan="4" valign="top"><table width="300" border="0">
            <?php   if(pg_numrows($rs_asistencia)>0){
				for($in=0;$in<pg_numrows($rs_asistencia);$in++){
					$fila_ina = pg_fetch_array($rs_asistencia,$in);	
				?>
              <tr>
                <td><strong>Inasistencia el d&iacute;a:</strong> <?php echo CambioFD($fila_ina['fecha']) ?></td>
              </tr>
          <?php   }}else{?>
            <tr>
                <td>Alumno no registra inasistencias</td>
              </tr>
           <?php  }?>
            </table></td>
          </tr>
          <tr>
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="6" align="center"><strong>RESUMEN DE ANOTACIONES</strong></td>
            </tr>
          <tr>
            <td colspan="6"><table width="327" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; border-color:black">
              <tr>
                <td width="121"><strong>TOTAL NEGATIVAS:</strong></td>
                <td width="20" align="center"><strong>L</strong></td>
                <td width="20" align="center"><strong>M</strong></td>
                <td width="20" align="center"><strong>G</strong></td>
                <td width="114"><strong>TOTAL POSITIVAS</strong></td>
              </tr>
              <tr>
                <td align="center"><?php echo intval($suma_nega) ?></td>
                <td align="center"><?php echo intval($suma_leves) ?></td>
                <td align="center"><?php echo intval($suma_medias) ?></td>
                <td align="center"><?php echo intval($suma_graves) ?></td>
                <td align="center"><?php echo intval($suma_positivas) ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="6">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><table width="300" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; border-color:black">
              <tr>
                <td width="241" ><strong>ENTREVISTAS APODERADO POR CONDUCTA</strong></td>
                <td width="43" align="center"><?php  //entrevistas rendimiento
				$tipo_entrevista=2;
				
				$scon2= $ob_reporte->conteo_entrevistas($ano,$alumno,$tipo_entrevista);
				$f_con2 = pg_fetch_array($scon2,0);
				echo $con2 = $f_con2['conteo'];
				//$sum_con= $sum_con+$con2;
				?> </td>
              </tr>
            </table></td>
            <td colspan="4" class="textosimple"><table width="300" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse; border-color:black">
              <tr>
                <td colspan="2" align="center"><strong>ATENCIONES APODERADO POR</strong></td>
                </tr>
              <tr>
                <td width="152"><strong>ORIENTACION</strong></td>
                <td width="132">&nbsp;</td>
              </tr>
              <tr>
                <td><strong>PSIC&Oacute;LOGO</strong></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><strong>NEUR&Oacute;LOGOS</strong></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><strong>OTROS</strong></td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
            </tr>
          <tr>
            <td colspan="6">&nbsp;</td>
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
