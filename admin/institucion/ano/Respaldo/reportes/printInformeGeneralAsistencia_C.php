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

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	if($_PERFIL==0){
		$sql ="SELECT num_corp FROM corp_instit WHERE rdb=".$institucion;
		$rs_corp = @pg_exec($conn,$sql);
		$corporacion = @pg_result($rs_corp,0);
	}else{
		$corporacion =$_CORPORACION;
	}
	 
	//----------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//----------
	$curso			=$cmb_curso;
	$fechaini		= $fecha1;
	$fechafin		= $fecha2;	
	$dia1			=substr($fechaini,0,2);
	$mes1			=substr($fechaini,3,2);
	$ano1			=$ano_escolar;
	$dia2			=substr($fechafin,0,2);
	$mes2			=substr($fechafin,3,2);
	$ano2			=$ano_escolar;
	
			
	if (empty($curso)){
	   // exit;
	}else{
	   
	if (!checkdate($mes1,$dia1,$ano1)) 
	{
		echo "FECHA INICIO INVALIDA <br>";
		exit;
	}	
	if (!checkdate($mes2,$dia2,$ano2)) 
	{
		echo "FECHA FINAL INVALIDA <br>"; 
		exit;
	}
	}
	if (empty($curso)){
	    $fecha1			= "";
	    $fecha2			= "";
	}else{	
	    $fecha3			= $fecha1;
	    $fecha4			= $fecha2;
	    $fecha1			= mktime(0,0,0,$mes1,$dia1,$ano1);
	    $fecha2			= mktime(0,0,0,$mes2,$dia2,$ano2);
	    $fecha_1		= $mes1."-".$dia1."-".$ano1;
	    $fecha_2		= $mes2."-".$dia2."-".$ano2;
		$fecha1			= $fecha3;
	    $fecha2			= $fecha4;
	}	
    if ($corporacion==13){
		$fecha_1	=fEs2En($fecha_1);
		$fecha_2	=fEs2En($fecha_2);
	}else{
		$fecha_1	= $fecha_1;
		$fecha_2	= $fecha_2;
	}		
	
	if (empty($curso)){
	   // exit;
	}else{
	   
	
	
	$sql_habiles = "select sum(dias_habiles) as dias_habiles from periodo where id_ano = ".$ano;
	$result_habiles =@pg_Exec($conn,$sql_habiles);
	$fila_habiles = @pg_fetch_array($result_habiles,0);	
	$dias_habiles = $fila_habiles['dias_habiles'];
	$sw = 0;
	if ($dias_habiles > 0) $sw = 1;
	if ($sw = 0)
	{
		echo "DEBE INGRESAR LOS DIAS HABILES EN EL SECTOR DE PERIODOS";
		exit;
	}
	
	}
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
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
				   echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
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
    <td  align="center" class="tableindex">INFORME DE ATRASOS E INASISTENCIAS</td>
  </tr>
  <tr>
                    <td align="center"><strong><font size="1" face="verdana, arial, geneva, helvetica">De&nbsp;<? echo (strtolower(strftime("%A, %d de %B de %Y",mktime(0,0,0,$mes1,$dia1,$ano1)))) ?> 
                      a&nbsp;<? echo (strtolower(strftime("%A, %d de %B de %Y",mktime(0,0,0,$mes2,$dia2,$ano2)))) ?></font></strong></td>
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
		<table width="650" border="1" cellspacing="0" cellpadding="0">
  		  <tr bgcolor="#003b85">
			<td width="18" class="item"><div align="center">Nº</div></td>
			<td width="277" class="item"><div align="center">Nombre del Alumno</div></td>
			<? if($ck_atraso==1){?>
			<td width="114" class="item"><div align="center">Atrasos</div></td>
			<? } ?>
			<td width="114" class="item"><div align="center">Ausencias</div></td>
			<td width="115" bgcolor="#003b85" class="item"><div align="center">%</div></td>
    	 </tr>
	<?	
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++)
  	{
	  $fila = @pg_fetch_array($result_alumno,$i);
	  $ob_reporte ->CambiaDato($fila);
	  $dias_ausente=0;
	  $justifica=0;
	  $res_asis=0;
	 ?>
	<tr>
    <td height="21" align="center" class="subitem"><? echo $i+1;?></td>
    <td class="subitem"><? echo $ob_reporte->tilde($ob_reporte->nombre);
							echo $ob_reporte->tilde($apellido= $ob_reporte->ape_pat);
							//echo " ".$apellido;
							
	?></td>
	<? if($ck_atraso==1){?>
    <td class="subitem"><div align="center">
	<?
		$ob_reporte ->rut_alumno =$ob_reporte->alumno;
		$ob_reporte ->fecha1 = $fecha_1;
		$ob_reporte ->fecha2 = $fecha_2;
		$ob_reporte ->tipo =2;
		$result_atraso =$ob_reporte ->AtrasosAsistencia($conn);
		echo @pg_numrows($result_atraso);	
	?>
	</div></td>
	<? } ?>
        <td class="subitem"><div align="center">
	<?
		$ob_reporte ->ano = $ano;
		$ob_reporte ->rut_alumno = $ob_reporte->alumno;
		$ob_reporte ->fecha_inicio = $fecha_1;
		$ob_reporte ->fecha_termino = $fecha_2;
		$result_asis = $ob_reporte ->Asistencia($conn);
		$dias_ausente = @pg_numrows($result_asis);
	
		if($ck_justifica==1){
		$ob_reporte ->fecha1 = $fecha_1;
		$ob_reporte ->fecha2= $fecha_2;
		$res_justi = $ob_reporte ->JustificaAsistencia($conn);
		$justifica = @pg_numrows($res_justi);
			if($dias_ausente!=0){
				 $res_asis = $dias_ausente - $justifica;
			}
		}else{
			$res_asis =	$dias_ausente;
		}
		echo $res_asis;
	?>
	</div></td>
    <td class="subitem"><div align="center">
	<?
	if ($dias_habiles>0)
	{
		$dias_asistidos = $dias_habiles - $res_asis;
		$procentaje = round(($dias_asistidos * 100)/$dias_habiles,2);
		echo $procentaje."%";
	}
	else
		echo "0%";
	{
	
	}

	?>
	</div></td>
  </tr>
  <? }?>
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
</center>
</form>

<?
}
?>
<!-- FIN CUERPO DE LA PAGINA -->


</body>
</html>
<? pg_close($conn);?>