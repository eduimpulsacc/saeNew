<style>
table{ font-size:12px;}
</style>
<?php
session_start();

$nombreusuario=$_NOMBREUSUARIO;
$usuario = $_USUARIO;

    function encriptar_AES($string)
    {
        
        $key="colegiointeractivo";
        
         $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
         $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM );
         mcrypt_generic_init($td, $key, $iv);
         $encrypted_data_bin = mcrypt_generic($td, $string);
         mcrypt_generic_deinit($td);
         mcrypt_module_close($td);
         $encrypted_data_hex = bin2hex($encrypted_data_bin);
         return $encrypted_data_hex;
     }
    
    
    

    
    
    
foreach($_POST as $nombre_campo => $valor){
$asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
eval($asignacion); }
//echo $estado_email;
    $titulo = "<b>Solicitud de dirección de correo electrónico para recuperación de clave</b><br><br>";
    $texto = "De ahora en adelante queremos ayudarte a recuperar tu contraseña de forma rápida y fácil. Para eso te pedimos que, por favor, ingreses tu dirección electrónica aquí abajo. Te enviaremos un mensaje de confirmación. Si no lo ves en tu bandeja de entrada, por favor revisa tu bandeja de correos no deseados o SPAM.En caso de cualquier duda puedes escribirnos a soporte@eduimpulsa.com o llamarnos al +56232411860.";
    $texto2 = "Se le ha enviado un link para confirmar su email. No olvide revisar su carpeta SPAM.No ha validado su correo.En la oportunidad anterior no logramos validar su correo electrónico. Le pedimos, por favor, que lo ingrese nuevamente y que revise su bandeja de entrada para validar el proceso. Si no lo ve en su bandeja de entrada le pedimos que revise su bandeja de correos no deseados (SPAM). Cualquier duda puedes llamarnos al +56232411860 o escribirnos a soporte@eduimpulsa.com";

if ($funcion == 1) {
    if($estado_email == 1) { ?>
         <form action="contact.php" method="post" name="myForm" id="myForm">
        <p align="center"><?php echo utf8_decode($titulo)?></p>
        <p align="center"><?php echo utf8_decode($texto2)?></p>
            <div align="center">
           <br><br /><br />


           <table width="50%" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td width="40%"><strong>Email</strong></td>
               <td width="60%"><input name="email2" align ="center" type="text" required="1" id="email1"/></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td>&nbsp;</td>
             </tr>
             <tr>
               <td><strong>
Confirme Email</br>
               </strong></td>
               <td><input name="email3" align ="center" type="text" id="email2"/></td>
             </tr>
           </table>
           </div>
        </form> <?php    }
    else if ($estado_email == 0) { ?>
         <form action="contact.php" method="post" name="myForm" id="myForm">
          <p align="center"><?php echo utf8_decode($titulo)?></p>
          <p align="center"><?php echo utf8_decode($texto)?></p><br /><br />
            <div align="center">
              <table width="50%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="40%"><strong>Email</strong></td>
                  <td width="60%"><input name="email" align ="center" type="text" required="1" id="email1"/></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><strong>Confirme email</strong></td>
                  <td><input name="emailConfirm" align ="center" type="text" id="email2"/></td>
                </tr>
              </table>
           
           </div>
        </form> <?
    }
}

if ($funcion == 2) {
    $conn=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j");
       if (!$conn){
           error('<b>ERROR:</b>No se puede conectar a la base de datos.(1)');
           echo "no conecté";
           exit;
       }
    $token = encriptar_AES("Hello world");
     $link = "https://app.colegiointeractivo.cl/sae3.0/session/estadoEmail/verifySAEUser.php?t=$token&user=$id";
    //$token = 'token';
     $qry="UPDATE usuario set estado_email = 1,token = '".$token."'  WHERE id_usuario=".$id;
    //die();
    $result = pg_exec($conn,$qry);

    
     $qry2 = "SELECT DISTINCT id_base from accede where id_usuario=".$id;
    $result2 = pg_exec($conn,$qry2);

    //Create a "unique" token.
    
    //Construct the URL.
    //$url = "http://34.194.110.89/sae3.0/session/verify.php?t=$token&user=$userId";
    //echo $qry2="UPDATE usuario set token =" .$token." WHERE id_usuario=".$id;
    //$result2 = pg_exec($conn,$qry2);
    
   
            
    
    for ($i = 0; $i < pg_numrows($result2) ; $i++) {
        $fila_base = pg_fetch_array($result2,$i);
         $id_base = $fila_base["id_base"];
         $sql2 = "SELECT * FROM base_dato where id_base = ".$id_base;
        $result2 = pg_exec($conn,$sql2);
         $host = pg_result($result2,2);
         $name_db = pg_result($result2,1);
         $user = pg_result($result2,4);
         $port = pg_result($result2,3);
         $password = pg_result($result2,5);
         $connection=pg_connect("dbname=$name_db host=$host port=$port user=$user password=$password");
        
                  if(!$connection){
                        echo "Error de conexion $name.\n";
                    }
                  else {
                       $q1 = "SELECT * FROM empleado where rut_emp = ".$_NOMBREUSUARIO; 
                       $res1 = pg_exec($connection,$q1);
                       pg_numrows($res1);
                      if(pg_numrows($res1)>0){
                        $qempleado = "UPDATE empleado set email ='".$email."' WHERE rut_emp =".$_NOMBREUSUARIO;
                        $res_empleado = pg_exec($connection,$qempleado);
                          $nom = pg_result($res1,2);
                          $apellido_paterno = pg_result($res1,3);
                          $apellido_materno = pg_result($res1,4);

                     }
                         $q2 = "SELECT * FROM apoderado where rut_apo = ".$_NOMBREUSUARIO;
                                        
                                         
                                        
                                        if(pg_numrows($res2)>0){
                                           $qapoderado = "UPDATE apoderado set email ='".$email."' WHERE rut_apo =".$_NOMBREUSUARIO;
                                           $res_apoderado = pg_exec($connection,$qapoderado);
                                            $res2 = pg_exec($connection,$q2);
                                            $nom = pg_result($res2,2);
                                            $apellido_paterno = pg_result($res2,3);
                                            $apellido_materno = pg_result($res2,4);
                                            


                                        }
                                        $q3 = "SELECT * FROM alumno where rut_alumno = ".$_NOMBREUSUARIO;
                                        $res3 = pg_exec($connection,$q3);
                                       
                                        if(pg_numrows($res3)>0) {
                                           $qalumno = "UPDATE alumno set email ='".$email."' WHERE rut_alumno =".$_NOMBREUSUARIO;
                                           $res_alumno = pg_exec($connection,$qalumno);
                                           $nom = pg_result($res3,2);
                                           $apellido_paterno = pg_result($res3,3);
                                          $apellido_materno = pg_result($res3,4);
                                            

                                        }

                }
        
        
    }
	
	require ('../../admin/clases/mailer/class.phpmailer.php');
	$mail = new PHPMailer();
	
	$email_de="correo@eduimpulsa.com";
	$nombre = "Sistema SAE";
	
	//Luego tenemos que iniciar la validaciï¿½n por SMTP:
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->Host = "smtp.gmail.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
	$mail->Username ="correo@eduimpulsa.com"; // Correo completo a utilizar
	$mail->Password = "eduImpulsa7802"; // Contraseï¿½a
	$mail->Port = 587; // Puerto a utilizar
	$mail->SMTPSecure = 'tls';
	
	$mail->From = "correo@eduimpulsa.com"; // Desde donde enviamos (Para mostrar)
	$mail->FromName = "Sistema SAE";
	
	
	$mail->AddAddress($email); // Esta es la direcciï¿½n a donde enviamos
	//$mail->AddAddress("claudia.canto@eduimpulsa.com"); 
	
	//$mail->AddReplyTo($email_de); 
	$mail->addCustomHeader("Sistema SAE", ' <'.$email_de.'>');
	$mail->setFrom($email_de, $nombre);
	
    $headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= 'From: <contacto@eduimpulsa.com>' . "\r\n";
	$subject = "[Sistema SAE] Actualizar email";
	
	$message = "
	<html>
	<body>
    Estimado(a) usuario(a) $nom $apellido_paterno $apellido_materno :<br />
<br />
<br>¡Gracias por ingresar su correo!</br><br>Para confirmarlo y continuar con el proceso  haz click en el siguiente link: ".$link." </br>
    <br>¡Gracias!</br>
 <br> Equipo Colegio Interactivo </br>

	
	 <p><i>Este es un mensaje automático, por favor no lo responda.</i></p>
	</body>
	</html>
	";
	
	$mail->IsHTML(true); // El correo se envï¿½a como HTML
	$mail->Subject = $subject; // Este es el titulo del email.
	$body = $message;
	$mail->Body = $body; // Mensaje a enviar
	//echo $message;
	//if(mail($email,$subject,$message,$headers)) {
     if($mail->Send()){ 
	  echo "correo enviado";
    }
	
	else{
		echo "<b class=\"wrong\">Datos no encontrados. Comun&iacute;quese con el administrador del sistema SAE en su colegio</b>";
	}
	//var_dump($_POST);	
   // header("location:mensaje.php");

    echo ($result)?1:0;
    
    
    
}
    ?>
    
    
