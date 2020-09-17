<?php 
require('../../../../util/header.inc'); 
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
$institucion= $_INSTIT;
$ano			= $_ANO;
 
 
$ob_reporte = new Reporte();
$ob_institucion = new Membrete();
	$ob_institucion -> ano =$ano;
	$ob_institucion -> institucion =$institucion;
	$ob_institucion -> institucion($conn);

$ob_reporte->ano = $ano; 
	
	
$sql_ense="select ensenanza from curso where id_curso=$id_curso";	

$rs_ense=pg_exec($conn,$sql_ense);
$ense = pg_result($rs_ense,0);

$Curso_pal = CursoPalabra($id_curso, 0, $conn);




function CambioFechaDisplay($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
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
<html xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<style>
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:11px;
}
</style>
</head>

<body lang=ES>
<div class=textosimple>
<table><tr><td>
  <table width=755 border=1 cellpadding=0 cellspacing=0 style="border-collapse:collapse">
    <tr>
      <td colspan=7 class="textonegrita"><p><?
						if($institucion!=""){
							echo "<img src='../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?></p>
        
       </td>
      <td colspan=5 valign="middle" class="textonegrita" align="center"><br><b><font size="2">FICHA DE MATR&Iacute;CULA <?
				$ob_institucion->ano = $ano;
				$ob_institucion->AnoEscolar($conn);
				echo ($ob_institucion->nro_ano)+1;
				?><u><br><br>
        CURSO:_____________________</u><br></font></b>
</td>
      <td width=119 colspan=2 valign=top><p align=center style='
  text-align:center'>FOTO</p></td>
    </tr>
   
  </table><br>
  <table width="755" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
  <tr>
    <td colspan="4" ><strong><u>ANTECEDENTES DEL ALUMNO</u></strong><br>
<br>
</td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td width="25%" align="center">(APELLIDO PATERNO)</td>
    <td width="25%" align="center">(APELLIDO MATERNO)</td>
    <td colspan="2" align="center">(NOMBRES)</td>
    </tr>
  <tr>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
  </tr>
  <tr>
    <td width="25%">Fecha de Nacimiento</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">C&eacute;dula de Identidad</td>
    <td width="25%">&nbsp;</td>
  </tr>
  <tr>
    <td>Edad al 31 de marzo</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">Direcci&oacute;n</td>
    <td width="25%">Comuna</td>
  </tr>
  <tr>
    <td width="25%">Fono red fija</td>
    <td width="25%">&nbsp;</td>
    <td width="25%">Fono Celular</td>
    <td width="25%">&nbsp;</td>
  </tr>
  <tr>
    <td>Colegio de procedencia</td>
    <td>&nbsp;</td>
    <td>Curso(s) que ha repetido</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Con Hermanos</td>
    <td colspan="2">&nbsp;</td>
    <td>Sin hermanos</td>
  </tr>
  <tr>
    <td>Tiene alg&uacute;n problema de salud significativo</td>
    <td colspan="3">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2">Enfermedades cr&oacute;nicas</td>
    <td colspan="2">Alergias</td>
    </tr>
  <tr>
    <td>&iquest;Con qu&iacute;en vive el alumno?</td>
    <td colspan="3">&nbsp;</td>
    </tr>
  </table>

  <br>
<table width="755" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
  <tr>
    <td colspan="5"><strong><u>ANTECEDENTES DE LOS PADRES</u></strong><br>
<br></td>
    </tr>
  <tr>
    <td colspan="5"><strong>PADRE</strong></td>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td width="20%" align="center">Apellido Paterno</td>
    <td width="20%" align="center">Apellido Materno</td>
    <td width="20%" align="center">Nombres</td>
    <td width="20%" align="center">RUT</td>
    <td width="20%" align="center">Estado Civil</td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td>Correo electr&oacute;nico</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="20%">Nivel Educacional</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">Previsi&oacute;n</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">Fono Fijo o Celular</td>
  </tr>
  <tr>
    <td>Direcci&oacute;n</td>
    <td colspan="2">&nbsp;</td>
    <td>Comuna</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="20%">Trabaja jornada</td>
    <td>&nbsp;</td>
    <td>Ocupaci&oacute;n</td>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
    <td colspan="5"><strong>MADRE</strong></td>
    </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td width="20%" align="center">Apellido Paterno</td>
    <td width="20%" align="center">Apellido Materno</td>
    <td width="20%" align="center">Nombres</td>
    <td width="20%" align="center">RUT</td>
    <td width="20%" align="center">Estado Civil</td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td width="20%">Nivel Educacional</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">Previsi&oacute;n</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">Fono Fijo o Celular</td>
  </tr>
  <tr>
    <td>Direcci&oacute;n</td>
    <td colspan="2">&nbsp;</td>
    <td>Comuna</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="20%">Trabaja jornada</td>
    <td>&nbsp;</td>
    <td>Ocupaci&oacute;n</td>
    <td colspan="2">&nbsp;</td>
    </tr>
</table>

<br>
<table width="755" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
  <tr>
    <td colspan="4"><strong><u>Antedecentes Apoderado, Padre Madre o Tutor LEGAL</u>:<br>
      (que firma el Contrato de Prestaci&oacute;n de servicios Educacionales y asume los costos de Mensualidad)</strong></td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr>
    <td width="121">Nombre Completo</td>
    <td width="341">&nbsp;</td>
    <td width="68">Rut</td>
    <td width="215">&nbsp;</td>
  </tr>
  <tr>
    <td>Trabaja en</td>
    <td>&nbsp;</td>
    <td>Profesi&oacute;n</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Correo electr&oacute;nico</td>
    <td>&nbsp;</td>
    <td>Celular</td>
    <td>&nbsp;</td>
  </tr>
</table>

<br>
<table width="755" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
  <tr>
    <td colspan="5"><strong><u>Otras personas autorizadas para retirar al alumno (Apoderado suplente)</u><br>
    </strong></td>
    </tr>
  <tr>
    <td width="20%"><strong>Nombre</strong></td>
    <td width="20%"><strong>Rut</strong></td>
    <td width="20%"><strong>Parentesco</strong></td>
    <td width="20%"><strong>Fono red fija</strong></td>
    <td width="20%"><strong>Fono Celular</strong></td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
  </tr>
  <tr>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
    <td width="20%">&nbsp;</td>
  </tr>
</table>

<br>
<table width="755" border="1" cellspacing="1" cellpadding="1" style="border-collapse:collapse">
  <tr>
    <td colspan="7" align="center"><strong>AUTORIZACIONES</strong></td>
    </tr>
  <tr>
   
    <td width="194">Tomar fotograf&iacute;as/videos en actividades escolares</td>
    <td width="66">&nbsp;</td>
    <td width="195">Compartir fotograf&iacute;as en p&aacute;gina institucional y/o en redes sociales institucionales</td>
    <td width="50">&nbsp;</td>
    <td width="166">Vacunas</td>
    <td width="51"><h1>&nbsp;</h1></td>
  </tr>
</table>

<br>

 <table width=550 border=1 cellpadding=0 cellspacing=0 style="border-collapse:collapse">
 <tr>
   <td width="173">N&uacute;mero Matr&iacute;cula (uso interno)</td><td width="371" colspan="2">&nbsp;</td></tr>
 <tr>
   <td>Encargado(a) Matr&iacute;cula</td>
   <td colspan="2">&nbsp;</td>
 </tr>
 <tr>
   <td>N&deg; Boleta CEPA/MINEDUC</td>
   <td>&nbsp;</td>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td>Observaciones</td>
   <td colspan="2">&nbsp;</td>
 </tr>
 </table>
<br>

  <table width=756 border=1 cellpadding=0 cellspacing=0 style="border-collapse:collapse">
    <tr>
      <td width=471 height="150" rowspan="3" valign=top>Al momento de matricular a mi pupilo/a en este establecimiento declaro haber sido informado, tomar conocimiento y aceptar el <strong>Proyecto Educativo Institucional</strong>, el<strong> Reglamento de Convivencia Escolar, Reglamento de Evaluaci&oacute;n</strong> y <strong>Protocolos de acci&oacute;n</strong>.<br>
Me comprometo a apoyar el proceso educativo de mi hijo, velando por el cumplimiento de la <strong>asistencia a clases</strong> y <strong>trabajos escolares</strong> que le sean asignados.<br>
Asistir a reuniones, entrevistas y cuando es citado/a por el colegio.<br>
Apoyar y participar de las actividades del establecimiento.</td>
      <td width=284 height="45" valign=baseline><p >Nombre del apoderado</p>
     </td>
    </tr>
    <tr>
      <td valign=baseline><p>Firma</p>
        <p>&nbsp;</p></td>
    </tr>
    <tr>
      <td valign=baseline><p>Fecha Matr&iacute;cula</p>
        <p>&nbsp;</p></td>
    </tr>
  </table>
  </td></tr></table>
</div>
</body>
</html>
