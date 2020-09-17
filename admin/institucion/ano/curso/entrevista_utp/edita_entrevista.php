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
		$sql =" select *  from entrevista_jefeutp where id_entrevista = ".$id_entrevista;
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
$(document).ready(function() { 
$( "#fecha_entrevista_ed" ).datepicker({
    'dateFormat':'dd-mm-yy',
	firstDay: 1,
	yearRange: "2000:<?php echo date("Y") ?>",
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

//$.datepicker.regional['es']	


});

</script>
<form method "post" action="#" name="form" id="form_editar">
<input name="id_entrevista" type="hidden" id="id_entrevista" value="<?php echo $fila['id_entrevista']; ?>"   />
 
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
 <tr>
   <td colspan="3" align="center" class="tableindex">&nbsp;Modifica datos Entrevista</td>
   </tr>
 <tr class="cuadro01">
   <td colspan="3"></td>
   </tr>
    <tr class="cuadro01">
      <td width="95" class="textosimple">&nbsp;Curso</td>
      <td colspan="2">
      <input name="hidden_curso" type="hidden" id="hidden_curso" value="<?php echo $fila['id_curso']; ?>"   />
      <? echo CursoPalabra($fila['id_curso'],0,$conn);?>
      </td>
    </tr>
 <tr class="cuadro01">
   <td class="textosimple">&nbsp;Nombre</td>
   <td colspan="2" class="textosimple"><?php 
   if($fila['tipo']==1){
   
		$ob_reporte->ano=$fila['id_ano'];
		$ob_reporte->curso=$fila['id_curso'];
		$ob_reporte->alumno=$fila['rut_entrevistado'];
		$result_alumno = $ob_reporte->TraeUnAlumno($conn);
		$fila_alumno = @pg_fetch_array($result_alumno,0);
		$nombre_entrevistado = ucwords(strtoupper($fila_alumno['ape_pat'] . " " . $fila_alumno['ape_mat'] . " 
		" . $fila_alumno['nombre_alu']));
   }
   elseif($fila['tipo']==2)
		{
		$ob_reporte->apoderado=$fila['rut_entrevistado'];
		$rs_apoderado = $ob_reporte->TraeUnApoderado($conn);
		$fil_apo = pg_fetch_array($rs_apoderado,0);
		$nombre_entrevistado = ucwords(strtolower($fil_apo["ape_pat"].$fil_apo["ape_mat"].", ".$fil_apo["nombre_apo"]));		
		}
	
	echo $nombre_entrevistado; ?></td>
   </tr>
  <tr class="cuadro01">
    <td class="textosimple">&nbsp;Fecha</td>
    <td width="223" ><input name="fecha_entrevista" type="text" id="fecha_entrevista_ed" size="12" readonly placeholder="Seleccione una fecha" value="<?php echo CambioFechaDisplay($fila['fecha']) ?>"></td>
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
      <textarea name="obs_entrevista" cols="50" rows="5" id="obs_entrevista_ed" placeholder="(Ingrese Observaciones)">
       <?php echo $fila['observaciones'] ?></textarea></td>
    </tr>
  <tr class="cuadro01">
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3" class="textosimple">&nbsp;Acuerdos</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3">&nbsp;&nbsp;<textarea name="obs_acuerdos_ed" cols="50" rows="5" id="obs_acuerdos_ed" placeholder="(Ingrese Acuerdos)"> <?php echo $fila['acuerdos'] ?></textarea></td>
  </tr>
  <tr>
    <td colspan="3" class="cuadro01">&nbsp;</td>
  </tr>
  <tr class="cuadro01">
    <td colspan="3">&nbsp;<input type="button" name="guardaEdita" id="guardaEdita" value="Actualizar Datos" onclick="guardarEditar()" class="botonXX"/>
      <input type="button" name="cancelar" id="cancelar" value="Cancelar" onclick="cancela()" class="botonXX"/></td>
  </tr>
</table>
</form >