<?php 
require("../../util/header.php");
session_start();
$_POSP=0; 
$_INSTIT=10774;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<link rel="shortcut icon" href="../../images/icono_sae_33.png">
<link href="../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link href="../../cortes/10774/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script><script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script>
$(document).ready(function(){
	listado();
	CantidadSolicitudes();
});

function listado(){
	var rdb				= $("#txtRDB2").val();
	var solicitante 	= $("#cmbSOLICITANTE2").val();
	var colegio			= $("#cmbCOLEGIO").val();
	var tipo			= $("#cmbTIPO2").val();
	
	var parametros="funcion=1&rdb="+rdb+"&solicitante="+solicitante+"&colegio="+colegio+"&tipo="+tipo;

	$.ajax({
		url:"constructor.php",
		data:parametros,
		type:'POST',
		success: function(data){
			$("#tabla").html(data);
		}
	})
}

function Agregar(){
	var parametros="funcion=2";
	$.ajax({
		url:"constructor.php",
		data:parametros,
		type:'POST',
		success: function(data){
			$("#tabla").html(data);
		}
	})	
}

function BuscaColegio(){
	var rdb = $("#txtRDB").val();
	var parametros ="funcion=3&rdb="+rdb;
	$.ajax({
		url:"constructor.php",
		data:parametros,
		type:'POST',
		success: function(data){
			var datos = data.split(",");
			$("#txtRDB").val(datos[1]);
			$("#txtCOLEGIO").val(datos[0]);
		}
	})	
		
}

function GuardaSolicitud(){
	var rdb = $("#txtRDB").val();
	var colegio = $("#txtCOLEGIO").val();
	var fecha = $("#txtFECHA").val();
	var solicitante = $("#cmbSOLICITANTE").val();
	var obs = $("#txtOBS").val();
	var sistema = $("#cmbSISTEMA").val();
	var medio = $("#cmbMEDIO").val();
	
	if(rdb==""){
		alert("DEBE INGRESAR UN RDB");
		$("#txtRDB").focus();	
	}else if($("#cmbSISTEMA").val()==0){
		alert("DEBE SELECCIONAR SISTEMA");
		$("#cmbSISTEMA").focus();
	}else if($("#cmbMEDIO").val()==0){
		alert("DEBE SELECCIONAR MEDIO DE ENTRADA");
		$("#cmbMEDIO").focus();
	}else if($("#txtOBS").val()==""){
		alert("DEBE INGRESAR LAS OBSERVACIONES DE LA SOLICITUD");
		$("#txtOBS").focus();
	}else{
	var parametros="funcion=4&rdb="+rdb+"&colegio="+colegio+"&fecha="+fecha+"&solicitante="+solicitante+"&obs="+obs+"&sistema="+sistema+"&medio="+medio;
	
	$.ajax({
		url:"constructor.php",
		data:parametros,
		type:'POST',
		success: function(data){
			
			if(data==1){
				listado();		
			}else{
				alert("ERROR AL GUARDAR");
			}

		}
	})		
	}
}

function Modificar(id){
	var parametros="funcion=5&id="+id;
	
	$.ajax({
		url:"constructor.php",
		data:parametros,
		type:'POST',
		success: function(data){
			$("#tabla").html(data);
		}
	})	
	
}

function AsignaSolicitud(id){
	var estado 	= $("#cmbESTADO").val();
	var rut 	= $("#cmbPERSONAL").val();
	var tipo 	= $("#cmbTIPO").val();
	var parametros="funcion=6&id="+id+"&estado="+estado+"&rut="+rut+"&tipo="+tipo;

	$.ajax({
		url:"constructor.php",
		data:parametros,
		type:'POST',
		success: function(data){
			if(data==1){
				alert("DATOS MODIFICADOS");
				listado();
			}else{
				alert("ERROR AL MODIFICAR");
			}
		}
	})
	
}

function AgregarComentario(id){
	var parametros="funcion=7&id="+id;
	
	$.ajax({
		url:"constructor.php",
		data:parametros,
		type:'POST',
		success: function(data){
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
					 if($('#cmbESTADO').val()==0){
						alert("Seleccione Estado de la Observacion");
						$('#cmbESTADO').focus();
						return false;
					}
					if($('#txtOBS').val()==""){
						alert("Escriba comentarios");
						$('#txtOBS').focus();
						return false;
					}
						IngresoObs(id);
					  
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


function IngresoObs(id){
	
	var estado 	= $("#cmbESTADO2").val();
	var obs 	= $("#txtOBS").val();
	var parametros="funcion=8&id="+id+"&estado="+estado+"&obs="+obs;
	
	$.ajax({
		url:"constructor.php",
		data:parametros,
		type:'POST',
		success: function(data){
			console.log(data);
			if(data==1){
				alert("DATOS MODIFICADOS");
				listado();
			}else{
				alert("ERROR AL MODIFICAR");
			}
		}
	})	
}
function Eliminar(id){
	if(confirm("ESTA SEGURO QUE DESEA ELIMINAR LA SOLICITUD-->"+id)==true){;
		var parametros="funcion=10&id="+id;
		$.ajax({
			url:"constructor.php",
			data:parametros,
			type:'POST',
			success: function(data){
				if(data==1){
					alert("DATOS ELIMINADOS");
					listado();
				}else{
					alert("ERROR AL ELIMINADOS");
				}
			}
		})		
	}
}

function CantidadSolicitudes(){
	var parametros="funcion=9";
	$.ajax({
		url:"constructor.php",
		data:parametros,
		type:'POST',
		success: function(data){
			$("#buscador").html(data);
		}
	})		
}

function Limpiar(){
	$("#txtRDB2").val();
	$("#cmbCOLEGIO").val(0);
	$("#cmbSOLICITANTE2").val(0);
	$("#cmbTIPO2").val(0);
	listado();

}
</script>
<style>
    fieldset {
      border: 0;
    }
    select {
      width: 200px;
    }
    .overflow {
      height:50px;
    }
  </style>
<title>SISTEMA SAE:====> REQUERIMIENTOS</title>
</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0">


<table width="1280" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="3" valign="top" background="../../cortes/24977/fondo_01_reca.jpg" width="50"  height="900"></td>
    <td colspan="2" align="left" valign="top" height="70"><? include("../../cabecera_new/head.php");?></td>
    <td rowspan="3" background="../../cortes/24977/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td width="300" height="435" align="left" valign="top">&nbsp;<div id="buscador">&nbsp;</div></td>
    <td valign="top" align="center"><br />
<br />
<div id="tabla">&nbsp;</div><div id="dialog" title="AGREGAR COMENTARIOS">&nbsp;</div></td>
  </tr>
  <tr>
    <td valign="bottom" colspan="2" align="left"><? include("../../cabecera_new/footer.html");?></td>
  </tr>
</table>




</body>

</html>
