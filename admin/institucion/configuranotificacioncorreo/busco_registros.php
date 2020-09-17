<? require('../../../util/header.inc');

$institucion = $_INSTIT;
$tipoensenanza="NULL";
$idconfig = "NULL";

if($_POST['tipoensenanza']!="")$tipoensenanza=$_POST['tipoensenanza'];

if($_POST['idconfig']!="")$idconfig=$_POST['idconfig'];

$sql="SELECT * FROM notifica_correo_configuracion ncc  WHERE 
			ncc.rbd = $institucion AND ncc.tipo_ensenanza = $tipoensenanza 
			AND id_notifica_correo_configuracion = $idconfig ";

$rs_ncc = @pg_exec($conn,$sql);

if ( @pg_num_rows($rs_ncc) > 0 ){

$reg_enc = pg_fetch_array($rs_ncc,0);

//<input name="" type="hidden" value="">

echo '<table width="100%" height="auto" border="1" cellpadding="1" cellspacing="1" style="border-collapse:collapse;">';

if($reg_enc['notifica_notas']==1){
	
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
				  <td width="20%" rowspan="2" bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;"  >LIBERAR&nbsp;</td>
				</tr>
				<tr>
				  <td colspan="2" bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;"  >Nota Deficiente : 
					<input name="nota_def" type="text" id="nota_def" 
					onpaste="return false" value="" size="4" maxlength="2" onKeyPress="return NO_letra(event)" >
				  </td>
				  </tr>
				<!--TERMINO-->';
	
	     }

if($reg_enc['notifica_asistencia']==1){
      
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
				  <td rowspan="2" class="textosimple" style="padding-left: 25px;">LIBERAR&nbsp;</td>
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

if($reg_enc['notifica_anotaciones']==1){
	
	      echo '<!--INICIO-->  
				<tr>
				  <td height="95" bgcolor="#FFFFCC"  class="textosimple" style="padding-left: 25px;" >Notificaci&oacute;n por Anotaci&oacute;nes    </td>
				  <td bgcolor="#FFFFCC" style="padding-left: 25px;"  ><input name="checkboxAnotaciones" type="checkbox" id="checkboxAnotaciones" value="1"></td>
				  <td  colspan="2" bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;">Cantidad Anotaci&oacute;nes : 
					<input name="cant_anot" type="text" id="cant_anot" 
					onpaste="return false" value="" size="4" maxlength="2" onKeyPress="return NO_letra(event)" >
					</td>
				  <td bgcolor="#FFFFCC" class="textosimple" style="padding-left: 25px;">LIBERAR&nbsp;</td>
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
				<input class="botonXX" type="button"  value="Modificar" onClick="guardar()">
				</div>
				</td>
				</tr>
				<tr class="tablatit2-1">
				  <td colspan="6">&nbsp;</td>
				</tr>
				</table> ';

echo $respuesta = '
<input id="hidden_id_notifica_correo_configuracion" type="hidden" value="'.$reg_enc['id_notifica_correo_configuracion'].'">
<input id="hidden_nombre_configuracion" type="hidden" value="'.$reg_enc['nombre_configuracion'].'">
<input id="hidden_rbd" type="hidden" value="'.$reg_enc['rbd'].'">
<input id="hidden_tipo_ensenanza" type="hidden" value="'.$reg_enc['tipo_ense?anza'].'">
<input id="hidden_cargo" type="hidden" value="'.$reg_enc['cargo'].'">
<input id="hidden_notifica_notas" type="hidden" value="'.$reg_enc['notifica_notas'].'">
<input id="hidden_nro_notas" type="hidden" value="'.$reg_enc['nro_notas'].'">
<input id="hidden_nota_deficiente" type="hidden" value="'.$reg_enc['nota_deficiente'].'">
<input id="hidden_notifica_anotaciones" type="hidden" value="'.$reg_enc['notifica_anotaciones'].'">
<input id="hidden_nro_anotaciones" type="hidden" value="'.$reg_enc['nro_anotaciones'].'">
<input id="hidden_notifica_asistencia" type="hidden" value="'.$reg_enc['notifica_asistencia'].'">
<input id="hidden_dias_asistencia" type="hidden" value="'.$reg_enc['dias_asistencia'].'">
<input id="hidden_periodo_notificacion" type="hidden" value="'.$reg_enc['periodo_notificacion'].'">';

 
 }else{ 
 	echo 1; 
 }
?>



