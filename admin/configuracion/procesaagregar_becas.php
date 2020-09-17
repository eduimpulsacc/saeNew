<?  // require "../../util/connect.php";
	//include('../clases/class_Reporte.php');
require('../../util/header.inc');
//echo $ano;
//echo "<br />".$cmb_becas;
//echo "<br />".$rut_alumno;


if($tipo==1){

$fecha = date("m/d/Y");

	$sql ="INSERT INTO becas_benef (id_beca,id_ano,rut_alumno,fecha_postul) VALUES (".$cmb_becas.",".$ano.",".$rut_alumno.",'".$fecha."')";
	$resp = pg_exec($conn,$sql);
	
?>
<script language="javascript">window.location="postulacion_becas.php?curso=<?=$curso?>&rut_alumno=<?=$rut_alumno?>"</script>
<? }


if($tipo==2){
	
	$sql_id="SELECT MAX(id_beca) FROM becas_conf";
	$res_sql_id=@pg_exec($conn,$sql_id);
	$id_beca_max1=pg_result($res_sql_id,0);
	$id_beca_max=$id_beca_max1+1;
	
	$sql ="INSERT INTO becas_conf (id_beca,nomb_beca,descripcion,id_ano) VALUES ";
	$sql.="(".$id_beca_max.",'".$beca."','".$desc."',".$ano.")";
	$res_sql=@pg_exec($conn,$sql);
	
?>

<script language="javascript">window.location="ingreso_becas.php"</script>
<? }


if($tipo==3){


	$sql_editar="UPDATE becas_conf SET nomb_beca='".$beca."',descripcion='".$desc."' WHERE id_beca=".$id_beca;
	$res_editar=@pg_exec($conn,$sql_editar);

?>
<script language="javascript">window.location="ingreso_becas.php"</script>	
<? }


if($tipo==4){

	$sql_borrar="DELETE FROM becas_conf WHERE id_beca=".$id_beca;
	$res_borrar=@pg_exec($conn,$sql_borrar);
	
	$sql_borrar_2="DELETE FROM becas_benef WHERE id_beca=".$id_beca;
	$res_borrar_2=@pg_exec($conn,$sql_borrar_2);



?>
<script language="javascript">window.location="ingreso_becas.php"</script>
<? }
if($tipo==5){
	$sql_borrar="DELETE FROM becas_benef WHERE id_beca=".$id_beca." AND id_ano=".$ano." AND rut_alumno=".$rut_alumno;
	$resp=pg_exec($conn,$sql_borrar);
?>
<script language="javascript">window.location="postulacion_becas.php?rut_alumno=<?=$rut_alumno?>&curso=<?=$curso?>"</script>
<? }?>


