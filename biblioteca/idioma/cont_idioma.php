<?
 require("../../util/header.php");
 require("mod_idioma.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_idioma = new Idioma();
 
 
 if($funcion==1){
	 $rs_listado = $ob_idioma->Listado($conn,$rdb);
	 
	 
?>
<table width="95%" border="0">
      <tr>
       <tr>
        <td align="center" class="titulos-respaldo"><p>MANTENEDOR DE IDIOMAS</p></td>
  </tr>
        <td align="right"><a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" title="AGREGAR" onClick="Nuevo()"></a></td>
      </tr>
    </table>

<table width="95%" border="1" style="border-collapse:collapse" align="center">
  <tr class="cuadro02">
    <td>Nº</td>
    <td>NOMBRE IDIOMA</td>
    <td>OPCIONES</td>
  </tr>
  <? for($i=0;$i<pg_numrows($rs_listado);$i++){
	  	$fila = pg_fetch_array($rs_listado,$i);
  ?>
  <tr class="cuadro01">
    <td>&nbsp;<?=$i+1;?></td>
    <td>&nbsp;<?=$fila['nombre'];?></td>
    <td>
    <a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/edit.png" width="24" height="24" onClick="Modifica(<?=$fila['id_idioma'];?>)"></a>
   
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
    <td class="cuadro02">NOMBRE IDIOMA</td>
    <td class="cuadro02">:</td>
    <td class="cuadro01"><input type="text" name="txtNOMBRE" id="txtNOMBRE"></td>
  </tr>
  
</table>


<?
	 
 }
 
 if($funcion==3){
		$rs_insert = $ob_idioma->Agregar($conn,$nombre,$rdb);
		
		if($rs_insert){
			echo 1;	
		}else{
			echo 0;
		}
 }
 
 if($funcion==4){
	  $rs_idi = $ob_idioma->Listado($conn,$_INSTIT);
	?>
    <select name="cmbIDIOMA" id="cmbIDIOMA">
       <option value="0">Seleccione...</option>
      <?php  for($i=0;$i<pg_numrows($rs_idi);$i++){
		 $fil_i = pg_fetch_array($rs_idi,$i);
		 ?>
     <option value="<?php echo $fil_i['id_idioma'] ?>"><?php echo $fil_i['nombre'] ?></option>
     <?php }?>
      </select>
    <?
	}
  if($funcion==5){
$dato = $ob_idioma->didioma($conn,$id);
?>
<table width="95%" border="0" cellpadding="3">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">NOMBRE IDIOMA</td>
    <td class="cuadro02">:</td>
    <td class="cuadro01"><input type="text" name="txtNOMBRE" id="txtNOMBRE" value="<?php echo pg_result($dato,1) ?>">
    <input name="ida" type="hidden" id="ida" value="<?php echo pg_result($dato,0); ?>" /></td>
  </tr>
  
</table>
<?
}
if($funcion==6){
	$rs_update = $ob_idioma->upidioma($conn,$id,$nombre);
		
		if($rs_update){
			echo 1;	
		}else{
			echo 0;
		}
}
 ?>