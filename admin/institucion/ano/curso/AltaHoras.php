<?php 
require('../../../../util/header.inc');


foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   }
   
   foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   } 
   
   if ($realizadas>$programadas)
   {
   ?>
   
   <script>
   alert("Horas No coinciden");
   window.open('InformeResumenHorasPlanificacionCurricular_C.php','_self');
   </script>
   <?
   
   }
   else
   {
   if ($tip==0)
   {
   $ins_hora="insert into res_hora_plancurri (rdb,id_curso,horas_programadas,horas_realizadas,horas_no_realizadas,mes,id_subsector) values($institucion2,$cmb_curso,$programadas,$realizadas,$norealizadas,$mes,$cmb_subsector)";
   @pg_exec($conn,$ins_hora);
   }
   else
   {
   $updte_hora="update res_hora_plancurri set horas_programadas=$programadas, horas_realizadas=$realizadas, horas_no_realizadas=$norealizadas where id_curso=$cmb_curso and id_subsector=$cmb_subsector and mes=$mes";
   @pg_exec($conn,$updte_hora);
   }
   ?>
   <script>
   alert("Proceso Efectuado Exitosamente");
   window.open('InformeResumenHorasPlanificacionCurricular_C.php','_self');
   </script>
  <?php  }?>