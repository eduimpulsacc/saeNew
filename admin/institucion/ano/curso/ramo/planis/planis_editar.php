<?php
	require('../../../../../../util/header.inc');
	
	
function salida_abrupta($mensaje){
//  echo "<script>window.location = 'http://intranet.colegiointeractivo.com/sae3.0/session/finSession.php'";
	echo "<script language=\"javascript\" type=\"text/javascript\">
						alert(\"{$mensaje}\");
						</script>";	
	echo "<script>window.location = \"planificacion.php?id_ramo=".$_POST['id_ramo']."\"</script>";
	exit;
}
/*	//------------------------
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
*/
	//------------------------
	// verificar variables
	//------------------------
	if (!($_RAMO && $_CURSO && $_ANO && $_INSTIT && $_USUARIO)){
		salida_abrupta("Existe un error en la información ingresada. Reintente");
	} else {
		$id_ramo		= $_RAMO;
		$curso			= $_CURSO;
		$ano			= $_ANO;
		$institucion	= $_INSTIT;
		$usuario		= $_USUARIO;
	}
		
	if (!is_numeric(($_POST["id_plani"]))){
		salida_abrupta("No se transmitió correctamente la información desde la página anterior. Por favor vuelva a intentarlo");
	} else
		$id_plani = $_POST["id_plani"];
	
	//------------------------
	// actualizar en tabla plani
	//------------------------
	if (($nombre = pg_escape_string($_POST['text_nombre'])) != "" ){
		$update_plani .= "nombre = '$nombre', ";
	}
	if (($descripcion = pg_escape_string($_POST['text_descripcion'])) != "" ){
		$update_plani .= "descripcion = '$descripcion', ";
	}		

	if ( ($dia_inicio = pg_escape_string($_POST['text_dia_inicio'])) != "" &&
			($mes_inicio = pg_escape_string($_POST['text_mes_inicio'])) != "" &&
			($ano_inicio = pg_escape_string($_POST['text_ano_inicio'])) != ""){
		if (is_numeric($dia_inicio) && is_numeric($mes_inicio) && is_numeric($ano_inicio)){
			if (checkdate($mes_inicio, $dia_inicio, $ano_inicio)){
				$update_plani .= "fecha_inicio = '$dia_inicio/$mes_inicio/$ano_inicio', ";
				$fecha_inicio="$dia_inicio/$mes_inicio/$ano_inicio";
			}
		}
	}

	if ( ($dia_fin = pg_escape_string($_POST['text_dia_fin'])) != "" &&
			($mes_fin = pg_escape_string($_POST['text_mes_fin'])) != "" &&
			($ano_fin = pg_escape_string($_POST['text_ano_fin'])) != ""){
		if (is_numeric($dia_fin) && is_numeric($mes_fin) && is_numeric($ano_fin)){
			if (checkdate($mes_fin, $dia_fin, $ano_fin)){
				$update_plani .= "fecha_fin = '$dia_fin/$mes_fin/$ano_fin', ";
				$fecha_fin="$dia_fin/$mes_fin/$ano_fin";
			}
		}
	}
	
	if ( ($dia_abor = pg_escape_string($_POST['text_dia_abor'])) != "" &&
			($mes_abor = pg_escape_string($_POST['text_mes_abor'])) != "" &&
			($ano_abor = pg_escape_string($_POST['text_ano_abor'])) != ""){
		if (is_numeric($dia_abor) && is_numeric($mes_abor) && is_numeric($ano_abor)){
			if (checkdate($mes_abor, $dia_abor, $ano_abor)){
				$update_plani .= "fecha_abordaje = '$dia_abor/$mes_abor/$ano_abor', ";
				$fecha_abordaje="$dia_abor/$mes_abor/$ano_abor";
			}
		}
	}
	
	echo "fechas------->"."<br>"."<br>".$fecha_inicio.'-'.$fecha_fin.'-'.$fecha_abordaje;

	
	if (($fecha_abordaje>=$fecha_inicio) and ($fecha_abordaje<=$fecha_fin))
	 {
	 
		 if ($fecha_abordaje>$fecha_fin) 
		 {
		 $update_plani .= "estado='No Cumplido', ";
		 
		 }
		 else
		 $update_plani .= "estado='Cumplido', ";
	 }
	
	
	
	
	if ( (strlen($fecha_inicio)<1) or (strlen($fecha_fin)<1) or (strlen($fecha_abordaje)<1))
	{
	 $update_plani .= "estado='Pendiente', ";
	 }else

	if ($fecha_abordaje>$fecha_fin)
	{
	 $update_plani .= "estado='No Cumplido', ";
	 }else
	
	if (($fecha_abordaje<=$fecha_inicio))
	 $update_plani .= "estado='Cumplido', ";
	
	
	if (($avance = pg_escape_string($_POST['text_avance'])) != "" ){
			if (is_numeric($avance)){
				if ($avance > 100)
						$avance = 100;
					$update_plani .= "avance = '$avance', ";	
			}
	}
	
	if (($logro = pg_escape_string($_POST['text_logro'])) != "" ){
			if (is_numeric($logro)){
				if ($logro > 100)
					$logro = 100;
				$update_plani .= "logro = '$logro', ";	
			}
	}
	
	// actualizar fechas en plani
	if ($update_plani != ""){
		 $sql_update_plani = "SET DateStyle TO 'SQL, dmy'; UPDATE plani SET $update_plani fecha_modificacion = 'now' WHERE id_plani = $id_plani";
		$result_update = @pg_Exec($conn, $sql_update_plani) or salida_abrupta("No se pudo actualizar la información");
	}
	
	// obtener tipo y momento
	$sql_select_tipo= "SELECT tipo, momento FROM plani WHERE id_plani=$id_plani";
	$result_select_tipo = @pg_Exec($conn, $sql_select_tipo) or salida_abrupta("No se pudo obtener información de la planificación");
	if (pg_numrows($result_select_tipo) == 1){
		if ($result_sql = @pg_fetch_array($result_select_tipo, 0, PGSQL_ASSOC)){
			$tipo = $result_sql['tipo'];
			$momento = $result_sql['momento'];
		}
	} else salida_abrupta("No se encontró la planificación");

	// obtener detalle
	switch ($tipo){
		// v heuristica
		case 10:
			$sql_select_v= "SELECT preguntas,
									conceptual,
									metodologia,
									acontecimientos
								FROM Plani_V
								WHERE id_plani=$id_plani";
			$result_select_v = @pg_Exec($conn, $sql_select_v) or salida_abrupta ("No se pudo obtener planificación tipo V heurística");
			if (pg_numrows($result_select_v) == 1){
				if ($result_v = @pg_fetch_array($result_select_v, 0, PGSQL_ASSOC)){
					$plani_preguntas = $result_v['preguntas'];
					$plani_conceptual = $result_v['conceptual'];
					$plani_metodologia = $result_v['metodologia'];
					$plani_acontecimientos = $result_v['acontecimientos'];
				}
			}
			break;
			
		// tipo t
		case 20:
			$sql_select_t= "SELECT contenidos,
									procedimientos,
									capacidades,
									valores
								FROM Plani_T
								WHERE id_plani=$id_plani";
			$result_select_t = @pg_Exec($conn, $sql_select_t) or salida_abrupta ("No se pudo obtener planificación tipo T");
			if (pg_numrows($result_select_t) == 1){
				if ($result_t = @pg_fetch_array($result_select_t, 0, PGSQL_ASSOC)){
					$plani_contenidos = $result_t['contenidos'];
					$plani_procedimientos = $result_t['procedimientos'];
					$plani_capacidades = $result_t['capacidades'];
					$plani_valores = $result_t['valores'];
				}
			}
			break;
		
		// de trayecto		
		case 30:
				// de unidad
			if ($momento == 20){
				$sql_select_t= "SELECT unidad_t,
										ofv,
										oft,
										cmo,
										meta_a,
										matriz,
										temas_f,
										conceptos_i,
										ideas_c,
										bibliografia,
										matriz_ev,
										modalidad_e,
										actividad_e,
										instancia_e,
										prodedimientos,
										instrumentos,
										agentes
								FROM Plani_Trayecto_Unidad
								WHERE id_plani=$id_plani";
				$result_select_t = @pg_Exec($conn, $sql_select_t) or salida_abrupta ("No se pudo obtener planificación de Trayecto Unidad");
				if (pg_numrows($result_select_t) == 1){
					if ($result_t = @pg_fetch_array($result_select_t, 0, PGSQL_ASSOC)){
						$unidad_t = $result_t['unidad_t'];
						$ofv = $result_t['ofv'];
						$oft = $result_t['oft'];
						$cmo = $result_t['cmo'];
						$meta_a = $result_t['meta_a'];
						$matriz = $result_t['matriz'];
						$temas_f = $result_t['temas_f'];
						$conceptos_i = $result_t['conceptos_i'];
						$ideas_c = $result_t['ideas_c'];
						$bibliografia = $result_t['bibliografia'];
						$matriz_ev = $result_t['matriz_ev'];
						$modalidad_e = $result_t['modalidad_e'];
						$actividad_e = $result_t['actividad_e'];
						$instancia_e = $result_t['instancia_e'];
						$prodedimientos = $result_t['prodedimientos'];
						$instrumentos = $result_t['instrumentos'];
						$agentes = $result_t['agentes'];
					}
				}
			}
				// de clase
			else if ($momento == 30){
				$sql_select_t= "SELECT unidad,
										sesion,
										hh,
										mm,
										metas_a,
										objetivo_d,
										c_conceptuales,
										c_procedimentales,
										c_actitudinales,
										matriz,
										modificaciones,
										fundamentaciones
								FROM Plani_Trayecto_Clase
								WHERE id_plani=$id_plani";
				$result_select_t = @pg_Exec($conn, $sql_select_t) or salida_abrupta ("No se pudo obtener planificación de Trayecto Clase");
				if (pg_numrows($result_select_t) == 1){
					if ($result_t = @pg_fetch_array($result_select_t, 0, PGSQL_ASSOC)){
						$unidad = $result_t['unidad'];
						$sesion = $result_t['sesion'];
						$hh = $result_t['hh'];
						$mm = $result_t['mm'];
						$metas_a = $result_t['metas_a'];
						$objetivo_d = $result_t['objetivo_d'];
						$c_conceptuales = $result_t['c_conceptuales'];
						$c_procedimentales = $result_t['c_procedimentales'];
						$c_actitudinales = $result_t['c_actitudinales'];
						$matriz = $result_t['matriz'];
						$modificaciones = $result_t['modificaciones'];
						$fundamentaciones = $result_t['fundamentaciones'];
					}
				}
			}
			break;
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
	<meta http-equiv="Content-Type" content="text/html"; charset="iso-8859-1">
	
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
			<td width="30%" class="texto1">&nbsp;&nbsp;Nombre: </td>
			<td colspan="3" class="texto2"><label><input readonly name="text_nombre" id="text_nombre" type="text" size="50" value="<?php echo $nombre ?>" ></label></td>
		</tr>
		<tr>
			<td class="texto1">&nbsp;&nbsp;Descripci&oacute;n: </td>
			<td colspan="3" class="texto2"><label><textarea readonly name="text_descripcion" id="text_descripcion" cols="50" rows="3"><?php echo $descripcion ?></textarea></label></td>
		</tr>
		<tr>
			<td class="texto1">&nbsp;&nbsp;Momento Pedag&oacute;gico: </td>
			<td class="texto2"><label><input readonly name="text_nombre" id="text_nombre" type="text" size="5" value="<?php 
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
			<td class="texto1">&nbsp;&nbsp;Tipo de Planificaci&oacute;n: </td>
			<td class="texto2"><label><input readonly name="text_nombre" id="text_nombre" type="text" size="10" value="<?php 
			switch ($tipo) {
				case 10:
					echo "V Heurística";
					break;
				case 20:
					echo "Tipo T";
					break;
				case 30:
					echo "de Trayecto";
					break;
			} ?>"></label></td>
		</tr>
		<tr>
			<td width="30%" class="texto1">&nbsp;&nbsp;Per&iacute;odo de aplicaci&oacute;n:</td>
			<td align="left" class="texto2">desde el&nbsp;<input readonly type="text" name="text_dia_inicio" id="text_dia_inicio" size=1 value="<?php echo $dia_inicio; ?>"><input readonly type="text" name="text_mes_inicio" id="text_mes_inicio" size=1 value="<?php echo $mes_inicio; ?>"><input readonly type="text" name="text_ano_inicio" id="text_ano_inicio" size=2 value="<?php echo $ano_inicio; ?>"></td>
			<td colspan="2"align="left" class="texto2">hasta el&nbsp;<input readonly type="text" name="text_dia_fin" id="text_dia_fin" size=1 value="<?php echo $dia_fin; ?>"><input readonly type="text" name="text_mes_fin" id="text_mes_fin" size=1 value="<?php echo $mes_fin; ?>"><input readonly type="text" name="text_ano_fin" id="text_ano_fin" size=2 value="<?php echo $ano_fin; ?>"></td>
		</tr>
		<tr>
		  <td class="texto1">&nbsp;&nbsp;Fecha de Abordaje:</td>
		  <td colspan="3" align="left" class="texto2">
		  <input readonly  type="text" name="text_dia_abor" id="text_dia_abor" size=1 value="<?php echo $dia_abor; ?>"><input readonly type="text" name="text_mes_abor" id="text_mes_abor" size=1 value="<?php echo $mes_abor; ?>"><input readonly type="text" name="text_ano_abor" id="text_ano_abor" size=2 value="<?php echo $ano_abor; ?>">
		  </td>
		  </tr>
	</table>
	
<!-- Form detalle plani -->

<form name="form_detalles" id="form_detalles" method="post" action="planis_actualizar.php">
	<input type="hidden" name="id_plani" id="id_plani" value='<?php echo $id_plani; ?>' >
	<input type="hidden" name="id_ramo" id="id_ramo" value='<?php echo $id_ramo; ?>' >
	<hr>
	<?php
	switch ($tipo){
		// Plani V heuristica
		case 10:
			?>
	<p class="titulo2">&nbsp;Paso # 2 - Completar esquema de planificaci&oacute;n 'V Heur&iacute;stica'</p>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#E0DFE3">
	  <tr align="center" valign="top">
	    <td colspan="3" valign="bottom"><table width="100%" border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td width="20%">&nbsp;</td>
	        <td width="60%" align="center" valign="bottom"><div id="CollapsiblePanel_Preguntas" class="CollapsiblePanel">
	          <div class="CollapsiblePanelTab">Preguntas Centrales</div>
	          <div class="CollapsiblePanelContent">
	            <textarea name="editor_preguntas" id="editor_preguntas" cols="60" rows="10" class="mceAdvanced"><?php echo $plani_preguntas; ?></textarea>
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
	              <textarea name="editor_conceptual" id="editor_conceptual" cols="40" rows="20" class="mceAdvanced"><?php echo $plani_conceptual; ?></textarea>
	        </div>
	    </div>    </td>
	    <td valign="top"><img src="images/bar_v_down.png" width="100%"/></td>
	    <td width="30%" valign="top">
	   	  <div id="CollapsiblePanel_Metodologia" class="CollapsiblePanel">
	        <div class="CollapsiblePanelTab">Dominio Metodol&oacute;gico</div>
	    	  <div class="CollapsiblePanelContent">
	    	    <textarea name="editor_metodologia" id="editor_metodologia" cols="40" rows="20" class="mceAdvanced"><?php echo $plani_metodologia; ?></textarea>
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
	            <textarea name="editor_acontecimientos" id="editor_acontecimientos" cols="60" rows="10" class="mceAdvanced"><?php echo $plani_acontecimientos; ?></textarea>
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
			
		// Plani tipo T	
		case 20:
			?> 
	<p class="titulo2">&nbsp;Paso # 2 - Completar esquema de planificaci&oacute;n 'tipo T'</p>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr bgcolor="#E0DFE3">
	    <td colspan="3" bgcolor="#000000">&nbsp;</td>
	  </tr>
	  <tr>
	    <td align="center" valign="top"><div id="CollapsiblePanel_Contenidos" class="CollapsiblePanel">
	      <div class="CollapsiblePanelTab">Contenidos Conceptuales</div>
	      <div class="CollapsiblePanelContent">
	        <textarea name="editor_contenidos" id="editor_contenidos" cols="40" rows="10" class="mceAdvanced"><?php echo $plani_contenidos; ?></textarea>
	      </div>
	    </div></td>
	    <td bgcolor="#000000">&nbsp;</td>
	    <td align="center" valign="top"><div id="CollapsiblePanel_Procedimientos" class="CollapsiblePanel">
	      <div class="CollapsiblePanelTab">Procedimientos - Estrategias</div>
	      <div class="CollapsiblePanelContent">
	        <textarea name="editor_procedimientos" id="editor_procedimientos" cols="40" rows="10" class="mceAdvanced"><?php echo $plani_procedimientos; ?></textarea>
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
	        <textarea name="editor_capacidades" id="editor_capacidades" cols="40" rows="10" class="mceAdvanced"><?php echo $plani_capacidades; ?></textarea>
	      </div>
	    </div></td>
	    <td bgcolor="#000000">&nbsp;</td>
	    <td align="center" valign="top"><div id="CollapsiblePanel_Valores" class="CollapsiblePanel">
	      <div class="CollapsiblePanelTab">Valores - Actitudes</div>
	      <div class="CollapsiblePanelContent">
	        <textarea name="editor_valores" id="editor_valores" cols="40" rows="10" class="mceAdvanced"><?php echo $plani_valores; ?></textarea>
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
			
		// Plani de Trayecto	
		case 30:
			// de unidad
			if ($momento == 20){
			?>
	<p class="titulo2">&nbsp;Paso # 2 - Completar esquema de planificaci&oacute;n 'de Trayecto'</p>			
		<p class="titulo1">Matriz Metas de Aprendizaje</p>
			<p class="titulo2">A. Organizaci&oacute;n de las Metas y su Evaluaci&oacute;n</p>
			<table width="55%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			    <td width="25%" height="30" class="texto1"><label>Unidad tem&aacute;tica:</label></td>
			    <td width="75%"><textarea name="editor_unidad_t" cols="60" rows="2" id="editor_unidad_t" class="mceNoEditor" ><?php echo $unidad_t; ?></textarea></td>
			  </tr>
			  <tr>
			    <td height="60" class="texto1"><label>OFV:</label></td>
			    <td><textarea name="editor_ofv" cols="60" rows="3" id="editor_ofv" class="mceNoEditor" ><?php echo $ofv; ?></textarea></td>
			  </tr>
			  <tr>
			    <td height="60" class="texto1"><label>OFT:</label></td>
			    <td><textarea name="editor_oft" cols="60" rows="3" id="editor_oft" class="mceNoEditor" ><?php echo $oft; ?></textarea></td>
			  </tr>
			  <tr>
			    <td height="60" class="texto1"><label>CMO:</label></td>
			    <td><textarea name="editor_cmo" cols="60" rows="3" id="editor_cmo" class="mceNoEditor" ><?php echo $cmo; ?></textarea></td>
			  </tr>
			  <tr>
			    <td height="60" class="texto1"><label>Meta de aprendizaje u objetivo de la unidad:</label></td>
			    <td><<textarea name="editor_meta_a" cols="60" rows="3" id="editor_meta_a" class="mceEditor"><?php echo $meta_a; ?></textarea></td>
			  </tr>
			  <tr>
			    <td height="90" colspan="2"><<textarea name="editor_matriz" cols="90" rows="10" id="editor_matriz" class="mceAdvanced"><?php echo $matriz; ?></textarea></td>
			  </tr>
			</table>
		<p class="titulo2">B. Red de Contenidos Conceptuales</p>
		    <table width="55%" border="0" cellpadding="0" cellspacing="0">
			      <tr>
			        <td width="25%" height="60" class="texto1">Temas fundamentales de la unidad:</td>
			        <td width="75%" ><textarea name="editor_temas_f" cols="60" rows="3" id="editor_temas_f" class="mceNoEditor" ><?php echo $temas_f; ?></textarea></td>
			      </tr>
			      <tr>
			        <td width="25%" height="60" class="texto1">Conceptos importantes tratados en cada una de las sesiones</td>
			        <td width="75%"><textarea name="editor_conceptos_i" cols="60" rows="3" id="editor_conceptos_i" class="mceNoEditor" ><?php echo $conceptos_i; ?></textarea></td>
			      </tr>
			      <tr>
			        <td width="25%" height="60" class="texto1"><label>Ideas claves extraidas de los textos</label></td>
			        <td width="75%"><textarea name="editor_ideas_c" cols="60" rows="3" id="editor_ideas_c"class="mceNoEditor" ><?php echo $ideas_c; ?></textarea></td>
			      </tr>
			      <tr>
			        <td width="25%" height="60" class="texto1"><label>Bibliograf&iacute;a consultada</label></td>
			        <td width="75%"><textarea name="editor_bibliografia" cols="60" rows="3" id="editor_bibliografia" class="mceNoEditor" ><?php echo $bibliografia; ?></textarea></td>
			      </tr>
			    </table>
			    
		<hr>
		<p class="titulo1">Matriz Plan de Evaluaci&oacute;n de la Unidad</p>
			<p class="titulo2">A. Modalidad de Evaluaci&oacute;n de cada Meta u Objetivo de Clase</p>
			<textarea name="editor_matriz_ev" cols="90" rows="10" id="editor_matriz_ev" class="mceAdvanced"><?php echo $matriz_ev; ?></textarea>
			<p class="titulo2">B. Evaluaci&oacuten de la meta de Unidad u Objetivo de Unidad</p>
			    <table width="55%" border="0" cellpadding="0" cellspacing="0">
			      <tr>
			        <td width="25%" height="60" class="texto1"><label>Modalidad de evaluaci&oacute;n</label></td>
			        <td width="75%"><textarea name="editor_modalidad_e" cols="60" rows="2" id="editor_modalidad_e" class="mceNoEditor" ><?php echo $modalidad_e; ?></textarea></td>
			      </tr>
			      <tr>
			        <td width="25%" height="60" class="texto1"><label>Actividad de evaluaci&oacute;n</label></td>
			        <td width="75%"><textarea name="editor_actividad_e" cols="60" rows="3" id="editor_actividad_e" class="mceNoEditor" ><?php echo $actividad_e; ?></textarea></td>
			      </tr>
			      <tr>
			        <td width="25%" height="60" class="texto1"><label>Instancia evaluativa</label></td>
			        <td width="75%"><textarea name="editor_instancia_e" cols="60" rows="3" id="editor_instancia_e" class="mceNoEditor" ><?php echo $instancia_e; ?></textarea></td>
			      </tr>
			      <tr>
			        <td width="25%" height="60" class="texto1"><label>Procedimientos</label></td>
			        <td width="75%"><textarea name="editor_procedimientos" cols="60" rows="3" id="editor_procedimientos" class="mceNoEditor" ><?php echo $prodedimientos; ?></textarea></td>
			      </tr>
			      <tr>
			        <td width="25%" height="60" class="texto1"><label>Instrumentos</label></td>
			        <td width="75%"><textarea name="editor_instrumentos" cols="60" rows="3" id="editor_instrumentos" class="mceNoEditor" ><?php echo $instrumentos; ?></textarea></td>
			      </tr>
			      <tr>
			        <td width="25%" height="60" class="texto1">Agentes</td>
			        <td width="75%"><textarea name="editor_agentes" cols="60" rows="3" id="editor_agentes" class="mceNoEditor" ><?php echo $agentes; ?></textarea></td>
			      </tr>
			    </table>			

			<?php
			}
			// de clase
			elseif ($momento == 30){
			?>
	<p class="titulo2">&nbsp;Paso # 2 - Completar esquema de planificaci&oacute;n 'de Trayecto'</p>		
		<p class="titulo2">A. Preparaci&oacute;n de la Ense&ntilde;anza</p>
		<table width="60%" border="0" cellpadding="0" cellspacing="0">
			<tr>
		      <td height="30" colspan="2" class="texto1"><label>Unidad: </label>
		          <input type="text" name="editor_unidad" id="editor_unidad" size="80" class="mceNoEditor" value="<?php echo $unidad; ?>" /></td>
		    </tr>
		    <tr>
		      <td colspan="2">
		      	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		        	<tr>
		                <td width="46%" height="30" class="texto1"><label>Sesi&oacute;n: </label>
		                    <input type="text" name="editor_sesion" id="editor_sesion" size="30" class="mceNoEditor" value="<?php echo $sesion; ?>" /></td>
		                <td width="29%" height="30" class="texto1"><label>Hora: </label>
		                    <label>
		                    <select name="select_hh" id="select_hh">
		                      <option <?php if ($hh == 8) echo "selected"; ?> value="8">08</option>
		                      <option <?php if ($hh == 9) echo "selected"; ?> value="9">09</option>
		                      <option <?php if ($hh == 10) echo "selected"; ?> value="10">10</option>
		                      <option <?php if ($hh == 11) echo "selected"; ?> value="11">11</option>
		                      <option <?php if ($hh == 12) echo "selected"; ?> value="12">12</option>
		                      <option <?php if ($hh == 13) echo "selected"; ?> value="13">13</option>
		                      <option <?php if ($hh == 14) echo "selected"; ?> value="14">14</option>
		                      <option <?php if ($hh == 15) echo "selected"; ?> value="15">15</option>
		                      <option <?php if ($hh == 16) echo "selected"; ?> value="16">16</option>
		                      <option <?php if ($hh == 17) echo "selected"; ?> value="17">17</option>
		                      <option <?php if ($hh == 18) echo "selected"; ?> value="18">18</option>
		                    </select>
		                    </label>
		                    <label>:</label>
		                    <label>
		                    <select name="select_mm" id="select_mm">
		                      <option value="0" <?php if ($mm == 0) echo "selected"; ?> >00</option>
		                      <option value="5" <?php if ($mm == 5) echo "selected"; ?> >05</option>
		                      <option value="10" <?php if ($mm == 10) echo "selected"; ?> >10</option>
		                      <option value="15" <?php if ($mm == 15) echo "selected"; ?> >15</option>
		                      <option value="20" <?php if ($mm == 20) echo "selected"; ?> >20</option>
		                      <option value="25" <?php if ($mm == 25) echo "selected"; ?> >25</option>
		                      <option value="30" <?php if ($mm == 30) echo "selected"; ?> >30</option>
		                      <option value="35" <?php if ($mm == 35) echo "selected"; ?> >35</option>
		                      <option value="40" <?php if ($mm == 40) echo "selected"; ?> >40</option>
		                      <option value="45" <?php if ($mm == 45) echo "selected"; ?> >45</option>
		                      <option value="50" <?php if ($mm == 50) echo "selected"; ?> >50</option>
		                      <option value="55" <?php if ($mm == 55) echo "selected"; ?> >55</option>
		                    </select>
		                    </label></td>
		         	 </tr>
		      	</table></td>
		    </tr>
		    <tr>
		      <td width="157" height="60" class="texto1"><label>Metas de aprendizaje u objetivos de la unidad:</label></td>
		      <td width="411" height="45" ><textarea name="editor_metas_a" cols="60" rows="3" id="editor_metas_a" class="mceNoEditor"><?php echo $metas_a; ?></textarea></td>
		    </tr>
		    <tr>
		      <td height="60" class="texto1"><label>Objetivo did&aacute;ctico de la sesi&oacute;n:</label></td>
		      <td height="40"><textarea name="editor_objetivo_d" cols="60" rows="3" id="editor_objetivo_d" class="mceNoEditor"><?php echo $objetivo_d; ?></textarea></td>
		    </tr>
		    <tr>
		      <td height="20" colspan="2" class="texto1"><label>Contenidos:</label></td>
		    </tr>
		    <tr>
		      <td colspan="2" ><table border="0" cellspacing="0" cellpadding="0">
		          <tr>
		            <td>&nbsp;</td>
		            <td height="60" class="texto1"><label>Conceptuales: </label></td>
		            <td><textarea name="editor_c_conceptuales" cols="70" rows="3" id="editor_c_conceptuales" class="mceNoEditor"><?php echo $c_conceptuales; ?></textarea></td>
		          </tr>
		          <tr>
		            <td>&nbsp;</td>
		            <td height="60" class="texto1"><label>Procedimentales: </label></td>
		            <td><textarea name="editor_c_procedimentales" cols="70" rows="3" id="editor_c_procedimentales" class="mceNoEditor"><?php echo $c_procedimentales; ?></textarea></td>
		          </tr>
		          <tr>
		            <td>&nbsp;</td>
		            <td height="60" class="texto1"><label>Actitudinales: </label></td>
		            <td><textarea name="editor_c_actitudinales" cols="70" rows="3" id="editor_c_actitudinales" class="mceNoEditor"><?php echo $c_actitudinales; ?></textarea></td>
		          </tr>
		      </table></td>
		    </tr>
		    <tr>
			      <td colspan="2" ><p class="texto3"><textarea name="editor_matriz" cols="90" rows="10" id="editor_matriz" class="mceAdvanced"><?php echo $matriz; ?></p></textarea>
				  </td>
			</tr>
		</table>
		<p class="titulo2">B. An&aacute;lisis de la Ense&ntilde;anza</p>
	    <table width="55%" border="0" cellpadding="0" cellspacing="0">
	      <tr>
	        <td width="25%" height="60" class="texto1">Modificaciones realizadas durante la clase:</td>
	        <td width="75%" ><textarea name="editor_modificaciones" cols="60" rows="3" id="editor_modificaciones" class="mceNoEditor"><?php echo $modificaciones; ?></textarea></td>
	      </tr>
	      <tr>
	        <td height="60" class="texto1"><label>Fundamentaci&oacute;n de las modificaciones:</label></td>
	        <td><textarea name="editor_fundamentaciones" cols="60" rows="3" id="editor_fundamentaciones" class="mceNoEditor"><?php echo $fundamentaciones; ?></textarea></td>
	      </tr>
	    </table>

	    <?php

			}
			break;			
	}
?>
	<p class="titulo2">&nbsp;Paso # 3 - Si ya est&aacute; conforme con las modificaciones, presione el bot&oacute;n  <input type="submit" value="Finalizar"></br>
	&nbsp;Para regresar a la lista de planificaciones <input type="button" value="Volver" onclick=document.location="planificacion.php?id_ramo=<?php echo $id_ramo; ?>"></p>
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
