<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
//exit;
?>
<?php
require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');
//print_r($_POST);
//exit;
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $txt_ano;
	$curso			= 1;
	$frmModo		= $_FRMMODO;
	$reporte		= $c_reporte;

	//print_r($_POST);

/*if ($select_cursos>0){
	$Curso_pal = CursoPalabra($curso, 1, $conn);
}*/


	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	

	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
 

	$ob_reporte->ano=$ano;
	$ob_reporte->fecha=CambioFE($txt_fecha);
	//$rs_cursos = $ob_reporte->ListadoCurso($conn);
	$rs_tipo = $ob_reporte ->tEnsenanzaAno($conn);
	//echo pg_numrows($rs_cursos);
	$ob_reporte ->AnoEscolar($conn);
	
	
		/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);


?>
<?
	$sql_institu = "SELECT institucion.rdb, institucion.dig_rdb, institucion.nombre_instit, institucion.calle, institucion.nro, institucion.telefono, region.nom_reg, provincia.nom_pro, comuna.nom_com ";
	$sql_institu = $sql_institu . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (region.cod_reg = provincia.cod_reg)) INNER JOIN comuna ON (provincia.cod_reg = comuna.cod_reg) AND (provincia.cor_pro = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$rdb = $fila_institu['rdb'] . "-" . $fila_institu['dig_rdb'];
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro']));
	$telefono = $fila_institu['telefono'];
	$comuna = ucwords(strtolower($fila_institu['nom_com']));
	$ciudad = ucwords(strtolower($fila_institu['nom_pro']));
	$region = ucwords(strtolower($fila_institu['nom_reg']));
?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 

<!-- INICIO CUERPO DE LA PAGINA -->

<?
	
				
?>
        
        
<div id="capa0">
  <table width="650" align="center">
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
      </td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	  
      </td>
    </tr>
  </table>
</div><br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
    <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($nombre_institu));?></strong></font></td>
    <td width="10">&nbsp;</td>
    <td width="125" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td width="125" align="center">
            <?
						if($institucion!=""){
						   echo "<img src='../../../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='../../../../../../menu/imag/logo.gif' >";
						}?></td>
		</tr>
      </table>
	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono: &nbsp;<? echo ucwords(strtolower($telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
            <td height="41" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>  
</table><br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr class="tableindex">
    <td align="center">MATR&Iacute;CULA POR G&Eacute;NERO AL <?php echo fecha_espanol($txt_fecha) ?></td>
  </tr>
</table>

<br>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="tableindex">
    <td rowspan="2" align="center">CURSO</td>
    <td rowspan="2" align="center">MAT.<br> <?php echo $ob_reporte ->nro_ano ?></td>
    <td rowspan="2" align="center">H</td>
    <td rowspan="2" align="center">M</td>
    <td colspan="2" align="center">ALTAS</td>
    <td rowspan="2" align="center">TOTAL<br>
    ALTAS</td>
    <td colspan="2" align="center">BAJAS</td>
    <td rowspan="2" align="center">TOTAL<br>
    BAJAS</td>
    <td rowspan="2" align="center">MAT.<br>
      TOTAL</td>
  </tr>
  <tr class="tableindex">
    <td align="center">H</td>
    <td align="center">M</td>
    <td align="center">H</td>
    <td align="center">M</td>
  </tr>
 <?php  for($i=0;$i<pg_numrows($rs_tipo);$i++){
	 $fila_tipo = pg_fetch_array($rs_tipo,$i);
	 $ob_reporte->ensenanza =$fila_tipo['cod_tipo'];
	 $rs_cursos = $ob_reporte->ListadoCurso($conn);
	 
	 for($j=0;$j<pg_numrows($rs_cursos);$j++){
		 $fila_curso = pg_fetch_array($rs_cursos,$j);
		 $ob_reporte->curso = $fila_curso['id_curso'];
		 $rs_cuenta = $ob_reporte->cuenMatriculaFecha($conn);
		 $f_inicio = $fila_curso['fecha_inicio'];
		 $tot_altas=0;
		 $tot_bajas=0;
		 $tot_mat=0;
		 
		 ?>
  <tr class="textosimple">
    <td><?php echo CursoPalabra($fila_curso['id_curso'],1,$conn)?></td>
    <td align="center"><?php echo pg_result($rs_cuenta,0);
	$sum_mat_ense[$fila_tipo['cod_tipo']][]=pg_result($rs_cuenta,0);
	$mat_cur = pg_result($rs_cuenta,0);
	 ?></td>
    <td align="center">
	<?php 
		$ob_reporte->sexo=2;
	 	$rs_cuentamh = $ob_reporte->cuenMariculaSexo($conn);
		echo pg_result($rs_cuentamh,0);
		
		$sum_mat_ense_h[$fila_tipo['cod_tipo']][]=pg_result($rs_cuentamh,0);
	?></td>
    <td align="center"><?php 
		$ob_reporte->sexo=1;
	 	$rs_cuentamm = $ob_reporte->cuenMariculaSexo($conn);
		echo pg_result($rs_cuentamm,0);
		
		$sum_mat_ense_m[$fila_tipo['cod_tipo']][]=pg_result($rs_cuentamm,0);
	?></td>
    <td align="center">
	<?php 
	$ob_reporte->sexo=2;
	$ob_reporte->fecha_inicio= $f_inicio;
	$ob_reporte->fecha_fin= CambioFE($txt_fecha);
	$rs_altah = $ob_reporte->cuenMatriculaAlta($conn);
	echo pg_result($rs_altah,0);
	
	
	$sum_mat_alta_h[$fila_tipo['cod_tipo']][]=pg_result($rs_altah,0);
	$tot_altas= $tot_altas+pg_result($rs_altah,0);
	$alta_t[$fila_tipo['cod_tipo']][]=pg_result($rs_altah,0)
	  ?></td>
    <td align="center"><?php 
	$ob_reporte->sexo=1;
	$ob_reporte->fecha_inicio= $f_inicio;
	$ob_reporte->fecha_fin= CambioFE($txt_fecha);
	$rs_altam = $ob_reporte->cuenMatriculaAlta($conn);
	echo pg_result($rs_altam,0);
	$sum_mat_alta_m[$fila_tipo['cod_tipo']][]=pg_result($rs_altam,0);
	$tot_altas= $tot_altas+pg_result($rs_altam,0);
	$alta_t[$fila_tipo['cod_tipo']][]=pg_result($rs_altam,0);
	  ?></td>
    <td align="center"><?php echo $tot_altas ?></td>
    <td align="center"><?php 
	$ob_reporte->sexo=2;
	$ob_reporte->fecha_inicio= $f_inicio;
	$ob_reporte->fecha_fin= CambioFE($txt_fecha);
	$rs_bajah = $ob_reporte->cuenMatriculaBaja($conn);
	echo pg_result($rs_bajah,0);
	
	$tot_bajas= $tot_bajas+pg_result($rs_bajah,0);
	$sum_mat_baja_h[$fila_tipo['cod_tipo']][]=pg_result($rs_bajah,0);
	$baja_t[$fila_tipo['cod_tipo']][]=pg_result($rs_bajah,0)
	  ?></td>
    <td align="center"><?php 
	$ob_reporte->sexo=1;
	$ob_reporte->fecha_inicio= $f_inicio;
	$ob_reporte->fecha_fin= CambioFE($txt_fecha);
	$rs_bajam = $ob_reporte->cuenMatriculaBaja($conn);
	echo pg_result($rs_bajam,0);
	$tot_bajas= $tot_bajas+pg_result($rs_bajam,0);
	$sum_mat_baja_m[$fila_tipo['cod_tipo']][]=pg_result($rs_bajam,0);
	$baja_t[$fila_tipo['cod_tipo']][]=pg_result($rs_bajam,0)
	  ?></td>
    <td align="center"><?php echo $tot_bajas;?></td>
    <td align="center">
    <?php echo  $tot_mat=($mat_cur+$tot_altas)-$tot_bajas;
	$totm[$fila_tipo['cod_tipo']][]=$tot_mat;
	   ?>
    </td>
  </tr>
  <?php }?>
  <tr class="tableindex">
    <td>Total <?php echo $fila_tipo['nombre_tipo'] ?></td>
    <td align="center"><?php echo 
	
	array_sum($sum_mat_ense[$fila_tipo['cod_tipo']]);
	$tmt = $tmt+array_sum($sum_mat_ense[$fila_tipo['cod_tipo']]);;
	
	  ?></td>
    <td align="center"><?php echo array_sum($sum_mat_ense_h[$fila_tipo['cod_tipo']]);
	$tmh=$tmh+  array_sum($sum_mat_ense_h[$fila_tipo['cod_tipo']]);
	 ?></td>
    <td align="center"><?php echo array_sum($sum_mat_ense_m[$fila_tipo['cod_tipo']]); 
	$tmm = $tmm+array_sum($sum_mat_ense_m[$fila_tipo['cod_tipo']]);
	 ?></td>
    <td align="center"><?php echo array_sum($sum_mat_alta_h[$fila_tipo['cod_tipo']]);
	$ah=$ah+array_sum($sum_mat_alta_h[$fila_tipo['cod_tipo']]);
	 ?></td>
    <td align="center"><?php echo array_sum($sum_mat_alta_m[$fila_tipo['cod_tipo']]);
	$am= $am+array_sum($sum_mat_alta_m[$fila_tipo['cod_tipo']]);
	 ?></td>
    <td align="center"><?php echo array_sum($alta_t[$fila_tipo['cod_tipo']]); 
	$tota=$tota+array_sum($alta_t[$fila_tipo['cod_tipo']]);;
	 ?></td>
    <td align="center"><?php echo array_sum($sum_mat_baja_h[$fila_tipo['cod_tipo']]);
	$bajah=$bajah+array_sum($sum_mat_baja_h[$fila_tipo['cod_tipo']]);;
	 ?></td>
    <td align="center"><?php echo array_sum($sum_mat_baja_m[$fila_tipo['cod_tipo']]);
	$bajam=$bajam+array_sum($sum_mat_baja_m[$fila_tipo['cod_tipo']]);
	 ?></td>
    <td align="center"><?php echo array_sum($baja_t[$fila_tipo['cod_tipo']]);
	$totb=$totb+array_sum($baja_t[$fila_tipo['cod_tipo']]);
	 ?></td>
    <td align="center"><?php echo array_sum($totm[$fila_tipo['cod_tipo']]);
	$matt=$matt+array_sum($totm[$fila_tipo['cod_tipo']]);
	 ?></td>
  </tr>
  
  <?php }?>
  <tr class="tableindex">
    <td>TOTAL GENERAL</td>
    <td align="center"><?php echo $tmt; ?></td>
    <td align="center"><?php echo $tmh; ?></td>
    <td align="center"><?php echo $tmm ?></td>
    <td align="center"><?php echo $ah ?></td>
    <td align="center"><?php echo $am ?></td>
    <td align="center"><?php echo $tota ?></td>
    <td align="center"><?php echo $bajah ?></td>
    <td align="center"><?php echo $bajam ?></td>
    <td align="center"><?php echo $totb ?></td>
    <td align="center"><?php echo $matt ?></td>
  </tr>
</table>

<br>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 
		 include("../../firmas/firmas.php");?>
 <?
	    echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	
	?>
	
    
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr >
    <td class="textosimple"><?   $fecha = date("d-m-Y");
	 $txf = ($_INSTIT!=25478)?fecha_espanol($fecha):fecha_espanol_min($fecha);
	 ?><? echo (trim($ob_membrete->comuna). ", ". $txf)?></td>
  </tr>
</table>

</body>
</html>
<? pg_close($conn);?>