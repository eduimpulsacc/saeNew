<?php require('../../../../../util/header.inc');
session_start();
require "mod_citacion.php";
$obj_citacion = new Citacion();

//echo $_NOMBREUSUARIO;

if($funcion==1){
	$rs_curso = $obj_citacion->curso($conn,$ano);
	
?>	&nbsp;
<select name="cmbCURSO" id="cmbCURSO" >
<option	value="0">TODOS LOS CURSOS</option>
    	
<? 		for($i=0;$i<pg_numrows($rs_curso);$i++){
			$fila = pg_fetch_array($rs_curso,$i);
?>
		<option value="<?=$fila['id_curso'];?>"><?=$fila['curso'];?></option>
        	
<?	
		}
?>
	</select>
<?
}




//var_dump($_POST);

if($funcion==12){
	$rs_asunto = $obj_citacion->asunto($conn,$rdb);
	
?>	&nbsp;<!--onchange="listado();"-->
<select name="cmbASUNTO" id="cmbASUNTO"  >
    	
<? 		for($i=0;$i<pg_numrows($rs_asunto);$i++){
			$fila = pg_fetch_array($rs_asunto,$i);
?>
		<option value="<?=$fila['id_asunto'];?>"><?=$fila['asunto'];?></option>
        	
<?	
		}
?>
	</select>
<?
}



?>