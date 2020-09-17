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
	imprime_array($row_planilla);
}
?>
<? if ($submit){

	$largo_cat=count($cat);
	for ($i=0;$i<$largo_cat;$i++){
		//echo $cat[$i]."<br>";
		$query_ins_cat="INSERT INTO informe_area_item (id_plantilla, id_padre, glosa) VALUES($plantilla, 0, '$cat[$i]')";
		$result=pg_exec($conn,$query_ins_cat);
		$query_ultima_cat="select max(id) as ultimo from  informe_area_item where id_plantilla='$plantilla' and id_padre='0'";
		$row_ultima_cat=pg_fetch_array(pg_exec($conn,$query_ultima_cat));
		$ultima_cat=$row_ultima_cat[ultimo];
		//echo "la ultima categoria es $ultima_cat <br>";
		$largo_sub=count($id_sub);
		for ($j=0;$j<$largo_sub;$j++){
			if ($i==$id_cat[$j]){
				//echo "---".$sub[$j]."<br>";
					$query_ins_sub="INSERT INTO informe_area_item (id_plantilla, id_padre, glosa) VALUES($plantilla, '$ultima_cat', '$sub[$j]')";
					$result=pg_exec($conn,$query_ins_sub);
					//echo $query_ins_sub."<br>";

				$query_ultima_sub="select max(id) as ultimo from  informe_area_item where id_plantilla='$plantilla' and id_padre<>'0'";					
				$row_ultima_sub=pg_fetch_array(pg_exec($conn,$query_ultima_sub));
				$ultima_sub=$row_ultima_sub[ultimo];
				//echo "la ultima sub- categoria es $ultima_sub<br>";

					
				$largo_items=count($items);	
				for ($z=0;$z<$largo_items;$z++){
				//echo "($id_cat1[$z]---$id_sub1[$z])($i---$id_sub[$j])-->$items[$z].<br>";
					if (($id_sub1[$z]==$j)&&($id_cat1[$z]==$i)){
					//echo "------".$items[$z]."<br>";
					$query_ins_item="INSERT INTO informe_area_item (id_plantilla, id_padre, glosa) VALUES($plantilla, '$ultima_sub', '$items[$z]')";
					$result=pg_exec($conn,$query_ins_item);
					//echo $query_ins_sub."<br>";

	
					//."($id_cat1[$z]---$id_sub1[$z])($i---$j])</font><br>";
					}
				}
			}
		}
	}
header ("Location : informe_2.php");
exit();
}?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Documento sin t&iacute;tulo</title>
<script>
contador_sub=-1;
function nuevoItem(cat,pos_cat,id_sub_local,pos_sub)
{	
	largo=document.getElementById(cat).rows.length;
	var x=document.getElementById(cat).insertRow(largo);
	var y=x.insertCell(0);
	y.className="td2";
	label=pos_cat+1;
	pos_sub2=pos_sub-1;
	temp=largo+1; 		
	label=label+"."+pos_sub+"."+temp;
	y.innerHTML=label+" <input name=\"items[]\" size=130 value=\""+label+"\"> <input name=\"id_sub1[]\"  type=hidden  value=\""+id_sub_local+"\"><input name=\"id_cat1[]\" value=\""+pos_cat+"\"  type=hidden >";

}

function nuevaSub(cat,pos)
{	
	vhs=cat+"-----"+pos;
	alert (cat);
	largo=document.getElementById(cat).rows.length;
	var x=document.getElementById(cat).insertRow(largo);
	var y=x.insertCell(0);
	y.className="td2";
	temp=largo+1
	nombre_items="items"+pos+"_"+temp;
	temp=largo+1;
	label=pos+1;
	label=label+"."+temp;
	contador_sub=contador_sub+1;
	y.innerHTML=label+" <input name=\"sub[]\" size=125 value=\""+label+"\"><input name=\"id_cat[]\" type=hidden value=\""+pos+"\"><input name=\"id_sub[]\" type=hidden  value=\""+contador_sub+"\"><a href=\"javascript:;\" onclick=\"nuevoItem('"+nombre_items+"',"+pos+","+contador_sub+","+temp+");\">agregar items</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:;\" onclick=\"eliminaItems('"+nombre_items+"');\">Eliminar items</a><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<table id=\""+nombre_items+"\" ></table>";
}

function nuevaCategoria()
{
	largo=document.getElementById('tabla_categoria').rows.length;
	var x=document.getElementById('tabla_categoria').insertRow(largo);
	j=largo;
	var y=x.insertCell(0);
	y.className="td2";
	y.id="td"+j;
	nombre_sub="sub_informe"+j;
	j=j+1;
	anterior=j-1;	
	y.innerHTML="<table ><tr><td colspan=2>Categoria "+j+"<input name=\"cat[]\" size=150 value=\"categoria "+j+"\"><a href=\"javascript:;\" onclick=\"nuevaSub('"+nombre_sub+"',"+anterior+");\">nueva Subcategoria</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:;\" onclick=\"eliminaSub('"+nombre_sub+"')\">Elimina Subcategoria</a></td></tr><tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td><table id=\""+nombre_sub+"\" cellpadding=\"0\" cellspacing=\"0\"></table></td></tr></table>";
}

function eliminaCategoria(){
largo=document.getElementById('tabla_categoria').rows.length;

	if (largo>0){
		largo=largo-1;
		document.getElementById('tabla_categoria').rows[largo].className="a_eliminar";
		a=confirm ('se Eliminara toda la zona con color ROJO, \r\nesta seguro');
			if (a==true){
				var x=document.getElementById('tabla_categoria').deleteRow(largo);
			}else{
				document.getElementById('tabla_categoria').rows[largo].className="normal";
			}

	}
}

function eliminaSub(subcate){
largo=document.getElementById(subcate).rows.length;

	if (largo>0){
		largo=largo-1;
		document.getElementById(subcate).rows[largo].className="a_eliminar";
		a=confirm ('se Eliminara toda la zona con color ROJO, \r\nesta seguro');
			if (a==true){
				var x=document.getElementById(subcate).deleteRow(largo);
			}else{
				document.getElementById(subcate).rows[largo].className="normal";
			}
		}
}

function eliminaItems(subcate){
largo=document.getElementById(subcate).rows.length;

	if (largo>0){
		largo=largo-1;
		document.getElementById(subcate).rows[largo].className="a_eliminar";
//		alert ("hola");
		a=confirm ('se Eliminara toda la zona con color ROJO, \r\nesta seguro');
		if (a==true){
			var x=document.getElementById(subcate).deleteRow(largo);
		}else{
			document.getElementById(subcate).rows[largo].className="normal";
		}
	}
}

</script>
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
<!--<table><tr><td>cat<? imprime_array($cat);?></td></tr></table>
<table><tr><td>id_cat<? imprime_array($id_cat);?></td><td>id_sub<? imprime_array($id_cat);?></td><td>sub<? imprime_array($sub);?></td></tr></table>
<table><tr><td>id_Cat1<? imprime_array($id_cat1);?></td><td>id_sub1<? imprime_array($id_sub1);?></td><td>items<? imprime_array($items);?></td></tr></table>
-->


<h1><? echo $row_planilla['nombre'];?></h1>
<form method="post" target="_blank" name="form"	>
<table cellpadding="0" cellspacing="3">
  <tr><td>
<a href="javascript:;" onClick="nuevaCategoria();">Agregar categoria</a>
</td>

<td><a href="javascript:;" onClick="eliminaCategoria();">Elimina Categoria</a></td>
</tr></table>
<table id="tabla_categoria">

</table>
<table cellpadding="0" cellspacing="3">
  <tr><td>
<a href="javascript:;" onClick="nuevaCategoria();">Agregar categoria</a>
</td>

<td><a href="javascript:;" onClick="eliminaCategoria();">Elimina Categoria</a></td>
</tr></table>
<input  type="submit" name="submit">
</form>
</body>
</html>
