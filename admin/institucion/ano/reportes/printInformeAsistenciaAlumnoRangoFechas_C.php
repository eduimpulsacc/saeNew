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
	
		$institucion	=$_INSTIT;
		$corporacion;
		$ano			=$_ANO;
		$reporte		=$c_reporte;
		$_POSP = 4;
		$_bot = 8;
	
	
	//----------
	 $sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//----------
	 $curso	=$c_curso;
	
	
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
	$ob_reporte ->retirado=$opt_ret;
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

<?php
function cc2_date_diff($start, $end) {
    
        $sdate = strtotime($start);
        $edate = strtotime($end);
        
        if ($edate < $sdate) {
            $sdate_temp = $sdate;
            $sdate = $edate;
            $edate = $sdate_temp;
            
        }
        $time = $edate - $sdate;
        $preday[0] = 0;
        
        if($time>=0 && $time<=59) {
                // Seconds
                $timeshift = $time.' seconds ';

        } elseif($time>=60 && $time<=3599) {
                // Minutes + Seconds
                $pmin = ($edate - $sdate) / 60;
                $premin = explode('.', $pmin);
               
                $presec = $pmin-$premin[0];
                $sec = $presec*60;
               
                $timeshift = $premin[0].' min '.round($sec,0).' sec ';

        } elseif($time>=3600 && $time<=86399) {
                // Hours + Minutes
                $phour = ($edate - $sdate) / 3600;
                $prehour = explode('.',$phour);
               
                $premin = $phour-$prehour[0];
                $min = explode('.',$premin*60);
               
                $presec = '0.'.$min[1];
                $sec = $presec*60;

                $timeshift = $prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

        } elseif($time>=86400) {
                // Days + Hours + Minutes
                $pday = ($edate - $sdate) / 86400;
                $preday = explode('.',$pday);

                $phour = $pday-$preday[0];
                $prehour = explode('.',$phour*24);

                $premin = ($phour*24)-$prehour[0];
                $min = explode('.',$premin*60);
               
                $presec = '0.'.$min[1];
                $sec = $presec*60;
               
                $timeshift = $preday[0].' days '.$prehour[0].' hrs '.$min[0].' min '.round($sec,0).' sec ';

        }
        
		
        return $preday[0]+1;
} 



//dias habiles por rango fijo, sin feriados
function habiles2($fechainicio, $fechafin, $diasferiados = array()) {
        // Convirtiendo en timestamp las fechas
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);
       
        // Incremento en 1 dia
        $diainc = 24*60*60;
       
        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();
       
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                        if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                                array_push($diashabiles, date('Y-m-d', $midia));
                        }
                }
        }
       
        return count($diashabiles);
}


function CambioFecha($fecha)   //    cambia fecha del tipo  dd/mm/aaaa  ->  aaaa/mm/dd    para poder hacer insert y update
{
	$retorno="";
	if(strlen($fecha) !=10)
		return $retorno;
	$d=substr($fecha,0,2);
	$m=substr($fecha,3,2);
	$a=substr($fecha,6,4);
	if (checkdate($m,$d,$a))
		$retorno=$a."-".$m."-".$d;
	else
		$retorno="";
	return $retorno;
}

$desde=CambioFecha($fecha_desde);
$hasta=CambioFecha($fecha_hasta);

//habiles



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
                    <td align="center"><strong><font size="1" face="verdana, arial, geneva, helvetica">De&nbsp;<? echo $fecha_desde ?> 
                      a&nbsp;<? echo $fecha_hasta ?></font></strong></td>
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
  		  <tr class="tableindex" >
			<td width="18" class="item"><div align="center">Nº</div></td>
			<td width="100" class="item" align="center">RUT</td>
			<td width="200" class="item"><div align="center">Nombre del Alumno</div></td>
		
			<td width="100" class="item"><div align="center">D&iacute;as asistidos</div></td>
		
			<td width="50" class="item"><div align="center">Ausencias</div></td>
			<td width="100"  class="item"><div align="center">% Asistencia</div></td>
    	 </tr>
	<?	
	for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++)
  	{
	  $fila = @pg_fetch_array($result_alumno,$i);
	  $ob_reporte ->CambiaDato($fila);
	  $dias_ausente=0;
	  $justifica=0;
	  $res_asis=0;
	  $fer=0;
	  $dias_t=0;
	 ?>
	<tr>
    <td height="21" align="center" class="subitem"><? echo $i+1;?></td>
    <td class="subitem"><? echo $ob_reporte->rut_alumno;?></td>
    <td class="subitem"><? echo $ob_reporte->tilde($ob_reporte->ape_nombre_alu);
							/*echo $ob_reporte->tilde($apellido= $ob_reporte->ape_pat);
							echo $ob_reporte->tilde($apellido= $ob_reporte->ape_mat);*/
							//echo " ".$apellido;
							
	?></td>
	
    <td class="subitem">
    <?php //dias trabajados
	//$diast = $cant_habiles-$cant_feriados;
	
	//obtengo real rango de fechas
	
	if($desde < $ob_reporte->fecha_matricula)
	{
		$f_desde= $ob_reporte->fecha_matricula;
	}
	else{
		$f_desde = $desde;
	}
	
	if($ob_reporte->fecha_retiro != null){
		
		if($hasta > $ob_reporte->fecha_retiro){
			$f_hasta = $ob_reporte->fecha_retiro;
		}
		elseif($hasta < $ob_reporte->fecha_retiro){
			$f_hasta = $hasta;
		}
		
	
	}
	else{
		$f_hasta = $hasta;
	}
	
	$cant_habiles = habiles2($f_desde,$f_hasta);
	
	
	//feriados
	//feriados

$ob_reporte->fecha_ini2=$f_desde;	
$ob_reporte->fecha2=$f_hasta;		
$rs_feriado2=$ob_reporte->DiaHabil2($conn);
if(pg_numrows($rs_feriado2)>0){
	for($f=0;$f<pg_numrows($rs_feriado2);$f++){
			$filaf=pg_fetch_array($rs_feriado2,$f);
			 $fecha_inif = date($filaf['fecha_inicio']);
			 $fecha_finf = date($filaf['fecha_fin']);
			 
			 
			$fer=$fer+cc2_date_diff($fecha_inif,$fecha_finf);
			
			 
			
		}
}
$cant_feriados=intval($fer);
	
	
	$ob_reporte ->fecha_inicio=$f_desde;
	$ob_reporte ->fecha_termino=$f_hasta;
	$diast=$cant_habiles-$cant_feriados;
	
	$result_asis = $ob_reporte ->Asistencia($conn);
	$cuenta_inasis = @pg_numrows($result_asis);
    $total_asis= $diast-$cuenta_inasis;
	
	$porc = ($total_asis*100)/$diast;
	
	?>
    
    <div align="center"><?php echo $total_asis ?></div></td>
	
        <td class="subitem"><div align="center"><?php echo $cuenta_inasis ?></div></td>
    <td class="subitem"><div align="center"><?php echo round($porc,1); ?></div></td>
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
<?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		// $concur=0;
		 include("firmas/firmas.php");?> 
    </center>
</form>

<?
}
?>
<!-- FIN CUERPO DE LA PAGINA -->


</body>
</html>
<? pg_close($conn);?>