<?	require('../../util/header.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;	
	$frmModo		=$_FRMMODO;
	$Menu			=$menu;
	$Categoria 		=$categoria;
	/*$_POSP = 4;
	$_bot = 8;*/
	
	if($cierra==1){
		echo "<script>window.close();</script>";
	}
	

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>MODIFICA MENU</title>
</head>
<script language="javascript" type="text/javascript">
function enviaForm(form){
	form.submit(true);
	//window.close();
}

</script>
<body>
<form name="form" action="procesoMenu.php" method="post">
<table width="400" border="1" cellpadding="0" cellspacing="0">
<? if($nivel==1){
		$sql = "SELECT nombre,url,nivel,orden,bool_i,bool_m,bool_e,bool_v FROM menu WHERE id_menu=".$menu;
		$rs_menu = @pg_exec($conn,$sql);
		$fila_menu = @pg_fetch_array($rs_menu,0);
?>


  <tr>
    <td class="textosimple">Menú</td>
    <td class="textosimple">&nbsp;:&nbsp;</td>
    <td class="textosimple">&nbsp;<input name="txtMENU" type="text" size="30" value="<?=$fila_menu['nombre'];?>" /></td>
  </tr>
  <tr>
    <td class="textosimple">URL</td>
    <td class="textosimple">&nbsp;:&nbsp;</td>
    <td class="textosimple">&nbsp;<input name="txtURLMENU" type="text" size="30" value="<?=$fila_menu['url'];?>"/></td>
  </tr>
  <tr>
    <td class="textosimple">Nivel</td>
    <td class="textosimple">&nbsp;:&nbsp;</td>
    <td class="textosimple">&nbsp;
		<select name="cmbNIVEL">
			<option value="0" <? if($fila_menu['nivel']==0) echo "selected";?>>Admin</option>
			<option value="1" <? if($fila_menu['nivel']==1) echo "selected";?>>Cliente</option>
		</select>	</td>
  </tr>
  <tr>
    <td class="textosimple">Orden</td>
    <td class="textosimple">&nbsp;:&nbsp;</td>
    <td class="textosimple">&nbsp;<input name="txtORDENMENU" type="text" id="txtORDENMENU" size="5" maxlength="2" value="<?=$fila_menu['orden'];?>" /></td>
  </tr>
  <tr>
    <td class="textosimple">Permisos</td>
    <td class="textosimple">:</td>
    <td class="textosimple">
	<input name="ck_ingreso" type="checkbox" id="ck_ingreso" value="1" <? echo (($fila_menu['bool_i']==1)?"checked":"");?> />I 
	<input name="ck_modifica" type="checkbox" id="ck_modifica" value="1" <? echo (($fila_menu['bool_m']==1)?"checked":"");?> />M 
	<input name="ck_elimina" type="checkbox" id="ck_elimina" value="1" <? echo (($fila_menu['bool_e']==1)?"checked":"");?> />E 
	<input name="ck_ver" type="checkbox" id="ck_ver" value="1" <? echo (($fila_menu['bool_v']==1)?"checked":"");?> />V
	</td>
  </tr></table>
<table width="400" border="1" cellpadding="0" cellspacing="0">

<input name="tipo" type="hidden" value="7" />
<input name="menu" type="hidden" value="<?=$menu;?>" />
<? }elseif($nivel==2){
		$sql = "SELECT nombre,url,orden,nivel FROM menu_categoria WHERE id_menu = ".$Menu." AND id_categoria=".$categoria;
		$rs_categoria = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$fila_cat = @pg_fetch_array($rs_categoria,0);
		
		$sql = "SELECT nombre,id_menu FROM menu ";
		$rs_menu = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);

?>
	
<tr>
    <td class="textosimple">Menú</td>
    <td class="textosimple">&nbsp;:&nbsp;</td>
    <td class="textosimple">
		<select name="cmbMENU">
			<? for($i=0;$i<@pg_numrows($rs_menu);$i++){
					$fila = @pg_fetch_array($rs_menu,$i);
						if($fila['id_menu']==$Menu){?>
							<option value="<?=$fila['id_menu'];?>" selected="selected"><?=$fila['nombre'];?></option>
					<? }else{?>
							<option value="<?=$fila['id_menu'];?>"><?=$fila['nombre'];?></option>
					<? }
				} ?>
		</select>	</td>
  </tr>
<tr>
    <td class="textosimple">Categoria</td>
    <td class="textosimple">&nbsp;:&nbsp;</td>
    <td class="textosimple"><input name="txtCATEGORIA" type="text" size="30" value="<?=$fila_cat['nombre'];?>" /></td>
  </tr>
  <tr>
    <td class="textosimple">URL</td>
    <td class="textosimple">&nbsp;:&nbsp;</td>
    <td class="textosimple"><input name="txtURLCATEGORIA" type="text" size="30" value="<?=$fila_cat['url'];?>"/></td>
  </tr>
  <tr>
    <td class="textosimple">Nivel</td>
    <td class="textosimple">&nbsp;:&nbsp;</td>
    <td class="textosimple">
		<select name="cmbNIVEL">
			<option value="0" <? if($fila_cat['nivel']==0) echo "selected";?>>Admin</option>
			<option value="1" <? if($fila_cat['nivel']==1) echo "selected";?>>Cliente</option>
		</select>	</td>
  </tr>
  <tr>
    <td class="textosimple">Orden</td>
    <td class="textosimple">&nbsp;:&nbsp;</td>
    <td class="textosimple"><input name="txtORDENCATEGORIA" type="text" id="txtORDENCATEGORIA" size="5" maxlength="2" value="<?=$fila_cat['orden'];?>" /></td>
  </tr>
  <tr>
    <td class="textosimple">Permisos</td>
    <td class="textosimple">:</td>
    <td class="textosimple">
	<input name="ck_ingresoC" type="checkbox" id="ck_ingresoC" value="1" <? echo (($fila_cat['bool_i']==1)?"checked":"");?> />I 
	<input name="ck_modificaC" type="checkbox" id="ck_modificaC" value="1" <? echo (($fila_cat['bool_m']==1)?"checked":"");?> />M 
	<input name="ck_eliminaC" type="checkbox" id="ck_eliminaC" value="1" <? echo (($fila_cat['bool_e']==1)?"checked":"");?> />E 
	<input name="ck_verC" type="checkbox" id="ck_verC" value="1" <? echo (($fila_cat['bool_v']==1)?"checked":"");?> />V
	</td>
  </tr>

<input name="tipo" type="hidden" value="8" />
<input name="menu" type="hidden" value="<?=$menu;?>" />
<input name="categoria" type="hidden" value="<?=$categoria;?>" />

<? }elseif($nivel==3){
		$sql = "SELECT nombre,url,orden,nivel FROM menu_categ_item WHERE id_menu = ".$Menu." AND id_categoria=".$categoria." AND id_item=".$item;
		$rs_item = @pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);
		$fila_item  =@pg_fetch_array($rs_item,0);
			
		$sql = "SELECT nombre,url,orden,nivel FROM menu_categoria WHERE id_menu = ".$Menu." AND id_categoria=".$categoria;
		$rs_categoria = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	
		
		$sql = "SELECT nombre,id_menu FROM menu ";
		$rs_menu = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);

?>
	
<tr>
    <td class="textosimple">Menú</td>
    <td class="textosimple">&nbsp;:&nbsp;</td>
    <td class="textosimple">
		<select name="cmbMENU">
			<? for($i=0;$i<@pg_numrows($rs_menu);$i++){
					$fila = @pg_fetch_array($rs_menu,$i);
						if($fila['id_menu']==$Menu){?>
							<option value="<?=$fila['id_menu'];?>" selected="selected"><?=$fila['nombre'];?></option>
					<? }else{?>
							<option value="<?=$fila['id_menu'];?>"><?=$fila['nombre'];?></option>
					<? }
				} ?>
		</select>	</td>
  </tr>
<tr>
  <td class="textosimple">Categoria</td>
  <td class="textosimple">&nbsp;:&nbsp;</td>
  <td class="textosimple">
  	<select name="cmbCATEGORIA">
		<? 	for($j=0;$j<@pg_numrows($rs_categoria);$j++){
				$fila_cat = @pg_fetch_array($rs_categoria,$j);
				if($categoria==$fila_cat['id_categoria']){?>
				<option value="<?=$fila_cat['id_categoria'];?>" selected="selected"><?=$fila_cat['nombre'];?></option>
			<? }else{?>
				<option value="<?=$fila_cat['id_categoria'];?>"><?=$fila_cat['nombre'];?></option>
			<? }
			} ?>
	</select>  </td>
</tr>
<tr>
    <td class="textosimple">Item</td>
    <td class="textosimple">&nbsp;:&nbsp;</td>
    <td class="textosimple"><input name="txtITEM" type="text" size="30" value="<?=$fila_item['nombre'];?>" /></td>
  </tr>
  <tr>
    <td class="textosimple">URL</td>
    <td class="textosimple">&nbsp;:&nbsp;</td>
    <td class="textosimple"><input name="txtURLITEM" type="text" size="30" value="<?=$fila_item['url'];?>"/></td>
  </tr>
  <tr>
    <td class="textosimple">Nivel</td>
    <td class="textosimple">&nbsp;:&nbsp;</td>
    <td class="textosimple">
		<select name="cmbNIVEL">
			<option value="0" <? if($fila_item['nivel']==0) echo "selected";?>>Admin</option>
			<option value="1" <? if($fila_item['nivel']==1) echo "selected";?>>Cliente</option>
		</select>	</td>
  </tr>
  <tr>
    <td class="textosimple">Orden</td>
    <td class="textosimple">&nbsp;:&nbsp;</td>
    <td class="textosimple"><input name="txtORDENITEM" type="text" id="txtORDENITEM" size="5" maxlength="2" value="<?=$fila_item['orden'];?>" /></td>
  </tr>
  <tr>
    <td class="textosimple">Permisos</td>
    <td class="textosimple">:</td>
    <td class="textosimple">
	<input name="ck_ingresoI" type="checkbox" id="ck_ingresoI" value="1" <? echo (($fila_item['bool_i']==1)?"checked":"");?> />I 
	<input name="ck_modificaI" type="checkbox" id="ck_modificaI" value="1" <? echo (($fila_item['bool_m']==1)?"checked":"");?> />M 
	<input name="ck_eliminaI" type="checkbox" id="ck_eliminaI" value="1" <? echo (($fila_item['bool_e']==1)?"checked":"");?> />E 
	<input name="ck_verI" type="checkbox" id="ck_verI" value="1" <? echo (($fila_item['bool_v']==1)?"checked":"");?> />V
	</td>
  </tr>

<input name="tipo" type="hidden" value="9" />
<input name="menu" type="hidden" value="<?=$menu;?>" />
<input name="categoria" type="hidden" value="<?=$categoria;?>" />
<input name="item" type="hidden" value="<?=$item;?>" />
  <? } ?>
  <tr>
    <td colspan="3"><div align="right">
      <input name="cb_modificar" type="button" id="cb_modificar" value="MODIFICAR"  class="botonXX" onclick="enviaForm(this.form);"/>
    </div></td>
  </tr>
</table>
</form>
</body>
</html>
