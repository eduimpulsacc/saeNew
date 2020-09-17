<?php 
session_start();
require('../../../../../../util/header.inc');

require "modInformeRamo.php";
$obj_inf = new InfRamo();

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
	$rs_subs = $obj_inf->subsector($conn,$ano);
?>
   <select name="cmbRamo" id="cmbRamo">
        <option value="0">seleccione...</option>
        <?php for($i=0;$i<pg_numrows($rs_subs);$i++){
			$fila = pg_fetch_array($rs_subs,$i);
			?>
          <option value="<?php echo $fila['cod_subsector'] ?>"><?php echo $fila['nombre'] ?></option>
          <?php }?>
      </select>
<?php }
?>