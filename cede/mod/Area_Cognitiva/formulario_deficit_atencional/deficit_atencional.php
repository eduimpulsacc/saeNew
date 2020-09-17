<?

 session_start();


	$id_curso=$_ID_CURSO;
    $rut_alumno=$_RUT_ALUMNO;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<script>

	 $(document).ready(function() {
		 
		 $("#txtFECHA").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'mm/dd/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']	
		 
		 $( "input:submit,input:button", "#cuerpo_area_cognitiva" ).button();
  $('#frm').submit();
  
  Buscar_AreaCog();
  
});


	
	function enviar(){

   if( $("#txtFECHA").val()==""){
      alert("Seleccionar Fecha");
      return false;
    }
	 if( $("#obser").val()==""){
      alert("Escriba Observacion");
      return false;
    }
  
	alert("Datos Cargados");
	 $('#frm').submit();
	
	Buscar_AreaCog($("#id_tipo").val(),<?=$rut_alumno;?>);
	
 } 
 
 
 function descarga_archivo(){
	var funcion="descarga";
	var parametros= "funcion="+funcion; 	 
		//alert(parametros);
		
		$.ajax({
		  url:'mod/Area_Cognitiva/formulario_deficit_atencional/cont_deficit_atencional.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
			//alert(data);
                if(data==0){
				  alert("No se Encontraron Datos");
				}else{
	if(confirm("Desea Descargar El Archivo?")) { 
	open(data);
	}else{
    return false;
                }   
			  }
		   }
	   })
	}	
	
	
	
	function Buscar_AreaCog(id_tipo){
		var funcion="CargaTabla";
		var rut_alumno="<?=$rut_alumno;?>"
		var id_tipo=$('#id_tipo').val();
		
	var parametros = "id_tipo="+id_tipo+"&funcion="+funcion+"&rut_alumno="+rut_alumno;  
	//alert(parametros);
			$.ajax({
			  url:'mod/Area_Cognitiva/formulario_deficit_atencional/cont_deficit_atencional.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				 // alert(data);
					if(data==0){
						alert("Error al Cargar");
					}else{ 
					
					$('#contenedor_area_cognitiva').html(data);
					$( "input:submit,input:button", "#contenedor_area_cognitiva" ).button();
					
						$('#select_profesional').removeAttr('disabled');
						$('#fileUpload').removeAttr('disabled');
						$("#txtFECHA").datepicker( "enable" );
						$('#obser').val("");
					    $("#select_profesional option[value=0]").attr("selected",true);
						$('#txtFECHA').val("");
						$('#fileUpload').val("");
		 $('#guardar').html('<br><input type="button" name="btn_guardar" id="btn_guardar"  value="Guardar" onclick="enviar()" />');
		 $("input:submit,input:button", "#guardar" ).button();
		
							
						
					  }
				 }
			})
	    }
	    
		
		function descarga_archivofinal(id_archivo){
	var funcion="descargafinal";
	var parametros= "funcion="+funcion+"&id_archivo="+id_archivo; 	 
	//	alert(parametros);
		
		$.ajax({
		  url:'mod/Area_Cognitiva/formulario_deficit_atencional/cont_deficit_atencional.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
		//	alert(data);
                if(data==0){
				  alert("No se Encontraron Datos");
				}else{
	if(confirm("Desea Descargar El Archivo?")) { 
	open(data);
	}else{
    return false;
                }   
			  }
		   }
	   })
	}	
	
	function ModificaArchivofinal(id_archivo){
				
	var parametros = "funcion=2&id_archivo="+id_archivo;
	//alert(parametros);
	 $.ajax({
		   url:'mod/Area_Cognitiva/formulario_deficit_atencional/cont_deficit_atencional.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data!=0){
                   //alert("Datos Encontrados");
				    $('#RespuestaBuscaAreaCog').html(data);
					
						var _nombre=$('#_id_prof').val();
				       
				 		var id_archivo = $('#id_archivo').val();
						var _obser=$('#_obser').val();
						$('#obser').val($('#_obser').val());
						$('#txtFECHA').val($('#_fecha').val());
						$("#fileUpload").attr("disabled","disabled");
						$("#txtFECHA").datepicker( "disable" );
						$('#obser').focus();
$('#guardar').html('<br><input name="Modificar" type="button" onClick="modifica_AreaCog('+id_archivo+')" value="Modificar" />');
				  $("input:submit,input:button", "#guardar" ).button();
				  }else{
		           alert("Error al Cargar Datos");				  
				  }
		      }
		  })	
		}
		
		
		function modifica_AreaCog(id_archivo){
		var rut_alumno="<?=$rut_alumno;?>"
		var _obser=$("#obser").val();	
		var id_tipo=$("#id_tipo").val();
		
		var parametros = "funcion=3&id_archivo="+id_archivo+"&_obser="+_obser;
		//alert(parametros);
			
			$.ajax({
			url:'mod/Area_Cognitiva/formulario_deficit_atencional/cont_deficit_atencional.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
			alert("Datos Actualizados");	
			Buscar_AreaCog(id_tipo,rut_alumno);
		    }
	     }
      })
   }
	
	function EliminaArchivofinal(id_archivo){
		
		var rut_alumno="<?=$rut_alumno;?>"
		var id_tipo=$("#id_tipo").val();
		
		var parametros = "funcion=4&id_archivo="+id_archivo;
	      if(!confirm("Seguro que desea Eliminar??")) { 
			return false;
			}else{
			$.ajax({
			url:'mod/Area_Cognitiva/formulario_deficit_atencional/cont_deficit_atencional.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se puede eliminar");
			}else{
			alert("Datos Eliminados");		
			Buscar_AreaCog(id_tipo,rut_alumno);
		    }
	      }
       })
      }
    }
	
	
	

</script>



<style type="text/css">




div.ui-datepicker{
font-size:12px;
}

.color_fondo{ background-image:url(jquery-ui-1.8.17.custom/css/redmond/images/ui-bg_gloss-wave_55_5c9ccc_500x100.png); }
</style> 

</head>

<body>
<div id="cuerpo_area_cognitiva" >
  <fieldset>
<legend><strong><?=htmlentities("Deficit Atencional",ENT_QUOTES,'UTF-8')?></strong></legend>
<div id="Area_Cognitiva" >
<form  id="frm" name="frm" method="post" enctype="multipart/form-data" action="mod/Area_Cognitiva/formulario_deficit_atencional/controlUpload.php" target="iframeUpload">

<div id="documento">
<label>Documento Oficial:
<input type="button" name="descargar" id="descargar" value="Descargar" onclick="descarga_archivo()" style="margin-left:6%;"/>
</label>
</div>
<br>
<div id="fecha">
<label >Seleccionar Fecha:
 <input type="text" name="txtFECHA" id="txtFECHA" style="margin-left:6%;">
</label>
</div>
<br>
<div id="archivo" >
<label>Seleccionar Archivo:
 <input type="file" name="fileUpload" id="fileUpload" style="margin-left:5%;">
</label>
</div>
<br>
<div id="observacion" >
<label>Observacion:
 <textarea name="obser" cols="60" rows="3" id="obser" style="margin-left:10%;"></textarea>
</label>
</div>
<br><br>
<div id="guardar" >
<input type="button" name="btn_guardar" id="btn_guardar"  value="Guardar" onclick="enviar()"/>
</div>
<br>
 <div id="contenedor_area_cognitiva"></div>
       
<iframe name="iframeUpload" id="iframeUpload" width="100%" height="50%" align="bottom"  marginwidth="10%" scrolling="no" class="autoHeight" frameborder="0"  >
</iframe>
<INPUT type="hidden" id="id_tipo" name="id_tipo" value="2">
</form>
</div>
</fieldset>
<div id="Pauta_Entravista"></div>
<div id="RespuestaBuscaAreaCog"></div>

</div>
</body>
</html>
