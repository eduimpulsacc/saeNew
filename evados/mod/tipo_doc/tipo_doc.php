<? 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Armar Bloques</title>

<link rel="stylesheet" type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css">
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>
        
<script type="text/javascript">
$(document).ready(function(){ // Script para cargar al inicio del modulo
cargartabla();
});

	function cargardatos(fu){
	
		if($('#tipodoc').val()==""){
			alert("Debe Ingresar un Nombre de Documento");
			$('#tipodoc').val().focus();
			return false;
		}
		
		var parametros = "funcion="+fu+"&tipodoc="+$('#tipodoc').val();
		if($('#_id_tipo'))  parametros = parametros+"&_id_tipo="+$('#_id_tipo').val();
		
		$.ajax({
		  url:'mod/tipo_doc/cont_doc.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
					   if(data==1){
						   alert("Se Cargaron los Datos");
						   cargartabla();
						}else{
						   alert("Error de Sistema");
						}
					 }
				 });
	
				$('#tipodoc').val("");
				$('#bottoncontrol').html('<br><input name="creardoc" type="button" onClick="cargardatos(0)" value="Crear" class="botonXX"/>');
				
	 }// fin funcion cargadatos
 
 
	function cargartabla(){
	var parametros = "funcion=3";
		$.ajax({
		  url:'mod/tipo_doc/cont_doc.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#table_evaluadores').html(data);
						
						$("#flex1").flexigrid({
								width : 400,
								height : 100
							});
						}
				     }
		         })
	          } // fin funcion cargartabla
 
 
	 function buscardoc(iddoc){
	   var parametros = "funcion=6&iddoc="+iddoc;
	   
			$.ajax({
			  url:'mod/tipo_doc/cont_doc.php',
			  type:'post',
			  //dataType: 'json',
			  data:parametros,
			  success:function(data){
						if(data!=0){
						
						 $('#respuestabuscardoc').html(data);			  
	
						$('#tipodoc').val($('#_nombre').val());
	
	$('#bottoncontrol').html('<br><input name="Modificar" type="button" class="botonXX" onClick="cargardatos(1)" value="Modificar" />');
	
						}else{
						  alert("Error al Cargar");
						}
				 }
			 })
		}
 
		 function EliminaDoc(a){
			var parametros = "funcion=5&tipo="+a;
			$.ajax({
				url:'mod/tipo_doc/cont_doc.php',
				//url:'cont_doc.php',
				data:parametros,
				type:'POST',
				success:function(data){
					if(data==0){
						alert("Error en la Eliminación");
					}else{
						cargartabla();
					}
				}
			})
		 }
 
</script>
<style>
#bloques{ margin:10px; margin-top:40px; margin-left:10%; text-align:left; width:80%; }
#table_evaluadores{  margin:10px; margin-top:25px; padding:15px;  }
#botton{ margin-top:10px; padding:15px; }
#nombre_bloque{ margin-top:15px; padding:3px; border:solid 1px; margin-bottom:5px; }
</style>

</head>
<body>
<div id="respuestabuscardoc">&nbsp;</div>
<div id="bloques" align="center"  >

<fieldset>
<legend>Tipo de Documentos</legend>

<div id="nombre_bloque">
																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																				 <br>
  <label for="nombrebloque">Tipo Documento:</label>
  <input name="tipodoc" type="text" id="tipodoc" size="20" maxlength="100" />
  <div id="bottoncontrol"><br>
  <input name="creardoc" type="button" onClick="cargardatos(0)" value="Crear" class="botonXX"/>
  </div>
</div>

<div id="table_evaluadores">

</div>

<div id="botton" >

</div>

</fieldset>






</div>




</body>
</html>
