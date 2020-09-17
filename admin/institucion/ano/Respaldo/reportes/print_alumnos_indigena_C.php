<?	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
 	$curso			=$c_curso;
	$alumno			=$c_alumno;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	if($curso==1){
		$sql="SELECT id_curso FROM curso WHERE id_ano=".$ano." LIMIT 1 OFFSET 1";
		$rs_curso = @pg_exec($conn,$sql);
		$curso1 = @pg_result($rs_curso,0);
	}
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	$ob_membrete = new Membrete();
	$ob_membrete->institucion=$institucion;
	$ob_membrete->institucion($conn);
	
if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Alumnos_extranjeros_$fecha_actual.xls"); 	 
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

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}


function exportar(){
			window.location='print_alumnos_extranjeros_C.php?c_curso=<?=$curso?>&xls=1';
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
function cerrar(){ 
	window.close();
}
//-->
</script>
<script> 
 
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
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">


<form name="form" method="post" action="print_alumnos_extranjeros_C.php" target="_blank">

 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top"> 
                              <table width="650" border="0" align="center" cellpadding="0" cellspacing="0" >
                                <tr> 
                                  <td>
								  
								
                                  <!-- INICIO CUERPO DE LA PAGINA -->
                                  <?

								  
if($curso!=""){	?>
<center>
<table width="100%">
	<tr>
		<td align="right"><div id="capa0">
		  <div align="left">
		    <input type="button" name="cerrar" value="CERRAR" class="botonXX" onClick="window.close()">
		    </div>
		</div></td>
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
			<td align="center" colspan="4"class="tableindex">ALUMNOS EXTRANJEROS</td>
		</tr>
		<tr align="center">
			<td class="item">CURSO</td>
			<td class="item">RUT</td>
			<td class="item">ALUMNO</td>
			
		</tr>
	<? 
if($curso == "1")
{
	$ob_reporte =new Reporte();
	$ob_reporte->institucion=$institucion;
	$ob_reporte->ano=$ano;
	$result=$ob_reporte->AlumnoIndigenaIns($conn);
}else{
	$ob_reporte =new Reporte();
	$ob_reporte->institucion=$institucion;
	$ob_reporte->ano=$ano;
	$ob_reporte->curso=$curso;
	$result=$ob_reporte->AlumnoIndigenaCurso($conn);
}


for($x=0;$x<pg_numrows($result);$x++)
{
$fila = pg_fetch_array($result,$x);
$curso_palabra = CursoPalabra($fila['id_curso'], 1, $conn);
$ob_reporte->CambiaDato($fila);
$nombre_alu=$ob_reporte->nombre_alu." ".$ob_reporte->ape_pat." ".$ob_reporte->ape_mat;
?>
		<tr align="left">
			<td class="subitem"><?=$curso_palabra?></td>
			<td class="subitem"><?=$ob_reporte->rut_alumno;?></td>
			<td class="subitem"><?=$ob_reporte->tilde($nombre_alu);?></td>
			
		</tr>	
<?	}	?>
  </table>
</center>	
<?	}	?>

	
	
<!-- FIN CUERPO DE LA PAGINA --> </td>
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
<? pg_close($conn);
?>