<? 

header( 'Content-type: text/html; charset=iso-8859-1' ); 
session_start(); 

$ano =$_REQUEST['ano'];
$curso = $_REQUEST['curso'];
$institucion 	= $_INSTIT;

//var_dump($_REQUEST);

require "../../Class/Membrete.php";	
require "../../Class/Reporte.php";	

$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
$ob_reporte = new Reporte($_IPDB,$_ID_BASE);

$fila_instit = $ob_membrete->institucion($_INSTIT);

$fila_ano =$ob_reporte->AnoEscolarSeteado($ano);

$rs_curso = $ob_reporte->AlumnoCurso($curso);


$rs_becas_ins= $ob_reporte->TraeDescBeca($ano);




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
        <td align="center" class="textonegrita"><p><u>REPORTE ENTREVISTAS APODERADOS</u></p></td>
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
              <tr>
                <td colspan="3" class="textonegrita">&nbsp;</td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td><br /><table width="100%" border="1" style="border-collapse:collapse">
              <tr class="textonegrita">
                <td width="50%" height="25">ALUMNO</td>
                <td width="25%" align="center">RENDIMIENTO</td>
                <td width="25%" align="center">CONDUCTA</td>
            
              </tr>
              <? for($i=0;$i<pg_numrows($rs_curso);$i++){
						$fila = pg_fetch_array($rs_curso,$i);
						
					
				?>
              <tr class="textosimple">
                <td >&nbsp;&nbsp;<? echo substr($fila['nombre_alumno'],0,30);?>...</td>
                <td align="center" >
                <?php //entrevistas rendimiento
				
				
				$tipo_entrevista=1;
				
				$scon1= $ob_reporte->conteo_entrevistas($ano,$fila['rut_alumno'],$tipo_entrevista);
				$f_con1 = pg_fetch_array($scon1,0);
				echo $con1 = $f_con1['conteo'];
				$sum_ren = $sum_ren+$con1;
				
				?>
                </td>
                <td align="center" >
                <?php //entrevistas rendimiento
				$tipo_entrevista=2;
				
				$scon2= $ob_reporte->conteo_entrevistas($ano,$fila['rut_alumno'],$tipo_entrevista);
				$f_con2 = pg_fetch_array($scon2,0);
				echo $con2 = $f_con2['conteo'];
				$sum_con= $sum_con+$con2;
				?>
                </td>
               
                
                </tr>
               <? } ?>
               <tr class="textonegrita"><td>TOTALES               
                 
                 <td align="center"><?php echo $sum_ren ?>                 
                 <td align="center"><?php echo $sum_con ?></tr>
            </table></td>
          </tr>
          
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="3" align="left" class=" textosesion">&nbsp;</td>
  </tr>
</table>
</body>
</html>
