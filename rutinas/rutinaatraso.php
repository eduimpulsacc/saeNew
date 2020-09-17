<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
?>
<? 


//base de datos antigua
$conn=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");

$qry_fecha = "select * from  anotacion where rut_alumno = '$rut_alumno' and tipo = 2 and fecha <= '$fechaMax' and fecha >= '$fechaMin' and jornada=".$jornada; //Selecciono todos los dias del mes actual

?>
