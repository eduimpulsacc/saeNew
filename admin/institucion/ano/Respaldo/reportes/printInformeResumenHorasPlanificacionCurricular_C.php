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

$meses=array("","","","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
$dias=array("","","",31,30,31,30,31,31,30,31,30,31);

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$periodo		=$cmb_periodos;
	$curso			=$cmb_curso;
	$subsector		=$cmb_subsector;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	$sw				=0;
	if ($curso>0 and $periodo>0)
		$sw = 1;
	if ($sw == 0){
	
	}
	
	foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   }
   
   foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   } 
	
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
	/* $ob_membrete ->ano=$ano;
	$ob_membrete ->periodo=$periodo;
	$ob_membrete ->periodo($conn);
	$periodo_pal = $ob_membrete->nombre_periodo . " DEL " . $nro_ano; */
	
	//------------------- CURSO -----------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Resumen_Horas_Planificacion_Curricular_$Fecha.xls"); 
	}	
	$meses=array("","","","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
	$dias=array("","","",31,30,31,30,31,31,30,31,30,31);
	
	
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
			function enviapag2(form){
					form.target="_blank";
					document.form.action='printInformeResumenHorasPlanificacionCurricular_C.php?cmb_curso=<?=$curso?>&cmb_subsector=<?=$subsector?>';
					document.form.submit(true);
			}
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'printInformeResumenHorasPlanificacionCurricular_C.php?institucion=$institucion';
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
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 10px; }
.Estilo4 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif;}
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->
<?
if ($curso == 0){
    ## nada
}else{
   ?>
  <form method="post" name="form" action="printInformeResumenHorasPlanificacionCurricular_C.php" target="mainFrame">
    <center>
<div id="capa0">
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	
	<table width="100%">
	  <tr>
	<td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
	<td align="right">
      <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">	  </td>
	  <? if($_PERFIL == 0){?>
	<td align="right"><input  type="button" class="botonXX" onClick="enviapag2(this.form)"  name="cb_ok" value="EXPORTAR"></td>
	  <? }?>
	  </tr></table>

    </td>
  </tr>
</table>
</div>
<?
	//------------------- SUBSECTOR ---------------------------------------------------------------------
	if ($subsector==0){
		$ob_reporte->curso=$curso;
		$ob_reporte->subsector=0;
		$ob_reporte->NombreSubsector($conn);
		$result_sub = $ob_reporte->result;
	}else{
		$ob_reporte->subsector=$subsector;
		$ob_reporte->NombreSubsector($conn);
		$result_sub = $ob_reporte->result;
	}		
	$registros = @pg_numrows($result_sub);
	
for($i=0 ; $i < $registros ; $i++)
{
	$cadena01=""; $cadena02=""; $cadena03="";$cadena04=""; $cadena05="";
	$cadena06=""; $cadena07=""; $cadena08="";$cadena09=""; $cadena10="";
	$cadena11=""; $cadena12=""; $cadena13="";$cadena14=""; $cadena15="";
	$cadena16=""; $cadena17=""; $cadena18="";$cadena19=""; $cadena20="";		
	$fila_sub = @pg_fetch_array($result_sub,$i);	
	$subsector = $fila_sub['id_ramo'];
	$subsector_pal = ucwords(strtoupper(trim($fila_sub['nombre'])));	
	$modo = $fila_sub['modo_eval'];
	
	/**************PROFESOR SUBSECTOR *********************/
	$ob_reporte ->ramo =$subsector;
	$ob_reporte ->ProfeSubsector($conn);
	
	$ob_reporte ->institucion =$institucion;
	$ob_reporte ->ano =$ano;
	$ob_reporte ->ramo =$subsector;
	$ob_reporte ->bool_ar=0;
	$ob_reporte ->nro_ano =$nro_ano;
	$result_alu =$ob_reporte ->AlumnosTiene($conn);
	
?>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">

	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487" class="item"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		
				   

		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top">
            <td width="125" align="center">
			  <?
				$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
				$arr=@pg_fetch_array($result,0);
				$fila_foto = @pg_fetch_array($result,0);
				## c�digo para tomar la insignia
		
			  if($institucion!=""){
				   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }?>			</td>
			 </tr>
         </table>	</td>
  </tr>
  <tr>
    <td class="item"><? echo ucwords(strtolower($ob_membrete->direccion));?></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td class="item">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>

	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr bgcolor="#003b85">
        <td colspan="23" class="tableindex"><div align="center">RESUMEN HORAS PLANIFICACION CURRICULAR </div></td>
        </tr>
      <tr>
        <td colspan="23"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo $periodo_pal;?> </strong></font></div></td>
        </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
        <td>&nbsp;</td>
        <td colspan="18">&nbsp;</td>
      </tr>
      <tr>
              <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Curso</strong></font></td>
        <td width="8"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td width="542" colspan="18"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $Curso_pal;?></font></td>
        </tr>
      <tr>
		      <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Subsector</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="18"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo $subsector_pal;?></font></td>
        </tr>
      <tr>
              <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Profesor(a)</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="-1"><strong>:</strong></font></td>
        <td colspan="18"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$ob_reporte->tildeM(strtoupper($ob_reporte->nombre_ape));?></font></td>
        </tr>
      <tr>
        <td colspan="4"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>A&ntilde;o</strong></font></td>
        <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>:</strong></font></td>
        <td colspan="18"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000000"><?php echo $nro_ano ?></font></td>
      </tr>
    </table>
	      <br>
          <br>
		  <table width="100%" border="1" cellpadding="0" cellspacing="0">
            
            <tr>
              <td colspan="12" bgcolor="#CCCCCC"><div align="center" class="Estilo3">MESES</div></td>
            </tr>
            <tr>
              <td><div align="center"><span class="Estilo3">N&ordm; Horas </span></div></td>
              <td><div align="center"><span class="Estilo3">MAR</span></div></td>
              <td><div align="center"><span class="Estilo3">ABR</span></div></td>
              <td><div align="center"><span class="Estilo3">MAY</span></div></td>
              <td><div align="center"><span class="Estilo3">JUN</span></div></td>
              <td><div align="center"><span class="Estilo3">JUL</span></div></td>
              <td><div align="center"><span class="Estilo3">AGO</span></div></td>
              <td><div align="center"><span class="Estilo3">SEP</span></div></td>
              <td><div align="center"><span class="Estilo3">OCT</span></div></td>
              <td><div align="center"><span class="Estilo3">NOV</span></div></td>
              <td><div align="center"><span class="Estilo3">DIC</span></div></td>
              <td><div align="center"><span class="Estilo3">Total Clases </span></div></td>
            </tr>
            <tr>
              <td class="Estilo4">Programadas</td>
			    <?php
				 for($i=0;$i<=12;$i++)
			  {
			  	if($i>2)
				{?>
				<td class="Estilo4"><div align="center">
                 
              	<?php 
				
			$sql_hor="select horas_programadas from res_hora_plancurri where id_curso=$curso and id_subsector=$subsector and mes=$i";
				$res_hora=@pg_exec($conn,$sql_hor);
				
			  	$fila_hora = pg_fetch_array($res_hora,0);
				$programadas=$fila_hora['horas_programadas'];
				if (pg_numrows ($res_hora)==0)
				echo "0"; 
				else
				echo $programadas;
				
				$tprog=$tprog+$programadas;
				   ?>
				  
				       
              </div></td>
			   <? }}?>
			  <td class="Estilo4"><div align="center"><?php echo $tprog ?></div></td>
            </tr>
            <tr>
              <td class="Estilo4">Realizadas</td>
               <?php for($i=0;$i<=12;$i++)
			  {
			  	if($i>2)
				{
			  ?>
              <td class="Estilo4"><div align="center"><?php 
				
			$sql_hor="select horas_realizadas from res_hora_plancurri where id_curso=$curso and id_subsector=$subsector and mes=$i";
				$res_hora=@pg_exec($conn,$sql_hor);
				
			  	$fila_hora = pg_fetch_array($res_hora,0);
				$realizadas=$fila_hora['horas_realizadas'];
				if (pg_numrows ($res_hora)==0)
				echo "0"; 
				else
				echo $realizadas;
				
				$trea=$trea+$realizadas;
				   ?></div></td>
			  <?php }}?>
			  <td class="Estilo4"><div align="center"><?php echo $trea ?></div></td>
            </tr>
            <tr>
              <td class="Estilo4">No realizadas</td>
               <?php for($i=0;$i<=12;$i++)
			  {
			  	if($i>2)
				{
			  ?>
              <td class="Estilo4"><div align="center"><?php 
				
			$sql_hor="select horas_no_realizadas from res_hora_plancurri where id_curso=$curso and id_subsector=$subsector and mes=$i";
				$res_hora=@pg_exec($conn,$sql_hor);
				
			  	$fila_hora = pg_fetch_array($res_hora,0);
				$no_realizadas=$fila_hora['horas_no_realizadas'];
				if (pg_numrows ($res_hora)==0)
				echo "0"; 
				else
				echo $no_realizadas;
				
				$tnrea=$tnrea+$no_realizadas;
				   ?></div></td>
			  <?php }}?>
			  <td class="Estilo4"><div align="center"><?php echo $tnrea ?></div></td>
            </tr>
            <!--<tr>
              <td class="Estilo4">Total Clases </td>
               <?php for($i=0;$i<=12;$i++)
			  {
			  	if($i>2)
				{
			  ?>
              <td class="Estilo4"><div align="center"></div></td>
			  <?php }}?>
			  <td class="Estilo4"><div align="center"></div></td>
            </tr>-->
          </table>
        </td>
  </tr>
</table>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85>	</td>
  </tr>
</table>
<?

} ?>
</center>
</form>
<?
}
?>


<!-- FIN CUERPO DE LA PAGINA -->

</body>
</html>
<? pg_close($conn);?>