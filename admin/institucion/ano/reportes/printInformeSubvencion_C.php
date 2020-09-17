<script type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<?php 	require('../../../../util/header.inc');
		include('../../../clases/class_Reporte.php');
		include('../../../clases/class_Membrete.php');
		setlocale(LC_ALL,"es_ES");
	//setlocale("LC_ALL","es_ES");
	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$mes 			=$cmb_meses;	
	$reporte		=$c_reporte;
	$_POSP 			= 4;
	$_bot 			= 8;
	
	if ($mes < 10){
	   $mes = "0".$mes;
	}
	
	

	if (empty($mes)){
	 //exit;
	}else{ 
		if ($mes == 1) $mes_pal = "Enero";
	    if ($mes == 2) $mes_pal = "Febrero";
	    if ($mes == 3) $mes_pal = "Marzo";
	    if ($mes == 4) $mes_pal = "Abril";
	    if ($mes == 5) $mes_pal = "Mayo";
	    if ($mes == 6) $mes_pal = "Junio";
	    if ($mes == 7) $mes_pal = "Julio";
	    if ($mes == 8) $mes_pal = "Agosto";
	    if ($mes == 9) $mes_pal = "Septiembre";
	    if ($mes == 10) $mes_pal = "Octubre";
	    if ($mes == 11) $mes_pal = "Noviembre";
	    if ($mes == 12) $mes_pal = "Diciembre";
	    $dia_1 = "01"; 	$dia_2 = "02"; 	$dia_3 = "03";  $dia_4 = "04";	
	    $dia_5 = "05";	$dia_6 = "06";	$dia_7 = "07";	$dia_8 = "08";	
	    $dia_9 = "09";	$dia_10 = "10";	$dia_11 = "11";	$dia_12 = "12";	
	    $dia_13 = "13";	$dia_14 = "14";	$dia_15 = "15";	$dia_16 = "16";	
	    $dia_17 = "17";	$dia_18 = "18";	$dia_19 = "19";	$dia_20 = "20";	
	    $dia_21 = "21";	$dia_22 = "22";	$dia_23 = "23";	$dia_24 = "24";	
	    $dia_25 = "25";	$dia_26 = "26";	$dia_27 = "27";	$dia_28 = "28";	
	    $dia_29 = "29";	$dia_30 = "30";	$dia_31 = "31";	
	}
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_membrete ->ano =$ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano=$ob_membrete->nro_ano;
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	if(!$cb_ok =="Consultar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Subvencion_$Fecha.xls"); 
	}	


function habiles($mes,$anno){
   $habiles = 0; 
   // Consigo el número de días que tiene el mes mediante "t" en date()
   $dias_mes = date("t", mktime(0, 0, 0, $mes, 1, $anno));
   // Hago un bucle obteniendo cada día en valor númerico, si es menor que 
   // 6 (sabado) incremento $habiles
   for($i=1;$i<=$dias_mes;$i++) {
       if (date("N", mktime(0, 0, 0, $mes, $i, $anno))<6) $habiles++;
   }

   return $habiles;
}


 
 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
function cerrar(){ 
	window.close() 
} 
function exportar(){
	window.location='printInformeSubvencion_C.php?cmb_meses=<?=$mes?>&c_reporte=<?=$reporte?>';
	return false;
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 
                              <!-- INICIO CUERPO DE LA PAGINA -->
 <?
if (empty($mes)){
   ## no hace nada
}else{
   ?>
                             
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
	<td width="700">
	
	<div id="capa0">
		<table width="100%">
		  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
		<td align="right">
			<input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">	
		<? if($_PERFIL == 0){?>								  </td>
		<td align="right"><input name="button32" type="button" class="botonXX" onClick="javascript:exportar();"  value="EXPORTAR"></td>
		<? }?>
	  </tr></table>									
	</div>							
	
	
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
			<td width="85%" class="item"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></td>
			<td width="10">&nbsp;</td>
			<td width="15%" rowspan="6" align="center">
			
			
			  <table width="125" border="0" cellpadding="0" cellspacing="0">
				<tr valign="top">
				  <td width="125" align="center"><?
					if($institucion!=""){
						echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
					}else{
						echo "<img src='".$d."menu/imag/logo.gif' >";
					}?>                                                  </td>
				</tr>
			</table></td>
		  </tr>
		  <tr>
			<td class="item"><? echo ucwords(strtolower($ob_membrete->direccion));?></td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td class="item">Fono: &nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
		    <td class="item">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td class="item">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
	  </table>
	  <br>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="center" class="tableindex">INFORME DE PROYECCI&Oacute;N A LA SUBVENCI&Oacute;N MENSUAL</td>
		  </tr>
		  <tr>
			<td align="center" class="cuadro01"><strong><? echo trim(strtoupper($mes_pal . " " . $ob_membrete->nro_ano)) ;?></strong></td>
		  </tr>
	  </table>
	  <br>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="80%" class="tableindex">Cursos</td>
			<td width="20%" class="tableindex">Subvenci&oacute;n por cursos </td>
		  </tr>
		  <?
		  //tomo todos los cursos de la institucion
			$ob_reporte ->ano = $ano;
			$ob_reporte ->institucion = $institucion;
			$rs_curso = $ob_reporte ->CursoEnsenanza($conn);
											  
		  for ($i=0; $i < @pg_numrows($rs_curso); $i++){
			   $fil_1 = @pg_fetch_array($rs_curso,$i);
			   $id_curso = $fil_1['id_curso'];
			   $val_sub  = $fil_1['val_sub'];
			   
			   // buscar los alumnos de este curso
			   
			   $ob_reporte ->curso = $id_curso;
			   $ob_reporte ->retirado=0;
			   $rs_alumno = $ob_reporte ->TraeTodosAlumnos($conn);
			   $cant_alu =@pg_numrows($rs_alumno);
			   $matricula_mensual = @pg_numrows($rs_alumno) * habiles($mes,$nro_ano);; 
			   /// ciclo de los alumnos											   
			   $subvencion_alumno =0;
			   $subvencion = 0;
			   
			  $sql_3 = "select count(*) as cantidad from asistencia where ano=".$ano." AND id_curso=".$id_curso." and date_part('month',fecha)=".$mes; 	
			   $res_3 = @pg_Exec($conn,$sql_3);
			   $fil_3 = @pg_fetch_array($res_3,0);
			   
			  $inasistencia = $fil_3['cantidad'];
			  $Matricula_real = $matricula_mensual - $inasistencia;
			  $porcentaje = ($Matricula_real * 100) / $matricula_mensual;
			  
			  $subvencion = (($val_sub * $cant_alu) * $porcentaje) / 100;
		   ?>
		  <tr>
			<td class="subitem"><? echo CursoPalabra($id_curso, 1, $conn);?></td>
			<td class="subitem"><div align="right"><?=number_format(round($subvencion),'0',',','.'); ?></div></td>
		  </tr>
		  <?										
			$subvencion_curso = $subvencion_curso + round($subvencion);
													
		  } ?>
		  <tr>
			<td class="subitem">&nbsp;</td>
			<td class="subitem">&nbsp;</td>
		  </tr>
		  <tr>
			<td><div align="right" class="item">Total proyecci&oacute;n de subvenci&oacute;n mensual </div></td>
			<td><div align="right" class="subitem">$
	          <?=number_format($subvencion_curso,'0',',','.')  ?>
			</div></td>
		  </tr>
	  </table></td>
  </tr>
</table>
<?	} ?>
<!-- FIN CUERPO DE LA PAGINA -->
                              
</body>
</html>
<? pg_close($conn);?>