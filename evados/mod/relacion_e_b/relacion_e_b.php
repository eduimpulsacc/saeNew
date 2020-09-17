<?php
session_start();
$periodo = $_PERIODO;

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

	cargarselectbloque(<?=$_ANO?>);
	//cargartablaevaluadores(0);
      $("#flex1").flexigrid({
		width : 620,
		height : 500
		});
	  
});



		function insertarevaluador(rut){
		
			var idbloque = $('#selectbloque').val();
			var idcargo = $('#cmbCARGO').val();
			var id_periodo = <?php echo $periodo ?>;
			
			if(idcargo == 0 ){ 
			   alert("Seleccionar Cargo"); 
			   return false;
			   }
			
			if( idbloque != 0 ){
			
			var parametros = "funcion=0&id_bloque="+$('#selectbloque').val()+"&rut_evaluador="+rut+"&id_cargo="+$('#cmbCARGO').val()+"&id_periodo="+id_periodo;
			
				$.ajax({
				  url:'mod/relacion_e_b/cont_relacion_e_b.php',
				  //url:'cont_bloques.php',
				  data:parametros,
				  type:'POST',
					  success:function(data){
						console.log(data);
							   if(data==1){
								   cargartablaevaluadores(idcargo);
								}else{
								   alert("Error al Insertar Evaluador");
								}
			
							 }
			
						 });
			  
			  }else{
				
				alert('Seleccionar Un Bloque');
				
				
				}
		
		 }// fin funcion 
 
 
 
	function cargarselectbloque(ano){
	    var parametros = "funcion=3&ano="+ano;
		$.ajax({
		  url:'mod/relacion_e_b/cont_relacion_e_b.php',
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
 
 
 
 
			function cargartablaevaluadores(id_cargo){
				
		var id_periodo = "<?=$periodo?>";
				//var parametros = "funcion=6&id_cargo="+id_cargo;
		var parametros =  "funcion=6&id_cargo="+id_cargo+"&id_periodo="+id_periodo;
			     
				 //alert(parametros);
				
					$.ajax({
					  url:'mod/relacion_e_b/cont_relacion_e_b.php',
					  //url:'cont_bloques.php',
					  data:parametros,
					  type:'POST',
						success:function(data){
					      //alert(data);
								if(data==0){
										alert("Error al Cargar");
								}else{
			
									$('#tabla_evaluadores').html(data);
										  
										  $("#flex1").flexigrid({
												width : 620,
												height : 500
											});
										
									}
								 }
							 })
			  } // fin funcion
			  


		function eliminarevaluador(rut){
		    
			var idbloque = $('#selectbloque').val();
		 	var idcargo = $('#cmbCARGO').val();
			var id_periodo = "<?=$periodo?>";
			if(idcargo == 0 ){ 
			   alert("Seleccionar Cargo"); 
			   return false;
			   }
			   
			/*   if($('#id_bloque_evaluador').val()!=$('#selectbloque').val()){
				alert("El Bloque seleccionado tiene que ser el mismo que tiene El Evaluador");
				return false;	 
				 }*/
			   
			   if(idbloque == 0 ){ 
			   alert("Seleccionar Bloque"); 
			   return false;
			   }
			   
			   
		 var parametros = "funcion=4&rut_evaluador="+rut+"&id_cargo="+$('#cmbCARGO').val()+"&id_bloque="+$('#selectbloque').val()+"&id_periodo="+id_periodo;

					  $.ajax({
					  url:'mod/relacion_e_b/cont_relacion_e_b.php',
					  data:parametros,
					  type:'POST',
						  success:function(data){
							//alert(data)
							if(data!=1){
								alert("Error al Borrar");
							  }else{	
							   cargartablaevaluadores(idcargo);
								}
										
							 }
					  })
		 
		 } // fin eliminar 

 
 function aviso(dato){
	if(dato==17){
		alert("BLOQUE NO APERATIVO PARA ESTE PERIODO");	
	}
 }
 
 function selevat(){
var cadeva = $('#cadeva').val();
var idcargo = $('#cmbCARGO').val();
var idbloque = $('#selectbloque').val();
var idperiodo = "<?=$periodo?>";
	   
		 var parametros = "funcion=7&cadeva="+cadeva+"&idcargo="+idcargo+"&idbloque="+idbloque+"&idperiodo="+idperiodo;	
		 
		 if ($('#selt').is(':checked') && confirm("Confirma asignar a todos como evaluadores?")){
$.ajax({
					  url:'mod/relacion_e_b/cont_relacion_e_b.php',
					  data:parametros,
					  type:'POST',
						  success:function(data){
							//alert(data)
							if(data!=1){
								alert("Error al Borrar");
							  }else{	
							   cargartablaevaluadores(idcargo);
								}
										
							 }
					  }) 
		 }//fin confirm
 }
</script>

<style>

#bloques{ margin:10px; margin-top:5px; text-align:left;width:90%; }
#select_bloque{ margin:0px; margin-top:25px; padding:15px; border:solid 1px;width:65%; }
#tabla_evaluadores { margin:0px; margin-top:10px; padding:5px;width:60%; }

</style>

</head>
<body>
<div id="bloques" align="center"  >
<fieldset style="width:100%">
<legend><strong><?=htmlentities("Relación Bloques Evaluadores",ENT_QUOTES,'UTF-8')?></strong></legend>
<div id="select_bloque">
</div>
<div id="tabla_evaluadores">
<label for="listaevaluadores">Tabla Evaluadores</label>
<table id="flex1" style="display:none" >
<thead>
<tr align="center" >
<th width="300" >Nombre Completo</th>
<th width="100" >Cargo</th>
<th width="100" >Nombre Bloque</th>
<th width="30" >Edit</th>
</tr>
</thead>
<tbody>
<tr align="center" >
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td></td>
</tr>
</tbody>
</table>
</div>
</fieldset>

</div>
</body>
</html>
