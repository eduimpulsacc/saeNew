<?
header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
require "../../class/Coneccion.class.php";
$conn = new DBManager($_IPDB,$_DBNAME);

for($e=1;$e<=count($_POST['conceptos']);$e++){

$datos = explode(",",$_POST['ids_pauta'][$e]);

$sql_insert = "INSERT INTO eva_plantilla_evaluacion(id_plantilla,id_area,id_subarea,id_item,  id_concepto,rut_evaluador,rut_evaluado,id_ano) VALUES ( ".$datos[0].",".$datos[1].",".$datos[2].",".$datos[3].",".$_POST['conceptos'][$e].",".$datos[4].",".$datos[5].",".$_ANO.");";
$regis = pg_Exec($conn->conectar(),$sql_insert) or die( "Error:".$sql_insert );

		   }

$sql_update = "UPDATE eva_relacion_evaluacion SET fecha_evaluacion = CURRENT_DATE
WHERE id_ano = ".$_ANO." AND rut_evaluado = ".$datos[5]." AND rut_evaluador = ".$datos[4].";";
$regis = pg_Exec($conn->conectar(),$sql_update) or die( "Error:".$sql_update );
echo 1;
?>
