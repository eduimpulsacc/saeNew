<?
 require("../../util/header.php");
 require("mod_categoria.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_categoria = new Categoria();
 
 
 if($funcion==1){
	 $rs_listado = $ob_categoria->Listado($conn,$rdb);
	 
	 
?>
<table width="95%" border="0">
      <tr>
       <tr>
        <td align="center" class="titulos-respaldo"><p>MANTENEDOR DE CATEGORIAS</p></td>
  </tr>
        <td align="right"><a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" title="AGREGAR" onClick="Nuevo()"></a></td>
      </tr>
    </table>

<table width="95%" border="1" style="border-collapse:collapse" align="center">
  <tr class="cuadro02">
    <td>Nº</td>
    <td>NOMBRE CATEGORIA</td>
    <td>OPCIONES</td>
  </tr>
  <? for($i=0;$i<pg_numrows($rs_listado);$i++){
	  	$fila = pg_fetch_array($rs_listado,$i);
  ?>
  <tr class="cuadro01">
    <td>&nbsp;<?=$i+1;?></td>
    <td>&nbsp;<?=$fila['nombre'];?></td>
    <td>
    <a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/edit.png" width="24" height="24" onClick="Modifica(<?=$fila['id_categoria'];?>)"></a>
    
    </td>
  </tr>
  <? } ?>
</table><br>
<br>

<? 
 }
 
 if($funcion==2){
?>
<table width="95%" border="0" cellpadding="3">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">NOMBRE CATEGORIA</td>
    <td class="cuadro02">:</td>
    <td class="cuadro01"><input type="text" name="txtNOMBRE" id="txtNOMBRE"></td>
  </tr>
  
</table>


<?
	 
 }
 
 if($funcion==3){
		$rs_insert = $ob_categoria->Agregar($conn,$nombre,$rdb);
		
		if($rs_insert){
			echo 1;	
		}else{
			echo 0;
		}
 }
 
 if($funcion==4){
	 
	  $rs_listado = $ob_categoria->Listado($conn,$_INSTIT);
?>
<select name="cmbCATEGORIA" id="cmbCATEGORIA">
      <option value="0">Seleccione...</option>
     <?php  for($c=0;$c<pg_numrows($rs_listado);$c++){
		 $fil_c = pg_fetch_array($rs_listado,$c);
		 ?>
     <option value="<?php echo $fil_c['id_categoria'] ?>"><?php echo $fil_c['nombre'] ?></option>
     <?php }?>
      </select>


<?
	 
 }
 if($funcion==5){
$dato = $ob_categoria->dcategoria($conn,$id);
?>
<table width="95%" border="0" cellpadding="3">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">NOMBRE CATEGORIA</td>
    <td class="cuadro02">:</td>
    <td class="cuadro01"><input type="text" name="txtNOMBRE" id="txtNOMBRE" value="<?php echo pg_result($dato,1) ?>">
    <input name="ida" type="hidden" id="ida" value="<?php echo pg_result($dato,0); ?>" /></td>
  </tr>
  
</table>
<?
}
if($funcion==6){
	$rs_update = $ob_categoria->upcategoria($conn,$id,$nombre);
		
		if($rs_update){
			echo 1;	
		}else{
			echo 0;
		}
}
 if($funcion==7){
	 
	  $rs_listado = $ob_categoria->Listado($conn,$_INSTIT);
?>
<select name="cmbCATEGORIA[]" size="8" multiple="multiple" id="cmbCATEGORIA" style="width:250px">
     
     <?php  for($c=0;$c<pg_numrows($rs_listado);$c++){
		 $fil_c = pg_fetch_array($rs_listado,$c);
		 ?>
     <option value="<?php echo $fil_c['id_categoria'] ?>"><?php echo $fil_c['nombre'] ?></option>
     <?php }?>
      </select>


<?
	 
 }
 
 ?>