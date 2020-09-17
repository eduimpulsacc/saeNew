<?php 

//include("valida_usuario.php");

//	include("../libs/fun_bd.php");

require_once("includes/widgets/widgets_start.php");

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html dir="ltr" lang="es">

<head>

<title>Agregar Noticias</title>


<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />

<meta name="generator" content="vBulletin 3.0.7" />

<meta name="description" content="" />



<script type="text/javascript" src="clientscript/vbulletin_global.js"></script>

<script type="text/javascript" src="clientscript/vbulletin_menu.js"></script>

<script type="text/javascript" src="clientscript/vbulletin_editor.js"></script>

<script type="text/javascript" src="clientscript/vbulletin_stdedit.js"></script>

<script type="text/JavaScript">

<!--

function MM_jumpMenu(targ,selObj,restore){ //v3.0

  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");

  if (restore) selObj.selectedIndex=0;

}

//-->

</script>

<SCRIPT language="JavaScript">

<!--





function valida(tipo){

	frm=document.vbform



	if(!chkVacio(frm.txtitulo,'Ingresar Titulo.')){

		return false;

	};	

	

	if(!chkVacio(frm.fecha_inicio,'Ingresar Fecha de Inicio.')){

		return false;

	};

	

	

	if(!chkVacio(frm.fecha_caduca,'Ingresar Fecha de Termino.')){

		return false;

	};

	

	

/*	if(!fechaMayorOIgualQue(frm.fecha_inicio, frm.fecha_caduca)){

		return false;

	};

*/	

	

	if(!chkVacio(frm.txtdet,'Ingresar Detalle.')){

		return false;

	};	





	document.vbform.accion.value=tipo;

	document.vbform.submit();





}



function chkVacio(box,msg){

	if (box.value==''){

		alert(msg);

		box.focus();

		box.select();

		return false;

	}else{

		return true;

	};

}



function fechaMayorOIgualQue(fec1, fec0){ 

    var bRes = false; 

    var sDia0 = fec0.value.substr(0, 2); 

    var sMes0 = fec0.value.substr(3, 2); 

    var sAno0 = fec0.value.substr(6, 4); 

    var sDia1 = fec1.value.substr(0, 2); 

    var sMes1 = fec1.value.substr(3, 2); 

    var sAno1 = fec1.value.substr(6, 4); 

    if (sAno0 >= sAno1) bRes = true; 

    else { 

     if (sAno0 == sAno1){ 

      if (sMes0 >= sMes1) bRes = true; 

      else { 

       if (sMes0 == sMes1) 

        if (sDia0 >= sDia1) bRes = true; 

      } 	

     } alert("Fecha de Termino debe ser mayor o igual que Fecha de Inicio");

    } 	

    return bRes; 

   }



function MM_goToURL() { //v3.0

  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;

  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");

}

//-->

</SCRIPT>

<link href="../sitio/style.css" rel="stylesheet" type="text/css" />
</head>

<body onload="editInit();">

<br />



<!-- logo -->

<a name="top"></a>

<tr><td valign=top>

	

<!-- / NAVBAR POPUP MENUS -->

<?

if($_POST["accion"]=="Modificar"){ 

//if($id_noticia!= 0){

$qry="SELECT * FROM DIN_NOTICIAS WHERE ID_NOTICIA = '".$_POST["id_noticia"]."'";

$result = @pg_Exec($coo,$qry);

//echo $id_noticia;

//$num = pg_numrows($result);

//$num;

$fila = @pg_fetch_array($result,0)



?>	

<? }



if ($id_noticia==0){ ?>
<!-- Ingreso -->
<form action="procesanot.php" method="post" enctype="multipart/form-data" name="vbform" onsubmit="return validatePost(this, this.txtitulo.value, 20, 20000);" onreset="vB_RESET(this);">

<input type="hidden" value="" name="accion" />

<table cellpadding="6" cellspacing="1" border="0" width="100%" align="center">

<tr>

	<td align="center">

	<div>

		<div style="width:540px" align="left">



		



		<!-- txtitulo field -->

		<table cellpadding="0" cellspacing="0" border="0" class="fieldset">

		<tr>

			<td width="24%" class="texto">Titulo: </td>

			<td colspan="2" bgcolor="#FFFFFF"><INPUT name="txtitulo" type="text" class="texto" size="50" maxlength="255" tabindex="1"></td>

		</tr>									

		<tr>

			<td width="30%" class="texto">Fecha de Inicio:</td>

			<td ><input name="fecha_inicio" type="widget" class="texto" id="fecha_inicio" size="12" maxlength="10"  subtype="wcalendar" format="%Y-%m-%d" skin="blue" language="es" label="..." mondayfirst="true" singleclick="true"  readonly="true" value="<? echo date("Y-m-d");?>	"/></td>

		</tr>

		<tr>

			<td width="30%" class="texto">Fecha de Termino:</td>

			<td ><input name="fecha_caduca" type="widget" class="texto" id="fecha_caduca" size="12" maxlength="10"  subtype="wcalendar" format="%Y-%m-%d" skin="blue" language="es" label="..." mondayfirst="true" singleclick="true"  readonly="true"/></td>

		</tr>

		<tr>

			<td width="30%" class="texto">Insertar Imágen:</td>

			<td ><input type="file" name="image" /></td>

		</tr>

		<tr>

			<td width="30%" class="texto">Estado:</td>

			<td ><select name="chkest" class="texto">

								<option value="1">Activar</option>

								<option value="0">Desactivar</option>

							</select>				

			</td>

		</tr>

					

		<tr>

			<td colspan="2" class="texto">

			<br />

		<!-- message area -->

		<div>Noticia:</div>	

		<br />	

		<!-- load scripts -->

<!-- EDITOR SCRIPTS -->



<script type="text/javascript">

<!--

var fontoptions = new Array("Arial", "Arial Black", "Arial Narrow", "Book Antiqua", "Century Gothic", "Comic Sans MS", "Courier New", "Fixedsys", "Franklin Gothic Medium", "Garamond", "Georgia", "Impact", "Lucida Console", "Lucida Sans Unicode", "Microsoft Sans Serif", "Palatino Linotype", "System", "Tahoma", "Times New Roman", "Trebuchet MS", "Verdana");

var sizeoptions = new Array(1, 2, 3, 4, 5, 6, 7);

var istyles = new Array(); istyles = { "pi_button_down" : [ "#98B5E2", "#000000", "0px", "1px solid #316AC5" ], "pi_button_hover" : [ "#C1D2EE", "#000000", "0px", "1px solid #316AC5" ], "pi_button_normal" : [ "#ECE9D8", "#000000", "1px", "none" ], "pi_button_selected" : [ "#E1E6E8", "#000000", "0px", "1px solid #316AC5" ], "pi_menu_down" : [ "#98B5E2", "#316AC5", "0px", "1px solid #316AC5" ], "pi_menu_hover" : [ "#C1D2EE", "#316AC5", "0px", "1px solid #316AC5" ], "pi_menu_normal" : [ "#FFFFFF", "#000000", "0px", "1px solid #FFFFFF" ], "pi_popup_down" : [ "#98B5E2", "#000000", "0px", "1px solid #316AC5" ] };

var normalmode = true;

var smiliewindow_x = 240;

var smiliewindow_y = 280;

var ignorequotechars = 1;

var vbphrase = {

	

		// standard only

		"enter_option_x_tag" : "Ingresa las opciones para la etiqueta [%1$s]:",

		"enter_text_to_be_formatted" : "Ingresa el texto a ser formateado",

		"enter_link_text" : "Ingresa el texto para mostrar como enlace (opcional):",

		"enter_list_type" : "¿Qué tipo de lista quieres?  Ingresa '1' para una lista en orden numérico, 'a' para una lista alfavética, o deja en blanco para una lista de puntos:",

		"enter_list_item" : "Ingresar un lista de artículos.\nDeja el campo vacío o presiona 'Cancel' para completar la lista:",

	

	// both

	"must_enter_txtitulo" : "¡Debes escribir un título / tema!",

	"message_too_short" : "El mensaje que has proporcionado es muy corto. Por favor extiende tu mensaje por lo menos a %1$s caracteres.",

	"enter_link_url" :  "Por favor ingresa la URL de tu enlace:",

	"enter_image_url" : "Por favor ingresa la URL para tu imagen:",

	"enter_email_link" : "Por favor ingresa la dirección de correo para el enlace:"

};



//-->

</script>



<link rel="stylesheet" type="text/css" href="clientscript/vbulletin_editor.css" />

<style type="text/css">

<!--

#vBulletin_editor {

	background: #ECE9D8;

	padding: 6px;

}

.imagebutton {

	background: #ECE9D8;

	color: #000000;

	padding: 1px;

	border: none;

}

.ocolor, .ofont, .osize, .osmilie, .osyscolor, .smilietitle {

	background: #FFFFFF;

	color: #000000;

	border: 1px solid #FFFFFF;

}

.popup_pickbutton {

	border: 1px solid #FFFFFF;

}

.popup_feedback {

	background: #FFFFFF;

	color: #000000;

	border-right: 1px solid #FFFFFF;

}

.popupwindow {

	background: #FFFFFF;

}

#fontOut, #sizeOut, .popup_feedback div {

	background: #FFFFFF;

	color: #000000;

}

.alt_pickbutton {

	border-left: 1px solid #ECE9D8;

}

-->

</style>

<!-- END EDITOR SCRIPTS -->



<!-- start message area --><div id="vBulletin_editor" style="text-align:left"><!-- / start message area -->





<table cellpadding="0" cellspacing="0" border="0">

<tr valign="bottom">

	<td colspan="2">



<!-- start control bar --><div id="controlbar"><!-- / start control bar -->



	<!-- first control row -->

	<div>

		<!--

		<table cellpadding="0" cellspacing="1" border="0" width="100%">

		<tr>

			

			<td>

			<select id="fontselect" onchange="fontformat(this.options[this.selectedIndex].value, 'FONT')">

				<option value="">[Font]</option>

				<script type="text/javascript"> build_fontoptions(false); </script>

			</select>&nbsp;			</td>

			

			

			<td>

			<select id="sizeselect" onchange="fontformat(this.options[this.selectedIndex].value, 'SIZE')">

				<option value="">[Size]</option>

				<script type="text/javascript"> build_sizeoptions(false); </script>

			</select>&nbsp;			</td>

			

			

			<td>

			<select id="colorselect" onchange="fontformat(this.options[this.selectedIndex].value, 'COLOR')">

				<option value="">[Color]</option>

				<script type="text/javascript"> build_coloroptions(false); </script>

			</select>&nbsp;			</td>

			</tr>

		</table>

		-->

	</div>

	<!-- / first control row -->

	

	<!-- second control row -->	

	<div>

		<table cellpadding="0" cellspacing="1" border="0" width="100%">

		<tr>

			

			<td><div><a href="#" onclick="return vbcode('B', '')" accesskey="b"><img class="image" src="editor/bold.gif" alt="Negrita" width="21" height="20" border="0" /></a></div></td>

			<td><div class="imagebutton"><a href="#" onclick="return vbcode('I', '')" accesskey="i"><img class="image" src="editor/italic.gif" alt="It&aacute;lica" width="21" height="20" border="0" /></a></div></td>

			<td><div class="imagebutton"><a href="#" onclick="return vbcode('U', '')" accesskey="u"><img class="image" src="editor/underline.gif" alt="Subrayado" width="21" height="20" border="0" /></a></div></td>

			<td><img src="editor/separator.gif" alt="" width="6" height="20" border="0" /></td>

			

			

			<td><div class="imagebutton"><a href="#" onclick="return vbcode('LEFT', '')"><img class="image" src="editor/justifyleft.gif" alt="Alinear a la Izquierda" width="21" height="20" border="0" /></a></div></td>

			<td><div class="imagebutton"><a href="#" onclick="return vbcode('CENTER', '')"><img class="image" src="editor/justifycenter.gif" alt="Alinear al Centro" width="21" height="20" border="0" /></a></div></td>

			<td><div class="imagebutton"><a href="#" onclick="return vbcode('RIGHT', '')"><img class="image" src="editor/justifyright.gif" alt="Alinear a la Derecha" width="21" height="20" border="0" /></a></div></td>

			<td><img src="editor/separator.gif" alt="" width="6" height="20" border="0" /></td>

			<td><div class="imagebutton"><a href="#" onclick="return vbcode('INDENT', '')"><img class="image" src="editor/indent.gif" alt="Sangrado" width="21" height="20" border="0" /></a></div></td>

			

			

			<td><div class="imagebutton"><a href="#" onclick="return dolist()"><img class="image" src="editor/insertunorderedlist.gif" alt="Crear Lista" width="21" height="20" border="0" /></a></div></td>

			

			<td><img src="editor/separator.gif" alt="" width="6" height="20" border="0" /></td>

			<!--

			<td><div class="imagebutton"><a href="#" onclick="return vbcode('IMG', 'http://')"><img src="editor/insertimage.gif" alt="Insertar Im&aacute;gen" width="21" height="20" border="0" /></a></div></td>

			-->

			<td><div class="imagebutton"><a href="#" onclick="namedlink('URL')"><img src="editor/createlink.gif" alt="Insertar Hiperenlace" width="21" height="20" border="0" /></a></div></td>

			<!--

			<td><div class="imagebutton"><a href="#" onclick="namedlink('EMAIL')"><img src="editor/email.gif" alt="Insertar Enlace de Correo Electr&oacute;nico" width="21" height="20" border="0" /></a></div></td>

			-->	

			<td><img src="editor/separator.gif" alt="" width="6" height="20" border="0" /></td>

			

			<td><div class="imagebutton"><a href="#" onclick="return vbcode('CODE', '')"><img src="editor/code.gif" alt="Envolver Etiquetas [CODE]" width="21" height="20" border="0" /></a></div></td>

			

			

			<td><div class="imagebutton"><a href="#" onclick="return vbcode('HTML', '')"><img src="editor/html.gif" alt="Envolver Etiquetas [HTML]" width="21" height="20" border="0" /></a></div></td>

			

			

			<td><div class="imagebutton"><a href="#" onclick="return vbcode('PHP', '')"><img src="editor/php.gif" alt="Envolver Etiquetas [PHP]" width="21" height="20" border="0" /></a></div></td>

			

			<td><img src="editor/separator.gif" alt="" width="6" height="20" /></td>

			<td><div class="imagebutton"><a href="#" onclick="return vbcode('QUOTE', '')"><img src="editor/quote.gif" alt="Envolver Etiquetas [QUOTE]" width="21" height="20" border="0" /></a></div></td>

			

			<td class="smallfont" width="100%" align="right">

				<span class="imagebutton">Cerrar Etiquetas <input type="button" style="color: red; font: bold 11px verdana" value=" x " onclick="closeall(this.form)" /></span>			</td>

		</tr>

		</table>

	</div>

	<!-- / second control row -->

	

	<!-- third control row -->

	<div class="controlholder">

	<table width="100%">

		<tr>

			<td colspan="0">

		<span class="imagebutton"><span class="smallfont">

			<label for="rb_mode_0"><input type="radio" name="mode" value="0" id="rb_mode_0" onclick="setmode(this.value)" checked="checked" />Modo Simple</label>

			<label for="rb_mode_1"><input type="radio" name="mode" value="1" id="rb_mode_1" onclick="setmode(this.value)"  />Modo Avanzado</label>

		</span></span>	

			</td>

			<td align="right">					

		<span class="imagebutton">Cerrar Etiqueta <input type="button" style="color: red; font: bold 11px verdana" value=" x " onclick="closetag(this.form)" /></span>

			</td>

		</tr>

	</table>

	</div>

	

<!-- end control bar --></div><!-- / end control bar -->	</td>

</tr>

<tr valign="top">

	<td>

	

	<!-- edit text area -->

	<textarea name="txtdet" id="message" rows="20" cols="60" wrap="virtual" style="width:500px; height:250px" tabindex="1"></textarea>	

	<!-- / edit text area -->	



		<div class="smallfont">

			<a href="#" onclick="return alter_box_height('message', 100)">Aumentar Tama&ntilde;o</a>

			<a href="#" onclick="return alter_box_height('message', -100)">Reducir Tama&ntilde;o</a>		</div>	</td>	

</tr>

</table>









<!-- end message area --></div><!-- / end message area -->

		<!-- / message area -->



		

	<script type="text/javascript">

	<!--

	function swap_posticon(imgid)

	{

		var out = fetch_object("display_posticon");

		var img = fetch_object(imgid);

		if (img)

		{

			out.src = img.src;

			out.alt = img.alt;

		}

		else

		{

			out.src = "clear.gif";

			out.alt = "";

		}

	}

	// -->

	</script>			</td>

		</tr>

		</table>

		</div>

	</div>

			

	<div style="margin-top:6px">

		<input type="hidden" name="s" value="" />

		<input type="hidden" name="f" value="63" />

		<input type="hidden" name="do" value="postthread" />

		<input type="hidden" name="posthash" value="8dc2c142679a0a5c2e30f470a10830ca" />

		<input type="hidden" name="poststarttime" value="1149263143" />



	</div>	</td>

</tr>

<tr>

<td align="center" colspan="2"><INPUT TYPE="button" value="GUARDAR"   name="btnGuardar" tabindex="1" onclick="valida('Ingresar')" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT   TYPE="submit" onclick="MM_goToURL('parent','muestranot.php?pag_actual=1 ');return document.MM_returnValue" value="VOLVER" ></td>

</tr>

</table>

</form>

<? } ?>

</td>

</tr>

</body>

</html>

<?  require_once("includes/widgets/widgets_end.php");?>