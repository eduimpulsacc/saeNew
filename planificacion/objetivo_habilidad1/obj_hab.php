<?php 
require("../../util/header.php");
session_start();
$_POSP=2;
//var_dump($_SESSION);<a href="../../util/header.php">header.php</a>
?>
<!doctype html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<link href="../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link href="../../cortes/8933/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<link href="../../cortes/8933/estilos.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	listado();
  });


/*function Inicio(){
	 $("#tabs").tabs();
	var parametros="funcion=3";
	$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  
		  }
	  })		
}*/
function listado(){
	var parametros="funcion=1";
	$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#tabla").html(data);
		  }
	  })		
}

function agregar(){
	var parametros="funcion=2";
	$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#tabla").html(data);
		  }
	  })	
}

function guardar(){
	var codigo 	= $("#txtCODIGO").val();
	var opcion 	= $('input[name=obj_hab]:checked').val();
	var texto  	= $("#arTEXTO").val();
	var eje 	= $("#cmbEJE").val();
	var parametros ="funcion=3&codigo="+codigo+"&tipo="+opcion+"&eje="+eje+"&texto="+texto;
	//alert(parametros);
	$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// console.log(data);
		  if(data==1){
			  if(!confirm("DATOS ALMACENADOS, DESEA INGRESAR MAS INFORMACION")){
				 listado();
			  }else{
				   listado();
				//alert("llego");  
			  }
		  }else{
			alert("ERROR AL GUARDAR"); 
		  }
	   
		  }
	  })	
}

function agregar_obj(){
var tipo = $('input:radio[name=obj_hab]:checked').val();

var parametros ="funcion=6&tipo="+tipo;
//alert(parametros);
$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
		 $("#titeje").html(data);
		 $("#titeje").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 400,
   Height: 300,
   minWidth: 400,
   minHeight: 300,
   maxWidth: 400,
   maxHeight: 300,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
	 "Guardar Datos": function(){
		
		   ingresarEje();
		  
		   $(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	},open: function() {
          	$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('disable');
			
      }      
  }) 
		  
	   
		  }
	  })

	
}

function existeCodigo(){
var cadena = $("#txtCODIGO").val();
var parametros = "funcion=5&cadena="+cadena;

if(cadena.length>0 && cadena.trim()!=""){
$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
	   if(data==1){
		   alert("CODIGO YA EXISTE");
		   }
		  }
	  })	 
}
}

function activaBotonEje(){
var lopc = $('input:radio[name=obj_hab2]:checked').length;
var cods = $('#codsubsector').val();
var ltxt = $('#nomeje').val();

if(lopc>0 && (ltxt.length>0 && ltxt.trim()!="") && ( cods!=0 && cods.trim()!="")){
			$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('enable');
		}
		else{
			$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('disable');
		}
}

function ingresarEje(){
var funcion=7;
var nombre = $("#nomeje").val();
var tipo=$('input:radio[name=obj_hab2]:checked').val();
var rbd =  $("#rbd").val();
var codramo = $("#codsubsector").val();
var parametros = "funcion="+funcion+"&nombre="+nombre+"&tipo="+tipo+"&rbd="+rbd+"&codramo="+codramo;

$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  
	   if(data==0){
		   alert("Error al guardar");
		   }else{
			 alert("Datos guardados");
			 
			 $("#subs").val(codramo);
			 $("#obj_hab"+tipo).prop("checked", true);
			 ejes(tipo,codramo);
			}
		  }
	  })
}

function ejes(tipo){
if(!tipo){tipo=$('input:radio[name=obj_hab]:checked').val()}

var subsector= $("#subs").val();
var funcion=8;
var parametros = "funcion="+funcion+"&tipo="+tipo+"&subsector="+subsector;
$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	   if(data==0){
		   alert("Error al cargar");
		   }else{
			$("#combeje").html(data);
			}
		  }
	  })
}

function gradoense(){
var funcion=9;
var tipoense=$("#tipense").val();
var parametros = "funcion="+funcion+"&tipoense="+tipoense;
$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
	   if(data==0){
		   alert("Error al cargar");
		   }else{
			$("#grados").html(data);
			}
		  }
	  })

}

function veramo(){
var cadena=""
cadena = $("#subs").val();


var parametros = "funcion=10&cadena="+cadena;

if(cadena.length>0 && cadena.trim()!=""){
$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// console.log(data);
	   if(data==0){
		   alert("SUBSECTOR NO EXISTE");
		   }
		  }
	  })	 
}
}

function veramo2(){

var cadena = $("#codsubsector").val();

var parametros = "funcion=10&cadena="+cadena;

if(cadena.length>0 && cadena.trim()!=""){
$.ajax({
	  url:'cont_obj_hab.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
	   if(data==0){
		   alert("SUBSECTOR NO EXISTE");
		   }
		  }
	  })	 
}
}

</script>
<title>SAE: SISTEMA PLANIFICACION</title>
</head>

<body>

<table width="1280" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100%" align="left" valign="top">
	   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <!--<td width="53" align="center" valign="top">ACA IMAGEN IZQUIERDA</td>-->
          <td width="640" align="center" valign="top" bgcolor="f7f7f7"><? include("../../cabecera_new/head.php");?></td>
         </tr>
         <tr align="left" valign="top"> 
            <td height="83" colspan="3" valign="top">
				   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <? include("../../menu_new/index.php");?>
						
					  </td>
                      <td align="left" valign="top" class="s"><br>
<br>

                      <div align="center" id="tabla">&nbsp;</div>
    <div id="titeje" align="center">&nbsp;</div>
					 </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("footer.html");?></td>
                    </tr>
                  </table>
		    </td>
         </tr>
       </table>
    </td>

  </tr>
</table>

</td>

    <!--<td width="53" align="center" valign="top" height="100%" >ACA IMAGEN DERECHA</td>-->
  </tr>
</table>
	
   <!-- <div id="tabs">
      <ul>
        <li><a href="#tabs-1">OBJETIVOS</a></li>
        <li><a href="#tabs-2">HABILIDADES</a></li>
      </ul>
	</div>-->
</body>
</html>
