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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<link href="../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
<title>SAE - MODULO DE PLANIFICACION</title>
<!--<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> -->
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

<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link href="../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 

<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
 <script type="text/javascript" src="../../admin/clases/jquery-ui-1.9.2.custom/development-bundle/ui/jquery.ui.dialog.js"></script>

<script>

$(document).ready(function(){
	
	traeCurso(<?php echo $_ANO ?>);
	/*traeRamo(<?php echo $_CURSO ?>);*/
	dicta(<?php echo $_IDR ?>);
	/*traeEnse(<?php echo $_CURSO ?>);*/
	codigo(<?php echo $_IDR ?>);
	<?php if(isset($orr)){?>
	
	$( "#sel_curso option:selected" ).val(<?php echo $cc ?>);
	$( "#sel_ramo option:selected" ).val(<?php echo $rr ?>);
	
	editaUnidad(<?php echo $uu ?>);
	
	<?php }?>

  });
  
  function traeCurso(ano){
	 // alert("lego");
	var funcion =1;
	//var crs = "<?php echo $_CURSO ?>";
	var parametros="funcion="+funcion+"&ano="+ano;
	 // $("#prof").html('<input type="text" name="docdicta" id="docdicta" value="0" />');
	// alert(crs); 
	
	$.ajax({
	  url:'cont_unidad.php',
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
	/*var rmo = <?php echo $_IDR ?>;*/
	var crm = $("#sel_curso").val().split("_");
	var grd = crm[0];
	var ens = crm[1];
	//var parametros="funcion="+funcion+"&curso="+curso+"&rmo="+rmo;
	var parametros="funcion="+funcion+"&grd="+grd+"&ens="+ens;
	
	 
	$.ajax({
	  url:'cont_unidad.php',
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
	  url:'cont_unidad.php',
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

function traeUnidades(){
var funcion =4;
var curso= $("#sel_curso").val();
var ramo= $("#sel_ramo").val();
var docente = 0;
var rdb = <?php echo $_INSTIT ?>;
var id_ano = <?php echo $_ANO ?>;

$("#tipou").html('');

var parametros = "funcion="+funcion+"&curso="+curso+"&ramo="+ramo+"&docente="+docente+"&rdb="+rdb+"&id_ano="+id_ano;
//alert(parametros);
$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#tabla").html(data);
		
		  }
	  })	
}



function tipoUnidad(){
$("#tipou").html('<input name="tipu" type="radio" value="2" onclick="carga()"/>Est&aacute;ndar');
$("#tabla").html('');
}

function carga(){
	
var tipo = 2;
creaUnidad(tipo);
}

function creaUnidad(tipo){

var funcion =(tipo==1)?5:17;
var curso= $("#sel_curso").val();
var ramo= $("#sel_ramo").val();
var docente = $("#docdicta").val();
var rdb = <?php echo $_INSTIT ?>;
var cod_ramo = $("#cod_ramo").val();
var grdo = $("#grdo").val();
var ens = $("#ens").val();

 $("#cargaobj").val()
 $("#cargahab").val()

if(sel_curso!=0 && ramo>0){
<!--<input type="button" name="nuevaUnidad" id="nuevaUnidad" class="botonXX" value="Guardar" onclick="GuardaUnidad()" />-->
 $("#nvo").html(' <input type="button" name="nuevaUnidad" id="nuevaUnidad" value="Nueva Planificaci&oacute;n" onclick="carga()" class="botonXX" /> <input type="button" name="nuevaUnidad" id="nuevaUnidad"  class="botonXX" value="Cancelar" onclick="cancela()" />');
   

var parametros = "funcion="+funcion+"&curso="+curso+"&ramo="+ramo+"&docente="+docente+"&rdb="+rdb+"&cod_ramo="+cod_ramo+"&grdo="+grdo+"&ens="+ens;
//alert(parametros);
if(funcion==5){
	$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#tabla").html(data);
		cargatipo($("#crg").val());
		$("#tipo0").prop('checked',true);
		
		  }
	  })
	
}else if(funcion==17){
 if(confirm("Se crear\u00E1 planificaci\u00F3n est\u00E1ndar, \u00BFDesea continuar?")){
	 
	generaStd();
	 
	 }

}



	
} else{
alert("Debe seleccionar curso y ramo");
$("#sel_curso").focus();
}
		
}

function cancela(){
 $("#nvo").html('<input type="button" name="nuevaUnidad" id="nuevaUnidad" value="Nueva Planificaci&oacute;n" onclick="carga()" class="botonXX" /> <input type="button" name="busca" id="busca" class="botonXX" value="Buscar" onclick="traeUnidades()" />');
  traeUnidades();
  
}

function codigo(ramo){
var funcion =6;
var parametros = "funcion="+funcion+"&ramo="+ramo;
$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#cod_ramo").val(data);
		
		  }
	  })		
}

function codigo2(ramo){
var funcion =6;
var parametros = "funcion="+funcion+"&ramo="+ramo;
$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
	    $("#cod_ramo").val(data);
		
		  }
	  })		
}

function cargaSelObj(id_eje){
var funcion =7;
var rdb = <?php echo $_INSTIT ?>;
var parametros = "funcion="+funcion+"&id_eje="+id_eje+"&rdb="+rdb;

$('#obj_destino option').remove();
 
 $.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	   $("#objetivos").html(data);
		
		  }
	  })
 
}


function cargaSelHab(id_eje){
var funcion =8;
var rdb = <?php echo $_INSTIT ?>;
 var parametros = "funcion="+funcion+"&id_eje="+id_eje+"&rdb="+rdb;
 $('#hab_destino option').remove();
 
 $.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
		
	   $("#habilidades").html(data);
		
		  }
	  })
 
}


function GuardaUnidad(){
//alert("paso");
var funcion =9;
var ano = <?php echo $_ANO ?>;
var rdb = <?php echo $_INSTIT ?>;
$('#destino').prop('selected',true);

var frm=$("#frm").serialize();
var parametros = "&funcion="+funcion+"&ano="+ano+"&rdb="+rdb+"&frm="+frm;
var total_checko = $("input.oo[type=checkbox]:checked").length;
var total_checkh = $("input.hh[type=checkbox]:checked").length;

 var startDate = $.datepicker.parseDate('dd/mm/yy', $("#txt_fechaini").val());
 var endDate = $.datepicker.parseDate('dd/mm/yy', $("#txt_fechater").val());

    var difference = (endDate - startDate) / (86400000);
    //alert(difference)
    if (difference < 0) {
        alert("Fecha inicio debe ser mayor a fecha t\u00E9rmino");
       
    }
	else if($("#txt_nombre").val()==""){
	alert ("Debe ingresar Nombre Unidad");
	$("#txt_nombre").focus();
	}
	
	
	else if($("#txt_semana").val()==""){
	alert ("Debe ingresar Cantidad Semanas Clases");
	$("#txt_semana").focus();
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
	
	else if($("#tipoFecha").val()==1 && $("#cmbMes").val()==0){
				alert ("Debe Seleccionar Mes");
				$("#cmbMes").focus();
		}
	
			
	else if($("#tipoFecha").val()==2 && $("#txt_fechaini").val()==""){
			alert ("Debe ingresar Fecha Inicio");
			$("#txt_fechaini").focus();
			}
			
	else if($("#tipoFecha").val()==2 && $("#txt_fechater").val()==""){
			alert ("Debe ingresar Fecha T\u00E9rmino");
			$("#txt_fechater").focus();
			}
			
	else if($("#tipoFecha").val()==0){
		alert("Debe seleccionar tipo de fecha unidad")
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
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		
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

function veUnidad(idUnidad){
var funcion =10;
var parametros = "funcion="+funcion+"&idUnidad="+idUnidad;

//alert(parametros);

$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		
	   $("#tabla").html(data);
		
		  }
	  })

}


function editaUnidad(idUnidad){
var funcion =11;

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
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	   $("#tabla").html(data);
	   
	 
		
		  }
	  })

}

function GuardaUnidadAct(){
var funcion =12;	
$('#obj_destino option').prop('selected', true);
$('#hab_destino option').prop('selected', true);
var frm=$("#frm").serialize();
$('#destino').prop('selected',true);
var parametros = "funcion="+funcion+"&frm="+frm;

	if($('#tipoFecha').val()==2){
	
	 var startDate = $.datepicker.parseDate('dd/mm/yy', $("#txt_fechaini").val());
	 var endDate = $.datepicker.parseDate('dd/mm/yy', $("#txt_fechater").val());
	
		var difference = (endDate - startDate) / (86400000);
		//alert(difference)
		if (difference < 0) {
			alert("Fecha inicio debe ser mayor a fecha término");
		   
		}
	}
	else if ($('#tipoFecha').val()==1){
		if($('#cmbMes').val()==0){
		alert("Selecicone mes");	
		$("#cmbMes").focus();
		return false;
		}
	}
	
	 if($("#txt_nombre").val()==""){
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
	  url:'cont_unidad.php',
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
}
}

function cargatipo(tipo,unidad){
	//alert(unidad);

var funcion =13;	
var rdb = <?php echo $_INSTIT ?>;
//var cod_ramo = $("#cod_ramo").val();
var cod_ramo = $("#sel_ramo").val();
var curso = $("#sel_curso").val();


var parametros="funcion="+funcion+"&rdb="+rdb+"&cod_ramo="+cod_ramo+"&tipo="+tipo+"&curso="+curso+"&unn="+unidad;
//alert(parametros);
//$("#x").html(tipo);
$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		//if(tipo==0){
		$("#mx").css('display','block');
		$("#my").css('display','none');	
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

function cargatipoedi(tipo,id_unidad){

var funcion =14;	
var rdb = <?php echo $_INSTIT ?>;
var cod_ramo = $("#rm").val();
var curso = $("#cr").val();

var parametros="funcion="+funcion+"&rdb="+rdb+"&cod_ramo="+cod_ramo+"&tipo="+tipo+"&id_unidad="+id_unidad+"&curso="+curso;

//$("#x").html(tipo);
$.ajax({
	  url:'cont_unidad.php',
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
/*function pp2(codigo){
//alert(codigo);

 if($("#destinoh"+codigo+"").is(':checked')) {
  $("#destinoh"+codigo+"").prop('checked',false);
  $("#fila"+codigo+"").removeClass( "check" );

}

else {
  $("#destinoh"+codigo+"").prop('checked',true);
  $("#fila"+codigo+"").addClass( "check" );
}


}
*/
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
	
	// $("#cargahab").val(valor2);
 		//dejamarcaobj();
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
}*/

function goUnidad(unidad){
//var parametros = "unidad="+unidad;	

location.href='../BPunidad/unidad.php?iun='+unidad;

}

function replicaUnidad(unidad){
var funcion=15;
var codramo = $("#rm"+unidad+"").val();
var ano = <?php echo $_ANO; ?>;
var grado = $("#grdo").val();
var ens = $("#ens").val();
var cur = $("#sel_curso").val();
var parametros = "funcion="+funcion+"&unidad="+unidad+"&codramo="+codramo+"&ano="+ano+"&grado="+grado+"&ens="+ens+"&cur="+cur;
	
$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
		
	   $("#replica").html(data);
	   	 $("#replica").dialog({ 
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
		
		   guardaReplica();
		  
		   $(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	},open: function() {
          	$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('disable');
			
      }      
  })
	   
	   //codigo($("#rm").val());
		
		  }
	  })
}


function marcatodo(){

	var marcado = $("#all").is(':checked');
	
	if(!marcado)
	 $(".cursoshab input[type=checkbox]").prop('checked', false)
	else
	 $(".cursoshab input[type=checkbox]").prop('checked', true)
				
}


function marcacur(){
var total_check = $("input.curr[type=checkbox]:checked").length;
if(total_check>0){
$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('enable');
}else{
	$(".ui-dialog-buttonpane button:contains('Guardar Datos')").button('disable');
}
}

function guardaReplica(){
var funcion=16;
var unidad = $("#idu").val();
var ano = $("#ida").val();
var codramo =$("#idr").val();
var searchIDs = [];
$("input.curr[type=checkbox]:checked").map(function(){
    searchIDs.push($(this).val());
  });



var parametros = "funcion="+funcion+"&unidad="+unidad+"&ano="+ano+"&codramo="+codramo+"&cursos="+searchIDs;
$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	   if(data==0){
			alert("ERROR AL GUARDAR");
		}else
		{
			alert("DATOS GUARDADOS");
			traeUnidades();
			//cancela();
		}
		
		  }
	  })
}

function rfecha(){
var ip  = $("#tipoFecha").val();
if(ip==1){
$("#ifecha").html("Mes");
$("#tfecha").html("");
$("#txt_fechater").prop("type", "hidden");
$("#txt_fechaini").prop("type", "hidden");
$("#txt_fechater").datepicker("destroy");
$("#txt_fechaini").datepicker("destroy");


$("#comes").css("display", "block");


}
else if(ip==2){
$("#ifecha").html("Fecha Inicio");
$("#tfecha").html("Fecha T&eacute;rmino");
$("#txt_fechaini").prop("type", "text");
$("#txt_fechater").prop("type", "text");
$("#comes").css("display", "none");
$("#txt_fechater").val("");
$("#txt_fechaini").val("");
$('#cmbMes option').eq(0).prop('selected',true);

$("#txt_fechaini, #txt_fechater").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});
}

}

function rfechaed(){
var ip  = $("#tipoFecha").val();
if(ip==1){
$("#ifecha").html("Mes");
$("#tfecha").html("");
$("#txt_fechater").prop("type", "hidden");
$("#txt_fechaini").prop("type", "hidden");
$("#txt_fechater").datepicker("destroy");
$("#txt_fechaini").datepicker("destroy");


$("#comes").css("display", "block");


}
else if(ip==2){
$("#ifecha").html("Fecha Inicio");
$("#tfecha").html("Fecha T&eacute;rmino");
$("#txt_fechaini").prop("type", "text");
$("#txt_fechater").prop("type", "text");
$("#comes").css("display", "none");
$('#cmbMes option').eq(0).prop('selected',true);

$("#txt_fechaini, #txt_fechater").datepicker({
			showOn: 'both',
			changeYear:true,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			/*minDate: new Date('01/01/'+anio+''),
			maxDate: new Date('12/31/'+anio+''),*/
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		  firstDay: 1,
			//buttonImage: 'img/Calendario.PNG',
		});
}

}

function fechames(mes){
var fini="";
var fter="";
var aa = $("#an").val();

	switch (mes){
	case "01":
	fini="01/"+mes+"/"+aa;
	fter="31/"+mes+"/"+aa;
	break;
	
	case "02":
	var dd = ((aa%4)==0)?29:28; // veo si es año bisiesto
	fini="01/"+mes+"/"+aa;
	fter= dd+"/"+mes+"/"+aa;
	break;
	
	case "03":
	fini="01/"+mes+"/"+aa;
	fter="31/"+mes+"/"+aa;
	break;
	
	case "04":
	fini="01/"+mes+"/"+aa;
	fter="30/"+mes+"/"+aa;
	break;
	
	case "05":
	fini="01/"+mes+"/"+aa;
	fter="31/"+mes+"/"+aa;
	break;
	
	case "06":
	fini="01/"+mes+"/"+aa;
	fter="30/"+mes+"/"+aa;
	break;
	
	case "07":
	fini="01/"+mes+"/"+aa;
	fter="31/"+mes+"/"+aa;
	break;
	
	case "08":
	fini="01/"+mes+"/"+aa;
	fter="31/"+mes+"/"+aa;
	break;
	
	case "09":
	fini="01/"+mes+"/"+aa;
	fter="30/"+mes+"/"+aa;
	break;
	
	case "10":
	fini="01/"+mes+"/"+aa;
	fter="31/"+mes+"/"+aa;
	break;
	
	case "11":
	fini="01/"+mes+"/"+aa;
	fter="30/"+mes+"/"+aa;
	break;
	
	case "12":
	fini="01/"+mes+"/"+aa;
	fter="31/"+mes+"/"+aa;
	break;
	
	}

$("#txt_fechaini").val(fini);
$("#txt_fechater").val(fter);
}


function generaStd(){
var funcion=18;
var rdb = <?php echo $_INSTIT ?>;
var ano = <?php echo $_ANO ?>;
//var id_ramo = $("#sel_ramo").val();
var curso = $("#sel_curso").val();
var cod_ramo = $("#sel_ramo").val();
var dicta = $("#docdicta").val();
var tipo =  2;
var crm = $("#sel_curso").val().split("_");
var grd = crm[0];
var ens = crm[1];
var parametros = "funcion="+funcion+"&rdb="+rdb+"&ano="+ano+/*"&id_ramo="+id_ramo+*/"&curso="+curso+"&tipo="+tipo+"&cod_ramo="+cod_ramo+"&dicta="+dicta+"&grd="+grd+"&ens="+ens;
//alert(parametros);

$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 console.log(data);
		  if(data==0){
			alert("ERROR AL GUARDAR");
			}
			else if(data==2){
			alert("YA EXISTE PLANIFICACION ANUAL PARA ESTA ASIGNATURA");
			}
			else{
				
			alert("DATOS GUARDADOS");
			traeUnidades();
			cancela();
			}
	
		
		  }
	  })
}


function traeEnse(curso){
var funcion=19;
var parametros = "funcion="+funcion+"&curso="+curso; 
$.ajax({
	  url:'cont_unidad.php',
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
function cambiaEstado(unidad){
	var funcion=20;
	var parametros = "funcion="+funcion+"&unidad="+unidad;
	
	$.ajax({
		url:"cont_unidad.php",
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
	 var funcion=21;
	 var estado=$('#opc_estado').val();
	 var descripcion=$('#txt_obser').val();
	 var unidad=$('#unidad').val();
	var parametros = "funcion="+funcion+"&unidad="+unidad+"&estado="+estado+"&descripcion="+descripcion;
	//alert(parametros);
	
	$.ajax({
		url:"cont_unidad.php",
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

function claserl(unidad,estado){

var rll=(estado==1)?"REALIZADA":"NO REALIZADA";
var funcion=22;

var parametros = "funcion="+funcion+"&unidad="+unidad+"&estado="+estado;

if(confirm("\xBFMarcar Clase como "+ rll+"?"))
{
$.ajax({
		url:"cont_unidad.php",
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
<?php if($_PERFIL==0){  ?>
function borraAnual(id){
var funcion=23;
var parametros = "funcion="+funcion+"&id_unidad="+id;

if(confirm("Seguro de borrar la planificacion anual?")){
	
	$.ajax({
		url:"cont_unidad.php",
		data:parametros,
		type:'POST',
		success:function(data){
			
			alert("DATOS ELIMINADOS");
			traeUnidades();
			}
		})
	
}


}

<? }?>

function indica(obj){
//alert(obj);
var funcion=24;
var ttp = $('input:radio[name=tipo]:checked').val()
var parametros="funcion="+funcion+"&obj="+obj;	
$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// console.log(data);
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




</script>



</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0">

<table width="1280" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top" background="../../cortes/<?=$_INSTIT;?>/fondo_01_reca.jpg" width="53"  height="900"></td>
    <td align="left" valign="top">
	   <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="600" align="center" valign="top" bgcolor="f7f7f7"><? include("../../cabecera_new/head.php");?></td>
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

                      <form id="frm">
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
                          <tr style="display:none">
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
                                <input type="button" name="nuevaUnidad" id="nuevaUnidad" class="botonXX" value="Nueva Planificaci&oacute;n" onclick="carga()" />                                  <input type="button" name="busca" id="busca" class="botonXX" value="Buscar" onclick="traeUnidades()" border="0" /></div></td>
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
    <td align="left" valign="top" background="../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53"></td>

  </tr>
</table>

</td>

    <!--<td width="53" align="center" valign="top" height="100%" >ACA IMAGEN DERECHA</td>-->
  </tr>
</table> 
<div id="replica" align="center"></div>
<div id="est" title="Estado Unidad" align="center"> </div>
 <div id="ind" title="Seleccionar indicadores de Evaluaci&oacute;n"></div>

</body>

</html>
