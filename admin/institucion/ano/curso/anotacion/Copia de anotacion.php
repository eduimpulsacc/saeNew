<?php 
require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO; 
	$modo			=$_FRMMODO;
	$empleado		=$_EMPLEADO;
	$anotacion		=$_ANOTACION;
	$opcion			=$_GET['opcion'];
	$c_alumno = $_GET['c_alumno'];
	
	
	
	
	if($c_alumno!=0 or $modo=="mostrar" or $modo=="modificar"){$alumno =$_ALUMNO;}else{$alumno = $_GET[
	'alumno'];}
    $_POSP = 5;
	$_bot           =5;
	$_MDINAMICO     = 1;
	
	$ano = $_GET['ano'];
	"</br>".$curso = $_GET['curso'];
	$activo = $_GET['activo'];
	$alumno;
	
	if($activo=="Agregar"){
	$activar = 1;
	}

	if($activo=="Buscar"){
	$activar = 0;
	}
	
	$activar;
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
			$_ITEM =$item;
			session_register('_ITEM');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND 
		id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}	
		
			
	if (trim($_url)=="") $_url=0;
?>

 <?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
	 alert ("No Autorizado");
	 window.location="../../../../../index.php";
</script>

<? } ?>
<?php
function generaSelect($_INSTIT,$conn,$ano)
{

//$sql="SELECT id_ano, nro_ano FROM ano_escolar WHERE id_ano=".$ano;

$sql="SELECT id_ano, nro_ano FROM ano_escolar WHERE id_institucion=".$_INSTIT." ORDER BY id_ano ASC";
	$rs_ano = @pg_exec($conn,$sql);

	echo "<select name='cmbANO' id='cmbANO' onChange='cargaContenido(this.id)' >";
	echo "<option value='0'>Elige</option>";

	for($i=0;$i<@pg_numrows($rs_ano);$i++){

		$fila_ano = @pg_fetch_array($rs_ano,$i);
			
		if ( $fila_ano['id_ano'] == $ano){
			
echo '<option selected value="'.$fila_ano['id_ano'].'">'.$fila_ano['nro_ano'].'</option>';
			
		}	else {
		
echo '<option value="'.$fila_ano['id_ano'].'">'.$fila_ano['nro_ano'].'</option>';
	    
		    }
	
	}
	
	echo "</select>";

   }
  

/*	  function cargarselectinicio(){   
			echo "<script>
			var valor = document.getElementsByClassName('cmbANO').value;
			alert(valor);
			cargaContenido(valor);
			</script>";
	   } */
 
 ?>  

  
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<link rel="stylesheet" type="text/css" media="all" href="../../../../../../estadisticas/widgets/calendar-brown.css" title="green"/>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=latin9">
<meta http-equiv="Content-Style-Type" content="text/css">
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<meta http-equiv="Content-Script-Type" content="text/javascript">
<style type="text/css" media="screen, projection">

            /* Not required for Tabs, just to make this demo look better... */

            body {
                font-size: 16px; /* @ EOMB */
            }
            * html body {
                font-size: 100%; /* @ IE */
            }
            body * {
                font-size: 87.5%;
                font-family: "Trebuchet MS", Trebuchet, Verdana, Helvetica, Arial, sans-serif;
            }
            body * * {
                font-size: 100%;
            }
            h1 {
                margin: 1em 0 1.5em;
                font-size: 18px;
            }
            h2 {
                margin: 2em 0 1.5em;
                font-size: 16px;
            }
            p {
                margin: 0;
            }
            pre, pre+p, p+p {
                margin: 1em 0 0;
            }
            code {
                font-family: "Courier New", Courier, monospace;
            }
        </style>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="jquery.tabs.css" type="text/css" media="print, projection, screen">
<script type="text/javascript" src="select.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
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
//-->
</script>
<script type="text/javascript" src="scripts/prototype.lite.js"></script>
<script type="text/javascript" src="scripts/moo.fx.js"></script>
<script type="text/javascript" src="scripts/moo.fx.pack.js"></script>

<script language="JavaScript" src="../../../../../../estadisticas/widgets/calendar.js"></script>
<script language="JavaScript" src="../../../../../../estadisticas/widgets/calendar-setup.js"></script>
<script language="JavaScript" src="../../../../../../estadisticas/widgets/lang/calendar-es.js"></script>
<SCRIPT type="text/javascript" src="../../../../../../estadisticas/js/mootools.js"></SCRIPT>
<SCRIPT type="text/javascript" src="../../../../../../estadisticas/js/moodalbox.js"></SCRIPT>


<script type="text/javascript">
						  
function cargarinicio(x){ 
 var id = x;
 cargaContenido(id); 
 
	}

function init(){
	var stretchers = document.getElementsByClassName('box');
	var toggles = document.getElementsByClassName('tab');
	var myAccordion = new fx.Accordion(
		toggles, stretchers, {opacity: false, height: true, duration: 1000}
	);
	//hash functions
	var found = false;
	toggles.each(function(h3, i){
		var div = Element.find(h3, 'nextSibling');
			if (window.location.href.indexOf(h3.title) > 0) {
				myAccordion.showThisHideOpen(div);
				found = true;
			}
		});
		if (!found) myAccordion.showThisHideOpen(stretchers[0]);
}
</script> 


<script src="jquery-1.1.3.1.pack.js" type="text/javascript"></script>
<script src="jquery.history_remote.pack.js" type="text/javascript"></script>
<script src="jquery.tabs.pack.js" type="text/javascript"></script>
<script type="text/javascript">

	


function valida5(form){	
			if(cmb_periodos.options[cmb_periodos.selectedIndex].value==0){
					alert('Debe Seleccionar un PERIODO.');
					return false;
				};
				if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					return false;
				};

				if(!chkFecha(form.txtFECHA,'Fecha inválida.')){
					return false;
				};

				if(!chkVacio(form.txtOBS,'Ingresar OBSERVACION.')){
					return false;
				};

				
				if(!(form.rdTIPO[0].checked) && !(form.rdTIPO[1].checked) && !(form.rdTIPO[2].checked)){

					alert('Seleccione TIPO DE ANOTACIÓN.');
					return false;
				
				}else{
				
				//CONDUCTA				
				if(form.rdTIPO[0].checked){
				if(!(form.tipo_conducta[0].checked) && !(form.tipo_conducta[1].checked)){
						alert("Seleccione Tipo de Coducta");
						return false;
				};
				};

				//ATRASO
				if(form.rdTIPO[1].checked || form.rdTIPO[2].checked){
					if(!chkVacio(form.txtHORAS,'Ingresar HORAS de atraso.')){
						return false;
					};
					if(!chkHora(form.txtHORAS,'Hora inválida.')){
						return false;
					};
				};
				};
						
frm.action='procesoAnotacion.php3?tipo_hoja=<?=$tipo_hoja?>&c_curso=<?=$curso?>&c_ano=<?=$ano?>&caso=1';
			frm.submit(true);	
				
				
			}


function Confirmacion(){
		if(confirm('¿ESTA SEGURO DE ELIMINAR ESTOS DATOS?') == false){ return; };
			document.location="procesoAnotacion.php3?desde=$desde&elimina=1>"
		};

	
function enviapag(form){
	if(document.form.cmbANO.value==0){
		alert('Ingrese AÑO.');
		return false;
	};
	if(document.form.cmbCURSO.value==0){
		alert('Ingrese CURSO.');
		return false;
	};
	if(document.form.cmbALUMNO.value==0){
		alert('Ingrese ALUMNO.');
		return false;
	};	
	curso=document.form.cmbCURSO.value;
	ano=document.form.cmbANO.value;
	alumno=document.form.cmbALUMNO.value;
	activo=document.form.btnBuscar.value;
	//alert(activo);
	form.action = 'seteaAnotacion.php3?caso=1&activo='+activo+'&c_curso='+curso+'&c_ano='+ano+'&alumno='+alumno;
	form.submit(true);
}	


function enviapag2(form){
	
	activo=document.form.btnAgregar.value;
	//alert(activo);
	form.action = 'seteaAnotacion.php3?caso=1&activo='+activo+'&c_curso=<?echo $curso;?>&c_ano=<?echo $ano;?>&alumno=<?echo $alumno;?>';
	form.submit(true);
}	


function enviapag3(form){
	periodo=document.form.cmb_periodos.value;
	form.action = 'anotacion.php?tipo_hoja=&ano=<?echo $ano;?>&curso=<?echo $curso;?>&cmb_periodos=<?echo $cmb_periodos;?>&activo=Agregar&c_alumno=<?echo $alumno;?>&pesta=2';
	form.submit(true);
}

function enviapag4(form){
    form.oculto.value=1;
	form.action = 'anotacion.php?tipo_hoja=&ano=<?echo $ano;?>&curso=<?echo $curso;?>&activo=Agregar&c_alumno=<?echo $alumno;?>&pesta=4';
	form.submit(true);
}

function enviapag5(form){
    periodo=document.frm.cmb_periodos.value;
	frm.action = 'anotacion.php?tipo_hoja=&ano=<?echo $ano;?>&curso=<?echo $curso;?>&cmb_periodos=<?echo $cmb_periodos;?>&activo=Agregar&c_alumno=<?echo $alumno;?>&pesta=2';
	frm.submit(true);
}




</script>


<script type="text/javascript">
			
				
			function valida(form){	
				if(!chkVacio(form.sigla2,'Ingrese SIGLA.')){
						return false;
				};
				if(!chkVacio(form.codigo2,'Ingrese CODIGO.')){
						return false;
				};	
				 
				if(tipo_responsable2.options[tipo_responsable2.selectedIndex].value==0){
						alert('Debe Seleccionar un RESPONSABLE.');
						return false;
				}
				
				if(cmb_periodos2.options[cmb_periodos2.selectedIndex].value==0){
						alert('Debe Seleccionar un PERIODO.');
						return false;
				}

				if(!chkVacio(form.txtFECHA2,'Ingresar FECHA.')){
					return false;
				};

				if(!chkFecha(form.txtFECHA2,'Fecha inválida.')){
					return false;
				};

				if(!chkVacio(form.txtOBS2,'Ingresar OBSERVACION.')){
					return false;
				};
			responsable=tipo_responsable2.options[tipo_responsable2.selectedIndex].value;
			periodo=cmb_periodos2.options[cmb_periodos2.selectedIndex].value;    


						
			form.action='procesoAnotacion.php3?c_curso=<?=$curso?>&c_ano=<?=$ano?>&tipo_responsable2='+responsable+'&cmb_periodos2='+periodo+'&c_curso='+<?=$curso?>+'&por=1';	
			form.submit(true);	
				
				
			}
			
			
			
			
			
			function valida2(form){	
			periodo=cmb_periodos3.options[cmb_periodos3.selectedIndex].value;    
			
			
				if(cmb_periodos3.options[cmb_periodos3.selectedIndex].value==0){
						alert('Debe Seleccionar un PERIODO.');
						return false;
				}
				
				if(sigla_subsector.options[sigla_subsector.selectedIndex].value==0){
						alert('Debe Seleccionar un SECTOR DE APRENDIZAJE.');
						return false;
				}
				if(tipo_anotacion.options[tipo_anotacion.selectedIndex].value==0){
						alert('Debe Seleccionar un TIPO DE ANOTACIÓN.');
						return false;
				}
				if(tipo_responsable.options[tipo_responsable.selectedIndex].value==0){
						alert('Debe Seleccionar un TIPO DE RESPONSABLE.');
						return false;
				}
				if(detalle_anotaciones.options[detalle_anotaciones.selectedIndex].value==0){
						alert('Debe Seleccionar un SUB TIPO DE ANOTACIÓN.');
						return false;
				}
				if(!chkVacio(form.txtFECHA3,'Ingresar FECHA.')){
					return false;
				};

				if(!chkFecha(form.txtFECHA3,'Fecha inválida.')){
					return false;
				};
				if(!chkVacio(form.txtOBS3,'Ingresar OBSERVACION.')){
					return false;
				};
		
						
form.action='procesoAnotacion.php3?c_curso=<?=$curso?>&c_ano=<?=$ano?>&cmb_periodos3='+periodo+'&desde=alumno&por=2';	
			form.submit(true);	
				
				
			}
			
			
			function valida3(form){	
			
			//var contador = 0;
			var fecha = 0;
			var periodos = 0;
			var sigla = 0;
			var responsable = 0;
			var anotacion = 0;
			var detalle = 0;
			var observaciones = 0;
			
			for(var i=0; i<10; i++){
			//alert(document.form['txtFechadesde'+i].value);
			if(document.form['txtFechadesde'+i].value=='' && document.form['cmb_periodos'+i].value==0 && document.form['sigla_subsector'+i].value==0 && document.form['tipo_responsable'+i].value==0 && document.form['tipo_anotacion'+i].value==0 && document.form['detalle_anotaciones'+i].value==0 && document.form['observaciones'+i].value==''){
			
				//if(contador==0){
				if(fecha==0 && sigla==0 && responsable==0 && anotacion==0 && detalle==0 && observaciones
				==0){
				alert('Debe ingresar datos antes de guardar.');
				return false;
				};
				
				if(fecha==periodos && fecha==sigla && fecha==responsable && fecha==anotacion && fecha==
				detalle && fecha==observaciones){
				form.action='procesoAnotacion.php3?tipo_hoja=<?=$tipo_hoja?>&c_curso=<?=$curso?>&c_ano=
				<?=$ano?>&oculto=1';	
				form.submit(true);
				};
			
			
			}else{
			
			
			/*if(fecha!=periodos && fecha!=sigla && fecha!=responsable && fecha!=anotacion && fecha!=detalle && fecha!=observaciones){*/
				if(document.form['txtFechadesde'+i].value==''){
						alert('Ingresar FECHA.');
						return false;
						}
						fecha++;
						
				/*if(!chkFecha(form.txtFECHA,'Fecha inválida.')){
						return false;
				};*/
				if(document.form['cmb_periodos'+i].value==0){
						alert('Debe seleccionar PERIODO.');
						return false;
						}
						periodos++;
						
				if(document.form['sigla_subsector'+i].value==0){
						alert('Debe seleccionar SECTOR DE APRENDIZAJE.');
						return false;
						}	
						sigla++;
						
				if(document.form['tipo_responsable'+i].value==0){
						alert('Debe seleccionar un RESPONSABLE.');
						return false;
						}	
						responsable++;
						
				if(document.form['tipo_anotacion'+i].value==0){
						alert('Debe seleccionar TIPO ANOTACIÓN.');
						return false;
						}						
						anotacion++;
						
				if(document.form['detalle_anotaciones'+i].value==0){
						alert('Debe seleccionar SUB TIPO.');
						return false;
						}	
						detalle++;
						
				if(document.form['observaciones'+i].value==''){
						alert('Ingresar OBSERVACIONES.');
						return false;
						}	
						observaciones++;
				
				//contador++;
					/*};*/
			
				};
			//alert(txtFechadesde+i.options[txtFechadesde+i.selectedIndex].value);
				/*if(!chkVacio(form.txtFechadesde+i,'Ingresar FECHA.')){
						return false;
					};*/
			};	
			
			// ARREGLAR CUANDO GUARDA LOS DATOS, YA QUE PARECE QUE SOLO ESTA REVISANDO LA 1ERA FILA.
		/*	
			if(fecha==periodos && fecha==sigla && fecha==responsable && fecha==anotacion && fecha==detalle && fecha==observaciones){
			form.action='procesoAnotacion.php3?tipo_hoja=<?=$tipo_hoja?>&c_curso=<?=$curso?>&c_ano=<?=$ano?>&oculto=1';	
			form.submit(true);
			};*/
				
				
			};
			
			
			
			var nro=0;
			
			function valida4(form){	
					
			/*if(cmb_periodos.options[cmb_periodos.selectedIndex].value==0){
					alert('Debe Seleccionar un PERIODO.');
					return false;
				};*/
				if(document.form.cmb_periodos.value==0){
					alert('Debe Seleccionar un PERIODO.');
					return false;
				}
				if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					return false;
				};

				if(!chkFecha(form.txtFECHA,'Fecha inválida.')){
					return false;
				};

				if(!chkVacio(form.txtOBS,'Ingresar OBSERVACION.')){
					return false;
				};

				
				if(!(form.rdTIPO[0].checked) && !(form.rdTIPO[1].checked) && !(form.rdTIPO[2].checked)){

					alert('Seleccione TIPO DE ANOTACIÓN.');
					return false;
				
				}else{
				
				//CONDUCTA				
				if(form.rdTIPO[0].checked){
				if(!(form.tipo_conducta[0].checked) && !(form.tipo_conducta[1].checked)){
						alert("Seleccione Tipo de Coducta");
						return false;
				};
				};

				//ATRASO
				if(form.rdTIPO[1].checked || form.rdTIPO[2].checked){
					if(!chkVacio(form.txtHORAS2,'Ingresar HORAS de atraso.')){
						return false;
					};
					if(!chkHora(form.txtHORAS2,'Hora inválida.')){
						return false;
					};
				};
				};
				
						
form.action='procesoAnotacion.php3?tipo_hoja=<?=$tipo_hoja?>&c_curso=<?=$curso?>&c_ano=<?=$ano?>';
			form.submit(true);	
				
				
			}
			
			
			
			

function muestra_tabla(tabla,span){

alert('hola');

	t=document.getElementById(tabla);
	  span2=document.getElementById(span);
	     temp=document.getElementById(tabla).style.display;
	
	document.getElementById('codigo').style.display='none';
	document.getElementById('seleccion').style.display='none';
	document.getElementById('tradicional').style.display='none';
	document.getElementById('masivo').style.display='none';
	
	document.getElementById('pesta1').className='span_normal';
	document.getElementById('pesta2').className='span_normal';
	document.getElementById('pesta3').className='span_normal';
	document.getElementById('pesta4').className='span_normal';
	
	t.style.display="";
	
	span2.className='span_seleccionado';
	
}	


	
	
		
					
		</SCRIPT>


</head>

<body onLoad="muestra_tabla('codigo','pesta1')" >

<? /*if (($pesta == "") or ($pesta == NULL) or ($pesta == " ") 

   or ($pesta == 1) or (!isset($pesta))){ ?>
      
	  muestra_tabla('codigo','pesta1'); <?
   } 
   if ($pesta == 2){ ?>
      
	  muestra_tabla('seleccion','pesta2'); <?
   }
   if ($pesta == 3){ ?>
      
	  muestra_tabla('tradicional','pesta3'); <?
   }
   if ($pesta == 4){ ?>
      
	  muestra_tabla('masivo','pesta4'); <?
   }*/
   
   ?>
   
<!--MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">-->

<? //"cargarinicio('cmbANO');"; ?>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
						<table width="100%">
							<tr>
								<td><? include("../../../../../cabecera/menu_superior.php"); ?></td>
		                    </tr>
						</table>
					</td>
                  </tr>
               
					<!-- FIN DE COPIA DE CABECERA -->
                 
                </table></td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing
				="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table><tr><td><?
					  		$menu_lateral="3_1";
							include("../../../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top" >

					                                 
	
					  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                      
                          <tr> 						  
                            <td nowrap="nowrap" align="left" valign="top" colspan="5">
							 <form name="form" action="procesoAnotacion.php3" method="post">
							 <br>
					  <table cellpadding="5" cellspacing="0"><tr>
					    <td height="15" class="textonegrita">A&Ntilde;O </td>
					    <td class="textonegrita">:</td>
					    <td><?php generaSelect($_INSTIT,$conn,$ano); ?></td>
					    <td>&nbsp;</td>
					    <td>&nbsp;</td>
					  </tr>
					    <tr>
					      <td height="15" class="textonegrita">CURSO</td>
					      <td class="textonegrita">:</td>
					      <td>
							 <select disabled="disabled" name="cmbCURSO" id="cmbCURSO">									                               <option value="0">Selecciona opci&oacute;n...</option>
							  </select>
						  </td>
					      <td>&nbsp;</td>
					      <td>&nbsp;</td>
					    </tr>
					    <tr>
					      <td height="15" class="textonegrita">ALUMNO</td>
					      <td class="textonegrita">:</td>
					      <td>
							<select disabled="disabled" name="cmbALUMNO" id="cmbALUMNO">
								<option value="0">Selecciona opci&oacute;n...</option>
							</select>
						  </td>
					      <td><input type="button" name="btnBuscar" value="Buscar" onClick="enviapag(this.form);" class="botonXX"></td>
					      <td>
						<? if($alumno!=NULL){?>
						  <input type="button" name="btnAgregar" value="Agregar" onClick="enviapag2(this.form);" class="botonXX">
						<? }?>
						  </td>
						</tr>
			 
					  </table>
					  <table>
					  <tr>
					  	<td width="10%">&nbsp;</td>
						<td width="30%">&nbsp;</td>
					    <td width="60%">&nbsp;</td>
					  </tr>
						<tr>
							<td width="10%"><? if($alumno!=NULL){?>Alumno:<? }?></td>
							<td width="30%"><?php
										
									
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												//error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														//error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														//exit();
													}
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']);
												}
											}
											
											
											
											
										?></td>
						    <td width="60%" align="right">
							</td>
						</tr>
					</table>	
					    	
						<? if($activar==1){?>
						<div class="tableindex">ANOTACION</div>
						   <table border="0" cellspacing="0" cellpadding="0" align="center" width="100%">
                    			  <tr> 
                                   <td >&nbsp;</td>
<td width="75" ><a href="javascript:;" onClick="muestra_tabla('codigo','pesta1');">
<span id="pesta1" >Por Código</span></a></td>
                                   <td>&nbsp;</td>
<td width="75" ><a href="javascript:;" onClick="muestra_tabla('seleccion','pesta2');">
<span id="pesta2" >Por Selección</span></a></td>
                                   <td >&nbsp;</td>
<td width="75" ><a href="javascript:;" onClick="muestra_tabla('tradicional','pesta3');">
<span id="pesta3" >Anotación Tradicional</span></a></td>
                                   <td >&nbsp;</td>	
<td width="75" ><a href="javascript:;" onClick="muestra_tabla('masivo','pesta4');">
<span id="pesta4" >Masivo por Selección</span></a></td>
                                   <td width="21" >&nbsp;</td>
                                  </tr>
                                </table>
						  
						  
						  
						  
						  
						  
					      <div id="codigo"><br>

                            <table width="100%" border="0" cellspacing="0" cellpadding="2" id="codigo">
                              <div align="right"><input class="botonXX" type="button" value="GUARDAR"   name="btnGuardar" onClick="valida(this.form);" ><INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick="window.history.go(-1)"></div>
                              <tr>
                                <td width="30%" class="textosimple">CODIGO DE ANOTACION </td>
                                <td width="40%">
								
								<table width="150" border="0" align="left" cellpadding="3" cellspacing="0">
                                  <tr>
                                    <td><div align="center" class="textosimple">SIGLA</div></td>
                                    <td><div align="center"></div></td>
                                    <td><div align="center" class="textosimple">CODIGO</div></td>
                                  </tr>
                                  <tr>
                                    <td><label>
                                      <div align="center">
                                        <input name="sigla2" type="text" id="sigla2" size="4">
                                        <span class="textosimple">(*)</span></div>
                                      </label></td>
                                    <td><div align="center">-</div></td>
                                    <td><label>
                                      <div align="center">
                                        <input name="codigo2" type="text" id="codigo2" size="4">
                                        <span class="textosimple">(*)</span></div>
                                      </label></td>
                                  </tr>
                                </table>								</td>
                                <td width="30"><label> <br>
                                </label></td>
                              </tr>
							  
							  
							  <tr>
								  <td width="30%" class="textosimple"><font face="Geneva, Arial, Helvetica" color=#000000>NOMBRE RESPONSABLE</font></td>
								  <td width="70%"> 
								    <?
									
									  $q200 = "select DISTINCT empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat from empleado,trabaja where empleado.rut_emp = trabaja.rut_emp and trabaja.rdb =".$institucion." AND trabaja.rut_emp not in(7717287,11850353,4818331,14051464,13270730,16008794,13561508,14166024,10425397,13689507,5924397,11653768,12657018,8434778,7051273,16986896) ORDER BY empleado.nombre_emp ASC";
									  //echo $q200;
									  $r200 = pg_Exec($conn,$q200);
									  $n200 = pg_numrows($r200);								 
									 ?>
									  
								  
								    <select name="tipo_responsable2" id="tipo_responsable2">
									  <option value="0">Seleccione Responsable </option>
									  <?									
									
									  $k = 0;
									  while ($k < $n200){
									       $f200 = pg_fetch_array($r200,$k);
                                           $rut_emp = $f200['rut_emp'];
										   $nombre = $f200['nombre_emp'];
										   $ape=$f200['ape_pat'];
										   ?>
										   <option value="<?=$rut_emp ?>"><? echo "$nombre"." "."$ape"; ?></option>
										   <?
										   $k++;
									  }						  
									
									    
								     ?>
									</select>								    </td>
								</tr>
							  
							  
							  <tr>
								  <td width="30%" class="textosimple">PERIODO</td>
								  <td width="70%"><select id="cmb_periodos2" name="cmb_periodos2" class="ddlb_9_x Estilo2">
                                    <option value=0 selected>(Seleccione Periodo)</option>
                                    <?
										$sql = "SELECT id_periodo,nombre_periodo FROM periodo WHERE id_ano=".$ano;
										$result_peri = @pg_exec($conn,$sql);
										  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
										  {
										  $fila1 = @pg_fetch_array($result_peri,$i); 
										  if ($fila1['id_periodo']==$cmb_periodos)
											echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
										  else
											echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
										  ?>
                                    <? } ?>
                                  </select> 
								    <span class="textosimple">(*) </span></td>
								</tr>
								
							  <tr>
								  <td width="30%" class="textosimple">FECHA</td>
								  <td width="70%" class="textosimple">
								    <label>
								    <INPUT type="text" name="txtFECHA2" id="txtFECHA2" size="10" maxlength="10">
								    <span class="textosimple">(*)</span>								    <br>
										<FONT face="arial, geneva, helvetica" size=1 color=#000000>
											<STRONG>(DD-MM-AAAA)</STRONG></FONT>									</label>								  </td>
								  </tr>
								<tr>
								  <td width="30%" class="textosimple">OBSERVACI&Oacute;N</td>
								  <td width="70%" class="textosimple">
								    <textarea name="txtOBS2" cols="40" rows="5"></textarea>								  </td>
								  </tr>
								  
								<tr>
								  <td colspan="2"><div align="center" class="Estilo13">(*) Datos obligatorios </div></td>
								  </tr> 						  
                            </table>
					        </div>
							
							
					      <div id="seleccion"> <br>
	<table width="100%" border="0" cellpadding="5" cellspacing="0">
								<div align="right"><input class="botonXX" type="button" value="GUARDAR"   name="btnGuardar1" onClick="valida2(this.form);" ><INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick="window.history.go(-1)"></div>
								<tr>
								  <td width="30%" class="Estilo2"><font face="Geneva, Arial, Helvetica" color=#000000>PERIODO</font></td>
								  <td width="70%"><select name="cmb_periodos3" id="cmb_periodos3" class="ddlb_9_x Estilo2">
                                    <option value=0 selected>(Seleccione Periodo)</option>
                                    <?
										
										
										  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
										  {
										  $fila1 = @pg_fetch_array($result_peri,$i); 
										  
										  
										  
										  
										  if ($fila1['id_periodo']==$cmb_periodos)
											echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
										  else
											echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
										  
										  
										  
										  ?>
                                    <? } 
									
									
									
									?>
									
									
                                  </select> 
								    <span class="Estilo7">(*)								    </span></td>
								</tr>
								
								
								
							
								
								<tr>
								  <td width="30%" class="Estilo3">SECTOR DE APRENDIZAJE </td>
								  <td width="70%" class="Estilo2">
								    <label>
									<?
									 $q100 = "select * from sigla_subsectoraprendisaje where rdb = '$institucion' order by detalle";
									 $r100 = pg_Exec($conn,$q100);
									 $n100 = pg_numrows($r100);
									  
									 ?> 
									
								    <select name="sigla_subsector" id="sigla_subsector">
									  <option value="0">Seleccione Sector de Aprendizaje </option>
									  <?
									  
								
									  $j = 0;
									  while ($j < $n100){
									       $f100 = pg_fetch_array($r100,$j);
										   $sigla    = $f100['sigla'];
										   $detalle  = $f100['detalle'];
										   $id_sigla = $f100['id_sigla'];
										   ?>
										   <option value="<?=$id_sigla ?>" <? if ($sigla_subsector==$id_sigla) { ?> selected="selected" <? } ?> ><? echo "$detalle - $sigla"; ?></option>
										   <?
										   $j++;
									  }
									 
									  
									  ?>									
								      </select>
								    </label>
								  </td>
								</tr>
								<tr>
								  <td width="30%" class="Estilo3">TIPO ANOTACION </td>
								  <td width="70%" class="Estilo2">
								     <?
									
									  $q200 = "select * from tipos_anotacion where rdb = '$institucion'";
									  $r200 = pg_Exec($conn,$q200);
									  $n200 = pg_numrows($r200);								 
									 ?>
									  
								
								    <select name="tipo_anotacion" onChange="enviapag3(this.form);" id="tipo_anotacion">
									  <option value="0">Seleccione Tipo de Anotaci&oacute;n </option>
									  <?									
									
									  $k = 0;
									  while ($k < $n200){
									       $f200 = pg_fetch_array($r200,$k);
                                           $id_tipo = $f200['id_tipo'];
										   $codtipo = $f200['codtipo'];
										   $descripcion = $f200['descripcion'];
										   ?>
										   <option value="<?=$id_tipo ?>" <? if ($tipo_anotacion==$id_tipo){ ?> selected="selected" <? }  ?> ><? echo "$codtipo - $descripcion"; ?></option>
										   <?
										   $k++;
									  }						  
									
									    
								     ?>
									</select>
									
								  </td>
								  </tr>
                                  <tr>
								  <td width="30%" class="Estilo3">NOMBRE RESPONSABLE </td>
								  <td width="70%" class="Estilo2">
								     <?
									/*
									    $q200 = "select DISTINCT empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat from empleado,trabaja where empleado.rut_emp = trabaja.rut_emp and trabaja.rdb =".$institucion." AND trabaja.rut_emp not in(7717287,11850353,4818331,14051464,13270730,16008794,13561508,14166024,10425397,13689507,5924397,11653768,12657018,8434778,7051273,16986896) ORDER BY empleado.nombre_emp ASC";	*/
									  $q200 = "select distinct empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat from empleado,trabaja where empleado.rut_emp = trabaja.rut_emp and trabaja.rdb =".$institucion." ORDER BY empleado.nombre_emp ASC";
									  //if($_PERFIL==0) echo $q200;
									  $r200 = pg_Exec($conn,$q200);
									  $n200 = pg_numrows($r200);								 
									 ?>
									  
								  
								    <select name="tipo_responsable" id="tipo_responsable">
									  <option value="0">Seleccione Responsable </option>
									  <?									
									
									  $k = 0;
									  while ($k < $n200){
									       $f200 = pg_fetch_array($r200,$k);
                                           $rut_emp = $f200['rut_emp'];
										   $nombre = $f200['nombre_emp'];
										   $ape=$f200['ape_pat'];
										   ?>
										   <option value="<?=$rut_emp ?>"><? echo "$nombre"." "."$ape"; ?></option>
										   <?
										   $k++;
									  }						  
									
									    
								     ?>
									</select>
									
								  </td>
								  </tr>
								<tr>
								  <td width="30%" class="Estilo3">SUB TIPO </td>
								  <td width="70%" class="Estilo2">
								    <?
									
								
									
									  $q300 = "select * from detalle_anotaciones where id_tipo = '".trim($tipo_anotacion)."' order by codigo";
									  $r300 = @pg_Exec($conn,$q300);
									  $n300 = @pg_numrows($r300);
									
									?>
									<select name="detalle_anotaciones" id="detalle_anotaciones">
									   <option value="0">Seleccione Sub-Tipo de Anotaci&oacute;n</option>
									  
									 <?								
									 
																  
									  $l = 0;
									  while ($l < $n300){
									       $f300 = pg_fetch_array($r300,$l);
										   $codigosubtipo  = $f300['codigo'];
										   $detallesubtipo = $f300['detalle'];
										   
										   if ($codigosubtipo!=NULL){
										       ?>
										       <option value="<?=$codigosubtipo ?>"><? echo "$codigosubtipo - $detallesubtipo"; ?></option>
										       <?
										   }	   
										   $l++;
									  }		  	 
										 
										 
									
									 ?>	   
                                    </select>
								  </td>
								  </tr>
								  
						 
								<tr>
								  <td width="30%" class="Estilo3">FECHA</td>
								  <td width="70%" class="Estilo2">
								    <label>
								    <INPUT type="text" name="txtFECHA3" id="txtFECHA3" size=10 maxlength=10>
								    <span class="Estilo7">(*)</span>								    <br>
										<FONT face="arial, geneva, helvetica" size=1 color=#000000>
											<STRONG>(DD-MM-AAAA)</STRONG>										</FONT>								    </label>
								  </td>
								  </tr>
								<tr>
								  <td width="30%" class="Estilo3">OBSERVACI&Oacute;N</td>
								  <td width="70%" class="Estilo2">
								    <textarea name="txtOBS3" cols="40" rows="5" id="txtOBS3"></textarea>
								  </td>
								  </tr>
								  
								<tr>
								  <td colspan="2"><div align="center" class="Estilo13">(*) Datos obligatorios </div></td>
								  </tr>  
							  </table>
 </div>
 
 
 
					      <div id="tradicional">
						  <TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="80%">  
						<tr>
							<td>&nbsp;</td>
							<td><div align="right"><input class="botonXX" type="button" value="GUARDAR"   name="btnGuardar3" onClick="valida4(this.form);" ><INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick="window.history.go(-1)"></div>
							<table width="500" border="0">
								<tr>
								  <td><font face="Geneva, Arial, Helvetica" size=1 color=#000000>PERIODO</font></td>
								</tr>
								<tr>
								  <td>
								  <?
								  if (($frmModo=="modificar") and ($_INSTIT == '8933')){ ?>
								      	<select name="cmb_periodos" class="ddlb_9_x" id="cmb_periodos">
										 <option value=0 selected>(Seleccione Periodo)</option>
										   <?
											  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
											  {
											  $fila1 = @pg_fetch_array($result_peri,$i); 
											  if (($fila1['id_periodo'])==($fila['id_periodo']))
												echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
											  else
												echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
											  ?>
										   <? } ?>
										</select>
																		  
								<? }else{ ?>							  
									  <select name="cmb_periodos" class="ddlb_9_x" id="cmb_periodos">
												<option value=0 selected>(Seleccione Periodo)</option>
										   <?
											  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
											  {
											  $fila1 = @pg_fetch_array($result_peri,$i); 
											  if ($fila1['id_periodo']==$cmb_periodos)
												echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
											  else
												echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
											  ?>
										   <? } ?>
										</select>
								 <? } ?>								  </td>
								</tr>
							  </table>							</td>
						</tr>
						<TR>
							<TD width=30></TD>
							<TD align=left>
								<TABLE WIDTH="500" BORDER=0 CELLSPACING=1 CELLPADDING=0 <?php if($frmModo!="mostrar"){ echo "bgcolor=#cccccc";}?>>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG><?php if($frmModo!="mostrar"){ echo "&nbsp;&nbsp;";}?>TIPO ANOTACION</STRONG>											</FONT>										</TD>
									</TR>
									<TR align=center>
										<TD>
											<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 bgcolor=White>
												<TR>
													<?php if($frmModo!="mostrar"){ echo "<TD width=15></TD>";}?>
													<TD align=left>
													<?php if($modo=="ingresar"){ ?>
														<input type="radio" value="1" name="rdTIPO" id="rdTIPO"  
														onClick="layerATRASO.style.visibility='hidden';layerTIPOCONDUCTA.style.visibility='visible';
														layerENFERMERIA.style.visibility='hidden';clean(this.form,'C');nro=1" <? if ($fila['tipo']==1){ ?> checked="checked" <? } ?>>
														<FONT face="arial, geneva, helvetica" size=2 color=black>
															<strong>CONDUCTA</strong>														</FONT>
														<input type="radio" value="2" name="rdTIPO" id="rdTIPO" 
														onClick="layerATRASO.style.visibility='visible'; layerTIPOCONDUCTA.style.visibility='hidden'
														layerENFERMERIA.style.visibility='hidden';clean(this.form,'A');nro=2" <? if ($fila['tipo']==2){ ?> checked="checked" <? } ?>>
														<FONT face="arial, geneva, helvetica" size=2 color=black>
															<strong>ATRASO</strong>														</FONT>
														<!--<input type=radio value=3 name=rdTIPO 
														onClick="layerATRASO.style.visibility='hidden';
														layerENFERMERIA.style.visibility='hidden';clean(this.form,'I');nro=3">
														<FONT face="arial, geneva, helvetica" size=2 color=black>
															<strong>INASISTENCIA</strong>
														</FONT> -->

														<input type="radio" value="4" name="rdTIPO" id="rdTIPO" 
														onClick="layerATRASO.style.visibility='hidden';layerTIPOCONDUCTA.style.visibility='hidden'
														layerATRASO.style.visibility='visible';
														layerENFERMERIA.style.visibility='visible';
														clean(this.form,'E');nro=4" <? if ($fila['tipo']==4){ ?> checked="checked" <? } ?>>
														<FONT face="arial, geneva, helvetica" size=2 color=black>
															<strong>RESPONSABILIDAD</strong>														</FONT>
													<?php };?>
													<?php 
														if($frmModo=="mostrar"){ 
															switch ($fila['tipo']) {
																 case 0:
																	 imp('Indeterminado');
																	 break;
																 case 1:
																	 imp('Conducta');
																	 break;
																 case 2:
																	 imp('Atraso');
																	 break;
																 case 3:
																	 imp('Inasistencia');
																	 break;
																 case 4:
																	 imp('Responsabilidad');
																	 break;
															 };
														};
													?>													</TD>
												</TR>
											</TABLE>										</TD>
									</TR>
								</TABLE>							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=left>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%>
									<TR>
										<TD width="43%" valign=bottom>
											<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=73%>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>FECHA</STRONG>														</FONT>													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($modo=="ingresar"){ ?>
															<INPUT type="text" name=txtFECHA size=10 maxlength=10 value="<? echo impF($fila['fecha']); ?>">
															<br>
															<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																<STRONG>(DD-MM-AAAA)</STRONG>															</FONT>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ 
																impF($fila['fecha']);
															};
														?>													</TD>
												</TR>
											</TABLE>
											<table width="229" height="39" border="0" cellpadding="0" cellspacing="0">
											  <tr>
												<td>
												<div id="layerTIPOCONDUCTA" style="visibility: <? if (($frmModo=="modificar") AND ($fila['tipo']==1)){ ?> true <? }else{ ?> hidden <? } ?>">
												<table width="229" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td><FONT face="arial, geneva, helvetica" size=1 color=#000000>TIPO CONDUCTA</FONT></td>
                                                  </tr>
                                                  <tr>
                                                    <td><input name="tipo_conducta" type="radio" <?  if (($frmModo=='modificar') AND ($fila['tipo_conducta']==1)) { ?>  checked="checked" <? } ?> value="1" >
                                                      POSITIVA
                                                        <input name="tipo_conducta" type="radio" <?  if (($frmModo=='modificar') AND ($fila['tipo_conducta']==2)) { ?>  checked="checked" <? } ?> value="2" >
                                                      NEGATIVA</td>
                                                  </tr>
                                                </table>
												</div>												</td>
											  </tr>
										  </table>										</TD>
										
										<TD width="57%" valign="top">
											<div id="layerATRASO" style="visibility: <? if (($frmModo=="modificar") AND ($fila['tipo'] > 1)){ ?>  true <? }else{ ?>  hidden <? } ?>">
												<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 >
													<TR>
														<TD>
															<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																
<STRONG>TIEMPO ATRASO (atraso)<BR>HORA INGRESO 
(enfermeria)</STRONG>															</FONT>														</TD>
													</TR>
													<TR>
														<TD>
															<?php if($modo=="ingresar"){ ?>
															<input name="txtHORAS2" type="text" size="4" maxlength="5" >
															<?php };?>
															

															<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																<STRONG>(HH:MM)</STRONG>															</FONT>													  </TD>
													</TR>
												</TABLE>
											</div>									  </TD>
									</TR>
								</TABLE>							</TD>
						</TR>
						<TR>
							<TD width="30">&nbsp;</TD>
							<TD align="left" class="textonergita">OBSERVACION<br>

							  <textarea name="txtOBS" cols="60" rows="5"><? echo trim($fila['observacion']) ?></textarea></TD>
						</TR>
						<TR>
								<TD width=30>&nbsp;</TD>
								<TD>&nbsp;</TD>
						</TR>						
						<TR>
							<TD width=30></TD>
							<TD align=left>
								<div id="layerENFERMERIA" style="visibility: <? if (($frmModo=="modificar") AND ($fila['tipo']==4)){ ?> true <? }else{ ?> hidden <? } ?>">
									<!--
									
									<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=50%>
										<TR>
											<TD>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>CAUSAL</STRONG>
												</FONT>
											</TD>
										</TR>
										<TR>
											<TD>
												<?php if(($frmModo=="ingresar") OR ($frmModo=="modificar")){ ?>
													<textarea name="txtCAUSAL" cols="60" rows="5"><? echo trim($fila['causal']) ?></textarea>
												<?php };?>
												<?php 
													if($frmModo=="mostrar"){ 
														imp($fila['causal']);
													};
												?>
											</TD>
										</TR>
										<TR height=15><TD></TD></TR>
										<TR>
											<TD>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>TRATAMIENTO</STRONG>
												</FONT>
											</TD>
										</TR>
										<TR>
											<TD>
												<?php if(($frmModo=="ingresar") OR ($frmModo=="modificar")){ ?>
													<textarea name="txtTRA" cols="60" rows="5"><? echo trim($fila['tratamiento']) ?></textarea>
												<?php };?>
												<?php 
													if($frmModo=="mostrar"){ 
														imp($fila['tratamiento']);
													};
												?>
											</TD>
										</TR>
									</TABLE>
									
									-->
								</div>							</TD>
						</TR>
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#003b85>										</TD>
									</TR>
								</TABLE>							</TD>
						</TR>
					</TABLE>
							  </div>
					      
						  <div id="masivo"> <br>
	<table width="100%" border="1" style="border-collapse:collapse">
                              <tr>
                                <td colspan="7" class="Estilo14">INGRESO MASIVO POR SELECCI&Oacute;N <br>
                                  <input name="oculto" type="hidden" id="oculto" value="0"></td>
                                </tr>
                              <tr>
                                <td width="50" class="Estilo3">FECHA</td>
                                <td class="Estilo3">PER&Iacute;ODO</td>
                                <td class="Estilo3">SECTOR APRENDIZAJE </td>
                                <td class="Estilo3">RESPONSABLE</td>
                                <td class="Estilo3">TIPO ANOTACI&Oacute;N </td>
                                <td class="Estilo3">SUB-TIPO</td>
                                <td class="Estilo3">OBSERVACI&Oacute;N</td>
                                </tr>
							<?
							
														
							for ($iii=0; $iii < 10; $iii++){
							    $txtFechadesde       = $_POST['txtFechadesde'.$iii];
								$cmb_periodos        = $_POST['cmb_periodos'.$iii];
								$sigla_subsector     = $_POST['sigla_subsector'.$iii];
								$tipo_responsable    = $_POST['tipo_responsable'.$iii];
								$tipo_responsable    = $_POST['tipo_responsable'.$iii];
								$tipo_anotacion      = $_POST['tipo_anotacion'.$iii];
								$detalle_anotaciones = $_POST['detalle_anotaciones'.$iii];
								$observaciones       = $_POST['observaciones'.$iii];								
	                            
								?>															
                                <tr>
                                <td><label>
                                 <input type="text" name="txtFechadesde<?=$iii?>" id="txtFechadesde<?=$iii?>" size="8" maxlength="10" readonly="true" class="ingreso" value="<?=$txtFechadesde?>"> 
                                 <input type="button" id="txtFecha_btn<?=$iii?>" class="botadd" value=".">
								  <script type="text/javascript">
									Calendar.setup({
										inputField     :    "txtFechadesde<?=$iii?>",      // id of the input field
										ifFormat       :    "%Y-%m-%d",  // format of the input field (even if hidden, this format will be honored)
										button         :    "txtFecha_btn<?=$iii?>",  // trigger button (well, IMG in our case)
										align          :    "Bl",           // alignment (defaults to "Bl")
										singleClick    :    true,
										mondayFirst	   :    true
									});
									</script>
                                </label></td>
                                <td><label>
								
                                  <select name="cmb_periodos<?=$iii?>" class="ddlb_9_x Estilo2">
                                    <option value="0" selected>...</option>
                                    <?			
									 for($i=0 ; $i < @pg_numrows($result_peri) ; $i++){
										  $fila1 = @pg_fetch_array($result_peri,$i); 
										  if ($fila1['id_periodo']==$cmb_periodos){
											  echo  "<option selected value=".$fila1["id_periodo"]." ><font style='font-size:6px'>".substr($fila1['nombre_periodo'],0,10)."</font></option>";
										  }else{
											  echo  "<option value=".$fila1["id_periodo"]." ><font style='font-size:6px'>".substr($fila1['nombre_periodo'],0,10)."</font></option>";
										  }	
										  ?>
                                    <? } ?>								
                                  </select>
                                </label></td>
                                <td><label>
                                  <label>
									<?
									 $q100 = "select * from sigla_subsectoraprendisaje where rdb = '$institucion' order by detalle";
									 $r100 = pg_Exec($conn,$q100);
									 $n100 = pg_numrows($r100);
									  
									 ?> 
									
								    <select name="sigla_subsector<?=$iii?>" style="width:120px">
									  <option value="0">...</option>
									  <?							
									  $j = 0;
									  while ($j < $n100){
									       $f100 = pg_fetch_array($r100,$j);
										   $sigla    = $f100['sigla'];
										   $detalle  = $f100['detalle'];
										   $id_sigla = $f100['id_sigla'];
										   ?>
										   <option value="<?=$id_sigla ?>" <? if ($sigla_subsector==$id_sigla){ ?> selected="selected" <? } ?> ><? echo substr($detalle,0,15);  ?></option>
										   <?
										   $j++;
									  }								  
									  ?>									
								      </select>
								    </label>
                                </label></td>
                                <td><label>
                                  <?
									
									 /* $q200 = "select empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat from empleado,trabaja where empleado.rut_emp = trabaja.rut_emp and trabaja.rdb =".$institucion;*/
									   $q200 = "select DISTINCT empleado.rut_emp,empleado.nombre_emp,empleado.ape_pat from empleado,trabaja where empleado.rut_emp = trabaja.rut_emp and trabaja.rdb =".$institucion." AND trabaja.rut_emp not in(7717287,11850353,4818331,14051464,13270730,16008794,13561508,14166024,10425397,13689507,5924397,11653768,8434778,7051273,16986896) ORDER BY empleado.ape_pat ASC";
									  //echo $q200;
									  $r200 = pg_Exec($conn,$q200);
									  $n200 = pg_numrows($r200);								 
									 ?>
                                  <select name="tipo_responsable<?=$iii?>">
                                    <option value="0">...</option>
                                    <?									
									  $k = 0;
									  while ($k < $n200){
									       $f200 = pg_fetch_array($r200,$k);
                                           $rut_emp = $f200['rut_emp'];
										   $nombre = $f200['nombre_emp'];
										   $ape=$f200['ape_pat'];
										   ?>
                                    <option value="<?=$rut_emp ?>" <? if ($tipo_responsable==$rut_emp){ ?> selected="selected" <? } ?>><? echo substr($ape,0,10); echo substr($nombre,0,8); ?></option>
                                    <?
										   $k++;
									  }								    
								     ?>
                                  </select>
                                </label></td>
                                <td><label>
                                     <?									
									  $q200 = "select * from tipos_anotacion where rdb = '$institucion'";
									  $r200 = pg_Exec($conn,$q200);
									  $n200 = pg_numrows($r200);								 
									 ?>								  
								    <select name="tipo_anotacion<?=$iii?>" onChange="enviapag4(this.form);">
									  <option value="0">...</option>
									  <?								
									  $k = 0;
									  while ($k < $n200){
									       $f200 = pg_fetch_array($r200,$k);
                                           $id_tipo = $f200['id_tipo'];
										   $codtipo = $f200['codtipo'];
										   $descripcion = $f200['descripcion'];
										   ?>
										   <option value="<?=$id_tipo ?>" <? if ($tipo_anotacion==$id_tipo){ ?> selected="selected" <? }  ?> ><? echo "$codtipo -"; echo substr($descripcion,0,15); ?></option>
										   <?
										   $k++;
									  }								    
								      ?>
									</select>
                                </label></td>
                                <td><label>
                                    <?					
									  $q300 = "select * from detalle_anotaciones where id_tipo = '".trim($tipo_anotacion)."' order by codigo";
									  $r300 = @pg_Exec($conn,$q300);
									  $n300 = @pg_numrows($r300);
								    ?>
									<select name="detalle_anotaciones<?=$iii?>">
									   <option value="0">...</option>
									    <?															  
										  $l = 0;
										  while ($l < $n300){
											   $f300 = pg_fetch_array($r300,$l);
											   $codigosubtipo  = $f300['codigo'];
											   $detallesubtipo = $f300['detalle'];
											   
											   if ($codigosubtipo!=NULL){
												   ?>
												   <option value="<?=$codigosubtipo?>" <? if ($detalle_anotaciones==$codigosubtipo){?> selected="selected" <? } ?>><? echo "$codigosubtipo -"; echo substr($detallesubtipo,0,15);  ?></option>
												   <?
											   }	   
											   $l++;
										  }								
									   ?>	   
                                    </select>
                                </label></td>
                                <td><label>
                                  <input name="observaciones<?=$iii?>" type="text" value="<?=$observaciones?>" size="10">
                                </label></td>
                                </tr>
                              <? } ?>
                             
                              <tr>
                                <td colspan="7"><div align="center">
                                  <label>
                                  <input type="button" class="botonXX" name="Submit" value="GRABAR INFORMACI&Oacute;N" onClick="valida3(this.form);">
                                  </label>
                                <input class="botonXX"  type="button" value="CANCELAR" name="btnCancelar" onClick="window.history.go(-1)"></div></td>
                                </tr>
                            </table>
</div>
					     <!-- </div>-->
				<? }?>
				</form>	
				
				
				
				
			<? if($activar==0){ 
						  if($ano!=NULL && $curso!=NULL && $alumno!=NULL){?>
						  <table WIDTH="100%" BORDER="0" align="center" CELLPADDING="5" CELLSPACING="0">
			<tr height="20">
				<td align="middle" colspan="5" class="tableindex">
					CONDUCTA
				</td>
			</tr>
			<tr>
				<td colspan=5 align=right>
				</td>
			</tr>
			
			<tr class="tablatit2-1">
				<td align="center" width="10%">
					FECHA				</td>
				<td align="center" width="15%">
					RESPONSABLE				</td>
				<td align="center" width="20%">
					SIGLA </td>
				<td align="center" width="30%">
					TIPO ANOTACION				</td>
				<td align="center" width="25%">
					ANOTACION				</td>
			</tr>
			<?php
				
					//$qry="SELECT anotacion.id_anotacion,anotacion.sigla,anotacion.codigo_tipo_anotacion,anotacion.codigo_anotacion,anotacion.rdb,empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, anotacion.fecha, anotacion.tipo, empleado.rut_emp, anotacion.tipo_conducta  FROM (anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((alumno.rut_alumno)=".trim($alumno).")) order by id_anotacion Desc ";				
				  
				$qry="SELECT anotacion.id_anotacion, anotacion.sigla, anotacion.codigo_tipo_anotacion, anotacion.codigo_anotacion, anotacion.tipo, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, anotacion.fecha, anotacion.tipo, empleado.rut_emp, anotacion.tipo_conducta  FROM (anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) left JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((alumno.rut_alumno)=".trim($alumno).")) and anotacion.id_periodo in (select id_periodo from periodo where id_ano = '".trim($ano)."') order by fecha ";
				$result =@pg_Exec($conn,$qry);
//				echo $numero_filas = pg_numrows($result);
				if (!$result){
					error('<B> ERROR :</b>Error al acceder a la BD. (101)</B>');
				}else{
				    if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
					    $fila = @pg_fetch_array($result,0);	
					    if (!$fila){
						    error('<B> ERROR :</b>Error al acceder a la BD. (8) No hay alumnos inscritos en este curso</B>');
						    exit();
					    }
					}
					    	
				}
			?>
			<?php 
			
			$nu_anotaciones = 0;
			
			
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
						
						$sigla_aux = $fila["sigla"];
						
						if($fila['tipo']==2){
			               $nu_anotaciones++;
			            }					
						
						//if ($sigla_aux!=NULL){
						
						/// NO MUESTRO NADA					
												
								
								 if ($sigla_aux!=NULL){
								     if ($nu_anotaciones==3){
								        ?>
								        <tr bgcolor="#F47068" onClick=go('seteaAnotacion.php3?alumno=<?php echo trim($alumno)?>&anotacion=<?php echo $fila["id_anotacion"];?>&caso=4&desde=alumno')>
							            <?
										$nu_anotaciones = 0;
									 }else{
									    ?>
								        <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaAnotacion.php3?alumno=<?php echo trim($alumno)?>&anotacion=<?php echo $fila["id_anotacion"];?>&caso=4&desde=alumno')>
							            <?									 
									 }	
							     }else{
								     if ($nu_anotaciones==3){
									     ?>
							    <tr bgcolor="#F47068" onClick=go('seteaAnotacion.php3?alumno=<?php echo trim($alumno)?>&anotacion=<?php echo $fila["id_anotacion"];?>&caso=4&desde=alumno&old=1')>
										 <?
										 $nu_anotaciones = 0;
									 }else{										 
								         ?>
					            <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaAnotacion.php3?alumno=<?php echo trim($alumno)?>&anotacion=<?php echo $fila["id_anotacion"];?>&caso=4&desde=alumno&old=1')>
							             <?
							         }
								    
								 }    
								 
								 ?> 	
															
									<td align="center" class="textosimple" >
										<font face="arial, geneva, helvetica" size="1" color="#000000">
											<strong>
												<?php echo impF($fila["fecha"]);?></strong></font></td>
												
									<td align="center" class="textosimple" >
										<font face="arial, geneva, helvetica" size="1" color="#000000">
											<strong>
												<?php echo $fila["ape_pat"]." ".$fila["ape_mat"].", ".$fila["nombre_emp"];?></strong></font></td>
												
									<td align="center" class="textosimple" >
										<font face="arial, geneva, helvetica" size="1" color="#000000">
											<strong>
												<?php 
												// busco la sigla
												
												$q1 = "select * from sigla_subsectoraprendisaje where id_sigla = '$sigla_aux'";
												$r1 = @pg_Exec($conn,$q1);
												$f1 = @pg_fetch_array($r1,0);
																					
												
												echo $f1["sigla"];?> </strong></font></td>						
												
												
									<td align="center" class="textosimple" >
										<font face="arial, geneva, helvetica" size="1" color="#000000">
											<strong><?php
												   if($fila["codigo_tipo_anotacion"]=="")
													{
													
													   if ($fila['tipo']==1){
													        echo "CONDUCTA ";
															if ($fila['tipo_conducta']==1){
															    echo "POSITIVA";
															}	
													        if ($fila['tipo_conducta']==2){
															    echo "NEGATIVA";
															}
													   }
													   	
														
														if($fila['tipo']==2){
															echo "ATRASO";
														}															
															
														if($fila['tipo']==3){
															echo "INASISTENCIA";
														}
															
														if($fila['tipo']==4){
															echo "RESPONSABILIDAD";
														}												
																											
												   	}else{
																							 
													   $cod_ta = $fila["codigo_tipo_anotacion"];													   
													   $q1 = "select * from tipos_anotacion where id_tipo = '$cod_ta'";
													   $r1 = @pg_Exec($conn,$q1);
													   $f1 = @pg_fetch_array($r1,0);

														
													   $codta       = $f1['codtipo'];
													   $descripcion	= $f1['descripcion'];
																																
													   echo "$codta - $descripcion";  
													  }
													  
													  ?>
									    </strong></font></td>
									<td align="center" class="textosimple" >
										<font face="arial, geneva, helvetica" size="1" color="#000000">
											<strong>
												<?php 
												   $codigo_anotacion = $fila["codigo_anotacion"];
												
												   $q1 = "select * from detalle_anotaciones  where id_tipo = '$cod_ta' and codigo = '$codigo_anotacion'";
												   $r1 = @pg_Exec($conn,$q1);
												   $f1 = @pg_fetch_array($r1,0);
												   
												   $detalle = $f1["detalle"];
												   
												   echo "$codigo_anotacion - $detalle"; 
												   ?>
												
									    </strong></font></td>
								</tr>
						<? // } ?>		
			<?php
			           
			
					}
				
			?>
			<tr>
				<td colspan="5">
				<hr width="100%" color="#003b85">
				</td>
			</tr>
		</table>
			<? 		}
			}?>
						
						
						
			<? if($modo=="mostrar" or $modo=="modificar"){?>
			
			<form name="frm" action="procesoAnotacion.php3" method="post">
			
			<? $qry="SELECT * FROM ANOTACION WHERE ID_ANOTACION=".$anotacion;
			$result =@pg_Exec($conn,$qry);
			if (!$result) {
			//error('<B> ERROR :</b>Error al acceder a la BD. (1333)</B>');
				}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
			}
		}
		
		
				$qry_nom_per="SELECT periodo.nombre_periodo FROM periodo INNER JOIN anotacion ON periodo.id_periodo=anotacion.id_periodo WHERE anotacion.id_anotacion=".$_ANOTACION;
			$result_nom_per =@pg_Exec($conn,$qry_nom_per);
			$nom_periodo = @pg_fetch_array($result_nom_per,0);	

	
			
				
			if($opcion==1){?>
<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">  
						<tr>
							<td>&nbsp;</td>
							<td><div align="right"><? if($modo=="mostrar"){?><input class="botonXX" type="button" value="MODIFICAR"   name="btnGuardar7" onClick=go('seteaAnotacion.php3?alumno=<?php echo trim($alumno)?>&anotacion=<?php echo $_ANOTACION?>&caso=2&desde=alumno&old=1') ><INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick="Confirmacion()"><? } if($modo=="modificar"){?><input class="botonXX" type="button" value="GUARDAR"   name="btnGuardar33" onClick="valida5(this.form);" > <? }?><INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick="window.history.go(-2)"></div>
							<table width="500" border="0">
								<tr>
								  <td><font face="Geneva, Arial, Helvetica" size=1 color=#000000>PERIODO</font></td>
								</tr>
								<tr>
								  
								  
								  <? if($modo!="mostrar"){?>
								  <td>
								  <?
								   
								    $qry_per="SELECT * FROM periodo WHERE id_ano=".$_ANO;
									$result_peri =@pg_Exec($conn,$qry_per);
										
								  
								  
								  if (($modo=="modificar") and ($_INSTIT == '8933')){ ?>
								      	<select name="cmb_periodos" id="cmb_periodos" class="ddlb_9_x">
										 <option value=0 selected>(Seleccione Periodo)</option>
										   <?
											  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
											  {
											  $fila1 = @pg_fetch_array($result_peri,$i); 
											  if (($fila1['id_periodo'])==($fila['id_periodo']))
												echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
											  else
												echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
											  ?>
										   <? } ?>
										</select>
																		  
								<? }else{?>							  
									  <select name="cmb_periodos" id="cmb_periodos" class="ddlb_9_x">
												<option value=0 selected>(Seleccione Periodo)</option>
										   <?
											  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
											  {
											  $fila1 = @pg_fetch_array($result_peri,$i); 
											  if ($fila1['id_periodo']==($fila['id_periodo']))
												echo  "<option selected value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
											  else
												echo  "<option value=".$fila1["id_periodo"]." >".$fila1['nombre_periodo']."</option>";
											  ?>
										   <? } ?>
										</select>
								 <? } ?>	
									
								  </td>
								  
								  <? }else{
								 
								  ?>
								  <td>
								  <? echo $nom_periodo['nombre_periodo'];?>
								  </td>
								  <? }?>
								  
								</tr>
							  </table>
							</td>
						</tr>
						<TR>
							<TD width=30></TD>
							<TD align=left>
								<TABLE WIDTH="500" BORDER=0 CELLSPACING=1 CELLPADDING=0 <?php if($frmModo!="mostrar"){ echo "bgcolor=#cccccc";}?>>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG><?php if($frmModo!="mostrar"){ echo "&nbsp;&nbsp;";}?>TIPO ANOTACION</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR align=center>
										<TD>
											<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0 bgcolor=White>
												<TR>
													<?php if($modo!="mostrar"){ echo "<TD width=15></TD>";}?>
													<TD align=left>
													<?php if(($modo=="ingresar") OR ($modo=="modificar")){ ?>
														<input type="radio" value="1" name="rdTIPO" id="rdTIPO"  
														onClick="layerATRASO.style.visibility='hidden';layerTIPOCONDUCTA.style.visibility='visible';
														layerENFERMERIA.style.visibility='hidden';clean(this.form,'C');nro=1" <? if ($fila['tipo']==1){ ?> checked="checked" <? } ?>>
														<FONT face="arial, geneva, helvetica" size=2 color=black>
															<strong>CONDUCTA</strong>
														</FONT>
														<input type="radio" value="2" name="rdTIPO" id="rdTIPO" 
														onClick="layerATRASO.style.visibility='visible'; layerTIPOCONDUCTA.style.visibility='hidden'
														layerENFERMERIA.style.visibility='hidden';clean(this.form,'A');nro=2" <? if ($fila['tipo']==2){ ?> checked="checked" <? } ?>>
														<FONT face="arial, geneva, helvetica" size=2 color=black>
															<strong>ATRASO</strong>
														</FONT>
														<!--<input type=radio value=3 name=rdTIPO 
														onClick="layerATRASO.style.visibility='hidden';
														layerENFERMERIA.style.visibility='hidden';clean(this.form,'I');nro=3">
														<FONT face="arial, geneva, helvetica" size=2 color=black>
															<strong>INASISTENCIA</strong>
														</FONT> -->

														<input type="radio" value="4" name="rdTIPO" id="rdTIPO" 
														onClick="layerATRASO.style.visibility='hidden';layerTIPOCONDUCTA.style.visibility='hidden'
														layerATRASO.style.visibility='visible';
														layerENFERMERIA.style.visibility='visible';
														clean(this.form,'E');nro=4" <? if ($fila['tipo']==4){ ?> checked="checked" <? } ?>>
														<FONT face="arial, geneva, helvetica" size=2 color=black>
															<strong>RESPONSABILIDAD</strong>														</FONT>
													<?php };?>
													<?php 
														if($modo=="mostrar"){ 
															switch ($fila['tipo']) {
																 case 0:
																	 imp('Indeterminado');
																	 break;
																 case 1:
																	 imp('Conducta');
																	 break;
																 case 2:
																	 imp('Atraso');
																	 break;
																 case 3:
																	 imp('Inasistencia');
																	 break;
																 case 4:
																	 imp('Responsabilidad');
																	 break;
															 };
														};
													
													
													?>													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=left>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=100%>
									<TR>
										<TD width="43%" valign=bottom>
											<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=73%>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>FECHA</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if(($modo=="ingresar") OR ($modo == "modificar")){ ?>
															<INPUT type="text" name=txtFECHA size=10 maxlength=10 value="<? echo impF($fila['fecha']); ?>">
															<br>
															<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																<STRONG>(DD-MM-AAAA)</STRONG>
															</FONT>
														<?php };?>
														<?php 
															if($modo=="mostrar"){ 
																impF($fila['fecha']);
															};
														?>
													</TD>
												</TR>
											</TABLE>
											<table width="229" height="39" border="0" cellpadding="0" cellspacing="0">
											  <tr>
												<td>
  <div id="layerTIPOCONDUCTA" style="visibility: <? if (($modo=="modificar") AND ($fila['tipo']==1)){ ?> true <? }else{ ?> hidden <? } ?>">
												<table width="229" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td><FONT face="arial, geneva, helvetica" size=1 color=#000000>TIPO CONDUCTA</FONT></td>
                                                  </tr>
                                                  <tr>
                                                    <td><input name="tipo_conducta" type="radio" <?  if (($modo=='modificar') AND ($fila['tipo_conducta']==1)) { ?>  checked="checked" <? } ?> value="1" >
                                                      POSITIVA
                                                        <input name="tipo_conducta" type="radio" <?  if (($modo=='modificar') AND ($fila['tipo_conducta']==2)) { ?>  checked="checked" <? } ?> value="2" >
                                                      NEGATIVA</td>
                                                  </tr>
                                                </table>
												</div>
												</td>
											  </tr>
										  </table>

										</TD>
										
										<TD width="57%" valign="top">
	
	<div id="layerATRASO" style="visibility: <? if (($modo=="modificar") AND ($fila['tipo'] > 1)){ ?>  true <? }else{ ?>  hidden <? } ?>">
	
												<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 >
													<TR>
														<TD>
															<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																
<STRONG>TIEMPO ATRASO (atraso)<BR>HORA INGRESO 
(enfermeria)</STRONG>															</FONT>														</TD>
													</TR>
													<TR>
														<TD>
															<?php if($modo=="ingresar"){ ?>
															<input name="txtHORAS2" type="text" size="4" maxlength="5" >
															<?php };?>
															
															<?php if($modo=="modificar"){ ?>
																      <INPUT type="text" name="txtHORAS" size="4" maxlength="5" value="<?=$fila['hora'] ?>">
															<?php };?>
															
															<?php 
																if($modo=="mostrar"){ 
																	imp($fila['hora']);
																};
															?>&nbsp;&nbsp; 
															<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																<STRONG>(HH:MM)</STRONG>															</FONT>													  </TD>
													</TR>
												</TABLE>
											</div>									  </TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=left>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=50%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>OBSERVACION</STRONG></FONT><!--</TD>-->
									</TR>
									<TR>
										<TD>
											<?php if(($modo=="ingresar") OR ($modo=="modificar")){ ?>
												<textarea name="txtOBS" cols="60" rows="5"><? echo trim($fila['observacion']) ?></textarea>
											<?php };?>
											<?php 
												if($modo=="mostrar"){ 
													imp($fila['observacion']);
												};
											?>
										</TD>
									</TR>
								</TABLE>
							
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=left>
								<div id="layerENFERMERIA" style="visibility: <? if (($modo=="modificar") AND ($fila['tipo']==4)){ ?> true <? }else{ ?> hidden <? } ?>">
									<!--
									
									<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=50%>
										<TR>
											<TD>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>CAUSAL</STRONG>
												</FONT>
											</TD>
										</TR>
										<TR>
											<TD>
												<?php if(($modo=="ingresar") OR ($modo=="modificar")){ ?>
													<textarea name="txtCAUSAL" cols="60" rows="5"><? echo trim($fila['causal']) ?></textarea>
												<?php };?>
												<?php 
													if($modo=="mostrar"){ 
														imp($fila['causal']);
													};
												?>
											</TD>
										</TR>
										<TR height=15><TD></TD></TR>
										<TR>
											<TD>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>TRATAMIENTO</STRONG>
												</FONT>
											</TD>
										</TR>
										<TR>
											<TD>
												<?php if(($modo=="ingresar") OR ($modo=="modificar")){ ?>
													<textarea name="txtTRA" cols="60" rows="5"><? echo trim($fila['tratamiento']) ?></textarea>
												<?php };?>
												<?php 
													if($modo=="mostrar"){ 
														imp($fila['tratamiento']);
													};
												?>
											</TD>
										</TR>
									</TABLE>
									
									-->
								</div>
							</TD>
						</TR>
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#003b85>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
					</TABLE>
			
			
			
			
			<? }?>
			
			</form>
			
			<? }?>
			
			
			
			
			
							
							
				</td>
              </tr>
            </table></td>
        </tr>
					
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
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
<? pg_close($conn); ?>		   

</body>
</html>
							 