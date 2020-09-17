<?php require('../../../../../util/header.inc');?>
<?
	
	  //Variables definidas por el usario
	  $abpath = "Archivos"; //Directorio donde los archivos serán subidos
	  $sizelim = "yes"; //Activando el limite de archivo a subir
	  $size = "204800"; //Soporte para archivos no mayores a 800 KB
	  //Tipos de archivos a soportar
	  $T1 = "image/pjpeg"; //Jpeg type 1 .jpg
	  $T2 = "image/jpeg"; //Jpeg type 2 .jpg
	  $T3 = "image/gif"; //Gif type .gif
	  $T4 = "application/octet-stream"; //Archivos de office .doc .xls
	  $T5 = "text/plain"; //Texto plano .txt 
	  $T6 = "application/msword"; //Texto plano .txt 
	  $log = ""; //Mensaje que se mostrará al usuario 
	  $exten = substr ($Documento_name, -3); //Extensión del archivo a subir
	  $Tip_er = 0; //Variable para indicar algún tipo de error
	  $subirlo = 0; //Variable utilizada para indicar exito
	
//		$Ruta_completa = "$abpath/" . substr($Documento_name, 0, strcspn($Documento_name,".")) . $_SESSION['Condominio_Id'] . "$fecha.$exten";  
		$Ruta_completa = "Archivos/" . substr($Documento_name, 0, strcspn($Documento_name,".")).".".$exten;  

	  //Si se eligio un archivo comenzar
	   if ($Documento_name != "") 
	   {
			$subirlo = 0;
			//Chequear que el archivo exista
			if (file_exists($Ruta_completa)) 
			{ 
				 $log .= "El archivo ya fue recibido durante este dia, por lo que ha sido satisfactoriamente actualizado";
				 $subirlo =1;
				 $Tip_er = 0;
			} 
			else 
  		   {
			   //Chequear el tamaño del archivo
			   if (($sizelim == "yes") && ($Documento_size > $size))  
			   { 
					$log .= "El tamaño del archivo no esta permitido.<br>";
					$Tip_er = 1;
					$subirlo = 0;
			   }
			   else
			   {
				//Chequea el tipo de archivo
					if ((($Documento_type == $T1) || ($Documento_type == $T2) || ($Documento_type == $T3) || ($Documento_type == $T4) || ($Documento_type == $T5) || ($Documento_type == $T6)) && (($exten == "txt") || ($exten == "doc") || ($exten == "xls") || ($exten == "pdf") || ($exten == "gif") || ($exten == "jpg"))) 
					{
						  //Subiendo el archivo al directorio
						 copy($Documento, $Ruta_completa);
						 //Comprovando si subio o no
						 if (file_exists($Ruta_completa)) 
						 {
							  $log .= "El archivo fue recibido correctamente.<br>"; 
							  $Tip_er = 0;
							  $subirlo = 1;
						 } 
						 else
						 {
							  $log .= "El archivo no pudo ser recibido.<br>";
							  $Tip_er = 1;
							  $subirlo = 0;
						 } 
					  } 
					  else 
					  {
						   $log .= "El archivo no posee un tipo permitido.<br>";
						   $Tip_er = 1;
						   $subirlo = 0;
					  }
				 }
			}
		}
		else
		{
			 $log .= "El archivo no pudo ser recibido.<br>";
			 $Tip_er = 1;
			 $subirlo = 0;
		} 

		printf("<title>ARCHIVO INSERTADO...</title>".$log."</p><input type=button value=ACEPTAR onClick=window.close()>");
		pg_close($conn);
?>