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
	
	
foreach($_POST as $nombre_campo => $valor){
$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
eval($asignacion);
}

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$mes 			= $cmb_mes;
	$ense			= $cmb_ense;
	$reporte		=$c_reporte;
	$curso			=$cmb_curso;	
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
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
		
	$mestrabaja=($mes<10)?"0".$mes:$mes;
	
	$ob_config->cod_tipo = $ense;
	$ob_config->TipoEnsenanza($conn);
	$tipe = $ob_config->nombre;
	
	
	$sql01 = "select nro_ano,fecha_inicio,fecha_termino from ano_escolar where id_ano = " . $ano;
	$result01 =pg_Exec($conn,$sql01);
	if (!$result01) 
	{
		error('<B> ERROR :</b>Error al acceder a la BD. (ANO ESCOLAR)</B>');
	}
	else
	{
	if (pg_numrows($result01)!=0)
	{//En caso de estar el arreglo vacio.
		$fila01 = @pg_fetch_array($result01,0);	
		if (!$fila01)
		{
			error('<B> ERROR :</b>Error al acceder a la BD. (ANO ESCOLAR)</B>');
			exit();
		}
	}
	}
	$nro_ano = $fila01['nro_ano'];
	$fi_ano = $fila01['fecha_inicio'];
	$ft_ano = $fila01['fecha_termino'];
	
	
	$numero_fin = cal_days_in_month(CAL_GREGORIAN, $mes, $nro_ano); // 31
	
	$ob_reporte->ano=$ano;


$fechaInicio = CambioFE($desde);
$fechaFin = CambioFE($hasta);

# Fecha como segundos
$tiempoInicio = strtotime($fechaInicio);
$tiempoFin = strtotime($fechaFin);
# 24 horas * 60 minutos por hora * 60 segundos por minuto
$dia = 86400;
$co=0;
while($tiempoInicio <= $tiempoFin){
	# Podemos recuperar la fecha actual y formatearla
	# Más información: http://php.net/manual/es/function.date.php
	$fechaActual = date("Y-m-d", $tiempoInicio);
	//printf("Fecha dentro del ciclo: %s\n", $fechaActual);
	
	if(!EsSabadoDomingo($fechaActual)){
		
		$ob_reporte->curso = $curso;
		$ob_reporte->fecha = $fechaActual;
		$rs_asig = $ob_reporte->getAsigBitacoraFecha($conn);
		
		if(pg_numrows($rs_asig)>0){
			$arr_fechas[$co]['fecha']=$fechaActual;
			$arr_fechas[$co]['cols']=pg_numrows($rs_asig);
			$co++;
		}
	}

	# Sumar el incremento para que en algún momento termine el ciclo
	$tiempoInicio += $dia;
	
}



$ob_reporte ->curso = $curso;
$ob_reporte ->ano = $ano;
$ob_reporte ->retirado =0;
//$ob_reporte ->orden =$ck_orden;
$result_alu =$ob_reporte ->TraeTodosAlumnos($conn);
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
 
<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
<?
if (empty($curso) or empty($desde) or empty($hasta)){
   ## no hace nada
}else{
	?>
 <center>
	<table width="827" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="827">
		
		<div id="capa0">
		<table width="100%">
		  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
		        <font size="1" face="Arial, Helvetica, sans-serif">**Imprimir 
                  horizontal**</font>

<input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	</td>
		
		  </tr></table>
		 
        </div></td>
      </tr>
    </table>
	
   <? if ($institucion=="770"){ 
		   // no muestro los datos de la institucion
		   // por que ellos tienen hojas pre-impresas
		   echo "<br><br><br><br><br><br><br><br><br><br>";
   }  ?>
	
	
  <table width="826" border="0" cellspacing="0" cellpadding="0">
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
  
</table><br>
<br>
<br>	
<table width="826" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="tableindex"><div align="center"> INFORME DE ASISTENCIA SEG&Uacute;N BIT&Aacute;CORA</div></td>
  </tr>
  <tr>
    <td align="center" class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td align="center" class="textosimple"><?php echo CursoPalabra($curso,1,$conn) ?></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><?php echo $desde ?> a <?php echo $hasta ?></strong></span></td>
  </tr>
  <tr>
    <td align="center" class="Estilo2">&nbsp;</td>
  </tr>
</table>
<br><br>
<table  border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="tableindex">
    <td rowspan="2" align="center">ALUMNO</td>
   <?php  for($f=0;$f<count($arr_fechas);$f++){
	   
	   
	   ?>
    <td  nowrap colspan="<?php echo $arr_fechas[$f]['cols'] ?>"><div align="center">&nbsp;<?php echo CambioFD($arr_fechas[$f]['fecha']) ?>&nbsp;</div></td>
  <?php  
		
   }?>
    <td rowspan="2" align="center">Cantidad</td>
    <td rowspan="2" align="center">Debi&oacute; asistir</td>
    <td rowspan="2" align="center">% Asistencia</td>
  </tr>
  <tr class="tableindex">
     <?php  for($f=0;$f<count($arr_fechas);$f++){
		$ob_reporte->curso = $curso;
		$ob_reporte->fecha = $arr_fechas[$f]['fecha'];
		$rs_asig = $ob_reporte->getAsigBitacoraFecha($conn);
		 for($r=0;$r<pg_numrows($rs_asig);$r++){
		$fila_asig = pg_fetch_array($rs_asig,$r);
		 ?>
         
    <td>
    <div align="center">
  <?php echo  Iniciales($fila_asig['nombre']); ?>
    </div></td>
     <?php }
    }?>
  </tr>
   <?php  for($a=0;$a<pg_numrows($result_alu);$a++){
		   $fila_alu = pg_fetch_array($result_alu,$a);
		   $rut_alumno  = $fila_alu['rut_alumno'];
		   $salu=0;
		   
		   ?>
  <tr class="textosimple">
    <td><? $nombre_alumno = ucwords(strtoupper(trim($fila_alu['ape_pat']) .  " " . trim($fila_alu['nombre_alu'])));
	  echo $ob_reporte->tildeM($nombre_alumno);  ?></td>
    <?php  for($f=0;$f<count($arr_fechas);$f++){
		$ob_reporte->curso = $curso;
		$ob_reporte->fecha = $arr_fechas[$f]['fecha'];
		$rs_asig = $ob_reporte->getAsigBitacoraFecha($conn);
		 for($r=0;$r<pg_numrows($rs_asig);$r++){
		$fila_asig = pg_fetch_array($rs_asig,$r);
		 ?>
         
    <td align="center">
   <?php  
    $ob_reporte->ramo =$fila_asig['id_ramo']; 
    $cuentaBi = $ob_reporte->getCantBitacoraDR($conn);
	$tbi[$rut_alumno][]=$cuentaBi;
	
	$ob_reporte->alumno =$rut_alumno;
	$cuentaAsis = $ob_reporte->getCantAsisBitacora($conn);
	 
	?>
    <div align="center">
    <?php  if($cuentaAsis>0){
		 echo $cuentaAsis;
		$tai[$rut_alumno][]=$cuentaAsis;
	 }
	 else{
		echo 0; 
		}?>
    </div></td>
     <?php }
    }?>
    <td align="center">
	<?php  $posibles = array_sum($tbi[$rut_alumno]);
	echo intval($posibles);
	 ?></td>
    <td align="center">
    <?php 
	 $asis = array_sum($tai[$rut_alumno]);
	 echo intval($asis);
	?>
    </td>
    <td align="center"><?php echo round(($asis*100)/$posibles) ?></td>
  </tr>
  <?php }?>
</table>
	
<?	
}



?>




<!-- FIN CUERPO DE LA PAGINA -->
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
</body>
</html>
<? pg_close($conn);?>