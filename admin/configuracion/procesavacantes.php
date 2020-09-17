<? 
require('../../util/header.inc');
$ano			=$_ANO;
$modo=$_REQUEST["modo"];
switch($modo){
case 1:
	$cmb_ensenanza=$_POST["ensenanza"];
	$cmb_curso=$_POST["curso"];
	$cantidad=$_POST["cantidad"];
	$sql_grado="select grado_curso from curso where id_curso=".$cmb_curso;
	$result_grado=@pg_Exec($conn,$sql_grado);
	$fila_grado = @pg_fetch_array($result_grado,0);
	$cmb_curso=$fila_grado["grado_curso"]; 
	$sql="INSERT INTO vacantes ( id_ano, ensenanza,grado,vac_ini,vac_dis) VALUES ($ano, $cmb_ensenanza,".$_POST["curso"].",$cantidad,$cantidad)";
	$resultado=@pg_Exec($conn,$sql);
	break;
case 2:
	$id_vacante=$_GET["id_vacante"];
	$sql="DELETE FROM  vacantes WHERE id_vacante=".$id_vacante;
	$resultado=@pg_Exec($conn,$sql);
break;
case 3:
	$id_vacante=$_POST["id_vacante"];
	$cmb_ensenanza=$_POST["ensenanza"];
	$cmb_curso=$_POST["curso"];
	$cantidad=$_POST["cantidad"];
	$sql="UPDATE vacantes SET ensenanza =".$cmb_ensenanza." , grado=".$cmb_curso." , vac_ini=".$cantidad." WHERE id_vacante=".$id_vacante;
	$resultado=@pg_Exec($conn,$sql);
}
?>
<script language="javascript">window.location="vacantes.php"</script>