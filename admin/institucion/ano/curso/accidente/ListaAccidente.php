<?php 
require('../../../../../util/header.inc');
include('../../../../clases/class_MotorBusqueda.php');
include('../../../../clases/class_Reporte.php');

$ob_motor = new MotorBusqueda();
$ob_reporte = new Reporte();

$ob_motor ->ano =$_POST['anio'];
$ob_motor ->cmb_curso =$_POST['curso'];
$result_curso = $ob_motor ->alumno($conn);



$sql = "SELECT * FROM DECLARACION_ACCIDENTE WHERE ID_CURSO = $curso order by fecha desc";
$result=@pg_Exec($conn, $sql);
$fila = pg_fetch_array($result);

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
$(function ($) {
    $.each($('a'), function() {
        e = $(this).attr("onclick");
        if(e!=undefined) {
            string = $(this).attr("onclick").toString();
            if (string.indexOf('return confirm(')!=-1) {
                target = $(this).attr("href");
                $(this).click(function (e) {
                    e.preventDefault();
                    confirm(null, function () {                     
                        window.location.href = target;
                    });
                });
            }
        }
    });
});

function confirm(id, callback) {
	
    $('body').append('<div id="confirm" style="display:none">&iquest;Desea eliminar registro?</div>');
    $( "#confirm" ).dialog({
        resizable: false,
        title: 'Elimar Registro Accidente',
        modal: true,
        buttons: [
            {
                text: "Eliminar",
                click: function() {
					$.ajax({
						url:"ProcesaAccidente.php",
						data:"id_accidente="+id+"&accion=3",
						type:'POST',
						success:function(data){
						
						$.ajax({
						url:"ListaAccidente.php",
						data:"curso="+$('#c_curso').val()+"&anio="+$('#c_ano').val(),
						type:'POST',
						success:function(data){
						$('#lista').html(data);
						limpiarformulario("#form_editar");
						$('#dialog-form2').css("display","none");
				  }
				})  	
							
						//$('#lista').html(data);
				  }
				})  
					
					
					$(this).dialog("close");
					// $( "#lista" ).html("+++++");
                }
            },{
                text: "Cancelar",
                click: function() { $(this).dialog("close");}
            }
        ],
        close: function(event, ui) { 
            $('#confirm').remove();
        }
    });
}


 function editarA(id){
	 
	$.ajax({
			url:"EditaAccidente.php",
			data:"id_accidente="+id,
			type:'POST',
			success:function(data){ 
			 $('#dialog-form2').css("display","block");
			  $("#dialog-form2").html(data);
			  $('#dialog-form').css("display","none");
           	
			}
		}) 
		 
 }
 
 
  
  
  //guardar nuevo accidente
 function guardarEditar(){
	 
	 if($('#fecha_accidente2').val()=="")
	{
		alert("Seleccione una fecha");
		$( "#fecha_accidente2" ).focus();
		return false;
	}
	
	else if($('#tipo_accidente2').val()==0)
	{
		alert("Seleccione tipo accidente");
		$( "#tipo_accidente2" ).focus();
		return false;
		
	}
	
	else if($('#obs_accidente2').val()=="")
	{
		alert("Describa Accidente");
		$( "#obs_accidente2" ).focus();
		return false;
	}
	else{
	 
	//$( "#guardaNuevo" ).click(function() {
		
		$.ajax({
				url:"ProcesaAccidente.php",
				data:"accion=2"
					 +"&fecha_accidente="+$('#fecha_accidente2').val()
					 +"&hora_accidente="+$('#hora_accidente2').val()
					 +"&minuto_accidente="+$('#minuto_accidente2').val()
					 +"&diasemana_accidente="+$('#diasemana_accidente2').val()
					 +"&tipo_accidente="+$('#tipo_accidente2').val()
					 +"&observaciones="+$('#obs_accidente2').val()
					 +"&nom_testigo1="+$('#nom_testigo12').val()
					 +"&nom_testigo2="+$('#nom_testigo22').val()
					 +"&rut_testigo1="+$('#rut_testigo12').val()
					 +"&rut_testigo2="+$('#rut_testigo22').val()
					 +"&id_accidente="+$('#id_accidente').val(),
				type:'POST',
				success:function(data){
					//$('#lista').html(data);
					//recargo listado accidentes
					$.ajax({
				url:"ListaAccidente.php",
				data:"curso="+$('#hidden_curso').val()+"&anio="+$('#hidden_anio').val(),
				type:'POST',
				success:function(data){
				$('#lista').html(data);
				limpiarformulario("#form_editar");
				$('#dialog-form').css("display","none");
				$('#dialog-form2').css("display","none");
		  }
		})  
					
					
			
		  }
		})  
		
		
       
    
	}
	
	}



</script>
    <table width="80%" border="0" cellpadding="0" cellspacing="0" align="center" >
      <tr>
        <td colspan="8">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="8" align="right">
        <form action="printListadoAccidentes.php" method="post" target="_blank">
        <input name="c_ano" type="hidden" id="c_ano" value="<?php echo $_POST['anio'] ?>" />
        <input name="c_curso" type="hidden" id="c_curso" value="<?php echo $_POST['curso'] ?>" />
        <input type="submit" name="imprimir" id="button2" value="Imprimir Listado" class="botonXX printer" >
        </form></td>
        </tr>
      <tr class="tablatit2-1">
        <td width="109" align="center">Fecha</td>
        <td width="366" align="center">Alumno</td>
       
        <td width="193" align="center">Tipo Accidente</td>
        <td colspan="3" align="center">Acciones</td>
      </tr>
     <?php  for($i=0 ; $i < @pg_numrows($result); $i++){
		  $fila = @pg_fetch_array($result,$i);
		  
		  	  
		$ob_reporte->ano=$_POST['anio'];
		$ob_reporte->curso=$curso;
		$ob_reporte->alumno=$fila['rut_alumno'];
		$result_alumno = $ob_reporte->TraeUnAlumno($conn);
		$fila_alumno = @pg_fetch_array($result_alumno,0);
		$nombre_alumno = ucwords(strtoupper($fila_alumno['ape_pat'] . " " . $fila_alumno['ape_mat'] . " 
		" . $fila_alumno['nombre_alu']));
		 ?>
      <tr  class="textosimple">
        <td><?php echo CambioFechaDisplay($fila['fecha']); ?></td>
        <td><?php echo $nombre_alumno; ?></td>
        <td><?php echo ($fila['tipo']==1)?"De Trayecto":"En el establecimiento"; ?></td>
       
        <td width="42" style="padding-top:10px" ><form name="deca" id="deca" action="../../reportes/alumno/declaracionaccidentes/printAccidenteEscolar.php" target="_blank" method="post">
          <input name="c_curso" type="hidden" id="c_curso" value="<?php echo $_POST['curso'] ?>" />
        <input name="c_alumno" type="hidden" id="c_alumno" value="<?php echo $fila['rut_alumno'] ?>" />
        <input name="fecha" type="hidden" id="fecha" value="<?php echo CambioFD($fila['fecha']) ?>" />
        <input name="c_ano2" type="hidden" id="c_ano2" value="<?php echo $_POST['anio'] ?>" />
        <input name="button" type="submit" value="IP" class="botonXX" title="Imprimir Declaraci&oacute;n" align="middle" />
        </form></td>
     
        <td width="58" align="center" valign="middle"><input type="button" name="editar" id="editar"  value="E" class="botonXX"  onClick="editarA(<?=$fila['id_accidente'];?>)" title="Editar Datos Accidente"></td>
        <td width="52" align="center" valign="middle"><input type="button" name="eliminar" id="eliminar"  value="X"  class="botonXX" onclick="return confirm(<?=$fila['id_accidente'];?>);" title="Eliminar Declaraci&oacute;"></a></td>
      </tr>
      <?php  } ?>
    </table>
    
