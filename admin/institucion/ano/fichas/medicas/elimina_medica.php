<?php require('../../../../../util/header.inc');?>

<?

$id_ficha=$id_ficha;
$alumno=$alumno;
$caso=$caso;


if($tipoficha==1){
$qry="DELETE FROM FICHA_MEDICANEW WHERE ID_FICHA='$id_ficha'";
}
elseif($tipoficha==2){
$qry="DELETE FROM ficha_medicanew3 WHERE id_fichamedica=$id_ficha";
}
//echo $qry;
$result =@pg_Exec($conn,$qry);

echo "<script>window.location = 'listarFichasAlumno.php3?alumno=$alumno&id_curso=$id_curso' </script>";


?>