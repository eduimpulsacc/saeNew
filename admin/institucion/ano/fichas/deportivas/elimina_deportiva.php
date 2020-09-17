<?php require('../../../../../util/header.inc');?>

<?

$id_ficha=$id_ficha;
$alumno=$alumno;
$caso=$caso;



$qry="DELETE FROM ficha_deportivanew WHERE RUT_ALUMNO='".trim($alumno)."' and id_ficha=".$id_ficha;
$result =@pg_Exec($conn,$qry);

echo "<script>window.location = 'lista_fichadeportiva.php?alumno=$alumno&id_curso=$_CURSO' </script>";


?>