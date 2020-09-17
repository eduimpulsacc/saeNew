<?php 	require('../../../../util/header.inc');
			$ano =$_ANO;
$sql="insert into citacion_apo (rut_alumno,fecha,observacion,id_ano,id_curso) values(".$_POST["cmb_acti"].",'".$_POST["fecha"]."','".$_POST["txtobservacion"]."',".$ano.",".$_POST["cmb_curso"].")";
$result =@pg_Exec($conn,$sql);
echo "<script>window.location ='lista_citacion.php3?cmb_curso=".$_POST['cmb_curso']."&cmb_acti=".$_POST["cmb_acti"]."'</script>";				
?>