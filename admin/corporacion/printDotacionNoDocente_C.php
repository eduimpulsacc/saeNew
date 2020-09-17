<?	require('../../util/header.inc');
	
	

$corporacion   =$_CORPORACION;
$ano		   = $cmbANOS;
	
	
	$sql = "SELECT nombre_corp FROM corporacion WHERE num_corp=".$corporacion;
	$rs_corp = @pg_exec($conn,$sql);
	$nombre_corp = @pg_result($rs_corp,0);
	
	$sql ="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
	$rs_ano = @pg_exec($conn,$sql);
	$nro_ano = @pg_result($rs_ano,0);
	

	
	
	$sql = "SELECT nombre_instit, rdb FROM institucion WHERE rdb in (".$rdb.")";
	$rs_instit = @pg_exec($conn,$sql);
	


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
<style type="text/css">
<!--
.Estilo1 {font-family: Verdana, Arial, Helvetica, sans-serif}
-->
</style>
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

.Estilo2 {font-size: 10px}
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
<br />
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="tableindex"><div align="center">DIRECTIVO DOCENTE </div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("A�O ".$cmbANOS)) ;?></strong></span></td>
  </tr>
</table>
<br />

<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
  <? for($x=0;$x<@pg_numrows($rs_instit);$x++){
  		$fila_inst = @pg_fetch_array($rs_instit,$x);
		$total_contrato = 0;
		$total_69 = 0;
		$total_simple = 0;
		$total_jec = 0;
		$total_aula = 0;
		$total_ex = 0;
?>
  <tr>
    <td  class="item Estilo1 Estilo2"><b><?=strtoupper($fila_inst['nombre_instit']);?></b></td>
  </tr>
  <tr>
    <td><table width="750" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="7" class="Estilo1 Estilo2">    DIRECTIVOS DOCENTES </td>
  </tr>
  <tr>
    <td class="Estilo1 Estilo2">RUT</td>
    <td class="Estilo1 Estilo2">CALIDAD <br />
    CONTRATO </td>
    <td class="Estilo1 Estilo2">NOMBRE</td>
    <td class="Estilo1 Estilo2">HORAS<br />
    CONTRATO</td>
    <td class="Estilo1 Estilo2">AMPLIACI&Oacute;N<br />
    HORARIA</td>
    <td class="Estilo1 Estilo2">TOTAL</td>
    <td class="Estilo1 Estilo2">TIPO<br />
      FUNCI&Oacute;N</td>
  </tr>
   <? 
   	$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmbANOS."  ";
	$rs_ano = pg_exec($conn,$sql);
	$ano_inst = pg_result($rs_ano,0);
	
	if($ano_inst=="") $ano_inst=0;	
	
   	$sql ="SELECT a.*,b.dig_rut,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' ' as varchar) || b.ape_mat as nombre FROM dotacion_docente a ";
	$sql.=" INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$fila_inst['rdb']." and id_ano=".$ano_inst." AND cargo in (1,2,6) ORDER BY ape_pat ASC";
	$rs_empleado = @pg_exec($conn,$sql) or die ("SELECT FALL� (DotacionDocente):".$sql);
   for($i=0;$i<@pg_numrows($rs_empleado);$i++){
  		$fila_emp = @pg_fetch_array($rs_empleado,$i);
		if($fila_emp['tipo_emp']==0)
			$contrato = "&nbsp;";
		elseif($fila_emp['tipo_emp']==1)
			$contrato="INDEFINIDO";
		elseif($fila_emp['tipo_emp']==2)
			$contrato="PLAZO FIJO";
		elseif($fila_emp['tipo_emp']==3)
			$contrato="HONORARIOS";
  ?>
  <tr>
    <td class="subitem"><div align="right" class="Estilo1 Estilo2">
        <?=$fila_emp['rut_emp']."-".$fila_emp['dig_rut'];?>
    </div></td>
    <td class="subitem"><span class="Estilo1 Estilo2">
      <?=$contrato;?>
    </span></td>
    <td class="subitem"><div align="left" class="Estilo1 Estilo2"><?=strtoupper($fila_emp['nombre']);?></div></td>
    <td class="subitem"><span class="Estilo1 Estilo2">
      <?=$fila_emp['hrs_contrato'];?>
    </span></td>
    <td class="subitem"><span class="Estilo1 Estilo2">
      <?=$fila_emp['amp_simple'];?>
    </span></td>
    <td class="subitem"><span class="Estilo1 Estilo2">
      <?=$fila_emp['total_aula'];?>
    </span></td>
    <td class="subitem"><span class="Estilo1 Estilo2">
      <?=strtoupper($fila_emp['tipo_func']);?>
    </span></td>
  </tr>
  <? 	$total_contrato = $total_contrato + $fila_emp['hrs_contrato'];
  		$total_simple	= $total_simple + $fila_emp['amp_simple'];
		$total_aula		= $total_aula + $fila_emp['total_aula'];
		
  } ?>
  <tr>
    <td colspan="3" class="Estilo1 Estilo2">TOTALES (<?=$i;?>)</td>
    <td class="item"><span class="Estilo1 Estilo2">
      <?=$total_contrato;?>
    </span></td>
    <td class="item"><span class="Estilo1 Estilo2">
      <?=$total_simple;?>
    </span></td>
    <td class="item"><span class="Estilo1 Estilo2">
      <?=$total_aula;?>
    </span></td>
    <td class="Estilo1 Estilo2">&nbsp;</td>
  </tr>
</table></td>
  </tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <? } ?>
  
</table>



<p>&nbsp;</p>
</body>
</html>
