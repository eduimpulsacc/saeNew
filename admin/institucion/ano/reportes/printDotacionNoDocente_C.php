<?	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');
	
	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$curso			=$c_curso	;
	$alumno			=$c_alumno	;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_membrete ->ano =$ano;
	$ob_membrete ->AnoEscolar($conn);
	
	$ob_reporte ->rdb =$institucion;
	$ob_reporte ->ano =$ano;
	$ob_reporte ->cargo="(1,2,6)";
	$rs_empleado = $ob_reporte->DotacionDirectivo($conn);
	
	$ob_reporte ->rdb =$institucion;
	$ob_reporte ->ano =$ano;
	$ob_reporte ->cargo="(1,2,6,5)";
	$rs_tecnico = $ob_reporte->DotacionTecnico($conn);
	
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
header("Content-Disposition:inline; filename=DotacionDocente_$fecha_actual.xls"); 	 
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
	window.location='printDotacionNoDocente_C.php?xls=1';
	return false;
		  }		  
		  
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</head>
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
<body>
<div id="capa0">
  <table width="650" border="0" align="center">
    <tr>
      <td><input type="button" name="Submit" value="CERRAR" onclick="window.close()" class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onclick="imprimir();"  value="IMPRIMIR" />
      </div></td>
	  <? if($_PERFIL == 0){?>					
		<td align="right"><input name="button32" type="button" class="botonXX" onClick="javascript:exportar();"  value="EXPORTAR"></td>
	  <? }?>
    </tr>
  </table>
</div>
<br />
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
    <td align="center" class="tableindex"><div align="center">DOTACI&Oacute;N DOCENTE </div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("AÑO ".$ob_membrete->nro_ano)) ;?></strong></span></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="7" class="item">    DIRECTIVOS DOCENTES </td>
  </tr>
  <tr>
    <td class="item">RUT</td>
    <td class="item">CALIDAD <br />
    CONTRATO </td>
    <td class="item">NOMBRE</td>
    <td class="item">HORAS<br />
    CONTRATO</td>
    <td class="item">AMPLIACI&Oacute;N<br />
    HORARIA</td>
    <td class="item">TOTAL</td>
    <td class="item">TIPO<br />
      FUNCI&Oacute;N</td>
  </tr>
   <? for($i=0;$i<@pg_numrows($rs_empleado);$i++){
  		$fila_emp = @pg_fetch_array($rs_empleado,$i);
		if($fila_emp['tipo_emp']==0)
			$contrato = "&nbsp;";
		elseif($fila_emp['tipo_emp']==1)
			$contrato="Indefinido";
		elseif($fila_emp['tipo_emp']==2)
			$contrato="Plazo Fijo";
		elseif($fila_emp['tipo_emp']==3)
			$contrato="Honorarios";
  ?>
  <tr>
    <td class="subitem"><div align="right">
        <?=$fila_emp['rut_emp']."-".$fila_emp['dig_rut'];?>
    </div></td>
    <td class="subitem"><?=$contrato;?></td>
    <td class="subitem"><div align="left"><?=$fila_emp['nombre'];?></div></td>
    <td class="subitem"><?=$fila_emp['hrs_contrato'];?></td>
    <td class="subitem"><?=$fila_emp['amp_simple'];?></td>
    <td class="subitem"><?=$fila_emp['total_aula'];?></td>
    <td class="subitem"><?=$fila_emp['tipo_func'];?></td>
  </tr>
  <? 	$total_contrato = $total_contrato + $fila_emp['hrs_contrato'];
  		$total_simple	= $total_simple + $fila_emp['amp_simple'];
		$total_aula		= $total_aula + $fila_emp['total_aula'];
		
  } ?>
  <tr>
    <td colspan="3" class="item">TOTALES</td>
    <td class="item"><?=$total_contrato;?></td>
    <td class="item"><?=$total_simple;?></td>
    <td class="item"><?=$total_aula;?></td>
    <td class="item">&nbsp;</td>
  </tr>
</table>
<p><br />
</p>
<table width="650" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="7" class="item"> TECNICO- PEDAGOGICOS </td>
  </tr>
  <tr>
    <td class="item">RUT</td>
    <td class="item">CALIDAD <br />
    CONTRATO </td>
    <td class="item">NOMBRE</td>
    <td class="item">HORAS<br />
    CONTRATO</td>
    <td class="item">AMPLIACI&Oacute;N<br />
    HORARIA</td>
    <td class="item">TOTAL</td>
    <td class="item">TIPO<br />
    FUNCI&Oacute;N</td>
  </tr>
  <? for($i=0;$i<@pg_numrows($rs_tecnico);$i++){
  		$fila_tec = @pg_fetch_array($rs_tecnico,$i);
		if($fila_tec['tipo_emp']==0)
			$contrato = "&nbsp;";
		elseif($fila_tec['tipo_emp']==1)
			$contrato="Indefinido";
		elseif($fila_tec['tipo_emp']==2)
			$contrato="Plazo Fijo";
		elseif($fila_tec['tipo_emp']==3)
			$contrato="Honorarios";
  ?>
  <tr>
    <td class="subitem"><div align="right">
        <?=$fila_tec['rut_emp']."-".$fila_tec['dig_rut'];?>
    </div></td>
    <td class="subitem"><?=$contrato;?></td>
    <td class="subitem"><div align="left"><?=$fila_tec['nombre'];?></div></td>
    <td class="subitem"><?=$fila_tec['hrs_contrato'];?></td>
    <td class="subitem"><?=$fila_tec['amp_simple'];?></td>
    <td class="subitem"><?=$fila_tec['total_aula'];?></td>
    <td class="subitem"><?=$fila_tec['tipo_func'];?></td>
  </tr>
  <? 	$total_contrato_t 	= $total_contrato_t + $fila_tec['hrs_contrato'];
  		$total_simple_t		= $total_simple_t + $fila_tec['amp_simple'];
		$total_aula_t		= $total_aula_t + $fila_tec['total_aula'];
  } ?>
  <tr>
    <td colspan="3" class="item">TOTALES</td>
    <td class="item"><?=$total_contrato_t;?></td>
    <td class="item"><?=$total_simple_t;?></td>
    <td class="item"><?=$total_aula_t;?></td>
    <td class="item">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
