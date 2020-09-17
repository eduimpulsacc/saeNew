<? session_start(); 

 $ano = $_ANO_CEDE;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Nivel de Logro</title>

<link rel="stylesheet" type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css">
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/codificacion.js"></script>
<script  language="javascript" type="text/javascript">


$(document).ready(function(){ // Script para cargar al inicio del modulo


$( "input:submit,input:button,a,button", "#mapaConcept" ).button();
$( "a", "#mapaConcept" ).click(function() { return false; });

/*$( "#botones").button({
            icons: {
                primary: "ui-icon-locked"
            }
			});*/

cargatabla(<?=$ano?>);
	
	/*$('#table_items').html(' <label>Tabla Nivel de Logro</label><table id="flex1" style="display:none" ><thead><tr align="center" ><th width="300" >&nbsp;</th></tr></thead><tbody><tr align="center" ><td>&nbsp;</td></tr><tbody></table>');
							  
	$("#flex1").flexigrid({
		width : 970,
		height : 100
	  });	
	*/
}); 
	

	function guarda_nivellogro(){
		
		if($('#selectNivel').val()==0){
			alert("Seleccione un nivel");
			return false;
		  }
		  
		  if($('#txt_concepto').val()==""){
			alert("Escriba un Concepto");
			return false;
		  }
		  if($('#txtDESCRIPCION').val()==""){
			alert("Escriba una Descripcion");
			return false;
		  }
		  
		   if($('#txt_NotaMinima').val()==""){
			alert("Escriba Nota Minima");
			return false;
		  }
		  if($('#txt_NotaMaxima').val()==""){
			alert("Escriba Nota Maxima");
			return false;
		  }
		  
		  
		  var ano = <?=$ano;?>
		 
var parametros = "funcion=1&id_nivel="+$("#selectNivel").val()+"&concepto="+$("#txt_concepto").val()+"&notaminima="+$("#txt_NotaMinima").val()+"&notamaxima="+$("#txt_NotaMaxima").val()+"&id_ano="+ano+"&descrip="+$("#txtDESCRIPCION").val();
		 
		// alert(parametros);	
		 $.ajax({
		   url:'mod/nivel_logro/cont_nivel_logro.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data)
				  if(data==1){
                   alert("Datos Guardados");
				    $("#selectNivel option[value=0]").attr("selected",true); 
						$('#txt_concepto').val("");
						$('#txt_NotaMinima').val("");
						$('#txt_NotaMaxima').val("");
						$('#txtDESCRIPCION').val("");
				   cargatabla(<?=$ano;?>);
				  }else{
		           alert("Error al Guardar Datos");				  
				  }
		      }
		  })
		}			
		
		
	function cargatabla(ano){
	var parametros = "funcion=2&ano="+ano;
	//alert(parametros);
		$.ajax({
		  url:'mod/nivel_logro/cont_nivel_logro.php',
		  //url:'cont_bloques.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
			//	alert(data);
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#table_items').html(data);
						
					
							$("input:submit,input:button,a,button", "#mapaConcept" ).button();
						}
				     }
		         })
	          } // fin funcion cargartabla
		
			  
			  
	function BuscaNivelLogro(id){
	
var parametros = "funcion=3&id="+id;
	
	 $.ajax({
		   url:'mod/nivel_logro/cont_nivel_logro.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				  if(data!=0){
                   //alert("Datos Encontrados");
				    $('#respuestabuscanivel').html(data);	
						var _id_nivel = $('#_id_nivel').val();
						$("#selectNivel option[value="+_id_nivel+"]").attr("selected",true); 
						$('#txt_concepto').val($('#_concepto').val());
						$('#txt_NotaMinima').val($('#_notaMinima').val());
						$('#txt_NotaMaxima').val($('#_notaMaxima').val());
						$('#txtDESCRIPCION').val($('#_descripcion').val());
						
						$('#txt_concepto').focus();
$('#boton_guardar').html('<br><input name="Modificar" type="button" class="botonXX" onClick="cargardatos(1)" value="Modificar" />');
$( "input:submit,input:button,a,button", "#mapaConcept" ).button();
				  
				  }else{
		           alert("Error al Cargar Datos");				  
				  }
		      }
		  })	
	}
	
	
	function cargardatos(){
		
	var ano = <?=$ano;?>;
	var id = $('#_id').val();
	var concepto =  $.trim(($("#txt_concepto").val()));
	alert(concepto);
	var parametros = "funcion=4&id_nivel="+$("#selectNivel").val()+"&concepto="+concepto+"&notaminima="+$("#txt_NotaMinima").val()+"&notamaxima="+$("#txt_NotaMaxima").val()+"&id_ano="+ano+"&id="+id;	
		alert(parametros);
	 $.ajax({
		   url:'mod/nivel_logro/cont_nivel_logro.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				alert(Utf8.decode(data))
				  if(data==1){
                   alert("Datos Modificados");
				   
				   
				   $("#selectNivel option[value=0]").attr("selected",true); 
						$('#txt_concepto').val("");
						$('#txt_NotaMinima').val("");
						$('#txt_NotaMaxima').val("");
		 $('#boton_guardar').html('<br><input name="Guardar" type="button" onClick="guarda_nivellogro()" value="Guardar" />')
				  cargatabla(<?=$ano;?>);
				  }else{
		           alert("Error al Modificar Datos");				  
				  }
		      }
		  })	
   	}
	
	function EliminarNivelLogro(id){
	
var parametros = "funcion=5&id="+id;

	//alert(parametros);
	if(!confirm("Seguro que desea Eliminar??")) { 
			return false;
			}else{
	 $.ajax({
		   url:'mod/nivel_logro/cont_nivel_logro.php',
	      data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				  if(data==1){
                 alert("Datos Eliminados");
				 cargatabla(<?=$ano;?>);
				  }else{
		           alert("Error al Cargar Datos");				  
				  }
		      }
		  })	
	   }
	}
	
	
	function validanotaminima(){
		var txtNotmin=$('#txt_NotaMinima').val();
		if(txtNotmin.length==2){
			
			if(txtNotmin > 70){
				alert("La Nota no puede ser mayor a 70");
				$('#txt_NotaMinima').val("");
				return false;
				}
			if(txtNotmin <= -1){
				alert("La Nota no puede ser Negativa");
				$('#txt_NotaMinima').val("");
				return false;
				}
		var x;
		for(x=0;x<3;x++){
	
	if (txtNotmin>=$("#nota_minima"+x+"").val() && txtNotmin<=$("#nota_maxima"+x+"").val()){
		alert("La nota ya esta dentro de un rango");
		$('#txt_NotaMinima').val("");
		return false;
		}
	  }
	}
  }
	
	
	function validanotamaxima(){
		var txtNotmax=$('#txt_NotaMaxima').val();
		if(txtNotmax.length==2){
			if(txtNotmax > 70){
				alert("La Nota no puede ser mayor a 70");
				$('#txt_NotaMaxima').val("");
				return false;
				}
				
				if(txtNotmax <= -1){
				alert("La Nota no puede ser Negativa");
				$('#txt_NotaMaxima').val("");
				return false;
				}
				
			if(txtNotmax <= $('#txt_NotaMinima').val()){
				alert("La Nota Maxima debe ser Mayor");
				$('#txt_NotaMaxima').val("");
				return false;
				}	
		var y;
		for(y=0;y<3;y++){
		if (txtNotmax>=$("#nota_minima"+y+"").val() && txtNotmax<=$("#nota_maxima"+y+"").val()){
		alert("La nota ya esta dentro de un rango");
		$('#txt_NotaMaxima').val("");
		return false;
		}
      }
	}
}
			  
			  
</script>

<style type="text/css">

/*body{ font:Georgia, "Times New Roman", Times, serif; size:10px;}
#mapaConcept{ margin:10px; margin-top:5px; text-align:left; width:%; }
#table_items{  margin:5px; margin-top:5px; padding:3px;  }*/
#nombre_bloque{ margin-top:5px; padding:10px; margin:10px; width:90%; }
#procesar_datos{ top:5px; }
#vistaprevia{ font:"Times New Roman", Times, serif; font-size-adjust:12px; font-size:12px;}
.color_fondo{ background-image:url(jquery-ui-1.8.17.custom/css/redmond/images/ui-bg_gloss-wave_55_5c9ccc_500x100.png); }
/*select,text{font-size:10px;}*/
/*input:focus, textarea:focus { 
 background:#FFF799; 
} */
/*fieldset { 
 border:none; 
} */
</style>
</head>
<body>
<div id="mapaConcept"> 

<fieldset>
<legend><strong><?="Nivel de Logro"; htmlentities("",ENT_QUOTES,'UTF-8')?></strong></legend>
<div id="nombre_bloque">
<div id="respuestabuscanivel"></div>
<br>
 <div id="select_nivel">
<label>Seleccione Nivel :
<select name='selectNivel' id='selectNivel' style="margin-left:5%">
    <option value='0' select='select'  >Selecccionar</option>
    <!--<option value='1'>Nivel Insuficiente</option>
    <option value='2'>Nivel Elemental</option>
    <option value='3'>Nivel Adecuado</option>-->
    <option value='1'>Nivel Logrado</option>
    <option value='2'>Nivel Por Lograr</option>
    </select></label>
</div><br>
  
 <div id="selectConcepto">
<label>Escriba Concepto:
<input  style="margin-left:4%" type="text" name="txt_concepto" id="txt_concepto" class="required" />
</label>
</div>
<br>  
<div id="selectDescripcion">
<label>Escriba Descripcion:
  <textarea name="txtDESCRIPCION" cols="40" rows="5" class="required" id="txtDESCRIPCION" style="margin-left:4%"></textarea>
</label>
</div>
<br>
  <div id="selecNotaMinima">
<label>Nota Minima:
 <input  style="margin-left:7.5%" type="text" name="txt_NotaMinima" id="txt_NotaMinima" size="3"  maxlength="2" class="required number" onkeyup="validanotaminima()" />
</label>
</div><br>

  
 <div id="selecNotaMaxima">
<label>Nota Maxima:
 <input  style="margin-left:7%" type="text" name="txt_NotaMaxima" id="txt_NotaMaxima" size="3"  maxlength="2" class="required number" onkeyup="validanotamaxima()"/>
</label>
</div><br>
  


<br><br>
<div id="boton_guardar"> 
<input   type="submit" name="btn_guardar" id="btn_guardar"  value="Guardar" class="ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" onclick="guarda_nivellogro()"/>

</div><br>
</div>
</fieldset>
<div id="table_items"></div>
</div>
</body>
</html>
