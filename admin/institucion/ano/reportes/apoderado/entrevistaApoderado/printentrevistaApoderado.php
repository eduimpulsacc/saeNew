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
	$curso 			= $cmb_curso;
	$asunto			= $asunto;
	$reporte		=$c_reporte;
	
	$_POSP = 4;
	$_bot = 8;


   
  /* echo "parte: $numero_ini<br>";
    echo "termina: $numero_fin<br>";*/
   
   	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_reporte->curso=$curso;
	$ob_reporte->ano=$ano;
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
		
	
	
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 
<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<?
if (empty($curso)){
   ## no hace nada
}else{
   ?>   

	
   <center>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="827">
		
		<div id="capa0">
		<table width="100%">
		  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right"><input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	</td>
		
		  </tr></table>
		 
        </div></td>
      </tr>
    </table>
	
  
	
	
  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="10">&nbsp;</td>
    <td width="125" rowspan="4" align="center">
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
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono: &nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  
</table>
<br>	
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="tableindex">Informe asistencias del apoderado a citaciones</td>
  </tr>
</table>
<br>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="87" align="center" class="textonegrita">Curso</td>
    <td width="13" align="center" class="textonegrita">:</td>
    <td width="550" class="textonegrita"><?php echo CursoPalabra($cmb_curso,0,$conn); ?>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="textonegrita">Asunto</td>
    <td align="center" class="textonegrita">:</td>
    <td class="textonegrita"><?php $ob_reporte->asunto=$asunto;
	$rs_asunto = $ob_reporte->traeNombreAsunto($conn);
	echo strtoupper(pg_result($rs_asunto,1));
	 ?></td>
  </tr>
</table><br>
<br>
<?php  $rs_listado =$ob_reporte->citacionapos($conn);  ?>
<table width="650"  border="1" align="center" style="border-collapse:collapse">
	  <tr class=" tablatit2-1">
	    <td align="center">#</td>
	    <td align="center">FECHA</td>
	    <td align="center">HORA</td>
	    <td align="center">CONVOCA</td>
        
	    <td align="center">APODERADO</td>
       
       
	    <td align="center">Estado</td>
      </tr>
<? if(pg_numrows($rs_listado)==0){?>
		<tr>
		  <td colspan="7" align="center" class="textosimple">SIN INFORMACI&Oacute;N</td>
	    </tr>
<? }else{
		for($i=0;$i<pg_numrows($rs_listado);$i++){
			$fila = pg_fetch_array($rs_listado,$i);
			
			
?>
	  <tr class="textosimple">
	    <td><?php echo ($i+1) ?></td>
	    <td>&nbsp;<?=CambioFD($fila['fecha']);?></td>
	    <td>&nbsp;<?=$fila['hora'];?></td>
	    <td  align="center"><?=$fila['atendido'];?></td>
	
			
       
	   
	    <td  align="center"><?=$fila['nom_apo'];?></td>
       
	    <td align="center"><?php echo ($fila['estado']==0)?"Ausente":"Presente" ?></td>
      </tr>
 <? }
}
?>
 
</table>
<?php }?>

  
</table>



<!-- FIN CUERPO DE LA PAGINA -->
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
</body>
</html>
<? pg_close($conn);?>