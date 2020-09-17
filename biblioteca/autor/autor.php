<?php 
require("../../util/header.php");
session_start();
$_POSP=3; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<link href="../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link href="../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script>

$(document).ready(function() {
    Listado();
});

function Listado(){
	
 var parametros="funcion=1";

 $.ajax({
	  url:'cont_autor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#tabla").html(data);
		  }
	  })	
}

function Nuevo(){

	var parametros="funcion=2";
	
	$.ajax({
		url:"cont_autor.php",
		data:parametros,
		type:'POST',
		success: function(data){
			 $("span.ui-dialog-title").text('DATOS AUTOR'); 
			$("#dialog").html(data);
			
			$("#dialog").dialog({ 
			   closeOnEscape: false,
			   modal:true,
			   resizable: true,
			   Width: 600,
			   Height: 700,
			   minWidth: 700,
			   minHeight: 300,
			   maxWidth: 600,
			   maxHeight: 500,
			   show: "fold",
			   hide: "scale",
			   stack: true,
			   sticky: true,
			  // position:"fixed",
			  // position: "absolute",
				buttons: {
				 "Guardar Datos": function(){
					 if($('#txtNOMBRE').val()==""){
						alert("DEBE INDICAR NOMBRE DE AUTOR");
						$('#txtNOMBRE').focus();
						return false;
					}
					/*if($('#txtNACIONALIDAD').val()==""){
						alert("DEBE INDICAR NACIONALIDAD DEL AUTOR");
						$('#txtNACIONALIDAD').focus();
						return false;
					}*/
						Agregar();
					  
					   $(this).dialog("close");
					 } ,
				 "Cerrar": function(){
					$(this).dialog("close");
				  }
				}   
			  }) 
		}
	})
		
	
}
function Agregar(){
 var nombre =$("#txtNOMBRE").val();
 var nacio = $("#txtNACIONALIDAD").val();
 var rdb = <?php echo $_INSTIT ?>;
 var parametros="funcion=3&nombre="+nombre+"&nacio="+nacio+"&rdb="+rdb;
 
 $.ajax({
	  url:'cont_autor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==1){
			  Listado();
		  }else{
			  alert("ERROR AL GUARDAR");			  
		  }
		  }
	  })	
}

function Elimina(id){
	if(confirm("ESTA OPCION ELIMINA TODOS LOS LIBROS ASOCIADOS A ESTE AUTOR, DESEA CONTINUAR")==true){
		 var parametros="funcion=4&id="+id
		 
		 $.ajax({
			  url:'cont_autor.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				 console.log(data);
				  //alert(data);
				 if(data==1){
					  Listado();
				  }else{
					  alert("ERROR AL MODIFICAR");			  
				  }
				  }
			  })	
	}
}

function edita(id){
	
		 var parametros="funcion=5&id="+id
		 
		 $.ajax({
			  url:'cont_autor.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				 
				
				 $("span.ui-dialog-title").text('DATOS AUTOR'); 
				 $("#dialog").html(data);
				 $("#dialog").dialog({ 
			   closeOnEscape: false,
			   modal:true,
			   resizable: true,
			   Width: 600,
			   Height: 700,
			   minWidth: 700,
			   minHeight: 300,
			   maxWidth: 600,
			   maxHeight: 500,
			   show: "fold",
			   hide: "scale",
			   stack: true,
			   sticky: true,
			  // position:"fixed",
			  // position: "absolute",
				buttons: {
				 "Guardar Datos": function(){
					 if($('#txtNOMBRE').val()==""){
						alert("DEBE INDICAR NOMBRE DE AUTOR");
						$('#txtNOMBRE').focus();
						return false;
					}
					if($('#txtNACIONALIDAD').val()==""){
						alert("DEBE INDICAR NACIONALIDAD DEL AUTOR");
						$('#txtNACIONALIDAD').focus();
						return false;
					}
						Modificar();
					  
					   $(this).dialog("close");
					 } ,
				 "Cerrar": function(){
					$(this).dialog("close");
				  }
				}   
			  })
				  //alert(data);
				 /*if(data==1){
					  Listado();
				  }else{
					  alert("ERROR AL GUARDAR");			  
				  }*/
				  }
			  })	
	
}

function Modificar(){
var nombre =$("#txtNOMBRE").val();
var nacio = $("#txtNACIONALIDAD").val();
var id = $("#ida").val();
var parametros="funcion=6&nombre="+nombre+"&nacio="+nacio+"&id="+id;
 $.ajax({
	  url:'cont_autor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
		  if(data==1){
			    alert("DATOS MODIFICADOS");
			 Listado();
		  }else{
			  alert("ERROR AL GUARDAR");			  
		  }
		  }
	  })


}

function Elimina(id){
	var parametros="funcion=7&id="+id;
	 $.ajax({
	  url:'cont_autor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
		  if(data==1){
			  alert("DATOS MODIFICADOS");
			 Listado();
		  }else{
			  alert("ERROR AL GUARDAR");			  
		  }
		  }
	  })
}
</script>
<title>SISTEMA SAE:====> BIBLIOTECA</title>
</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0" >

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="3" valign="top" background="../../cortes/<?=$_INSTIT;?>/fondo_01_reca.jpg" width="50"  height="900"></td>
    <td colspan="2" align="center" valign="top" height="70"><? include("../../cabecera_new/head.php");?></td>
    <td rowspan="3" background="../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td valign="top" align="left"><? include("../../menu_new/menu_biblio.php");?></td>
    <td valign="top" align="center"><br />
    <table width="95%" border="0" cellpadding="0" cellspacing="0" class="cajaborde" >
    <tr>
    	<td width="5%" colspan="4"><br /><div id="tabla">&nbsp;</div><div id="dialog" title="DATOS AUTOR" >&nbsp;</div></td>
    </tr>
    </table>
	
</td>
  </tr>
  <tr>
    <td colspan="2" valign="bottom" align="center"><? include("../../cabecera_new/footer.html");?></td>
  </tr>
</table>


</body>

</html>
