<?php require('../../../../../util/header.inc');
require "mod_entrevista.php";

$ob_entrevista= new Entrevista();
$funcion = $_POST['funcion'];

if($funcion==1){
	
	
	$rs_alumno = $ob_entrevista->carga_lista_alumnos($conn,$curso,$anio);
	?>
<select name='select_alumno' id='select_alumno'  >
		<option value='0'  >(Seleccionar)</option>
       <?php for($i=0;$i<pg_numrows($rs_alumno);$i++){
			$fila=pg_fetch_array($rs_alumno,$i);
		?>
            <option value="<?=$fila['rut_alumno']?>" ><?=$fila['ape_pat'].' '.$fila['ape_mat'].' '.$fila['nombre_alu']?></option>
      <?
	   }
	   ?>
</select>
<?
}
if($funcion==2){
//show($_POST);
$rs_entre = $ob_entrevista->carga_entrevista_todo($conn,$curso,$ano,$alumno);	
?>
<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
<tr><td colspan="8" align="center" class="tableindex">LISTADO ENTREVISTAS</td></tr>
<?php if(pg_numrows($rs_entre)==0){?>
<tr><td colspan="8" align="center" class="textosimple">Alumno no registra entrevistas</td></tr>
<?php }else{?>
<tr class="tableindex">
  <td width="16%" align="center">Fecha</td>
  <td width="16%" align="center">
Entrevistador</td>
  <td width="16%" align="center">Cargo </td> 
  <td width="16%" align="center">Descripci&oacute;n  </td>
  <td width="16%" align="center">Observaciones  </td>
  <td width="16%" align="center">Acuerdos  </td>
  <td colspan="2" align="center">Acciones</td>
  </tr>
 <?php  for($i=0;$i<pg_numrows($rs_entre);$i++){
	 $fila = pg_fetch_array($rs_entre,$i);
	 
	 switch ( $fila['tipo_entrevista']){
	case 1:
	$cargo ="Orientador";
	break;
	case 2:
	$cargo ="Jefe UTP";
	break;
	case 3:
	$cargo ="Profesor Jefe";
	break;
	case 4:
	$cargo ="Docente";
	break;
	
	case 5:
	$cargo ="Director";
	break;
	case 6:
	$cargo ="Inspector General";
	break;
	
	case 7:
	$cargo ="Encargado de Convivencia Escolar";
	break;
	}
	 
	 
	 ?>
<tr class="textosimple">
  <td><?php echo CambioFD($fila['fecha']) ?></td>
  <td><?php echo $fila['entrevistador'] ?></td>
  <td><?php echo $cargo ?></td>
  <td><?php echo $fila['descripcion'] ?></td>
  <td><?php echo $fila['observaciones'] ?></td>
  <td><?php echo $fila['acuerdos'] ?></td>
  <td width="10%" align="center"><img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/edit.png" width="24" height="24" onclick="mode(<?php echo $fila['id_entrevista'] ?>)" /></td>
  <td width="10%" align="center"><img src="../../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/Delete.png" width="24" height="24" onclick="elimina(<?php echo $fila['id_entrevista'] ?>)" /></td>
<tr><td colspan="8">
</td></tr>
<?php }?>
<?php }?>
</table>
<?
}if($funcion==3){
	
$sql_curso = "select id_curso from curso where id_ano= $ano order by ensenanza, grado_curso,letra_curso";	
$result_curso = pg_exec($conn,$sql_curso);
?>
<script>
$(document).ready(function() { 
$( "#fecha_entrevista" ).datepicker({
    'dateFormat':'dd/mm/yy',
	firstDay: 1,
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ]/*,
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
		 $('#diasemana_accidente').val(dayOfWeek);
		 
    }*/
	
});
});
</script>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
 <tr>
   <td colspan="3" align="center" class="tableindex">&nbsp;Ingresar datos Entrevista</td>
   </tr>
 <tr class="cuadro01">
   <td colspan="3">&nbsp;</td>
   </tr>

 
    <tr class="cuadro01">
    <td width="95" class="textosimple">&nbsp;Curso</td>
    <td colspan="2"><!--onChange="selAlumnosCurso();"-->
    <select name="cmb_curso2" id="cmb_curso2"  class="ddlb_9_x" onchange="cargaAlumno2(this.value);cargaentrevistador()">
    <option value=0>(Seleccione Curso)</option>
     <?
		  for($i=0 ; $i < @pg_numrows($result_curso) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_curso,$i); 
		  if ($fila["id_curso"]==$c_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
  </select>
  </td>
  </tr>
  <tr class="cuadro01">
   <td class="textosimple">Entrevistador 
     </td>
   <td colspan="2" class="textosimple">
   <select name="tipo_entrevista" id="tipo_entrevista" onchange="cargaentrevistador()">
   <option value="0">Seleccione Cargo Entrevistador</option>
   <option value="5">Director</option>
   <option value="2">Jefe UTP</option>
   <option value="6">Inspector General</option>
   <option value="7">Encargado de Convivencia Escolar</option>
   <option value="1">Orientador</option>
   <option value="3">Profesor Jefe</option>
   <option value="4">Docente</option>
   
  
   
   </select></td>
  </tr>
  <tr class="cuadro01">
    <td class="textosimple">&nbsp;</td>
    <td colspan="2" class="textosimple"><div id="rentrevistador"><select name="entrevistador" id="entrevistador">
      <option value="0">(Seleccione entrevistador)</option>
    </select></div></td>
  </tr>
 <tr class="cuadro01">
   <td class="textosimple">&nbsp;Alumno</td>
   <td class="textosimple"><div id="listentrevistado">
 <select name="entrevistado" id="entrevistado">
      <option value="0">(Seleccione alumno)</option>
    </select>
   
   </div></td>
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
    <td colspan="3" class="textosimple">&nbsp;Descripci&oacute;n</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3">&nbsp;
      <textarea name="desc_entrevista" cols="50" rows="5" id="desc_entrevista" placeholder="(Ingrese Descripci&oacute;n)"></textarea></td>
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
    <td colspan="3">&nbsp;<textarea name="acuer_entrevista" cols="50" rows="5" id="acuer_entrevista" placeholder="(Ingrese Acuerdos)"></textarea></td>
  </tr>
  <tr>
    <td colspan="3" class="cuadro01">&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3">&nbsp;<input type="button" name="guardaNuevo" id="guardaNuevo" value="Ingresar datos" onclick="guardarNuevo()" class="botonXX" />
      <input type="button" name="cancelar" id="cancelar" value="Cancelar" onclick="cancela()" class="botonXX"/></td>
  </tr>
</table>
<?	
}
if($funcion==4){
	
if($tipo==1)//orientador
{
$rs_cargo = $ob_entrevista->empcargo($conn,$rdb,11);
}
if($tipo==2)//jefe utp
{
	$rs_cargo = $ob_entrevista->empcargo($conn,$rdb,2);
	}
if($tipo==3)//profesor jefe
{
	$rs_cargo = $ob_entrevista->profejefe($conn,$curso);
	}
if($tipo==4)//docente
{
	$rs_cargo = $ob_entrevista->docente($conn,$_INSTIT);
}
if($tipo==5)//director
{
	$rs_cargo = $ob_entrevista->empcargo($conn,$rdb,1);
}
if($tipo==6)//inspector general
{
	$rs_cargo = $ob_entrevista->empcargo($conn,$rdb,7);
}
if($tipo==7)//convivencia escolar
{
	$rs_cargo = $ob_entrevista->empcargo($conn,$rdb,44);
}
?>
<select name="entrevistador" id="entrevistador">
      <option value="0">(Seleccione entrevistador)</option>
     <?php  for($c=0;$c<pg_numrows($rs_cargo);$c++){
		 $fila = pg_fetch_array($rs_cargo,$c);
		 ?>
         <option value="<?php echo $fila['rut_emp'] ?>"><?php echo $fila['ape_pat']." ".$fila['ape_mat']." ".$fila['nombre_emp'] ;?></option>
         <?php }?>
    </select>
<?

}
if($funcion==5){
	$rs_alu = $ob_entrevista->carga_lista_alumnos($conn,$curso,$ano);
	?>
    <select name="entrevistado" id="entrevistado">
      <option value="0">(Seleccione alumno)</option>
        <?php  for($c=0;$c<pg_numrows($rs_alu);$c++){
    $fila = pg_fetch_array($rs_alu,$c);
		 ?>
      <option value="<?php echo $fila['rut_alumno'] ?>"><?php echo $fila['ape_pat']." ".$fila['ape_mat']." ".$fila['nombre_alu'] ;?></option>
         <?php }?>
    </select>
    <?
}if($funcion==6){

$rs_cuarda = $ob_entrevista->guardaNuevo($conn,$curso,$ano,$entrevistador,$entrevistado,$tipo,utf8_decode($descripcion),utf8_decode($observaciones),utf8_decode($acuerdos),CambioFE($fecha));
if($rs_cuarda){
echo 1;
}
else{echo 0;}

}
if($funcion==7){
	
	
	$rs_alumno = $ob_entrevista->carga_lista_alumnos($conn,$curso,$anio);
	?>
<select name='entrevistado' id='entrevistado'  >
  <option value='0'  >(Seleccionar)</option>
       <?php for($i=0;$i<pg_numrows($rs_alumno);$i++){
			$fila=pg_fetch_array($rs_alumno,$i);
		?>
            <option value="<?=$fila['rut_alumno']?>" ><?=$fila['ape_pat'].' '.$fila['ape_mat'].' '.$fila['nombre_alu']?></option>
      <?
	   }
	   ?>
</select>
<?
}
if($funcion==8){
	$rs_cuarda = $ob_entrevista->eliminarE($conn,$ide);
if($rs_cuarda){
echo 1;
}
else{echo 0;}
}
if($funcion==9){
$rs_entrevista = $ob_entrevista->carga_entrevista_uno($conn,$ide);
$fila = pg_fetch_array($rs_entrevista,0);
$emp = $ob_entrevista->empleado($conn,$fila['rut_entrevistador']);
$fila_emp = pg_fetch_array($emp,0);
$alu = $ob_entrevista->alumno($conn,$fila['rut_entrevistado']);
$fila_alu = pg_fetch_array($alu,0);
?>
<script>
$(document).ready(function() { 
$( "#fecha_entrevista" ).datepicker({
    'dateFormat':'dd/mm/yy',
	firstDay: 1,
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ]
   
	
});
});
</script>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
 <tr>
   <td colspan="3" align="center" class="tableindex"><label for="ide"></label>
    <input type="hidden" name="ide" id="ide" value="<?php echo $ide;?>" />     &nbsp;Modificar datos Entrevista</td>
   </tr>
 <tr class="cuadro01">
   <td colspan="3">&nbsp;</td>
   </tr>
  <tr class="cuadro01">
    <td width="95" class="textosimple">Entrevistador 
     </td>
    <td colspan="2" class="textosimple"><?php echo $fila_emp['ape_pat']." ".$fila_emp['ape_mat']." ".$fila_emp['nombre_emp'] ;?></td>
  </tr>
 <tr class="cuadro01">
   <td class="textosimple">Alumno</td>
   <td class="textosimple"><div id="listentrevistado"><?php echo $fila_alu['ape_pat']." ".$fila_alu['ape_mat']." ".$fila_alu['nombre_alu'] ;?></div></td>
   <td class="textosimple">&nbsp;</td>
 </tr>
  <tr class="cuadro01">
    <td class="textosimple">&nbsp;Fecha</td>
    <td width="223" ><input name="fecha_entrevista" type="text" id="fecha_entrevista" size="12" readonly placeholder="Seleccione una fecha" value="<?php echo CambioFD($fila['fecha']) ?>"></td>
    <td width="332" class="textosimple">&nbsp;</td>
    </tr>
  <tr class="cuadro01">
    <td colspan="3" class="textosimple">&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3" class="textosimple">&nbsp;Descripci&oacute;n</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3">&nbsp;
      <textarea name="desc_entrevista" cols="50" rows="5" id="desc_entrevista" placeholder="(Ingrese Descripci&oacute;n)"><?php echo $fila['descripcion'] ?></textarea></td>
    </tr>
  <tr class="cuadro01">
    <td colspan="3" class="textosimple">&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3" class="textosimple">&nbsp;Observaciones</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3">&nbsp;
      <textarea name="obs_entrevista" cols="50" rows="5" id="obs_entrevista" placeholder="(Ingrese Observaciones)"><?php echo $fila['observaciones'] ?></textarea></td>
    </tr>
  <tr class="cuadro01">
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3" class="textosimple">Acuerdos</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3">&nbsp;<textarea name="acuer_entrevista" cols="50" rows="5" id="acuer_entrevista" placeholder="(Ingrese Acuerdos)"><?php echo $fila['acuerdos'] ?></textarea></td>
  </tr>
  <tr>
    <td colspan="3" class="cuadro01">&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3">&nbsp;<input type="button" name="guardaNuevo" id="guardaNuevo" value="Modificar datos" onclick="guardarAct()" class="botonXX" />
      <input type="button" name="cancelar" id="cancelar" value="Cancelar" onclick="cancela()" class="botonXX"/></td>
  </tr>
</table>
<?
}
if($funcion==10){
	$rs_up =  $ob_entrevista->upEntrevista($conn,$ide,CambioFE($fecha),utf8_decode($descripcion),utf8_decode($observaciones),utf8_decode($acuerdos));
	if($rs_up){
echo 1;
}
else{echo 0;}
}

?>