<? 
require("../../../util/header.php");
require("mod_motor.php");

$funcion = $_POST['funcion'];

$ob_motor = new Motor();

if($funcion==1){
	$rs_curso = $ob_motor->Curso($conn,$ano);
?>
<select name="cmbCURSO" id="cmbCURSO" onChange="cambia_ramo();" class="select_redondo">
	<option value="0">seleccione...</option>
<? for($i=0;$i<pg_numrows($rs_curso);$i++){
		$fila = pg_fetch_array($rs_curso,$i);
?>	 
	<option value="<?=$fila['id_curso'];?>"><?=CursoPalabra($fila['id_curso'], 1, $conn);?></option>
<?   
 }
 ?>
 </select>

<?		
}

if($funcion==2){
	var_dump($_POST);
	$rs_ramo = $ob_motor->RamoUno($conn,$ano,$curso,$codramo);
?>
<select name="cmbRAMO" id="cmbRAMO" onChange="cambia_unidad();" class="select_redondo"	>
	<option value="0">seleccione...</option>
<? for($i=0;$i<pg_numrows($rs_ramo);$i++){
		$fila = pg_fetch_array($rs_ramo,$i);
?>
	<option value="<?=$fila['id_ramo'];?>"><?=$fila['nombre'];?></option>
<? } ?>
</select>
<?
}

if($funcion==3){
	
	$rs_unidad = $ob_motor->Unidad($conn,$ano,$curso,$ramo);
?>
<select name="cmbUNIDAD[<?php echo $curso ?>][]" id="cmbUNIDAD<?php echo $curso ?>" onchange="cambia_clase(<?php echo pg_result($rs_unidad,0)?>,<?php echo $curso ?>); cargadata(<?php echo $curso ?>)" class="select_redondo">
	<option value="0">seleccione...</option>
<? for($i=0;$i<pg_numrows($rs_unidad);$i++){
		$fila=pg_fetch_array($rs_unidad,$i);
?>
	<option value="<?=$fila['id_unidad'];?>"><?=$fila['nombre'];?></option>
<? } ?>
</select>
	
<?	
}

if($funcion==4){
	$rs_clase = $ob_motor->Clase($conn,$ano,$curso,$unidad,$ramo);
?>
<select name="cmbCLASE[<?php echo $unidad ?>][]" id="cmbCLASE<?php echo $curso ?>" onchange="cargadata(<?php echo $curso ?>)"  class="select_redondo">
	<option value="0">TODAS.</option>
<? for($i=0;$i<pg_numrows($rs_clase);$i++){
		$fila=pg_fetch_array($rs_clase,$i);
?>
	<option value="<?=$fila['id_clase'];?>"><?=$fila['nombre'];?></option>
<? } ?>
</select>
	
<?	
}if($funcion==5){
	$rs_periodo = $ob_motor->Periodo($conn,$ano);
?>
<select name="cmbPERIODO" id="cmbPERIODO" class="select_redondo" >
	<option value="0">Seleccione.</option>
<? for($i=0;$i<pg_numrows($rs_periodo);$i++){
		$fila=pg_fetch_array($rs_periodo,$i);
?>
	<option value="<?=$fila['id_periodo'];?>"><?=$fila['nombre_periodo'];?></option>
<? } ?>
</select>
	
<?	}
if($funcion==6){
//var_dump($_POST);
$rs_grados = $ob_motor->Grados($conn,$ano);?>
<select name="cmbGRADOS" id="cmbGRADOS" onchange="ramogrado();" class="select_redondo" >
	<option value="0">Seleccione.</option>
<? for($i=0;$i<pg_numrows($rs_grados);$i++){
		$fila=pg_fetch_array($rs_grados,$i);
?>
	<option value="<?=$fila['ensenanza']."_".$fila['grado_curso'];?>">GRADO <?=$fila['grado_curso']." - ".$fila['nombre_tipo'];?></option>
<? } ?>
</select>
<?
}if($funcion==7){
	 $rs_cursos = $ob_motor->cursoGrado($conn,$ano,$grado,$ense);
	 
	 for($c=0;$c<pg_numrows($rs_cursos);$c++){
		 $fila= pg_fetch_array($rs_cursos,$c);
	?>
<script>
    $( document ).ready(function() {
   ramocur(<?php echo$fila['id_curso'] ?>);
});
    </script>
    
    <table width="100%" border="0" >
  <tr>
    <td width="10%" class="textonegrita">CURSO</td>
    <td width="1%" align="center"><strong>:</strong></td>
    <td width="89%" class="textosimple"><?=CursoPalabra($fila['id_curso'], 1, $conn);?>
    <input type="hidden" name="curso[]" id="curso<?php echo $fila['id_curso'] ?>" value="<?php echo trim($fila['id_curso']) ?>"  /><input name="idramo[<?php echo $fila['id_curso'] ?>]" type="hidden" id="idramo<?php echo $fila['id_curso'] ?>" size="50" /></td>
  </tr>
  <tr>
    <td class="textonegrita">UNIDAD</td>
    <td align="center"><strong>:</strong></td>
    <td class="textosimple"> <div id="unidad<?php echo $fila['id_curso'] ?>">
        <select name="cmbUNIDAD" id="cmbUNIDAD" class="select_redondo">
            <option value="0">seleccione...</option>
        </select>
    </div></td>
  </tr>
  <tr>
    <td class="textonegrita">CLASE</td>
    <td align="center"><strong>:</strong></td>
    <td class="textosimple"><div id="clase<?php echo $fila['id_curso'] ?>">
    <select name="cmbCLASE[]" id="cmbCLASE" class="select_redondo">
        <option value="0">seleccione...</option>
    </select>
    </div></td>
  </tr>
  <tr>
    <td colspan="3"><div id="dataclase<?php echo $fila['id_curso'] ?>"></div></td>
    </tr>
</table><br />


    <?
	}
	 
?>
<?php }?>
<? if($funcion==9){
//var_dump($_POST);
$rs_ramo =$ob_motor->ramoGrado($conn,$ano,$ense,$grado)
?>

<select name="cmbRAMO" id="cmbRAMO" onchange="cursogrado();"   class="select_redondo" >
	<option value="0">Seleccione.</option>
<? for($i=0;$i<pg_numrows($rs_ramo);$i++){
		$fila=pg_fetch_array($rs_ramo,$i);
?>
	<option value="<?=$fila['cod_subsector'];?>"> <?=$fila['nombre'];?></option>
<? } ?>
</select>
<?php }?>
<?php if($funcion==10){
//var_dump($_POST);
$rs_ramo =$ob_motor->RamoUno($conn,$cur,$codramo);
echo trim(pg_result($rs_ramo,2));
	}?>
