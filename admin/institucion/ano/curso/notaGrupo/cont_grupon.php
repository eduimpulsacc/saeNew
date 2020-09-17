<?php 
session_start();
require('../../../../../util/header.inc');
include('mod_grupon.php');

$ob_grupo = new Grupon();

$funcion=$_POST['funcion'];

if($funcion==1){
	$rs_listado=$ob_grupo->tablaCurso($conn,$curso);
	//$rs_ramo=$ob_grupo->nombreSubsector($conn,$ramo);
	
	?>
    <input name="curso" type="hidden" id="curso" value="<?php echo $curso ?>" />
     
     
<table width="98%" border="1" id="conte" cellpadding="0" cellspacing="0" style="border-collapse:collapse">

  <tr class="tablatit2-1">
   
    <td width="28%" height="42" align="center" valign="middle">Leccionario</td>
    <td width="12%" align="center" valign="middle">Porcentaje</td>
    <td width="14%" align="center" valign="middle">Casilla</td>
    <td width="14%" align="center" valign="middle">Orden</td>
    <td width="16%" align="center" valign="middle">Acciones</td>
  </tr><?php  if(pg_numrows($rs_listado)>0){?>
 <?php  for($l=0;$l<pg_numrows($rs_listado);$l++){
	 $cas="";
	 $fila = pg_fetch_array($rs_listado,$l);
	 $pac= $pac+pg_result($rs_listado,4) ;
	 ?>
  <tr id="fila<?php echo $fila['id_grupo'] ?>">
   
    <td height="33"><?php echo pg_result($rs_listado,24) ?></td>
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
<br />
<table width="98%" border="1"  cellpadding="0" cellspacing="0" style="border-collapse:collapse">
 <tr>
    <td  width="58%">Porcentaje Acumulado</td>
    <td width="12%" align="center" ><?php echo $pac ?>%</td>
    <td width="30%" align="center" >&nbsp;</td>
  </tr>
</table>
 <br />
 
<input name="" type="button" value="Crear Grupo" onclick="ngr(<?php echo $curso ?>)" class="botonXX" /><br />
<?php if(pg_numrows($rs_listado)>0){?>
<br />
<br />
<input name="" type="button" value="Distrubuir grupos " onclick="modg(<?php echo $curso ?>)" class="botonXX" />
<?php }?>



<?
}
if($funcion==2){
	
	?>
  
<tr>
  
    <td height="33"><input name="txtLECCIONARIO" id="txtLECCIONARIO" type="text"  /></td>
    <td height="3" align="center"><input name="prc" type="text" id="prc" size="2" class="prco" /></td>
    <td><?php for($n=1;$n<=19;$n++){
		$rs_marca = $ob_grupo->veMarca($conn,$ramo,$n);
		
		 $vis = (pg_result($rs_marca,0)==1)?' style="display:none"':""; 
		
		?><span <?php echo $vis ?>><input name="n<?php echo $n?>" id="n<?php echo $n?>"  type="checkbox" value="" class="grn" />Nota <?php echo $n ?><br /></span>
  <?php }?></td>
    <td><input name="" type="button" value="Guardar" class="botonXX" onclick="guardaGrupo();" /></td>
</tr>

    <?
}
if($funcion==3){
$rs_guarda=$ob_grupo->guardaGrupo($conn,$_ANO,$curso,$porcentaje,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12,$n13,$n14,$n15,$n16,$n17,$n18,$n19,0,utf8_decode($leccionario));

}
if($funcion==4){
	$rs_fila = $ob_grupo->tablaGrupo($conn,$grupo);
	$fila = pg_fetch_array($rs_fila,0);
	$rs_ramo=$ob_grupo->nombreSubsector($conn,$fila['id_ramo']);
	?>
  
  
  <td height="33"><input name="txtLECCIONARIO" id="txtLECCIONARIO" type="text"  value="<?php echo $fila['nombre']; ?>"/></td>
  <td height="3" align="center"><input name="prc" type="text" id="prc" class="prco" size="2" value="<?php echo $fila['porcentaje'] ?>" /></td>
  <td><?php for($n=1;$n<=19;$n++){
		$rs_marca = $ob_grupo->veMarca($conn,$fila['id_ramo'],$n,$grupo);
		?><input name="n<?php echo $n?>" id="n<?php echo $n?>" type="checkbox" value="" class="grn" <?php echo ($fila['nota'.$n]==1)?'checked':"" ?> <?php echo (pg_result($rs_marca,0)==1)?'style="visibility:hidden"':""  ?> />Nota <?php echo $n ?><br />
  <?php }?></td>
  <td><input name="idg" type="hidden" id="idg" value="<?php echo $fila['id_grupo'] ?>" /><input name="" type="button" value="Guardar" class="botonXX" onclick="guardaGrupoEdi();" />&nbsp;<input type="button" name="button" id="button" value="Cancela Edici&oacute;n" class="botonXX" onclick="grupon(<?php echo $fila['id_curso'] ?>)" /></td>


<?
}
if($funcion==5){
	$rs_guarda=$ob_grupo->actualizaGrupo($conn,$grupo,$porcentaje,$n1,$n2,$n3,$n4,$n5,$n6,$n7,$n8,$n9,$n10,$n11,$n12,$n13,$n14,$n15,$n16,$n17,$n18,$n19,0,utf8_decode($leccionario));
}

if($funcion==6){
	$rs_eli=$ob_grupo->borraGrupo($conn,$curso);
	echo ($rs_eli)?1:0;
}

if($funcion==7){
	$rs_eli=$ob_grupo->borraGrupoC($conn,$grupo);
	echo ($rs_eli)?1:0;
}
if($funcion==8){
//busco grupos existentes;
$rsexis = $ob_grupo->existeGrupo($conn,$curso);

$rle= "";
$esub="";
for($re=0;$re<pg_numrows($rsexis);$re++){
	$filare = pg_fetch_array($rsexis,$re);
	$rle.=$filare['id_ramo'].",";
	
	$esu  = $ob_grupo->nombreSubsector($conn,$filare['id_ramo']);
	$esub.=pg_result($esu,0).",";
	
	}
$rle=substr($rle,0,-1);
$esub=substr($esub,0,-1);
//echo $esub;
//actualizar masivo
$borram = $ob_grupo->borraGrupoM($conn,$rle);

$cact="";
//lista de los cursos que debo configurar;
$rs_grupoNE = $ob_grupo->NEgrupo($conn,$curso);
for($ne=0;$ne<pg_numrows($rs_grupoNE);$ne++){
$filaNE = pg_fetch_array($rs_grupoNE,$ne);
$cact.=$filaNE['id_ramo'].",";
 
}
echo "\cact->".$cact=substr($cact,0,-1);
//activar los grupos para los ramos restante
$ob_grupo->activaGrupoMA($conn,$cact);

/*$rs_listado=$ob_grupo->tablaCurso($conn,$curso);
for($c=0;$c<pg_numrows($rs_listado);$c++){
$fila_grupo = pg_fetch_array($rs_listado,$c);




}*/

}
?>