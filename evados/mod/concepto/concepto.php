<? 
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
<title>Conceptos</title>

<link rel="stylesheet" type="text/css" href="../admin/clases/flexigrid-1.1/css/flexigrid.css">
<script type="text/javascript" src="../admin/clases/flexigrid-1.1/js/flexigrid.js"></script>

        
<script type="text/javascript">
$(document).ready(function(){ // Script para cargar al inicio del modulo
cargartabla();
});


function cargardatos(fu){

	if($('#categoria').val()==""){
		alert("Debe Ingresar una Categoria");
		$('#categoria').val().focus();
		exit;
	}
	if($('#concepto').val()==""){
		alert("Debe Ingresar un Concepto");
		$('#concepto').val().focus();
		exit;
	}
	if($('#sigla').val()==""){
		alert("Debe Ingresar una Sigla");
		$('#sigla').val().focus();
		exit;
	}
	
	
	if($('#critico').is(':checked')){ 
		var critico =1;
	}else{
	  var critico =0;
	 }
	
var parametros = "funcion="+fu+"&categoria="+$('#categoria').val()+"&concepto="+$('#concepto').val()+"&sigla="+$('#sigla').val()+"&critico="+critico+"&estado="+$('#estado').val()+"&peso="+$('#peso').val()+"&optimo="+$('#optimo').val();
 
if($('#_idconcepto'))  parametros = parametros+"&id_concepto="+$('#_idconcepto').val();
 
	$.ajax({
	  url:'mod/concepto/cont_concepto.php',
	 // url:'cont_doc.php',
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

		$('#categoria').val("");
		$('#concepto').val("");
	    $('#sigla').val("");
		$('#peso').val("");	
		$('#critico').attr("checked",false);					
		$('#estado').attr("checked",false);
		$('#optimo').attr("checked",false);										
				$('#bottoncontrol').html('<br><input name="creardoc" type="button" onClick="cargardatos(0)" value="Crear" class="botonXX"/>');
				
 }// fin funcion cargadatos
 
 
	function cargartabla(){
		
	var parametros = "funcion=3";

		$.ajax({
		  url:'mod/concepto/cont_concepto.php',
		 // url:'cont_doc.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
					
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#table_evaluadores').html(data);
						
						$("#flex1").flexigrid({
								width : 600,
								height : 200
							});
							
						}
				     }
		         })
	          } // fin funcion cargartabla
 
 
 function buscarconcepto(id_concepto){
   var parametros = "funcion=6&id_concepto="+id_concepto;
 
  		$.ajax({
		  url:'mod/concepto/cont_concepto.php',
		  //url:'cont_bloques.php',
		  type:'post',
		  //dataType: 'json',
		  data:parametros,
		  success:function(data){
		   
					if(data!=0){
					  
					 $('#resultadosbusqueda').html(data);			  

				    $('#categoria').val($('#_categoria').val());
					$('#concepto').val($('#_concepto').val());
					$('#sigla').val($('#_sigla').val());
					
					if($('#_critico').val()==1){ 
					$('#critico').attr("checked","checked");
					}else{
					$('#critico').attr("checked",false);
					}

$('#bottoncontrol').html('<br><input name="Modificar" type="button" class="botonXX" onClick="cargardatos(1)" value="Modificar" />');
					  
					}else{
					  alert("Error al Cargar");
					}
			 }
		 })
    }
 
 
 function EliminaConcepto(a){
 	var parametros = "funcion=5&id="+a;
	//alert(parametros);
	$.ajax({
		url:'mod/concepto/cont_concepto.php',
		//url:'cont_doc.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("Error en la Eliminacin");
			}else{
				cargartabla(<?=$_ANO?>);
				$("#flex1").flexigrid({
					width : 600,
					height : 200
				});
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

<div id="resultadosbusqueda" >&nbsp;</div>

<div id="bloques" align="center"  >

<fieldset>
<legend>Conceptos de Pauta de Evaluaci&oacute;n</legend>

<div id="nombre_bloque">
<table width="100%" border="0" cellspacing="5" cellpadding="5" style="border-collapse:collapse">
  <tr>
    <td width="18%" class="textonegrita">&nbsp;Categoria:</td>
    <td width="82%">&nbsp;<input name="categoria" type="text" id="categoria" size="20" maxlength="20" /></td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;Concepto:</td>
    <td>&nbsp;<textarea name="concepto" cols="60" rows="3" id="concepto"></textarea></td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;Sigla:</td>
    <td>&nbsp;<input name="sigla" type="text" id="sigla" size="20" maxlength="20" /></td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;Concepto Critico:</td>
    <td>&nbsp;<input name="critico" id="critico" type="checkbox" value="1"  /></td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;Peso</td>
    <td>&nbsp;<input type="text" name="peso" id="peso" /></td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;Estado</td>
    <td>&nbsp;<input type="checkbox" name="estado" id="estado" value="1"  /></td>
  </tr>
  <tr>
    <td class="textonegrita">&nbsp;Optimo</td>
    <td>&nbsp;<input type="checkbox" name="optimo" id="optimo" value="1"  /></td>
  </tr>
</table>	

<div id="bottoncontrol" >
<br>																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																<input name="creardoc" type="button" onClick="cargardatos(0)" value="Crear" class="botonXX"/>
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
