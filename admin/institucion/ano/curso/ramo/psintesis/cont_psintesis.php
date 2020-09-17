<?php require("../../../../../../util/header.php");
require("mod_psintesis.php");

$funcion = $_POST['funcion'];

$ob_sintesis = new Psisntesis();

if($funcion==1){
$rs_ano = $ob_sintesis->traeAno($conn,$ano);
echo @pg_result($rs_ano,0);
?>
<input type="hidden" name="nro_ano" id="nro_ano" value="<?php echo @pg_result($rs_ano,0);?>">
<?
}
if($funcion==2){
	$rs_ramo=$ob_sintesis->traeRamo($conn,$id_ramo);
	echo @pg_result($rs_ramo,0);
}
if($funcion==3){
	$rs_periodo=$ob_sintesis->traePeriodo($conn,$id_ano);
	?>
    <select name="cmbPERIODO" class="ddlb_x" onchange="traeLista()" id="cmbPERIODO">
    <option value="0">seleccione</option>
    <?
		for($i=0;$i<@pg_numrows($rs_periodo);$i++){
		$fila_per = @pg_fetch_array($rs_periodo,$i); 
		if($fila_per['id_periodo']){?>
			  <option value="<?=$fila_per['id_periodo'];?>">
				<?=$fila_per['nombre_periodo'];?>
				</option>
			  <? }else{?>
			  <option value="<?=$fila_per['id_periodo'];?>">
				<?=$fila_per['nombre_periodo'];?>
				</option>
			  <? 	}	
		} ?>
    
    </select>
    <?
}
if($funcion==4){
	//var_dump($_POST);
	$rs_alumno = $ob_sintesis->traeAlumnos($conn,$id_curso,$id_ramo,$id_periodo,$id_ano,$nro_ano);
	?>
    <table width="80%" border="1" cellspacing="0" cellpadding="3" align="center">
        <tr class="tablatit2-1">
        <td><div align="center">N&ordm;</div></td>
        <td><div align="center">NOMBRE</div></td>
        <td><div align="center">NOTA <br />PRUEBA </div></td>
        </tr>
         <? for($i=0;$i<@pg_numrows($rs_alumno);$i++){
			$fila_alu = @pg_fetch_array($rs_alumno,$i);
			$rs_nota = $ob_sintesis->traeNotaPsintesis($conn,$fila_alu['rut_alumno'],$id_ramo,$id_periodo);
			$nota = pg_result($rs_nota,0);
			?>
            <tr>
            <td class="Estilo17"><?=$i+1;?><input name="txtRUT<?=$i;?>" type="hidden" value="<?=$fila_alu['rut_alumno'];?>" /></td>
            <td class="Estilo17"><?=strtoupper($fila_alu['nombre']);?></td>
             <td align="center" class="Estilo17"><div id="nota"><?=$nota;?></div></td>
            </tr>

            <?
		 } ?>
    </table>
    <?
}
if($funcion==5){
	$rs_alumno = $ob_sintesis->traeAlumnos($conn,$id_curso,$id_ramo,$id_periodo,$id_ano,$nro_ano);
	?>
    <script>
        $(document).ready(function (){
          $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
          });
        });
		
		
    </script>
    <table width="80%" border="1" cellspacing="0" cellpadding="3" align="center">
        <tr class="tablatit2-1">
        <td><div align="center">N&ordm;</div></td>
        <td><div align="center">NOMBRE</div></td>
        <td><div align="center">NOTA <br />PRUEBA </div></td>
        </tr>
         <? for($i=0;$i<@pg_numrows($rs_alumno);$i++){
			$fila_alu = @pg_fetch_array($rs_alumno,$i);
			$rs_nota = $ob_sintesis->traeNotaPsintesis($conn,$fila_alu['rut_alumno'],$id_ramo,$id_periodo);
			$nota = pg_result($rs_nota,0);
			?>
            <tr>
            <td class="Estilo17"><?=$i+1;?><input name="txtRUT[]" type="hidden" value="<?=$fila_alu['rut_alumno'];?>" /></td>
            <td class="Estilo17"><?=strtoupper($fila_alu['nombre']);?></td>
             <td align="center" class="Estilo17"><div id="nota"><input name="notaps[]" type="text" id="nota<?php echo $i?>" value="<?=$nota;?>" size="2" maxlength="2" class="solo-numero" onBlur="rango(<?php echo $i?>)"></div></td>
            </tr>

            <?
		 } ?>
    </table>
<? }
if($funcion==6){
	//var_dump($_POST);
	
$rut=$_POST['txtRUT'];
$nota=$_POST['notaps'];

for ($i=0;$i<count($rut);$i++) {
	//revisar si hay notas
	$rs_nota = $ob_sintesis->traeNotaPsintesis($conn,$rut[$i],$id_ramo,$cmbPERIODO);
	
	//ingreso nota
	if(pg_numrows($rs_nota)==0){
		$ing_nota = $ob_sintesis->IngresoNota($conn,$id_curso,$id_ramo,$id_ano,$rut[$i],intval($nota[$i]),$cmbPERIODO);
	}
	//update nota
	else{
		$ing_nota = $ob_sintesis->CambiaNota($conn,$id_ramo,$rut[$i],intval($nota[$i]),$cmbPERIODO);
	}

}	
}
if($funcion==7){
//var_dump($_POST);
$rs_nota = $ob_sintesis->borraNotas($conn,$id_ramo,$id_periodo);
}
?>