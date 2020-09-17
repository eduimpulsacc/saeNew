<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="../planilla/grabaAreas.php" method="post">
<?php 
	for ($cant==0 ; $cant<$txtCant ; $cant++){
			$obj = "<td width=47%>";
			$obj = $obj."<font size=2 face=Arial, Helvetica, sans-serif>Nombre: ";
			$obj = $obj."<input name=txtNombreAr".$cant." type=text size=30 maxlength=100>";
			$obj = $obj."</font></td>";
			$obj = $obj."<td width=25% valign=middle>";
			$obj = $obj."<label>";
			$obj = $obj."<input type=radio name=RadioGroup".$cant." value=1>&nbsp;";
			$obj = $obj."<font size=1 face=Arial, Helvetica, sans-serif>con Concepto Evaluativo</font></label>";
			$obj = $obj."</td>";
			$obj = $obj."<td width=28% valign=middle>";
			$obj = $obj."<input type=radio name=RadioGroup".$cant." value=0>";
			$obj = $obj."<font size=1 face=Arial, Helvetica, sans-serif>sin Concepto Evaluativo</font>";
			$obj = $obj."</td><br><br>";
			echo $obj;
			

	}
	
	if($cant!=0){
		echo "<input type='submit' name='enviar' value='Grabar Areas' onclick='window.location=grabarAreas.php?cant=".$cant.";'>";
	}else{
		echo "<script>window.location='area.php'</script>";
	}
?>
</form>
</body>
</html>