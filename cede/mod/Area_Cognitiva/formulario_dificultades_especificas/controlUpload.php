<?
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();	

require "mod_dificultades_especificas.php";
$Obj_Area_cog = new AreaCog($_IPDB,$_ID_BASE); 

$id_curso=$_ID_CURSO;
$rut_alumno=$_RUT_ALUMNO;



//echo "-------->>>>".$_FILES['fileUpload']['name'];
if ( $archivo != ""){
header("Content-type: application/x-file");
header("Content-Disposition: attachment; filename=$archivo");
readfile("archivos/$archivo");

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<title>sin titulo</title>

<?
		 
//$_POST['id_prof'];
/*$tipodoc=explode('/',$_POST['tipo_documento']);
$tipodoc[0];
$tipodoc[1];*/
"NOMBRE--->".$nombre=$_FILES['fileUpload']['name'];
if($nombre){

if(is_uploaded_file($_FILES['fileUpload']['tmp_name'])){
	
	$partes = explode(".", $nombre); 
    $tipo = end($partes); 
	
   //$tipo = $_FILES['fileUpload']['type'];
	$fileUpload = utf8_decode($_FILES['fileUpload']['name']);
	
	$fileUpload = str_replace("#","No.",$fileUpload);
	$fileUpload = str_replace("$","Dollar",$fileUpload);
	$fileUpload = str_replace("%","Percent",$fileUpload);
	$fileUpload = str_replace("^","",$fileUpload);
	$fileUpload = str_replace("&","and",$fileUpload);
	$fileUpload = str_replace("*","",$fileUpload);
	$fileUpload = str_replace("?","",$fileUpload);
	$fileUpload = str_replace(" ","_",$fileUpload);

	$fileUpload1 = str_replace("á","a",$fileUpload);
	$fileUpload = str_replace("é","e",$fileUpload);
	$fileUpload = str_replace("í","i",$fileUpload);
	$fileUpload = str_replace("ó","o",$fileUpload);
	$fileUpload = str_replace("ú","u",$fileUpload);
	
	$fileUpload = str_replace("Á","A",$fileUpload);
	$fileUpload = str_replace("É","E",$fileUpload);
	$fileUpload = str_replace("Í","I",$fileUpload);
	$fileUpload = str_replace("Ó","O",$fileUpload);
	$fileUpload = str_replace("Ú","U",$fileUpload);
 
if (($tipo =="docx") or($tipo=="pdf")){

	$fechaup=$_POST['txtFECHA'];
	
    $fechaupload = ereg_replace("[/]", "", $fechaup);
    
	$nombre_archivo=$_RUT_ALUMNO.'_'.$fechaupload.'_'.$fileUpload;
	if(copy($_FILES['fileUpload']['tmp_name'],'archivos/'.$nombre_archivo)){

   $result =  $Obj_Area_cog->InsertaAreaCognitiva($_ANO_CEDE, $id_curso, $rut_alumno, $_POST['txtFECHA'],$_NOMBREUSUARIO,$_POST['obser'],   $nombre_archivo,$_POST['id_tipo']);
	 
	 if($result){
		 
		 
		 }
	}else{ "<script type=\"text/javascript\">alert(\"Error al Cargar\");</script>";}
	 
    }else{ "<script type=\"text/javascript\">alert(\"Solo Archivos .Word Y .Pdf\");</script>";}
 
    }else{ echo "<script type=\"text/javascript\">alert(\"No se Cargo el Archivo\");</script>";}


}else{
	
	//echo Buscar_entrevistas(1);  
	  
	  }

?>