<?php require('../../../../../util/header.inc');?>
<? 
$institucion	=$_INSTIT;
$frmModo		=$_FRMMODO;
$ano			=$_ANO;
$curso			=$_CURSO; 
$_POSP          =5;

$sql_borra1 = "delete from promocion where id_ano = '$ano' and id_curso = '$curso'";
//$sql_borra1 = "UPDATE promocion SET promedio=NULL, asistencia=NULL, fecha_prom=NULL, hora_prom=NULL WHERE id_curso = '$curso'";
$res_borra1 = @pg_Exec($conn, $sql_borra1);

$sql_borra2 = "delete from promedio_sub_alumno where id_curso = '$curso'";
$res_borra2 = @pg_Exec($conn, $sql_borra2);

?>
<script>alert('La promoción de este curso ha sido eliminada. Ahora debe procesar y guardar nuevamente la promoción');</script>

<script>window.location='promocion_pro.php'</script>



