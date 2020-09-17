
<form method "post" action="#" name="form" id="form_agregar">
  <? 
  $ob_motor = new MotorBusqueda();
   $ob_motor->ano=$ano;
   $resultado_query_cue = $ob_motor->curso($conn);?>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
 <tr>
   <td colspan="3" align="center" class="tableindex">&nbsp;Ingresar datos Entrevista</td>
   </tr>
 <tr class="cuadro01">
   <td colspan="3">&nbsp;</td>
   </tr>

 <tr class="cuadro01">
   <td class="textosimple">Entrevista a 
     </td>
   <td class="textosimple"><input type="radio" name="tipo" id="tipo_ap" value="2" onchange="cargalista()">
Apoderado
  <input type="radio" name="tipo" id="tipo_alu" value="2" onchange="cargalista()">
Alumno </td>
   <td class="textosimple">&nbsp;</td>
   </tr>
    <tr class="cuadro01">
    <td width="95" class="textosimple">&nbsp;Curso</td>
    <td colspan="2"><!--onChange="selAlumnosCurso();"-->
    <select name="cmb_curso2" id="cmb_curso2"  class="ddlb_9_x" onchange="cargalista()">
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
   <td class="textosimple">&nbsp;Nombre</td>
   <td class="textosimple"><div id="listentrevistado"></div></td>
   <td class="textosimple">&nbsp;</td>
 </tr>
  <tr class="cuadro01">
    <td class="textosimple">&nbsp;Fecha</td>
    <td width="223" ><input name="fecha_entrevista" type="text" id="fecha_entrevista" size="12" readonly placeholder="Seleccione una fecha"></td>
    <td width="332" class="textosimple">&nbsp;</td>
    </tr>
  <tr class="cuadro01">
    <td colspan="3" class="textosimple">&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3" class="textosimple">&nbsp;Observaciones</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3">&nbsp;
      <textarea name="obs_entrevista" cols="50" rows="5" id="obs_entrevista" placeholder="(Ingrese Observaciones)"></textarea></td>
    </tr>
  <tr class="cuadro01">
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3" class="textosimple">Acuerdos</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3">&nbsp;<textarea name="obs_acuerdos" cols="50" rows="5" id="obs_acuerdos" placeholder="(Ingrese Acuerdos)"></textarea></td>
  </tr>
  <tr>
    <td colspan="3" class="cuadro01">&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3">&nbsp;<input type="button" name="guardaNuevo" id="guardaNuevo" value="Ingresar datos" onclick="guardarNuevo()" class="botonXX" />
      <input type="button" name="cancelar" id="cancelar" value="Cancelar" onclick="cancela()" class="botonXX"/></td>
  </tr>
</table>
</form >