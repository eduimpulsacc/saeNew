<?php 

require('../../../../../util/header.inc');
session_start();
require "mod_infespecial.php";
$obj_infespecial = new Infespecial();

$funcion = $_POST['funcion'];
if($funcion==1){
//var_dump($_POST);
$rs_anos = $obj_infespecial->ano($conn,$rdb);
?>
<select name="cmb_ano" id="cmb_ano" onChange="periodo(this.value),curso(this.value)">
        <option value="0">seleccione...</option>
        <?php for($i=0;$i<pg_numrows($rs_anos);$i++){
			$fila_ano = pg_fetch_array($rs_anos,$i);
			?>
        <option value="<?php echo $fila_ano['id_ano'] ?>"><?php echo $fila_ano['nro_ano'] ?></option>
        <?php }?>
      </select>
<?
}if($funcion==2){
	$rs_periodo = $obj_infespecial->periodo($conn,$ano);
	?>
    <select name="cmb_periodo" id="cmb_periodo">
      <option value="0">seleccione...</option>
       <?php for($i=0;$i<pg_numrows($rs_periodo);$i++){
			$fila_periodo = pg_fetch_array($rs_periodo,$i);
			?>
        <option value="<?php echo $fila_periodo['id_periodo'] ?>"><?php echo $fila_periodo['nombre_periodo'] ?></option>
        <?php }?>
    </select>
<?php }
if($funcion==3){
	$rs_curso = $obj_infespecial->curso($conn,$ano);
?>
<select name="cmb_curso" id="cmb_curso" onChange="alumno(this.value)">
        <option value="0">seleccione...</option>
        <?php for($i=0;$i<pg_numrows($rs_curso);$i++){
			$fila_curso = pg_fetch_array($rs_curso,$i);
			?>
        <option value="<?php echo $fila_curso['id_curso'] ?>"><?php echo $fila_curso['curso'] ?></option>
        <?php }?>
      </select>
<?php }
if($funcion==4){
	$rs_alumno = $obj_infespecial->alumno($conn,$curso);
?>
<select name="cmb_alumno" id="cmb_alumno" onchange="cargaReporte()">
        <option value="0">seleccione...</option>
         <?php for($i=0;$i<pg_numrows($rs_alumno);$i++){
			$fila_alumno = pg_fetch_array($rs_alumno,$i);
			?>
        <option value="<?php echo $fila_alumno['rut_alumno'] ?>"><?php echo $fila_alumno['nombre'] ?></option>
        <?php }?>
      </select>
<?php }
if($funcion==5){
//var_dump($_POST);
 $rs_inf = $obj_infespecial->traeEntrevista($conn,$anio,$periodo,$curso,$alumno);

?>
<table width="90%" border="0" align="center" cellspacing="0">
  <tr>
    <td colspan="2" align="center" class="tableindex"><div align="center">Evaluaci&oacute;n Diagn&oacute;stica Integral de Necesidades Educativas Especiales</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td width="16%">&nbsp;</td>
    <td width="84%" align="right"><?php if (pg_numrows($rs_inf)==0){ ?><input type="button" value="Ingresar" onclick="nuevoInf()" class="botonXX" /><?php }?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
 
  <tr >
    <td colspan="2" valign="top">
     <?php if (pg_numrows($rs_inf)>0){ ?>
      <table width="100%" border="0" cellspacing="0">
        <tr class="tableindex">
          <td width="16%">FECHA ENTREGA INFORME</td>
          <td width="28%">FECHA PR&Oacute;XIMA EVALUACI&Oacute;N</td>
          <td width="41%">RESPONSABLE INFORMACI&Oacute;N</td>
          <td width="15%">&nbsp;</td>
        </tr>
       <?php  for($in=0;$in<pg_numrows($rs_inf);$in++){
		   $fila = pg_fetch_array($rs_inf,$in);
		   $rs_emp = $obj_infespecial->empleado1($conn,$fila['rut_emp']);
		   
		   $nom_doc = pg_result($rs_emp,2)." ".pg_result($rs_emp,3)." ".pg_result($rs_emp,4);
		   
		   ?>
        <tr class="textosimple" onclick="buscaReporte(<?php echo $fila['id_necesidad'] ?>)" style="cursor:pointer" onmouseover="this.style.background='yellow';" onmouseout="this.style.background='white';">
          <td align="center"  onclick="buscaReporte(<?php echo $fila['id_necesidad'] ?>)"><?php echo CambioFD($fila['fecha_entrega']) ?></td>
          <td align="center"  onclick="buscaReporte(<?php echo $fila['id_necesidad'] ?>)"><?php echo CambioFD($fila['prox_evaluacion']) ?></td>
          <td align="center"  onclick="buscaReporte(<?php echo $fila['id_necesidad'] ?>)"><?php echo $nom_doc ?></td>
          <td><input type="button" name="button" id="button" value="Eliminar" onclick="eliminaReporte(<?php echo $fila['id_necesidad'] ?>)" class="botonXX" /></td>
        </tr>
        <?php  } ?>
    </table>
	
	<?php }?></td>
  </tr>
  
  <tr>
    <td colspan="2">
    
    </td>
  </tr>
</table>


<?php }
if($funcion==6){
	//var_dump($_POST);
	$rs_emp = $obj_infespecial->empleado($conn,$rdb);
	
	?>
    <script>
$(document).ready(function(){
	
				
	$("#fecha_entrega, #prox_evaluacion").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			/*minDate: new Date('01/01/'+anio+''),
			maxDate: new Date('12/31/'+anio+''),*/
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});
		
		
		

  });
  
 
	

  </script>
    <table width="90%" border="0" align="center" cellspacing="0">
  <tr>
    <td colspan="2" align="center" class="tableindex"><div align="center">Ingreso Evaluaci&oacute;n Diagn&oacute;stica Integral de Necesidades Educativas Especiales</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td width="16%">&nbsp;</td>
    <td width="84%" align="right"><input type="button" value="Guardar" onclick="guardanuevoInf()" class="botonXX" />
    <input type="button" value="Cancelar" onclick="atras()" class="botonXX" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr  class="tableindex">
    <td colspan="2">IDENTIFICACI&Oacute;N DEL PROFESIONAL DEL ESTABLECIMIENTO ESCOLAR QUE ENTREGA LA INFORMACI&Oacute;N</td>
    </tr>
  <tr>
    <td colspan="2">
    <select name="cmb_empleado" id="cmb_empleado">
    <option value="0">seleccione...</option>
   <?php for($e=0;$e<pg_numrows($rs_emp);$e++){
	   $fila_emp= pg_fetch_array($rs_emp,$e);
	   ?>
    <option value="<?php echo $fila_emp['rut_emp'] ?>"><?php echo $fila_emp['nombre_emp'] ?> <?php echo $fila_emp['ape_pat'] ?> <?php echo $fila_emp['ape_mat'] ?></option>
    <?php }?>
    </select></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr  class="tableindex">
    <td colspan="2">IDENTIFICACI&Oacute;N DE LA PERSONA QUE RECIBE LA INFORMACI&Oacute;N</td>
    </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0">
      <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr class="textonegrita">
        <td width="21%">Nombre</td>
        <td><input name="nombre_recibe" type="text" id="nombre_recibe" size="70" /></td>
        </tr>
      <tr class="textonegrita">
        <td>Rut</td>
        <td><input type="text" name="rut_recibe" id="rut_recibe" onchange="javascript:return Rut(document.formu.rut_recibe.value)" /></td>
        </tr>
      <tr class="textonegrita">
        <td>Relaci&oacute;n con el/la estudiante</td>
        <td><input type="text" name="relacion_recibe" id="relacion_recibe" /></td>
        </tr>
      <tr>
        <td colspan="2"><input name="interprete_recibe" type="text" id="interprete_recibe" size="70" /></td>
      </tr>
      <tr class="textonegrita">
        <td colspan="2">En presencia de (miembro de la familia, int&eacute;prete, otro/a)</td>
        </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr  class="tableindex">
    <td colspan="2">RESULTADOS DE LA EVALUACI&Oacute;N</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita">Tipo de Evaluaci&oacuten</td>
    <td class="textosimple"><input type="radio" name="tipo_eval" id="tipo_eval0" value="1" class="cl"  />
    Ingreso 
      <input type="radio" name="tipo_eval" id="tipo_eval1" value="2" class="cl" />
    Reevaluaci&oacuten</td>
  </tr>
  <tr>
    <td class="textonegrita">Observaciones</td>
    <td><textarea name="motivo_evaluacion" cols="40" rows="5" id="motivo_evaluacion"></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="tableindex">
    <td>DIAGN&Oacute;STICO</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><textarea name="diagnostico" cols="80" rows="5" id="diagnostico"></textarea></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr  class="tableindex">
    <td colspan="2">FORTALEZAS Y NECESIDADES DE APOYO EN CADA &Aacute;MBITO</td>
    </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" class="textonegrita">
      <tr class="tableindex">
        <td colspan="2">AMBITO ACADEMICO</td>
        </tr>
      <tr  class="textonegrita">
        <td>FORTALEZAS</td>
        <td>NECESIDADES DE APOYO</td>
      </tr>
      <tr>
        <td><textarea name="academico_fortaleza" cols="40" rows="5" id="academico_fortaleza"></textarea></td>
        <td><textarea name="academico_necesidad" cols="40" rows="5" id="academico_necesidad"></textarea></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" >
      <tr class="tableindex">
        <td colspan="2">&Aacute;MBITO SOCIAL/AFCTIVO</td>
      </tr>
      <tr  class="textonegrita">
        <td>FORTALEZAS</td>
        <td>NECESIDADES DE APOYO</td>
      </tr>
      <tr>
        <td><textarea name="social_fortaleza" cols="40" rows="5" id="social_fortaleza"></textarea></td>
        <td><textarea name="social_necesidad" cols="40" rows="5" id="social_necesidad"></textarea></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0">
      <tr class="tableindex">
        <td colspan="2">&Aacute;MBITO DE LA SALUD</td>
      </tr>
      <tr  class="textonegrita">
        <td>FORTALEZAS</td>
        <td>NECESIDADES DE APOYO</td>
      </tr>
      <tr>
        <td><textarea name="salud_fortaleza" cols="40" rows="5" id="salud_fortaleza"></textarea></td>
        <td><textarea name="salud_necesidad" cols="40" rows="5" id="salud_necesidad"></textarea></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr  class="tableindex">
    <td colspan="2">APOYOS EDUCATIVOS QUE DAR&Aacute; LA ESCUELA AL ESTUDIANTE (En  sala de clases, en sala de recursos, en la participaci&oacute;n de la comundad educativa)</td>
    </tr>
  <tr>
    <td colspan="2"><textarea name="apoyo_hogar" cols="80" rows="5" id="apoyo_hogar"></textarea></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr  class="tableindex">
    <td colspan="2">DESCRIPCI&Oacute;N DE LOS APOYOS QUE EL ALUMNO O ALUMNA REQUIERE RECIBIR EN EL HOGAR (refuerzo escolar, apoyo afectivo, desarrollo de h&aacute;bitos, actitud y compromiso de participaci&oacute;n)</td>
    </tr>
  <tr>
    <td colspan="2"><textarea name="descrip_apoyo" cols="80" rows="5" id="descrip_apoyo"></textarea></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr  class="tableindex">
    <td colspan="2">NECESIDADES DE APOYO QUE REQUIERE LA FAMILIA PARA PODER CUMPLIR CON LOS APOYOS EN EL HOGAR</td>
    </tr>
  <tr>
    <td colspan="2"><textarea name="necesidad_apoyo" cols="80" rows="5" id="necesidad_apoyo"></textarea></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr  class="tableindex">
    <td colspan="2">ACUERDOS Y COMPROMISOS DE LA ESCUELA Y DE LA FAMILIA</td>
    </tr>
  <tr>
    <td colspan="2"><textarea name="acuerdo" cols="80" rows="5" id="acuerdo"></textarea></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita">Fecha entrega del informe</td>
    <td><input name="fecha_entrega" type="text" id="fecha_entrega" readonly="readonly" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td  class="textonegrita">Fecha pr&oacute;xima evaluaci&oacute;n</td>
    <td><input name="prox_evaluacion" type="text" id="prox_evaluacion" readonly="readonly" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?
}if($funcion==7){
	foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion);
  //echo "<br>".$asignacion; 
	}
	
	$rr = str_replace(".","",$rut_recibe);
	$rr = explode("-",$rr);
	
	$rut_recibe = $rr[0];
	$digrut_recibe = $rr[1];
	
	$rs_guarda = $obj_infespecial->guardar($conn,$cmb_ano,$cmb_periodo,$cmb_curso,$cmb_alumno,$cmb_empleado,$nombre_recibe,$rut_recibe,$digrut_recibe,$relacion_recibe,$interprete_recibe,$tipo_eval,$motivo_evaluacion,$diagnostico,$academico_fortaleza,$academico_necesidad,$social_fortaleza,$social_necesidad,$salud_fortaleza,$salud_necesidad,$apoyo_hogar,$descrip_apoyo,$necesidad_apoyo,$acuerdo,CambioFE($fecha_entrega),CambioFE($prox_evaluacion));
  if($rs_guarda){
	echo 1;
	}
	else{
	echo 0;
	}
		

}
if($funcion==8){
	//var_dump($_POST);
	$rs_emp = $obj_infespecial->empleado($conn,$rdb);
	$rs_inf =  $obj_infespecial->traeReporte($conn,$id);
	$fila_inf = pg_fetch_array($rs_inf,0);
	
	?>
       <script>
$(document).ready(function(){
	
				
	$("#fecha_entrega, #prox_evaluacion").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			/*minDate: new Date('01/01/'+anio+''),
			maxDate: new Date('12/31/'+anio+''),*/
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});
		
		
		

  });
  
 
	

  </script>
    <table width="90%" border="0" align="center" cellspacing="0">
  <tr>
    <td colspan="2" align="center" class="tableindex"><div align="center">Edici&oacute;n Evaluaci&oacute;n Diagn&oacute;stica Integral de Necesidades Educativas Especiales</div></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td width="16%">&nbsp;</td>
    <td width="84%" align="right"><input type="button" name="imp" id="imp" value="Imprimir" class="botonXX" onclick="imprimeReporte(<?php echo $fila_inf['id_necesidad'] ?>)"/>&nbsp;&nbsp;&nbsp;
      <input type="button" value="Guardar" onclick="guardaActuInf()" class="botonXX" />
    <input type="button" value="Cancelar" onclick="atras()" class="botonXX" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr  class="tableindex">
    <td colspan="2">IDENTIFICACI&Oacute;N DEL PROFESIONAL DEL ESTABLECIMIENTO ESCOLAR QUE ENTREGA LA INFORMACI&Oacute;N</td>
    </tr>
  <tr>
    <td colspan="2">
    <select name="cmb_empleado" id="cmb_empleado">
    <option value="0">seleccione...</option>
   <?php for($e=0;$e<pg_numrows($rs_emp);$e++){
	   $fila_emp= pg_fetch_array($rs_emp,$e);
	   ?>
    <option value="<?php echo $fila_emp['rut_emp'] ?>" <?php echo ($fila_emp['rut_emp']==$fila_inf['rut_emp'])?"selected":""; ?>><?php echo $fila_emp['nombre_emp'] ?> <?php echo $fila_emp['ape_pat'] ?> <?php echo $fila_emp['ape_mat'] ?></option>
    <?php }?>
    </select>
    <input type="hidden" name="id_necesidad" id="id_necesidad" value="<?php echo $fila_inf['id_necesidad'] ?>"  /></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr  class="tableindex">
    <td colspan="2">IDENTIFICACI&Oacute;N DE LA PERSONA QUE RECIBE LA INFORMACI&Oacute;N</td>
    </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0">
      <tr>
        <td colspan="2">&nbsp;</td>
        </tr>
      <tr class="textonegrita">
        <td width="21%">Nombre</td>
        <td><input name="nombre_recibe" type="text" id="nombre_recibe" size="70" value="<?php echo $fila_inf['nombre_recibe'] ?>"  /></td>
        </tr>
      <tr class="textonegrita">
        <td>Rut</td>
        <td><input type="text" name="rut_recibe" id="rut_recibe" value="<?php echo $fila_inf['rut_recibe'] ?>-<?php echo $fila_inf['digrut_recibe'] ?>" onchange="javascript:return Rut(document.formu.rut_recibe.value)" /></td>
        </tr>
      <tr class="textonegrita">
        <td>Relaci&oacute;n con el/la estudiante</td>
        <td><input type="text" name="relacion_recibe" id="relacion_recibe" value="<?php echo $fila_inf['relacion_recibe'] ?>" /></td>
        </tr>
      <tr>
        <td colspan="2"><input name="interprete_recibe" type="text" id="interprete_recibe" size="70" value="<?php echo $fila_inf['interprete_recibe'] ?>" /></td>
      </tr>
      <tr class="textonegrita">
        <td colspan="2">En presencia de (miembro de la familia, int&eacute;prete, otro/a)</td>
        </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr  class="tableindex">
    <td colspan="2">RESULTADOS DE LA EVALUACI&Oacute;N</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita">Tipo de Evaluaci&oacuten</td>
    <td class="textosimple"><input type="radio" name="tipo_eval" id="tipo_eval0" value="1" class="cl" <?php echo ($fila_inf['tipo_evaluacion']==1)?"checked":""; ?> />
    Ingreso 
      <input type="radio" name="tipo_eval" id="tipo_eval1" value="2" class="cl" <?php echo ($fila_inf['tipo_evaluacion']==2)?"checked":""; ?> />
    Reevaluaci&oacuten</td>
  </tr>
  <tr>
    <td class="textonegrita">Observaciones</td>
    <td><textarea name="motivo_evaluacion" cols="40" rows="5" id="motivo_evaluacion"><?php echo $fila_inf['motivo_evaluacion'] ?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="tableindex">
    <td>DIAGN&Oacute;STICO</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><textarea name="diagnostico" cols="80" rows="5" id="diagnostico"><?php echo $fila_inf['diagnostico'] ?></textarea></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr  class="tableindex">
    <td colspan="2">FORTALEZAS Y NECESIDADES DE APOYO EN CADA &Aacute;MBITO</td>
    </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" class="textonegrita">
      <tr class="tableindex">
        <td colspan="2">AMBITO ACADEMICO</td>
        </tr>
      <tr  class="textonegrita">
        <td>FORTALEZAS</td>
        <td>NECESIDADES DE APOYO</td>
      </tr>
      <tr>
        <td><textarea name="academico_fortaleza" cols="40" rows="5" id="academico_fortaleza"><?php echo $fila_inf['academico_fortaleza'] ?></textarea></td>
        <td><textarea name="academico_necesidad" cols="40" rows="5" id="academico_necesidad"><?php echo $fila_inf['academico_necesidad'] ?></textarea></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0" >
      <tr class="tableindex">
        <td colspan="2">&Aacute;MBITO SOCIAL/AFCTIVO</td>
      </tr>
      <tr  class="textonegrita">
        <td>FORTALEZAS</td>
        <td>NECESIDADES DE APOYO</td>
      </tr>
      <tr>
        <td><textarea name="social_fortaleza" cols="40" rows="5" id="social_fortaleza"><?php echo $fila_inf['social_fortaleza'] ?></textarea></td>
        <td><textarea name="social_necesidad" cols="40" rows="5" id="social_necesidad"><?php echo $fila_inf['social_necesidad'] ?></textarea></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0" cellspacing="0">
      <tr class="tableindex">
        <td colspan="2">&Aacute;MBITO DE LA SALUD</td>
      </tr>
      <tr  class="textonegrita">
        <td>FORTALEZAS</td>
        <td>NECESIDADES DE APOYO</td>
      </tr>
      <tr>
        <td><textarea name="salud_fortaleza" cols="40" rows="5" id="salud_fortaleza"><?php echo $fila_inf['salud_fortaleza'] ?></textarea></td>
        <td><textarea name="salud_necesidad" cols="40" rows="5" id="salud_necesidad"><?php echo $fila_inf['salud_necesidad'] ?></textarea></td>
      </tr>
    </table></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr  class="tableindex">
    <td colspan="2">APOYOS EDUCATIVOS QUE DAR&Aacute; LA ESCUELA AL ESTUDIANTE (En  sala de clases, en sala de recursos, en la participaci&oacute;n de la comundad educativa)</td>
    </tr>
  <tr>
    <td colspan="2"><textarea name="apoyo_hogar" cols="80" rows="5" id="apoyo_hogar"><?php echo $fila_inf['apoyo_hogar'] ?></textarea></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr  class="tableindex">
    <td colspan="2">DESCRIPCI&Oacute;N DE LOS APOYOS QUE EL ALUMNO O ALUMNA REQUIERE RECIBIR EN EL HOGAR (refuerzo escolar, apoyo afectivo, desarrollo de h&aacute;bitos, actitud y compromiso de participaci&oacute;n)</td>
    </tr>
  <tr>
    <td colspan="2"><textarea name="descrip_apoyo" cols="80" rows="5" id="descrip_apoyo"><?php echo $fila_inf['descrip_apoyo'] ?></textarea></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr  class="tableindex">
    <td colspan="2">NECESIDADES DE APOYO QUE REQUIERE LA FAMILIA PARA PODER CUMPLIR CON LOS APOYOS EN EL HOGAR</td>
    </tr>
  <tr>
    <td colspan="2"><textarea name="necesidad_apoyo" cols="80" rows="5" id="necesidad_apoyo"><?php echo $fila_inf['necesidad_apoyo'] ?></textarea></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
   <tr  class="tableindex">
    <td colspan="2">ACUERDOS Y COMPROMISOS DE LA ESCUELA Y DE LA FAMILIA</td>
    </tr>
  <tr>
    <td colspan="2"><textarea name="acuerdo" cols="80" rows="5" id="acuerdo"><?php echo $fila_inf['acuerdo'] ?></textarea></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita">Fecha entrega del informe</td>
    <td><input name="fecha_entrega" type="text" id="fecha_entrega" readonly="readonly" value="<?php echo cambioFD($fila_inf['fecha_entrega']) ?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td  class="textonegrita">Fecha pr&oacute;xima evaluaci&oacute;n</td>
    <td><input name="prox_evaluacion" type="text" id="prox_evaluacion" readonly="readonly" value="<?php echo cambioFD($fila_inf['prox_evaluacion']) ?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
    <?
}if($funcion==9){
	//var_dump($_POST);
	
	foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion);
  //echo "<br>".$asignacion; 
	}
	
	$rr = str_replace(".","",$rut_recibe);
	$rr = explode("-",$rr);
	
	$rut_recibe = $rr[0];
	$digrut_recibe = $rr[1];
	
	$rs_act = $obj_infespecial->actualizar($conn,$cmb_empleado,$nombre_recibe,$rut_recibe,$digrut_recibe,$relacion_recibe,$interprete_recibe,$tipo_eval,$motivo_evaluacion,$diagnostico,$academico_fortaleza,$academico_necesidad,$social_fortaleza,$social_necesidad,$salud_fortaleza,$salud_necesidad,$apoyo_hogar,$descrip_apoyo,$necesidad_apoyo,$acuerdo,CambioFE($fecha_entrega),CambioFE($prox_evaluacion),$id_necesidad);
	
	 if($rs_act){
	echo 1;
	}
	else{
	echo 0;
	}
	
	?>
    <?
}if($funcion==10){
	$rs_eli  = $obj_infespecial->eliminaReporte($conn,$id);
	 if($rs_eli){
	echo 1;
	}
	else{
	echo 0;
	}
	}
	
	
	
if($funcion==11){
	
	$rs_listado = $obj_infespecial->entPend($conn,$anio,$periodo);
	if(pg_numrows($rs_listado)>0){
	?>
    <table width="100%" border="1" style="border-collapse:collapse" cellpadding="0" cellspacing="0">
  <tr class="tableindex">
    <td>FECHA</td>
    <td>ALUMNO</td>
    <td>CURSO</td>
    <td>ENTREVISTADOR</td>
  </tr>
  <?php for($e=0;$e<pg_numrows($rs_listado);$e++){
	  $fila=pg_fetch_array($rs_listado,$e);
	 $rs_emp = $obj_infespecial->empleado1($conn,$fila['rut_emp']);
	 $nom_doc = pg_result($rs_emp,2)." ".pg_result($rs_emp,3)." ".pg_result($rs_emp,4);
	 $rs_alu = $obj_infespecial->alumno1($conn,$fila['rut_alumno']);
	 $nom_alu = pg_result($rs_alu,0);
	 
	 $fondo = ($e%2==1)?"#cccccc":"#ffffff";
	 
	  ?>
  <tr class="textosimple" bgcolor="<?php echo $fondo ?>">
    <td><?php echo CambioFD($fila['prox_evaluacion']) ?></td>
    <td><?php echo $nom_alu ?></td>
    <td><?php echo CursoPalabra($fila['prox_evaluacion'],1,$conn) ?></td>
    <td><?php echo $nom_doc ?></td>
  </tr>
 <?php  }?>
</table>
<?php }else{?>
<p align="center">Sin entrevistas pendientes</p>
<?php }?>

    <?
}
	?>