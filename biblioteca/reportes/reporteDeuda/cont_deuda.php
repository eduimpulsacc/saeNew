<?php
 require("../../../util/header.php");
 
//show($_POST);
  $sql = "select a.rut_alumno rut, a.ape_pat||' '||a.ape_mat||' '||a.nombre_alu  nombre
from alumno a
inner join matricula m on m.rut_alumno = a.rut_alumno
where m.id_curso = $tipo and m.bool_ar=0
order by nombre";
	$result = pg_exec($conn,$sql);
	?>
	 <select name="cmb_usuario" id="cmb_usuario">
            <option value="0">Seleccione</option>
            <?php  for($e=0;$e<pg_numrows($result);$e++){
$fila_e = pg_fetch_array($result,$e); ?>
<option value="<?php echo $fila_e['rut'] ?> "><?php echo strtoupper($fila_e['nombre']) ?> </option>
<?
 }
?>
    </select>
	