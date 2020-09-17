<? require('../../../util/header.inc');


	$result =	$_GET['resultado'];
	
	for($i=0;$i<pg_numrows($result);$i++){
	
	$datos=pg_fetch_array($result,$i);
	
	echo $datos['nombre_usuario'];	
	
	}





?>