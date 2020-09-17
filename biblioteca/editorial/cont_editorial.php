<?
 require("../../util/header.php");
 require("mod_editorial.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_editorial = new Editorial();
 
 
 if($funcion==1){
	 $rs_listado = $ob_editorial->Listado($conn,$rdb);
	 
	 
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
<table width="95%" border="0" align="center">
      <tr>
        <td align="center" class="titulos-respaldo"><p>MANTENEDOR DE EDITORIALES</p></td>
  </tr>
     
      <tr>
        <td align="right"><a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" title="AGREGAR" onClick="Nuevo()"></a></td>
      </tr>
    </table>

<table width="95%" border="1" style="border-collapse:collapse" align="center" id="mt">
 <tbody>
  <tr class="cuadro02 header">
    <th>N&ordm;</th>
    <th>NOMBRE EDITORIAL</th>
    <th>OPCIONES</th>
  </tr>
  <? for($i=0;$i<pg_numrows($rs_listado);$i++){
	  	$fila = pg_fetch_array($rs_listado,$i);
  ?>
  <tr class="cuadro01">
    <td>&nbsp;<?=$i+1;?></td>
    <td>&nbsp;<?=$fila['nombre'];?></td>
    <td>
    <a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/edit.png" width="24" height="24" onClick="Modifica(<?=$fila['id_editorial'];?>)"></a>

    </td>
  </tr>
  <? } ?>
  </tbody>
</table><br>
 <div id="green" style="margin: auto; width:750px" > </div><br>
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
    <td class="cuadro02">NOMBRE EDITORIAL</td>
    <td class="cuadro02">:</td>
    <td class="cuadro01"><input type="text" name="txtNOMBRE" id="txtNOMBRE"></td>
  </tr>
  
</table>


<?
	 
 }
 
 if($funcion==3){
		$rs_insert = $ob_editorial->Agregar($conn,$nombre,$rdb);
		
		if($rs_insert){
			echo 1;	
		}else{
			echo 0;
		}
 }
 if($funcion==4){
	 $rs_listado = $ob_editorial->Listado($conn,$_INSTIT);
	?>
    <select name="cmbEDITORIAL" id="cmbEDITORIAL">
       <option value="0">Seleccione...</option>
     <?php  for($e=0;$e<pg_numrows($rs_listado);$e++){
		 $fil_e = pg_fetch_array($rs_listado,$e);
		 ?>
     <option value="<?php echo $fil_e['id_editorial'] ?>"><?php echo $fil_e['nombre'] ?></option>
     <?php }?>
      </select>
    <? 
	}
 if($funcion==5){
$dato = $ob_editorial->deditorial($conn,$id);
?>
<table width="95%" border="0" cellpadding="3">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">NOMBRE EDITORIAL</td>
    <td class="cuadro02">:</td>
    <td class="cuadro01"><input type="text" name="txtNOMBRE" id="txtNOMBRE" value="<?php echo pg_result($dato,1) ?>">
    <input name="ida" type="hidden" id="ida" value="<?php echo pg_result($dato,0); ?>" /></td>
  </tr>
  
</table>
<?
}
if($funcion==6){
	$rs_update = $ob_editorial->upeditorial($conn,$id,$nombre);
		
		if($rs_update){
			echo 1;	
		}else{
			echo 0;
		}
}
 ?>