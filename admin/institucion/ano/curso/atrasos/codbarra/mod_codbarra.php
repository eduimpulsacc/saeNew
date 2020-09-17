<?php 

function getAsistencia($conn,$rut_alumno,$id_ano,$id_curso,$fecha){
echo $query = "select * from asistencia where rut_alumno =$rut_alumno and ano= $id_ano and id_curso=$id_curso and fecha='$fecha'";
}
?>