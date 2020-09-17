<?
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();	
require_once("mod_archivos_publicos.php");


/*var_dump($_POST);
var_dump($_FILES);
*/
$ArchivosPublicos = new SubirArchivo($conn); 

$rdb	= $_INSTIT;



if ( $archivo != ""){
	
header("HTTP/1.1 200 OK"); //mandamos código de OK
header("Status: 200 OK"); //sirve para corregir un bug de IE (fuente: php.net)
//header('Content-Type: application/force-download');
header('Content-Disposition: attachment; filename="'.$archivo.'"'); //
header ("Content-Type: application/octet-stream"); 
header('Content-Length: '.filesize($archivo));	
readfile("archivos/$archivo");	

}
		 

$nombre=$_FILES['fileUpload']['name'];
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
	$fileUpload = str_replace("°","",$fileUpload);
	
	$fileUpload = str_replace("Ñ","N",$fileUpload);
	
	$fileUpload = str_replace("ñ","ñ",$fileUpload);
	
	
 
/*if (($tipo == "doc") || ($tipo == "docx") || ($tipo== "pdf") || ($tipo== "PDF") || ($tipo == "xls") || ($tipo == "xlsx") || ($tipo == "jpg") || ($tipo == "jpeg") || ($tipo == "gif") || ($tipo == "bmp") || ($tipo == "png")){*/

	$fechaup=$_POST['txtFECHA'];
	
    $fechaupload = ereg_replace("[/]", "", $fechaup);
    
	$nombre_archivo=$rdb.'_'.$fechaupload.'_'.$_POST['tipo'].'_'.$fileUpload;
	
	$vista_al=(isset($_POST['vista_al']))?1:0;
$vista_apo=(isset($_POST['vista_apo']))?1:0;
	//echo copy($_FILES['fileUpload']['tmp_name'],'archivos/'.$nombre_archivo);
//	if(copy($_FILES['fileUpload']['tmp_name'],'archivos/'.$nombre_archivo)){
	if(move_uploaded_file($_FILES['fileUpload']['tmp_name'],'/var/www/html/sae3.0/admin/institucion/ano/archivos_publicos/archivos/'.$nombre_archivo)){
	 //if($_PERFIL==0){print_r($result);}
		
   //$result =  $ArchivosPublicos->InsertaArchivo($rdb,$_ANO,$_POST['txtFECHA'],$_POST['txt_observacion'],$nombre_archivo,$_POST['estado'],$_POST['vista_al'],intval($_POST['vista_apo']),$_POST['tipo']);
   $result =  $ArchivosPublicos->InsertaArchivo($rdb,$_ANO,$_POST['txtFECHA'],$_POST['txt_observacion'],$nombre_archivo,$_POST['estado'],$vista_al,$_POST['tipo'],$vista_apo);
	
	 if($result){
		
		$rul  = $ArchivosPublicos->ultimoArchivo($rdb,$_ANO);
		$ul = pg_result($rul,0);
		
		
		for($ar=0;$ar<count($_POST['cur']);$ar++){
			$res2 = $ArchivosPublicos->gArchivoCurso($ul,$_POST['cur'][$ar]);
			}
		 
		 }
		 echo "<script type=\"text/javascript\">location.href='archivos_publicos.php?menu=8&categoria=86&nw=1'</script>";
	}else{echo "<script type=\"text/javascript\">alert(\"Error al Cargar\");</script>";}
	 
    }
	
	
	/**/

/*}
else{ echo"<script type=\"text/javascript\">alert(\"Solo Archivos .doc, .docx, .xls, .xlsx, .pdf, .jpg, jpeg, .gif, .bmp, .png\");</script>";}*/
 
    }
	
	else{ echo "<script type=\"text/javascript\">alert(\"No se Cargo el Archivo\");</script>";}
	  
	  

?>