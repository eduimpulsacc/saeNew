<? 	require('../../../../../../util/header.inc');
	include('../../../../../clases/class_MotorBusqueda.php');
	include('../../../../../clases/class_Membrete.php');
	include('../../../../../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$curso			=$c_curso	;
	$alumno			=$c_alumno	; 
	$reporte		=$c_reporte;
	$_POSP = 6;
	$_bot = 8;
	
	if($curso!=1){
		$sql="SELECT id_curso FROM curso WHERE id_ano=".$ano." LIMIT 1 OFFSET 1";
		$rs_curso = @pg_exec($conn,$sql);
		$curso1 = @pg_result($rs_curso,0);
	}else{
		$curso1 = $curso;
	}	
	$ob_config = new Reporte();
	$ob_reporte = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$ob_membrete = new Membrete();
	$ob_membrete->institucion=$institucion;
	$ob_membrete->institucion($conn);
	
	
	if($_PERFIL!=0 && $_PERFIL!=14){
			//veo si tiene autorizacion permanente
			$autp=$ob_reporte->checAutReporteTrabaja($conn);
			$aut = pg_result($autp,0);
			//echo "aut->".$aut;
			
		
			if($aut==0){
				//veo si el usuario tiene el reporte
				$ob_reporte->rdb=$institucion;
				$ob_reporte->usuario= $_NOMBREUSUARIO;
				$ob_reporte->item=$reporte;
				$rp = $ob_reporte->checAutReporte($conn);
				$crp= pg_numrows($rp);
				//echo "aut2->".$crp;
			
				}
				else{
				$crp = $aut;
				}
				
				$rs_quita = $ob_reporte->quitaAutReporte($conn);
		}
		else{
		$crp=1;
		}


if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Alumnos_retirados_$fecha_actual.xls"); 	 
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

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

function cerrar(){ 
window.close();
} 


		  
function exportar(){
			window.location='print_alumnos_retirados_C.php?c_curso=<?=$curso?>&xls=1';
			return false;
		  }		  
		  
		  

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
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
 
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">


<form name="form" method="post" action="../../print_alumnos_retirados_C.php" target="_blank">

 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                <tr> 
                                  <td>
								  
								
                                  <!-- INICIO CUERPO DE LA PAGINA -->
                                  <?

								  
if($curso!=""){	?>
<center>
<table width="100%">
	<tr>
		<td align="right">

    	    <div id="capa0">
	          <div align="left">
	            <input name="cerrar" type="button" id="cerrar" class="botonXX" value="CERRAR" onClick="cerrar()">
	            </div>
    	    </div>		</td>
	    <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
	      <input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR"></td>
	</tr>
</table>
<?
if ($institucion=="770"){ 
    // no muestro los datos de la institucion
    // por que ellos tienen hojas pre-impresas
   echo "<br><br><br><br><br><br><br><br><br><br><br>";   
}else{?>
	<table width="650" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td rowspan="6"><? echo "<img src='".$d."tmp/".$institucion."insignia". "' >";	?></td>
        <td height="0" valign="top"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><?=$ob_membrete->ins_pal;?></strong></font></td>
      </tr>
      <tr>
        <td height="0"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><?=$ob_membrete->direccion;?></strong></font></td>
      </tr>
      <tr>
        <td height="0"><font face="Verdana, Arial, Helvetica, sans-seri" size="1"><strong><?=$ob_membrete->telefono;?></strong></font></td>
      </tr>
      <tr>
        <td height="0" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="0" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="0" valign="top">&nbsp;</td>
      </tr>
    </table>
<? } ?>
	<table width="100%" border="1">
		<tr>
			<td align="center" colspan="5"class="tableindex">ALUMNOS RETIRADOS	</td>
		</tr>
		<tr align="center">
			<td class="item">CURSO</td>
			<td class="item">RUT</td>
			<td class="item">ALUMNO</td>
			<td class="item">FECHA RETIRO</td>
			<td class="item">MOTIVO RETIRO</td>
		</tr>
	<? 
if(trim($curso)==1){
	$ob_reporte = new Reporte();
	$ob_reporte->institucion=$institucion;
	$ob_reporte->ano=$ano;
	$result=$ob_reporte->AlumnoRetiradoIns($conn);
}else{
	$ob_reporte = new Reporte();
	$ob_reporte->institucion=$institucion;
	$ob_reporte->curso=$curso;
	$ob_reporte->ano=$ano;
	$result=$ob_reporte->AlumnoRetiradoCurso($conn);
}


for($x=0;$x<pg_numrows($result);$x++){
	$retirados = pg_fetch_array($result,$x);
	$ob_reporte->CambiaDato($retirados);
	$curso_palabra = CursoPalabra($retirados['id_curso'], 1, $conn); ?>
		<tr align="left">
			<td class="subitem">&nbsp;<?=$curso_palabra?></td>
			<td class="subitem">&nbsp;<?=$ob_reporte->rut_alumno;?></td>
			<td class="subitem">&nbsp;<? $nombre_alu=$ob_reporte->nombre." ".$ob_reporte->ape_pat." ".$ob_reporte->ape_mat; echo $ob_reporte->tilde($nombre_alu);?></td>
			<td class="subitem">&nbsp;<? impF($ob_reporte->fecha_retiro); ?></td>
			<td class="subitem"><?php  
			switch($retirados['tipo_retiro']){
				case 1: echo "Cambio de Domicilio";
				break;
				case 2: echo "Traslado de establecimiento";
				break;
				case 3: echo "Deserci&oacute;n";
				break;
				case 4: echo "Motivos de salud";
				break;
				case 5: echo "Otros";
				break;
			} ?></td>
		</tr>	
<?	}	?>
  </table>
</center>	
<?	}	?><br>

 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
<!-- FIN CUERPO DE LA PAGINA --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table></td>
              </tr>
            </table>          </td>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
<? pg_close($conn);?>