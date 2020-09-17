<?

//mail("pcardenas@colegiointectivo.com", "Log Procesador_Notas.php", "Esto es una Prueba");
							
$para      = 'pcardenas@colegiointectivo.com';
$titulo = 'El título';
$mensaje = 'Hola';
$cabeceras = 'From: webmaster@example.com' . "\r\n" .
'Reply-To: webmaster@example.com' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
							
if(mail($para, $titulo, $mensaje, $cabeceras)){
	echo "Correo Enviado";
 }else{
	echo "Error En Correo";									
  };
							

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
</body>
</html>