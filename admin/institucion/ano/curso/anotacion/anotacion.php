<?php 

require('../../../../../util/header.inc');
	$institucion	=$_INSTIT;
    $ano			=$_ANO;
    $curso			=$_CURSO;
    $ramo			=$_RAMO; 
	$modo			=$_FRMMODO;
	//phpinfo();
	
	$sql="select situacion from ano_escolar where id_ano=$ano";
    $result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
	
	if ($modo==NULL)$modo=$_GET['modo'];
		
    $empleado		=$_EMPLEADO;
    $nombreusuario  =$_NOMBREUSUARIO;

	$anotacion1		=$_ANOTACION1;
	
	$opcion			=$_GET['opcion'];
	$c_alumno = $_GET['c_alumno'];
	
	
	if($c_alumno!=0 or $modo=="mostrar" or $modo=="modificar")
	
	{   $alumno = $_ALUMNO;}
	
	else{
	
	$alumno = $_GET['alumno'];}
	
    $alumno;
	
		
    $_POSP = 5;
	$_bot           =5;
	$_MDINAMICO     = 1;
	
	$ano = $_GET['ano'];
	$curso = $_GET['curso'];
	
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
<script type="text/javascript">
	 alert ("No Autorizado");
	 window.location="../../../../../index.php";
</script>

<? } ?>
<?php
function generaSelect($_INSTIT,$conn,$ano)
{
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
 
 ?>  

  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Style-Type" content="text/css">
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
			
			div.ui-datepicker{
                font-size:14px;
                  }
			
			#Layer1 {
				position:absolute;
				left:516px;
				top:319px;
				width:330px;
				height:239px;
				z-index:1;
			}	 
			

			.estilotabla{
				background-color:ffffff;
				border-style:solid;
				border-color:666666;
				border-width:1px;
			}
			.estilocelda{
				background-color:ddeeff;
				color:333333;
				font-weight:bold;
				font-size:10pt;
			}


</style>

<style type="text/css">
<!--
.Estilo1 {
	font-family: Georgia, "Times New Roman", Times, serif;
	color: #FF0000;
	font-size:11pt;
}
-->
</style>

		
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">


<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/themes/smoothness/jquery-ui-1.8.6.custom.css">

<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script language="JavaScript" src="../../../../clases/jquery.ui.core.js"></script>
<script language="JavaScript" src="../../../../clases/jquery.ui.datepicker-es.js"></script>
<script language="JavaScript" src="../../../../clases/jquery.ui.datepicker.js"></script>
<script language="JavaScript" src="../../../../clases/jquery.ui.widget.js"></script>

<script type="text/javascript" src="../../../../../util/chkform.js"></SCRIPT>
<script type="text/javascript" language="javascript" src="select.js"></script>

<script src="jquery.history_remote.pack.js" type="text/javascript"></script>


<script type="text/javascript" language="javascript">

//******************************************************************//
  
function cargarinicio(x){ 
 var id = x;
 
 cargaContenido(id); 
 
	}
	
//******************************************************************//

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

//******************************************************************//
//******************************************************************//

function valida5(form){	
			if(cmb_periodos.options[cmb_periodos.selectedIndex].value==0){
					alert('Debe Seleccionar un PERIODO.');
					return false;
				};
				if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					return false;
				};

				if(!chkFecha(form.txtFECHA,'Fecha inv\xe1lida.')){
					return false;
				};

				if(!chkVacio(form.txtOBS,'Ingresar OBSERVACION.')){
					return false;
				};

				
				if(!(form.rdTIPO[0].checked) && !(form.rdTIPO[1].checked) && !(form.rdTIPO[2].checked)){

					alert('Seleccione TIPO DE ANOTACI\xd3N.');
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
					if(!chkHora(form.txtHORAS,'Hora inv\xe1lida.')){
						return false;
					};
				};
				};
						
frm.action='procesoAnotacion.php3?tipo_hoja=<?=$tipo_hoja?>&c_curso=<?=$curso?>&c_ano=<?=$ano?>&caso=1';
			frm.submit(true);	
				
				
			}

//******************************************************************//
//******************************************************************//

function Confirmacion(){
		if(confirm('\xbfESTA SEGURO DE ELIMINAR ESTOS DATOS?') == false){ return; };
			document.location="procesoAnotacion.php3?desde=$desde&elimina=1>"
		};

//******************************************************************//
//******************************************************************//
	
function enviapag(x,y=0){

	
	if(document.form.cmbANO.value==0){
		alert('Ingrese A\xd1O.');
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
    if ( x == 0 )
	   { var Cuenta = 0;
	    }
	else { var Cuenta = x;
		}

	var curso=document.form.cmbCURSO.value;
	var ano=document.form.cmbANO.value;
	var alumno=document.form.cmbALUMNO.value;

$("#cabeza").html('Listado Anotaciones');

var x ='<br><h5>Espere Por Favor Procesando...</h5><br>';
    x = x+'<img src="../../../../clases/img_jquery/ajax-loader.gif"><br><br><br><br><br><br><br>'; 

$("#modulodatos").html(x);

var parametros='c_ano='+ano+'&alumno='+alumno+'&Cuenta='+Cuenta+"&van="+y;
    
    $.ajax({
			
	  url:'list_anotaciones_2.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  
	    $("#modulodatos").html(data);
		
	
		  }
      
	  })

}	

//******************************************************************//

function enviapag2(form){
	
   var institu = $("#institucion").val();
   var ano = $("#cmbANO").val();
   var rutusuario = $("#rutusuario").val();
   var cur = $("#cmbCURSO").val();
   	
      
   $("#cabeza").html('Ingresar Anotacion');
      	
   var x ='<br><h5>Espere Por Favor Procesando...</h5><br>';
   x = x+'<img src="../../../../clases/img_jquery/ajax-loader.gif"><br><br><br><br><br><br><br>'; 

   $("#modulodatos").html(x);
   
   var parametros='institucion='+institu+'&ano='+ano+"&rutusuario="+rutusuario+"&cur="+cur;
   
 //  alert(parametros);
    $.ajax({
	  url:"agregaranotaciones.php",
	  type:"POST",
	  data:parametros,
	  success: function(data)
	 {
	//  alert(data);
	  $("#modulodatos").html(data);
	
		
		  }
      
	  })
	
   }	

//******************************************************************//

function enviapag3(form){

  var tp = $("#tipo_anotacion").val();
  var t1 = tp.split("_");
  var tipo = t1[0];
  
  
  $("#SubTipo").html('Cargando...')

  var parametros='tipo_anotacion='+tipo;
           
  $.ajax({

	  url:'select_subtipo.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	  
	    $("#SubTipo").html(data);
		
		  }
      
	  })
	  
}

//******************************************************************//

				
function guardar1(){	

	var sigla2 = $("#sigla2").val();
	var codigo2 = $("#codigo2").val();
	var tipo_responsable2 = $("#tipo_responsable2").val();
	var cmb_periodos2 = $("#cmb_periodos2").val();
	var txtFECHA2 = $("#txtFECHA2").val();
	var txtOBS2 = $("#txtOBS2").val();
	
	var institucion = $("#institucion").val();
	var ano = $("#ano").val();	
	var alumno = $("#cmbALUMNO").val();
	var curso = $("#cmbCURSO").val();	
	var tipo_conducta = $("#tipo_a").val();

    if( ano == 0 ) {
		alert("Debe Seleccionar un A\xd1o.");
		return false;}
    
	if( curso == 0 ) {
		alert("Debe Seleccionar un Curso.");
		return false;}

	if( alumno == 0 ) {
	    alert("Debe Seleccionar un Alumno.");
	    return false;}

	if( sigla2 == "" ) {
		alert("Debe Ingresar una Sigla");
		return false;}
		
	if( codigo2 == "" ){
		alert("Debe Ingresar una Codigo Anotacion");
		return false;}	
				 
	if( tipo_responsable2 == 0 ){
	   alert('Debe Seleccionar un Responsable.');
	   return false;}
				
	if( cmb_periodos2 == 0 ){
		alert('Debe Seleccionar un Periodo.');
		return false;}

	if( txtFECHA2 == "" ) {
	     alert('Debe Seleccionar una Fecha.'); 
		 return false;}

/*	if( txtOBS2 == "" ) {
	    alert('Debe Ingresar un Comentario.');
		return false;}*/
	
		if ( $('#fecha_inicio').val() == "Ingresar Fecha Inicio" ) {
	         alert("Si no tiene Fecha Inicio periodo no puede realizar este Registro");
	         return false;
	        }
	
		if ( $('#fecha_termino').val() == "Ingresar Fecha Termino" ) {
	         alert("Si no tiene Fecha Termino periodo no puede realizar este Registro");
	         return false;
	        }	
		
			
	var x = "sigla="+sigla2+"&codigo2="+codigo2+"&tipo_responsable="+tipo_responsable2;
	x = x+"&periodo="+cmb_periodos2+"&fecha="+txtFECHA2+"&observacion="+txtOBS2+"&tipo_conducta="+tipo_conducta;			
    x = x+"&institucion="+institucion+"&ano="+ano+"&alumno="+alumno+"&guardar=1";
	
	var parametros=x;
	
	$("#guardar1").html("<p>Guandando Espere por Favor</p><br>");
	
	$.ajax({
				
		url:'procesoAnotacion.php',
		data:parametros,
		type:'POST',
			success:function(data){
			//alert(data);
				 if (data == 1 ){
				 
						alert('Guardado OK');
						
						$('#Formulariolista')[0].reset();	
						
						$("#guardar1").html('<input class="botonXX" type="button" value="GUARDAR"   name="btnGuardar3" onClick="guardar1()" >');
						
						$("#fechasdeperiodo1").html('<p></p>');
						$("#fechasdeperiodo3").html('<p></p>');
						
						enviapag(0); // muestro lista ordenada desde 0 al 5 
										
						
				 } else { //alert( 'Errorr : '+data ); 
				 	alert("Error al guardar");
				  } 
			
			 }
     	  }) 
				 
     }


//*******************************************************************//

			
function guardar2(){
			
		var tp = $("#tipo_anotacion").val();
	  var t1 = tp.split("_");
	  //var vsg = t1[1];
	 		
			
				
	var cmb_periodos3 = $("#cmb_periodos3").val();
	var sigla_subsector = $("#sigla_subsector").val();
	//var tipo_anotacion = $("#tipo_anotacion").val();
	var tipo_anotacion = t1[0];
	var detalle_anotaciones = $("#detalle_anotaciones").val();
	var tipo_responsable = $("#tipo_responsable").val();
	var txtFECHA3 = $("#txtFECHA3").val();
	var txtOBS3 = $("#txtOBS3").val();

    var institucion = $("#institucion").val();
	var ano = $("#ano").val();	
	var alumno = $("#cmbALUMNO").val();
	var curso = $("#cmbCURSO").val();
	var tipo_conducta = $("#tipo_a2").val();
	
	//alert(alumno);
						
	if( ano == 0 ) {
		alert("Debe Seleccionar un Aￜo.");
		return false;}
    
	if( curso == 0 ) {
		alert("Debe Seleccionar un Curso.");
		return false;}

	if( alumno == 0 ) {
	    alert("Debe Seleccionar un Alumno.");
	    return false;}
		
							
	if(cmb_periodos3==0){
		alert('Debe Seleccionar un PERIODO.');
		return false;}
				
	if(sigla_subsector==0){
		alert('Debe Seleccionar un SECTOR DE APRENDIZAJE.');
		return false;}
				
	if(tipo_anotacion==0){
		alert('Debe Seleccionar un TIPO DE ANOTACI\xd3N.');
		return false;}
				
	if(tipo_responsable==0){
		alert('Debe Seleccionar un TIPO DE RESPONSABLE.');
		return false;}
		
	if(detalle_anotaciones==0){
		alert('Debe Seleccionar un SUB TIPO DE ANOTACI\xd3N.');
		return false;}
		
	if(txtFECHA3==""){
		alert('Debe Seleccionar una Fecha');
		return false;};
		
/*	if(txtOBS3==""){
		alert('Ingrese Observaciￜn');
		return false;};*/


	var x = "sigla="+sigla_subsector+"&tipo_responsable="+tipo_responsable;
	x = x+"&periodo="+cmb_periodos3+"&fecha="+txtFECHA3+"&observacion="+txtOBS3;
	x = x+"&tipo_anotacion="+tipo_anotacion+"&detalle_anotacion="+detalle_anotaciones+"&tipo_conducta="+tipo_conducta;			
    x = x+"&institucion="+institucion+"&ano="+ano+"&alumno="+alumno+"&guardar=2";
	
	var parametros=x;
	
	$("#guardar2").html("<p>Guandando Espere por Favor</p><br>");
	
	$.ajax({
				
		url:'procesoAnotacion.php',
		data:parametros,
		type:'POST',
			success:function(data){
		
			if (data == 1 ){
				
				alert('Guardado OK');
			$('#Formulariolista')[0].reset();
			$("#guardar2").html('<input class="botonXX" type="button" value="GUARDAR"   name="btnGuardar3" onClick="guardar2()" >');
			$("#fechasdeperiodo1").html('<p></p>');
			$("#fechasdeperiodo3").html('<p></p>');
			
			} else { //alert( 'Error : '+data ); 
			alert("Error al guardar");
			} 
			
		   }
     	  }) 
	}

//******************************************************************//
//******************************************************************//
			
  function guardar3(){	
				
   var usuarioactual =$('#usuarioactual2').val();
   var cmb_periodos  =$('#cmb_periodos').val();
   var txtFECHA      =$('#txtFECHA').val();
   var txtOBS        =$('#txtOBS').val();

   var institucion = $("#institucion").val();
   var ano = $("#ano").val();	
   
   var cmbANO = $("#cmbANO").val();
   
   var alumno = $("#cmbALUMNO").val();
   var curso = $("#cmbCURSO").val();
   var ramo =$('#cmbRAMO').val();
   var tipo_anotacion = "";
   var tipo_conducta = "";
   var horaatraso = "";
   
   if( ano == 0 ) {
		alert("Debe Seleccionar un Aￜo.");
		return false;}
    
	if( curso == 0 ) {
		alert("Debe Seleccionar un Curso.");
		return false;}

	if( alumno == 0 ) {
	    alert("Debe Seleccionar un Alumno.");
	    return false;}
	
   if( cmb_periodos==0 ){
	   alert('Debe Seleccionar un PERIODO.');
	   return false;
	 }
				
   if(txtFECHA == ""){
		alert("Ingresar Fecha");
		return false;
	}


	if( $('#rdTIPO1').is(':checked') || $('#rdTIPO2').is(':checked') || $('#rdTIPO3').is(':checked') ){	
	
		   if(  $('#rdTIPO1').is(':checked')  ){
				tipo_anotacion = $('#rdTIPO1').val();
				if ($('#positiva').is(':checked')){
							 tipo_conducta = 1;
						  }
				if ($('#negativa').is(':checked')){ 	 
							 tipo_conducta =2;
						  }
				if (tipo_conducta == ""){
				    alert("Ingrese el Tipo de Conducta");
					return false;}	  
				}
				
			 if(  $('#rdTIPO2').is(':checked')  ){
				    tipo_anotacion = $('#rdTIPO2').val();
				    horaatraso = $('#txtHORAS2').val();
				   if (horaatraso == ""){ 
				   alert("Ingrese Hora Atraso");
				   return false;}
			    }		
			
			if(  $('#rdTIPO3').is(':checked')  ){
				   tipo_anotacion = $('#rdTIPO3').val();
                  }
   
        }else{ 
		alert("Ingresar Tipo Anotacion");
		return false;}
   
   /*if (txtOBS==""){
		alert("Ingresar Observacion");
		return false;
	}*/
	
var x ="periodo="+cmb_periodos+"&fecha="+txtFECHA+"&observacion="+txtOBS+"&cmbANO="+cmbANO;
x = x+"&tipo_anotacion="+tipo_anotacion+"&tipo_responsable="+usuarioactual+"&tipo_conducta="+tipo_conducta;	
x = x+"&hora="+horaatraso+"&institucion="+institucion+"&ano="+ano+"&alumno="+alumno+"&curso="+curso+"&guardar=3&ramo="+ramo;
	
	var parametros=x;
	
	<? if($_PERFIL==0){ 	?>
	
	//alert(parametros);
	
	<? } ?>
	
	$("#guardar3").html("<p>Guandando Espere por Favor</p><br>");
	
	$.ajax({
		url:'procesoAnotacion.php',
		data:parametros,
		type:'POST',
			success:function(data){
					//alert(data);
				 if (data == 1 ){
						
						alert('Guardado OK');
						
						$("#guardar3").html('<input class="botonXX" type="button" value="GUARDAR"   name="btnGuardar3" onClick="guardar3()" >');
						
						$("#fechasdeperiodo1").html('<p></p>');
						$("#fechasdeperiodo3").html('<p></p>');
						
						
						$('#Formulariolista')[0].reset();
						
						//enviapag(0); // muestro lista ordenada desde 0 al 5 
						
				 } else { 
				 
				 //alert(data);
				 console.log(data);
				// alert( 'Error22 : '+data ); 
				alert("Error al guardar");
				 
				 //$("#result").html(data);
				 

				 $("#guardar3").html('<input class="botonXX" type="button" value="GUARDAR"   name="btnGuardar3" onClick="guardar3()" >');
				 
				 } 
			
			 }
     	  }) 
            

	 	
	   }
	       			
			
//******************************************************************//
//******************************************************************//


   function elimina_anotacion(idx){ 
   	var parametros ="idanotacion="+idx;

	if (!confirm('\xbfDesea Eliminar Esta Anotaci\xf3n?'))
       { 
	        return false;
		
		}else{
		
		$.ajax({
   			  url:'elimina_anotacion.php',
   			  data:parametros,
			  type:'POST',
			  success:function(data){
			  //alert(data);
        	      if (data==1){ 
				    alert("Se ha eliminado El Registro");
					//$('#Formulariolista')[0].reset();             
					enviapag(0);			 
								    } else{ 
									     alert("Error al Eliminar");   
									    }
				    } 
	             })  
		
		}
   
   			
		       
	  } 
			   
//******************************************************************//
//******************************************************************//

/*//script de comunicapp para mensajeria
function pruebaEdugestorInasistenciaUno(){
<?php if($_PERFIL==0){?>
var curso = 280;
var rbd   = 555;
<?php }
else{?>
var curso = $("#cmbCURSO").val();
var rbd = <?php echo $_INSTIT;?>
<?php }?>

//var al = $("#cmbALUMNO").val();
//var alumno = new Array();
var alumno = 24764512;
//alumno.push(al);

//montar responsable
//montar mensaje
//montar cargo responsable



var url2 = "https://www.comunicapp.cl/api_partners/reporteInasistencia";
        $.ajax({
            data: {'token': "RWR1SW1wdWxzYQ==", 'rbd':rbd, 'curso':[curso], 'alumnos' : [alumno],'user': <?php echo ($_PERFIL==0)?13907900:$_NOMBREUSUARIO ?>, 'fecha':"<?php echo date("Y-m-d") ?>",'hora':"<?php echo date("H:i:s") ?>",'modo':"Alumno Especifico",'user_name':"<?php echo ($_PERFIL==0)?"Rodrigo Monte":trim($_USUARIOENSESION) ?>", 'user_type':$("#perf").val(),'texto':$("#txtSMS").val()},
            url: url2,
            xhrFields: {
                withCredentials: true
            },
            type: 'POST',
            success: function (response) {//resultado de la funci�n
                console.log(response);
            }
        });
	


}	*/	   		
</script>



</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" 
onLoad= "<? echo "cargarinicio('cmbANO');";?> " >
<div id="result"></div>
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
					  </td></tr>
					  </table>
					  
					  </td>
                      <td width="73%" align="left" valign="top" >

					                                 
	
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
<tr>
<td nowrap="nowrap" align="left" valign="top" colspan="5"><br>

<form name="form" id="form" action="procesoAnotacion.php3" method="post">
<table align="center">
<tr>
<td class="textonegrita">A&Ntilde;O </td>
<td class="textonegrita">:</td>
<td><?php generaSelect($_INSTIT,$conn,$ano); ?></td>
<td><input name="ano" id="ano" type="hidden" value="<?=$ano?>">&nbsp;</td>
<td><input name="institucion" id="institucion" type="hidden" value="<?=$_INSTIT?>">
<input name="rutusuario" id="rutusuario" type="hidden" value="<?=$nombreusuario?>">
&nbsp;</td>
</tr>
<tr>
<td class="textonegrita">CURSO</td>
<td class="textonegrita">:</td>
<td>
<select disabled="disabled" name="cmbCURSO" id="cmbCURSO">									
<option value="0">Selecciona opci&oacute;n...</option>
</select>
</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
<tr>
<td class="textonegrita">ALUMNO</td>
<td class="textonegrita">:</td>
<td>
<select disabled="disabled" name="cmbALUMNO" id="cmbALUMNO">
<option value="0">Selecciona opci&oacute;n...</option>
</select>
</td>
<td>
<input type="button" name="btnBuscar" value="Buscar" onClick="enviapag(0);" class="botonXX">
</td>
<td>
 <input type="button" name="btnAgregar" value="Agregar" onClick="enviapag2(this.form);" class="botonXX">
</td>
</tr>
<tr>
<td>
<div id="etiquetaalumno">
&nbsp;
</div>
</td>
<td>
<div id="nombreaalumno">
&nbsp;
</div>
</td>
</tr>
</table>
</form>
<div class="tableindex" id="cabeza" >Listado Anotaciones</div>

 <div id="modulodatos" align="center" >
  &nbsp;
 </div>

 </td>
 </tr>
 </table>
	
 </td>
 </tr>
 <tr align="center" valign="middle"> 
 <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
 </tr>
 </table>
 </td>
 </tr>
 </table>
 </td>
 <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
 </tr>
 </table>
 </td>
 </tr>
</table>

<? pg_close($conn);
pg_close($connection); ?>		   

</body>
</html>
							 