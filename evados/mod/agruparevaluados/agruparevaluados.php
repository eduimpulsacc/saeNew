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

	cargarselectbloque(<?=$_ANO?>);
	//cargartablaevaluadores(0);
      $("#flex1").flexigrid({
		width : 620,
		height : 150
		});
	  
});



		function insertarevaluado(rut){

			var idbloque = $('#selectbloque').val();
			var idcargo = $('#cmbCARGO').val();
			
			if(idcargo == 0 ){ 
			   alert("Seleccionar Cargo"); 
			   return false;
			   }
			
			if( idbloque != 0 ){
			
			var parametros = "funcion=0&id_bloque="+$('#selectbloque').val()+"&rut_evaluado="+rut+"&id_cargo="+$('#cmbCARGO').val();
			
				$.ajax({
				  url:'mod/agruparevaluados/cont_agruparevaluados.php',
				  data:parametros,
				  type:'POST',
				  success:function(data){
							   if(data==1){
								   cargartablaevaluados(idcargo);
								}else{
								   alert("Error al Insertar Evaluador");
								}
			
							 }
			
						 });
			  
			  }else{
			      alert('Seleccionar Un Bloque');
			      return false;
				}
		 }// fin funcion 
 
 
 
	function cargarselectbloque(ano){
	    var parametros = "funcion=3";
		$.ajax({
		  url:'mod/agruparevaluados/cont_agruparevaluados.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#select_bloque').html(data);
						}
				     }
		         })
	          } // fin funcion
 
  
			function cargartablaevaluados(id_cargo){
				var parametros = "funcion=6&id_cargo="+id_cargo;
					$.ajax({
					  url:'mod/agruparevaluados/cont_agruparevaluados.php',
					  data:parametros,
					  type:'POST',
						success:function(data){
								if(data==0){
								  alert("Error al Cargar");
								}else{
									$('#tabla_evaluadores').html(data);
									  $("#flex1").flexigrid({
										width : 620,
										height : 150
									  });
									}
								 }
							 })
			  } // fin funcion
			  


		function eliminarevaluado(rut,idbloq){
		
				var idbloque = $('#selectbloque').val();
				var idcargo = $('#cmbCARGO').val();
		
					if(idcargo == 0 ){ 
					   alert("Seleccionar Cargo"); 
					   return false;
					   }
		
			   if(idbloq!=$('#selectbloque').val()){
				alert("El Bloque seleccionado tiene que ser el mismo que tiene El Evaluador");
				return false;	 
				 }
		
			   if(idbloque == 0 ){ 
			   alert("Seleccionar Bloque"); 
			   return false;
			   }
		
		 var parametros = "funcion=4&rut_evaluado="+rut+"&id_cargo="+$('#cmbCARGO').val()+"&id_bloque="+$('#selectbloque').val();

					  $.ajax({
					  url:'mod/agruparevaluados/cont_agruparevaluados.php',
					  data:parametros,
					  type:'POST',
						  success:function(data){
							if(data!=1){
								alert("Error al Cargar");
							  }else{	
							      cargartablaevaluados(idcargo);
								}
							 }
					      })
		               } // fin eliminar 
					   
					   
</script>
<style>
#bloques{ margin:10px; margin-top:5px; text-align:left;width:70%; }
#select_bloque{ margin:0px; margin-top:25px; padding:15px; border:solid 1px;width:65%; }
#tabla_evaluadores { margin:0px; margin-top:10px; padding:5px;width:60%; }
</style>
</head>
<body>
<div id="bloques" align="center"  >
<fieldset style="width:60%">
<legend><strong><?=htmlentities("Agrupar Evaluadores:",ENT_QUOTES,'UTF-8')?></strong></legend>
<div id="select_bloque">
</div>
<div id="tabla_evaluadores">
<label for="listaevaluadores">Tabla Evaluados:</label>
<table id="flex1" style="display:none" >
<thead>
<tr align="center" >
<th width="300" >Nombre Completo</th>
<th width="100" >Cargo</th>
<th width="100" >Nombre Bloque</th>
<th width="30" >Agregar</th>
</tr>
</thead>
</table>
</div>
</fieldset>
</div>
</body>
</html>
