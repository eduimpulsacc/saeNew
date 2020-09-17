<?php require('../../../../../../util/header.inc');
	$plantilla	=$_PLANTILLA;
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="../../../../planilla_planillas2/area/subarea/item/procesoItem.php" method="post">
<input type="hidden" name="subarea" value="<?php echo $subarea; ?>">

<?php 

	$sqlTraeSubarea="select * from informe_subarea where id_subarea=".$subarea;
	$returnTraeSubarea=@pg_Exec($conn, $sqlTraeSubarea);
		if (!$returnTraeSubarea) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlTraeSubarea);
		}
	$filaTraeSubarea=@pg_fetch_array($returnTraeSubarea,0);

if($creada!=1){
	$sqlConConcepto="select con_concepto from informe_area where id_area=".$area;
	$resultConConcepto=@pg_Exec($conn, $sqlConConcepto);
		if (!$resultConConcepto) {
			error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$sqlConConcepto);
		}

	$filaConConcepto=@pg_fetch_array($resultConConcepto,0);
	$con_concepto=$filaConConcepto['con_concepto'];
}//fin if($creada!=1)
	
	
if(($creada!=1) and ($con_concepto==1)){//ITEM es con concepto evaluativo
	for ($cant=0 ; $cant<$txtCant ; $cant++){
			$obj = "<td width=47%>";
			$obj = $obj."<font size=2 face=Arial, Helvetica, sans-serif>Nombre: ";
			$obj = $obj."<input name=\"txtNombreItem[".$cant."]\" type=text size=30 maxlength=100>";
			$obj = $obj."</font></td>";
			$obj = $obj."<td width=25% valign=middle>";
			$obj = $obj."<label>";
			$obj = $obj."<input type=hidden name=con_concepto value=0>";
			$obj = $obj."</td><br><br>";
			echo $obj;
	}
	
		echo "<input type='hidden' name='cant' value='".$cant."'>";
	
		if($cant!=0){
			echo "<td>";
			//echo "<input type='submit' name='enviar' value='Grabar Areas' onclick='window.location=procesoArea.php?cant=".$cant.";'>";
			echo "<input type='submit' class=botonZ onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name='enviar' value='GRABAR ITEMES'>";
			echo "</td>";
			echo "<td>";
			echo "&nbsp;&nbsp;<input type='button' class=botonX onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name='atras' value='VOLVER' onclick='window.location=\"area.php\";'>";
			echo "</td>";
	
		}else {
			echo "<script>window.location='blanco.htm'</script>";
		}// fin if($cant!=0){

	
	//echo "<input type='hidden' name='cant' value='".$cant."'>";
	
}else if(($creada!=1) and ($con_concepto==0 )){
	for ($cant=0 ; $cant<$txtCant ; $cant++){
			$obj = "<td width=47%>";
			$obj = $obj."<font size=2 face=Arial, Helvetica, sans-serif>Nombre: ";
			$obj = $obj."<input name=\"txtNombreItem[".$cant."]\" type=text size=30 maxlength=100>";
			$obj = $obj."</font></td>&nbsp;&nbsp;";
			$obj = $obj."<td width=28% valign=middle>";
			$obj = $obj."<font size=1 face=Arial, Helvetica, sans-serif>Respuesta en:</font>";
			$obj = $obj."</td>&nbsp;&nbsp;";
			$obj = $obj."<td width=25% valign=middle>";
			$obj = $obj."<label>";
			$obj = $obj."<input type=radio name=\"con_concepto[".$cant."]\" value=2>";//CUADRO DE TEXTO
			$obj = $obj."<font size=1 face=Arial, Helvetica, sans-serif>Cuadro de texto</font></label>";
			$obj = $obj."</td>&nbsp;&nbsp;";
			$obj = $obj."<td width=28% valign=middle>";
			$obj = $obj."<input type=radio name=\"con_concepto[".$cant."]\" value=1>";//SI/NO
			$obj = $obj."<font size=1 face=Arial, Helvetica, sans-serif>alternativa SI/NO</font>";
			$obj = $obj."</td><br><br>";
			echo $obj;
	}//fin for

	echo "<input type='hidden' name='cant' value='".$cant."'>";
	
		if($cant!=0){
			echo "<td>";
			//echo "<input type='submit' name='enviar' value='Grabar Areas' onclick='window.location=procesoArea.php?cant=".$cant.";'>";
			echo "<input type='submit' name='enviar' value='Grabar Areas'>";
			echo "</td>";
			echo "<td>";
			echo "&nbsp;&nbsp;<input type='button' name='atras' value='Atras' onclick='window.location=\"area.php\";'>";
			echo "</td>";
	
		}else {
			echo "<script>window.location='item.php'</script>";
		}// fin if($cant!=0){


}

	//Despues de crear areas las muestro
	if($creada==1){
		$sqlTraeAreas="SELECT * FROM informe_item WHERE id_subarea=".$subarea;
		$resultTraeAreas=pg_Exec($conn, $sqlTraeAreas);
		if (!$resultTraeAreas)
					error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$sqlTraeAreas);
				else{
					echo "<td><font size=2 face=Arial, Helvetica, sans-serif>Itemes Creados para la Subarea ".$filaTraeSubarea['nombre']."</font></td><br><br>";
					for($count=0 ; $count<pg_numrows($resultTraeAreas) ; $count++){
						$filaAreas=pg_fetch_array($resultTraeAreas, $count);
						echo "<tr>";
						echo "<td>";
						echo "<font size=2 face=Arial, Helvetica, sans-serif>Area:";
						echo "&nbsp;&nbsp;";
						echo $filaAreas['glosa'];
						echo "</td>";
						echo "</tr><br>";
					}//
				}//fin else
	
						echo "<br><br><font size=2 face=Arial, Helvetica, sans-serif><STRONG>";
						echo "Itemes creados";
						echo "</strong></font>";
	}//fin ($creada==1){
			
			
?>
</form>
</body>
</html>