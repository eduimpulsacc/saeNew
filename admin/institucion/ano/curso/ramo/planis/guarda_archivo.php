<?php
require('../../../../../../util/header.inc');
//print_r($_POST);

	$rutemp=$_POST['rutemp'];
	$id_curso=$_POST['id_curso'];
	$id_ramo=$_POST['id_ramo'];
	$text_descripcion=$_POST['text_descripcion'];
	
	
	 $fecha=date('m/d/Y');
	
	function mensaje($mensaje){


	echo "<script language=\"javascript\" type=\"text/javascript\">
						alert(\"{$mensaje}\");
						</script>";	
	echo"<script>window.location = \"planificacion.php?id_ramo=".$_POST['id_ramo']."\"</script>";
	exit;
}
	
	
	
$uploaddir = "archivos/"; 
$nombre_archivo=basename($_FILES['archivo']['name']);
$ruta_archivo = $uploaddir . basename($_FILES['archivo']['name']); 

 
 
if(isset($ruta_archivo)) { 
$subido = copy($_FILES['archivo']['tmp_name'], $ruta_archivo); 
} 

if($subido) {
	
	
	
	
	
	$sql="insert into plani_archivos (rut_emp,id_ramo,id_curso,fecha,ruta_archivo,observ) values (".$rutemp.",".$id_ramo.",".$id_curso.",'".$fecha."','".$nombre_archivo."','".$text_descripcion."') ";
	
		$result_insert = @pg_Exec($conn,$sql) or die("Fallo".$sql);
	
	if($result_insert){
	mensaje("Datos Guardados"); 	
	}else{
	echo mensaje("Error al guardar");	
		}
		
	
	}else{ 
	echo mensaje("Error al Subir Archivo"); 
	}


?>