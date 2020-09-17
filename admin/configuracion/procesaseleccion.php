<? 
require('../../util/header.inc');
$ano			=$_ANO;
$modo=$_REQUEST["modo"];
switch($modo){
case 1:
	$ensenanza=$_POST["ensenanza"];
	$cmb_curso=$_POST["curso"];
	$sigla=$_POST["sigla"];
	$descripcion=$_POST["descripcion"];
	$valor=$_POST["valor"];
	$sqlcurso="select grado_curso from curso where id_curso=".$cmb_curso;
	$resultado=@pg_Exec($conn,$sqlcurso);
	$fila = @pg_fetch_array($resultado,0);
	$cmb_curso=$fila["grado_curso"]; 
	$sql="INSERT INTO criterio_seleccion ( id_ano, descripcion,valor,ensenanza,grado,sigla) VALUES ($ano, '".$descripcion."',$valor,$ensenanza,$cmb_curso,'".$sigla."')";
	$resultado=@pg_Exec($conn,$sql);
							 	
	break;
case 2:
	$id_sel=$_GET["id_sel"];
	$sql="DELETE FROM  Criterio_seleccion WHERE id_sel=".$id_sel;
	$resultado=@pg_Exec($conn,$sql);
break;
case 3:
	$id_vacante=$_POST["id_vacante"];
	$cmb_ensenanza=$_POST["ensenanza"];
	$cmb_curso=$_POST["curso"];
	$descripcion=$_POST["descripcion"];
	$valor=$_POST["valor"];
	$sigla=$_POST["sigla"];
	$sql="UPDATE criterio_seleccion SET ensenanza =".$cmb_ensenanza." , grado=".$cmb_curso." , descripcion='".$descripcion."',valor=".$valor.",sigla='".$sigla."' WHERE id_sel=".$id_vacante;
	$resultado=@pg_Exec($conn,$sql);
}
?>
<script language="javascript">window.location="Criterio_seleccion.php"</script>