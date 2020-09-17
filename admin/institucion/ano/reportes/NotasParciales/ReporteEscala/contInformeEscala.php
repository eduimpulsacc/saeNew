<?php 
session_start();
require('../../../../../../util/header.inc');

require "modInformeEscala.php";
$obj_inf = new InfEscala();

$funcion = $_POST['funcion'];

if($funcion==1){
//var_dump($_POST);

$rs_periodo = $obj_inf->periodo($conn,$ano);
?>
  <select name="cmbPeriodo" id="cmbPeriodo">
        <option value="0">seleccione...</option>
        <?php for($i=0;$i<pg_numrows($rs_periodo);$i++){
			$fila = pg_fetch_array($rs_periodo,$i);
			?>
          <option value="<?php echo $fila['id_periodo'] ?>"><?php echo $fila['nombre_periodo'] ?></option>
          <?php }?>
      </select>
<?
}if($funcion==2){ 
	$rs_ense = $obj_inf->ensenanza($conn,$ano);
?>
   <select name="cmbEnse" id="cmbEnse">
        <option value="0">seleccione...</option>
        <?php for($i=0;$i<pg_numrows($rs_ense);$i++){
			$fila = pg_fetch_array($rs_ense,$i);
			?>
          <option value="<?php echo $fila['cod_tipo'] ?>"><?php echo $fila['nombre_tipo'] ?></option>
          <?php }?>
      </select>
<?php }
if($funcion==3){ 
	$rs_escala = $obj_inf->escala($conn,$ano,$rdb);
?>
   <select name="cmbEscala" id="cmbEscala">
        <option value="0">seleccione...</option>
        <?php for($i=0;$i<pg_numrows($rs_escala);$i++){
			$fila = pg_fetch_array($rs_escala,$i);
			?>
          <option value="<?php echo $fila['id'] ?>"><?php echo $fila['nombre_concepto'] ?></option>
          <?php }?>
      </select>
<?php }?>