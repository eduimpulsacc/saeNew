<?php 
	require('../../../../util/header.inc');
	
	$_POSP   =4;
	//if($_INSTIT==25114){
	//show($_SESSION);
	//}
	if($_PERFIL==0){
	//show($_SESSION);
	}
?>

<!doctype html>

<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</HEAD>

<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>


<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">




<script type="text/javascript">

$(document).ready(function(){
	$("#cnt").hide();
		isHab();
		$(".grp").hide();
		$(".alu").hide();
		$("#nvo").hide();
		$("#env").hide();
		$(".pln").hide();
		NroAno();
		tipoSis();
		cargoEmp();
		TodosAlusCol(); 
		ListarMotivo2();
		
		$( "#bdesde,#basta" ).datepicker({
	showOn: 'both',
	changeYear:false,
	changeMonth:false,
	dateFormat: 'dd/mm/yy',
	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
	dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
  firstDay: 1
	//buttonImage: 'img/Calendario.PNG',
	});;
		
		
		
});


function isHab(){
	var parametros="funcion=0&rbd=<?php echo $_INSTIT ?>";
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		
	  if(data==1){
		  $("#cnt").show();
		Inicio();
		ListarMotivo();
		<?php if($_SMS==15){?>
		cuentaSMS();
		<?php }?>
		ListarPantilla();
		  }else{
			  $("#cnt").show();
			
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
		var mm = hoy.getMonth(); //hoy es 0!
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
		
		
	  
	   $("#sal").html("Saldo disponible: "+saldo+" de "+bolsa+"  ");
	    $("#salm").val(saldo);
	   
	   if(saldo==0){
			alert("Sin Saldo Disponible");
				$("#env").hide();   
		   }
	  if(saldo>0 && saldo<=matri  ){
			alert("Quedan pocos mensajes disponibles");
				  
		   }
		   
		  
		   
		
				}
		  
		  }
	
	})		
}


function caducaBolsa(ic){
	var parametros="funcion=17&ic="+ic;
	
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	 
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
		
		BuscaAlumno();
		BuscaApoderado();
		//Listado();
		BuscaGrupo();
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
		
	    $("#apoderado").html(data);
			//Listado();
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
	
	 $('#tabla').html('<div><img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/loading.gif"/></div>');
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
		  if(data==0){
			alert("Error de sistema, favor intente mas tarde");  
		  }else{
			  //Listado();
			<?php if($_SMS==15){?>
			 cuentaSMS();
			<?php }?>
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
		
		  $("#motivo").html(data);
		  }
	  })	
}
function ListarMotivo2(){
	var parametros="funcion=34";
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		  $("#motivo2").html(data);
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
		 
		  $("#alumno").html(data);
		  BuscaApoderado();
		  //Listado();
		  }
	  })		
}
function Listado(){
	
	
	var funcion =10;
	var desde  = $("#bdesde").val();
	var hasta = $("#basta").val();
	var motivo = $("#cmbMOTIVOB").val();
	var via = $('input[name=viab]:checked').val();
	var modulo = $("#mobuloB").val();
	if(via==undefined){
		alert("Debe seleccionar sistema");
	}else{
		var parametros = "funcion="+funcion+"&desde="+desde+"&hasta="+hasta+"&motivo="+motivo+"&via="+via+"&modulo="+modulo;
		$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
		  $("#tabla").html(data);
		  }
	  })
	}
}

function NuevoSMS(){
	var parametros="funcion=11";
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  $(".pln").show();
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

   cuenta();
} 
function cuenta(){ 
   num_caracteres = $("#txtSMS").val().length
   $("#caracteres").val(num_caracteres); 
} 


function valida_longitud2(){
	
   num_caracteres = $("#txtMENSAJE").val().length
   if (num_caracteres > num_caracteres_permitidos){ 
      $("#txtMENSAJE").val(contenido_textarea);
   }else{ 
      contenido_textarea = $("#txtMENSAJE").val()	
   } 
   if (num_caracteres >= (num_caracteres_permitidos-10)){ 
      $("#caracteres2").css({'color' : '#ff0000'}); 
   }else{ 
     $("#caracteres2").css({'color' : '#000000'}); 
   } 

   cuenta2() ;
} 
function cuenta2(){ 
   num_caracteres = $("#txtMENSAJE").val().length
   $("#caracteres2").val(num_caracteres); 
} 


function Valida(){
	var rd = $('input[name=tdest]:checked').val();
	var via = $('input[name=via]:checked').val();
	
	//sms
	if(rd==1){
		
	var curso = $("#cmbCURSO").val();
	var alumno =$("#cmbALUMNO").val();
	var apoderado = $("#cmbAPODERADO").val();
	var dato_apo = apoderado.split(",");
	var motivo = $("#cmbMOTIVO").val();
	cantidad = $("#txtSMS").length;
	
	if($("#cmbCURSO").val()==0 && $("#cmbALUMNO").val()==0 && $("#cmbAPODERADO").val()==0){
		if(confirm("ADVERTENCIA: Esta a punto de enviar un mensaje a cada apoderado del colegio")){  
			if($("#cmbMOTIVO").val()==0){
				alert("Debe seleccionar un motivo");
				$("#cmbMOTIVO").val();	
			}else if($("#txtSMS").val()==""){
				alert("Debe redactar el Mensaje");
				$("#txtSMS").focus();	
			}else{
				if(via==1){
					msg();	
				}
				if(via==2){
					
					mensajeTodosCol();
					
				}
				
			}
		}
	}else if($("#cmbCURSO").val()!=0 && $("#cmbALUMNO").val()==0 && $("#cmbAPODERADO").val()==0){
		if(confirm("ADVERTENCIA: Esta a punto de enviar un mensaje a cada apoderado del Curso")){  
			if($("#cmbMOTIVO").val()==0){
				alert("Debe seleccionar un motivo");
				$("#cmbMOTIVO").val();	
			}else if($("#txtSMS").val()==""){
				alert("Debe redactar el Mensaje");
				$("#txtSMS").focus();	
			}else{
				if(via==1){
					msg();
				}
				if(via==2){
				 mensajeTodosApo();
				}
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
			if(via==1){
			 msg();	
			}
			if(via==2){
				//mandar por comunicapp
			 mensajeUnUsuario();
			}
		}	
	}	
		
		}
		//mandar mensajes a grupos
	if(rd==2){
		
		var grupo = $("#gdes").val();
		var usuario = $("#desgrupo").val();
		var dato_apo = usuario.split(",");
		var motivo = $("#cmbMOTIVO").val();
		var cantidad = $("#txtSMS").length;
		
		if($("#gdes").val()==0){
			alert("Debe seleccionar grupo de usuarios");	
		$("#gdes").focus();
		}
		else{
		if($("#cmbMOTIVO").val()==0){
			alert("Debe seleccionar un motivo");
			$("#cmbMOTIVO").val();	
		}else if($("#txtSMS").val()==""){
			alert("Debe redactar el Mensaje");
			$("#txtSMS").focus();	
		}else{
			if(via==1){
			  msg2();	
			}else{
			 mensajeGrupo();
			}
		}	
	}
		
		
		}	
	
}

function VistaPrevia(id){
	var via = $('input[name=viab]:checked').val();
	var parametros="funcion=12&id="+id+"&via="+via;
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
	
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 
	    	if(data==0){
				alert("Mensaje Recepcionado");
				//Listado();
			}else{
				alert("ERROR EN ENVIO");
				//Listado();
			}	
		  }
	  })
	
}

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

function muetraDes(){
	 var rd = $('input[name=tdest]:checked').val();
	 if(rd==1){
		$(".grp").hide();
		$(".alu").show();
		$("#nvo").show();
		$("#env").show(); 
		}
		if(rd==2){
		$(".grp").show();
		$(".alu").hide();
		$("#nvo").show();
		$("#env").show(); 
		}
}

function BuscaGrupo(){
var funcion=18;	
var parametros="funcion="+funcion;
$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#grupo").html(data);
		  }
	  })	
}

function grupodes(){
var funcion=19;
var grupo = $("#gdes").val();	
var parametros="funcion="+funcion+"&grupo="+grupo;
$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#intg").html(data);
		  }
	  })	
}


function msg2(id){
	//alert("gro");
	var grupo = $("#gdes").val();
	var usuario = $("#desgrupo").val();
	var motivo = $("#cmbMOTIVO").val();
	var mensaje = $("#txtSMS").val();
	var parametros="funcion=20&grupo="+grupo+"&usuario="+usuario+"&motivo="+motivo+"&mensaje="+mensaje;
	
	 $('#tabla').html('<div><img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/loading.gif"/></div>');
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		  if(data==0){
			alert("Error de sistema, favor intente mas tarde");  
		  }else{
			  //Listado();
			<?php if($_SMS==15){?>
			 cuentaSMS();
			<?php }?>
		  }
		
		  }
	  })
		
}


function ValidaSMS(){

	
	var parametros="funcion=21";
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#validar").html(data);
		 
		 $("#validar").dialog({ 
					autoOpen:true,
					width:500,
					height:300,
					modal:true,
					buttons: {
						'Validar': function(){
						if($('#fechaval').val()=="" || $('#tipoval').val()==0 ){
							alert("complete todos los campos");
							
							return false;
						}
						else{
							ValSMSDia();
							}
						 
						  
						 //  $(this).dialog("close");	
						},
					    'Cerrar': function(){ $(this).dialog('close');}
					 }
			   });
		  }
	  })	
}

function  ValSMSDia(){
	var fecha=$('#fechaval').val();
	var motivo = $('#tipoval').val();
	
	
	var funcion =22;
	var parametros ="funcion="+funcion+"&motivo="+motivo+"&fecha="+fecha;
	$('.ui-dialog-buttonpane button:contains("Validar")').button().hide();
	$('#validar').html('<div align="center"><img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/loading.gif"/><br>Ejecutando proceso de validaci&oacute;n. Por favor espere.</div>');
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){ 
	  var codigos = data.split("/");
		//  alert("mensajes validados");
		$('#validar').html('<div align="center"><p><img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/OK.png" width="20" height="20"/> Total mensajes entregados: '+codigos[0]+'</p><p><img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Warning.png" width="20" height="20"/> Total mensajes en espera:'+codigos[1]+'</p>		<p><img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/NO.png" width="20" height="20"/> Total mensajes rechazados:'+codigos[2]+'</p></div>');
		   //$('#validar').dialog('close');
		  
		  /*  Listado();
			
			 cuentaSMS();*/
			 $('.ui-dialog-buttonpane button:contains("Cerrar")').button().click(function(){
			 //Listado();
			 <?php if($_SMS==15){?>
			 cuentaSMS();
			 <?php }?>
});
	  
	  
		  }
	  })
	
	
}


function AgregarPlantilla(){
	var parametros="funcion=24";
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#newplantilla").html(data);
		 $("#newplantilla").dialog({ 
					autoOpen:true,
					width:500,
					height:300,
					modal:true,
					buttons: {
						'Guardar': function(){
						if($('#txtMOTIVOP').val()==""){
							alert("Escriba t\xEDtulo de plantilla");
							$('#txtMOTIVOP').focus();
							return false;
						}
						else if($('#txtMENSAJE').val()==""){
							alert("Escriba contenido de plantilla");
							$('#txtMENSAJE').focus();
							return false;
						}
						   IngresarPlantilla();
						  
						   $(this).dialog("close");	
						},
					    'Cerrar': function(){ $(this).dialog('close');}
					 }
			   });
		  }
	  })
		
}

function IngresarPlantilla(){
	var titulo = $('#txtMOTIVOP').val();
	var mensaje = $('#txtMENSAJE').val();
	var parametros="funcion=25&titulo="+titulo+"&mensaje="+mensaje;
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	   		if(data == 0){
			   alert("Error al Guardar Datos");
			}else{
			  alert("Datos Guardados");
			  ListarPantilla();
			  return true;
			}
	  }
	  })
	
}

function ListarPantilla(){
	var parametros="funcion=26";
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		  $("#plantilla").html(data);
		  }
	  })	
}

function cargaPlantilla(idP){
	
	var parametros="funcion=27&idP="+idP;
	
	if(idP!=0){
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#txtSMS").val(getCleanedString(data).trim());
		 cuenta();
		  }
	  })
	}
}

function getCleanedString(cadena){
   // Definimos los caracteres que queremos eliminar
   var specialChars = "!#$^&%*()+=-[]\/{}|<>?.:";

   // Los eliminamos todos
   for (var i = 0; i < specialChars.length; i++) {
       cadena= cadena.replace(new RegExp("\\" + specialChars[i], 'gi'), '');
   }   

   // Lo queremos devolver limpio en minusculas
   cadena = cadena.toLowerCase();

   // Quitamos espacios y los sustituimos por _ porque nos gusta mas asi
  // cadena = cadena.replace(/ /g," ");

   // Quitamos acentos y "?". Fijate en que va sin comillas el primer parametro
   cadena = cadena.replace(/á/gi,"a");
   cadena = cadena.replace(/é/gi,"e");
   cadena = cadena.replace(/í/gi,"i");
   cadena = cadena.replace(/ó/gi,"o");
   cadena = cadena.replace(/ú/gi,"u");
   cadena = cadena.replace(/ñ/gi,"n");
   cadena = cadena.replace(/Á/gi,"A");
   cadena = cadena.replace(/É/gi,"E");
   cadena = cadena.replace(/Í/gi,"I");
   cadena = cadena.replace(/Ó/gi,"O");
   cadena = cadena.replace(/Ú/gi,"U");
   cadena = cadena.replace(/Ñ/gi,"N");
   return cadena;
}

function tipoSis(){
	var parametros="funcion=28&rbd="+<?php echo $_INSTIT ?>;
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#tsis").html(data);
		
		  }
	  })
	
}

function mensajeUnUsuario(){
var al=new Array();
var curso = $("#cmbCURSO").val();
var rbd = <?php echo $_INSTIT;?>;
var user = "<?php echo trim($_NOMBREUSUARIO) ?>";
var alu  = $("#cmbALUMNO").val();
al.push(alu);
var fecha ="<?php echo date("Y-m-d") ?>";
var hora = "<?php echo date("H:i:s") ?>";
var modo = "Alumno Especifico";
var user_name = "<?php echo ($_PERFIL==0)?"Admin SAE":trim($_USUARIOENSESION) ?>";
var user_type = $("#peri").val();
var texto = $("#txtSMS").val();

var token = $("#token").val();
var saldo = $("#salm").val();
var url2 = "https://www.comunicapp.cl/api_partners/EnvioAlumnoEspecifico";

 $.ajax({
            data: {'token': token, 'rbd':rbd, 'curso':curso, 'alumnos':al,'user': user, 'fecha':fecha,'hora':hora,'modo':modo,'user_name':user_name, 'user_type':user_type,'texto':texto},
            url: url2,
            xhrFields: {
                withCredentials: true
            },
            type: 'POST',
            success: function (response) {//resultado de la funci?nconsole
               // console.log(response);
				var jsonobj =JSON.parse(response);
				var registrados = jsonobj.respuesta.registrados.registrados;
				var no_registrados = jsonobj.respuesta.registrados.no_registrados;
				
				guardaMsg();
				
				if(registrados=="" && no_registrados!="")
				{
				
				<?php if ($_SMS==15 && $_COMUNICAPP==17){?>
					if(saldo>0){
						RevisarMensajesTodosApo(response,texto,cmbMOTIVO); 	   
					}
				}
				<?php }?>
				alert("Mensaje enviado");
            }
        });


}

function cargoEmp(){
	<?php if($_PERFIL==0){?>
	var usu =0;
	<?php }
	else{?>
	var usu = <?php echo $_NOMBREUSUARIO ?>;	
	<?php }?>
	
	var parametros="funcion=29&usu="+usu;
	
	
	$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	   $("#perd").html(data);
		
		  }
	  })
	
}
function guardaMsg(){
var al=new Array();
var curso = $("#cmbCURSO").val();
var rbd = <?php echo $_INSTIT;?>;
var user = <?php echo ($_PERFIL==0)?0:$_NOMBREUSUARIO ?>;
var alu  = $("#cmbALUMNO").val();
al.push(alu);
var destinatario = al;
	
var fecha ="<?php echo date("Y-m-d") ?>";
var hora = "<?php echo date("H:i:s") ?>";
var modo = "Alumno Especifico";
var user_name = "<?php echo ($_PERFIL==0)?"ADMIN SAE":trim($_USUARIOENSESION) ?>";
var user_type = $("#peri").val();
var texto = $("#txtSMS").val();
var token = $("#token").val();
var funcion = 30;
var tipomensaje = 1;
var mot = $("#cmbMOTIVO").val();

var parametros = "funcion="+funcion+"&token="+token+"&rbd="+rbd+"&curso="+curso+"&user="+user+"&fecha="+fecha+"&hora="+hora+"&modo="+modo+"&user_type="+user_type+"&texto="+texto+"&destinatario="+destinatario+"&tipomensaje="+tipomensaje+"&motivo="+mot;

$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  
		
		  }
	  })
}

function mensajeTodosApo(){
var al=new Array();
var curso = $("#cmbCURSO").val();
var rbd = <?php echo $_INSTIT;?>;
var user = <?php echo ($_PERFIL==0)?0:$_NOMBREUSUARIO ?>;
var user_name = "<?php echo ($_PERFIL==0)?"ADMIN SAE":trim($_USUARIOENSESION) ?>";
$("#cmbALUMNO option").each(function(){
   //alert('opcion '+$(this).text()+' valor '+ $(this).attr('value'))
    if($(this).attr('value')!=0){
		al.push($(this).attr('value'));
	}
});


var fecha ="<?php echo date("Y-m-d") ?>";
var hora = "<?php echo date("H:i:s") ?>";
var modo = "Alumno Especifico";
var user_type = $("#peri").val();
var texto = $("#txtSMS").val();

var token = $("#token").val();
var cmbMOTIVO = $("#cmbMOTIVO").val();
var saldo = $("#salm").val();
var url2 = "https://www.comunicapp.cl/api_partners/EnvioAlumnoEspecifico";
var tx='';
 $.ajax({
            data: {'token': token, 'rbd':rbd, 'curso':curso, 'alumnos':al,'user': user, 'fecha':fecha,'hora':hora,'modo':modo,'user_name':user_name, 'user_type':user_type,'texto':texto},
            url: url2,
            xhrFields: {
                withCredentials: true
            },
            type: 'POST',
            success: function (response) {//resultado de la funci?n
				console.log(response);
				guardaMensajeTodosApo();
				
				<?php if ($_SMS==15 && $_COMUNICAPP==17){?>
				if(saldo>0){
					22055568(response,texto,cmbMOTIVO); 	   tx='\nSe enviar\xe1 SMS a usuarios que no tienen aplicaci\xf3n instalada, favor espere... ';
				}
				<?php }?>
				alert("Mensaje enviado"+tx);
            }
        });


}

function guardaMensajeTodosApo(){
var al=new Array();
var curso = $("#cmbCURSO").val();
var rbd = <?php echo $_INSTIT;?>;
var user = <?php echo ($_PERFIL==0)?0:$_NOMBREUSUARIO ?>;
var user_name = "<?php echo ($_PERFIL==0)?"ADMIN SAE":trim($_USUARIOENSESION) ?>";

$("#cmbALUMNO option").each(function(){
 if($(this).attr('value')!=0){
		al.push($(this).attr('value'));
	}
});

var fecha ="<?php echo date("Y-m-d") ?>";
var hora = "<?php echo date("H:i:s") ?>";
var modo = "Alumno Especifico";
var user_name = "<?php echo trim($_USUARIOENSESION) ?>";
var user_type = $("#peri").val();
var texto = $("#txtSMS").val();
var token = $("#token").val();	
var mot = $("#cmbMOTIVO").val();
var funcion = 31;
var tipomensaje = 1;
	
	
var parametros = "funcion="+funcion+"&token="+token+"&rbd="+rbd+"&curso="+curso+"&user="+user+"&fecha="+fecha+"&hora="+hora+"&modo="+modo+"&user_type="+user_type+"&texto="+texto+"&destinatario="+al+"&tipomensaje="+tipomensaje+"&motivo="+mot;

$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	   
		
		  }
	  })
}

function mensajeTodosCol(){

//mandar mensaje a todo el colegio
var al=new Array();
var curso = 0;
var rbd = <?php echo $_INSTIT;?>;
var user = <?php echo ($_PERFIL==0)?0:$_NOMBREUSUARIO ?>;
var user_name = "<?php echo ($_PERFIL==0)?"ADMIN SAE":trim($_USUARIOENSESION) ?>";


var alu = $("#talu").val();
alu = alu.split(",");

for (x=0;x<alu.length;x++){
       al.push(alu[x]);
}

//al.push($(this).attr('value'));

var fecha ="<?php echo date("Y-m-d") ?>";
var hora = "<?php echo date("H:i:s") ?>";
var modo = "Alumno Especifico";
var user_type = $("#peri").val();
var texto = $("#txtSMS").val();

var token = $("#token").val();
var saldo = $("#salm").val();
var url2 = "https://www.comunicapp.cl/api_partners/EnvioAlumnoEspecifico";
var tx='';

//guardaMensajeTodosCol();
 $.ajax({
            data: {'token': token, 'rbd':rbd, 'curso':curso, 'alumnos':al,'user': user, 'fecha':fecha,'hora':hora,'modo':modo,'user_name':user_name, 'user_type':user_type,'texto':texto},
            url: url2,
            xhrFields: {
                withCredentials: true
            },
            type: 'POST',
            success: function (response) {//resultado de la funci?n
             console.log(response);
				 guardaMensajeTodosCol();
				 <?php if ($_SMS==15 && $_COMUNICAPP==17){?>
				if(saldo>0){
					RevisarMensajesTodosApo(response,texto,cmbMOTIVO); 	   tx='\nSe enviar\xe1 SMS a usuarios que no tienen aplicaci\xf3n instalada, favor espere... ';
				}
				<?php }?>
				alert("Mensaje enviado"+tx);
            }
        });

}
function guardaMensajeTodosCol(){
var al=new Array();
var curso = 0;
var rbd = <?php echo $_INSTIT;?>;
var user = <?php echo ($_PERFIL==0)?0:$_NOMBREUSUARIO ?>;
var user_name = "<?php echo ($_PERFIL==0)?"ADMIN SAE":trim($_USUARIOENSESION) ?>";


var alu = $("#talu").val();
alu = alu.split(",");

for (x=0;x<alu.length;x++){
       al.push(alu[x]);
}

//al.push($(this).attr('value'));
var fecha ="<?php echo date("Y-m-d") ?>";
var hora = "<?php echo date("H:i:s") ?>";
var modo = "Alumno Especifico";
var user_type = $("#peri").val();
var texto = $("#txtSMS").val();
var token = $("#token").val();	
var funcion = 32;
var tipomensaje = 1;
var mot = $("#cmbMOTIVO").val();
	
	
var parametros = "funcion="+funcion+"&token="+token+"&rbd="+rbd+"&curso="+curso+"&user="+user+"&fecha="+fecha+"&hora="+hora+"&modo="+modo+"&user_type="+user_type+"&texto="+texto+"&destinatario="+al+"&tipomensaje="+tipomensaje+"&motivo="+mot;

$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	   
		
		  }
	  })	
}

function TodosAlusCol(){
var funcion = 33;
var parametros = "funcion="+funcion;
$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		$("#malu").html(data);
		  }
	  })
}

function mensajeGrupo(){
var grupo = $("#gdes").val();
var inte  = $("#desgrupo").val();
var ca="";
var al=new Array();
var curso = 0;
var rbd = <?php echo $_INSTIT;?>;
var user = <?php echo ($_PERFIL==0)?0:$_NOMBREUSUARIO ?>;
var user_name = "<?php echo ($_PERFIL==0)?"ADMIN SAE":trim($_USUARIOENSESION) ?>";
//mando mensajes
var fecha ="<?php echo date("Y-m-d") ?>";
var hora = "<?php echo date("H:i:s") ?>";
var modo = "Alumno Especifico";
var user_type = $("#peri").val();
var texto = $("#txtSMS").val();

var token = $("#token").val();
var saldo = $("#salm").val();
var url2 = "https://www.comunicapp.cl/api_partners/EnvioAlumnoEspecifico";

	if(grupo==0){
			alert("Debe seleccionar un grupo");
	}
	else{
		//a desarmar el combo de 
		if(inte==0){
			
			$("#desgrupo option").each(function(){
			 if($(this).attr('value')!=0){
				 ca = $(this).attr('value').split(",");
					al.push(ca[0]);
				}
			});
		}
		//mensaje solo a 1 integrante del grupo
		else{
			ca = $("#desgrupo").val().split(",");
					al.push(ca[0]);
		}
		
		
 $.ajax({
            data: {'token': token, 'rbd':rbd, 'curso':curso, 'alumnos':al,'user': user, 'fecha':fecha,'hora':hora,'modo':modo,'user_name':user_name, 'user_type':user_type,'texto':texto},
            url: url2,
            xhrFields: {
                withCredentials: true
            },
            type: 'POST',
            success: function (response) {//resultado de la funci?n
                 console.log(response);
				 guardaMensajeGrupo();
				alert("Mensaje enviado");
            }
        });
	
	}

}

function guardaMensajeGrupo(){
var funcion=32;
var grupo = $("#gdes").val();
var inte  = $("#desgrupo").val();
var ca="";
var al=new Array();
var curso = 0;
var rbd = <?php echo $_INSTIT;?>;
var user = <?php echo ($_PERFIL==0)?0:$_NOMBREUSUARIO ?>;
var user_name = "<?php echo ($_PERFIL==0)?"ADMIN SAE":trim($_USUARIOENSESION) ?>";
//mando mensajes
var fecha ="<?php echo date("Y-m-d") ?>";
var hora = "<?php echo date("H:i:s") ?>";
var modo = "Alumno Especifico";
var user_type = $("#peri").val();
var texto = $("#txtSMS").val();
var tipomensaje = 1;
var token = $("#token").val();
var mot = $("#cmbMOTIVO").val();


	if(grupo==0){
			
	}
	else{
		//a desarmar el combo de 
		if(inte==0){
			
			$("#desgrupo option").each(function(){
			 if($(this).attr('value')!=0){
				 ca = $(this).attr('value').split(",");
					al.push(ca[0]);
				}
			});
		}
		//mensaje solo a 1 integrante del grupo
		else{
			ca = $("#desgrupo").val().split(",");
					al.push(ca[0]);
		}
		
	var parametros = "funcion="+funcion+"&token="+token+"&rbd="+rbd+"&curso="+curso+"&user="+user+"&fecha="+fecha+"&hora="+hora+"&modo="+modo+"&user_type="+user_type+"&texto="+texto+"&destinatario="+al+"&tipomensaje="+tipomensaje+"&motivo="+mot;	
		
		$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  
		
		  }
	  })
 
	
	}

}

function filtro2(){
	var funcion =10;
	var desde  = $("#bdesde").val();
	var hasta = $("#basta").val();
	var motivo = $("#cmbMOTIVOB").val();
	var via = $('input[name=viab]:checked').val();
	var modulo = $("#mobuloB").val();
	if(via==undefined){
		alert("Debe seleccionar sistema");
	}else{
		var parametros = "funcion="+funcion+"&desde="+desde+"&hasta="+hasta+"&motivo="+motivo+"&via="+via+"&modulo="+modulo;
		$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  
		  }
	  })
	}
}

function RevisarMensajesTodosApo(response,texto,cmbMOTIVO){
var funcion = 36;
var parametros =  "funcion="+funcion+"&respuesta="+response+"&texto="+texto+"&motivo="+cmbMOTIVO;
$.ajax({
	  url:'cont_sms.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  alert("Mensajes SMS Enviados");
		 
		  }
	  })
}
</script>

<style>
textarea{
padding-top:0;
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
-ms-box-sizing: border-box;
-o-box-sizing: border-box;
box-sizing: border-box;
}
div.ui-datepicker{
 font-size:10px;
}



</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr><td>
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
                            <td align="left" valign="top"></td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> <span id="tsis"></span><span id="perd"></span>                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="200" valign="top"><!-- inicio codigo antiguo -->
                                 
<table width="650" border="1" style="border-collapse:collapse" align="center">
<tr class="tableindex">
  <td colspan="4" height="31">Filtrar mensajes</td>
  </tr>
<tr>
  <td width="25%" class="cuadro02">Fecha</td>
  <td width="30%">
    <input type="text" name="bdesde" id="bdesde"></td>
  <td width="5%" class="cuadro02"><div align="center">a</div></td>
  <td width="40%"><input type="text" name="basta" id="basta"></td>
  </tr>
<tr>
  <td class="cuadro02">Motivo</td>
<td><span id="motivo2"> 
		<select name="cmbMOTIVOB" id="cmbMOTIVOB">
				<option value="0">seleccione...</option>
		</select>
			</span> </td>
  <td class="cuadro02" style="visibility:<?=($_SMS!=0 && $_COMUNICAPP!=0)?'visible':'hidden';?>"><div align="center">V&iacute;a</div></td>
  <td class="cuadro01" style="visibility:<?=($_SMS!=0 && $_COMUNICAPP!=0)?'visible':'hidden';?>">
	<?php if($_SMS==15){
									$chs = ($_SMS==15 && $_COMUNICAPP==0)?"checked":"";	 
										 ?>    <input name="viab" type="radio" id="viab1" value="1" <?php echo $chs?>>
                                    SMS <?php }?> 
                                         <?php if($_COMUNICAPP==17){
											 $chc = ($_SMS==0 && $_COMUNICAPP==17)?"checked":"";	 
											 ?>
                                         <input name="viab" type="radio" id="viab2" value="2" <?php echo  $chc?>> Comunicapp
                                     <?php  }?></td> 
  </tr>
<tr>
  <td class="cuadro02">M&oacute;dulo</td>
  <td colspan="3"> 
    <select name="mobuloB" id="mobuloB">
      <option value="0">Seleccione</option>
      <option value="1">Comunicaciones</option>
      <option value="2">Anotaciones</option>
      <option value="3">Atrasos</option>
      <option value="4">Asistencia</option>
      <option value="5">Citaci&oacute;n</option>
    </select></td>
  
  </tr>
	<tr><td colspan="4" align="right"><input type="button" class="botonXX" value="Filtrar Mensajes" onclick="Listado();">
</table><br>
<br>

								  <br>
<div id="cnt">
						  			<table width="650" border="1" style="border-collapse:collapse" align="center">
                                      <tr>
                                        <td width="112" class="cuadro02">A&Ntilde;O</td>
                                        <td width="27" class="cuadro02">&nbsp;:&nbsp;</td>
                                        <td width="100" class="cuadro01" >&nbsp;<input id="salm" type="hidden"><div id="nroano"></div></td><td align="right" bgcolor="#cccccc"><span id="sal" style="text-align:right; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10px"></span></td>
                                      </tr>
                                      <tr >
                                        <td class="cuadro02">DESTINATARIOS</td>
                                        <td class="cuadro02">:</td>
                                        <td colspan="2" class="cuadro01" ><input type="radio" name="tdest" id="tdest1" value="1" onClick="muetraDes()">
                                          Apoderados 
                                            <input type="radio" name="tdest" id="tdest2" value="2" onClick="muetraDes()">
                                            Grupos</td>
                                        </tr>
                                      <tr class="grp">
                                        <td class="cuadro02">GRUPO</td>
                                        <td class="cuadro02">:</td>
                                        <td colspan="2" class="cuadro01" >
                                        <div id="grupo">
                                        <select name="gdes" id="gdes" onChange="grupodes()">
                                        <option value="0">seleccione...</option>
                                        </select>
                                        </div></td>
                                        </tr>
                                      <tr class="grp">
                                        <td class="cuadro02">INTEGRANTE</td>
                                        <td class="cuadro02">:</td>
                                        <td colspan="2" class="cuadro01" >
                                        <div id="intg">
                                        <select name="desgrupo" id="desgrupo" >
                                        <option value="0">seleccione...</option>
                                        </select>
                                        </div></td>
                                      </tr>
                                      <tr class="alu">
                                        <td class="cuadro02">CURSO</td>
                                        <td class="cuadro02">&nbsp;:&nbsp;</td>
                                        <td colspan="2" class="cuadro01"><div id="curso">
                                        <select name="cmbCURSO" id="cmbCURSO" onChange="BuscaApoderado()">
                                            <option value="0">seleccione...</option>
                                         </select>
                                        </div>
                                        </td>
                                      </tr>
                                      <tr class="alu">
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
                                      <tr class="alu">
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
                                       <tr >
                                        <td class="cuadro02">MOTIVO</td>
                                        <td class="cuadro02">&nbsp;:&nbsp;</td>
                                        <td width="100" class="cuadro01" colspan="2"><span id="motivo"> 
                                        	<select name="cmbMOTIVO" id="cmbMOTIVO">
                                            	<option value="0">seleccione...</option>
	                                        </select>
                                            </span> 
                                         
                                          <img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" onClick="AgregarMotivo()">                                     
                                        </td>
                                      </tr>
                                       <tr class="pln" >
                                         <td class="cuadro02">PLANTILLA</td>
                                         <td class="cuadro02">:</td>
                                         <td class="cuadro01" colspan="2"><span id="plantilla">
                                           <select name="cmbPLANTILLA" id="cmbPLANTILLA">
                                             <option value="0">seleccione...</option>
                                           </select>
                                         </span> <img src="../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" onClick="AgregarPlantilla()"></td>
                                       </tr>
                                       
                                      
                               
                                       <tr class="pln" style="visibility:<?=($_SMS!=0 && $_COMUNICAPP!=0)?'visible':'hidden';?>"  >
                                         <td class="cuadro02">VIA</td>
                                         <td class="cuadro02">:</td>
                                         <td class="cuadro01" colspan="2">
                 
                                      
                                     <?php if($_SMS==15){
									$chs = ($_SMS==15 && $_COMUNICAPP==0)?"checked":"";	 
										 ?>    <input name="via" type="radio" id="via1" value="1" <?php echo $chs?>>
                                    SMS <?php }?> 
                                         <?php if($_COMUNICAPP==17){
											 $chc = ($_SMS==0 && $_COMUNICAPP==17)?"checked":"";	 
											 ?>
                                         <input name="via" type="radio" id="via2" value="2" <?php echo  $chc?>> Comunicapp
                                     <?php  }?>
                                          </td>
                                       </tr>
                                       <tr>
                                        <TD colspan="4" align="right" class="cuadro02"> <div align="right">
                                        <input type="button" id="env" value="Enviar Mensaje" onClick="Valida();" class="botonXX">
                                        <input type="button" id="nvo" value="Nuevo Mensaje" onClick="NuevoSMS();" class="botonXX">
                                       
                                        <input type="button" id="nvo" value="Validar Mensajes SMS" onClick="ValidaSMS();" class="botonXX">
                                      
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
                                    <div id="tabla" align="center">
                                      <!--<select name="cmbMOTIVO2" id="cmbMOTIVO2">
                                        <option value="0">seleccione...</option>
                                      </select>-->
                                      &nbsp;</div>
                                    <div id="newmotivo">&nbsp;</div>
                                    <div id="vista">&nbsp;</div>
                                    <div id="vistaprevia" title="Vista Previa SMS">&nbsp;</div>
                                    <div id="estadistica" title="Estadistica SMS">&nbsp;</div>
                                    <div id="validar" title="Validar SMS">&nbsp;</div>
                                     <div id="tval">&nbsp;</div>
                                     <div id="newplantilla" title="Ingresar nueva plantilla"></div>
                                     <div id="malu"></div>
			  
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
