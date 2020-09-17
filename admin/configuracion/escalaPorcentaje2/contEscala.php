
<?
require('../../../util/header.inc');
require('modEscala.php');

$ob_grupo = new Escala();


foreach($_POST as $nombre_campo => $valor){
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion);
}

if($funcion==1){
	$rs_ense= $ob_grupo->getEnsenanza($conn,$ano);
	$nano =  $ob_grupo->nroAno($conn,$ano);
	?>
    <select name="ense" id="ense"  onChange="getNivel(this.value);">
    <option value="0">(TODOS LOS TIPOS DE ENE&Ntilde;ANZA)</option>
    <?php for($e=0;$e<pg_numrows($rs_ense);$e++){
		$fila_ense = pg_fetch_array($rs_ense,$e);
		?>
    <option value="<?php echo $fila_ense['ensenanza'] ?>"><?php echo $fila_ense['nombre_tipo'] ?></option>
    <?php }?>
</select>
    <?
}

if($funcion==2){
?>
<input type="button" value="Ver Grupos" class="botonXX" onclick="muestraCreaGrupo();">
<?
}
if($funcion==3){
	
	
	$rs_listado=$ob_grupo->tablaGrupo($conn,$_INSTIT,$_ANO,$ensenanza,$nivel,$subsector,$periodo);
	 $maxMax =  $ob_grupo->getMaxMaximo($conn,$_ANO,$ensenanza);
	 $maximoAnt = intval(pg_result($maxMax,0));
	?>
   
<table width="98%" border="1" id="conte" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

  <tr class="tablatit2-1">
   
    <td width="28%" height="42" align="center" valign="middle">Concepto</td>
    <td width="28%" align="center" valign="middle">Descripci&oacute;n</td>
    <td width="12%" align="center" valign="middle">% M&iacute;mino</td>
    <td width="14%" align="center" valign="middle">% M&aacute;ximo</td>
    <td width="14%" align="center" valign="middle">Orden</td>
    <td width="16%" align="center" valign="middle">Acciones</td>
  </tr><?php  if(pg_numrows($rs_listado)>0){?>
 <?php  for($l=0;$l<pg_numrows($rs_listado);$l++){
	 $cas="";
	 $fila = pg_fetch_array($rs_listado,$l);
	
	 ?>
  <tr id="fila<?php echo $fila['id'] ?>" class="textosimple">
   
    <td height="33"><?php echo $fila['concepto'] ?></td>
    <td align="center"><?php echo $fila['descripcion'] ?></td>
    <td align="center"><?php echo $fila['minimo'] ?> </td>
    <td><?php echo $fila['maximo'] ?></td>
    <td align="center"><?php echo $fila['orden'] ?></td>
    <td align="center"><input type="button" name="button" id="button" class="botonXX btne" value="Editar" onclick="edifila(<?php echo $fila['id'] ?>)" /> <input type="button" name="button" id="button" class="botonXX btne" value="Eliminar" onclick="elifila(<?php echo $fila['id'] ?>)" /></td>
  </tr>

  <?php }?>
  <?php }?> 
  
</table>
<br />
<br />
 <?php if($maximoAnt<100){?>
<input name="input" type="button" value="Crear Escala de Porcentaje" onclick="ngr(<?php echo $curso ?>)" class="botonXX" /><br />
 <?php }?>
 <? }
if($funcion==4){
	 
	 $maxorden =  $ob_grupo->getOrdenGrupo($conn,$ano,$ensenanza,$nivel,$subsector,$periodo);
	$maxMax =  $ob_grupo->getMaxMaximo($conn,$ano,$ensenanza,$nivel,$subsector,$periodo);
	 $maximoAnt = intval(pg_result($maxMax,0));
	  $valmin=($maximoAnt>0)?($maximoAnt+1):$maximoAnt;
	 ?>
      
     
<tr class="textosimple">
  
    <td height="33"><input name="txtLECCIONARIO" type="text" id="txtLECCIONARIO" size="50"  /></td>
    <td height="33"><input name="txtDESCRIPCION" type="text" id="txtDESCRIPCION" size="50"  /></td>
    <td height="3" align="center"><input name="minimo" type="text" class="prco solo-numero" id="minimo" onchange="compPrc(this.value)" value="<?php echo $valmin ?>" size="3" maxlength="3" /></td>
    <td><input name="maximo" type="text" id="maximo" size="3" class="prco solo-numero" onchange="compPrc(this.value)" maxlength="3" /></td>
    <td align="center"><input name="orden" type="text" id="orden" value="<?php echo (pg_result($maxorden,0)+1) ?>" size="2" class="solo-numero" /></td>
    <td><input type="hidden" name="maxAnt" id="maxAnt" value="<?php echo $maximoAnt ?>" /><input type="button" value="Guardar" class="botonXX" onclick="guardaGrupo();" />&nbsp;<input type="button" name="button" id="button" value="Cancelar" class="botonXX" onclick="muestraCreaGrupo();" /></td>
</tr>
 <?
	 }
if($funcion==5){
	
	
	$rs_guarda=$ob_grupo->guardaGrupo($conn,$_INSTIT,$_ANO,$minimo,$maximo,utf8_decode($leccionario),$ensenanza,$orden,$nivel,$subsector,$periodo,utf8_decode($descripcion));
echo ($rs_guarda)?1:0;

}
if($funcion==8){
	//show($_POST);
$rs_fila = $ob_grupo->tablaGrupoDet($conn,$grupo);
	$fila = pg_fetch_array($rs_fila,0);
	
	$maxMax =  $ob_grupo->getMaxMaximo($conn,$_ANO,$fila['ensenanza']);
	 $maximoAnt = intval(pg_result($maxMax,0));
	 
	?>
	<td height="33"><input name="txtLECCIONARIO" type="text" id="txtLECCIONARIO"  value="<?php echo $fila['concepto']; ?>" size="50"/></td>
    <td height="33"><input name="txtDESCRIPCION" type="text" id="txtDESCRIPCION"  value="<?php echo $fila['descripcion']; ?>" size="50"/></td>
  <td height="3" align="center"><input name="minimo" type="text" class="prco solo-numero" id="minimo" value="<?php echo $fila['minimo'] ?>" size="3" maxlength="3" onchange="compPrc(this.value)" /></td>
<td class="textosimple"><input name="maximo" type="text" class="prco solo-numero" id="maximo" value="<?php echo $fila['maximo'] ?>" size="3" maxlength="3" onchange="compPrc(this.value)" /></td>
   <td align="center"><input name="orden" type="text" id="orden" value="<?php echo $fila['orden'] ?>" size="2" class="solo-numero" /></td>
  <td><input name="idg" type="hidden" id="idg" value="<?php echo $fila['id'] ?>" />
   <input type="hidden" name="maxAnt" id="maxAnt" value="<?php echo $maximoAnt ?>" />
    <input name="" type="button" value="Guardar" class="botonXX" onclick="guardaGrupoEdi();" />&nbsp;<input type="button" name="button" id="button" value="Cancela Edici&oacute;n" class="botonXX" onclick="muestraCreaGrupo();" /></td>
<? }
if($funcion==9){

$rs_guarda=$ob_grupo->actualizaGrupo($conn,$grupo,$minimo,$maximo,utf8_decode($leccionario),$orden,utf8_decode($descripcion));
echo ($rs_guarda)?1:0;
}
if($funcion==10){
$rs_eli=$ob_grupo->borraGrupo($conn,$grupo);
echo ($rs_eli)?1:0;
}
if($funcion==12){

$rs_periodo = $ob_grupo->getPeriodos($conn,$_ANO);
?>
<select id="periodo" name="periodo">
<option value="0">(ANUAL)</option>
<? for($p=0;$p<pg_numrows($rs_periodo);$p++){
	$fila_periodo = pg_fetch_array($rs_periodo,$p);
	?>
<option value="<?php echo $fila_periodo['id_periodo'] ?>"><?php echo $fila_periodo['nombre_periodo'] ?></option>
<?php }?>
</select>
<?

}
if($funcion==13){
	$rs_nivel= $ob_grupo->getNivel($conn,$ano,$ensenanza);
	?>
    <select name="nivel" id="nivel" onChange="getAsig(this.value);">
    <option value="0">(TODOS LOS NIVELES)</option>
    <?php for($e=0;$e<pg_numrows($rs_nivel);$e++){
		$fila_nivel = pg_fetch_array($rs_nivel,$e);
		?>
    <option value="<?php echo $fila_nivel['grado_curso'] ?>"><?php echo $fila_nivel['grado_curso'] ?>&deg; A&Ntilde;O</option>
    <?php }?>
    </select>
    <?
}
if($funcion==14){
	
    $rs_asig= $ob_grupo->getAsignatura($conn,$ano,$ensenanza,$nivel);
	?>
    <select name="asignatura" id="asignatura" >
    <option value="0">(TODAS LAS ASIGNATURAS)</option>
    <?php for($e=0;$e<pg_numrows($rs_asig);$e++){
		$fila_asig = pg_fetch_array($rs_asig,$e);
		?>
    <option value="<?php echo $fila_asig['cod_subsector'] ?>"><?php echo $fila_asig['nombre'] ?></option>
    <?php }?>
    </select>
    <?
} ?>