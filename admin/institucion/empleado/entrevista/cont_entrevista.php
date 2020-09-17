<?php 
session_start();
include_once('mod_entrevista.php');

$obj_entr = new Entrevista($conn);

$funcion= $_POST['funcion'];

if($funcion==1){
//var_dump($_POST);	
$rs_ano = $obj_entr->traeAno($rdb);
?>
<select name="cmbAno" id="cmbAno" onchange="buscarEntrevista()">
<option value="0">seleccione...</option>
<?php for($i=0;$i<pg_numrows($rs_ano);$i++){
	$fila = pg_fetch_array($rs_ano,$i);
	?>
 <option value="<?php echo $fila['id_ano'] ?>"><?php echo $fila['nro_ano'] ?></option>
 <?php }?>
</select>
<?
}if($funcion==2){
	//var_dump($_POST);
$rs_docente = $obj_entr->traeDocente($rdb);
?>
<select name="cmbEntrevistado" id="cmbEntrevistado" onchange="buscarEntrevista()">
<option value="0">seleccione...</option>
<?php for($i=0;$i<pg_numrows($rs_docente);$i++){
	$fila = pg_fetch_array($rs_docente,$i);
	?>
 <option value="<?php echo $fila['rut_emp'] ?>" style="text-transform:uppercase"><?php echo $fila['nombre_emp'] ?> <?php echo $fila['ape_pat'] ?> <?php echo $fila['ape_mat'] ?></option>
 <?php }?>
</select>
<?
}
if($funcion==3){
	$rs_entre = $obj_entr->traeEntrevista($ano,$rut);
?>
<table width="100%" border="0" cellspacing="0">
 <tr>
    <td colspan="6" align="right"><input type="button" name="button" id="button" value="Agregar" class="botonXX" onclick="agrega()" /></td>
  </tr>
  <tr>
    <td colspan="6" align="center" class="tableindex">Lista entrevistas</td>
  </tr>
 
  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr class="tableindex">
    <td width="1%">#</td>
    <td width="10%" align="center">Fecha</td>
    <td width="34%" align="center">Entrevistador</td>
    <td width="34%" align="center">Asunto</td>
    <td width="11%" align="center">Editar</td>
    <td width="10%" align="center">Eliminar</td>
  </tr>
  <?php if(pg_numrows($rs_entre)>0){
	  for($i=0;$i<pg_numrows($rs_entre);$i++){
		  $fila = pg_fetch_array($rs_entre,$i);
		  
		  $rs_entrevistador = $obj_entr->traeEmpleado($fila['entrevistador']);
		  $entrevistador = pg_result($rs_entrevistador,2)." ".pg_result($rs_entrevistador,3)." ".pg_result($rs_entrevistador,4);
		  
		  $rs_asunto = $obj_entr->traeAsuntoDetalle($fila['asunto']);
		  $asunto = pg_result($rs_asunto,1);
	  ?>
   <tr class="textosimple">
    <td width="1%"><?php echo ($i+1) ?></td>
    <td width="10%"> <?php echo CambioFD($fila['fecha']) ?></td>
    <td width="34%" align="center"><?php echo $entrevistador ?> </td>
    <td width="34%" align="center"><?php echo $asunto ?></td>
    <td width="11%" align="center"><input type="submit" name="button2" id="button2" value="Editar" class="botonXX" onclick="traeEntrevista(<?php echo $fila['id_entrevista'] ?>)"/></td>
    <td width="10%" align="center"><input type="submit" name="button3" id="button3" value="Eliminar" onclick="elimina(<?php echo $fila['id_entrevista'] ?>)" class="botonXX"/></td>
  </tr>
  <?php 
	  }//fin for entrevistas
  }else{?>
  
  <tr class="textosimple">
    <td colspan="6" align="center">Sin informaci&oacute;n</td>
  </tr>
  <?
  }
  ?>
</table>

<?
}if($funcion==4){
	$rs_entrevistador = $obj_entr->traeDirectivo($rdb);
	$rs_asunto = $obj_entr->traeAsunto($rdb);
?>
<script>
$( document ).ready(function() {
   $( "#fecha" ).datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			/*minDate: new Date('01/01/'+anio+''),
			maxDate: new Date('12/31/'+anio+''),*/
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});
});
</script>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td colspan="2" align="right" class="textonegrita"><input type="submit" name="button4" id="button4" value="Guardar" class="botonXX" onclick="guardaNuevo()" />
    <input type="submit" name="button5" id="button5" value="Cancelar" onclick="cancela()" class="botonXX" /></td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;</td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td width="14%" class="textonegrita">Fecha</td>
    <td width="86%" class="textosimple"><input name="fecha" type="text" id="fecha" readonly="readonly" /></td>
  </tr>
  <tr>
    <td class="textonegrita">Entrevistador</td>
    <td class="textosimple">
    <select name="cmbEntrevistador" id="cmbEntrevistador">
     <option value="0">seleccione...</option>
   <?php  for($e=0;$e<pg_numrows($rs_entrevistador);$e++){
	   $fila_ent = pg_fetch_array($rs_entrevistador,$e)?>
      <option value="<?php echo $fila_ent['rut_emp'] ?>"><?php echo $fila_ent['nombre_emp'] ?> <?php echo $fila_ent['ape_pat'] ?> <?php echo $fila_ent['ape_mat'] ?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td class="textonegrita">Asunto</td>
    <td class="textosimple">
    <span id="asunto">
    <select name="cmbAsunto" id="cmbAsunto">
      <option value="0">seleccione...</option>
      <?php  for($as=0;$as<pg_numrows($rs_asunto);$as++){
	   $fila_asu = pg_fetch_array($rs_asunto,$as)?>
      <option value="<?php echo $fila_asu['id_asunto'] ?>"><?php echo $fila_asu['asunto'] ?></option>
      <?php }?>
    </select>
    </span>
    <img src="../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Add.png" width="24" height="24" onclick="agregaAsunto()" /></td>
  </tr>
  <tr>
    <td class="textonegrita">Observaciones</td>
    <td class="textosimple"><textarea name="observaciones" cols="50" rows="5" id="observaciones"></textarea></td>
  </tr>
  <tr>
    <td class="textonegrita">Acuerdos</td>
    <td class="textosimple"><textarea name="acuerdos" cols="50" rows="5" id="acuerdos"></textarea></td>
  </tr>
  <tr>
    <td class="textonegrita">Compromisos</td>
    <td class="textosimple"><textarea name="compromisos" cols="50" rows="5" id="compromisos"></textarea></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?
}
if($funcion==5){
$rs_guardaent=$obj_entr->guardaEntrevista($id_ano,$entrevistado,$entrevistador,$fecha,$observaciones,$asunto,$acuerdos,$compromisos);	
if($rs_guardaent){
echo 1;
}else{
	echo 0;
	}
}
if($funcion==6){
?>
<table width="284">
<tr><td width="80">Asunto</td><td width="192"><input name="nom_asunto" type="text" id="nom_asunto" size="20" /></td></tr></table>
<?	
	}
if($funcion==7){
$rs_asunto = $obj_entr->guardaAsunto($txt,$rdb);
if($rs_asunto){
echo 1;
}else{
	echo 0;
	}
}
if($funcion==8){
$rs_asunto = $obj_entr->traeAsunto($rdb);
?>
 <select name="cmbAsunto" id="cmbAsunto">
      <option value="0">seleccione...</option>
      <?php  for($as=0;$as<pg_numrows($rs_asunto);$as++){
	   $fila_asu = pg_fetch_array($rs_asunto,$as)?>
      <option value="<?php echo $fila_asu['id_asunto'] ?>"><?php echo $fila_asu['asunto'] ?></option>
      <?php }?>
</select>
<?	
}

if($funcion==9){
$rs_entrevistador = $obj_entr->traeDirectivo($rdb);
$rs_asunto = $obj_entr->traeAsunto($rdb);
$rs_entrevista = $obj_entr->traeEntrevistaDetalle($id);
$fila = pg_fetch_array($rs_entrevista,0);
?>
<script>
$( document ).ready(function() {
   $( "#fecha" ).datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			/*minDate: new Date('01/01/'+anio+''),
			maxDate: new Date('12/31/'+anio+''),*/
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});
});
</script>
<table width="100%" border="0" cellspacing="0">
  <tr>
    <td colspan="2" align="right" class="textonegrita"><input type="submit" name="button4" id="button4" value="Guardar" class="botonXX" onclick="guardaEdita()" />
    <input type="submit" name="button5" id="button5" value="Cancelar" onclick="cancela()" class="botonXX" /></td>
  </tr>
  <tr>
    <td class="textonegrita"><input type="hidden" name="id_entrevista" id="id_entrevista" value="<?php echo $fila['id_entrevista'] ?>" /></td>
    <td class="textosimple">&nbsp;</td>
  </tr>
  <tr>
    <td width="14%" class="textonegrita">Fecha</td>
    <td width="86%" class="textosimple"><input name="fecha" type="text" id="fecha" readonly="readonly" value="<?php echo CambioFD($fila['fecha']) ?>" /></td>
  </tr>
  <tr>
    <td class="textonegrita">Entrevistador</td>
    <td class="textosimple">
    <select name="cmbEntrevistador" id="cmbEntrevistador">
     <option value="0">seleccione...</option>
   <?php  for($e=0;$e<pg_numrows($rs_entrevistador);$e++){
	   $fila_ent = pg_fetch_array($rs_entrevistador,$e)?>
      <option value="<?php echo $fila_ent['rut_emp'] ?>" <?php echo ($fila_ent['rut_emp']==$fila['entrevistador'])?"selected":"" ?>><?php echo $fila_ent['nombre_emp'] ?> <?php echo $fila_ent['ape_pat'] ?> <?php echo $fila_ent['ape_mat'] ?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td class="textonegrita">Asunto</td>
    <td class="textosimple">
    <span id="asunto">
    <select name="cmbAsunto" id="cmbAsunto">
      <option value="0">seleccione...</option>
      <?php  for($as=0;$as<pg_numrows($rs_asunto);$as++){
	   $fila_asu = pg_fetch_array($rs_asunto,$as)?>
      <option value="<?php echo $fila_asu['id_asunto'] ?>" <?php echo ($fila_asu['id_asunto']==$fila['asunto'])?"selected":"" ?>><?php echo $fila_asu['asunto'] ?></option>
      <?php }?>
    </select>
    </span>
    <img src="../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Add.png" width="24" height="24" onclick="agregaAsunto()" /></td>
  </tr>
  <tr>
    <td class="textonegrita">Observaciones</td>
    <td class="textosimple"><textarea name="observaciones" cols="50" rows="5" id="observaciones"><?php echo $fila['observaciones'] ?></textarea></td>
  </tr>
   <tr>
    <td class="textonegrita">Acuerdos</td>
    <td class="textosimple"><textarea name="acuerdos" cols="50" rows="5" id="acuerdos"><?php echo $fila['acuerdos'] ?></textarea></td>
  </tr>
  <tr>
    <td class="textonegrita">Compromisos</td>
    <td class="textosimple"><textarea name="compromisos" cols="50" rows="5" id="compromisos"><?php echo $fila['compromisos'] ?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>	
<?
}
if($funcion==10){
$rs_guardaent=$obj_entr->actualizaEntrevista($id_ano,$entrevistado,$entrevistador,$fecha,$observaciones,$asunto,$id_entrevista,$acuerdos,$compromisos);	
if($rs_guardaent){
echo 1;
}else{
	echo 0;
	}	
	
}
if($funcion==11){
$rs_elimina = $obj_entr->borraEntrevista($id);
if($rs_elimina){
echo 1;
}else{
	echo 0;
	}
}

?>