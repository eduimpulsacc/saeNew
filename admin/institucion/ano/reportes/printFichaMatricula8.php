<?php 
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/

require('../../../../util/header.inc'); 
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
$institucion= $_INSTIT;
$ano			= $_ANO;

$rut_alumno=$alumno;
$id_curso=$cmb_curso;

$ob_reporte = new Reporte();
$ob_institucion = new Membrete();
	$ob_institucion -> ano =$ano;
	$ob_institucion -> institucion =$institucion;
	$ob_institucion -> institucion($conn);

$ob_reporte->ano = $ano; 
$ob_reporte->AnoEscolar($conn);
$nro_ano = $ob_reporte->nro_ano;
	
	
$sql_ense="select ensenanza,bool_jor from curso where id_curso=$id_curso";	

$rs_ense=pg_exec($conn,$sql_ense);
$ense = pg_result($rs_ense,0);

switch(pg_result($rs_ense,1)){
case 1:
$jornada ="Ma&ntilde;ana";
break;
case 2:
$jornada ="Tarde";
break;
case 3:
$jornada ="Ma&ntilde;ana y Tarde";
break;
case 4:
$jornada ="Vespertino";
break;
}

$Curso_pal = CursoPalabra($id_curso, 0, $conn);

if ($rut_alumno!=0){
	$ob_reporte->ano = $ano; 
	$ob_reporte->alumno = $rut_alumno;
	$result_home=$ob_reporte->FichaAlumnoUno_fichamat($conn);
	$fila = pg_fetch_array($result_home,0);
}



?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<style>
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:11px;
}
</style>
</head>
<script language="javascript1.1" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<!--tabla contenedora-->
<body>
<? if ((pg_numrows($result_home)>0) ){
	
	$fila=pg_fetch_array($result_home);
$ob_reporte->CambiaDato($fila);
	?>
<div id="capa0">
<table width="650" align="center">
  <tr>
    <td><input name="button4" type="button" class="botonXX" onclick="window.location='nueva_ficha3.php'"   value="CERRAR" /></td>
    <td align="right"><input name="button3" type="button" class="botonXX"  value="IMPRIMIR" onclick="javascript:imprimir()" />
     </td>
  </tr>
</table>
</div>
<?php }?>
<table width=650 border=1 align="center" cellpadding=0 cellspacing=0 style="border-collapse:collapse">
    <tr>
      <td width="217" align="center"  class="textonegrita"><br />
<?
						if($institucion!=""){
							echo "<img src='../../../../tmp/".$institucion."insignia". "' width='50%' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?><br />
        &nbsp;<?=$ob_institucion->ins_pal;?><br />
        <b>  &nbsp; RBD <?=$ob_institucion->rrdb;?></b></td>
      <td width="125"  valign=top>&nbsp;<b>Año<br />
      </b>
        &nbsp;Nº Matrícula<br />
&nbsp;Fecha Ingreso<br />
&nbsp;Jornada<br />
&nbsp;Curso</td>
      <td width="187"  valign=top>&nbsp;<?php echo $nro_ano ?><br />
       &nbsp;<?=$ob_reporte->num_matricula;?>
        <br />
       &nbsp;<?=impF($ob_reporte->fecha_matricula);?>
        <br />
         &nbsp;<?php echo $jornada; ?>
         <br />
		&nbsp;<?php echo $Curso_pal; ?></td>
      <td width="111" colspan=2 valign="middle" align="center"><img src="../../../../infousuario/images/<?php echo $ob_reporte->alumno ?>" width="130" height="130" /></td>
    </tr>
    </table>
<table width=650 border=1 align="center" cellpadding=0 cellspacing=0 style="border-collapse:collapse">
    <tr>
      <td colspan="6" align="center"  valign=top><b>FICHA
          DE MATRICULA</b></td>
    </tr>
    <tr>
      <td colspan="4"  valign=top><b>IDENTIFICACIÓN
          DEL ALUMNO</b></td>
      <td colspan="2"  valign=top>RUT: <?=$ob_reporte->rut_alumno;?>  </td>
    </tr>
    <tr>
      <td colspan="6"  valign=top>NOMBRE: <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->nombre)));?> <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->ape_pat))); ?> <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->ape_mat)));?>
      </td>
    </tr>
    <tr>
      <td colspan="4" valign=top>FECHA
      DE NACIMIENTO: <?php impF($ob_reporte->fecha_nacimiento);?></td>
      <td valign=top colspan="2">

<!--// Comprobamos si hay algún año bisiesto. 86400 segundos es un dias
//$fInicio = $ob_reporte->fecha_nacimiento;-->


      EDAD
      AL 31 DE MARZO: <?php echo edadAnoMes($ob_reporte->fecha_nacimiento,$nro_ano."-03-31"); ?></td>
    </tr>
    <tr>
      <td colspan="4"  valign=top>DIRECCIÓN:
      <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->direccion_alu)));?>
		<? if (trim($ob_reporte->depto)!="" && trim($ob_reporte->depto)!="-"){
			echo "DPTO $ob_reporte->depto";
		}?>
		<? if (trim($ob_reporte->block)!="" && trim($ob_reporte->block)!="-"){
			echo "&nbsp;BLOCK $ob_reporte->block";
		}?>
	  <? if (trim($ob_reporte->villa)!=""  && trim($ob_reporte->villa)!="-"){
			echo "&nbsp;VILLA $ob_reporte->villa";
		}?>
         <? if (trim($ob_reporte->sector)!=""  && trim($ob_reporte->sector)!="-"){
			echo "&nbsp;SECTOR $ob_reporte->sector";
		}?>
        </td>
      <td  valign=top colspan="2">COMUNA:
      <?=$ob_reporte->comuna;?></td>
    </tr>
    <tr>
      <td colspan="4" valign=top>ENFERMEDADES
          CRÓNICAS:
        <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->enfermedad)));?>      </td>
      <td colspan="2" valign=top>ALERGIAS
          ALIMENTOS:
        <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->alergia)));?></td>
    </tr>
    <tr>
      <td  colspan="2"  valign=top><b>ANTECEDENTES
          FAMILIARES:</b></td>
      <td  valign=top colspan="4">
      
      ESTADO
      CIVIL DE LOS PADRES: <?php  echo $ob_reporte->estado_padres?></td>
    </tr>
    <tr>
     <?php 
 $rs_padre=$ob_reporte->Padre($conn);
   
    $fila_padre = @pg_fetch_array($rs_padre,0);
	
		$ob_reporte->CambiaDatoApo($fila_padre);
		
		
		$nombre_padre    = $fila_padre['nombre_apo'];
		$paterno_padre   = $fila_padre['ape_pat'];
		$materno_padre   = $fila_padre['ape_mat'];
		$rut_padre       = $fila_padre['rut_apo'];
		$dig_rut_padre   = $fila_padre['dig_rut'];
		$fechanac_padre   = $fila_padre['fecha_nac'];
		$direccion_padre   = $fila_padre['calle']." ".$fila_padre['nro'];
		$telefono_padre   = $fila_padre['telefono'];

		$ultimo_ano_padre    = $fila_padre['ultimo_ano_aprobado'];
		
		$ocupacion_padre     = $fila_padre['ocupacion'];
   
   
   ?>
   <?php 
 $rs_madre=$ob_reporte->Madre($conn);
   
    $fila_madre = @pg_fetch_array($rs_madre,0);
	
		$ob_reporte->CambiaDatoApo($fila_madre);
		
		
		$nombre_madre    = $fila_madre['nombre_apo'];
		$paterno_madre   = $fila_madre['ape_pat'];
		$materno_madre   = $fila_madre['ape_mat'];
		$rut_madre       = $fila_madre['rut_apo'];
		$dig_rut_madre   = $fila_madre['dig_rut'];
		$fechanac_madre   = $fila_madre['fecha_nac'];
		$direccion_madre   = $fila_madre['calle']." ".$fila_madre['nro'];
		$telefono_madre   = $fila_madre['telefono'];

		$ultimo_ano_madre    = $fila_madre['ultimo_ano_aprobado'];
		
		$ocupacion_madre     = $fila_madre['ocupacion'];
		$primer_parto_madre     = $fila_madre['edad_primer_parto'];
   
   
   ?>
      <td  valign=top colspan="4">NOMBRE
       PADRE: <?php echo "$nombre_padre $paterno_padre $materno_padre" ?></td>
      <td  valign=top colspan="2">EDAD: <?php echo edad($fechanac_padre) ?>
      </td>
    </tr>
    <tr>
      <td  valign=top colspan="4">OCUPACIÓN: <?php echo $ocupacion_padre ?></td>
      <td  valign=top colspan="2">ESCOLARIDAD:<?php echo $ultimo_ano_padre ?></td>
    </tr>
    <tr>
      <td  valign=top colspan="4">DIRECCIÓN: <?php echo $direccion_padre ?>
      </td>
      <td  valign=top colspan="2">TELÉFONO:
      <?php echo $telefono_padre ?></td>
    </tr>
    <tr>
      <td  valign=top colspan="4">NOMBRE
       MADRE: <?php echo "$nombre_madre $paterno_madre $materno_madre" ?></td>
      <td valign=top colspan="2">EDAD:<?php echo edad($fechanac_madre) ?> </td>
    </tr>
    <tr>
      <td  valign=top colspan="4">OCUPACIÓN: <?php echo $ocupacion_madre ?></td>
      <td  valign=top colspan="2">ESCOLARIDAD:
      <?php echo $ultimo_ano_madre ?></td>
    </tr>
    <tr>
      <td  valign=top colspan="4">DIRECCIÓN:
      <?php echo $direccion_madre ?></td>
      <td  valign=top colspan="2">TELÉFONO:
      <?php echo $telefono_madre ?></td>
    </tr>
    <tr>
      <td  valign=top colspan="4">Nº
      DE HERMANOS: 
      <?=$ob_reporte->cant_hermanos;?></td>
      <td  valign=top colspan="2">LUGAR
          QUE OCUPA:  <?=$ob_reporte->num_hermano;?></td>
    </tr>
    <tr>
      <td  valign=top colspan="6">PERSONAS
      CON QUIEN VIVE: 
      <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->con_quien_vive)));?>
      </td>
    </tr>
    <tr>
    <?php 
   
   $ob_reporte->responsable=1; 
   $rs_apo=$ob_reporte->Apoderado($conn);
   
   $fila_apo = @pg_fetch_array($rs_apo,0);
		$ob_reporte->CambiaDatoApo($fila_apo);
		$sexo_apo      = $fila_apo['sexo'];
		$nombre_apo    = $fila_apo['nombre_apo'];
		$paterno_apo   = $fila_apo['ape_pat'];
		$materno_apo   = $fila_apo['ape_mat'];
		$rut_apo       = $fila_apo['rut_apo']."-". $fila_apo['dig_rut'];
		
		$direccion_apo   = $fila_apo['calle']." ".$fila_apo['nro'];
		$nro_apo       = $fila_apo['nro'];
		$telefono_apo  = $fila_apo['telefono'];
		$celular_apo   = $fila_apo['celular'];
		$email_apo     = $fila_apo['email'];
		$parentezco_apo     = $fila_apo['relacion'];
		$fechanac_apo     = $fila_apo['fecha_nac'];
		$ocupacion_apo     = $fila_apo['ocupacion']; 
		$ultimo_ano_apo    = $fila_apo['ultimo_ano_aprobado'];
		$email_apo    = $fila_apo['email'];
		
		
		$comuna_apo     = $fila_apo['comuna_apo'];
		
		$calle_apo=  $fila_apo['calle']." ".$fila_apo['nro'];;
		
		//var_dump($fil_1);
   ?>
      <td c valign=top colspan="4">NOMBRE
      DEL APODERADO: <?php echo $nombre_apo ?> <?php echo $paterno_apo ?> <?php echo $materno_apo ?></td>
      <td  valign=top colspan="2">EDAD: <?php echo edad($ob_reporte->fecha_nac_apo) ?>
      </td>
    </tr>
    <tr>
      <td  valign=top colspan="4">PARENTESCO:
      <?php  if ($fila_apo['relacion']==1) $relacion = "PADRE";
						if ($fila_apo['relacion']==2) $relacion = "MADRE";
						if ($fila_apo['relacion']==3) $relacion = "OTROS"; ?>
       <?php echo $relacion ?></td>
      <td  valign=top colspan="2">RUT: <?php echo $rut_apo ?></td>
    </tr>
    <tr>
      <td  valign=top colspan="4">OCUPACIÓN:  <?php echo $ocupacion_apo ?></td>
      <td  valign=top colspan="2">ESCOLARIDAD:  <?php echo $ultimo_ano_apo ?></td>
    </tr>
    <tr>
      <td  valign=top colspan="4">DIRECCIÓN: <?php echo $direccion_apo ?></td>
      <td valign=top colspan="2">TELÉFONO:  <?php echo $telefono_apo ?> </td>
    </tr>
    <tr>
      <td  valign=top colspan="6">CORREO
          ELECTRÓNICO:  <?php echo $email_apo ?></td>
    </tr>
    <tr>
      <td  valign=top colspan="6"><b>AUTORIZACIONES</b></td>
    </tr>
    <tr>
      <td width="182" >Cambiar de
          ropa en caso de ser necesario</td>
      <td width="79" align="center" ><?php echo $ob_reporte->bool_cambioropa ?></td>
      <td width="99" >Tomar fotografías/videos
          en actividades escolares</td>
      <td width="55" align="center" ><?php echo $ob_reporte->bool_tomafoto ?></td>
      <td width="139" >Compartir
          fotografías en facebook Escuela</td>
      <td width="82" align="center" ><?php echo $ob_reporte->bool_facebook ?></td>
    </tr>
    <tr>
      <td colspan="6"  valign=top>RETIRAR
          AL ALUMNO:</td>
    </tr>
    <tr>
      <td valign=top colspan="3">PROCEDENCIA: 
        <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->proced_alumno)));?>
      </td>
      <td  valign=top colspan="3">ELECCIÓN:
      </td>
    </tr>
    <tr>
      <td  valign=top colspan="6"><p style='text-align:justify'>OBSERVACIONES: Al momento de
          matricular a mi pupilo/a en este establecimiento declaro haber sido
          informado, tomar conocimiento y aceptar el <b>Proyecto Educativo Institucional</b>, el <b>Reglamento de Convivencia Escolar</b> y <b>Procedimiento de acción ante Emergencia</b>.
        <p style='text-align:justify'>Me comprometo a apoyar el proceso
          educativo de mi pupilo/a, velando por el cumplimiento de la <b>asistencia a clases</b>, <b>tareas escolares</b> que le sean
          asignadas. Asistir a reuniones, entrevistas y cuando sean citado. Apoyar y
          participar de las actividades extraescolares.</td>
    </tr>
    <tr>
      <td height="77" colspan="6" align="center"  valign=top><p>&nbsp;</p>
      <p>_______________________________________<br />
Firma Apoderado&nbsp; </p></td>
    </tr>
   
   
  </table>

</body>
</html>
