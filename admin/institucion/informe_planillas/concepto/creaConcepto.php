<?php require('../../../../util/header.inc');
$plantilla	=$_PLANTILLA;
if ($option==2){
	$creada=1;
}

?>
<script>
function Modifica(form){
		form.target='_parent';
		form.action='../plantilla/plantilla.php';
		form.submit(true);
}
</script>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="procesoConcepto.php" method="post">
<?php 
if($creada!=1){
	for ($canti=0 ; $canti<$txtCant ; $canti++){
			$obj = "<td width=47%>";
			$obj = $obj."<font size=2 face=Arial, Helvetica, sans-serif>Nombre: ";
			$obj = $obj."<input name=txtNombreConc[".$canti."] type=text size=20 maxlength=100>&nbsp;&nbsp;";
			$obj = $obj."</font></td>";
			
			$obj = $obj."<td>";
			$obj = $obj."<font size=2 face=Arial, Helvetica, sans-serif>Sigla: ";
			$obj = $obj."<input name=txtSigla[".$canti."] type=text size=4 maxlength=3>&nbsp;&nbsp;";
			$obj = $obj."</font></td>";
			
			$obj = $obj."<td>";
			$obj = $obj."<font size=2 face=Arial, Helvetica, sans-serif>Glosa: ";
			$obj = $obj."<input name=txtGlosaConc[".$canti."] type=text size=30 maxlength=200>";
			$obj = $obj."</font></td>";			
			$obj = $obj."</td><br><br>";
			echo $obj;
			

	}
	
	echo "<input type='hidden' name='canti' value='".$canti."'>";

	
	if($canti!=0){
		echo "<td>";
		//echo "<input type='submit' name='enviar' value='Grabar Conceptos' onclick='window.location=\"procesoConcepto.php?canti=".$canti."\";'>";
		echo "<input type='submit' class=botonZ onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name='enviar' value='GRABAR CONCEPTOS'>";
		echo "</td>";
		echo "<td>";
		echo "&nbsp;&nbsp;<input type='button' class=botonX onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name='enviar' value='VOLVER' onclick='window.location=\"concepto.php\";'>";
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
							echo "<font size=2 face=Arial, Helvetica, sans-serif>Glosa:";
							echo "&nbsp;&nbsp;";
							echo $filaConceptos['glosa'];
							echo "</td>";
							echo "</tr><br>";
						}//
					}//fin else
		
							echo "<br><br><font size=2 face=Arial, Helvetica, sans-serif><STRONG>";
							echo "Estos datos han sido grabados Presione \"SIGUIENTE\" para continuar.";
							echo "</strong></font>";
					
					echo $_CONCEPTO=$filaConceptos['id_concepto'];
					//registra el id de la ultima area en la session, la q recien se grabó
					/*if(!session_is_registered('_CONCEPTO')){
							session_register('_CONCEPTO');
					};*/
			
					//echo "<script>parent.window.location='../plantilla/plantilla.php'<--!/script-->";
}
?>
</form>
</body>
</html>