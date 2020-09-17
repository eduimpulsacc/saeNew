<?php
include_once('mod_ficha_alumno.php');
//print_r($_POST);

$obj_familiar = new FichaAlumno();


?>


<div id="ingreso_familiar" style="width:102.2%; margin-left:-38px">
<table width="100%">
<tr>
<td>
<div id="rut_familiar" class="cuadro01" style="float:left">
Rut Familiar  :<br>
<input type="text" name="rut_fam" id="rut_fam">
-<input type="text" name="dig_rut_fam" id="dig_rut_fam" size="1" maxlength="1">
</div>
<div id="c_rut_familiar" class="cuadro01" style="float:left">
<br>
<input type="button" class="botonXX"  name="comprobar_rut" id="comprobar_rut" value="Comprobar rut" onClick="prueba_rut()">
<br>

</div>
<br>
<div id="div_volver" style="float:right" class="cuadro01"><input type="button" class="botonXX" name="btn_volver" id="btn_volver" value="Volver" onclick="volver()"></div>
<div id="guardar_apo" class="cuadro01"  style="float:right""><input type="button" class="botonXX" name="btn_guarda_apo" id="btn_guarda_apo" value="Guardar Relaci&oacute;n" onClick="guarda_familiar()"></div>
<div id="guardar_apo_nuevo" class="cuadro01"  style="float:right""><input type="button" class="botonXX" name="btn_guarda_apo_nuevo" id="btn_guarda_apo_nuevo" value="Guardar Datos" onClick="guarda_familiar_nuevo()"></div>


</td>
</tr>
</table>
<div id="carga_si_encuentra" style="width:105%" ></div>


</div>   