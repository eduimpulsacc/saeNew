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
	
var parametros = "funcion="+fu+"&nombrebloque="+$('#nombrebloque').val()+"&porcentajebloque="+$('#porcentajebloque').val()+"&tipo_evaluacion="+$("input[name='tipo_eva']:checked").val();
    }
 
	$.ajax({
	  url:'mod/bloques/cont_bloques.php',
	  //url:'cont_bloques.php',
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
		  url:'mod/bloques/cont_bloques.php',
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
 
 
 function buscarbloque(id_bloque){
  var parametros = "funcion=6&id_bloque="+id_bloque;
  		$.ajax({
		  url:'mod/bloques/cont_bloques.php',
		  //url:'cont_bloques.php',
		  type:'post',
		  dataType: 'json',
		  data:parametros,
		  success:function(data){
					if(data!=0){
					  $('#id_bloque').val(data[0]);
					  $('#nombrebloque').val(data[1]);
					  $('#porcentajebloque').val(data[2]);
					  $('#bottoncontrol').html('<br><input name="modificarbloque" type="button" class="botonXX" onClick="modificarbloque()" value="Modificar" />');
					}else{
					  alert("Error al Cargar");
					}
			 }
		 })
    }
 
 
 
 function modificarbloque(){
  
 var id = $('#id_bloque').val();
  
 var parametros = "funcion=5&id_bloque="+id+"&nombrebloque="+$('#nombrebloque').val()+"&porcentajebloque="+$('#porcentajebloque').val()+"&tipo_evaluacion="+$("input[name='tipo_eva']:checked").val();
 
 		$.ajax({
		  url:'mod/bloques/cont_bloques.php',
		  //url:'cont_bloques.php',
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
 

function Eliminabloque(id){
 
 var parametros = "funcion=4&id_bloque="+id;

 			$.ajax({
			  url:'mod/bloques/cont_bloques.php',
			  //url:'cont_bloques.php',
			  data:parametros,
			  type:'POST',
						success:function(data){

										if(data==0){
										alert("Error al Cargar");
										return false;
										}
										
												if(data==1){	
													alert("Bloque Eliminado");
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
<legend><strong><?=htmlentities("Creación Bloques",ENT_QUOTES,'UTF-8')?></strong></legend>
<div id="nombre_bloque">
<input type="hidden" name="id_bloque" id="id_bloque" value="0" />
<br>
  <label for="nombrebloque">Nombre Bloque:</label>
  <input name="nombrebloque" type="text" id="nombrebloque" size="80" />
  <label for="porcentajebloque">Porcentaje Bloque:</label>
  <input name="porcentajebloque" type="text" id="porcentajebloque" size="4" maxlength="4" />
  <br /><br />
  Evaluaci&oacute;n Individual&nbsp;<input type="radio" name="tipo_eva" id="tipo_eva" value="0" checked="checked" style="margin-left:1px" /><br />
  Evaluaci&oacute;n Masiva&nbsp;<input type="radio" name="tipo_eva" id="tipo_eva" value="1" style="margin-left:18px" /><br /><br />
  
<div id="bottoncontrol">
  <input name="crearbloque" type="button" class="botonXX" onClick="insertarbloque(0)" value="Crear" />
</div>

</div>

<div id="table_evaluadores">

</div>


</fieldset>






</div>




</body>
</html>
