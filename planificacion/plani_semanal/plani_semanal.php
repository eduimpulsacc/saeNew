<?php 
require("../../util/header.php");
session_start();
$_POSP=2;
//var_dump($_GET);
//echo $_NOMBREUSUARIO;
//show($_SESSION);

if(!session_is_registered('_CURSO')){
  session_register('_CURSO');
};

if(!session_is_registered('_ANO')){
  session_register('_ANO');
}	

if(!session_is_registered('_MENU')){
  session_register('_MENU');
}

if(!session_is_registered('_CATEGORIA')){
  session_register('_CATEGORIA');
}

if(!session_is_registered('_VOL')){
  session_register('_VOL');
}

if(isset($orr)){
$id_ramo = $rr;
$_ANO = $aa;
$_CURSO = $cc;
$_MENU = 4;
$_CATEGORIA = 61;
$_VOL = $orr;
$_PERFIL = 17;
}


if($_VOL==1){
	require("../plani_anual/mod_plani.php");
	$uni2 = new Unidad();
	$ru = $uni2->traeUnidad($conn,$_GET['iun']);
	$iiun = pg_result($ru,14);
	
		
		
		$ruta = "../plani_semanal/plani_semanal.php?iun=$iiun"; 
		}else{
			$ruta = "../plani_anual/plani_anual.php";
		}

//echo $ruta;

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<link href="../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link href="../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<style>
.check{
	background-color:#0F70B7;
	color:white;
 
}
.nocheck{
	background-color:blue;

}
.botonXXI {
	BACKGROUND-POSITION: center 50%; FONT-WEIGHT: bolder; LIST-STYLE-POSITION: inside; FONT-SIZE: 11px; Border-Radius:9px;BACKGROUND-IMAGE: url(fondo_linea01.jpg); TEXT-TRANSFORM: none; COLOR: #ffffff; FONT-STYLE: normal; FONT-FAMILY: "Times New Roman", Times, serif; LIST-STYLE-TYPE: disc; BACKGROUND-COLOR: #A39C9C; TEXT-ALIGN: center; FONT-VARIANT: normal
}

.botonBX {
	BACKGROUND-POSITION: center 50%; FONT-WEIGHT: bolder; LIST-STYLE-POSITION: inside; FONT-SIZE: 11px; Border-Radius:9px;BACKGROUND-IMAGE: url(fondo_linea01.jpg); TEXT-TRANSFORM: none; COLOR: #FFFFFF; FONT-STYLE: normal; FONT-FAMILY: "Times New Roman", Times, serif; LIST-STYLE-TYPE: disc; BACKGROUND-COLOR: #DD1A7D; TEXT-ALIGN: center; FONT-VARIANT: normal
}


</style>

<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
 <script type="text/javascript" src="../../admin/clases/jquery-ui-1.9.2.custom/development-bundle/ui/jquery.ui.dialog.js"></script>
<script>

$(document).ready(function(){
	<?php if(!isset($orr)){?>
	traeUnidad(<?php echo $iun?>);
	<?php }else{?>
	traeUnidad(<?php echo $iun?>);
	editaClase(<?php echo $uu?>);
	$("#nvo").html('');
<?php }?>
	
});

function traeUnidad(unidad){
var funcion=1;
var parametros = "funcion="+funcion+"&unidad="+unidad;

	$.ajax({
	  url:'cont_psemanal.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#hdr").html(data);
		<?php if(!isset($orr)){?>
		traeClases();
		<?php  } ?>

		  }
	  })	

}

function creaClase(){
var funcion=2;
var iunidad = $("#iunidad").val();
var icurso = $("#icurso").val();
var iramo = $("#iramo").val();
var cod_ramo = $("#cod_ramo").val();
var doc = $("#doc").val();
var parametros = "funcion="+funcion+"&iunidad="+iunidad+"&icurso="+icurso+"&iramo="+iramo+"&cod_ramo="+cod_ramo+"&doc="+doc;



$("#nvo").html('<input type="button" name="nuevaClase id="nuevaClase" value="Guardar" onclick="GuardaClase()" class="botonXX" /> <input type="button" name="btnC" id="btnC" value="Cancelar" onclick="cancela()"  class="botonXX"/>');

	$.ajax({
	  url:'cont_psemanal.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);&nbsp;
	    $("#tabla").html(data);
		cargatipo($("#crg").val(),iunidad)

		  }
	  })

}

function cargatipo(tipo,unidad)
{
var funcion =4;
var clase =  $("#id_clase").val();
var parametros = "funcion="+funcion+"&unidad="+unidad+"&tipo="+tipo+"&clase="+clase;


$.ajax({
	  url:'cont_psemanal.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);&nbsp;
	    
		$("#mx").css('display','block');
		$("#my").css('display','none');	
	   $("#mx").html(data);
	   dejamarca(tipo);
		
	  
	   }
	})  


}

function creaRecurso(){
	$("#recu").html('<br><form name="ingresoClas" id="ingresoClas" ><table><tr><td width="180"><label class="textonegrita">Nombre:</label></td><td width="174" ><input name="nombre_clas" id="nombre_clas" type="text" size="15" maxlength="30" /></td></tr></table></form>');
		   
	$("#recu").dialog({ 
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
		 if($('#nombre_clas').val()==0){
			alert("Escriba nombre de Rrcurso");
			$('#nombre_clas').focus();
			return false;
		}
		   ingresar_Rec();
		  
		   $(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }) 
		   
  

}

function ingresar_Rec(){
	
var parametros = "funcion=3&nombre="+$("#nombre_clas").val()+"&ins="+$("#ins").val();
//alert (parametros);
  $.ajax({
	url:"cont_psemanal.php",
	data:parametros,
	type:'POST',
	success:function(data){
			if(data == 0){
			   alert("Error al Guardar Datos");
			}else{
			  alert("Datos Guardados");
			 // cargaselectClas();
			 // console.log(data);
			  //.remove().appendTo('#destino');
			  $("#origen").append(data);
			}
		}
	}) 
  }		


function cancela(){
	traeClases();
	 $("#nvo").html(' <input type="button" name="nuevaUnidad" id="nuevaUnidad" value="Nueva Clase" onclick="creaClase()" class="botonXX"/>&nbsp;&nbsp;&nbsp; <input type="button" name="VOLVER" id="VOLVER" value="VOLVER" onclick="location.href=\'<?php echo $ruta ?>\'" class="botonXX" />');
	
}


function traeClases(){
	var funcion=6;
	var unidad =$("#iunidad").val();
	var parametros="funcion="+funcion+"&unidad="+unidad;
	
	$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
				if(data == 0){
				   alert("Error al cargar");
				}else{
					$("#tabla").html(data);
				}
			}
		})
	
	
	
	}


/*function pp(codigo){
//alert(codigo);

 if($("#destino"+codigo+"").is(':checked')) {
  $("#destino"+codigo+"").prop('checked',false);
  $("#fila"+codigo+"").removeClass( "check" );

}

else {
  $("#destino"+codigo+"").prop('checked',true);
  $("#fila"+codigo+"").addClass( "check" );
}
}*/

function pp(codigo){
//alert(codigo);

 if($("#destino"+codigo+"").is(':checked')) {
  $("#destino"+codigo+"").prop('checked',false);
  $("#fila"+codigo+"").removeClass( "check" );
  $("#lindv"+codigo+"").val("");

}

else {
  $("#destino"+codigo+"").prop('checked',true);
  $("#fila"+codigo+"").addClass( "check" );
   indica(codigo);
   
}


}


/*var dato;
var contador;
var valor= new Array();
var arrct = new Array();
function sumaobj(codigo){
var searchIDs2 = [];
 var total_check = $("input.oo[type=checkbox]:checked").length;
 var modi = $("#cargaobj").val();
 
 if(total_check==0){
		valor.length=0;
		arrct.length=0;
		$("#cargaobj").val();
	}
	

 
 if($("#destino"+codigo+"").is(':checked')){
			dato= $("#destino"+codigo+"").val();
			valor.push(dato);
			valor.sort();
			contador = valor.length;
			
			arrct.push(dato);
			arrct.sort();
			var sw=1;
			
		
	
}else{
	for(i=0; i<valor.length; i++){
		if(!$("#destino"+codigo+"").is(':checked')){	
			dato = $("#destino"+codigo+"").val();
			if(dato == valor[i]){
				valor.splice(i,1);
				valor.sort();
				arrct.splice(i,1);
				arrct.sort();
				var sw=1;						
			}
		}
	}
	
}

if(modi.length >0){
	var cuenta = modi.split(",");
	for (var i = 0; i < cuenta.length; i++) {
		//alert(cuenta[i]);
		if($("#destino"+cuenta[i]+"").is(':checked') && sw!=1){
			dato= $("#destino"+cuenta[i]+"").val();
			valor.push(dato);
			valor.sort();
			contador = valor.length;
			
			arrct.push(dato);
			arrct.sort();
		}
	
	}	
}
		
	//alert(valor);	
	$("input.oo[type=checkbox]:checked").map(function(){
    searchIDs2.push($(this).val());
  });
  $("#cargaobj").val(searchIDs2);
	
	 //$("#cargaobj").val(valor);
 		//dejamarcaobj();
}


var dato2;
var contador2;
var valor2= new Array();
var arrct2 = new Array();

function sumahab(codigo){
var searchIDs = [];
 var total_check2 = $("input.hh[type=checkbox]:checked").length;
 var modi2 = $("#cargahab").val();
 
 if(total_check2==0){
		valor2.length=0;
		arrct2.length=0;
		$("#cargahab").val();
	}
	
 
 if($("#destinoh"+codigo+"").is(':checked')){
			dato2= $("#destinoh"+codigo+"").val();
			valor2.push(dato2);
			valor2.sort();
			contador2 = valor2.length;
			
			arrct2.push(dato2);
			arrct2.sort();
			var sw2=1;
			
		
	
}else{
	for(i=0; i<valor2.length; i++){
		if(!$("#destinoh"+codigo+"").is(':checked')){	
			dato2 = $("#destinoh"+codigo+"").val();
			if(dato2 == valor2[i]){
				valor2.splice(i,1);
				valor2.sort();
				arrct2.splice(i,1);
				arrct2.sort();
				var sw2=1;						
			}
		}
	}
	
}

if(modi2.length >0){
	var cuenta2 = modi2.split(",");
	for (var i = 0; i < cuenta2.length; i++) {
		//alert(cuenta[i]);
		if($("#destinoh"+cuenta2[i]+"").is(':checked') && sw2!=1){
			dato2= $("#destinoh"+cuenta2[i]+"").val();
			valor2.push(dato2);
			valor2.sort();
			contador2 = valor2.length;
			
			arrct2.push(dato2);
			arrct2.sort();
		}
		
	
	}	
}
		
	//alert(valor);	
	
	$("input.hh[type=checkbox]:checked").map(function(){
    searchIDs.push($(this).val());
  });
	
	 $("#cargahab").val(searchIDs);
 		//dejamarcaobj();
}
function dejamarcaobj(){
var base = $("#cargaobj").val();
var cuenta = base.split(",");
for (var i = 0; i < cuenta.length; i++) {
	//alert(cuenta[i]);
	$("#destino"+cuenta[i]+"").prop('checked',true);
	$("#fila"+cuenta[i]+"").addClass( "check" );

}	

}
function dejamarcahab(){
	
var base = $("#cargahab").val();
var cuenta = base.split(",");
for (var i = 0; i < cuenta.length; i++) {
	//alert(cuenta[i]);
	$("#destinoh"+cuenta[i]+"").prop('checked',true);
	$("#fila"+cuenta[i]+"").addClass( "check" );

}	
}
*/
function GuardaClase(){
var funcion=5;
// $('#destino option').prop('selected', 'selected');
$('#destino *').attr('selected','selected');
$('#eva_destino *').attr('selected','selected');
var form =$("#frm").serialize();
var total_checko = $("input.oo[type=checkbox]:checked").length;
var total_checkh = $("input.hh[type=checkbox]:checked").length;


var parametros ="funcion="+funcion+"&form="+form; 

//valido fechas
 //var startDate = $.datepicker.parseDate('dd/mm/yy', $("#f_inicio").val());
// var endDate = $.datepicker.parseDate('dd/mm/yy', $("#f_termino").val());

/* var difference = (endDate - startDate) / (86400000);
    //alert(difference)
	 if($("#f_inicio").val()=="")
	{
	alert("Debe Ingresar fecha de Inicio");
	$("#f_inicio").focus();
	}
	
	else if($("#f_termino").val()=="")
	{
	alert("Debe Ingresar fecha de Término");
	$("#f_termino").focus();
	}
	
   else if (difference < 0) {
        alert("Fecha inicio debe ser mayor a fecha término");
		$("#f_inicio").focus();
       
    }
	else if($("#cant_clases").val()=="")
	{
	alert("Debe Ingresar cantidad de clases");
	$("#cant_clases").focus();
	}
	else if($("#cant_horas").val()=="")
	{
	alert("Debe Ingresar cantidad de horas de clases");	
	$("#cant_horas").focus();
	}
	else if($("#txt_nombre").val()=="")
	{
	alert("Debe Nombre de la clase");	
	$("#txt_nombre").focus();
	}
	else if($("#cmb_tipo").val()==0)
	{
	alert("Debe seleccionar tipo de clase");	
	$("#cmb_tipo").focus();
	}
	else if($("#cmbDocente").val()==0)
	{
	alert("Debe seleccionar docente que impartirá la clase");
	$("#cmbDocente").focus();	
	}*/
	
	/*else if($("#eva_destino").val().length==0)
	{
	alert("Debe seleccionar tipo de evaluacion");	
	$("#eva_origen").focus();
	}*/
	
	 if($("#txt_actividades").val()=="")
	{
	alert("Debe describir actividades");	
	$("#txt_actividades").focus();
	}
	
	/*else if($("#txt_desarrollo").val()=="")
	{
	alert("Debe describir desarrollo");	
	$("#txt_desarrollo").focus();
	}
	
	else if($("#txt_cierre").val()=="")
	{
	alert("Debe describir cierre");	
	$("#txt_cierre").focus();
	}
	
	else if($("#txt_actitudes").val()=="")
	{
	alert("Debe describir actitudes");	
	$("#txt_actitudes").focus();
	}
	
	/*else if(total_checko==0){
		alert ("Debe Seleccionar al menos 1 objetivo");
		$("#tipo0").focus();
		$("#tipo0").prop('checked',true);
		cargatipo(0,$("#iunidad").val());
	}
	else if(total_checkh==0){
		alert ("Debe Seleccionar al menos 1 habilidad");
		$("#tipo1").focus();
		$("#tipo1").prop('checked',true);
		cargatipo(1,$("#iunidad").val());
	}*/
	else{
	$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data);
				if(data == 0){
				   alert("Error al Guardar Datos");
				}else{
				  alert("Datos Guardados");
				 // cargaselectClas();
				  //console.log(data);
				  //.remove().appendTo('#destino');
				  traeClases();
				  cancela();
				}
			}
		})
	}

}

function detClase(clase){
var funcion=7;
var parametros ="funcion="+funcion+"&clase="+clase;

$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
				if(data == 0){
				   alert("Error al Cargar Datos");
				}else{
				  //alert("Datos Guardados");
				 // cargaselectClas();
				  //console.log(data);
				  //.remove().appendTo('#destino');
				 $("#tabla").html(data);
				}
			}
		})
}
function editaClase(clase){
var funcion=8;
//var iunidad = $("#iunidad").val();
//var icurso = $("#icurso").val();
//var iramo = $("#iramo").val();
<?php if(!isset($orr)){?>
var cod_ramo = $("#cod_ramo").val();
<?php }else{?>
var cod_ramo = <?php echo $ss ?>;
<?php }?>
//var doc = $("#doc").val();



var parametros ="funcion="+funcion+"&clase="+clase+"&cod_ramo="+cod_ramo;
//alert(parametros);

$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
				if(data == 0){
				   alert("Error al Cargar Datos");
				}else{
				 
				 $("#tabla").html(data);
				}
			}
		})
}


function cargatipoedi(tipo,id_unidad){
//alert(tipo);
var funcion =9;	
var rdb = <?php echo $_INSTIT ?>;
var cod_ramo = $("#rm").val();

var parametros="funcion="+funcion+"&rdb="+rdb+"&cod_ramo="+cod_ramo+"&tipo="+tipo+"&id_unidad="+id_unidad;

$.ajax({
	  url:'cont_psemanal.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		
		if(tipo==0){
		$("#mx").css('display','block');
		$("#my").css('display','none');	
	   $("#mx").html(data);
	   // $("input.oo[type=checkbox]").prop('checked',false);
	  //dejamarcaobj();
		}
		if(tipo==1){
		$("#mx").css('display','none');
		$("#my").css('display','block');	
	   $("#my").html(data);
	  
	   dejamarcahab();
		}
	  
		
		  }
	  })
}

function GuardaClaseEdi(){
var funcion =10;
 //$('#destino option').prop('selected', 'selected');
 $('#destino *').attr('selected','selected');
  $('#eva_destino *').attr('selected','selected');
var form =$("#frm").serialize();
var total_checko = $("input.oo[type=checkbox]:checked").length;
var total_checkh = $("input.hh[type=checkbox]:checked").length;


var parametros ="funcion="+funcion+"&form="+form; 

//valido fechas
 var startDate = $.datepicker.parseDate('dd/mm/yy', $("#f_inicio").val());
 var endDate = $.datepicker.parseDate('dd/mm/yy', $("#f_termino").val());

 var difference = (endDate - startDate) / (86400000);
    //alert(difference)
	 if($("#f_inicio").val()=="")
	{
	alert("Debe Ingresar fecha de Inicio");
	$("#f_inicio").focus();
	}
	
	else if($("#f_termino").val()=="")
	{
	alert("Debe Ingresar fecha de Término");
	$("#f_termino").focus();
	}
	
   else if (difference < 0) {
        alert("Fecha inicio debe ser mayor a fecha término");
		$("#f_inicio").focus();
       
    }
	else if($("#cant_clases").val()=="")
	{
	alert("Debe Ingresar cantidad de clases");
	$("#cant_clases").focus();
	}
	else if($("#cant_horas").val()=="")
	{
	alert("Debe Ingresar cantidad de horas de clases");	
	$("#cant_horas").focus();
	}
	/*else if($("#txt_nombre").val()=="")
	{
	alert("Debe Nombre de la clase");	
	$("#txt_nombre").focus();
	}
	else if($("#cmb_tipo").val()==0)
	{
	alert("Debe seleccionar tipo de clase");	
	$("#cmb_tipo").focus();
	}
	else if($("#cmbDocente").val()==0)
	{
	alert("Debe seleccionar docente que impartirá la clase");
	$("#cmbDocente").focus();	
	}
	
	else if($("#txt_evaluacion").val()=="")
	{
	alert("Debe describir evaluacion");	
	$("#txt_evaluacion").focus();
	}
	
	else if($("#txt_inicio").val()=="")
	{
	alert("Debe describir inicio");	
	$("#txt_inicio").focus();
	}
	
	else if($("#txt_desarrollo").val()=="")
	{
	alert("Debe describir desarrollo");	
	$("#txt_desarrollo").focus();
	}
	
	else if($("#txt_cierre").val()=="")
	{
	alert("Debe describir cierre");	
	$("#txt_cierre").focus();
	}
	
	else if($("#txt_actitudes").val()=="")
	{
	alert("Debe describir actitudes");	
	$("#txt_actitudes").focus();
	}*/
	
	/*else if(total_checko==0){
		alert ("Debe Seleccionar al menos 1 objetivo");
		$("#tipo0").focus();
		$("#tipo0").prop('checked',true);
		cargatipo(0,$("#iunidad").val());
	}
	else if(total_checkh==0){
		alert ("Debe Seleccionar al menos 1 habilidad");
		$("#tipo1").focus();
		$("#tipo1").prop('checked',true);
		cargatipo(1,$("#iunidad").val());
	}*/
	else{
	$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data);
				if(data == 0){
				   alert("Error al Guardar Datos");
				}else{
				  alert("Datos Guardados");
				 // cargaselectClas();
				  console.log(data);
				  //.remove().appendTo('#destino');
				  traeClases();
				}
			}
		})
	}
}

function cambiaEstado(clase){
	var funcion=11;
	var parametros = "funcion="+funcion+"&clase="+clase;
	
	$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data);
				if(data == 0){
				   alert("Error al Cargar Datos");
				}else{
				 
				 $("#est").html(data);
				 $("#est").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 650,
   Height: 500,
   minWidth: 650,
   minHeight: 500,
   maxWidth: 650,
   maxHeight: 500,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
		<?php if($_PERFIL==0 || $_PERFIL==14 || $_PERFIL==25){?>
	 "Guardar Datos": function(){
		
		  if($('#opc_estado').val()==0){
			  alert("Seleccione estado");
			  return false;
			 }
			 
			else if($('#opc_estado').val()==4 && $('#txt_obser').val()==""){
			  alert("Ingrese descripcion");
			  return false;
			 }
		  else{
			 ingresar_estado(); 
			 }
		  
		   $(this).dialog("close");
	     } ,
		<?php }?>
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  })
				}
			}
		})
}

function abrecomen(){
var opc = $('#opc_estado').val();
//alert(opc)
if(opc==4){
//$('#comest').html('<textarea id="txt_obser" name="txt_obser"></textarea>');
$('#comest').html('<table width="599" border="1" style="border-collapse:collapse"><tr><td width="110" class="cuadro02">Motivo rechazo</td><td><textarea id="txt_obser" name="txt_obser" style="margin: 1px black solid; width: 456px; height: 60px;"></textarea></td></tr></table>');
}else{
$('#comest').html('<input  type="hidden" id="txt_obser" name="txt_obser" value="" />');
}
}


 function ingresar_estado(){
	 var funcion=12;
	 var estado=$('#opc_estado').val();
	 var descripcion=$('#txt_obser').val();
	 var clase=$('#clase').val();
	var parametros = "funcion="+funcion+"&clase="+clase+"&estado="+estado+"&descripcion="+descripcion;
	
	$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
				if(data == 0){
				   alert("Error al Guardar Datos");
				}else{
				  alert("Datos Guardados");
				 // cargaselectClas();
				  console.log(data);
				  traeClases();
				  //.remove().appendTo('#destino');
				 // traeClases();
				}
			}
		})
}


function claserl(clase,estado){

var rll=(estado==1)?"REALIZADA":"NO REALIZADA";
var funcion=13;

var parametros = "funcion="+funcion+"&clase="+clase+"&estado="+estado;

if(confirm("\xBFMarcar Clase como "+ rll+"?"))
{
$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data);
				if(data == 0){
				   alert("Error al Guardar Datos");
				}else{
				  alert("Datos Guardados");
				 // cargaselectClas();
				 // console.log(data);
				  traeClases();
				  //.remove().appendTo('#destino');
				 // traeClases();
				}
			}
		})
}
}


function replica(clase){
var cod_ramo = $("#cod_ramo").val();
var funcion=14;
var ano=<?php echo $_ANO ?>;
var parametros = "funcion="+funcion+"&cod_ramo="+cod_ramo+"&clase="+clase+"&ano="+ano;
$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
				if(data == 0){
				   alert("Error al Cargar Datos");
				}else{
				 
				 $("#repli").html(data);
				 $("#repli").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 650,
   Height: 500,
   minWidth: 650,
   minHeight: 500,
   maxWidth: 650,
   maxHeight: 500,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
	 "Guardar Datos": function(){
		 guardaReplica();
		   $(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	},open: function() {
            $(this).dialog('widget').find('button:first').prop('disabled', true);
			
      }   
  })
//activaboton();
  
				}
			}
			
			
			
		})
}
  

function activaboton(){
	
	if($("#cur2").val()>0 && $("#unid").val()>0){
		//alert("llego");
$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('enable');
}
else{
		//alert("llego");
$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('disable');
}
}

function suni(curso){
var funcion=15;
var parametros = "funcion="+funcion+"&curso="+curso;
$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
				if(data == 0){
				   alert("Error al cargar");
				}else{
				    $("#lcur").html(data);
				}
			}
		})
}

function guardaReplica(){
var funcion=16;
var curso = $("#cur2").val();
var fuente = $("#clsorig").val();
var destino = $("#unid").val();
var cod_ramo = $("#cod_ramo").val();

var parametros = "funcion="+funcion+"&curso="+curso+"&fuente="+fuente+"&destino="+destino+"&cod_ramo="+cod_ramo;
//alert(parametros);
$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
				if(data == 0){
				   alert("Error al guardar");
				}else{
				    alert("Clase replicada");
					console.log(data);
				}
			}
		})

}

function asocianota(clase){

var cod_ramo = $("#cod_ramo").val();
var funcion=17;
var ano=<?php echo $_ANO ?>;
var parametros = "funcion="+funcion+"&cod_ramo="+cod_ramo+"&clase="+clase+"&ano="+ano;


$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
				if(data == 0){
				   alert("Error al Cargar Datos");
				}else{
				 
				 $("#nota").html(data);
				 $("#nota").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 650,
   Height: 500,
   minWidth: 650,
   minHeight: 500,
   maxWidth: 650,
   maxHeight: 500,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
	 "Guardar Datos": function(){
			guardaNotas();
		
		   $(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	},open: function() {
            $(this).dialog('widget').find('button:first').prop('disabled', true);
			
      }   
  })
//activaboton();
  
				}
			}
			
			
			
		})

}

function activanota(){
var funcion=18;	
var clase = $('#clase').val();
var unidad = $('#unidad').val();
var periodo = $('#cmbPeriodo').val();
var ramo = $('#ramo').val();

//alert(ramo);
//alert(clase);


var parametros = "funcion="+funcion	+"&clase="+clase+"&unidad="+unidad+"&periodo="+periodo+"&ramo="+ramo;
	
	if($('#cmbPeriodo').val()>0){
	$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
				if(data == 0){
				   alert("Error al cargar");
				}else{
				   $('#chknota').html(data);
				   cuentacheck();
				}
			}
		})
		
	}
	else{
	//$("input.notas[type=checkbox]").removeAttr('checked');
	$('#chknota').html('');
	$("input.notas[type=checkbox]").attr('disabled','disabled');
	$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('disable');
	}
}

function  cuentacheck(){
total_checko = $("input.notas[type=checkbox]:checked").length;
//alert (total_checko);
if(total_checko>0){
			$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('enable');
		}
		else{
			$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('disable');
		}
}

function guardaNotas(){
var funcion=19;
var clase = $('#clase').val();
var unidad = $('#unidad').val();
var periodo = $('#cmbPeriodo').val();
var ramo = $('#ramo').val();

//alert(ramo);

var searchIDs = [];
$("input.notas[type=checkbox]:checked").map(function(){
    searchIDs.push($(this).val());
  });
  
 
var parametros ="funcion="+funcion+"&clase="+clase+"&unidad="+unidad+"&periodo="+periodo+"&pos="+searchIDs+"&ramo="+ramo;
$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			//console.log(data)
				if(data == 0){
				   alert("Error al guardar");
				}else{
				   //$('#chknota').html(data);
				   alert('Datos almacenados')
				  
				}
			}
		})
}

function leccionario(clase){
var cod_ramo = $("#cod_ramo").val();
var funcion=20;
var ano=<?php echo $_ANO ?>;
var parametros = "funcion="+funcion+"&cod_ramo="+cod_ramo+"&clase="+clase+"&ano="+ano;


$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
				if(data == 0){
				   alert("Error al Cargar Datos");
				}else{
				 
				 $("#lex").html(data);
				 $("#lex").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 650,
   Height: 500,
   minWidth: 650,
   minHeight: 500,
   maxWidth: 650,
   maxHeight: 500,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
	 "Guardar Datos": function(){
		 if($("#idlx").val()=="")
		 {guardaLX();}
		 else{
		 guardaEditarLX();
		}
			mcasillero();
			 $(this).dialog('widget').find('button:first').prop('disabled', true);
		
		   //$(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	},open: function() {
            $(this).dialog('widget').find('button:first').prop('disabled', true);
			
      }   
  })
//activaboton();
  
				}
			}
			
			
			
		})

}

function mcasillero(){
var funcion=21;
var clase = $('#clase').val();
var unidad = $('#unidad').val();
var periodo = $('#cmbPeriodo').val();
var ramo = $('#ramo').val();
	
	if(periodo!=0){
	var parametros ="funcion="+funcion+"&clase="+clase+"&unidad="+unidad+"&periodo="+periodo+"&ramo="+ramo;
$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			//console.log(data)
				if(data == 0){
				   alert("Error al cargar");
				}else{
				   $('#infnota').html(data);
				  // alert('Datos almacenados')
				  
				}
			}
		})
	}else{
		 $('#infnota').html('');
		}
}

function nuevoLX(nota){
var funcion=22;
var clase = $('#clase').val();
var unidad = $('#unidad').val();
var periodo = $('#cmbPeriodo').val();
var ramo = $('#ramo').val();	
var ano = <?php echo $_ANO ?>;
var curso = $("#icurso").val();
	
	var parametros ="funcion="+funcion+"&clase="+clase+"&unidad="+unidad+"&periodo="+periodo+"&ramo="+ramo+"&nota="+nota+"&ano="+ano+"&curso="+curso;
$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data)
				if(data == 0){
				   alert("Error al cargar");
				}else{
				   $('#infnota').html(data);
				  // alert('Datos almacenados')
				  
				}
			}
		})
	
}

function valtipo(){

var largo = $("#nombrelx").val().length;
var largofecha = $("#fechalex").val().length;
//alert (total_checko);
if(largo>0 && $("#tipolex").val()>0 && largofecha>0){
			$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('enable');
		}
		else{
			$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('disable');
		}

	
}

function guardaLX(){
var funcion=23;
var descripcion =$("#nombrelx").val();
var periodo = $('#cmbPeriodo').val();
var ramo = $('#ramo').val();	
var ano = <?php echo $_ANO ?>;
var curso = $("#icurso").val();
var fecha = $("#fechalex").val();
var tipo = $("#tipolex").val();
var nota = $("#notalx").val();

var parametros = "funcion="+funcion+"&ano="+ano+"&curso="+curso+"&ramo="+ramo+"&fecha="+fecha+"&descripcion="+descripcion+"&tipo="+tipo+"&nota="+nota+"&id_periodo="+periodo

$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data)
				if(data == 0){
				   alert("Error al guardar");
				}else{
				  
				   alert('Datos guardados');
				   
				  
				}
			}
		})

}

function editaLX(idlec){
var funcion=25;
var clase = $('#clase').val();
var unidad = $('#unidad').val();
var periodo = $('#cmbPeriodo').val();
var ramo = $('#ramo').val();	
var ano = <?php echo $_ANO ?>;
var curso = $("#icurso").val();
	var parametros = "funcion="+funcion+"&idlec="+idlec+"&clase="+clase+"&unidad="+unidad+"&periodo="+periodo+"&ramo="+ramo+"&nota="+nota+"&ano="+ano+"&curso="+curso;;
	$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			//console.log(data)
				if(data == 0){
				   alert("Error al cargar");
				}else{ 
				   $('#infnota').html(data);
				  
				}
			}
		})
	
}

function guardaEditarLX(){
var funcion=26;
var id_lexionario = $("#idlx").val();
var fecha = $("#fechalex").val();
var tipo = $("#tipolex").val();
var descripcion = $("#nombrelx").val();

var parametros = "funcion="+funcion+"&id_lexionario="+id_lexionario+"&fecha="+fecha+"&descripcion="+descripcion+"&tipo="+tipo;

$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data)
				if(data == 0){
				   alert("Error al guardar");
				}else{
				  
				   alert('Datos guardados');
				   
				  
				}
			}
		})

}

function eliminaLX(idlec){
var funcion=24;
var parametros = "funcion="+funcion+"&idlec="+idlec;
if(confirm("\xBFDesea Eliminar este Leccionario?"))
{
$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			//console.log(data)
				if(data == 0){
				   alert("Error al eliminar");
				}else{ 
				   alert('Datos eliminados');
				   mcasillero();
				  
				}
			}
		})
}
}

function nuevotipo(){
var funcion=27;
var ramo = $('#ramo').val();	
var ano = <?php echo $_ANO ?>;
var curso = $("#icurso").val();

var parametros = "funcion="+funcion+"&ramo="+ramo+"&ano="+ano+"&curso="+curso;
$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			$("#tplx").html(data);
			$("#tplx").dialog({ 
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
	 "Guardar Tipo": function(){
			Guardatipo();
		  
		   $(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
			
      }  ,open: function() {
            $(this).dialog('widget').find('button:first').prop('disabled', true);
	}   
  }) 
			}
		})

}

function Guardatipo(){
var funcion=28;
var ramo = $('#ramo').val();	
var ano = <?php echo $_ANO ?>;
var curso = $("#icurso").val();
var nombre = $("#nombretp").val();
var parametros = "funcion="+funcion+"&ramo="+ramo+"&ano="+ano+"&curso="+curso+"&nombre="+nombre;

$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data);
				if(data == 0){
				   alert("Error al guardar");
				}else{ 
				   alert('Datos guardados');
				  cargaTpl();
				  
				}
			}
		})
}


function valtipotp(){

var largo = $("#nombretp").val().length;

//alert (total_checko);
if(largo>0){
			$(".ui-dialog-buttonpane button:contains('Guardar Tipo')").button('enable');
		}
		else{
			$(".ui-dialog-buttonpane button:contains('Guardar Tipo')").button('disable');
		}

	
}

function cargaTpl(){
var ramo = $('#ramo').val();	
var ano = <?php echo $_ANO ?>;
var curso = $("#icurso").val();
var funcion=29;

var parametros = "funcion="+funcion+"&ramo="+ramo+"&ano="+ano+"&curso="+curso;

$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data);
				if(data == 0){
				   alert("Error al cargar");
				}else{ 
				    $("#seltipo").html(data);
				  
				}
			}
		})
}

function cargaArchivo(clase){
	var funcion=30;
	var parametros = "funcion="+funcion+"&clase="+clase;
$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			$("#arv").html(data);
			$("#arv").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: true,
   Width: 400,
   Height: 300,
   minWidth: 400,
   minHeight: 300,
  
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
	 "Guardar Archivo": function(){
			GuardaArchivo();
		  
		   $(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
			
      }  ,open: function() {
            $(this).dialog('widget').find('button:first').prop('disabled', true);
	}   
  }) 
			}
		})
}

function GuardaArchivo(){

}

function creatipoEva(){
	$("#tipoeva").html('<br><form name="ingresoClas" id="ingresoClas" ><table><tr><td width="180"><label class="textonegrita">Nombre:</label></td><td width="174" ><input name="nombre_clas" id="nombre_clas" type="text" size="15" maxlength="30" /></td></tr></table></form>');
		   
	$("#tipoeva").dialog({ 
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
		 if($('#nombre_clas').val()==0){
			alert("Escriba nombre de Rrcurso");
			$('#nombre_clas').focus();
			return false;
		}
		   ingresar_tipoEva();
		  
		   $(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }) 
		   
  

}

function  ingresar_tipoEva(){
var parametros = "funcion=31&nombre="+$("#nombre_clas").val()+"&ins="+$("#ins").val();
//alert (parametros);
  $.ajax({
	url:"cont_psemanal.php",
	data:parametros,
	type:'POST',
	success:function(data){
			if(data == 0){
			   alert("Error al Guardar Datos");
			}else{
			  alert("Datos Guardados");
			 // cargaselectClas();
			 // console.log(data);
			  //.remove().appendTo('#destino');
			  $("#eva_origen").append(data);
			}
		}
	}) 	
	
}


/******************************************************/
var dato3;
var contador3;
var valor3= new Array();
var arrct3 = new Array();
function sumatipo(tipo){

	
var searchIDs3 = [];
 var total_check3 = $("input.oo"+tipo+"[type=checkbox]:checked").length;
 //alert(total_check3);
 var modi3 = $("#cargatipo"+tipo).val();
 
 if(total_check3==0){
		valor3.length=0;
		arrct3.length=0;
		$("#cargatipo"+tipo).val();
	}
	
 
 if($("#destino"+tipo+"").is(':checked')){
			dato3= $("#destino"+tipo+"").val();
			valor3.push(dato);
			valor3.sort();
			contador3 = valor3.length;
			
			arrct3.push(dato);
			arrct3.sort();
			var sw3=1;
			
		
	
}else{
	for(i=0; i<valor3.length; i++){
		if(!$("#destino"+tipo+"").is(':checked')){	
			dato3 = $("#destino"+tipo+"").val();
			if(dato3 == valor3[i]){
				valor3.splice(i,1);
				valor3.sort();
				arrct3.splice(i,1);
				arrct3.sort();
				var sw=1;						
			}
		}
	}
	
}

if(modi3.length >0){
	var cuenta3 = modi3.split(",");
	for (var i = 0; i < cuenta3.length; i++) {
		//alert(cuenta[i]);
		if($("#destino"+cuenta3[i]+"").is(':checked') && sw!=1){
			dato3= $("#destino"+cuenta3[i]+"").val();
			valor3.push(dato3);
			valor3.sort();
			contador3 = valor3.length;
			
			arrct3.push(dato3);
			arrct3.sort();
		}
	
	}	
}
		
	//alert(valor);	
	$("input.oo"+tipo+"[type=checkbox]:checked").map(function(){
    searchIDs3.push($(this).val());
  });
  $("#cargatipo"+tipo).val(searchIDs3);
}



function dejamarca(tipo){
var base = $("#cargatipo"+tipo).val();
var cuenta = base.split(",");
for (var i = 0; i < cuenta.length; i++) {
	//alert(cuenta[i]);
	$("#destino"+cuenta[i]+"").prop('checked',true);
	$("#fila"+cuenta[i]+"").addClass( "check" );

}
}

/******************************************************/

<?php if($_PERFIL==0 ){  ?>
function borraClase(id){
var funcion=32;
var parametros = "funcion="+funcion+"&id_clase="+id;

if(confirm("Seguro de borrar la planificacion de clase?")){
	
	$.ajax({
		url:"cont_psemanal.php",
		data:parametros,
		type:'POST',
		success:function(data){
			alert("DATOS ELIMINADOS");
			traeClases();
			}
		})
	
}


}
<?php }?>

function indica(obj){
//alert(obj);
var funcion=33;
var ttp = $('input:radio[name=tipo]:checked').val();
var un = $("#iunidad").val();
var parametros="funcion="+funcion+"&obj="+obj+"&un="+un;	
$.ajax({
	  url:'cont_psemanal.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// console.log(data);
		 $("#indev").html(data);
			$("#indev").dialog({
				autoOpen:true,
				width: "650px",
  				maxWidth: "450px",
				show: {
				effect: "blind",
				duration: 1000
				},
				hide: {
				effect: "explode",
				duration: 1000
				},buttons: [
    {
        text: 'Guardar',
        open: function() { $(this).addClass('b') }, //will append a class called 'b' to the created 'OK' button.
        click: function() { 
		armalin(obj);
		buscasel(ttp,obj);
		$(this).dialog("close");
		}
    },
    {
        text: "Cancelar",
        click: function() {$( this ).dialog( "close" );}
    }
  ]
					
				
				});
		  }
	  })
}

function ppi(codigo,tipo,rr){
//alert(codigo);


 if($("#ind"+codigo+"").is(':checked')) {
  $("#ind"+codigo+"").prop('checked',false);
  $("#filaind"+codigo+"").removeClass( "check" );
  

}

else {
  $("#ind"+codigo+"").prop('checked',true);
  $("#filaind"+codigo+"").addClass( "check" );
  buscasel(rr,codigo);
 
}



}


var dato4;
var contador4;
var valor4= new Array();
var arrct4 = new Array();

function armalin(tipo){

var searchIDs4 = [];
 var total_check4 = $("input.oid"+tipo+"[type=checkbox]:checked").length;
 
	
var modi4 = $("#lindv"+tipo).val();
 
 if(total_check4==0){
		valor4.length=0;
		arrct4.length=0;
		$("#lindv"+tipo).val();
	}
	
if($("#ind"+tipo+"").is(':checked')){
			dato4= $("#ind"+tipo+"").val();
			valor4.push(dato);
			valor4.sort();
			contador4 = valor4.length;
			
			arrct4.push(dato);
			arrct4.sort();
			var sw=1;
			
		
	
}else{
	for(i=0; i<valor4.length; i++){
		if(!$("#ind"+tipo+"").is(':checked')){	
			dato4 = $("#ind"+tipo+"").val();
			if(dato4 == valor4[i]){
				valor4.splice(i,1);
				valor4.sort();
				arrct4.splice(i,1);
				arrct4.sort();
				var sw=1;						
			}
		}
	}
	
}

if(modi4.length >0){
	var cuenta4 = modi4.split(",");
	for (var i = 0; i < cuenta4.length; i++) {
		//alert(cuenta[i]);
		if($("#ind"+cuenta4[i]+"").is(':checked') && sw!=1){
			dato4= $("#ind"+cuenta4[i]+"").val();
			valor4.push(dato4);
			valor4.sort();
			contador4 = valor4.length;
			
			arrct4.push(dato4);
			arrct4.sort();
		}
	
	}	
}
		
	//alert(valor);	
	$("input.oid"+tipo+"[type=checkbox]:checked").map(function(){
    searchIDs4.push($(this).val());
  });
  
  
  
   
  
  $("#lindv"+tipo).val(searchIDs4);	
}


function buscasel(tipo,codigo){
	//alert(tipo);
var sid=[];
$(".lindv"+tipo+"").map(function(){
	if($(this).val().length>0){
    sid.push($(this).val());
	}
  });
  //alert(sid);
  var con = (sid.length>0)?sid+",":sid;
  
 $("#cargaind"+tipo).val(con);	
}

function vfi(fecha){

 var cfecha = $.datepicker.parseDate('dd/mm/yy', $("#f_inicio").val());
  
  var finicio = $("#ffi").val();
 	var parts = finicio.split("/");
	var di = new Date(parseInt(parts[2], 10),
                  parseInt(parts[1], 10) - 1,
                  parseInt(parts[0], 10));
 

 var ftermino = $("#fft").val();
 var partst = ftermino.split("/");
	var dt = new Date(parseInt(partst[2], 10),
                  parseInt(partst[1], 10) - 1,
                  parseInt(partst[0], 10));
 
 
 if(cfecha<di || cfecha>dt)
 {
	alert("Fecha inicio fuera de rango"); 
	 }
 
 

 //var difference = (endDate - startDate) / (86400000);
	
}
function vft(fecha){
	 var cfecha = $.datepicker.parseDate('dd/mm/yy', $("#f_termino").val());
 //var finicio = Date.parse($("#ffi").val());
// var ftermino = Date.parse($("#fft").val());
 //alert(ftermino);
 
// if(cfecha<finicio || cfecha>ftermino)
// {
	var finicio = $("#ffi").val();
 	var parts = finicio.split("/");
	var di = new Date(parseInt(parts[2], 10),
                  parseInt(parts[1], 10) - 1,
                  parseInt(parts[0], 10));
 

 var ftermino = $("#fft").val();
 var partst = ftermino.split("/");
	var dt = new Date(parseInt(partst[2], 10),
                  parseInt(partst[1], 10) - 1,
                  parseInt(partst[0], 10));
 
 
 if(cfecha<di || cfecha>dt)
 {
	alert("Fecha t\xe9rmino fuera de rango"); 
	 }
	
}

</script>

</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0">


<table width="1280" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td align="left" valign="top" background="../../cortes/<?=$_INSTIT;?>/fondo_01_reca.jpg" width="53"  height="900"></td>
    <td height="100%" align="left" valign="top">
	   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" align="left">
        <tr>
          <td width="640" align="left" valign="top" bgcolor="f7f7f7"><? include("../../cabecera_new/head.php");?></td>
         </tr>
         <tr align="left" valign="top"> 
            <td height="83" colspan="3" valign="top">
				   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" align="left">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"><? include("../../menu_new/index.php");?></td>
                      <td align="left" valign="top" class="s"><br>
<br>

                      <form id="frm" enctype="multipart/form-data" class="formulario">
                      <table width="860" border="0" class="tablaredonda">
                          <tr>
                            <td>

<input type="hidden" name="ff" id="ff" />
<input type="hidden" name="ins" id="ins" value="<?php echo $_INSTIT ?>" />
<div id="hdr"></div>
<br />
<br />
<div id="tabla"></div>
<div id="recu" title="Nuevo Recurso"></div>
<div id="est" title="Estado Clase" align="center"> </div>
<div id="repli" title="Replicar Clase" align="center"> </div>
<div id="nota" title="Asociar clase a una nota" align="center"> </div>
<div id="lex" title="Leccionario" align="center"> </div>
<div id="tplx" title="Tipo Leccionario" align="center"> </div>
<div id="arv" title="Subir Archivos" align="center"> </div>
<div id="tipoeva" title="Nuevo tipo Evaluaci&oacute;n"></div>
<div id="indev" title="Seleccionar indicadores de Evaluaci&oacute;n"></div>

<br />

</td>
                          </tr>
                        </table>
</form>
					 </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina" align="left"><? include("../../cabecera_new/footer.html");?></td>
                    </tr>
                  </table>
		    </td>
         </tr>
       </table>
    </td>
 <td align="left" valign="top" background="../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
</table>

</td>

    <!--<td width="53" align="center" valign="top" height="100%" >ACA IMAGEN DERECHA</td>-->
  </tr>
</table> 
</body>
</html>
