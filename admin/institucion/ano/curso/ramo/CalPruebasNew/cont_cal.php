<?php 
require('../../../../../../util/header.inc');
include('mod_cal.php');

foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
   //echo "<br>".$asignacion;
   
} 


$obj_calendario = new Calendario($conn,$connection);

if($funcion==1){

$rs_cur = $obj_calendario->cursos($id_ano);
?>
<select name="select_Curso" id="select_cursos" onChange="carga_ramos(this.value)" >
      <option value="0">Seleccionar</option>
      <? for($c=0;$c<pg_numrows($rs_cur);$c++){    
	  $fila = pg_fetch_array($rs_cur,$c);
		  ?>
      <option value="<?php echo $fila['id_curso'] ?>"><?php echo CursoPalabra($fila['id_curso'],1,$conn) ?></option>
      <?php }?>
      </select>
<?
}

if($funcion==2){
$rs_ram = $obj_calendario->ramos($id_curso);
?>
<select name="select_Ramos" id="select_ramos" onChange="carga_pruebas(this.value)" >
      <option value="0">Seleccionar</option>
      <? for($r=0;$r<pg_numrows($rs_ram);$r++){    
	  $fila = pg_fetch_array($rs_ram,$r);
		  ?>
      <option value="<?php echo $fila['id_ramo'] ?>"><?php echo $fila['nombre'] ?></option>
      <?php }?>
      </select>
      <?
}

if($funcion==3){

$rs_ram = $obj_calendario->pruebas($id_curso,$id_ramo);
	?>
    
<?php if(pg_numrows($rs_ram)>0){?>
    <table width="650" border="1" cellspacing="0" cellpadding="0" align="center" style="border-collapse:collapse">
  <tr class="tableindex">
    <td colspan="8" align="center">Listado de Evaluaciones</td>
    </tr>
  <tr>
    <td colspan="8">&nbsp;</td>
    </tr>
  <tr class="tableindex">
    <td align="center">Fecha</td>
    <td align="center">Hora</td>
    <td align="center">Asignatura</td>
    <td align="center">Docente</td>
    <td align="center">Contenido</td>
    <td align="center">Archivo</td>
    <td align="center">Eliminar</td>
   
  </tr>
 <?php  for($r=0;$r<pg_numrows($rs_ram);$r++){
	 $filar = pg_fetch_array($rs_ram,$r);
	 ?>
  <tr>
    <td align="center"><?php echo CambioFD($filar['fecha_inicio']) ?></td>
    <td align="center"><?php echo $filar['hora'] ?></td>
    <td align="center"><?php echo $filar['asignatura'] ?></td>
    <td align="center"><?php echo $filar['profesor'] ?></td>
    <td align="center"><?php echo utf8_decode($filar['descripcion']) ?></td>
    <td align="center"><?php if($filar['archivo']!=""){?>
    <a href="files/<?php echo $filar['archivo'] ?>" target="_blank">
    <img src="../../../../../clases/img_jquery/iconos/Free_web_development_icons_by_kurumizawa/Colored/PNG/download.png" width="16" height="16"></a>
    <?php }?></td>
    
    <td align="center"><input type="button" name="button" id="button" value="Eliminar" onclick="quitaPrueba(<?php echo $filar['id_prueba'] ?>);" class="botonXX" /></td>
  </tr>
  <?php }?>
</table>
<?php }?>
    <?
}

if($funcion==4){

$ex = $obj_calendario->seaRc($ipd);
$fex = pg_fetch_array($ex,0);
$arc = $fex['archivo'];

if(strlen($arc)>0){
if (file_exists("files/$arc")){
	unlink("files/$arc");
	}
}
$del = $obj_calendario->delPrueba($ipd);
echo($del)?1:0;

 }
if($funcion==5){
$rs_ram = $obj_calendario->ramos($id_curso);
?>
<select name="select_RamosN" id="select_RamosN"  >
      <option value="0">Seleccionar</option>
      <? for($r=0;$r<pg_numrows($rs_ram);$r++){    
	  $fila = pg_fetch_array($rs_ram,$r);
		  ?>
      <option value="<?php echo $fila['id_ramo'] ?>"><?php echo $fila['nombre'] ?></option>
      <?php }?>
</select>
      <?
}

if($funcion==6){
echo "dkkddk";
}

?>