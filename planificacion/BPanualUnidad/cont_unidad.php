<?

require("../../util/header.php");
require("mod_unidad.php");

$funcion = $_POST['funcion'];

$ob_unidad = new Unidad();
session_start();


if($funcion==1){
	
	//$_CURSO = $crs;
	
	/*if(!$crs){
	$crs = $_CURSO;
	}*/
	
	
	
		$rs_curso = $ob_unidad->traeCursosN($conn,$ano);	
	
	//exit;
	
?>	

<!--onchange="apoderado(this.value);"-->
<select name="sel_curso" id="sel_curso" onchange="traeRamo(this.value);traeEnse(this.value);" class="select_redondo" >
    	<option	value="0">seleccione...</option>
<? 		for($i=0;$i<pg_numrows($rs_curso);$i++){
			$fila = pg_fetch_array($rs_curso,$i);
?>
		<option value="<?=$fila['id_curso'];?>_<?=$fila['ensenanza'];?>"  ><?=$fila['curso'];?></option>
        	
<?	
		}
?>
	</select>
<?
}


if($funcion==2){
	//show($_POST);
	$_CURSO = $curso;
	
		$rs_ramo = $ob_unidad->ramosDctN($conn,$_ANO,$ens,$grd)
	//	$rs_ramo = $ob_unidad->ramosDct($conn,$_NOMBREUSUARIO,$curso);
	
	
	//exit;
	
?>	<!--onchange="apoderado(this.value);"-->
<select name="sel_ramo" id="sel_ramo" onchange="dicta(this.value);codigo(this.value)" class="select_redondo" >
    	<option	value="0">seleccione...</option>
<? 		for($i=0;$i<pg_numrows($rs_ramo);$i++){
			$fila = pg_fetch_array($rs_ramo,$i);
?>
		<!--<option value="<?=$fila['id_ramo'];?>" <?php echo  ($fila['id_ramo']==$_IDR)?"selected":""?>><?=$fila['nombre'];?></option>-->
  <option value="<?=$fila['cod_subsector'];?>"><?=$fila['nombre'];?></option>
        	
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
//$rs_lista = $ob_unidad->listaUnidad($conn,$id_ano,$rdb,$curso,$ramo,$docente);
//$rs_lista = $ob_unidad->listaUnidad($conn,$id_ano,$rdb,$curso,$ramo,$docente);
$crm = explode("_",$curso);
$grado=$crm[0];
$ense=$crm[1];
$rs_lista = $ob_unidad->listaUnidadN($conn,$id_ano,$rdb,$ense,$grado,$ramo)

//$rs_a=  $ob_unidad->anoEscola($conn,$_ANO);
 


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
    <td colspan="8" align="center" class="cuadro02 tablaredonda"><div align="center">Acciones</div></td>
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
    <td class="tablaredonda"><?php echo pg_result($rs_estado,1); ?></td>
    <td align="center" class="tablaredonda"><?php echo CambioFD($fila['fecha_inicio'])?></td>
    <td align="center" class="tablaredonda"><?php echo CambioFD($fila['fecha_termino']) ?></td>
   
    <td align="center" class="tablaredonda"><input name="vi" type="button" onClick="veUnidad(<?php echo $fila['id_unidad']?>)" value="V" class="botonXX" title="Ver Planificacion"/></td>
    <?php if($_PERFIL==0 || $_PERFIL==14 || $_PERFIL==17){?>

    <td align="center" class="tablaredonda"><input name="ed" type="button" id="ed" onclick="editaUnidad(<?php echo $fila['id_unidad']?>)" value="E" class="botonXX" title="Editar Planificacion"/></td>
    <?php }?>
	   
   <!-- <td align="center" class="tablaredonda"><input type="button" name="u" id="u" value="U" title="Asignar Unidades" onclick="goUnidad(<?php echo $fila['id_unidad']?>)" class="botonXX" /></td>-->
    
    <?php if($_PERFIL==0 ){?>
    <td  class="tablaredonda"><input type="button" name="button2" id="button2" value="X" class="botonBX"  onclick="borraAnual(<?php echo $fila['id_unidad'] ?>)" /></td>
   <?php }?>
  </tr>
  <?php }?>
</table>
<?
}
if($funcion==5){
	//var_dump($_SESSION);
	$rs_objetivo =$ob_unidad->traeEjeObjetivo($conn,$rdb,$cod_ramo);
	$rs_habilidad =$ob_unidad->traeEjeHabilidad($conn,$rdb,$cod_ramo);
	$rs_ano =$ob_unidad->anoEscola($conn,$_ANO);
	$nano = pg_result($rs_ano,1);
	$rs_tipo = $ob_unidad->teje($conn,$cod_ramo,$ens,$grdo);
	
?>
<script>
$(document).ready(function(){
	
	
		
          $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
          });
        

  });
  </script>
 
<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td colspan="2" class="cuadro02">Nombre
      <input name="an" type="hidden" id="an" value="<?php echo $nano ?>" />
    </td>
    <td width="195" class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" class="cuadro01"><input name="txt_nombre" type="text" id="txt_nombre" size="40" /></td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td width="207" class="cuadro02">Rango fechas</td>
    <td width="226" class="cuadro02"><div id="ifecha"></div></td>
    <td class="cuadro02"><div id="tfecha"></div></td>
  </tr>
  <tr>
    <td class="cuadro01">
    <select name="tipoFecha" id="tipoFecha" onchange="rfecha()">
    <option value="0">seleccione...</option>
    <option value="1">Mensual</option>
    <option value="2">Fechas</option>
    </select></td>
    <td class="cuadro01"><input type="hidden" name="txt_fechaini" id="txt_fechaini" />
      <div id="comes" style="display:none">
      <select name="cmbMes" id="cmbMes" onchange="fechames(this.value)">
       <option value="0">seleccione...</option>
    <option value="01">Enero</option>
    <option value="02">Febrero</option>
     <option value="03">Marzo</option>
    <option value="04">Abril</option>
    <option value="05">Mayo</option>
     <option value="06">Junio</option>
    <option value="07">Julio</option>
    <option value="08">Agosto</option>
     <option value="09">Septiembre</option>
    <option value="10">Octubre</option>
    <option value="11">Noviembre</option>
    <option value="12">Diciembre</option>
    </select></div>
      </td>
    <td class="cuadro01"><input type="hidden" name="txt_fechater" id="txt_fechater" /></td>
  </tr>
   <tr>
    <td class="cuadro02">Cantidad Semanas</td>
    <td class="cuadro02">Cantidad Horas</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01"><input type="text" name="txt_semana" id="txt_semana" class="solo-numero" /></td>
    <td class="cuadro01"><input type="text" name="txt_horas" id="txt_horas" class="solo-numero" />
      </td>
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
    <td colspan="4" class="cuadro02"><!--<input name="tipo" id="tipo0" type="radio" value="0" onclick="cargatipo(0);" />Objetivos <input name="tipo" id="tipo1" type="radio" value="1" onclick="cargatipo(1);" />-->
    
     <!-- <input type="hidden" name="cargaobj" id="cargaobj" /> 
      <input type="hidden" name="cargahab" id="cargahab" />-->
       <?php for($ti=0;$ti<pg_numrows($rs_tipo);$ti++){
		  $fila_tipo = pg_fetch_array($rs_tipo,$ti);
		  ?>
          <?php if($ti==0){ ?>
          <input name="crg" id="crg" type="hidden" value="<?php echo $fila_tipo['id_objetivo']; ?>" />
          <?php }?>
           <input type="hidden" name="cargatipo[]" id="cargatipo<?php echo $fila_tipo['id_objetivo']; ?>" />
           <input type="hidden" name="cargaind[]" id="cargaind<?php echo $fila_tipo['id_objetivo']; ?>" />  
      <input name="tipo" id="tipo<?php echo $t ?>" type="radio" value="<?php echo $fila_tipo['id_objetivo']; ?>" onclick="cargatipo(<?php echo $fila_tipo['id_objetivo']; ?>);" <?php echo ($ti==0)?"checked":"" ?> /><?php echo $fila_tipo['nombre']; ?>
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
show($_POST);
$obj_destino=$_POST['cargatipo'];
//$hab_destino=$_POST['hab_destino'];
//$mes = $_POST['cmbMes'];
$mes=(isset($_POST['cmbMes']))?$_POST['cmbMes']:0;

$exs=$ob_unidad->existe($conn,CambioFE($txt_fechaini),CambioFE($txt_fechater),$sel_curso,$sel_ramo);
if(pg_numrows($exs)>0){
echo 2;
}
else{

$rs_guarda = $ob_unidad->guardaUnidad($conn,$rdb,$ano,$sel_curso,$sel_ramo,$docdicta,CambioFE($txt_fechaini),CambioFE($txt_fechater),$txt_semana,utf8_decode($texto),utf8_decode($txt_nombre),$tipu,$mes,$txt_horas);

if($rs_guarda){
$rs_ultimaUnidad = $ob_unidad->ultimaUnidad($conn,$rdb);
$id_unidad = pg_result($rs_ultimaUnidad,0);

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
					show($cuenta_ind);
					for($k=0;$k<count($cuenta_ind);$k++){
					$cc=explode("_",$cuenta_ind[$k]);
					$indicador = $cc[1];
					$objetivo =$cc[0];
					  $ob_unidad->guardaIndicador($conn,$id_unidad,$objetivo,$indicador); 
					 
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
		  <td colspan="4" align="center" class="titulo">PLANIFICACI&Oacute;N ANUAL</td>
	  </tr>
     <? if(pg_numrows($rs_unidad)>0){
		$fila_unidad = pg_fetch_array($rs_unidad,0);
		$rs_dicta=$ob_unidad->traeDicta($conn,$fila_unidad['id_ramo']);
		$rs_ramo=$ob_unidad->traeRamo($conn,$fila_unidad['id_curso'],$fila_unidad['id_ramo']);
		$rs_eje=$ob_unidad->tejeUnidad($conn,$idUnidad);
		$rs_arc = $ob_unidad->traearchivo($conn,$idUnidad);
		
		
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
		<!--<tr>
		  <td class="cuadro02">DOCENTE</td>
		  <td colspan="3" class="cuadro01"><?php echo strtoupper(pg_result($rs_dicta,2)) ?></td>
	  </tr>-->
		<tr>
		  <td width="127" class="cuadro02">FECHA INICIO</td>
		  <td width="25%" class="cuadro02">FECHA TERMINO</td>
		  <td width="25%" class="cuadro02">SEMANAS ASIGNADAS</td>
		  <td width="25%" class="cuadro02">HORAS ASIGNADAS</td>
	  </tr>
		<tr>
		  <td class="cuadro01"><?php echo CambioFD($fila_unidad['fecha_inicio']) ?></td>
		  <td class="cuadro01"><?php echo CambioFD($fila_unidad['fecha_termino']) ?></td>
		  <td class="cuadro01"><?php echo $fila_unidad['cant_semanas'] ?></td>
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
      <?php if(pg_numrows($rs_eje)>0){
		?>
           <?php for($e=0;$e<pg_numrows($rs_eje);$e++){
		  $fila_eje = pg_fetch_array($rs_eje,$e);
		 
		  $rs_tipe=$ob_unidad->tipoEjesBloqueAnio($conn,$idUnidad,$fila_eje['id_objetivo']);
		
		  ?>
		<tr>
		  <td colspan="4" >
		  <table width="100%">
          <tr class="cuadro02">
            <td colspan="2"><?php echo strtoupper($fila_eje['nombre'])?></td>
            </tr>
           <?php   for($ti=0;$ti<pg_numrows($rs_tipe);$ti++){ 
		     $fila_tipe = pg_fetch_array($rs_tipe,$ti);
			  $rs_obj=$ob_unidad->traeObjeUnidadAnio($conn,$fila_tipe['id_eje'],$fila_eje['id_objetivo'],$idUnidad);
		   ?>
          <tr class="cuadro02">
          <td  width="50%"><?php echo strtoupper($fila_tipe['texto']) ?></td><td>INDICADORES DE EVALUACI&Oacute;N</td></tr>
         
          <?php for($o=0;$o<pg_numrows($rs_obj);$o++){
		  $fila_obj = pg_fetch_array($rs_obj,$o);
		  ?>
		<tr class="cuadro01">
		  <td valign="top"><?php echo strtoupper($fila_obj['codigo']) ?> - <?php echo nl2br($fila_obj['texto'])?></td>  							          <td valign="top">
          <?php 
		  $rs_ind_a = $ob_unidad->buscaIndicadorSel($conn,$fila_obj['id_obj']);
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
		<tr><td colspan="4" align="center">SIN INFORMACI&Oacute;N</td></tr>
	<?    }?>
	</table>
   <? 
	
}
if($funcion==11){
	//var_dump($_POST);
	/*$rs_objetivo =$ob_unidad->traeEjeObjetivo($conn,$rdb,$cod_ramo);
	$rs_habilidad =$ob_unidad->traeEjeHabilidad($conn,$rdb,$cod_ramo);*/
	$rs_unidad =$ob_unidad->traeUnidad($conn,$idUnidad);
	$fila_unidad = pg_fetch_array($rs_unidad,0);
	
	// echo pg_numrows($rs_obj);
	$rs_ramo=$ob_unidad->traeRamo($conn,$fila_unidad['id_curso'],$fila_unidad['id_ramo']);
	//$rs_tipo = $ob_unidad->teje($conn,$cod_ramo,$ens,$grdo);
	$rs_tipo = $ob_unidad->teje($conn,$fila_unidad['cod_ramo'],$fila_unidad['ensenanza'],$fila_unidad['grado_curso']);
	//$rs_curso = $ob_unidad->traeCursosUno($conn,$fila_unidad['id_curso']);
	
	//ano escolar
	
	
	$rs_ano =$ob_unidad->anoEscola($conn,$_ANO);
	$nano = pg_result($rs_ano,1);
	
	
?>
<script>
$(document).ready(function(){
	rfechaed();
	
		
		 $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
          });

  });
  
  
  


  </script>
  <input type="hidden" name="idUnidad" id="idUnidad" value="<?php echo $fila_unidad['id_unidad']?>" />
<input type="hidden" name="rm" id="rm" value="<?=pg_result($rs_ramo,2);?>" />
<input type="hidden" name="cr" id="cr" value="<?php echo $fila_unidad['id_curso']?>" />
  <input name="an" type="hidden" id="an" value="<?php echo $nano ?>" />
<table width="650" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td colspan="3" class="cuadro02">Nombre</td>
  </tr>
  <tr>
    <td colspan="3" class="cuadro01"><input name="txt_nombre" type="text" id="txt_nombre" value="<?php echo $fila_unidad['nombre'] ?>" size="40" />
    </td>
  </tr>
  <tr>
    <td width="207" class="cuadro02">Rango fechas</td>
    <td width="226" class="cuadro02"><div id="ifecha"></div></td>
    <td class="cuadro02"><div id="tfecha"></div></td>
  </tr>
  <tr>
    <td class="cuadro01">
    <select name="tipoFecha" id="tipoFecha" onchange="rfecha()">
    <option value="0">seleccione...</option>
    <option value="1" <?php echo ($fila_unidad['num_mes']>=1 && $fila_unidad['num_mes']<=12)?"selected":"" ?>>Mensual</option>
    <option value="2" <?php echo (intval($fila_unidad['num_mes'])==0)?"selected":"" ?>>Fechas</option>
    </select></td>
    <td class="cuadro01"><input type="hidden" name="txt_fechaini" id="txt_fechaini" value="<?php echo CambioFD($fila_unidad['fecha_inicio']) ?>" />
      <div id="comes" style="display:none">
      <?php  $nmes =($fila_unidad['num_mes']<10)?"0".$fila_unidad['num_mes']:$fila_unidad['num_mes'];?>
      
      <select name="cmbMes" id="cmbMes" onchange="fechames(this.value)">
       <option value="0">seleccione...</option>
    <option value="01" <?php echo ($nmes=="01")?"selected":""; ?>>Enero</option>
    <option value="02" <?php echo ($nmes=="02")?"selected":""; ?>>Febrero</option>
     <option value="03" <?php echo ($nmes=="03")?"selected":""; ?>>Marzo</option>
    <option value="04" <?php echo ($nmes=="04")?"selected":""; ?>>Abril</option>
    <option value="05" <?php echo ($nmes=="05")?"selected":""; ?>>Mayo</option>
     <option value="06" <?php echo ($nmes=="06")?"selected":""; ?>>Junio</option>
    <option value="07" <?php echo ($nmes=="07")?"selected":""; ?>>Julio</option>
    <option value="08" <?php echo ($nmes=="08")?"selected":""; ?>>Agosto</option>
     <option value="09" <?php echo ($nmes=="09")?"selected":""; ?>>Septiembre</option>
    <option value="10" <?php echo ($nmes=="10")?"selected":""; ?>>Octubre</option>
    <option value="11" <?php echo ($nmes=="11")?"selected":""; ?>>Noviembre</option>
    <option value="12" <?php echo ($nmes=="12")?"selected":""; ?>>Diciembre</option>
    </select></div>
      </td>
    <td class="cuadro01"><input type="hidden" name="txt_fechater" id="txt_fechater" value="<?php echo CambioFD($fila_unidad['fecha_termino']) ?>" /></td>
  </tr>
  <tr>
    <td class="cuadro02">Cantidad Semanas</td>
    <td class="cuadro02">Horas</td>
    <td class="cuadro02">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro01"><input type="text" name="txt_semana" id="txt_semana" class="solo-numero" value="<?php echo $fila_unidad['cant_semanas'] ?>" /></td>
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
    <td colspan="4" class="cuadro02">
       <?php for($ti=0;$ti<pg_numrows($rs_tipo);$ti++){
		  $fila_tipo = pg_fetch_array($rs_tipo,$ti);
		  $cad_ind="";
		  if ($ti==0){
			  ?>
              <?php if($ti==0)
			  $crg=$fila_tipo['id_objetivo'];
			  { ?>
          <input name="crg" id="crg" type="hidden" value="<?php echo $fila_tipo['id_objetivo']; ?>" />
          <?php }?>
              <? }
		  
			$rs_obj=$ob_unidad->traeObjUnidad($conn,$fila_tipo['id_objetivo'],$_POST['idUnidad']);
			$cob="";
			for($o=0;$o<pg_numrows($rs_obj);$o++){
				$fil_obj=pg_fetch_array($rs_obj,$o);
				
				$cob.=$fil_obj['id_obj'].",";
				
				
			}
			$cob=substr($cob, 0, -1);
			
			$rs_inditpo = $ob_unidad->traeIndiUnidadC($conn,$fila_unidad['id_unidad'],$fila_tipo['id_objetivo']);
			if(pg_numrows($rs_inditpo)>0){
			
			for($in=0;$in<pg_numrows($rs_inditpo);$in++){
			$fila_in = pg_fetch_array($rs_inditpo,$in);
			$cad_ind.=$fila_in['id_obj']."_".$fila_in['id_indicador'].","; 	
			}	
			}
		  
		  ?>
           <input type="hidden" name="cargatipo[]" id="cargatipo<?php echo $fila_tipo['id_objetivo']; ?>" value="<?php echo $cob ?>" /> 
      <input name="tipo" id="tipo<?php echo $t ?>" type="radio" value="<?php echo $fila_tipo['id_objetivo']; ?>" onclick="cargatipo(<?php echo $fila_tipo['id_objetivo']; ?>,<?php echo $fila_unidad['id_unidad']; ?>);" <?php echo ($ti==0)?"checked":"" ?> />
      <?php echo $fila_tipo['nombre']; ?>
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
	
//	show($_POST);
$obj_destino=$_POST['cargatipo'];




$rs_guarda = $ob_unidad->actualizaUnidad($conn,$idUnidad,CambioFE($txt_fechaini),CambioFE($txt_fechater),$txt_semana,$txt_horas,utf8_decode($texto),utf8_decode($txt_nombre));	

$d_obj = $ob_unidad->eliminaObHa($conn,$idUnidad);
$d_obj = $ob_unidad->borraIndicador($conn,$idUnidad);


 if(count($obj_destino)>0){
			for ($i=0;$i<count($obj_destino);$i++) {
				//echo $i;
				
				
				if(strlen($obj_destino[$i])>0){ 
					$cuenta_tipo = explode(",",$obj_destino[$i]);
					for ($j=0;$j<count($cuenta_tipo);$j++) { 
					$rs_guardaObjetivo = $ob_unidad->guardaObjetivo($conn,$idUnidad,$cuenta_tipo[$j]);
					//$rs_buseje = $ob_unidad->buscaIndicador($conn,$cuenta_tipo[$j]);
					
				
					
					
							/*for($k=0;$k<pg_numrows($rs_buseje);$k++){
								$fila_ind = pg_fetch_array($rs_buseje,$k);
								$indicador = $fila_ind['id_indicador'];
								$ob_unidad->guardaIndicador($conn,$idUnidad,$cuenta_tipo[$j],$indicador);
							}*/
							
							}
							
							
				}
				
			} 
			
			
		 }
	//echo $_POST["cargaind"]."<br>";
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
					  $ob_unidad->guardaIndicador($conn,$idUnidad,$objetivo,$indicador); 
					 
						}
					}
				}
				
				}

	/* if(count($obj_destino)>0){
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
		echo 1;
		
}
if($funcion==13){
	//show($_POST);
	$rs_curso = $ob_unidad->traeCursosUno($conn,$curso);
	 $cmr = explode("_",$curso);
	
	$ense =  $cmr[1];
	$grado = $cmr[0];
	
	?>
    <br />

<table width="650" align="center" border="1" style="border-collapse:collapse">
	<?
	
//$rs_objetivo =$ob_unidad->traeEjeObjetivo($conn,$rdb,$cod_ramo,$tipo);
$rs_objetivo =$ob_unidad->traeEjeObjetivo2($conn,$rdb,$cod_ramo,$tipo,$ense,$grado);
 for($o=0;$o<pg_numrows($rs_objetivo);$o++){
		 $fila_obj = pg_fetch_array($rs_objetivo,$o);
		
		  
		
			
			
			
		 ?>
		  <tr><td class="cuadro02"><?php echo $fila_obj['texto'] ?></td>
		  <?
		 $rs_eje =$ob_unidad->traeObj($conn,$fila_obj['id_eje'],$rdb,$ense,$grado,$tipo);
		 for($j=0;$j<pg_numrows($rs_eje);$j++){
			$fila = $fila_obj = pg_fetch_array($rs_eje,$j);
			$rs_ideva = $ob_unidad->buscaIndicador($conn,$fila['id_obj']);
			
			$cad_ind="";
			
			$ideva = "";
			$rs_inditpo = $ob_unidad->traeIndiUnidadO($conn,$unn,$fila['id_obj']);
			
			if(pg_numrows($rs_inditpo)>0){
			
				for($in=0;$in<pg_numrows($rs_inditpo);$in++){
				$fila_in = pg_fetch_array($rs_inditpo,$in);
				$cad_ind.=$fila_in['id_obj']."_".$fila_in['id_indicador'].","; 	
				}	
			}
			?>
		  <tr><td align="justify" id="fila<?php echo  $fila['id_obj']?>" onclick="pp(<?php echo  $fila['id_obj']?>);sumatipo(<?php echo  $fila['tipo']?>); buscasel(<?php echo  $fila['tipo']?>);" class="i textosimple"><?php echo nl2br($fila['codigo']."-".$fila['texto']) ?><input name="obj_destino[]" type="checkbox" class="oo<?php echo  $fila['tipo']?>" id="destino<?=$fila['id_obj']?>" style="visibility:hidden" value="<?php echo  $fila['id_obj']?>" /> 
 <input type="hidden" id="lindv<?php echo  $fila['id_obj']?>" name="lindv<?php echo  $fila['id_obj']?>" class="lindv<?php echo  $fila['tipo']?>" value="<?php echo $cad_ind ?>" />
 </td>
          <?
		 }
		 
		 
              
 }

	
	/*elseif($tipo==1){
$rs_habilidad =$ob_unidad->traeEjeHabilidad($conn,$rdb,$cod_ramo);
for($h=0;$h<pg_numrows($rs_habilidad);$h++){
		 $fila_hab = pg_fetch_array($rs_habilidad,$h);
		 ?>
		  <tr><td class="cuadro02"><?php echo $fila_hab['texto'] ?></td>
		  <?
       $rs_eje =$ob_unidad->traeHab($conn,$fila_hab['id_eje'],$rdb,$ense,$grado);
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
	//var_dump($_POST);
	$rs_curso = $ob_unidad->traeCursosUno($conn,$curso);
	$ense = pg_result($rs_curso,3);
	$grado = pg_result($rs_curso,1);
	?><br />

   
<table width="650" align="center" border="1" style="border-collapse:collapse">
	<?
	
$rs_objetivo =$ob_unidad->traeEjeObjetivo($conn,$rdb,$cod_ramo,$_POST['tipo']);
 for($o=0;$o<pg_numrows($rs_objetivo);$o++){
		 $fila_obj = pg_fetch_array($rs_objetivo,$o);
		 ?>
		  <tr><td class="cuadro02"><?php echo $fila_obj['texto'] ?></td>
		  <?
		 $rs_eje =$ob_unidad->traeObj($conn,$fila_obj['id_eje'],$rdb,$ense,$grado);
		 for($j=0;$j<pg_numrows($rs_eje);$j++){
			$fila = $fila_obj = pg_fetch_array($rs_eje,$j);
			
			$rs_marca = $ob_unidad->traeMarcado($conn,$id_unidad,$fila['id_obj']);
			if(pg_numrows($rs_marca)==0){
			$marca=0;
			}else{
			$marca=1;
			}
			
			$l_oo="";
			$rs_tob = $ob_unidad->traeIndiUnidadO($conn,$id_unidad,$fila['id_obj']);
			
			?>
		   <tr><td align="justify" id="fila<?php echo  $fila['id_obj']?>" onclick="pp(<?php echo  $fila['id_obj']?>);sumatipo(<?php echo  $fila['tipo']?>); buscasel(<?php echo  $fila['tipo']?>)" class="i textosimple"><?php echo nl2br($fila['codigo']."-".$fila['texto']) ?><input name="obj_destino[]" type="checkbox" class="oo<?php echo  $fila['tipo']?>" id="destino<?=$fila['id_obj']?>" style="visibility:hidden" value="<?php echo  $fila['id_obj']?>" />
		       <input type="hidden" id="lindv<?php echo  $fila['id_obj']?>" name="lindv<?php echo  $fila['id_obj']?>" class="lindv<?php echo  $fila['tipo']?>" /></td>
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
//$rs_curso = $ob_unidad->cursoTieneRamo($conn,$ano,$codramo);

$rs_curso = $ob_unidad->cursoTieneRamoGrado($conn,$ano,$codramo,$grado,$ens,$cur);
?>
<input type="hidden" name="idu" id="idu" value="<?php echo $unidad ?>" />
<input type="hidden" name="ida" id="ida" value="<?php echo $ano ?>" />
<input type="hidden" name="idr" id="idr" value="<?php echo $codramo ?>" />
<table border="1" style="border-collapse:collapse">
<tr class="cuadro02">
  <td colspan="2" align="center">Seleccione curso(s) donde replicar planificaci&oacute;n</td></tr>
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
			
//$rs_guarda = $ob_unidad->guardaUnidad($conn,$_INSTIT,$ano,$cc[$c],$id_ramo,$rut_emp,pg_result($rs_unidad,6),pg_result($rs_unidad,7),pg_result($rs_unidad,8),pg_result($rs_unidad,9),pg_result($rs_unidad,10),pg_result($rs_unidad,13));

$rs_guarda = $ob_unidad->guardaUnidad($conn,$_INSTIT,$ano,$cc[$c],$id_ramo,$rut_emp,pg_result($rs_unidad,6),pg_result($rs_unidad,7),pg_result($rs_unidad,16),utf8_decode(pg_result($rs_unidad,10)),utf8_decode(pg_result($rs_unidad,13)),pg_result($rs_unidad,14),intval(pg_result($rs_unidad,15)),pg_result($rs_unidad,9));
//exit;

				$rs_ultimaUnidad = $ob_unidad->ultimaUnidad($conn,$_INSTIT);
				$id_unidad = pg_result($rs_ultimaUnidad,0);
				
				for($o=0;$o<pg_numrows($rs_obj);$o++){
					$fila_obj = pg_fetch_array($rs_obj,$o);
					
					 $rs_guardaObjetivo = $ob_unidad->guardaObjetivo($conn,$id_unidad,$fila_obj['id_obj']);
				
				}
			
			} 
		 }
		 
		 echo 1;
}
if($funcion==17){
?>
<input name="gen" type="button" onClick="generaStd();" value="GENERAR" class="botonXX" />
<?
}
if($funcion==18){
var_dump($_POST);
$rs_existe = $ob_unidad->existeT2($conn,$curso,$id_ramo,$tipo);
if(pg_numrows($rs_existe)>0){
echo 2;
}else{
	$rs_sub= $ob_unidad->subsector($conn,$cod_ramo);
	$cod_sub = pg_result($rs_sub,1);
	$ids = pg_result($rs_sub,0);
	
	$rs_ano = $ob_unidad->anoEscola($conn,$_ANO);
	$txt_fechaini = pg_result($rs_ano,2);
	$txt_fechater = pg_result($rs_ano,3);
	$numa = pg_result($rs_ano,1);
	
	//$rs_curuno = $ob_unidad->traeCursosUno($conn,$curso);
	//$gr = pg_result($rs_curuno,1);
	//$lt = pg_result($rs_curuno,2);
	$en = pg_result($rs_curuno,3);
	
	
	//$rs_obj = $ob_unidad->traeObjAll($conn,$rdb,$en,$gr);
	
	$rs_obj = $ob_unidad->traeObjAll2($conn,$rdb,$ens,$grd,$cod_ramo);
	
	$txt_nombre = "PLANIFICACION ".$grd."_".$ens."_$cod_ramo"."_$numa";
	
	$rs_guarda = $ob_unidad->guardaUnidadT2($conn,$rdb,$ano,0,0,0,$txt_fechaini,$txt_fechater,utf8_decode($txt_nombre),$tipo,$grd,$ens,$cod_ramo);

	if($rs_guarda){
	$rs_ultimaUnidad = $ob_unidad->ultimaUnidad($conn,$rdb);
	$id_unidad = pg_result($rs_ultimaUnidad,0);
	
	//busco objetivos que hayan para el ramo y el grado
	for($o=0;$o<pg_numrows($rs_obj);$o++){
		$obj = pg_fetch_array($rs_obj,$o);
		$ob_unidad->guardaObjetivo($conn,$id_unidad,$obj['id_obj']);
		$rs_buseje = $ob_unidad->buscaIndicador($conn,$obj['id_obj']);
				for($k=0;$k<pg_numrows($rs_buseje);$k++){
					$fila_ind = pg_fetch_array($rs_buseje,$k);
					$indicador = $fila_ind['id_indicador'];
				    $ob_unidad->guardaIndicador($conn,$id_unidad,$obj['id_obj'],$indicador);
				}
		}
	
	
	echo 1;
	}
	else echo 0;
}
}

if($funcion==19){
	$rs_curso = $ob_unidad->traeCursosUno($conn,$curso);
	
	?>
 <input type="hidden" name="grdo" id="grdo" value="<?php echo pg_result($rs_curso,1) ?>" />
 <input name="ens" type="hidden" id="ens" value="<?php echo pg_result($rs_curso,3) ?>" />
 <?
}
if($funcion==20){

	$rs_estado = $ob_unidad->traeEstadoClase($conn);
	$rs_historial = $ob_unidad->traeHistorialcambiosUAnual($conn,$unidad);
	
	?><?php if($_PERFIL==0 || $_PERFIL==14 || $_PERFIL==25){?>
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
	
	$rs_estado = $ob_unidad->guardaHistorialcambiosUAnual($conn,$unidad,date("Y-m-d"),$desc);
	
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

$rs_listaua = $ob_unidad->traeUnidadU($conn,$id_unidad);
for($ua=0;$ua<pg_numrows($rs_listaua);$ua++){
$filaua = pg_fetch_array($rs_listaua,$ua);

$id_unidadU = $filaua['id_unidad'];

//clases
$rs_cls= $ob_unidad->traeClasesU($conn,$id_unidadU);
for($c=0;$c<pg_numrows($rs_cls);$c++){
	$fila_cls = pg_fetch_array($rs_cls,$c);
	
	$id_clase=$fila_cls['id_clase'];
	
		$ruta ="../clase/acv/";

		//busco si tengo archivos asociados
		$rs_lista = $ob_unidad->archivoClase($conn,$id_clase);
		if(pg_numrows($rs_lista)>0){
			for($a=0;$a<pg_numrows($rs_lista);$a++){
			$fila = pg_fetch_array($rs_lista,$a);
				@unlink($ruta.$fila['ruta']) ;
			}
		}
	
		$ob_unidad->delArchivoClase($conn,$id_clase);
		$ob_unidad->delNotaClase($conn,$id_clase);
		$ob_unidad->delObsClase($conn,$id_clase);
		$ob_unidad->delRecursoClase($conn,$id_clase);
		$ob_unidad->delTipoevaClase($conn,$id_clase);
		$ob_unidad->delObjClase($conn,$id_clase);
		$ob_unidad->delClase($conn,$id_clase);
	}


//borro datos de unidad
$ruta_u ="../unidad/acv/";
//busco si tengo archivos asociados
		$rs_listau = $ob_unidad->archivoUnidadU($conn,$id_unidadU);
		if(pg_numrows($rs_lista)>0){
			for($b=0;$b<pg_numrows($rs_listau);$b++){
			$filau = pg_fetch_array($rs_listau,$b);
				@unlink($ruta_u.$filau['ruta']) ;
			}
		}


$ob_unidad->delObsUnidadU($conn,$id_unidadU);
$ob_unidad->delArchivoUnidadU($conn,$id_unidadU);
$ob_unidad->delObjUnidadU($conn,$id_unidadU);
$ob_unidad->delNotaUnidadU($conn,$id_unidadU);
$ob_unidad->delUnidadU($conn,$id_unidadU);


}


//borro datos unidad anual

/*$ruta_u ="acv/";
//busco si tengo archivos asociados
		$rs_listaa = $ob_unidad->archivoUanual($conn,$id_unidad);
		if(pg_numrows($rs_lista)>0){
			for($q=0;$q<pg_numrows($rs_listaa);$q++){
			$filaa = pg_fetch_array($rs_listaa,$q);
				@unlink($busco.$filaa['ruta']) ;
			}
		}
		
$ob_unidad->archivoUnidad($conn,$id_unidad);
$ob_unidad->delObsUnidad($conn,$id_unidad);	
$ob_unidad->borraIndicador($conn,$id_unidad);
$ob_unidad->delObjUnidad($conn,$id_unidad);	*/
$ob_unidad->delUnidad($conn,$id_unidad);		
		
}//fin funcion
if($funcion==24){
//show($_POST);

$rs_indi = $ob_unidad->buscaIndicador($conn,$obj);
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
