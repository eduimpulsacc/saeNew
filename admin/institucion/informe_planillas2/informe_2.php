<?php require('../../../util/header.inc');
$plantilla	=$_PLANTILLA;
$area		=$_AREA;
$concepto	=$_CONCEPTO;
$_POSP = 3;
$_bot = 6;

$query_plantilla="select * from informe_plantilla where id_plantilla='$plantilla'";
$result_planilla=pg_exec($conn,$query_plantilla);
$num_planilla=pg_numrows($result_planilla);

if ($num_planilla>0){
	$row_planilla=pg_fetch_array($result_planilla);
}

if ($submit){
	$concepto=$_POST[concepto];
//	imprime_array($concepto);
	$largo=count($id_item);
	for ($i=0;$i<$largo;$i++){
		$query_update ="update informe_area_item set con_concepto='$concepto[$i]' where id='$id_item[$i]'";
		//echo "$query_update<br>";
		$result_update=pg_exec($conn,$query_update);
		
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
table {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
body{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
input{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
text{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
.a_eliminar {
	color: #FFFFFF;
	background-color: #990000;
}
.normal{
	color: #000000;
	background-color: #FFFFFF;
}

-->
</style>
</head>

<body>
<a href="preview.php" target="_blank">preview</a>
<form method="post" >
<? $cont_radio=0;?>
<table border="1">	
<? 	$query_cat="select * from informe_area_item where id_plantilla='$plantilla' and id_padre=0";
	$result_cat=pg_exec($conn,$query_cat);
	$num_cat=pg_numrows($result_cat);
	?>
	<tr><td rowspan="2" valign="bottom">glosa-nombre</td><td colspan="2">concepto Evaluativo</td></tr>
	<tr><td>con </td><td>sin</td></tr>
<? for ($i=0;$i<$num_cat;$i++){
	$row_cat=pg_fetch_array($result_cat);
?>
	<tr><td><? echo $row_cat['glosa'];?></td><td>&nbsp;</td><td>&nbsp;</td></tr>
		<? 	$query_sub="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_cat[id]";
			$result_sub=pg_exec($conn,$query_sub);
			$num_sub=pg_numrows($result_sub);?>
			<? for ($j=0;$j<$num_sub;$j++){
				$row_sub=pg_fetch_array($result_sub);
			?>
			<tr><td><img src="../../../cortes/p.gif" width="10" height="1" border="0"><? echo $row_sub['glosa'];?>
			</td>
				<? 	
					$query_total="select count(*) as total from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id]";
					$result_total=pg_exec($conn,$query_total);
					$row_total=pg_fetch_array($result_total);
					
					?>
				<? if ($row_total[total]==0){?>
				<td><input name="id_item[<? echo $cont_radio;?>]" value="<? echo $row_sub[id];?>" type="hidden">
					<input  name="concepto[<? echo $cont_radio;?>]" type="radio" value="1" checked>
				</td>
				<td><input type="radio"  name="concepto[<? echo $cont_radio;?>]" value="0"></td>
				<? $cont_radio++;?>
				<? }else{?>
				<td>&nbsp;</td><td>&nbsp;</td>
				<? }?>
				</tr>
			
				<? 	 $query_item="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id]";
					$result_item=pg_exec($conn,$query_item);
					$num_item=pg_numrows($result_item);?>
					<? for ($z=0;$z<$num_item;$z++){
						$row_item=pg_fetch_array($result_item);
					?>
						<tr><td><img src="../../../cortes/p.gif" width="20" height="1" border="0"><? echo $row_item['glosa'];?></td>
										<td><input name="id_item[<? echo $cont_radio;?>]" value="<? echo $row_item[id];?>" type="hidden">
										<input  name="concepto[<? echo $cont_radio;?>]" type="radio" value="1" checked></td><td><input type="radio"  name="concepto[<? echo $cont_radio;?>]" value="0"></td>
										<? $cont_radio++;?>
						</tr>
					<? }?>
			<? }?>
			
	
<? }?>
<tr>
	<td colspan="3" align="center"> <input name="submit" type="submit" value="Guardar"></td>
</tr>

</table>
</form>
</body>
</html>
