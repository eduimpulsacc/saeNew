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
	$curso			=1;
	$periodo		=$cmb_periodos;
	$reporte		=$c_reporte;
	
	
	
	$sql_periodo = "select nombre_periodo from periodo where id_periodo = $periodo";
	$rs_periodo = @pg_exec($conn,$sql_periodo)or die("fallo");
	$fila_per = @pg_fetch_array($rs_periodo);
	$periodo_pal = $fila_per['nombre_periodo'];
	
	
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
	
	
	$lista_emp = $ob_reporte->Empleado($conn);
	
	$ob_reporte ->periodo = $periodo;
	$ob_reporte ->Periodo($conn);
	
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ano = $ano;
	$ob_reporte ->tipo=2;
	
	$finicio_periodo = $ob_reporte->fecha_inicio;
	$parmi=explode("-",$finicio_periodo);
	$mesi=$parmi[1];
	
	$ftermino_periodo = $ob_reporte->fecha_termino;
	$parte=explode("-",$ftermino_periodo);
	$mest=$parte[1];
	
	
	for($m=$mesi;$m<=$mest;$m++){
	 $mes=($m<10 && $m!=$mesi)?"0$m":$m;
	 
	 $armes[]=envia_mesCorto($mes);
	 
	 $fin = dia_mes($mes,$parte[0]);
	 
	 
	 
	 if($mes==$mesi){
	 $finicio = $finicio_periodo;
	 }else{
		  $finicio = $parte[0]."-".$mes."-01";
	 }
	 
	 if($mes==$mest){
	     $termino = $ftermino_periodo;
	 }else{
		 $termino = $parte[0]."-".$mes."-".$fin;
	 }
	
	 
	//echo $finicio."..".$termino."<br>";
	$ob_reporte->fecha_inicio = $finicio;
	$ob_reporte->fecha_termino = $termino;
	 
 	 $dfer = DiasTrabajados($ano,$finicio, $termino) * pg_numrows($lista_emp)."<br>";
	
	  $ina=$ob_reporte->InasistenciaDocenteMesTodos($conn);
	 $inasistencia = pg_numrows($ina);
	 $arfal[]=round(100-(($inasistencia*100)/$dfer),1);
	 
	 
	}
	
	
	
	
?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<script type="text/javascript" src="../../../../../clases/highcharts/js/highcharts2.js"></script>
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
<center>
   <table width="650" border="0" cellspacing="0" cellpadding="0">
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




<table width="650" border="0" cellspacing="0" cellpadding="0">
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
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" class="tableindex"><div style="text-align:center">GR&Aacute;FICO DE ASISTENCIA POR PERIODO</div></td>
    </tr>
  <tr>
    <td><br><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><strong><? echo $periodo_pal;?> DE <?php echo $parmi[0] ?></strong></font></div></td>
    </tr>
</table>
<br>
<div id="container" style="width: 650px; height: 400px; margin: 0 auto"></div>
<br>
 <br>
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("firmas/firmas.php");?><br>

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
 <? 
 if  (($cantidad_cursos - $i)<>1) 
	  echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
// } ?>

</center>
<!-- FIN CUERPO DE LA PAGINA -->
</body>
<script>

Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [
		<?php for($am=0;$am<count($armes);$am++){
			echo  "'".$armes[$am]."',";
			}?>
		]
    },
    yAxis: {
		 min: 0,
            max: 100,
            tickInterval: 10,

        title: {
            text: ''
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
	credits: {
        enabled: false
    },
    series: [{
        name: '% Asistencia Empleado',
        data: [<?php for($am=0;$am<count($arfal);$am++){
			echo  $arfal[$am].",";
			}?>]
    }]
});
</script>
</html>
<? pg_close($conn);?>