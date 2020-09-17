<?php 	require('../../../../../../util/header.inc');

 	$sql="DELETE FROM examen_semestral WHERE id_examen=".$id_examen;
	$rs_examen = @pg_exec($conn,$sql);
	
	$sql="DELETE FROM notas_examen WHERE id_examen=".$id_examen;
	$rs_notas = @pg_exec($conn,$sql);
	
	echo "<script>window.location='../ramo.php3?ramo=".$_RAMO."'</script>";
    

?>