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
var funcion=1;
var parametros = "funcion="+funcion;
	  $.ajax({
			url:"cont_multa.php",
			data:parametros,
			type:'POST',
			success:function(data){
			//console.log(data);
					if(data == 0){
					   alert("Error al cargar");
					}else{
					 $("#tabla").html(data);
					}
		        }
		    })

}
 function guarda(tipo){
var funcion=2;
var monto = $("#monto").val();


	 
var parametros = "funcion="+funcion+"&monto="+monto+"&tipo="+tipo;
if(monto==""){
alert("DEBE INGRESAR MONTO DE LA MULTA");
$("#monto").focus();
}
else{
	  $.ajax({
			url:"cont_multa.php",
			data:parametros,
			type:'POST',
			success:function(data){
			alert("DATOS MODIFICADOS");
			filtro();
					
		        }
		    })
	}
}


function elimina(){
var funcion=3;
var parametros = "funcion="+funcion;
	  $.ajax({
			url:"cont_multa.php",
			data:parametros,
			type:'POST',
			success:function(data){
			
					if(data == 0){
					   alert("Error al cargar");
					}else{
						alert("DATOS ELIMINADOS")
					 filtro();
					}
		        }
		    })

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
    	<td width="5%" colspan="4"><br />
<br />
<br />
<div id="tabla"></div>
<br />
<br />
</td>
    </tr>
    </table>
	
</td>
  </tr>
  <tr>
    <td colspan="2" valign="bottom" align="center"><? include("../../cabecera_new/footer.html");?></td>
  </tr>
</table>


</body>

</html>
