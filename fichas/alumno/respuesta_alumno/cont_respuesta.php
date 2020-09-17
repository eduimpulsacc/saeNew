<?php 
session_start();
require("../../../util/header.inc");
require("mod_respuesta.php");

$ob_respuesta = new cargaFile();
 
 
foreach($_POST as $nombre_campo => $valor){
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion); 
}

if($funcion==1){
	//show($_POST);
$rs_File = $ob_respuesta->getFileSubject($conn,$ida);
$fila_arc = pg_fetch_array($rs_File,0);
$rs_upV = $ob_respuesta->actVista($conn,$nano,$al,$ida);
?>

<form enctype="multipart/form-data" id="formuploadajax" method="post" action="">
<input type="hidden" id="far" value="<?php echo $ida ?>" />
<input type="hidden" id="al" value="<?php echo $al ?>" />
<table width="400" border="1" cellspacing="0" cellpadding="0" cl>
  <tr>
    <td width="133" class="cuadro02">T&iacute;tulo</td>
    <td width="261" class="cuadro01"><?php echo $fila_arc['titulo'] ?></td>
  </tr>
  <tr>
    <td class="cuadro02">Descripci&oacute;n</td>
    <td class="cuadro01"><?php echo $fila_arc['descripcion_archivo'] ?></td>
  </tr>
  <tr>
    <td class="cuadro02">Fecha Asignaci&oacute;n</td>
    <td class="cuadro01"><?php echo CambioFD($fila_arc['fecha']) ?></td>
  </tr>
  <tr>
    <td class="cuadro02">Fecha Entrega</td>
    <td class="cuadro01"><?php echo CambioFD($fila_arc['fecha_entrega']) ?></td>
  </tr>
  <tr>
    <td class="cuadro02">Web 1</td>
    <td class="cuadro01"><?php echo $fila_arc['web1'] ?></td>
  </tr>
  <tr>
    <td class="cuadro02">Web 2</td>
    <td class="cuadro01"><?php echo $fila_arc['web2'] ?></td>
  </tr>
  <tr>
    <td class="cuadro02">Web 3</td>
    <td class="cuadro01"><?php echo $fila_arc['web3'] ?></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">Archivo</td> 
    <td class="cuadro01">
   <?php  if( is_file("../../../tmp/".trim($fila_arc['nombre_archivo']))){?>																					<a style="font-size:10px;cursor:pointer"  href="../tmp/<?php echo trim($fila_arc['nombre_archivo'])?>" onmouseover=this.style.cursor='hand' title="Descargar" target="_blank"> <?php echo  trim($fila_arc['nombre_archivo']); ?>

    <?php }else{
		echo  trim($fila_arc['nombre_archivo']);
		}?>
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2" class="cuadro02">Subir Archivo Respuesta</td>
  </tr>
  
  <tr>
    <td colspan="2" class="cuadro01"><input type="file" id="are" name="are" />
    <!--  <input type="button" name="env" id="env" value="Enviar" onclick="sendFile()" class="botonXX" />--></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr> 
  <tr>
    <td class="cuadro02">Archivo Respuesta</td>
    <td class="cuadro01">
    <div id="muestraResp">
    <?php 
    $fant = $ob_respuesta->getFileRespuesta($conn,$al,$ida); 
   if(pg_numrows($fant)>0){?>
   <a href="alumno/respuesta_alumno/cargaFile/<?php echo pg_result($fant,0) ?>" style="cursor:pointer;font-size:10px;" target="_blank"><?php echo pg_result($fant,0) ?></a>
   
   <?php }?>
   </div>
   </td>
  </tr>
 
 
</table>
</form>
<?
$rs_File2 = $ob_respuesta->countVista($conn,$nano,$al,$ida);
//$fila_arc2 = pg_fetch_array($rs_File2,0);
?>
<script>
$( document ).ready(function() {
    listaFRamo(<?php echo $rm ?>,<?php echo pg_result($rs_File2,0) ?>);
});
</script>
<?	
}
if($funcion==2){ 

$archivo = $_FILES['archivo']['tmp_name'];

$dir = "cargaFile/";

$newPath = $dir.$idarchivo."_".$rut."_".date("YmdHis").".".$ext;
$newName = $idarchivo."_".$rut."_".date("YmdHis").".".$ext;
$error=0;

if (!copy($archivo, $newPath)) {
	$error="No se pudo subir archivo";
}
else{
//$error="si se subio";
//buscar archivo anterior 
$fileAnt = $ob_respuesta->fExist($conn,$idarchivo,$rut);


if(pg_numrows($fileAnt)>0){
$ruta= pg_result($fileAnt,0);

if(is_file($dir.$ruta)){
unlink($dir.$ruta);
}	
	
	
$rs_up = $ob_respuesta->modFile($conn,$idarchivo,$rut,$newName);

}else{
$rs_up = $ob_respuesta->createFile($conn,$idarchivo,$rut,$newName);

}

$error=($rs_up)?1:0;

}
echo  $error;
}
if($funcion==3){
	//show($_POST);
    $fant = $ob_respuesta->getFileRespuesta($conn,$al,$ida); 
   if(pg_numrows($fant)>0){?>
   <a href="../alumno/respuesta_alumno/cargaFile/<?php echo pg_result($fant,0) ?>" style="cursor:pointer;font-size:10px;" target="_blank" ><?php echo pg_result($fant,0) ?></a>
   
  <?
}
}
  ?>