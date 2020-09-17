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
	  url:'cont_devolucion.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#tabla").html(data);
		 $("#fil0, #fil1").hide();
		  }
	  })	
}

function muestraFiltro(tipo){
if(tipo==0){
	$("#fil0").show();
	$("#fil1").hide();
	$("#txt").val("");
}
else if(tipo==1){
	$("#fil0").hide();
	$("#fil1").show();
	$("#txtCodigo").val("");
}

}

function limpia(){

	$("#idLBR").val('');
	
}

function veolb(tipo,cad){
	
 var funcion=2;	
 var parametros = "funcion="+funcion+"&tipo="+tipo+"&cade="+cad;
 $.ajax({
	  url:'cont_devolucion.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		$("#lista").html(data);
		 
		  }
	  })
}


function devuelve(pres,ejm){
 var funcion=3;	
 var tipo = $("#ttt").val();
 var cad = $("#ccc").val();
 var datraso = parseInt($("#datraso_"+pres).val());
 var estadop = $("#estadop_"+pres).val();
 var usp = $("#prestado_"+pres).val();
 var parametros = "funcion="+funcion+"&pres="+pres+"&ejm="+ejm+"&datraso="+datraso+"&estadop="+estadop+"&usp="+usp;
// alert(parametros);
 $.ajax({
	  url:'cont_devolucion.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//console.log(data);
		 if(data==1){
			
		alert("EJEMPLAR DEVUELTO");
		veolb(tipo,cad);
	  }else{
		  alert("ERROR AL GUARDAR");
		  }
		  }
	  })
}

function multa(pres,lib){
var parametros="funcion=4&pres="+pres+"&lib="+lib;
	
	$.ajax({
		url:"cont_devolucion.php",
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
	  url:'cont_devolucion.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  console.log(data);
		 if(data==1){
			
		alert("MULTA PAGADA, SE PUEDE DEVOLVER EL LIBRO");
		veolb(tipo,cad);
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

<div id="mul" title="DATOS PAGO MULTA"></div>
</body>

</html>
