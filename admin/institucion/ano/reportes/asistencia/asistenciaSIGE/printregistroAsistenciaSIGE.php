<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?php require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');
setlocale(LC_ALL,"es_ES");
	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$reporte		=$c_reporte;
	$curso=1;	
	$_POSP = 4;
	$_bot = 8;


   
  /* echo "parte: $numero_ini<br>";
    echo "termina: $numero_fin<br>";*/
   
   	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->ano=$ano;
	
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$ob_reporte->institucion=$institucion;
	$ob_reporte->ano=$ano;	
	$fecha=CambioFE($fec_consulta);
	$ob_reporte->fecha = $fecha;
	
	$lista_op = $ob_reporte->registroSIGE($conn);
	
	
	function tipo_env($tipo)
	{ 
		switch($tipo){
		case 1:
		$tip = "Enviar Semilla";	
		break;
		case 2:
		$tip = "Enviar asistencia";
		break;
		case 3:
		$tip = "Comprobar env&iacute;o asistencia";
		break;
		case 4:
		$tip = "Comprobar asistencia";
		break;
		}
		return $tip;
	}	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script> 

function cerrar(){ 
window.close() 
} 
</script>
</head>
<style type="text/css">
<!--
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 9px}
.Estilo4 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 9px;
}
.Estilo6 {font-size: 9px}
.Estilo11 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 9px; }
-->
</style>
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
.Estilo12 {font-weight: bold; font-family: Verdana, Arial, Helvetica, sans-serif;}
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
 

<table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td width="650">
	
	
	

	<table width="650" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td >
		
		<div id="capa0">
		<table width="100%">
		  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">&nbsp;</td>
		   <? if($_PERFIL == 0){?>
		    <td align="right"><input name="button32" TYPE="button" class="botonXX" onClick="javascript:exportar();"  value="EXPORTAR"></td>
		  <? }?>
		  </tr></table>
		 
        </div></td>
      </tr>
    </table>
	
   <? if ($institucion=="770"){ 
		   // no muestro los datos de la institucion
		   // por que ellos tienen hojas pre-impresas
		   echo "<br><br><br><br><br><br><br><br><br><br>";
   }  ?>
	
	
  <table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
   <tr>
    <td ><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="212" rowspan="4" align="center">
      <table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
          <td width="125" align="center">
            <? if ($institucion=="770"){ 
		  
			   
	 }else{ 
		    if($institucion!=""){
			    echo "<img src='../../../../../../tmp/".$institucion."insignia". "' >";
		    }else{
			    echo "<img src='".$d."menu/imag/logo.gif' >";
		    }?>
            
            <? } ?>  
            
            
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono: &nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    </tr>
  
</table>
<br>	
<table width="650" border="0" cellpadding="0" cellspacing="0" align="center">
  <tr>
    <td align="center" class="tableindex">REGISTRO ASISTENCIA V&Iacute;A SIGE</td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong>FECHA CONSULTA: <?php echo $fec_consulta ?></td>
  </tr>
 
</table><br>

 <table width="650" align="center" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
 <tr class="tableindex">
   <td>Curso</td>
   <td align="center">Fecha Operaci&oacute;n</td>
   <td align="center">Fecha env&iacute;o</td>
   <td align="center">Tipo env&iacute;o</td>
   <td align="center">Respuesta</td>
   </tr>
  <?php  if(pg_numrows($lista_op)==0){?>
 <tr class="textosimple">
   <td colspan="5" align="center">Sin informaci&oacute;n</td>
   </tr>
   <?php }else{
	   for($h=0;$h<pg_numrows($lista_op);$h++){
		   $fila_op= pg_fetch_array($lista_op,$h);
	   ?>
 <tr class="textosimple">
   <td><?php echo  CursoPalabra($fila_op['id_curso'],1,$conn) ?></td>
   <td align="center"><?php echo CambioFD($fila_op['fecha_operacion'])." ".$fila_op['hora_operacion'] ?></td>
   <td align="center"><?php echo CambioFD($fila_op['fecha_envio'] )?></td>
   <td align="center"><?php echo tipo_env($fila_op['tipo']) ?></td>
   <td align="center"><?php  
   if($fila_op['tipo']==2 && $fila_op['cod_respuesta']==1){
   echo "Asistencia enviada correctamente";
   }
   elseif($fila_op['tipo']==4 && $fila_op['cod_respuesta']==1){
   echo "Asistencia comprobada correctamente";
   }
   elseif($fila_op['tipo']==4 && $fila_op['cod_respuesta']==4){
   echo "Asistencia a&uacute;n no ha sido procesada";
   }
   elseif($fila_op['tipo']==4 && $fila_op['cod_respuesta']==8){
   echo "Servicio NO Disponible";
   }
   elseif($fila_op['tipo']==4 && $fila_op['cod_respuesta']==5){
   echo "Par&aacute;metros no corresponden. Verifique si asistencia fue enviada para ese d&iacute;a.";
   }
   else{
	  echo  $fila_op['mensaje_respuesta'];
	   }?></td>
   </tr>
   <?php }?>
   <?php }?>
 </table>

  
</table>

<!-- FIN CUERPO DE LA PAGINA -->
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
</body>
</html>
<? pg_close($conn);?>