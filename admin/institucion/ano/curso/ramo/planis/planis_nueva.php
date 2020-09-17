<?php
	require('../../../../../../util/header.inc');
	
	
	
function salida_abrupta($mensaje){


	echo "<script language=\"javascript\" type=\"text/javascript\">
						alert(\"{$mensaje}\");
						</script>";	
	"<script>window.location = \"planificacion.php?id_ramo=".$_POST['id_ramo']."\"</script>";
	exit;
}

	//------------------------
	// verificar doble post
	//------------------------
 	if (isset($_SESSION['postid'])) {
		if ($_POST['postID'] == $_SESSION['postid']){
			unset($_SESSION['postid']);
		} else{
			unset($_SESSION['postid']);
			salida_abrupta("Puede que ud. esté usando la sesión de otra persona, por favor vuelva a iniciar su sesión");
		}
	} else salida_abrupta("Para evitar duplicar las planificaciones, por favor vuelva a la página anterior");

	//------------------------
	// verificar variables
	//------------------------
	$_RAMO = $_POST['id_ramo'];
	 if (!($_RAMO && $_CURSO && $_ANO && $_INSTIT && $_USUARIO)){
		salida_abrupta("Existe un error en la información ingresada. Reintente");
//		salida_abrupta("ramo ".$_RAMO." curso ".$_CURSO." año ".$_ANO." instit ".$_INSTIT." user ".$_USUARIO);
	} else {
		$id_ramo		= $_RAMO;
		$curso			= $_CURSO;
		$ano			= $_ANO;
		$institucion	= $_INSTIT;
		$usuario		= $_USUARIO;
	$rut_empleado		=$_NOMBREUSUARIO;
		
	}
	
	$nombre = pg_escape_string($_POST['text_nombre']);
	$descripcion = pg_escape_string($_POST['text_descripcion']);
	if (!is_numeric(($_POST["select_tipo"]))){
		salida_abrupta("No se transmitió correctamente la información desde la página anterior. Por favor vuelva a intentarlo");
	} else
		$tipo = pg_escape_string($_POST['select_tipo']);
	if (!is_numeric(($_POST["select_momento"]))){
		salida_abrupta("No se transmitió correctamente la información desde la página anterior. Por favor vuelva a intentarlo");
	} else
		$momento = pg_escape_string($_POST['select_momento']);
	// caso plani anual y trayecto, no es posible
	if ($momento == 10 && $tipo == 30)
		salida_abrupta("No se acepta crear una planificación anual de tipo trayecto. Pruebe otra combinación");
	
	//------------------------
	// validacion rut usuario match rut ramo
	//------------------------
		// rut empleado
	 $sql_rut_usuario = "SELECT rut_emp FROM empleado WHERE rut_emp = '{$rut_empleado}' LIMIT 1 ";
	$result_rut_usuario = @pg_Exec($conn, $sql_rut_usuario) or salida_abrupta ("No se encontró usuario en la lista de empleados");
	if (pg_numrows($result_rut_usuario) == 1){
		$rut_usuario = @pg_fetch_array($result_rut_usuario, 0);
		$rut_usuario= $rut_usuario[0];
	} else salida_abrupta("No se encontró usuario en la lista de empleados");
	
		// rut ramo
		
	$sql_rut_ramo = "SELECT rut_emp FROM dicta WHERE id_ramo = '{$id_ramo}' LIMIT 1 ";
	$result_rut_ramo = @pg_Exec($conn, $sql_rut_ramo) or salida_abrupta("No se encontró el ramo en la lista de ramos dictados");
	if (pg_numrows($result_rut_ramo) == 1){
		$rut_ramo = @pg_fetch_array($result_rut_ramo, 0);
		$rut_ramo = $rut_ramo[0];
	} else salida_abrupta("No se encontró el RUN en la lista de ramos dictados");
		// comparar
	if ($rut_usuario != $rut_ramo){
		
		salida_abrupta("Dueño de la planificación no concuerda con usuario de la sesión");
		
      	}
	//------------------------
	// insertar nueva planificacion
	//------------------------
	if ( !is_null($nombre) && !is_null($descripcion) && is_numeric($momento) && is_numeric($tipo)){
		$insert_into = "INSERT INTO plani (rut_emp, id_ramo, nombre, descripcion, momento, tipo, estado) VALUES ";
		$insert_values = "({$rut_usuario}, {$id_ramo}, '{$nombre}', '{$descripcion}', {$momento}, {$tipo},0);";
		$select_currval = "SELECT currval('plani_id_plani_seq');";
		$result_insert = @pg_Exec($conn, $insert_into.$insert_values.$select_currval) or salida_abrupta ("No se logró ingresar la planificación. Reintente más tarde, $insert_into $insert_values");
		if (pg_numrows($result_insert) == 1){
			$last_plani_id = @pg_fetch_array($result_insert, 0);
			$last_plani_id = $last_plani_id[0];
		} else salida_abrupta("Existe un pequeño incoveniente con la base de datos... por favor reintente unos minutos más tarde");
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
	<meta http-equiv="Content-Type" content="text/html; charset=latin9">
	
	<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
	<link href="./scripts/SpryData.css" rel="stylesheet" type="text/css">
	<link href="./scripts/LiteCalendarPopup.css" rel="stylesheet" type="text/css">

	<script src="scripts/LiteCalendarPopup.js"></script> 
	<script src="scripts/load_calendar.js"></script>
	<script src="scripts/utils.js"></script>

<script language="JavaScript" type="text/JavaScript">
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
	
<script language="JavaScript" type="text/JavaScript">
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

<script language="JavaScript" src="../../../../../../util/chkform.js"></script>
<script language="JavaScript">
	function fn(form,field)
	{
		var next=0, found=false
		var f=frm
	
	//			field.value=toUpperCase(field.value);
		field.value=field.value.toUpperCase();
		if(event.keyCode==38)  // codigo ascii de la flecha hacia arriba 
		{
			for(var i=0;i<f.length;i++)	{
				if(field.name==f.item(i).name){
					next=i-1;
					found=true
					break;
				}
			}
		}
		
		if(event.keyCode==40)  // codigo ascii de la flecha hacia abajo
		{
			for(var i=0;i<f.length;i++)	{
				if(field.name==f.item(i).name){
					next=i+1;
					found=true
					break;
				}
			}
		}
	
	
	
		while(found){
			if( f.item(next).disabled==false &&  f.item(next).type!='hidden'){
				f.item(next).focus();
				break;
			}
			else{
				if(next<f.length-1)
					next=next+1;
				else
					break;
			}
		}
	}
	function validaNota(box){
		if(box.value.length==0)	
			return true; // acepta longitud 0
		if(!notaNroOnly(box,'Nota invalida.')){
			return false;
		}
		return true;
	}
	
	function Valida(){ 
	//VALIDA NOTAS
		for (var zz=3;zz<document.frm.elements.length;zz++){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
			if(!validaNota(document.frm.elements[zz])){
					return false;
			}
		}
		alert('El promedio debe procesarse en el ingreso de las notas');
		frm.submit(true);
	}
	
	function validaNotaConceptual(box){
		
		if(box.value.length==0)	
			return true; // acepta longitud 0
		if(!notaConOnly(box,'ingrese un concepto valido!!!'))
			return false;
		return true;
	}
	
	function Valida_Conceptual(){ 
	//VALIDA NOTAS
		for (var zz=3;zz<document.frm.elements.length;zz++){ //MENOS LOS 2 PRIMEROS BOTONES Y EL ULTIMO DE PROMEDIO
			if(!validaNotaConceptual(document.frm.elements[zz])){
					return false;
			}
		}
		confirm('El promedio debe procesarse en el ingreso de las notas');
		frm.submit(true);
	}


</script>

<script language="JavaScript">
	function enviapag(form){
		if (form.cmbPERIODO.value!=0){
			form.cmbPERIODO.target="self";
			form.submit(true);
		}
	}
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
	
	function MM_openBrWindow(theURL,winName,features) { //v2.0
	  window.open(theURL,winName,features);
	}
</script>

<!-- Scripts AJAX -->
<script language="javascript" type="text/javascript" src="scripts/SpryData.js"></script>
<script language="javascript" type="text/javascript" src="scripts/SpryHTMLDataSet.js"></script>
<script language="javascript" type="text/javascript" src="scripts/SpryEffects.js"></script>

<script src="../../../../../../SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="../../../../../../SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />

<!-- Scripts Editor WYSIWYG -->
<script src="tiny_mce3/tiny_mce.js" type="text/javascript"></script>
<script src="tiny_mce3/tiny_mce_gzip.js" type="text/javascript"></script>
<script src="tiny_mce3/load_tiny.js" type="text/javascript"></script>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	    <td height="589" align="left" valign="top">
	    	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	        	<tr>
					<td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
					<td width="0%" align="left" valign="top" bgcolor="f7f7f7"><? include("../../../../../../cabecera/menu_superior.php"); ?></td>
	        	</tr>
	        	<tr align="left" valign="top"> 
					<td height="83" colspan="3">
						<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	                    	<tr> 
								<td width="27%" height="363" align="left" valign="top"><? $menu_lateral="3_1";?> <? include("../../../../../../menus/menu_lateral.php"); ?></td>
								<td width="73%" align="left" valign="top">
	                      			<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tr> 
	                            			<td align="left" valign="top">&nbsp;</td>
	                            		</tr>
	                        			<tr> 
	                      					<td height="395" align="left" valign="top">
												<table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
	                            					<tr>
														<td height="390" valign="top">

<!-- Inicio Nueva Planificacion -->

<!--Resumen plani -->
	<p class="titulo2">&nbsp;1 - Res&uacute;men de la Planificaci&oacute;n</p>
	<table>
		<tr>
			<td class="texto1">&nbsp;&nbsp;Nombre:&nbsp;</td>
			<td colspan="3" class="texto2"><label><input readonly name="text_nombre" id="text_nombre" type="text" size="50" value="<?php echo $nombre ?>" ></label></td>
		</tr>
		<tr>
			<td class="texto1">&nbsp;&nbsp;Descripci&oacute;n:&nbsp;</td>
			<td colspan="3" class="texto2"><label><textarea readonly name="text_descripcion" id="text_descripcion" cols="50" rows="3"><?php echo $descripcion ?></textarea></label></td>
		</tr>
		<tr>
			<td class="texto1">&nbsp;&nbsp;Momento Pedag&oacute;gico:&nbsp;</td>
			<td class="texto2"><label><input readonly name="text_nombre" id="text_nombre" type="text" size="10" value="<?php 
			switch ($momento) {
				case 10:
					echo "Anual";
					break;
				case 20:
					echo "Unidad";
					break;
				case 30:
					echo "Clase";
					break;
			} ?>"></label></td>
			<td class="texto1">&nbsp;&nbsp;Tipo de Planificaci&oacute;n:&nbsp;</td>
			<td class="texto2"><label><input readonly name="text_nombre" id="text_nombre" type="text" size="10" value="<?php 
			switch ($tipo) {
				case 10:
					echo "V heurística";
					break;
				case 20:
					echo "Tipo T";
					break;
				case 30:
					echo "de Trayecto";
					break;
			} ?>"></label></td>
		</tr>
	</table>
	
<!-- Form detalle plani -->

<form name="form_detalles" id="form_detalles" method="post" action="planis_insertar.php?id_ramo=<?php echo $id_ramo; ?>">
	<input type="hidden" name="id_plani" id="id_plani" value='<?php echo $last_plani_id; ?>'>

	<p class="titulo2">&nbsp;Paso # 2 - Detalle de la planificaci&oacute;n</p>
	<table>
		<tr>
			<td class="texto1">&nbsp;&nbsp;Per&iacute;odo de aplicaci&oacute;n</td>
			<td class="texto2">desde el</td>
			<td class="texto2" onClick="cal1.showCalendar('text_fecha_inicio'); return false;" name="text_fecha_inicio" id="text_fecha_inicio"><input type="text" name="text_dia_inicio" id="text_dia_inicio" size=1 ><input type="text" name="text_mes_inicio" id="text_mes_inicio" size=1 ><input type="text" name="text_ano_inicio" id="text_ano_inicio" size=2 ></td>
			<td class="texto2">hasta el</td>
			<td class="texto2" onClick="cal2.showCalendar('text_fecha_fin'); return false;" name="text_fecha_fin" id="text_fecha_fin"><input type="text" name="text_dia_fin" id="text_dia_fin" size=1 ><input type="text" name="text_mes_fin" id="text_mes_fin" size=1 ><input type="text" name="text_ano_fin" id="text_ano_fin" size=2 ></td>
		</tr>

<?php
	// tabla plani_has_*
	switch ($momento){
		case 10:
			// nada definido por el momento
			echo "\n</table>";
			break;
		case 20:
			// nada definido por el momento
			echo "\n</table>";
			break;
		case 30:
			// asociar plani clase con alguna plani de unidad
			$sql_planis_unidad = "SELECT id_plani,
														to_char(fecha_creacion, 'DD-MM-YY'),
														nombre
														FROM plani
														WHERE id_ramo = ".$id_ramo." AND
															esta_oculta = FALSE AND
															momento = 20";
			if ($result_planis_unidad = @pg_Exec($conn, $sql_planis_unidad)){			
				if (($num_planis_unidad = pg_numrows($result_planis_unidad)) > 0){
					for ($i = 0; $i < $num_planis_unidad; $i ++){
						$planis_unidad[$i] = @pg_fetch_array($result_planis_unidad, $i, PGSQL_ASSOC) or salida_abrupta('Error obteniendo las planificaciones de unidad');	
					}		
				} else if ($num_planis_unidad == 0){
					$planis_unidad = "No existen planificaciones de unidad";
				} else salida_abrupta('Error en la carga de las planificaciones');	
			}
			else salida_abrupta('Error realizando la consulta a la BD');
			?>
		<tr>
			<td class="texto1">&nbsp;&nbsp;Asociar a la siguiente planificaci&oacute;n de unidad:</td>
			<td colspan="3" class="texto2"><select name="select_unidad_plani" id="select_unidad_plani">
		        <?php
					if (is_array($planis_unidad)){
						echo "\t<option value=\"0\">seleccione</option>";
						foreach ($planis_unidad as $unidad_i){
							echo "<option value=\"{$unidad_i['id_plani']}\"> {$unidad_i['nombre']} ({$unidad_i['to_char']}) </option>\n";
						}
					} else echo "\t<option value=\"0\">no existe ninguna unidad planificada</option>";
		        ?>
			</select></td>
		</tr>
	</table>
			<?php				
			break;
		default:
			echo "\n</table>";
			break;
	}
	// tabla plani_tipo_*
	switch ($tipo){
		case 10:
			?>
					<!-- Plani V heuristica -->
			<p class="titulo2">&nbsp;Paso # 3 - Completar esquema de planificaci&oacute;n 'V Heur&iacute;stica'</p>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#E0DFE3">
			  <tr align="center" valign="top">
			    <td colspan="3" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			      <tr>
			        <td width="20%">&nbsp;</td>
			        <td width="60%" align="center" valign="bottom"><div id="CollapsiblePanel_Preguntas" class="CollapsiblePanel">
			          <div class="CollapsiblePanelTab">Preguntas Centrales</div>
			          <div class="CollapsiblePanelContent">
			            <textarea name="editor_preguntas" id="editor_preguntas" cols="60" rows="10" class="mceAdvanced">Escriba aqu&iacute; las preguntas centrales.</textarea>
			          </div>
			        </div></td>
			        <td width="20%">&nbsp;</td>
			      </tr>
			    </table></td>
			    </tr>
			  <tr align="center" valign="top">
			    <td valign="bottom"><img src="images/bar_v_side.png" width="100%" height="10" /></td>
			    <td valign="bottom"><img src="images/bar_v_top.png" width="100%" height="10" /></td>
			    <td valign="bottom"><img src="images/bar_v_side.png" width="100%" height="10" /></td>
			  </tr>
			  <tr align="center" valign="middle">
			    <td width="30%" valign="top">
			      <div id="CollapsiblePanel_Conceptual" class="CollapsiblePanel">
			        <div class="CollapsiblePanelTab">Dominio Conceptual</div>
			            <div class="CollapsiblePanelContent">
			              <textarea name="editor_conceptual" id="editor_conceptual" cols="40" rows="20" class="mceAdvanced">Escriba aqu&iacute; la filosof&iacute;a.</textarea>
			        </div>
			    </div>    </td>
			    <td valign="top"><img src="images/bar_v_down.png" width="100%"/></td>
			    <td width="30%" valign="top">
			   	  <div id="CollapsiblePanel_Metodologia" class="CollapsiblePanel">
			        <div class="CollapsiblePanelTab">Dominio Metodol&oacute;gico</div>
			    	  <div class="CollapsiblePanelContent">
			    	    <textarea name="editor_metodologia" id="editor_metodologia" cols="40" rows="20" class="mceAdvanced">Escriba las afirmaciones de valor.</textarea>
				    </div>
			    </div>	</td>
			  </tr>
			  <tr align="center" valign="top">
			    <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			      <tr>
			        <td width="20%">&nbsp;</td>
			        <td width="60%" align="center" valign="top"><div id="CollapsiblePanel_Acontecimientos" class="CollapsiblePanel">
			          <div class="CollapsiblePanelTab">Acontecimientos - Objetos</div>
			          <div class="CollapsiblePanelContent">
			            <textarea name="editor_acontecimientos" id="editor_acontecimientos" cols="60" rows="10" class="mceAdvanced">Escriba aqu&iacute; los objetos.</textarea>
			          </div>
			        </div></td>
			        <td width="20%">&nbsp;</td>
			      </tr>
			    </table></td>
			    </tr>
			</table>
		
			<script type="text/javascript">
				var CollapsiblePanel_Conceptual = new Spry.Widget.CollapsiblePanel("CollapsiblePanel_Conceptual");
				var CollapsiblePanel_Metodologia = new Spry.Widget.CollapsiblePanel("CollapsiblePanel_Metodologia");
				var CollapsiblePanel_Preguntas = new Spry.Widget.CollapsiblePanel("CollapsiblePanel_Preguntas");
				var CollapsiblePanel_Acontecimientos= new Spry.Widget.CollapsiblePanel("CollapsiblePanel_Acontecimientos");
			</script>	
			<?php
			break;

		case 20:
			?>
					<!-- Plani tipo T -->
			<p class="titulo2">&nbsp;Paso # 3 - Completar esquema de planificaci&oacute;n 'tipo T'</p>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr bgcolor="#E0DFE3">
			    <td colspan="3" bgcolor="#000000">&nbsp;</td>
			  </tr>
			  <tr>
			    <td align="center" valign="top"><div id="CollapsiblePanel_Contenidos" class="CollapsiblePanel">
			      <div class="CollapsiblePanelTab">Contenidos Conceptuales</div>
			      <div class="CollapsiblePanelContent">
			        <textarea name="editor_contenidos" id="editor_contenidos" cols="40" rows="10" class="mceAdvanced">Escriba aqu&iacute; los contenidos conceptuales</textarea>
			      </div>
			    </div></td>
			    <td bgcolor="#000000">&nbsp;</td>
			    <td align="center" valign="top"><div id="CollapsiblePanel_Procedimientos" class="CollapsiblePanel">
			      <div class="CollapsiblePanelTab">Procedimientos - Estrategias</div>
			      <div class="CollapsiblePanelContent">
			        <textarea name="editor_procedimientos" id="editor_procedimientos" cols="40" rows="10" class="mceAdvanced">Escriba aqu&iacute; los procedimientos y estrategias</textarea>
			      </div>
			    </div></td>
			  </tr>
			  
			  <tr>
			    <td height="1" colspan="3" bgcolor="#000000">&nbsp;</td>
			  </tr>
			  <tr>
			    <td align="center" valign="top"><div id="CollapsiblePanel_Capacidades" class="CollapsiblePanel">
			      <div class="CollapsiblePanelTab">Capacidades - Destrezas</div>
			      <div class="CollapsiblePanelContent">
			        <textarea name="editor_capacidades" id="editor_capacidades" cols="40" rows="10" class="mceAdvanced">Escriba aqu&iacute; las capacidades y destrezas</textarea>
			      </div>
			    </div></td>
			    <td bgcolor="#000000">&nbsp;</td>
			    <td align="center" valign="top"><div id="CollapsiblePanel_Valores" class="CollapsiblePanel">
			      <div class="CollapsiblePanelTab">Valores - Actitudes</div>
			      <div class="CollapsiblePanelContent">
			        <textarea name="editor_valores" id="editor_valores" cols="40" rows="10" class="mceAdvanced">Escriba aqu&iacute; los valores y actitides</textarea>
			      </div>
			    </div></td>
			  </tr>
			  <tr bgcolor="#000000">
			    <td colspan="3">&nbsp;</td>
			  </tr>
			</table>
			<script type="text/javascript">
				var CollapsiblePanel_Contenidos = new Spry.Widget.CollapsiblePanel("CollapsiblePanel_Contenidos");
				var CollapsiblePanel_Capacidades = new Spry.Widget.CollapsiblePanel("CollapsiblePanel_Capacidades");
				var CollapsiblePanel_Procedimientos = new Spry.Widget.CollapsiblePanel("CollapsiblePanel_Procedimientos");
				var CollapsiblePanel_Valores = new Spry.Widget.CollapsiblePanel("CollapsiblePanel_Valores");
			</script>
			<?php
			break;
			
	case 30:
		switch ($momento){
			case 20:
				?>
					<!-- Plani tipo Trayecto Unidad -->
				<p class="titulo2">&nbsp;Paso # 3 - Completar esquema de planificaci&oacute;n 'Trayecto'</p>

						<p class="titulo1">Matriz Metas de Aprendizaje</p>
						<p class="titulo2">A. Organizaci&oacute;n de las Metas y su Evaluaci&oacute;n</p>
						<table width="55%" border="0" cellpadding="0" cellspacing="0">
						  <tr>
						    <td width="25%" height="30" class="texto1"><label>Unidad tem&aacute;tica:</label></td>
						    <td width="75%" class="texto2"><textarea name="editor_unidad_t" cols="60" rows="2" id="editor_unidad_t" class="mceNoEditor" ></textarea></td>
						  </tr>
						  <tr>
						    <td height="60" class="texto1"><label>OFV:</label></td>
						    <td class="texto2"><textarea name="editor_ofv" cols="60" rows="3" id="editor_ofv" class="mceNoEditor" ></textarea></td>
						  </tr>
						  <tr>
						    <td height="60" class="texto1"><label>OFT:</label></td>
						    <td class="texto2"><textarea name="editor_oft" cols="60" rows="3" id="editor_oft" class="mceNoEditor" ></textarea></td>
						  </tr>
						  <tr>
						    <td height="60" class="texto1"><label>CMO:</label></td>
						    <td class="texto2"><textarea name="editor_cmo" cols="60" rows="3" id="editor_cmo" class="mceNoEditor" ></textarea></td>
						  </tr>
						  <tr>
						    <td height="60" class="texto1"><label>Meta de aprendizaje u objetivo de la unidad:</label></td>
						    <td class="texto2"><textarea name="editor_meta_a" cols="60" rows="3" id="editor_meta_a" class="mceEditor"></textarea></td>
						  </tr>
						  <tr>
						    <td height="90" colspan="2"><textarea name="editor_matriz" cols="90" rows="10" id="editor_matriz" class="mceAdvanced">
						    	<table class="texto3" width="80%" border="1" cellspacing="0" cellpadding="0">
						      <tr>
						        <td scope="col">Metas de Clase u Objetivos de Clase</td>
						        <td colspan="3" scope="col">Desglose de Contenidos</td>
						        <td scope="col">Sesi&oacute;n / Fecha</td>
						      </tr>
						      <tr>
						        <td>&nbsp;</td>
						        <td>Conceptuales</td>
						        <td>Procedimentales</td>
						        <td>Actitudinales</td>
						        <td>&nbsp;</td>
						      </tr>
						      <tr>
						        <td>1</td>
						        <td>&nbsp;</td>
						        <td>&nbsp;</td>
						        <td>&nbsp;</td>
						        <td>&nbsp;</td>
						      </tr>
						      <tr>
						        <td>2</td>
						        <td>&nbsp;</td>
						        <td>&nbsp;</td>
						        <td>&nbsp;</td>
						        <td>&nbsp;</td>
						      </tr>
						    </table></textarea></td>
						  </tr>
						</table>
						<p class="titulo2">B. Red de Contenidos Conceptuales</p></div>
						    <table width="55%" border="0" cellpadding="0" cellspacing="0">
						      <tr>
						        <td width="25%" height="60" class="texto1">Temas fundamentales de la unidad:</td>
						        <td width="75%" class="texto2"><textarea name="editor_temas_f" cols="60" rows="3" id="editor_temas_f" class="mceNoEditor" ></textarea></td>
						      </tr>
						      <tr>
						        <td width="25%" height="60" class="texto1">Conceptos importantes tratados en cada una de las sesiones</td>
						        <td width="75%" class="texto2"><textarea name="editor_conceptos_i" cols="60" rows="3" id="editor_conceptos_i" class="mceNoEditor" ></textarea></td>
						      </tr>
						      <tr>
						        <td width="25%" height="60" class="texto1"><label>Ideas claves extraidas de los textos</label></td>
						        <td width="75%" class="texto2"><textarea name="editor_ideas_c" cols="60" rows="3" id="editor_ideas_c"class="mceNoEditor" ></textarea></td>
						      </tr>
						      <tr>
						        <td width="25%" height="60" class="texto1"><label>Bibliograf&iacute;a consultada</label></td>
						        <td width="75%" class="texto2"><textarea name="editor_bibliografia" cols="60" rows="3" id="editor_bibliografia" class="mceNoEditor" ></textarea></td>
						      </tr>
						    </table>

						<p class="titulo1">Matriz Plan de Evaluaci&oacute;n de la Unidad</p>
						<p class="titulo2">A. Modalidad de Evaluaci&oacute;n de cada Meta u Objetivo de Clase</p>
						<textarea name="editor_matriz_ev" cols="90" rows="10" id="editor_matriz_ev" class="mceAdvanced">
							        <table class="texto3" width="100%" border="1" cellspacing="0" cellpadding="0">
							          <tr>
							            <td scope="col">Objetivos de Clase</td>
							            <td scope="col">Modalidad de Evaluaci&oacute;n</td>
							            <td scope="col">Actividad de Evaluaci&oacute;n</td>
							            <td scope="col">Instancia Evaluativa</td>
							            <td scope="col">Procedimientos</td>
							            <td scope="col">Instrumentos</td>
							            <td scope="col">Agentes</td>
							          </tr>
							          <tr>
							            <td>1</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							          </tr>
							          <tr>
							            <td>2</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							          </tr>
							          <tr>
							            <td>3</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							            <td>&nbsp;</td>
							          </tr>
							        </table></textarea>
							<p class="titulo2">B. Evaluaci&oacuten de la meta de Unidad u Objetivo de Unidad</p>
							    <table width="55%" border="0" cellpadding="0" cellspacing="0">
							      <tr>
							        <td width="25%" height="60" class="texto1"><label>Modalidad de evaluaci&oacute;n</label></td>
							        <td width="75%" class="texto2"><textarea name="editor_modalidad_e" cols="60" rows="2" id="editor_modalidad_e" class="mceNoEditor" ></textarea></td>
							      </tr>
							      <tr>
							        <td width="25%" height="60" class="texto1"><label>Actividad de evaluaci&oacute;n</label></td>
							        <td width="75%" class="texto2"><textarea name="editor_actividad_e" cols="60" rows="3" id="editor_actividad_e" class="mceNoEditor" ></textarea></td>
							      </tr>
							      <tr>
							        <td width="25%" height="60" class="texto1"><label>Instancia evaluativa</label></td>
							        <td width="75%" class="texto2"><textarea name="editor_instancia_e" cols="60" rows="3" id="editor_instancia_e" class="mceNoEditor" ></textarea></td>
							      </tr>
							      <tr>
							        <td width="25%" height="60" class="texto1"><label>Procedimientos</label></td>
							        <td width="75%" class="texto2"><textarea name="editor_procedimientos" cols="60" rows="3" id="editor_procedimientos" class="mceNoEditor" ></textarea></td>
							      </tr>
							      <tr>
							        <td width="25%" height="60" class="texto1"><label>Instrumentos</label></td>
							        <td width="75%" class="texto2"><textarea name="editor_instrumentos" cols="60" rows="3" id="editor_instrumentos" class="mceNoEditor" ></textarea></td>
							      </tr>
							      <tr>
							        <td width="25%" height="60" class="texto1">Agentes</td>
							        <td width="75%" class="texto2"><textarea name="editor_agentes" cols="60" rows="3" id="editor_agentes" class="mceNoEditor" ></textarea></td>
							      </tr>
							    </table>    
			<?php
			break;		
	
			case 30:
				?>
					<!-- Plani tipo Trayecto Clase -->
				<p class="titulo2">&nbsp;Paso # 3 - Completar esquema de planificaci&oacute;n 'Trayecto'</p>
				
				<p class="titulo2">A. Preparacion de la Ensenanza</p>
				      <table width="60%" border="0" cellpadding="0" cellspacing="0">
				        <tr>
				          <td height="30" colspan="2" class="texto1"><label>Unidad: </label>
				              <input type="text" name="editor_unidad" id="editor_unidad" size="80" class="mceNoEditor" /></td>
				        </tr>
				        <tr>
				          <td colspan="2">
				          	<table class="texto3" width="100%" border="0" cellspacing="0" cellpadding="0">
				            	<tr>
					                <td width="46%" height="30" class="texto1"><label>Sesi&oacute;n: </label>
					                    <input type="text" name="editor_sesion" id="editor_sesion" size="30" class="mceNoEditor" /></td>
					                <td width="29%" height="30" class="texto1"><label>Hora: </label>
					                    <label>
					                    <select name="select_hh" id="select_hh">
					                      <option value="8">08</option>
					                      <option value="9">09</option>
					                      <option value="10">10</option>
					                      <option value="11">11</option>
					                      <option value="12">12</option>
					                      <option value="13">13</option>
					                      <option value="14">14</option>
					                      <option value="15">15</option>
					                      <option value="16">16</option>
					                      <option value="17">17</option>
					                      <option value="18">18</option>
					                    </select>
					                    </label>
					                    <label>:</label>
					                    <label>
					                    <select name="select_mm" id="select_mm">
					                      <option value="0">00</option>
					                      <option value="5">05</option>
					                      <option value="10">10</option>
					                      <option value="15">15</option>
					                      <option value="20">20</option>
					                      <option value="25">25</option>
					                      <option value="30">30</option>
					                      <option value="35">35</option>
					                      <option value="40">40</option>
					                      <option value="45">45</option>
					                      <option value="50">50</option>
					                      <option value="55">55</option>
					                    </select>
					                    </label></td>
				             	 </tr>
				          	</table></td>
				        </tr>
				        <tr>
				          <td width="157" height="60" class="texto1"><label>Metas de Aprendizaje u Objetivos de la Unidad:</label></td>
				          <td width="411" height="45" class="texto2"><textarea name="editor_metas_a" cols="60" rows="3" id="editor_metas_a" class="mceNoEditor"></textarea></td>
				        </tr>
				        <tr>
				          <td height="60" class="texto1"><label>Objetivo Did&aacute;ctico de la sesi&oacute;n:</label></td>
				          <td height="40" class="texto2"><textarea name="editor_objetivo_d" cols="60" rows="3" id="editor_objetivo_d" class="mceNoEditor"></textarea></td>
				        </tr>
				        <tr>
				          <td height="20" colspan="2" class="texto1"><label>Contenidos:</label></td>
				        </tr>
				        <tr>
				          <td colspan="2" ><table border="0" cellspacing="0" cellpadding="0">
				              <tr>
				                <td>&nbsp;</td>
				                <td height="60" class="texto1"><label>Conceptuales: </label></td>
				                <td class="texto2"><textarea name="editor_c_conceptuales" cols="70" rows="3" id="editor_c_conceptuales" class="mceNoEditor"></textarea></td>
				              </tr>
				              <tr>
				                <td>&nbsp;</td>
				                <td height="60" class="texto1"><label>Procedimentales: </label></td>
				                <td class="texto2"><textarea name="editor_c_procedimentales" cols="70" rows="3" id="editor_c_procedimentales" class="mceNoEditor"></textarea></td>
				              </tr>
				              <tr>
				                <td>&nbsp;</td>
				                <td height="60" class="texto1"><label>Actitudinales:</label></td>
				                <td class="texto2"><textarea name="editor_c_actitudinales" cols="70" rows="3" id="editor_c_actitudinales" class="mceNoEditor"></textarea></td>
				              </tr>
				          </table></td>
				        </tr>
				        <tr>
				          <td colspan="2"><p class="texto3"><textarea name="editor_matriz" cols="90" rows="10" id="editor_matriz" class="mceAdvanced">
				   
				        <table class="texto3" width="80%" border="1" cellspacing="0" cellpadding="0">
				         <tr>
				          <td>Momento de la Clase</td>
				          <td>Actividades de Aprendizaje</td>
				          <td>Actividades de Ense&ntilde;anza (Intervenci&oacute;n Docente)</td>
				          <td>Recursos de Aprendizaje</td>
				          <td>Adecuaciones Curriculares</td>
				        </tr>
				        <tr>
				          <td>Inicio</td>
				          <td>&nbsp </td>
				          <td>&nbsp </td>
				          <td>&nbsp </td>
				          <td>&nbsp </td>
				        </tr>
				        <tr>
				          <td>Desarrollo</td>
				          <td>&nbsp </td>
				          <td>&nbsp </td>
				          <td>&nbsp </td>
				          <td>&nbsp </td>
				        </tr>
				        <tr>
				          <td>Cierre</td>
				          <td>&nbsp </td>
				          <td>&nbsp </td>
				          <td>&nbsp </td>
				          <td>&nbsp </td>
				        </tr>
				        <tr>
				          <td colspan="5"><p>Activides de Evaluacion:</p></td>
				        </tr>
				      </table></textarea></p>
				      </td>
				      </tr>
				      </table>
				<p class="titulo2">B. Analisis de la Ensenanza</p></div>
				        <table width="55%" border="0" cellpadding="0" cellspacing="0">
				          <tr>
				            <td width="25%" height="60" class="texto1">Modificaciones realizadas durante la clase:</td>
				            <td width="75%" class="texto2"><textarea name="editor_modificaciones" cols="60" rows="3" id="editor_modificaciones" class="mceNoEditor"></textarea></td>
				          </tr>
				          <tr>
				            <td height="60" class="texto1"><label>Fundamentacion de las modificaciones:</label></td>
				            <td class="texto2"><textarea name="editor_fundamentaciones" cols="60" rows="3" id="editor_fundamentaciones" class="mceNoEditor"></textarea></td>
				          </tr>
				        </table>
				<?php
				break;
		}
		break;
	}
?>
	<p class="titulo2">&nbsp;Paso # 4 - Si ya est&aacute; conforme con la planificaci&oacute;n ingresada, presione el bot&oacute;n  <input type="submit" value="Finalizar"></p>
</form>
<!-- Fin Planificaciones -->
	                              						</td>
	                            					</tr>
	                          					</table></td>
	                      				</tr>
	            					</table></td>
		                    </tr>
							<tr align="center" valign="middle"> 
	              					<td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2008</td>
	            			</tr>
	                  	</table></td>
				</tr>
			</table></td>
		<td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
	</tr>
</table>
</body>
</html>
<?php pg_close($conn);
?>
