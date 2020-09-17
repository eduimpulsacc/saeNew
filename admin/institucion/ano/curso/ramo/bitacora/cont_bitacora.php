<?php  session_start();
require('../../../../../../util/header.inc');
include('mod_bitacora.php');


foreach($_POST as $nombre_campo => $valor){
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion);
}

$ob_bitacora = new Bitacora();

if($funcion==1){
	
	//show($_POST);
$rs_ramo  = $ob_bitacora->getDataRamo($conn,$ramo);
$rs_dicta = $ob_bitacora->getDicta($conn,$ramo);
$rs_curso = $ob_bitacora->getDataCurso($conn,$curso);
$rs_periodo = $ob_bitacora->getPeriodo($conn,$_ANO);

$ensenanza = pg_result($rs_curso,0);
$nivel = pg_result($rs_curso,1);

?>

<input type="hidden" id="rm" value="<?php echo $ramo ?>" />
<input type="hidden" id="cr" value="<?php echo $curso ?>" />
<table width="98%" align="center" border="1" style="border-collapse:collapse">
  <tr>
    <td width="93" class="tableindex">Curso</td>
    <td width="541"><?php echo CursoPalabra($curso,1,$conn) ?>&nbsp;</td>
  </tr>
  <tr>
    <td class="tableindex">Asignatura</td>
    <td><?php echo pg_result($rs_ramo,0); ?></td>
  </tr>
  <tr>
    <td class="tableindex">Docente</td>
    <td><?php echo trim(pg_result($rs_dicta,0)) ?> <?php echo trim(pg_result($rs_dicta,1)) ?>, <?php echo trim(pg_result($rs_dicta,2)) ?></td>
  </tr>
  <tr>
    <td class="tableindex">Periodo</td>
    <td>
      <select name="cmb_periodo" id="cmb_periodo" onchange="listaAct(this.value)">
      <option value="0">Selecione periodo</option>
      <?php for($p=0;$p<pg_numrows($rs_periodo);$p++){
		  $fila_periodo = pg_fetch_array($rs_periodo,$p);?>
      <option value="<?php echo $fila_periodo['id_periodo'] ?>"><?php echo $fila_periodo['nombre_periodo'] ?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><input type="button" name="button" id="button" value="Nueva Actividad" class="botonXX" onclick="nuevaACT()" /></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div id="lact">&nbsp;</div>
    
    </td>
  </tr>
</table>

<?
}
if($funcion==2){
	
	if($periodo!=0){
		$rs_bita = $ob_bitacora->getBitacora($conn,$ramo,$periodo);
		
			
		$ense = $ob_bitacora->getEnsenanzabyCurso($conn,$curso);
		
	?>
    <table width="98%" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="tableindex">
    <td align="center">Fecha</td>
    <td width="35%" align="center"><?php echo ($ense==10)?"N&uacute;cleo":"Unidad" ?></td>
   
    <td width="35%" align="center">Observacion</td>
    <td colspan="30%" align="center">Acciones</td>
  </tr>
<?php   
if(pg_numrows($rs_bita)>0){
for($b=0;$b<pg_numrows($rs_bita);$b++){
	$fila_bita  = pg_fetch_array($rs_bita,$b);
	$unidad = $fila_bita['id_unidad']; 
	$d_unidad = $ob_bitacora->getUnidadbyID($conn,$unidad);
	?>
  <tr>
    <td><?php echo CambioFD($fila_bita['fecha']); ?></td>
    <td><?php echo ($unidad>0)?pg_result($d_unidad,2):"Sin informaci&oacute;n"; ?></td>
    <td><?php echo cortar_palabras(($fila_bita['texto']), 10);  ?></td>
    <td align="center"><input type="button" name="button2" id="button2" value="D" class="botonXX" title="Ver detalle actividad" onclick="verAct(<?php echo $fila_bita['id_bitacora'] ?>)" /></td>
    <td align="center"><input type="button" name="button3" id="button3" value="E" class="botonXX" title="Editar datos actividad" onclick="ediAct(<?php echo $fila_bita['id_bitacora'] ?>)" /></td>
    <td align="center"><input type="button" name="button4" id="button4" value="X" class="botonXX" title="Elminar actividad" onclick="delAct(<?php echo $fila_bita['id_bitacora'] ?>)" /></td>
  </tr>
 <?php  }
}else{?>
<tr>
    <td colspan="8" align="center"><font style="font-size:18px !important">Sin informaci&oacute;n</font></td>
    </tr>
	<?php }?>
</table>
<? }

    
}
if($funcion==3){
	//show($_POST);
	
	$rs_curso = $ob_bitacora->getDataCurso($conn,$curso);
	$rs_periodo = $ob_bitacora->getPeriodo($conn,$_ANO);
	$rs_ramo  = $ob_bitacora->getDataRamo($conn,$ramo);
	
	$ense = $ob_bitacora->getEnsenanzabyCurso($conn,$curso);
	
	$ensenanza = pg_result($rs_curso,0);
	$nivel = pg_result($rs_curso,1);
	$cod_ramo = pg_result($rs_ramo,1);
	
	$rs_unidad = $ob_bitacora->getUnidades($conn,$cod_ramo,$nivel,$ensenanza);
	$rs_alu = $ob_bitacora->getListAlumno($conn,$curso);
	require("Calendario/calendario.php");
	
	$rs_doc = $ob_bitacora->listaDoc($conn,$_INSTIT,5);
	$rd = $ob_bitacora->dictaAsig($conn,$ramo);
	$dicta  = pg_result($rd,0);
	?>

<script src="bitacora/Calendario/javascripts.js" type="text/javascript"></script>

<style>
.ui-datepicker-trigger { position:relative;height:16px;width:16px }
.ui-combobox {
    position: relative;
    display: inline-block;
  }
  .ui-combobox-toggle {
    position: absolute;
    top: 0;
    bottom: 0;
    margin-left: -1px;
    padding: 0;
    /* support: IE7 */
    *height: 1.7em;
    *top: 0.1em;
  }
  .ui-combobox-input {
    margin: 0;
    padding: 0.3em;
  }
</style>

	
<script>
  $(document).ready(function() {
			
		listaCanales();
		
		
	/*	  $( "#txt_fecha" ).datepicker({
    'dateFormat':'dd-mm-yy',
	firstDay: 1,
	showOn: "both",
                buttonImage: "bitacora/Calendario/calendario.gif",
                buttonImageOnly: true,
	yearRange: '<?php echo $nro_ano ?>:<?php echo $nro_ano ?>',
	changeMonth: true,
	//changeYear: true,
	//minDate: new Date('<?php echo $nro_ano ?>/01/01'),
   // maxDate: new Date('<?php echo $nro_ano ?>/12/31'),
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ]
	
});*/
		
		 $('.pasaro').click(function() { return !$('#alu_origen option:selected').remove().appendTo('#alu_destino'); });  
		$('.quitaro').click(function() { return !$('#alu_destino option:selected').remove().appendTo('#alu_origen'); });
		$('.pasartodoso').click(function() { $('#alu_origen option').each(function() { $(this).remove().appendTo('#alu_destino'); }); });
		$('.quitartodoso').click(function() { $('#alu_destino option').each(function() { $(this).remove().appendTo('#alu_origen'); }); });
		
	
	
	
  });
	 
  
  </script>
  <form name="form">
<table width="95%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse" align="center">
  <tr>
    <td width="29%" class="tableindex">Periodo</td>
    <td colspan="3" >&nbsp;<select name="cmb_periodoF" id="cmb_periodoF">
      <option value="0">Selecione periodo</option>
      <?php for($p=0;$p<pg_numrows($rs_periodo);$p++){
		  $fila_periodo = pg_fetch_array($rs_periodo,$p);?>
      <option value="<?php echo $fila_periodo['id_periodo'] ?>"><?php echo $fila_periodo['nombre_periodo'] ?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td class="tableindex"><?php echo ($ense==10)?"N&uacute;cleo":"Unidad" ?></td>
    <td colspan="3">
     <div id="lunidad">
      &nbsp;<select name="cmb_unidad" id="cmb_unidad"  onchange="getObj(this.value);getIndicador(this.value)" class="ui-widget" style="width:250px">
      <option value="0">Seleccione <?php echo ($ense==10)?"N&uacute;cleo":"Unidad" ?></option>
    <?php   for($u=0;$u<pg_numrows($rs_unidad);$u++){
		$fila_unidad = pg_fetch_array($rs_unidad,$u);
		?>
    <option value="<?php echo $fila_unidad['id'] ?>"><?php echo $fila_unidad['nombre'] ?></option>
      <?php }?>
    </select>
    </div></td>
  </tr>
  <tr>
    <td class="tableindex"><?php echo ($ense==10)?"Objetivo  de Aprendizaje":"Objetivo de Aprendizaje" ?></td>
    <td colspan="3"><div id="obj">&nbsp;<select name="cmb_objetivo" id="cmb_objetivo" style="width:250px">
    <option value="0">Seleccione <?php echo ($ense==10)?"Objetivo  de Aprendizaje":"Objetivo de Aprendizaje" ?></option>
    </select></div></td>
  </tr>
  <?php if($ense!=10){?>
  <tr>
    <td class="tableindex">Indicador</td>
    <td colspan="3"><div id="indi">&nbsp;<select name="cmb_indicador" id="cmb_indicador" style="width:250px">
    <option value="0">Seleccione Indicador</option>
    </select></div></td>
  </tr>
 <?php  }else{?>
	<input name="cmb_indicador" id="cmb_indicador" value="0" type="hidden" />
	 <?php }?>
  <tr>
    <td class="tableindex">Fecha</td>
    <td colspan="3">&nbsp;<input name="txt_fecha" type="text" id="txt_fecha" size="12" />
    (DD/MM/AAAA)</td>
  </tr>
  <tr>
    <td class="tableindex">Hora inicio</td>
    <td width="31%">&nbsp;<input name="hora_inicio" type="text" id="hora_inicio" size="6" />
    (HH:MM)</td>
    <td width="20%">Hora t&eacute;rmino</td>
    <td width="20%">&nbsp;<input name="hora_termino" type="text" id="hora_termino" size="6" />
      (HH:MM)</td>
  </tr>
  <tr>
    <td class="tableindex">Observaciones</td>
    <td colspan="3" align="center">&nbsp;<textarea name="txt_observaciones" cols="70" rows="5" id="txt_observaciones"></textarea></td>
  </tr>
  <tr>
    <td class="tableindex">Canal de informaci&oacute;n</td>
    <td colspan="3" ><span id="listcanal">
     
    </span> <!--<img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Add.png" title="Crear canal de informaci&oacute;n" onclick="creacanal()" />--> </td>
  </tr>

  <tr>
    <td class="tableindex">Planificaci&oacute;n PIE</td>
    <td colspan="3" ><input type="checkbox" id="bool_pie" value="1" /></td>
  </tr>
  <tr>
    <td class="tableindex">Docente</td>
    <td colspan="3" >
    <select id="docente">
   <?php  for($d=0;$d<pg_numrows($rs_doc);$d++){
	   $fila_doc = pg_fetch_array($rs_doc,$d);
	 
	   ?>
    <option value="<?php echo $fila_doc['rut_emp'] ?>" <?php echo ($dicta ==$fila_doc['rut_emp'])?"selected":""; ?>><?php echo $fila_doc['nombre'] ?></option>
    <?php }?>
    </select></td>
  </tr>
 
  <tr>
    <td colspan="4" height="30">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4" class="tableindex">ALUMNOS PARTICIPANTES</td>
    </tr>
  <tr>
    <td colspan="4" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center" ><table width="65%" border="0">
      <tr>
        <td><select name="alu_origen[]" multiple="multiple" size="8" style="width:250px" id="alu_origen">
          <?php for($t=0;$t<pg_numrows($rs_alu);$t++){
				$fila_alu = pg_fetch_array($rs_alu,$t);?>
          <option value="<?php echo $fila_alu['rut_alumno'] ?>"><?php echo $fila_alu['ape_pat'] ?> <?php echo $fila_alu['ape_mat'] ?> <?php echo $fila_alu['nombre_alu'] ?></option>
          <?php }?>
        </select></td>
        <td><p>
    <input type="button" class="pasaro izq botonXX" value="Pasar &raquo;">
  </p>
    <p>
      <input type="button" class="quitaro der botonXX" value="&laquo; Quitar"><br />
      <input type="button" class="pasartodoso izq botonXX" value="Todos &raquo;" >
    </p>
    <p>
      <input type="button" class="quitartodoso der botonXX" value="&laquo; Todos">
    </p></td>
        <td><select name="alu_destino[]" id="alu_destino" multiple="multiple" size="8" style="width:250px">
        </select></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<?	 
}
if($funcion==4){
	$rs_objetivo = $ob_bitacora->getObjetivo($conn,$unidad);
	$ense = $ob_bitacora->getEnsenanzabyCurso($conn,$curso);
	?>
&nbsp;<select name="cmb_objetivo" id="cmb_objetivo" style="width:250px"> 
<option value="0">Seleccione <?php echo ($ense==10)?"N&uacute;cleo":"Unidad" ?></option>
    <?php if($unidad>0){?>
    
  <?php for($o=0;$o<pg_numrows($rs_objetivo);$o++){
		 $fila_objetivo = pg_fetch_array($rs_objetivo,$o);
		 ?>
          <option value="<?php echo $fila_objetivo['id'] ?>"><?php echo $fila_objetivo['descripcion'] ?></option>
     <?php }?>
     <?php }?>
    </select>
    <?
}
if($funcion==5){
	$rs_indicador = $ob_bitacora->getIndicador($conn,$unidad);
	?>
&nbsp;<select name="cmb_indicador" id="cmb_indicador" style="width:250px">
 <option value="0">Seleccione Indicador</option>
      <?php if($unidad>0){?>
      
  <?php for($o=0;$o<pg_numrows($rs_indicador);$o++){
		 $fila_indicador = pg_fetch_array($rs_indicador,$o);
		 ?>
          <option value="<?php echo $fila_indicador['id'] ?>"><?php echo $fila_indicador['descripcion'] ?></option>
     <?php }?>
     <?php }?>
    </select>
    <?
}
if($funcion==6){
//show($_POST);
$hora_inicio=$hora_inicio.":00";
$hora_termino=$hora_termino.":00";
$rs_guarda=  $ob_bitacora->guardaAct($conn,$curso,$ramo,$periodo,$unidad,$objetivo,$indicador,CambioFE($fecha),utf8_decode($obs),$canal,$hora_inicio,$hora_termino,$bool_pie,$doc);
/*echo ($rs_guarda)?1:0; */
if($rs_guarda){
$ult = $ob_bitacora->getLastBitacora($conn,$ramo);
$l_alus = explode(",",$alus);
	for($a=0;$a<count($l_alus);$a++){
		$rs_gba = $ob_bitacora->insertAluBitacora($conn,$ult,$l_alus[$a]);
	}
	echo 1;
}
else{ 
	echo 0;
	}

}

if($funcion==7){
	
	$campos = $ob_bitacora->getActividadById($conn,$id);
	$unidad = pg_result($campos,5);
	$objetivo = pg_result($campos,6);
	$indicador = pg_result($campos,7);
	$d_unidad = $ob_bitacora->getUnidadbyID($conn,$unidad);
	$d_objetivo = $ob_bitacora->getObjetivobyID($conn,$objetivo);
	$d_indicador = $ob_bitacora->getIndicadorID($conn,$indicador);
	$rs_alu = $ob_bitacora->getAlumnosParticipantes($conn,$id);
	
	$canal = pg_result($campos,9);
	$rs_canalid= $ob_bitacora-> getCanalbyID($conn,$canal);
	
	$hora_inicio = pg_result($campos,10);
	$hora_inicio  = substr($hora_inicio,0,-3);
	$hora_termino = pg_result($campos,11);
	$hora_termino = substr($hora_termino,0,-3);
	$docente = pg_result($campos,13);
	
	$ense = $ob_bitacora->getEnsenanzabyCurso($conn,$curso);
	
	$ldocente = $ob_bitacora->getDocenteBitacora($conn,$docente);
	$ndocente =pg_result($ldocente,1);
?>
<table width="100%" border="0" cellpadding="0">
  <tr>
    <td width="44%" class="tableindex"><?php echo ($ense==10)?"N&uacute;cleo":"Unidad" ?></td>
    <td width="56%"><?php echo ($unidad>0)?pg_result($d_unidad,2):"Sin informaci&oacute;n"; ?></td>
  </tr>
  <tr>
    <td class="tableindex"><?php echo ($ense==10)?"Objetivo  de Aprendizaje":"Objetivo de Aprendizaje" ?></td>
    <td>
	<?php if($objetivo>0){?>
	<?php echo pg_result($d_objetivo,2) ?> <?php echo pg_result($d_objetivo,4) ?>
    <?php }else{echo "Sin informaci&oacute;n";}?></td>
  </tr>
  <?php if($ense!=10){?>
  <tr>
    <td class="tableindex">Indicador</td>
    <td>
	<?php if($indicador>0){?>
	<?php echo pg_result($d_indicador,2) ?>
    <?php }else{echo "Sin informaci&oacute;n";}?></td>
  </tr>
  <?php }?>
  <tr>
    <td class="tableindex">Fecha</td>
    <td><?php echo CambioFD(pg_result($campos,3)); ?></td>
  </tr>
  <tr>
    <td class="tableindex">Hora Inicio</td>
    <td><?php echo $hora_inicio ?></td>
  </tr>
  <tr>
    <td class="tableindex">Hora t&eacute;rmino</td>
    <td><?php echo $hora_termino ?></td>
  </tr>
  <tr>
    <td class="tableindex">Observaciones</td>
    <td><?php echo (pg_result($campos,4)); ?></td>
  </tr>
  <tr>
    <td class="tableindex">Canal de informaci&oacute;n</td>
    <td><?php echo pg_result($rs_canalid,2) ?></td>
  </tr>
  <tr>
    <td class="tableindex">Planificaci&oacute;n PIE</td>
    <td><?php echo (pg_result($campos,12)==1)?"SI":"NO"; ?></td>
  </tr>
  <tr>
    <td class="tableindex">Docente</td>
    <td><?php echo $ndocente ?></td>
  </tr>
  <tr>
    <td class="tableindex">Alumnos Participantes</td>
    <td> <?php for($t=0;$t<pg_numrows($rs_alu);$t++){
				$fila_alu = pg_fetch_array($rs_alu,$t);?>
         <?php echo $fila_alu['ape_pat'] ?> <?php echo $fila_alu['ape_mat'] ?> <?php echo $fila_alu['nombre_alu'] ?><br />
          <?php }?></td>
  </tr>
</table>

<?
}
if($funcion==8){
//show($_POST);
$rs = $ob_bitacora->delActividad($conn,$id);
echo ($rs)?1:0;
}
if($funcion==9){

$campos = $ob_bitacora->getActividadById($conn,$id);
$fila_c = pg_fetch_array($campos,0);

	$rs_curso = $ob_bitacora->getDataCurso($conn,$curso);
	$rs_periodo = $ob_bitacora->getPeriodo($conn,$_ANO);
	$rs_ramo  = $ob_bitacora->getDataRamo($conn,$ramo);
	
	$ensenanza = pg_result($rs_curso,0);
	$nivel = pg_result($rs_curso,1);
	$cod_ramo = pg_result($rs_ramo,1);
	
	$rs_unidad = $ob_bitacora->getUnidades($conn,$cod_ramo,$nivel,$ensenanza);
	$unidad = pg_result($campos,5);
	$objetivo = pg_result($campos,6);
	$indicador = pg_result($campos,7);
	$periodo = pg_result($campos,8);
	$canal = pg_result($campos,9);
	
	$rs_objetivo = $ob_bitacora->getObjetivo($conn,$unidad);
	$rs_indicador = $ob_bitacora->getIndicador($conn,$unidad);
	
	$rs_canales = $ob_bitacora->getCanales($conn,$_INSTIT);
	
	$rs_alu = $ob_bitacora->getListAlumnoRA($conn,$curso,$id);
	
	$rs_aluP = $ob_bitacora->getAlumnosParticipantes($conn,$id);
	
	$hora_inicio = pg_result($campos,10);
	$hora_inicio  = substr($hora_inicio,0,-3);
	$hora_termino = pg_result($campos,11);
	$hora_termino = substr($hora_termino,0,-3);
	
	$ense = $ob_bitacora->getEnsenanzabyCurso($conn,$curso);
	
	$rs_doc = $ob_bitacora->listaDoc($conn,$_INSTIT,5);
	?>
    
<script>
$(document).ready(function(){
	
	/*$("#txt_fecha").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			//minDate: new Date('<?php echo $nro_ano ?>/01/01'),
   // maxDate: new Date('<?php echo $nro_ano ?>/12/31'),
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});*/
		
		
        listaCanales();
         $('.pasaro').click(function() { return !$('#alu_origen option:selected').remove().appendTo('#alu_destino'); });  
		$('.quitaro').click(function() { return !$('#alu_destino option:selected').remove().appendTo('#alu_origen'); });
		$('.pasartodoso').click(function() { $('#alu_origen option').each(function() { $(this).remove().appendTo('#alu_destino'); }); });
		$('.quitartodoso').click(function() { $('#alu_destino option').each(function() { $(this).remove().appendTo('#alu_origen'); }); });

  });
  </script>
<input type="hidden" name="idact" id="idact" value="<?php echo $id ?>" />
<table width="95%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse" align="center">
  <tr>
    <td width="21%" class="tableindex">Periodo</td>
    <td colspan="3" >&nbsp;<select name="cmb_periodoF" id="cmb_periodoF">
      <option value="0">Selecione periodo</option>
      <?php for($p=0;$p<pg_numrows($rs_periodo);$p++){
		  $fila_periodo = pg_fetch_array($rs_periodo,$p);?>
      <option value="<?php echo $fila_periodo['id_periodo'] ?>" <?php echo ($periodo==$fila_periodo['id_periodo'])?"selected":""; ?>><?php echo $fila_periodo['nombre_periodo'] ?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td class="tableindex"><?php echo ($ense==10)?"N&uacute;cleo":"Unidad" ?></td>
    <td colspan="3">&nbsp;
      <select name="cmb_unidad" id="cmb_unidad"  onchange="getObj(this.value);getIndicador(this.value)" style="width:250px">
      <option value="0">Seleccione <?php echo ($ense==10)?"N&uacute;cleo":"Unidad" ?></option>
    <?php   for($u=0;$u<pg_numrows($rs_unidad);$u++){
		$fila_unidad = pg_fetch_array($rs_unidad,$u);
		?>
    <option value="<?php echo $fila_unidad['id'] ?>" <?php echo ($unidad==$fila_unidad['id'])?"selected":""; ?>><?php echo $fila_unidad['nombre'] ?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td class="tableindex"><?php echo ($ense==10)?"Objetivo  de Aprendizaje":"Objetivo de Aprendizaje" ?></td>
    <td colspan="3"><div id="obj">&nbsp;
      <select name="cmb_objetivo" id="cmb_objetivo" style="width:250px">
       <option value="0">Seleccione <?php echo ($ense==10)?"Objetivo  de Aprendizaje":"Objetivo de Aprendizaje" ?></option>
        <?php if($unidad>0){?>
       
        <?php for($o=0;$o<pg_numrows($rs_objetivo);$o++){
		 $fila_objetivo = pg_fetch_array($rs_objetivo,$o);
		 ?>
        <option value="<?php echo $fila_objetivo['id'] ?>" <?php echo ($objetivo==$fila_objetivo['id'])?"selected":""; ?>><?php echo $fila_objetivo['descripcion'] ?></option>
        <?php }?>
        <?php }?>
      </select>
    </div></td>
  </tr>
   <?php if($ense!=10){?>
  <tr>
    <td class="tableindex">Indicador</td>
    <td colspan="3"><div id="indi">&nbsp;
      <select name="cmb_indicador" id="cmb_indicador" style="width:250px">
       <option value="0">Seleccione Indicador</option>
        <?php if($unidad>0){?>
       
        <?php for($o=0;$o<pg_numrows($rs_indicador);$o++){
		 $fila_indicador = pg_fetch_array($rs_indicador,$o);
		 ?>
        <option value="<?php echo $fila_indicador['id'] ?>" <?php echo ($indicador==$fila_indicador['id'])?"selected":""; ?>><?php echo $fila_indicador['descripcion'] ?></option>
        <?php }?>
        <?php }?>
      </select>
    </div></td>
  </tr>
   <?php  }else{?>
	<input name="cmb_indicador" id="cmb_indicador" value="0" type="hidden" />
	 <?php }?>
  <tr>
    <td class="tableindex">Fecha</td>
    <td colspan="3">&nbsp;<input name="txt_fecha" type="text" id="txt_fecha" value="<?php echo CambioFD(pg_result($campos,3)); ?>" size="12" />
    (DD/MM/AAAA)</td>
  </tr>
   <tr>
    <td class="tableindex">Hora inicio</td>
    <td width="16%">&nbsp;<input name="hora_inicio" type="text" id="hora_inicio" size="6" value="<?php echo $hora_inicio ?>" /></td>
    <td width="24%">Hora t&eacute;rmino</td>
    <td width="39%">&nbsp;<input name="hora_termino" type="text" id="hora_termino" size="6" value="<?php echo $hora_termino ?>" /></td>
  </tr>
 
  <tr>
    <td class="tableindex">Planificaci&oacute;n PIE</td>
    <td colspan="3" ><input type="checkbox" id="bool_pie" value="1" <?php echo ($fila_c['bool_pie']==1)?"checked":""  ?> /></td>
  </tr>
  <tr>
    <td class="tableindex">Docente</td>
    <td colspan="3" >&nbsp;
    <select id="docente">
   <?php  for($d=0;$d<pg_numrows($rs_doc);$d++){
	   $fila_doc = pg_fetch_array($rs_doc,$d);
	 
	   ?>
    <option value="<?php echo $fila_doc['rut_emp'] ?>" <?php echo ($fila_c['docente'] ==$fila_doc['rut_emp'])?"selected":""; ?>><?php echo $fila_doc['nombre'] ?></option>
    <?php }?>
    </select></td>
  </tr>
 
  <tr>
    <td class="tableindex">Canal de informaci&oacute;n</td>
    <td colspan="3">&nbsp;
    <select id="canal">
    <option value="0">Seleccione</option>
   <?php  for($c=0;$c<pg_numrows($rs_canales);$c++){
			$fila_canal=pg_fetch_array($rs_canales,$c);
			?>
        <option value="<?php echo $fila_canal['id'] ?>"  <?php echo ($canal==$fila_canal['id'])?"selected":""; ?>><?php echo $fila_canal['nombre'] ?></option>
        <?php }?>
    </select>
   <!--<img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Add.png" title="Crear canal de información" onclick="creacanal()" />-->
    </td>
  </tr>
  <tr>
    <td class="tableindex">Observaciones</td>
    <td colspan="3"><textarea name="txt_observaciones" cols="70" rows="5" id="txt_observaciones"><?php echo (pg_result($campos,4)); ?></textarea></td>
  </tr>
  <tr>
    <td colspan="4" height="30">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="4" class="tableindex">ALUMNOS PARTICIPANTES</td>
    </tr>
  <tr>
    <td colspan="4" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="center" ><table width="65%" border="0">
      <tr>
        <td><select name="alu_origen[]" multiple="multiple" size="8" style="width:250px" id="alu_origen">
          <?php for($t=0;$t<pg_numrows($rs_alu);$t++){
				$fila_alu = pg_fetch_array($rs_alu,$t);?>
          <option value="<?php echo $fila_alu['rut_alumno'] ?>"><?php echo $fila_alu['ape_pat'] ?> <?php echo $fila_alu['ape_mat'] ?> <?php echo $fila_alu['nombre_alu'] ?></option>
          <?php }?>
        </select></td>
        <td><p>
    <input type="button" class="pasaro izq botonXX" value="Pasar &raquo;">
  </p>
    <p>
      <input type="button" class="quitaro der botonXX" value="&laquo; Quitar"><br />
      <input type="button" class="pasartodoso izq botonXX" value="Todos &raquo;" >
    </p>
    <p>
      <input type="button" class="quitartodoso der botonXX" value="&laquo; Todos">
    </p></td>
        <td><select name="alu_destino[]" id="alu_destino" multiple="multiple" size="8" style="width:250px">
         <?php for($t=0;$t<pg_numrows($rs_aluP);$t++){
				$fila_alu = pg_fetch_array($rs_aluP,$t);?>
          <option value="<?php echo $fila_alu['rut_alumno'] ?>"><?php echo $fila_alu['ape_pat'] ?> <?php echo $fila_alu['ape_mat'] ?> <?php echo $fila_alu['nombre_alu'] ?></option>
          <?php }?>
        </select></td>
      </tr>
</table>
</td></tr></table>
<?
}
if($funcion==10){
$hora_inicio=$hora_inicio.":00";
$hora_termino=$hora_termino.":00";
$rs_guarda= $ob_bitacora->modificaAct($conn,$unidad,$objetivo,$indicador,CambioFE($fecha),utf8_decode($obs),$id,$canal,$hora_inicio,$hora_termino,$bool_pie,$doc);
if($rs_guarda){
$ob_bitacora->delAluAct($conn,$id);
$l_alus = explode(",",$alus);
	for($a=0;$a<count($l_alus);$a++){
		$rs_gba = $ob_bitacora->insertAluBitacora($conn,$id,$l_alus[$a]);
	}
	echo 1;
}
else{ 
	echo 0;
	} 
}
if($funcion==11){
	
	$rs_canales = $ob_bitacora->getCanales($conn,$_INSTIT);
	?>&nbsp;
<select name="canal" id="canal">
        <option value="0">Seleccione</option>
        <?php  for($c=0;$c<pg_numrows($rs_canales);$c++){
			$fila_canal=pg_fetch_array($rs_canales,$c);
			?>
        <option value="<?php echo $fila_canal['id'] ?>"><?php echo $fila_canal['nombre'] ?></option>
        <?php }?>
</select>
    <?
	}
if($funcion==12){
	?>
	<table width="95%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td class="tableindex">Nombre</td>
    <td>&nbsp;<input name="nomcanal" id="nomcanal" type="text" /></td>
  </tr>
</table>
<?
}
if($funcion==13){
	//show($_POST);
	$rs_guarda  = $ob_bitacora->guardaCanal($conn,$_INSTIT,utf8_decode($canal));
	echo ($rs_guarda)?1:0;
}

 ?>