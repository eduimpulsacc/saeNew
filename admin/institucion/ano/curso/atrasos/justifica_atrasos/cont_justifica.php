<?php 
require('../../../../../../util/header.inc');
require("mod_justifica.php");

$funcion = $_POST['funcion'];

$ob_justifica = new Justifica();

if($funcion==1){
$rs_an = $ob_justifica->traeAno($conn,$_INSTIT);
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
$rs_cur = $ob_justifica->traeCursos($conn,$ano);
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

$rs_fecha = $ob_justifica->curso($conn,$cur);
$fil_fecha = pg_fetch_array($rs_fecha,0);
if(($fil_fecha['fecha_inicio']=="1111-11-11" && $fil_fecha['fecha_termino']=="1111-11-11") || ($fil_fecha['fecha_inicio']==NULL && $fil_fecha['fecha_termino']==NULL)){
$rs_ano = $ob_justifica->ano($conn,$ano);
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
$rs_alu = $ob_justifica->listaAlumno($conn,$ano,$mes,$curso,$numano);
$tot_alum = pg_numrows($rs_alu);
?>
<table <?php echo ($tot_alum>0)?'border="1"':""; ?>  >
<?php if(pg_numrows($rs_alu)>0){
for($xa=0; $xa < $tot_alum; $xa++){
	$alumnos = pg_fetch_array($rs_alu,$xa);
	$rut_alumno = $alumnos['rut_alumno'];
	
	$rs_atraso = $ob_justifica->listaAtraso($conn,$ano,$mes,$curso,$numano,$rut_alumno);
?>
<tr><td class="textosesion" width="280"><?=trim($alumnos['ape_pat'])." ".trim($alumnos['ape_mat']).", ".trim($alumnos['nombre_alu'])?></td>
<?php for($at=0;$at<pg_numrows($rs_atraso);$at++){
	$atrasos = pg_fetch_array($rs_atraso,$at);
	$fech_atraso = $atrasos['fecha'];
	$separa = explode("-",$fech_atraso);
	//$jus = $ob_justifica->trajeJustificado($conn,$atrasos['id_anotacion']);
	$jus = $ob_justifica->trajeJustificado2($conn,$rut_alumno,$atrasos['fecha']);
	$tipo = (pg_numrows($jus)==0)?1:0;
	@$fjus = pg_fetch_array($jus,0);
	$motivo = (pg_numrows($jus)>0)? 'title="'.CambioFD($fjus['fecha']).' - '.$fjus['observacion'].'"':"";
	
	 ?>
	<td class="tabla03" align="center" style="width:30px; cursor:pointer" onClick="justifica('<?php echo $rut_alumno ?>','<?php echo $atrasos['fecha'] ?>',<?php echo $tipo ?>)" <?php echo $motivo ?>>
	
    
	<?=$separa[2]?><br>
    <? if(pg_numrows($jus)==0){?>
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
	
	//$rs_anota= $ob_justifica->Anotacion($conn,$anota);
	$rs_anota = $ob_justifica->Anotacion2($conn,$rut,$fecha);
	$fila = pg_fetch_array($rs_anota,0);
	
	$rs_alu =  $ob_justifica->Alumno($conn,$fila['rut_alumno']);
	$alumnos = pg_fetch_array($rs_alu,0);
	
?>
<table width="95%" align="center">
<tr><td colspan="3" class="textonegrita">
   <input type="hidden" name="rut" id="rut" value="<?php echo $rut ?>">
  <input type="hidden" name="ano" id="ano" value="<?php echo $anio ?>">
  <input type="hidden" name="fecha" id="fecha" value="<?php echo $fecha ?>">
 
  
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
  <td class="textosimple"><?php echo $fila['hora'] ?></td>
</tr>
<tr>
  <td class="textosimple">Adjunta Documentos</td>
  <td align="center" class="textosimple">:</td>
  <td class="textosimple"><input type="checkbox" name="adj" id="adj" /></td>
</tr>

<tr>
  <td colspan="3" class="textosimple"><br>
    <textarea name="motivo" id="motivo" style="width:300px; height:100px"></textarea></td>
    </tr>
</table>
<?	
}
if($funcion==6){
	$rs_elim = $ob_justifica->quitaJustificado($conn,$rut,$anio,$curso,$fecha);

}

if($funcion==7){
	$rs_guarda = $ob_justifica->GuardaJustificado($conn,0,$ano,$curso,$fecha,$rut,$text,$chk);

}


?>