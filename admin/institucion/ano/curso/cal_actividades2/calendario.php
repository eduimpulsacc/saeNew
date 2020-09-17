<?php 
require('../../../../../util/header.inc');
session_start();


	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	
	 
	$ramo			=$_RAMO; 
	$frmModo		=$_FRMMODO;
	$empleado		=$_EMPLEADO;
    $_POSP = 5;
	$_bot           =5;
	$_MDINAMICO     = 1;
	$curso			= $c_curso;

//var_dump($_SESSION);
 

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script>
$(document).ready(function(){
	curso(<?php echo $ano ?>);
});

function curso(ano){
	var funcion=1;
	$.ajax({
			url:"cont_calendario.php",
			data:"funcion="+funcion+"&anio="+ano,
			type:'POST',
			success:function(data){
			$('#cur').html(data);
	  }
	});  
}

function traeEvento(curso){
var funcion=2;
		$("#example").remove();
		$("#add-event-form").remove();
		
	if(curso!=0){
		
	$.ajax({
				url:"cont_calendario.php",
				data:"funcion="+funcion+"&curso="+curso,
				type:'POST',
				success:function(data){
				$('#fecha').html(data);
				
				
		  }
		});  
	}else{
	$('#fecha').html('');
	}
}

function creaEvento(){

var formData =$('#frm').serialize();
var funcion=3;
var curso = $('#cmb_curso').val();
var parametros = "funcion="+funcion+"&curso="+curso+"&data="+formData;
$.ajax({
				url:"cont_calendario.php",
				data:parametros,
				type:'POST',
				success:function(data){
				console.log(data);
				
				
		  }
		});
}
function eliminaEvento(evento){
		var funcion=4;
		
		
		$.ajax({
				url:"cont_calendario.php",
				data:"funcion="+funcion+"&act="+evento,
				type:'POST',
				success:function(data){
				//console.log(data);
				alert('Actividad Eliminada');
		  }
		});  
		
	}

function modificaEvento(evento){
		var funcion=5;
		
		
		$.ajax({
				url:"cont_calendario.php",
				data:"funcion="+funcion+"&act="+evento,
				type:'POST',
				success:function(data){
				//console.log(data);
				//alert('Actividad Eliminada');
				//$("#display-event-form").dialog('close');
				 $("#ediact").html(data);
				 $("#ediact").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
  height: 350,
	width: 400,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
	 "Guardar Datos": function(){
		
		  /*if($('#opc_estado').val()==0){
			  alert("Seleccione estado");
			  return false;
			 }
			 
			else if($('#opc_estado').val()==4 && $('#txt_obser').val()==""){
			  alert("Ingrese descripcion");
			  return false;
			 }
		  else{*/
			 GmodificaEvento(); 
			 //}
		  
		   //$(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  })
		  }
		});  
		
	}

	
	function GmodificaEvento(){
		var funcion=6;
var curso =$('#cmb_curso').val();
var nombre = $('#what2').val(); 
var fecha_inicio=$('#startDate2').val();
var fecha_termino=$('#endDate2').val();
var hora_inicio=$('#startHour2').val()+":"+$('#startMin2').val();
var hora_termino=$('#endHour2').val()+":"+$('#endMin2').val();
var descripcion=$('#descripcion2').val();
var idact=$('#idact').val();

var parametros= "funcion="+funcion+"&nombre="+nombre+"&fecha_inicio="+fecha_inicio+"&fecha_termino="+fecha_termino+"&hora_inicio="+hora_inicio+"&hora_termino="+hora_termino+"&descripcion="+descripcion+"&idact="+idact;
		
		
		$.ajax({
				url:"cont_calendario.php",
				data:parametros,
				type:'POST',
				success:function(data){
				//console.log(data);
				alert('Actividad actualizada');
				$("#ediact").dialog('close');
				location.reload();
				traeEvento(curso);
				
		  }
		  
		  
		  
		  
		  
		});  
		
		
		
	}
</script>


<link rel="stylesheet" type="text/css" href="../../../../clases/jquery-ui-1.9.2.custom/development-bundle/demos/demos.css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="" align="left" valign="top"> 
                        <? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top" class="tableindex">Calendario de Actividades</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top">
                            
<table width="650" border="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="textonegrita">
    <td width="108" >CURSO</td>
    <td width="8" align="center">:</td>
    <td width="528" class="textonegrita">
    <div id="cur">
   
    </div>
    </td>
  </tr>
  <tr>
    <td></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

                           
                            </td>
                          </tr>
                          <tr><td id="cale" align="center"><div id="fecha" ></div></td></tr>
                           <tr><td>&nbsp;</td></tr>
                          <tr>
                            <td height="" align="left" valign="top">
                            <!--div de formulario de accidente-->

                            
                            </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"> <? include("../../../../../cabecera/menu_inferior.php") ;?> </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>




</body>
</html>
