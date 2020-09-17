<?php
session_start();
require("../../../util/header.inc");
require("../mod_unidad.php");
$ob_clase = new Unidad();


//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
 
    //obtenemos el archivo a subir
    $file = $_FILES['archivo']['name'];
	 $ext = pathinfo($file, PATHINFO_EXTENSION);  
	$time = time();
    $fecha= date("YmdHis", $time);
	$nom=$_INSTIT."_".$_SESSION["_ICLS"]."_".$fecha.".".$ext;
 
    //comprobamos si existe un directorio para subir el archivo
    //si no es así, lo creamos
    if(!is_dir("../acv/")) 
        mkdir("../acv/", 0777);
     else{
		 chmod("../../unidad/", 0777);
		 chmod("../acv/", 0777);
	}
	 
    //comprobamos si el archivo ha subido
    if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"../acv/".$nom))
    {
       
	    chmod("../unidad/", 0755);
		 chmod("../acv/", 0755);
		 
		 $rs_busca = $ob_clase->traearchivo($conn,$_SESSION["_ICLS"]);
		 for($b=0;$b<pg_numrows($rs_busca);$b++){
			$fila = pg_fetch_array($rs_busca,$b);
			$ruta =$fila['ruta'];
			
			if(is_file('../acv/'.$ruta)){
				unlink('../acv/'.$ruta);
			}
		}
		 
		 $rs_pisa = $ob_clase->pisaArchivos($conn,$_SESSION["_ICLS"]);
		 $rs_crea = $ob_clase->guardaArchivos($conn,$_SESSION["_ICLS"],$nom);
		 if($rs_crea){
			sleep(3);//retrasamos la petición 3 segundos
		    echo $file;//devolvemos el nombre del archivo para pintar la imagen
		}else{
			throw new Exception("Error Processing Request", 1);   
		}
    }
}else{
    throw new Exception("Error Processing Request", 1);   
}