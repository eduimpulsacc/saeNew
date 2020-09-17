<?	require('../../util/header.inc');
	/*include('../clases/class_MotorBusqueda.php');
	include('../clases/class_Membrete.php');
	include('../clases/class_Reporte.php');*/

	$institucion	=$_INSTIT	;
	//$ano			=$_ANO		;
	$corporacion	=$_CORPORACION;
	$curso			=$c_curso	;
	$alumno			=$c_alumno	;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	
	$sql = "SELECT nombre_corp FROM corporacion WHERE num_corp=".$corporacion;
	$rs_corp = @pg_exec($conn,$sql);
	$nombre_corp = @pg_result($rs_corp,0);
	
	$sql ="SELECT rdb,id_ano FROM ano_escolar a INNER JOIN corp_instit b ON a.id_institucion=b.rdb where b.num_corp=".$_CORPORACION." AND a.nro_ano=".$nro_ano;
	$rs_instit = @pg_exec($conn,$sql);
	for($i=0;$i<@pg_numrows($rs_instit);$i++){
		$fila_ins = @pg_fetch_array($rs_instit,$i);
		if($i==0){
			$rdb = $fila_ins['rdb'];
			$ano = $fila_ins['id_ano'];
		}else{
			$rdb = $rdb.",".$fila_ins['rdb'];
			$ano = $ano.",".$fila_ins['id_ano'];
		}
	}
		
	$sql="SELECT a.nombre_instit,sum(b.hrs_contrato) as contrato, sum(b.art_69) as art, sum(b.amp_simple) as simple , sum(b.amp_jec) as jec,
sum(total_aula) as aula FROM institucion a INNER JOIN dotacion_docente b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON c.id_institucion=a.rdb 
AND c.id_institucion=b.rdb WHERE b.rdb IN (".$rdb.") AND b.id_ano in (".$ano.") GROUP BY nombre_instit  ";
	$rs_informe = @pg_exec($conn,$sql);
?>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
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
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo5 {font-size: 14px}
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; }
.Estilo8 {font-size: 10px}
-->
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
    <td align="right"><input name="button32" type="button" class="botonXX" onClick="javascript:exportar();"  value="EXPORTAR" /></td>
    <? }?>
  </tr>
</table>
</div>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" class="tableindex Estilo4 Estilo5"><div align="center">CORPORACI&Oacute;N DE 
      <?=strtoupper($nombre_corp);?>
    </div></td>
  </tr>
  <tr>
    <td align="center" class="tableindex"><div align="center" class="Estilo7">DOTACI&Oacute;N DOCENTE </div></td>
  </tr>
  <tr>
    <td align="center"><span class="Estilo7"><strong><? echo trim(strtoupper("AÑO ".$nro_ano)) ;?></strong></span></td>
  </tr>
</table>
<br />
<table width="650" border="1" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><span class="Estilo3">INSTITUCION</span></td>
    <td><span class="Estilo3">HORAS<br />
    CONTRATO</span></td>
    <td><span class="Estilo3">ART.69</span></td>
    <td><span class="Estilo3">HORAS<br />
      AMPLIACI&Oacute;N<br />
      SIMPLES</span></td>
    <td><span class="Estilo3">HORAS<br />
      AMPLIACI&Oacute;N <br />
      JEC </span></td>
    <td><span class="Estilo3">TOTAL<br />
      HORAS<br />
      AULA</span></td>
  </tr>
  <? for($i=0;$i<@pg_numrows($rs_informe);$i++){
			$fila = @pg_fetch_array($rs_informe,$i);?>
	  <tr>
		<td><span class="Estilo8"><?=$fila['nombre_instit'];?></span></td>
		<td><span class="Estilo8"><?=$fila['contrato'];?></span></td>
		<td><span class="Estilo8"><?=$fila['art'];?></span></td>
		<td><span class="Estilo8"><?=$fila['simple'];?></span></td>
		<td><span class="Estilo8"><?=$fila['jec'];?></span></td>
		<td><span class="Estilo8"><?=$fila['aula'];?></span></td>
	  </tr>
	  <? } ?>
	</table>
	<br>
	
</table>
</body>
</html>
<? pg_close($conn);?>
