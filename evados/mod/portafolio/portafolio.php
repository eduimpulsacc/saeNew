<?
session_start();	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Carga Documentos</title>

<link rel="stylesheet" type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css">
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>
<script type="text/javascript" src="../../js/jquery_autoHeight.js"></script>

        
<script type="text/javascript">

$(document).ready(function(){ // Script para cargar al inicio del modulo

cargarselectcargos();
buscartipodoc(<?=$_INSTIT;?>);
cargartablaevaluados(0);

});


 function buscartipodoc(rbd){
  var parametros = "funcion=8&rbd="+rbd;
  		$.ajax({
		  url:'mod/portafolio/cont_portafolio.php',
		  type:'post',
		  data:parametros,
		  success:function(data){
					if(data!=0){
                      $("#tipodoc").html(data)
					}else{
					  alert("Error al Cargar");
					}
			 }
		 })
    }
 
    function cargarselectcargos(){
	var parametros = "funcion=7";
		$.ajax({
		  url:'mod/portafolio/cont_portafolio.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#select_cargos').html(data);
						}
				     }
		         })
	          } // fin funcion
			  
			  
	function cargartablaevaluados(cargo){
    
	if( cargo != 0 ){
	var parametros = "funcion=9&id_cargo="+cargo;
	
	     $.ajax({
          url:'mod/portafolio/cont_portafolio.php',
		  data:parametros,
		  type:'POST',
				success:function(data){
								if(data==0){
										alert("Error al Cargar");
								}else{
									$('#tabla_evaluados').html(data);
										  $("#flex2").flexigrid({
												width : 550,
												height : 200
											});
									}
						 }
		         })
				}else{

			                 $('#tabla_evaluados').html(' <label for="listaEvaluados">Tabla Evaluados</label><table id="flex2" style="display:none" ><thead><tr align="center" ><th width="300" >Nombre Completo</th></tr></thead><tbody><tr align="center" ><td>&nbsp;</td></tr><tbody></table><input type="hidden" id="rut_empleado" name="rut_empleado" value="">');
							  
					 $("#flex2").flexigrid({
						width : 400,
						height : 100
						});
				
				   } 
				 
	          } // fin funcion	
			  
  
  function carga_rut(rutempl){
   $("#rut_empleado").val(rutempl);  
  }			  
			  
			  
 /*function resultadoUpload(estado, file) {
var link = '<br /><br /><a href="portafolio.php">Subir Archivo</a> - <a href="verArchivos.php">Ver Imagenes</a>';
if (estado == 0)
var mensaje = 'El Archivo <a href="documentos/' + file + '" target="_blank">' + file + '</a> se ha subido al servidor correctamente' + link;
if (estado == 1)
var mensaje = 'Error ! - El Archivo no llego al servdor' + link;
if (estado == 2)
var mensaje = 'Error ! - Solo se permiten Archivos tipo Imagen' + link;
if (estado == 3)
var mensaje = 'Error ! - No se pudo copiar Archivo. Posible problema de permisos en server' + link;
document.getElementById('formUpload').innerHTML=mensaje;
} */

$(document).ready(function() {
  $('#frm').submit();
});



function enviar(){

  if( $("#rut_empleado").val() == "" ){
      alert("Seleccionar Evaluado");
      return false;
    }

   if( $("#tipo_documento").val() == 0 ){
      alert("Seleccionar Tipo Documento");
      return false;
    }
  
    alert("Datos Enviados");
    $('#frm').submit();

 }


</script>
<style>
#bloques{ margin:10px; margin-top:5px; text-align:left; width:%; }
#cargar_archivo{ margin-top:5px; padding:20px; border:solid 1px; margin:10px; }
</style>

</head>
<body>

<div id="bloques" align="center"  >
<fieldset>
<legend><strong><? echo (htmlentities("Cargar Documentos"));?></strong></legend>
<div id="cargar_archivo">
<form  id="frm" name="frm" method="post" enctype="multipart/form-data" action="mod/portafolio/controlUpload.php" target="iframeUpload">

<div id="select_cargos">
</div>
<br>
<div id="tabla_evaluados">
</div>
<br>
<div id="tipodoc">
<label>Tipo Documento:</label>
<select name="tipo_documento" id="tipo_documento">
<option value="0">Seleccionar</option>
</select>
<br><br>
</div>
<br>
Buscar Archivo: <input name="fileUpload" type="file" onchange="javascript:enviar()" />
<br><br>
<iframe name="iframeUpload" id="iframeUpload" width="100%" height="50%" align="bottom"  marginwidth="10%" scrolling="no" class="autoHeight" frameborder="0">
</iframe>
</form> 
</div>
</fieldset>
</div>
</body>
</html>
