<?php 
require("../../util/header.php");
session_start();
$_POSP=2;
//var_dump($_SESSION);<a href="../../util/header.php">header.php</a>
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
<link href="../../admin/clases/jquery/uploadfile.css" rel="stylesheet" type="text/css"> 
<style>
.check{
	background-color:#0F3;
 
}
.nocheck{
	background-color:blue;

}
</style>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
 <script type="text/javascript" src="../../admin/clases/jquery-ui-1.9.2.custom/development-bundle/ui/jquery.ui.dialog.js"></script>
 <script type="text/javascript" src="../../admin/clases/jquery/uploadfile.js"></script>
<script>

$(document).ready(function(){

	traeCurso(<?php echo $_ANO ?>);
});

 function traeCurso(ano){
	var funcion =1;
	var parametros="funcion="+funcion+"&ano="+ano;
	 // $("#prof").html('<input type="text" name="docdicta" id="docdicta" value="0" />');
	  
	
	$.ajax({
	  url:'cont_evaluacion.php',
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
	
	var funcion =2;
	var parametros="funcion="+funcion+"&curso="+curso;
	 
	$.ajax({
	  url:'cont_evaluacion.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#ram").html(data);
		
		  }
	  })	
	
}





function cambia_unidad(){
 var curso = $("#sel_curso").val();
 var ramo = $("#sel_ramo").val();
 var ano = <?php echo $_ANO; ?>;
 var parametros="funcion=5&ano="+ano+"&curso="+curso+"&ramo="+ramo;
 $.ajax({
	  url:'cont_evaluacion.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		 //alert(data);
	    $("#unidad").html(data);

		  }
	  })		
}

function cambia_clase(){
 var ano = <?php echo $_ANO; ?>;
 var curso = $("#sel_curso").val();
 var ramo = $("#sel_ramo").val();
 var unidad = $("#cmbUNIDAD").val();
 
 var parametros="funcion=6&ano="+ano+"&curso="+curso+"&ramo="+ramo+"&unidad="+unidad;
 $.ajax({
	  url:'cont_evaluacion.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //console.log(data);
		 //alert(data);
	    $("#clase").html(data);

		  }
	  })		
}

function traeEvaluaciones(){
var funcion =7;
var curso= $("#sel_curso").val();
var ramo= $("#sel_ramo").val();
var rdb = <?php echo $_INSTIT ?>;
var id_ano = <?php echo $_ANO ?>;
var unidad = $("#cmbUNIDAD").val();
var clase= $("#cmbCLASE").val();

var parametros = "funcion="+funcion+"&curso="+curso+"&ramo="+ramo+"&rdb="+rdb+"&id_ano="+id_ano+"&unidad="+unidad+"&clase="+clase;
$.ajax({
	  url:'cont_evaluacion.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#tabla").html(data);
		
		  }
	  })	
}
function creaEvaluacion(){
var funcion =8;
var curso= $("#sel_curso").val();
var ramo= $("#sel_ramo").val();
var rdb = <?php echo $_INSTIT ?>;
var id_ano = <?php echo $_ANO ?>;
var unidad = $("#cmbUNIDAD").val();
var clase= $("#cmbCLASE").val();

$("#nvo").html('<input type="button" name="nuevaClase id="nuevaClase" value="Guardar" onclick="GuardaEvaluacion()" class="botonXX" /> <input type="button" name="btnC" id="btnC" value="Cancelar" onclick="cancela()"  class="botonXX"/>');


var parametros = "funcion="+funcion+"&curso="+curso+"&ramo="+ramo+"&rdb="+rdb+"&id_ano="+id_ano+"&unidad="+unidad+"&clase="+clase;

if(curso==0){
alert("Seleccione curso");
}
else if(ramo==0){
alert("Seleccione ramo");
}
else if(unidad==0){
alert("Seleccione unidad");
}
else if(clase==0){
alert("Seleccione clase");
}
else{
$.ajax({
	  url:'cont_evaluacion.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
	    $("#tabla").html(data);
		
		  }
	  })

}
}


function cancela(){
	traeEvaluaciones();
	 $("#nvo").html(' <input type="button" name="nuevaUnidad" id="nuevaUnidad" class="botonXX" value="Nueva Evaluaci&oacute;n" onclick="creaEvaluacion()" />                                  <input type="button" name="busca" id="busca" class="botonXX" value="Buscar" onclick="traeEvaluaciones()" border="0" />');
	
}

function GuardaEvaluacion(){
var funcion=9;
var unidad = $("#cmbUNIDAD").val();
var clase= $("#cmbCLASE").val();
var nombre= $("#nombre").val();
var descripcion= $("#descripcion").val();

var parametros = "funcion="+funcion+"&unidad="+unidad+"&clase="+clase+"&nombre="+nombre+"&descripcion="+descripcion;


if(nombre.length==0){
alert("Escriba nombre");
}
else if(descripcion.length==0){
alert("Escriba texto descriptivo");
}
else{
$.ajax({
	  url:'cont_evaluacion.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  console.log(data);
		// alert(data);
	    //$("#tabla").html(data);
		if(data==0){
		alert("Error al guardar");
		}else{
		alert("Datos ingresados");
		traeEvaluaciones();
		}
		
		  }
	  })

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

                      <form id="frm" enctype="multipart/form-data"  method="post">
                      <table width="860" border="0" class="tablaredonda">
                          <tr>
                            <td>

<input type="hidden" name="ff" id="ff" />
<input type="hidden" name="ins" id="ins" value="<?php echo $_INSTIT ?>" />
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
                            <td class="textonegrita">UNIDAD</td>
                            <td><div id="unidad">
                              <select name="cmbUNIDAD" id="cmbUNIDAD" class="select_redondo">
                                <option value="0">seleccione...</option>
                                </select>
                              </div></td>
                          </tr>
                          <tr>
                            <td class="textonegrita">CLASE</td>
                            <td><div id="clase">
    <select name="cmbCLASE1" id="cmbCLASE1" class="select_redondo">
        <option value="0">seleccione...</option>
    </select>
    </div></td>
                          </tr>
                          <tr>
                            <td colspan="2" align="left">
                            <table width="100%" border="0">
                              <tr>
                                <td align="right"><div id="nvo">
                                <input type="button" name="nuevaUnidad" id="nuevaUnidad" class="botonXX" value="Nueva Evaluaci&oacute;n" onclick="creaEvaluacion()" />                                  <input type="button" name="busca" id="busca" class="botonXX" value="Buscar" onclick="traeEvaluaciones()" border="0" /></div></td>
                              </tr>
                            </table>

                            </td>
                          </tr>
                          <tr>
                            <td colspan="2" align="right">&nbsp;</td>
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
 <td align="left" valign="top" background="../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
</table>

</td>

    <!--<td width="53" align="center" valign="top" height="100%" >ACA IMAGEN DERECHA</td>-->
  </tr>
</table> 
</body>
</html>
