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
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_MotorBusqueda.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$periodo		=$cmb_periodos;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	if ($periodo==0){
	   ## nada
	}else{
		 
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();	 
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** A�O ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;

	/****************DATOS PERIODO************/
	$ob_membrete ->ano=$ano;
	$ob_membrete ->periodo=$periodo;
	$ob_membrete ->periodo($conn);
	$periodo_pal = $ob_membrete->nombre_periodo . " DEL " . $nro_ano;
	
	// DATOS CURSO
	//----------------------------------------------------------------------------	
	if ($curso == 0){
		$sql_curso = "select * from curso where id_ano= ".$ano ." order by ensenanza, grado_curso, letra_curso";
		$result_curso = @pg_Exec($conn, $sql_curso);
	}
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
}	

if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Grafico_Cursos_$Fecha.xls"); 
		
}	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
	function enviapag2(form){
				form.target="_blank";
				document.form.action='printInformeGraficoCursos_C.php?cmb_periodos=<?=$periodo?>&c_reporte=<?=$reporte?>';
				document.form.submit(true);
	}
	function enviapag(form){
		form.action = 'InformeGraficoCursos.php?institucion=$institucion';
		form.submit(true);
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->
<?
if ($periodo==0){
   ## nada
}else{
   ?> 
   <form name="form" action="printInformeGraficoCursos_C2.php" method="post">  
<center>
<div id="capa0">
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
		<div align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
        </div>
      </td>
	<? if($_PERFIL==0){?>
    <td><input name="button4" type="button" onClick="enviapag2(this.form)" class="botonXX" value="EXPORTAR"></td>
  	<? }?>
  
  </tr>
  
</table>
</div>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
    <table width="650" border="0" cellspacing="0" cellpadding="0">
	   <tr>
		<?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia'])){ 
	       if($institucion!=""){
		       echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	       }else{
		       echo "<img src='".$d."menu/imag/logo.gif' >";
	       } 
		   ?>
	    </td>
		   <td width="50">&nbsp;</td>
		   <td>
	
		   <table>
			 <tr>
			   <td width="450" class="item"><div align="left"><strong><?=$ob_membrete->ins_pal?></strong></div></td>
			 </tr>
		   </table>
		   <table>
		     <tr>
				<td width="450" class="item"><div align="left"><strong><?=$ob_membrete->direccion;?></strong></div></td>
			 </tr>
		   </table>
		   <table>
		     <tr>
				<td width="450" class="item"><div align="left"><strong><?=$ob_membrete->telefono;?></strong></div></td>
			 </tr>
		   </table>
		   </td>

	<? }else{?>
		    <td>
			<table width="100%">
			  <tr>
				<td width="100%" class="item"><div align="left"><strong><?=$ob_membrete->ins_pal?></strong></div></td>
			  </tr>
			</table>
			<table>  <tr>
				<td width="100%" class="item"><div align="left"><strong><?=$ob_membrete->direccion;?></strong></div></td>
				</tr>
			</table>
			<table>  <tr>
				<td width="100%" class="item"><div align="left"><strong><?=$ob_membrete->telefono;?></strong></div></td>
				</tr>
			</table>
		    </td>
	<? }  ?>
	</tr>
</table>

<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr><td colspan=3>&nbsp;</td></tr>
  <tr>
    <td colspan=3 class="tableindex"><div align="center">RENDIMIENTO GR�FICO POR CURSO</div></td>
    </tr>
  <tr>
    <td colspan=3><div align="center"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><? echo $periodo_pal;?></strong></font></div></td>
  </tr>  
</table>

<table width="650" border="0" cellspacing="1" cellpadding="0" bgcolor="#CCCCCC">
  <tr>
      <td bgcolor="#ffffff" rowspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:12px"><b>CURSOS</b></font></td>
	  <? if($cb_ok=="Buscar"){?>
	  <td colspan="7" align="center" bgcolor="#ffffff">
	  <font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">Rango de notas</font>
	  </td>
	  <? }?>
	  <td width="40" bgcolor="#c8d6fb" align="center" rowspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">Promedio</font></td>
  </tr>
  <tr>
     <? if($cb_ok=="Buscar"){?>
	  <td width="40" bgcolor="#FFFFFF" align="center" class="item">0-10</td>
	  <td width="40" bgcolor="#FFFFFF" align="center" class="item">11-20</td>
	  <td width="40" bgcolor="#FFFFFF" align="center" class="item">21-30</td>
	  <td width="40" bgcolor="#FFFFFF" align="center" class="item">31-40</td>
	  <td width="40" bgcolor="#FFFFFF" align="center" class="item">41-50</td>
	  <td width="40" bgcolor="#FFFFFF" align="center" class="item">51-60</td>
	  <td width="40" bgcolor="#FFFFFF" align="center" class="item">61-70</td>
	<? }?>
  </tr>
  <?
 	$ob_motor = new MotorBusqueda();
	$ob_motor ->ano = $ano;
	$resultado_query_cue = $ob_motor ->curso($conn);
  // aqui muestro todos los curso de la instituci�n
  
  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
     $fila = @pg_fetch_array($resultado_query_cue,$i); 
	 $id_curso = $fila['id_curso'];
     $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
	 
	 // aqui tomo todos los promedios de este curso
	 $ob_reporte ->curso =$id_curso;
	 $ob_reporte ->periodo =$periodo;
	 $ob_reporte ->nro_ano =$nro_ano;
	 $ob_reporte ->PromedioRamo($conn);
	
	 $promedio_curso = @intval($ob_reporte->suma/ $ob_reporte->contador);
	 $anchotabla = ($promedio_curso * 4) + 1;
	   
	 ?>
	  <tr>
		  <td bgcolor="#FFFFFF" height="20" class="subitem"><? echo "$Curso_pal"; ?></td>
		<? if($cb_ok=="Buscar"){?>
		  <td colspan="7" width="280" bgcolor="#FFFFFF">
		        <? if ($promedio_curso==0){ 
				     ?>&nbsp; <? 
			   	   } else{ ?>
				          <table border="2" cellpadding="0" cellspacing="0" height="13">
						      <tr>
							       <td  width="<?=$anchotabla ?>"></td>
								   <td  width="9"></td>
							  </tr>
						  </table>
				 <? } ?></td>
				 <? }?>
		  <td bgcolor="#c8d6fb" align="center" class="subitem"><? if ($promedio_curso==0){ ?> &nbsp; <? }else{ ?><? echo "$promedio_curso"; ?><? } ?></td>
	  </tr>
	  <?
  }
  ?>
</table>
<? if($cb_ok!="Buscar"){?>
	<table border="0" width="650">
	<tr>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	</tr>
	<tr>
	<td>&nbsp;</td>
	</tr>
	</table>
<? }?>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
<hr width="100%" color=#003b85>
</tr>
</table>  
<? if  (($cantidad_cursos - $i)<>1) 
    	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
?>
</center>
</form>
<?
}
?>
<!-- FIN CUERPO DE LA PAGINA -->
</body>
</html>
<? pg_close($conn);?>