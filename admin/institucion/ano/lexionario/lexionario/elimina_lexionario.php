<? 
require('../../../../util/header.inc');


$xidlex = $_REQUEST['xidlex'];

//$qry="DELETE FROM MATRICULA WHERE RUT_ALUMNO=".$xrut." AND RDB=".$xinstitucion." AND ID_ANO =".$xano;

$sql= "DELETE FROM LEXIONARIO WHERE ID_LEXIONARIO=".$xidlex;
$rs_lexionario =pg_Exec($conn,$sql)/* or die ("fallo:".$sql)*/;

if (!$rs_lexionario) {
			
	echo 0;
	
		 
  }else{
    
	echo 1;
	
  }
  

?>


