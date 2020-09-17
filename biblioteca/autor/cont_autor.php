<?
 require("../../util/header.php");
 require("mod_autor.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_autor = new Autor();
 
 
 if($funcion==1){
	 $rs_listado = $ob_autor->Listado($conn,$_INSTIT);
	 
	 
?>
 <link rel="stylesheet" type="text/css" href="../../admin/clases/smartpaginator/smartpaginator.css">
<script src="../../admin/clases/smartpaginator/smartpaginator.js"></script>
<script>
 $(document).ready(function() {//pg_numrows($rs_listado)
 
               $('#green').smartpaginator({ totalrecords: <?php echo pg_numrows($rs_listado) ?>,

                                      recordsperpage: 30, 

                                      datacontainer: 'mt', 

                                      dataelement: 'tr',

                                      theme: 'red' });

        });
</script>
<table width="95%" border="0">
      <tr>
       <tr>
        <td align="center" class="titulos-respaldo"><p>MANTENEDOR DE AUTORES</p></td>
  </tr>
        <td align="right"><a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" title="AGREGAR" onClick="Nuevo()"></a></td>
      </tr>
    </table>

<table width="95%" border="1" style="border-collapse:collapse" align="center" id="mt">
<tbody>
  <tr class="cuadro02 header">
    <th>N&ordm;</th>
    <th>NOMBRE AUTOR</th>
    <th>NACIONALIDAD</th>
    <th>OPCIONES</th>
  </tr>
  <? for($i=0;$i<pg_numrows($rs_listado);$i++){
	  	$fila = pg_fetch_array($rs_listado,$i);
  ?>
  <tr class="cuadro01">
    <td>&nbsp;<?=$i+1;?></td>
    <td>&nbsp;<?=$fila['nombre'];?></td>
    <td>&nbsp;<?=$fila['nacionalidad']=(strlen($fila['nacionalidad'])>0)?$fila['nacionalidad']:"S/I";?></td>
    <td>
    <a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/edit.png" width="24" height="24" onClick="edita(<?=$fila['id_autor'];?>)"></a>
    <a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Delete.png" width="24" height="24" onClick="Elimina(<?=$fila['id_autor'];?>)"></a>
    </td>
  </tr>
  <? } ?>
  </tbody>
</table><br>
<br>
 <div id="green" style="margin: auto; width:750px" > </div>
<? 
 }
 
 if($funcion==2){
?>
<table width="95%" border="0" cellpadding="3">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">NOMBRE AUTOR</td>
    <td class="cuadro02">:</td>
    <td class="cuadro01"><input type="text" name="txtNOMBRE" id="txtNOMBRE"></td>
  </tr>
  <tr>
    <td class="cuadro02">NACIONALIDAD</td>
    <td class="cuadro02">:</td>
    <td class="cuadro01"><input type="text" name="txtNACIONALIDAD" id="txtNACIONALIDAD"></td>
  </tr>
</table>


<?
	 
 }
 
 if($funcion==3){
	 $nacio = (strlen($nacio)>0)?$nacio:"";
	 
		$rs_insert = $ob_autor->Agregar($conn,$nombre,$nacio,$rdb);
		
		if($rs_insert){
			echo 1;	
		}else{
			echo 0;
		}
 }
 
 if($funcion==4){
	 
	  $rs_listado = $ob_autor->Listado($conn,$_INSTIT);
?>
<select name="cmbAUTOR" id="cmbAUTOR">
      <option value="0">Seleccione...</option>
     <?php  for($a=0;$a<pg_numrows($rs_listado);$a++){
		 $fil_a = pg_fetch_array($rs_listado,$a);
		 ?>
     <option value="<?php echo $fil_a['id_autor'] ?>"><?php echo $fil_a['nombre'] ?></option>
     <?php }?>
</select>


<?
	 
 }
 if($funcion==5){

$dato = $ob_autor->autor($conn,$id);
?>
<table width="95%" border="0" cellpadding="3">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">NOMBRE AUTOR</td>
    <td class="cuadro02">:</td>
    <td class="cuadro01"><input name="ida" type="hidden" id="ida" value="<?php echo pg_result($dato,0); ?>" />      <input type="text" name="txtNOMBRE" id="txtNOMBRE" value="<?php echo pg_result($dato,1); ?>"></td>
  </tr>
  <tr>
    <td class="cuadro02">NACIONALIDAD</td>
    <td class="cuadro02">:</td>
    <td class="cuadro01"><input type="text" name="txtNACIONALIDAD" id="txtNACIONALIDAD"  value="<?php echo pg_result($dato,2); ?>"></td>
  </tr>
</table>
<?
}
 if($funcion==6){


$rs_update = $ob_autor->upautor($conn,$id,$nombre,$nacio);
		
		if($rs_update){
			echo 1;	
		}else{
			echo 0;
		}

}if($funcion==7){
	$rs_update = $ob_autor->eliautor($conn,$id);
		
		if($rs_update){
			echo 1;	
		}else{
			echo 0;
		}
}
if($funcion==8){
	 
	  $rs_listado = $ob_autor->Listado($conn,$_INSTIT);
?>
<select name="cmbAUTOR[]" size="8" multiple="multiple" id="cmbAUTOR" style="width:250px">
      
     <?php  for($a=0;$a<pg_numrows($rs_listado);$a++){
		 $fil_a = pg_fetch_array($rs_listado,$a);
		 ?>
     <option value="<?php echo $fil_a['id_autor'] ?>"><?php echo $fil_a['nombre'] ?></option>
     <?php }?>
</select>


<?
	 
 }
 ?>