<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');

$_POSP = 4;
$_bot = 8;

//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodos;
	$reporte		=$c_reporte;
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_reporte ->curso = $curso;
	$ob_reporte ->ProfeJefe($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Asistencia_Por_Horas_Periodo_$Fecha.xls"); 
	}	
?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'InformeAsistenciaPeriodo.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
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
function exportar(){
			//form.target="_blank";
			window.location='printInformeAsistenciaPeriodo_C.php?cmb_curso=<?=$curso?>&cmb_periodos=<?=$periodo?>&c_reporte=<?=$reporte?>';
			//document.form.submit(true);
		return false;
}
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
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
		  <td align="right"><input name="button32" type="button" class="botonXX" onClick="javascript:exportar()"  value="EXPORTAR"></td>
		  <? }?>
		  </tr>
        </table>
      </div></td>
   </tr>
  </table>
  <?
}

	if ($curso == 0)
	{
		//$sql_curso = "select * from curso where id_ano= ".$ano ." order by ensenanza, grado_curso, letra_curso";
		//$result_curso = @pg_Exec($conn, $sql_curso);
	}
	else
	{
		$sql_curso = "select * from curso where id_curso = ".$curso;
		$result_curso = @pg_Exec($conn, $sql_curso);
	}
		$Curso_pal = CursoPalabra($curso, 0, $conn);
	
?>


<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br>";
  }
  
 ?>

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
      
	
   <? if ($institucion=="770"){ 
		  
     }else{  ?>  
	  
		  <table width="125" border="0" cellpadding="0" cellspacing="0">
			<tr valign="top">
			  <td width="125" align="center"> 
				<?
				if($institucion!=""){
				    echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
			    }else{
				    echo "<img src='".$d."menu/imag/logo.gif' >";
			    } ?>
		  </td>
			</tr>
		  </table>
  <? } ?>	  
	  
	  
	  
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
    <td align="center" class="tableindex">INFORME DE ASISTENCIA POR PERIODO</td>
    </tr>
  <tr>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><strong><? echo $periodo_pal;?></strong></font></div></td>
    </tr>
</table>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="118"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Curso</strong></font></div></td>
    <td width="10"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
    <td width="522"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $Curso_pal?></font></div></td>
  </tr>
  <tr>
    <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor(a) Jefe </strong></font></div></td>
    <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></div></td>
    <td><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $ob_reporte->tildem($ob_reporte->profe_jefe);?></font></div></td>
  </tr>
</table>
<br>
<table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="21" align="center" bgcolor="#999999" class="item">N&ordm;</td>
    <td width="365" align="center" bgcolor="#999999" class="item">NOMBRE DEL ALUMNO</td>
    <td width="111" align="center" bgcolor="#999999" class="item">DIAS INASISTENTE</td>
    <td width="143" align="center" bgcolor="#999999" class="item">PORCENTAJE ASISTENCIA</td>
  </tr>
  <?
	$ob_reporte ->periodo = $periodo;
	$ob_reporte ->Periodo($conn);
	
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ano = $ano;
	$ob_reporte ->orden= $ck_orden;
	$res_alu = $ob_reporte ->TraeTodosAlumnos($conn);
	
	for($i=0; $i<@pg_numrows($res_alu); $i++){
	$x = $i +1;
	$fila_alu = pg_fetch_array($res_alu,$i);
	/****** ASISTENCIA ******/
	$ob_reporte->alumno = $fila_alu['rut_alumno'];
	$ob_reporte->fecha1 = $ob_reporte->fecha_inicio;
	$ob_reporte->fecha2 = $ob_reporte->fecha_termino;
	$ob_reporte->ano =$ano;
	$res_asistencia = $ob_reporte->Asistencia($conn);
	$tot_asistencia = pg_numrows($res_asistencia);
	$dias_habiles = $ob_reporte->dias_habiles;
	/***** JUSTIFICA ASISTENCIA *****/
	$ob_reporte->alumno = $fila_alu['rut_alumno'];
	$ob_reporte->fecha1 = $ob_reporte->fecha_inicio;
	$ob_reporte->fecha2 = $ob_reporte->fecha_termino;
	$ob_reporte->ano =$ano;
	$res_justifica = $ob_reporte->JustificaAsistencia($conn);
	$fila_justifica = @pg_fetch_array($res_justifica);
	$justifica = @pg_numrows($res_justifica);
	$justifica_tot =  $tot_asistencia - $justifica;
	
	if ($dias_habiles>0)	
		$porcentaje = round((($dias_habiles-$justifica_tot)*100)/$dias_habiles,2);
        ?>
	    <tr>
		  <td align="center" class="subitem"><? echo $x;?></td>
		  <td class="subitem"><? echo $ob_reporte->tilde(trim(ucfirst(strtolower($fila_alu['ape_pat'])))." ".trim(ucfirst(strtolower($fila_alu['ape_mat']))).", ".trim(ucfirst(strtolower($fila_alu['nombre_alu']))));?></td>
		  <td align="center" class="subitem"><? echo $justifica_tot;?></td>
		  <td align="center" class="subitem"><? echo $porcentaje."%";?></td>
	    </tr>
 <? } ?>
</table>
 

<table width="650" border="0" align="center">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>
<br>
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
</html>
<? pg_close($conn);?>