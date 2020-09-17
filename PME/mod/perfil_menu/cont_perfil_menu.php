<? header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "mod_crea_prfil_menu.php";

$institucion=$_INSTIT;
$objMembrete= new Membrete($_IPDB,$_ID_BASE);
$obj_Perfil_Menu = new Crea_Perfil_Menu($_IPDB,$_ID_BASE);
$funcion = $_POST['funcion'];




if($funcion==sperfil){

$result = $obj_Perfil_Menu->carga_perfil();
if($result){
$select = "<label>PERFIL:  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>"."<select name='cmbPERFIL' id='cmbPERFIL' onchange='cargatabla_perfilMenu(this.value)'>
<option value='0' select='select'  >Selecccionar</option>";
for($i=0;$i<@pg_numrows($result);$i++){
$fila=pg_fetch_array($result,$i);
$select .= "<option value='".$fila['id_perfil']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre_perfil']))))."</option>";

}  // for 2 
$select .= "</select>"; 
echo $select;

}else{

echo 0;			

}

} // fin funcion 


if($funcion==1){ 

	$caso=1;	
	$cmbPERFIL=$_POST['cmbPERFIL'];
	if($cmbPERFIL!=0){
		 $sql = "SELECT * FROM pme.perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$cmbPERFIL;
		$result = @pg_Exec($obj_Perfil_Menu->Conec->conectar(),$sql);	
		if(@pg_numrows($result) > 0){
			for($i=0;$i<@pg_numrows($result);$i++){
				$fila = @pg_fetch_array($result,$i);
				$perfil[$i]=$fila['id_item'];
			}
			$caso=2;
		}
	}
	
	?>
    
    
    <input name="caso" type="hidden" value="<?=$caso;?>">
<div align="right">
<? if($caso==1){ ?>
<input type="button" name="guardar"  id="guardar"value="AGREGAR"  onClick="enviar()">
<? } ?>

<? if($caso==2){?>
<input type="button" name="guardar2" id="guardar2" value="GUARDAR" onclick="enviar()">
<? } ?>
</div><br><br>
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
<?  $sql = "SELECT id_menu,nombre,bool_i,bool_m,bool_e,bool_v FROM pme.menu WHERE nivel=1 ORDER BY orden ASC";
$rs_menu = @pg_Exec($obj_Perfil_Menu->Conec->conectar(),$sql);
for($i=0;$i<@pg_numrows($rs_menu);$i++){
$fila_menu = @pg_fetch_array($rs_menu,$i);
if($caso==2){
 $sql ="SELECT id_menu FROM pme.perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$cmbPERFIL." AND id_menu=".$fila_menu['id_menu'];
$rs_existe_menu = @pg_Exec($obj_Perfil_Menu->Conec->conectar(),$sql);
if(@pg_numrows($rs_existe_menu)!=0){
$activo_menu ="checked=checked";
}else{
$activo_menu ="&nbsp;";
}
}
?>
<tr>
<td class="cuadro02" width="10%" >&nbsp;<input name="ck_menu<?=$i;?>"  id="ck_menu<?=$i;?>" type="checkbox" value="<?=$fila_menu['id_menu'];?>" <?=$activo_menu;?>>&nbsp;<?=$fila_menu['nombre'];?></td>
<td width="90%"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
<tr>
<td width="<?=$wh;?>"><table width="100%" border="0" cellspacing="" cellpadding="0" style="border-collapse:collapse">
<tr>
<td width="50%"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="border-collapse:collapse">
<tr>
<td width="25%"  class="textosimple"><table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
<?  $sql = "SELECT id_categoria,nombre,bool_i,bool_m,bool_e,bool_v FROM pme.menu_categoria WHERE id_menu=".$fila_menu['id_menu']." AND nivel=1 ORDER BY orden ASC";
$rs_categoria = @pg_Exec($obj_Perfil_Menu->Conec->conectar(),$sql);
for($j=0;$j<@pg_numrows($rs_categoria);$j++){
$fila_cat = @pg_fetch_array($rs_categoria,$j);
$activo_cat_i="&nbsp;";
$activo_cat_m="&nbsp;";
$activo_cat_e="&nbsp;";
$activo_cat_v="&nbsp;";
if($caso==2){
$sql ="SELECT bool_i,bool_m,bool_e,bool_v FROM pme.perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$cmbPERFIL." AND id_menu=".$fila_menu['id_menu']." AND id_categoria=".$fila_cat['id_categoria'];
$rs_existe_cat = @pg_Exec($obj_Perfil_Menu->Conec->conectar(),$sql);

if(@pg_numrows($rs_existe_cat)!=0){
$activo_cat ="checked=checked";
if(@pg_result($rs_existe_cat,0)==1) $activo_cat_i="checked"; else $activo_cat_i="&nbsp;";
if(@pg_result($rs_existe_cat,1)==1) $activo_cat_m="checked"; else $activo_cat_m="&nbsp;";
if(@pg_result($rs_existe_cat,2)==1) $activo_cat_e="checked"; else $activo_cat_e="&nbsp;";
if(@pg_result($rs_existe_cat,3)==1) $activo_cat_v="checked"; else $activo_cat_v="&nbsp;";
}else{
$activo_cat ="&nbsp;";
}
}
?>
<tr>
<?  $sql ="SELECT id_item,nombre_item,bool_i,bool_m,bool_e,bool_v FROM pme.menu_categ_item WHERE id_menu=".$fila_menu['id_menu']." AND id_categoria=".$fila_cat['id_categoria']." AND nivel=1 ORDER BY orden_item ASC";
$rs_item = @pg_Exec($obj_Perfil_Menu->Conec->conectar(),$sql);

if(@pg_numrows($rs_item)==0){
$rw=1;
$wh="50%";
}else{
$rw=0;
$wh="100%";
}
?>
<td  width="50%%" class="cuadro01" colspan="<?=$rw;?>" >&nbsp;
<input name="ck_categoria[<?=$i;?>][<?=$j;?>]" type="checkbox" value="<?=$fila_cat['id_categoria'];?>" <?=$activo_cat;?>>
&nbsp;
<?=$fila_cat['nombre'];?></td>
<? if($rw==1){?>
<td width="<?=$wh;?>"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td  width="25%" class="cuadro01">&nbsp;
<? if($fila_cat['bool_i']==1){?>
<input name="ck_ingreso[<?=$i;?>][<?=$j;?>]" type="checkbox" value="1" <?=$activo_cat_i;?>>
&nbsp;I&nbsp;
<? } ?></td>
<td  width="25%" class="cuadro01">&nbsp;
<? if($fila_cat['bool_m']==1){?>
<input name="ck_modifica[<?=$i;?>][<?=$j;?>]" type="checkbox" value="1" <?=$activo_cat_m;?>>
&nbsp;M&nbsp;
<? } ?></td>
<td   width="25%" class="cuadro01">&nbsp;
<? if($fila_cat['bool_e']==1){?>
<input name="ck_elimina[<?=$i;?>][<?=$j;?>]" type="checkbox" value="1" <?=$activo_cat_e;?>>
&nbsp;E&nbsp;
<? } ?></td>
<td   width="25%" class="cuadro01">&nbsp;
<? if($fila_cat['bool_v']==1){?>
<input name="ck_ver[<?=$i;?>][<?=$j;?>]" type="checkbox" value="1" <?=$activo_cat_v;?>>
&nbsp;V&nbsp;
<? } ?></td>
</tr>
</table></td>
<? } 
if(@pg_numrows($rs_item)!=0){?>
<td width="<?=$wh;?>"><table width="100%" border="1" cellspacing="0" cellpadding="0"  >
<? 
for($x=0;$x<@pg_numrows($rs_item);$x++){
$fila_item = @pg_fetch_array($rs_item,$x);
$activo_item_i="&nbsp;";
$activo_item_m="&nbsp;";
$activo_item_e="&nbsp;";
$activo_item_v="&nbsp;";
if($caso==2){
$sql ="SELECT bool_i,bool_m,bool_e,bool_v FROM pme.perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$cmbPERFIL." AND id_menu=".$fila_menu['id_menu']." AND id_categoria=".$fila_cat['id_categoria']." AND id_item=".$fila_item['id_item'];
$rs_existe_item = @pg_Exec($obj_Perfil_Menu->Conec->conectar(),$sql);

if(@pg_numrows($rs_existe_item)!=0){
$activo_item ="checked=checked";
if(@pg_result($rs_existe_item,0)==1) $activo_item_i="checked"; else $activo_item_i="&nbsp;";
if(@pg_result($rs_existe_item,1)==1) $activo_item_m="checked"; else $activo_item_m="&nbsp;";
if(@pg_result($rs_existe_item,2)==1) $activo_item_e="checked"; else $activo_item_e="&nbsp;";
if(@pg_result($rs_existe_item,3)==1) $activo_item_v="checked"; else $activo_item_v="&nbsp;";
}else{
$activo_item ="&nbsp;";
}
}
?>
<tr>
<td  width="50%"class="textosimple">&nbsp;
<input name="ck_item[<?=$i;?>][<?=$j;?>][<?=$x;?>]" type="checkbox" value="<?=$fila_item['id_item'];?>" <?=$activo_item;?>>
&nbsp;
<?=$fila_item['nombre'];?></td>
<td width="50%"><table border="0" cellspacing="0" cellpadding="0" width="100%" >
<tr>
<td width="25%" class="textosimple"><? if($fila_item['bool_i']==1){?>
<input name="ck_ingreso[<?=$i;?>][<?=$j;?>][<?=$x;?>]" type="checkbox" value="1" <?=$activo_item_i;?>>
&nbsp;I&nbsp;
<? } ?></td>
<td width="25%"  class="textosimple"><? if($fila_item['bool_m']==1){?>
<input name="ck_modifica[<?=$i;?>][<?=$j;?>][<?=$x;?>]" type="checkbox" value="1" <?=$activo_item_m;?>>
&nbsp;M&nbsp;
<? } ?></td>
<td width="25%"  class="textosimple"><? if($fila_item['bool_e']==1){?>
<input name="ck_elimina[<?=$i;?>][<?=$j;?>][<?=$x;?>]" type="checkbox" value="1" <?=$activo_item_e;?>>
&nbsp;E&nbsp;
<? } ?></td>
<td width="25%"  class="textosimple"><? if($fila_item['bool_v']==1){?>
<input name="ck_ver[<?=$i;?>][<?=$j;?>][<?=$x;?>]" type="checkbox" value="1" <?=$activo_item_v;?>>
&nbsp;V&nbsp;
<? } ?></td>
</tr>
</table></td>
</tr>
<? }
?>
<input name="contador_item[<?=$i;?>][<?=$j;?>]" type="hidden" value="<?=$x;?>">
</table></td>
<? } ?>
</tr>
<? } 
if(@pg_numrows($rs_categoria)==0){?>
<tr>
<td><table width="100%" >
<tr class="cuadro01">
<td  width="25%"  ><? if($fila_menu['bool_i']==1){ ?>
<input name="ck_ingreso[<?=$i;?>]" type="checkbox" value="1" <?=$activo_item_i;?> >
&nbsp;I&nbsp;
<? } ?></td>
<td  width="25%" ><? if($fila_menu['bool_m']==1){ ?>
<input name="ck_modifica[<?=$i;?>]" type="checkbox" value="1" <?=$activo_item_m;?> >
&nbsp;M&nbsp;
<? } ?></td>
<td  width="25%" ><? if($fila_menu['bool_e']==1){ ?>
<input name="ck_elimina[<?=$i;?>]" type="checkbox" value="1" <?=$activo_item_e;?>>
&nbsp;E&nbsp;
<? } ?></td>
<td  width="25%"><? if($fila_menu['bool_v']==1){ ?>
<input name="ck_ver[<?=$i;?>]" type="checkbox" value="1" <?=$activo_item_v;?>>
&nbsp;V&nbsp;
<? } ?></td>
</tr>
</table></td>
</tr>
<? } ?>
<input name="contador_categoria<?=$i;?>" type="hidden" value="<?=$j;?>">
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
<? } ?>
<input name="contador_menu" id="contador_menu" type="hidden" value="<?=$i;?>">
</table>	
<?

}

?>