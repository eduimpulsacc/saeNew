<?php  

require("../../util/header.php");
session_start();
$_POSP=2;
//var_dump($_SESSION);<a href="../../util/header.php">header.php</a>
//echo $_ID_BASE;
?>
<!doctype html>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<link href="../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link href="../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<!--<link href="../../cortes/<?=$_INSTIT;?>/estilos.css" rel="stylesheet" type="text/css"> -->
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	tpob();
	 $("#listado").hide();
	
  });



function tpob(){
var parametros = "funcion=1";
	$.ajax({
	  url:'cont_indicadoreva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
	    $("#tabla").html(data);
		  }
	  })	
}

function gradoe(){
var ense =  $("#cmb_ense").val();
var parametros = "funcion=2&ense="+ense;
	$.ajax({
	  url:'cont_indicadoreva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
	    $("#grd").html(data);
		  }
	  })	
}

function subs(){
var ense =  $("#cmb_ense").val();
var grado =  $("#cmb_grado").val();
var parametros = "funcion=3&ense="+ense+"&grado="+grado;
	$.ajax({
	  url:'cont_indicadoreva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#subs").html(data);
		  }
	  })	
}

function tipo(){
var parametros = "funcion=5";
	$.ajax({
	  url:'cont_indicadoreva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#tip").html(data);
		  }
	  })	
}


function eje(){
var ense =  $("#cmb_ense").val();
var grado =  $("#cmb_grado").val();
var subs =  $("#cmb_subsector").val();
var tipo =  $("#cmb_tipo").val();
var parametros = "funcion=4&ense="+ense+"&grado="+grado+"&subs="+subs+"&tipo="+tipo;
	$.ajax({
	  url:'cont_indicadoreva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#deje").html(data);
		  }
	  })	
}


function obje(){
var ense =  $("#cmb_ense").val();
var grado =  $("#cmb_grado").val();
var subs =  $("#cmb_subsector").val();
var tipo =  $("#cmb_tipo").val();
var eje =  $("#cmb_eje").val();
var parametros = "funcion=6&ense="+ense+"&grado="+grado+"&subs="+subs+"&tipo="+tipo+"&eje="+eje;
	$.ajax({
	  url:'cont_indicadoreva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#obj").html(data);
		
		
		  }
	  })	
}

 
function ingresarIND(){

var tipo =  $("#cmb_tipo").val();
var eje =  $("#cmb_eje").val();
var txt =  $("#txt_ind").val();
var obj =  $("#cmb_objetivo").val();
var uni =  $("#cmb_unidad").val();
var parametros = "funcion=8&tipo="+tipo+"&eje="+eje+"&txt="+txt+"&obj="+obj+"&uni="+uni;
	$.ajax({
	  url:'cont_indicadoreva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //console.log(data);
		 if(data==1){
			alert("DATOS GUARDADOS");
			$("#titeje").html('');
			 lista();
			}
			else{
			alert("ERROR AL GUARDAR");
			}
		  }
	  })		

}

function lista(){
var eje =  $("#cmb_eje").val();
var obj =  $("#cmb_objetivo").val();
var uni =  $("#cmb_unidad").val();
var parametros = "funcion=9&obj="+obj+"&eje="+eje+"&uni="+uni;
	$.ajax({
	  url:'cont_indicadoreva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  $("#listado").show();
	    $("#listado").html(data);
		$(".tr1").show();
		$("#btn").show();
		  }
	  })	
}


function elimina(id){

if(confirm("Seguro de eliminar?")){
var parametros = "funcion=10&id="+id;
	$.ajax({
	  url:'cont_indicadoreva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 console.log(data);
		 if(data==1){
			alert("DATOS MODIFICADOS");
			 lista();
			}
			else{
			alert("ERROR AL MODIFICAR");
			}
		  }
	  })		
}
}

function replica(id){
	
var parametros = "funcion=11&id="+id;
	$.ajax({
	  url:'cont_indicadoreva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// console.log(data);
		 $("#copia").html(data);
			$("#copia").dialog({
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
        click: function() { guardaRepUni() ;$(this).dialog("close");}
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


function guardaRepUni(){
var funcion=12;
var uni1 =  ($('#uni1').is(':checked'))?1:0;
var uni2 =  ($('#uni2').is(':checked'))?2:0;
var uni3 =  ($('#uni3').is(':checked'))?3:0;
var uni4 =  ($('#uni4').is(':checked'))?4:0;
var uni5 =  ($('#uni5').is(':checked'))?5:0;
var uni6 =  ($('#uni6').is(':checked'))?6:0;
var uni7 =  ($('#uni7').is(':checked'))?7:0;
var uni8 =  ($('#uni8').is(':checked'))?8:0;
var uni9 =  ($('#uni9').is(':checked'))?9:0;
var uni10 =  ($('#uni10').is(':checked'))?10:0;
var idun =  $("#iduni").val();

var parametros = "funcion="+funcion+"&uni1="+uni1+"&uni2="+uni2+"&uni3="+uni3+"&uni4="+uni4+"&uni5="+uni5+"&uni6="+uni6+"&uni7="+uni7+"&uni8="+uni8+"&uni9="+uni9+"&uni10="+uni10+"&idun="+idun;
//alert(parametros);

$.ajax({
	  url:'cont_indicadoreva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  console.log(data);
		 if(data==1){
			alert("DATOS MODIFICADOS");
			
			 lista();
			 
			}
			else{
			alert("ERROR AL MODIFICAR");
			}
		  }
	  })	

}
function edita(id){
var parametros = "funcion=13&id="+id;
	$.ajax({
	  url:'cont_indicadoreva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// console.log(data);
		 $("#edi").html(data);
			$("#edi").dialog({
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
        click: function() { guardaEdi(); $(this).dialog("close");
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

function guardaEdi(){
var funcion=14;
var txt = $("#txt_edi").val();
var id = $("#iduedi").val();
var parametros ="funcion="+funcion+"&id="+id+"&txt="+txt;
if(txt==""){
alert("DEBE COMPLETAR EL CAMPO");
//return false;
}else{
	//alert(parametros);
	$.ajax({
	  url:'cont_indicadoreva.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  console.log(data);
		 if(data==1){
			alert("DATOS MODIFICADOS");
			
			 lista();
			}
			else{
			alert("ERROR AL MODIFICAR");
			}
		  }
	  })
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
            <td><br>
  			<div align="center" id="tabla"><br>
<br><br>
				

            </td>
          </tr>
        </table>
         
     <div id="listado"></div><br>
		
    </td>
  </tr>
  <tr>
    <td colspan="2"><? include("../../cabecera_new/footer.html");?></td>
  </tr>
</table>
<div id="copia" title="Replicar Indicadores"></div>
<div id="edi" title="Editar Indicador"></div>
</body>
</html>
