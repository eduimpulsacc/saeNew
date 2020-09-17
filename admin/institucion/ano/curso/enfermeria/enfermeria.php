<?php require('../../../../../util/header.inc');


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
<script type="text/javascript" src="../../../../clases/jquery/jquery-1.11.2.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.datepicker.js"></script>

<script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.core.js"></script>
<!--<script type="text/javascript" src="../../../../../util/chkform.js"></script>
-->
<script type="text/javascript" src="../../../../clases/jquery/print2.js"></script>
<script language="javascript">
$(document).ready(function() {
	curso();
	
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
		url:'cont_enfermeria.php',
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
		url:'cont_enfermeria.php',
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

function alumno(curso){
	var parametros ="funcion=2&curso="+curso;
	
	$.ajax({
		url:'cont_enfermeria.php',
		data:parametros,
		type:'POST',
		success:function(data){
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				$("#alumno").html(data);	
			}
		}
	})
}

function listado(){
	var ano =$("#cmbANO").val();
	var curso =$("#cmbCURSO").val();
	var alumno =$("#cmbALUMNO").val();
	var parametros ="funcion=3&curso="+curso+"&ano="+ano+"&alumno="+alumno;
	
	$.ajax({
		url:'cont_enfermeria.php',
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
		url:'cont_enfermeria.php',
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

function guardar(){
		var ano 	= $("#cmbANO").val();
		var curso 	= $("#cmbCURSO").val();
		var alumno 	= $("#cmbALUMNO").val();
		var fecha 	= $("#txtFECHAS").val();
		var hingreso= $("#txtHORAINGRESO").val();
		var hegreso	= $("#txtHORAEGRESO").val();
		//var consulta = utf8_encode($("#txtCONSULTA").val());
		var consulta = "";
		var destino	= $("#txtDESTINO").val();
		var proced	= $("#txtPROCEDIMIENTO").val();
		var obs		= $("#txtOBS").val();
		var patolo	= $("#cmbPATOLOGIA").val();
		var motivo	= $("#txtMOTIVO").val();
		
		var parametros = "funcion=5&ano="+ano+"&curso="+curso+"&alumno="+alumno+"&fecha="+fecha+"&ingreso="+hingreso+"&egreso="+hegreso+"&consulta="+consulta+"&destino="+destino+"&proced="+proced+"&obs="+obs+"&patologia="+patolo+"&motivo="+motivo;
		
		$.ajax({
		url:'cont_enfermeria.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//console.log(data);
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				listado();
				mostrar2(data);
			}
		}
		})
}
function elimina(id){
	var parametros="funcion=6&id="+id;
	$.ajax({
	url:'cont_enfermeria.php',
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

function mostrar(id){
	//alert("llego");
	var parametros="funcion=7&id="+id;
	
	$.ajax({
	url:'cont_enfermeria.php',
	data:parametros,
	type:'POST',
	success:function(data){
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{
			$("#muestra").html(data);
			$("#muestra").dialog({
				autoOpen:true,
				width: "450px",
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

function mostrar2(id){
	//alert("llego");
	var parametros="funcion=7&id="+id;
	
	$.ajax({
	url:'cont_enfermeria.php',
	data:parametros,
	type:'POST',
	success:function(data){
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{
			//$("#muestra").html(data);
			 $(".print").html(data);
			$("#muestra").dialog({
				autoOpen:true,
				width: "450px",
  				maxWidth: "450px",
				show: {
				effect: "blind",
				duration: 1000
				},
				hide: {
				effect: "explode",
				duration: 1000
				},
				 buttons: {
	 "Imprimir": function(){
		 $( "#muestra" ).dialog( "close" );
	     PrintElem('.print');
		 } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	} ,
	 create:function () {
        $(this).closest(".ui-dialog").find(".ui-button:first").addClass("printer");
    }
				});
		}
	}
	})	
}


function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'my div', 'height=400,width=600');
        mywindow.document.write('<html><head><title>my div</title>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }


function modifica(id){
	var parametros="funcion=8&id="+id;
	
	$.ajax({
	url:'cont_enfermeria.php',
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
		var ano 	= $("#cmbANO").val();
		var curso 	= $("#cmbCURSO").val();
		var alumno 	= $("#cmbALUMNO").val();
		var fecha 	= $("#txtFECHAS").val();
		var hingreso= $("#txtHORAINGRESO").val();
		var hegreso	= $("#txtHORAEGRESO").val();
		//var consulta = utf8_encode($("#txtCONSULTA").val());
		var consulta = "";
		var destino	= $("#txtDESTINO").val();
		var proced	= $("#txtPROCEDIMIENTO").val();
		var obs		= $("#txtOBS").val();
		var id		= $("#id").val();
		var patolo	= $("#cmbPATOLOGIA").val();
		var motivo	= $("#txtMOTIVO").val();
		
		var parametros = "funcion=9&ano="+ano+"&curso="+curso+"&alumno="+alumno+"&fecha="+fecha+"&ingreso="+hingreso+"&egreso="+hegreso+"&consulta="+consulta+"&destino="+destino+"&proced="+proced+"&obs="+obs+"&id="+id+"&patolo="+patolo+"&motivo="+motivo;;
	
		$.ajax({
		url:'cont_enfermeria.php',
		data:parametros,
		type:'POST',
		success:function(data){
			console.log(data);
			if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				listado();
				mostrar2(id)
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
			alert("Escriba nombre de Clasificacion");
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
	url:"cont_enfermeria.php",
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
	url:'cont_enfermeria.php',
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

function ppp(){
alert("ssss");
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
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
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
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
                                        <td>&nbsp;
                                        <? $sql="SELECT id_ano, nro_ano,situacion FROM ano_escolar WHERE id_institucion=".$institucion." ORDER BY nro_ano ASC";
		$rs_ano = pg_exec($conn,$sql) or die("ERROR".$sql);
		?>
                                        <select name="cmbANO" id="cmbANO" onchange="curso(this.value)">
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
                                        
                                        </td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">CURSO</td>
                                        <td><div id="curso">&nbsp;
                                        <select name="cmbCURSO" id="cmbCURSO">
                                        	<option value="0">seleccione...</option>
                                         </select>
                                        </div></td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">ALUMNO</td>
                                        <td>
                                        <div id="alumno">&nbsp;
                                        <select name="cmbALUMNO" id="cmbALUMNO">
                                        	<option value="0">seleccione...</option>
                                         </select>
                                         </div>
                                        </td>
                                      </tr>
                                    </table>
								  <div id="buscador">&nbsp;</div><br />
								  <div id="tabla">&nbsp;</div>
                                  <div id="muestra" title="Detalle de Atenci&oacute;n">
                                  <div class="print"></div>
                                  </div>
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
</body>
</html>
