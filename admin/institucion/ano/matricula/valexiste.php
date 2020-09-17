<?php  
require('../../../../util/header.inc'); 

foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
   //echo "asignacion=".$asignacion."<br>";
}

 $sql_al="select * from matricula where rut_alumno=$rut_alumno and id_curso=$curso and id_ano=$anio and bool_ar=0";
 $rs_dt_alumno = pg_exec($conn,$sql_al)or die("fallo");
 if(pg_numrows($rs_dt_alumno)>0){
echo 1;
}else echo 0;
?>
