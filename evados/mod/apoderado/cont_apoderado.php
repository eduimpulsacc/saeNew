<? 

session_start();
require "mod_apoderado.php";


$funcion = $_POST['funcion'];

$ob_Apoderado = new Apoderado($_IPDB,$_ID_BASE);

if($funcion==1){
	$rs_curso = $ob_Apoderado->Listado($curso);
	
?><br />
<br />

<table width="90%" border="0" align="center">
  <tr>
    <td align="center">&nbsp;<strong>LISTADO DE CURSO</strong></td>
  </tr>
</table>

<table width="90%" border="1" align="center" style="border-collapse:collapse">
  <tr class="tableindex">
    <td>RUT ALUMNO</td>
    <td>ALUMNO</td>
    <td> RUT APODERADO</td>
    <td>APODERADO</td>
    <td>&nbsp;</td>
  </tr>
  <? for($i=0;$i<pg_numrows($rs_curso);$i++){
	  $fila =pg_fetch_array($rs_curso,$i);
	?>
	  
  <tr>
    <td>&nbsp;<?=$fila['rut_alumno']."-".$fila['dig_rut'];?></td>
    <td>&nbsp;<?=$fila['nombre_alumno'];?></td>
    <td>&nbsp;<?=$fila['rut_apo']."-".$fila['dig_rut_apo'];?></td>
    <td>&nbsp;<?=$fila['nombre_apoderado'];?></td>
    <td>&nbsp;<a href="#"><? if($fila['rut_apo']=="") echo "<img src='img/PNG-48/Add.png' width='22' height='22' border='0' title='Agregar Apoderado' onclick='agregar_apo(".$fila['rut_alumno'].")'/>";?></a></td>
  </tr>
  <? } ?>
  
</table>
<?		
}



if($funcion==2){
	$rs_alumno =$ob_Apoderado->BuscarAlu($rut_alumno);
	$fila = pg_fetch_array($rs_alumno,0);
?>
<br />

<table width="90%" border="0" align="center">
  <tr>
    <td colspan="3" align="center">&nbsp;<strong>DATOS APODERADO</strong></td>
  </tr>
  <tr>
    <td colspan="3" align="right"><input name="GUARDAR" type="button" class="botonXX" id="GUARDAR" value="GUARDAR"  onclick="guardar_apo()"/></td>
  </tr>
  <tr>
    <td width="12%" align="left" class="cuadro02">RUT ALUMNO</td>
    <td width="1%" align="right" class="cuadro02">:</td>
    <td width="87%" align="left">&nbsp;<?=$fila['rut_alumno']."-".$fila['dig_rut'];?></td>
  </tr>
  <tr>
    <td align="left" class="cuadro02">NOMBRE</td>
    <td align="right" class="cuadro02">:</td>
    <td align="left">&nbsp;<?=$fila['nombre'];?></td>
  </tr>
</table>
<br />

<table width="90%" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td width="26%" class="cuadro02">RUT</td>
    <td width="25%"><label for="textfield"></label>
    <input name="txtRUT" type="text" id="txtRUT" size="10" maxlength="8" onblur="busca_rut(this.value);" /> 
    - 
    <label for="textfield2"></label>
    <input name="txtDIG" type="text" id="txtDIG" size="5" maxlength="1" /></td>
    <td width="4%">&nbsp;</td>
    <td width="20%" class="cuadro02">NOMBRES</td>
    <td width="25%"><input type="text" name="txtNOMBRE" id="txtNOMBRE" /></td>
  </tr>
  <tr>
    <td class="cuadro02">APELLIDO PATERNO</td>
    <td><input type="text" name="txtPATERNO" id="txtPATERNO" /></td>
    <td>&nbsp;</td>
    <td class="cuadro02">APELLIDO MATERNO</td>
    <td><input type="text" name="txtMATERNO" id="txtMATERNO" /></td>
  </tr>
</table>
<blockquote><label class="textosimple" >Nota: Si el RUT existe se completaran los datos automaticamente</label>
<input type="hidden" name="rut_alumno" id="rut_alumno" value="<?=$_POST['rut_alumno'];?>" />
<? 	
}


if($funcion==3){
	$rs_apo = $ob_Apoderado->BuscarApo($rut_apo);
	$fila = pg_fetch_array($rs_apo,0);
?>
<input type="hidden" name="hdDIG" id="hdDIG" value="<?=$fila['dig_rut'];?>" />
<input type="hidden" name="hdNOMBRE" id="hdNOMBRE" value="<?=trim($fila['nombre_apo']);?>" />
<input type="hidden" name="hdAPEPAT" id="hdAPEPAT" value="<?=trim($fila['ape_pat']);?>" />
<input type="hidden" name="hdAPEMAT" id="hdAPEMAT" value="<?=trim($fila['ape_mat']);?>" />
    
<?		
}


if($funcion==4){
	$result = $ob_Apoderado->GuardaApo($rut_apo,$dig_rut,$nombre_apo,$ape_pat,$ape_mat,$rut_alu);	
	
	if($result){
		echo 1;
	}else{
		echo 0;	
	}
}
?>