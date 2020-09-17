<?php
if($_POST["submit"]) {
$numPar=0;
$parametros="";
foreach ($_POST as $key => $value){
	$numPar++;
	$parametros.="s:".(strlen($key)+1).":\"\$".$key."\";s:".strlen($value).":\"".$value."\";";
}
?>
<body onload="formulario.submit()">
<form name=formulario method=post action="http://200.2.201.33/reportes/agata/web/generate.php">
<input type=hidden name=Parameters value='a:<?=$numPar?>:{<?=$parametros?>}'>
<input type=hidden name=mimetype value="<?=$_POST["mimetype"]?>">
<?if($_POST["mimetype"]=="pdf") {?>
<input type=hidden name=layout value='default-PDF'>
<?}else{?>
<input type=hidden name=layout value='default-HTML'>
<?}}else{?>

<form name=formulario method=post action="form.php">






ID Curso: <input type="text" name="idcurso"><br>
<select name="mimetype">
<option value="txt">txt</option>
<option value="html" selected>html</option>
<option value="pdf">pdf</option>
<option value="csv">csv</option>
</select>

<br>

<input type="submit" name="submit" value="generar reporte">

<?}?>

<p>

<input type=hidden name=file value=/opt/www/coeint/reportes/agata/reports/colegio.agt>
<input type=hidden name=type value='report'>
<input type=hidden name=lang value=en>
<input type=hidden name=connection value=colegio>


</form>

