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
<? 
	
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
<table width="650" border="0" align="center">
  <tr>
    <td>
    
   <table width="650" border="0" align="center">
   <tr><td width="51" rowspan="3"><?
						if($institucion!=""){
							echo "<img src='../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?></td>
     <td width="589"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong>
       <?=$ob_institucion->ins_pal;?>
     </strong></font></td>
     </tr>
   <tr>
     <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><?php echo $ob_institucion->comuna;?></strong></font></td>
   </tr>
   <tr>
     <td align="right"  class="textonegrita">CURSO:</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="right"  class="textonegrita">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="2" align="center"  class="textonegrita des">FICHA DE MATRICULA <?
				$ob_institucion->ano = $ano;
				$ob_institucion->AnoEscolar($conn);
				echo $ob_institucion->nro_ano;
				?> </td>
     </tr>
   <tr>
     <td>&nbsp;</td>
     <td align="center">&nbsp;</td>
   </tr>
  
   </table>
<br />
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; border-color:#E4E4E4" class="textosimple">
 <tr>
    
     <td colspan="4" align="center"  class="textonegrita des" ><div style="width:100%; border:2px solid black">DATOS DEL ALUMNO</div></td>
   </tr>
 <tr>
   <td width="119">NOMBRE</td>
   <td colspan="3">&nbsp;</td>
   </tr>
 <tr>
   <td width="119">RUT</td>
   <td width="193">&nbsp;
     </td>
   <td width="119">FONO</td>
   <td width="193">&nbsp;</td>
 </tr>
 <tr>
   <td>FECHA DE NAC.</td>
   <td width="193">&nbsp;</td>
   <td>FONO RECADOS</td>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td>DIRECCION</td>
   <td width="193">&nbsp;</td>
   <td>COMUNA</td>
   <td>&nbsp;</td>
 </tr>
 <?php if($ense<=10){?>
 <tr>
   <td>PESO Y TALLA AL NACER</td>
   <td width="193">&nbsp;</td>
   <td>TIPO DE PARTO</td>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td colspan="4">&nbsp;</td>
   </tr>
   <?php }?>
   <?php 
   
   $ob_reporte->responsable=1; 
   $rs_apo=$ob_reporte->Apoderado($conn);
   
   $fil_1 = @pg_fetch_array($rs_apo,0);
		$ob_reporte->CambiaDatoApo($fila_apo);
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
		$parentezco_apo     = $fil_1['parentezco'];
		
		$comuna_apo     = $fil_1['comuna_apo'];
		
		$calle_apo= $fil_1['nom_com'];
		
		//var_dump($fil_1);
   ?>
 <tr>
   <td colspan="4" align="center"  class="textonegrita des"><div style="width:100%; border:2px solid black">DATOS DEL APODERADO</div></td>
   </tr>
   <tr>
   <td height="20">NOMBRE</td>
   <td colspan="3">&nbsp;</td>
   </tr>
   <tr>
     <td height="38">CEDULA DE IDENTIDAD</td>
     <td>&nbsp;</td>
     <td>PARENTEZCO</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>DIRECCION</td>
     <td>&nbsp;</td>
     <td>COMUNA</td>
     <td>&nbsp;</td>
   </tr>
    <tr>
   <td colspan="2" align="center"  class="textonegrita des"><div style="width:100%; border:2px solid black">DATOS DEL PADRE</div></td>
   <td colspan="2" align="center"  class="textonegrita des"><div style="width:100%; border:2px solid black">DATOS DE LA MADRE</div></td>
   </tr>
   <?php 
 $rs_padre=$ob_reporte->Padre($conn);
   
    $fil_2 = @pg_fetch_array($rs_padre,0);
	
		$ob_reporte->CambiaDatoApo($fila_padre);
		
		
		$nombre_padre    = $fil_2['nombre_apo'];
		$paterno_padre   = $fil_2['ape_pat'];
		$materno_padre   = $fil_2['ape_mat'];
		$rut_padre       = $fil_2['rut_apo'];
		$dig_rut_padre   = $fil_2['dig_rut'];

		$ultimo_ano_padre    = $fil_2['ultimo_ano_aprobado'];
		
		$ocupacion_padre     = $fil_2['ocupacion'];
   
   
   ?>
   
    <?php 
 $rs_madre=$ob_reporte->Madre($conn);
   
    $fil_2 = @pg_fetch_array($rs_madre,0);
	
		$ob_reporte->CambiaDatoApo($fila_madre);
		
		
		$nombre_madre    = $fil_2['nombre_apo'];
		$paterno_madre   = $fil_2['ape_pat'];
		$materno_madre   = $fil_2['ape_mat'];
		$rut_madre       = $fil_2['rut_apo'];
		$dig_rut_madre   = $fil_2['dig_rut'];

		$ultimo_ano_madre    = $fil_2['ultimo_ano_aprobado'];
		
		$ocupacion_madre     = $fil_2['ocupacion'];
		$primer_parto_madre     = $fil_2['edad_primer_parto'];
   
   
   ?>
   
   <tr>
   <td>NOMBRE</td>
   <td>&nbsp;</td>
   <td>NOMBRE</td>
   <td>&nbsp;</td>
   </tr>
   <tr>
     <td>CEDULA DE IDENTIDAD</td>
     <td>&nbsp;</td>
     <td>CEDULA DE IDENTIDAD</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>ESCOLARIDAD</td>
     <td>&nbsp;</td>
     <td>ESCOLARIDAD</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>OCUPACION</td>
     <td>&nbsp;</td>
     <td>OCUPACION</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
   <td colspan="4" align="center"  class="textonegrita des"><div style="width:100%; border:2px solid black">INFORMACION GENERAL</div></td>
   </tr>
   <tr>
   <td>CON QUIEN VIVE</td>
   <td>&nbsp;</td>
   <td>JEFE DE HOGAR</td>
   <td>&nbsp;</td>
   </tr>
   <tr>
     <td>N&deg; GRUPO FAMILIAR</td>
     <td>&nbsp;</td>
     <td>OCUPACION JEFE DE HOGAR</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>TOTAL DE INGRESOS</td>
     <td>&nbsp;</td>
     <td>VIVIENDA</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>NRO DORMITORIOS</td>
     <td>&nbsp;</td>
     <td>NRO DE BA&Ntilde;OS</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>SISTEMA DE SALUD</td>
     <td>&nbsp;</td>
     <td>RELIGION</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>ORIGEN INDIGENA</td>
     <td>&nbsp;</td>
     <td>PROGRAMA PAE</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <?php if($ense<=10){?>
   </tr>
   <tr>
     <td height="47">EDAD PRIMER PARTO MADRE</td>
     <td>&nbsp;</td>
     <td>&iquest;PARTICIPA EN ORGANIZACION? &iquest;CUAL?</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td height="61">&iquest;HAY ESPACIO PARA EL ESTUDIO?</td>
     <td>&nbsp;</td>
     <td>&iquest;HIZO JARDIN O PREKINDER?</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td height="38">&iquest;HAY ESPACIO PARA JUGAR?</td>
     <td>&nbsp;</td>
     <td>&iquest;HAY FIGURA PATERNA? &iquest;QUI&Eacute;N?</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>&iquest;QUE TAN CARI&Ntilde;OSO ES?</td>
     <td>&nbsp;</td>
     <td colspan="2"  class="textonegrita des"><div style="width:100%; border:2px solid black">PROBLEMAS DE SALUD</div></td>
     </tr>
   <tr>
     <td height="48">&iquest;QUE TAN SOCIALBLE ES?</td>
     <td>&nbsp;</td>
     <td>PRESENTA PROBLEMAS DENTALES</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td height="48">&iquest;QUE TAN CURIOSO ES?</td>
     <td>&nbsp;</td>
     <td>ESTA EN CONTROL DENTAL</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td height="47">&iquest;CON QUIEN ESTUDIA?</td>
     <td>&nbsp;</td>
     <td>FECHA ULTIMO CONTROL SANO</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>PROCEDENCIA</td>
     <td>&nbsp;</td>
     <td>FAMILAR CON PROBLEMAS DE SALUD O DISCAPACIDAD DIAGNOSTICADA</td>
     <td>&nbsp;</td>
   </tr>
   <?php }?>
   <tr>
     <td>OBSERVACIONES DE SALUD</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td colspan="2">OBSERVACIONES GENERALES</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <tr>
     <td colspan="4">&nbsp;</td>
     </tr>
   <tr>
     <td colspan="2">&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
   </tr>
   <!--CARGAR SI TIENE HERMANOS-->
  
   <tr>
     <td colspan="4">HERMANOS EN EL ESTABLECIMIENTO</td>
     </tr>
    
  
   <tr>
     <td colspan="4">&nbsp;</td>
   </tr>
 
   <!--FIN CARGA HERMANOS-->
   <tr>
     <td colspan="4"><div style="width:100%; border:1px solid black; text-align:justify">RECIBO Y TOMO CONOCIMIENTO DEL MANUAL DE CONVIVENCIA ESCOLAR (ESPECIALMENTE AL QUE SE REFIERE AL PERFIL, DERECHOS Y DEBERES DEL ALUMNO Y DEL APODERADO) Y DEL COMPROMISO QUE HA ADQUIRIDO EL ESTABLECIMIENTO DE RECIBIR Y ENTREGAR LOS TEXTO ESCOLARES QUE PROVEERA EL MINISTERIO DE EDUCACION PARA EL A&Ntilde;O <?php echo $ob_institucion->nro_ano;?></div></td>
   </tr>
   <tr>
     <td colspan="4">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="4">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="4">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="4">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="2" align="center" valign="bottom">_______________________________</td>
     <td colspan="2" align="center" valign="bottom">______________________________</td>
     </tr>
   <tr>
     <td colspan="2" align="center">RESPONSABLE MATRICULA</td>
     <td colspan="2" align="center">FIRMA APODERADO(A)</td>
   </tr>
   <tr>
     <td colspan="2" align="center">&nbsp;</td>
     <td colspan="2" align="center">&nbsp;</td>
   </tr>
   <tr>
     <td colspan="4">
	  <? $fecha = date("d-m-Y") ?>
	 <? echo ($ob_institucion->comuna . ", " . fecha_espanol($fecha))?></td>
     </tr>
   <tr>
     <td colspan="2" align="center">&nbsp;</td>
     <td colspan="2" align="center">&nbsp;</td>
   </tr>
   
</table>
    </td>
  </tr>
</table>

</body>
</html>