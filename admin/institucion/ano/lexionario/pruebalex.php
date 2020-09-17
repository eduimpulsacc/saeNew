<script language="JavaScript" type="text/JavaScript">


$(document).ready(function() {
$("#theDate").datepicker({
   showOn: 'both',
   
   dateFormat: 'dd/mm/yy' 
 }); 
 $.datepicker.regional['es']	
});

</script>
<?

require('../../../../util/header.inc');


	 
if($_REQUEST['ingresar']=="agregar"){
		$frmModo="ingresar";
	}

	 
if ($_REQUEST['frmModo']=="modificar"){
	$sql= "select lexionario.*, tipo_lexionario.nombre from lexionario INNER JOIN tipo_lexionario ON lexionario.tipo=tipo_lexionario.id_tipo where id_lexionario=$_REQUEST[id_lexionario]";
	$res_modificar = @pg_Exec($conn,$sql);
	$fila = @pg_fetch_array($res_modificar,0);
	$fecha = Cfecha($fila['fecha']);
	$descripcion = $fila['descripcion'];
	$tipo = $fila['tipo'];
	$nota = $fila['nota'];
	$curso = $fila['id_curso'];
	$ramo = $fila['id_ramo'];
	
}

$sql ="SELECT * FROM tipo_lexionario WHERE id_curso=$_REQUEST[id_curso] AND id_ramo=$_REQUEST[id_ramo]";
$rs_tipo = @pg_exec($conn,$sql);


	 
	 
	 
$TR="";

$TR .= 
"<table width='100%' align='center'>				 
	<td align='middle' colspan='6' class='tableindex'>Lexionario</td></tr></table>
<table class='textonegrita' >


		
<tr><td>Fecha Tipo<br> (DD/MM/YYYY): </td><td> 
";
if($frmModo=='modificar'){
	$TR .= "<input type='text' readonly name='theDate' id='theDate' value='$fecha'>";
 }else{
	
	$TR .= "<input type='text' readonly name='theDate' id='theDate' value='Seleccione'>";
 } 

		


if($frmModo=='agregar'){
$TR .= "<td>
<input class='botonXX' type='button' value='GUARDAR' name='btnGuardar' onClick='valida();'></td>

<td>
<input class='botonXX'  TYPE='button' value='VOLVER'  onClick='cargadatos(0)'></td>";
}

if($frmModo=='modificar'){
$TR .= "<td>
<input class='botonXX' type='button' value='MODIFICAR' name='btnModificar' 
onClick='validag($_REQUEST[id_lexionario]);'></td>
<td>
<input class='botonXX'  TYPE='button' value='VOLVER'  onClick='cargadatos(0)'></td>";
}

$TR .= "

<tr>
<td >TIPO:  </td>
<td >";
if($frmModo=='modificar'){

/*	switch ($tipo){
		case 1:
			$valor1="selected";
			break;
		case 2:
			$valor2="selected";
			break;
		case 3:
			$valor3="selected";
			break;
		case 4:
			$valor4="selected";
			break;
		case 5:
			$valor5="selected";
			break;
	}*/

$TR .= "<select id='cmb_tipo' name='cmb_tipo' class='textosimple'>
<option value=0 >(Seleccione Tipos)</option>";

for($i=0;$i<@pg_numrows($rs_tipo);$i++){
	$fila_tipo = @pg_fetch_array($rs_tipo,$i);

if($fila_tipo['id_tipo']==$tipo){
$TR.="<option value='".$fila_tipo['id_tipo']."' selected >".$fila_tipo['nombre']."</option>";
}else{
$TR.="<option value='".$fila_tipo['id_tipo']."'>".$fila_tipo['nombre']."</option>";
}

}
$TR.="</select>";


}else{

$TR .= "<select id='cmb_tipo' name='cmb_tipo' class='textosimple'>
<option value=0 selected>(Seleccione Tipo)</option>";
for($i=0;$i<@pg_numrows($rs_tipo);$i++){
	$fila_tipo = @pg_fetch_array($rs_tipo,$i);
$TR.="
	<option value='$fila_tipo[id_tipo]'>$fila_tipo[nombre]</option>";
}
$TR.="
</select><input class='botonXX'  TYPE='button' value='+'  onClick='abrirdialog()'></td>";	
 }
 
$TR .= "<span ></span></td>
	</tr>";

$TR .= "</tr>
<td> 
<tr>
<td nowrap='nowrap' >DESCRIPCI&Oacute;N:</td>
<td nowrap='nowrap'>";



 if($frmModo=='modificar'){
	$TR .= "<textarea name='txt_obser' id='txt_obser' cols='40' rows='5'>$descripcion</textarea>";
 }else{
	$TR .= "<textarea name='txt_obser' id='txt_obser' cols='40' rows='5'></textarea>";
 } 
$TR .= "</td>
</tr>";

$TR .= "
	<tr>
<td >CASILLERO:  </td>
<td  >";
if($frmModo=='modificar'){
switch ($nota){
		case 1:
			$cnota1="selected";
			break;
		case 2:
			$cnota2="selected";
			break;
		case 3:
			$cnota3="selected";
			break;
		case 4:
			$cnota4="selected";
			break;
		case 5:
			$cnota5="selected";
			break;
		case 6:
			$cnota6="selected";
			break;
		case 7:
			$cnota7="selected";
			break;
		case 8:
			$cnota8="selected";
			break;
		case 9:
			$cnota9="selected";
			break;
		case 10:
			$cnota10="selected";
			break;	
		case 11:
			$cnota11="selected";
			break;
		case 12:
			$cnota12="selected";
			break;
		case 13:
			$cnota13="selected";
			break;
		case 14:
			$cnota14="selected";
			break;
		case 15:
			$cnota15="selected";
			break;
		case 16:
			$cnota16="selected";
			break;
		case 17:
			$cnota17="selected";
			break;
		case 18:
			$cnota18="selected";
			break;
		case 19:
			$cnota19="selected";
			break;
		case 20:
			$cnota20="selected";
			break;	
	}

$TR .="<select id='cmb_nota' name='cmb_nota' class=''>
<option value=0 selected>(Seleccione Casillero)</option>
					
					<option value='01' $cnota1>01</option>
					<option value='02' $cnota2>02</option>
					<option value='03' $cnota3>03</option>
					<option value='04' $cnota4>04</option>
					<option value='05' $cnota5>05</option>
					<option value='05' $cnota6>06</option>
					<option value='07' $cnota7>07</option>
					<option value='08' $cnota8>08</option>
					<option value='09' $cnota9>09</option>
					<option value='10' $cnota10>10</option>
					<option value='11' $cnota11>11</option>
					<option value='12' $cnota12>12</option>
					<option value='13' $cnota13>13</option>
					<option value='14' $cnota14>14</option>
					<option value='15' $cnota15>15</option>
					<option value='16' $cnota16>16</option>
					<option value='17' $cnota17>17</option>
					<option value='18' $cnota18>18</option>
					<option value='19' $cnota19>19</option>
					<option value='20' $cnota20>20</option>
					
					</select>";
		}else{
		
		
	$TR .="<select id='cmb_nota' name='cmb_nota' class=''>
	<option value=0 selected>(Seleccione Casillero)</option>
					
					<option value='01'>01</option>
					<option value='02'>02</option>
					<option value='03'>03</option>
					<option value='04'>04</option>
					<option value='05'>05</option>
					<option value='06'>06</option>
					<option value='07'>07</option>
					<option value='08'>08</option>
					<option value='09'>09</option>
					<option value='10'>10</option>
					<option value='11'>11</option>
					<option value='12'>12</option>
					<option value='13'>13</option>
					<option value='14'>14</option>
					<option value='15'>15</option>
					<option value='16'>16</option>
					<option value='17'>17</option>
					<option value='18'>18</option>
					<option value='19'>19</option>
					<option value='20'>20</option>
					
</select>
  
  </td>
	</tr>
	
	<td >";
}

$TR .= "</table>";
 
echo $TR;


?>