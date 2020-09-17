<?php
 //Establecemos zona horaria por defecto
 // date_default_timezone_set("America/Brasilia");

    //preguntamos la zona horaria
    $zonahoraria = date_default_timezone_get();
    echo 'Zona horaria predeterminada: ' . $zonahoraria;
	echo date("H:i:s");
exit;
?>