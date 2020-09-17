<? session_start();
 $x = $_GET['x'];
 	$rdb=$_INSTIT;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Entrevista</title>

<script type="text/javascript">

$(document).ready(function(){ // Script para cargar al inicio del modulo

	cargarselect(<?=$_ANO_CEDE?>,1);
 
});


	function cargarselect(param,fun){
		
		if(fun==1){
	       var parametros = "funcion="+fun+"&ano="+param;
		   var selec = "select_bloque";
		 // alert("1"+parametros);
		   }
		
		if(fun==2){
		  var rdb="<?=$rdb;?>";		
	      var parametros = "funcion="+fun+"&id_bloque="+param+"&tipo="+<?=$x?>+"&rdb="+rdb;
		  var selec = "select_plantilla";
		  //alert("2"+parametros);
	      }
       
   		if(fun==3){
			
		  var rdb="<?=$rdb;?>";	
	      var parametros = "funcion="+fun+"&id_plantilla="+param+"&tipo="+<?=$x?>+"&rdb="+rdb;
		  var selec = "Pauta_Entrevista";
		  //alert("3"+parametros);
	      }
	      
	      
		$.ajax({
		  url:'mod/Entrevistas/Cont_Entrevistas.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				if(data==0){
				  alert("Error al Cargar Select");
				}else{ 
				$('#'+selec+'').html(data);
		        }
			   }
		     })
	       } // fin funcion
		   

      function publico_entrevista(){
	  //cargar datos por ajax
      $.ajax({
		        url:'mod/Entrevistas/Cont_Entrevistas.php',
			    data: $('#entrevista_patoc').serialize(),
				type: 'POST',
				success: function(data){
				  if(data==0){  
				  	 alert("Datos no Guardados Intentar Nuevamente");		
				  }else{ 
				  	alert("Datos Guardados");   
				  }
				}
			})
			
		   
		   //$("#entrevista_patoc").reset();
		   
		document.getElementById("entrevista_patoc").reset();
		   
							  	
		} // fin funcion 


</script>

<style>

#bloques{ margin:10px; margin-top:5px; text-align:left; width:%; }
#table_items{  margin:5px; margin-top:5px; padding:3px;  }
#nombre_bloque{ margin-top:5px; padding:10px; margin:10px; width:90%; }
#procesar_datos{ top:5px; }

</style>


</head>
<body>

<div id="Entrevista" >

<fieldset>
<?php
	if ($x==1){

?>
<legend><strong><?=htmlentities("Entrevistas Apoderado",ENT_QUOTES,'UTF-8')?></strong></legend>
<?php
	}else{
		
	?>
    <legend><strong><?=htmlentities("Entrevistas Alumno",ENT_QUOTES,'UTF-8')?></strong></legend>
    
    <?	
	}
?>
<br>

<div id="select_bloque">&nbsp;</div>

<br>

<div id="select_plantilla">
<label>Seleccionar Plantilla&nbsp;:&nbsp; &nbsp; 
 <select name="selectplantilla" id="selectplantilla">
<option value=0 selected="selected" >Selecccionar</option>
</select>
</label>

</div>

<br>

</fieldset>

<div id="Pauta_Entrevista"></div>


<div id="Resultados_2"></div>



</body>
</html>