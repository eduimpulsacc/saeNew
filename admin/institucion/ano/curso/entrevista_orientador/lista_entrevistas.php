<?php
require('../../../../../util/header.inc');
include('../../../../clases/class_Reporte.php');
include('../../../../clases/class_Membrete.php');
include('../../../../clases/class_MotorBusqueda.php');
$ob_reporte = new Reporte();
$ob_motor = new MotorBusqueda();


 $institucion	=$_INSTIT;
 $ano			=$_ANO;
 $empleado		=$_NOMBREUSUARIO;
 $perfil 		=$_PERFIL;
 
foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
  //echo $asignacion."<br>";
}

//show($_SESSION);
 
$ob_reporte->ano = $ano;
$ob_reporte->curso = $curso;
$ob_reporte->institucion = $institucion;
$ob_motor ->ano = $ano;
$ob_motor ->cmb_curso = $curso;




function CambioFecha($fecha)   //    cambia fecha del tipo  dd/mm/aaaa  ->  aaaa/mm/dd    para poder hacer insert y update
{
	$retorno="";
	if(strlen($fecha) !=10)
		return $retorno;
	$d=substr($fecha,0,2);
	$m=substr($fecha,3,2);
	$a=substr($fecha,6,4);
	if (checkdate($m,$d,$a))
		$retorno=$a."-".$m."-".$d;
	else
		$retorno="";
	return $retorno;
}

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

//query
 $qry="select * from entrevista_orientador where id_ano=$ano and id_curso=$curso and fecha='".CambioFecha($fecha)."'";
$res= pg_exec($conn,$qry);

if(pg_numrows($res)>0){
?>
<script>
function confirm(id, callback) {
	
    $('body').append('<div id="confirm" style="display:none">&iquest;Desea eliminar registro?</div>');
	var curso =  $('#c_curso').val();
	var fecha =  $('#fecha_en1').val();
	
    $( "#confirm" ).dialog({
        resizable: false,
        title: 'Elimar Registro entrevista',
        modal: true,
        buttons: [
            {
                text: "Eliminar",
                click: function() {
					$.ajax({
						url:"procesaEntrevista.php",
						data:"id_entrevista="+id+"&accion=3",
						type:'POST',
						success:function(data){
						//console.log(data);
						alert('Datos eliminados');
						$.ajax({
						url:"lista_entrevistas.php",
				data:"curso="+curso+"&fecha="+fecha,
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


//carga datos accidente para editar
function editarA(id){
	 
	$.ajax({
			url:"edita_entrevista.php",
			data:"id_entrevista="+id,
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
	 
	 if($('#fecha_entrevista_ed').val()=="")
	{
		alert("Seleccione una fecha");
		$( "#fecha_entrevista_ed" ).focus();
		return false;
	}
	
	
	else if($('#obs_entrevista_ed').val()=="")
	{
		alert("Describa observaciones");
		$( "#obs_entrevista_ed" ).focus();
		return false;
	}
	else{
	 
	//$( "#guardaNuevo" ).click(function() {
		
		$.ajax({
				url:"procesaEntrevista.php",
				data:"accion=2"
					 +"&fecha_entrevista="+$('#fecha_entrevista_ed').val()
					+"&observaciones="+$('#obs_entrevista_ed').val()
					 +"&acuerdos="+$('#obs_acuerdos_ed').val()
					+"&id_entrevista="+$('#id_entrevista').val(),
				type:'POST',
				success:function(data){
					console.log(data);
					//$('#lista').html(data);
					//recargo listado accidentes
					$.ajax({
				url:"lista_entrevistas.php",
				data:"curso="+$('#hidden_curso').val()+"&fecha="+$('#fecha_entrevista_ed').val(),
				type:'POST',
				success:function(data){
					alert('Datos modificados');
					$('#combo').find("select").val($('#hidden_curso').val()).attr("selected","selected");
				$('#fecha_en1').val($('#fecha_entrevista_ed').val())
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

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr class="tableindex">
    <td align="center">Fecha</td>
    <td align="center">Entrevistado</td>
    <td align="center">Tipo</td>
    <td align="center">Entrevistador</td>
    <?php if($perfil==0 || $perfil==14 || $perfil == 20){  ?> <td colspan="2" align="center">Acciones</td><?php }?>
  </tr>
 <?php for($i=0;$i<pg_numrows($res);$i++){
	 $fila= pg_fetch_array($res,$i);
	 
		if($fila['tipo']==1)
		{
		$ob_reporte->alumno=$fila['rut_entrevistado'];	
		$rs_alumno = $ob_reporte->TraeUnAlumno($conn);
		$fil_alu = pg_fetch_array($rs_alumno,0);
		$nombre_entrevistado = ucwords(strtolower($fil_alu["ape_pat"].$fil_alu["ape_mat"].", ".$fil_alu["nombre_alu"]));
		}
		elseif($fila['tipo']==2)
		{
		$ob_reporte->apoderado=$fila['rut_entrevistado'];
		$rs_apoderado = $ob_reporte->TraeUnApoderado($conn);
		$fil_apo = pg_fetch_array($rs_apoderado,0);
		$nombre_entrevistado = ucwords(strtolower($fil_apo["ape_pat"].$fil_apo["ape_mat"].", ".$fil_apo["nombre_apo"]));		
		}
	 
	 
	 ?> 
  <tr class="textosimple">
    <td><?php echo CambioFechaDisplay($fila['fecha']) ?></td>
    <td><?php echo $nombre_entrevistado ?></td>
    <td>&nbsp;
	<?php echo ($fila['tipo']==1)?"Alumno":"Apoderado" ?></td>
    <td>&nbsp;
    <?php 
	if($fila['rut_emp'] != 'admin'){
	$ob_reporte->empleado = $fila['rut_emp'];
	$rs_empleado = $ob_reporte->TraeUnempleado($conn);
	$fil_emp = pg_fetch_array($rs_empleado,0);
	$nombre_entrevistador = ucwords(strtolower($fil_emp["ape_pat"].$fil_emp["ape_mat"].", ".$fil_emp["nombre_emp"]));
	}else{
		$nombre_entrevistador = $fila['rut_emp'];
		}
		
		echo $nombre_entrevistador;
	?>
    
    </td>
   <?php if($perfil==0 || $perfil==14 || $perfil == 20){  ?> 
    <td align="center"><input type="button" name="editar" id="editar"  value="Editar Entrevista" class="botonXX"  onClick="editarA(<?=$fila['id_entrevista'];?>)"></td>
    <td align="center"><input type="button" name="eliminar" id="eliminar"  value="Eliminar Entrevista"  class="botonXX" onclick="return confirm(<?=$fila['id_entrevista'];?>);"></a></td>
	<?php }?>
  </tr>
  <?php }?>
</table>
<?php }else{?>
<div align="center" class="textosimple">No se encontraron datos</div>
<?php }?>