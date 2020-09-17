<?

require("../../util/header.php");
require("mod_clase.php");

$funcion = $_POST['funcion'];

$ob_clase = new Clase();
 

if($funcion==1){
$rs_unidad = $ob_clase->traeUnidad($conn,$unidad);	
$fila_unidad = pg_fetch_array($rs_unidad,0);
		$rs_dicta=$ob_clase->traeDicta($conn,$fila_unidad['id_ramo']);
		$rs_ramo=$ob_clase->traeRamo($conn,$fila_unidad['id_curso'],$fila_unidad['id_ramo']);
	/*	$rs_obj=$ob_unidad->traeObjUnidad($conn,0,$idUnidad);
		$rs_hab=$ob_unidad->traeObjUnidad($conn,1,$idUnidad);*/
		
		

	
?>
<table width="650" border="0" align="center">
  <tr>
    <td class="cuadro02">UNIDAD</td>
    <td colspan="3" class="cuadro01"><?php echo $fila_unidad['nombre'] ?> <input name="iunidad" type="hidden" id="iunidad" value="<?php echo $unidad ?>"></td>
  </tr>
  <tr>
    <td width="195" class="cuadro02">CURSO</td>
    <td width="439" colspan="3" class="cuadro01"><?php echo CursoPalabra($fila_unidad['id_curso'],1,$conn) ?>
    <input type="hidden" name="icurso" id="icurso" value="<?php echo $fila_unidad['id_curso'] ?>"></td>
  </tr>
  <tr>
    <td class="cuadro02">ASIGNATURA</td>
    <td colspan="3" class="cuadro01"><?=pg_result($rs_ramo,1);?>
    <input type="hidden" name="iramo" id="iramo" value="<?php echo $fila_unidad['id_ramo'] ?>">
    <input type="hidden" name="cod_ramo" id="cod_ramo" value="<?=pg_result($rs_ramo,2);?>" /></td>
  </tr>
  <tr>
    <td class="cuadro02">PROFESOR</td>
    <td colspan="3" class="cuadro01"><?php echo strtoupper(pg_result($rs_dicta,2)) ?>
    <input type="hidden" name="doc" id="doc" value="<?=pg_result($rs_dicta,0);?>" /></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" align="right"> <div id="nvo">
    <input type="button" name="nuevaUnidad" id="nuevaUnidad" value="Nueva Clase" onclick="creaClase()" class="botonXX" />&nbsp;&nbsp;&nbsp; <input type="button" name="VOLVER" id="VOLVER" value="VOLVER" onclick="location.href='../unidad/unidad.php?iun=<?php echo $fila_unidad['unidad_anual'] ?>'" class="botonXX" />
    </div></td>
  </tr>
  <tr>
    <td colspan="4" align="right">&nbsp;</td>
  </tr>
 
  <tr>
		  <td width="195" class="cuadro02">FECHA INICIO</td>
		  <td width="439" class="cuadro02">FECHA TERMINO</td>
		  <td width="25%" class="cuadro02">CLASES ASIGNADAS</td>
		  <td width="25%" class="cuadro02">HORAS ASIGNADAS</td>
	  </tr>
		<tr>
		  <td class="cuadro01"><?php echo CambioFD($fila_unidad['fecha_inicio']) ?></td>
		  <td class="cuadro01"><?php echo CambioFD($fila_unidad['fecha_termino']) ?></td>
		  <td class="cuadro01"><?php echo $fila_unidad['cantidad_clases'] ?></td>
		  <td class="cuadro01"><?php echo $fila_unidad['nro_horas'] ?></td>
	  </tr>
		<tr>
		  <td colspan="4">&nbsp;</td>
	  </tr>
		<tr>
		  <td colspan="4" class="cuadro02">DESCRIPCION</td>
	  </tr>
		<tr>
		  <td colspan="4" class="cuadro01"><?php echo $fila_unidad['texto'] ?></td>
	  </tr>
		<tr>
		  <td colspan="4">&nbsp;</td>
	  </tr>
</table>
<?
} if($funcion==2){
	//var_dump($_POST);
	$rs_clase = $ob_clase->tipoClase($conn);
	$rs_recurso = $ob_clase->traeRecurso($conn,$_INSTIT);
	$rs_docente = $ob_clase->traeDocente($conn,$_INSTIT,$cod_ramo);
	$rs_tipoeva = $ob_clase->traeTipoEva($conn,$_INSTIT);
	$rs_tipo=$ob_clase->tejeUnidad($conn,$iunidad);
?>


<script>

$(document).ready(function(){
	
	$("#f_inicio, #f_termino").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			/*minDate: new Date('01/01/'+anio+''),
			maxDate: new Date('12/31/'+anio+''),*/
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});
		
		
	
		$('.pasar').click(function() { return !$('#origen option:selected').remove().appendTo('#destino'); });  
		$('.quitar').click(function() { return !$('#destino option:selected').remove().appendTo('#origen'); });
		$('.pasartodos').click(function() { $('#origen option').each(function() { $(this).remove().appendTo('#destino'); }); });
		$('.quitartodos').click(function() { $('#destino option').each(function() { $(this).remove().appendTo('#origen'); }); });
		//$('.submit').click(function() { $('#destino option').prop('selected', 'selected'); });
	 
	 
	 $('.pasaro').click(function() { return !$('#eva_origen option:selected').remove().appendTo('#eva_destino'); });  
		$('.quitaro').click(function() { return !$('#eva_destino option:selected').remove().appendTo('#eva_origen'); });
		$('.pasartodoso').click(function() { $('#eva_origen option').each(function() { $(this).remove().appendTo('#eva_destino'); }); });
		$('.quitartodoso').click(function() { $('#eva_destino option').each(function() { $(this).remove().appendTo('#eva_origen'); }); });
		//$('.submit').click(function() { $('#destino option').prop('selected', 'selected'); });
	 

 $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
          });

  
  tinymce.init({
  selector: 'textarea',
  height: 300,
  theme: 'modern',
  plugins: '  searchreplace autolink directionality  visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount  imagetools    contextmenu colorpicker textpattern tiny_mce_wiris ',
  toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry tiny_mce_wiris_CAS',
  image_advtab: true,
  menubar: 'edit view insert fotmat table',
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ]/*,
  content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
  ]*/
 });
	
});
  </script>
  
<table width="650" border="0" align="center" cellspacing="3">
 <tr>
   <td colspan="4" align="center" class="cuadro02">INFORMACION CLASE</td>
  </tr>
 <tr>
		  <td width="120" class="cuadro02">FECHA INICIO</td>
		  <td width="126" class="cuadro02">FECHA TERMINO</td>
		  <td width="152" class="cuadro02">CLASES ASIGNADAS</td>
		  <td width="147" class="cuadro02">HORAS ASIGNADAS</td>
	  </tr>
		<tr>
		  <td class="cuadro01"><input name="f_inicio" type="text" id="f_inicio" size="10"></td>
		  <td class="cuadro01"><input name="f_termino" type="text" id="f_termino" size="10"></td>
		  <td class="cuadro01"><input name="cant_clases" type="text" id="cant_clases" size="5" class="solo-numero"></td>
		  <td class="cuadro01"><input name="cant_horas" type="text" id="cant_horas" size="5" class="solo-numero"></td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
  </tr>
		<tr>
		  <td class="cuadro02">NOMBRE CLASE</td>
		  <td class="cuadro01"><input type="text" name="txt_nombre" id="txt_nombre" /></td>
		  <td colspan="2" class="cuadro02">DOCENTE	      </td>
  </tr>
		<tr>
		  <td class="cuadro02">TIPO</td>
		  <td class="cuadro01"><select name="cmb_tipo" id="cmb_tipo">
          <option value="0">seleccione...</option>
          <?php for($t=0;$t<pg_numrows($rs_clase);$t++){
			  $fila_tipo=pg_fetch_array($rs_clase,$t);
			  ?>
          <option value="<?php echo $fila_tipo['id_tipo'] ?>"><?php echo $fila_tipo['tipo'] ?></option>
          
          <?php }?>
	      </select></td>
		  <td colspan="2" class="cuadro01">
          <select name="cmbDocente" id="cmbDocente">
          <option value="0" selected="selected">seleccione...</option>
         <?php  for($d=0;$do<pg_numrows($rs_docente);$do++){
			 $fila_do = pg_fetch_array($rs_docente,$do);
			 ?>
          <option value="<?php echo $fila_do['rut_emp'] ?>" <?php echo ($doc==$fila_do['rut_emp'])?'selected="selected"':"" ?>><?php echo $fila_do['ape_pat'] ?> <?php echo $fila_do['ape_mat'] ?>,<?php echo $fila_do['nombre_emp'] ?></option>
         <?php }?>
	      </select></td>
  </tr>
</table><br>
<br>
<table width="650" border="0" align="center">
 <tr>
    <td colspan="4" class="cuadro02"><!--<input name="tipo" type="radio" id="tipo0" onclick="cargatipo(0,<?php echo $iunidad?>)" value="0" checked="checked" />Objetivos <input name="tipo" id="tipo1" type="radio" value="1" onclick="cargatipo(1,<?php echo $iunidad ?>)" />
      Habilidades 
      <input type="hidden" name="cargaobj" id="cargaobj" value="" /> 
    <input type="hidden" name="cargahab" id="cargahab"  value="" />-->
    <?php 
	//echo "ee".pg_numrows($rs_tipo);
	for($ti=0;$ti<pg_numrows($rs_tipo);$ti++){
		  $fila_tipo = pg_fetch_array($rs_tipo,$ti);
		  
		  
		  
		  ?>
          <?php if($ti==0){ ?>
      <input name="crg" id="crg" type="hidden" value="<?php echo $fila_tipo['id_objetivo']; ?>" />
          <?php }?>
          
      <input type="hidden" name="cargatipo[]" id="cargatipo<?php echo $fila_tipo['id_objetivo']; ?>" value="" /> 
      <input type="hidden" name="cargaind[]" id="cargaind<?php echo $fila_tipo['id_objetivo']; ?>" value="<?php echo $cad_ind ?>" />
      <input name="tipo" id="tipo<?php echo $t ?>" type="radio" value="<?php echo $fila_tipo['id_objetivo']; ?>" onclick="cargatipo(<?php echo $fila_tipo['id_objetivo']; ?>,<?php echo $iunidad ?>);" <?php echo ($ti==0)?"checked":"" ?> /><?php echo $fila_tipo['nombre']; ?>
      
    <?php }?></td>
  </tr>
</table>
<div id="mx">
</div>
<div id="my">
</div><br />
<table align="center" width="650">
<tr>
   <td class="cuadro02">Actitudes</td>
 </tr>
 <tr>
   <td class="cuadro01"><textarea name="txt_actitudes" cols="80" rows="5" id="txt_actitudes"></textarea></td>
 </tr>
</table>
<br />

<table width="650" border="0" align="center" cellspacing="3">

 <tr>
   <td class="cuadro02">Inicio</td>
 </tr>
 <tr>
   <td class="cuadro01"><textarea name="txt_inicio" cols="80" rows="5" id="txt_inicio"></textarea></td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td class="cuadro02">Desarrollo</td>
 </tr>
 <tr>
   <td class="cuadro01"><textarea name="txt_desarrollo" cols="80" rows="5" id="txt_desarrollo"></textarea></td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td class="cuadro02">Cierre</td>
 </tr>
 <tr>
   <td class="cuadro01"><textarea name="txt_cierre" cols="80" rows="5" id="txt_cierre"></textarea></td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
  <tr>
   <td class="cuadro02">Evaluaci&oacute;n&nbsp;<input type="button" name="button5" id="button5" value="+" onClick="creatipoEva()" class="botonXX"></td>
  </tr>
 <tr>
		  <td class="cuadro01"><!--<textarea name="txt_evaluacion" cols="80" rows="5" id="txt_evaluacion"></textarea>-->
          <table width="100%" border="0" cellspacing="0">
  <tr>
    <td width="43%">&nbsp;
      <select name="eva_origen[]" multiple="multiple" size="8" style="width:250px" id="eva_origen">
        <?php for($t=0;$t<pg_numrows($rs_tipoeva);$t++){
				$fila_tipo = pg_fetch_array($rs_tipoeva,$t);?>
                 <option value="<?php echo $fila_tipo['id_tipo'] ?>"><?php echo $fila_tipo['nombre'] ?></option>
                <?php }?>
      </select></td>
    <td width="12%" align="center"><p>
    <input type="button" class="pasaro izq botonXX" value="Pasar &raquo;">
  </p>
    <p>
      <input type="button" class="quitaro der botonXX" value="&laquo; Quitar"><br />
      <input type="button" class="pasartodoso izq botonXX" value="Todos &raquo;" >
    </p>
    <p>
      <input type="button" class="quitartodoso der botonXX" value="&laquo; Todos">
    </p>
</td>
    <td width="45%"><select name="eva_destino[]" id="eva_destino" multiple="multiple" size="8" style="width:250px">
    </select></td>
  </tr>
</table>
</td>
  </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 
</table>
<br>
<table width="650" border="1" align="center" idth="650" style="border-collapse:collapse">
<tr>
  <td colspan="3" class="cuadro02">Recursos 
    <input type="button" name="button5" id="button5" value="+" onClick="creaRecurso()" class="botonXX"></td>
  </tr>
<tr>
  <td class="cuadro01"><div id="traeorg">
  <select name="origen[]" id="origen" multiple="multiple" size="8" style="width:250px">
			  <?php for($r=0;$r<pg_numrows($rs_recurso);$r++){
				$fila_recurso = pg_fetch_array($rs_recurso,$r);?>
            <option value="<?php echo $fila_recurso['id_recurso'] ?>"><?php echo $fila_recurso['nombre'] ?></option>
            <?php }?>
			</select>
    </div>
</td>
  <td align="center" class="cuadro01"><p>
    <input type="button" class="pasar izq botonXX" value="Pasar &raquo;">
  </p>
    <p>
      <input type="button" class="quitar der botonXX" value="&laquo; Quitar"><br />
      <input type="button" class="pasartodos izq botonXX" value="Todos &raquo;" >
    </p>
    <p>
      <input type="button" class="quitartodos der botonXX" value="&laquo; Todos">
    </p>

  </td>
  <td class="cuadro01"><select name="destino[]" id="destino" multiple="multiple" size="8" style="width:250px"></select>

</td>
</tr>
</table>
<br />
<br />


<?	
}  
if($funcion==3){
$rs_nuevor=$ob_clase->guardaRecurso($conn,$nombre,$ins);

$rs_ultimo=$ob_clase->traeUltimoRecurso($conn,$ins);
$f_re=pg_fetch_array($rs_ultimo,0);	
	
echo '<option value="'.$f_re['id_recurso'].'">'.utf8_decode($f_re['nombre']).'</option>';
}

if($funcion==4){
	$rs_objevo=$ob_clase->traeObjUnidad($conn,$tipo,$unidad);
	?>
    
<table width="650" align="center" border="1" style="border-collapse:collapse">
	<?
	
	for($o=0;$o<pg_numrows($rs_objetivo);$o++){
		 $fila = pg_fetch_array($rs_objetivo,$o);
		 
		 $cad_ind="";
			$rs_inditpo = $ob_clase->traeIndiClaseO($conn,$clase,$fila['id_obj']);
			if(pg_numrows($rs_inditpo)>0){
			
				for($in=0;$in<pg_numrows($rs_inditpo);$in++){
				$fila_in = pg_fetch_array($rs_inditpo,$in);
				$cad_ind.=$fila_in['id_obj']."_".$fila_in['id_indicador'].","; 	
				}	
			}
		 
		 ?>
        <!-- <tr><td id="fila<?php echo  $fila_obj['id_obj']?>" onclick="pp(<?php echo  $fila_obj['id_obj']?>);sumatipo(<?php echo $tipo ?>)" class="i textosimple"><?php echo $fila_obj['codigo']."-".$fila_obj['texto'] ?><input name="obj_destino[]" type="checkbox" class="oo" id="destino<?=$fila_obj['id_obj']?>" style="visibility:visible" value="<?php echo  $fila_obj['id_obj']?>" /></td>-->
        <tr><td align="justify" id="fila<?php echo  $fila['id_obj']?>" onclick="pp(<?php echo  $fila['id_obj']?>);sumatipo(<?php echo  $tipo?>);buscasel(<?php echo  $fila['tipo']?>);" class="i textosimple"><?php echo $fila['codigo']."-".$fila['texto'] ?><input name="obj_destino[]" type="checkbox" class="oo<?php echo  $fila['tipo']?>" id="destino<?=$fila['id_obj']?>" style="visibility:hidden" value="<?php echo  $fila['id_obj']?>" />
          <input type="hidden" id="lindv<?php echo  $fila['id_obj']?>" name="lindv<?php echo  $fila['id_obj']?>" class="lindv<?php echo  $fila['tipo']?>" value="<?php echo $cad_ind ?>"/></td></tr>
         <?
		}
	
?>
</table>
    <?
}
if($funcion==5){
//var_dump($_POST);	
	
$rs_guarda = $ob_clase->guardaClase($conn,$iunidad,$icurso,$iramo,$cmbDocente,$txt_nombre,$cmb_tipo,CambioFE($f_inicio),CambioFE($f_termino),$txt_evaluacion,$txt_inicio,$txt_desarrollo,$txt_cierre,$txt_actitudes,$cant_clases,$cant_horas);

if($rs_guarda){
	 
$rs_ultimo = $ob_clase->ultimaClase($conn,$iunidad);
$clase = pg_result($rs_ultimo,0);
	
$rec = $_POST['destino'];	
if(count($rec)>0){
	for($d=0;$d<count($rec);$d++){
		$rs_recurso = $ob_clase->guardaClaseRecurso($conn,$clase,$rec[$d]);
	}
}
$obj_destino=$_POST['cargatipo'];

$eva_destino=$_POST['eva_destino'];

 /*if(count($obj_destino)>0){
			for ($i=0;$i<count($obj_destino);$i++) { 
			$rs_guardaObjetivo = $ob_clase->guardaObjetivo($conn,$clase,$obj_destino[$i]);
			} 
		 }
	*/
		if(count($obj_destino)>0){
			for ($i=0;$i<count($obj_destino);$i++) { 
			$cuenta_tipo = explode(",",$obj_destino[$i]);
				for ($j=0;$j<count($cuenta_tipo);$j++) { 
				$rs_guardaObjetivo = $ob_clase->guardaObjetivo($conn,$clase,$cuenta_tipo[$j]);
				}
			} 
		 }
		
		if(count($eva_destino)>0){	
			 for ($k=0;$k<count($eva_destino);$k++) { 
			 $rs_guardaTipo = $ob_clase->guardaEva($conn,$clase,$eva_destino[$k]);
			} 
		}
		
		 //indicadores
			if(strlen($_POST["cargaind"])>0){
				$lista = $_POST["cargaind"];
				for($l=0;$l<count($_POST["cargaind"]);$l++){
					$cuenta_ind = explode(",",$lista[$l]);
					if(strlen($lista[$l])>0){
					//show($cuenta_ind);
					for($k=0;$k<count($cuenta_ind);$k++){
					$cc=explode("_",$cuenta_ind[$k]);
					$indicador = $cc[1];
					$objetivo =$cc[0];
					  $ob_clase->guardaIndicadorSel($conn,$clase,$objetivo,$indicador); 
					 
						}
					}
				}
				
				}

	echo 1;
}
else{
echo 0;
}
}
if($funcion==6){
//var_dump($_POST);
$rs_lista = $ob_clase->traeClases($conn,$unidad);
?>

<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td colspan="13" align="center" class="cuadro02">Listado Clases</td>
  </tr>
  <tr>
    <td class="cuadro02">Nombre</td>
    <td class="cuadro02">Fecha Inicio</td>
    <td class="cuadro02">Fecha T&eacute;rmino</td>
    <td class="cuadro02">Estado</td>
    <td colspan="<?php echo ($_PERFIL==0 || $_PERFIL==14 || $_PERFIL==25 || $_PERFIL==32)?9:8 ?>" align="center" class="cuadro02">Acciones</td>
  </tr>
  <?php if(pg_numrows($rs_lista)>0){
	  for($c=0;$c<pg_numrows($rs_lista);$c++){
		  $fila=pg_fetch_array($rs_lista,$c);
		  
		  $rs_estado=$ob_clase->traeEstadoClaseUno($conn,$fila['estado']);
	  ?>
  <tr>
    <td class="cuadro01"><?php echo $fila['nombre'] ?></td>
    <td class="cuadro01"><?php echo CambioFD($fila['fecha_inicio']) ?></td>
    <td class="cuadro01"><?php echo CambioFD($fila['fecha_termino']) ?></td>
    <td class="cuadro01"><?php echo pg_result($rs_estado,1); ?></td>
    <td class="cuadro01"><input type="button" name="ve" id="ve" value="V" title="Ver Detalle Clase" onclick="detClase(<?php echo $fila['id_clase'] ?>)" class="botonXX" /></td>
    <td class="cuadro01"><input type="button" name="ed" id="ed" value="E" title="Editar Clase" onclick=" editaClase(<?php echo $fila['id_clase'] ?>)" class="botonXX" /></td>
   
    
     <td class="cuadro01"><input name="es" type="button" value="ES" title="Cambiar Estado" onclick="cambiaEstado(<?php echo $fila['id_clase'] ?>)" class="botonXX" /></td>
   
     <?php if($_PERFIL==0 || $_PERFIL==14 || $_PERFIL==17){?>
    <td class="cuadro01"><input type="button" name="rl" id="rl" value="<?php echo ($fila['ejecutada']==1)?"NRL":"RL" ?>" title="Marcar Clase como <?php echo ($fila['ejecutada']==1)?"NO realizada":"Realizada" ?>" <?php echo ($fila['estado']!=2)?"disabled":"" ?> onclick="claserl(<?php echo $fila['id_clase'] ?>,<?php echo ($fila['ejecutada']==1)?0:1 ?>)" class="<?php echo ($fila['estado']!=2)?"botonXXI":"botonXX" ?>" /></td>
    <?php }?>
    <td class="cuadro01"><input type="button" name="re" id="re" value="RE" title="Replicar Clase" <?php echo ($fila['estado']!=2)?"disabled":"" ?> onclick="replica(<?php echo $fila['id_clase'] ?>)" class="<?php echo ($fila['estado']!=2)?"botonXXI":"botonXX" ?>" /></td>
    
    <td class="cuadro01"><input type="button" name="no" id="no" value="N" title="Asociar a notas" <?php echo ($fila['estado']!=2)?"disabled":"" ?> onclick="asocianota(<?php echo $fila['id_clase'] ?>)" class="<?php echo ($fila['estado']!=2)?"botonXXI":"botonXX" ?>" /></td>
    
    <td class="cuadro01"><input type="button" name="le" id="le" value="L" title="Leccionario" <?php echo ($fila['estado']!=2)?"disabled":"" ?> onclick="leccionario(<?php echo $fila['id_clase'] ?>)" class="<?php echo ($fila['estado']!=2)?"botonXXI":"botonXX" ?>" /></td>
    
    <td class="cuadro01"><a href="carhgafile/index.php?rr=<?php echo $_INSTIT ?>&icls=<?php echo $fila['id_clase'] ?>" target="_blank" onClick="window.open(this.href, this.target, 'width=600,height=300'); return false;"><input type="button" name="ac" id="ac" value="A" title="Subir Archivo Evaluaci&oacute;n"  class="botonXX" /></a>
    
    </td>
    <?php if($_PERFIL==0 ){?>
    <td class="cuadro01"><input type="button" name="button2" id="button2" value="X" class="botonBX"  onclick="borraClase(<?php echo $fila['id_clase'] ?>)" /></td>
   <?php }?>
   
  </tr>
  <?php 
	  }
  }else{?>
  <td colspan="13" align="center" class="cuadro01">Sin informaci&oacute;n</td>
  <?php }?>
</table>

<?
}

if($funcion==7){
	$rs_clase=$ob_clase->traeClaseUno($conn,$clase);
	$fila = pg_fetch_array($rs_clase,0);
	
	$rs_tipo=$ob_clase->tipoClaseUno($conn,$fila['tipo']);
	$rs_dicta=$ob_clase->traeDicta($conn,$fila['id_ramo']);
	$rs_recurso=$ob_clase->listaRecursosClase($conn,$clase);
	/*$rs_obj=$ob_clase->traeObjclase($conn,0,$clase);
	$rs_hab=$ob_clase->traeObjclase($conn,1,$clase);*/
	//$rs_objetivo=$ob_clase->traeObjUnidad($conn,$tipo,$fila['id_ramo']);
	
	$rs_arc = $ob_clase->traearchivo($conn,$clase);
	$rs_eva=$ob_clase->listaEvaluacionClase($conn,$clase);
	
	$rs_eje=$ob_clase->tejeClase($conn,$clase);
	
	?>
<table width="650" border="0" align="center">
 <tr>
   <td colspan="4" align="center" class="cuadro02">    INFORMACION CLASE</td>
  </tr>
 <tr>
		  <td width="120" class="cuadro02">FECHA INICIO</td>
		  <td width="126" class="cuadro02">FECHA TERMINO</td>
		  <td width="152" class="cuadro02">CLASES ASIGNADAS</td>
		  <td width="147" class="cuadro02">HORAS ASIGNADAS</td>
	  </tr>
		<tr>
		  <td class="cuadro01"><?php echo CambioFD($fila['fecha_inicio']) ?></td>
		  <td class="cuadro01"><?php echo CambioFD($fila['fecha_termino']) ?></td>
		  <td class="cuadro01"><?php echo $fila['cant_clase'] ?></td>
		  <td class="cuadro01"><?php echo $fila['cant_hora'] ?></td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
  </tr>
		<tr>
		  <td class="cuadro02">NOMBRE CLASE</td>
		  <td class="cuadro01"><?php echo $fila['nombre'] ?></td>
		  <td colspan="2" class="cuadro02">DOCENTE	      </td>
  </tr>
		<tr>
		  <td class="cuadro02">TIPO</td>
		  <td class="cuadro01"><?php echo pg_result($rs_tipo,1); ?></td>
		  <td colspan="2" class="cuadro01"><?php echo strtoupper(pg_result($rs_dicta,2)) ?></td>
  </tr>
</table><br />
<br />
<table width="650" border="0" align="center" cellspacing="3">
  
  <?php if(pg_numrows($rs_eje)>0){?>
   <?php for($e=0;$e<pg_numrows($rs_eje);$e++){
		  $fila_eje = pg_fetch_array($rs_eje,$e);
		  $rs_obj=$ob_clase->traeObjclase($conn,$fila_eje['id_objetivo'],$clase);
		   $rs_tipe=$ob_clase->tipoEjesBloqueClaseInd($conn,$clase,$fila_eje['id_objetivo']);
		  		  ?>
                  
                  
                  <?php if(pg_numrows($rs_obj)>0){?>
                  <tr>
   <td>&nbsp;</td>
 </tr>
      <tr>
		  <td colspan="4" >
		   <table width="100%">
          <tr class="cuadro02">
            <td colspan="2"><?php echo strtoupper($fila_eje['nombre'])?></td>
            </tr>
           <?php   for($ti=0;$ti<pg_numrows($rs_tipe);$ti++){ 
		     $fila_tipe = pg_fetch_array($rs_tipe,$ti);
			  $rs_obj=$ob_clase->traeObjeclaseInd($conn,$fila_tipe['id_eje'],$fila_eje['id_objetivo'],$clase);
		   ?>
          <tr class="cuadro02">
          <td  width="50%"><?php echo strtoupper($fila_tipe['texto']) ?></td><td>INDICADORES DE EVALUACI&Oacute;N</td></tr>
         
          <?php for($o=0;$o<pg_numrows($rs_obj);$o++){
		  $fila_obj = pg_fetch_array($rs_obj,$o);
		  ?>
		<tr class="cuadro01">
		  <td valign="top"><?php echo strtoupper($fila_obj['codigo']) ?> - <?php echo  nl2br($fila_obj['texto'])?></td>  							          <td valign="top">
          <?php 
		  $rs_ind_a = $ob_clase->buscaIndicadorSel2($conn,$fila_obj['id_obj'],$clase);
		   for($ff=0;$ff<pg_numrows($rs_ind_a);$ff++){
			  $fila_inda = pg_fetch_array($rs_ind_a,$ff);
		  echo nl2br($fila_inda['texto'])."<br>";
		  }
		  ?>
          </td>
	  </tr>
	  <?php }?>
	  <?php }?>
          </table>
		  
		</td>
	  </tr>
       
      
       <?php }?> 
                  
  <?php }?>
  <?php }?>
  <tr>
    <td >&nbsp;</td>
  </tr>
  <tr>
   <td class="cuadro02">Inicio</td>
 </tr>
 <tr>
   <td class="cuadro01"><?php echo nl2br($fila['inicio']) ?></td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td class="cuadro02">Desarrollo</td>
 </tr>
 <tr>
   <td class="cuadro01"><?php echo nl2br($fila['desarrollo']) ?></td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td class="cuadro02">Cierre</td>
 </tr>
 <tr>
   <td class="cuadro01"><?php echo nl2br($fila['cierre']) ?></td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td class="cuadro02">Evaluaci&oacute;n</td>
  </tr>
 <?php for($t=0;$t<pg_numrows($rs_eva);$t++){
	 $fila_top= pg_fetch_array($rs_eva,$t);
	 ?>
 <tr>
   <td class="cuadro01"><?php echo $fila_top['nombre'] ?></td>
 </tr>
 <?php }?>
  <?php if(pg_numrows($rs_arc )>0){
	  $ruta = pg_result($rs_arc,2);
	  ?>
  <tr>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td class="cuadro02">Archivo Evaluaci&oacute;n</td>
 </tr>
 
 <tr>
   <td class="cuadro01"><a href="acv/<?php echo $ruta ?>" target="_blank"><?php echo $ruta ?></a></td>
 </tr><?php }?>
 <tr>
   <td>&nbsp;</td>
 </tr>
 
 <tr>
   <td class="cuadro02">Actitudes</td>
 </tr>
 <tr>
   <td class="cuadro01"><?php echo nl2br($fila['actitudes']) ?></td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td class="cuadro02">Recursos</td>
 </tr>
 
  <?php for($r=0;$r<pg_numrows($rs_recurso);$r++){
	 $fila_rec= pg_fetch_array($rs_recurso,$r);
	 ?>
 <tr>
   <td class="cuadro01"><?php echo $fila_rec['nombre'] ?></td>
 </tr>
 <?php }?>

 
 <tr>
   <td>&nbsp;</td>
 </tr>
 
 
</table>
    <?
}
//editar clase
if($funcion==8){
	//show($_POST);
	$rs_clase=$ob_clase->traeClaseUno($conn,$clase);
	$fila = pg_fetch_array($rs_clase,0);
	$rs_dicta=$ob_clase->traeDicta($conn,$fila['id_ramo']);
	$rs_recurso=$ob_clase->listaRecursosClase($conn,$clase);
	$rs_recurso_org=$ob_clase->recursoNoSE($conn,$clase,$_INSTIT);
	/*$rs_obj=$ob_clase->traeObjclase($conn,0,$clase);
	$rs_hab=$ob_clase->traeObjclase($conn,1,$clase);*/
	$rs_tipoClase = $ob_clase->tipoClase($conn);
	//$rs_recurso = $ob_clase->traeRecurso($conn,$_INSTIT);
	$rs_docente = $ob_clase->traeDocente($conn,$_INSTIT,$cod_ramo);
	$rs_ramo=$ob_clase->traeRamo($conn,$fila['id_curso'],$fila['id_ramo']);
	$rs_eva=$ob_clase->listaEvaluacionClase($conn,$clase);
	$rs_eva_org=$ob_clase->tipoevaNoSE($conn,$clase,$_INSTIT);
	$rs_tipo=$ob_clase->tejeUnidad($conn,$fila['id_unidad']);
	
	
	
	?>
<script>
$(document).ready(function(){
	
	$("#f_inicio, #f_termino").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			/*minDate: new Date('01/01/'+anio+''),
			maxDate: new Date('12/31/'+anio+''),*/
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});
		
		
	
		$('.pasar').click(function() { return !$('#origen option:selected').remove().appendTo('#destino'); });  
		$('.quitar').click(function() { return !$('#destino option:selected').remove().appendTo('#origen'); });
		$('.pasartodos').click(function() { $('#origen option').each(function() { $(this).remove().appendTo('#destino'); }); });
		$('.quitartodos').click(function() { $('#destino option').each(function() { $(this).remove().appendTo('#origen'); }); });
		//$('.submit').click(function() { $('#destino option').prop('selected', 'selected'); });
	 

 $('.pasaro').click(function() { return !$('#eva_origen option:selected').remove().appendTo('#eva_destino'); });  
		$('.quitaro').click(function() { return !$('#eva_destino option:selected').remove().appendTo('#eva_origen'); });
		$('.pasartodoso').click(function() { $('#eva_origen option').each(function() { $(this).remove().appendTo('#eva_destino'); }); });
		$('.quitartodoso').click(function() { $('#eva_destino option').each(function() { $(this).remove().appendTo('#eva_origen'); }); });


 $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
          });
		  
		  		  


$("#nvo").html('<input type="button" name="nuevaClase id="nuevaClase" value="Guardar" onclick="GuardaClaseEdi()" class="botonXX" /> <input type="button" name="btnC" id="btnC" value="Cancelar" onclick="cancela()" class="botonXX" />');

  });
  
 




</script>

  </script>
<table width="650" border="0" align="center" cellspacing="3">
 <tr>
   <td colspan="4" align="center"><input type="hidden" name="id_clase" id="id_clase" value="<?php echo $fila['id_clase'] ?>" />
    <input type="hidden" name="rm" id="rm" value="<?=pg_result($rs_ramo,2);?>" />    INFORMACION CLASE </td>
  </tr>
 <tr>
		  <td width="120" class="cuadro02">FECHA INICIO</td>
		  <td width="126" class="cuadro02">FECHA TERMINO</td>
		  <td width="152" class="cuadro02">CLASES ASIGNADAS</td>
		  <td width="147" class="cuadro02">HORAS ASIGNADAS</td>
	  </tr>
		<tr>
		  <td class="cuadro01"><input name="f_inicio" type="text" id="f_inicio" size="10" value="<?php echo CambioFD($fila['fecha_inicio']) ?>" /> </td>
		  <td class="cuadro01"><input name="f_termino" type="text" id="f_termino" size="10" value="<?php echo CambioFD($fila['fecha_termino']) ?>" />	</td>
		  <td class="cuadro01"><input name="cant_clases" type="text" id="cant_clases" size="5" class="solo-numero" value="<?php echo $fila['cant_clase'] ?>" />		    </td>
		  <td class="cuadro01"><input name="cant_horas" type="text" id="cant_horas" size="5" class="solo-numero" value="<?php echo $fila['cant_hora'] ?>" /></td>
	  </tr>
		<tr>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
		  <td>&nbsp;</td>
  </tr>
		<tr>
		  <td class="cuadro02">NOMBRE CLASE</td>
		  <td class="cuadro01"><input type="text" name="txt_nombre" id="txt_nombre" value="<?php echo $fila['nombre'] ?>" /></td>
		  <td colspan="2" class="cuadro02">DOCENTE	      </td>
  </tr>
		<tr>
		  <td class="cuadro02">TIPO</td>
		  <td class="cuadro01"><select name="cmb_tipo" id="cmb_tipo">
          <option value="0">seleccione...</option>
          <?php for($t=0;$t<pg_numrows($rs_tipoClase);$t++){
			  $fila_tipo=pg_fetch_array($rs_tipoClase,$t);
			  ?>
          <option value="<?php echo $fila_tipo['id_tipo'] ?>" <?php echo ($fila_tipo['id_tipo']==$fila['tipo'])?"selected":"" ?>><?php echo $fila_tipo['tipo'] ?></option>
          
          <?php }?>
	      </select></td>
		  <td colspan="2" class="cuadro01"><select name="cmbDocente" id="cmbDocente">
		    <option value="0" selected="selected">seleccione...</option>
		    <?php  for($d=0;$do<pg_numrows($rs_docente);$do++){
			 $fila_do = pg_fetch_array($rs_docente,$do);
			 ?>
		    <option value="<?php echo $fila_do['rut_emp'] ?>" <?php echo ($fila['rut_emp']==$fila_do['rut_emp'])?'selected="selected"':"" ?>><?php echo $fila_do['ape_pat'] ?> <?php echo $fila_do['ape_mat'] ?>,<?php echo $fila_do['nombre_emp'] ?></option>
		    <?php }?>
	      </select></td>
  </tr>
</table>
<br />
<br />
<table width="650" border="0" align="center">
 <tr>
    <td colspan="4" class="cuadro02"><!--<input name="tipo" type="radio" id="tipo0" onclick="cargatipoedi(0,<?php echo $fila['id_unidad']?>);dejamarcaobj()" value="0" checked="checked" />Objetivos 
<input name="tipo" id="tipo1" type="radio" value="1" onclick="cargatipoedi(1,<?php echo $fila['id_unidad']?>); " />
      Habilidades 
      <input type="hidden" name="cargaobj" id="cargaobj" value="<?php echo $cob ?>" /> 
    <input type="hidden" name="cargahab" id="cargahab"  value="<?php echo $cab ?>" />-->
     <?php 
	 
	 
	 for($ti=0;$ti<pg_numrows($rs_tipo);$ti++){
		  $fila_tipo = pg_fetch_array($rs_tipo,$ti);
		  ?>
           <?php if($ti==0){
				$crg=$fila_tipo['id_objetivo'];
				 ?>
          <input name="crg" id="crg" type="hidden" value="<?php echo $fila_tipo['id_objetivo']; ?>" />
          <?php }?>
          <?
		  
			$rs_obj=$ob_clase->traeObjclase($conn,$fila_tipo['id_objetivo'],$clase);
			$cob="";
			for($o=0;$o<pg_numrows($rs_obj);$o++){
				$fil_obj=pg_fetch_array($rs_obj,$o);
				
				$cob.=$fil_obj['id_obj'].",";
			}
			$cob=substr($cob, 0, -1);
			
			$cad_ind="";
			$rs_inditpo = $ob_clase->traeIndiUnidadC($conn,$clase,$fila_tipo['id_objetivo']);
			if(pg_numrows($rs_inditpo)>0){
			for($in=0;$in<pg_numrows($rs_inditpo);$in++){
			$fila_in = pg_fetch_array($rs_inditpo,$in);
			$cad_ind.=$fila_in['id_obj']."_".$fila_in['id_indicador'].","; 	
			}	
			}
		  
		  ?>
           <input type="hidden" name="cargatipo[]" id="cargatipo<?php echo $fila_tipo['id_objetivo']; ?>" value="<?php echo $cob ?>" /> 
      <input name="tipo" id="tipo<?php echo $t ?>" type="radio" value="<?php echo $fila_tipo['id_objetivo']; ?>" onclick="cargatipo(<?php echo $fila_tipo['id_objetivo']; ?>,<?php echo $fila['id_unidad']?>);" <?php echo ($ti==0)?"checked":"" ?> /><?php echo $fila_tipo['nombre']; ?>
      <input type="hidden" name="cargaind[]" id="cargaind<?php echo $fila_tipo['id_objetivo']; ?>" value="<?php echo $cad_ind ?>" />
      
    <?php }?></td>
  </tr>
</table>
<div id="mx">
</div>
<div id="my">
</div>
<br />
<br />
<table width="650" border="0" align="center" cellspacing="3">
 
 <tr>
   <td class="cuadro02">Inicio</td>
 </tr>
 <tr>
   <td class="cuadro01"><textarea name="txt_inicio" cols="80" rows="5" id="txt_inicio"><?php echo $fila['inicio'] ?></textarea>     </td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td class="cuadro02">Desarrollo</td>
 </tr>
 <tr>
   <td class="cuadro01"><textarea name="txt_desarrollo" cols="80" rows="5" id="txt_desarrollo"><?php echo $fila['desarrollo'] ?></textarea>     </td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td class="cuadro02">Cierre</td>
 </tr>
 <tr>
   <td class="cuadro01"><textarea name="txt_cierre" cols="80" rows="5" id="txt_cierre"><?php echo $fila['cierre'] ?></textarea>     </td>
 </tr>
 <tr>
   <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
   <td class="cuadro02">Evaluaci&oacute;n&nbsp;<input type="button" name="button5" id="button5" value="+" onClick="creatipoEva()" class="botonXX"></td>
  </tr>
 <tr>
		  <td class="cuadro01"><!--<textarea name="txt_evaluacion" cols="80" rows="5" id="txt_evaluacion"></textarea>-->
          <table width="100%" border="0" cellspacing="0">
  <tr>
    <td width="43%">&nbsp;
      <select name="eva_origen[]" multiple="multiple" size="8" style="width:250px" id="eva_origen">
        <?php for($t=0;$t<pg_numrows($rs_eva_org);$t++){
				$fila_tipo = pg_fetch_array($rs_eva_org,$t);?>
                 <option value="<?php echo $fila_tipo['id_tipo'] ?>"><?php echo $fila_tipo['nombre'] ?></option>
                <?php }?>
      </select></td>
    <td width="12%" align="center"><p>
    <input type="button" class="pasaro izq botonXX" value="Pasar &raquo;">
  </p>
    <p>
      <input type="button" class="quitaro der botonXX" value="&laquo; Quitar"><br />
      <input type="button" class="pasartodoso izq botonXX" value="Todos &raquo;" >
    </p>
    <p>
      <input type="button" class="quitartodoso der botonXX" value="&laquo; Todos">
    </p>
</td>
    <td width="45%"><select name="eva_destino[]" id="eva_destino" multiple="multiple" size="8" style="width:250px">
    <?php for($t=0;$t<pg_numrows($rs_eva);$t++){
	 $fila_top= pg_fetch_array($rs_eva,$t);
	 ?>
     <option value="<?php echo $fila_top['id_tipo'] ?>"><?php echo $fila_top['nombre'] ?></option>
     <?php }?>
    </select></td>
  </tr>
</table>
</td>
  </tr>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td class="cuadro02">Actitudes</td>
 </tr>
 <tr>
   <td class="cuadro01"><textarea name="txt_actitudes" cols="80" rows="5" id="txt_actitudes"><?php echo $fila['actitudes'] ?></textarea></td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 <tr>
   <td class="cuadro02">Recursos
    <input type="button" name="button" id="button" value="+" onclick="creaRecurso()" class="botonXX"/></td>
 </tr>
 
 <!-- <?php for($r=0;$r<pg_numrows($rs_recurso);$r++){
	 $fila_rec= pg_fetch_array($rs_recurso,$r);
	 ?>
 <tr>
   <td><?php echo $fila_rec['nombre'] ?></td>
 </tr>
 <?php }?>
-->
 
 <tr>
   <td><table width="650" border="0" align="center" idth="650">

<tr class="cuadro01">
  <td align="center"><div id="traeorg">
  <select name="origen[]" id="origen" multiple="multiple" size="8" style="width:250px">
			  <?php for($r=0;$r<pg_numrows($rs_recurso_org);$r++){
				$fila_recurso_org = pg_fetch_array($rs_recurso_org,$r);?>
            <option value="<?php echo $fila_recurso_org['id_recurso'] ?>"><?php echo $fila_recurso_org['nombre'] ?></option>
            <?php }?>
			</select>
    </div>
</td>
  <td align="center"><p>
    <input type="button" class="pasar izq botonXX" value="Pasar &raquo;">
  </p>
    <p>
      <input type="button" class="quitar der botonXX" value="&laquo; Quitar"><br />
      <input type="button" class="pasartodos izq botonXX" value="Todos &raquo;" >
    </p>
    <p>
      <input type="button" class="quitartodos der botonXX" value="&laquo; Todos" >
    </p>

  </td>
  <td align="center"><select name="destino[]" id="destino" multiple="multiple" size="8" style="width:250px">
   <?php for($r=0;$r<pg_numrows($rs_recurso);$r++){
				$fila_recurso = pg_fetch_array($rs_recurso,$r);?>
            <option value="<?php echo $fila_recurso['id_recurso'] ?>"><?php echo $fila_recurso['nombre'] ?></option>
            <?php }?></select>

</td>
</tr>
</table></td>
 </tr>
 <tr>
   <td>&nbsp;</td>
 </tr>
 <?php for($o=0;$o<pg_numrows($rs_obj);$o++){
	 $fila_obj= pg_fetch_array($rs_obj,$o);
	 ?>
 <?php }?>
  <?php for($h=0;$h<pg_numrows($rs_hab);$h++){
	 $fila_hab= pg_fetch_array($rs_hab,$h);
	 ?>
 <?php }?>
 
</table>
<br />
<br />

<script>
cargatipo(<?php echo  $crg?>,<?php echo $fila['id_unidad']?>);

</script>

<?php }
if($funcion==9){
	
	$rs_objetivo=$ob_clase->traeObjUnidad($conn,$tipo,$id_unidad);
	
	?>
    
<table width="650" align="center" border="1" style="border-collapse:collapse">
	<?
	
$rs_objetivo =$ob_clase->traeEjeObjetivo($conn,$rdb,$cod_ramo,$tipo);
 for($o=0;$o<pg_numrows($rs_objetivo);$o++){
		 $fila_obj = pg_fetch_array($rs_objetivo,$o);
		 ?>
		  <tr><td class="cuadro02"><?php echo $fila_obj['texto'] ?></td>
		  <?
		 $rs_eje =$ob_unidad->traeObj($conn,$fila_obj['id_eje'],$rdb,$ense,$grado);
		 for($j=0;$j<pg_numrows($rs_eje);$j++){
			$fila = $fila_obj = pg_fetch_array($rs_eje,$j);
			
			$rs_marca = $ob_unidad->ob_clase($conn,$id_unidad,$fila['id_obj']);
			if(pg_numrows($rs_marca)==0){
			$marca=0;
			}else{
			$marca=1;
			}
			
			?>
		   <tr><td align="justify" id="fila<?php echo  $fila['id_obj']?>" onclick="pp(<?php echo  $fila['id_obj']?>);sumatipo(<?php echo  $fila['tipo']?>);" class="i textosimple"><?php echo $fila['codigo']."-".$fila['texto'] ?><input name="obj_destino[]" type="checkbox" class="oo<?php echo  $fila['tipo']?>" id="destino<?=$fila['id_obj']?>" style="visibility:hidden" value="<?php echo  $fila['id_obj']?>" <?php echo ($marca==1)?"checked":"" ?> />
		       <input type="hidden" id="lindv<?php echo  $fila['id_obj']?>3" name="lindv<?php echo  $fila['id_obj']?>3" class="lindv<?php echo  $fila['tipo']?>" value="<?php echo $cad_ind ?>"/></td></tr>
          <?
		 }
		 
		 
              
 }


	
	?>
</table>
<script>
//dejamarcaobj();
</script>
    <?

	}
	
if($funcion==10){
	

	$rs_guarda = $ob_clase->modificaClase($conn,$cmbDocente,utf8_decode($txt_nombre),$cmb_tipo,CambioFE($f_inicio),CambioFE($f_termino),utf8_decode($txt_evaluacion),utf8_decode($txt_inicio),utf8_decode($txt_desarrollo),utf8_decode($txt_cierre),utf8_decode($txt_actitudes),$cant_clases,$cant_horas,$id_clase);

if($rs_guarda){
	$ob_clase->eliminaObHa($conn,$id_clase);
	$ob_clase->eliminaRec($conn,$id_clase); 
	$ob_clase->eliminaEva($conn,$id_clase); 
	$d_obj = $ob_clase->borraIndicador($conn,$id_clase);
	
$rec = $_POST['destino'];	
if(count($rec)>0){
	for($d=0;$d<count($rec);$d++){
		$rs_recurso = $ob_clase->guardaClaseRecurso($conn,$id_clase,$rec[$d]);
	}
}
$obj_destino=$_POST['cargatipo'];

$eva_destino=$_POST['eva_destino'];

 /*if(count($obj_destino)>0){
			for ($i=0;$i<count($obj_destino);$i++) { 
			$rs_guardaObjetivo = $ob_clase->guardaObjetivo($conn,$id_clase,$obj_destino[$i]);
			} 
		 }
	
		if(count($hab_destino)>0){	
			 for ($j=0;$j<count($hab_destino);$j++) { 
			 $rs_guardaHabilidad = $ob_clase->guardaObjetivo($conn,$id_clase,$hab_destino[$j]);
			} 
		}*/
		
		if(count($obj_destino)>0){
			for ($i=0;$i<count($obj_destino);$i++) { 
			$cuenta_tipo = explode(",",$obj_destino[$i]);
				for ($j=0;$j<count($cuenta_tipo);$j++) { 
				$rs_guardaObjetivo = $ob_clase->guardaObjetivo($conn,$id_clase,$cuenta_tipo[$j]);
				}
			} 
		 }

		if(count($eva_destino)>0){	
			 for ($k=0;$k<count($eva_destino);$k++) { 
			 $rs_guardaTipo = $ob_clase->guardaEva($conn,$id_clase,$eva_destino[$k]);
			} 
		}

	 //indicadores
			if(strlen($_POST["cargaind"])>0){
				$lista = $_POST["cargaind"];
				for($l=0;$l<count($_POST["cargaind"]);$l++){
					$cuenta_ind = explode(",",$lista[$l]);
					if(strlen($lista[$l])>0){
					//show($cuenta_ind);
					for($k=0;$k<count($cuenta_ind);$k++){
					$cc=explode("_",$cuenta_ind[$k]);
					$indicador = $cc[1];
					$objetivo =$cc[0];
					  $ob_clase->guardaIndicadorSel($conn,$id_clase,$objetivo,$indicador); 
					 
						}
					}
				}
				
				}

	echo 1;
}
else{
echo 0;
}
	
}

if($funcion==11){
	$rs_estado = $ob_clase->traeEstadoClase($conn);
	$rs_historial = $ob_clase->traeHistorialcambios($conn,$clase);
	
	?>
    <?php if($_PERFIL==0 || $_PERFIL==14 || $_PERFIL==25){?>
    <input type="hidden" id="clase" value="<?php echo $clase ?>" />
    <table width="599" border="1" style="border-collapse:collapse">
    <tr><td width="160" class="cuadro02">Seleccione Estado</td>
    <td width="711"><select name="opc_estado" id="opc_estado" onchange="abrecomen()">
    <option value="0">seleccione...</option>
    <?php for($e=0;$e<pg_numrows($rs_estado);$e++){
		$fila_estado = pg_fetch_array($rs_estado,$e);
		if($fila_estado['id_estado']!=1 && $fila_estado['id_estado']!=3){
		?>
        <option value="<?php echo $fila_estado['id_estado'] ?>"><?php echo $fila_estado['glosa'] ?></option>
		
   <?php }}?>
    
    </select></td></tr>
    </table>
<br />
<br />

    <div id="comest"></div>
    <br />
<br />
<?php }?>
<table width="600" border="1" style="border-collapse:collapse">
<tr class="cuadro02">
<td colspan="2" align="center">Historial de Cambios</td>
</tr>
<tr class="cuadro02">
<td width="105" >Fecha</td>
<td width="479">Descripci&oacute;n</td>
</tr>
 <?php 
 for($h=0;$h<pg_numrows($rs_historial);$h++){
		$fila_historial = pg_fetch_array($rs_historial,$h);
?>
<tr class="cuadro01">
<td width="105"><?php echo CambioFD($fila_historial['fecha']) ?></td>
<td width="479"><?php echo $fila_historial['observacion'] ?></td>
</tr>
<?php }?>
</table>
    <?
 
}	
if($funcion==12){
	//var_dump($_POST);
	
	$desc=($estado==2)?"Aprobación final":$descripcion;
	
	$rs_estado = $ob_clase->guardaHistorialcambios($conn,$clase,date("Y-m-d"),$desc);
	
	if($rs_estado){
	$rs_cambia = $ob_clase->cambiaEstadoClase($conn,$clase,$estado);
	echo 1;
	}
	else{
	echo 0;
	}
}
if($funcion==13){
	//var_dump($_POST);
	
		
	$rs_estado = $ob_clase->cambiaRealizada($conn,$clase,$estado);
	
	if($rs_estado){
	echo 1;
	}
	else{
	echo 0;
	}
}
if($funcion==14){
	//var_dump($_POST);
	
	$rs_curso =  $ob_clase->cursoTieneRamo($conn,$ano,$cod_ramo);
	?>
    <div align="center">Seleccione curso y clase donde desea replicar la clase</div>
    <br />
<br />
 
<input type="hidden" id="clsorig" value="<?php echo $clase ?>" />
    <select name="cur2" id="cur2" onchange="suni(this.value)">
    <option value="0">seleccione...</option>
    <?php for($e=0;$e<pg_numrows($rs_curso);$e++){
		$fila_curso = pg_fetch_array($rs_curso,$e);
		?>
        <option value="<?php echo $fila_curso['id_curso'] ?>"><?php echo CursoPalabra( $fila_curso['id_curso'],1,$conn) ?></option>
   <?php }?>
    </select>
    <br />
<br />

    <div id="lcur"></div>
    <br />
<br />
    <?
}if($funcion==15){
	$rs_unidad =  $ob_clase->listaUnidad($conn,$curso);
	if(pg_numrows($rs_unidad)>0){
?>
 <select name="unid" id="unid" onchange="activaboton()">
  <option value="0">seleccione unidad...</option>
  <?php for($u=0;$u<pg_numrows($rs_unidad);$u++){
	  $fila_unidad = pg_fetch_array($rs_unidad,$u);
	  ?>
  <option value="<?php echo $fila_unidad['id_unidad'] ?>"><?php echo $fila_unidad['nombre'] ?></option>
  <?php }?>
 </select>
<?	
}else{
echo "curso no tiene unidades asocadas";
}
}

if($funcion==16){
$clase_fuente = $ob_clase->traeClaseUno($conn,$fuente);
$fila_fuente = pg_fetch_array($clase_fuente,0);

$rs_ramo_des=$ob_clase->traecodRamo2($conn,$curso,$cod_ramo);
$ramo_destino = pg_result($rs_ramo_des,0);

$rs_doc_des = $ob_clase->traeDicta($conn,$ramo_destino);
$doc_destino = pg_result($rs_doc_des,0);

$txt_nombre = $fila_fuente['nombre'];
$cmb_tipo = $fila_fuente['tipo'];
$f_inicio = $fila_fuente['fecha_inicio'];
$f_termino = $fila_fuente['fecha_termino'];
$txt_evaluacion = $fila_fuente['evaluacion'];
$txt_desarrollo = $fila_fuente['desarrollo'];
$txt_cierre = $fila_fuente['cierre'];
$txt_actitudes = $fila_fuente['actitudes'];
$cant_clases = $fila_fuente['cant_clase'];
$cant_horas = $fila_fuente['cant_hora'];
$txt_inicio = $fila_fuente['inicio'];


$rs_guarda = $ob_clase->guardaClase($conn,$destino,$curso,$ramo_destino,$doc_destino,$txt_nombre,$cmb_tipo,$f_inicio,$f_termino,$txt_evaluacion,$txt_inicio,$txt_desarrollo,$txt_cierre,$txt_actitudes,$cant_clases,$cant_horas);

if($rs_guarda){
	 
$rs_ultimo = $ob_clase->ultimaClase($conn,$destino);
$clase = pg_result($rs_ultimo,0);

//objetivos y habilidades
$rs_obj = $ob_clase->traeObjclaseAll($conn,$fuente);
if(pg_numrows($rs_obj)>0){
	for($ro=0;$ro<pg_numrows($rs_obj);$ro++){
		$fila_obj = pg_fetch_array($rs_obj,$ro);
		$rs_guardaObjetivo = $ob_clase->guardaObjetivo($conn,$clase,$fila_obj['id_obj']);
	}
}

//recursos
$rs_recurso=$ob_clase->listaRecursosClase($conn,$fuente);
if(pg_numrows($rs_recurso)>0){
//$fila_recurso = pg_fetch_array();
	for($rr=0;$rr<pg_numrows($rs_recurso);$rr++){
		$fila_recursor = pg_fetch_array($rs_recurso,$rr);
		$rs_recursor = $ob_clase->guardaClaseRecurso($conn,$clase,$fila_recursor['id_recurso']);
	}
}



	echo 1;
}
else{
echo 0;
}
 
}
if($funcion==17){
$clase_fuente = $ob_clase->traeClaseUno($conn,$clase);
$fila_fuente = pg_fetch_array($clase_fuente,0);
$rs_periodo = $ob_clase->periodo($conn,$_ANO);

	?>
   
     <div align="center">Seleccione a qu&eacute; nota se debe asociar la clase</div>
    <br />
<br />
<input type="hidden" id="lo" name="lo" value="" />
<input type="hidden" id="clase" name="clase" value="<?php echo $clase ?>" />
<input type="hidden" id="unidad" name="unidad" value="<?php echo pg_result($clase_fuente,1) ?>" />
<input type="hidden" id="ramo" name="ramo" value="<?php echo pg_result($clase_fuente,3) ?>" />
<select id="cmbPeriodo" name="cmbPeriodo" onchange="activanota()">
<option value="0">Selecione periodo</option>
<?php for($p=0;$p<pg_numrows($rs_periodo);$p++){
	$fila_periodo = pg_fetch_array($rs_periodo,$p);
	
	
	 ?>
<option value="<?php echo $fila_periodo['id_periodo'] ?>"><?php echo $fila_periodo['nombre_periodo'] ?></option>
<?php }?>
</select><br />
<br />
<div id="chknota"></div>

	<?
	
}
if($funcion==18){

?>

<table border="1">
<tr>
<?php 
//casillas notas
for($n=1;$n<=20;$n++){
	$rs_nota = $ob_clase->marcanota($conn,$clase,$unidad,$periodo,$n,$ramo);
	$fclase = pg_fetch_array($rs_nota,0);
	//echo "<br>".$clase."-".$fclase['id_clase'];
	?>
<td>
<input type="checkbox" name="pos_nota[]" id="nota<?php echo $n ?>" class="notas" <?php echo (pg_numrows($rs_nota)>0 && $clase==$fclase['id_clase'])?"checked":"" ?> <?php //echo (pg_numrows($rs_nota)>0 && $clase!=$fclase['id_clase'])?'disabled="disabled"':"" ?> onclick="cuentacheck()" value="<?php echo $n ?>" /> Nota<?php echo $n ?>
</td>
<?
	
	echo ($n%5==0)?"</tr><tr>":"";
		?>
 
    <? } ?>
  </tr>
</table>
<?
}
if($funcion==19){
$rs_borranota = $ob_clase->borraNota($conn,$clase,$unidad,$periodo);

$ps = $_POST['pos'];
$ps1=explode(",",$ps);

for ($p=0;$p<count($ps1);$p++) { 
			$rs_guardaNota = $ob_clase->guardaNota($conn,$clase,$unidad,$ps1[$p],$periodo,$ramo);
			}

echo 1;
}
if($funcion==20){
$rs_periodo = $ob_clase->periodo($conn,$_ANO);
$clase_fuente = $ob_clase->traeClaseUno($conn,$clase);
$fila_fuente = pg_fetch_array($clase_fuente,0);
?>
<input type="hidden" id="clase" name="clase" value="<?php echo $clase ?>" />
<input type="hidden" id="unidad" name="unidad" value="<?php echo pg_result($clase_fuente,1) ?>" />
<input type="hidden" id="ramo" name="ramo" value="<?php echo pg_result($clase_fuente,3) ?>" />
<input type="hidden" id="ano" name="ano" value="<?php echo $ano ?>" />
<input type="hidden" id="curso" name="curso" value="<?php echo $curso ?>" />

<select id="cmbPeriodo" name="cmbPeriodo" onchange="mcasillero()">
<option value="0">Selecione periodo</option>
<?php for($p=0;$p<pg_numrows($rs_periodo);$p++){
	$fila_periodo = pg_fetch_array($rs_periodo,$p);
	
	
	 ?>
<option value="<?php echo $fila_periodo['id_periodo'] ?>"><?php echo $fila_periodo['nombre_periodo'] ?></option>
<?php }?>
</select><br />
<br />

<div id="infnota">

</div>
<?
}
if($funcion==21){
	?>
<table border="1">
<tr><td>Casillero</td>
  <td>Fecha</td>
  <td>Tipo</td>
  <td colspan="2">Acciones</td></tr>
<?php for($c=1;$c<=20;$c++){
	$rs_cas = $ob_clase->traeLeccionario($conn,$ramo,$c,$periodo);
	$fila_lx= pg_fetch_array($rs_cas,0);
	?>
<tr>
  <td><?php echo $c; ?></td>
  <td align="center"><?php echo (pg_numrows($rs_cas)>0)?CambioFD($fila_lx['fecha']):"Disponible" ?></td>
   <td align="center"><?php echo (pg_numrows($rs_cas)>0)?$fila_lx['descripcion']:"--" ?></td>
  <td align="center">
  <?php if (pg_numrows($rs_cas)>0){ ?>
  <input type="button" name="an" id="an" value="ED" onclick="editaLX(<?php echo $fila_lx['id_lexionario'] ?>)" />
  <?php }else {?>
  <input type="button" name="an" id="an" value="AL" onclick="nuevoLX(<?php echo $c?>)" />
  <?php }?>
  </td>
  <td align="center"><?php echo (pg_numrows($rs_cas)>0)?'<input type="button" name="an2" id="an2" value="E" onclick="eliminaLX('.$fila_lx['id_lexionario'].')" />':"--" ?></td>
</tr>
<?php }?>
</table>
<?
}
if($funcion==22){
//var_dump($_POST);

$rs_tipolex = $ob_clase->traeTipoLeccionario($conn,$ramo,$curso,$ano);
//echo pg_numrows($rs_tipolex);
?>
<script>
$(document).ready(function(){
	
	$("#fechalex").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			/*minDate: new Date('01/01/'+anio+''),
			maxDate: new Date('12/31/'+anio+''),*/
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});
		
	  });
  
 
	

  </script>

<input type="hidden" id="ramo" name="ramo" value="<?php echo $ramo ?>" />
<input type="hidden" id="ano" name="ano" value="<?php echo $ano ?>" />
<input type="hidden" id="curso" name="curso" value="<?php echo $curso ?>" />
<input type="hidden" id="notalx" name="notalx" value="<?php echo $nota ?>" />
<input type="hidden" id="idlx" name="idlx" value="<?php echo $idlec ?>" />
<table>
<tr><td>Fecha</td>
<td><input type="text" id="fechalex" name="fechalex" /></td></tr>
<tr>
  <td>Tipo</td>
  <td>
   <span id="seltipo">
  <select name="tipolex" id="tipolex" onchange="valtipo()">
  <option value="0">seleccione...</option>
  <? for($lx=0;$lx<pg_numrows($rs_tipolex);$lx++){
	  $fila_lx = pg_fetch_array($rs_tipolex,$lx);
	   ?>
  <option value="<?php echo $fila_lx['id_tipo'] ?>"><?php echo $fila_lx['nombre'] ?></option>
  <? } ?>
  </select>
  </span>
  <input type="button" name="btnadlex" id="btnadlex" value="+" onclick="nuevotipo()"/></td>
</tr>
<tr>
  <td>Descripci&oacute;n</td>
  <td><textarea name="nombrelx" id="nombrelx" onblur="valtipo()"></textarea></td>
</tr>
</table>

<?

}
if($funcion==23){
	

$fecha=CambioFE($fecha);

$rs_guarda_lex = $ob_clase->guardaLeccionario($conn,$ano,$curso,$ramo,$fecha,$descripcion,$tipo,$nota,$id_periodo);
if($rs_guarda_lex){
echo 1;
}else echo 0;
}

if($funcion==24){
$rs_borra_lex = $ob_clase->eliminaLeccionario($conn,$idlec);
if($rs_borra_lex){
echo 1;
}else echo 0;
}
if($funcion==25){
//var_dump($_POST);
$rs_lx1 = $ob_clase->traeLeccionarioUno($conn,$idlec);
$rs_tipolex = $ob_clase->traeTipoLeccionario($conn,$ramo,$curso,$ano);
//echo pg_numrows($rs_tipolex);
?>
<script>
$(document).ready(function(){
	
	$("#fechalex").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			/*minDate: new Date('01/01/'+anio+''),
			maxDate: new Date('12/31/'+anio+''),*/
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});
		
	  });
  
 
	

  </script>
<input type="hidden" id="idlx" name="idlx" value="<?php echo $idlec ?>" />
<input type="hidden" id="ramo" name="ramo" value="<?php echo $ramo ?>" />
<input type="hidden" id="ano" name="ano" value="<?php echo $ano ?>" />
<input type="hidden" id="curso" name="curso" value="<?php echo $curso ?>" />
<table>
<tr><td>Fecha</td>
<td><input type="text" id="fechalex" name="fechalex" value="<?php echo CambioFD(pg_result($rs_lx1,4)); ?>" /></td></tr>
<tr>
  <td>Tipo</td>
  <td>
  <span id="seltipo">
  
  <select name="tipolex" id="tipolex" onchange="valtipo()">
  <option value="0">seleccione...</option>
  <? for($lx=0;$lx<pg_numrows($rs_tipolex);$lx++){
	  $fila_lx = pg_fetch_array($rs_tipolex,$lx);
	   ?>
  <option value="<?php echo $fila_lx['id_tipo'] ?>" <?php echo ($fila_lx['id_tipo']==pg_result($rs_lx1,6)?"selected":"") ?>><?php echo $fila_lx['nombre'] ?></option>
  <? } ?>
  </select>
  </span>
  <input type="button" name="btnadlex" id="btnadlex" value="+" onclick="nuevotipo()"/></td>
</tr>
<tr>
  <td>Descripci&oacute;n</td>
  <td><textarea name="nombrelx" id="nombrelx" onblur="valtipo()"><?php echo pg_result($rs_lx1,5) ?></textarea></td>
</tr>
</table>
<?
}
if($funcion==26){
$fecha=CambioFE($fecha);

$rs_guarda_lex = $ob_clase->actualizaLeccionario($conn,$fecha,$descripcion,$tipo,$id_lexionario);
if($rs_guarda_lex){
echo 1;
}else echo 0;
}
if($funcion==27){
	//var_dump($_POST);
	?>
    
    <input type="hidden" id="ramo" name="ramo" value="<?php echo $ramo ?>" />
<input type="hidden" id="ano" name="ano" value="<?php echo $ano ?>" />
<input type="hidden" id="curso" name="curso" value="<?php echo $curso ?>" />
    <table>
    <tr>
  <td>Descripci&oacute;n</td>
  <td><input type="text" name="nombretp" id="nombretp" onblur="valtipotp()"></td>
</tr>
    </table>
    <?
}
if($funcion==28){
	//var_dump($_POST);
	$rs_guardatipo = $ob_clase->guardaTipoLeccionario($conn,$ramo,$curso,$ano,$nombre);
	if($rs_guardatipo){
		echo 1;
	}else{
		echo 0;
	}
}

if($funcion==29){
	$rs_tipolex = $ob_clase->traeTipoLeccionario($conn,$ramo,$curso,$ano);
	
	if($rs_tipolex){
	?>
     <select name="tipolex" id="tipolex" onchange="valtipo()">
  <option value="0">seleccione...</option>
  <? for($lx=0;$lx<pg_numrows($rs_tipolex);$lx++){
	  $fila_lx = pg_fetch_array($rs_tipolex,$lx);
	   ?>
  <option value="<?php echo $fila_lx['id_tipo'] ?>" <?php echo ($fila_lx['id_tipo']==pg_result($rs_lx1,6)?"selected":"") ?>><?php echo $fila_lx['nombre'] ?></option>
  <? } ?>
  </select>
    <?
	}else{
		echo 0;
	}
}
if($funcion==30){
?>
 
<script>
$(document).ready(function(){
 
    $(".messages").hide();
    //queremos que esta variable sea global
    var fileExtension = "";
    //función que observa los cambios del campo file y obtiene información
    $(':file').change(function()
    {
        //obtenemos un array con los datos del archivo
        var file = $("#imagen")[0].files[0];
        //obtenemos el nombre del archivo
        var fileName = file.name;
        //obtenemos la extensión del archivo
        fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
        //obtenemos el tamaño del archivo
        var fileSize = file.size;
        //obtenemos el tipo de archivo image/png ejemplo
        var fileType = file.type;
        //mensaje con la información del archivo
        showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" bytes.</span>");
    });
 
    //al enviar el formulario
    $('#subei').click(function(){
        //información del formulario
        var formData = new FormData($(".formulario")[0]);
        var message = ""; 
        //hacemos la petición ajax  
        $.ajax({
            url: 'upload.php',  
            type: 'POST',
            // Form data
            //datos del formulario
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            //mientras enviamos el archivo
            beforeSend: function(){
                message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
                showMessage(message)        
            },
            //una vez finalizado correctamente
            success: function(data){
                message = $("<span class='success'>La imagen ha subido correctamente.</span>");
                showMessage(message);
                if(isImage(fileExtension))
                {
                    $(".showImage").html("<img src='../acv/"+data+"' />");
                }
            },
            //si ha ocurrido un error
            error: function(){
                message = $("<span class='error'>Ha ocurrido un error.</span>");
                showMessage(message);
            }
        });
    });
})
 
//como la utilizamos demasiadas veces, creamos una función para 
//evitar repetición de código
function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}
 
//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
function isImage(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'jpg': case 'gif': case 'png': case 'jpeg':
            return true;
        break;
        default:
            return false;
        break;
    }
}
</script>
 


    <!--el enctype debe soportar subida de archivos con multipart/form-data-->
   <!-- <form enctype="multipart/form-data" class="formulario">-->
        <label>Subir un archivo</label><br />
        <input name="archivo" type="file" id="imagen" /><br /><br />
        <input type="button" value="Subir imagen" id="subei" /><br />
    <!--</form>-->
    <!--div para visualizar mensajes-->
    <div class="messages"></div><br /><br />
    <!--div para visualizar en el caso de imagen-->
    <div class="showImage"></div>

<?
}if($funcion==31){
	$rs_nuevot=$ob_clase->guardatipo($conn,$nombre,$ins);

$rs_ultimo=$ob_clase->traeUltimotipo($conn,$ins);
$f_re=pg_fetch_array($rs_ultimo,0);	
	
echo '<option value="'.$f_re['id_tipo'].'">'.utf8_decode($f_re['nombre']).'</option>';
}
if($funcion==32){

$ruta ="acv/";

//busco si tengo archivos asociados
$rs_lista = $ob_clase->archivoClase($conn,$id_clase);
if(pg_numrows($rs_lista)>0){
	for($a=0;$a<pg_numrows($rs_lista);$a++){
	$fila = pg_fetch_array($rs_lista,$a);
		@unlink($ruta.$fila['ruta']) ;
	}
}





$ob_clase->delArchivoClase($conn,$id_clase);
$ob_clase->delNotaClase($conn,$id_clase);
$ob_clase->delObsClase($conn,$id_clase);
$ob_clase->delRecursoClase($conn,$id_clase);
$ob_clase->delTipoevaClase($conn,$id_clase);
$ob_clase->delObjClase($conn,$id_clase);
$ob_clase->delClase($conn,$id_clase);

}
if($funcion==33){
//show($_POST);

$rs_indi = $ob_clase->buscaIndicadorSel($conn,$obj,$un);
?><br />
<br />

<table width="100%" border="1" style="border-collapse:collapse">
<?php for($i=0;$i<pg_numrows($rs_indi);$i++){
	$fila=pg_fetch_array($rs_indi,$i);?>
  <tr id="filaind<?php echo  $fila['id_indicador']?>">
    <td onclick="ppi(<?php echo $fila['id_indicador'] ?>,<?php echo $obj ?>,<?php echo $fila['tipo'] ?>)"><?php echo $fila['texto'] ?>&nbsp;
    <input type="checkbox" name="ind[]" id="ind<?php echo $fila['id_indicador'] ?>"  class="oid<?php echo  $fila['id_obj']?>" value="<?php echo $fila['id_obj'] ?>_<?php echo $fila['id_indicador'] ?>" style="visibility:hidden" />
    <span class="i textosimple">
    <input type="hidden" id="lindv<?php echo  $fila['id_obj']?>2" name="lindv<?php echo  $fila['id_obj']?>2" class="lindv<?php echo  $fila['tipo']?>" value="<?php echo $cad_ind ?>"/>
    </span></td>
  </tr>
  <?php }?>
</table>
<?	
}
?>