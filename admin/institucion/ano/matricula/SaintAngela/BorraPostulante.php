<?
require('../../../../../util/header.inc');

	setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
	//Borrar
	$sql_delete = "delete from postulacion where id_post = ".$id_post;
	$result_delete = @pg_Exec($conn,$sql_delete);	
	echo "<script>window.location ='ListadoPostulantes.php'</script>";
	pg_close($conn);
?>