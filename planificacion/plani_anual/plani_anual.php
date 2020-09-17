<?php 
require("../../util/header.php");

$_POSP=2;
//if($_PERFIL==0)var_dump($_SESSION);
	   
session_start();

if(!session_is_registered('_CURSO')){
  session_register('_CURSO');
};	

if(!session_is_registered('_ANO')){
  session_register('_ANO');
};	

if(!session_is_registered('_MENU')){
  session_register('_MENU');
};

if(!session_is_registered('_CATEGORIA')){
  session_register('_CATEGORIA');
};
	   
if(isset($orr)){
$id_ramo = $rr;
$_ANO = $aa;
$_CURSO = $cc;
$_MENU = 4;
$_CATEGORIA = 61;
$_PERFIL = 17;
}


if(!$_IDR){
	 $_IDR = $id_ramo;
}
	
  if(!session_is_registered('_IDR')){
	      session_register('_IDR');
	   };
	

	
 

	/*if(!$id_ramo){
	 $id_ramo = $_IDR;
	}*/
	
	
//echo "<BR>ramo-->".$_IDR;



?>
<!doctype html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<link href="../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link href="../../cortes/<?=$_INSTIT;?>/estilos.css" rel="stylesheet" type="text/css"> 
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
<!--<link href="../../cortes/<?=$_INSTIT;?>/estilos.css" rel="stylesheet" type="text/css"> -->
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
<script src="../../admin/clases/jquery/moment.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
	traeCurso(<?php echo $_ANO ?>);
	traeRamo(<?php echo $_CURSO ?>);
	dicta(<?php echo $_IDR ?>);
	traeEnse(<?php echo $_CURSO ?>);
	codigo(<?php echo $_IDR ?>);
	

  });
  
  function traeCurso(ano){
	 // alert("lego");
	var funcion =1;
	//var crs = "<?php echo $_CURSO ?>";
	var parametros="funcion="+funcion+"&ano="+ano;
	 // $("#prof").html('<input type="text" name="docdicta" id="docdicta" value="0" />');
	// alert(crs); 
	
	$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#cur").html(data);

		  }
	  })		
	
}

function traeRamo(curso){
	document.getElementById("prof").innerHTML = '<input type="hidden" name="docdicta" id="docdicta" value="0" />';
	var funcion =2;
	var rmo = <?php echo $_IDR ?>;
	var parametros="funcion="+funcion+"&curso="+curso+"&rmo="+rmo;
	 
	$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
	    $("#ram").html(data);
		
		  }
	  })	
	
}

function dicta(ramo){
	
	var funcion =3;
	var parametros="funcion="+funcion+"&ramo="+ramo;
	//alert (parametros);
	
	$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#prof").html(data);
		<?php if(!isset($orr)){?>
		cancela();
		<?php }?>
		  }
	  })	
	
}

function traeEnse(curso){
var funcion=6;
var parametros = "funcion="+funcion+"&curso="+curso; 
$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		  if(data==0){
			alert("ERROR AL CARGAR");
			}
			else {
			$("#gren").html(data);
			}
			
			
		
		
		  }
	  })
}


function traeUnidades(){
var funcion =4;
var curso= $("#sel_curso").val();
var ramo= $("#sel_ramo").val();
var docente = $("#docdicta").val();
var rdb = <?php echo $_INSTIT ?>;
var id_ano = <?php echo $_ANO ?>;

$("#tipou").html('');

var parametros = "funcion="+funcion+"&curso="+curso+"&ramo="+ramo+"&docente="+docente+"&rdb="+rdb+"&id_ano="+id_ano;
//alert(parametros);
$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#tabla").html(data);
		
		  }
	  })	
}
function cancela(){
 $("#nvo").html('<input type="button" name="nuevaUnidad" id="nuevaUnidad" class="botonXX" value="Nueva Unidad" onclick="creaUnidad()">   <input type="button" name="busca" id="busca" class="botonXX" value="Buscar" onclick="traeUnidades()" />');
  traeUnidades();
  
}

function creaUnidad(){
var funcion =5;
var curso= $("#sel_curso").val();
var ramo= $("#sel_ramo").val();
var docente = $("#docdicta").val();
var rdb = <?php echo $_INSTIT ?>;
var cod_ramo = $("#cod_ramo").val();
var ense = $("#ens").val();
var grado = $("#grdo").val();


 //$("#cargaobj").val()
 //$("#cargahab").val()

if(curso>0 && ramo>0){

 $("#nvo").html('<input type="button" name="nuevaUnidad" id="nuevaUnidad" class="botonXX" value="Guardar" onclick="GuardaUnidad()" /> <input type="button" name="nuevaUnidad" id="nuevaUnidad"  class="botonXX" value="Cancelar" onclick="cancela()" />');
   

var parametros = "funcion="+funcion+"&curso="+curso+"&ramo="+ramo+"&docente="+docente+"&rdb="+rdb+"&cod_ramo="+cod_ramo+"&ense="+ense+"&grado="+grado;

$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	   $("#tabla").html(data);
		cargatipo($("#crg").val());
		$("#tipo0").prop('checked',true);
		
		  }
	  })
	
} else{
alert("Debe seleccionar curso y ramo");
$("#sel_curso").focus();
}
		
}

function traeEnse(curso){
var funcion=6;
var parametros = "funcion="+funcion+"&curso="+curso; 
$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		  if(data==0){
			alert("ERROR AL CARGAR");
			}
			else {
			$("#gren").html(data);
			}
			
			
		
		
		  }
	  })
}

function codigo(ramo){
var funcion =7;
var parametros = "funcion="+funcion+"&ramo="+ramo;
$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#cod_ramo").val(data);
		
		  }
	  })		
}
function cargatipo(tipo,unidad){
	//alert(unidad);

var funcion =8;	
var rdb = <?php echo $_INSTIT ?>;
var cod_ramo = $("#cod_ramo").val();
var curso = $("#sel_curso").val();


var parametros="funcion="+funcion+"&rdb="+rdb+"&cod_ramo="+cod_ramo+"&tipo="+tipo+"&curso="+curso+"&unn="+unidad;
///alert(parametros);
//$("#x").html(tipo);
$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		//if(tipo==0){
		$("#mx").css('display','block');
		  $("#mx").html(data);
	   dejamarca(tipo);
		//}
		/*if(tipo==1){
		$("#mx").css('display','none');
		$("#my").css('display','block');	
	   $("#my").html(data);
	   dejamarcahab();
		}*/
	   //codigo($("#rm").val());
		
		  }
	  })
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

function pp(codigo){


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

function indica(obj){
//alert(obj);
var funcion=9;
var ttp = $('input:radio[name=tipo]:checked').val()
var parametros="funcion="+funcion+"&obj="+obj;	
$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		 $("#ind").html(data);
			$("#ind").dialog({
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
/******************************************************/
var dato3;
var contador3;
var valor3= new Array();
var arrct3 = new Array();
function sumatipo(tipo){

	
var searchIDs3 = [];
 var total_check3 = $("input.oo"+tipo+"[type=checkbox]:checked").length;

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
		
	
	$("input.oo"+tipo+"[type=checkbox]:checked").map(function(){
    searchIDs3.push($(this).val());
  });
  $("#cargatipo"+tipo).val(searchIDs3);
}

function cmes(){
	var mes=$("#mes").val();
	var nano = $("#nn_ano").val();
	$("#fecha_inicio").val("");	
$("#fecha_termino").val("");
	var funcion =10;
var parametros = "funcion="+funcion+"&nano="+nano;
$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#sem").html(data);
		
		  }
	  })	
	
}


function GuardaUnidad(){

var funcion =11;
var ano = <?php echo $_ANO ?>;
var rdb = <?php echo $_INSTIT ?>;
$('#destino').prop('selected',true);

var frm=$("#frm").serialize();
var parametros = "&funcion="+funcion+"&ano="+ano+"&rdb="+rdb+"&frm="+frm;
var total_checko = $("input.oo[type=checkbox]:checked").length;
var total_checkh = $("input.hh[type=checkbox]:checked").length;

 var startDate = $.datepicker.parseDate('dd/mm/yy', $("#fecha_inicio").val());
 var endDate = $.datepicker.parseDate('dd/mm/yy', $("#fecha_termino").val());

    var difference = (endDate - startDate) / (86400000);
  
    if (difference < 0) {
        alert("Fecha inicio debe ser mayor a fecha término");
       
    }
	/*else if($("#txt_nombre").val()==""){
	alert ("Debe ingresar Nombre Unidad");
	$("#txt_nombre").focus();
	}
	else if($("#cant_clases").val()==""){
	alert ("Debe ingresar Cantidad Clases");
	$("#cant_clases").focus();
	}
	else if($("#txt_horas").val()==""){
	alert ("Debe ingresar Cantidad Horas");
	$("#txt_horas").focus();
	}
	else if($("#texto").val()==""){
	alert ("Debe ingresar Texto descriptivo Unidad");
	$("#texto").focus();
	}
	else if($("#sel_curso").val()==0){
	alert ("Debe Seleccionar Curso");
	$("#sel_curso").focus();
	}
	else if($("#sel_ramo").val()==0){
	alert ("Debe Seleccionar RAMO");
	$("#sel_ramo").focus();
	}
	
	else if($("#txt_fechaini").val()==""){
	alert ("Debe ingresar Fecha Inicio");
	$("#txt_fechaini").focus();
	}
	
	else if($("#txt_fechater").val()==""){
	alert ("Debe ingresar Fecha Termini");
	$("#txt_fechater").focus();
	}*/
	
else{
$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		console.log(data);
		if(data==0){
			alert("ERROR AL GUARDAR");
		}
		else if(data==2)
		{
			alert("EXISTEN UNIDADES ASOCIADAS AL CURSO CON SIMILAR RANGO DE FECHAS");
			
		}
		else
		{
			alert("DATOS GUARDADOS");
			
			traeUnidades();
			cancela();
		}
		
	
		
		  }
	  })

}
}
function goUnidad(unidad){
//var parametros = "unidad="+unidad;	

location.href='../plani_semanal/plani_semanal.php?iun='+unidad;

}
<?php if($_PERFIL==0){  ?>
function borraAnual(id){
var funcion=12;
var parametros = "funcion="+funcion+"&id_unidad="+id;

if(confirm("Seguro de borrar la planificacion anual?")){
	
	$.ajax({
		url:"cont_plani.php",
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data);
			alert("DATOS ELIMINADOS");
			traeUnidades();
			}
		})
	
}


}<? }?>
function cambiaEstado(unidad){
	var funcion=13;
	var parametros = "funcion="+funcion+"&unidad="+unidad;
	
	$.ajax({
		url:"cont_plani.php",
		data:parametros,
		type:'POST',
		success:function(data){
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
	 var funcion=14;
	 var estado=$('#opc_estado').val();
	 var descripcion=$('#txt_obser').val();
	 var unidad=$('#unidad').val();
	var parametros = "funcion="+funcion+"&unidad="+unidad+"&estado="+estado+"&descripcion="+descripcion;
	//alert(parametros);
	
	$.ajax({
		url:"cont_plani.php",
		data:parametros,
		type:'POST',
		success:function(data){
			  
				if(data == 0){
				   alert("Error al Guardar Datos");
				}else{
				  alert("Datos Guardados");
				 
				
				 traeUnidades();
				}
			}
		})
}
////
function veUnidad(idUnidad){
var funcion =15;
var parametros = "funcion="+funcion+"&idUnidad="+idUnidad;

//alert(parametros);

$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		
	   $("#tabla").html(data);
		
		  }
	  })

}


function editaUnidad(idUnidad){
var funcion =16;

var rdb = <?php echo $_INSTIT ?>;
<?php if($orr!=1){?>
var grdo = $("#grdo2"+idUnidad).val();
var ens = $("#ens2"+idUnidad).val();
var cod_ramo= $('#rm'+idUnidad+'').val();
<?php }else{?>
var grdo = <?php echo $gg ?>;
var ens = <?php echo $ee ?>;
var cod_ramo = <?php echo $ss ?>
//var cod_ramo = 288;

<?php }?>
var parametros = "funcion="+funcion+"&idUnidad="+idUnidad+"&cod_ramo="+cod_ramo+"&rdb="+rdb+"&grdo="+grdo+"&ens="+ens;

$("#nvo").html('<input type="button" name="actUnidad" id="actaUnidad" value="Actualizar Datos" onclick="GuardaUnidadAct()" class="botonXX"/> <input type="button" name="cUnidad" id="cUnidad" value="Cancelar" onclick="cancela()" class="botonXX" />');


$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	   $("#tabla").html(data);
	   
	 
		
		  }
	  })

}

function cargatipoedi(tipo,id_unidad){

var funcion =17;	
var rdb = <?php echo $_INSTIT ?>;
var cod_ramo = $("#rm").val();
var curso = $("#cr").val();

var parametros="funcion="+funcion+"&rdb="+rdb+"&cod_ramo="+cod_ramo+"&tipo="+tipo+"&id_unidad="+id_unidad+"&curso="+curso;

//$("#x").html(tipo);
$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		
		//if(tipo==0){
		$("#mx").css('display','block');
		$("#my").css('display','none');	
	   $("#mx").html(data);
	   // $("input.oo[type=checkbox]").prop('checked',false);
	  dejamarca(tipo);
		//}
		
	   //codigo($("#rm").val());
		
		  }
	  })
}


function GuardaUnidadAct(){
	
var funcion =18;	
$('#obj_destino option').prop('selected', true);
$('#hab_destino option').prop('selected', true);
var frm=$("#frm").serialize();
$('#destino').prop('selected',true);
var parametros = "funcion="+funcion+"&frm="+frm;

	//if($('#tipoFecha').val()==2){
	
	 var startDate = $.datepicker.parseDate('dd/mm/yy', $("#fecha_inicio").val());
	 var endDate = $.datepicker.parseDate('dd/mm/yy', $("#fecha_termino").val());
	
		var difference = (endDate - startDate) / (86400000);
		//alert(difference)
		if (difference < 0) {
			alert("Fecha inicio debe ser mayor a fecha término");
		   
		}
	//}
	//else if ($('#tipoFecha').val()==1){
		/*if($('#cmbMes').val()==0){
		alert("Selecicone mes");	
		$("#cmbMes").focus();
		return false;
		}*/
	//}
	
	/* if($("#txt_nombre").val()==""){
	alert ("Debe ingresar Nombre Unidad");
	$("#txt_nombre").focus();
	}
	
	else if($("#cant_clases").val()==""){
	alert ("Debe ingresar Cantidad Clases");
	$("#cant_clases").focus();
	}
	
	else if($("#txt_horas").val()==""){
	alert ("Debe ingresar Cantidad Horas");
	$("#txt_horas").focus();
	}
	
	else if($("#texto").val()==""){
	alert ("Debe ingresar Texto descriptivo Unidad");
	$("#texto").focus();
	}
		
	else if($("#txt_fechaini").val()==""){
	alert ("Debe ingresar Fecha Inicio");
	$("#txt_fechaini").focus();
	}
	
	else if($("#txt_fechater").val()==""){
	alert ("Debe ingresar Fecha Termino");
	$("#txt_fechater").focus();
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
	}

else{*/

$.ajax({
	  url:'cont_plani.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		
		if(data==0){
			alert("ERROR AL GUARDAR");
		}else
		{
			alert("DATOS GUARDADOS");
			traeUnidades();
			cancela();
		}
		
	// $("#tabla").html(data);
		
		  }
	  })
//}

	}
	
	function impPL(ipl){
	var funcion=19;	
	var parametros="funcion="+funcion+"&ipl="+ipl;
	//alert("llego i");
		
			
		  $.ajax({
			url:"cont_plani.php",
		data:parametros,
			type:'POST',
			success:function(data){
		   
		  // alert(data);
			//alert("Datos guardados");
			 $(".print").html(data);
			$("#prp").dialog({
				autoOpen:true,
				width: "740px",
  				maxWidth: "550px",
				show: {
				effect: "blind",
				duration: 1000
				},
				hide: {
				effect: "explode",
				duration: 1000
				},
				
    buttons: {
	 "Imprimir": function(){
		 $( "#prp" ).dialog( "close" );
	     PrintElem('.print');
		 } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	} ,
	 create:function () {
        $(this).closest(".ui-dialog").find(".ui-button:first").addClass("printer");
    }
				});
		
	  }
	})	
		
		
		
		
	
}
	
	 function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'Planificación', 'height=400,width=600');
        mywindow.document.write('<html><head><title>my div</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
	
	
function calsem(){
if($("#fecha_inicio").val()!="" && $("#fecha_termino").val()!=""){

var startDate = $.datepicker.parseDate('dd/mm/yy', $("#fecha_inicio").val());
var endDate = $.datepicker.parseDate('dd/mm/yy', $("#fecha_termino").val());

var difference = (endDate - startDate) / (86400000);
//alert(difference)
if (difference < 0) {
alert("Fecha inicio debe ser menor a fecha término");

}else{


var fi = $("#fecha_inicio").val().split("/");
var ft = $("#fecha_termino").val().split("/");


var a = moment([fi[2], (fi[1]-1), fi[0]]);


var b = moment([ft[2], (ft[1]-1), ft[0]]);


var diferencia= b.diff(a, 'week')+1;




$("#cant_semanas").val(diferencia);	

$("#mes").val(fi[1]);
cmes();

}
}
}

function cdias(){
alert("hola");
var campo = $("#semana option:selected").text();
if($("#semana option:selected").val()!=0){
var cmd = campo.split(" ");
var fi = cmd[3].replace(/\-/g, '/');
var ft = cmd[5].replace(/\-/g, '/');
$("#fecha_inicio").val(fi);	
$("#fecha_termino").val(ft);
}	
else{
$("#fecha_inicio").val("");	
$("#fecha_termino").val("");	
}

}
</script>
<title>SAE: SISTEMA PLANIFICACION</title>
</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0">

<table width="1280" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="3" valign="top" background="../../cortes/<?=$_INSTIT;?>/fondo_01_reca.jpg" width="50"  height="900"></td>
    <td colspan="2" align="left" valign="top" height="70"><? include("../../cabecera_new/head.php");?></td>
    <td rowspan="3" background="../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td valign="top" align="left"><? include("../../menu_new/index.php");?></td>
    <td valign="top" align="center">
    	<br />
		<br />
        <table width="870" border="0" class="cajaborde">
          <tr>
            <td><br> <form id="frm">
                        <input type="hidden" name="rr" id="rr" value="" />
                        <table width="860" border="0" class="tablaredonda">
  <tr>
    <td>

                        <table width="650" border="0" align="center">
                          <tr>
                            <td width="195" class="textonegrita">CURSO:</td>
                            <td width="439"><div id="cur">
                            <select name="sel_curso" id="sel_curso" class="select_redondo">
                            <option value="0">Seleccione...</option>
                            </select></div></td>
                          </tr>
                          <tr>
                            <td class="textonegrita">ASIGNATURA</td>
                            <td><div id="ram">
                              <select name="sel_ramo" id="sel_ramo" class="select_redondo">
                              <option value="0">Seleccione...</option>
                              </select>
                            </div></td>
                          </tr>
                          <tr>
                            <td class="textonegrita">PROFESOR</td>
                            <td>
                            <div id="prof">
                                  <input type="hidden" name="docdicta" id="docdicta" value="0" />
                            </div>
                            </td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                            <td>
                            <input type="hidden" name="cod_ramo" id="cod_ramo" value="" />
                            <span id="gren">
                             <input type="hidden" name="grdo" id="grdo" />
                             <input name="ens" type="hidden" id="ens" />
                             </span>
                             </td>
                          </tr>
                          <tr>
                            <td colspan="2" align="left">
                            <table width="100%" border="0">
                              <tr>
                                <td align="right"><div id="nvo">
                                                              
                                    <input type="button" name="busca" id="busca" class="botonXX" value="Buscar" onclick="traeUnidades()" border="0" /></div></td>
                              </tr>
                            </table>

                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" align="right" class="textosimple"><div id="tipou"></div></td>
                          </tr>
                          <tr>
                            <td colspan="2" align="right">
                           
                            </td>
                          </tr>
                        </table>
                        <br />
                        <br />
                        <div id="tabla"></div><br />

                        </td>
  </tr>
</table>
                        </form>
  			<div align="center" id="tabla"><br>
<br>
				<div id="listado"></div>

            </td>
          </tr>
        </table>
     
		<div id="titeje" align="center">&nbsp;</div>
    </td>
  </tr>
  <tr>
    <td colspan="2"><? include("../../cabecera_new/footer.html");?></td>
  </tr>
</table>
<div id="replica" align="center"></div>
<div id="est" title="Estado Unidad" align="center"> </div>
<div id="ind" title="Seleccionar indicadores de Evaluaci&oacute;n"></div>
<div id="prp" title="Informaci&oacute;n planificación" class="print"></div>
</body>
</html>
