<? 

require('../../../../../util/header.inc');
include('../../../../clases/class_Reporte.php');
include('../../../../clases/class_MotorBusqueda.php');

foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
  // echo $asignacion."<br>";
}

$ob_reporte = new Reporte();
$ob_motor = new MotorBusqueda();


 //datos accidente
		$sql =" select *  from declaracion_accidente where id_accidente = ".$id_accidente;
		$result = @pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql); 
		
		$fila = @pg_fetch_array($result,0);
		
		
function CambioFechaDisplay($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m."/".$a;
	else
		$retorno="";
	return $retorno;
}
  
?>

<script>



//mostrar u ocultar formulario testigos accidente
function testigos2(){
	var tipo =  $('#tipo_accidente2').val();
	if(tipo == 1){
		 $('#listatestigos2').css("display","block");
	}
	else{
		 $('#listatestigos2').css("display","none");
		 $('#nom_testigo12').val("");
		 $('#rut_testigo12').val("");
		 $('#nom_testigo22').val("");
		 $('#rut_testigo22').val("");
	}
	
}

$(document).ready(function() {
	
	
	
$( "#fecha_accidente2" ).datepicker({
    'dateFormat':'dd-mm-yy',
	firstDay: 1,
	yearRange: "2000:<?php echo date("Y") ?>",
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ],
    onSelect: function(dateText){
        var seldate = $(this).datepicker('getDate');
        seldate = seldate.toDateString();
        seldate = seldate.split(' ');
        var weekday=new Array();
            weekday['Mon']="1";
            weekday['Tue']="2";
            weekday['Wed']="3";
            weekday['Thu']="4";
            weekday['Fri']="5";
            weekday['Sat']="6";
            weekday['Sun']="7";
        var dayOfWeek = weekday[seldate[0]];
		 $('#diasemana_accidente2').val(dayOfWeek);
		 
    }
	
});

$.datepicker.regional['es']	


});

</script>

<form method "post" action="#" name="form" id="form_editar">
<input name="id_accidente" type="hidden" id="id_accidente" value="<?php echo $fila['id_accidente']; ?>"   />
<table border="0" cellpadding="0" cellspacing="0" width="650" class="cajaborde" align="center">
  <tr>
    <td colspan="6" class="tableindex">&nbsp;Editar Datos Accidente</td>
    </tr>
  <tr class="cuadro01">
    <td colspan="6" >&nbsp;</td>
    </tr>
  <tr class="cuadro01">
    <td width="97">&nbsp;Curso</td>
    <td colspan="5"><input name="hidden_curso" type="hidden" id="hidden_curso" value="<?php echo $fila['id_curso']; ?>"   />
	<input name="hidden_anio" type="hidden" id="hidden_anio" value="<?php echo $fila['id_ano']; ?>"   />
	<? echo CursoPalabra($fila['id_curso'],0,$conn);?></td>
  </tr>
  <tr class="cuadro01">
    <td>&nbsp;Alumno</td>
    <td colspan="5"><?php 
		$ob_reporte->ano=$fila['id_ano'];
		$ob_reporte->curso=$fila['id_curso'];
		$ob_reporte->alumno=$fila['rut_alumno'];
		$result_alumno = $ob_reporte->TraeUnAlumno($conn);
		$fila_alumno = @pg_fetch_array($result_alumno,0);
		$nombre_alumno = ucwords(strtoupper($fila_alumno['ape_pat'] . " " . $fila_alumno['ape_mat'] . " 
		" . $fila_alumno['nombre_alu']));
	
	echo $nombre_alumno; ?></td>
  </tr>
  <tr class="cuadro01">
    <td>&nbsp;Fecha</td>
    <td width="106"><input name="fecha_accidente2" type="text" id="fecha_accidente2" size="12" readonly placeholder="Seleccione una fecha" value="<?php echo CambioFechaDisplay($fila['fecha'])?>"></td>
    <td width="45">Hora</td>
    <td width="63">
    <select name="hora_accidente2" id="hora_accidente2">
    <option value="00" <?php echo ($fila['hora']==0)?"selected":""; ?> >00</option>
    <option value="01" <?php echo ($fila['hora']==1)?"selected":""; ?>>01</option>
    <option value="02" <?php echo ($fila['hora']==2)?"selected":""; ?>>02</option>
    <option value="03" <?php echo ($fila['hora']==3)?"selected":""; ?>>03</option>
    <option value="04" <?php echo ($fila['hora']==4)?"selected":"";?>>04</option>
    <option value="05" <?php echo ($fila['hora']==5)?"selected":"" ?>>05</option>
    <option value="06" <?php echo ($fila['hora']==6)?"selected":"" ?>>06</option>
    <option value="07" <?php echo ($fila['hora']==6)?"selected":"" ?>>07</option>
    <option value="08" <?php echo ($fila['hora']==8)?"selected":"" ?>>08</option>
    <option value="09" <?php echo ($fila['hora']==9)?"selected":"" ?>>09</option>
    <option value="10" <?php echo ($fila['hora']==10)?"selected":"" ?>>10</option>
    <option value="11" <?php echo ($fila['hora']==11)?"selected":"" ?>>11</option>
    <option value="12" <?php echo ($fila['hora']==12)?"selected":"" ?>>12</option>
    <option value="13" <?php echo ($fila['hora']==13)?"selected":"" ?>>13</option>
    <option value="14" <?php echo ($fila['hora']==14)?"selected":"" ?>>14</option>
    <option value="15" <?php echo ($fila['hora']==15)?"selected":"" ?>>15</option>
    <option value="16" <?php echo ($fila['hora']==16)?"selected":"" ?>>16</option>
    <option value="17" <?php echo ($fila['hora']==17)?"selected":"" ?>>17</option>
    <option value="18" <?php echo ($fila['hora']==18)?"selected":"" ?>>18</option>
    <option value="19" <?php echo ($fila['hora']==19)?"selected":"" ?>>19</option>
    <option value="20" <?php echo ($fila['hora']==20)?"selected":"" ?>>20</option>
    <option value="21" <?php echo ($fila['hora']==21)?"selected":"" ?>>21</option>
    <option value="22" <?php echo ($fila['hora']==22)?"selected":"" ?>>22</option>
    <option value="23" <?php echo ($fila['hora']==23)?"selected":"" ?>>23</option>
    </select></td>
    <td width="48">Minuto</td>
    <td width="291"><select name="minuto_accidente2" id="minuto_accidente2">
    <option value="00" <?php echo ($fila['minuto']==0)?"selected":"" ?>>00</option>
    <option value="01" <?php echo ($fila['minuto']==1)?"selected":"" ?>>01</option>
    <option value="02" <?php echo ($fila['minuto']==2)?"selected":"" ?>>02</option>
    <option value="03" <?php echo ($fila['minuto']==3)?"selected":"" ?>>03</option>
    <option value="04" <?php echo ($fila['minuto']==4)?"selected":"" ?>>04</option>
    <option value="05" <?php echo ($fila['minuto']==5)?"selected":"" ?>>05</option>
    <option value="06" <?php echo ($fila['minuto']==6)?"selected":"" ?>>06</option>
    <option value="07" <?php echo ($fila['minuto']==7)?"selected":"" ?>>07</option>
    <option value="08" <?php echo ($fila['minuto']==8)?"selected":"" ?>>08</option>
    <option value="09" <?php echo ($fila['minuto']==9)?"selected":"" ?>>09</option>
    <option value="10" <?php echo ($fila['minuto']==10)?"selected":"" ?>>10</option>
    <option value="11" <?php echo ($fila['minuto']==11)?"selected":"" ?>>11</option>
    <option value="12" <?php echo ($fila['minuto']==12)?"selected":"" ?>>12</option>
    <option value="13" <?php echo ($fila['minuto']==13)?"selected":"" ?>>13</option>
    <option value="14" <?php echo ($fila['minuto']==14)?"selected":"" ?>>14</option>
    <option value="15" <?php echo ($fila['minuto']==15)?"selected":"" ?>>15</option>
    <option value="16" <?php echo ($fila['minuto']==16)?"selected":"" ?>>16</option>
    <option value="17" <?php echo ($fila['minuto']==17)?"selected":"" ?>>17</option>
    <option value="18" <?php echo ($fila['minuto']==18)?"selected":"" ?>>18</option>
    <option value="19" <?php echo ($fila['minuto']==19)?"selected":"" ?>>19</option>
    <option value="20" <?php echo ($fila['minuto']==20)?"selected":"" ?>>20</option>
    <option value="21" <?php echo ($fila['minuto']==21)?"selected":"" ?>>21</option>
    <option value="22" <?php echo ($fila['minuto']==22)?"selected":"" ?>>22</option>
    <option value="23" <?php echo ($fila['minuto']==23)?"selected":"" ?>>23</option>
    <option value="24" <?php echo ($fila['minuto']==24)?"selected":"" ?>>24</option>
    <option value="25" <?php echo ($fila['minuto']==25)?"selected":"" ?>>25</option>
    <option value="26" <?php echo ($fila['minuto']==26)?"selected":"" ?>>26</option>
    <option value="27" <?php echo ($fila['minuto']==27)?"selected":"" ?>>27</option>
    <option value="28" <?php echo ($fila['minuto']==28)?"selected":"" ?>>28</option>
    <option value="29" <?php echo ($fila['minuto']==29)?"selected":"" ?>>29</option>
    <option value="30" <?php echo ($fila['minuto']==30)?"selected":"" ?>>30</option>
    <option value="31" <?php echo ($fila['minuto']==31)?"selected":"" ?>>31</option>
    <option value="32" <?php echo ($fila['minuto']==32)?"selected":"" ?>>32</option>
    <option value="33" <?php echo ($fila['minuto']==33)?"selected":"" ?>>33</option>
    <option value="34" <?php echo ($fila['minuto']==34)?"selected":"" ?>>34</option>
    <option value="35" <?php echo ($fila['minuto']==35)?"selected":"" ?>>35</option>
    <option value="36" <?php echo ($fila['minuto']==36)?"selected":"" ?>>36</option>
    <option value="37" <?php echo ($fila['minuto']==37)?"selected":"" ?>>37</option>
    <option value="38" <?php echo ($fila['minuto']==38)?"selected":"" ?>>38</option>
    <option value="39" <?php echo ($fila['minuto']==39)?"selected":"" ?>>39</option>
    <option value="40" <?php echo ($fila['minuto']==40)?"selected":"" ?>>40</option>
    <option value="41" <?php echo ($fila['minuto']==41)?"selected":"" ?>>41</option>
    <option value="42" <?php echo ($fila['minuto']==42)?"selected":"" ?>>42</option>
    <option value="43" <?php echo ($fila['minuto']==43)?"selected":"" ?>>43</option>
    <option value="44" <?php echo ($fila['minuto']==44)?"selected":"" ?>>44</option>
    <option value="45" <?php echo ($fila['minuto']==45)?"selected":"" ?>>45</option>
    <option value="46" <?php echo ($fila['minuto']==46)?"selected":"" ?>>46</option>
    <option value="47" <?php echo ($fila['minuto']==47)?"selected":"" ?>>47</option>
    <option value="48" <?php echo ($fila['minuto']==48)?"selected":"" ?>>48</option>
    <option value="49" <?php echo ($fila['minuto']==49)?"selected":"" ?>>49</option>
    <option value="50" <?php echo ($fila['minuto']==50)?"selected":"" ?>>50</option>
    <option value="51" <?php echo ($fila['minuto']==51)?"selected":"" ?>>51</option>
    <option value="52" <?php echo ($fila['minuto']==52)?"selected":"" ?>>52</option>
    <option value="53" <?php echo ($fila['minuto']==53)?"selected":"" ?>>53</option>
    <option value="54" <?php echo ($fila['minuto']==54)?"selected":"" ?>>54</option>
    <option value="55" <?php echo ($fila['minuto']==55)?"selected":"" ?>>55</option>
    <option value="56" <?php echo ($fila['minuto']==56)?"selected":"" ?>>56</option>
    <option value="57" <?php echo ($fila['minuto']==57)?"selected":"" ?>>57</option>
    <option value="58" <?php echo ($fila['minuto']==58)?"selected":"" ?>>58</option>
    <option value="59" <?php echo ($fila['minuto']==59)?"selected":"" ?>>59</option>
    </select></td>
  </tr>
  <tr class="cuadro01">
    <td>&nbsp;D&iacute;a Accidente</td>
    <td><input name="diasemana_accidente2" type="text" id="diasemana_accidente2" size="5" readonly value="<?php echo $fila['dia_accidente']; ?>"></td>
    <td>Tipo</td>
    <td colspan="3"><select name="tipo_accidente2" id="tipo_accidente2" onChange="testigos2()">
      <option value="0">Seleccione</option>
      <option value="1" <?php echo ($fila['tipo']==1)?"selected":"" ?>>De Trayecto</option>
      <option value="2" <?php echo ($fila['tipo']==2)?"selected":"" ?>>En el establecimiento</option>
    </select></td>
    </tr>
  <tr class="cuadro01">
    <td colspan="6">&nbsp;</td>
    </tr>
    <tr class="cuadro01"><td colspan="6"><!--style="display:none"--> 
    <div id="listatestigos2" <?php echo ($fila['tipo']!=1)?"style=\"display:none\"":"" ?>>
    <table border="0" cellpadding="0" cellspacing="0">
  <tr class="cuadro01">
    <td width="110">&nbsp;Nombre Testigo 1</td>
    <td colspan="2"><input name="nom_testigo12" type="text" id="nom_testigo12" value="<?php echo $fila['nombre_testigo1']; ?>" size="50"></td>
    <td>&nbsp;RUT&nbsp;</td>
    <td colspan="2"><input name="rut_testigo12" type="text" id="rut_testigo12" size="12" maxlength="12" value="<?php echo $fila['rut_testigo1']; ?>" onBlur="valida_rut('#rut_testigo12')"></td>
    </tr>
  <tr class="cuadro01">
    <td>&nbsp;Nombre Testigo 2</td>
    <td colspan="2"><input name="nom_testigo22" type="text" id="nom_testigo22" value="<?php echo $fila['nombre_testigo2']; ?>" size="50"></td>
    <td>&nbsp;RUT&nbsp;</td>
    <td colspan="2"><input name="rut_testigo22" type="text" id="rut_testigo22" size="12" maxlength="12" value="<?php echo $fila['rut_testigo2']; ?>" onBlur="valida_rut('#rut_testigo22')"></td>
    </tr>
    </table>
    </div>
    </td></tr>
    
  <tr class="cuadro01">
    <td colspan="6">&nbsp;</td>
    </tr>
  <tr class="cuadro01">
    <td colspan="6" >&nbsp;Observaciones</td>
    </tr>
  <tr class="cuadro01">
    <td colspan="6">&nbsp;<label for="obs_accidente2"></label>
      <textarea name="obs_accidente2" cols="50" rows="5" id="obs_accidente2" placeholder="(Describa c&oacute;mo ocurri&oacute; + causal)"><?php echo $fila['observaciones']; ?></textarea></td>
    </tr>
  <tr class="cuadro01">
    <td colspan="6">&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="6">&nbsp;<input type="button" name="guardaEdita" id="guardaEdita" value="Actualizar Datos" onclick="guardarEditar()" />
      <input type="button" name="cancelar" id="cancelar" value="Cancelar" onclick="cancela()" /></td>
  </tr>
</table>
</form >
