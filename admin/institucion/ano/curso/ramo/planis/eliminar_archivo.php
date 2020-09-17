<?
require('../../../../../../util/header.inc');

//print_r($_POST);

$id_archivo=$_GET['id_archivo'];

if(isset($id_archivo)){
	
	
		
	function mensaje($mensaje){


	echo "<script language=\"javascript\" type=\"text/javascript\">
						
						alert(\"{$mensaje}\");
						</script>";	
	echo"<script>javascript:history.go(-1)</script>";
	
	exit;
}
	
	
	
	
	$sql="delete from plani_archivos where id_archivo=$id_archivo";
	 $result = pg_Exec($conn,$sql) or die ("Fallo".$sql);
	 
	 if($result){
	mensaje("Datos Eliminados"); 	
	}else{
	echo mensaje("Error al Eliminar");	
		}
		
	
	
	
	
	}


?>
