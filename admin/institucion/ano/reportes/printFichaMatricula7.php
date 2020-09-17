<?php 
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

$ob_institucion->AnoEscolar($conn);	
$nro_ano=$ob_institucion->nro_ano;	
$sql_ense="select ensenanza from curso where id_curso=$id_curso";	

$rs_ense=pg_exec($conn,$sql_ense);
$ense = pg_result($rs_ense,0);

$Curso_pal = CursoPalabra($id_curso, 0, $conn);

if ($rut_alumno!=0){
	$ob_reporte->ano = $ano; 
	$ob_reporte->alumno = $rut_alumno;
	$result_home=$ob_reporte->FichaAlumnoUno_fichamat($conn);
	$fila = pg_fetch_array($result_home,0);
}else{
	$ob_reporte->ano = $ano; 
	$ob_reporte->curso = $id_curso;
	$ob_reporte->retirado = 0;
	$ob_reporte->orden=1;
	$result_home=$ob_reporte->FichaAlumnoTodos($conn);
}


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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<style>
.des{ font-size:18px}
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
<br />
<? if($rut_alumno!=0){?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%" rowspan="4"><?
						if($institucion!=""){
							echo "<img src='../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?></td>
    <td width="67%" class="textosimple">&nbsp;</td>
    <td width="13%" class="textosimple">A&ntilde;o Escolar </td>
    <td width="10%" class="textosimple">&nbsp;
      <?=$nro_ano;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="textosimple">N&ordm; Matricula </td>
    <td class="textosimple">&nbsp;
      <?=$fila['num_mat'];?></td>
  </tr>
  <tr>
    <td class="textonegrita"><div align="center">FICHA DE MATRICULA </div></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">

  <tr>
    <td colspan="6" valign="top"  class="textonegrita"><p>DATOS DEL ALUMNO</p></td>
  </tr>
  <tr>
    <td width="123" valign="top"  class="textosimple">RUT</td>
    <td valign="top" class="textosimple">&nbsp;<?=$fila['rut_alumno']."-".$fila['dig_rut'];?></td>
    <td  valign="top"  class="textosimple">EDAD</td>
    <td  valign="top" class="textosimple">&nbsp;
    
    </td>
  </tr>
  <tr>
    <td width="123" valign="top" class="textosimple">NOMBRE</td>
    <td valign="top" class="textosimple">&nbsp;<?=$fila['nombre_alu'];?></td>
    <td  valign="top" class="textosimple">APE. PATERNO</td>
     <td valign="top" class="textosimple">&nbsp;<?=$fila['ape_pat'];?></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">APE. MATERNO</td>
     <td valign="top" class="textosimple">&nbsp;<?=$fila['ape_mat'];?></td>
    <td  valign="top" class="textosimple">F.NAC</td>
     <td valign="top" class="textosimple">&nbsp;<?=$fila['fecha_nac'];?></td>
  </tr>
  <tr>
    <td width="123" valign="top" class="textosimple">SEXO</td>
    <td valign="top" class="textosimple">&nbsp;<? if($fila['sexo']==2) echo "Masculino"; else echo "Femenino";?></td>
    <td  valign="top" class="textosimple">NACIONALIDAD</td>
     <td valign="top" class="textosimple">&nbsp;<? if($fila['nacionalidad']==2) echo "Chilena"; else echo "Extranjera";?></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">HIJOS</td>
    <td valign="top"><span class="textosimple">
      &nbsp;<?=$fila['cant_hijos'];?>
    </span></td>
    <td  valign="top" class="textosimple">ESTADO CIVIL</td>
     <td valign="top" class="textosimple">&nbsp;
	 <?php 
	 
	 	switch($fila['estado_civil']){
		case 1: $ec="Soltero(a)";break;
		case 2: $ec="Casado(a)";break;
		case 3: $ec="Viudo(a)";break;
		case 4: $ec="Divorciado(a)";break;
		case 5: $ec="Otro";break;
		 default: $ec="-"; break; 
		}
		
		echo $ec;?></td>
  </tr>
  <tr>
    <td width="123" valign="top" class="textosimple">DOMICILIO</td>
     <td valign="top" class="textosimple" colspan="3">&nbsp;<?=$fila['calle']." ".$fila['nro'];?></td>
  </tr>
  <tr>
    <td width="123" valign="top" class="textosimple">COMUNA</td>
    <td width="173"  valign="top"><span class="textosimple">
     &nbsp;<?=$fila['nom_com'];?>
    </span></td>
    <td width="140" valign="top" class="textosimple">TELEFONO FIJO:</td>
    <td valign="top" class="textosimple">&nbsp;
      <?=$fila['telefono'];?></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">CELULAR</td>
    <td  valign="top"><span class="textosimple">
     &nbsp;<?=$fila['celular'];?>
    </span></td>
    <td valign="top" class="textosimple">E-MAIL</td>
    <td valign="top" class="textosimple">&nbsp;
      <?=$fila['email'];?></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">TRABAJA</td>
    <td  valign="top" class="textosimple">&nbsp;<?=($fila['bool_trabaja']==1)?"SI":"NO";?></td>
    <td valign="top" class="textosimple">LUGAR TRABAJO</td>
    <td valign="top"><span class="textosimple">&nbsp;
        <?=$fila['lugar_trabajo'];?>
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">EMBARAZADA</td>
    <td  valign="top" class="textosimple">&nbsp;<?=($fila['bool_ae']==1)?"SI":"NO";?></td>
    <td valign="top" class="textosimple">MESES</td>
    <td valign="top"><span class="textosimple">&nbsp;
        <?=$fila['txt_mesembarazo'];?>
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">ETNIA</td>
    <td  valign="top">&nbsp;<?=$fila['txt_etnia'];?></td>
    <td valign="top" class="textosimple">VIVE CON</td>
    <td valign="top"><span class="textosimple">&nbsp;
        <?=$fila['con_quien_vive'];?>
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">ESTUDIO A&Ntilde;O ANTERIOR</td>
    <td  valign="top" class="textosimple">&nbsp;<?=($fila['bool_estudio_anoant']==1)?"SI":"NO";?></td>
    <td valign="top" class="textosimple">A&Ntilde;OS REPETIDOS</td>
    <td valign="top"><span class="textosimple">&nbsp;
        <?=$fila['txt_anosrepetidos'];?>
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">A&Ntilde;OS RETIRADOS</td>
    <td  valign="top">&nbsp;<?=$fila['txt_anosretiro'];?></td>
    <td valign="top" class="textosimple">CAUSA</td>
    <td valign="top"><span class="textosimple">&nbsp;
       <?=$fila['txt_causaretiroant'];?>
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">ESTUDIOS DEL PADRE</td>
    <td  valign="top"><span class="textosimple">
      &nbsp;<?=$fila['nivel_edu_padre'];?>
    </span></td>
    <td valign="top" class="textosimple">ESTUDIOS DE LA MADRE</td>
    <td valign="top"><span class="textosimple">
      &nbsp;<?=$fila['nivel_edu_madre'];?>
    </span></td>
  </tr>
</table>
<br />
<?
	
		$ob_reporte ->responsable=1;
		$resultado = $ob_reporte->Apoderado($conn);
		$fila_apo = @pg_fetch_array($resultado,0);
		$ob_reporte->CambiaDatoApo($fila_apo);
/*	$sql_1 = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno = '$rut_alumno' and responsable='1')";
	$res_1 = @pg_Exec($conn, $sql_1);
	$num_1 = @pg_numrows($res_1);
	$fil_1 = @pg_fetch_array($res_1);
	*/	
	$sexo_apo      = $fil_1['sexo'];
	
	$nombre_apo    = $fil_1['nombre_apo'];
	$paterno_apo   = $fil_1['ape_pat'];
	$materno_apo   = $fil_1['ape_mat'];
	$rut_apo       = $fil_1['rut_apo'];
	$dig_rut_apo   = $fil_1['dig_rut'];
	$direccion_apo = $fil_1['direccion'];
	$nro_apo       = $fil_1['nro'];
	$telefono_apo  = $fil_1['telefono'];
	$celular_apo   = $fil_1['celular'];
	$email_apo     = $fil_1['email'];
		
	?>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">

  <tr>
    <td colspan="4" class="textonegrita"><p>DATOS APODERADO<br />
    </p></td>
  </tr>
  <tr>
    <td width="203" class="textosimple">NOMBRE CASO EMERGENCIA</td>
    <td width="246"><span class="textosimple">
      &nbsp;<?=$fila['txt_contactoemergencia'];?>
    </span></td>
    <td width="50" class="textosimple">FONO</td>
    <td width="123"><span class="textosimple">
      &nbsp;<?=$fila['txt_fonocontactoemergencia'];?>
    </span></td>
  </tr>
  <tr>
    <td class="textosimple">NOMBRE APODERADO /TUTOR</td>
    <td>&nbsp;<? if ($ob_reporte->nombre_apo!=NULL){ echo $ob_reporte->ape_nombre_apo; }else{ ?>  <? } ?></td>
    <td class="textosimple">FONO</td>
    <td>&nbsp;<? if ($ob_reporte->telefono_apo!=NULL){ echo $ob_reporte->telefono_apo; }else{ ?>  <? } ?></td>
  </tr>
  <tr>
    <td class="textosimple">DOMICILIO</td>
    <td colspan="3">&nbsp;<? if ($ob_reporte->direccion!=NULL){ echo $ob_reporte->direccion; }else{ ?>  <? } ?></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">

  <tr>
    <td colspan="4" class="textonegrita"><p>DATOS DE SALUD</p></td>
  </tr>
  <tr>
    <td width="183" class="textosimple">PROBLEMA APRENDIZAJE</td>
    <td width="84" class="textosimple">&nbsp;<?php echo ($fila['bool_tastornosaprendizaje']==1)?"SI":"NO"; ?></td>
    <td width="115" class="textosimple">TIPO PROBLEMA</td>
    <td width="240" class="textosimple">&nbsp;<?php echo $fila[txt_tastornosaprendizaje] ?></td>
  </tr>
  <tr>
    <td class="textosimple">ENFERMEDAD CR&Oacute;NICA</td>
    <td class="textosimple">&nbsp;<?php echo (strlen($fila['enfermedad'])>0)?"SI":"NO"; ?></td>
    <td class="textosimple">TIPO ENFERMEDAD</td>
    <td class="textosimple"><?php echo (strlen($fila['enfermedad'])>0)?$fila['enfermedad']:""; ?></td>
  </tr>
  <tr>
    <td class="textosimple">TRATAMIENTO PSICOL&Oacute;GICO</td>
    <td class="textosimple">&nbsp;<?php echo (strlen($fila['bool_psicologo'])==1)?"SI":"NO"; ?></td>
    <td class="textosimple">CENTRO DE ATENCI&Oacute;N</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">POSEE DISCAPACIDAD</td>
    <td class="textosimple">&nbsp;<?php echo (strlen($fila['bool_discapacidad'])==1)?"SI":"NO"; ?></td>
    <td class="textosimple">TIPO</td>
    <td class="textosimple"><table width="100%" border="0">
      <tr>
        <td>VISUAL </td>
        <td><input type="checkbox" name="checkbox9" id="checkbox15" /></td>
        <td>MOTRIZ </td>
        <td><input type="checkbox" name="checkbox10" id="checkbox16" /></td>
      </tr>
      <tr>
        <td>TGD </td>
        <td><input type="checkbox" name="checkbox14" id="checkbox20" /></td>
        <td>AUDITIVA </td>
        <td><input type="checkbox" name="checkbox12" id="checkbox18" /></td>
      </tr>
      <tr>
        <td>INTELECTUAL</td>
        <td><input type="checkbox" name="checkbox11" id="checkbox17" /></td>
        <td>OTRAS </td>
        <td><input type="checkbox" name="checkbox13" id="checkbox19" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="textosimple">CARNET DISCAPACIDAD</td>
    <td class="textosimple">&nbsp;<?php echo (strlen($fila['bool_carnetdiscapacidad'])==1)?"SI":"NO"; ?></td>
    <td class="textosimple">REQUIERE EX&Aacute;MEN DE VALIDACI&Oacute;N DE ESTUDIOS</td>
    <td class="textosimple">&nbsp;<?php echo (strlen($fila['bool_examenvalidacion'])==1)?"SI":"NO"; ?></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">

  <tr>
    <td colspan="4" class="textonegrita"><p>BENEFICIOS<br />
    </p></td>
  </tr>
  <tr>
    <td class="textosimple">PROYECTO INTEGRACI&Oacute;N</td>
    <td class="textosimple"><? if($fila['bool_integracion']==1) echo "SI"; else echo "NO";?>&nbsp;</td>
    <td class="textosimple">FICHA PROTECCION SOCIAL</td>
    <td class="textosimple">&nbsp;<?php echo (strlen($fila['txt_fichaps'])>4)?$fila['txt_fichaps']:"N/A" ?></td>
  </tr>
  <tr>
    <td class="textosimple">BECA JUNAEB</td>
    <td class="textosimple"><? if($fila['bool_juaneb']==1) echo "SI"; else echo "NO";?></td>
    <td class="textosimple">PROGRAMAS SOCIALES</td>
    <td><table width="100%" border="0">
      <tr>
        <td class="textosimple">CHILE CRECE CONTIGO</td>
        <td class="textosimple"><? if($fila['bool_ccc']==1) echo "SI"; else echo "NO";?>&nbsp;</td>
      </tr>
      <tr>
        <td class="textosimple">PROGRAMA PUENTE</td>
        <td class="textosimple"><? if($fila['ben_puente']==1) echo "SI"; else echo "NO";?></td>
      </tr>
      <tr>
        <td class="textosimple">CHILE SOLIDARIO</td>
        <td class="textosimple"><? if($fila['bool_bchs']==1) echo "SI"; else echo "NO";?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="textosimple">PROGRAMAS JUDICIALES</td>
    <td class="textosimple"><table width="100%" border="0">
      <tr>
        <td class="textosimple">SENAME</td>
        <td class="textosimple"><? if($fila['bool_sename']==1) echo "SI"; else echo "NO";?>&nbsp;</td>
      </tr>
      <tr>
        <td class="textosimple">SERNAM</td>
        <td class="textosimple"><? if($fila['bool_sernam']==1) echo "SI"; else echo "NO";?></td>
      </tr>
    </table></td>
    <td class="textosimple">PROGRAMAS DE SALUD</td>
    <td class="textosimple"><table width="100%" border="0">
      <tr>
        <td class="textosimple">VIOLENCIA FAMILIAR</td>
        <td class="textosimple"><? if($fila['bool_vf']==1) echo "SI"; else echo "NO";?>&nbsp;</td>
      </tr>
      <tr>
        <td class="textosimple">SALUD MENTAL</td>
        <td class="textosimple"><? if($fila['bool_saludmental']==1) echo "SI"; else echo "NO";?></td>
      </tr>
      <tr>
        <td class="textosimple">CONSUMO DROGAS</td>
        <td class="textosimple"><? if($fila['bool_drogas']==1) echo "SI"; else echo "NO";?></td>
      </tr>
    </table></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="textonegrita"><p>DOCUMENTOS</p></td>
  </tr>
  <tr>
    <td class="textosimple">CERTIFICADO NACIMIENTO</td>
    <td align="center" class="textosimple"><? if($fila['bool_traecertificados']==1) echo "SI"; else echo "NO";?></td>
    <td class="textosimple">CERTIFICADO DE NOTAS</td>
    <td align="center" class="textosimple"><? if($fila['bool_traecertificadosant']==1) echo "SI"; else echo "NO";?></td>
  </tr>
  <tr>
    <td class="textosimple">AUTOR. SECREMINEDUC</td>
    <td align="center" class="textosimple"><? if($fila['bool_secreduc']==1) echo "SI"; else echo "NO";?></td>
    <td class="textosimple">NIVEL</td>
    <td align="center" class="textosimple"><? echo (strlen($fila['nivel_certificado'])>0) ? "SI": "NO";?></td>
  </tr>
  <tr>
    <td class="textosimple">PLAZO FECHA</td>
    <td align="center" class="textosimple"><? echo (strlen($fila['plazo_autorizacion'])>0) ? "SI": "NO";?></td>
    <td class="textosimple">MANUAL DE CONVIVENCIA</td>
    <td align="center" class="textosimple"><? if($fila['bool_manualconvivencia']==1) echo "SI"; else echo "NO";?></td>
  </tr>
  <tr>
    <td class="textosimple">APORTE VOLUNTARIO CCA</td>
    <td align="center" class="textosimple"><? echo (strlen($fila['txtaporteCGP'])>0) ? "SI": "NO";?></td>
    <td class="textosimple">PAGO MATRICULA</td>
    <td align="center" class="textosimple"><? if($fila['bool_pagomatricula']==1) echo "SI"; else echo "NO";?></td>
  </tr>
</table>
<br />
<br />
<br />
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla04">
  <tr>
    <td><div align="right">______________________________</div></td>
  </tr>
  <tr>
    <td><div align="right">FIRMA APODERADO </div></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center" cellpadding="2" cellspacing="0" class="tabla04">
  <tr>
    <td width="154">FECHA MATRICULA </td>
    <td width="496">_______________________________</td>
  </tr>
  <tr>
    <td>FECHA RETIRO </td>
    <td>_______________________________</td>
  </tr>
  <tr>
    <td>MOTIVO RETIRO </td>
    <td>_____________________________________________________________</td>
  </tr>
  <tr>
    <td colspan="2">___________________________________________________________________________________</td>
  </tr>
</table>
<? }else{
		for($i=0;$i<pg_numrows($result_home);$i++){
			$fila= pg_fetch_array($result_home,$i);
			
			$edad = date("Y-m-d") - $fila['fecha_nac'];
?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="10%" rowspan="4"><?
						if($institucion!=""){
							echo "<img src='../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?></td>
    <td width="67%" class="textosimple">&nbsp;</td>
    <td width="13%" class="textosimple">A&ntilde;o Escolar </td>
    <td width="10%" class="textosimple">&nbsp;<?=$nro_ano;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="textosimple">N&ordm; Matricula </td>
    <td class="textosimple">&nbsp;<?=$fila['num_mat'];?></td>
  </tr>
  <tr>
    <td class="textonegrita"><div align="center">FICHA DE MATRICULA </div></td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="6" valign="top"  class="textonegrita"><p>DATOS DEL ALUMNO</p></td>
  </tr>
  <tr>
    <td width="123" valign="top"  class="textosimple">RUT</td>
    <td valign="top" class="textosimple">&nbsp;<?=$fila['rut_alumno']."-".$fila['dig_rut'];?></td>
    <td  valign="top"  class="textosimple">EDAD</td>
    <td  valign="top" class="textosimple">&nbsp;<?=$edad;?></td>
  </tr>
  <tr>
    <td width="123" valign="top" class="textosimple">NOMBRE</td>
    <td valign="top" class="textosimple">&nbsp;<?=$fila['nombre_alu'];?></td>
    <td  valign="top" class="textosimple">APE. PATERNO</td>
     <td valign="top" class="textosimple">&nbsp;<?=$fila['ape_pat'];?></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">APE. MATERNO</td>
     <td valign="top" class="textosimple">&nbsp;<?=$fila['ape_mat'];?></td>
    <td  valign="top" class="textosimple">F.NAC</td>
     <td valign="top" class="textosimple">&nbsp;<?=$fila['fecha_nac'];?></td>
  </tr>
  <tr>
    <td width="123" valign="top" class="textosimple">SEXO</td>
    <td valign="top" class="textosimple">&nbsp;<? if($fila['sexo']==2) echo "Masculino"; else echo "Femenino";?></td>
    <td valign="top" class="textosimple">NACIONALIDAD</td>
    <td valign="top" class="textosimple">&nbsp;<? if($fila['nacionalidad']==2) echo "Chilena"; else echo "Extranjera";?></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">HIJOS</td>
    <td valign="top" class="textosimple">&nbsp;<?=$fila['cant_hijos'];?></td>
    <td valign="top" class="textosimple">ESTADO CIVIL</td>
    <td valign="top" class="textosimple">&nbsp;
    <?php 
	 
	 	switch($fila['estado_civil']){
		case 1: $ec="Soltero(a)";break;
		case 2: $ec="Casado(a)";break;
		case 3: $ec="Viudo(a)";break;
		case 4: $ec="Divorciado(a)";break;
		case 5: $ec="Otro";break;
		 default: $ec="-"; break; 
		}
		
		echo $ec;?></td>
  </tr>
  <tr>
    <td width="123" valign="top" class="textosimple">DOMICILIO</td>
    <td valign="top" class="textosimple" colspan="3">&nbsp;<?=$fila['calle']." ".$fila['nro'];?></td>
  </tr>
  <tr>
    <td width="123" valign="top" class="textosimple">COMUNA</td>
    <td width="173"  valign="top" class="textosimple">&nbsp;<?=$fila['nom_com'];?></td>
    <td width="140" valign="top" class="textosimple">TELEFONO FIJO:</td>
    <td valign="top" class="textosimple">&nbsp;
      <?=$fila['telefono'];?></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">CELULAR</td>
    <td valign="top" class="textosimple">&nbsp;<?=$fila['celular'];?></td>
    <td valign="top" class="textosimple">E-MAIL</td>
    <td valign="top" class="textosimple">&nbsp;
      <?=$fila['email'];?></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">TRABAJA</td>
    <td  valign="top" class="textosimple">&nbsp;<?=($fila['bool_trabaja']==1)?"SI":"NO";?></td>
    <td valign="top" class="textosimple">LUGAR TRABAJO</td>
    <td valign="top"><span class="textosimple">&nbsp;
      <?=$fila['lugar_trabajo'];?>
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">EMBARAZADA</td>
    <td  valign="top" class="textosimple">&nbsp;<?=($fila['bool_ae']==1)?"SI":"NO";?></td>
    <td valign="top" class="textosimple">MESES</td>
    <td valign="top"><span class="textosimple">&nbsp;
      <?=$fila['txt_mesembarazo'];?>
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">ETNIA</td>
    <td  valign="top">&nbsp;<?=$fila['txt_etnia'];?></td>
    <td valign="top" class="textosimple">VIVE CON</td>
    <td valign="top"><span class="textosimple">&nbsp;
      <?=$fila['con_quien_vive'];?>
    </span></td>
  </tr>

  <tr>
    <td valign="top" class="textosimple">ESTUDIO A&Ntilde;O ANTERIOR</td>
    <td  valign="top" class="textosimple">&nbsp;<?=($fila['bool_estudio_anoant']==1)?"SI":"NO";?></td>
    <td valign="top" class="textosimple">A&Ntilde;OS REPETIDOS</td>
    <td valign="top"><span class="textosimple">&nbsp;
      <?=$fila['txt_anosrepetidos'];?>
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">A&Ntilde;OS RETIRADOS</td>
    <td valign="top" class="textosimple">&nbsp;<?=$fila['txt_anosretiro'];?></td>
    <td valign="top" class="textosimple">CAUSA</td>
    <td valign="top"><span class="textosimple">&nbsp;
      <?=$fila['txt_causaretiroant'];?>
    </span></td>
  </tr>
  <tr>
    <td valign="top" class="textosimple">ESTUDIOS DEL PADRE</td>
    <td valign="top" class="textosimple">&nbsp;<?=$fila['nivel_edu_padre'];?></td>
    <td valign="top" class="textosimple">ESTUDIOS DE LA MADRE</td>
    <td valign="top"><span class="textosimple"> &nbsp;
      <?=$fila['nivel_edu_madre'];?>
    </span></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="textonegrita"><p>DATOS APODERADO<br />
    </p></td>
  </tr>
  <tr>
    <td width="203" class="textosimple">NOMBRE CASO EMERGENCIA</td>
    <td width="246"><span class="textosimple">
      &nbsp;<?=$fila['txt_contactoemergencia'];?>
    </span></td>
    <td width="50" class="textosimple">FONO</td>
    <td width="123"><span class="textosimple">
      &nbsp;<?=$fila['txt_fonocontactoemergencia'];?>
    </span></td>
  </tr>
  <tr>
    <td class="textosimple">NOMBRE APODERADO /TUTOR</td>
    <td>&nbsp;<? if ($ob_reporte->nombre_apo!=NULL){ echo $ob_reporte->ape_nombre_apo; }else{ ?>
      <? } ?></td>
    <td class="textosimple">FONO</td>
    <td>&nbsp;<? if ($ob_reporte->telefono_apo!=NULL){ echo $ob_reporte->telefono_apo; }else{ ?>
      <? } ?></td>
  </tr>
  <tr>
    <td class="textosimple">DOMICILIO</td>
    <td colspan="3">&nbsp;
      <? if ($ob_reporte->direccion!=NULL){ echo $ob_reporte->direccion; }else{ ?>
      <? } ?></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="textonegrita"><p>DATOS DE SALUD</p></td>
  </tr>
  <tr>
    <td width="183" class="textosimple">PROBLEMA APRENDIZAJE</td>
    <td width="84" class="textosimple">&nbsp;<?php echo ($fila['bool_tastornosaprendizaje']==1)?"SI":"NO"; ?></td>
    <td width="115" class="textosimple">TIPO PROBLEMA</td>
    <td width="240" class="textosimple">&nbsp;<?php echo $fila[txt_tastornosaprendizaje] ?></td>
  </tr>
  <tr>
    <td class="textosimple">ENFERMEDAD CR&Oacute;NICA</td>
    <td class="textosimple">&nbsp;<?php echo (strlen($fila['enfermedad'])>0)?"SI":"NO"; ?></td>
    <td class="textosimple">TIPO ENFERMEDAD</td>
    <td class="textosimple"><?php echo (strlen($fila['enfermedad'])>0)?$fila['enfermedad']:""; ?></td>
  </tr>
  <tr>
    <td class="textosimple">TRATAMIENTO PSICOL&Oacute;GICO</td>
    <td class="textosimple">&nbsp;<?php echo (strlen($fila['bool_psicologo'])==1)?"SI":"NO"; ?></td>
    <td class="textosimple">CENTRO DE ATENCI&Oacute;N</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple">POSEE DISCAPACIDAD</td>
    <td class="textosimple">&nbsp;<?php echo (strlen($fila['bool_discapacidad'])==1)?"SI":"NO"; ?></td>
    <td class="textosimple">TIPO</td>
    <td class="textosimple"><table width="100%" border="0">
      <tr>
        <td>VISUAL </td>
        <td><input type="checkbox" name="checkbox" id="checkbox" /></td>
        <td>MOTRIZ </td>
        <td><input type="checkbox" name="checkbox" id="checkbox2" /></td>
      </tr>
      <tr>
        <td>TGD </td>
        <td><input type="checkbox" name="checkbox" id="checkbox3" /></td>
        <td>AUDITIVA </td>
        <td><input type="checkbox" name="checkbox" id="checkbox4" /></td>
      </tr>
      <tr>
        <td>INTELECTUAL</td>
        <td><input type="checkbox" name="checkbox" id="checkbox5" /></td>
        <td>OTRAS </td>
        <td><input type="checkbox" name="checkbox" id="checkbox6" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="textosimple">CARNET DISCAPACIDAD</td>
    <td class="textosimple">&nbsp;<?php echo (strlen($fila['bool_carnetdiscapacidad'])==1)?"SI":"NO"; ?></td>
    <td class="textosimple">REQUIERE EX&Aacute;MEN DE VALIDACI&Oacute;N DE ESTUDIOS</td>
    <td class="textosimple">&nbsp;<?php echo (strlen($fila['bool_examenvalidacion'])==1)?"SI":"NO"; ?></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="textonegrita"><p>BENEFICIOS<br />
    </p></td>
  </tr>
  <tr>
    <td class="textosimple">PROYECTO INTEGRACI&Oacute;N</td>
    <td class="textosimple"><? if($fila['bool_integracion']==1) echo "SI"; else echo "NO";?>
      &nbsp;</td>
    <td class="textosimple">FICHA PROTECCION SOCIAL</td>
    <td class="textosimple">&nbsp;<?php echo (strlen($fila['txt_fichaps'])>4)?$fila['txt_fichaps']:"N/A" ?></td>
  </tr>
  <tr>
    <td class="textosimple">BECA JUNAEB</td>
    <td class="textosimple"><? if($fila['bool_juaneb']==1) echo "SI"; else echo "NO";?></td>
    <td class="textosimple">PROGRAMAS SOCIALES</td>
    <td><table width="100%" border="0">
      <tr>
        <td class="textosimple">CHILE CRECE CONTIGO</td>
        <td class="textosimple"><? if($fila['bool_ccc']==1) echo "SI"; else echo "NO";?>
          &nbsp;</td>
      </tr>
      <tr>
        <td class="textosimple">PROGRAMA PUENTE</td>
        <td class="textosimple"><? if($fila['ben_puente']==1) echo "SI"; else echo "NO";?></td>
      </tr>
      <tr>
        <td class="textosimple">CHILE SOLIDARIO</td>
        <td class="textosimple"><? if($fila['bool_bchs']==1) echo "SI"; else echo "NO";?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td class="textosimple">PROGRAMAS JUDICIALES</td>
    <td class="textosimple"><table width="100%" border="0">
      <tr>
        <td class="textosimple">SENAME</td>
        <td class="textosimple"><? if($fila['bool_sename']==1) echo "SI"; else echo "NO";?>
          &nbsp;</td>
      </tr>
      <tr>
        <td class="textosimple">SERNAM</td>
        <td class="textosimple"><? if($fila['bool_sernam']==1) echo "SI"; else echo "NO";?></td>
      </tr>
    </table></td>
    <td class="textosimple">PROGRAMAS DE SALUD</td>
    <td class="textosimple"><table width="100%" border="0">
      <tr>
        <td class="textosimple">VIOLENCIA FAMILIAR</td>
        <td class="textosimple"><? if($fila['bool_vf']==1) echo "SI"; else echo "NO";?>
          &nbsp;</td>
      </tr>
      <tr>
        <td class="textosimple">SALUD MENTAL</td>
        <td class="textosimple"><? if($fila['bool_saludmental']==1) echo "SI"; else echo "NO";?></td>
      </tr>
      <tr>
        <td class="textosimple">CONSUMO DROGAS</td>
        <td class="textosimple"><? if($fila['bool_drogas']==1) echo "SI"; else echo "NO";?></td>
      </tr>
    </table></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="textonegrita"><p>DOCUMENTOS</p></td>
  </tr>
  <tr>
    <td class="textosimple">CERTIFICADO NACIMIENTO</td>
    <td align="center" class="textosimple"><? if($fila['bool_traecertificados']==1) echo "SI"; else echo "NO";?></td>
    <td class="textosimple">CERTIFICADO DE NOTAS</td>
    <td align="center" class="textosimple"><? if($fila['bool_traecertificadosant']==1) echo "SI"; else echo "NO";?></td>
  </tr>
  <tr>
    <td class="textosimple">AUTOR. SECREMINEDUC</td>
    <td align="center" class="textosimple"><? if($fila['bool_secreduc']==1) echo "SI"; else echo "NO";?></td>
    <td class="textosimple">NIVEL</td>
    <td align="center" class="textosimple"><? echo (strlen($fila['nivel_certificado'])>0) ? "SI": "NO";?></td>
  </tr>
  <tr>
    <td class="textosimple">PLAZO FECHA</td>
    <td align="center" class="textosimple"><? echo (strlen($fila['plazo_autorizacion'])>0) ? "SI": "NO";?></td>
    <td class="textosimple">MANUAL DE CONVIVENCIA</td>
    <td align="center" class="textosimple"><? if($fila['bool_manualconvivencia']==1) echo "SI"; else echo "NO";?></td>
  </tr>
  <tr>
    <td class="textosimple">APORTE VOLUNTARIO CCA</td>
    <td align="center" class="textosimple"><? echo (strlen($fila['txtaporteCGP'])>0) ? "SI": "NO";?></td>
    <td class="textosimple">PAGO MATRICULA</td>
    <td align="center" class="textosimple"><? if($fila['bool_pagomatricula']==1) echo "SI"; else echo "NO";?></td>
  </tr>
</table>
<br />
<br />
<br />
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla04">
  <tr>
    <td><div align="right">______________________________</div></td>
  </tr>
  <tr>
    <td><div align="right">FIRMA APODERADO </div></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center" cellpadding="2" cellspacing="0" class="tabla04">
  <tr>
    <td width="154">FECHA MATRICULA </td>
    <td width="496">_______________________________</td>
  </tr>
  <tr>
    <td>FECHA RETIRO </td>
    <td>_______________________________</td>
  </tr>
  <tr>
    <td>MOTIVO RETIRO </td>
    <td>_____________________________________________________________</td>
  </tr>
  <tr>
    <td colspan="2">___________________________________________________________________________________</td>
  </tr>
</table>

<? 
echo "<H1 class=SaltoDePagina></H1>";
	}

} ?>
	
</body>
</html>
