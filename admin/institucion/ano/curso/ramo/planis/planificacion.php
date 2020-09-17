<?php
/*MODIFICADO EL 12/03/2008 POR CRISTIAN RODRIGUEZ*/
	require('../../../../../../util/header.inc');

	
	
	
	$rut_prof=$_NOMBREUSUARIO;
	
	
	
	if ($id_ramo){
		$_RAMO = $id_ramo;
		$_FRMMODO = "mostrar";
	} else {
		$id_ramo = $_GET['id_ramo'];
	}
	if ($modificar){
		$_FRMMODO = "modificar";
	}
	
	if ($viene_de){
		$_VIENEPAG = $viene_de;	
	}
	$_POSP          =6;
	$_bot           =5;
	
	$_RAMO = $_GET['id_ramo'];
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
	<link href="./scripts/SpryData.css" rel="stylesheet" type="text/css">
	<link href="./scripts/LiteCalendarPopup.css" rel="stylesheet" type="text/css">
    
    
    
    
    

	<script src="scripts/LiteCalendarPopup.js"></script> 
	<script src="scripts/load_calendar.js"></script>
	<script src="scripts/utils.js"></script>


<script language="JavaScript" type="text/JavaScript">


	function elimina(x){
		//alert(x);
	if(confirm("Seguro que quieres Eliminar")) 
	{ 
		location.href="eliminar_archivo.php?id_archivo="+x; 
	} 
	else 
	{ 
	return false
	} 
		
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
		if(!notaNroOnly(box,'Nota inválida.')){
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
<script language="javascript" type="text/javascript" src="scripts/load_data.js"></script>

<script>
var filtrar_por_unidad = function(dataSet, row, rowNumber) {
	var list = document.form_planis.select_1;
	var chosenItem = list.options[list.selectedIndex].value
	if (row['unidad_id_plani'] == chosenItem) {
		return row;
	}
	else {
		return null;
	}
}
</script>

<?  //---------------- SELECT DSICRIMINA EN CASO DE QUE HAYA ALGO QUE MOSTRAR, LUEGO EL IF QUE SIGUE IMPIDE QUE 
	//-----------------APAREZCA EL ERROR QUE INDICA QUE NO HAY NINGUN DATO PARA MOSTRAR.

	$qry="SELECT * FROM plani WHERE id_ramo=".$_RAMO." AND esta_oculta=FALSE";
	$result = @pg_Exec($conn, $qry);	
?>

<script language="javascript" type="text/javascript">
var ds_datos = new Spry.Data.HTMLDataSet("planis_lista.php?id_ramo=<?echo $id_ramo;?>&viene_de=../listarRamos.php3", "tabla_datos_ramo");
</script>

<? if(pg_numrows($result)!=0){?>

<script>
var ds1 = new Spry.Data.HTMLDataSet("planis_lista.php?id_ramo=<? echo $id_ramo;?>&viene_de=../listarRamos.php3", "tabla_planis",{sortOnLoad:"nombre", sortOrderOnLoad:"ascending"});
var ds2 = new Spry.Data.HTMLDataSet("planis_lista.php?id_ramo=<? echo $id_ramo;?>&viene_de=../listarRamos.php3", "tabla_planis",{sortOnLoad:"id_momento", sortOrderOnLoad:"ascending"});
ds2.setColumnType('avance', 'number');
ds2.setColumnType('logro', 'number');
ds2.sort('fecha_creacion', 'toggle');
ds2.sort('nombre', 'toggle');
ds2.sort('momento', 'toggle');
ds2.sort('avance', 'toggle');
ds2.sort('logro', 'toggle');
ds2.loadData();


</script>

<? }else{?>

<script>
var ds1 = new Spry.Data.HTMLDataSet();
var ds2 = new Spry.Data.HTMLDataSet();
</script>

<? }?>
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
<!-- Inicio Planificaciones -->
<div spry:region="ds_datos" id="region_datos">
	<div spry:state="ready">
	<table id="tabla_datos">
		<tr>
			<td class="titulo2">A&ntilde;o Escolar:</td>
			<td class="texto2">{ano_escolar}</td>
		</tr>
		<tr>
			<td class="titulo2">Curso:</td>
			<td class="texto2">{curso}</td>
		</tr>
		<tr>
			<td class="titulo2">Subsector:</td>
			<td class="texto2">{subsector}</td>
		</tr> 
		<tr>
			<td class="titulo2">Docente:</td>
			<td class="texto2">{docente}</td>
		</tr>  
	</table>
	</div>
    </div>
<hr>
<div id="div_plani">
</div>

<form name="form_planis" id="form_planis">
	<span spry:region="ds1" id="region_form_planis">
    	<p class="texto2">Mostrar planificaciones de clase de la unidad:
        <select spry:repeatchildren="ds1" spry:test="'{id_momento}' == '20'" name="select_1" id="select_1" onChange="ds2.filter(filtrar_por_unidad);ds2.loadData();">
          <option value="{@id_plani}">{nombre}</option>
    </select></p>
  </span>
</form>        

<form>
<input type="button" value="Mostrar Todas" onClick="ds2.filter();ds2.loadData();" />
&nbsp;|&nbsp;
<input type="button" value="Vista Previa" onClick="fadeIt('div_plani','planis_cargar.php?id_plani='+ds2.getCurrentRow()['@id_plani']); return false;"/>
<input type="button" value="Imprimir" onClick="window.open('planis_imprimir.php?id_plani='+ds2.getCurrentRow()['@id_plani'],'Imprimir','width=660,height=768, scrollbars=yes, resizable=yes')" />
&nbsp;|&nbsp;
<input type="button" value="Nueva" onClick="fadeIt('div_plani','planis_form_nueva.php?id_ramo=<?php echo $id_ramo; ?>'); return false;"/>
<input type="button" value="Editar" onClick="fadeIt('div_plani','planis_form_editar.php?id_ramo=<?php echo $id_ramo; ?>&id_plani='+ds2.getCurrentRow()['@id_plani']); return false;"/>
<input type="button" value="Borrar" onClick="if (confirm('¿Está seguro que desea borrar la planificación seleccionada?')) fadeIt('div_plani','planis_borrar.php?id_ramo=<?php echo $id_ramo; ?>&id_plani='+ds2.getCurrentRow()['@id_plani']); return false;"/>

<input type="button" value="Atras" onClick="javascript:history.back(1)";>


<input type="button" value="Subir y Mostrar" onClick="fadeIt('div_plani','planis_form_subir.php?id_ramo=<?php echo $id_ramo; ?>&id_plani='+ds2.getCurrentRow()['@id_plani']); return false;"/>






</form>

<table width="100%">
	<tr>
		<td width="65%" valign="top"><div spry:region="ds2" id="region_1" >
		<!--<div spry:state="error" class="error">Error cargando los datos</div> 
	    <div spry:state="loading" class="loading">Cargando...</div>-->
		<div spry:state="ready">
	  	<table width="100%">
	     	<tr valign="top">
				<td width="1%" valign="top" width="20%" onclick="ds2.sort('fecha_creacion');" class="titulo1">Creaci&oacute;n</td>
				<td valign="top" width="50%" onClick="ds2.sort('nombre');" class="titulo1">Nombre</td>
				<td valign="top" width="10%" onClick="ds2.sort('id_momento');" class="titulo1">Momento</td>
				
			</tr>
			<tr spry:repeat="ds2" spry:setrow="ds2" class="planis" spry:select="selected"  spry:hover="hover">
				<td valign="top"><div>{fecha_creacion}</div></td>
				<td valign="top"><div>{nombre}</div></td>
				<td valign="top"><div>{momento}</div></td>
				<!--<td valign="top"><div>{avance} %</div></td>
				<td valign="top"><div>{logro} %</div></td>-->
			</tr>
		</table>
			</div>
            </div></td>
		<td width="35%" valign="top">
		<div id="plani_descripcion" spry:detailregion="ds2">
			<table>
				<tr>
					<td class="titulo1">Detalles</td>
				</tr>
	    		<tr class="planis">
					<td><strong>Inicio: </strong>{fecha_inicio}</td>
				</tr>
				<tr class="planis">
					<td><strong>T&eacute;rmino: </strong>{fecha_fin}</td>
				</tr>
				<tr class="planis">
					<td><strong>Abordaje: </strong>{fecha_abordaje}</td>
				</tr>
				<tr class="planis">
					<td><strong>Estado: </strong>{estado}</td>
				</tr>
				<!--<tr class="planis">
					<td><strong>Abordaje: </strong>{fecha_abordaje}</td>
				</tr> -->
				
				<tr class="planis">
					<td><strong>Tipo: </strong>{tipo}</td>
				</tr>
				<tr class="planis">
					<td><strong>Descripci&oacute;n: </strong>{descripcion}</td>
				</tr>
			</table>
            </div>
            </td>
	</tr>
</table>	
<!-- Fin Planificaciones -->
	                              						</td>
	                            					</tr>
	                          					</table></td>
	                      				</tr>
	            					</table></td>
		                    </tr>
							<tr align="center" valign="middle"> 
	              					<td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
	            			</tr>
	                  	</table></td>
				</tr>
			</table>
		<td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
	</tr>
</table>
</body>
</html>
<?php pg_close($conn);
?>
