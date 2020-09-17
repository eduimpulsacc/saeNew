<?php require('../../../../../util/header.inc');

//var_dump($_SESSION);

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP			=5;
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die("Select Fallo: ".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<link  rel="shortcut icon" href="../../../../../images/icono_sae_33.png">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/themes/smoothness/jquery.ui.all.css">
<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.core.js"></script>
<!--<script type="text/javascript" src="../../../../../util/chkform.js"></script>
-->
<script language="javascript">
$(document).ready(function() {
	curso();
	cursoI();
	asunto();
	cargoEmp();
	
	<?php /*if($_PERFIL==17){?>
	apoderado($("#cmbCURSO").val());
	
	<?php }*/?>
 	
	
	
 });
function utf8_encode(argString) {
  //  discuss at: http://phpjs.org/functions/utf8_encode/
  // original by: Webtoolkit.info (http://www.webtoolkit.info/)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: sowberry
  // improved by: Jack
  // improved by: Yves Sucaet
  // improved by: kirilloid
  // bugfixed by: Onno Marsman
  // bugfixed by: Onno Marsman
  // bugfixed by: Ulrich
  // bugfixed by: Rafal Kukawski
  // bugfixed by: kirilloid
  //   example 1: utf8_encode('Kevin van Zonneveld');
  //   returns 1: 'Kevin van Zonneveld'

  if (argString === null || typeof argString === 'undefined') { 
    return '';
  }

  var string = (argString + ''); // .replace(/\r\n/g, "\n").replace(/\r/g, "\n");
  var utftext = '',
    start, end, stringl = 0;

  start = end = 0;
  stringl = string.length;
  for (var n = 0; n < stringl; n++) {
    var c1 = string.charCodeAt(n);
    var enc = null;

    if (c1 < 128) {
      end++;
    } else if (c1 > 127 && c1 < 2048) {
      enc = String.fromCharCode(
        (c1 >> 6) | 192, (c1 & 63) | 128
      );
    } else if ((c1 & 0xF800) != 0xD800) {
      enc = String.fromCharCode(
        (c1 >> 12) | 224, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
      );
    } else { // surrogate pairs
      if ((c1 & 0xFC00) != 0xD800) {
        throw new RangeError('Unmatched trail surrogate at ' + n);
      }
      var c2 = string.charCodeAt(++n);
      if ((c2 & 0xFC00) != 0xDC00) {
        throw new RangeError('Unmatched lead surrogate at ' + (n - 1));
      }
      c1 = ((c1 & 0x3FF) << 10) + (c2 & 0x3FF) + 0x10000;
      enc = String.fromCharCode(
        (c1 >> 18) | 240, ((c1 >> 12) & 63) | 128, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128
      );
    }
    if (enc !== null) {
      if (end > start) {
        utftext += string.slice(start, end);
      }
      utftext += enc;
      start = end = n + 1;
    }
  }

  if (end > start) {
    utftext += string.slice(start, stringl);
  }

  return utftext;
}
function cargartabla(){

	var parametros ="funcion=1";
	
	$.ajax({
		url:'cont_citacion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				$("#buscador").html(data);	
			}
		}
	})
}
function curso(ano){
	var ano =$("#cmbANO").val();
	var parametros ="funcion=1&ano="+ano;
	
	$.ajax({
		url:'cont_citacion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				$("#curso").html(data);	
			}
		}
	})
}

function cursoI(){
	var ano =$("#cmbANO").val();
	var parametros ="funcion=13&ano="+ano;
	
	$.ajax({
		url:'cont_citacion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				$("#cursoi").html(data);	
			}
		}
	})
}

function apoderado(curso){
	var parametros ="funcion=2&curso="+curso;
	
	$.ajax({
		url:'cont_citacion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				$("#apoderado").html(data);	
			}
		}
	})
}


function apoderadoI(){
		var curso =$("#cmbCURSOI").val();
		//alert(curso);
		//alert("paso");
		if(curso!=0){
			curso=curso
			}else{
			curso=0;
			}
		
	var parametros ="funcion=14&curso="+curso;
	
	$.ajax({
		url:'cont_citacion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				$("#apoI").html(data);	
			}
		}
	});
	
		
}


function asunto(){
	var rdb =<?php echo $institucion ?>;
	var parametros ="funcion=12&rdb="+rdb;
	
	$.ajax({
		url:'cont_citacion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				$("#asunto").html(data);	
			}
		}
	})
}






function listado(){
	$("#citacion").html("");
	var ano =$("#cmbANO").val();
	var curso =$("#cmbCURSO").val();
	var apoderado =$("#cmbAPODERADO").val();
	var asunto =$("#cmbASUNTO").val();
	var parametros ="funcion=3&curso="+curso+"&ano="+ano+"&apoderado="+apoderado+"&asunto="+asunto;
	
	$.ajax({
		url:'cont_citacion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				$("#tabla").html(data);	
			}
		}
	})
}

function agregar(){
	
	
	var ano =$("#cmbANO").val();
	var curso =$("#cmbCURSO").val();
	var alumno =$("#cmbALUMNO").val();
	var parametros ="funcion=4&curso="+curso+"&ano="+ano+"&rut_alumno="+alumno;
	
	$.ajax({
		url:'cont_citacion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//console.log(data);
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				$("#citacion").html(data);	
			}
		}
	})
}

function guardar(){
	var ano 	= $("#cmbANO").val();
	var curso 	= $("#cmbCURSOI").val();
	var apoderado 	= $("#cmbAPODERADOI").val();
	var fecha 	= $("#txtFECHAS").val();
	var hora= $("#txtHORAINGRESO").val();
	var mensaje = $("#txtOBSI").val();
	var asunto	= $("#cmbASUNTOI").val();
	var empleado	= $("#cmbEmpleadoI").val();
	var alumno =$("#cmbALUMNO").val();
	var emptext=$("#cmbEmpleadoI option:selected").text().trim();
		
		
		
		var parametros = "funcion=5&ano="+ano+"&curso="+curso+"&apoderado="+apoderado+"&fecha="+fecha+"&hora="+hora+"&mensaje="+mensaje+"&asunto="+asunto+"&empleado="+empleado;
		
		$.ajax({
		url:'cont_citacion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//console.log(data);
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				//aqui mando el mensaje
				listado();
				<?php if($_COMUNICAPP==17){?>
				SendMessage(fecha,hora,mensaje,curso,emptext,apoderado);
				<?php }?>
				
			}
		}
		})
}
function elimina(id){
	var parametros="funcion=6&id="+id;
	if(confirm("¿Esta seguro de eliminar esta citación?")){
	$.ajax({
	url:'cont_citacion.php',
	data:parametros,
	type:'POST',
	success:function(data){
		//console.log(data);
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{
			listado();
		}
	}
	})	
	}
}

function mostrar11(id){
	//alert("llego");
	var parametros="funcion=7&id="+id;
	
	$.ajax({
	url:'cont_citacion.php',
	data:parametros,
	type:'POST',
	success:function(data){
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{
			$("#muestra").html(data);
			$("#muestra").dialog({
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
				}
				});
		}
	}
	})	
}
function modifica(id){
	var parametros="funcion=8&id="+id;
	
	$.ajax({
	url:'cont_citacion.php',
	data:parametros,
	type:'POST',
	success:function(data){
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{
			$("#tabla").html(data);	
		}
	}
	})
}

function guarda_modifica(){
		//alert("pase");
	
		var ano 	= $("#cmbANO").val();
		var curso 	= $("#cmbCURSOI").val();
		var fecha 	= $("#txtFECHAS").val();
		var hora= $("#txtHORAINGRESO").val();
		var mensaje = "MODIFCACION CITACION: "+utf8_encode($("#txtOBS").val());
		var asunto	= $("#cmbASUNTOI").val();
		var empleado	= $("#cmbEmpleado").val();
		var id		= $("#id").val();
		
		var parametros = "funcion=9&ano="+ano+"&curso="+curso+"&apoderado="+apoderado+"&fecha="+fecha+"&hora="+hora+"&mensaje="+mensaje+"&asunto="+asunto+"&empleado="+empleado+"&id="+id;
	
	
		$.ajax({
		url:'cont_citacion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//console.log(data);
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				
				listado();
				<?php if($_COMUNICAPP==17){?>
				 SendMessageMod(fecha,hora,mensaje);
				<?php }else{?>
				alert("DATOS MODIFICADOS");	
				<?php }?>
				//mostrar11(id)
			}
		}
		})
}

function IngresoPatologia(){
	$("#formulario_clas").html('<br><form name="ingresoClas" id="ingresoClas" ><table><tr><td width="180"><label>Nombre:</label></td><td width="174"><input name="nombre_clas" id="nombre_clas" type="text" size="15" maxlength="30" /></td></tr></table></form>');
		   
	$("#formulario_clas").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 400,
   Height: 300,
   minWidth: 400,
   minHeight: 300,
   maxWidth: 400,
   maxHeight: 300,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
	 "Guardar Datos": function(){
		 if($('#nombre_clas').val()==0){
			alert("Escriba Asunto");
			$('#nombre_clas').focus();
			return false;
		}
		   ingresar_Pat();
		  
		   $(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }) 
		   
  }
function ingresar_Pat(){
	
var parametros = "funcion=10&nombre="+$("#nombre_clas").val();
  $.ajax({
	url:"cont_citacion.php",
	data:parametros,
	type:'POST',
	success:function(data){
			if(data == 0){
			   alert("Error al Guardar Datos");
			}else{
			  alert("Datos Guardados");
			  cargaselectClas();
			  return true;
			}
		}
	}) 
  }		  
function cargaselectClas(){
var parametros="funcion=11";
	$.ajax({
	url:'cont_citacion.php',
	data:parametros,
	type:'POST',
	success:function(data){
	//alert(data);
		if(data==0){
		alert("Error al Cargar");
		}else{
			$('#patologia').html(data);
			
			}
		 }
	 })
} // fin funcion cargartabla	

function marca(id,estado){
	var es=(estado==1)?"PRESENTE":"AUSENTE";
	
	
	
	if(confirm("Desea cambiar estado a "+es+"?")){
var parametros="funcion=15&id="+id+"&est="+estado;
	$.ajax({
	url:'cont_citacion.php',
	data:parametros,
	type:'POST',
	success:function(data){
	//alert(data);
		if(data==0){
		alert("Error al Cargar");
		}else{
			listado();
			
			}
		 }
	 })
	}
}

function SendMessage(ff,hh,mm,cc,ee,aa){
var curso = cc;
var apo = aa;
var al=new Array();
var ano = <?php echo $_ANO ?>;
var funcion = 16;
var user = <?php echo ($_PERFIL==0)?0:$_NOMBREUSUARIO ?>;
var modo = "Alumno Especifico";
var user_name = "<?php echo ($_PERFIL==0)?"Admin SAE":trim($_USUARIOENSESION) ?>";
var user_type = $("#peri").val();
var token = $("#token").val();
var rbd=<?php echo $_INSTIT ?>;
var tipomensaje = 5;
var fecha2="<?php echo date("Y-m-d") ?>";
var hora2="<?php echo date("H:i:s") ?>";
var texto="Citacion a establecimiento de "+ee+" el día "+ff+" a las "+hh+" hrs. Motivo Citacion: "+mm;
var tipo_mensaje=5;
var mot = $("#cmbASUNTOI").val();

var url2 = "https://www.comunicapp.cl/api_partners/EnvioAlumnoEspecifico";



var parametros = "funcion="+funcion+"&ano="+ano+"&curso="+curso+"&apo="+apo;

			$.ajax({
				url:'cont_citacion.php',
				data:parametros,
				type:'POST',
				success:function(data){
				console.log(data);
				
				var alu = data.split(',');
				for (x=0;x<alu.length;x++){
					al.push(alu[x]);
				}
	
	//alert(al);
	
		$.ajax({
            data: {'token': token, 'rbd':rbd, 'curso':curso, 'alumnos':al,'user': user, 'fecha':fecha2,'hora':hora2,'modo':modo,'user_name':user_name, 'user_type':user_type,'texto':texto},
            url: url2,
            xhrFields: {
                withCredentials: true
            },
            type: 'POST',
            success: function (response) {//resultado de la funci?nconsole
              console.log(response);
				var jsonobj =JSON.parse(response);
				var registrados = jsonobj.respuesta.registrados.registrados;
				var no_registrados = jsonobj.respuesta.registrados.no_registrados;
				
				var envio = jsonobj.respuesta.send;
				var err = jsonobj.respuesta.err;
			
			//si el mensaje se mando
			if(envio==true){
				
				var registrados2 = jsonToText(registrados);
				registrados2 = registrados2.slice(0, -1);
				
				var parametros2 = "funcion=18&token="+token+"&rbd="+rbd+"&curso="+curso+"&user="+user+"&fecha="+fecha2+"&hora="+hora2+"&modo="+modo+"&user_type="+user_type+"&texto="+texto+"&destinatario="+registrados2+"&tipomensaje="+tipomensaje+"&motivo="+mot;
				
				//alert (registrados2);
			
			$.ajax({
				  url:'cont_citacion.php',
				  data:parametros2,
				  type:'POST',
				  success:function(data){
				  console.log(data);
					alert("Mensaje enviado");
					  }
				  })
				
				
				}
				else{
				alert("Mensaje no enviado. Contacte al administrador de la plataforma.");
				}
            }
        }); //fin envio comunicapp
	
		 }
	 })

}
function cargoEmp(){
	<?php if($_PERFIL==0){?>
	var usu =0;
	<?php }
	else{?>
	var usu = <?php echo $_NOMBREUSUARIO ?>;	
	<?php }?>
	
	var parametros="funcion=17&usu="+usu;
	
	
	$.ajax({
	  url:'cont_citacion.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	   $("#perd").html(data);
		
		  }
	  })
	
}


function jsonToText (json) {
    var retText = '';

    if (typeof json == "object") {
        if (json instanceof Array) {
            $.each(json, function (key, val) {
                retText += jsonToText(val);
            });
        }
        else {
            $.each(json, function (key, val) {
				retText += jsonToText (val);
               
            });
        }
    }
    else {
        retText += json.toString() + ",";
    }

    return retText;
}


function SendMessageMod(ff,hh,mm){
var curso = $("#cmbCURSO").val();
var apo = $("#cmbAPODERADO").val();
var al=new Array();
var ano = <?php echo $_ANO ?>;
var funcion = 16;
var user = <?php echo ($_PERFIL==0)?0:$_NOMBREUSUARIO ?>;
var hora = "<?php echo date("H:i:s") ?>";
var modo = "Alumno Especifico";
var user_name = "<?php echo ($_PERFIL==0)?"Admin SAE":trim($_USUARIOENSESION) ?>";
var user_type = $("#peri").val();
var mensaje = $("#txtOBS").val();
var user_type = $("#peri").val();
var token = $("#token").val();
var rbd=<?php echo $_INSTIT ?>;
var fecha ="<?php echo date("Y-m-d") ?>";
var tipomensaje = 5;
var fecha2="<?php echo date("Y-m-d") ?>";
var hora2="<?php echo date("H:i:s") ?>";
var texto="MODIFICACION: Citacion a establecimiento de "+$("#cmbEmpleado option:selected").text().trim()+" el día "+$("#txtFECHAS").val()+" a las "+$("#txtHORAINGRESO").val()+" hrs. Motivo Citacion: "+mensaje;
var tipo_mensaje=5;
var mot = $("#cmbASUNTOI").val();

var url2 = "https://www.comunicapp.cl/api_partners/EnvioAlumnoEspecifico";

var parametros = "funcion="+funcion+"&ano="+ano+"&curso="+curso+"&apo="+apo;

			$.ajax({
				url:'cont_citacion.php',
				data:parametros,
				type:'POST',
				success:function(data){
				//console.log(data);
				
				var alu = data.split(',');
				for (x=0;x<alu.length;x++){
					al.push(alu[x]);
			}
	
	//alert(al);
	
		$.ajax({
            data: {'token': token, 'rbd':rbd, 'curso':curso, 'alumnos':al,'user': user, 'fecha':fecha,'hora':hora,'modo':modo,'user_name':user_name, 'user_type':user_type,'texto':texto},
            url: url2,
            xhrFields: {
                withCredentials: true
            },
            type: 'POST',
            success: function (response) {//resultado de la funci?nconsole
               //console.log(response);
				var jsonobj =JSON.parse(response);
				var registrados = jsonobj.respuesta.registrados.registrados;
				var no_registrados = jsonobj.respuesta.registrados.no_registrados;
				
				var envio = jsonobj.respuesta.send;
				var err = jsonobj.respuesta.err;
			
			//si el mensaje se mando
			if(envio==true){

				var parametros2 = "funcion=18&token="+token+"&rbd="+rbd+"&curso="+curso+"&user="+user+"&fecha="+fecha+"&hora="+hora+"&modo="+modo+"&user_type="+user_type+"&texto="+texto+"&destinatario="+al+"&tipomensaje="+tipomensaje+"&motivo="+mot;
				
			$.ajax({
				  url:'cont_citacion.php',
				  data:parametros2,
				  type:'POST',
				  success:function(data){
						alert("DATOS MODIFICADOS");
					  }
				  })
				
				
				}
				else{
				alert("Mensaje no enviado. Contacte al administrador de la plataforma.");
				}
            }
        }); //fin envio comunicapp
	
		 }
	 })

}
</script>
 <style>
.ui-resizable-se {
bottom: 17px;
}
</style>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
           <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr><td>
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="73" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?php $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="200" valign="top">
                                  <!-- inicio codigo antiguo -->
                                 
                                  <br />

                                  <table width="90%" border="0" align="center" style="border-collapse:collapse">
                                      <tr>
                                        <td class="textonegrita">AÑO</td>
                                        <td class="textosimple">&nbsp;
                                       <?php  if($_PERFIL !=17){?>
                                        
                                        <? $sql="SELECT id_ano, nro_ano,situacion FROM ano_escolar WHERE id_institucion=".$institucion." ORDER BY nro_ano ASC";
		$rs_ano = pg_exec($conn,$sql) or die("ERROR".$sql);
		?>
                                        <select name="cmbANO" id="cmbANO" onchange="curso(this.value);asunto(this.value);cursoI(this.value)">
                                        <? for($i=0;$i<pg_numrows($rs_ano);$i++){
                                                $fila_ano = pg_fetch_array($rs_ano,$i);
                                                if($fila_ano['situacion']==1){
                                        ?>
                                            <option value="<?=$fila_ano['id_ano'];?>" selected="selected"><?=$fila_ano['nro_ano'];?></option>	
                                        <? }else{?>
                                            <option value="<?=$fila_ano['id_ano'];?>" ><?=$fila_ano['nro_ano'];?></option>	
                                        <? } 
                                        }?>
                                        </select>
                                        <?php }else{
											$sa= "SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
		$ra = pg_exec($conn,$sa);
										echo pg_result($ra,0); 
											
											?>
                                        <input name="cmbANO" type="hidden" id="cmbANO" value="<?php echo $ano ?>" />  
                                        <?php echo $nro_ano; }?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">CURSO</td>
                                      
                                        <td class="textosimple"> &nbsp; <?php  /*if($_PERFIL !=17){*/?>
                                        <div id="curso">
                                        
                                        <select name="cmbCURSO" id="cmbCURSO">
                                        	<option value="0">seleccione...</option>
                                         </select>
                                        </div>
                                        <?php
                                       /* }else{
											?>
										<input name="cmbCURSO" type="hidden" id="cmbCURSO" value="<?php echo $_CURSO ?>" /> <?php 
										$sc= "SELECT grado_curso ||'-'|| letra_curso ||' '|| nombre_tipo AS curso, ensenanza FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza=tipo_ensenanza.cod_tipo WHERE id_curso=".$_CURSO." ORDER BY ensenanza,curso ASC";
		$rc = pg_exec($conn,$sc);
										echo pg_result($rc,0); ?>
										<?php }*/?></td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">APODERADO</td>
                                        <td>
                                        <div id="apoderado">&nbsp;
                                        <select name="cmbAPODERADO" id="cmbAPODERADO">
                                        	<option value="0">seleccione...</option>
                                         </select>
                                         </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">ASUNTO</td>
                                        <td><div id="asunto">&nbsp;
                                          <select name="cmbASUNTO" id="cmbASUNTO">
                                            <option value="0">seleccione...</option>
                                          </select>
                                        </div></td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">&nbsp;</td>
                                        <td><span id="perd"></span></td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">&nbsp;</td>
                                        <td align="right"><input type="submit" name="btnBusca" id="btnBusca" value="BUSCAR" class="botonXX" onclick="listado()"/></td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" class="textonegrita"><input type="submit" name="button" id="button" value="AGREGAR"  class="botonXX" onclick="agregar();cursoI();"/></td>
                                      </tr>
                                    </table>
                                     <div id="citacion">&nbsp;</div><br />
								  <div id="buscador">&nbsp;</div><br />
								  <div id="tabla">&nbsp;</div>
                                  <div id="muestra" title="Detalle de Citación"></div>
								  <!-- fin codigo -->
								   </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
      </td>
      </tr></table>
</body>
</html>
