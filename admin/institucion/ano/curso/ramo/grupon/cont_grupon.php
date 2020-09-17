<?php 
session_start();
require('../../../../../../util/header.inc');
include('mod_grupon.php');

$ob_grupo = new Grupon();

$funcion=$_POST['funcion'];

if($funcion==1){ 
	$rs_listado=$ob_grupo->tablaCurso($conn,$curso,$ramo);
	$rs_ramo=$ob_grupo->nombreSubsector($conn,$ramo);
	$rs_periodo  = $ob_grupo->getPeriodos($conn,$_ANO);
	
	?>
    <input name="curso" type="hidden" id="curso" value="<?php echo $curso ?>" />
     <input name="ramo" type="hidden" id="ramo" value="<?php echo $ramo ?>" />
  <div align="center" >  
    <?php //if($_PERFIL==0){?>
    <select id="idP" onchange="gruponNew(this.value)">
    <option value="0">Seleccione Periodo</option>
    <? for($p=0;$p<pg_numrows($rs_periodo);$p++){
		$fila_p = pg_fetch_array($rs_periodo,$p);
		?>
      <option value="<?php echo $fila_p['id_periodo'] ?>"><?php echo $fila_p['nombre_periodo'] ?></option>
	<?php }?> 
    </select>
    </div>
    <br />
<br />
 <?php //}?>
   <div id="listaGrupos">
    <table width="100%" border="1" cellpadding="0" cellspacing="0" id="conte" style="border-collapse:collapse">

  <tr class="tablatit2-1">
    <td width="16%" height="42" align="center" valign="middle">Asignatura</td>
    <td width="18%" height="42" align="center" valign="middle">Leccionario</td>
    <td width="16%" align="center" valign="middle">Porcentaje</td>
    <td width="15%" align="center" valign="middle">Casilla</td>
    <td width="10%" align="center" valign="middle">Orden</td>
    <td width="25%" align="center" valign="middle">Acciones</td>
  </tr>
  </table> 
<!--<table width="100%" border="1" cellpadding="0" cellspacing="0" id="conte" style="border-collapse:collapse">

  <tr class="tablatit2-1">
    <td width="16%" height="42" align="center" valign="middle">Asignatura</td>
    <td width="18%" height="42" align="center" valign="middle">Leccionario</td>
    <td width="16%" align="center" valign="middle">Porcentaje</td>
    <td width="15%" align="center" valign="middle">Casilla</td>
    <td width="10%" align="center" valign="middle">Orden</td>
    <td width="25%" align="center" valign="middle">Acciones</td>
  </tr><?php  if(pg_numrows($rs_listado)>0){?>
 <?php  for($l=0;$l<pg_numrows($rs_listado);$l++){
	 $cas="";
	 $fila = pg_fetch_array($rs_listado,$l);
	 $pac= $pac+pg_result($rs_listado,4) ;
	 ?>
  <tr id="fila<?php echo $fila['id_grupo'] ?>">
    <td height="33"><?php echo pg_result($rs_ramo,0) ?></td>
    <td height="33"><?php echo pg_result($rs_listado,25) ?></td>
    <td align="center"><?php echo pg_result($rs_listado,4) ?> <input type="hidden" class="prco" value="<?php echo pg_result($rs_listado,4) ?>" /></td>
    <td><?php for($n=1;$n<=19;$n++){?>
	<?php $cas.= ($fila['nota'.$n]==1)?$n.",":""; ?>
	<?php }?>
	<?php echo substr($cas,0,-1) ?></td>
    <td align="center"><?php echo $fila['orden']; ?></td>
    <td align="center"><input type="button" name="button" id="button" class="botonXX btne" value="Editar" onclick="edifila(<?php echo $fila['id_grupo'] ?>)" /> <input type="button" name="button" id="button" class="botonXX btne" value="Eliminar" onclick="elifila(<?php echo $fila['id_grupo'] ?>)" /></td>
  </tr>

  <?php }?>
  <?php }?> 
  
</table>
</div>
<br />
<table width="98%" border="1"  cellpadding="0" cellspacing="0" style="border-collapse:collapse">
 <tr>
    <td  width="58%">Porcentaje Acumulado</td>
    <td width="12%" align="center" ><?php echo $pac ?>%</td>
    <td width="30%" align="center" >&nbsp;</td>
  </tr>
</table>
 <br />
  <?php if($pac<100){?>
<input name="" type="button" value="Crear Grupo" onclick="ngr(<?php echo $ramo ?>)" class="botonXX" />-->
<?php }?>
<?
}
if($funcion==2){
	$rs_ramo=$ob_grupo->nombreSubsector($conn,$ramo);
	$maxorden =  $ob_grupo->getOrdenGrupo($conn,$ramo,$per);
	?>
  
<tr>
  	<td><?php echo pg_result($rs_ramo,0) ?></td>
    <td height="33"><input name="txtLECCIONARIO" id="txtLECCIONARIO" type="text"  /></td>
    <td height="3" align="center"><input name="prc" type="text" id="prc" size="2" class="prco" /></td>
    <td><?php for($n=1;$n<=19;$n++){
		//$rs_marca = $ob_grupo->veMarca($conn,$ramo,$n);
		$rs_marca = $ob_grupo->veMarcaNew($conn,$ramo,$per,$n);
		
		 $vis = (pg_result($rs_marca,0)==1)?' style="display:none"':""; 
		
		?><span <?php echo $vis ?>><input name="n<?php echo $n?>" id="n<?php echo $n?>"  type="checkbox" value="" class="grn" />Nota <?php echo $n ?><br /></span>
  <?php }?></td>
  <td align="center"><input name="orden" type="text" id="orden" value="<?php echo (pg_result($maxorden,0)+1) ?>" size="2" class="solo-numero" /></td>
    <td><input name="" type="button" value="Guardar" class="botonXX" onclick="guardaGrupo();" /></td>
</tr>

    <?
}
if($funcion==3){
$rs_guarda=$ob_grupo->guardaGrupo($conn,$_ANO,$curso,$ramo,$porcentaje,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12,$n13,$n14,$n15,$n16,$n17,$n18,$n19,0,utf8_decode($leccionario),$orden,$per);

}
if($funcion==4){
//	show($_POST);
	$rs_fila = $ob_grupo->tablaGrupo($conn,$grupo);
	$fila = pg_fetch_array($rs_fila,0);
	$rs_ramo=$ob_grupo->nombreSubsector($conn,$fila['id_ramo']);
	?>
  
  <td><?php echo pg_result($rs_ramo,0) ?></td>
  <td height="33"><input name="txtLECCIONARIO" id="txtLECCIONARIO" type="text"  value="<?php echo $fila['nombre']; ?>"/></td>
  <td height="3" align="center"><input name="prc" type="text" id="prc" class="prco" size="2" value="<?php echo $fila['porcentaje'] ?>" /></td>
  <td><?php for($n=1;$n<=19;$n++){
		//$rs_marca = $ob_grupo->veMarca($conn,$fila['id_ramo'],$n,$grupo);
	$rs_marca = $ob_grupo->veMarcaNew($conn,$fila['id_ramo'],$per,$n,$grupo)
		?>
        <span <?php echo (pg_result($rs_marca,0)==1)?'style="display:none"':""  ?>>
        <input name="n<?php echo $n?>" id="n<?php echo $n?>" type="checkbox" value="" class="grn" <?php echo ($fila['nota'.$n]==1)?'checked':"" ?> <?php echo (pg_result($rs_marca,0)==1)?'style="visibility:hidden"':""  ?> />Nota <?php echo $n ?><br /></span>
  <?php }?></td>
  <td align="center"><input name="orden" type="text" id="orden" value="<?php echo $fila['orden'] ?>" size="2" class="solo-numero" /></td>
  <td><input name="idg" type="hidden" id="idg" value="<?php echo $fila['id_grupo'] ?>" /><input name="" type="button" value="Guardar" class="botonXX" onclick="guardaGrupoEdi();" />&nbsp;<input type="button" name="button" id="button" value="Cancela Edici&oacute;n" class="botonXX" onclick="grupon(<?php echo $fila['id_ramo'] ?>,<?php echo $fila['id_curso'] ?>)" /></td>


<?
}
if($funcion==5){
	$rs_guarda=$ob_grupo->actualizaGrupo($conn,$grupo,$porcentaje,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12,$n13,$n14,$n15,$n16,$n17,$n18,$n19,0,utf8_decode($leccionario),$orden);
	$rs_cestado=$ob_grupo->cambiaEstado($conn,$ramo);
}

if($funcion==6){
	$rs_eli=$ob_grupo->borraGrupo($conn,$grupo);
	$rs_cestado=$ob_grupo->cambiaEstado($conn,$ramo);
}
if($funcion==7){
	//show($_POST);
	$rs_listado=$ob_grupo->tablaCursoNew($conn,$curso,$ramo,$per);
	$rs_ramo=$ob_grupo->nombreSubsector($conn,$ramo);?>
    <table width="100%" border="1" cellpadding="0" cellspacing="0" id="conte" style="border-collapse:collapse">

  <tr class="tablatit2-1">
    <td width="16%" height="42" align="center" valign="middle">Asignatura</td>
    <td width="18%" height="42" align="center" valign="middle">Leccionario</td>
    <td width="16%" align="center" valign="middle">Porcentaje</td>
    <td width="15%" align="center" valign="middle">Casilla</td>
    <td width="10%" align="center" valign="middle">Orden</td>
    <td width="25%" align="center" valign="middle">Acciones</td>
  </tr><?php  if(pg_numrows($rs_listado)>0){?>
 <?php  for($l=0;$l<pg_numrows($rs_listado);$l++){
	 $cas="";
	 $fila = pg_fetch_array($rs_listado,$l);
	 $pac= $pac+$fila['porcentaje'] ;
	 ?>
  <tr id="fila<?php echo $fila['id_grupo'] ?>">
    <td height="33"><?php echo pg_result($rs_ramo,0) ?></td>
    <td height="33"><?php echo $fila['nombre'] ?></td>
    <td align="center"><?php echo $fila['porcentaje'] ?> <input type="hidden" class="prco" value="<?php echo $fila['porcentaje'] ?>" /></td>
    <td><div align="center"><?php for($n=1;$n<=19;$n++){?>
	<?php $cas.= ($fila['nota'.$n]==1)?$n.",":""; ?>
	<?php }?>
	<?php echo substr($cas,0,-1) ?></div></td>
    <td align="center"><?php echo $fila['orden']; ?></td>
    <td align="center"><input type="button" name="button" id="button" class="botonXX btne" value="Editar" onclick="edifila(<?php echo $fila['id_grupo'] ?>)" /> <input type="button" name="button" id="button" class="botonXX btne" value="Eliminar" onclick="elifila(<?php echo $fila['id_grupo'] ?>)" /></td>
  </tr>

  <?php }?>
  <?php }?> 
  
</table>
<br />
<table width="98%" border="1"  cellpadding="0" cellspacing="0" style="border-collapse:collapse">
 <tr>
    <td  width="58%">Porcentaje Acumulado</td>
    <td width="12%" align="center" ><?php echo $pac ?>%</td>
    <td width="30%" align="center" >&nbsp;</td>
  </tr>
</table>
 <br />
  <?php if($pac<100){?>
<input name="" type="button" value="Crear Grupo" onclick="ngr(<?php echo $ramo ?>)" class="botonXX" />
<?php }?>
	<?
	}
?>