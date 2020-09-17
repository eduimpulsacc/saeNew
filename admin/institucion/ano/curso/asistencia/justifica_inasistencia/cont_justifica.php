<?php require("../../../../../../util/header.inc");
include_once('mod_justifica.php');

foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
}

$obj_justifica = new Justifica($conn,$connection);

if($funcion==1){
	$rs_tipo = $obj_justifica->tipoJustifica($_INSTIT);
	$rs_ano  = $obj_justifica->Ano_academico($_ANO);
	$rs_alu  = $obj_justifica->nomAlumno($r);
	
	$numero = cal_days_in_month(CAL_GREGORIAN, $m,  pg_result($rs_ano,0)); // 31
	
	$rs_historia = $obj_justifica->cargaHistoria($r,$ano,$_CURSO,pg_result($rs_ano,0)."-".$m."-01",pg_result($rs_ano,0)."-".$m."-$numero");
	
	?>
    <script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
    <script type="text/javascript" src="../../../../clases/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script>
      <script>
      $("#fecha_desde,#fecha_hasta").datepicker({
	showOn: 'both',
	changeYear:false,
	changeMonth:false,
	dateFormat: 'dd/mm/yy',
	minDate: new Date('<?php echo $m ?>/01/'+<?php echo pg_result($rs_ano,0)?>+''),
			maxDate: new Date('<?php echo $m ?>/<?php echo $numero ?>/'+<?php echo pg_result($rs_ano,0)?>+''),
	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
  firstDay: 1
	//buttonImage: 'img/Calendario.PNG',
	});
      </script>
      <style>
	  div.ui-datepicker{
 font-size:12px;
}
div.ui-dialog{
 font-size:12px;
}
	  </style>
      <form id="fjus"  enctype="multipart/form-data">
    <table width="80%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="tableindex">
    <td colspan="2">Ingresar justificaci&oacute;n
      
      <input type="hidden" name="rut_alumno" id="rut_alumno" value="<?php echo $r ?>" />
      
     
      </td>
    </tr>
  <tr class="cuadro01">
    <td class="cuadro01">Estudiante</td>
    <td class="cuadro01"><?php echo pg_result($rs_alu,0); ?>&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td width="19%" class="cuadro01">Fecha</td>
    <td width="81%" class="cuadro01">
    <input name="fecha_desde" type="text" class="cal" id="fecha_desde" readonly="readonly"> a 
    <input name="fecha_hasta" type="text" class="cal" id="fecha_hasta" readonly="readonly"></td>
  </tr>
  <tr class="cuadro01">
    <td>Tipo Inasistencia</td>
    <td><span id="tipoinas">
      <label for="tipo_jistifica"></label>
      <select name="tipo_jistifica" id="tipo_jistifica">
        <option value="0">Seleccione</option>
       <?php  for($t=0;$t<pg_numrows($rs_tipo);$t++){
		   $ft = pg_fetch_array($rs_tipo,$t);
		   ?>
         <option value="<?php echo $ft['id_tipo'] ?>"><?php echo $ft['nombre'] ?></option>
        <?php }?>
      </select></span>
      <span>
      <img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Add.png" width="24" height="24" border="0" onclick="IngresoTipo()" title="AGREGAR CITACION" style="cursor:pointer">
      </span>
      </td>
  </tr>
  <tr class="cuadro01">
    <td>Detalle</td>
    <td>
      <textarea name="descripcion" id="descripcion" style="margin: 0px; width: 397px; height: 91px;"></textarea></td>
  </tr>
  <tr class="cuadro01">
    <td class="cuadro01">Archivo</td>
    <td>
    <input type="file" name="archivo" id="archivo"><div id="err"></div></td>
  </tr>
</table>
</form>
<br>
<div id="hisj">
<table width="80%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td colspan="5" class="tableindex">Historial justifaci&oacute;n Mes</td>
  </tr>
  <tr class="cuadro02">
    <td>Desde</td>
    <td>Hasta</td>
    <td>Tipo Inasistencia</td>
    <td>Archivo</td>
    <td>Eliminar</td>
  </tr>
  <?php if(pg_numrows($rs_historia)==0){?>
  <tr class="cuadro01">
    <td colspan="5" align="center">Sin informaci&oacute;n</td>
    </tr>
    <?php }else{
		for($h=0;$h<pg_numrows($rs_historia);$h++){
			$fila_historia = pg_fetch_array($rs_historia,$h);
			$rs_tipo = $obj_justifica->tipoUno($fila_historia['tipo_justificacion']);
		?>
  <tr class="cuadro01">
    <td><?php echo CambioFD($fila_historia['fecha_desde'])?></td>
    <td><?php echo CambioFD($fila_historia['fecha_hasta'])?></td>
    <td><?php echo pg_result($rs_tipo,0) ?></td>
    <td align="center"><?php if(strlen($fila_historia['archivo'])>0){?><a href="justifica_inasistencia/archivos/<?php echo $fila_historia['archivo'] ?>" target="_blank">Descargar</a><?php }?></td>
    <td align="center"><input type="submit" name="button" id="button" value="X" class="botonXX" onclick="quitaHistoria(<?php echo $fila_historia['id_justifica_inasistencia_detalle'] ?>)"></td>
  </tr>
  <?php
		} //fin for
   }?>
</table>
</div>
    <?
}
if($funcion==2){
?>
<table width="80%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="cuadro01">
    <td width="63%">Nombre&nbsp;&nbsp;</td>
    <td width="37%">
    <input type="text" name="txt_nombre" id="txt_nombre" /></td>
  </tr>
</table>
<?
}
if($funcion==3){
$rs_guarda = $obj_justifica->creaTipo($nombre,$rbd);
echo ($rs_guarda)?1:0;
}
if($funcion==4){
$rs_tipo = $obj_justifica->tipoJustifica($_INSTIT);
?>
<select name="tipo_jistifica" id="tipo_jistifica">
        <option value="0">Seleccione</option>
       <?php  for($t=0;$t<pg_numrows($rs_tipo);$t++){
		   $ft = pg_fetch_array($rs_tipo,$t);
		   ?>
         <option value="<?php echo $ft['id_tipo'] ?>"><?php echo $ft['nombre'] ?></option>
        <?php }?>
      </select>
<?
}
if($funcion==5){
$dir ="archivos/";

$fd = CambioFE($fdesde);
$fh = CambioFE($fhasta);

function obtenerExtensionFichero($str)
{
        return end(explode(".", $str));
}
$nombre="";
if(isset($_FILES['archivo']['name'])){
$extension = obtenerExtensionFichero($_FILES['archivo']['name']);


$nombre="Jus".date("Ymdhis").$rut.$curso.".".$extension;
$tempFile= $_FILES['archivo']['tmp_name'];
$targetFile = $dir.$nombre;


move_uploaded_file($tempFile,$targetFile);
}

$guarda = $obj_justifica->guardaHistoria($rut,$_ANO,$curso,$fd,$fh,$tipo,$detalle,$nombre);
 echo ($guarda)?1:0;
}
if($funcion==6){
$his = $obj_justifica->historiaUno($id);
$arc = pg_result($his,8);
if(is_file("archivos/".$arc)){
unlink ("archivos/".$arc);
}
$del=$obj_justifica->delhistoriaUno($id);
echo($del)?1:0;
}
if($funcion==7){
	
	$rs_ano  = $obj_justifica->Ano_academico($_ANO);
	
	
	$numero = cal_days_in_month(CAL_GREGORIAN, $mes,  pg_result($rs_ano,0)); // 31
	
	$rs_historia = $obj_justifica->cargaHistoria($rut,$_ANO,$_CURSO,pg_result($rs_ano,0)."-".$mes."-01",pg_result($rs_ano,0)."-".$mes."-$numero");
	?>
    <table width="80%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr>
    <td colspan="5" class="tableindex">Historial justifaci&oacute;n Mes</td>
  </tr>
  <tr class="cuadro02">
    <td>Desde</td>
    <td>Hasta</td>
    <td>Tipo Inasistencia</td>
    <td>Archivo</td>
    <td>Eliminar</td>
  </tr>
  <?php if(pg_numrows($rs_historia)==0){?>
  <tr class="cuadro01">
    <td colspan="5" align="center">Sin informaci&oacute;n</td>
    </tr>
    <?php }else{
		for($h=0;$h<pg_numrows($rs_historia);$h++){
			$fila_historia = pg_fetch_array($rs_historia,$h);
			$rs_tipo = $obj_justifica->tipoUno($fila_historia['tipo_justificacion']);
		?>
  <tr class="cuadro01">
    <td><?php echo CambioFD($fila_historia['fecha_desde'])?></td>
    <td><?php echo CambioFD($fila_historia['fecha_hasta'])?></td>
    <td><?php echo pg_result($rs_tipo,0) ?></td>
    <td align="center"><?php if(strlen($fila_historia['archivo'])>0){?><a href="justifica_inasistencia/archivos/<?php echo $fila_historia['archivo'] ?>" target="_blank">Descargar</a><?php }?></td>
    <td align="center"><input type="submit" name="button" id="button" value="X" class="botonXX" onclick="quitaHistoria(<?php echo $fila_historia['id_justifica_inasistencia_detalle'] ?>)"></td>
  </tr>
  <?php
		} //fin for
   }?>
</table>
    <?
}
?>