<? header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();
require "mod_crea_menu.php";

$objMembrete= new Membrete($_IPDB,$_ID_BASE);
$obj_Menu = new CreaMenu($_IPDB,$_ID_BASE);

if(isset($_POST['ficha'])) $numero_ficha = $_POST['ficha'];
if(isset($_GET['ficha'])) $numero_ficha = $_GET['ficha'];
$funcion = $_POST['funcion'];

if($funcion==1){
	//$result = $obj_Menu->cargaMenu();
		?>
		
    <table width="650" border="1" cellspacing="0" cellpadding="5" align="center">
    <tr class="color_fondo">
    <td colspan="3" >MEN&Uacute;</td>
    </tr>
    <? 	$sql ="SELECT id_menu,nombre,orden FROM cede.menu ORDER BY orden ASC";
	$rs_menu = @pg_Exec($obj_Menu->Conec->conectar(),$sql);	
    for($i=0;$i<@pg_numrows($rs_menu);$i++){
    $fila_menu = @pg_fetch_array($rs_menu,$i);
    ?>
    <tr > 
    <td width="563">(<?=$fila_menu['orden'];?>)&nbsp;<?=$fila_menu['nombre'];?></td>
    
<td width="7%"><input name="cb_mod_cat" type="button" id="cb_mod_cat" value="M" onclick='Busca_Menu(<?=$fila_menu['id_menu']?>)'/></td>
<td width="7%"><input name="cb_eli_cat" type="button" id="cb_eli_cat" value="E" onclick='EliminarMenu(<?=$fila_menu['id_menu']?>)'/></td>
    </tr>
    <? } ?>
    </table>
    <?
    
			
	 } // fin funcion 2
	 
	 
	if($funcion == 2){
		 $id_menu = $_POST['id_menu'];
		$result = $obj_Menu->Busca_menu($id_menu);
	if($result){
		if(@pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id_menu" type="hidden" value="'.$fila['id_menu'].'" />';
				echo '<input id="_menu" type="hidden" value="'.$fila['nombre'].'" />';
				echo '<input id="_url" type="hidden" value="'.$fila['url'].'" />';
				echo '<input id="_nivel" type="hidden" value="'.$fila['nivel'].'" />';
				echo '<input id="_orden" type="hidden" value="'.$fila['orden'].'" />';
				echo '<input id="_ck_ingreso" type="hidden" value="'.$fila['bool_i'].'" />';
				echo '<input id="_ck_modifica" type="hidden" value="'.$fila['bool_m'].'" />';
				echo '<input id="_ck_elimina" type="hidden" value="'.$fila['bool_e'].'" />';
				echo '<input id="_ck_ver" type="hidden" value="'.$fila['bool_v'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
 }
	 
	 
	 if($funcion == 3){
		 $nombre_menu = $_POST['nombre_menu'];
		 $url = $_POST['url'];
		 $nivel = $_POST['nivel'];
		 $orden_menu = $_POST['orden_menu'];
		 $ck_ingreso = $_POST['ck_ingreso'];
		 $ck_modifica = $_POST['ck_modifica'];
		 $ck_elimina = $_POST['ck_elimina'];
		 $ck_ver = $_POST['ck_ver'];
		 
		 
 $result = $obj_Menu->guarda_menu($nombre_menu,$url,$nivel,$orden_menu,$ck_ingreso,$ck_modifica,$ck_elimina,$ck_ver);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}	
	
	if($funcion == 4){
	 	 $id_menu=$_POST['id_menu'];	
		 $nombre_menu = $_POST['nombre_menu'];
		 $url = $_POST['url'];
		 $nivel = $_POST['nivel'];
		 $orden_menu = $_POST['orden_menu'];
		 $ck_ingreso = $_POST['ck_ingreso'];
		 $ck_modifica = $_POST['ck_modifica'];
		 $ck_elimina = $_POST['ck_elimina'];
		 $ck_ver = $_POST['ck_ver'];
		 
		 
 $result = $obj_Menu->modifica_menu($nombre_menu,$url,$nivel,$orden_menu,$ck_ingreso,$ck_modifica,$ck_elimina,$ck_ver,$id_menu);
		 
	if($result){
		echo 1;
		 }else{
		echo 0;			
		 }
	}	
	
	if($funcion == 5){
		
		 $id_menu = $_POST['id_menu'];
		 $result = $obj_Menu->eliminad_menu($id_menu);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}	
	
	if($funcion==mmenu){
	   $result = $obj_Menu->carga_menu();
		if($result){
		$select = "<select name='selectMenu' id='selectMenu' >
		<option value='0' select='select'  >Selecccionar</option>";
		for($i=0;$i<@pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_menu']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre']))))."</option>";
			
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
			
		 }else{
            
		 echo 0;			
			
		 }
			
     } // fin funcion 
	 
	 
	 if($funcion == 6){
		 $id_Menu=$_POST['id_Menu'];
		 $categoria=$_POST['categoria'];
		 $nivel = $_POST['nivel'];
		 $url_cat = $_POST['url_cat'];
		 $orden_cat = $_POST['orden_cat'];
		 $ck_ingresoC = $_POST['ck_ingresoC'];
		 $ck_modificaC = $_POST['ck_modificaC'];
		 $ck_eliminaC = $_POST['ck_eliminaC'];
		 $ck_verC = $_POST['ck_verC'];
		 
		 
 $result = $obj_Menu->guarda_menu_categoria($id_Menu,$categoria,$nivel,$url_cat,$orden_cat,$ck_ingresoC,$ck_modificaC,$ck_eliminaC,$ck_verC);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}	
	 
	
	if($funcion==7){
	//$result = $obj_Menu->cargaMenu_categoria();
		//if($result){
			?>
		<table width="650" border="1" align="center" cellpadding="3" cellspacing="0">
        <tr class="color_fondo">
        <td class="cuadro02" valign="bottom">MEN&Uacute;</td>
        <td class="cuadro02">CATEGORIA</td>
        </tr>
			<? 	
										
	 $sql="SELECT id_menu,nombre,orden FROM cede.menu ORDER BY orden ASC;"; 
	$rs_menu = @pg_Exec($obj_Menu->Conec->conectar(),$sql);	
	for($i=0;$i<@pg_numrows($rs_menu);$i++){
	$fila_menu = @pg_fetch_array($rs_menu,$i);
	?> 
    <tr>
   <td>(<?=$fila_menu['orden'];
 ?>)&nbsp;<?=$fila_menu['nombre'];?></td>
    <td><table width="100%" border="0" cellspacing="5" cellpadding="0">
	<? $sql2 = "SELECT * FROM cede.menu_categoria WHERE id_menu=".$fila_menu['id_menu']." ORDER BY orden_categoria ASC";
	$rs_cat = @pg_Exec($obj_Menu->Conec->conectar(),$sql2);	
	for($j=0;$j<@pg_numrows($rs_cat);$j++){
	$fila_cat = @pg_fetch_array($rs_cat,$j);
	?>
      <tr this.style.cursor='hand' > 
 <td width="86%">&nbsp; (<?=$fila_cat['orden_categoria'];?>)&nbsp;<?=$fila_cat['nombre_categoria'];?></td>
<td width="7%"><input name="cb_mod_cat" type="button" id="cb_mod_cat" value="M" onclick='Busca_Menu_categoria(<?=$fila_cat['id_categoria']?>)'/></td>
<td width="7%"><input name="cb_eli_cat" type="button" id="cb_eli_cat" value="E" onclick='EliminarMenu_Categoria(<?=$fila_cat['id_categoria']?>)'/></td>
        </tr>
    <? } ?>
      </table></td>
    </tr>
    <? } ?>
  </table>	
		  <?
			//}else{ 
			//   echo 0; 
			//}
	 } // fin funcion 2
	 
	 
	 if($funcion == 8){
		 $id_categoria = $_POST['id_categoria'];
		$result = $obj_Menu->Busca_menu_categoria($id_categoria);
	if($result){
		if(@pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id_categoria" type="hidden" value="'.$fila['id_categoria'].'" />';
				echo '<input id="_menu_categoria" type="hidden" value="'.$fila['id_menu'].'" />';
				echo '<input id="_categoriaC" type="hidden" value="'.$fila['nombre_categoria'].'" />';
				echo '<input id="_urlC" type="hidden" value="'.$fila['url'].'" />';
				echo '<input id="_nivelC" type="hidden" value="'.$fila['nivel'].'" />';
				echo '<input id="_ordenC" type="hidden" value="'.$fila['orden'].'" />';
				echo '<input id="_ck_ingresoC" type="hidden" value="'.$fila['bool_i'].'" />';
				echo '<input id="_ck_modificaC" type="hidden" value="'.$fila['bool_m'].'" />';
				echo '<input id="_ck_eliminaC" type="hidden" value="'.$fila['bool_e'].'" />';
				echo '<input id="_ck_verC" type="hidden" value="'.$fila['bool_v'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
 }
 
 	if($funcion == 9){
	 	 $id_Menu=$_POST['id_Menu'];	
		 $categoria = $_POST['categoria'];
		 $nivel = $_POST['nivel'];
		 $url_cat = $_POST['url_cat'];
		 $orden_cat = $_POST['orden_cat'];
		 $ck_ingresoC = $_POST['ck_ingresoC'];
		 $ck_modificaC = $_POST['ck_modificaC'];
		 $ck_eliminaC = $_POST['ck_eliminaC'];
		 $ck_verC = $_POST['ck_verC'];
		 
		 
 $result = $obj_Menu->modifica_menu_categoria($id_Menu,$categoria,$nivel,$url_cat,$orden_cat,$ck_ingresoC,$ck_modificaC,$ck_eliminaC,$ck_verC,$i_id_categoria);
		 
	if($result){
		echo 1;
		 }else{
		echo 0;			
		 }
	}	
	
	
	if($funcion == 10){
		
		 $id_menu_categoria = $_POST['id_categoria'];
		 $result = $obj_Menu->eliminad_menu_categoria($id_categoria);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}	
	
	if($funcion==mmenu_item){
	   $result = $obj_Menu->carga_menu($id_menu);
		if($result){
		$select = "<select name='selectMenuItem' id='selectMenuItem' onchange='carga_categoria(this.value)' >
		<option value='0' select='select'  >Selecccionar</option>";
		for($i=0;$i<@pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_menu']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre']))))."</option>";
			
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
			
		 }else{
            
		 echo 0;			
			
		 }
			
     } // fin funcion
 
 
 
 	if($funcion==selectCat){
	   $result = $obj_Menu->carga_menu_categoria($id_menu);
		if($result){
		$select = "<select name='selectCategoria' id='selectCategoria' onchange='' >
		<option value='0' select='select'  >Selecccionar</option>";
		for($i=0;$i<@pg_numrows($result);$i++){
			$fila=pg_fetch_array($result,$i);
			$select .= "<option value='".$fila['id_categoria']."'>".ucwords(strtolower(htmlentities(trim($fila['nombre_categoria']))))."</option>";
			
		 }  // for 2 
		 $select .= "</select>"; 
		 echo $select;
			
		 }else{
            
		 echo 0;			
			
		 }
			
     } // fin funcion
	 
	 
	 if($funcion == 11){
		 $id_Menu=$_POST['id_Menu'];
		 $categoria=$_POST['categoria'];
		 $nombre_item=$_POST['nombre_item'];
		 $nivel = $_POST['nivel'];
		 $url_item = $_POST['url_item'];
		 $orden_Item = $_POST['orden_Item'];
		 $ck_ingresoI = $_POST['ck_ingresoI'];
		 $ck_modificaI = $_POST['ck_modificaI'];
		 $ck_eliminaI = $_POST['ck_eliminaI'];
		 $ck_verI = $_POST['ck_verI'];
		 
		 
 $result = $obj_Menu->guarda_menu_item($id_Menu,$categoria,$nombre_item,$nivel,$url_item,$orden_Item,$ck_ingresoI,$ck_modificaI,$ck_eliminaI,$ck_verI);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}	
	
	
	if ($funcion==12){ 
	?>
		
		<table width="800" border="1" align="center" cellpadding="5" cellspacing="0">
    <tr class="color_fondo">
    <td width="27%" >MEN&Uacute;</td>
    <td width="35%" >CATEGORIA</td>
    <td width="38%" >ITEM</td>
    </tr>
    <? 
	 $sql="SELECT id_menu,nombre,orden FROM cede.menu ORDER BY orden ASC;"; 
	$rs_menu = @pg_Exec($obj_Menu->Conec->conectar(),$sql);	
	for($i=0;$i<@pg_numrows($rs_menu);$i++){
    $fila_menu = @pg_fetch_array($rs_menu,$i);
    ?>		
    <tr>
    <td>&nbsp;(<?=$fila_menu['orden'];?>)&nbsp;<?=$fila_menu['nombre'];?></td>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <?  $sql = "SELECT id_categoria,nombre_categoria,orden_categoria FROM cede.menu_categoria WHERE id_menu=".$fila_menu['id_menu'];
	$rs_categoria = @pg_Exec($obj_Menu->Conec->conectar(),$sql);	
        for($j=0;$j<@pg_numrows($rs_categoria);$j++){
    $fila_cat = @pg_fetch_array($rs_categoria,$j);
    ?>
    <tr>
    <td width="47%" valign="top">&nbsp;(<?=$fila_cat['orden_categoria'];?>)&nbsp;<?=$fila_cat['nombre_categoria'];?></td>
    <td width="53%">
    <table width="100%" border="0" cellspacing="0" cellpadding="5">
    <?  $sql ="SELECT id_item,nombre_item,orden_item FROM cede.menu_categ_item WHERE id_categoria=".$fila_cat['id_categoria']." ORDER BY orden_item ASC";
	$rs_item = @pg_Exec($obj_Menu->Conec->conectar(),$sql);
    for($x=0;$x<@pg_numrows($rs_item);$x++){
    $fila_item = @pg_fetch_array($rs_item,$x);
    ?>
    <tr> 
    <td width="74%">&nbsp;(<?=$fila_item['orden_item'];?>)&nbsp;<?=$fila_item['nombre_item'];?></td>
   <td width="13%"><input name="cb_mod_cat" type="button" id="cb_mod_cat" value="M" onclick='Busca_Menu_item(<?=$fila_item['id_item']?>)'/></td>
<td width="13%"><input name="cb_eli_cat" type="button" id="cb_eli_cat" value="E" onclick='EliminarMenu_item(<?=$fila_item['id_item']?>)'/></td>
    </tr>
    <? } ?>
    </table>
    </td>
    </tr>
    <? } ?>
    </table>
    </td>
    </tr>
    <? } ?>
    </table> 
    <?
		}
		
		
		
		if($funcion == 13){
		 $id_categoria = $_POST['id_item'];
		$result = $obj_Menu->Busca_menu_item($id_item);
	if($result){
		if(@pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id_itemI" type="hidden" value="'.$fila['id_item'].'" />';
				echo '<input id="_id_categoriaI" type="hidden" value="'.$fila['id_categoria'].'" />';
				echo '<input id="_nombre_categoriaI" type="hidden" value="'.$fila['nombre_categoria'].'" />';
				echo '<input id="_menu_categoriaI" type="hidden" value="'.$fila['id_menu'].'" />';
				echo '<input id="_categoriaI" type="hidden" value="'.$fila['nombre_item'].'" />';
				echo '<input id="_urlI" type="hidden" value="'.$fila['url'].'" />';
				echo '<input id="_nivelI" type="hidden" value="'.$fila['nivel'].'" />';
				echo '<input id="_ordenI" type="hidden" value="'.$fila['orden_categoria'].'" />';
				echo '<input id="_ck_ingresoI" type="hidden" value="'.$fila['bool_i'].'" />';
				echo '<input id="_ck_modificaI" type="hidden" value="'.$fila['bool_m'].'" />';
				echo '<input id="_ck_eliminaI" type="hidden" value="'.$fila['bool_e'].'" />';
				echo '<input id="_ck_verI" type="hidden" value="'.$fila['bool_v'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
 }
 
 	if($funcion == 14){
		
		 $id_item = $_POST['id_item'];
		 $result = $obj_Menu->eliminad_menu_item($id_item);
		 
	if($result){
		echo 1;
		 }else{
            
		echo 0;			
		 }
	}	
 
	 
 ?>