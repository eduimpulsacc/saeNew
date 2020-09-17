<? session_start();?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>

<script>

$(document).ready(function(){ // Script para cargar al inicio del modulo
   Buscar_entrevistas(1);
   $("#crea_menu").tabs({});
   
$("#txtFECHA").datepicker({
		showOn: 'both',
		changeYear:true,
		changeMonth:true,
		dateFormat: 'mm/dd/yy'
	    //buttonImage: 'img/Calendario.PNG',
			});
		$.datepicker.regional['es']	
 cargarselect();
 $( "input:submit,input:button", "#Entrevista_profesional" ).button();
 $("a", "#Entrevista_profesional" ).click(function() { return false; });
 
});



function cargarselect(){
	var	fun="selectProf"; 
	       var parametros = "funcion="+fun;
		   var selec = "selectProfesional";
		 // alert(parametros);
		  
		$.ajax({
		  url:'mod/entrevista_profesional/cont_entrevista_profesional.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
			//alert(data);
                if(data==0){
				  alert("No se Encontraron Datos en el Curso");
				 // $('#cmb_funcion').html(0);
				   $("#cmb_funcion option[value=0]").attr("selected",true); 
				}else{
				$('#'+selec+'').html(data);
				//$( "input:submit,input:button", "#Entrevista_profesional" ).button();
				
				  }
		        }
		     })
	       } // fin funcion
       
	   function guarda_entrevista(){
		   
	  }
	   
	   
/* $(document).ready(function() {
  $('#frm').submit();
});*/


	
	function enviar(){
		
    if( $("#select_profesional").val()==0){
      alert("Seleccionar Profesional");
      return false;
    }

   if( $("#txtFECHA").val()==""){
      alert("Seleccionar Fecha");
      return false;
    }
	
	 if( $("#obser").val()==""){
      alert("Escriba Observacion");
      return false;
    }
  
    
    $('#frm').submit();
	alert("Datos Guardados");
 	Buscar_entrevistas($("#select_profesional").val());
	
	
	

 } 
 
 

 
 
 	function Buscar_entrevistas(id_prof){
		var funcion="CargaTabla";
		var id_ano="<?=$_ANO_CEDE;?>";
	var parametros = "id_prof="+id_prof+"&id_ano="+id_ano+"&funcion="+funcion;  
	//alert(parametros);
	
			$.ajax({
			  url:'mod/entrevista_profesional/cont_entrevista_profesional.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				 // alert(data);
					if(data==0){
						alert("Error al Cargar");
					}else{ 
					
					$('#contenedor_entrevistas').html(data);
					$( "input:submit,input:button", "#contenedor_entrevistas" ).button();
					
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
		
		
			  
		
	function ModificaArchivo(id_entrevista){
				
	var parametros = "funcion=2&id_entrevista="+id_entrevista;
	//alert(parametros);
	 $.ajax({
		   url:'mod/entrevista_profesional/cont_entrevista_profesional.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data!=0){
                   //alert("Datos Encontrados");
				    $('#RespuestaBuscamenuEntrevista').html(data);
					
						var _nombre=$('#_id_prof').val();
				       
				 		var _id_entrevista = $('#_id_entrevista').val();
						var _obser=$('#_obser').val();
						$("#select_profesional option[value="+_nombre+"]").attr("selected",true);
						$('#obser').val($('#_obser').val());
						$('#txtFECHA').val($('#_fecha').val());
						$("#select_profesional").attr("disabled","disabled");
						$("#fileUpload").attr("disabled","disabled");
						
						
						$("#txtFECHA").datepicker( "disable" );
												
						$('#obser').focus();
$('#guardar').html('<br><input name="Modificar" type="button" onClick="modifica_Entrevista()" value="Modificar" />');
				  $("input:submit,input:button", "#guardar" ).button();
				  }else{
		           alert("Error al Cargar Datos");				  
				  }
		      }
		  })	
		}		
 		
		
		function modifica_Entrevista(){
		var _id_prof=$("#_id_prof").val();	
		//alert(_id_prof);
		var _id_entrevista=$("#_id_entrevista").val();	
		var _obser=$("#obser").val();	
		
		var parametros = "funcion=3&_id_entrevista="+_id_entrevista+"&_obser="+_obser;
		//alert(parametros);
			
			$.ajax({
			url:'mod/entrevista_profesional/cont_entrevista_profesional.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se Encontraron Datos");
			}else{
			alert("Datos Actualizados");		
			Buscar_entrevistas(_id_prof);
		    }
	     }
      })
   }
   
   function EliminaArchivo(id_entrevista,id_prof){
		
		var parametros = "funcion=4&id_entrevista="+id_entrevista;
	      if(!confirm("Seguro que desea Eliminar??")) { 
			return false;
			}else{
			$.ajax({
			url:'mod/entrevista_profesional/cont_entrevista_profesional.php',
			data:parametros,
			type:'POST',
			success:function(data){
			//alert(data);
			if(data==0){
			alert("No se puede eliminar");
			}else{
			alert("Datos Eliminados");		
			Buscar_entrevistas(id_prof);
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

<div id="cuerpo_profesional" >
<fieldset>
<legend><strong><?=htmlentities("Entrevista Profesional",ENT_QUOTES,'UTF-8')?></strong></legend>
<div id="Entrevista_profesional" >
<form  id="frm" name="frm" method="post" enctype="multipart/form-data" action="mod/entrevista_profesional/controlUpload.php" target="iframeUpload">
<div id="selectProfesional">&nbsp;</div>
<div id="fecha">
<label >Seleccionar Fecha:
 <input type="text" name="txtFECHA" id="txtFECHA" style="margin-left:6%;">
 
</label>
</div>
<br>
<div id="archivo" >
<label>Seleccionar Archivo:
 <input type="file" name="fileUpload" id="fileUpload" style="margin-left:5%;">&nbsp;Solo Archivos Word y Pdf.
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
<div id="crea_menu">
        <ul>
            <li><a href="cont_entrevista_profesional.php"  onclick="Buscar_entrevistas(1,0)">Neurologo</a></li>
            <li><a href="cont_entrevista_profesional.php" onclick="Buscar_entrevistas(2,0)">Psicopedagogo</a></li>
            <li><a href="cont_entrevista_profesional.php" onclick="Buscar_entrevistas(3,0)">Sicologo</a></li>
            <li><a href="cont_entrevista_profesional.php" onclick="Buscar_entrevistas(4,0)">Orientador</a></li>
            <li><a href="cont_entrevista_profesional.php" onclick="Buscar_entrevistas(5,0)">Educadora Diferencial</a></li>
        </ul>
      <div id="contenedor_entrevistas"></div>
        </div>
        
       
<iframe name="iframeUpload" id="iframeUpload" width="100%" height="50%" align="bottom"  marginwidth="10%" scrolling="no" class="autoHeight" frameborder="0" >
</iframe>

</form>
</div>
</fieldset>
<div id="Pauta_Entravista"></div>
<div id="RespuestaBuscamenuEntrevista"></div>
</div>


</body>
</html>
