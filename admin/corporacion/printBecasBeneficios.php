<?php require('../../util/header.inc');
	

$corporacion   =$_CORPORACION;
$cmb_ano2;


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<style type="text/css">
<!--
.Estilo1 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.Estilo25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo8 {font-size: 10px}
-->
</style>
</head>
<script>
	function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
	</script>
<body>
<div id="capa0">
<table width="650" border="0" align="center">
  <tr>
    <td><input name="CERRAR" type="button" onClick="window.close();" value="CERRAR" class="botonXX"/></td>
    <td><div align="right">
      <input name="IMPRIMIR" type="button" onClick="imprimir();" value="IMPRIMIR" class="botonXX"  align="right"/>
    </div></td>
  </tr>
</table>
</div>
<br />
<? if($consultar==1){
$sql  ="SELECT nombre_instit, rdb FROM institucion WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.")";
$rs_instit = @pg_exec($conn,$sql);

?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center" class="Estilo1">ALUMNOS BECADOS DE TODOS LOS ESTABLECIMIENTOS </td>
  </tr>
  <tr>
    <td colspan="2" align="center" class="Estilo25">&nbsp;</td>
  </tr>
  <tr>
    <td width="8%"><span class="Estilo25">A&Ntilde;O:&nbsp;</span></td>
    <td width="92%"><span class="Estilo25">
      <?=$cmb_ano2;?>
    </span></td>
  </tr>
  <tr>
    <td colspan="2"><table width="650" border="1" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td class="Estilo1">ESTABLECIMIENTO</td>
        <td align="center"class="Estilo1">CANTIDAD</td>
      </tr>
      <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
								$fila_instit = @pg_fetch_array($rs_instit,$i);
					       ?>
      <tr>
        <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
        <? 
					$sql_ano  ="SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_instit['rdb']." ";
					$sql_ano.="and nro_ano=".$cmb_ano2."";
					$rs_ano = @pg_exec($conn,$sql_ano);
					$id_ano = pg_result($rs_ano,0);
					//echo $fila_instit['rdb']."=".$id_ano;
					
					$sql_becados  ="SELECT COUNT(*) FROM becas_benef WHERE id_ano=".$id_ano." ";
					$rs_becados = @pg_exec($conn,$sql_becados);
					$becados = pg_result($rs_becados,0);
					
						  ?>
        <td class="Estilo25"><?=$becados?></td>
        <? $total= $total+$becados; 
						  ?>
      </tr>
      <? } ?>
      <tr>
        <td class="Estilo1">TOTAL BECADOS </td>
        <td class="Estilo25"><?=$total?></td>
      </tr>
    </table>
        <br /></td>
  </tr>
</table>
<? }?>




<? if($consultar==2){
$sql  ="SELECT nombre_instit, rdb FROM institucion WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.")";
$rs_instit = @pg_exec($conn,$sql);

?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" align="center" class="Estilo1">ALUMNOS BECADOS DE TODOS LOS ESTABLECIMIENTOS POR BECA </td>
  </tr>
  <tr>
    <td colspan="2" align="center" class="Estilo25">&nbsp;</td>
  </tr>
  <tr>
    <td width="8%"><span class="Estilo25">BECA:&nbsp;</span></td>
    <? $sql_beca  ="SELECT nomb_beca FROM becas_conf WHERE id_beca=".$cmb_beca."";
					$rs_beca = @pg_exec($conn,$sql_beca);
					$beca = pg_result($rs_beca,0);?>
    <td width="92%"><span class="Estilo25">
      <?=$beca;?>
    </span></td>
  </tr>
  <tr>
    <td width="8%"><span class="Estilo25">A&Ntilde;O:&nbsp;</span></td>
    <td width="92%"><span class="Estilo25">
      <?=$cmb_ano2;?>
    </span></td>
  </tr>
  <tr>
    <td colspan="2"><table width="650" border="1" align="center" cellpadding="3" cellspacing="0">
      <tr>
        <td class="Estilo1">ESTABLECIMIENTO</td>
        <td align="center"class="Estilo1">CANTIDAD</td>
      </tr>
      <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
								$fila_instit = @pg_fetch_array($rs_instit,$i);
					       ?>
      <tr>
        <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
        <? 
					$sql_ano  ="SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_instit['rdb']." ";
					$sql_ano.="and nro_ano=".$cmb_ano2."";
					$rs_ano = @pg_exec($conn,$sql_ano);
					$id_ano = pg_result($rs_ano,0);
					//echo $fila_instit['rdb']."=".$id_ano;
					
					$sql_becados  ="SELECT COUNT(*) FROM becas_benef WHERE id_ano=".$id_ano." and id_beca=".$cmb_beca;
					$rs_becados = @pg_exec($conn,$sql_becados);
					$becados = pg_result($rs_becados,0);
					
						  ?>
        <td class="Estilo25"><?=$becados?></td>
        <? $total= $total+$becados; 
						  ?>
      </tr>
      <? } ?>
      <tr>
        <td class="Estilo1">TOTAL BECADOS </td>
        <td class="Estilo25"><?=$total?></td>
      </tr>
    </table>
        <br /></td>
  </tr>
</table>
<? }?>
</body>
</html>
<? pg_close($conn);?>