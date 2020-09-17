<?
require("../../util/header.php");
require("mod_evaluacion.php");

$funcion = $_POST['funcion'];

$ob_evaluacion = new Evaluacion();
 

if($funcion==1){
$rs_curso = $ob_evaluacion->traeCursos($conn,$ano);
	//exit;
	
?>	<!--onchange="apoderado(this.value);"-->
<select name="sel_curso" id="sel_curso" onchange="traeRamo(this.value);" class="select_redondo" >
    	<option	value="0">seleccione...</option>
<? 		for($i=0;$i<pg_numrows($rs_curso);$i++){
			$fila = pg_fetch_array($rs_curso,$i);
?>
		<option value="<?=$fila['id_curso'];?>" ><?=$fila['curso'];?></option>
        	
<?	
		}
?>
	</select>
<?

	

}
if($funcion==2){
	$rs_ramo = $ob_evaluacion->traeRamo($conn,$curso);
	//exit;
	
?>	<!--onchange="apoderado(this.value);"-->
<select name="sel_ramo" id="sel_ramo"  class="select_redondo" onChange="cambia_unidad();">
    	<option	value="0">seleccione...</option>
<? 		for($i=0;$i<pg_numrows($rs_ramo);$i++){
			$fila = pg_fetch_array($rs_ramo,$i);
?>
		<option value="<?=$fila['id_ramo'];?>" ><?=$fila['nombre'];?></option>
        	
<?	
		}
?>
	</select>
<?
}



if($funcion==4){
$rs_ramo =$ob_evaluacion->traeRamoUno($conn,$ramo);
$fila_ramo = pg_fetch_array($rs_ramo,0);
$cod_ramo=$fila_ramo['cod_subsector'];
echo $cod_ramo;
}
if($funcion==5){
	$rs_unidad = $ob_evaluacion->Unidad($conn,$ano,$curso,$ramo);
?>
<select name="cmbUNIDAD" id="cmbUNIDAD" onchange="cambia_clase();" class="select_redondo">
	<option value="0">seleccione...</option>
<? for($i=0;$i<pg_numrows($rs_unidad);$i++){
		$fila=pg_fetch_array($rs_unidad,$i);
?>
	<option value="<?=$fila['id_unidad'];?>"><?=$fila['nombre'];?></option>
<? } ?>
</select>
	
<?	
}

if($funcion==6){
	$rs_clase = $ob_evaluacion->Clase($conn,$ano,$curso,$unidad,$ramo);
?>
<select name="cmbCLASE" id="cmbCLASE"  class="select_redondo">
	<option value="0">seleccione...</option>
<? for($i=0;$i<pg_numrows($rs_clase);$i++){
		$fila=pg_fetch_array($rs_clase,$i);
?>
	<option value="<?=$fila['id_clase'];?>"><?=$fila['nombre'];?></option>
<? } ?>
</select>
<?
}
if($funcion==7){
	$rs_eva = $ob_evaluacion->traeEvaluaciones($conn,$unidad,$clase);
	
	?>
<table width="700" border="0" align="center" cellspacing="0">
  
  <?php if(pg_numrows($rs_eva)>0){?>
  <tr>
    <td align="center" class="cuadro02 tablaredonda">NOMBRE</td>
    <td align="center" class="cuadro02 tablaredonda">ESTADO</td>
    <td align="center" class="cuadro02 tablaredonda">FECHA CREACION</td>
    <td align="center" class="cuadro02 tablaredonda"> FECHA MODIFICACION</td>
    <td colspan="6" align="center" class="cuadro02 tablaredonda">ACCIONES</td>
  </tr>
 <?php  for($i=0;$i<pg_numrows($rs_eva);$i++){
	 $fila = pg_fetch_array($rs_eva,$i);
	 
	 $clase = ($i%2==0)?"detalleoff":"detalleon";
	 
	 ?>
  <tr class="<?php echo $clase ?>">
    <td><?php echo $fila['nombre'] ?></td>
    <td>&nbsp;</td>
    <td><?php echo CambioFD($fila['fecha_creacion']) ?></td>
    <td><?php echo CambioFD($fila['fecha_modificacion']) ?></td>
    <td align="center"><input type="submit" name="b1" id="b1" value="V" title="Detalle Evaluaci&oacute;n" class="botonXX" onclick="detalle(<?php echo $fila['id_evaluacion'] ?>)" /></td>
    <td align="center"><input type="submit" name="b2" id="b2" value="M" title="Modificar Evaluaci&oacute;n" class="botonXX" /></td>
    <td align="center"><input type="submit" name="b3" id="b3" value="A" title="Asociar Archivos" class="botonXX"/></td>
    <td align="center"><input type="submit" name="b4" id="b4" value="E" title="Modificar Estado" class="botonXX"/></td>
    <td align="center"><input type="submit" name="b5" id="b5" value="N" title="Asociar Notas" class="botonXX"/></td>
    <td align="center"><input type="submit" name="b6" id="b6" value="X" title="Elimiar Evaluaci&oacute;n" class="botonXX"/></td>
    <?php }?>
  </tr>
 <?php  }else{?>
  <tr>
    <td colspan="10" align="center" class="textosimple">SIN INFORMACI&Oacute;N</td>
  </tr>
  <?php }?>
</table>
<?
}if($funcion==8){
?>

<input name="id_unidad" type="hidden" value="<?php echo $unidad ?>" />
<input name="id_clase" type="hidden" value="<?php echo $clase?>" />
<table width="700" border="0" align="center" cellspacing="3">
<tr><td width="94" class="cuadro02">Nombre</td><td width="602"><input name="nombre" type="text" id="nombre" size="50" /></td></tr>
<tr><td class="cuadro02">Descripci&oacute;n</td><td><textarea name="descripcion" cols="50" rows="5" id="descripcion"></textarea></td></tr>
</table>
<?
}if($funcion==9){
//var_dump($_POST);
$rs_guardaEva = $ob_evaluacion->guardaEvaluacion($conn,$unidad,$clase,$nombre,$descripcion);
echo ($rs_guardaEva)?1:0;

}if($funcion==10){

?>
<?	
}
?>