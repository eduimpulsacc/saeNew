<?php require('../../../../util/header.inc');
$plantilla	=$_PLANTILLA;
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form action="procesoConcepto.php" method="post">
<?php 
if($creada!=1){
	for ($canti=0 ; $canti<$txtCant ; $canti++){
			$obj = "<td width=47%>";
			$obj = $obj."<font size=2 face=Arial, Helvetica, sans-serif>Nombre: ";
			$obj = $obj."<input name=txtNombreConc[".$canti."] type=text size=30 maxlength=100>&nbsp;&nbsp;&nbsp;&nbsp;";
			$obj = $obj."</font></td>";
			$obj = $obj."<td>";
			$obj = $obj."<font size=2 face=Arial, Helvetica, sans-serif>Sigla: ";
			$obj = $obj."<input name=txtSiglaConc[".$canti."] type=text size=3 maxlength=5>";
			$obj = $obj."</font></td>";			
			$obj = $obj."</td><br><br>";
			echo $obj;
			

	}
	
	echo "<input type='hidden' name='canti' value='".$canti."'>";

	
	if($canti!=0){
		echo "<td>";
		//echo "<input type='submit' name='enviar' value='Grabar Conceptos' onclick='window.location=\"procesoConcepto.php?canti=".$canti."\";'>";
		echo "<input type='submit' name='enviar' value='Grabar Conceptos'>";
		echo "</td>";
		echo "<td>";
		echo "&nbsp;&nbsp;<input type='button' name='enviar' value='Atras' onclick='window.location=\"concepto.php\";'>";
		echo "</td>";
		
	}else{
		echo "<script>window.location='concepto.php'</script>";
	}
}

if($creada==1){

	$sqlTraeConceptos="SELECT * FROM informe_concepto_eval WHERE id_plantilla=".$plantilla;
			$resultTraeConceptos=pg_Exec($conn, $sqlTraeConceptos);
			if (!$resultTraeConceptos)
						error('<b> ERROR :</b>Error al acceder a la BD. (2)'.$sqlTraeConceptos);
					else{
						echo "<td><font size=2 face=Arial, Helvetica, sans-serif>Conceptos Creados</font></td><br><br>";
						for($count=0 ; $count<pg_numrows($resultTraeConceptos) ; $count++){
							$filaConceptos=pg_fetch_array($resultTraeConceptos, $count);
							echo "<tr>";
							echo "<td>";
							echo "<font size=2 face=Arial, Helvetica, sans-serif>Nombre:";
							echo "&nbsp;&nbsp;";
							echo $filaConceptos['nombre'];
							echo "</td>";
							echo "<td>";
							echo "<font size=2 face=Arial, Helvetica, sans-serif>Sigla:";
							echo "&nbsp;&nbsp;";
							echo $filaConceptos['sigla'];
							echo "</td>";
							echo "</tr><br>";
						}//
					}//fin else
		
							echo "<br><br><font size=2 face=Arial, Helvetica, sans-serif><STRONG>";
							echo "Estos datos han sido grabados Presione \"SIGUIENTE\" para continuar.";
							echo "</strong></font>";

}
?>
</form>
</body>
</html>