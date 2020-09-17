<? session_start(); 
$rdb=$_INSTIT;
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Configuracion Entrevista</title>


<link rel="stylesheet" type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css">
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>
      
<script type="text/javascript">

$(document).ready(function(){ // Script para cargar al inicio del modulo

cargarselect(<?=$_ANO_CEDE?>,7);
	
 $('#table_items').html(' <label>Tabla Indicadores</label><table id="flex1" style="display:none" ><thead><tr align="center" ><th width="300" >&nbsp;</th></tr></thead><tbody><tr align="center" ><td>&nbsp;</td></tr><tbody></table>');
							  
	$("#flex1").flexigrid({
		width : 600,
		height : 100
	  });

//$(window).scrollTop(300);

//Button
$( "input:submit,input:button,a,button", "#bloques" ).button();
$( "a", "#bloques" ).click(function() { return false; });

});

	function cargarselect(param,fun){

		if(fun==7){
	       var parametros = "funcion="+fun+"&ano="+param;
		   var selec = "select_bloque";
		   }
		
		if(fun==9){
	      var parametros = "funcion="+fun+"&id_bloque="+param;
		  var selec = "select_plantilla";
	      }
		
		if(fun==10){
	       var parametros = "funcion="+fun;
		   var selec = "select_Area";
		  }
		 
		 if(fun==11){
		 
            var parametros = "funcion="+fun;
			
			if($("#selectplantilla").val()!=0){
			   parametros = parametros+"&id_plantilla="+$("#selectplantilla").val();
			 }
						  
			if($("#select_areas").val()!=0){
			  parametros = parametros+"&id_area="+$("#select_areas").val();
			 }	  
				  
			var selec = "table_items";

		   }
		   
		   	if(fun==111){
		 
            var parametros = "funcion=11";
			
			if($("#selectplantilla").val()!=0){
			   parametros = parametros+"&id_plantilla="+$("#selectplantilla").val();
			 }
						  
			if($("#select_areas").val()!=0){
			  parametros = parametros+"&id_area="+$("#select_areas").val();
			 }	  
				  
			var selec = "table_items";

		   }
		 
		$.ajax({
		  url:'mod/Conf_Entrevistas/Cont_Conf_Entrevistas.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
                if(data==0){
				  alert("Error al Cargar Select");
				}else{ 

				$('#'+selec+'').html(data);
				 				
				if(fun==11){ 
				cargar_conceptos();  
				carga_areas();  
				$("#flex1").flexigrid({ width : 600, height : 100 });  }
				
				if(fun==111){  
				$("#flex1").flexigrid({ width : 600, height : 100 }); }
				
				$( "input:submit,input:button,a,button", "#bloques" ).button();
				
				  }
		        }
		     })
	       } // fin funcion
	
			  
	function cargar_conceptos(){
	   var parametros = "funcion=1122";
	   if($("#selectplantilla").val()!=0){
	   parametros = parametros+"&id_plantilla="+$("#selectplantilla").val();
		$.ajax({
		  url:'mod/Conf_Entrevistas/Cont_Conf_Entrevistas.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
                if(data==0){
				  alert("Error al Cargar Select");
				}else{
				$('#select_Concepto').html(data);
				$( "input:submit,input:button,a,button", "#bloques" ).button();
				  }
		        }
		     })
		   }
		}

   
   function carga_areas(){
	   var parametros = "funcion=1123";
	   if($("#selectplantilla").val()!=0){
	   parametros = parametros+"&id_plantilla="+$("#selectplantilla").val();
	   $.ajax({
		  url:'mod/Conf_Entrevistas/Cont_Conf_Entrevistas.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
                if(data==0){
				  alert("Error al Cargar Select");
				}else{
				$('#select_Area').html(data);
				$( "input:submit,input:button,a,button", "#bloques" ).button();
				  }
		        }
		     })
	       }
	     }
   

	function buscar_procesar(fun,procez){
		if(fun==13){
		    if($("#selectplantilla").val()==0){
			  alert("Seleccionar Plantilla");
			  return false;
			  }
		  var rdb="<?=$rdb?>" 
		  var param = $('#selectplantilla').val(); 
	      var parametros = "funcion="+fun+"&id_plantilla="+param+"&param="+rdb+"&param="+rdb;
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
  	      if($("#selectConcepto").val()==0){
			  alert("Seleccionar Concepto");
			  return false;
			  }
	      var parametros = "funcion="+fun+"&id_concepto="+$('#selectConcepto').val()+"&param="+procez;
		 }
		 
        if(fun==24){
			var parametros = "funcion="+fun+"&id_item="+procez;
			} 
		
		$.ajax({
		  url:'mod/Conf_Entrevistas/Cont_Conf_Entrevistas.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
                if(data==0){ 
					 alert("Error al Cargar");
				}else{
				  if(fun!=24){
				  $('#procesar_datos').html(data);
				  $('#procesar_datos').dialog({ autoOpen:true,width:500,height:340,modal:true,
							buttons: {
							  'Aceptar': function(){  
								  if(fun==13){
								  		if(procez==2){ funcion_guardar_datos(16,1); }   // ACTUALIZAR PLANTILLA 
								  		if(procez==3){ funcion_eliminar_datos(17,1); }   // ELIMINAR PLANTILLA
								  }
								  if(fun==14){
								  		if(procez==2){ funcion_guardar_datos(19,2); }    //   ACTUALIZAR AREA
								  		if(procez==3){ funcion_eliminar_datos(20,2); }   //   ELIMINAR AREA
								  }
								  if(fun==155){
								  		if(procez==2){ funcion_guardar_datos(193,4); }   //  ACTUALIZAR  CONCEPTO
								 		 if(procez==3){ funcion_eliminar_datos(194,4); }   //  ELIMINAR CONCEPTO
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
			html = html+'<fieldset><legend>Ingresar Nombre de Plantilla</legend><label>Nombre Plantilla : <input type="text" name="nombre_plantilla" id="nombre_plantilla"  SIZE=18 MAXLENGTH=18 value="" /></label><br/><br/><input type="radio" name="group1" value="0" checked >Plantilla para Alumno<br><input type="radio" name="group1" value="1" >Plantilla para Apoderado</fieldset>';
			html = html+'<input type="hidden" name="id_plantilla" id="id_plantilla"  value="" />';
			}
			
			if(fun_int==14){
			html = html+'<fieldset><legend>Ingresar Nombre de Area</legend><br><br><label>Nombre Area : <input type="text" name="nombre_area" id="nombre_area" SIZE=18 MAXLENGTH=18  value="" /></label></fieldset>';
			html = html+'<input type="hidden" name="id_plantilla" id="id_plantilla"  value="" />';
			}
			
			if(fun_int==15){
			html = html+'<fieldset><legend>Ingresar Datos de Concepto</legend><label>Nombre Concepto : <input type="text" name="nombre_concepto" id="nombre_concepto"  SIZE=18 MAXLENGTH=18 value="" /></label><br><br><label>Nombre Glosa : <input type="text" name="glosa_concepto" id="glosa_concepto"  value="" /></label><br><br><label>Nombre Sigla : <input type="text" name="sigla_concepto" id="sigla_concepto"  value="" /></label></fieldset>';
			html = html+'<input type="hidden" name="id_plantilla" id="id_plantilla"  value="" />';
			}
			
			$('#procesar_datos').html(html);
			
			$('#procesar_datos').dialog({ autoOpen:true,width:500,height:330,modal:true,
					buttons: { 
					  'Aceptar': function( ){
						if(fun_int==13){ funcion_guardar_datos(15,1); } // ingresar datos  plantilla parametro 1 = plantilla 
						if(fun_int==14){ funcion_guardar_datos(18,2); } // ingresar datos 2 area
						if(fun_int==15){ funcion_guardar_datos(192,4); } // ingresar datos 3 concepto
						$(this).dialog('close');
					  },
					  'Cancelar': function(){ 
					  $(this).dialog('close');
					  }
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
			  	
			if($("input[name='group1']:checked").val()==0) var persona = "Alumno";
			else  var persona = "Apoderado";
			
			var parametros = "funcion=15&nombre_plantilla="+$("#nombre_plantilla").val()+"&id_bloque="+$("#selectbloque").val()+"&tipo_plantilla="+$("input[name='group1']:checked").val()+"&persona="+persona;
							
			 }
				  
			 if(fun==16){ // actualiza datos plantilla 
				 if($("#selectplantilla").val()==0){
					 alert("Seleccionar Nombre Plantilla 1");
					 return false;
					 }
				  var parametros = "funcion=16&nombre_plantilla="+$("#nombre_plantilla").val()+"&id_bloque="+$("#selectbloque").val()+"&id_plantilla="+$("#selectplantilla").val();
				  }	  
		      } // fin elem == 1
			  
			  
		if(elem==2){ // INSTRUCCIONES AREA
			  
		if(fun==18){  // INGRESO DE DATOS
		if($("#selectplantilla").val()==0){
		alert("Seleccionar Nombre Plantilla 3");
		return false; }
        var parametros = "funcion=18&nombre_area="+$("#nombre_area").val()+"&id_plantilla="+$("#selectplantilla").val();	
		}
				  
		if(fun==19){ // ACTUALIZA DATOS
		if($("#select_areas").val()==0){
		alert("Seleccionar Nombre Area");
		return false;
		}
		var parametros = "funcion=19&nombre_area="+$("#nombre_area").val()+"&id_area="+$("#select_areas").val();
		}	  
			  
		} // FIN AREA == 2
			  
			  
			if(elem==3){ // es instruccion para item.
		      
		   if($("#selectplantilla").val()==0){
		   alert("Seleccionar Nombre Plantilla");
		   return false;
		   }
		   if($("#select_areas").val()==0){
		   alert("Seleccionar Nombre Area");
		   return false;
		   }
		   if($("#ingresoitem").val()==""){
		   alert("Dato Item es Requerido");
		   return false; 
		   }
		   if(fun==21){  // ingresa datos plantilla 
					
				var parametros = "funcion=21&id_area="+$("#select_areas").val()+"&id_plantilla="+$("#selectplantilla").val()+"&nombre_item="+$("#ingresoitem").val();	
				//alert(parametros);
				  
				  }
				  
			 if(fun==22){ // actualiza datos item
			 
				 var parametros = "funcion=22&id_area="+$("#select_areas").val()+"&id_plantilla="+$("#selectplantilla").val()+"&id_subarea="+$("#select_subareas").val()+"&nombre_item="+$("#ingresoitem").val()+"&id_item="+$("#id_item").val();
				  
				  }	  
			  
		      } // fin elem == 3
		  
		if(elem==4){   // INSTRUCION PARA CONCEPTO
			  
		if(fun==192){  // INGRESA DATOS 
		if($("#selectplantilla").val()!=0){
		var parametros = "funcion=192&nombre_concepto="+$("#nombre_concepto").val()+"&glosa_concepto="+$("#glosa_concepto").val()+"&sigla_concepto="+$("#sigla_concepto").val()+"&id_plantilla="+$("#selectplantilla").val();
		 
		  }
		}
		
		 if(fun==193){ // ACTUALIZA DATOS
		 
		 if($("#selectConcepto").val()==0){
		 alert("Seleccionar Concepto");
		 return false;
		 }
		  var parametros = "funcion=193&nombre_concepto="+$("#nombre_concepto").val()+"&id_concepto="+$("#selectConcepto").val()+"&glosa_concepto="+$("#glosa_concepto").val()+"&sigla_concepto="+$("#sigla_concepto").val();
				  
			}
				  
		 }     

	      $.ajax({
		  url:'mod/Conf_Entrevistas/Cont_Conf_Entrevistas.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				   if(data==1){
				   	
                   alert("Dato Guardado");
				   
				   if(elem==1)cargarselect($("#selectbloque").val(),9);
				   
				   if(elem==2)carga_areas();
				   
				   if(elem==4)cargar_conceptos();
				   
				   if(elem==3){	
				   
				   cargarselect(0,111);
				  
				  $("#Ingresar_Item").html('<div id="botton_proceso" style="float:right; margin:2px; "><input type="submit" name="btn_guardar2" id="btn_guardar2"  value="+" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" onclick="funcion_guardar_datos(21,3)" /></div><label>Ingresar Item:<textarea name="ingresoitem" cols="70" rows="3" id="ingresoitem" class="required" ></textarea></label>'); 
				  
				  }
				  
				  }else{ alert("Error al Guardar Datos = "+data);  } } }) 		   
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
		url:'mod/Conf_Entrevistas/Cont_Conf_Entrevistas.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==1){	
				alert("Dato Eliminado");
				if(elem==1){ cargarselect($("#selectbloque").val(),9); }
				if(elem==2){ cargarselect($("#selectplantilla").val(),10); }
				if(elem==4)  cargarselect($("#select_areas").val(),101);
				if(elem==3)  cargarselect($("#select_subareas").val(),11);
				}else{
				alert("Error Sistema :"+data);
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
	    var parametros = "funcion=26&id_item="+id; 
		}
		 
		$.ajax({
		  url:'mod/Conf_Entrevistas/Cont_Conf_Entrevistas.php',
		  //url:'Cont_Conf_Entrevistas.php',
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
 

</script>

<style>

#bloques{ margin:10px; margin-top:5px; text-align:left; width:%; }
#table_items{  margin:5px; margin-top:5px; padding:3px;  }
#nombre_bloque{ margin-top:5px; padding:10px; margin:10px; width:90%; }
#procesar_datos{ top:5px; }

</style>

</head>
<body>
<div id="bloques" >

<fieldset>
<legend><strong><?=htmlentities("Configuración de Entrevistas",ENT_QUOTES,'UTF-8')?></strong></legend>
<div id="nombre_bloque">
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
<div id="select_Concepto">
<label>Seleccionar Concepto&nbsp;:&nbsp; &nbsp;  
<select name="selectConcepto" id="selectConcepto">
<option value=0  selected="selected" >Selecccionar</option>
</select>
</label>
</div>
<br>
<div id="select_Area">
<label>Seleccionar  Area&nbsp;:&nbsp; &nbsp;    
<select name="selectfuncion" id="selectfuncion">
<option value=0  selected="selected" >Selecccionar</option>
</select>
</label>  
</div>
<br>

<div id="Ingresar_Item"  style="width:69%	; margin:10px; " >

<div id="botton_proceso" style="float:right; margin:2px; ">
  <input type="submit" name="btn_guardar2" id="btn_guardar2"  value="+" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" onclick="funcion_guardar_datos(21,3)" />
</div>

    <label>Ingresar Item:
    		<textarea name="ingresoitem" cols="70" rows="3" id="ingresoitem" class="required" ></textarea>
    </label>

</div>

<div id="table_items" style="width:100%" ></div>

</div>

</fieldset>
</div>
<div id="procesar_datos"></div>



</body>
</html>
