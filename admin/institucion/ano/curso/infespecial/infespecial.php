<?php require('../../../../../util/header.inc');
require('../../../../../util/funciones_new.php');

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
<?php 

	

/*******************************/
	
	// REGISTRO DE HISTORIAL DE NAVEGACION
	registrarnavegacion($_USUARIO,'INFORME NECESIDADES ESPECIALES',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);
	//******************************************************//
		


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>						
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.css">
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../../clases/rut_jquery/jquery.Rut.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="validaRutClave.js"></script>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
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

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}


$(document).ready(function() {
    traeano(<?php echo $_INSTIT ?>);	
});


function traeano(rdb){
var funcion =1;
var parametros ="funcion="+funcion+"&rdb="+rdb;

$.ajax({
	url:'cont_infespecial.php',
	data:parametros,
	type:'POST',
	success:function(data){
		//console.log(data);
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{ 
		
			$("#ano").html(data);
			
		}
	}
	})	

}

function periodo(ano){
var funcion =2;
var parametros ="funcion="+funcion+"&ano="+ano;

$.ajax({
	url:'cont_infespecial.php',
	data:parametros,
	type:'POST',
	success:function(data){
		//console.log(data);
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{ 
		
			$("#periodo").html(data);
			
		}
	}
	})	

}

function curso(ano){
var funcion =3;
var parametros ="funcion="+funcion+"&ano="+ano;

$.ajax({
	url:'cont_infespecial.php',
	data:parametros,
	type:'POST',
	success:function(data){
		//console.log(data);
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{ 
		
			$("#curso").html(data);
			
		}
	}
	})	

}

function alumno(curso){
var funcion =4;
var parametros ="funcion="+funcion+"&curso="+curso;

$.ajax({
	url:'cont_infespecial.php',
	data:parametros,
	type:'POST',
	success:function(data){
		//console.log(data);
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{ 
		
			$("#alumno").html(data);
			
		}
	}
	})	

}

function cargaReporte(){
	var funcion=5;
	var anio = $("#cmb_ano").val();
	var periodo = $("#cmb_periodo").val();
	var curso = $("#cmb_curso").val();
	var alumno = $("#cmb_alumno").val();
	var parametros ="funcion="+funcion+"&anio="+anio+"&periodo="+periodo+"&curso="+curso+"&alumno="+alumno;
	
	$.ajax({
	url:'cont_infespecial.php',
	data:parametros,
	type:'POST',
	success:function(data){
		//console.log(data);
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{ 
			$("#nvoreporte").html('');
			$("#listareporte").html(data);
			
		}
	}
	})
}

function nuevoInf(){
var funcion=6;
	var anio = $("#cmb_ano").val();
	var periodo = $("#cmb_periodo").val();
	var curso = $("#cmb_curso").val();
	var alumno = $("#cmb_alumno").val();
	var rdb = <?php echo $institucion ?>;
	var parametros ="funcion="+funcion+"&anio="+anio+"&periodo="+periodo+"&curso="+curso+"&alumno="+alumno+"&rdb="+rdb;
	
	$.ajax({
	url:'cont_infespecial.php',
	data:parametros,
	type:'POST',
	success:function(data){
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{ 
		
			$("#listareporte").html('');
			$("#nvoreporte").html(data);
			
		}
		
	}
	})

}

function atras()
{
if (confirm('¿Seguro desea cancelar?')){
	cargaReporte();
}	
}

function guardanuevoInf(){
var funcion=7;
var formu = $("#formu").serialize();
var parametros = "funcion="+funcion+"&formu="+formu;

total_checko = $("input.cl[type=radio]:checked").length;

if($("#cmb_empleado").val()==0){
alert("campo obligatorio");
$("#cmb_empleado").focus();
}
else if($("#nombre_recibe").val()==""){
alert("campo obligatorio");
$("#nombre_recibe").focus();
}
else if($("#rut_recibe").val()==""){
alert("campo obligatorio");
$("#rut_recibe").focus();
}
else if($("#relacion_recibe").val()==""){
alert("campo obligatorio");
$("#relacion_recibe").focus();
}
else if($("#relacion_recibe").val()==""){
alert("campo obligatorio");
$("#relacion_recibe").focus();
}
else if($("#interprete_recibe").val()==""){
alert("campo obligatorio");
$("#interprete_recibe").focus();
}
else if(total_checko==0){
alert("campo obligatorio");
$("#tipo_eval0").focus();
}
else if($("#motivo_evaluacion").val()==""){
alert("campo obligatorio");
$("#motivo_evaluacion").focus();
}
else if($("#diagnostico").val()==""){
alert("campo obligatorio");
$("#diagnostico").focus();
}
else if($("#academico_fortaleza").val()==""){
alert("campo obligatorio");
$("#academico_fortaleza").focus();
}
else if($("#academico_necesidad").val()==""){
alert("campo obligatorio");
$("#academico_necesidad").focus();
}
else if($("#social_fortaleza").val()==""){
alert("campo obligatorio");
$("#social_fortaleza").focus();
}
else if($("#social_necesidad").val()==""){
alert("campo obligatorio");
$("#social_necesidad").focus();
}
else if($("#salud_fortaleza").val()==""){
alert("campo obligatorio");
$("#salud_fortaleza").focus();
}
else if($("#salud_necesidad").val()==""){
alert("campo obligatorio");
$("#salud_necesidad").focus();
}
else if($("#apoyo_hogar").val()==""){
alert("campo obligatorio");
$("#apoyo_hogar").focus();
}
else if($("#descrip_apoyo").val()==""){
alert("campo obligatorio");
$("#descrip_apoyo").focus();
}
else if($("#necesidad_apoyo").val()==""){
alert("campo obligatorio");
$("#necesidad_apoyo").focus();
}
else if($("#acuerdo").val()==""){
alert("campo obligatorio");
$("#acuerdo").focus();
}
else if($("#fecha_entrega").val()==""){
alert("campo obligatorio");
$("#fecha_entrega").focus();
}

else if($("#prox_evaluacion").val()==""){
alert("campo obligatorio");
$("#prox_evaluacion").focus();
}

else{


$.ajax({
	url:'cont_infespecial.php',
	data:parametros,
	type:'POST',
	success:function(data){
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{ 
		console.log(data);
		alert("DATOS GUARDADOS");
		cargaReporte();
			
		}
		
	}
	})
	
 }
}

function buscaReporte(id){
var funcion=8;
var rdb = <?php echo $institucion ?>;
var parametros ="funcion="+funcion+"&id="+id+"&rdb="+rdb;
	
	$.ajax({
	url:'cont_infespecial.php',
	data:parametros,
	type:'POST',
	success:function(data){
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{ 
		
			$("#listareporte").html('');
			$("#nvoreporte").html(data);
			
		}
		
	}
	})
}

function guardaActuInf(){
var funcion=9;
var formu = $("#formu").serialize();
var parametros = "funcion="+funcion+"&formu="+formu;

total_checko = $("input.cl[type=radio]:checked").length;

if($("#cmb_empleado").val()==0){
alert("campo obligatorio");
$("#cmb_empleado").focus();
}
else if($("#nombre_recibe").val()==""){
alert("campo obligatorio");
$("#nombre_recibe").focus();
}
else if($("#rut_recibe").val()==""){
alert("campo obligatorio");
$("#rut_recibe").focus();
}
else if($("#relacion_recibe").val()==""){
alert("campo obligatorio");
$("#relacion_recibe").focus();
}
else if($("#relacion_recibe").val()==""){
alert("campo obligatorio");
$("#relacion_recibe").focus();
}
else if($("#interprete_recibe").val()==""){
alert("campo obligatorio");
$("#interprete_recibe").focus();
}
else if(total_checko==0){
alert("campo obligatorio");
$("#tipo_eval0").focus();
}
else if($("#motivo_evaluacion").val()==""){
alert("campo obligatorio");
$("#motivo_evaluacion").focus();
}
else if($("#diagnostico").val()==""){
alert("campo obligatorio");
$("#diagnostico").focus();
}
else if($("#academico_fortaleza").val()==""){
alert("campo obligatorio");
$("#academico_fortaleza").focus();
}
else if($("#academico_necesidad").val()==""){
alert("campo obligatorio");
$("#academico_necesidad").focus();
}
else if($("#social_fortaleza").val()==""){
alert("campo obligatorio");
$("#social_fortaleza").focus();
}
else if($("#social_necesidad").val()==""){
alert("campo obligatorio");
$("#social_necesidad").focus();
}
else if($("#salud_fortaleza").val()==""){
alert("campo obligatorio");
$("#salud_fortaleza").focus();
}
else if($("#salud_necesidad").val()==""){
alert("campo obligatorio");
$("#salud_necesidad").focus();
}
else if($("#apoyo_hogar").val()==""){
alert("campo obligatorio");
$("#apoyo_hogar").focus();
}
else if($("#descrip_apoyo").val()==""){
alert("campo obligatorio");
$("#descrip_apoyo").focus();
}
else if($("#necesidad_apoyo").val()==""){
alert("campo obligatorio");
$("#necesidad_apoyo").focus();
}
else if($("#acuerdo").val()==""){
alert("campo obligatorio");
$("#acuerdo").focus();
}
else if($("#fecha_entrega").val()==""){
alert("campo obligatorio");
$("#fecha_entrega").focus();
}

else if($("#prox_evaluacion").val()==""){
alert("campo obligatorio");
$("#prox_evaluacion").focus();
}

else{


$.ajax({
	url:'cont_infespecial.php',
	data:parametros,
	type:'POST',
	success:function(data){
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{ 
		console.log(data);
		alert("DATOS ACTUALIZADOS");
		cargaReporte();
			
		}
		
	}
	})
	
 }
}


function eliminaReporte(id){
var funcion =10;
var parametros ="funcion="+funcion+"&id="+id;

if (confirm('¿Seguro desea eliminar esta ficha?')){
	


$.ajax({
	url:'cont_infespecial.php',
	data:parametros,
	type:'POST',
	success:function(data){
		//console.log(data);
		if(data==0){
			alert("ERROR DE SISTEMA");	
		}else{ 
		
		alert("DATOS ELIMINADOS");
		cargaReporte();
			
		}
	}
	})	
}

}

function imprimeReporte(id){	
	
	window.open('printinfespecial.php?idFicha='+id,'_blank');
}

function pendInf(){
	var funcion=11;
	var periodo =$("#cmb_periodo").val();
	var ano =$("#cmb_ano").val();
	var curso =$("#cmb_curso").val();
	var alumno =$("#cmb_alumno").val();
	
	if(ano==0 || periodo==0 ){
		alert("Debe seleccionar año y periodo para búsqueda");
		return false;
		
		}
	var parametros = "funcion="+funcion+"&periodo="+periodo+"&curso="+curso+"&alumno="+alumno+"&anio="+ano;
	  $.ajax({
			url:"cont_infespecial.php",
			data:parametros,
			type:'POST',
			success:function(data){
				$(".pend").html(data);
				 $(".pend").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
  height: 350,
	width: 750,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
	 
	 "Cerrar": function(){
	    $(this).dialog("destroy");
	  }
	}   
  })
		   
	  }
	})

}

</script>

<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
	

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <p>
              <? include("../../../../../cabecera/menu_superior.php"); ?>
            </p>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top">
								  <!-- inicio codigo nuevo -->

								  <table width="90%"  border="0" cellpadding="0" cellspacing="0">
								    <tr> 
    <td align="center" valign="top"> 
      <? //include("../../../../../cabecera/menu_inferior.php"); ?> </td>
  </tr>
</table>

	<?php //echo tope("../../../../../util/");?>
	
				<div align="right"></div>
               
<DIV ID="seleccion">

<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</div>
<form id="formu" name="formu">
<input type="hidden" name="x" value="">
<table width="90%" border="0" cellspacing="3" align="center">
 <tr>
      <td colspan="3" class="tableindex">Buscador Avanzado </td>
      </tr>
  <tr>
    <td class="textonegrita">&nbsp;</td>
    <td align="center" class="textonegrita">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="86" class="textonegrita">A&ntilde;o</td>
    <td width="8" align="center" class="textonegrita">:</td>
    <td width="530"><div id="ano">
      <select name="cmb_ano" id="cmb_ano">
        <option value="0">seleccione...</option>
      </select>
    </div></td>
  </tr>
   <tr>
    <td class="textonegrita">Periodo</td>
    <td width="8" align="center" class="textonegrita">:</td>
    <td>
    <div id="periodo">
    <select name="cmb_periodo" id="cmb_periodo">
      <option value="0">seleccione...</option>
    </select>
    </div></td>
  </tr>
  <tr>
    <td class="textonegrita">Curso</td>
    <td width="8" align="center" class="textonegrita">:</td>
    <td><div id="curso">
      <select name="cmb_curso" id="cmb_curso">
        <option value="0">seleccione...</option>
      </select>
    </div></td>
  </tr>
  <tr>
    <td class="textonegrita">Alumno</td>
    <td width="8" align="center" class="textonegrita">:</td>
    <td><div id="alumno">
      <select name="cmb_alumno" id="cmb_alumno">
        <option value="0">seleccione...</option>
      </select>
    </div></td>
  </tr>
</table>
<br>
<br><div align="right">
<input type="button" value="Listar Evaluaciones pendientes" onclick="pendInf()" class="botonXX" />&nbsp;&nbsp;
</div>
<br>
<!--tabla reportes-->
<div id="listareporte">
</div>
<div id="nvoreporte">
</div>
<div id="prreporte">
<div class="print"></div>
</div>

</form>
<div class="pend" title="Entrevistas programadas "></div>
<!-- fin codigo nuevo -->
							  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php");?></td>
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
</body>
</html>
