<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');


	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $cmb_curso;
	$docente		= 5; //Codigo Docente
	$frmModo		=$_FRMMODO;
	$alumno			=$alumno;
	$reporte		= $c_reporte;	


$ob_reporte = new Reporte();
$ob_membrete = new Membrete();
$ob_membrete ->institucion = $institucion;
$ob_membrete ->institucion($conn);

if ($alumno!=0){
	$ob_reporte->ano = $ano; 
	$ob_reporte->alumno = $alumno;
	$result_home=$ob_reporte->FichaAlumnoUno_fichamat($conn);
}
if(($alumno==0)&&($cmb_curso!=0)){
	$ob_reporte->ano =$ano;
	$ob_reporte->curso = $cmb_curso;
	$ob_reporte->retirado= 0;
	$result_home=$ob_reporte->FichaAlumnoTodos($conn);
}

/*if(!$cb_ok =="Buscar"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Ficha_Matricula_$Fecha.xls"); 
	
}*/	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
	<style type="text/css">
<!--
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:9px;
}
.conscroll {
overflow: auto;
width: 500px;
height: 400px;
clear:both;
} 
.salto{
page-break-after:always;
}
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px;}
-->
    </style>
	
<SCRIPT language="JavaScript">
		
									
	function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';


}


//-->
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
 
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<form method="post" action="printFichaMatricula_C.php" name="form">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="0%" height="1024" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="1024" valign="top"><table width="100%">
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 

                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr> 
                                  <td valign="top">
								  
								

<!-- INICIO CUERPO DE LA PAGINA -->

<? if ((pg_numrows($result_home)>0) ){?>
<div id="capa0">
<table width="650" align="center">
  <tr>
    <td><input name="button4" type="button" class="botonXX" onclick="window.location='nueva_ficha3.php'"   value="CERRAR" /></td>
    <td align="right"><input name="button3" type="button" class="botonXX"  value="IMPRIMIR" onclick="javascript:imprimir()" />
     </td>
  </tr>
</table>
</div>
<?

for ($i=0;$i<pg_numrows($result_home);$i++){
$fila=pg_fetch_array($result_home);
$ob_reporte->CambiaDato($fila);
?>
<table align="center" bgcolor="#FFFFFF"><tr><td>
  <table width=755 border=1 cellpadding=0 cellspacing=0 style="border-collapse:collapse">
    <tr>
      <td colspan=7 class="textonegrita"><p><?
						if($institucion!=""){
							echo "<img src='../../../../tmp/".$institucion."insignia". "' width='90' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?></p>
        
       </td>
      <td colspan=5 valign="middle" class="textonegrita" align="center"><br><b><font size="2">FICHA DE MATR&Iacute;CULA <?
				$ob_membrete->ano = $ano;
				$ob_membrete->AnoEscolar($conn);
				echo $ob_membrete->nro_ano;
				?><u><br><br>
        CURSO: <?php echo CursoPalabra($curso,1,$conn) ?></u><br></font></b>
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
    <td width="25%" align="center"><b>
      <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->ape_pat))); ?>
    </b></td>
    <td width="25%" align="center"><b>
      <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->ape_mat)));?>
    </b></td>
    <td colspan="2" align="center"><b>
      <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->nombre)));?>
    </b></td>
    </tr>
  <tr>
    <td width="25%" align="center"><strong>(APELLIDO PATERNO)</strong></td>
    <td width="25%" align="center"><strong>(APELLIDO MATERNO)</strong></td>
    <td colspan="2" align="center"><strong>(NOMBRES)</strong></td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr>
    <td width="25%"><strong>Fecha de Nacimiento</strong></td>
    <td width="25%"><b>
      <?php impF($ob_reporte->fecha_nacimiento);?>
    </b></td>
    <td width="25%"><strong>C&eacute;dula de Identidad</strong></td>
    <td width="25%"><b>
      <?=$ob_reporte->rut_alumno;?>
    </b></td>
  </tr>
  <tr>
    <td><strong>Edad al 31 de Marzo</strong></td>
    <td><b><?php 
	$apaso = $ob_membrete->nro_ano;
	echo edadAnoMes($ob_reporte->fecha_nacimiento,$apaso."-03-01"); ?></b></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><strong>Direcci&oacute;n</strong> 
      <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->direccion_alu)));?>
      <? if (trim($ob_reporte->depto)!=""){
			echo "DPTO $ob_reporte->depto";
		}?>
      <? if (trim($ob_reporte->block)!=""){
			echo "&nbsp;BLOCK $ob_reporte->block";
		}?>
      <? if (trim($ob_reporte->villa)!=""){
			echo "&nbsp;VILLA $ob_reporte->villa";
		}?>
    </td>
    <td width="25%"><strong>Comuna</strong>
      <?=$ob_reporte->comuna;?>
    </td>
  </tr>
  <tr>
    <td width="25%"><strong>Fono red fija</strong></td>
    <td width="25%"><span class="textosimple">
      <?=$fila['telefono'];?>
    </span></td>
    <td width="25%"><strong>Fono Celular</strong></td>
    <td width="25%"><span class="textosimple">
      <?=$fila['celular'];?>
    </span></td>
  </tr>
  <tr>
    <td><strong>Colegio de procedencia</strong></td>
    <td><?=$ob_reporte->proced_alumno;?></td>
    <td><strong>Curso(s) que ha repetido</strong></td>
    <td><span class="textosimple">
      <?=$fila['txt_anosrepetidos'];?>
    </span></td>
  </tr>
  <tr>
    <td><strong>Con Hermanos</strong></td>
    <td colspan="2"><?php 
	$rs_hermano=$ob_reporte->hermanos($conn);
	if(pg_numrows($rs_hermano)==0){
	echo "SIN HERMANOS";	
	}else{
		for($h=0;$h<pg_numrows($rs_hermano);$h++){
			$fil_hermano=pg_fetch_array($rs_hermano,$h);
		 echo $fil_hermano['ape_pat'] ?> <?php echo $fil_hermano['ape_mat'] ?>, <?php echo $fil_hermano['nombre_hermano'] ?> -  <?php echo CursoPalabra($fil_hermano['id_curso'], 0, $conn)."<br>" ;
		}
	}
	?></td>
    <td><strong>Sin hermanos</strong></td>
  </tr>
  <tr>
    <td><strong>Tiene alg&uacute;n problema de salud significativo</strong></td>
    <td colspan="3"><?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->inf_salud)));?></td>
    </tr>
  <tr>
    <td><strong>Enfermedades crónicas</strong></td>
    <td><?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->enfermedad)));?></td>
    <td><strong>Alergias</strong></td>
    <td>
    <?=$ob_reporte->tilde(ucfirst(strtolower($ob_reporte->alergia)));?>
   </td>
  </tr>
  <tr>
    <td><strong>&iquest;Con qu&iacute;en vive el alumno?</strong></td>
    <td colspan="3"><?=$ob_reporte->cq_vive;?></td>
    </tr>
  </table>

  <br>
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
		$telefono_padre   = ($fila_padre['telefono']!="" && trim($fila_padre['telefono'])!="-")?$fila_padre['telefono']." - ":"";
		$celular_padre   = ($fila_padre['celular']!="" && trim($fila_padre['celular'])!="-")?$fila_padre['celular']:"";

		$ultimo_ano_padre    = (trim($fila_padre['ultimo_ano_aprobado'])=='SUPERIOR')?"ENSE&Ntilde;ANZA ".$fila_padre['ultimo_ano_aprobado']:$fila_padre['ultimo_ano_aprobado'];
		
		$ocupacion_padre     = $fila_padre['ocupacion'];
		
		
		$comuna_padre = $ob_reporte->comuna_apo;
		$ob_reporte->id_sistema_salud= $fila_padre['sistema_salud'];
		$rs_sisaludp = $ob_reporte->sistema_salud($conn);
		$fi_sisaludp = pg_fetch_array($rs_sisaludp,0);
		$sissalud_padre = $fi_sisaludp['sistema_salud'];
		
		$email_padre    = $fila_padre['email'];
		
		
		  switch($fila_padre['estado_civil']){
			  case 1: $estp="SOLTERO(A)";break;
			  case 2: $estp="CASADO(A)";break;
			  case 3: $estp="VIUDO(A)";break;
			  case 4: $estp="DIVORCIADO(A)";break;
			  case 5: $estp="OTROS";break;
			  default: $estp="SIN INFORMACI&Oacute;N";break;
			  
		 }
		 
		  switch($fila_padre['tipo_trabajo']){
			  case 1: $ttp="JORNADA COMPLETA";break;
			  case 2: $ttp="JORNADA PARCIAL";break;
			  case 3: $ttp="NO TRABAJA EN ESTE MOMENTO";break;
			  case 4: $ttp="NO ESTA TRABAJANDO PERO ESTA EN BUSQUEDA";break;
			  case 5: $ttp="OTROS";break;
			  default: $ttp="SIN INFORMACI&Oacute;N";break;
			  
		 }
		 
		 
		  
		
   
   
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
		$telefono_madre   = ($fila_madre['telefono']!="" && trim($fila_madre['telefono'])!="-")?$fila_madre['telefono']." - ":"";
		
		$celular_madre   = ($fila_madre['celular']!="" && trim($fila_madre['celular'])!="-")?$fila_madre['celular']:"";

		$ultimo_ano_madre    = ($fila_madre['ultimo_ano_aprobado']=="SUPERIOR")?"ENSE&Ntilde;ANZA ".$fila_madre['ultimo_ano_aprobado']:$fila_madre['ultimo_ano_aprobado'];
		
		$ocupacion_madre     = $fila_madre['ocupacion'];
		$primer_parto_madre     = $fila_madre['edad_primer_parto'];
		$comuna_madre = $ob_reporte->comuna_apo;
		$email_madre    = $fila_madre['email'];
		
		$ob_reporte->id_sistema_salud= $fila_madre['sistema_salud'];
		$rs_sisaludm = $ob_reporte->sistema_salud($conn);
		$fi_sisaludm = pg_fetch_array($rs_sisaludm,0);
		$sissalud_madre = $fi_sisaludm['sistema_salud'];
		
				
		 switch($fila_madre['estado_civil']){
			  case 1: $estm="SOLTERO(A)";break;
			  case 2: $estm="CASADO(A)";break;
			  case 3: $estm="VIUDO(A)";break;
			  case 4: $estm="DIVORCIADO(A)";break;
			  case 5: $estm="OTROS";break;
			  default: $estm="SIN INFORMACI&Oacute;N";break;
			  
		 }
		 
		 switch($fila_madre['tipo_trabajo']){
			  case 1: $ttm="JORNADA COMPLETA";break;
			  case 2: $ttm="JORNADA PARCIAL";break;
			  case 3: $ttm="NO TRABAJA EN ESTE MOMENTO";break;
			  case 4: $ttm="NO ESTA TRABAJANDO PERO ESTA EN BUSQUEDA";break;
			  case 5: $ttm="OTROS";break;
			  default: $ttm="SIN INFORMACI&Oacute;N";break;
			  
		 }
   
   
   ?>
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
    <td width="20%"><?php echo $paterno_padre ?></td>
    <td width="20%"><?php echo $materno_padre ?></td>
    <td width="20%"><?php echo $nombre_padre ?></td>
    <td width="20%"><?php echo $rut_padre ?>-<?php echo $dig_rut_padre ?></td>
    <td width="20%"><?php echo $estp; ?></td>
  </tr>
  <tr>
    <td width="20%" align="center"><strong>Apellido Paterno</strong></td>
    <td width="20%" align="center"><strong>Apellido Materno</strong></td>
    <td width="20%" align="center"><strong>Nombres</strong></td>
    <td width="20%" align="center"><strong>RUT</strong></td>
    <td width="20%" align="center"><strong>Estado Civil</strong></td>
  </tr>
  <tr>
    <td width="20%"><strong>Correo electr&oacute;nico</strong></td>
    <td colspan="4"><?php echo $email_padre ?></td>
    </tr>
  <tr>
    <td width="20%"><strong>Nivel Educacional</strong></td>
    <td width="20%"><?php echo $ultimo_ano_padre ?></td>
    <td width="20%"><strong>Previsi&oacute;n</strong></td>
    <td width="20%"><?php echo $sissalud_padre ?></td>
    <td width="20%"><strong>Fono Fijo<br>
       o Celular</strong>  <?php echo $telefono_padre ?><?php echo $celular_padre?></td>
  </tr>
  <tr>
    <td><strong>Direcci&oacute;n</strong></td>
    <td colspan="2"><?php echo $direccion_padre ?></td>
    <td><strong>Comuna</strong></td>
    <td><?php echo $comuna_padre ?></td>
  </tr>
  <tr>
    <td width="20%"><strong>Trabaja jornada</strong></td>
    <td><?php echo $ttp ?></td>
    <td><strong>Ocupaci&oacute;n</strong></td>
    <td colspan="2"><?php echo $ocupacion_padre ?></td>
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
    <td width="20%"><?php echo $paterno_madre ?></td>
    <td width="20%"><?php echo $materno_madre ?></td>
    <td width="20%"><?php echo $nombre_madre ?></td>
    <td width="20%"><?php echo $rut_madre ?>-<?php echo $dig_rut_madre ?></td>
    <td width="20%"><?php echo $estm; ?></td>
  </tr>
  <tr>
    <td width="20%" align="center"><strong>Apellido Paterno</strong></td>
    <td width="20%" align="center"><strong>Apellido Materno</strong></td>
    <td width="20%" align="center"><strong>Nombres</strong></td>
    <td width="20%" align="center"><strong>RUT</strong></td>
    <td width="20%" align="center"><strong>Estado Civil</strong></td>
  </tr>
  <tr>
    <td width="20%"><strong>Correo electr&oacute;nico</strong></td>
    <td colspan="4"><?php echo $email_madre ?></td>
    </tr>
  <tr>
    <td width="20%"><strong>Nivel Educacional</strong></td>
    <td width="20%"><?php echo $ultimo_ano_madre ?></td>
    <td width="20%"><strong>Previsi&oacute;n</strong></td>
    <td width="20%"><?php echo $sissalud_madre ?></td>
    <td width="20%"><strong>Fono Fijo<br> 
      o Celular</strong> <?php echo $telefono_madre ?><?php echo $celular_madre?></td>
  </tr>
  <tr>
    <td><strong>Direcci&oacute;n</strong></td>
    <td colspan="2"><?php echo $direccion_madre ?></td>
    <td><strong>Comuna</strong></td>
    <td><?php echo $comuna_madre ?></td>
  </tr>
  <tr>
    <td width="20%"><strong>Trabaja jornada</strong></td>
    <td><?php echo $ttm ?></td>
    <td><strong>Ocupaci&oacute;n</strong></td>
    <td colspan="2"><?php echo $ocupacion_madre ?></td>
    </tr>
</table>
<br>
<table width="599" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
  <tr>
    <td colspan="6" align="center"><strong>AUTORIZACIONES</strong></td>
    </tr>
  <tr>
    <td width="171"><strong>Tomar fotograf&iacute;as/videos en actividades escolares</strong></td>
    <td width="40"><?=$ob_reporte->bool_tomafoto;?></td>
    <td width="159"><strong>Compartir fotograf&iacute;as en p&aacute;gina institucional y/o en redes sociales institucionales</strong></td>
    <td width="40"><?=$ob_reporte->bool_facebook;?></td>
    <td width="135"><strong>Vacunas</strong></td>
    <td width="40"><?=$ob_reporte->aut_vacuna;?></td>
  </tr>
</table>

<br>
<? 	
	$ob_reporte->sostenedor=1;
	$ob_reporte->suplente=0;
	$ob_reporte->alumno = $ob_reporte->alumno;
	$ob_reporte->responsable=1;
	$rs_apoderado = $ob_reporte->Apoderado($conn);
	$fila_apo = pg_fetch_array($rs_apoderado,0);
	$ob_reporte->CambiaDatoApo($fila_apo);
?>
<table width="755" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
  <tr>
    <td colspan="4"><strong><u>Antedecentes Apoderado, Padre Madre o Tutor LEGAL</u>:<br>
      (que firma el Contrato de Prestaci&oacute;n de servicios Educacionales y asume los costos de Mensualidad)</strong></td>
    </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    </tr>
  <tr>
    <td width="121"><strong>Nombre Completo</strong></td>
    <td width="341"><span class="textosimple">
      <?=$ob_reporte->ape_nombre_apo;?>
    </span></td>
    <td width="68"><strong>Rut</strong></td>
    <td width="215"><span class="textosimple">
      <?=$ob_reporte->rut_apo;?>
    </span></td>
  </tr>
  <tr>
    <td><strong>Trabaja en</strong></td>
    <td><span class="textosimple">
      <?=$ob_reporte->lugar_trabajo;?>
    </span></td>
    <td><strong>Profesi&oacute;n</strong></td>
    <td><span class="textosimple">
      <?=$ob_reporte->profesion;?>
    </span></td>
    </tr>
  <tr>
    <td><strong>Correo electr&oacute;nico</strong></td>
    <td><span class="textosimple">
      <?=$ob_reporte->email_apo;?>
    </span></td>
    <td><strong>Celular</strong></td>
    <td><span class="textosimple">
      <?=$ob_reporte->celular;?>
    </span></td>
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
    <td width="20%"><?php echo $fila['nombre_retira'] ?>&nbsp;</td>
    <td width="20%"><?php echo $fila['rut_retira'] ?></td>
    <td width="20%"><?php echo $fila['parentesco_retira'] ?></td>
    <td width="20%"><?php echo $fila['fono_retira'] ?></td>
    <td width="20%"><?php echo $fila['celular_retira'] ?></td>
  </tr>
  <tr>
    <td width="20%"><?php echo $fila['nombre_retira2'] ?>&nbsp;</td>
    <td width="20%"><?php echo $fila['rut_retira2'] ?></td>
    <td width="20%"><?php echo $fila['parentesco_retira2'] ?></td>
    <td width="20%"><?php echo $fila['fono_retira2'] ?></td>
    <td width="20%"><?php echo $fila['celular_retira2'] ?></td>
  </tr>
  <tr>
    <td width="20%"><?php echo $fila['nombre_retira3'] ?>&nbsp;</td>
    <td width="20%"><?php echo $fila['rut_retira3'] ?></td>
    <td width="20%"><?php echo $fila['parentesco_retira2'] ?></td>
    <td width="20%"><?php echo $fila['fono_retira3'] ?></td>
    <td width="20%"><?php echo $fila['celular_retira3'] ?></td>
  </tr>
</table>

<br>


 <table width=599 border=1 cellpadding=0 cellspacing=0 style="border-collapse:collapse">
 <tr><td width="150"><strong>N&uacute;mero Matr&iacute;cula (uso interno)</strong></td><td colspan="2"><?=$ob_reporte->num_matricula;?></td></tr>
 <tr>
   <td><strong>Encargado(a) Matr&iacute;cula</strong></td>
   <td colspan="2"><?php if(intval($fila['enc_matricula'])!=0){
	   $ob_reporte->empleado =$fila['enc_matricula'];
	   $rs_enc = $ob_reporte->TraeUnempleado($conn); 
	   $femp = pg_fetch_array($rs_enc,0);
	   echo $femp['nombre_emp']." ".$femp['ape_pat']." ".$femp['ape_mat'];
	   } ?></td>
 </tr>
 <tr>
   <td><strong>N&deg; Boleta CEPA/MINEDUC</strong></td>
   <td width="169"><?php echo $fila['numboleta'] ?></td>
   <td width="223">&nbsp;</td>
 </tr>
 <tr>
   <td><strong>Observaciones</strong></td>
   <td colspan="2"><?php echo $fila['observacion'] ?></td>
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

<? if ($i<pg_numrows($result_home)){?> 
	<H1 class=SaltoDePagina></H1>
	<? }?>
<? }
}

?>

</body>
</html>
<? pg_close($conn);
unset($cb_ok)?>