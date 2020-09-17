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
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$reporte		= $c_reporte;
	$curso			= $cmb_curso;
	
	$_POSP = 4;
	$_bot = 8;
	
	
	
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_membrete ->ano=$ano;
	$ob_membrete ->AnoEscolar($conn);
	
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano  =$ob_membrete->nro_ano;
	
	
//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);


	

	if (empty($curso)){
	    $fecha1			= "";
	    $fecha2			= "";
	}else{	
	   
	}	
    
	
	if (empty($curso)){
	   // exit;
	}else{
		$ob_reporte ->cmb_curso =$curso;
		$result_apoderado = $ob_reporte ->ApoderadoCurso($conn);
		
		$ob_reporte ->ano =$ano;
		$result_habiles =$ob_reporte ->DiasHabiles($conn);
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
    	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Asistencia_Apoderado_$Fecha.xls"); 
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
					window.location='printInformeAsistenciaApoderado_C.php?cmb_curso=<?=$curso?>&c_reporte=<?=$reporte?>';
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
	<td align="right"><input name="button4" type="button" class="botonXX" onClick="javascript:exportar()"  value="EXPORTAR"></td>
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
    <td width="487" class="item"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></td>
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
			  }?>			</td>
		 </tr>
       </table>
	<? } ?>	</td>
  </tr>
  <tr>
    <td class="item"><? echo ucwords(strtolower($ob_membrete->direccion));?></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td class="item">Fono :<? echo ucwords(strtolower($ob_membrete->telefono));?></td>
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
    <td  align="center" class="tableindex">INFORME DE INASISTENCIAS DE APODERADOS</td>
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
            <td class="subitem" ><font size="1" face="arial, geneva, helvetica"><? echo $ob_reporte->tildeM($ob_reporte->profe_jefe); ?></font></td>
          </tr>
        </table>
		<br>
		
		<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="cccccc">
          <tr>
            <td width="23%" height="25" bgcolor="#CCCCCC" class="item"><div align="center"><strong>Apoderado</strong></div></td>
            <td width="7%" bgcolor="#CCCCCC" class="item"><div align="center"><strong>Mar</strong></div></td>
            <td width="7%" bgcolor="#CCCCCC" class="item"><div align="center"><strong>Abr</strong></div></td>
            <td width="7%" bgcolor="#CCCCCC" class="item"><div align="center"><strong>May</strong></div></td>
            <td width="7%" bgcolor="#CCCCCC" class="item"><div align="center"><strong>Jun</strong></div></td>
            <td width="7%" bgcolor="#CCCCCC" class="item"><div align="center"><strong>Jul</strong></div></td>
            <td width="7%" bgcolor="#CCCCCC" class="item"><div align="center"><strong>Ago</strong></div></td>
            <td width="7%" bgcolor="#CCCCCC" class="item"><div align="center"><strong>Sep</strong></div></td>
            <td width="7%" bgcolor="#CCCCCC" class="item"><div align="center"><strong>Oct</strong></div></td>
            <td width="7%" bgcolor="#CCCCCC" class="item"><div align="center"><strong>Nov</strong></div></td>
            <td width="7%" bgcolor="#CCCCCC" class="item"><div align="center"><strong>Dic</strong></div></td>
            <td width="7%" bgcolor="#CCCCCC" class="item"><div align="center"><strong>Total</strong></div></td>
          </tr>
		  <?	
		  for($i=0 ; $i < @pg_numrows($result_apoderado) ; $i++){
		     $fila = @pg_fetch_array($result_apoderado,$i);
		     $nombre_apo = ucwords(strtolower(trim($fila['ape_pat']) . " " . trim($fila['ape_mat']) . " " . trim($fila['nombre_apo'])));
		     $rut_apo = $fila['rut_apo'];
		     ?>
             <tr>
			 <?
			  // determinar la inasistencia por cada mes
			  
			  $ob_reporte ->ano = $ano;
			  $ob_reporte ->rut_apo=$rut_apo;
			  $ob_reporte ->fecha1="03-01-".$nro_ano;
			  $ob_reporte ->fecha2="03-31-".$nro_ano;
			  $ob_reporte ->AsistenciaApo($conn);
			  $marzo = $ob_reporte ->dias_ausente;
			  
			  $ob_reporte ->ano = $ano;
			  $ob_reporte ->rut_apo=$rut_apo;
			  $ob_reporte ->fecha1="03-01-".$nro_ano;
			  $ob_reporte ->fecha2="03-30-".$nro_ano;
			  $ob_reporte ->AsistenciaApo($conn);
			  $abril = $ob_reporte ->dias_ausente;
			  
			  $ob_reporte ->ano = $ano;
			  $ob_reporte ->rut_apo=$rut_apo;
			  $ob_reporte ->fecha1="03-01-".$nro_ano;
			  $ob_reporte ->fecha2="03-31-".$nro_ano;
			  $ob_reporte ->AsistenciaApo($conn);
			  $mayo = $ob_reporte ->dias_ausente;
			  
			  $ob_reporte ->ano = $ano;
			  $ob_reporte ->rut_apo=$rut_apo;
			  $ob_reporte ->fecha1="03-01-".$nro_ano;
			  $ob_reporte ->fecha2="03-30-".$nro_ano;
			  $ob_reporte ->AsistenciaApo($conn);
			  $junio = $ob_reporte ->dias_ausente;
			  
			  $ob_reporte ->ano = $ano;
			  $ob_reporte ->rut_apo=$rut_apo;
			  $ob_reporte ->fecha1="03-01-".$nro_ano;
			  $ob_reporte ->fecha2="03-31-".$nro_ano;
			  $ob_reporte ->AsistenciaApo($conn);
			  $julio = $ob_reporte ->dias_ausente;
			  
			  $ob_reporte ->ano = $ano;
			  $ob_reporte ->rut_apo=$rut_apo;
			  $ob_reporte ->fecha1="03-01-".$nro_ano;
			  $ob_reporte ->fecha2="03-31-".$nro_ano;
			  $ob_reporte ->AsistenciaApo($conn);
			  $agosto = $ob_reporte ->dias_ausente;
			  
			  $ob_reporte ->ano = $ano;
			  $ob_reporte ->rut_apo=$rut_apo;
			  $ob_reporte ->fecha1="03-01-".$nro_ano;
			  $ob_reporte ->fecha2="03-30-".$nro_ano;
			  $ob_reporte ->AsistenciaApo($conn);
			  $septiembre = $ob_reporte ->dias_ausente;
			  
			  $ob_reporte ->ano = $ano;
			  $ob_reporte ->rut_apo=$rut_apo;
			  $ob_reporte ->fecha1="03-01-".$nro_ano;
			  $ob_reporte ->fecha2="03-31-".$nro_ano;
			  $ob_reporte ->AsistenciaApo($conn);
			  $octubre = $ob_reporte ->dias_ausente;
			  
			  $ob_reporte ->ano = $ano;
			  $ob_reporte ->rut_apo=$rut_apo;
			  $ob_reporte ->fecha1="03-01-".$nro_ano;
			  $ob_reporte ->fecha2="03-30-".$nro_ano;
			  $ob_reporte ->AsistenciaApo($conn);
			  $noviembre = $ob_reporte ->dias_ausente;
			  
			  $ob_reporte ->ano = $ano;
			  $ob_reporte ->rut_apo=$rut_apo;
			  $ob_reporte ->fecha1="03-01-".$nro_ano;
			  $ob_reporte ->fecha2="03-31-".$nro_ano;
			  $ob_reporte ->AsistenciaApo($conn);
			  $diciembre = $ob_reporte ->dias_ausente;
			  
			  $total = $marzo + $abril + $mayo + $junio + $julio + $agosto + $septiembre + $octubre + $noviembre + $diciembre;
			  ?>			  
			 
              <td bgcolor="ffffff" class="subitem">&nbsp;<? echo $ob_reporte->tilde($nombre_apo);?></td>
              <td bgcolor="ffffff" class="subitem"><div align="center">&nbsp;
                <?=$marzo ?>
              </div></td>
              <td bgcolor="ffffff" class="subitem"><div align="center">&nbsp;
                <?=$abril ?>
              </div></td>
              <td bgcolor="ffffff" class="subitem"><div align="center">&nbsp;
                <?=$mayo ?>
              </div></td>
              <td bgcolor="ffffff" class="subitem"><div align="center">&nbsp;
                <?=$junio ?>
              </div></td>
              <td bgcolor="ffffff" class="subitem"><div align="center">&nbsp;
                <?=$julio ?>
              </div></td>
              <td bgcolor="ffffff" class="subitem"><div align="center">&nbsp;
                <?=$agosto ?>
              </div></td>
              <td bgcolor="ffffff" class="subitem"><div align="center">&nbsp;
                <?=$septiembre ?>
              </div></td>
              <td bgcolor="ffffff" class="subitem"><div align="center">&nbsp;
                <?=$octubre ?>
              </div></td>
              <td bgcolor="ffffff" class="subitem"><div align="center">&nbsp;
                <?=$noviembre ?>
              </div></td>
              <td bgcolor="ffffff" class="subitem"><div align="center">&nbsp;
                <?=$diciembre ?>
              </div></td>
              <td bgcolor="ffffff" class="subitem"><div align="center">&nbsp;
                <?=$total ?>
              </div></td>
             </tr>
			 <?
		   }
		   ?>			 
        </table>
		
		
		</td>
      </tr>
    </table></td>
  </tr>
</table>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
<p><br>
</p>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><HR width="100%" color=#003b85></td>
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