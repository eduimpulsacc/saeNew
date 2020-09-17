<?php
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');

$_POSP = 4;
$_bot = 8;



//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodo;
	$reporte		=$c_reporte;
	$ramo 			=$cmbAsignatura;
	
	
	
	
	

	
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_reporte->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$ob_reporte->idc=$curso;
	$ense = $ob_reporte->getEnsenanzabyCurso($conn);
	
	
$ob_reporte->ramo =$ramo;
$ob_reporte->periodo=$periodo;
$rs_bitacora = $ob_reporte->getListaBitacora($conn);

	
	
?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<SCRIPT language="JavaScript">
			
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>

<script> 

function cerrar(){ 
window.close() 
} 
</script>


</head>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
 <!-- INICIO CUERPO DE LA PAGINA -->


<?
if ($curso != 0){
   ?>

<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
   <tr>
    <td><div id="capa0">
		<table width="100%">
		  <tr>
		<td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
		<td align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR"></td>
		  
		  <? if($_PERFIL == 0){?>
		  <? }?>
		  </tr>
        </table>
      </div></td>
   </tr>
  </table>
  <?
}

	
?>

<?php if(pg_numrows($rs_bitacora)>0){
for($b=0;$b<pg_numrows($rs_bitacora);$b++){
	$fila_b = pg_fetch_array($rs_bitacora,$b);
	
	
	
?>

<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
      
	
  
	  
		  <table width="125" border="0" cellpadding="0" cellspacing="0">
			<tr valign="top">
			  <td width="125" align="center"> 
				<?
				if($institucion!=""){
				    echo "<img src='../../../../../../tmp/".$institucion."insignia". "' >";
			    }else{
				    echo "<img src='../../../../../../tmp/menu/imag/logo.gif' >";
			    } ?>
		  </td>
			</tr>
		  </table>
  	  
	  
	  
	  
    </td>
  </tr>
  <tr>
    <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>

<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center" class="tableindex"><div style="text-align:center">INFORME BIT&Aacute;CORA POR ASIGNATURA</div></td>
    </tr>
  <tr>
    <td><div align="center"></div></td>
    </tr>
</table>

<br>
<table width="650" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse" align="center">
  <tr>
    <td width="132" class="textonegrita">&nbsp;Curso</td>
    <td width="512" class="textosimple">&nbsp;<?php echo CursoPalabra($curso,1,$conn); ?>&nbsp;</td>
  </tr>
  <tr>
    <td  class="textonegrita">&nbsp;Asignatura</td>
    <td class="textosimple">&nbsp;<?php echo $fila_b['nombre_ramo'] ?>&nbsp;</td>
  </tr>
  <tr>
    <td  class="textonegrita">&nbsp;Docente</td>
    <td class="textosimple">&nbsp;<?php echo $fila_b['nombre_docente'] ?></td>
  </tr>
  <tr>
    <td  class="textonegrita">&nbsp;Periodo</td>
    <td class="textosimple">&nbsp;<?php echo $fila_b['nombre_periodo'] ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td  class="textonegrita">&nbsp;Fecha Actividad</td>
    <td class="textosimple">&nbsp;<?php echo CambioFD($fila_b['fecha']) ?></td>
  </tr>
  <tr>
    <td  class="textonegrita">&nbsp;Horario</td>
    <td class="textosimple">&nbsp;<?php echo substr($fila_b['hora_inicio'],0,-3) ?> a <?php echo substr($fila_b['hora_termino'],0,-3) ?></td>
  </tr>
  <tr>
    <td  class="textonegrita">&nbsp;Docente Asignatura</td>
    <td class="textosimple">&nbsp;<?php echo $fila_b['nombre_docente'] ?></td>
  </tr>
  <tr>
    <td  class="textonegrita">&nbsp;Canal de comunicaci&oacute;n</td>
    <td class="textosimple">&nbsp;<?php echo $fila_b['nombre_canal'] ?></td>
  </tr>
  <tr>
    <td  class="textonegrita">Planificaci&oacute;n PIE</td>
    <td class="textosimple">&nbsp;<?php echo ($fila_b['bool_pie']==1)?"SI":"NO" ?></td>
  </tr>
  <tr>
    <td  class="textonegrita">Docente Planificaci&oacute;n</td>
    <td class="textosimple">&nbsp;<?php 
	$docPla= $fila_b['docente'];
	$ob_reporte->rut_emp=$docPla;
	$ob_reporte->Profesor($conn);
	echo $ob_reporte->profesor;
	
	?></td>
  </tr>
  <tr>
    <td  class="textonegrita">&nbsp;<?php echo ($ense==10)?"N&uacute;cleo":"Unidad" ?></td>
    <td class="textosimple">&nbsp;<?php echo ($fila_b['id_unidad']>0)?$fila_b['nombre_unidad']:"Sin informaci&oacute;n" ?></td>
  </tr>
  <tr>
    <td  class="textonegrita">&nbsp;<?php echo ($ense==10)?"Objetivo  de Aprendizaje":"Objetivo de Aprendizaje" ?></td>
    <td class="textosimple">&nbsp;<?php  echo ($fila_b['id_objetivo']>0)?$fila_b['nombre_objetivo']:"Sin informaci&oacute;n"; ?></td>
  </tr>
  <?php if($ense!=10){?>
  <tr>
    <td  class="textonegrita">&nbsp;Indicador</td>
    <td class="textosimple">&nbsp;<?php echo ($fila_b['id_indicador']>0)?$fila_b['nombre_indicador']:"Sin informaci&oacute;n"; ?></td>
  </tr>
  <?php }?>
  <tr>
    <td  class="textonegrita">&nbsp;Observaciones</td>
    <td  class="textosimple">&nbsp;<?php echo $fila_b['texto'] ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <?php if($aluP==1){
	 $ob_reporte->idbitacora = $fila_b['id_bitacora'];
	 $rs_alubi = $ob_reporte->getListaAlumnosBitacora($conn);
	  ?>
  <tr>
    <td colspan="2" class="textonegrita">Alumnos particiantes en la actividad</td>
  </tr>
 <?php  if(pg_numrows($rs_alubi)>0){
	?>
  <tr>
    <td colspan="2" class="textosimple">
     <?php for($al=0;$al<pg_numrows($rs_alubi);$al++){
		 $fila_al = pg_fetch_array($rs_alubi,$al);
    echo  "- ".$fila_al['nombre_alumno']."<br>";
    
     }?></td>
  </tr>
  <?php 
	
  }else{?>
  <tr>
    <td colspan="2" align="center" class="textonegrita">Sin Informaci&oacute;n</td>
  </tr>
  <?php }?>
  <?php }?>
</table>

<br>
<br>
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("firmas/firmas.php");?><br>

<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
 <? 
 if  (pg_numrows($rs_bitacora)>1){ 
	  echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
 } ?>

<?php
} //fin for si hay registros
 }//fin if si hay registros
 else{
?>
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
      
	
  
	  
		  <table width="125" border="0" cellpadding="0" cellspacing="0">
			<tr valign="top">
			  <td width="125" align="center"> 
				<?
				if($institucion!=""){
				    echo "<img src='../../../../../../tmp/".$institucion."insignia". "' >";
			    }else{
				    echo "<img src='../../../../../../tmp/menu/imag/logo.gif' >";
			    } ?>
		  </td>
			</tr>
		  </table>
  	  
	  
	  
	  
    </td>
  </tr>
  <tr>
    <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>

<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center" class="tableindex"><div style="text-align:center">INFORME BIT&Aacute;CORA POR ASIGNATURA</div></td>
    </tr>
  <tr>
    <td><div align="center"></div></td>
    </tr>
</table><br>
<br>

<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td align="center" class="textonegrita"><div style="text-align:center">SIN INFORMACI&Oacute;N</div></td>
    </tr>
  <tr>
    <td><div align="center"></div></td>
    </tr>
</table>

<?	
}
 ?>
<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>