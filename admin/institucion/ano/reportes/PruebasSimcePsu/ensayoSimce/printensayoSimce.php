<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<SCRIPT language="JavaScript">
			
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
			
				

				
									
</script>

<?
require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');



	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$select_anos;
	$curso			=$select_cursos;
	$ramo			=$sel_ramo;
	$reporte		=$c_reporte;
	$total          =$anual;
	
	$_POSP = 6;
	$_bot = 8;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	$ob_reporte ->curso = $curso;
	$ob_reporte ->ano = $ano;
	$ob_reporte->ramo=$ramo;
	$ob_reporte ->ProfeSubsector($conn);	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$rs_ramo = $ob_reporte->ramoUNO($conn);
	$ramo_Pal=strtoupper(pg_result($rs_ramo,1));
	
	$ob_reporte->AnoEscolar($conn);
	
	
	/************** FIRMA ***********************/
		$ob_reporte->rdb=$institucion;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
		$ob_reporte->item=$reporte;
		
	
		
		if($_PERFIL!=0 && $_PERFIL!=14){
			//veo si tiene autorizacion permanente
			$autp=$ob_reporte->checAutReporteTrabaja($conn);
			$aut = pg_result($autp,0);
			//echo "aut->".$aut;
			
		
			if($aut==0){
				//veo si el usuario tiene el reporte
				$ob_reporte->rdb=$institucion;
				$ob_reporte->usuario= $_NOMBREUSUARIO;
				$ob_reporte->item=$reporte;
				$rp = $ob_reporte->checAutReporte($conn);
				$crp= pg_numrows($rp);
				//echo "aut2->".$crp;
			
				}
				else{
				$crp = $aut;
				}
				
				$rs_quita = $ob_reporte->quitaAutReporte($conn);
		}
		else{
		$crp=1;
		}




?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
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



function exportar(){
		window.location='printInformeAnotacionesCurso_C.php?cmb_periodos=<?=$periodo?>&cmb_curso=<?=$curso?>&anual=<?=$total?>&xls=1';
			return false;
		  }
			


//-->
</script>
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
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<!-- INSERTO CUERPO DE LA PÁGINA -->
	   
<?
if ($curso != 0){
   
   ?>
<form method "post" name="form" action="../../printInformeAnotacionesCurso_C.php" target="_blank">

    <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
    <td>
	   <div id="capa0">
	     <table width="100%">
	       <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
	       <td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
		  
	      </td></tr>
		 </table>
      </div>
	</td>
    </tr>
   </table>
 
<br>
<?
	$ob_membrete ->institucion =$institucion;
	$ob_membrete ->institucion($conn);
	

?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
			<?	
				if($institucion!=""){
					echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
				}else{
					echo "<img src='".$d."menu/imag/logo.gif' >";
				}
			?>
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
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex"><div align="center">INFORME ENSAYOS SIMCE</div></td>
  </tr>
  <tr>
</table>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        
        <tr>
          <td width="124"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Curso</strong></font></td>
          <td width="14" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
          <td width="512"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $Curso_pal?></font></td>
        </tr>
        <tr>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Asignatura</strong></font></td>
          <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $ramo_Pal?></font></td>
        </tr>
        <tr>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Docente</strong></font></td>
          <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $ob_reporte->nombre_ape?></font></td>
        </tr>
        <tr>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>A&ntilde;o Acad&eacute;mico</strong></font></td>
          <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $ob_reporte->nro_ano?></font></td>
        </tr>
</table>
<br>
<br>
<?php 
$ob_reporte->id_curso=$curso;
$ob_reporte->id_ramo=$ramo;
$rs_fecha = $ob_reporte->listaPuntajeSimce($conn);
//echo "fecha->".pg_numrows($rs_fecha);
$rs_alu = $ob_reporte->TraeTodosAlumnos($conn);?>

<table border="1" align="center"  cellspacing="0">

  <tr class="tableindex">
    <td width="200">Alumno</td>
    <?php  for($x=0;$x<@pg_numrows($rs_fecha);$x++){
	   $fila_fecha=pg_fetch_array($rs_fecha,$x);?>
    <td align="center"><strong>&nbsp;<?php echo CambioFDSN($fila_fecha['fecha']) ?>&nbsp; </strong></td>
    
    <?php }?>
   <!-- <td align="center">Variaci&oacute;n</td>-->
    <td align="center">Desv.<br> &nbsp;Est&aacute;ndar&nbsp;</td>
  </tr>
  
  <?php for($a=0;$a<pg_numrows($rs_alu);$a++){
	  $fila_alu = pg_fetch_array($rs_alu,$a);
	  $ob_reporte->CambiaDato($fila_alu);
	  $sumvp2=0;
	  $promvarp1=0;
	  
	  ?>
  <tr class="textosimple">
    <td width="200"><?php echo $ob_reporte->ape_nombre_alu ?></td>
    <?php  
	for($y=0;$y<@pg_numrows($rs_fecha);$y++){
		  $fila_fecha2=pg_fetch_array($rs_fecha,$y);
		 	 
		  ?>
    <td align="center">
	<?php
	$ob_reporte->rut_alumno= $fila_alu['rut_alumno'];
	$ob_reporte->fecha=$fila_fecha2['fecha'];
	 $result3=$ob_reporte->puntajeAlumnoSimce($conn);
	 
	//var_dump($result3);
	$puntaje = pg_result($result3,5);
	
	 
	echo ($puntaje==0)?"S/I":$puntaje;
	
	$arr_varp1[$fila_alu['rut_alumno']][$y]=$puntaje;
	
	 ?></td>
  	<?php $desv =1?> 
	  <?php }?> 
     <!-- <td align="center">-->
      <?php 
	  //paso 1: calcular promedio
	   $promvarp1 = array_sum($arr_varp1[$fila_alu['rut_alumno']])/count($arr_varp1[$fila_alu['rut_alumno']]);
	 //paso 2: restarle a cada uno de los valores el promedio y el resultado elevarlo al ^2
	for($vr=0;$vr<count($arr_varp1[$fila_alu['rut_alumno']]);$vr++){
	 $sumvp2= $sumvp2+ pow(($promvarp1-$arr_varp1[$fila_alu['rut_alumno']][$vr]),2);
	}
	 $varianza= $sumvp2/(count($arr_varp1[$fila_alu['rut_alumno']])-1);
	// echo round($varianza,2);
	  ?>
      
      <!--</td>-->
    <td align="center"><?php echo round(sqrt($varianza),2); ?></td>
  </tr>
  <?php  } ?>
</table>

<br>
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
</form>

	   </center>
<? } ?>   
       <!-- FIN CUERPO DE LA PAGINA -->					  
</p>
</body>
</html>
<? pg_close($conn);?>