
<script>
//$('#fff').html();
//mostrar u ocultar formulario testigos accidente
function testigos(){
	var tipo =  $('#tipo_accidente').val();
	if(tipo == 1){
		 $('#listatestigos').css("display","block");
	}
	else{
		 $('#listatestigos').css("display","none");
		 $('#nom_testigo1').val("");
		 $('#rut_testigo1').val("");
		 $('#nom_testigo2').val("");
		 $('#rut_testigo2').val("");
	}
	
}

 function mfo(fo){
	 
	if(fo==0){
		$('#fff').html('<input name="foli" type="text" id="foli" value="0">');
		$('#foli').hide();
		
	}
	if(fo==1){
		
		 $.ajax({
				url:"folio.php",
				data:"ano="+<?php echo $ano ?>,
				type:'POST',
				success:function(data){
				$('#fff').html('<input name="foli" type="text" id="foli" value="'+data+'">');
		$('#foli').show();
		  }
		  
		}); 
		
		
	}

 }

</script>


<form method "post" action="#" name="form" id="form_agregar">
  <? 
  $ob_motor = new MotorBusqueda();
   $ob_motor->ano=$ano;
   $resultado_query_cue = $ob_motor->curso($conn);?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
 <tr>
   <td colspan="6" align="center" class="tableindex">&nbsp;Ingresar datos accidente</td>
   </tr>
 <tr class="cuadro01">
   <td colspan="6">&nbsp;</td>
   </tr>
 <tr class="cuadro01">
    <td width="124" class="textosimple">&nbsp;Curso</td>
    <td colspan="5">
    <select name="cmb_curso2" id="cmb_curso2"  class="ddlb_9_x" onChange="selAlumnosCurso();">
    <option value=0>(Seleccione Curso)</option>
    <?
      for($i=0 ; $i < @pg_numrows($resultado_query_cue) ;++$i)
      {
      $fila = @pg_fetch_array($resultado_query_cue,$i);
       
      if ($fila["id_curso"]==$cmb_curso){
            
            $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
            
            echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."                                                                      </option>";
      }else{
            
            $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
            echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
      }
      } ?>
  </select>
  </td>
  </tr>
  <tr class="cuadro01">
    <td class="textosimple">&nbsp;Alumno</td>
    <td colspan="5">
    <div id="alcurso">
      </div></td>
  </tr>
  <tr class="cuadro01">
    <td class="textosimple">&nbsp;Fecha</td>
    <td width="81" ><input name="fecha_accidente" type="text" id="fecha_accidente" size="12" readonly placeholder="Seleccione una fecha"></td>
    <td width="47" class="textosimple">Hora</td>
    <td width="68">
    <select name="hora_accidente" id="hora_accidente">
    <option value="00">00</option>
    <option value="01">01</option>
    <option value="02">02</option>
    <option value="03">03</option>
    <option value="04">04</option>
    <option value="05">05</option>
    <option value="06">06</option>
    <option value="07">07</option>
    <option value="08">08</option>
    <option value="09">09</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
    <option value="18">18</option>
    <option value="19">19</option>
    <option value="20">20</option>
    <option value="21">21</option>
    <option value="22">22</option>
    <option value="23">23</option>
    </select></td>
    <td width="51" class="textosimple">Minuto</td>
    <td width="279"><select name="minuto_accidente" id="minuto_accidente">
    <option value="00">00</option>
    <option value="01">01</option>
    <option value="02">02</option>
    <option value="03">03</option>
    <option value="04">04</option>
    <option value="05">05</option>
    <option value="06">06</option>
    <option value="07">07</option>
    <option value="08">08</option>
    <option value="09">09</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
    <option value="18">18</option>
    <option value="19">19</option>
    <option value="20">20</option>
    <option value="21">21</option>
    <option value="22">22</option>
    <option value="23">23</option>
    <option value="24">24</option>
    <option value="25">25</option>
    <option value="26">26</option>
    <option value="27">27</option>
    <option value="28">28</option>
    <option value="29">29</option>
    <option value="30">30</option>
    <option value="31">31</option>
    <option value="32">32</option>
    <option value="33">33</option>
    <option value="34">34</option>
    <option value="35">35</option>
    <option value="36">36</option>
    <option value="37">37</option>
    <option value="38">38</option>
    <option value="39">39</option>
    <option value="40">40</option>
    <option value="41">41</option>
    <option value="42">42</option>
    <option value="43">43</option>
    <option value="44">44</option>
    <option value="45">45</option>
    <option value="46">46</option>
    <option value="47">47</option>
    <option value="48">48</option>
    <option value="49">49</option>
    <option value="50">50</option>
    <option value="51">51</option>
    <option value="52">52</option>
    <option value="53">53</option>
    <option value="54">54</option>
    <option value="55">55</option>
    <option value="56">56</option>
    <option value="57">57</option>
    <option value="58">58</option>
    <option value="59">59</option>
    </select></td>
  </tr>
  <tr class="cuadro01">
    <td class="textosimple">&nbsp;D&iacute;a Accidente</td>
    <td><input name="diasemana_accidente" type="text" id="diasemana_accidente" size="2" readonly></td>
    <td class="textosimple">Tipo</td>
    <td colspan="3"><select name="tipo_accidente" id="tipo_accidente" onChange="testigos()">
      <option value="0">Seleccione</option>
      <option value="1">De Trayecto</option>
      <option value="2">En el establecimiento</option>
    </select></td>
    </tr>
  <tr class="cuadro01">
    <td class="textosimple">&nbsp;Foliar Declaraci&oacute;n</td>
    <td class="textosimple"><input type="radio" name="radio" id="f1" value="f1" onclick="mfo(1)" />
      SI 
      <input name="radio" type="radio" id="f2" onclick="mfo(0)" value="f2" checked="checked" />
      NO</td>
    <td colspan="4" class="cuadro01"><span id="fff"></span></td>
    </tr>
    <tr class="cuadro01"><td colspan="6">
    <div id="listatestigos" style="display:none"  >
    <table  border="0" cellpadding="0" cellspacing="0" >
  <tr class="cuadro01">
    <td width="95" class="textosimple">&nbsp;Nombre Testigo 1&nbsp;</td>
    <td colspan="2"><input name="nom_testigo1" type="text" id="nom_testigo1" size="50"></td>
    <td width="34" class="textosimple">&nbsp;RUT&nbsp;</td>
    <td width="72" colspan="2"><input name="rut_testigo1" type="text" id="rut_testigo1" size="12" maxlength="12" onBlur="valida_rut('#rut_testigo1')"></td>
    </tr>
  <tr class="cuadro01">
    <td class="textosimple">&nbsp;Nombre Testigo 2&nbsp;</td>
    <td colspan="2"><input name="nom_testigo2" type="text" id="nom_testigo2" size="50"></td>
    <td class="textosimple">&nbsp;RUT&nbsp;</td>
    <td colspan="2"><input name="rut_testigo2" type="text" id="rut_testigo2" size="12" maxlength="12" onBlur="valida_rut('#rut_testigo2')"></td>
    </tr>
    </table>
    </div>
    </td></tr>
    
  <tr>
    <td colspan="6"class="cuadro01">&nbsp;</td>
    </tr>
  <tr class="cuadro01">
    <td colspan="6" class="textosimple">&nbsp;Observaciones</td>
    </tr>
  <tr class="cuadro01">
    <td colspan="6"><label for="obs_accidente"></label>&nbsp;
      <textarea name="obs_accidente" cols="50" rows="5" id="obs_accidente" placeholder="(Describa c&oacute;mo ocurri&oacute; + causal)"></textarea></td>
    </tr>
  <tr>
    <td colspan="6" class="cuadro01">&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="6">&nbsp;<input type="button" name="guardaNuevo" id="guardaNuevo" value="Ingresar datos" onclick="guardarNuevo()" class="botonXX" />
      <input type="button" name="cancelar" id="cancelar" value="Cancelar" onclick="cancela()" class="botonXX"/></td>
  </tr>
</table>
</form >