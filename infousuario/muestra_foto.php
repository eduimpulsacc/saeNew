<?
require('../util/header.inc');
include('../util/rpc.php3');

echo	$sql = "select * from matricula where id_ano=838";
	$result = pg_Exec($conn,$sql);	
echo "<br>total = ".@pg_numrows($result);	

	for($i=0;$i<@pg_numrows($result);$i++){
echo "uno";
		$arr=@pg_fetch_array($result,$i);	
		$nombre_archivo = 'images/'.$arr['rut_alumno'];	
		echo "<br>".$arr['rut_alumno'];
	}

?>