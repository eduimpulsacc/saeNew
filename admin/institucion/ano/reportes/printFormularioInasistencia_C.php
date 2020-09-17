<?	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');
	
	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$curso			=$cmb_curso	;
	$alumno			=$c_alumno	;
	$reporte		=$c_reporte;
	$fecha			=$txtFecha;
	$_POSP = 4;
	$_bot = 8;
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_membrete ->ano =$ano;
	$ob_membrete ->AnoEscolar($conn);
	
	$fecha_m = fEs2En($fecha);
	$ob_reporte->ano =$ano;
	$ob_reporte->curso =$curso;
	$ob_reporte->fecha =$fecha_m;
	
	$rs_mathombre = $ob_reporte->MatriculaHombre($conn);
	$rs_matmujer = $ob_reporte->MatriculaMujer($conn);
	$rs_inahombre = $ob_reporte->InasistenciaHombre($conn);
	$rs_inamujer = $ob_reporte->InasistenciaMujer($conn);
	$rs_profesor = $ob_reporte->ProfeJefe($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if($xls==1){
	$fecha_actual = date('d/m/Y-H:i:s');	 
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=FormularioInasistencia_$fecha_actual.xls"); 	 
	}	
	
?>
<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}


		  
function exportar(){
	window.location='printFormularioInasistencia_C.php?xls=1&cmb_curso=<?=$curso;?>&txtFecha=<?=$fecha;?>';
	return false;
		  }		  
		  
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
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
</head>

<body>
<div id="capa0">
  <table width="650" border="0" align="center">
    <tr>
      <td><input type="button" name="Submit" value="CERRAR" onClick="window.close()" class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" />
      </div></td>
	   <? if($_PERFIL == 0){?>					
		<td align="right"><input name="button32" type="button" class="botonXX" onClick="javascript:exportar();"  value="EXPORTAR"></td>
	  <? }?>
    </tr>
  </table>
</div><br />

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="10">&nbsp;</td>
    <td width="125" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
      <tr valign="top">
        <td width="125" align="center"><? if ($institucion=="770"){ 
		  
			   
	 }else{ 
	 	  
			if($institucion!=""){
			    echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
		    }else{
			    echo "<img src='".$d."menu/imag/logo.gif' >";
		    }?>
              <? } ?>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono: &nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="41" valign="top">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="tableindex"><div align="center">FORMULARIO DE CAPTURA DE INASISTENCIA DIARIA </div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("AÑO ".$ob_membrete->nro_ano)) ;?></strong></span></td>
  </tr>
</table>
<br />
<table width="600" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td class="item"><span class="Estilo5">NOMBRE DOCENTE </span></td>
    <td colspan="2" class="subitem">&nbsp;<?=$ob_reporte->profe_nombre;?></td>
  </tr>
  <tr>
    <td class="item"><span class="Estilo5">FECHA</span></td>
    <td colspan="2" class="subitem"><?=$fecha;?></td>
  </tr>
  <tr>
    <td class="item"><span class="Estilo5">CURSO</span></td>
    <td colspan="2" class="subitem"><? echo $Curso_pal = CursoPalabra($curso, 1, $conn);?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="titulo">&nbsp;</td>
    <td bgcolor="#CCCCCC" class="titulo">CANTIDAD <br />
    HOMBRES</td>
    <td bgcolor="#CCCCCC" class="titulo">CANTIDAD<br />
    MUJERES</td>
  </tr>
  <tr>
    <td class="item">CANTIDAD DE ASISTENTE </td>
    <td class="item">&nbsp;<?=@pg_result($rs_mathombre,0)-@pg_result($rs_inahombre,0);?></td>
    <td class="item">&nbsp;<?=@pg_result($rs_matmujer,0)-@pg_result($rs_inamujer,0);?></td>
  </tr>
  <tr>
    <td class="item">CANTIDAD DE INASISTENTE </td>
    <td class="item">&nbsp;<?=@pg_result($rs_inahombre,0);?></td>
    <td class="item">&nbsp;<?=@pg_result($rs_inamujer,0);?></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="item">TOTAL ALUMNOS MATRICULADOS </td>
    <td bgcolor="#CCCCCC" class="item">&nbsp;<?=@pg_result($rs_mathombre,0);?></td>
    <td bgcolor="#CCCCCC" class="item">&nbsp;<?=@pg_result($rs_matmujer,0);?></td>
  </tr>
</table>
<br />
<br />
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
</body>
</html>
