<?php 
session_start();
require_once("../../../../../util/header.inc");
//show($_POST);

echo $cad = substr($alumno, 0, -1);
$cad = explode(",",$cad);
for($i=0;$i<count($cad);$i++){

$alumno = $cad[$i];
echo $sql="insert into cuenta_certificado(id_ano,id_curso,rut_alumno,id_reporte) values($ano,$curso,$alumno,$reporte)";
if($_PERFIL!=0){
$result= pg_exec($conn,$sql);
}
} 

?>