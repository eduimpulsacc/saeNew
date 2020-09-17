<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
require('../../../../../../util/header.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');

setlocale(LC_TIME, "es_ES");
	
	//print_r($_POST);
	
	
	//echo "<br>".pg_dbname();
	//setlocale("LC_ALL","es_ES");
		$institucion	=$_INSTIT;
		$corporacion;
		$ano			=$_ANO;
		$reporte		=$c_reporte;
		$curso			=$c_curso;
		$periodo		=$c_periodos;
		$_POSP = 6;
		$_bot = 9;
	
	//echo $ck_justifica;
	
	/*if($_PERFIL==0){
		$sql ="SELECT num_corp FROM corp_instit WHERE rdb=".$institucion;
		$rs_corp = @pg_exec($conn,$sql);
		$corporacion = @pg_result($rs_corp,0);
	}else{
		$corporacion =$_CORPORACION;
	}*/
	 
	//----------
	 $sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//----------
	// $curso			=$cmb_curso;
	
	
	//-----------------------------------------
   	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	$ob_reporte ->ano = $ano;
	$ob_reporte ->curso = $curso;
	$ob_reporte ->orden = $ck_orden;
	$ob_reporte ->retirado=0;
	$result_alumno = $ob_reporte ->TraeTodosAlumnos($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_General_Asistencia_$Fecha.xls"); 
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
//-->
</script>

<script> 
function exportar(){
			//form.target="_blank";
			window.location='printInformeGeneralAsistencia_C.php?cmb_curso=<?=$curso?>&fecha1=<?=$fechaini?>&fecha2=<?=$fechafin?>&c_reporte=<?=$reporte?>';
			//document.form.submit(true);
		return false;
}
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->

<?
if (empty($curso)){
  ## no hace nada
}else{
   ?>  

  <form action="" method="get">
    <center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>

	<div id="capa0">
	<table width="100%">
	  <tr>
	<td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
	<td align="right">
      <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">	  </td>

	<td align="right"><input name="button32" type="button" class="botonXX" onClick="javascript:exportar()"  value="EXPORTAR"></td>

	  </tr></table>
	 </div>
</td>
  </tr>
</table>

 <? if ($institucion=="770"){ 
		 echo "<br><br><br><br><br><br><br><br><br>";
 }
 
 ?>



<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		
		
	 <? if ($institucion=="770"){ 
		  
		  
		  
     }else{  ?>
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="125" align="center">
			 <?
			  if($institucion!=""){
				   echo "<img src='".$d."tmp/".$institucion."insignia". "' width='100' height='100' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' width='100' height='100' >";
			  }?>
			</td>
		  </tr>
        </table>
	<? } ?>			 
			 
			 
			 
	</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono :<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>
	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  align="center" class="tableindex">INFORME DE ANOTACIONES</td>
  </tr>
  <tr>
                    <td align="center">&nbsp;</td>
  </tr>
</table>
<br>
		<table width="650" border="0" cellspacing="0" cellpadding="0">
          <tr>
                    <td width="126" class="item"><strong>Curso</strong></td>
            <td width="10" ><div align="left"><strong><font size="1" face="arial, geneva, helvetica">:</font></strong></div></td>
            <td width="514" class="subitem" ><font size="1" face="arial, geneva, helvetica"><? echo $Curso_pal; ?></font></td>
          </tr>
          <tr>
                    <td class="item"><strong>Profesor(a) 
                      Jefe</strong></td>
            <td ><div align="left"><strong><font size="1" face="arial, geneva, helvetica">:</font></strong></div></td>
            <td class="subitem" ><font size="1" face="arial, geneva, helvetica"><?=$ob_reporte->tildeM($ob_reporte->profe_jefe); ?></font></td>
          </tr>
        </table>
		<br>
		<table width="634" border="1" cellspacing="0" cellpadding="0">
  		  <tr bgcolor="#003b85">
			<td width="18" class="item"><div align="center">Nº</div></td>
			<td width="200" class="item"><div align="center">Nombre del Alumno</div></td>
			<td width="100" align="center" class="item">Atrasos</td>
			<td width="100" class="item"><div align="center">Anotaciones <br>Positivas</div></td>
			<td width="50" class="item"><div align="center">Anotaciones<br>Negativas</div></td>
			<td width="50" align="center" class="item">Anotaciones<br>Responsabilidad</td>
			<td width="100" bgcolor="#003b85" class="item"><div align="center">Total</div></td>
    	 </tr>
	<?	
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++)
  	{
	  $fila = @pg_fetch_array($result_alumno,$i);
	  $ob_reporte ->CambiaDato($fila);

	 ?>
	<tr>
    <td height="21" align="center" class="subitem"><? echo $i+1;?></td>
    <td class="subitem"><? echo $ob_reporte->tilde($ob_reporte->ape_nombre_alu);?></td>
    <td class="subitem"><div align="center"><?
		$ob_reporte->periodo=$periodo;
		$rs_periodo = $ob_reporte->Periodo($conn);
			
		$ob_reporte->fecha_inicio=$ob_reporte->fecha_inicio;
		$ob_reporte->fecha_termino=$ob_reporte->fecha_termino;
		$ob_reporte->alumno=$fila['rut_alumno'];
		$ob_reporte->tipo=2;
		//$ob_reporte->tipo_conducta=1;
		$rs_anotaciones = $ob_reporte->Anotaciones($conn);
		echo $atrasos=@pg_numrows($rs_anotaciones);
		$sum_atrasos = $sum_atrasos + $atrasos;
		 	?></div></td>	
    <td class="subitem"><div align="center"><?
		$ob_reporte->periodo=$periodo;
		$rs_periodo = $ob_reporte->Periodo($conn);
			
		$ob_reporte->fecha_inicio=$ob_reporte->fecha_inicio;
		$ob_reporte->fecha_termino=$ob_reporte->fecha_termino;
		$ob_reporte->alumno=$fila['rut_alumno'];
		$ob_reporte->tipo=1;
		$ob_reporte->tipo_conducta=1;
		$rs_anotaciones = $ob_reporte->Anotaciones($conn);
		echo $positiva=@pg_numrows($rs_anotaciones); 
		$sum_positivas = $sum_positivas + $positiva;	?></div></td>
    <td class="subitem"><div align="center"><?
		$ob_reporte->tipo=1;
		$ob_reporte->tipo_conducta=2;
		$rs_anotaciones = $ob_reporte->Anotaciones($conn);
		echo $negativa=@pg_numrows($rs_anotaciones);
			$sum_negativa = $sum_negativa + $negativa;
	 ?></div></td>
    <td class="subitem"><div align="center"><? 
		$ob_reporte->tipo=3;
		$ob_reporte->tipo_conducta=0;
		$rs_anotaciones = $ob_reporte->Anotaciones($conn);
		echo $resposabilidad=@pg_numrows($rs_anotaciones);
		$sum_resposabilidad = $sum_resposabilidad + $resposabilidad;
		?></div></td>
    <td class="subitem"><div align="center"><? echo $satotal = $positiva+$negativa+$resposabilidad+$atrasos;
	$total = $total + $satotal;
		?></div></td>
  </tr>
	
  <? }?>
  <tr>
	  <td height="21" colspan="2" align="left" class="subitem"><strong>TOTAL</strong></td>
	  <td align="center" class="item"><strong><?php echo $sum_atrasos ?></strong></td>
	  <td align="center" class="item"><strong><?php echo $sum_positivas ?></strong></td>
	  <td align="center" class="item"><strong><?php echo $sum_negativa ?></strong></td>
	  <td align="center" class="item"><strong><?php echo $sum_resposabilidad ?></strong></td>
	  <td align="center" class="item"><strong><?php echo $total ?></strong></td>
	  </tr>
</table>		</td>
      </tr>
    </table></td>
  </tr>
</table>
<br>

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
  </tr>
</table>
<br>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("../../firmas/firmas.php");?>
    </center>
</form>

<?
}
?>
<!-- FIN CUERPO DE LA PAGINA -->


</body>
</html>
<? pg_close($conn);?>