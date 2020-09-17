<?php session_start();
//var_dump($_SESSION);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<style>
.check{
	background-color:#0F3;

}
.nocheck{
	background-color:blue;

}
</style>

<link href="../../cortes/8933/estilos.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.9.2.custom/development-bundle/jquery-1.8.3.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.9.2.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../../admin/clases/jquery-ui-1.9.2.custom/development-bundle/demos/demos.css"/>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.9.2.custom/development-bundle/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.9.2.custom/development-bundle/ui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../../admin/clases/tinymce/tinymce.min.js"></script>
<script>

$(document).ready(function(){
	traeCurso(<?php echo $_ANO ?>);
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
		
		
		

  });
  
  function traeCurso(ano){
	var funcion =1;
	var parametros="funcion="+funcion+"&ano="+ano;
	 // $("#prof").html('<input type="text" name="docdicta" id="docdicta" value="0" />');
	  
	
	$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#cur").html(data);

		  }
	  })		
	
}

function traeRamo(curso){
	document.getElementById("prof").innerHTML = '<input type="text" name="docdicta" id="docdicta" value="0" />';
	var funcion =2;
	var parametros="funcion="+funcion+"&curso="+curso;
	 
	$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#ram").html(data);
		
		  }
	  })	
	
}

function dicta(ramo){
	
	var funcion =3;
	var parametros="funcion="+funcion+"&ramo="+ramo;
	
	$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#prof").html(data);
		
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

var parametros = "funcion="+funcion+"&curso="+curso+"&ramo="+ramo+"&docente="+docente+"&rdb="+rdb+"&id_ano="+id_ano;
$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#tabla").html(data);
		
		  }
	  })	
}

function creaUnidad(){
var funcion =5;
var curso= $("#sel_curso").val();
var ramo= $("#sel_ramo").val();
var docente = $("#docdicta").val();
var rdb = <?php echo $_INSTIT ?>;
var cod_ramo = $("#cod_ramo").val();

 $("#cargaobj").val()
 $("#cargahab").val()



 $("#nvo").html('<input type="button" name="nuevaUnidad" id="nuevaUnidad" value="Guardar" onclick="GuardaUnidad()" /> <input type="button" name="nuevaUnidad" id="nuevaUnidad" value="Cancelar" onclick="cancela()" />');
   

var parametros = "funcion="+funcion+"&curso="+curso+"&ramo="+ramo+"&docente="+docente+"&rdb="+rdb+"&cod_ramo="+cod_ramo;
$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#tabla").html(data);
		cargatipo(0);
		
		  }
	  })	
}

function cancela(){
 $("#nvo").html('<input type="button" name="nuevaUnidad" id="nuevaUnidad" value="Nueva Unidad" onclick="creaUnidad()" />');
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
		 // console.log(data);
		// alert(data);
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
		 // console.log(data);
		// alert(data);
		
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
		 // console.log(data);
		// alert(data);
		
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
        alert("Fecha inicio debe ser mayor a fecha término");
       
    }
	else if($("#txt_nombre").val()==""){
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
	}
	else if(total_checko==0){
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

else{
$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  console.log(data);
		// alert(data);
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
		
	// $("#tabla").html(data);
		
		  }
	  })

}
}

function veUnidad(idUnidad){
var funcion =10;
var parametros = "&funcion="+funcion+"&idUnidad="+idUnidad;

//alert(parametros);

$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  console.log(data);
		 //alert(data);
		
	   $("#tabla").html(data);
		
		  }
	  })

}


function editaUnidad(idUnidad){
var funcion =11;
var cod_ramo= $('#rm'+idUnidad+'').val();
var rdb = <?php echo $_INSTIT ?>;
var parametros = "&funcion="+funcion+"&idUnidad="+idUnidad+"&cod_ramo="+cod_ramo+"&rdb="+rdb;
$("#nvo").html('<input type="button" name="actUnidad" id="actaUnidad" value="Actualizar Datos" onclick="GuardaUnidadAct()" /> <input type="button" name="cUnidad" id="cUnidad" value="Cancelar" onclick="cancela()" />');
//alert(parametros);

$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
		
	   $("#tabla").html(data);
	   
	   //codigo($("#rm").val());
		
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
var total_checko = $("input.oo[type=checkbox]:checked").length;
var total_checkh = $("input.hh[type=checkbox]:checked").length;


 var startDate = $.datepicker.parseDate('dd/mm/yy', $("#txt_fechaini").val());
 var endDate = $.datepicker.parseDate('dd/mm/yy', $("#txt_fechater").val());

    var difference = (endDate - startDate) / (86400000);
    //alert(difference)
    if (difference < 0) {
        alert("Fecha inicio debe ser mayor a fecha término");
       
    }
	else if($("#txt_nombre").val()==""){
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
	
	else if(total_checko==0){
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

else{

$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
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

function cargatipo(tipo){
//alert(tipo);
var funcion =13;	
var rdb = <?php echo $_INSTIT ?>;
var cod_ramo = $("#cod_ramo").val();

var parametros="funcion="+funcion+"&rdb="+rdb+"&cod_ramo="+cod_ramo+"&tipo="+tipo;

//$("#x").html(tipo);
$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
		
		if(tipo==0){
		$("#mx").css('display','block');
		$("#my").css('display','none');	
	   $("#mx").html(data);
	   dejamarcaobj();
		}
		if(tipo==1){
		$("#mx").css('display','none');
		$("#my").css('display','block');	
	   $("#my").html(data);
	   dejamarcahab();
		}
	   //codigo($("#rm").val());
		
		  }
	  })
}

function cargatipoedi(tipo,id_unidad){
//alert(tipo);
var funcion =14;	
var rdb = <?php echo $_INSTIT ?>;
var cod_ramo = $("#rm").val();

var parametros="funcion="+funcion+"&rdb="+rdb+"&cod_ramo="+cod_ramo+"&tipo="+tipo+"&id_unidad="+id_unidad;

//$("#x").html(tipo);
$.ajax({
	  url:'cont_unidad.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
		
		if(tipo==0){
		$("#mx").css('display','block');
		$("#my").css('display','none');	
	   $("#mx").html(data);
	   // $("input.oo[type=checkbox]").prop('checked',false);
	  dejamarcaobj();
		}
		if(tipo==1){
		$("#mx").css('display','none');
		$("#my").css('display','block');	
	   $("#my").html(data);
	  
	   dejamarcahab();
		}
	   //codigo($("#rm").val());
		
		  }
	  })
}
  
function pp(codigo){
//alert(codigo);

 if($("#destino"+codigo+"").is(':checked')) {
  $("#destino"+codigo+"").prop('checked',false);
  $("#fila"+codigo+"").removeClass( "check" );

}

else {
  $("#destino"+codigo+"").prop('checked',true);
  $("#fila"+codigo+"").addClass( "check" );
}


}

function pp2(codigo){
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

var dato;
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
}

function creaclases(unidad){
//var parametros = "unidad="+unidad;	

location.href='../clase/clase.php?cls='+unidad;

}
</script>



</head>

<body>
<form id="frm">
<input type="hidden" name="rr" id="rr" value="" />
<table width="650" border="1" align="center">
  <tr>
    <td width="195">CURSO</td>
    <td width="439"><div id="cur">
    <select name="sel_curso" id="sel_curso">
    <option value="0">Seleccione...</option>
    </select></div></td>
  </tr>
  <tr>
    <td>ASIGNATURA</td>
    <td><div id="ram">
      <select name="sel_ramo" id="sel_ramo">
      <option value="0">Seleccione...</option>
      </select>
    </div></td>
  </tr>
  <tr>
    <td>PROFESOR</td>
    <td>
    <div id="prof">
          <input type="hidden" name="docdicta" id="docdicta" value="0" />
    </div>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    <input type="text" name="cod_ramo" id="cod_ramo" /></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><input type="button" name="busca" id="busca" value="Buscar" onclick="traeUnidades()" /></td>
  </tr>
  <tr>
    <td colspan="2" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="right">
    <div id="nvo">
    <input type="button" name="nuevaUnidad" id="nuevaUnidad" value="Nueva Unidad" onclick="creaUnidad()" />
    </div></td>
  </tr>
</table>
<br />
<br />
<div id="tabla"></div>
</form>
</body>

</html>
