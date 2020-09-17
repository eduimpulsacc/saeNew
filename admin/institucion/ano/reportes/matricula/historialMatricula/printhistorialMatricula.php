<?php
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_Reporte.php');
include('../../../../../clases/class_Membrete.php');

	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= 1;
    $tipolibro      = $_POST['tipolibro'];
   	$reporte		= $c_reporte;
	$docente		= 5; //Codigo Docente

	
	$fecha1 	 = $anoN."-04-30"; 
	$ob_membrete = new Membrete();
	$ob_membrete -> ano = $ano;
	$ob_membrete -> institucion = $institucion;
	$ob_membrete -> institucion($conn);
	
	
	$ob_membrete -> AnoEscolar($conn);
	
	
	$ob_reporte = new Reporte();
	$ob_reporte ->cod_tipo = $cmb_curso;
	$ob_reporte ->TipoEnsenanza($conn);
	
	
	

	$ob_reporte_apo = new Reporte();
	
	$ob_reporte ->institucion = $institucion;
	$ob_reporte ->ano =$ano;
	$ob_reporte ->cmb_curso = $cmb_curso;

	
	

	
	
		$resultado_query= $ob_reporte ->AlumnoEnsenanza($conn);
		$total_filas= @pg_numrows($resultado_query);
	
	
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
	header("Content-Disposition:inline; filename=historial_matricula_$Fecha.xls"); 
	
}	
$ob_reporte->rdb=$institucion;
$ob_reporte->nroano=$ob_membrete ->nro_ano;
$rs_ano = $ob_reporte->AnoInstitucionHasta($conn);

	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script>
	function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
	
<SCRIPT language="JavaScript">
<!-- 
	   function enviapag2(form){
	   form.target="_blank";
       form.action=='printRegistroMatricula_Ensenanza_C.php?cmb_curso=<?=$curso?>&orden=<?=$orden?>';
	   form.submit(true);
		  	}

       function enviapag(form){
	   if (form.cmb_curso.value!=0){
	   form.cmb_curso.target="self";
	   form.action = 'RegistroMatricula.php?institucion=$institucion';
	   form.submit(true);
			}	
		}
//-->
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
<style type="text/css">
<!--
.Estilo1 {font-size: 9px}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">




 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								 

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->

  <STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<center>
<?
if ($curso != 0){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td>
  	<div id="capa0">
	<TABLE width="100%"><TR><TD>
	<table>
    <tr>
	  <td align="left"><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">	  </td>
	</tr>
  </table>
  </TD><TD>
		<div align="right"> <font face="Arial, Helvetica, sans-serif" size="-1">Imprimir Horizontal</font>
		  <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">	
          <!--INPUT name="button" TYPE="button" class="botonX" onClick=document.location="curso.php3" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="VOLVER"-->
  		</div></TD>
		
  <TD>&nbsp;</TD>
	</TR></TABLE>
	</div>
	</td>
  </tr>
  <tr>
    <td>
	 <table width="100%" height="" border="0" >
        <tr>
          <td align="left" class="textonegrita">RBD</td>
          <td align="left" class="textonegrita">:&nbsp;<? echo $institucion."-".$ob_membrete->dig_rdb;; ?></td>
          <td align="left" class="textonegrita">&nbsp;</td>
          <td rowspan="5" align="right" class="textonegrita">
          <?
					$result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto  = @pg_fetch_array($result,0);
					## c&oacute;digo para tomar la insignia
			
				  if($institucion!=""){
					  $rt = "../../../../../../tmp/";
					  
					  echo "<img src='".$rt.$fila_foto['rdb']."insignia". "' >";
					 // echo "<img src='"."http://".$_SERVER['HTTP_HOST']."/sae3.0/tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?>
       
          </td>
          <td align="left" class="textonegrita">&nbsp;</td>
        </tr>
        <tr>
          <td width="138" align="left" class="textonegrita">ESTABLECIMENTO</td>
          <td width="200" align="left" class="textonegrita">:&nbsp;<?=$ob_membrete->ins_pal; ?></td>    
          <td width="50" align="left" class="textonegrita">&nbsp;</td>
          <td width="243" align="left" class="textonegrita">&nbsp;</td>
        </tr>
        <tr>
          <td class="textonegrita">DIRECCION</td>
          <td class="textonegrita">:&nbsp;<? echo $ob_reporte->tildeM(strtoupper($ob_membrete->direccion));?></td>
          <td class="textonegrita">&nbsp;</td>
          <td width="243" align="left" class="textonegrita">&nbsp;</td>
        </tr>
        <tr>
          <td class="textonegrita">FONO</td>
          <td class="textonegrita">:&nbsp;<? echo strtoupper($ob_membrete->telefono) ?></td>
          <td class="textonegrita">&nbsp;</td>
          <td align="left" class="textonegrita">&nbsp;</td>
        </tr>
        <tr>
          <td class="textonegrita">COMUNA</td>
          <td class="textonegrita">:&nbsp;<? echo strtoupper($ob_membrete->comuna) ?></td>
          <td class="textonegrita">&nbsp;</td>
          <td align="left" class="textonegrita">&nbsp;</td>
        </tr>
        <tr>
          <td class="textonegrita">TIPO DE ENSEÑANZA</td>
          <td class="textonegrita">:&nbsp;<? echo strtoupper($ob_reporte->nombre) ?></td>
          <td class="textonegrita">&nbsp;</td>
          <td class="textonegrita">&nbsp;</td>
          <td align="left" class="textonegrita">&nbsp;</td>
        </tr>
		<tr>
			<td>&nbsp;</td>
            <td></td>
		</tr>
        <tr>
          <td height="16" colspan="14"><div align="center" class="textonegrita"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>LIBRO DE REGISTRO DE MATR&Iacute;CULA <?php echo $ob_membrete ->nro_ano; ?></strong></font></div></td>
        </tr>
      </table>

<!--TABLA MUESTRA DATOS -->
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse" class="textosimple">
<tr>
  <td rowspan="2">CURSO</td>
  <td rowspan="2">RUT</td>
  <td rowspan="2">ALUMNO</td>
 <?php  for($a=0;$a<pg_numrows($rs_ano);$a++){
	 $fila_ano = pg_fetch_array($rs_ano,$a);
	 $id_ano = $fila_ano['id_ano'];
	 $nro_ano = $fila_ano['nro_ano'];
	 ?>
  <td colspan="2" align="center">&nbsp;<?php echo $nro_ano ?></td>
  <?php }?>
  </tr>
<tr>
 <?php  for($a=0;$a<pg_numrows($rs_ano);$a++){ ?>
  <td align="center" nowrap>F. Matr&iacute;cula</td>
    <td align="center" nowrap>F. Retiro</td>
<?php  }?>
</tr>
  <?php for($i=0;$i<pg_numrows($resultado_query);$i++){
	  $fila_alu = pg_fetch_array($resultado_query,$i);
	  ?>
<tr>
  <td nowrap><?php echo CursoPalabra($fila_alu['id_curso'],1,$conn) ?>&nbsp;</td>
  <td nowrap><?php echo $fila_alu['rut_alumno']."-".$fila_alu['dig_rut'] ?>&nbsp;</td>
  <td nowrap><?php echo $fila_alu['ape_pat']." ".$fila_alu['ape_mat']." ".$fila_alu['nombre_alu'] ?>&nbsp;</td>
  <?php  for($a=0;$a<pg_numrows($rs_ano);$a++){
	   $fila_ano = pg_fetch_array($rs_ano,$a);
	 $id_ano = $fila_ano['id_ano'];
	 $nro_ano = $fila_ano['nro_ano'];
	 
	 $ob_reporte->alumno = $fila_alu['rut_alumno'];
	 $ob_reporte->id_ano = $id_ano;
	 $rs_damata =  $ob_reporte->fechaMatrPANO($conn);
	 
	  ?>
  <td align="center" nowrap><?php echo CambioFD(pg_result($rs_damata,0)) ?></td>
  <td align="center" nowrap><?php echo CambioFD(pg_result($rs_damata,1)) ?></td>
  <?php }?>
</tr>
<?php }?>
</table>
</td>
  </tr>
</table>
<? //pg_close($conn);
}

?>
</center>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 $concur=0;
		 include("firmas/firmas.php");?>

 <!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->
								 
<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table>
							  
						    </td>
                          </tr>
                        </table>
						
					</td>
                    </tr>
                  </table>
               </td>
              </tr>
            </table>
          </td>

       
        </tr>
      </table>
    </td>
  </tr>
</table>

</body>
</html>
<? pg_close($conn);?>