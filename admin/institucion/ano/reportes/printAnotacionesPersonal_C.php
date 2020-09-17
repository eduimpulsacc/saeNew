<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	$empleado 		= $cmb_empleado;

//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);

if(!$cb_ok =="Buscar"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Anotaciones_Personal_$Fecha.xls"); 
	
}	

?>		

<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<SCRIPT language="JavaScript">
			function enviapag20(form){
					form.target="_blank";
					var empleado = document.form.empleado.value;
		   			form.action=='www.google.cl?cmb_empleado='+empleado;
					form.submit(true);
		  	}
		/*	function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'InformeAnotaciones.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}*/
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>	

<?	
	$ob_reporte = new Reporte();
	
	$ob_membrete = new Membrete();
	$ob_membrete->institucion=$institucion;
	$ob_membrete->institucion($conn);
	
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
.Estilo25 {font-weight: bold; }
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">


           <!-- INSERTO CUERPO DE LA PÁGINA -->
<form name="form" action="printAnotacionesPersonal_C.php?cmb_empleado=<?=$empleado?>&c_curso=<?=$curso?>" method="post">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
      <td><div id="capa0">
	<tablE width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR"></td><td align="right">
           <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	    </td>
	    <td align="right"><input name="exportar" type="button" class="botonXX" onClick="enviapag20(this.form)"  value="EXPORTAR">
		<input type="hidden" name="empleado" value="<?=$empleado?>" >
		</td>
	  </tr></tablE>
     
      </div></td>
     </tr>
</table>
<br>
<?
if($empleado != ""){
	if($empleado > 0){
		$ob_reporte->institucion =$institucion;
		$ob_reporte->empleado = $empleado;
		$result = $ob_reporte->Empleado($conn);
	}else{
		$ob_reporte->institucion =$institucion;
		$result = $ob_reporte->Empleado($conn);
	}	
	

	$cantidad_docente = @pg_numrows($result);
	for($i=0 ; $i < @pg_numrows($result); $i++){
		$ob_reporte->CambiaDatoEmp($result,$i);
		$fila_docente = @pg_fetch_array($result,$i);
		
		$empleado = $fila_docente['rut_emp'];
		$nombre = ucwords(strtoupper($fila_docente['ape_pat'])) . " " . ucwords(strtoupper($fila_docente['ape_mat'])) . " " . ucwords(strtoupper($fila_docente['nombre_emp']));

	 if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br>";
	   
  }else{

	?>


	<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
		<td width="11">&nbsp;</td>
		<td width="152" rowspan="4" align="center">
				<?	if($institucion!=""){
						echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
					}else{
						echo "<img src='".$d."menu/imag/logo.gif' >";
					}
				?>		</td>
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
	
<? } ?>



<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex"><div align="center">INFORME DE ATRASOS E INASISTENCIAS DEL PERSONAL </div></td>
  </tr>
  <tr>
</table>
<br>


<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="159" class="item"><b>Nombre Empleado </b></td>
          <td width="10"><strong><font size="1">:</font></strong></td>
          <td width="485" class="subitem"><? echo $ob_reporte->tildem($nombre);?></td>
        </tr>
  </table>
	 <strong><br>
	 
	 <?
//******************* INASISTENCIA X ASIGNATURA *********************
$ob_reporte->empleado = $empleado;
$ob_reporte->ano = $ano;
$res_asignatura = $ob_reporte->AtrasoAsignaturaDocente($conn);

if (@pg_numrows($res_asignatura)==0) echo "<font face=Verdana, Arial, Helvetica, sans-serif size=4><center><strong>NO REGISTRA INASISTENCIAS POR ASIGNATURAS</strong></center></font><br>";
else echo "<font face=Verdana, Arial, Helvetica, sans-serif size=3><center><strong>INASISTENCIAS POR ASIGNATURA</strong></center></font><br>";

for($t=0 ; $t < @pg_numrows($res_asignatura) ; $t++)
{
	$fila_asignatura = @pg_fetch_array($res_asignatura,$t);
	$ob_reporte->CambiaDatoAtrasoDocente($fila_asignatura);
	$fecha_asig = fecha_espanol($fecha_asig);	
?>
     </strong>
	 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	    <tr>
		  <td class="Estilo7"><hr width="100%" color=#003b85></td>
	    </tr>
	   </table>
		 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
		   <tr>
			 <td width="50"><strong>Dia:</strong></td>
			 <td width="140" class="subitem"><?=$ob_reporte->fecha_asig;?></td>
			 <td width="100" class="subitem"><? echo $ob_reporte->hora_asig." Hrs";?></td>
			 <td width="150" class="subitem"><?=$ob_reporte->tipo;?></td>
			 <td class="subitem"><?=$ob_reporte->ramo_asig;?></td>
		   </tr>
		 </table>	
         <strong>
<? }?>
	 
	 
	
	 
<? 
// *************************** INASISTENCIAS ********************
	$ob_reporte->empleado = $empleado;
	$ob_reporte->tipo=2;
	$result_anota = $ob_reporte->AtrasoInasistenciaDocente($conn);
	
	if (@pg_numrows($result_anota)==0) echo "<font face=Verdana, Arial, Helvetica, sans-serif size=4><center><strong>NO REGISTRA INASISTENCIAS</strong></center></font><br>";
	else echo "<font face=Verdana, Arial, Helvetica, sans-serif size=3><center><strong>INASISTENCIAS</strong></center></font><br>";
	for($e=0 ; $e < @pg_numrows($result_anota) ; $e++)
	{
		$fila_anota = @pg_fetch_array($result_anota,$e);
		$fecha = $fila_anota[fecha];
		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);		
		?>		
		  </strong>
        <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
		   <tr>
			 <td class="Estilo16"><hr width="100%" color=#003b85></td>
		   </tr>
		 </table>
		 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
		   <tr>
			 <td width="150"><strong>Inasistencia el día:</strong></td>
			 <td><?=$fecha;?></td>
		   </tr>
		 </table>
	     <strong>
	     <? } ?>
                  </strong>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td class="Estilo22"><hr width="100%" color=#003b85></td>
   </tr>
 </table>
         <strong>
         <? 	
	$ob_reporte->empleado = $empleado;
	$ob_reporte->tipo=1;
	$result_anota = $ob_reporte->AtrasoInasistenciaDocente($conn);

	if (@pg_numrows($result_anota)==0) echo "<br><br><font face=Verdana, Arial, Helvetica, sans-serif size=4><center><strong>NO REGISTRA ATRASOS</strong></center></font><br>";
	else echo "<br><br><font face=Verdana, Arial, Helvetica, sans-serif size=3><center><strong>ATRASOS</strong></center></font><br>";
	for($e=0 ; $e < @pg_numrows($result_anota) ; $e++)
	{
		$fila_anota = @pg_fetch_array($result_anota,$e);
		$fecha = $fila_anota[fecha];
		$dia = substr($fecha,8,2);
		$mes = substr($fecha,5,2);
		$anno = substr($fecha,0,4);
		$fecha = $dia."-".$mes."-".$anno;
		$fecha = fecha_espanol($fecha);		
		?>		
		  </strong>
        <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
		   <tr>
			 <td class="Estilo25"><hr width="100%" color=#003b85></td>
		   </tr>
		 </table>
		 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
		   <tr>
			 <td width="150"><strong>Atraso el día:</strong></td>
			 <td class="subitem"><?=$fecha;?></td>
		   </tr>
		 </table>
	     <strong>
	     <? } ?>	
                  </strong>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
   <tr>
     <td><hr width="100%" color=#003b85></td>
   </tr>
</table>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 $concur=0;
		 include("firmas/firmas.php");?>
<?
echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
 }//asistencia

	} 

 ?>
<br>
</center>
</form>
</body>
</html>
<? pg_close($conn);
unset($cb_ok);?>