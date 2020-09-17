<?php require('../../../../util/header.inc');

echo $plantilla	=$_PLANTILLA;
$area		=$_AREA;
$concepto	=$_CONCEPTO;
$_POSP = 4;
$_bot = 7;
//exit;

if ($guardar){
	$largo=count($nombre);
	for ($i=0;$i<$largo;$i++){
		if ($nombre[$i]!=""){
			$sqlConcepto="INSERT INTO informe_concepto_eval (id_plantilla, nombre, sigla, glosa, fecha_creacion) VALUES($plantilla, '$nombre[$i]', '$sigla[$i]', '$glosa[$i]',now ())";
			$sqlConcepto."<br>";
			$resultConcepto=pg_Exec($conn, $sqlConcepto);
		}
	}
header ("Location: conceptos.php?ver=1");
exit();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<script>
function insRow(tabla)
{
	largo=document.getElementById(tabla).rows.length;
	var x=document.getElementById(tabla).insertRow(largo);
	var y=x.insertCell(0);
	var w=x.insertCell(1);
	var z=x.insertCell(2);
	//y.id="td"+j;
	y.innerHTML="<input name=nombre[] type=text>";
	w.innerHTML="<input name=sigla[] type=text>";
	z.innerHTML="<input name=glosa[] type=text>";
}
function delRow(tabla)
{
	largo=document.getElementById(tabla).rows.length;
	largo=largo-1
	var x=document.getElementById(tabla).deleteRow(largo);
	
}
</script>
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
-->
</style>
<link href="../../../../estilos.css"rel="stylesheet" type="text/css"> 
</head>

<body>
<? if ($plantilla){?>
<? if (!$ver){?>
<a href="javascript:;" onClick="insRow('mytable')">agrega</a>
<a href="javascript:;" onClick="delRow('mytable')">Eliminar</a>
<table >
<form>
	<tr><td width="33%">Nombre</td><td width="33%">Sigla</td><td width="33%">Glosa</td></tr>
	<tr>
		<td colspan="3"><table id="mytable"></table></td>
	</tr>
	<tr><td colspan="3"><input name="guardar" type="submit" class="botonXX" value="Guardar"></td></tr>
</form>
</table>
<? }?>
<? if ($ver){?>
	<table>
		<tr><td width="33%">Nombre</td><td width="33%">Sigla</td><td width="33%">Glosa</td></tr>
		<? 
			$query_todos="SELECT * FROM informe_concepto_eval where id_plantilla='$plantilla'";
			$result_todos=pg_exec($conn,$query_todos);
			$num_todos=pg_numrows($result_todos);
			?>
		<? for ($i=0;$i<$num_todos;$i++){
			$row_todos=pg_fetch_array ($result_todos);?>
			<tr>
				<td><? echo $row_todos['nombre'];?></td>
				<td><? echo $row_todos['sigla'];?></td>
				<td><? echo $row_todos['glosa'];?></td>
			</tr>
		<? }?>
		<form action="../informe_1.php" <? //target="_top"?>  target="_blank">
		<tr><td colspan="2"><input name="aa" type="submit" value="Siguiente"></td></tr>
		</form>
	</table>
<? }?>
<? }?>
<? if (!$plantilla){?>
	ingrese los datos en el paso uno
<? }?>
</body>
</html>
