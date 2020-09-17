<?php require('../../../../../util/header.inc');

foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   }
   
   foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   } 
   
   
   //borro
   $sql_del="delete from calendario_actividades where id_actividad=".$id_actividad;
  $res_del=pg_exec($conn,$sql_del);
?>
<script>
alert ('Actividad Eliminada Exitosamente');
window.open('CalCurso.php?id_curso=<?php echo $id_curso ?>&subsector=<?php echo $subsector ?>&fecha_inicio2=<?php echo $fecha_inicio2 ?>&fecha_termino2=<?php echo $fecha_termino2 ?>&nuevo=1','_self');
</script>