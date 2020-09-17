<?php 	require('../../../../util/header.inc');
			$ano =$_ANO;

$qry="DELETE FROM CITACION_APO WHERE rut_alumno='".$_GET['alumno']."' and id_citacion=".$_GET['cita'];
$result =@pg_Exec($conn,$qry);
echo "<script>window.location ='lista_citacion.php3?cmb_curso=".$_CURSO."&cmb_acti=".$_GET['alumno']."'</script>";				
?>