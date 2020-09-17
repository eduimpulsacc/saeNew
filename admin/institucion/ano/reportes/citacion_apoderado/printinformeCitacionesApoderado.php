
<?php
require('../../../../../util/header.inc');
include('../../../../clases/class_Reporte.php');
include('../../../../clases/class_Membrete.php');
//print_r($_POST);
	$_POSP = 5;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $cmbANO;
	$curso			= 1;
	$docente		= 5; //Codigo Docente
	$frmModo		= $_FRMMODO;
	$asunto			= $cmbASUNTO;	
	$reporte		= $c_reporte;

	//print_r($_POST);

/*if ($select_cursos>0){
	$Curso_pal = CursoPalabra($curso, 1, $conn);
}*/


	$ob_config = new Reporte();
	$ob_reporte = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
 
	$fecha=$ob_reporte->fecha_actual();
	

	//echo $ob_config->finicio_curso;
	
	/********** AÑO ESCOLAR*****************/
	$ob_membrete = new Membrete();
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	$iniano = $ob_membrete->fecha_inicio;
	$finano = $ob_membrete->fecha_termino;
	
	$d_fini=explode("-",$iniano);
	$d_fter=explode("-",$finano);
	
	//lista de cursos
	$ob_reporte ->ano = $ano;
	$rs_cursos=$ob_reporte->ListadoCurso($conn);
	
	
	/***************periodo******************/
	$rs_periodos=$ob_reporte->TotalPeriodo($conn);
	$cper=pg_numrows($rs_periodos);
	$sigla_per=($cper==2)?"SEM":"TRI";
	
	if($cper==2)
	{
		$corte1="07";
		$corte2="12";
	}
	elseif($cper==3)
	{
		$corte1="05";
		$corte2="08";
		$corte3="12";
	}

		/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
	
		//asnto
		$ob_reporte->asunto=$asunto;
		$rs_asunto=$ob_reporte->traeNombreAsunto($conn);
		$nom_asunto=pg_result($rs_asunto,1);

$atr_mes=array();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

function imprimir(){
Element = document.getElementById("layer1")
Element.style.display='none';
Element = document.getElementById("layer2")
Element.style.display='none';
window.print();
Element = document.getElementById("layer1")
Element.style.display='';
Element = document.getElementById("layer2")
Element.style.display='';
}

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

function exportar(){
		//	window.location='printCartaApoderado_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
			return false;
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
	  <? if($_PERFIL==0){?>		  
		<!--<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">-->
	<? }?>
      </td>
    </tr>
  </table>
</div>
        		
		


		<table width="680"  align="center" border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td><table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
		  <tr>
    <? if ($institucion!="770"){ ?>
    <td width="178" class="item"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
    <td width="10" class="item"><strong>:</strong></td>
    <td width="310" class="item"><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>
    <td width="156" rowspan="3" align="center" valign="top" ><?
					$result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto  = @pg_fetch_array($result,0);
					## c&oacute;digo para tomar la insignia
			
				  if($institucion!=""){
					   echo "<img src='../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?>    </td>
    <? } ?>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>A&Ntilde;O ESCOLAR</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left"><? echo trim($nro_ano) ?></div></td>
  </tr>
  <tr>
    <td class="item"><strong>ASUNTO CITACION</strong></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><?php echo strtoupper($nom_asunto) ?></td>
    </tr>
  
  
        </table>
        <BR><BR>
		
        <table  width="650" border="1" align="center" class="tableindex" style="border-collapse:collapse">
        <tr>
        <td align="center">ESTADISTICA CITACIONES APODERADO</td>
        </tr>
        </table>
        
        <BR>
        <br>
        <table width="650" border="1" align="center" style="border-collapse:collapse">
          <tr class="tableindex">
            <td align="center">CURSO</td>
            <?php for($m=$d_fini[1];$m<=$d_fter[1];$m++){
		$mes=($m<10)?"0".$m:$m;
		?>
            <td colspan="2" align="center"><?php echo envia_mesCorto($mes) ?>&nbsp;</td>
            <?php if($corte1==$mes || $corte2==$mes || $corte3==$mes){
		$pp++;?>
            <td colspan="2" align="center"><?php echo $pp ?>&nbsp;<?php echo $sigla_per; ?>&nbsp;</td>
            <?php }?>
            <?php }?>
            <td colspan="2" align="center">TOT. ANUAL</td>
          </tr>
          <tr class="textosimple">
            <td align="left">&nbsp;</td>
             <?php for($m=$d_fini[1];$m<=$d_fter[1];$m++){
				$mes=($m<10)?"0".$m:$m;?>
            <td align="center">CITADO</td>
            <td align="center">PRESENTE</td>
			   <?php if($corte1==$mes || $corte2==$mes || $corte3==$mes){
		$pp++;?>
          <td align="center" bgcolor="#CCCCCC"><strong>CITADO</strong></td>
            <td align="center" bgcolor="#CCCCCC"><strong>PRESENTE</strong></td>
            <?php }?>
			 <?php }?>
             
            
             <td align="center" bgcolor="#CCCCCC"><strong>CITADO</strong></td>
            <td align="center" bgcolor="#CCCCCC"><strong>PRESENTE</strong></td>
          </tr>
          <?php for($c=0;$c<pg_numrows($rs_cursos);$c++){
	  $fila_curso=pg_fetch_array($rs_cursos,$c);
	  $suma_fila=0;
	  
	 $ob_reporte->curso=$fila_curso['id_curso'];
	 $sum_cur_pres=0;
	 $sum_cur_cit=0;
	 
	  
	  ?>
          
          <tr class="textosimple">
            <td align="left"><?php echo CursoPalabra($fila_curso['id_curso'],1,$conn); ?></td>
              <?php for($m=$d_fini[1];$m<=$d_fter[1];$m++){
				$mes=($m<10 && $m!=$d_fini[1])?"0".$m:$m;
				//$cita_mes=0;
				
				$ob_reporte->mes=$mes;
				$ob_reporte->nro_ano=$nro_ano;
				$ob_reporte->asunto=$asunto;
				$c_cita_mes=$ob_reporte->citacionTotal($conn);
				$c_cita_aus=$ob_reporte->citacionAusente($conn);
				$cita_mes=pg_result($c_cita_mes,0);
				$cita_aus=pg_result($c_cita_aus,0);
				
				$sum_cur_cit=$sum_cur_cit+$cita_mes;
				$sum_cur_pres=$sum_cur_pres+$cita_aus;
				
				$arr_cit_m[$m][]=$cita_mes;
				$arr_cit_a[$m][]=$cita_aus;
				
				$sum_per_cit=$sum_per_cit+$cita_mes;
				$sum_per_aus=$sum_per_aus+$cita_aus;
				
				$sum_ano_cit=$sum_ano_cit+$cita_mes;
				$sum_ano_aus=$sum_ano_aus+$cita_aus;
				
				?>
            <td align="center"><?php echo $cita_mes; ?></td>
            <td align="center"><?php echo $cita_aus; ?></td>
			   <?php if($corte1==$mes || $corte2==$mes || $corte3==$mes){
		$pp++;
		
		
		
		?>
          <td align="center" bgcolor="#CCCCCC"><?php echo $sum_per_cit ?></td>
            <td align="center" bgcolor="#CCCCCC"><?php echo $sum_per_aus ?></td>
            <?php 
			$sum_per_cit=0;
			$sum_per_aus=0;
			 }?>
			 <?php }?>
             
            
            <td align="center" bgcolor="#CCCCCC"><?php echo $sum_cur_cit?></td>
            <td align="center" bgcolor="#CCCCCC"><?php echo $sum_cur_pres ?></td>
          </tr>
          <?php }?>
          <tr class="textonegrita">
            <td align="center"><strong>TOTAL</strong></td>
             <?php for($m=$d_fini[1];$m<=$d_fter[1];$m++){
				$mes=($m<10)?"0".$m:$m;
				$sum_per_t_cit=$sum_per_t_cit+array_sum($arr_cit_m[$m]);
				$sum_per_t_aus=$sum_per_t_aus+array_sum($arr_cit_a[$m]);
				?>
            <td align="center"><?php echo array_sum($arr_cit_m[$m]) ?></td>
            <td align="center"><?php echo array_sum($arr_cit_a[$m]) ?></td>
			   <?php if($corte1==$mes || $corte2==$mes || $corte3==$mes){
		$pp++;
		
		?>
          <td align="center" bgcolor="#CCCCCC"><?php echo $sum_per_t_cit ?></td>
            <td align="center" bgcolor="#CCCCCC"><?php echo $sum_per_t_aus ?></td>
            <?php 
			
			$sum_per_t_cit=0;
			$sum_per_t_aus=0;
			}?>
			 <?php }?>
             
            
            <td align="center" bgcolor="#CCCCCC"><?php echo $sum_ano_cit ?></td>
            <td align="center" bgcolor="#CCCCCC"><?php echo $sum_ano_aus ?></td>
          </tr>
        </table></td>
	  </tr>
</table>
  <?php  
		 $ruta_timbre =5;
		 $ruta_firma =3;
		 $concur=0;
		 include("../firmas/firmas.php");?>
<table width="650" border="0" align="center">
  <tr>
    <td>&nbsp;<hr></td>
  </tr>
  
  <tr>
    <td><div align="right" class="subitem"><?=$fecha;?></div></td>
  </tr>

  
</table>

	
	
   

</body>
</html>
<? pg_close($conn);?>