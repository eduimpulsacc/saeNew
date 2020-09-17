<?php 
	require('../../../../util/header.inc');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');
	


	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$periodo        =$cmb_periodos;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_membrete ->ano=$ano;
	$ob_membrete ->AnoEscolar($conn);
	
	$ob_membrete ->ano=$ano;
	$ob_membrete ->periodo = $periodo;
	$ob_membrete ->periodo($conn);
	
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
		header("Content-Disposition:inline; filename=Informe_Asistencia_Grafico_Alumnos_$Fecha.xls"); 
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
//-->
</script>
<script>
function exportar(){
					//form.target="_blank";
					window.location='printInformeAsistenciaGraficoAlumnos_C.php?cmb_curso=<?=$curso?>&cmb_periodos=<?=$periodo?>';
					//document.form.submit(true);
				return false;
			}
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
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
.Estilo1 {
	font-size: 9px;
	font-weight: bold;
}
</style>
<body leftmargin="0" topmargin="0">
<table width="700" border="0" cellpadding="0" cellspacing="3">
   <div id="capa0" align="right">
   <tr>   
   <td><input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR"></td>
   <? if($_PERFIL == 0){?>
    <td><input name="button4" type="button" class="botonXX" onClick="javascript:exportar()" value="EXPORTAR"></td>
   <? }?>
 
  </tr>
</div>
  <tr><td colspan="2"><table border=0 cellspacing=1 cellpadding=3>
          <tr> 
            <td align=left class="item"> <span class="Estilo1"> INSTITUCION              </span></td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> 
              </font> </td>
            <td class="subitem"> <font face="arial, geneva, helvetica" size="1"> <strong> 
              <?=$ob_membrete->ins_pal; ?>
              </strong> </font> </td>
          </tr>
          <tr> 
            <td align=left class="item"> <span class="Estilo1"> AÑO ESCOLAR  </span></td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> </font> </td>
            <td class="subitem"> <font face="arial, geneva, helvetica" size="1"> <strong> 
              <?=$ob_membrete->nro_ano; ?>
              </strong> </font> </td>
          </tr>
          <tr> 
            <td align=left class="item"> <span class="Estilo1"> CURSO              </span></td>
            <td> <font face="arial, geneva, helvetica" size="1"> <strong>:</strong> 
              </font> </td>
            <td class="subitem"> <font face="arial, geneva, helvetica" size="1"> <strong> 
              <?php echo $Curso_pal = CursoPalabra($curso, 0, $conn);?>
              </strong> </font> </td>
          </tr>
        </table></td></tr>
  <tr><td colspan="2">
   <table width="100%"> 
	<br>
	<tr height="20"> 
      <td align="middle" class="tableindex"><div align="center">LISTADO DEL CURSO</div></td>
    </tr>
	<tr><td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><?=$ob_membrete->nombre_periodo; ?>
	  <br>
	  <br>
	  <br>
	</b></font></td></tr>
	<br>
	<tr><td>
	    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
	       <tr> 
           <td width="32" align="center" bgcolor="#666666" class="item">N&ordm;</td>
           <td width="207" align="center" bgcolor="#666666" class="item">NOMBRE</td>
		   <? if($cb_ok == "Buscar"){?>
           <td width="340" align="center" bgcolor="#666666" class="item">Asistencia</td>
           <? }?>
		   <td align="center" width="97" class="item" bgcolor="#666666"><div align="center">%</div></td>
           </tr>
			<?
			
			$ob_reporte ->curso =$curso;
			$ob_reporte ->ano = $ano;
			$ob_reporte ->retirado = 0;
			$ob_reporte ->orden=1;
			$result = $ob_reporte ->TraeTodosAlumnos($conn);

			/// ciclo para listar cada alumno	
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila = @pg_fetch_array($result,$i);
				$rut_alumno = $fila['rut_alumno'];		
				
				$ob_reporte ->periodo = $periodo;
				$ob_reporte ->Periodo($conn);
				$result_periodo = $ob_reporte->result;
				$periodos = @pg_numrows($result_periodo);
				$cadena_asis_periodo=0;
				for($cont=0 ; $cont < @pg_numrows($result_periodo) ; $cont++){
					$fila_periodo = @pg_fetch_array($result_periodo,$cont);
					$fecha_ini = $fila_periodo['fecha_inicio'];
					$fecha_fin = $fila_periodo['fecha_termino'];
					$dias_habiles = $fila_periodo['dias_habiles'];
									
					
					//$sql_asis = "select * from asistencia where fecha > '".$fila_periodo['fecha_inicio']."' and fecha < '".$fila_periodo['fecha_termino']."' and rut_alumno = ".trim($rut_alumno);
					$ob_reporte ->ano = $ano;
					$ob_reporte ->alumno = $rut_alumno;
					$ob_reporte ->fecha_inicio=$fila_periodo['fecha_inicio'];
					$ob_reporte ->fecha_termini = $fila_periodo['fecha_termino'];
					$result_asis = $ob_reporte ->Asistencia($conn);
					//@pg_Exec($conn, $sql_asis);
					$num_asis = @pg_numrows($result_asis);
					
					
					$asistencia = @round(100-($num_asis*100/$dias_habiles));	
					$anchotabla = (3 * $asistencia);
							
				}		
				?>
			   <tr>
			   <td align="left" class="subitem" > <font color="#000000">&nbsp;&nbsp;<? echo $i+1; ?></font> </td>
			   <td align="left" class="subitem" ><font  color="#000000"><?php echo $ob_reporte->tilde($fila["ape_pat"]." ".$fila["ape_mat"].", ".$fila["nombre_alu"]);?></font></td>
			   <? if($cb_ok == "Buscar"){?>
			   <td width="340" align="left" class="subitem" >
				       <table border="2" cellspacing="0" cellpadding="0" height="13">
					      <tr>
						      <td  width="<?=$anchotabla ?>"></td>
							  <td  width="9"></td>
						  </tr>
			      </table>				</td>
				  <? }?>
			   <td align="right" bgcolor="#c8d6fb" class="subitem" ><? echo "$asistencia %"; ?></td>
			   </tr>
             <? }?>
		 </table>
	 </td>
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
  </td></tr>
</table>
<br>
</body>
</html>
<? pg_close($conn);?>