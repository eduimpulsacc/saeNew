<?php 
require('../../../../../../util/header.inc');
require("mod_motivo.php");

$funcion = $_POST['funcion'];

$ob_motivo = new Matraso();

if($funcion==1){
$rs_an = $ob_motivo->traeAno($conn,$_INSTIT);
?>
<select name="cmb_ano" id="cmb_ano" class="ddlb_x" onchange="cargaCurso(this.value);">
    <option value="0">Seleccione...
    <?php for($a=0;$a<pg_numrows($rs_an);$a++){
		$fil_a = pg_fetch_array($rs_an,$a);
		?>
    <option value="<?php echo $fil_a['id_ano'] ?>" <?php echo ($fil_a['situacion']==1)?"selected":""; ?>><?php echo $fil_a['nro_ano'] ?> (<?php echo ($fil_a['situacion']==1)?"abierto":"cerrado"; ?>) </option>
    <?php } ?>
    </select>
<?
}

if($funcion==2){
$rs_cur = $ob_motivo->traeCursos($conn,$ano);
?>
<select name="cmb_curso" id="cmb_curso" class="ddlb_x" onchange="cargames(this.value);" >
    <option value="0">Seleccione...
    <?php for($a=0;$a<pg_numrows($rs_cur);$a++){
		$fil_a = pg_fetch_array($rs_cur,$a);
		?>
    <option value="<?php echo $fil_a['id_curso'] ?>" ><?php echo CursoPalabra($fil_a['id_curso'],1,$conn); ?></option>
    <?php } ?>
    </select>
<?
}
if($funcion==3){

$rs_fecha = $ob_motivo->curso($conn,$cur);
$fil_fecha = pg_fetch_array($rs_fecha,0);
if(($fil_fecha['fecha_inicio']=="1111-11-11" && $fil_fecha['fecha_termino']=="1111-11-11") || ($fil_fecha['fecha_inicio']==NULL && $fil_fecha['fecha_termino']==NULL)){
$rs_ano = $ob_motivo->ano($conn,$ano);
$fil_anio = pg_fetch_array($rs_ano,0);

$f_ini = $fil_anio['fecha_inicio'];
$f_ter = $fil_anio['fecha_termino'];

}else{
$f_ini = $fil_fecha['fecha_inicio'];
$f_ter = $fil_fecha['fecha_termino'];
}

$mini = explode("-",$f_ini);
$mini = intval($mini[1]);

$mter = explode("-",$f_ter);
$mter = $mter[1];

?>
<select name="cmb_mes" id="cmb_mes" class="ddlb_x" onChange="lista()">
    <option value="0">Seleccione...</option>
   <?php  for($m=$mini;$m<=$mter;$m++){
	   $mes = ($m<10)?"0".$m:$m;
	   ?>
    <option value="<?php echo $mes ?>"><?php echo envia_mes($mes) ?></option>
    <?php }?>
    </select>
<?

}
if($funcion==4){
$rs_alu = $ob_motivo->listaAlumno($conn,$ano,$mes,$curso,$numano);
$tot_alum = pg_numrows($rs_alu);
?>
<table <?php echo ($tot_alum>0)?'border="1"':""; ?>  >
<?php if(pg_numrows($rs_alu)>0){
for($xa=0; $xa < $tot_alum; $xa++){
	$alumnos = pg_fetch_array($rs_alu,$xa);
	$rut_alumno = $alumnos['rut_alumno'];
	
	$rs_atraso = $ob_motivo->listaAtraso($conn,$ano,$mes,$curso,$numano,$rut_alumno);
?>
<tr><td class="textosesion" width="280"><?=trim($alumnos['ape_pat'])." ".trim($alumnos['ape_mat']).", ".trim($alumnos['nombre_alu'])?></td>
<?php for($at=0;$at<pg_numrows($rs_atraso);$at++){
	$atrasos = pg_fetch_array($rs_atraso,$at);
	$fech_atraso = $atrasos['fecha'];
	$separa = explode("-",$fech_atraso);
	
	//$jus = $ob_motivo->trajeJustificado($conn,$atrasos['id_anotacion']);
	//$jus = $ob_motivo->trajeJustificado2($conn,$rut_alumno,$atrasos['fecha']);
	 $tipo = (strlen($atrasos['hora'])== 0 || $atrasos['hora']== '00:00:00')?1:0;
	$motivo = ($tipo==0)? 'title="'.CambioFD($fech_atraso).' - '.$atrasos['observacion'].'"':"";
	
	 ?>
	<td class="tabla03" align="center" style="width:30px; cursor:pointer" onClick="traeMotivo('<?php echo $atrasos['id_anotacion'] ?>',<?php echo $tipo ?>)" <?php echo $motivo ?>>
	
    
	<?=$separa[2]?><br>
    <? if($tipo==1){?>
        <img src="b_drop.png">
    <? }else{?>
        <img src="vb.gif">
    <? }?>	
    
    </td>
<?php }?>


</tr>

<?php 
 } // fin for si existen alumnos

 } // fin if si existen alumnos
 
 else{?>
<tr><td class="cajamenu2" style="width:100%"><div align="center">NO SE REGISTRARON ATRASOS</div><br></td></tr>
<?php }?>
</table>
<?
}
if($funcion==5){
	
	$rs_anota= $ob_motivo->Anotacion($conn,$id_anotacion);
	//$rs_anota = $ob_motivo->Anotacion2($conn,$rut,$fecha);
	$fila = pg_fetch_array($rs_anota,0);
	
	$rs_alu =  $ob_motivo->Alumno($conn,$fila['rut_alumno']);
	$alumnos = pg_fetch_array($rs_alu,0);
	$fecha = $fila['fecha'];
	
?>
<script type="text/javascript" src="../../../../../clases/jquery-ui-1.9.2.custom/js/jquery.maskedinput-1.2.2.js"></script>
<script>
	$(document).ready(function() {
	$("#txt_horatraso").mask('99:99');
		$("#txt_minatraso").mask('99:99');
	
	});

</script>
<table width="95%" align="center">
<tr><td colspan="3" class="textonegrita">
   <input type="hidden" name="rut" id="rut" value="<?php echo $rut ?>">
  <input type="hidden" name="ano" id="ano" value="<?php echo $anio ?>">
  <input type="hidden" name="fecha" id="fecha" value="<?php echo $fecha ?>">
  <input type="hidden" name="ida" id="ida" value="<?php echo $id_anotacion ?>">
 
  
</td>
  <tr>
  <td width="25%" class="textosimple">Alumno</td>
  <td width="2%" align="center" class="textosimple">:</td>
  <td width="73%" class="textosimple"><?=trim($alumnos['ape_pat'])." ".trim($alumnos['ape_mat']).", ".trim($alumnos['nombre_alu'])?></td>
  </tr>
<tr>
  <td class="textosimple">Fecha Atraso</td>
  <td align="center" class="textosimple">:</td>
  <td class="textosimple"><?php echo CambioFD($fila['fecha']) ?></td>
  </tr>
<tr>
  <td class="textosimple">Jornada</td>
  <td align="center" class="textosimple">:</td>
  <td class="textosimple"><?php echo ($fila['jornada']==1)?"Ma&ntilde;ana":"Tarde"; ?></td>
  </tr>
 
<tr>
  <td class="textosimple">Hora Atraso</td>
  <td align="center" class="textosimple">:</td>
  <td class="textosimple"><input name="txt_horatraso" type="text" id="txt_horatraso" size="5" maxlength="5" data-mask="00:00"> 
    (EJ: 10:50)</td>
</tr>
<tr>
  <td class="textosimple">Minutos Atraso</td>
  <td align="center" class="textosimple">:</td>
  <td class="textosimple"><input name="txt_minatraso" type="text" id="txt_minatraso" size="5" maxlength="5" data-mask="00:00">
    (EJ: 00:10)</td>
</tr>
<tr>
  <td class="textosimple">Observaciones</td>
  <td align="center" class="textosimple">:</td>
  <td class="textosimple">&nbsp;</td>
</tr>

<tr>
  <td colspan="3" class="textosimple">
    <textarea name="motivo" id="motivo" style="width:300px; height:100px"></textarea></td>
    </tr>
</table>
<?	
}
if($funcion==6){
	$rs_elim = $ob_motivo->quitaMotivo($conn,$id);

}

if($funcion==7){
	$horas = $hora.":00";
	$minutos = $minuto.":00";
	
	$rs_guarda = $ob_motivo->GuardaMotivo($conn,$ida,$horas,$minutos,$motivo);

}


?>