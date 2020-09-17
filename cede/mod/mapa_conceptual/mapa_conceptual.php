<? session_start(); 
$ano=$_ANO_CEDE;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Documento sin título</title>

<script type="text/javascript">


$(document).ready(function(){ // Script para cargar al inicio del modulo
 cargarselect(<?=$ano;?>,3);
 
 $( "input:submit,input:button,a,button", "#mapaConcept" ).button();
  $( "input:submit,input:button,a,button", "#tabla" ).button();
$( "a", "#mapaConcept" ).click(function() { return false; });

 cargaTabla();
});


function cargarselect(param,fun){

		if(fun=="ccurso"){
	       var parametros = "funcion="+fun+"&ano="+param;
		   var selec = "select_bloque";
		 //  alert(parametros);
		  }
		  
		  if(fun==2){
	       var parametros = "funcion="+fun+"&id_nivel="+param;
		   var selec = "selectcurso";
		   $("#cmb_funcion option[value=0]").attr("selected",true);
		    //alert(parametros);
		   
		  }
		  if(fun==3){
	       var parametros = "funcion="+fun+"&id_ramo="+param;
		   var selec = "selectnivel";
		   
		  }
		  if(fun==4){
		   var subsector = $('#selectRamo').val();
	       var parametros = "funcion="+fun+"&subsector="+subsector;
		   var selec = "selectfuncion";
		   // alert(parametros);
		  
		  }
           // var parametros = "funcion="+fun;
			// alert(parametros);
		$.ajax({
		  url:'mod/mapa_conceptual/cont_mapa_conceptual.php',
		  
		  data:parametros,
		  type:'POST',
			success:function(data){
		//	alert(data);
                if(data==0){
				  alert("No se Encontraron Datos en el Curso");
				 // $('#cmb_funcion').html(0);
				   $("#cmb_funcion option[value=0]").attr("selected",true); 
				}else{
				$('#'+selec+'').html(data);
				$( "input:submit,input:button,a,button", "#mapaConcept" ).button();
				limpiatext();
				  }
		        }
		     })
	       } // fin funcion
		   
		   
		function ventana_ingreso(){
			
			var html="";
				
			html = html+'<label>Nombre Funci&oacute;n : <input type="input" name="nombre_funcion" id="nombre_funcion"  value="" /></label>';
			html = html+'<input type="hidden" name="id_funcion" id="id_funcion"  value="" />';
			
			$('#procesar_datos').html(html);
			 
			$('#procesar_datos').dialog({ autoOpen:true,width:500,height:200,modal:true,
					buttons: {
					  'Aceptar': function( ){
						funcion_guardar_funcion(); 
						
						$(this).dialog('close');
					  
					  },
					  'Cancelar': function(){ 
					   $(this).dialog('close');
					  
					  }
					 }
				   });
		
			} // fin funcion	   
			
			
	function funcion_guardar_funcion(){
		
		if($('#cmb_subsector').val()==0){
			alert("Seleccione un Subsector");
			return false;
		  }
		  
		  if($('#nombre_funcion').val()==""){
			alert("Escriba un Nombre de Funcion");
			return false;
		  }
		 
		 
		 var parametros = "funcion=5&id_curso="+$("#selectRamo").val()+"&nombre_funcion="+$("#nombre_funcion").val();
		 
		 //alert(parametros);	
		
		 $.ajax({
		   url:'mod/mapa_conceptual/cont_mapa_conceptual.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data)
				  if(data==1){
                   alert("Datos Guardados");
				   cargarselect(0,4);
				  }else{
		           alert("Error al Guardar Datos");				  
				  }
				  
		      }
		  })
		}			
		
		
	function guarda_mapcon(){
		
		if($('#cmb_subsector').val()==0){
			alert("Seleccione un Subsector");
			return false;
		  }
		  if($('#selectRamo').val()==0){
			alert("Seleccione un Subsector");
			return false;
		  }
		  
		  if($('#cmb_nivel').val()==0){
			alert("Seleccione Nivel");
			return false;
		  }
		  if($('#cmb_funcion').val()==0){
			alert("Seleccione Funcion");
			return false;
		  }
		 if($('#text_concepto').val()==""){
			alert("Escriba en el Campo Concepto");
			return false;
		  }
		  if($('#text_ejemplos').val()==""){
			alert("Escriba en el Campo Ejemplo");
			return false;
		  }
		 
		 var parametros = "funcion=6&id_ramo="+$("#selectRamo").val()+"&id_nivel="+$("#cmb_nivel").val()+"&id_funcion="+$("#cmb_funcion").val()+"&text_concepto="+$("#text_concepto").val()+"&text_ejemplos="+$("#text_ejemplos").val();
		 
		// alert(parametros);	
		 
		 $.ajax({
		   url:'mod/mapa_conceptual/cont_mapa_conceptual.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data)
				  if(data==1){
                   alert("Datos Guardados");
					    $("#selectRamo option[value=0]").attr("selected",true);
						$("#cmb_nivel option[value=0]").attr("selected",true);
						$("#cmb_funcion option[value=0]").attr("selected",true);
						$('#text_concepto').val("");
						 $('#text_ejemplos').val("");
				    }else{ 
		           alert("Error al Guardar Datos");				  
				  }
				  
		      }
		  })
		}				
		
		
		function verregistros(x,y,j){
		
		if(x!=null){
			var parametros= "funcion=7&id_ramo="+x+"&id_nivel="+y+"&id_funcion="+j;
			}else{
			var parametros = "funcion=7&id_ramo="+$("#selectRamo").val()+"&id_nivel="+$("#cmb_nivel").val()+"&id_funcion="+$("#cmb_funcion").val();
				}	
		
		alert(parametros);
		$.ajax({
		   url:'mod/mapa_conceptual/cont_mapa_conceptual.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data)
				  if(data==0){
                 //alert("No Existen Datos");
				       	  limpiatext();
				    }else{ 
		           	
				    alert("Existen Datos");
					   $('#muestradatos').html(data);
					 	
					    $('#text_concepto').val($('#_conceptos').val());
					   $('#text_ejemplos').val($('#_ejemplos').val());		  
				  }
				  
		      }
		  })
		}
		
		
		function cargaTabla(){
			
		var parametros = "funcion=8";
		//alert(parametros);
		$.ajax({
		   url:'mod/mapa_conceptual/cont_mapa_conceptual.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data)
				  if(data==0){
                 //alert("No Existen Datos");
				       	 // limpiatext();
				    }else{ 
		           	
				   // alert("Existen Datos");
					   $('#tabla').html(data);
					 	
					    //$('#text_concepto').val($('#_conceptos').val());
					   //$('#text_ejemplos').val($('#_ejemplos').val());		  
				  }
				  
		      }
		  })
		}
		
		
		
		
		function limpiatext(){
			$('#text_concepto').val("");
		    $('#text_ejemplos').val("");	
			
			
			}
		
			  
</script>

<style type="text/css">

<!--body{ font:Georgia, "Times New Roman", Times, serif; size:10px;}
-->#mapaConcept{ margin:10px; margin-top:5px; text-align:left; width:%; }
#table_items{  margin:5px; margin-top:5px; padding:3px;  }
#nombre_bloque{ margin-top:5px; padding:10px; margin:10px; width:90%; }
#procesar_datos{ top:5px; }
#vistaprevia{ font:"Times New Roman", Times, serif; font-size-adjust:12px; font-size:12px;}

.color_fondo{ background-image:url(jquery-ui-1.8.17.custom/css/redmond/images/ui-bg_gloss-wave_55_5c9ccc_500x100.png); }



</style>



</head>

<body>

<div id="mapaConcept" > 
<fieldset>
<legend><strong><?="Matrices de Progreci&oacute;n";?></strong></legend>
<div id="nombre_bloque">

<!--<div id="select_bloque">
<label>Seleccionar Curso:</label>
</div>-->
<div id="selectnivel">
<label>Seleccionar Nivel:&nbsp;&nbsp;&nbsp;&nbsp;
 <select name="cmb_nivel" id="cmb_nivel" >
<option value=0 selected="selected" >Selecccionar</option>
</select>
</label>
</div><br>

<div id="selectcurso">
<label>Seleccionar Asignatura:  &nbsp;&nbsp;
 <select name="cmb_subsector" id="cmb_subsector">
<option value=0 selected="selected" >Selecccionar</option>
</select>
</label>
</div>
<br>  
<div id="selectfuncion">
<label>Seleccionar Funcion:
<select name="cmb_funcion1" id="cmb_funcion1" style="margin-left:46px">
<option value=0 selected="selected" >Selecccionar</option>
</select>
</label>
</div><br>
  
<div id="textConcepto" style="width:100%;">
<label>Escriba Concepto:&nbsp;&nbsp;&nbsp;&nbsp;
<textarea name="text_concepto" cols="60" rows="4" id="text_concepto"></textarea>
</label>
</div><br>
   
<div id="textEjemplos">
<label>Escriba Ejemplos:&nbsp;&nbsp;&nbsp;&nbsp;  
<textarea name="text_ejemplos" cols="60" rows="4" id="text_ejemplos"></textarea>
</label>
</div><br>



<div id="textboton">&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp; 
<input type="button" name="btn_guardar" id="btn_guardar"  value="Guardar" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" onclick="guarda_mapcon()"/>
</div><br>
</div>
</fieldset>
<div id="procesar_datos"></div>
<div id="muestradatos"></div>
<div id="tabla"></div>
</div>
</body>
</html>