<?php 
require("../../util/header.php");
session_start();
$_POSP=3; 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<link href="../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link href="../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<style>
</style>
<script>

$( document ).ready(function() {
  filtro();
 
   
});

function filtro(){
var parametros="funcion=1";

 $.ajax({
	  url:'cont_reserva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#tabla").html(data);
		  }
	  })	
}

function tipo(t){
if(t==1){
	$('.tp2').show();
	$('.tp1').hide();
	traeEmp();
}
else if(t==2 || t==3){
	$('.tp1').show();
	  $('.tp2').show();
	    traeCur(t);
	
	}
else{
$('.tp1').hide();
 $('.tp2').hide();

}
}

function limpia(){

	$("#idLBR").val('');
	
}



function traeEmp(){
	$("#nom").html("");
	$("#cur").html("");
	var funcion =2;
	var rdb = <?php echo $_INSTIT; ?>;
	var parametros = "funcion="+funcion+"&rdb="+rdb;
	$.ajax({
	  url:'cont_reserva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#nom").html(data);
				
		  }
	  })
}
function traeCur(){
	$("#nom").html("");
	$("#cur").html("");
	var funcion =3;
	var ano = <?php echo $_ANO; ?>;
	var tipo = $("#cmbTipo").val();
	var parametros = "funcion="+funcion+"&ano="+ano+"&tipo="+tipo;
	$.ajax({
	  url:'cont_reserva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#cur").html(data);
		  }
	  })
	
}
function traeNombre(){
	$("#nom").html("");
	
	var funcion =4;
	var tipo = $("#cmbTipo").val();
	var curso =$("#cmbCurso").val();
	var rdb = <?php echo $_INSTIT; ?>;
	var parametros = "funcion="+funcion+"&curso="+curso+"&tipo="+tipo;
	$.ajax({
	  url:'cont_reserva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#nom").html(data);
		  }
	  })
}


function rsv(){
	$("#lista").html('');
	$("#rr").html('');
	
	
	var funcion =5;
	var rut = $("#cmbRUT").val();
	var parametros = "funcion="+funcion+"&rut="+rut;
	$.ajax({
	  url:'cont_reserva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#lista").html(data);
		  }
	  })
	
}


function creares(){
	var funcion =7;
	
	var parametros = "funcion="+funcion;
	$.ajax({
	  url:'cont_reserva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#rr").html(data);
		$("#nr").hide();
		  }
	  })
}

function dsp(){
	var funcion =8;
	var lbr = $("#idLBR").val();
	var rut = $("#cmbRUT").val();
	$("#ffe").hide();
	
	var parametros = "funcion="+funcion+"&lbr="+lbr+"&rut="+rut;
	$.ajax({
	  url:'cont_reserva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		if(data==0){
			$("#ffe").show();
			}
		else if(data==2){
		 alert("RESERVA DUPLICADA PARA ESE TITULO");
		$("#buttonr").hide();
		
		}
		else {
		 alert("TITULO SE ENCUENTRA SIN EJEMPLARES DISPONIBLES HASTA "+ data.trim());
		 
		}
		  }
	  })
}

function reserva(){
var funcion=9;
var lbr = $("#idLBR").val();
var rut = $("#cmbRUT").val();
var fecha_reserva = $("#txtFECHARES").val();
var tip = $("#cmbTipo").val();
var parametros = "funcion="+funcion+"&lbr="+lbr+"&rut="+rut+"&fecha_reserva="+fecha_reserva+"&tip="+tip;

if(lbr==""){
	alert("DEBE SELECCIONAR LIBRO");
	$('#combobox').focus();
	return false;
}
else if(fecha_reserva==""){
	alert("DEBE SELECCIONAR FECHA");
	$('#txtFECHARES').focus();
	return false;
}
else{
	$.ajax({
	  url:'cont_reserva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		
		alert("RESERVA REALIZADA")
		rsv();
		$("#rr").html("");
		  }
	  })
}
}

function anular(idr){
var funcion=10;
var parametros = "funcion="+funcion+"&idr="+idr;
if(confirm("¿SEGURO DE ANULAR RESERVA?")){
	$.ajax({
	  url:'cont_reserva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		console.log(data);
		alert("RESERVA ANULADA")
		rsv();
		$("#nr").show();
		
		  }
	  })
}
}

function prestar(idr){
var funcion=11;
var parametros = "funcion="+funcion+"&idr="+idr;

if(confirm("¿SEGURO DE EFECTUAR RESERVA?")){
	$.ajax({
	  url:'cont_reserva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		//console.log(data);
		if(data==0){
			
			dfecha(idr);
		
		}
		else if(data==2){
		 alert("USUARIO POSEE EL MÁXIMO PERMITIDO DE EJEMPLARES EN SU PODER. DEBE DEVOLVER AL MENOS 1");
		 $(".bp").hide();
		 $("#buttonr").hide();
		}
		else {
		 alert("TITULO SE ENCUENTRA SIN EJEMPLARES DISPONIBLES HASTA "+ data.trim());
		 $("#bpre_"+idr).hide();
		}
		
		  }
	  })
}
}

function dfecha(idr){
	var funcion=12;
var parametros = "funcion="+funcion+"&idr="+idr;

	$.ajax({
	  url:'cont_reserva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		$('#dialog').prop('title', 'Fecha Devolución préstamo');
			$("#dialog").html(data);
			$("#dialog").dialog({ 
			   closeOnEscape: false,
			   modal:true,
			   resizable: true,
			   Width: 400,
			   Height: 200,
			   minWidth: 400,
			   minHeight: 200,
			   maxWidth: 400,
			   maxHeight: 200,
			   show: "fold",
			   hide: "scale",
			   stack: true,
			   sticky: true,
			  // position:"fixed",
			  // position: "absolute",
				buttons: {
				 
				  "Generar Préstamo": function(){
					  guardap();
					//$(this).dialog("close");
				  },
				  "Cerrar": function(){
					$(this).dialog("close");
				  }
				}   
			  }) 
		
		  }
	  })

}

function guardap(){
var funcion=13;
var fecha = $('#txtFECHADEV2').val();
var libro = $('#id_libr').val();
var ejemplar = $('#id_ejmp').val();
var rut = $('#rut_us').val();
var tipo = $('#ti_us').val();
var res = $('#id_rss').val();
var parametros = "funcion="+funcion+"&libro="+libro+"&ejemplar="+ejemplar+"&fecha="+fecha+"&rut="+rut+"&tipo="+tipo+"&res="+res;
	
	if(fecha==""){
		alert("DEBE SELECCIONAR FECHA DEVOLUCION LIBRO");
		$('#txtFECHADEV2').focus();
		
	}else{
		$.ajax({
	  url:'cont_reserva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		console.log(data);
		alert("PRESTAMO REALIZADO");
		$("#dialog").dialog("close");
		rsv();
		
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
    <td colspan="2" align="center" valign="top" height="70"><? include("../../cabecera_new/head.php");?></td>
    <td rowspan="3" background="../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td valign="top" align="left"><? include("../../menu_new/menu_biblio.php");?></td>
    <td valign="top" align="center"><br />
    <table width="95%" border="0" cellpadding="0" cellspacing="0" class="cajaborde" >
    <tr>
    	<td width="5%" colspan="4"><br /><div id="tabla">&nbsp;</div></td>
    </tr>
    </table>
	
</td>
  </tr>
  <tr>
    <td colspan="2" valign="bottom" align="center"><? include("../../cabecera_new/footer.html");?></td>
  </tr>
</table>
<div id="dialog"></div>

</body>

</html>
