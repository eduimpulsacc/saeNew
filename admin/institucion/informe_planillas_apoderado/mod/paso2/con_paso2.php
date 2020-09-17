<?php  require('../../../../../util/header.inc');
$institucion=$_INSTIT;
$ano = $_ANO;

session_start();
require "../../Class/mod_plantillas.php";
$obj_informe = new informeApo();


foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
    eval($asignacion); 
 // echo  $asignacion."<br>";
  
   
}

if($funcion==1){ 

	//var_dump($_POST);
	$rs_registro=$obj_informe->ing_item($conn,$plantilla,$area,$nombre);
	if($rs_registro){
	echo 1;		
	}else{
		echo 0;
	}
}


if($funcion==2){
	//var_dump($_POST);
	$rs_area=$obj_informe->getAreas($conn,$plantilla);
	if($rs_area){
		for($a=0;$a<pg_numrows($rs_area);$a++){
			$fil_area = pg_fetch_array($rs_area,$a);
		$rs_item=$obj_informe->getConcepto($conn,$fil_area['id_plantilla'],$fil_area['id_area']);	
			?>
<form id="itm">
            <input type="hidden" name="id" />
  <table width="650" border="1" style="border-collapse:collapse">
    <tr>
    <td colspan="2"><strong><?php echo strtoupper($fil_area['nombre']) ?></strong></td>
    </tr>
  <?php if(pg_numrows($rs_item)>0){
	  for($i=0;$i<pg_numrows($rs_item);$i++){
			$fil_item = pg_fetch_array($rs_item,$i);?>
  <tr>
    <td>
      <input type="hidden" name="iditem[]" value="<?php echo $fil_item['id_item'] ?>" id="iditem_<?php echo $fil_item['id_item'] ?>">
      <textarea name="item[]" cols="50" id="item<?php echo $i ?>" style="margin: 0px; width: 493px; height: 119px;"><?php echo utf8_decode($fil_item['nombre']) ?></textarea></td>
    <td>
      <input type="button" name="button" id="button" value="Eliminar" onclick="eliminaIndicador(<?php echo $fil_item['id_item'] ?>)" /></td>
  </tr>
  <?php }
  }else{?>
   <tr>
    <td>Sin &iacute;tems asosciados</td>
    <td>&nbsp;</td>
   </tr>
  <?php }}?>
</table>
</form>
	<?
	}else{
		echo 0;
	}
}

if($funcion==3){
	var_dump($_POST);
	for($f=0;$f<count($_POST['iditem']);$f++){
		$iditem= $_POST['iditem'][$f];
		$nombre = $_POST['item'][$f];
		 $rs_update =  $obj_informe->ActualizaItem($conn,$nombre,$iditem);
	}
}

if($funcion==4){
	//var_dump($_POST);
	$rs_alimina=$obj_informe->elimina_item($conn,$item);
	if($rs_alimina){
	echo 1;		
	}else{
		echo 0;
	}
}

if($funcion==10){
	$rs_registro=$obj_informe->nuevaArea($conn,$plantilla,$nombre);
	
if($rs_registro){
	echo 1;		
	}else{
		echo 0;
	}

}

if($funcion==11){
	$rs_area = $obj_informe->getAreas($conn,$plantilla);
	
if($rs_area){?>
	 <select name="cmbArea" id="cmbArea">
    <option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_area);$i++){
				$fila_area = pg_Fetch_array($rs_area,$i);
		?>
        <option value="<?=$fila_area['id_area'];?>"><?=$fila_area['nombre'];?></option>
        <? } ?>
    </select>	
	<?php }else{
		echo 0;
	}

}

 ?>