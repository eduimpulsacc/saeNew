<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Armar Bloques</title>

<link rel="stylesheet" type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css">
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>
        
<script type="text/javascript">
$(document).ready(function(){ // Script para cargar al inicio del modulo
cargartabla(<?=$_ANO?>);
});


function insertarbloque(fu){

if(fu==0){
var parametros = "funcion="+fu+"&nombrebloque="+$('#nombrebloque').val()+"&porcentajebloque="+$('#porcentajebloque').val();
    }
 
	$.ajax({
	  url:'mod/grupoevaluados/cont_grupoevaluados.php',
	  data:parametros,
	  type:'POST',
		  success:function(data){
				   if(data==1){
					   
					   alert("Se ha Creado el Bloque");
					   
					   $('#id_bloque').val("");
					   $('#nombrebloque').val("");
					   $('#porcentajebloque').val("");
							
					   cargartabla(<?=$_ANO?>);
					
					}else{
					   alert("Error al Crear el Bloque");
					}
			     }
             });

					if(fu==0){
					$('#nombrebloque').val("");
					$('#porcentajebloque').val("");
						}

 }// fin funcion cargadatos
 
 
	function cargartabla(ano){
	var parametros = "funcion=3&ano="+ano;
		$.ajax({
		  url:'mod/grupoevaluados/cont_grupoevaluados.php',
		  //url:'cont_bloques.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#table_evaluadores').html(data);
						
						$("#flex1").flexigrid({
								width : 700,
								height : 150
							});
							
						}
				     }
		         })
	          } // fin funcion cargartabla
 
 
 function buscargrupo(id_bloq_evaluado){
 
  var parametros = "funcion=6&id_bloq_evaluado="+id_bloq_evaluado;

  		$.ajax({
		  url:'mod/grupoevaluados/cont_grupoevaluados.php',
		  type:'post',
		  data:parametros,
		  success:function(data){
		   if(data!=0){

	       $('#respuesta_buscador').html(data);
					 
           $('#id_bloque').val($('#id_bloq_evaluado').val());
		   $('#nombrebloque').val($('#nombre_bloq_eva').val());
		   $('#porcentajebloque').val($('#porcentaje_bloq_eva').val());
					  
		   $('#bottoncontrol').html('<br><input name="modificargrupo" type="button" class="botonXX" onClick="modificargrupo()" value="Modificar" />');

					}else{
					  alert("Error al Cargar");
					}
			 }
		 })
    }
 
 
 
 function modificargrupo(){
  
 var id = $('#id_bloque').val();
  
 var parametros = "funcion=5&id_bloque="+id+"&nombrebloque="+$('#nombrebloque').val()+"&porcentajebloque="+$('#porcentajebloque').val();
 
 		$.ajax({
		  url:'mod/grupoevaluados/cont_grupoevaluados.php',
		  data:parametros,
		  type:'POST',
		  success:function(data){

					if(data==0){
					alert("Error al Cargar");
					}
					
						if(data==1){
							alert("Bloque Modificado");
							
							$('#id_bloque').val("");
					        $('#nombrebloque').val("");
					        $('#porcentajebloque').val("");
							
							$('#bottoncontrol').html('<br><input name="crearbloque" type="button" class="botonXX" onClick="insertarbloque(0)" value="Crear" />');
							
							cargartabla(<?=$_ANO?>);
							$("#flex1").flexigrid({
									width : 400,
									height : 150
								});
							}
				    
					 }
		         })
 
 } // modificar 
 

function Eliminagrupo(id){
 
 var parametros = "funcion=4&id_bloque="+id;

 			$.ajax({
			  url:'mod/grupoevaluados/cont_grupoevaluados.php',
			  data:parametros,
			  type:'POST',
						success:function(data){
                              
										if(data==0){
										alert("Error al Cargar");
										return false;
										}
										
												if(data==1){	
													
													alert("Grupo Eliminado");
													
													$('#id_bloque').val("");
					                                $('#nombrebloque').val("");
					                                $('#porcentajebloque').val("");
							
													cargartabla(<?=$_ANO?>);
													$("#flex1").flexigrid({
															width : 400,
															height : 150
														});
													}
								
								 }
					 })
 
 } // fin eliminar 

 
 
</script>

<style>
#bloques{ margin:10px; margin-top:5px; text-align:left; width:%; }
#table_evaluadores{  margin:10px; margin-top:25px; padding:15px;  }
#nombre_bloque{ margin-top:15px; padding:20px; border:solid 1px; margin:20px; width:90%; }
</style>

</head>
<body>
<div id="bloques" align="center"  >
<fieldset>
<legend><strong><?=htmlentities("Creación Grupos Evaluados",ENT_QUOTES,'UTF-8')?></strong></legend>
<div id="nombre_bloque">
<input type="hidden" name="id_bloque" id="id_bloque" value="0" />
<br>
  <label for="nombrebloque">Nombre Grupo:</label>
  <input name="nombrebloque" type="text" id="nombrebloque" size="40" maxlength="40" />
  <label for="porcentajebloque">Porcentaje:</label>
  <input name="porcentajebloque" type="text" id="porcentajebloque" size="4" maxlength="4" />

<div id="bottoncontrol" align="center">
<br><br>
  <input name="crearbloque" type="button" class="botonXX" onClick="insertarbloque(0)" value="Crear" />
</div>
</div>
<div id="table_evaluadores">
</div>
</fieldset>
</div>
<div id="respuesta_buscador" >&nbsp;</div>
</body>
</html>