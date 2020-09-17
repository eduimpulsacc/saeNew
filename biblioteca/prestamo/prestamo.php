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

$( document ).ready(function() {
  filtro();
   
});

function filtro(){
var parametros="funcion=1";

 $.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#tabla").html(data);
		  }
	  })	
}

function tipo(t){
	$('#txt_rut').val('');
if(t==1){
	$('.tp2').show();
	$('.tp1').hide();
	traeEmp();
}
else if(t==2 || t==3){
	$('.tp1').show();
	  $('.tp2').show();
	    traeCur(t);
	//  traeNombre(t);
	}
else{
$('.tp1').hide();
 $('.tp2').hide();

}
}


function traeEmp(){
	$("#nom").html("");
	$("#cur").html("");
	var funcion =2;
	var rdb = <?php echo $_INSTIT; ?>;
	var parametros = "funcion="+funcion+"&rdb="+rdb;
	$.ajax({
	  url:'cont_prestamo.php',
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
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#cur").html(data);
		  }
	  })
	
}
function traeNombre(){
	$("#nom").html("");
	//$("#cur").html("");
	var funcion =4;
	var tipo = $("#cmbTipo").val();
	var curso =$("#cmbCurso").val();
	var rdb = <?php echo $_INSTIT; ?>;
	var parametros = "funcion="+funcion+"&curso="+curso+"&tipo="+tipo;
	$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#nom").html(data);
		  }
	  })
}

function veodisp(lbr){
var funcion =5;
var parametros = "funcion="+funcion+"&id_libro="+lbr;
$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#lisbr").html(data);
		  }
	  })
}

function prestar(ejm){
var funcion =6;
var rut = $("#cmbRUT").val();
var tipou = $("#cmbTipo").val();
var id_libro = $("#idLBR").val();
var fechadev = $("#txtFECHADEV").val();
var parametros = "funcion="+funcion+"&id_libro="+id_libro+"&id_ejemplar="+ejm+"&fechadev="+fechadev+"&rut="+rut+"&tipou="+tipou;

if(rut==0){
alert("DEBE SELECCIONAR USUARIO");
}
else if(id_libro==""){
alert("DEBE SELECCIONAR LIBRO");
}
else if(fechadev==""){
alert("DEBE SELECCIONAR FECHA DE DEVOLUCION");
}
else
{
$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==1)
		alert("PRESTAMO RELIZADO ");
		veors();acpres()
		 //$('#bss').show();
		$("#lista").html('');
		//console.log(data);
		//comprobante();
		  }
	  })
	  
}
	 
}

function limpia(){

	$("#idLBR").val('');
	
}

function veors(){
	$("#lista").html('');
var funcion =7;
var usuario = $("#cmbRUT").val();
var parametros = "funcion="+funcion+"&rut_usuario="+usuario;
$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		   if(data==2){
		 alert("USUARIO POSEE UN EJEMPLAR DE ESTE LIBRO");
		 $("#bpre_"+idr).hide();
	 	 //$(".bp").hide();
		 /*	$("#buttonr").hide();*/
		}
		  
		else{
		 
		$("#res").html(data);
		}
		  }
	  })
}

function anular(idr){
var funcion=8;
var parametros = "funcion="+funcion+"&idr="+idr;
if(confirm("¿SEGURO DE ANULAR RESERVA?")){
	$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		alert("RESERVA ANULADA")
		veors();
		
		
		  }
	  })
}
}

function prestarl(idr){
var funcion=9;
var usuario = $("#cmbRUT").val();
var parametros = "funcion="+funcion+"&idr="+idr+"&usuario="+usuario;

if(confirm("¿SEGURO DE EFECTUAR PRESTAMO?")){
	$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		console.log(data);
		if(data==0){
			
			//dfecha(idr);
			preserva(idr);
		
		}
		else if(data==2){
		 alert("USUARIO POSEE EL MÁXIMO PERMITIDO DE EJEMPLARES EN SU PODER. DEBE DEVOLVER AL MENOS 1");
		 $(".bp").hide();
		 $("#buttonr").hide();
		 $("#bpre_"+idr).hide();
		}
		else if(data==3){
		 alert("USUARIO POSEE UN EJEMPLAR DE ESTE LIBRO");
		 $("#bpre_"+idr).hide();
	 	 //$(".bp").hide();
		 /*	$("#buttonr").hide();*/
		}
		else {
		 alert("TITULO SE ENCUENTRA SIN EJEMPLARES DISPONIBLES HASTA "+ data.trim());
		 $("#bpre_"+idr).hide();
		}
		
		  }
	  })
}
}

function acpres(){
 $('#bss').hide();
var funcion=10;
var usuario = $("#cmbRUT").val();
var parametros = "funcion="+funcion+"&usuario="+usuario;
$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  console.log(data);
		if(data==0){
			 alert("USUARIO POSEE EL MÁXIMO PERMITIDO DE EJEMPLARES EN SU PODER. DEBE DEVOLVER AL MENOS 1");
		}
		else if(data==2){
			 // alert("USUARIO BLOQUEADO POR POSEER MULTAS IMPAGAS");
			  alert("USUARIO POSEE MULTAS IMPAGAS");
			  // $('#bss').hide();
			  // $('.bp').hide();
			   
		}
		else if(data==1){
			  $('#bss').show();
		}
		
		  }
	  })
}

function actp(){
 $('#bss').hide();	
 
 
var funcion=11;
var parametros = "funcion="+funcion;

	$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		$("#lista").html(data);
		
		  }
	  })


 
}
 function cambio(idp,tipo){
 var funcion=12;
var parametros = "funcion="+funcion+"&idp="+idp+"&tipo="+tipo;

var txt=(tipo==1)?"RENOVAR":"DEVOLVER";
var txt2=(tipo==1)?"PRESTAMO RENOVADO":"EJEMPLAR DEVUELTO";
if(confirm("¿SEGURO DE "+txt+" PRESTAMO?")){

	$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		console.log(data);
		$('#txt_rut').val('');
		if(tipo==1){
			$('#dgg').prop('title', 'Fecha Devolución préstamo');
			$("#dgg").html(data);
			$("#dgg").dialog({ 
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
				 
				  "Renovar Préstamo": function(){
					  renueva(idp);
					//$(this).dialog("close");
				  },
				  "Cerrar": function(){
					$(this).dialog("close");
				  }
				}   
			  })
			
			}
		else if(tipo==2){
		alert(txt2);
		veors();
		acpres();
		}
		  }
	  })
	}
}

function  renueva(){
var funcion =13;
var idp = $("#idp").val();
var fecha = $("#txtFECHADEV2").val();
var parametros = "funcion="+funcion+"&idp="+idp+"&fecha="+fecha;
 if(fecha==""){
alert("DEBE SELECCIONAR FECHA DE DEVOLUCION");
}else{
	$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
		 alert("PRESTAMO RENOVADO");
		$("#dgg").dialog("close");
		
		  }
	  })
}

}

function preserva(res){
var funcion =14;
var usuario = $("#cmbRUT").val();
var parametros = "funcion="+funcion+"&res="+res+"&usuario="+usuario;
$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
		console.log(data);
		
		$('#dgg').prop('title', 'Fecha Devolución préstamo');
			$("#dgg").html(data);
			$("#dgg").dialog({ 
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
var funcion=15;
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
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		console.log(data);
		alert("PRESTAMO REALIZADO");
		$("#dgg").dialog("close");
		veors();
		acpres();
		
		  }
	  })
	}
}

function multa(pres,lib){
var parametros="funcion=4&pres="+pres+"&lib="+lib;
	
	$.ajax({
		url:"../devolucion/cont_devolucion.php",
		data:parametros,
		type:'POST',
		success: function(data){
			
			$("#mul").html(data);
			
			$("#mul").dialog({ 
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
				 "Pagar Multa": function(){
					 if($('#rebaja').val()=="" || $('#rebaja').val()==0){
						alert("DEBE INDICAR VALOR REBAJA");
						$('#rebaja').focus();
						return false;
					}
					else if($('#rebaja').val()>$('#mon').val()){
						alert("VALOR INGRESADO ES MAYOR AL MONTO DE LA MULTA");
						$('#rebaja').focus();
						return false;
					}
						PagaMulta();
					  
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
function  muestrarebaja(){
	 $('#rebaja').attr('type', 'text');
}

function PagaMulta(){
	var funcion=5
	var pres = $("#prestamo").val();
	var ejm = $("#ejemplar").val();
	var rba = $("#rebaja").val();
	var rutu = $("#rutu").val();
	var datr = $("#datraso").val();
	var mon = $("#mon").val();
	var tipo = $("#ttt").val();
	var cad = $("#ccc").val();
	
	var parametros ="funcion="+funcion+"&pres="+pres+"&ejm="+ejm+"&rba="+rba+"&rutu="+rutu+"&datr="+datr+"&mon="+mon;
	
	$.ajax({
	  url:'../devolucion/cont_devolucion.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  console.log(data);
		 if(data==1){
			
		alert("MULTA PAGADA, SE PUEDE DEVOLVER EL LIBRO");
		veors();acpres();
	  }else{
		  alert("ERROR AL GUARDAR");
		  }
		  }
	  })
	
}
function cambiovalo(){
	//alert("cambio");
	var mon = $("#mon").val();
	var rba = $("#rebaja").val();
	if(mon != rba){
	var vali = parseInt(mon)-parseInt(rba);	
	$("#valpago").html(vali); 
	
	}
	
}

//hacer reserva del libro via codigo de barras
function disporcod(){
	var cod = $("#txt_cb").val();
	$("#txt").val("");
	$("#idLBR").val("");
	var funcion = 16;
	var parametros = "cod="+cod+"&funcion="+funcion;
	var cad = "";
	
	 if ( $("#txt_cb").val().length>0)
	{
		$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		console.log(data);
		cad = data.split("^");
		
		
		$("#txt").val(cad[1]);
		$("#idLBR").val(cad[0].trim());
		veodispE(cad[0].trim(),$("#txt_cb").val());
		$("#txt").focus();
		$("#txt").blur();
		/*alert("PRESTAMO REALIZADO");
		$("#dgg").dialog("close");
		veors();
		acpres();*/
		
		  }
	  })
	}
	
}
function veodispE(lbr,eje){
var funcion =17;
var parametros = "funcion="+funcion+"&id_libro="+lbr+"&id_ejemplar="+eje;
$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#lisbr").html(data);
		  }
	  })
}
function existe(){
var funcion=18;
var tipo = $("#cmbTipo").val();
var rut = $("#txt_rut").val();
var parametros = "funcion="+funcion+"&tipo="+tipo+"&rut="+rut;
if(rut!=""){
$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		if(data==1){
			veors();acpres();
			}else{
				alert("Rut no encontrado");
				}
		  }
	  })
}else{
	$("#lista").html('');
	}
}
function limpia(){
	//if($("#combobox").val()==""){
		$("#idLBR").val('');

}

function limpia2(){
	//if($("#combobox").val()==""){
		$("#idAUT").val('');

}

function limpia3(){
	//if($("#combobox").val()==""){
		$("#idMAT").val('');

}
function buscaDis(){
	
var funcion=19;
var aut = $("#idAUT").val();
var mat = $("#idMAT").val();
var lbr = $("#idLBR").val();
var parametros = "funcion="+funcion+"&aut="+aut+"&mat="+mat+"&lbr="+lbr;
$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//$("#lis").html(data);
		$("#lisbr").html(data);
		
		  }
	  })	
}

function prestar2(ejm,libro){
var funcion =6;
var rut = $("#txt_rut").val();
var tipou = $("#cmbTipo").val();
var id_libro = libro;
var fechadev = $("#txtFECHADEV").val();
var parametros = "funcion="+funcion+"&id_libro="+id_libro+"&id_ejemplar="+ejm+"&fechadev="+fechadev+"&rut="+rut+"&tipou="+tipou;

if(rut==0){
alert("DEBE SELECCIONAR USUARIO");
}
else if(id_libro==""){
alert("DEBE SELECCIONAR LIBRO");
}
else if(fechadev==""){
alert("DEBE SELECCIONAR FECHA DE DEVOLUCION");
}
else
{
$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==1)
		alert("PRESTAMO RELIZADO ");
		veors();acpres()
		 //$('#bss').show();
		$("#lista").html('');
		//console.log(data);
		//comprobante();
		  }
	  })
	  
}
	 
}

function siBloqueo(tipo){
	var funcion =20;
	var rut = (tipo==1)?$("#cmbRUT").val():$("#txt_rut").val();
	if(rut!=""){
	var parametros = "funcion="+funcion+"&rut="+rut;
	$.ajax({
	  url:'cont_prestamo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		console.log(data);
		if(data!=1){
			alert(data);
			}
		  }
	  })
	}
}
function cam(){
	var rut = $("#cmbRUT").val();
	$("#txt_rut").val(rut);
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
    <td valign="top" align="left"><br />
    <table width="900" border="0" cellpadding="0" cellspacing="0" class="cajaborde" >
    <tr>
    	<td colspan="4"><br /><div id="tabla">&nbsp;</div></td>
    </tr>
    </table>
	
</td>
  </tr>
  <tr>
    <td colspan="2" valign="bottom" align="center"><? include("../../cabecera_new/footer.html");?></td>
  </tr>
</table>

<div id="prt"></div>
<div id="dgg"></div>
<div id="mul" title="DATOS PAGO MULTA"></div>
</body>

</html>
