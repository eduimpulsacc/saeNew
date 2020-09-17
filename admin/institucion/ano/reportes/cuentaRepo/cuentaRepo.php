<?php 
session_start();
require_once("../../../../../util/header.inc");
//show($_POST);


 $sql="insert into cuenta_certificado(id_ano,id_curso,rut_alumno,id_reporte) values($ano,$curso,$alumno,$reporte)";
 if($_PERFIL!=0){
$result= pg_exec($conn,$sql);
 }


?>