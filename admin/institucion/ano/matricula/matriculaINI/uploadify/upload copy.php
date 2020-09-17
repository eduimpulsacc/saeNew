<?php
// JQuery File Upload Plugin v1.4.1 by RonnieSan - (C)2009 Ronnie Garcia
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	//$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_GET['folder'] . '/';
	$targetPath = "../files/";
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	
	// Uncomment the following line if you want to make the directory if it doesn't exist
	 mkdir(str_replace('//','/',$targetPath), 0755, true);
	
	move_uploaded_file($tempFile,$targetFile);
}

  			switch ($_FILES['Filedata']['error'])
				{  	case 0:
						$msg = "No Error";
						break;
					case 1:
           				$msg = "El archivo es más grande que permite la instalación PHP";
           				break;
   					case 2:
           				$msg = "El archivo es más grande que esta forma permite que";
           				break;
    				case 3:
           				$msg = "Sólo una parte del archivo subido";
           				break;
    				case 4:
          		 		$msg = "No existe el fichero subido";
           				break;
					case 6:
          		 		$msg = "Falta una carpeta temporal";
           				break;
    				case 7:
          		 		$msg = "No se pudo escribir el archivo en el disco";
           				break;
    				case 8:
          		 		$msg = "Archivo de carga se detuvo, por extensión,";
           				break;
 					default:
						$msg = "unknown error ".$_FILES['Filedata']['error'];
						break;
				}

	$setupFile = "uploadVARresults.txt";
	$fh = fopen($setupFile, 'w');
	if ($fh) {
		$stringData = "path: ".$_GET['folder']."\n targetFile: ".$targetFile."\n Error: ".$_FILES['Filedata']['error']."\nError Info: ".$msg;		
	}
	fwrite($fh, $stringData);
	fclose($fh);
	
	echo '1';

?>