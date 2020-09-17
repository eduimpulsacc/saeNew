<?
session_start();
require "mod_evaluaciones.php";
$obj_Evaluaciones = new Evaluaciones($_IPDB,$_ID_BASE);

$funcion = $_POST['funcion'];

if($funcion==1){
	$rs_cargo = $obj_Evaluaciones->cargos();
	$rs_empleado = $obj_Evaluaciones->empleado($id_cargo,$rdb,$ano,$periodo);

?>
<table width="90%" border="0" align="center">
  <tr>
    <td class="textonegrita">&nbsp;CARGOS</td>
    <td>&nbsp;</td>
    <td class="textosimple">&nbsp;
    <select name="cmbCARGO" id="cmbCARGO" onchange="cargartabla()">
    	<option value="0">seleccione...</option>
        <option value="101">Apoderado</option>
        <option value="100">Alumno</option>
      <? 
	  	for($i=0;$i<pg_numrows($rs_cargo);$i++){
			$fila_c =pg_fetch_array($rs_cargo,$i);
			if($id_cargo==$fila_c['id_cargo']){
	  ?>
	      <option value="<?=$fila_c['id_cargo'];?>" selected="selected"><?=$fila_c['nombre_cargo'];?></option>
          
      <? }else{ ?>
		 <option value="<?=$fila_c['id_cargo'];?>"><?=$fila_c['nombre_cargo'];?></option> 
	  <? 		}
		}?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;EMPLEADOS</td>
    <td>&nbsp;</td>
    <td class="textosimple">&nbsp;
    <select name="cmbEMPLEADO" id="cmbEMPLEADO" onchange="Listado();">
    	<option value="0">seleccione...</option>
      <? 
	  	for($i=0;$i<pg_numrows($rs_empleado);$i++){
			$fila_e =pg_fetch_array($rs_empleado,$i);
	  ?>
      <option value="<?=$fila_e['rut_emp'];?>"><?=$fila_e['nombre'];?></option>
      <? } ?>
      </select>
    
    </td>
  </tr>
</table>

<?	
}

if($funcion==2){
	$rs_relacion = $obj_Evaluaciones->relaciones($ano,$periodo,$rut);
?>
<table width="90%" border="0" align="center">
  <tr>
    <td align="center" class="tableindex">&nbsp;LISTADO DE EVALUACIONES REALIZADAS</td>
  </tr>
</table><br />
<table width="90%" border="1" align="center" style="border-collapse:collapse">
  <tr class="tabla01">
    <td width="50%">&nbsp;EMPLEADO</td>
    <td width="25%">&nbsp;FECHA</td>
    <td width="25%">&nbsp;ELIMINAR</td>
  </tr>
  
 <? for($i=0;$i<pg_numrows($rs_relacion);$i++){
	 	$fila = pg_fetch_array($rs_relacion,$i);
?>
		
	 
  <tr>
    <td>&nbsp;<?=$fila['nombre'];?></td>
    <td align="center">&nbsp;<?=$fila['fecha_evaluacion'];?></td>
    <td align="center">&nbsp;<a href="#"><img src="img/PNG-48/Delete.png" width="25" height="25" onclick="elimina(<?=$fila['rut_evaluado'];?>)" /></a></td>
  </tr>
 <? } ?>
</table>


<?		
}

if($funcion==3){
	$rs_elimina =$obj_Evaluaciones->Elimina($ano,$periodo,$rut,$rut_evaluado);
	
	if($rs_elimina){
		echo 1;
	}else{
		echo 0;	
	}
		
	
}
 
?>
