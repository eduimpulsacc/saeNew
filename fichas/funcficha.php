<?
require('../util/header.inc');
foreach($_REQUEST as $nombre_campo => $valor)
{ 
 $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
 eval($asignacion);
 //echo "asignacion=$asignacion<br>";
} 
if($funcion==1){
    $fecha = CambioFE($fecha);
    $sql_ram="select p.*,s.nombre as asignatura,e.nombre_emp||' '||e.ape_pat as profesor
    from cal_pruebas_new p inner join ramo r on r.id_ramo = p.id_ramo 
    inner join subsector s on s.cod_subsector = r.cod_subsector
    inner join dicta d on d.id_ramo = r.id_ramo
    inner join empleado e on e.rut_emp = d.rut_emp 
    where r.id_curso = $_CURSO and  p.fecha_inicio>='$fecha' order by fecha_inicio asc";
    $rs_ram = pg_exec($conn, $sql_ram);
    ?>
    <table width="650" border="1" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse">
  
  <tr class="tableindex">
    <td align="center">Fecha</td>
    <td align="center">Hora</td>
    <td align="center">Asignatura</td>
    <td align="center">Docente</td>
    <td align="center">Contenido</td>
    <td align="center">Archivo</td>
    </tr>
 <?php  for($r=0;$r<pg_numrows($rs_ram);$r++){
	 $filar = pg_fetch_array($rs_ram,$r);
	 ?>
  <tr style="font-size:12px">
    <td align="center"><?php echo CambioFD($filar['fecha_inicio']) ?></td>
    <td align="center"><?php echo $filar['hora'] ?></td>
    <td align="center"><?php echo $filar['asignatura'] ?></td>
    <td align="center"><?php echo $filar['profesor'] ?></td>
    <td align="center"><?php echo utf8_decode($filar['descripcion']) ?></td>
    <td align="center">
    <?php if($filar['archivo']!=""){?>
    <a href="../admin/institucion/ano/curso/ramo/CalPruebasNew/files/<?php echo $filar['archivo'] ?>" target="_blank">
    <img src="../admin/clases/img_jquery/iconos/Free_web_development_icons_by_kurumizawa/Colored/PNG/download.png" width="16" height="16"></a>
    <?php }?></td>
    </tr>
  <?php }?>
</table>
    <?
}
?>