<? require('../../../../../util/header.inc');

echo "lleago";
exit;
$sql = "UPDATE ramo SET porc_examen WHERE id_ramo=";
$rs_ramo = @pg_exec($conn,$sql);

$sql ="SELECT id_ramo, id_curso FROM ramo WHERE id_ramo=";
$result = @pg_exec($conn,$sql);

$sql = "INSERT INTO examen_semestral (id_curso,id_ramo,nombre,porc,bool_ap) VALUES ()";
$rs_examen = @pg_exec($conn,$sql);






?>