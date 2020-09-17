<? 

header( 'Content-type: text/html; charset=iso-8859-1' ); 
session_start(); 

$institucion 	= $_INSTIT;
 $ano 			=$_REQUEST['ano'];
 "<br>".$curso 			= $_REQUEST['curso'];

require "../../Class/Membrete.php";	
require "../../Class/Reporte.php";	

$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

$fila_instit = $ob_membrete->institucion($_INSTIT);

$fila_ano =$ob_reporte->AnoEscolarSeteado($ano);

$rs_curso = $ob_reporte->AlumnoCurso($curso);







?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../../../cortes/25269/estilos.css"/>
<title>REPORTE CEDE:::::: COLEGIO INTERACTIVO</title>
</head>

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
    <td colspan="3"><table width="95%" border="0" align="center" cellpadding="0">
      <tr>
        <td align="center" class="textonegrita"><p><u>REPORTE ASISTENCIA APODERADOS</u></p></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td><table width="100%" border="0">
              <tr>
                <td width="23%" class="textonegrita">CURSO</td>
                <td width="2%" class="textonegrita">:</td>
                <td width="75%" class="textosimple">&nbsp;<? echo $ob_reporte->CursoPalabra($curso,0);?></td>
              </tr>
              <tr>
                <td class="textonegrita">PROFESOR JEFE</td>
                <td class="textonegrita">:</td>
                <td class="textosimple">&nbsp;<? echo $ob_reporte->ProfesorJefe($curso);?></td>
              </tr>
              <tr>
                <td class="textonegrita"><?=htmlentities("AÑO",ENT_QUOTES,'UTF-8')?></td>
                <td class="textonegrita">:</td>
                <td class="textosimple">&nbsp;<? echo $fila_ano['nro_ano'];?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><br /><table width="100%" border="1" style="border-collapse:collapse">
              <tr>
                <td width="50%">ALUMNO</td>
                <td align="center">APODERADO</td>
                <td align="center">ENTREVISTAS</td>
              </tr>
              <? for($i=0;$i<pg_numrows($rs_curso);$i++){
						$fila = pg_fetch_array($rs_curso,$i);
						//echo "<br>".$fila['rut_alumno'];
						
						$data_apo=$ob_reporte->datos_apoderado($fila['rut_alumno']);
				?>
              <tr>
                <td class="textosimple">&nbsp;&nbsp;<? echo $fila['nombre_alumno'];?></td>
                <td class="textosimple"><?php echo $data_apo[2] ?></td>
                <td align="center"><?php echo $ob_reporte->conteo_entrevistas_todas($ano,$fila['rut_alumno']) ?></td>
                </tr>
               <? } ?>
            </table></td>
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
