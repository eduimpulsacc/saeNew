<?php

require('../../../../../../../util/header.inc');
//require('../mod_cal.php');
session_start();

//$obj_calendario = new Calendario($conn,$connection);
foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
  //echo "<br>".$asignacion;
   
} 

//comprobamos que sea una petición ajax
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
 
    //obtenemos el archivo a subir
    $file = $_FILES['archivo']['name'];
	$ext = $ext = pathinfo($file, PATHINFO_EXTENSION);  
	$time = time();
    $fecha= date("YmdHis", $time);
	$nom=$_INSTIT."_arvEva_".$fecha.".".$ext;
 
    //comprobamos si existe un directorio para subir el archivo
    //si no es así, lo creamos
    
		
		 //chmod("files/", 0777);
$archivo="";	
	 
    //comprobamos si el archivo ha subido
    if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"../files/".$nom))
    {
		$archivo=$nom;
       
	    
    }
	$fecha = CambioFE($txt_fecha);
	$_SESSION['cu']=$select_CursoN;
	$_SESSION['ra']=$select_RamosN;
	 $sql="insert into cal_pruebas_new(id_curso,id_ramo,fecha_inicio,hora,descripcion,archivo) values($select_CursoN,$select_RamosN,'$fecha','$txt_hora','$txt_contenido','$archivo')";
$result=pg_Exec($conn,$sql)or die("Fallo 0 ".$sql);


}else{
    throw new Exception("Error Processing Request", 1);   
}
