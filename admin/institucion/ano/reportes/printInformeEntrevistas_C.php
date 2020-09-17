<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}


</script>
<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

	//setlocale("LC_ALL","es_ES");

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$alumno 		=$cmb_alumno;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_reporte ->ano = $ano;
	$ob_reporte ->AnoEscolar($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);


if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Informe_de_entrevistas_$fecha_actual.xls"); 	 
}	 
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
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



function exportar(form){
		form.target="_blank";
		form.action='printInformeEntrevistas_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
		form.submit(true);
}
//-->
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">

<!-- AQUÍ EL CONTENIDO CENTRAL DE LA PÁGINA -->
<?
if ($curso != 0){
   ?><br> 
  <form name="form" method="post" action="printInformeEntrevistas_C.php" target="_blank">
 
  <table width="650" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div id="capa0">
	  <tablE width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
           <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		   <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR">
										<? }?>
	    </td></tr></table>
	</div>
	</td>
  </tr>
</table><br>
<?
}

	if ($alumno > 0)
	{
		$ob_reporte->ano = $ano;
		$ob_reporte->alumno = $alumno;
		$result_alumno= $ob_reporte->FichaAlumnoUno($conn);
	}else{
		$ob_reporte->ano = $ano;
		$ob_reporte->curso = $curso;
		$ob_reporte->retirado = 0;
		$result_alumno= $ob_reporte->FichaAlumnoTodos($conn);
	}	

	$cantidad_alumnos = @pg_numrows($result_alumno);
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++){
		$fila_alumno = @pg_fetch_array($result_alumno,$i);
		$ob_reporte ->CambiaDato($fila_alumno);
?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	   <?
		if($institucion!=""){
		   echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
	    }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	    }
	  ?>
	</td>
    <td><div align="center" class="titulo"><b> DIRECCI&Oacute;N ACAD&Eacute;MICA E INSPECTOR&Iacute;A </b></div></td>
    <td><div align="right">&nbsp;
	<?
	$result = @pg_Exec($conn,"select * from alumno where rut_alumno=".$alumno);
	$arr=@pg_fetch_array($result,0);
	$fila_foto = @pg_fetch_array($result,0);
	
	if 	(!empty($fila_foto['foto'])){
		$output= "select lo_export(".$arr['foto'].",'/var/www/html/tmp/".$arr[rut_alumno]."');";
		$retrieve_result = @pg_exec($conn,$output);?> 
		
		<img src=../../../../../../../infousuario/images/<? echo $alumno ?> ALT="FOTO"  height="100">
  <? } ?>	
	</div></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td class="tableindex"><div align="center">REGISTRO DE ENTREVISTAS - <?=$Nro_Ano?> </div></td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><div align="right" class="item"><b>PROFESOR JEFE : </b></div></td>
    <td class="subitem">      <?php
			$ob_reporte->curso = $curso;
			$ob_reporte ->ProfeJefe($conn);
			echo $ob_reporte->tildeM($ob_reporte ->profe_jefe);
			?>         </td>
  </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><strong class="item">Alumno (a) : </strong></td>
    <td class="subitem">      <?=$ob_reporte->tilde($ob_reporte->nombres);?>    </td>
    <td ><strong class="item">Curso : </strong></td>
    <td class="subitem">      <? $Curso_pal = CursoPalabra($curso,1,$conn); echo "$Curso_pal"; ?>    </td>
    <td ><strong class="item"> N&ordm; Lista : </strong></td>
    <td class="subitem" >&nbsp;      <?=$ob_reporte->num_matricula; ?>    </td>
  </tr>
</table>
<br>
<br>
<table width="650" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="3"><div align="center" class="titulo"><font face="Verdana, Arial, Helvetica, sans-serif" size="3"><b>ENTREVISTAS - <?=$ob_reporte->nro_ano;?> </b></font></div></td>
  </tr>
  <tr>
    <td colspan="3"><div align="center">
      <hr size="1">
    </div></td>
  </tr>
  <?
  	$ob_reporte->ano = $ano;
	$ob_reporte->institucion = $institucion;
	$res = $ob_reporte ->Entrevista($conn);
	$num = @pg_numrows($res);
  
  for ($x=0; $x < $num; $x++){
      $fil = @pg_fetch_array($res,$x);
	  
	  $fecha = $fil['fecha'];
	  $asunto = $fil['asunto'];
	  $observaciones = $fil['observaciones'];
	  
	  ?>	
	  <tr>
		<td width="15%" valign="top" class="subitem" ><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"> <? impF($fecha); ?></font></td>
		<td width="25%" valign="top" class="subitem" ><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><?=$asunto ?></font></td>
		<td width="60%" valign="top" class="subitem" ><font face="Verdana, Verdana, Arial, Helvetica, sans-seri" size="1"><?=nl2br($observaciones) ?></font></td>
	  </tr>
	  <tr>
	    <td colspan="3" valign="top" ><hr size="1"></td>
  </tr>
	  <?
  }
  
  ?>  
</table>
<br><br><br>
<table width="650" border="0">
		   <tr>
		  	<?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
                
			<td width="25%" class="item" height="100"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><span class="item"><?=$ob_reporte->nombre_emp;?> </span><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			<? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 2 encontrado";
	             }else{
	               "Archivo Firma 2 no existe"; 
		        }
				if(isset($firmadig2)){
				echo $firmadig2;
				}else{
				?>
		    <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"> 
		      <div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 3 encontrado";
	             }else{
	               "Archivo Firma 3 no existe"; 
		        }
				if(isset($firmadig3)){
				echo $firmadig3;
				}else{
				
				?>
			<td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? }} ?>
			 <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				echo $firmadig4;
				}else{
		?>
		  <td width="25%" class="item"><div style="width:100; height:50;"></div><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?> </div></td>
			<? }}?>
		  </tr>
		</table>
</form>

<? 
if  (($cantidad_alumnos - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
}

?>
</body>
</html>
<? pg_close($conn);?>