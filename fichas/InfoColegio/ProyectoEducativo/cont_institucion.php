<?php 
	require('../../../util/header.inc');
	require("mod_institucion.php");

	$ob_reporte = new Institucion();
	
	$funcion =$_POST['funcion'];

if($funcion==1){
	$rs_institucion = $ob_reporte->Institucion($conn,$_INSTIT);
	?>
<table width="85%" border="0" align="center">
  <tr>
    <td class="tableindexredondo">&nbsp;PROYECTO EDUCATIVO</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textosimple" align="justify">&nbsp;<?=nl2br(pg_result($rs_institucion,0));?></td>
  </tr>
</table>
	
<?
}
	
?>
