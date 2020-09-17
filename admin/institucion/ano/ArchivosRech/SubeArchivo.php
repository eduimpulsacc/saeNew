<?php require('../../../../util/header.inc');?>
<?
		$ano = $_ANO;

		$Flag=0;

	$sql_ano = "SELECT * FROM ano_escolar WHERE id_ano=".$ano."";
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila = @pg_fetch_array($result_ano,0);
	$nro_ano = $fila['nro_ano'];

	  //Variables definidas por el usario
	  $abpath = "Archivos"; //Directorio donde los archivos serán subidos
	  $sizelim = "no"; //Activando el limite de archivo a subir	  
	  $size = "1638400000"; //Soporte para archivos no mayores a 800 KB
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

		$Otro = $Documento;	
//		$Ruta_completa = "$abpath/" . substr($Documento_name, 0, strcspn($Documento_name,".")) . $_SESSION['Condominio_Id'] . "$fecha.$exten";  
		$Ruta_completa = "Archivos/".substr($Documento_name, 0, strcspn($Documento_name,".")).".".$exten;  
//		$Ruta_completa2 = "Archivos/".substr($Documento2_name, 0, strcspn($Documento2_name,".")).".".$exten;  

		$Ruta_copia = "Archivos/Antiguo/".substr($Documento_name, 0, strcspn($Documento_name,"."))."_".$nro_ano.".".$exten;  

	  //Si se eligio un archivo comenzar
	   if ($Documento_name != "") 
	   {
			$subirlo = 0;
			//Chequear que el archivo exista  
			if (file_exists($Ruta_completa)) 
			{ 
				echo "<br>existe";
				 $log .= "El archivo ya fue recibido durante este dia, por lo que ha sido satisfactoriamente actualizado";
				 $subirlo =1;
				 $Tip_er = 0;

				chmod ($Otro,777);			 // permiso
				 copy($Otro, $Ruta_copia);

/* ********************** */
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
	
							 //Comprobando si subio o no
	
							 if (file_exists($Ruta_completa)) 
							 {
								  $log .= "El archivo fue recibido correctamente.<br>"; 
								  $Tip_er = 0;
								  $subirlo = 1;
	// insertar el archivo a la tabla archivo_rech, para llevar un control de los archivos ingresados
									$rdb_nro = substr ($Documento_name, 1,-4); //Extensión del archivo a subir
									$separa = explode('_',$rdb_nro);
									$rdb = trim($separa[0]);
									$nro = trim($separa[1]);
	//								$nombre = substr($Documento_name,0,-4);
									$nombre = setType($Documento_name,"string");
								  $sql_insert = "INSERT INTO archivo_rech (rdb,numero,nombre_archivo,estado_archivo) VALUES(".$rdb.",".$nro.",'".$Documento_name."',0)";
	
								  $result_insert = pg_exec($conn,$sql_insert);
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

/* ********************** */


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

						 //Comprobando si subio o no

						 if (file_exists($Ruta_completa)) 
						 {
							  $log .= "El archivo fue recibido correctamente.<br>"; 
							  $Tip_er = 0;
							  $subirlo = 1;
// insertar el archivo a la tabla archivo_rech, para llevar un control de los archivos ingresados
								$rdb_nro = substr ($Documento_name, 1,-4); //Extensión del archivo a subir
								$separa = explode('_',$rdb_nro);
								$rdb = trim($separa[0]);
								$nro = trim($separa[1]);
//								$nombre = substr($Documento_name,0,-4);
								$nombre = setType($Documento_name,"string");
							  $sql_insert = "INSERT INTO archivo_rech (rdb,numero,nombre_archivo,estado_archivo) VALUES(".$rdb.",".$nro.",'".$Documento_name."',0)";

							  $result_insert = pg_exec($conn,$sql_insert);
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
			 $Flag=1;
		} 
        
		if($Flag==0){
		   
			echo "<script>window.location = 'ArchRech.php?caso=2'</script>";
		}
		else{
		   
			echo "<script>window.location = 'ArchRech.php?caso=1'</script>";
		}

		pg_close($conn);
?>