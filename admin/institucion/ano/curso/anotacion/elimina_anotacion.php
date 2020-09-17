<?
require('../../../../../util/header.inc');

$idanotacion = $_REQUEST['idanotacion']; 

$sql = "DELETE FROM anotacion
WHERE id_anotacion = $idanotacion";

$result =@pg_Exec($conn,$sql);

  if (!$result) {
			
	echo 0;
		 
  }else{
    
	echo 1;
	
  }

?>
