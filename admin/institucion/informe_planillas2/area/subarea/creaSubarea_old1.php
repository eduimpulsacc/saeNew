<?php require('../../../../../util/header.inc');
	$plantilla	=$_PLANTILLA;
/*if($plantilla==""){
	if($_PLANTILLA!="") {
		$plantilla	=$_PLANTILLA;
	
	}
}*/
echo $plantilla;

if ($option==2){
	$creada=1;
}
?>

<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="../../../planilla_planillas2/area/subarea/procesoSubarea.php" method="post">
<!-- <input name="plantilla" type="text" value="<?php //echo $plantilla?>"> -->
<?php 
if($creada!=1){
	$sqlTraeAreas="SELECT * FROM informe_area where id_plantilla=".$plantilla." AND con_subarea=1";
	$resultTraeArea=pg_Exec($conn, $sqlTraeAreas);
	
	for ($cant=0 ; $cant<$txtCant ; $cant++){
			$obj = "<td width=47%>";
			$obj = $obj."<font size=2 face=Arial, Helvetica, sans-serif>Nombre Subarea: ";
			$obj = $obj."<input name=\"txtNombreSubar[".$cant."]\" type=text size=30 maxlength=100>";
			$obj = $obj."</font></td>";
			$obj = $obj."<td width=25% valign=middle>";
			$obj = $obj."<label>";
						//crea el select con las areas a que se asigna la subarea
			$obj = $obj."<select name=\"cmbArea[".$cant."]\">";
			$obj = $obj."<option value=0>SELECCIONE AREA</option>";
						for($countAr=0 ; $countAr<pg_numrows($resultTraeArea) ; $countAr++ ){
							$filaArea=pg_fetch_array($resultTraeArea,$countAr);
			$obj = $obj."<option value=".$filaArea['id_area'].">".$filaArea['nombre']."</option>";
						}//fin for ($countAr=0......
			$obj = $obj."</select></label>";
			$obj = $obj."</td><br>";
			echo $obj;
			

	}
	
	echo "<input type='hidden' name='cant' value='".$cant."'>";
	
	if($cant!=0){
		echo "<td>";
		//echo "<input type='submit' name='enviar' value='Grabar Areas' onclick='window.location=procesoArea.php?cant=".$cant.";'>";
		echo "<input type='submit' class=botonZ onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name='enviar' value='GRABAR SUBAREAS'>";
		echo "</td>";
		echo "<td>";
		echo "&nbsp;&nbsp;<input type='button' class=botonX onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name='atras' value='VOLVER' onclick='window.location=\"subarea.php\";'>";
		echo "</td>";

	}else {
		echo "<script>window.location='subarea.php'</script>";
	}
}
	//Despues de crear areas las muestro
	if($creada==1){
						echo "<font size=2 face=Arial, Helvetica, sans-serif><STRONG>";
						echo "Estos datos han sido grabados, para crear los itemes de cada Area o Subarea pinche sobre el nombre.";
						echo "</strong></font><br><br>";
		//$sqlTraeAreas="SELECT * FROM informe_subarea WHERE id_plantilla=".$plantilla;
		$sqlTraeSubareas="select informe_subarea.nombre, informe_subarea.id_subarea from informe_subarea inner join informe_area on informe_subarea.id_area=informe_area.id_area where informe_area.id_plantilla=".$plantilla;
		$resultTraeSubareas=pg_Exec($conn, $sqlTraeSubareas);
		if (!$resultTraeSubareas)
					error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$sqlTraeSubareas);
				else{
					echo "<td><font size=2 face=Arial, Helvetica, sans-serif>Subareas Creadas</font></td><br><br>";
					for($count=0 ; $count<pg_numrows($resultTraeSubareas) ; $count++){
						$filaSubareas=pg_fetch_array($resultTraeSubareas, $count);
						echo "<tr>";
						echo "<td>";
						echo "<font size=2 face=Arial, Helvetica, sans-serif>Subarea:";
						echo "&nbsp;&nbsp;";
						echo "<a href='#' onclick=\"parent.frames['iframeItem'].location.href='item/item.php?subarea=".$filaSubareas['id_subarea']."';\">";
						//echo "<a href=\"item/item.php?".$filaSubareas['id_subarea']." \" target=\"href.location.iframeItem\">";
						echo $filaSubareas['nombre'];
						echo "</a>";
						echo "</td>";
						echo "</tr><br>";
					}//
				}//fin else
	
						
	}//fin ($creada==1){
			
			
?>
</form>

</body>
</html>