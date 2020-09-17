<?php
//comprobamos que sea una petición ajax
session_start();
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
 
    //obtenemos el archivo a subir
    $file = $_FILES['archivo']['name'];
	//$nom = $_INSTIT."_".$_SESSION["_ICLS"]."_".date("YmdHis");
 
    //comprobamos si existe un directorio para subir el archivo
	
	
    //si no es así, lo creamos
    if(!is_dir("../acv/")) {
        mkdir("../acv/", 0777);}
	else{
	//chmod("../acv/", 0777);
	}
     
    //comprobamos si el archivo ha subido
    if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"../acv/".$file))
    {
       sleep(3);//retrasamos la petición 3 segundos
       echo $file;//devolvemos el nombre del archivo para pintar la imagen
	  // chmod("../acv/", 0644);//le vuelvo a cambiar el permiso
    }
}else{
    throw new Exception("Error Processing Request", 1);   
}
?>