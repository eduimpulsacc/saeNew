<?	$mime = $_FILES['archivo']['type'];
	$archivo = $_FILES['archivo']['name'];
	$path = $_FILES['archivo']['tmp_name'];
	$size = $_FILES['archivo']['size'];
	
	$to = "efuentes@colegiointeractivo.com";
	$from = "efuentes@colegiointeractivo.com";
	$subject = "Prueba de envío de correo con attachments";
	
	$headers = "From: ".$from." ";
	
	$file = fopen($path,'rb');
	$data = fread($file,$size);
	fclose($file);
	
	 $semi_rand = md5( time() ); 
        $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
    
        $headers .= "\nMIME-Version: 1.0\n" . 
                    "Content-Type: multipart/mixed;\n" . 
                    " boundary=\"{$mime_boundary}\"";
    
        $message = "This is a multi-part message in MIME format.\n\n" . 
                "--{$mime_boundary}\n" . 
                "Content-Type: text/plain; charset=\"iso-8859-1\"\n" . 
                "Content-Transfer-Encoding: 7bit\n\n" . 
                $message . " Nombre: ".$_POST['nombre']."\n\n Apellidos: ".$_POST['apellidos']."\n\n Direccion: ".$_POST['direccion']."\n\n";
    
        $data = chunk_split( base64_encode( $data ) );
                 
        $message .= "--{$mime_boundary}\n" . 
                 "Content-Type: {$mime};\n" . 
                 " name=\"{$archivo}\"\n" . 
                 "Content-Disposition: attachment;\n" . 
                 " filename=\"{$archivo}\"\n" . 
                 "Content-Transfer-Encoding: base64\n\n" . 
                 $data . "\n\n" . 
                 "--{$mime_boundary}--\n"; 
	
	
	
	
	if( mail( $to, $subject, $message, $headers ) ) {
         
            echo "<p>The email was sent.</p>"; 
         
        }
        else { 
        
            echo "<p>There was an error sending the mail.</p>"; 
         
        }
    
	
?>