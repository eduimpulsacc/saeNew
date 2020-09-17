<?
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();	

require "mod_entrevista_profesional.php";
$Obj_entrevista_prof = new EntrevistaProf($_IPDB,$_ID_BASE);

$rut_alumno=$_RUT_ALUMNO;
$id_curso=$_ID_CURSO;

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
 
if (($tipo =="docx") or ($tipo =="doc") or($tipo=="pdf")){

if($_POST['id_prof']){
   mkdir("/var/www/sae3.0/cede/mod/entrevista_profesional/archivos/".$_POST['id_prof']."", 0777);
  }

	if(copy($_FILES['fileUpload']['tmp_name'],'archivos/'.$_POST['id_prof'].'/'.$fileUpload)){

     $result =  $Obj_entrevista_prof->InsertaEntrevista($_ANO_CEDE, $id_curso, $rut_alumno, $_POST['txtFECHA'],$_POST['select_profesional'],$_POST['obser'],$fileUpload);
	
	 
	 if($result){
		 
		  return "<script type=\"text/javascript\">alert(\"Datos guardados\");</script>";
		  
		 }else{
			  echo "<script type=\"text/javascript\">alert(\"dirijase a ficha de alumno, seleccione un alumno y vuelva para guardar datos.\");</script>";
			 }
		
	}else{ echo"<script type=\"text/javascript\">alert(\"Error de datos\");</script>";}
	 
    }else{ "<script type=\"text/javascript\">alert(\"Solo Archivos .Word Y .Pdf\");</script>";}
 
    }else{ echo "<script type=\"text/javascript\">alert(\"No se Cargo el Archivo\");</script>";}


}else{
	
	//echo Buscar_entrevistas(1);  
	  
	  }

?>