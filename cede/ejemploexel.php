<?
	 require("exel.php");
	$excel=new ExcelWriter("excel/FicheroExcel2.xls");
    
	if($excel==false) {   
	 echo $excel->error;
	}

	// PRIMERA FORMA DE ESCRITURA DE FILAS
	$myArr=array("CeldaA1","CeldaB1","CeldaC1","CeldaD1");
	$excel->writeLine($myArr);

	$myArr=array("CeldaA2","CeldaB2","CeldaC2","CeldaD2");
	$excel->writeLine($myArr);

	//SEGUNDA FORMA DE ESCRITURA DE FILAS
	$excel->writeRow();
	$excel->writeCol("CeldaA3");
	$excel->writeCol("CeldaB3");
	$excel->writeCol("CeldaC3");
	$excel->writeCol("CeldaD3");
	
	$excel->writeRow();
	$excel->writeCol("CeldaA4");
	$excel->writeCol("CeldaB4");
	$excel->writeCol("CeldaC4");
	$excel->writeCol("CeldaD4");

	$excel->close();
	//echo "Los datos se han grabado con &eacute;xito.";

	include("includes/excelwriter.inc.php");
 
	$excel=new ExcelWriter("galeria_comercial.xls");
 
	if($excel==false) {
	echo $excel->error;
	}
 
	//Escribimos la primera fila con las cabeceras
	$myArr=array("Nombre Comercial","Direccion","CP","Localidad","Telefono","Email");
	$excel->writeLine($myArr);
 
	//REALIZAMOS LA CONSULTA
	$dbhost = "localhost";
	$dbuser = "usuario";
	$dbpassword = "password";
	$dbname = "base_de_datos";
 
	$db2 = mysql_connect($dbhost, $dbuser, $dbpassword) or die("Connection Error: " . mysql_error());
	mysql_select_db($dbname) or die("Error al conectar a la base de datos.");
	$sql2 = "SELECT * FROM ComerciosGaleria";
	$sql2 .= " ORDER BY NombreComercial ASC ";
	$result2 = mysql_query( $sql2) or die("No se puede ejecutar la consulta: ".mysql_error());
 
	//Escribimos todos los registros de la base de datos
	//en el fichero EXCEL
	while($Rs2 = mysql_fetch_array($result2)) {
	$myArr=array(
	$Rs2['Nombre_Comercial'],
	$Rs2['Direccion'],
	$Rs2['CodigoPostal'],
	$Rs2['Localidad'],
	$Rs2['Telefono'],
	$Rs2['Email']
	);  
	
	$excel->writeLine($myArr);
	
	//Otra forma es
	//$excel->writeLine($Rs2);
	//De este modo volcariamos todos los registros seleccionados
	//Sin necesidad de colocarlos/filtrar previamente en $myArr
	
	}
	
	$excel->close();
	 
	//Abrimos el fichero excel que acabamos de crear
	header("location:galeria_comercial.xls");


?>