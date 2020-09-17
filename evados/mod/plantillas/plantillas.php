<? session_start();

echo "Nacionals-->".$_NACIONAL; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Pauta Evaluacion</title>

<link rel="stylesheet" type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css">
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>
      
<script type="text/javascript">
$(document).ready(function(){ // Script para cargar al inicio del modulo

cargarselect(<?=$_ANO?>,7);
//cargarselect(0,9);
cargarselect(0,10);
cargarselect(0,101);
//cargarplantilla(0);
	
 $('#table_items').html(' <label>Tabla Indicadores</label><table id="flex1" style="display:none" ><thead><tr align="center" ><th width="300" >&nbsp;</th></tr></thead><tbody><tr align="center" ><td>&nbsp;</td></tr><tbody></table>');
							  
	$("#flex1").flexigrid({
		width : 600,
		height : 100
	  });

//$(window).scrollTop(300);
	
});


	function cargarselect(param,fun){

		if(fun==7){
	       var parametros = "funcion="+fun+"&ano="+param;
		   var selec = "select_bloque";
		   //alert(parametros);
		  }
		
		if(fun==9){
	      var parametros = "funcion="+fun+"&id_bloque="+param;
		  var selec = "select_plantilla";
	      }
		
		if(fun==10){
	       var parametros = "funcion="+fun;
		   var selec = "select_Area";
		  }
		 
		  if(fun==101){
			 var parametros = "funcion="+fun;
		     var selec = "select_funcion";
		    }
		 
		 if(fun==11){
		 
            var parametros = "funcion="+fun;
			
					 if($("#selectplantilla").val()!=0){
						   parametros = parametros+"&id_plantilla="+$("#selectplantilla").val();
						  }
						  
					 if($("#select_areas").val()!=0){
						 parametros = parametros+"&id_area="+$("#select_areas").val();
					   }	  
					
					 if($("#select_subareas").val()!=0){
					   parametros = parametros+"&id_subarea="+$("#select_subareas").val();
					  }
				  
			 var selec = "table_items";
			 //alert(parametros);
		   }
		 
		$.ajax({
		  url:'mod/plantillas/cont_plantillas.php',
		  //url:'cont_bloques.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
			
			//alert(data);
			
                if(data==0){
				  alert("Error al Cargar Select");
				}else{

					  $('#'+selec+'').html(data);

							  if(fun==11){
								   $("#flex1").flexigrid({
									width : 700,
									height : 300
									});
								  }

				  }
		        }
		     })
	       } // fin funcion
			  
	



	function buscar_procesar(fun,procez){
		
		if(fun==13){
			
		    if($("#selectplantilla").val()==0){
			  alert("Seleccionar Plantilla");
			  return false;
			  }
			  
		  var param = $('#selectplantilla').val(); 
	      var parametros = "funcion="+fun+"&id_plantilla="+param+"&param="+procez;
		 }
		 
		 if(fun==14){
			 
		    if($("#select_areas").val()==0){
			  alert("Seleccionar Area");
			  return false;
			  }
		  var param = $('#select_areas').val();
	      var parametros = "funcion="+fun+"&id_area="+param+"&param="+procez;
		 }
		 
		 
		 if(fun==155){

		  	if($("#select_subareas").val()==0){
			  alert("Seleccionar SubArea");
			  return false;
			  }
	      var parametros = "funcion="+fun+"&id_subarea="+$('#select_subareas').val()+"&param="+procez;
		  
		 }
		 
        if(fun==24){
			var parametros = "funcion="+fun+"&id_item="+procez;
			
			} 
			
		$.ajax({
		  url:'mod/plantillas/cont_plantillas.php',
		  data:parametros,
		  type:'POST',
			success:function(data){

                if(data==0){
				  alert("Error al Cargar");
				}else{
		          
				  if(fun!=24){
					  
				  $('#procesar_datos').html(data);
				  $('#procesar_datos').dialog({ autoOpen:true,width:500,height:200,modal:true,
							buttons: {
							  'Aceptar': function(){  
							      
								  if(fun==13){
								  if(procez==2){ funcion_guardar_datos(16,1); } // actualizar datos  elem 1 = plantilla 
								  if(procez==3){ funcion_eliminar_datos(17,1); } // eliminar datos  plantilla
								  }
								  
								  if(fun==14){
								  if(procez==2){ funcion_guardar_datos(19,2); } // actualizar datos  elem 1 = plantilla 
								  if(procez==3){ funcion_eliminar_datos(20,2); } // eliminar datos  plantilla
								  }
								  
								  if(fun==155){
								  if(procez==2){ funcion_guardar_datos(192,4); } // actualizar datos  elem 1 = plantilla 
								  if(procez==3){ funcion_eliminar_datos(202,4); } // eliminar datos  plantilla
								  }
								  
								  $(this).dialog('close');
								   
								  },
							  'Cancelar': function(){ $(this).dialog('close');}
							 }
						   });
				     
					 }else{
						 
						$("#Ingresar_Item").html(data);					    
					    
					  }
				  
				  }
		        }
		     })
	       } // fin funcion
		   



		function ventana_ingreso(fun_int){
			
			var html="";
				
			if(fun_int==13){
	
			html = html+'<br><br><label>Nombre Plantilla : <input type="input" name="nombre_plantilla" id="nombre_plantilla"  value="" /></label>';
			html = html+'<input type="hidden" name="id_plantilla" id="id_plantilla"  value="" />';
			
			}

			if(fun_int==14){
	
			html = html+'<br><br><label>Nombre Area : <input type="text" name="nombre_area" id="nombre_area"  value="" /></label>';
			html = html+'<input type="hidden" name="id_plantilla" id="id_plantilla"  value="" />';
			
			}
	
			if(fun_int==15){
	
			html = html+'<br><br><label>Nombre SubArea : <input type="text" name="nombre_subarea" id="nombre_subarea"  value="" /></label>';
			html = html+'<input type="hidden" name="id_plantilla" id="id_plantilla"  value="" />';
			
			}
			
			$('#procesar_datos').html(html);
			 
			$('#procesar_datos').dialog({ autoOpen:true,width:500,height:200,modal:true,
					buttons: {
					  'Aceptar': function( ){
						
						if(fun_int==13){ funcion_guardar_datos(15,1); } // ingresar datos  plantilla parametro 1 = plantilla 
						
						if(fun_int==14){ funcion_guardar_datos(18,2); } // ingresar datos 2 area
						
						if(fun_int==15){ funcion_guardar_datos(182,4); } // ingresar datos 3 subarea
						
						$(this).dialog('close');
					  
					  },
					  'Cancelar': function(){ $(this).dialog('close');}
					 }
				   });
		
			} // fin funcion


              
	    function funcion_guardar_datos(fun,elem){
		    

		  
		  if(elem==1){ // es instruccion para plantilla.
		  
		  	if($("#selectbloque").val()==0){
			  alert("Seleccionar Cargo");
			  return false;
			  }
			  
		  
			  if(fun==15){  // ingresa datos plantilla 
				  
				  var parametros = "funcion=15&nombre_plantilla="+$("#nombre_plantilla").val()+"&id_bloque="+$("#selectbloque").val();	
				  
				  }
				  
			 if(fun==16){ // actualiza datos plantilla 
				 
				 if($("#selectplantilla").val()==0){
					 alert("Seleccionar Nombre Plantilla");
					 return false;
					 }
				 
				  var parametros = "funcion=16&nombre_plantilla="+$("#nombre_plantilla").val()+"&id_bloque="+$("#selectbloque").val()+"&id_plantilla="+$("#selectplantilla").val();
				  
				  }	  
			  
		      } // fin elem == 1
			  
			  
			  if(elem==2){ // es instruccion para area.
		  
			  if(fun==18){  // ingresa datos area 
				  
				/*   if($("#selectplantilla").val()==0){
					 alert("Seleccionar Nombre Plantilla");
					 return false;
					 }*/
					 
				  var parametros = "funcion=18&nombre_area="+$("#nombre_area").val();	
				  
				  }
				  
			 if(fun==19){ // actualiza datos area
				 
				 if($("#nombre_area").val()==0){
					 alert("Seleccionar Nombre Area");
					 return false;
					 }
				 
				 var parametros = "funcion=19&nombre_area="+$("#nombre_area").val()+"&id_plantilla="+$("#selectplantilla").val()+"&id_area="+$("#select_areas").val();
				  
				  }	  
			  
		      } // fin elem == 2
			  
			  
			if(elem==3){ // es instruccion para item.
		      
			  	if($("#selectplantilla").val()==0){
				 alert("Seleccionar Nombre Plantilla");
				 return false;
				}
					 
				if($("#select_areas").val()==0){
				 alert("Seleccionar Nombre Plantilla");
				 return false;
				}
					 
				if($("#select_subareas").val()==0){
				 alert("Seleccionar Nombre Plantilla");
				 return false;
				}
			  
			  if(fun==21){  // ingresa datos plantilla 
					 
				var parametros = "funcion=21&id_area="+$("#select_areas").val()+"&id_plantilla="+$("#selectplantilla").val()+"&id_subarea="+$("#select_subareas").val()+"&nombre_item="+$("#ingresoitem").val();	
				  
				  }
				  
			 if(fun==22){ // actualiza datos item
			 
				 var parametros = "funcion=22&id_area="+$("#select_areas").val()+"&id_plantilla="+$("#selectplantilla").val()+"&id_subarea="+$("#select_subareas").val()+"&nombre_item="+$("#ingresoitem").val()+"&id_item="+$("#id_item").val();
				  
				  }	  
			  
		      } // fin elem == 3
		  
          
		  
		  	if(elem==4){ // es instruccion para subarea
		      
/*			  	if($("#selectplantilla").val()==0){
				 alert("Seleccionar Nombre Plantilla");
				 return false;
				}
					 
				if($("#select_areas").val()==0){
				 alert("Seleccionar Nombre Plantilla");
				 return false;
				}*/


			  if(fun==182){  // ingresa datos subarea 
				 var parametros = "funcion=182&nombre_subarea="+$("#nombre_subarea").val();
				 }
				  
			 if(fun==192){ // actualiza datos subarea
			 
			 
			 if($("#select_subareas").val()==0){
				 alert("Seleccionar Nombre Sub Area");
				 return false;
				}
				
				 var parametros = "funcion=192&id_area="+$("#select_areas").val()+"&id_plantilla="+$("#selectplantilla").val()+"&id_subarea="+$("#select_subareas").val()+"&nombre_subarea="+$("#nombre_subarea").val();
				  
				  }	  
			  
		      } // fin elem == 3
		  
		//alert(parametros);
		  
		  $.ajax({
		  url:'mod/plantillas/cont_plantillas.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				
				//alert(data)
				
				  if(data==1){

                   alert("Dato Guardado");
				   
				   if(elem==1)cargarselect($("#selectbloque").val(),9);
				   
				   if(elem==2)cargarselect(0,10);
				   
				    if(elem==4)cargarselect(0,101);
					
				   if(elem==3){
					
					cargarselect(0,11);
				   
				  $("#Ingresar_Item").html('<label>Ingresar Indicadores:</label><br><textarea name="ingresoitem" cols="70" rows="3" id="ingresoitem"></textarea><div id="botton_proceso" ><input type="button" name="" id=""  value="+" class="botonXX" onclick="funcion_guardar_datos(21,3)" />');
				   
				   }
				   
				  }else{
		           alert("Error al Guardar Datos");				  
				  }
				  
		      }
		  })
			   
  }// fin funcion 	  
		

function funcion_eliminar_datos(fun,elem,id){
	
			  
	if(elem==1){
	 if(fun==17){ 
	 
	  if($("#selectplantilla").val()==0){
		alert("Seleccionar Nombre Plantilla");
		return false;
		}
					 
		var parametros = "funcion=17&id_plantilla="+$("#id_plantilla").val(); 
	 
	  }
	 }
   
    
	if(elem==2){
	 if(fun==20){ 
	 
	  if($("#select_area").val()==0){
		alert("Seleccionar Nombre Area");
		return false;
		}
					 
		var parametros = "funcion=20&id_area="+$("#select_areas").val(); 
	 
	  }
	 }
    
	if(elem==4){
	 if(fun==202){  
	 
	  if($("#select_subareas").val()==0){
		alert("Seleccionar Nombre SubArea");
		return false;
		}
					 
		var parametros = "funcion=202&id_subarea="+$("#select_subareas").val(); 

	  }
	 }
    
	if(elem==3){
	 if(fun==23){ 
	 				 
		var parametros = "funcion=23&id_item="+id; 
	 
	  }
	 }
		 
 	$.ajax({
		url:'mod/plantillas/cont_plantillas.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==1){	
				
				alert("Dato Eliminado");
				if(elem==1){ cargarselect($("#selectbloque").val(),9); }
				if(elem==2){ cargarselect($("#selectplantilla").val(),10); }
				if(elem==4)cargarselect($("#select_areas").val(),101);
				if(elem==3)cargarselect($("#select_subareas").val(),11);
				
				}else{
					
					alert("Error Sistema"+data);
					
					}
								
		}
	})
 
 } // fin eliminar */

 
 
 	function vistaprevia(id,param){
        
		if(param==1){
		
		if($("#selectplantilla").val()==0){
		   alert("Seleccionar Nombre Plantilla");
		   return false;
		  }
		
		var parametros = "funcion=25&id_plantilla="+$("#selectplantilla").val(); 
		
		}
		
		if(param==2){
	     // var parametros = "funcion=26&id_item="+id; 
		  var fun=26;
		  var procez=id;
		  var parametros = "funcion="+fun+"&id_item="+procez+"&id_plantilla="+$('#selectplantilla').val()+"&id_area="+$('#select_areas').val()+"&id_sub_area="+$('#select_subareas').val();
			//alert(parametros);
		 }
         
		 
		// alert(parametros);
		 
		$.ajax({
		  url:'mod/plantillas/cont_plantillas.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
		
                if(data==0){
				  alert("Error al Cargar");
				}else{
				  
				 if(!$('#procesar_datos').html()){  
				     $('#bloques').append('<div id="procesar_datos"></div>');	  
				    }
				
				  $('#procesar_datos').html(data);
				  
				  if(param==2){
					   $("#flex4").flexigrid({
						width : 600,
						height : 200
						});
					  }
				   	
					if(param==2){
					  
					  $('#procesar_datos').dialog({ autoOpen:true,width:650,height:500,modal:true,title: "Asignar Bloques",
								buttons: {
								  'Aceptar': function(){  
						  			  $(this).dialog('close');
								     },
								  }
							   });
						
						}else{	   			  
					        
							$('#procesar_datos').dialog({ autoOpen:true,width:800,height:800,modal:true,title: "Pauta Evaluacìon",
								buttons: {
								  'Aceptar': function(){  
						  			  $(this).dialog('close');
								     },
								  }
							   });
				           }
						   
				  }
		        }
		     })
	       } // fin funcion
 
     
	 function vincular_bloque(fun,idbloq,iditem){
	 
	     if($("#selectplantilla").val()==0){
		      alert("Seleccionar Nombre Plantilla");
		      return false;
		    }
		  
		if($("#select_area").val()==0){
		    alert("Seleccionar Nombre Area");
		    return false;
		  }
		  
		if($("#select_subareas").val()==0){
		     alert("Seleccionar Nombre SubArea");
		     return false;
		   }

if(fun==27){
var parametros = "funcion="+fun+"&id_plantilla="+$("#selectplantilla").val()+"&id_area="+$("#select_areas").val()+"&id_subarea="+$("#select_subareas").val()+"&id_item="+iditem+"&id_bloque="+idbloq; 
		}
		
if(fun==28){
var parametros = "funcion="+fun+"&id_plantilla="+$("#selectplantilla").val()+"&id_area="+$("#select_areas").val()+"&id_subarea="+$("#select_subareas").val()+"&id_item="+iditem+"&id_bloque="+idbloq; 
}		
//alert(parametros);
					   
		  $.ajax({
		  url:'mod/plantillas/cont_plantillas.php',
		  data:parametros,
		  type:'POST',
			  success:function(data){
				//  alert(data)
					if(data==1){
					  //alert("Dato Ingresado Ok");
					  //$(window).scrollTop(500);
					  $('#procesar_datos').remove();
					  //$('#procesar_datos').dialog.('close');
					  vistaprevia(iditem,2);
					}else{
					    alert("Error al Ingresar Dato");
					}
				}
		 })
    }
 
</script>
<style>
body{ font:Georgia, "Times New Roman", Times, serif; size:10px;}
#bloques{ margin:10px; margin-top:5px; text-align:left; width:%; }
#table_items{  margin:5px; margin-top:5px; padding:3px;  }
#nombre_bloque{ margin-top:15px; padding:20px; border:solid 1px; margin:20px; width:90%; }
#procesar_datos{ top:5px; }
#vistaprevia{ font:"Times New Roman", Times, serif; font-size-adjust:12px; font-size:12px;}
</style>
</head>
<body>
<div id="bloques" >
<fieldset>
<legend><strong><?="Creación de Pauta de Evaluación"; /*htmlentities("",ENT_QUOTES,'UTF-8')*/?></strong></legend>
<div id="nombre_bloque">
<br>
<div id="select_bloque">&nbsp;</div>
<br>
<div id="select_plantilla">
<label>Seleccionar Pauta de Evaluaciòn:  
 <select name="selectplantilla" id="selectplantilla">
<option value=0 selected="selected" >Selecccionar</option>
</select>
</label>
</div>
<br>
<div id="select_Area">
<label>Seleccionar Dimención:  
<select name="selectArea" id="selectAreaa">
<option value=0  selected="selected" >Selecccionar</option>
</select>
</label>
</div>
<br>
<div id="select_funcion">
<label>Seleccionar  Función:    
<select name="selectfuncion" id="selectfuncion">
<option value=0  selected="selected" >Selecccionar</option>
</select>
</label>  
</div>
<br>
<div id="Ingresar_Item"  style="width:100%">
<label>Ingresar Indicador:</label><br> 
<textarea name="ingresoitem" cols="70" rows="3" id="ingresoitem"></textarea>
<div id="botton_proceso" >
  <input type="button" name="input" id="input"  value="+" class="botonXX" onclick="funcion_guardar_datos(21,3)" />
</div>
</div>
<div id="table_items"></div>
</div>
</fieldset>
<div id="procesar_datos"></div>
</div>
</body>
</html>
