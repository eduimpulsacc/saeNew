<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?
	
	$periodo		=$cmb_periodos;
	$curso			=$cmb_curso;
	$subsector		=$cmb_subsector;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	
	
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
$institucion	=$_INSTIT;
	$ano			=$_ANO;
	//setlocale("LC_ALL","es_ES");
	
	
	
	if ($periodo!=0)
	$periodo_pal = $ob_membrete->nombre_periodo . " DEL " . $nro_ano;
	else
	$periodo_pal = " AÑO ACADEMICO " . $nro_ano;
	//------------------- CURSO -----------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	$sw				=0;
	if ($curso>0 and $periodo>0)
		$sw = 1;
	if ($sw == 0){
	
	}
		
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	/****************DATOS PERIODO************/
	$ob_membrete ->ano=$ano;
	$ob_membrete ->periodo=$periodo;
	$ob_membrete ->periodo($conn);
	if ($periodo!=0)
	$periodo_pal = $ob_membrete->nombre_periodo . " DEL " . $nro_ano;
	else
	$periodo_pal = " AÑO ACADEMICO " . $nro_ano;
	//------------------- CURSO -----------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	$ob_reporte ->periodo=$periodo;
	$ob_reporte ->ano=$ano;
	$ob_reporte ->curso=$curso;
	$ob_reporte ->id_ramo=$subsector;
	
	if ($ob_reporte ->periodo!=0)
	{
		 $sql_per="select fecha_inicio,fecha_termino from periodo where id_periodo=".$ob_reporte ->periodo;
		$res_per=@pg_exec($conn,$sql_per);
		$fil_per=@pg_fetch_array($res_per);
		 $ob_reporte ->fecha_inicio=$fil_per['fecha_inicio'];
		 $ob_reporte ->fecha_termino=$fil_per['fecha_termino'];	
	}
	
	
	//conteo cumplidos
	 if($periodo==0)
	 {
		$sql="select count (*) as cumplido from plani where id_ramo=".$subsector." and estado='Cumplido'";
		$res=@pg_exec($conn,$sql);
		$fil_cum=@pg_fetch_array($res,0);
		 $cumplido=$fil_cum['cumplido'];
		 
		//calulo logro
		  $sql_log="select sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas".$nro_ano." where id_ramo=$subsector and promedio > 0";
		$res_log=@pg_exec($conn,$sql_log);
		$fil_log=@pg_fetch_array($res_log,0);
		$suma=$fil_log['suma'];
		$cantidad=$fil_log['cantidad'];
		$promedio=$suma/$cantidad;
		
		
		}
	  else
	  { 
		 $sql="select count (*) as cumplido from plani where id_ramo=".$subsector." and fecha_inicio>= '".$ob_reporte ->fecha_inicio."' and fecha_fin<='".$ob_reporte ->fecha_termino."' and estado='Cumplido'";
		$res=@pg_exec($conn,$sql);
		$fil_cum=@pg_fetch_array($res,0);
		$cumplido=$fil_cum['cumplido'];
		
		 $sql_log="select sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas".$nro_ano." where id_ramo=$subsector and promedio > 0 and id_periodo=$periodo";
		$res_log=@pg_exec($conn,$sql_log);
		$fil_log=@pg_fetch_array($res_log,0);
		$suma=$fil_log['suma'];
		$cantidad=$fil_log['cantidad'];
		$promedio=$suma/$cantidad;
		
	   
	 }
	
	
	
	
		if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Planificacion_Curricular_$Fecha.xls"); 
	}	
		
		$resultado_query= $ob_reporte ->planificacion_curri($conn);
		$total_filas= @pg_numrows($resultado_query);
		
		//porcentaje avance
	$porc=($cumplido/$total_filas)*100;
	
	//porcentaje logro
	$porc_log=($promedio/70)*100;
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
					document.form.action='printInformePlanificacionCurricular_C.php?cmb_periodos=<?=$periodo?>&cmb_curso=<?=$curso?>&cmb_subsector=<?=$subsector?>';
					document.form.submit(true);
			}
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'InformePlanificacionCurricular_C.php.php?institucion=$institucion';
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
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo10 {
	font-size: 10;
	font-weight: bold;
}
.Estilo11 {font-size: 10}
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->
<?
if ($curso == 0){
    ## nada
}else{
   ?>
    
<div id="capa0">
<form method="post" name="form" action="PrintInformPlanififacionCurricular.php" target="mainFrame">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	
	<table width="100%">
	  <tr>
	<td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td>
	<td align="right">
      <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">	  </td>
	  <? if($_PERFIL == 0){?>
	<td align="right"><input name="button4" type="button" class="botonXX" onClick="enviapag2(this.form)" value="EXPORTAR"></td>
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
	
	
	 function CambioFechaDisplay($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m."/".$a;
	else
		$retorno="";
	return $retorno;
}
?>

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" valign="top">

	<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="99" class="item"><span class="Estilo10"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></span></td>
    <td width="10"><span class="Estilo11"></span></td>
    <td width="541" align="center"><span class="Estilo11"></span></td>
  </tr>
  <tr>
    <td class="item"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtolower($ob_membrete->direccion));?></strong></font></td>
    <td>&nbsp;</td>
    <td width="541" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td class="item"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></strong></font></td>
    <td>&nbsp;</td>
    <td width="541" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="541" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="20">&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>  
</table>

	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr bgcolor="#003b85">
        <td colspan="23" class="tableindex"><div align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PLANIFICACION CURRICULAR </div></td>
        </tr>
      <tr>
        <td colspan="23"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<? echo $periodo_pal;?> </strong></font></div></td>
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
    </table>
	      <br>
          <br>
          <table width="650" border="1" align="center" cellpadding="0" cellspacing="0" >
          
            <tr>
              <td width="31"><div align="center"><strong><span class="Estilo7">N&ordm;</span></strong></div></td>
              <td width="146" class="Estilo7"><div align="center"><strong>Nombre</strong></div></td>
              <td width="164"><div align="center"><strong><span class="Estilo7">Descripci&oacute;n</span></strong></div></td>
              <td width="164"><div align="center" class="Estilo7"><strong>Momento</strong></div></td>
              <td width="85"><div align="center"><strong><span class="Estilo7">Fecha Inicio</span></strong></div></td>
              <td width="96" class="Estilo7"><div align="center"><strong>Fecha T&eacute;rmino</strong></div></td>
              <td width="66"><div align="center"><strong><span class="Estilo7">Fecha Abordaje </span></strong></div></td>
              <td width="62"><div align="center"><strong><span class="Estilo7">Estado</span></strong></div></td>
            </tr>
            <?
			if ($total_filas==0)
			{
			?>
			 <tr>
              <td colspan="8"><div align="center" class="Estilo7" >Sin resultados</div>                <div align="center" class="Estilo7"></div>                <div align="center" class="Estilo7" ></div>                <div align="center" class="Estilo7" ></div>                <div align="center" class="Estilo7" ></div></td>
            </tr>
			<?
			}
			else
			{ 
			for ($i=0;$i<$total_filas;$i++)
			{
				$fil_planif=@pg_fetch_array($resultado_query,$i);
				
				if ($fil_planif['momento']==10)
				$mom="Anual";
				if ($fil_planif['momento']==20)
				$mom="Unidad";
				if ($fil_planif['momento']==30)
				$mom="Clase";
				
			?>
            <tr>
              <td><div align="center" class="Estilo7" ><?php echo $i+1 ?></div></td>
              <td class="Estilo7" ><div align="center"><?php echo $fil_planif['nombre'] ?>&nbsp;</div></td>
              <td class="Estilo7"><div align="center" class="Estilo7"><?php echo $fil_planif['descripcion'] ?>&nbsp;</div></td>
              <td class="Estilo7"><div align="center"><?php echo $mom ?>&nbsp;</div></td>
              <td class="Estilo7"><div align="center" class="Estilo7" ><?php echo CambioFechaDisplay($fil_planif['fecha_inicio']) ?>&nbsp;</div></td>
              <td class="Estilo7"><div align="center"><?php echo CambioFechaDisplay($fil_planif['fecha_fin']) ?>&nbsp;</div></td>
              <td class="Estilo7"><div align="center" class="Estilo7" ><?php echo CambioFechaDisplay($fil_planif['fecha_abordaje']) ?>&nbsp;</div></td>
              <td class="Estilo7"><div align="center" class="Estilo7" >
			  
			 <?php echo $fil_planif['estado']?>
			  </div></td>
            </tr>
            <? 
			} 
			}
			?>
          </table>
      <br></td>
  </tr>
  <tr>
    <td colspan="2" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td width="542" valign="top" class="Estilo7"><div align="right">Porcentaje Avance </div></td>
    <td width="108" valign="top" class="Estilo7"><div align="center"><strong>
	<?php echo round($porc);?>%
	</strong></div></td>
  </tr>
  <tr>
    <td valign="top" class="Estilo7"><div align="right">Promedio Curso </div></td>
    <td valign="top" class="Estilo7"><div align="center"><strong><?php echo $promedio;?></strong></div></td>
  </tr>
  <tr>
    <td valign="top" class="Estilo7"><div align="right">Porcentaje Logro </div></td>
    <td valign="top" class="Estilo7"><div align="center"><strong><?php echo round($porc_log);?>%</strong></div></td>
  </tr>
  <tr>
    <td colspan="2" valign="top">&nbsp;</td>
  </tr>
</table>
<?
if  (($registros - $i)<>1) 
	echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
} ?>
</form>
<?
}
?>
<?
function ValidaNota($nota, $ModoEval)
{
	if ($ModoEval == 1)
	{
		if ($nota<40 && $nota>0){	?>
			<font color="#FF0000"><? echo $nota;?> </font>	<?
		}else if($nota=='' || $nota==0 || $nota==NULL || $nota == ' '){
			echo "&nbsp;";	
		}
		else{
			echo $nota;
		}
	}
	else
	{
		if (trim($nota)=="0")
			echo "&nbsp;";
		else
			echo $nota;
	}
}
function porcentaje1($cadena)
{
	$arreglo= explode(";",$cadena);
	$largo_arreglo = count($arreglo);		
	for($o=0; $o < $largo_arreglo; $o++)
	{
		if ($arreglo[$o]>0 and $arreglo[$o]<39)
			$cont1 = $cont1 + 1;
		if ($arreglo[$o]>0)
			$cont_gen = $cont_gen + 1;
	}
	if ($cont1>0)
		echo round(($cont1 * 100)/$cont_gen,0)."%";
	else
		echo "&nbsp;";
}
function porcentaje2($cadena)
{
	$arreglo= explode(";",$cadena);
	$largo_arreglo = count($arreglo);		
	for($o=0; $o < $largo_arreglo; $o++)
	{
		if ($arreglo[$o]>39 and $arreglo[$o]<50)
			$cont1 = $cont1 + 1;
		if ($arreglo[$o]>0)
			$cont_gen = $cont_gen + 1;
	}
	if ($cont1>0)
		echo round(($cont1 * 100)/$cont_gen,0)."%";
	else
		echo "&nbsp;";
}
function porcentaje3($cadena)
{
	$arreglo= explode(";",$cadena);
	$largo_arreglo = count($arreglo);		
	for($o=0; $o < $largo_arreglo; $o++)
	{
		if ($arreglo[$o]>49 and $arreglo[$o]<60)
			$cont1 = $cont1 + 1;
		if ($arreglo[$o]>0)
			$cont_gen = $cont_gen + 1;
	}
	if ($cont1>0)
		echo round(($cont1 * 100)/$cont_gen,0)."%";
	else
		echo "&nbsp;";
}
function porcentaje4($cadena)
{
	$arreglo= explode(";",$cadena);
	$largo_arreglo = count($arreglo);		
	for($o=0; $o < $largo_arreglo; $o++)
	{
		if ($arreglo[$o]>59 and $arreglo[$o]<71)
			$cont1 = $cont1 + 1;
		if ($arreglo[$o]>0)
			$cont_gen = $cont_gen + 1;
	}
	if ($cont1>0)
		echo round(($cont1 * 100)/$cont_gen,0)."%";
	else
		echo "&nbsp;";
}
?>

<!-- FIN CUERPO DE LA PAGINA -->

</body>
</html>
<? pg_close($conn);?>