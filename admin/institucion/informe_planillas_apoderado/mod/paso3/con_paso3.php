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

$rs_ingreso = $obj_informe->IngresoConcepto($conn,$plantilla,$nombre,$sigla,$glosa);
if($rs_ingreso){
	echo 1;
	
	}else{
		echo 0;
	}

}

if($funcion==2){ 


$rs = $obj_informe->ListaConcepto($conn,$plantilla);
if($rs){?>

	<table width="650" border="0" cellpadding="0" cellspacing="0" class="textosesion">
     <tr class="tableindex">
    <td width="157" align="center">Nombre</td>
    <td width="178" align="center">Sigla</td>
    <td width="183" align="center">Glosa</td>
 
 
    <td colspan="2" align="center">&nbsp;</td>
    </tr>
	<?php
		for($i=0;$i<pg_numrows($rs);$i++){
			$fila_con = pg_fetch_array($rs,$i);
		?>
	
  <tr>
    <td width="157"><input name="txt_nombre<?php echo $fila_con['id_concepto'] ?>" type="hidden" id="txt_nombre<?php echo $fila_con['id_concepto'] ?>" value="<?php echo $fila_con['nombre'] ?>"><div id="nombre_<?php echo $fila_con['id_concepto'] ?>"><?php echo $fila_con['nombre'] ?></div></td>
    <td width="178"><input name="txt_sigla<?php echo $fila_con['id_concepto'] ?>" type="hidden" id="txt_sigla<?php echo $fila_con['id_concepto'] ?>" value="<?php echo $fila_con['sigla'] ?>"><div id="sigla_<?php echo $fila_con['id_concepto'] ?>"><?php echo $fila_con['sigla'] ?></div></td>
    <td width="183">
    <input name="txt_glosa<?php echo $fila_con['id_concepto'] ?>" type="hidden" id="txt_glosa<?php echo $fila_con['id_concepto'] ?>" value="<?php echo utf8_decode($fila_con['glosa']) ?>" style="width:250px">
    <div id="glosa_<?php echo $fila_con['id_concepto'] ?>"><?php echo utf8_decode($fila_con['glosa']) ?></div></td>
 
 
    <td width="68" align="center"><div id="div_<?php echo $fila_con['id_concepto'] ?>">
      <input type="button" name="button" id="button" value="Modificar" onClick="modificaConcepto(<?php echo $fila_con['id_concepto'] ?>)">
    </div></td>
    <td width="64" align="center"><div id="div2_<?php echo $fila_con['id_concepto'] ?>">
      <input type="button" name="button2" id="button2" value="Eliminar" onclick="eliminaIndicador(<?php echo $fila_con['id_concepto'] ?>)">
    </div></td>
   </tr>
<?php 
		}
	
	//echo 1;?>
	</table>		
	<?php }else{
		echo 0;
	}

}
//modificar
if($funcion==3){ 
$rs_mod=$obj_informe->modificaConcepto($conn,$id_concepto,$nombre,$sigla,$glosa);
echo ($rs_mod)?1:0;
}
//eliminar
if($funcion==4){
	$rs_elim=$obj_informe->eliminaConcepto($conn,$id_concepto);
	echo ($rs_elim)?1:0;
}

?>