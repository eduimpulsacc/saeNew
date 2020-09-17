<?php 
require("../../util/header.php");
session_start();
$_POSP=3; 
//show($_SESSION);
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
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.9.2.custom/js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.8.14.custom/js/jquery-ui-1.8.14.custom.min.js"></script>
<script>
$( document ).ready(function() {
   filtro();
   
   $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
          });

  
   
});

function filtro(){
var parametros="funcion=1";

 $.ajax({
	  url:'cont_libro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#tabla").html(data);
		  }
	  })	
}

function Nuevo(){
var rdb = <?php echo $_INSTIT ?>;

	var parametros="funcion=2&rdb="+rdb;
	
	$.ajax({
		url:"cont_libro.php",
		data:parametros,
		type:'POST',
		success: function(data){
			$('#dialog').prop('title', 'Nuevo Libro');
			$("#dialog").html(data);
			$("#dialog").dialog({ 
			   closeOnEscape: false,
			   modal:true,
			   resizable: true,
			   Width: 600,
			   Height: 750,
			   minWidth: 700,
			   minHeight: 750,
			   maxWidth: 600,
			   maxHeight: 750,
			   show: "fold",
			   hide: "scale",
			   stack: true,
			   sticky: true,
			  // position:"fixed",
			  // position: "absolute",
				buttons: {
				 "Guardar Datos": function(){
					 if($('#txtISBN').val()==""){
						alert("DEBE INDICAR ISBN");
						$('#txtISBN').focus();
						return false;
					}
					if($('#txtTITULO').val().length==0){
						alert("DEBE INDICAR TITULO");
						$('#txtTITULO').focus();
						return false;
					}
					if($('#cmbAUTOR').val()==0){
						alert("DEBE SELECCIONAR AUTOR");
						$('#cmbAUTOR').focus();
						return false;
					}
					
					if($('#cmbEDITORIAL').val()==0){
						alert("DEBE SELECCIONAR EDITORIAL");
						$('#cmbEDITORIAL').focus();
						return false;
					}
					if($('#txtEDICION').val()==""){
						alert("DEBE INDICAR EDICION");
						$('#txtEDICION').focus();
						return false;
					}
					if($('#txtANOPUB').val()==""){
						alert("DEBE INDICAR AÑO PUBLICACION");
						$('#txtANOPUB').focus();
						return false;
					}
					if($('#cmbCATEGORIA').val()==0){
						alert("DEBE SELECCIONAR CATEGORIA");
						$('#cmbCATEGORIA').focus();
						return false;
					}
					if($('#cmbIDIOMA').val()==0){
						alert("DEBE SELECCIONAR IDIOMA");
						$('#cmbIDIOMA').focus();
						return false;
					}
					/*if($('#txtPAGINAS').val()==''){
						alert("DEBE INDICAR CANTIDAD DE PAGINAS");
						$('#txtPAGINAS').focus();
						return false;
					}*/
						Agregar();
					  
					   
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
	var funcion =3;
	var isbn = $('#txtISBN').val();
	var titulo = $('#txtTITULO').val();
	//var autor = $('#cmbAUTOR').val();
	var autor = [];
	$("#cmbAUTOR option:selected").map(function(){
    	autor.push($(this).val());
  	});
  
	var editorial = $('#cmbEDITORIAL').val();
	var edicion = $('#txtEDICION').val();
	var ano_publicacion = $('#txtANOPUB').val();
	//var categoria = $('#cmbCATEGORIA').val();
	var categoria = [];
	$("#cmbCATEGORIA option:selected").map(function(){
    	categoria.push($(this).val());
  	});
	
	var idioma = $('#cmbIDIOMA').val();
	var paginas = parseInt($('#txtPAGINAS').val());
	var lectura_comp = ($('#chkLCOMP').is(':checked'))?1:0;
	var rdb = <?php echo $_INSTIT ?>;
	var ejem = parseInt($('#ejem').val());
	var estante = $('#estante').val();
	var sacable = ($('#chkSACABLE').is(':checked'))?1:0;
	var parametros="funcion="+funcion+"&isbn="+isbn+"&titulo="+titulo+"&autor="+autor+"&editorial="+editorial+"&edicion="+edicion+"&ano_publicacion="+ano_publicacion+"&categoria="+categoria+"&idioma="+idioma+"&paginas="+paginas+"&lectura_comp="+lectura_comp+"&rdb="+rdb+"&ejem="+ejem+"&estante="+estante+"&sacable="+sacable;
	

 $.ajax({
	  url:'cont_libro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//$("#tabla").html(data);
		console.log(data);
		if(data==1){
		alert("DATOS GUARDADOS");
		$("#dialog").dialog("close");
		busqueda();
		}
		
		else if(data==2){
		alert("TITULO YA SE ENCUENTRA REGISTRADO");
		}
		else{
		alert("ERROR AL GUARDAR");
		
		}
		  }
	  })
}


function busqueda(){
var criterio = $('#cmbCRIT').val(); 
var filtro = $('#txtCRIT').val();
var orden =  $('#cmbORDEN').val();
var rdb = <?php echo $_INSTIT ?>;

var parametros="funcion=4&criterio="+criterio+"&filtro="+filtro+"&orden="+orden+"&rdb="+rdb;

 $.ajax({
	  url:'cont_libro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#lista").html(data);
		  }
	  })
	  

}

function ejemplar(lbr){
	var parametros="funcion=5&lbr="+lbr;
	
	$.ajax({
		url:"cont_libro.php",
		data:parametros,
		type:'POST',
		success: function(data){
			$('#dialog').prop('title', 'Ejemplares Libro');
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
				  "Cerrar": function(){
					$(this).dialog("close");
				  }
				}   
			  }) 
		}
	})
		
	



}

function NuevoEjemplar(){
	var id_libro = $("#lbri").val();
	
	var parametros="funcion=6&id_libro="+id_libro;
	
	$.ajax({
		url:"cont_libro.php",
		data:parametros,
		type:'POST',
		success: function(data){
			$('#dialogd').prop('title', 'Agregar Ejemplares Libro');
			$("#dialogd").html(data);
			$("#dialogd").dialog({ 
			   closeOnEscape: false,
			   modal:true,
			   resizable: true,
			   Width: 360,
			   Height: 360,
			   minWidth: 360,
			   minHeight: 360,
			   maxWidth: 360,
			   maxHeight: 360,
			   show: "fold",
			   hide: "scale",
			   stack: true,
			   sticky: true,
			  // position:"fixed",
			  // position: "absolute",
				buttons: {
				 "Guardar Datos": function(){
					 
					  guardaEjemplar();
					   
					 } ,
				 "Cerrar": function(){
					$(this).dialog("close");
				  }
				}   
			  })
			   
			  
		}
	})
		
}

function guardaEjemplar(){
var funcion=7;
var id_libro =  $("#lbri").val();
var codigo =  $("#txtCODLIBRO").val();
var ubicacion =  $("#txtESTANTE").val();

	if(ubicacion==""){
		alert("DEBE ESCRIBIR UBICACION");
		$('#txtESTANTE').focus();
		return false;
	}
else{
var parametros="funcion="+funcion+"&id_libro="+id_libro+"&codigo="+codigo+"&ubicacion="+ubicacion;

 $.ajax({
	  url:'cont_libro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//$("#lista").html(data);
		alert("DATOS GUARDADOS");
		$("#dialogd").dialog("close");
		$("#dialog").dialog("close");
		ejemplar(id_libro);
		  }
	  })
}

}


function bajaL(lbr){
var funcion=8;
var parametros="funcion="+funcion+"&id_libro="+lbr;
if(confirm("SEGURO DE ELIMINAR TITULO?")){
		 $.ajax({
	  url:'cont_libro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//$("#lista").html(data);
		alert("TITULO DADO DE BAJA");
		
		busqueda();
		  }
	  })
	
}
	
}
function bajaE(ejm){
var funcion=9;
var id_libro =  $("#lbri").val();
var parametros="funcion="+funcion+"&id_ejemplar="+ejm;
if(confirm("SEGURO DE DAR DE BAJA EJEMPLAR?")){
	 $.ajax({
	  url:'cont_libro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//$("#lista").html(data);
		alert("EJEMPLAR DADO DE BAJA");
		$("#dialog").dialog("close");
		ejemplar(id_libro);
		  }
	  })
}
}

function editaE(ejm){
	//var id_libro = $("#lbri").val();
	
	var parametros="funcion=10&id_ejemplar="+ejm;
	
	$.ajax({
		url:"cont_libro.php",
		data:parametros,
		type:'POST',
		success: function(data){
			$('#dialogd').prop('title', 'Modificar Ejemplar Libro');
			$("#dialogd").html(data);
			$("#dialogd").dialog({ 
			   closeOnEscape: false,
			   modal:true,
			   resizable: true,
			   Width: 360,
			   Height: 360,
			   minWidth: 360,
			   minHeight: 360,
			   maxWidth: 360,
			   maxHeight: 360,
			   show: "fold",
			   hide: "scale",
			   stack: true,
			   sticky: true,
			  // position:"fixed",
			  // position: "absolute",
				buttons: {
				 "Guardar Datos": function(){
					 
					  guardaEjemplarEdit();
					   
					 } ,
				 "Cerrar": function(){
					$(this).dialog("close");
				  }
				}   
			  }) 
		}
	})
		
}

function guardaEjemplarEdit(){
var funcion=11;
var id_libro =  $("#lbri").val();
var id_ejemplar =  $("#txtEJEMPLAR").val();
var ubicacion =  $("#txtESTANTE").val();

	if(ubicacion==""){
		alert("DEBE ESCRIBIR UBICACION");
		$('#txtESTANTE').focus();
		return false;
	}
else{
var parametros="funcion="+funcion+"&id_ejemplar="+id_ejemplar+"&ubicacion="+ubicacion;

 $.ajax({
	  url:'cont_libro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		console.log(data);
		alert("DATOS GUARDADOS");
		$("#dialogd").dialog("close");
		ejemplar(id_libro);
		  }
	  })
}
}

function editaL(lbr){
	


	var parametros="funcion=12&id_libro="+lbr;
	
	$.ajax({
		url:"cont_libro.php",
		data:parametros,
		type:'POST',
		success: function(data){
			$('#dialoge').prop('title', 'Editar Datos Libro');
			$("#dialoge").html(data);
			$("#dialoge").dialog({ 
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
					 if($('#txtISBN').val()==""){
						alert("DEBE INDICAR ISBN");
						$('#txtISBN').focus();
						return false;
					}
					if($('#txtTITULO').val()==""){
						alert("DEBE INDICAR TITULO");
						$('#txtTITULO').focus();
						return false;
					}
					if($('#cmbAUTOR').val()==0){
						alert("DEBE SELECCIONAR AUTOR");
						$('#cmbAUTOR').focus();
						return false;
					}
					
					if($('#cmbEDITORIAL').val()==0){
						alert("DEBE SELECCIONAR EDITORIAL");
						$('#cmbEDITORIAL').focus();
						return false;
					}
					if($('#txtEDICION').val()==""){
						alert("DEBE INDICAR EDICION");
						$('#txtEDICION').focus();
						return false;
					}
					if($('#txtANOPUB').val()==""){
						alert("DEBE INDICAR AÑO PUBLICACION");
						$('#txtANOPUB').focus();
						return false;
					}
					if($('#cmbCATEGORIA').val()==0){
						alert("DEBE SELECCIONAR CATEGORIA");
						$('#cmbCATEGORIA').focus();
						return false;
					}
					if($('#cmbIDIOMA').val()==0){
						alert("DEBE SELECCIONAR IDIOMA");
						$('#cmbIDIOMA').focus();
						return false;
					}
					if($('#txtPAGINAS').val()==''){
						alert("DEBE INDICAR CANTIDAD DE PAGINAS");
						$('#txtPAGINAS').focus();
						return false;
					}
					if($('#estante').val()==''){
						alert("DEBE INDICAR UBICACION");
						$('#estante').focus();
						return false;
					}
						guardaEdit();
					  
					   
					 } ,
				 "Cerrar": function(){
					$(this).dialog("close");
				  }
				}   
			  }) 
		}
	})

}

function guardaEdit(){
var funcion=13;
var lll = $('#ed_libro').val()
var isbn = $('#txtISBN').val();
var titulo = $('#txtTITULO').val();
//var autor = $('#cmbAUTOR').val();
var editorial = $('#cmbEDITORIAL').val();
var edicion = $('#txtEDICION').val();
var ano_publicacion = $('#txtANOPUB').val();
//var categoria = $('#cmbCATEGORIA').val();
var idioma = $('#cmbIDIOMA').val();
var paginas = $('#txtPAGINAS').val();
var lectura_comp = ($('#chkLCOMP').is(':checked'))?1:0;
var sacable = ($('#chkSACABLE').is(':checked'))?1:0;
var estante = $('#estante').val(); 

 var autor = [];
	$("#cmbAUTOR option:selected").map(function(){
    	autor.push($(this).val());
  	});
	
var categoria = [];
	$("#cmbCATEGORIA option:selected").map(function(){
    	categoria.push($(this).val());
  	});

var parametros="funcion="+funcion+"&isbn="+isbn+"&titulo="+titulo+"&autor="+autor+"&editorial="+editorial+"&edicion="+edicion+"&ano_publicacion="+ano_publicacion+"&categoria="+categoria+"&idioma="+idioma+"&paginas="+paginas+"&lectura_comp="+lectura_comp+"&lll="+lll+"&sacable="+sacable+"&estante="+estante;

 $.ajax({
	  url:'cont_libro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		console.log(data);
		if(data==1){
			alert("DATOS GUARDADOS");
			$("#dialoge").dialog("close");
			$("#lista").html(data);
			busqueda();
		}
		
		/*else if(data==2){
		alert("TITULO YA SE ENCUENTRA REGISTRADO");
		}
		else{
		alert("ERROR AL GUARDAR");
		
		}*/
		  }
	  })
}


function NuevoAutor(){	
	var parametros="funcion=2";
	
	$.ajax({
		url:"../autor/cont_autor.php",
		data:parametros,
		type:'POST',
		success: function(data){
			$('#dialogd').prop('title', '');
			$('#dialogd').prop('title', 'Agregar autor');
			$("#dialogd").html(data);
			$("#dialogd").dialog({ 
			   closeOnEscape: false,
			   modal:true,
			   resizable: true,
			   Width: 360,
			   Height: 360,
			   minWidth: 360,
			   minHeight: 360,
			   maxWidth: 360,
			   maxHeight: 360,
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
					 
					 AgregarAutor();
					  $(this).dialog("destroy");
					
					   
					 } ,
				 "Cerrar": function(){
					$(this).dialog("destroy");
				  }
				}   
			  }) 
		}
	})
		

}


function AgregarAutor(){
var funcion=3;

 var nombre =$("#txtNOMBRE").val();
 var nacio = $("#txtNACIONALIDAD").val();
 var rdb = <?php echo $_INSTIT ?>;
 var parametros="funcion="+funcion+"&nombre="+nombre+"&nacio="+nacio+"&rdb="+rdb;
 
 $.ajax({
	  url:'../autor/cont_autor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  console.log(data);
		  if(data==1){
			 ListadoAutor();
		  }else{
			  alert("ERROR AL GUARDAR");			  
		  }
		  }
	  })	

}

function ListadoAutor(){
	var funcion=8;
	var parametros="funcion="+funcion;
	$.ajax({
	  url:'../autor/cont_autor.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#au").html(data);
		  }
	  })

}





function NuevoEditorial(){


	
	var parametros="funcion=2";
	
	$.ajax({
		url:"../editorial/cont_editorial.php",
		data:parametros,
		type:'POST',
		success: function(data){
			$('#dialogd').prop('title', '');
			$('#dialogd').prop('title', 'Agregar Editorial');
			$("#dialogd").html(data);
			$("#dialogd").dialog({ 
			   closeOnEscape: false,
			   modal:true,
			   resizable: true,
			   Width: 360,
			   Height: 360,
			   minWidth: 360,
			   minHeight: 360,
			   maxWidth: 360,
			   maxHeight: 360,
			   show: "fold",
			   hide: "scale",
			   stack: true,
			   sticky: true,
			  // position:"fixed",
			  // position: "absolute",
				buttons: {
				 "Guardar Datos": function(){
					 if($('#txtNOMBRE').val()==""){
						alert("DEBE INDICAR NOMBRE DE EDITORIAL");
						$('#txtNOMBRE').focus();
						return false;
					}
					 AgregarEditorial();
					 $(this).dialog("destroy");
					
					   
					 } ,
				 "Cerrar": function(){
					$(this).dialog("destroy");
				  }
				}   
			  }) 
		}
	})
		
}



function AgregarEditorial(){
var funcion=3;

 var nombre =$("#txtNOMBRE").val();
 var nacio = $("#txtNACIONALIDAD").val();
 var rdb = <?php echo $_INSTIT ?>;
 var parametros="funcion="+funcion+"&nombre="+nombre+"&nacio="+nacio+"&rdb="+rdb;
 
 $.ajax({
	  url:'../editorial/cont_editorial.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==1){
			
			  ListadoEditorial();
		  }else{
			  alert("ERROR AL GUARDAR");			  
		  }
		  }
	  })	

}

function ListadoEditorial(){
	var funcion=4;
	var parametros="funcion="+funcion;
	$.ajax({
	  url:'../editorial/cont_editorial.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#edi").html(data);
		  }
	  })

}



function NuevoCategoria(){
	
	var parametros="funcion=2";
	
	$.ajax({
		url:"../categoria/cont_categoria.php",
		data:parametros,
		type:'POST',
		success: function(data){
			$('#dialogd').prop('title', '');
			$('#dialogd').prop('title', 'Agregar Categoría');
			$("#dialogd").html(data);
			$("#dialogd").dialog({ 
			   closeOnEscape: false,
			   modal:true,
			   resizable: true,
			  Width: 360,
			   Height: 360,
			   minWidth: 360,
			   minHeight: 360,
			   maxWidth: 360,
			   maxHeight: 360,
			   show: "fold",
			   hide: "scale",
			   stack: true,
			   sticky: true,
			  // position:"fixed",
			  // position: "absolute",
				buttons: {
				 "Guardar Datos": function(){
					 if($('#txtNOMBRE').val()==""){
						alert("DEBE INDICAR NOMBRE DE CATEGORIA");
						$('#txtNOMBRE').focus();
						return false;
					}
					  AgregarCategoria();
					  $(this).dialog("destroy");
					   
					 } ,
				 "Cerrar": function(){
					$(this).dialog("destroy");
				  }
				}   
			  }) 
		}
	})
		


}



function AgregarCategoria(){
 var nombre =$("#txtNOMBRE").val();
 var rdb = <?php echo $_INSTIT ?>;
 var parametros="funcion=3&nombre="+nombre+"&rdb="+rdb;
 
 $.ajax({
	  url:'../categoria/cont_categoria.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==1){
			
			  ListadoCategoria();
		  }else{
			  alert("ERROR AL GUARDAR");			  
		  }
		  }
	  })	

}

function ListadoCategoria(){
	var funcion=7;
	var parametros="funcion="+funcion;
	$.ajax({
	   url:'../categoria/cont_categoria.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#cate").html(data);
		  }
	  })

}


function NuevoIdioma(){


	
	var parametros="funcion=2";
	
	$.ajax({
		url:"../idioma/cont_idioma.php",
		data:parametros,
		type:'POST',
		success: function(data){
			$('#dialogd').prop('title', '');
			$('#dialogd').prop('title', 'Agregar Idioma');
			$("#dialogd").html(data);
			$("#dialogd").dialog({ 
			   closeOnEscape: false,
			   modal:true,
			   resizable: true,
			   Width: 360,
			   Height: 360,
			   minWidth: 360,
			   minHeight: 360,
			   maxWidth: 360,
			   maxHeight: 360,
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
					
						AgregarIdioma();
					  
					   $(this).dialog("destroy");
					 } ,
				 "Cerrar": function(){
					$(this).dialog("destroy");
				  }
				}   
			  }) 
		}
	})
		


}



function AgregarIdioma(){

 var nombre =$("#txtNOMBRE").val();
 var rdb = <?php echo $_INSTIT ?>;
 var parametros="funcion=3&nombre="+nombre+"&rdb="+rdb;
 
 $.ajax({
	  url:'../idioma/cont_idioma.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==1){
			
			  ListadoIdioma();
		  }else{
			  alert("ERROR AL GUARDAR");			  
		  }
		  }
	  })	

}


function ListadoIdioma(){
	var funcion=4;
	var parametros="funcion="+funcion;
	$.ajax({
	   url:'../idioma/cont_idioma.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#idi").html(data);
		  }
	  })

}

function comparaLib(){
var titulo=	 $("#txtTITULO").val();
var funcion = 15;
var parametros="funcion="+funcion+"&titulo="+titulo;
	$.ajax({
	   url:'cont_libro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// $("#idi").html(data);
		//console.log(data)
		  }
	  })
}


function codigoBarra(idlibro)
{
var funcion = 15;
var parametros="idlibro="+idlibro+"&funcion="+funcion;
  
	$.ajax({
	    url:'cont_libro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  $("#dialogc").html(data);
		 $("#dialogc" ).dialog(
		 {
      resizable: true,
      height: "auto",
      width: 800,
      modal: true,
      buttons: {
        "Imprimir": function() {
         desWord(idlibro);
        },
        "Salir": function() {
          $( this ).dialog( "close" );
        }
      }
    }
		 );
		 
		
		  }
	  })
}
function desWord(idlibro){
var ruta = "codbarra/codbarraW.php?idlibro="+idlibro;
window.open(ruta, '_blank');

}
function codigoBarraEjemplar(idejemplar)
{
var funcion = 16;
var parametros="idejemplar="+idejemplar+"&funcion="+funcion;
 $("#dialogc").html("");
  
	$.ajax({
	    url:'cont_libro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
		  $("#dialogc").html(data);
		 $("#dialogc" ).dialog(
		 {
      resizable: true,
      height: "auto",
      width: 800,
      modal: true,
      buttons: {
        "Imprimir": function() {
         desWordE(idejemplar);
        },
        "Salir": function() {
          $( this ).dialog( "close" );
        }
      }
    }
		 );
		 
		
		  }
	  })
}
function desWordE(ejemplar){
var ruta = "codbarra/codbarraE.php?ejemplar="+ejemplar;
window.open(ruta, '_blank');

}
function cargaExcel(){
var funcion=17;
var parametros = "funcion="+funcion;
$.ajax({
	    url:'cont_libro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
		  $("#dialogx").html(data);
		 $("#dialogx" ).dialog(
		 {
      resizable: true,
      height: "auto",
      width: 800,
      modal: true,
      buttons: {
        "Guardar": function() {
         subeXLS();
        },
        "Salir": function() {
          $( this ).dialog( "close" );
        }
      }
    }
		 );
		 
		
		  }
	  })
}
function subeXLS(){
var funcion=18;
var fd = new FormData();
var formData = new FormData();
var file = document.getElementById('arc').files[0];

if(file !== undefined){
var fileName = file.name;
//obtenemos la extensión del archivo
fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
//obtenemos el tamaño del archivo
var fileSize = file.size;
//obtenemos el tipo de archivo image/png ejemplo
var fileType = file.type;

if(isValid(fileExtension)){
			if(isValidSize(fileSize)){
		showMessage("<span class='info'>Archivo para subir: "+fileName+"</span><br><span class='info'> peso total: "+fileSize+" bytes.</span>");	
		
		fd.append('archivo', file);
		fd.append('funcion', funcion);
		
		$.ajax({
		url: 'cont_libro.php',
		data: fd,
		type: 'POST',
		contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
		processData: false, // NEEDED, DON'T OMIT THIS
		success: function (data) {
		//console.log(data);
		if(data!=1){
			alert(data);
			}
			else{
				 $("#dialogx").dialog( "close" );
			}
		
		}
		
		});
		
			}else{
				showMessage("<span class='error'>Error: Archivo tiene un tama&ntilde;o superior a 4MB</span>");	
			}
		}
		else{
		showMessage("<span class='error'>Error: Archivo tiene una extesi&oacute;n inv&aacute;lida</span>");	
		
		}


}else{
showMessage("<span class='error'>Error: DEBE selecccionar in archivo con extens&oacute;n xls o xlsx</span>");	
		
		}

}

//para extension
function isValid(extension)
{
    switch(extension.toLowerCase()) 
    {
        case 'xls': case 'xlsx':
            return true;
        break;
        default:
            return false;
        break;
    }
}

function isValidSize(size)
{
   
       if(size<=4194304)
            return true;
       else
            return false;
       
    
}
//como la utilizamos demasiadas veces, creamos una función para 
//evitar repetición de código
function showMessage(message){
    $(".messages").html("").show();
    $(".messages").html(message);
}

function existeISBN(){
var funcion=19;
var isbn = $("#txtISBN").val();
if(isbn!=""){
var parametros = "funcion="+funcion+"&isbn="+isbn;
$.ajax({
	   url:'cont_libro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data!=1){
			alert(data);
		  }
		  }
	  })
}
}


 
</script>
<title>SISTEMA SAE:====> BIBLIOTECA</title>
</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0" >

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="3" valign="top" background="../../cortes/<?=$_INSTIT;?>/fondo_01_reca.jpg" width="50"  height="900"></td>
    <td colspan="2" align="center" valign="top" height="70" ><? include("../../cabecera_new/head.php");?></td>
    <td rowspan="3" background="../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td valign="top" align="left"><? include("../../menu_new/menu_biblio.php");?></td>
    <td valign="top" align="center"><br />
    <table width="95%" border="0" cellpadding="0" cellspacing="0" class="cajaborde" >
    <tr>
    	<td width="5%" colspan="4"><br /><div id="tabla"></div></td>
    </tr>
    </table>
	
</td>
  </tr>
  <tr>
    <td colspan="2" valign="bottom" align="center" ><? include("../../cabecera_new/footer.html");?></td>
  </tr>
</table>
<div id="dialog">&nbsp;</div>
<div id="dialoge">&nbsp;</div>
<div id="dialogd">&nbsp;</div>
<div id="dialogc">&nbsp;</div>
<div id="dialogx">&nbsp;</div>
</body>

</html>
