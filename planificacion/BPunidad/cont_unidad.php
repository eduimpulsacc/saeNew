
<?
require("../../util/header.php");
require("mod_unidad.php");
session_start();
$funcion = $_POST['funcion'];

$ob_unidad = new Unidad();


if($funcion==1){ 

	//$rs_curso = $ob_unidad->traeCursos($conn,$ano);
	if($_PERFIL==17){
		$rs_curso= $ob_unidad->cursoSsDocente($conn,$_NOMBREUSUARIO,$_INSTIT,$ano);
	
	}
	else{
		$rs_curso = $ob_unidad->traeCursos($conn,$ano);	
	}
	//exit;
	
?>	<!--onchange="apoderado(this.value);"-->
<?php //echo "dd".$_CURSO ?>

<select name="sel_curso" id="sel_curso" onchange="traeRamo(this.value);" class="select_redondo" >
    	<option	value="0">seleccione...</option>
<? 		for($i=0;$i<pg_numrows($rs_curso);$i++){
			$fila = pg_fetch_array($rs_curso,$i);
?>
		<option value="<?=$fila['id_curso'];?>" <?php echo ($fila['id_curso']==$_CURSO)?"selected":"" ?> ><?=CursoPalabra($fila['id_curso'], 0, $conn);?></option>
        	
<?	
		}
?>
	</select>
<?
}


if($funcion==2){
	//$rs_ramo = $ob_unidad->traeRamo($conn,$curso);
	$_CURSO = $curso;
	
	if($_PERFIL!=17){
	$rs_ramo = $ob_unidad->traeRamo($conn,$curso);
	}else{
	//quiero ver si es profesor jefe
	$rs_super = $ob_unidad->esPJefe($conn,$_NOMBREUSUARIO,$curso) ;
	if(pg_numrows($rs_super )>0){
		$rs_ramo = $ob_unidad->traeRamo($conn,$curso);
	}else{
		$rs_ramo = $ob_unidad->ramosDct($conn,$_NOMBREUSUARIO,$curso);
		}
	}
	//exit;
	
?>	<!--onchange="apoderado(this.value);"-->
<select name="sel_ramo" id="sel_ramo" onchange="dicta(this.value);codigo(this.value);uanual();" class="select_redondo" >
    	<option	value="0">seleccione...</option>
<? 		for($i=0;$i<pg_numrows($rs_ramo);$i++){
			$fila = pg_fetch_array($rs_ramo,$i);
?>
		<option value="<?=$fila['id_ramo'];?>" ><?=$fila['nombre'];?></option>
        	
<?	
		}
?>
	</select>
<?
}

if($funcion==3){
	$_IDR = $ramo;
	
	$rs_dicta = $ob_unidad->traeDicta($conn,$ramo);
	
	if(!$rs_dicta || pg_numrows($rs_dicta)==0)
		{
		 echo "no se encontro docente asociado";	
		}else{
		?>
        <input type="hidden" name="docdicta" id="docdicta" value="<?php echo pg_result($rs_dicta,0) ?>" class="select_redondo" />
        <div class="textosimple"><?php echo strtoupper(pg_result($rs_dicta,2)) ?></div>
        <?
			
		}
	
}

if($funcion==4){
//var_dump($_POST);
$rs_lista = $ob_unidad->listaUnidad($conn,$id_ano,$rdb,$curso,$ramo,$docente,$iun);


?>
<table width="700" border="0" align="center">
  <tr>
    <td align="center" class="cuadro02 tablaredonda">#</td>
    <?php if($curso==0){?>
    <td class="cuadro02 tablaredonda">Curso</td>
    <?php }?>
    <?php if($ramo==0){?>
    <td class="cuadro02 tablaredonda">Ramo</td>
    <?php }?>
    <td class="cuadro02 tablaredonda">Nombre</td>
    <td class="cuadro02 tablaredonda">Estado</td>
    <td class="cuadro02 tablaredonda">Fecha Inicio</td>
    <td class="cuadro02 tablaredonda">Fecha T&eacute;rmino</td>
    <td class="cuadro02 tablaredonda">Horas</td>
    <td colspan="3" align="center" class="cuadro02 tablaredonda"><div align="center">Acciones</div></td>
  </tr>
 <?php  for($i=0;$i<pg_numrows($rs_lista);$i++){
	 $fila=pg_fetch_array($rs_lista,$i);
	 $rs_ramo=$ob_unidad->traeRamo($conn,$fila['id_curso'],$fila['id_ramo']);
	  $rs_estado=$ob_unidad->traeEstadoClaseUno($conn,$fila['estado']);
	   $rs_curso = $ob_unidad->traeCursosUno($conn,$fila['id_curso']);
	 ?>
  <tr class="cuadro01">
    <td align="center" class="tablaredonda">
	<?php echo ($i+1) ?>
    <input type="hidden" name="idUnidad" id="idUnidad" value="<?php echo $fila['id_unidad']?>" />
    <input type="hidden" name="rm<?php echo $fila['id_unidad']?>" id="rm<?php echo $fila['id_unidad']?>" value="<?=pg_result($rs_ramo,2);?>" />
    <input type="hidden" name="grdo2<?php echo $fila['id_unidad']?>" id="grdo2<?php echo $fila['id_unidad']?>" value="<?php echo pg_result($rs_curso,1) ?>" />
 <input name="ens2<?php echo $fila['id_unidad']?>" type="hidden" id="ens2<?php echo $fila['id_unidad']?>" value="<?php echo pg_result($rs_curso,3) ?>"/>
    </td>
     <?php if($curso==0){?>
    <td class="tablaredonda"><?php echo CursoPalabra($fila['id_curso'],1,$conn) ?></td>
    <?php }?>
    <?php if($ramo==0){?>
    <td class="tablaredonda"><?=pg_result($rs_ramo,1);?></td>
    <?php }?>
    <td class="tablaredonda"><?php echo $fila['nombre'] ?></td>
    <td align="center" class="tablaredonda"><?php echo pg_result($rs_estado,1); ?></td>
    <td align="center" class="tablaredonda"><?php echo CambioFD($fila['fecha_inicio'])?></td>
    <td align="center" class="tablaredonda"><?php echo CambioFD($fila['fecha_termino']) ?></td>
    <td align="center" class="tablaredonda"><?php echo $fila['nro_horas'] ?></td>
    <td align="center" class="tablaredonda"><input name="vi" type="button" onClick="veUnidad(<?php echo $fila['id_unidad']?>)" value="V" class="botonXX" /></td>
    <td align="center" class="tablaredonda"><input name="ed" type="button" id="ed" onclick="editaUnidad(<?php echo $fila['id_unidad']?>)" value="E" class="botonXX" /></td>
    
    <td align="center" class="tablaredonda"><input type="button" name="button2" id="button2" value="X" class="botonBX"  onclick="borraUnidad(<?php echo $fila['id_unidad'] ?>)" ></td>
   
      <?php if($_PERFIL==0 || $_PERFIL==14 || $_PERFIL==17 || $_PERFIL==25){?>
    <?php }?>
    <?php if($_PERFIL==0 ){?>
    <?php }?>
  </tr>
  <?php }?>
</table>
<?
}
if($funcion==5){
	//var_dump($_POST);
	
	$rs_objetivo =$ob_unidad->traeEjeObjetivo($conn,$rdb,$cod_ramo);
	$rs_habilidad =$ob_unidad->traeEjeHabilidad($conn,$rdb,$cod_ramo);
	$rs_tipo=$ob_unidad->tejeUnidad($conn,$ciu);
	
	
?>
<script>
$(document).ready(function(){
	
	$("#txt_fechaini, #txt_fechater").datepicker({
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
		
		
          $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
          });
        

  });
  </script>
 
<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td class="cuadro02">Nombre</td>
    <td class="cuadro02">Fecha Inicio</td>
    <td class="cuadro02">Fecha T&eacute;rmino</td>
  </tr>
  <tr>
    <td class="cuadro01"><input type="text" name="txt_nombre" id="txt_nombre" /></td>
    <td class="cuadro01"><input type="text" name="txt_fechaini" id="txt_fechaini" /></td>
    <td class="cuadro01"><input type="text" name="txt_fechater" id="txt_fechater" /></td>
  </tr>
  <tr>
    <td class="cuadro02">Cantidad clases</td>
    <td class="cuadro02">Horas</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01">
    <input type="text" name="cant_clases" id="cant_clases" class="solo-numero" /></td>
    <td class="cuadro01"><input type="text" name="txt_horas" id="txt_horas" class="solo-numero" /></td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="cuadro02">Texto</td>
  </tr>
  <tr>
    <td colspan="3" class="cuadro01"><textarea name="texto" cols="50" rows="5" id="texto" ></textarea></td>
  </tr>
</table>
<br />
<br />

<table width="650" border="1" align="center" style="border-collapse:collapse">
 <tr>
    <td colspan="4" class="cuadro02"><!--<input name="tipo" id="tipo0" type="radio" value="0" onclick="cargatipo(0);" />Objetivos <input name="tipo" id="tipo1" type="radio" value="1" onclick="cargatipo(1);" />
      Habilidades -->
      <!--<input type="hidden" name="cargaobj" id="cargaobj" /> 
      <input type="hidden" name="cargahab" id="cargahab" />-->
      <?php for($ti=0;$ti<pg_numrows($rs_tipo);$ti++){
		  $fila_tipo = pg_fetch_array($rs_tipo,$ti);
		  ?>
          <?php if($ti==0){ ?>
      <input name="crg" id="crg" type="hidden" value="<?php echo $fila_tipo['id_objetivo']; ?>" />
          <?php }?>
          
      <input type="hidden" name="cargatipo[]" id="cargatipo<?php echo $fila_tipo['id_objetivo']; ?>" value="" /> 
      <input name="tipo" id="tipo<?php echo $t ?>" type="radio" value="<?php echo $fila_tipo['id_objetivo']; ?>" onclick="cargatipo(<?php echo $fila_tipo['id_objetivo']; ?>);" <?php echo ($ti==0)?"checked":"" ?> /><?php echo $fila_tipo['nombre']; ?>
      <input type="hidden" name="cargaind[]" id="cargaind<?php echo $fila_tipo['id_objetivo']; ?>" />
    <?php }?>
    </td>
  </tr>
</table>
<div id="obj">
</div>
<div id="hab">
</div>
<div id="mx">
</div>
<div id="my">
</div>

<script>
$(document).ready(function(){

	$('.obj_pasar').click(function() { return !$('#obj_origen option:selected').remove().appendTo('#obj_destino'); });  
		$('.obj_quitar').click(function() { return !$('#obj_destino option:selected').remove().appendTo('#obj_origen'); });
		$('.obj_pasartodos').click(function() { $('#obj_origen option').each(function() { $(this).remove().appendTo('#obj_destino'); }); });
		$('.obj_quitartodos').click(function() { $('#obj_destino option').each(function() { $(this).remove().appendTo('#obj_origen'); }); });
		
		$('.hab_pasar').click(function() { return !$('#hab_origen option:selected').remove().appendTo('#hab_destino'); });  
		$('.hab_quitar').click(function() { return !$('#hab_destino option:selected').remove().appendTo('#hab_origen'); });
		$('.hab_pasartodos').click(function() { $('#hab_origen option').each(function() { $(this).remove().appendTo('#hab_destino'); }); });
		$('.hab_quitartodos').click(function() { $('#hab_destino option').each(function() { $(this).remove().appendTo('#hab_origen'); }); });
		

  });
</script>

<?

}

if($funcion==6){
$rs_ramo =$ob_unidad->traeRamoUno($conn,$ramo);
$fila_ramo = pg_fetch_array($rs_ramo,0);
$cod_ramo=$fila_ramo['cod_subsector'];
echo $cod_ramo;
}

if($funcion==7){
$rs_eje =$ob_unidad->traeObj($conn,$id_eje,$rdb);
?>

<select name="obj_origen[]" id="obj_origen" multiple="multiple" size="8" style="overflow:auto;width:250px;" onmouseover="bla(this,'inline')" onmouseout="bla(this,'none')">

<?php for($e=0;$e<pg_numrows($rs_eje);$e++){
$fila=pg_fetch_array($rs_eje,$e);
?>
<option value="<?php echo $fila['id_obj'] ?>" ><?php echo $fila['texto'] ?></option>
<?php }?>

</select>	
<?
}


if($funcion==8){
$rs_eje =$ob_unidad->traeHab($conn,$id_eje,$rdb);
?>
<select name="hab_origen[]" id="hab_origen" multiple="multiple" size="8" style="overflow:auto;width:250px;" >
<?php for($e=0;$e<pg_numrows($rs_eje);$e++){
$fila=pg_fetch_array($rs_eje,$e);
?>
<option value="<?php echo $fila['id_obj'] ?>"><?php echo $fila['codigo'] ?>-<?php echo $fila['texto'] ?></option>
<?php }?>
</select>	
<?
}

if ($funcion==9){
//var_dump($_POST);
/*$obj_destino=$_POST['obj_destino'];
$hab_destino=$_POST['hab_destino'];*/
$obj_destino=$_POST['cargatipo'];

$exs=$ob_unidad->existe($conn,CambioFE($txt_fechaini),CambioFE($txt_fechater),$sel_curso,$sel_ramo);
if(pg_numrows($exs)>0){
echo 2;
}
else{

$rs_guarda = $ob_unidad->guardaUnidad($conn,$rdb,$ano,$sel_curso,$sel_ramo,$docdicta,CambioFE($txt_fechaini),CambioFE($txt_fechater),$cant_clases,$txt_horas,$texto,$txt_nombre,$ciu);

if($rs_guarda){
$rs_ultimaUnidad = $ob_unidad->ultimaUnidad($conn,$rdb);
$id_unidad = pg_result($rs_ultimaUnidad,0);
 
		 /*if(count($obj_destino)>0){
			for ($i=0;$i<count($obj_destino);$i++) { 
			$rs_guardaObjetivo = $ob_unidad->guardaObjetivo($conn,$id_unidad,$obj_destino[$i]);
			} 
		 }
	
		if(count($hab_destino)>0){	
			 for ($j=0;$j<count($hab_destino);$j++) { 
			 $rs_guardaHabilidad = $ob_unidad->guardaObjetivo($conn,$id_unidad,$hab_destino[$j]);
			} 
		}*/
		 if(count($obj_destino)>0){
			for ($i=0;$i<count($obj_destino);$i++) { 
			$cuenta_tipo = explode(",",$obj_destino[$i]);
				for ($j=0;$j<count($cuenta_tipo);$j++) { 
				$rs_guardaObjetivo = $ob_unidad->guardaObjetivo($conn,$id_unidad,$cuenta_tipo[$j]);
				}
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
					  $ob_unidad->guardaIndicadorSel($conn,$id_unidad,$objetivo,$indicador); 
					 
						}
					}
				}
				
				}
	
	echo 1;
}else
echo 0;

}
}

if($funcion==10){
	//var_dump($_POST);
	$rs_unidad =$ob_unidad->traeUnidad($conn,$idUnidad);
	
?>
	<table width="650" border="0" align="center" cellspacing="3">
    <tr>
		  <td colspan="4" align="center" class="titulo">INFORMACION UNIDAD</td>
	  </tr>
     <? if(pg_numrows($rs_unidad)>0){
		$fila_unidad = pg_fetch_array($rs_unidad,0);
		$rs_dicta=$ob_unidad->traeDicta($conn,$fila_unidad['id_ramo']);
		$rs_ramo=$ob_unidad->traeRamo($conn,$fila_unidad['id_curso'],$fila_unidad['id_ramo']);
		//$rs_obj=$ob_unidad->traeObjUnidad($conn,0,$idUnidad);
		//$rs_tipo=$ob_unidad->tejeUnidad($conn,$fila_unidad['unidad_anual']);
		$rs_arc = $ob_unidad->traearchivo($conn,$idUnidad);
		$rs_eje=$ob_unidad->tejeUnidad($conn,$idUnidad);
		//echo "-".pg_numrows($rs_eje);
		
     ?>
     <tr>
		  <td colspan="4" class="cuadro02">TITULO: <?php echo $fila_unidad['nombre'] ?></td>
	  </tr>
      <tr>
		  <td class="cuadro02">CURSO</td>
		  <td colspan="3" class="cuadro01"><?php echo CursoPalabra($fila_unidad['id_curso'],1,$conn) ?></td>
	  </tr>
      <tr>
		  <td width="127" class="cuadro02">ASIGNATURA</td>
		  <td colspan="3" class="cuadro01"><?=pg_result($rs_ramo,1);?></td>
      </tr>
		<tr>
		  <td class="cuadro02">DOCENTE</td>
		  <td colspan="3" class="cuadro01"><?php echo strtoupper(pg_result($rs_dicta,2)) ?></td>
	  </tr>
		<tr>
		  <td width="127" class="cuadro02">FECHA INICIO</td>
		  <td width="25%" class="cuadro02">FECHA TERMINO</td>
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
		  <td colspan="4" class="cuadro01"><?php echo nl2br($fila_unidad['texto']) ?></td>
	  </tr>
		<tr>
		  <td colspan="4">&nbsp;</td>
	  </tr>
      <?php if(pg_numrows($rs_eje)>0){
		?>
           <?php for($e=0;$e<pg_numrows($rs_eje);$e++){
		  $fila_eje = pg_fetch_array($rs_eje,$e);
		  $rs_obj=$ob_unidad->traeObjUnidad($conn,$fila_eje['id_objetivo'],$idUnidad);
		   $rs_tipe=$ob_unidad->tipoEjesBloqueUnidadInd($conn,$idUnidad,$fila_eje['id_objetivo']);
		  
		  ?>
		
      
      <?php if(pg_numrows($rs_obj)>0){
		 
		      for($ti=0;$ti<pg_numrows($rs_tipe);$ti++){ 
		  ?>
          
      <tr>
		  <td colspan="4">
		   <table width="100%">
          <tr class="cuadro02">
            <td colspan="2"><?php echo strtoupper($fila_eje['nombre'])?></td>
            </tr>
           <?php   for($ti=0;$ti<pg_numrows($rs_tipe);$ti++){ 
		     $fila_tipe = pg_fetch_array($rs_tipe,$ti);
			  $rs_obj=$ob_unidad->traeObjeUnidadInd($conn,$fila_tipe['id_eje'],$fila_eje['id_objetivo'],$idUnidad);
		   ?>
          <tr class="cuadro02">
          <td  width="50%"><?php echo strtoupper($fila_tipe['texto']) ?></td><td>INDICADORES DE EVALUACI&Oacute;N</td></tr>
         
          <?php for($o=0;$o<pg_numrows($rs_obj);$o++){
		  $fila_obj = pg_fetch_array($rs_obj,$o);
		  ?>
		<tr class="cuadro01">
		  <td valign="top"><?php echo strtoupper($fila_obj['codigo']) ?> - <?php echo  nl2br($fila_obj['texto'])?></td>  							          <td valign="top">
          <?php 
		  $rs_ind_a = $ob_unidad->buscaIndicadorSel2($conn,$fila_obj['id_obj'],$idUnidad);
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
      <?php }?>
		<tr>
		  <td colspan="4">&nbsp;</td>
	  </tr>
      
     
       <?php if(pg_numrows($rs_arc )>0){
	  $ruta = pg_result($rs_arc,2);
	  ?>
  <tr>
   <td colspan="4">&nbsp;</td>
 </tr>
 <tr>
   <td class="cuadro02" colspan="4">ARCHIVO EVALUACI&Oacute;N</td>
 </tr>
 
 <tr>
   <td class="cuadro01" colspan="4"><a href="acv/<?php echo $ruta ?>" target="_blank"><?php echo $ruta ?></a></td>
 </tr><?php }?>
     <? }
	else{ ?>
		<tr><td colspan="4" align="center">SIN INFORMACION</td></tr>
	<?    }?>
	</table>
   <? 
	
}
if($funcion==11){
	//var_dump($_POST);
	$rs_objetivo =$ob_unidad->traeEjeObjetivo($conn,$rdb,$cod_ramo);
	$rs_habilidad =$ob_unidad->traeEjeHabilidad($conn,$rdb,$cod_ramo);
	$rs_unidad =$ob_unidad->traeUnidad($conn,$idUnidad);
	$fila_unidad = pg_fetch_array($rs_unidad,0);
	
	/*// echo pg_numrows($rs_obj);
	$rs_hab=$ob_unidad->traeObjUnidad($conn,1,$idUnidad);*/
	$rs_ramo=$ob_unidad->traeRamo($conn,$fila_unidad['id_curso'],$fila_unidad['id_ramo']);
	$rs_tipo=$ob_unidad->tejeUnidad($conn,$fila_unidad['unidad_anual']);
	 $cad_ind="";
	
		
	
	
?>
<script>
$(document).ready(function(){
	
	$("#txt_fechaini, #txt_fechater").datepicker({
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
		
		 $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
          });

  });
  
  $("#nvo").html('<input type="button" name="actUnidad" id="actaUnidad" value="Actualizar Datos" onclick="GuardaUnidadAct()" class="botonXX"/> <input type="button" name="cUnidad" id="cUnidad" value="Cancelar" onclick="cancela()" class="botonXX" />');

  
  
 /* $('.obj_pasar').click(function() { return !$('#obj_origen option:selected').remove().appendTo('#obj_destino'); });  
		$('.obj_quitar').click(function() { return !$('#obj_destino option:selected').remove().appendTo('#obj_origen'); });
		$('.obj_pasartodos').click(function() { $('#obj_origen option').each(function() { $(this).remove().appendTo('#obj_destino'); }); });
		$('.obj_quitartodos').click(function() { $('#obj_destino option').each(function() { $(this).remove().appendTo('#obj_origen'); }); });
		
		$('.hab_pasar').click(function() { return !$('#hab_origen option:selected').remove().appendTo('#hab_destino'); });  
		$('.hab_quitar').click(function() { return !$('#hab_destino option:selected').remove().appendTo('#hab_origen'); });
		$('.hab_pasartodos').click(function() { $('#hab_origen option').each(function() { $(this).remove().appendTo('#hab_destino'); }); });
		$('.hab_quitartodos').click(function() { $('#hab_destino option').each(function() { $(this).remove().appendTo('#hab_origen'); }); });
		*/

  </script>
  <input type="hidden" name="idUnidad" id="idUnidad" value="<?php echo $fila_unidad['id_unidad']?>" />
<input type="hidden" name="rm" id="rm" value="<?=pg_result($rs_ramo,2);?>" />
<input type="hidden" name="cr" id="cr" value="<?php echo $fila_unidad['id_curso']?>" />
<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td class="cuadro02">Nombre</td>
    <td class="cuadro02">Fecha Inicio</td>
    <td class="cuadro02">Fecha T&eacute;rmino</td>
  </tr>
  <tr>
    <td class="cuadro01"><input type="text" name="txt_nombre" id="txt_nombre" value="<?php echo $fila_unidad['nombre'] ?>" />
    </td>
    <td class="cuadro01"><input type="text" name="txt_fechaini" id="txt_fechaini" value="<?php echo CambioFD($fila_unidad['fecha_inicio']) ?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_fechater" id="txt_fechater" value="<?php echo CambioFD($fila_unidad['fecha_termino']) ?>" /></td>
  </tr>
  <tr>
    <td class="cuadro02">Cantidad clases</td>
    <td class="cuadro02">Horas</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01">
    <input type="text" name="cant_clases" id="cant_clases" value="<?php echo $fila_unidad['cantidad_clases'] ?>" class="solo-numero" /></td>
    <td class="cuadro01"><input type="text" name="txt_horas" id="txt_horas" value="<?php echo $fila_unidad['nro_horas'] ?>" class="solo-numero" /></td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="cuadro02">Texto</td>
  </tr>
  <tr>
    <td colspan="3" class="cuadro01"><textarea name="texto" cols="50" rows="5" id="texto" ><?php echo $fila_unidad['texto'] ?></textarea></td>
  </tr>
</table><br />
<br />
<table width="650" border="1" align="center" style="border-collapse:collapse">
 <tr>
    <td colspan="4" class="cuadro02"><!--<input name="tipo" type="radio" id="tipo0" onclick="cargatipoedi(0,<?php echo $fila_unidad['id_unidad']?>);" value="0" checked="checked" />Objetivos <input name="tipo" id="tipo1" type="radio" value="1" onclick="cargatipoedi(1,<?=$_POST['idUnidad'] ?>)" />
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
		  
			$rs_obj=$ob_unidad->traeObjUnidad($conn,$fila_tipo['id_objetivo'],$fila_unidad['id_unidad']);
			$cob="";
			for($o=0;$o<pg_numrows($rs_obj);$o++){
				$fil_obj=pg_fetch_array($rs_obj,$o);
				
				$cob.=$fil_obj['id_obj'].",";
			}
			$cob=substr($cob, 0, -1);
			$cad_ind="";
			$rs_inditpo = $ob_unidad->traeIndiUnidadC($conn,$idUnidad,$fila_tipo['id_objetivo']);
			if(pg_numrows($rs_inditpo)>0){
				
			
			for($in=0;$in<pg_numrows($rs_inditpo);$in++){
			$fila_in = pg_fetch_array($rs_inditpo,$in);
			$cad_ind.=$fila_in['id_obj']."_".$fila_in['id_indicador'].","; 	
			}	
			}
		  
		  ?>
           <input type="hidden" name="cargatipo[]" id="cargatipo<?php echo $fila_tipo['id_objetivo']; ?>" value="<?php echo $cob ?>" /> 
      <input name="tipo" id="tipo<?php echo $t ?>" type="radio" value="<?php echo $fila_tipo['id_objetivo']; ?>" onclick="cargatipo(<?php echo $fila_tipo['id_objetivo']; ?>,<?php echo $idUnidad; ?>);" <?php echo ($ti==0)?"checked":"" ?> /><?php echo $fila_tipo['nombre']; ?>
      <input type="hidden" name="cargaind[]" id="cargaind<?php echo $fila_tipo['id_objetivo']; ?>" value="<?php echo $cad_ind ?>" />  
    <?php }?>
    </td>
  </tr>
</table>
<div id="mx">
</div>
<div id="my">
</div>
<script>
cargatipo(<?php echo $crg ?>,<?php echo $idUnidad ?>);
</script>
<?	
	} 
	
if($funcion==12){
	//var_dump($_POST);
$obj_destino=$_POST['cargatipo'];
/*$hab_destino=$_POST['hab_destino'];*/

$rs_guarda = $ob_unidad->actualizaUnidad($conn,$idUnidad,CambioFE($txt_fechaini),CambioFE($txt_fechater),$cant_clases,$txt_horas,$texto,$txt_nombre);	

$d_obj = $ob_unidad->eliminaObHa($conn,$idUnidad);
$d_obj = $ob_unidad->borraIndicador($conn,$idUnidad);


	/*
	 if(count($obj_destino)>0){
			for ($i=0;$i<count($obj_destino);$i++) { 
			//echo "Numero Seleccionado " . $i . ": " . $obj_destino[$i]; 
			$rs_guardaObjetivo = $ob_unidad->guardaObjetivo($conn,$idUnidad,$obj_destino[$i]);
			} 
		 }
	
		if(count($hab_destino)>0){	
			 for ($j=0;$j<count($hab_destino);$j++) { 
			 $rs_guardaHabilidad = $ob_unidad->guardaObjetivo($conn,$idUnidad,$hab_destino[$j]);
			} 
		}*/
		 if(count($obj_destino)>0){
			for ($i=0;$i<count($obj_destino);$i++) { 
			$cuenta_tipo = explode(",",$obj_destino[$i]);
				for ($j=0;$j<count($cuenta_tipo);$j++) { 
				$rs_guardaObjetivo = $ob_unidad->guardaObjetivo($conn,$idUnidad,$cuenta_tipo[$j]);
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
					  $ob_unidad->guardaIndicadorSel($conn,$idUnidad,$objetivo,$indicador); 
					 
						}
					}
				}
				
				}
		 }
		 
		 
		echo 1;
}
if($funcion==13){
	//show($_POST);
$rs_curso = $ob_unidad->traeCursosUno($conn,$curso);
	$ense = pg_result($rs_curso,3);
	$grado = pg_result($rs_curso,1);
	?>
<br />

<table width="650" align="center" border="1" style="border-collapse:collapse">
	<?
	//if($tipo==0){ejeDeUnidad ejeDeUnidad($conn,$unidad,$tipo,$rdb,$cod_ramo)
$rs_objetivo =$ob_unidad->ejeDeUnidad($conn,$ciu,$tipo,$rdb,$cod_ramo);
//echo pg_numrows($rs_objetivo);
 for($o=0;$o<pg_numrows($rs_objetivo);$o++){
		 $fila_obj = pg_fetch_array($rs_objetivo,$o);
		 ?>
		  <tr><td class="cuadro02"><?php echo $fila_obj['texto'] ?></td>
		  <?
		// $rs_eje =$ob_unidad->traeObj($conn,$fila_obj['id_eje'],$rdb,$ense,$grado);
		 
		  $rs_eje =$ob_unidad->traeObjAnio($conn,$fila_obj['id_eje'],$rdb,$ciu,$tipo);
		 for($j=0;$j<pg_numrows($rs_eje);$j++){
			$fila = $fila_obj = pg_fetch_array($rs_eje,$j);
			
			$cad_ind="";
			$rs_inditpo = $ob_unidad->traeIndiUnidadO($conn,$unn,$fila['id_obj']);
			if(pg_numrows($rs_inditpo)>0){
			
				for($in=0;$in<pg_numrows($rs_inditpo);$in++){
				$fila_in = pg_fetch_array($rs_inditpo,$in);
				$cad_ind.=$fila_in['id_obj']."_".$fila_in['id_indicador'].","; 	
				}	
			}
			
			
			?>
		  <!--<tr><td align="justify" id="fila<?php echo  $fila['id_obj']?>" onclick="pp(<?php echo  $fila['id_obj']?>);sumaobj(<?php echo  $fila['id_obj']?>);" class="i textosimple"><?php echo $fila['codigo']."-".$fila['texto'] ?><input name="obj_destino[]" type="checkbox" class="oo" id="destino<?=$fila['id_obj']?>" style="visibility:hidden" value="<?php echo  $fila['id_obj']?>" /></td>-->
  <tr><td align="justify" id="fila<?php echo  $fila['id_obj']?>" onclick="pp(<?php echo  $fila['id_obj']?>);sumatipo(<?php echo  $fila['tipo']?>); buscasel(<?php echo  $fila['tipo']?>);" class="i textosimple"><?php echo $fila['codigo']."-".$fila['texto'] ?><input name="obj_destino[]" type="checkbox" class="oo<?php echo  $fila['tipo']?>" id="destino<?=$fila['id_obj']?>" style="visibility:hidden" value="<?php echo  $fila['id_obj']?>" /> <input type="hidden" id="lindv<?php echo  $fila['id_obj']?>" name="lindv<?php echo  $fila['id_obj']?>" class="lindv<?php echo  $fila['tipo']?>" value="<?php echo $cad_ind ?>"/></td></tr>
		  
                  <?
				  
		 }
		 
		 
              
 }

	/*}
	elseif($tipo==1){
$rs_habilidad =$ob_unidad->traeEjeHabilidad($conn,$rdb,$cod_ramo);
for($h=0;$h<pg_numrows($rs_habilidad);$h++){
		 $fila_hab = pg_fetch_array($rs_habilidad,$h);
		 ?>
		  <tr><td class="cuadro02"><?php echo $fila_hab['texto'] ?></td>
		  <?
       //$rs_eje =$ob_unidad->traeHab($conn,$fila_hab['id_eje'],$rdb,$ense,$grado);
	   $rs_eje =$ob_unidad->traeObjAnio($conn,$fila_hab['id_eje'],$rdb,$ciu,1);
		 for($j=0;$j<pg_numrows($rs_eje);$j++){
			$fila = $fila_obj = pg_fetch_array($rs_eje,$j);
			?>
		  <tr><td id="fila<?php echo  $fila['id_obj']?>" onclick="pp2(<?php echo  $fila['id_obj']?>);sumahab(<?php echo  $fila['id_obj']?>);" class="textosimple" align="justify"><?php echo $fila['codigo']."-".$fila['texto'] ?><input name="hab_destino[]" id="destinoh<?=$fila['id_obj']?>" type="checkbox" class="hh" value="<?php echo  $fila['id_obj']?>" style="visibility:hidden"  /></td>
          <?
		 
		 }
       
 }

	}*/
	?>
</table>
    <?
}

if($funcion==14){
	var_dump($_POST);
	
	$rs_curso = $ob_unidad->traeCursosUno($conn,$curso);
	$ense = pg_result($rs_curso,3);
	$grado = pg_result($rs_curso,1);
	?><br />

   

<table width="650" align="center" border="1" style="border-collapse:collapse">
	<?
	
$rs_objetivo =$ob_unidad->traeEjeObjetivo($conn,$rdb,$cod_ramo,$tipo);
 for($o=0;$o<pg_numrows($rs_objetivo);$o++){
		 $fila_obj = pg_fetch_array($rs_objetivo,$o);
		 ?>
		  <tr><td class="cuadro02"><?php echo $fila_obj['texto'] ?></td>
		  <?
		 $rs_eje =$ob_unidad->traeObj($conn,$fila_obj['id_eje'],$rdb,$ense,$grado,$tipo);
		 for($j=0;$j<pg_numrows($rs_eje);$j++){
			$fila = $fila_obj = pg_fetch_array($rs_eje,$j);
			
			$rs_marca = $ob_unidad->traeMarcado($conn,$id_unidad,$fila['id_obj']);
			if(pg_numrows($rs_marca)==0){
			$marca=0;
			}else{
			$marca=1;
			}
			
			
			$rs_inditpo = $ob_unidad->traeIndiUnidadC($conn,$id_unidad,$fila['id_obj']);
			if(pg_numrows($rs_inditpo)>0){
				$cad_ind="";
			
			for($in=0;$in<pg_numrows($rs_inditpo);$in++){
			$fila_in = pg_fetch_array($rs_inditpo,$in);
			$cad_ind.=$fila_in['id_obj']."_".$fila_in['id_indicador'].","; 	
			}	
			}
			?>
		   <tr><td align="justify" id="fila<?php echo  $fila['id_obj']?>" onclick="pp(<?php echo  $fila['id_obj']?>);sumatipo(<?php echo  $fila['tipo']?>); buscasel(<?php echo  $fila['tipo']?>)" class="i textosimple"><?php echo $fila['codigo']."-".$fila['texto'] ?><input name="obj_destino[]" type="checkbox" class="oo<?php echo  $fila['tipo']?>" id="destino<?=$fila['id_obj']?>" style="visibility:hidden" value="<?php echo  $fila['id_obj']?>" <?php echo ($marca==1)?"checked":"" ?> />  <input type="hidden" id="lindv<?php echo  $fila['id_obj']?>" name="lindv<?php echo  $fila['id_obj']?>" class="lindv<?php echo  $fila['tipo']?>" value="<?php echo $cad_ind ?>" /></td></tr>
          <?
		 }
		 
		 
              
 }


	
	?>
</table>
    <?
}
if($funcion==15){
//var_dump($_POST);
$rs_unidad =$ob_unidad->traeUnidad($conn,$unidad);
$rs_obj=$ob_unidad->traeObjUnidadAll($conn,$unidad);
$rs_curso = $ob_unidad->cursoTieneRamo($conn,$ano,$codramo);
?>
<input type="hidden" name="idu" id="idu" value="<?php echo $unidad ?>" />
<input type="hidden" name="ida" id="ida" value="<?php echo $ano ?>" />
<input type="hidden" name="idr" id="idr" value="<?php echo $codramo ?>" />
<table border="1" style="border-collapse:collapse">
<tr class="cuadro02">
  <td colspan="2" align="center">Seleccione curso(s) donde replicar unidad</td></tr>
<tr class="cuadro02">
  <td align="center">Todos<br />
<input name="all" type="checkbox" onclick="marcatodo();marcacur()" id="all" />
  </td><td align="center">Curso</td></tr>
 
<?
for($c=0;$c<pg_numrows($rs_curso);$c++){
$fil_cur = pg_fetch_array($rs_curso,$c);
?>
<tr class="cuadro01"><td align="center"> <span class="cursoshab"><input name="cur[]" type="checkbox" value="<?php echo $fil_cur['id_curso'] ?>" class="curr" onclick="marcacur()" /></span></td><td><?php echo CursoPalabra( $fil_cur['id_curso'],1,$conn) ?></td></tr>
<?

}
?>

</table>
<?
}
if($funcion==16){
//var_dump($_POST);
$rs_unidad =$ob_unidad->traeUnidad($conn,$unidad);
$rs_obj=$ob_unidad->traeObjUnidadAll($conn,$unidad);
$cc=explode(",",$_POST['cursos']);

if(count($cc)>0){
			for ($c=0;$c<count($cc);$c++) { 
			//echo "Numero Seleccionado " . $c . ": " . $cc[$c]; 
			//$rs_dicta=$ob_unidad->traeDicta($conn,$fila_unidad['id_ramo']);
			//$rs_ramo=$ob_unidad->traeRamo($conn,$fila_unidad['id_curso'],$fila_unidad['id_ramo']);
			$rs_ramo=$ob_unidad->cursoTieneRamo2($conn,$ano,$codramo,$cc[$c]);
			$id_ramo = pg_result($rs_ramo,0);
			$rs_dicta=$ob_unidad->traeDicta($conn,$id_ramo);
			$rut_emp = pg_result($rs_dicta,0);
			
$rs_guarda = $ob_unidad->guardaUnidad($conn,$_INSTIT,$ano,$cc[$c],$id_ramo,$rut_emp,pg_result($rs_unidad,6),pg_result($rs_unidad,7),pg_result($rs_unidad,8),pg_result($rs_unidad,9),utf8_decode(pg_result($rs_unidad,10)),utf8_decode(pg_result($rs_unidad,13)));


				$rs_ultimaUnidad = $ob_unidad->ultimaUnidad($conn,$_INSTIT);
				$id_unidad = pg_result($rs_ultimaUnidad,0);
				
				for($o=0;$o<pg_numrows($rs_obj);$o++){
					$fila_obj = pg_fetch_array($rs_obj,$o);
					
					 $rs_guardaObjetivo = $ob_unidad->guardaObjetivo($conn,$id_unidad,$fila_obj['id_obj']);
				
				}
			
			} 
		 }
		 
		 echo 1;
}if($funcion==17){
//var_dump($_POST);
$rs_uni = $ob_unidad->listaUnidadAnio($conn,$curso,$ramo);

?>
<select name="sel_uan" id="sel_uan" class="select_redondo" onchange="cargahdn()">
  <option value="0">Seleccione...</option>
  <?php for($i=0;$i<pg_numrows($rs_uni);$i++){
	  $fila = pg_fetch_array($rs_uni,$i);
	  ?>
  <option value="<?php echo $fila['id_unidad'] ?>"><?php echo $fila['nombre'] ?></option>
  <?php }?>
</select>
<?
}if($funcion==18){
$iun= $unidad;	

$rs_unano = $ob_unidad->traeUnidadAnio($conn,$iun);
$ramo = pg_result($rs_unano,4);
$curso = pg_result($rs_unano,3);
$rs_ramo = $ob_unidad->traeRamo($conn,$curso,$ramo);
$codrm = pg_result($rs_ramo,2)


?>
<input name="ciu" type="hidden" id="ciu" value="<?php echo $iun ?>" />
<input name="cic" type="hidden" id="cic" value="<?php echo pg_result($rs_unano,3) ?>"  />
<input name="cir" type="hidden" id="cir" value="<?php echo pg_result($rs_unano,4) ?>"  />
<input name="ccr" type="hidden" id="ccr" value="<?php echo $codrm ?>"  />
<input name="cid" type="hidden" id="cid" value="<?php echo pg_result($rs_unano,5) ?>"  />
<?
}if($funcion==19){

//$rs_curso = $ob_unidad->traeCursos($conn,$_ANO);
if($_PERFIL==17){
		$rs_curso= $ob_unidad->cursoSsDocente($conn,$_NOMBREUSUARIO,$_INSTIT,$_ANO);
	
	}
	else{
		$rs_curso = $ob_unidad->traeCursos($conn,$_ANO);	
	}
//$rs_ramo = $ob_unidad->traeRamo($conn,$cic);

if($_PERFIL!=17){
	$rs_ramo = $ob_unidad->traeRamo($conn,$cic);
	}else{
	//quiero ver si es profesor jefe
	$rs_super = $ob_unidad->esPJefe($conn,$_NOMBREUSUARIO,$cic) ;
	if(pg_numrows($rs_super )>0){
		$rs_ramo = $ob_unidad->traeRamo($conn,$cic);
	}else{
		$rs_ramo = $ob_unidad->ramosDct($conn,$_NOMBREUSUARIO,$cic);
		}
	}

$rs_uni = $ob_unidad->listaUnidadAnio($conn,$cic,$cir);
$rs_dicta = $ob_unidad->traeDicta($conn,$cir);




if(!$rs_dicta || pg_numrows($rs_dicta)==0)
		{
		 $nd= "no se encontro docente asociado";	
		}else{
		$nd =  strtoupper(pg_result($rs_dicta,2));
			
		}
?>
<script>
$( document ).ready(function() {
    $(".hp").hide();
});
</script>
<table width="650" border="0" align="center">
                          <tr>
                            <td width="195" class="textonegrita">CURSO:</td>
                            <td width="439"><div id="cur">
                           <select name="sel_curso" id="sel_curso" onchange="traeRamo(this.value);" class="select_redondo" >
    	<option	value="0">seleccione...</option>
<? 		for($i=0;$i<pg_numrows($rs_curso);$i++){
			$fila = pg_fetch_array($rs_curso,$i);
?>
		<option value="<?=$fila['id_curso'];?>" <?php echo ($fila['id_curso']==$cic)?"selected":"" ?>><?=CursoPalabra($fila['id_curso'], 0, $conn);?></option>
        	
<?	
		}
?>
	</select></div></td>
                          </tr>
                          <tr>
                            <td class="textonegrita">ASIGNATURA</td>
                            <td><div id="ram">
                            <select name="sel_ramo" id="sel_ramo" onchange="dicta(this.value);codigo(this.value);uanual();" class="select_redondo" >
    	<option	value="0">seleccione...</option>
<? 		for($r=0;$r<pg_numrows($rs_ramo);$r++){
			$fila_r = pg_fetch_array($rs_ramo,$r);
?>
		<option value="<?=$fila_r['id_ramo'];?>" <?php echo ($fila_r['id_ramo']==$cir)?"selected":"" ?> ><?=$fila_r['nombre'];?></option>
        	
<?	
		}
?>
	</select>
                            </div></td>
                          </tr>
                          <tr>
                            <td class="textonegrita">UNIDAD</td>
                            <td><div id="uan">
                             
                               <select name="sel_uan" id="sel_uan" class="select_redondo" onchange="cargahdn()">
  <option value="0">Seleccione...</option>
  <?php for($u=0;$u<pg_numrows($rs_uni);$u++){
	  $fila_u = pg_fetch_array($rs_uni,$u);
	  ?>
  <option value="<?php echo $fila_u['id_unidad'] ?>" <?php echo ($fila_u['id_unidad']==$ciu)?"selected":"" ?>><?php echo $fila_u['nombre'] ?></option>
  <?php }?>
</select>
                          
                            </div></td>
                          </tr>
                          <tr class="hp">
                            <td class="textonegrita">PROFESOR</td>
                            <td>
                            <div id="prof" class="textosimple">
                                  <input type="hidden" name="docdicta" id="docdicta" value="<?php echo $cid ?>" /><?php echo $nd ?>
                            </div>
                            </td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>
                            <input type="hidden" name="cod_ramo" id="cod_ramo" value="<?php echo $ccr ?>" /></td>
                          </tr>
                          <tr>
                            <td colspan="2" align="left">
                            <table width="100%" border="0">
                              <tr>
                                <td align="right"><span id="nvo">
                                <input type="button" name="nuevaUnidad" id="nuevaUnidad" class="botonXX" value="Nueva Unidad" onclick="creaUnidad()" />                                  <input type="button" name="busca" id="busca" class="botonXX" value="Buscar" onclick="traeUnidades()" border="0" /></span>&nbsp;<input type="button" name="nuevaUnidad" id="nuevaUnidad" class="botonXX" value="Volver a unidad Anual" onclick="vuelveAnual(<?php echo $cic ?>)" />  </td>
                              </tr>
                            </table>

                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" align="right">&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="2" align="right">
                            </td>
                          </tr>
                        </table>
<?
}
if($funcion==20){

	$rs_estado = $ob_unidad->traeEstadoClase($conn);
	$rs_historial = $ob_unidad->traeHistorialcambiosUAnual($conn,$unidad);
	
	?>
    <?php if($_PERFIL==0 || $_PERFIL==14 || $_PERFIL==25){?>
    <input type="hidden" id="unidad" value="<?php echo $unidad ?>" />
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
<?php  } ?>
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
 

}if($funcion==21){
	
	$desc=($estado==2)?"Aprobación final":$descripcion;
	
	$rs_estado = $ob_unidad->guardaHistorialcambiosUAnual($conn,$unidad,date("Y-m-d"),utf8_decode($desc));
	
	if($rs_estado){
	$rs_cambia = $ob_unidad->cambiaEstadoClaseUAnual($conn,$unidad,$estado);
	echo 1;
	}
	else{
	echo 0;
	}
}
if($funcion==22){
	$rs_estado = $ob_unidad->cambiaRealizada($conn,$unidad,$estado);
	
	if($rs_estado){
	echo 1;
	}
	else{
	echo 0;
	}
	
}

if($funcion==23){
	//var_dump($_POST);
$clase_fuente = $ob_unidad->traeUnidad($conn,$unidad);
$fila_fuente = pg_fetch_array($clase_fuente,0);
$rs_periodo = $ob_unidad->periodo($conn,$_ANO);

	?>
   
     <div align="center">Seleccione a qu&eacute; nota se debe asociar la clase</div>
    <br />
<br />
<input type="hidden" id="lo" name="lo" value="" />
<input type="hidden" id="unidad" name="unidad" value="<?php echo pg_result($clase_fuente,0) ?>" />
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
if($funcion==24){

?>

<table border="1">
<tr>
<?php 
//casillas notas
for($n=1;$n<=20;$n++){
	$rs_nota = $ob_unidad->marcanota($conn,$unidad,$periodo,$n,$ramo);
	$fclase = pg_fetch_array($rs_nota,0);
	//echo "<br>".$clase."-".$fclase['id_clase'];
	?>
<td>
<input type="checkbox" name="pos_nota[]" id="nota<?php echo $n ?>" class="notas" <?php echo (pg_numrows($rs_nota)>0 && $unidad==$fclase['id_unidad'])?"checked":"" ?> <?php //echo (pg_numrows($rs_nota)>0 && $clase!=$fclase['id_clase'])?'disabled="disabled"':"" ?> onclick="cuentacheck()" value="<?php echo $n ?>" /> Nota<?php echo $n ?>
</td>
<?
	
	echo ($n%5==0)?"</tr><tr>":"";
		?>
 
    <? } ?>
  </tr>
</table>
<?
}
if($funcion==25){
$rs_borranota = $ob_unidad->borraNota($conn,$unidad,$periodo);

$ps = $_POST['pos'];
$ps1=explode(",",$ps);

for ($p=0;$p<count($ps1);$p++) { 
			$rs_guardaNota = $ob_unidad->guardaNota($conn,$unidad,$ps1[$p],$periodo,$ramo);
			}

echo 1;
}
if($funcion==26){
	



$ob_unidad->delUnidad($conn,$id_unidad);



}
if($funcion==27){
//show($_POST);

$rs_indi = $ob_unidad->buscaIndicadorSel($conn,$obj,$ciu);
?><br />
<br />

<table width="100%" border="1" style="border-collapse:collapse">
<?php for($i=0;$i<pg_numrows($rs_indi);$i++){
	$fila=pg_fetch_array($rs_indi,$i);?>
  <tr id="filaind<?php echo  $fila['id_indicador']?>">
    <td onclick="ppi(<?php echo $fila['id_indicador'] ?>,<?php echo $obj ?>,<?php echo $fila['tipo'] ?>)"><?php echo $fila['texto'] ?>&nbsp;
    <input type="checkbox" name="ind[]" id="ind<?php echo $fila['id_indicador'] ?>"  class="oid<?php echo  $fila['id_obj']?>" value="<?php echo $fila['id_obj'] ?>_<?php echo $fila['id_indicador'] ?>" style="visibility:hidden" /></td>
  </tr>
  <?php }?>
</table>
<?	
}


?>
