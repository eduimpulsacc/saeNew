<?	require('../../../../util/header.inc');
	include('../../../clases/class_MotorBusqueda.php');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');
	
	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$curso			=$c_curso	;
	$alumno			=$c_alumno	;
	$reporte		=79;//$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	$ob_membrete ->ano =$ano;
	$ob_membrete ->AnoEscolar($conn);
	
	$sql = "SELECT sum(hrs_plan) as  plan , sum(hrs_jec) as jec, grado_curso,ensenanza  FROM ramo INNER JOIN curso ON ramo.id_curso=curso.id_curso WHERE id_ano=".$ano." GROUP BY grado_curso, ensenanza ORDER BY ensenanza, grado_curso ASC";
	$rs_horas = @pg_exec($conn,$sql);
	
	
	
	
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
      <td><input type="button" name="Submit" value="CERRAR" onClick="window.close()" class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" />
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
<table width="650" align="center">
	<tr><td valign="top">
<table width="90%" border="1" align="left" cellpadding="5" cellspacing="0">
  
  <tr>
    <td class="item">NIVELES</td>
    <td class="item">N&ordm; CURSO  </td>
    <td class="item">HORAS<br />
      PLAN ESTUDIO </td>
    <td class="item">HORAS<br />
      JEC</td>
    <td class="item">TOTAL</td>
  </tr>
  <? $sql = "SELECT distinct  b.cod_tipo, b.nombre_tipo FROM tipo_ense_inst a INNER JOIN tipo_ensenanza b ON a.cod_tipo=b.cod_tipo where rdb=".$institucion." ";
  	 $rs_ensenanza = @pg_exec($conn,$sql);
	 for($i=0;$i<@pg_numrows($rs_ensenanza);$i++){
	 	$fila_ense = @pg_fetch_array($rs_ensenanza,$i);
	?>
  
  <tr>
    <td class="subitem"><?=$fila_ense['nombre_tipo'];?></td>
    <td class="subitem">&nbsp;</td>
    <td class="subitem">&nbsp;</td>
    <td class="subitem">&nbsp;</td>
    <td class="subitem">&nbsp;</td>
  </tr>
  <? 	$sql = "SELECT COUNT(*) as cuenta, grado_curso FROM curso WHERE id_ano=".$ano." AND ensenanza=".$fila_ense['cod_tipo']." GROUP BY grado_curso ORDER BY grado_curso ASC";
  		$rs_curso = @pg_exec($conn,$sql);
		
		
		for($j=0;$j<@pg_numrows($rs_curso);$j++){
			$fila_curso = @pg_fetch_array($rs_curso,$j);
			for($x=0;$x<@pg_numrows($rs_horas);$x++){
				$fila_hrs = @pg_fetch_array($rs_horas,$x);
				if(($fila_ense['cod_tipo']==$fila_hrs['ensenanza']) && ($fila_curso['grado_curso']==$fila_hrs['grado_curso'])){
					$horas_plan= $fila_hrs['plan'];
					$horas_jec= $fila_hrs['jec'];
					$total = $horas_plan + $horas_jec;
					$total_plan = $total_plan + $horas_plan;
					$total_jec = $total_jec + $horas_jec;
					$total_gral = $total_gral + $total;
					break;
				}
			}
	?>
  <tr>
  	<? if($fila_ense['cod_tipo']==10){?>
	    <td class="subitem"><?=CursoPalabra_Informe(2,$fila_ense['cod_tipo'],$fila_curso['grado_curso'],$conn);?></td>
	<? }else{?>
		<td class="subitem"><?=$fila_curso['grado_curso'];?></td>
	<? } ?>
    <td class="subitem"><?=$fila_curso['cuenta'];?></td>
    <td class="subitem">&nbsp;<?=$horas_plan;?></td>
    <td class="subitem">&nbsp;<?=$horas_jec;?></td>
    <td class="subitem">&nbsp;<?=$total;?></td>
  </tr>	
		
<?		$total_curso=$total_curso + $fila_curso['cuenta'];	
}
  
  } ?>
  
  <tr>
    <td class="item">TOTALES</td>
    <td class="item"><?=$total_curso;?></td>
    <td class="item">&nbsp;<?=$total_plan;?></td>
    <td class="item">&nbsp;<?=$total_jec;?></td>
    <td class="item">&nbsp;<?=$total_gral;?></td>
  </tr>
</table>
</td><td valign="middle">
<table width="90%" border="1" align="right" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="2" class="subitem">Uso Exlcusivo &Aacute;rea de Educaci&oacute;n </td>
    </tr>
  <tr>
    <td colspan="2" class="subitem">&nbsp;</td>
    </tr>
  <tr>
    <td width="69%" class="subitem">Plan de Estudio </td>
    <td width="31%" class="subitem">&nbsp;</td>
  </tr>
  <tr>
    <td class="subitem">Contrata</td>
    <td class="subitem">&nbsp;</td>
  </tr>
  <tr>
    <td class="subitem">Excedente</td>
    <td class="subitem">&nbsp;</td>
  </tr>
</table>

</td></tr>
</table>
<p><br />
</p>
<p>&nbsp;</p>
</body>
</html>
