<?php 
	require('../../../../util/header.inc');
	
	$_POSP   =4;
	
?>
<!doctype html>

<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>

<script type="text/javascript">

$(document).ready(function(){
	$("#cnt").hide();
		isHab();
});


function isHab(){
	var parametros="funcion=0&rbd=<?php echo $_INSTIT ?>";
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  console.log(data)
		
	  if(data==1){
		  $("#cnt").show();
		Inicio();
		ListarMotivo();
		cuentaSMS();
		  }else{
			  $("#cnt").show();
			 //$("#cnt").html("no"); 
			 merror();
			 }
	  		
	  
	  		  }
	  })		
}

function cuentaSMS(){
var parametros="funcion=16";
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		  if(data==999){
			  alert("Sin Bolsas SMS activas");
			  $("#env").hide();   
			 }else{
				 
	  
	
		  
	   var str = data.split("_");
	  
	   var saldo = parseInt(str[0]);
	   var bolsa =  parseInt(str[1]);
	   var matri =  parseInt(str[2]);
	   var ic =  parseInt(str[4]);
	   var fcadu =  str[3];
	  
	   fcadu = fcadu.split("-");
	  
	   var hoy = new Date();
		var dd = hoy.getDate();
		var mm = hoy.getMonth()+1; //hoy es 0!
		var yyyy = hoy.getFullYear();
		
		if(dd<10) {
			dd='0'+dd
		} 
		
		if(mm<10) {
			mm='0'+mm
		} 
		
		
		var f1 = new Date(yyyy, mm, dd); //31 de diciembre de 2015
		var f2 = new Date(fcadu[0], (fcadu[1]-1), fcadu[2]);
		if(f1>f2){
			alert("Su bolsa de SMS ha caducado.\nFavor comunicarse con el administrador del sistema");
			$("#env").hide();   
			caducaBolsa(ic);	
		}
		
		//alert(hoy);
	  
	   $("#sal").html("Saldo disponible: "+saldo+" de "+bolsa+"  ");
	   
	   
	   if(saldo==0){
			alert("Sin Saldo Disponible");
				$("#env").hide();   
		   }
	  if(saldo>0 && saldo<=matri  ){
			alert("Quedan pocos mensajes disponibles");
				  
		   }
		    /* if(str[0]>0 && str[0]>str[2]){
			alert("hla");
				  
		   }*/
		  
		   
		
				}
		  
		  }
	
	})		
}


function caducaBolsa(ic){
	var parametros="funcion=17&ic="+ic;
	//alert(parametros)
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  //  $("#nroano").html(data);
	 // console.log(data);
		  }
	  })	
}


function Inicio(){
	var parametros="funcion=1";
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#curso").html(data);
		NroAno();
		BuscaAlumno();
		BuscaApoderado();
		Listado();
		  }
	  })		
}



function NroAno(){
	var parametros="funcion=4";
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#nroano").html(data);
		  }
	  })	
}
function BuscaApoderado(){
	var curso = $("#cmbCURSO").val();
	var alumno = $("#cmbALUMNO").val();
	var parametros="funcion=2&curso="+curso+"&alumno="+alumno;
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  console.log(data);
	    $("#apoderado").html(data);
		Listado();
		  }
	  })
		
}
function msg(id){
	var curso = $("#cmbCURSO").val();
	var alumno = $("#cmbALUMNO").val();
	var apoderado = $("#cmbAPODERADO").val();
	var dato_apo = apoderado.split(",");
	var motivo = $("#cmbMOTIVO").val();
	var mensaje = $("#txtSMS").val();
	var parametros="funcion=5&curso="+curso+"&alumno="+alumno+"&apoderado="+dato_apo[0]+"&motivo="+motivo+"&mensaje="+mensaje+"&fono="+dato_apo[1];
	//alert(parametros);
	 $('#tabla').html('<div><img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/loading.gif"/></div>');
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 console.log(data);
		// alert(data);
		  if(data==0){
			alert("Error de sistema, favor intente mas tarde");  
		  }else{
			  Listado();
			 //ValidaSMS(data);
			 cuentaSMS();
			 $("#vista").html(data);
		  }
		
		  }
	  })
		
}
function AgregarMotivo(){
	var parametros="funcion=6";
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#newmotivo").html(data);
		 $("#newmotivo").dialog({ 
					autoOpen:true,
					width:400,
					height:200,
					modal:true,
					buttons: {
						'Guardar': function(){
						if($('#txtMOTIVO').val()==0){
							alert("Escriba nombre del motivo");
							$('#txtMOTIVO').focus();
							return false;
						}
						   IngresarMotivo();
						  
						   $(this).dialog("close");	
						},
					    'Cerrar': function(){ $(this).dialog('close');}
					 }
			   });
		  }
	  })
		
}

function IngresarMotivo(){
	var motivo = $('#txtMOTIVO').val();
	var parametros="funcion=7&motivo="+motivo;
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //console.log(data);
	   		if(data == 0){
			   alert("Error al Guardar Datos");
			}else{
			  alert("Datos Guardados");
			  ListarMotivo();
			  return true;
			}
	  }
	  })
	
}

function ListarMotivo(){
	var parametros="funcion=8";
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		  $("#motivo").html(data);
		  }
	  })	
}

function BuscaAlumno(){
	var curso = $("#cmbCURSO").val();
	var parametros = "funcion=9&curso="+curso;
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //console.log(data);
		  $("#alumno").html(data);
		  BuscaApoderado();
		  Listado();
		  }
	  })		
}
function Listado(){
	//alert("nuevo");
	var curso = $("#cmbCURSO").val();
	var alumno =$("#cmbALUMNO").val();
	var apoderado = $("#cmbAPODERADO").val();
	var dato_apo = apoderado.split(",");
	var motivo = $("#cmbMOTIVO").val();
	var parametros="funcion=10&curso="+curso+"&alumno="+alumno+"&apoderado="+dato_apo['0']+"&motivo="+motivo;
	//alert(parametros);
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#tabla").html(data);
		  }
	  })
}

function NuevoSMS(){
	var parametros="funcion=11";
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#tabla").html(data);
		  }
	  })	
}


contenido_textarea = "" 
num_caracteres_permitidos = 160 
function valida_longitud(){
	
   num_caracteres = $("#txtSMS").val().length
   if (num_caracteres > num_caracteres_permitidos){ 
      $("#txtSMS").val(contenido_textarea);
   }else{ 
      contenido_textarea = $("#txtSMS").val()	
   } 
   if (num_caracteres >= (num_caracteres_permitidos-10)){ 
      $("#caracteres").css({'color' : '#ff0000'}); 
   }else{ 
     $("#caracteres").css({'color' : '#000000'}); 
   } 

   cuenta() 
} 
function cuenta(){ 
   num_caracteres = $("#txtSMS").val().length
   $("#caracteres").val(num_caracteres); 
} 

function Valida(){
	var curso = $("#cmbCURSO").val();
	var alumno =$("#cmbALUMNO").val();
	var apoderado = $("#cmbAPODERADO").val();
	var dato_apo = apoderado.split(",");
	var motivo = $("#cmbMOTIVO").val();
	cantidad = $("#txtSMS").length;
	
	
	/*if($("#cmbCURSO").val()==0){
		alert("Debe seleccionar curso");	
		$("#cmbCURSO").focus();
	}else if($("#cmbALUMNO").val()==0){
		alert("Debe seleccionar Alumno");
		$("#cmbALUMNO").focus();	
	}else if($("#cmbAPODERADO").val()==0){
		alert("Debe seleccionar Apoderado");
		$("#cmbAPODERADO").focus();
	*/
	if($("#cmbCURSO").val()==0 && $("#cmbALUMNO").val()==0 && $("#cmbAPODERADO").val()==0){
		if(confirm("ADVERTENCIA: Esta a punto de enviar un SMS a cada apoderado del colegio")){  
			if($("#cmbMOTIVO").val()==0){
				alert("Debe seleccionar un motivo");
				$("#cmbMOTIVO").val();	
			}else if($("#txtSMS").val()==""){
				alert("Debe redactar el Mensaje");
				$("#txtSMS").focus();	
			}else{
				//alert(cantidad);
				msg();	
			}
		}
	}else if($("#cmbCURSO").val()!=0 && $("#cmbALUMNO").val()==0 && $("#cmbAPODERADO").val()==0){
		if(confirm("ADVERTENCIA: Esta a punto de enviar un SMS a cada apoderado del Curso")){  
			if($("#cmbMOTIVO").val()==0){
				alert("Debe seleccionar un motivo");
				$("#cmbMOTIVO").val();	
			}else if($("#txtSMS").val()==""){
				alert("Debe redactar el Mensaje");
				$("#txtSMS").focus();	
			}else{
				//alert(cantidad);
				msg();	
			}
		}
	}else{
		if($("#cmbMOTIVO").val()==0){
			alert("Debe seleccionar un motivo");
			$("#cmbMOTIVO").val();	
		}else if($("#txtSMS").val()==""){
			alert("Debe redactar el Mensaje");
			$("#txtSMS").focus();	
		}else{
			//alert(cantidad);
			msg();	
		}	
	}
}

function VistaPrevia(id){
	var parametros="funcion=12&id="+id;
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#vistaprevia").html(data);
		 $("#vistaprevia").dialog({ 
					autoOpen:true,
					width:550,
					height:450,
					modal:true,
					buttons: {
					    'Cerrar': function(){ $(this).dialog('close');}
					 }
			   });
		  }
	  })
		
}

function Estadistica(rut){
	var parametros="funcion=13&rut="+rut;
	//alert(parametros);
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#estadistica").html(data);
		 $("#estadistica").dialog({ 
					autoOpen:true,
					width:550,
					height:450,
					modal:true,
					buttons: {
					    'Cerrar': function(){ $(this).dialog('close');}
					 }
			   });
		  }
	  })
}

function ValidaSMS(id){
	
	var parametros = "funcion=14&id="+id;
	//alert(parametros);
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		//  alert(data);
	    	if(data==0){
				alert("Mensaje Recepcionado");
				Listado();
			}else{
				alert("ERROR EN ENVIO");
				Listado();
			}	
		  }
	  })
	
}
/*function NuevoRetiro(){
	var curso =$("#cmbCURSO").val();
	var alumno=$("#cmbALUMNO").val();
	if(curso==0 || alumno==0){
		alert("DEBE SELECCIONAR ALUMNO A RETIRAR");	
	}
	var parametros="funcion=5&curso="+curso+"&alumno="+alumno;
	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#tabla").html(data);
		  }
	  })
	
}

function GuardarRetiro(){
	var ano =<?=$_ANO;?>;
	var curso =$("#cmbCURSO").val();
	var alumno=$("#cmbALUMNO").val();
	var fecha =$("#txtFECHAS").val();
	var hora_ingreso = $("#txtHORAINGRESO").val();
	var hora_regreso = $("#txtHORAREGESO").val();
	var empleado = $("#cmbEMPLEADO").val();
	var motivo = $("#txtMOTIVO").val();
	var retira = $("#txtRETIRA").val();
	
	var parametros="funcion=6&ano="+ano+"&curso="+curso+"&alumno="+alumno+"&fecha="+fecha+"&hora_ing="+hora_ingreso+"&hora_egr="+hora_regreso+"&empleado="+empleado+"&motivo="+motivo+"&retira="+retira;
	
	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==1){
			  Listado();
		  }else{
			alert("ERROR EN INGRESO");
		  }

		  }
	  })
}

function Eliminar(id){
	var parametros="funcion=7&id_retiro="+id;
	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==1){
			  Listado();
		  }else{
			alert("ERROR EN INGRESO");
		  }

		  }
	  })
		
}
function Modificar(id){
	var parametros="funcion=8&id_retiro="+id;
	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#tabla").html(data);
		  }
	  })
		
}

function ModificaRetiro(id){
	var ano =<?=$_ANO;?>;
	var curso =$("#cmbCURSO").val();
	var alumno=$("#cmbALUMNO").val();
	var fecha =$("#txtFECHAS").val();
	var hora_ingreso = $("#txtHORAINGRESO").val();
	var hora_regreso = $("#txtHORAREGESO").val();
	var empleado = $("#cmbEMPLEADO").val();
	var motivo = $("#txtMOTIVO").val();
	var retira = $("#txtRETIRA").val();
	
	var parametros="funcion=9&ano="+ano+"&curso="+curso+"&alumno="+alumno+"&fecha="+fecha+"&hora_ing="+hora_ingreso+"&hora_egr="+hora_regreso+"&empleado="+empleado+"&motivo="+motivo+"&retira="+retira+"&id_retiro="+id;
	
	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		   if(data==1){
			  Listado();
		  }else{
			alert("ERROR EN MODIFICACION");
		  }

		  }
	  })	
}
*/

function merror(){
	var parametros="funcion=15";
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#cnt").html(data);
		  }
	  })	
}

</script>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <? include("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?php $menu_lateral="3_1"; include("../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="200" valign="top"><!-- inicio codigo antiguo -->
								  <br>
<div id="cnt">
						  			<table width="650" border="1" style="border-collapse:collapse" align="center">
                                      <tr>
                                        <td width="112" class="cuadro02">AÑO</td>
                                        <td width="27" class="cuadro02">&nbsp;:&nbsp;</td>
                                        <td width="100" class="cuadro01" >&nbsp;<div id="nroano"><?=$nro_ano;?></div></td><td align="right" bgcolor="#cccccc"><span id="sal" style="text-align:right; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px"></span></td>
                                      </tr>
                                      <tr>
                                        <td class="cuadro02">CURSO</td>
                                        <td class="cuadro02">&nbsp;:&nbsp;</td>
                                        <td colspan="2" class="cuadro01"><div id="curso">
                                        <select name="cmbCURSO" id="cmbCURSO" onChange="BuscaApoderado()">
                                            <option value="0">seleccione...</option>
                                         </select>
                                        </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td class="cuadro02">ALUMNO</td>
                                        <td class="cuadro02">&nbsp;:&nbsp;</td>
                                        <td colspan="2" class="cuadro01">
                                        <div id="alumno">
                                        <select name="cmbALUMNO" id="cmbALUMNO">
                                            <option value="0">seleccione...</option>
                                        </select>
                                        </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td class="cuadro02">APODERADO</td>
                                        <td class="cuadro02">&nbsp;:&nbsp;</td>
                                        <td colspan="2" class="cuadro01">
                                        <div id="apoderado">
                                        <select name="cmbAPODERADO" id="cmbAPODERADO">
                                            <option value="0">seleccione...</option>
                                        </select>
                                        </div>
                                        </td>
                                      </tr>
                                       <tr>
                                        <td class="cuadro02">MOTIVO</td>
                                        <td class="cuadro02">&nbsp;:&nbsp;</td>
                                        <td width="50" class="cuadro01" colspan="2"><span id="motivo"> 
                                        	<select name="cmbMOTIVO" id="cmbMOTIVO">
                                            	<option value="0">seleccione...</option>
	                                        </select>
                                            </span> 
                                         
                                          <img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" onClick="AgregarMotivo()">                                     
                                        </td>
                                      </tr>
                                       <tr>
                                        <TD colspan="4" align="right" class="cuadro02"> <div align="right">
                                        <input type="button" id="env" value="Enviar SMS" onClick="Valida();" class="botonXX">
                                        <input type="button" id="nvo" value="Crear SMS" onClick="NuevoSMS();" class="botonXX">
                                        </div>
                                        </td>
                                      </tr>
                                    </table><br>
<br>

                                    
                                      <!-- <table width="650" border="0" align="center">
                                          <tr>
                                            <td>&nbsp;MENSAJE</td>
                                            <td>&nbsp;<textarea name="txtSMS" cols="50" rows="10"></textarea></td>
                                          </tr>
                                        </table>
	
                                         <input type="button" value="mensaje" onClick="msg();">-->                              
                                    <div id="tabla" align="center">&nbsp;</div>
                                    <div id="newmotivo">&nbsp;</div>
                                    <div id="vista">&nbsp;</div>
                                    <div id="vistaprevia" title="Vista Previa SMS">&nbsp;</div>
                                    <div id="estadistica" title="Estadistica SMS">&nbsp;</div>
			  
								  <!-- fin codigo -->
                                  </div>
								   </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
