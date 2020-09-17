<?php 
require('../../util/header.inc');
$ano			=$_ANO;
  $modo= $_REQUEST["modo"];

switch ($modo){

case 1:
 	$sql="insert into actividades_extra(observacion,nombre_extra,id_ano,fecha_extra,id_curso) values ('".$_POST["observaciones"]."','".$_POST["nombre"]."',".$ano.",'".fEs2En($_POST["fecha"])."',".$_POST["cmb_curso"].")";
	$resp = pg_exec($conn,$sql);
	echo "<script language='javascript'>window.location='acti_extra.php'</script>";
break;

case 2:
 	$sql="DELETE FROM actividades_extra WHERE id_extra =".$_GET["id_extra"];
	$resp = pg_exec($conn,$sql);
	$sql2="DELETE FROM asiste_actividad WHERE id_extra =".$_GET["id_extra"];
	$resp2 = pg_exec($conn,$sq02l);
	echo "<script language='javascript'>window.location='acti_extra.php'</script>";
break;

case 3:
 	$sql="UPDATE actividades_extra SET observacion ='".$_POST["observaciones"]."',fecha_extra='".fEs2En($_POST["fecha"])."',nombre_extra='".$_POST["nombre"]."',id_curso=".$_POST["cmb_curso"]." WHERE id_extra = ".$_POST["id_extra"];
	//return;
	$resp = pg_exec($conn,$sql);
	echo "<script language='javascript'>window.location='acti_extra.php'</script>";
break;

}
?>

