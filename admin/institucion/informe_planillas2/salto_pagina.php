<?php
require('../../../util/header.inc');

	//print_r($_POST);
	
	$platilla = $_POST['plantilla'];
	$funcion = $_POST['funcion'];
	
if($funcion==1){
 //print_r($_POST);
 
 $sql_up="update informe_area_item set salto_pagina=$chk where id=$id_cat";
 $res = pg_exec($conn,$sql_up)or die("f ".$sql_up);
 if($res){
	 echo 1;
	 }else{
	 echo 0;	 
	 }
 
 
}else{
	

	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<table width="650" align="center" border="0" style="border-collapse:collapse;">
<tr class="cuadro02">
<td width="%">NOMBRE</td>
<td width="%">SALTO</td>
</tr>
<tr class="cuadro02">
<td width="%" colspan="2">&nbsp;</td>
</tr>
<?
	$sql="select * from informe_area_item where id_plantilla=$platilla and id_padre=0 order by id";
	$result = pg_exec($conn,$sql)or die("f ".$sql);
	for($x=0;$x<pg_numrows($result);$x++){
	$fila = pg_fetch_array($result,$x);
	//print_r($fila);
	?>
    <tr class="cuadro01">
    <td><?=$fila['glosa']?></td>
    <?
    	if($fila['salto_pagina']==1){
	?>
      <td><input type="checkbox" name="salto<?=$x?>" id="salto<?=$x?>" value="0" onClick="guarda_salto(<?=$fila['id']?>,this.name)" checked></td>
    <?		
			}else{
	?>
    <td><input type="checkbox" name="salto<?=$x?>" id="salto<?=$x?>" value="0" onClick="guarda_salto(<?=$fila['id']?>,this.name)"></td>
    <?
			}
	}
	
?>

</tr>
<tr>
<td >&nbsp;</td>
</tr>
<tr>
<td style="font-size:10px; font-family:Arial, Helvetica, sans-serif; color:#30F">(Generar&aacute; un salto de pagina en el item seleccionado)</td>
</tr>

</table>
</body>
</html>
<?
}
?>