<?
require('../../../../../../util/header.inc');




foreach($_REQUEST as $nombre_campo => $valor){
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
   eval($asignacion);
}


 	
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	/*$curso			= $curso;	
	$ramo 			= $ramo;*/
	
	  
	
	$_POSP           =6;
$_bot            = 5;
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="../../../../../clases/jquery-ui-1.8.14.custom/development-bundle/demos/demos.css">
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>


<script type="text/javascript">
$( document ).ready(function() {
   cargaHA(<?php echo $curso?>,<?php echo $ramo ?>);
});
function cargaHA(curso,ramo){

	var parametros="funcion=1&curso="+curso+"&ramo="+ramo;
	//alert(parametros);
	$.ajax({
				url:'cont_bitacora.php',
				data:parametros,
				type:'POST',
				success:function(data){
				$("#bitacora").html(data);
		  }
		});

	 /* $.ajax({
	  url:'bitacora/cont_bitacora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  $("#bitacora").html(data);
		$( "#bitacora" ).dialog(
		{ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
  height: 550,
	width: 850,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
		 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }
		);
		  }
	  })	
 */

}
function listaAct(periodo){
	var funcion = 2;
	var ramo = $("#rm").val();
	var curso = <?php echo $_CURSO; ?>;
		var parametros = "funcion="+funcion+"&ramo="+ramo+"&periodo="+periodo+"&curso="+curso;
		$.ajax({
				url:'cont_bitacora.php',
				data:parametros,
				type:'POST',
				success:function(data){
				$("#lact").html(data);
		  }
		});
	}
	
	
	function nuevaACT(){
	var ano=<?php echo $_ANO ?>; 
	var curso=<?php echo $_CURSO ?>;
	var ramo = $("#rm").val();
	var parametros="funcion=3&ano="+ano+"&curso="+curso+"&ramo="+ramo;
	//alert(parametros);

	$.ajax({
	  url:'cont_bitacora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#nact").html(data);
		$( "#nact" ).dialog(
		{ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
    height: 650,
	width: 750,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
   title: 'Registrar actividad',
   
    buttons: {
		 "Guardar": function(){
			 guardaActividad();
			  $("#txt_fecha").datepicker();
	    	$(this).dialog("close");
	  },
		 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }
		);
		  }
	  })	
 

}

function getObj(unidad){
	var funcion = 4;
	var curso=<?php echo $_CURSO ?>;
	
		var parametros = "funcion="+funcion+"&unidad="+unidad+"&curso="+curso;
		$.ajax({
				url:'cont_bitacora.php',
				data:parametros,
				type:'POST',
				success:function(data){
				$("#obj").html(data);
		  }
		});
	}

	function getIndicador(unidad){
	var funcion = 5;
	
		var parametros = "funcion="+funcion+"&unidad="+unidad;
		$.ajax({
				url:'cont_bitacora.php',
				data:parametros,
				type:'POST',
				success:function(data){
				$("#indi").html(data);
		  }
		});
	}
	
	function guardaActividad(){
		
	var funcion=6;
	var curso=<?php echo $_CURSO ?>;
	var ramo = $("#rm").val();
	var periodo = $("#cmb_periodoF").val();
	var unidad = $("#cmb_unidad").val();
	var objetivo = $("#cmb_objetivo").val();
	var indicador = $("#cmb_indicador").val();
	var fecha = $("#txt_fecha").val();
	var obs = $("#txt_observaciones").val();
	var canal = $("#canal").val();
	var hora_inicio = $("#hora_inicio").val();
	var hora_termino = $("#hora_termino").val();
	
	var bool_pie =$("#bool_pie").is(':checked')?1:0;
	var doc = $("#docente").val();
	
	if(periodo==0){
		alert("Debe selecionar periodo");
		return false;
	}
	/*else if(unidad==0){
		alert("Debe selecionar unidad");
		return false;
	}
	else if(objetivo==0){
		alert("Debe selecionar objetivo");
		return false;
	}
	else if(indicador==0){
		alert("Debe selecionar indicador");
		return false;
	}*/
	else if(fecha==""){
		alert("Debe selecionar fecha");
		return false;
	}
	else if(obs==""){
		alert("Debe ingresar observaciones");
		return false;
	}
	else if(canal==0){
		alert("Debe seleccionar canal de comunicac\xf3n");
		return false;
	}
	else if(hora_inicio==""){
		alert("Debe ingresar fecha de inicio");
		return false;
	}
	else if(hora_termino==""){
		alert("Debe seleccionar canal de t\xe9rmino");
		return false;
	}
	
		else{
		
		$('#alu_destino *').attr('selected','selected');
	
	var alus = [];
	$('#alu_destino option:selected').each(function() {
    alus.push($(this).val());
	//alert($(this).val());
});
  
 
		
			var parametros = "funcion="+funcion+"&curso="+curso+"&ramo="+ramo+"&periodo="+periodo+"&unidad="+unidad+"&objetivo="+objetivo+"&indicador="+indicador+"&fecha="+fecha+"&obs="+obs+"&alus="+alus+"&canal="+canal+"&hora_inicio="+hora_inicio+"&hora_termino="+hora_termino+"&bool_pie="+bool_pie+"&doc="+doc;
				$.ajax({
						url:'cont_bitacora.php',
						data:parametros,
						type:'POST',
						success:function(data){
						if(data==1){
							alert("Datos ingresados");
							$(this).dialog("close");
							listaAct(periodo);
							
							$('#cmb_periodo option[value='+periodo+']').attr('selected','selected');
							
						}
						else{
							alert("Error al ingresar datos");
						}
						
				  }
				});
		}
	}
	
function verAct(id){
	var ano=$("#cmb_ano").val();
	var curso=<?php echo $_CURSO ?>;
	var ramo = $("#rm").val();
	var parametros="funcion=7&id="+id+"&curso="+curso;
	//alert(parametros);

	$.ajax({
	  url:'cont_bitacora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#nact").html(data);
		$( "#nact" ).dialog(
		{ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
  height: 450,
	width: 750,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,

   position:"fixed",
   position: "absolute",
   title: 'Detalle actividad',
    buttons: {
		 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }
		);
		  }
	  })	
 
}

function delAct(id){
if(confirm("\xbfDesea eliminar este registro?")){
	var funcion=8;
	var periodo = $("#cmb_periodo").val();
	
	
		
			var parametros = "funcion="+funcion+"&id="+id;
				$.ajax({
						url:'cont_bitacora.php',
						data:parametros,
						type:'POST',
						success:function(data){
						if(data==1){
							alert("Registro eliminado");
							listaAct(periodo);
						}
						else{
							alert("Error al eliminar registro");
						}
						
				  }
				});
		
	
	}
}

function ediAct(id){
var funcion=9;
var curso=<?php echo $_CURSO ?>;
	var ramo = $("#rm").val();
	var ano=$("#cmb_ano").val();
	
	var parametros="funcion="+funcion+"&ano="+ano+"&curso="+curso+"&ramo="+ramo+"&id="+id;

	
	//alert(parametros);

	$.ajax({
	  url:'cont_bitacora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#nact").html(data);
		$( "#nact" ).dialog(
		{ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
  	 height: 650,
	width: 750,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute", 
   title: 'Editar datos actividad',
   
    buttons: {
		 "Guardar": function(){
			 guardaActividadEdi();
	    	$(this).dialog("close");
	  },
		 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }
		);
		  }
	  })	
}

function guardaActividadEdi(){
	var funcion=10;
	var curso=<?php echo $_CURSO ?>;
	var ramo = $("#rm").val();
	var periodo = $("#cmb_periodoF").val();
	var unidad = $("#cmb_unidad").val();
	var objetivo = $("#cmb_objetivo").val();
	var indicador = $("#cmb_indicador").val();
	var fecha = $("#txt_fecha").val();
	var obs = $("#txt_observaciones").val();
	var id = $("#idact").val();
	var canal = $("#canal").val();
	var hora_inicio = $("#hora_inicio").val();
	var hora_termino = $("#hora_termino").val();
	var bool_pie =$("#bool_pie").is(':checked')?1:0;
	var doc = $("#docente").val();
	
	if(periodo==0){
		alert("Debe selecionar periodo")
	}
	/*else if(unidad==0){
		alert("Debe selecionar unidad")
	}
	else if(objetivo==0){
		alert("Debe selecionar objetivo")
	}
	else if(indicador==0){
		alert("Debe selecionar indicador")
	}*/
	else if(fecha==""){
		alert("Debe selecionar fecha")
	}
	else if(obs==""){
		alert("Debe ingresar observaciones")
	}
	else if(canal==0){
		alert("Debe seleccionar canal de comunicac\xf3n")
	}
	else if(hora_inicio==""){
		alert("Debe ingresar fecha de inicio")
	}
	else if(hora_termino==""){
		alert("Debe seleccionar canal de t\xe9rmino")
	}
		else{
		
		$('#alu_destino *').attr('selected','selected');
	
	var alus = [];
	$('#alu_destino option:selected').each(function() {
    alus.push($(this).val());
	//alert($(this).val());
});
		
			var parametros = "funcion="+funcion+"&curso="+curso+"&ramo="+ramo+"&periodo="+periodo+"&unidad="+unidad+"&objetivo="+objetivo+"&indicador="+indicador+"&fecha="+fecha+"&obs="+obs+"&id="+id+"&alus="+alus+"&canal="+canal+"&hora_inicio="+hora_inicio+"&hora_termino="+hora_termino+"&bool_pie="+bool_pie+"&doc="+doc;
				$.ajax({
						url:'cont_bitacora.php',
						data:parametros,
						type:'POST',
						success:function(data){
						if(data==1){
							alert("Datos modificados");
							listaAct(periodo);
							
							$('#cmb_periodo option[value='+periodo+']').attr('selected','selected');
							
						}
						else{
							alert("Error al ingresar datos");
						}
						
				  }
				});
		}
}


function listaCanales(){
	var funcion=11;
	var parametros = "funcion="+funcion;
		$.ajax({
				url:'cont_bitacora.php',
				data:parametros,
				type:'POST',
				success:function(data){
				$("#listcanal").html(data); 
		  }
		});
	}
	
function creacanal(){ 
	var parametros = "funcion=12";
	$.ajax({
	  url:'cont_bitacora.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#ncanal").html(data);
		$( "#ncanal" ).dialog(
		{ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
  height: 150,
	width: 350,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
   
    buttons: {
		 "Guardar": function(){
			 guardaCanal();
	    	$(this).dialog("close");
	  },
		 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }
		);
		  }
	  })	
	}

function  guardaCanal(){
	var funcion=13;
	var canal=$("#nomcanal").val();
	if(canal==""){
		alert("Ingrese nombre de canal");	
		}
	else{
	var parametros = "funcion="+funcion+"&canal="+canal;
		$.ajax({
				url:'cont_bitacora.php',
				data:parametros,
				type:'POST',
				success:function(data){
				if(data==1){
					alert("Datos ingresados");
					listaCanales();
				}else{
					alert("Error al ingresar datos");
					}
		  }
		});
	}
	}
//fun funciones nueva actividad	óo
</script>

<style type="text/css">
<!--
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr align="left" valign="top">
              <td height="75" valign="middle"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle"><?   include("../../../../../../cabecera/menu_superior.php");?>                    </td>
                  </tr>
              </table></td>
            </tr>
            <!-- FIN DE COPIA DE CABECERA -->
        </table></td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><table>
                <tr>
                  <td><? 
				  $menu_lateral="3_1";
				  include("../../../../../../menus/menu_lateral.php"); ?></td>
              </table></td>
              <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top"><table width="100%" border="1" cellspacing="0" cellpadding="0" class="cajaborde">
					  <tr>
						<td>
						
						<form name="form" method="post" action="<?=$PHP_SELF;?>">
						<input name="id_ramo" type="hidden" value="<?=$ramo;?>" />
						</form>
						<BR />
						<form name="form1" method="post" action="procesoApreciacion.php">
						  <table width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
                            <tr>
                              <td align="right">
							
							 
							  <input name="volver" type="button" id="volver" value="VOLVER" class="botonXX" onClick="window.location='../listarRamos.php3'"/>
														  </td>
                            </tr>
                          </table>
						  <br />
						<table width="100%" border="0" cellspacing="3" cellpadding="0" align="center">
						  <tr>
							<td class="tableindex"><div align="center">BIT&Aacute;CORA ASIGNATURA</div></td>
						  </tr>
						</table>
						<br />
                        <div id="bitacora" title="Historial Asignatura"></div>
<div id="nact"></div>
<div id="ncanal" title="Nuevo canal de comunicaci&oacute;n"></div>
						</form>
						</td>
					  </tr>
					</table>
					</td>
                  </tr>
                 
              </table></td>
            </tr>
            <tr align="center" valign="middle">
              <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
      </table>
</td>
  </tr>
</table>
</body>
</html>
 <? pg_close($conn)?>