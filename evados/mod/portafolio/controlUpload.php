<?
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();	

require "mod_portafolio.php";
$ob_portafolio_2 = new portafolio($_IPDB,$_DBNAME);

/*require "../../class/Membrete.class.php";
$ob_membrete = new Membrete($_IPDB,$_DBNAME);
$ob_membrete->estilosae($_INSTIT);*/


if ( $archivo != ""){
header("Content-type: application/x-file");
header("Content-Disposition: attachment; filename=$archivo");
readfile("documentos/$archivo");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="../../<?=$ob_membrete->ESTILO?>" rel="stylesheet" type="text/css">
<title>SISTEM EVADOS</title>

<!--<link type="text/css" href="../../../admin/clases/jqueryui/jquery-ui-1.8.6.custom.css" rel="stylesheet" />-->
<link rel="stylesheet" type="text/css" href="../../../admin/clases/flexigrid-1.1/css/flexigrid.css">

<script type="text/javascript" src="../../../admin/clases/jqueryui/jquery-1.4.2.min.js"></script>
<!--<script type="text/javascript" src="../../../admin/clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
-->
<script type="text/javascript" src="../../../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>


<script>

function eliminar_archivo(rut_empl,id_ano,nom_arch){
  var parametros = "funcion=10&rut_empl="+rut_empl+"&id_ano="+id_ano+"&nom_arch="+nom_arch;
  
  alert(parametros);
  
  		/*$.ajax({
		  url:'mod/portafolio/cont_portafolio.php',
		  type:'post',
		  data:parametros,
		  success:function(data){
					if(data!=0){
                      alert("Archivo Eliminado");
					}else{
					  alert("Error");
					}
			 }
		 })*/
		
    }
	
function cargatabla(){
	$("#flex3").flexigrid({
		width : 550,
		height : 100
		});
  }

</script>

<?

$_POST['rut_empleado'];
$tipodoc=explode('/',$_POST['tipo_documento']);
$tipodoc[0];
$tipodoc[1];

if($_FILES['fileUpload']['name']){

if(is_uploaded_file($_FILES['fileUpload']['tmp_name'])){
	
	
    $tipo = $_FILES['fileUpload']['type'];
	
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

if ( ($tipo == 'application/msword') or ($tipo =="application/msexcel") or ($tipo=="application/pdf") ) {

if($_POST['rut_empleado']){
   mkdir("/var/www/sae3.0/evados/mod/portafolio/documentos/".$_POST['rut_empleado']."", 0777);
  }

	if(copy($_FILES['fileUpload']['tmp_name'],'documentos/'.$_POST['rut_empleado'].'/'.$fileUpload)){

       $ob_portafolio_2->insertaportafolio($_POST['rut_empleado'],$_ANO,$tipodoc[0],$fileUpload,$tipo);
	   $ob_portafolio_2->cargaportafolios($_POST['rut_empleado'],$_ANO);
	
	}else{ echo "Error al cargar"; } 

 }else{ echo "Solo Archivos .Word .Exel .Pdf";}

}else{ echo "No se Cargo Archivo"; }


}else{
	  
	//echo cargatable();  
	  
	  }

?>