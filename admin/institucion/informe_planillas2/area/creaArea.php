<?php require('../../../../util/header.inc');
	$plantilla	=$_PLANTILLA;
if ($option==2){
	$creada=1;
}
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="../../planilla_planillas2/area/procesoArea.php" method="post">
<?php 

if($creada!=1){
	for ($cant=0 ; $cant<$txtCant ; $cant++){
			$obj = "<td width=47%>";
			$obj = $obj."<font size=2 face=Arial, Helvetica, sans-serif>Nombre: ";
			$obj = $obj."<input name=\"txtNombreAr[".$cant."]\" type=text size=30 maxlength=100>";
			$obj = $obj."</font></td>";
			$obj = $obj."<td width=25% valign=middle>";
			$obj = $obj."<label><br>";
			$obj = $obj."<input type=radio name=\"concepto[".$cant."]\" value=1>";
			$obj = $obj."<font size=1 face=Arial, Helvetica, sans-serif>con Concepto Evaluativo</font></label>";
			$obj = $obj."</td>&nbsp;&nbsp;";
			$obj = $obj."<td width=28% valign=middle>";
			$obj = $obj."<input type=radio name=\"concepto[".$cant."]\" value=0>";
			$obj = $obj."<font size=1 face=Arial, Helvetica, sans-serif>sin Concepto Evaluativo</font>";
			$obj = $obj."<br>";
			$obj = $obj."<input type=radio name=\"subArea[".$cant."]\" value=1>";
			$obj = $obj."<font size=1 face=Arial, Helvetica, sans-serif>con Subareas</font></label>";
			$obj = $obj."</td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$obj = $obj."<td width=28% valign=middle>";
			$obj = $obj."<input type=radio name=\"subArea[".$cant."]\" value=0>";
			$obj = $obj."<font size=1 face=Arial, Helvetica, sans-serif>sin Subareas</font>";

			$obj = $obj."</td><br><br>";
			echo $obj;
			

	}
	
	echo "<input type='hidden' name='cant' value='".$cant."'>";
	
	if($cant!=0){
		echo "<td>";
		//echo "<input type='submit' name='enviar' value='Grabar Areas' onclick='window.location=procesoArea.php?cant=".$cant.";'>";
		echo "<input type='submit' class=botonZ onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name='enviar' value='GRABAR AREAS'>";
		echo "</td>";
		echo "<td>";
		echo "&nbsp;&nbsp;<input type='button' class=botonXX  name='atras' value='VOLVER' onclick='window.location=\"area.php\";'>";
		echo "</td>";

	}else {
		echo "<script>window.location='area.php'</script>";
	}
}
	//Despues de crear areas las muestro
	if($creada==1){
		$sqlTraeAreas="SELECT * FROM informe_area WHERE id_plantilla=".$plantilla;
		$resultTraeAreas=pg_Exec($conn, $sqlTraeAreas);
		if (!$resultTraeAreas)
					error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$sqlTraeAreas);
					//exit;
				else{
					echo "<td><font size=2 face=Arial, Helvetica, sans-serif>Areas Creadas</font></td><br><br>";
					for($count=0 ; $count<pg_numrows($resultTraeAreas) ; $count++){
						$filaAreas=pg_fetch_array($resultTraeAreas, $count);
						echo "<tr>";
						echo "<td>";
						echo "<font size=2 face=Arial, Helvetica, sans-serif>Area:";
						echo "&nbsp;&nbsp;";
						echo $filaAreas['nombre'];
						echo "</td>";
						echo "</tr><br>";
					}//
					//trae el id de la ultima area para registrarlo en la session
					$sqlTraeId="select max (id_area) as id_area from informe_area where id_plantilla=".$plantilla;
					$resultTraeId=pg_Exec($conn, $sqlTraeId);
					if (!$resultTraeId)
						error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$sqlTraeId);
						//exit;
					else{
						$filaTraeId=pg_fetch_array($resultTraeId,0);
						//echo $_AREA=$filaTraeId['id_area'];
				
					//registra el id de la ultima area en la session, la q recien se grabó
					if(!session_is_registered('_AREA')){
							session_register('_AREA');
					};
				}//fin if (!$resultTraeId)
				}//fin else
	
						echo "<br><br><font size=2 face=Arial, Helvetica, sans-serif><STRONG>";
						echo "Estos datos han sido grabados siga con el paso Nro. 3";
						echo "</strong></font>";
	}//fin ($creada==1){
			
			
?>
</form>
</body>
</html>