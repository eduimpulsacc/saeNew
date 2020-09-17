<?php 
require('../../../../../../util/header.inc');
require "mod_asigdocente.php";

//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$obj_asig = new Asig($conn);

$funcion = $_POST['funcion'];

if($funcion==1 && $doc!=0){
	$rs = $obj_asig->subs($conn,$_ANO,$doc);
	
?>
<select name="cmb_ramo" id="cmb_ramo">

      <option value="0">(TODAS LAS ASIGNATURAS)</option>
      <?php for($i=0;$i<pg_numrows($rs);$i++){
		  $fila = pg_fetch_array($rs,$i);?>
      <option value="<?php echo $fila['cod_subsector'] ?>"><?php echo $fila['nombre'] ?></option>
      <?php }?>
      </select>
<?
}

?>