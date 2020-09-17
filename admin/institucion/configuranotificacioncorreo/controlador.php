<? require('../../../util/header.inc');


if($_POST['funcion']==1){

$institucion = $_INSTIT;
$tipoensenanza="NULL";

if($_POST['ense']!="")$tipoensenanza=$_POST['ense'];

$sql="SELECT * FROM notifica_correo_configuracion ncc 
WHERE ncc.rbd = $institucion AND ncc.tipo_ensenanza = $tipoensenanza";

$Rs_Config_EnvCorr = @pg_exec($conn,$sql);

if ( @pg_num_rows($Rs_Config_EnvCorr) > 0 ){

echo 'Configuran Existentes : <select  id="select5"  onChange="buscoregistro(this.value)" >
<option value="0" >Seleccionar Configuracion</option>';
     	
		$i = 0;

		while ( $i < pg_num_rows($Rs_Config_EnvCorr) ){
		
		$Fila_Config_EnvCorr = pg_fetch_array($Rs_Config_EnvCorr,$i);
	
	   echo '<option value="'.$Fila_Config_EnvCorr ['id_notifica_correo_configuracion'].'">'.trim($Fila_Config_EnvCorr ['nombre_configuracion']).'</option>';
	   
	   $i++; 
	   
	   }	 
		   
echo '</select>';

}else{
	
	echo 1;
	
	
	}

 } // FUN 1


if($_POST['funcion']==2){
	
	$institucion = $_INSTIT;
	$tipoensenanza="NULL";
	if($_POST['tipoensenanza']!="")$tipoensenanza=$_POST['tipoensenanza'];

echo '<table width="100%" height="auto" border="1" cellpadding="1" cellspacing="1" style="border-collapse:collapse;">';

$sql = "SELECT ncc.notifica_notas FROM  notifica_correo_configuracion as ncc 
WHERE ncc.rbd = $institucion  AND ncc.tipo_ensenanza = $tipoensenanza  AND ncc.notifica_notas = 1";
$Rs = @pg_exec($conn,$sql);

if(pg_num_rows($Rs)==0){
	
	echo '<!--INICIO-->
			  <tr>
			  <td width="25%" height="95" rowspan="2" bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;">
				  Notificaci&oacute;n por Notas  </td>
				  <td width="12%" rowspan="2" bgcolor="#FFFFCC" style="padding-left: 25px;"  >
				  <input name="checkboxnotas" type="checkbox" id="checkboxnotas" value="1">
				  </td>
				  <td colspan="2" bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;"  >Cantidad de Notas : 
					<input name="cant_notas" type="text" id="cant_notas" 
					onpaste="return false" value="" size="4" maxlength="2" onKeyPress="return NO_letra(event)" >
					</td>
				  <td width="20%" rowspan="2" bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;"  >&nbsp;</td>
				</tr>
				<tr>
				  <td colspan="2" bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;"  >Nota Deficiente : 
					<input name="nota_def" type="text" id="nota_def" 
					onpaste="return false" value="" size="4" maxlength="2" onKeyPress="return NO_letra(event)" >
				  </td>
				  </tr>
				<!--TERMINO-->';
	
	     }

$sql = "SELECT ncc.notifica_asistencia FROM notifica_correo_configuracion as ncc 
WHERE ncc.rbd = $institucion  AND ncc.tipo_ensenanza = $tipoensenanza AND ncc.notifica_asistencia = 1";
$Rs = @pg_exec($conn,$sql);
if(pg_num_rows($Rs)==0){

	  echo '<!--INICIO-->
				<tr>
				  <td rowspan="2" height="95" class="textosimple" style="padding-left: 25px;" >
				  Notificaci&oacute;n por Asistencia 
				  </td>
				  <td rowspan="2" style="padding-left: 25px;"  >
				  <input name="checkboxAsistencia" type="checkbox"  id="checkboxAsistencia" value="1" >
				  </td>
				  <td style="padding-left: 25px;"  colspan="2" class="textosimple">Dias a Notificar : 
					<input name="dias_not" type="text" id="dias_not" 
					onpaste="return false" value="" size="4" maxlength="2" onKeyPress="return NO_letra(event)" >
					</td>
				  <td rowspan="2" class="textosimple" style="padding-left: 25px;">&nbsp;</td>
				</tr>
				<tr>
				  <td style="padding-left: 25px;"  colspan="2" class="textosimple">Periodo : 
					<select name="selec_periodo" id="selec_periodo">
					  <option value="0" selected="selected" >Seleccionar</option>
					  <option value="1">Semanal</option>
					  <option value="2">Quinsenal</option>
					  <option value="3">Mensual</option>
					</select>
				  </td>
				</tr>
				<!--TERMINO-->';	
	
	      }


$sql = "SELECT ncc.notifica_anotaciones FROM  notifica_correo_configuracion as ncc  
WHERE ncc.rbd = $institucion  AND ncc.tipo_ensenanza = $tipoensenanza  AND ncc.notifica_anotaciones = 1";
$Rs = @pg_exec($conn,$sql);

if(pg_num_rows($Rs)==0){
	
	      echo '<!--INICIO-->  
				<tr>
				  <td height="95" bgcolor="#FFFFCC"  class="textosimple" style="padding-left: 25px;" >Notificaci&oacute;n por Anotaci&oacute;nes    </td>
				  <td bgcolor="#FFFFCC" style="padding-left: 25px;"  ><input name="checkboxAnotaciones" type="checkbox" id="checkboxAnotaciones" value="1"></td>
				  <td  colspan="2" bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;">Cantidad Anotaci&oacute;nes : 
					<input name="cant_anot" type="text" id="cant_anot" 
					onpaste="return false" value="" size="4" maxlength="2" onKeyPress="return NO_letra(event)" >
					</td>
				  <td bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;">&nbsp;</td>
				</tr>
				<tr>
				  <td height="39" colspan="6">&nbsp;</td>
				  </tr>
				<!--TERMINO-->';
	   }
	   
	   	   echo "</table>";

	   echo "<br/>";
	   
	   echo '<table width="100%"><tr class="tablatit2-1">
				<td height="59" colspan="6" align="left">
				<div  style=" text-align:center; padding-top:15px;">
				<input class="botonXX" type="button"  value="Nuevo" onClick="nuevo()">
				<input class="botonXX" type="button"  value="Guardar" onClick="guardar()">
				</div>
				</td>
				</tr>
				<tr class="tablatit2-1">
				  <td colspan="6">&nbsp;</td>
				</tr>
				</table> ';
	
			}

?>