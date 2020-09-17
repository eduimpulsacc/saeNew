<?php
	
 require_once('../../../../../../util/header.inc');
	//print_r($_GET);
	$institucion	=$_INSTIT;
//	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_GET['alumno'];
	$id_curso 		=$_GET['crs'];
	$_CURSO 		= $id_curso;	
	$_POSP = 6;
	$_bot = 6;
	
	$ret = $_REQUEST['r'];
	
	if($_PERFIL==0){
	//show($_SESSION);
	}
	
	if($Modo==1)
	{
	//	$frmModo = "mostrar";
	}
	
	
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
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
	
	 if($_PERFIL!=0 && ($_PERFIL!=15 and $_PERFIL!=16)){
  $sql_campoemp="select t.cargo,c.nombre_cargo 
from trabaja t inner join cargos c on c.id_cargo = t.cargo 
where t.rut_emp = $_NOMBREUSUARIO and t.rdb=$_INSTIT order by identificador asc limit 1";
$campoemp = pg_exec($conn,$sql_campoemp);
$cargouser = pg_result($campoemp,0);
$nombrecargo = pg_result($campoemp,1);
 }else{
$cargouser = 0;
$nombrecargo = "ADMIN SAE";
}

if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../index.php";
		 </script>

<? } 
	
	

if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../../index.php";
		 </script>

<? } ?>			
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">
	div.ui-datepicker{
	font-size:12px;
	}
	textarea:focus, input[type=password]:focus, input[type=text]:focus, select :focus{
	border: 1px solid #79b7e7; background: #fff;
	outline: none; box-shadow: 0 1px 4px #c5c5a2;
	-webkit-box-shadow: 0 1px 4px #c5c5a2;
	-moz-box-shadow: 0 1px 4px #c5c5a2; }
	
</style>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="../../../../../clases/jqueryui/themes/smoothness/jquery.ui.all.css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.core.js"></script>
<script type="text/javascript" src="valida_rut_simple.js"></script>
<script type="text/javascript" src="formatea_rut.js"></script>
<script type="text/javascript" src="../../../../../clases/jquery/print2.js"></script>


<script language="javascript">
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

	function MM_openBrWindow(theURL,winName,features) { //v2.0
    window.open(theURL,winName,features);
    }

 $(document).ready(function() {
	 $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
          });
	 
   cargaTabs()
   ano_academico();
 });
 
 function ano_academico()
 {
	var id_ano = "<?=$ano;?>";
	var funcion = 15;
	
	 var parametros='funcion='+funcion+'&id_ano='+id_ano;
	//alert(parametros);
    $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //alert(data)
	    $("#ano_acad").html(data);
	 }
      
	  })
	 
	 
 }
 
 
function cambia_titulos(x){
	
	if (x==1){
	$('#titulo').html('Personal');
	}
	if (x==2){
	$('#titulo').html('Familiar');
	$('#volver_fam').hide();
	//alert('aqui');
	
	}
	if (x==3){
	$('#titulo').html('Academico');
	}
	if (x==4){
	$('#titulo').html('Conducta');
	}
	if (x==5){
	$('#titulo').html('Becas');
	}
	if (x==6){
	$('#titulo').html('Grupos');
	}
	if (x==7){
	$('#titulo').html('Entrevista Apoderado');
	}
	
	} 
 
 
 
function cargaTabs(){
	
	
	var curso =	  $('#select_cursos').val()	
	if(curso==undefined){
		 var curso = "<?=$id_curso;?>";
		}
		//alert(curso)
  
   var ano = "<?=$ano;?>"
   var rutusuario = "<?=$alumno;?>"	
   var ret = "<?=$ret;?>"	
      
   var x ='<br><h5>Espere Por Favor Procesando...</h5><br>';
   x = x+'<img src="../../../../../clases/img_jquery/loading.gif"><br><br>'; 
   $("#modulodatos").html(x);
    var parametros='curso='+curso+'&ano='+ano+"&rutusuario="+rutusuario+"&ret="+ret;
	//alert(parametros);
    $.ajax({
	  url:'muestra_datos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#modulodatos").html(data);
	 }
      
	  })
   } 
   
   function modifica_datos()
   {
	   
	   
   var curso = "<?=$id_curso;?>";
   var ano = "<?=$ano;?>"
   var rutusuario = "<?=$alumno;?>"	
   var ret = "<?=$ret;?>"
      
   var x ='<br><h5>Espere Por Favor Procesando...</h5><br>';
   x = x+'<img src="../../../../../clases/img_jquery/loading.gif"><br><br>'; 
   $("#modulodatos").html(x);
    var parametros='curso='+curso+'&ano='+ano+"&rutusuario="+rutusuario+"&ret="+ret;
	//alert(parametros);
    $.ajax({
	  url:'modifica_datos.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#modulodatos").html(data);
	 }
      
	  })   
   }
   
   function volver_home(){
	   cargaTabs();
	   }
   
   function volver()
   {
	   $('#ingreso_familiar').hide();
	   $("#ver_familiar").show();
   }
   
   function volver_f()
  {
	   //alert("aqui");
	   $("#carga_familiar").html(""); 
	   $('#volver_fam').hide();
	   $('#ingresa_fam').show();
	   $('#div_volver').hide();
	   
	   $("#select_familiar option[value=0]").attr("selected",true);
  }
   
  /* function cambiarut(rut_alumno,dig_rut)
   {
	   parametros="rut_alumno="+rut_alumno+"&dig_rut="+dig_rut;
	 // alert(parametros);
		   $.ajax({
			
	  url:'modifica_rut.php',
	  data:parametros,
	  type:'POST',
	 
	  success:function(data){
	    // alert(data);
		$("#dialog_rut").html(data);
		
			   $("#dialog_rut").dialog({
				  modal: true,
				  text: '',
				  width: 450,
				  resizable: false,
				  show: "fold",
				  hide: "scale",
		
			 buttons: [
        {
            text: "Cerrar",
            "class": 'cancelButtonClass',
            click: function() {
                $(this).dialog("close");
            }
        },
        {
            text: "Guardar",
            "class": 'saveButtonClass',
            click: function() {
                //valida_rut();
				$("#frm1").submit();
            }
        }
    ],
    close: function() {
        // Close code here (incidentally, same as Cancel code)
    }
			   });
		  }
	  });   
   }*/
   
   
   function valida_rut()
   {
	   
	var rut_alumno = $("#rut").val();
    var parametros='rut_alumno='+rut_alumno;
	//alert(parametros);
    $.ajax({
	  url:'valida_rut.js',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //alert(data);
	    $("#valida_rut").html(data);
	 }
	  })   
   }
   
   
   function prueba_rut()
   {
	var rut = $('#rut_fam').val();
	var dig_rut = $('#dig_rut_fam').val();
	
	var resultado=Valida_Rut(rut,dig_rut);
	 if(resultado==0){
		 alert("rut Incorrecto");
		 $("#carga_si_encuentra").html("");
		 return false;
		 }else if(resultado==1){
		//alert("rut Correcto")
			
	var funcion = 6;		
	parametros="funcion="+funcion+"&rut="+rut+"&dig_rut="+dig_rut;
	//alert(parametros);
	   $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==0){
			alert("No existen registros");
			if(confirm("Desea Ingresar un nuevo apoderado")){  
		  	nuevo_apo();
			}
		  }else{
		 // alert(data);
	    $("#carga_si_encuentra").html(data);
		$('#guardar_apo').show();
		$('#guardar_apo_nuevo').hide();
		  }
     //   $('#rut_fam').attr('disabled','-1')
       // $('#dig_rut_fam').attr('disabled','-1')
	//alert($('#rut_fam').val());
	    }
	  })   
	}
  }
  
  function nuevo_apo(){
	var rut_alumno="<?=$alumno?>";  
	var funcion = 12;  
	parametros="funcion="+funcion+"&rut_alumno="+rut_alumno; 
	
	 $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //alert(data);
	    $("#carga_si_encuentra").html(data);
		$('#guardar_apo').hide();
		$('#guardar_apo_nuevo').show();
		  }
	  }) 
  }
  
  function guarda_familiar_nuevo()
  {
	  
	 if($('#_nombre_apo').val()==""){
		 alert("Escriba un nombre");
		 $('#_nombre_apo').focus();
		 return false;
		 }
	 if($('#_ape_pat_apo').val()==""){
		 alert("Escriba Apellido Paterno");
		 $('#_ape_pat_apo').focus();
		 return false;
		 }
	if($('#_ape_mat_apo').val()==""){
		 alert("Escriba Apellido Materno");
		 $('#_ape_mat_apo').focus();
		 return false;
		 }	 
		 <?php 
	/*if($('#_fecha_nac_apo').val()==""){
		 alert("Seleccione una Fecha");
		 return false;
		 $('#_fecha_nac_apo').focus();
		 
		 }*/
		?>
		 
		 	 	  
	/*if($('#txt_calle_apo_').val()==""){
		 alert("Escriba Direccion");
		 $('#txt_calle_apo_').focus();
		 return false;
		 }		*/ 
	/*if($('#txt_fono_apo_').val()==""){
		 alert("Escriba Fono de Contacto");
		 $('#txt_fono_apo_').focus();
		 return false;
		 }	*/ 
	/*if($('#txt_celular_apo_').val()==""){
		 alert("Escriba Celular de Contacto");
		 $('#txt_celular_apo_').focus();
		 return false;
		 }*/	 
	/*if($('#txt_email_apo_').val()==""){
		 alert("Escriba mail de Contacto");
		 $('#txt_email_apo_').focus();
		 return false;
		 }	*/	 
	  
	  
	var funcion = 13;  
	var rut_alumno="<?=$alumno;?>";
	var rut_apo = $('#rut_fam').val();
	var dig_rut_apo = $('#dig_rut_fam').val();
	var nombre_apo  = $('#_nombre_apo').val();
	var ape_pat	    = $('#_ape_pat_apo').val();
	var ape_mat	    = $('#_ape_mat_apo').val();
	var fecha_nac   = $('#_fecha_nac_apo').val();
	var sexo = $("input[name='sexo_']:checked").val();
	var nacionalidad = $("input[name='_nacionalidad']:checked").val();
	var calle_apo	    = $('#txt_calle_apo_').val();
	var nro_apo	    = $('#txt_nro_apo_').val();
	var block_apo	    = $('#txt_block_apo_').val();
	var depto_apo	    = $('#txt_depto_apo_').val();
	var villa_apo	    = $('#txt_villa_apo_').val();
	var region_apo	=$('#select_region_apo_i').val();
	//var prov_apo	=$('#select_provincias').val();
	var ciudad_apo = $('#select_provincias').val();
	ciudad_apo  = ciudad_apo.split(",");
	prov_apo = ciudad_apo[0];
	var comuna_apo	    = $('#select_comunas').val();
	var fono_apo	    = $('#txt_fono_apo_').val();
	var cel_apo	    = $('#txt_celular_apo_').val();
	var mail_apo	    = $('#txt_email_apo_').val();
	var niv_edu_apo	    = $('#txt_niv_edu_apo_').val();
	var ocupacion_apo	    = $('#txt_ocupacion_apo_').val();
	var religion_apo	    = $('#txt_religion_apo_').val();
	var sistema_salud	    = $('#select_sistema_salud_apo_').val();
	var relacion      =  $('#relacion').val();
	var txt_profesion_apo = $('#txt_profesion_apo_').val();
	
	
	var edad_primer_parto = $('#txtEDADPRIMERPARTO_').val();
	
	var ultimo_ano_aprobado	= $('#cmbULTIMOANO_').val();
	
	var estado_civil	= $('#cmbESTADOCIVILX').val();
	var tipo_trabajo	= $('#cmbTIPOTRABAJOX').val();
	
	
	if($("#_chk_apoderado").is(':checked')){
			var chk_apoderado=1;
		}else{
			var chk_apoderado=0;
	}  
	if($("#_chk_sostenedor").is(':checked')){
			var chk_sostenedor=1;
		}else{
			var chk_sostenedor=0;
	}  		
	
	var pais_origen_apo = ($('#pais_origen_apo').val()>0)?$('#pais_origen_apo').val():46;
	
		var parametros='funcion='+funcion+'&rut_alumno='+rut_alumno+'&rut_apo='+rut_apo+'&dig_rut_apo='+dig_rut_apo+'&chk_apoderado='+chk_apoderado+'&chk_sostenedor='+chk_sostenedor+'&relacion='+relacion+'&nombre_apo='+nombre_apo+'&ape_pat='+ape_pat+'&ape_mat='+ape_mat+'&fecha_nac='+fecha_nac+'&sexo='+sexo+'&nacionalidad='+nacionalidad+'&calle_apo='+calle_apo+'&nro_apo='+nro_apo+'&block_apo='+block_apo+'&depto_apo='+depto_apo+'&villa_apo='+villa_apo+'&comuna_apo='+comuna_apo+'&fono_apo='+fono_apo+'&cel_apo='+cel_apo+'&mail_apo='+mail_apo+'&niv_edu_apo='+niv_edu_apo+'&ocupacion_apo='+ocupacion_apo+'&religion_apo='+religion_apo+'&sistema_salud='+sistema_salud+'&region_apo='+region_apo+'&prov_apo='+prov_apo+"&txt_profesion_apo="+txt_profesion_apo+"&edad_primer_parto="+edad_primer_parto+"&ultimo_ano_aprobado="+ultimo_ano_aprobado+"&estado_civil="+estado_civil+"&tipo_trabajo="+tipo_trabajo+"&pais_origen_apo="+pais_origen_apo;
		
		<?php if($_PERFIL==0){?>
		//alert(parametros);	
		<?php }?>
	
	if(confirm("Desea Guardar")){
	 $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 //alert(data);
		// document.writeln(data);
		//console.log(data);
		  if(data==1){
			  alert("Datos Guardados");
			  alert("Relacion creada");
			  cargaTabs();
		  }else{
			  alert("Error al Guardar 5");
		  }
	   // $("#carga_si_encuentra").html(data);
		//$('#guardar_apo').hide();
		//$('#guardar_apo_nuevo').show();
		  }
	  }) 
	}
	
  }
  
   
  function guarda_familiar()
  {
	  var rut_apo=$('#rut_fam').val();
	  var funcion = 8;
	  var rut_alumno = "<?=$alumno?>";
	   
	  parametros="funcion="+funcion+"&rut_apo="+rut_apo+"&rut_alumno="+rut_alumno;
	// alert(parametros);

	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // alert(data);
		  if(data==1){
			  alert("Relacion Creada");
		  }else{
			alert("La Relacion ya ha sido creada");  
		  }
	    }
	  })
  }
  
  function get_familiar(rut_apo)
  {
	 // alert(rut_apo);
	  $("#carga_familiar").html(""); 
	  $('#Modifica_fam').hide();
	  $('#ingresa_fam').show();
	  $('#volver_fam').hide();
	  if(rut_apo>0){
	 //alert(rut_apo);
	 var funcion = 6;		
	parametros="funcion="+funcion+"&rut="+rut_apo;
	//alert(parametros);
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){

	    $("#carga_familiar").html(data);
		$('#Modifica_fam').show();
		$('#ingresa_fam').hide();
		 $('#volver_fam').show();

   		
	    }
	  })  
	 }
  }
  
  function Modifica_familiar(rut_apo)
  {
	  if(rut_apo==undefined){
		 rut_apo=$('#hidden_rut_familiar').val(); 
	  }
	  rut_alumno = <?=$alumno;?>
	  
	  $("#tabla_mod_familiar").html("");
	  $('#div_mofificar').hide();
	
		if(rut_apo>0){
		 var funcion = 10;		
		 parametros="funcion="+funcion+"&rut_apo="+rut_apo+"&rut_alumno="+rut_alumno;
		//alert(parametros);
		  $.ajax({
		  url:'cont_ficha_alumno.php',
		  data:parametros,
		  type:'POST',
		  success:function(data){
		  //alert(data); 	
			 // modifica_datos();
			$("#tabla_mod_familiar").html(data);
			$('#Modifica_fam').show();
			$('#div_mofificar').show();
			//$('#ingresa_fam').hide();
			}
		  })  
		
	   }
  }
  
    function modificar_becas()
  {
	  var rut_alumno="<?=$alumno?>";
	 // alert(rut_alumno);
	  var funcion=16
	  var parametros = 'funcion='+funcion+'&rut_alumno='+rut_alumno;
	 // alert(parametros);
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// alert(data);
		// $('#mod_becas').show();
	    $("#mod_becas").html(data);
		//$("#muestra_becas").hide();
		//$('#guardar_apo').hide();
		
		
	   }
	})		
  }
  
  function agregar_grupo()
  {
	var rdb = "<?=$institucion?>";
	var funcion=17;
	var parametros ='funcion='+funcion+'&rdb='+rdb;
	
	//alert(parametros);
	 $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// alert(data);
		// $('#mod_becas').show();
	   $("#agrega_grupos").html(data);
	   $('#agregar_gruposx').hide();
	   $("#muestra_grupos").hide();
	   $("#agrega_grupos").show();
		
		//$('#botones_g2').show();
		
	   }
	})		
  }
  
  
   function vuelve_g()
  {
	  //alert('aqui');
	$("#agrega_grupos").hide();
	$('#agregar_gruposx').show();
	$("#muestra_grupos").show();
  }
  
  function guarda_grupo(id_grupo,nombre_check)
  {
	
	var funcion = 18;  
	var rut_alumno = "<?=$alumno?>";  
    var id_ano   = "<?=$ano;?>";
	var id_curso = "<?=$id_curso?>";
	
	
	var parametros = 'funcion='+funcion+'&rut_alumno='+rut_alumno+'&id_grupo='+id_grupo+'&id_ano='+id_ano+'&id_curso='+id_curso;

	if(confirm("Desea Añadir al Grupo")){
	
	 $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //alert(data);
	  if(data==1){
		  alert("Datos Guardados");
		  $("#"+nombre_check+"").attr('checked', false);
		   cargaTabs();
		  }else{
		  alert("Error Al Guardar");	
		  return false;			  
	 }
		
	   }
	})	
  }
 }
 
 function elimina_grupo(x)
 {
	var funcion=19;
	var id_aux =x;
	
	var parametros = 'funcion='+funcion+'&id_aux='+id_aux;
	//alert(parametros);
if(confirm("El Registro se Eliminara")){	
	$.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //alert(data);
	  if(data==1){
		  alert("Datos Eliminados");
		   cargaTabs();
		  }else{
		  alert("Error Al Eliminar");	
		  return false;			  
	 }
		
	   }
	})	
  }
}

function agregar_entrevistas()
{
	var nombre_apo = $('#hidden_n_apo').val();
	var rut_apo = $('#h_rut_responsable').val();
	var funcion = 20;
		var parametros = 'funcion='+funcion+'&nombre_apo='+nombre_apo+"&rut_apo="+rut_apo;
		//alert(parametros);
		
	$.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  $('#div_agrega_ent').show();
	 $('#div_agrega_ent').html(data);
		 $('#contenedor_ent').hide();
		
	   }
	})		
}

function volver_ent(){
	$('#div_agrega_ent').hide();
		 $('#contenedor_ent').show();
	} 
	
	
	function guardar_entrevistas()
	{
		
		var rut_apo = $('#h_rut_responsable').val()
		var rut_alumno = "<?=$alumno?>";
		var id_ano = "<?=$ano?>";
		var rdb = "<?=$institucion?>";
		var fecha_ent = $('#fecha_ent').val();
		var asunto_ent = $('#asunto_ent').val();
		var contenido_ent = $('#contenido_ent').val();
		var compromiso_ent = $('#compromiso_ent').val();
		var acuerdo_ent = $('#acuerdo_ent').val();
		var fecha_citacion = $('#fecha_citacion').val();
		var convoca = $('#convoca').val();
		
		if($("#tipo_entrevista1").is(':checked')) {
           var tipo_entrevista =1; 
        } else if($("#tipo_entrevista2").is(':checked')) {  
           var tipo_entrevista =2; 
        }  
		
		var id_asistencia=$("#id_asistencia").val();
		
		
		var motivo_ent = $('#motivo_ent').val();
		var canal = $('#canal').val();
		
		
		var funcion = 21;
		 
		var parametros = 'funcion='+funcion+'&rut_apo='+rut_apo+'&rut_alumno='+rut_alumno+'&id_ano='+id_ano+'&rdb='+rdb+'&fecha_ent='+fecha_ent+'&asunto_ent='+asunto_ent+'&contenido_ent='+contenido_ent+"&tipo_entrevista="+tipo_entrevista+"&id_asistencia="+id_asistencia+"&fecha_citacion="+fecha_citacion+"&motivo_ent="+motivo_ent+"&compromiso_ent="+compromiso_ent+"&acuerdo_ent="+acuerdo_ent+"&convoca="+convoca+"&canal="+canal;
		//alert(parametros);
if(confirm("Desea Guardar?")){		
		$.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// console.log(data);
		 //alert(data);
		  if(data==1){
			alert("Datos Guardados");
			cargaTabs();
			traeComprobanteEntrevista(rut_apo,fecha_ent,asunto_ent,contenido_ent,tipo_entrevista,id_asistencia,fecha_citacion,motivo_ent,compromiso_ent,acuerdo_ent,convoca,canal);			  
		  	
			
		  }else{
			  alert("Error al Guardar");
			}
		
	   }
	})		
  }
}
   
   function elimina_ent(id_entrevista,citacion)
   {
	   var funcion = 22;
	   
	   var parametros = 'funcion='+funcion+'&id_entrevista='+id_entrevista+"&citacion="+citacion;
		//alert(parametros);
 if(confirm("Desea Eliminar el Registro")){	
	$.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
			if(data==1){
				alert("Registro Eliminado");
				cargaTabs();
				}else{
				alert("Error al eliminar");	
				return false;
				}
		
	   }
	})
   }
 }
 
 function cargaCitacionAll(){
	var funcion = 24;
	var id_ano = "<?=$ano?>";
	   
   var parametros = 'funcion='+funcion+'&rut_apo='+$("#h_rut_responsable").val()+"&id_ano="+id_ano;
	//alert(parametros);
	
	$.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
			$("#citacioncmb").html(data);
		
	   }
	})
 }
 
 function cargaCitacion1(){
	
	var funcion = 25;
	var id_ano = "<?=$ano?>";
	var rut_apo=$("#h_rut_responsable").val();
	var id_citacion=$("#cmbTipo").val();
    var parametros = 'funcion='+funcion+'&rut_apo='+rut_apo+"&id_ano="+id_ano+"&id_citacion="+id_citacion;
		
	$.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==0){
			 alert("sin informacion");
			 }
			 else{
				$("#idasis").html(data);
			 }
		 }
	})
	}
	
	function traeComprobanteEntrevista(rut_apo,fecha_ent,asunto_ent,contenido_ent,tipo_entrevista,id_asistencia,fecha_citacion,motivo_ent,compromiso_ent,acuerdo_ent,convoca,canal){
		var funcion=26;
		var rut_alumno = "<?=$alumno?>";  
		var id_ano   = "<?=$ano;?>";
		var id_curso = "<?=$id_curso?>";
		
		//var id_citacion=$("#cmbTipo").val();
		
		var parametros="funcion="+funcion+"&rut_alumno="+rut_alumno+"&id_ano="+id_ano+"&id_curso="+id_curso+"&rut_apo="+rut_apo+"&fecha_ent="+fecha_ent+"&asunto_ent="+asunto_ent+"&contenido_ent="+contenido_ent+"&tipo_entrevista="+tipo_entrevista+"&id_asistencia="+id_asistencia+"&fecha_citacion="+fecha_citacion+"&motivo_ent="+motivo_ent+"&compromiso_ent="+compromiso_ent+"&acuerdo_ent="+acuerdo_ent+"&convoca="+convoca+"&canal="+canal;
		
		$.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  target:'_blank',
	  success:function(data){
		  $(".print").html(data);
		$("#dialog_entr").dialog({
				autoOpen:true,
				width: "740px",
  				maxWidth: "550px",
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
		 $( "#dialog_entr" ).dialog( "close" );
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
	})
		
	}
	
	function PrintElem(elem)
    {
        Popup($(elem).html());
    }

    function Popup(data) 
    {
        var mywindow = window.open('', 'Códigos Curso', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Códigos Curso</title>');
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

function nacio(){
	var nac = $("input[name='nacionalidad']:checked").val();
	if(nac==1){
		$("#pais_origen").val(0);
		
	}
	else{
		$("#pais_origen").val(46);
		
	
	}

}
function traeComprobanteEntrevista2(ident,idcit){
	var funcion=27;
	var rut_alumno = "<?=$alumno?>";  	var id_ano   = "<?=$ano;?>";
	var id_curso = "<?=$id_curso?>";
	var rut_apo=$("#h_rut_responsable").val();
	
	
	var parametros = "funcion="+funcion+"&id_entrevista="+ident+"&idcit="+idcit+"&rut_alumno="+rut_alumno+"&id_ano="+id_ano+"&id_curso="+id_curso+"&rut_apo="+rut_apo;
	
	$.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
				  
		  var fil = data.split("_");
		 		  
		   traeComprobanteEntrevista(rut_apo,fil[0],fil[1],fil[2],fil[3],idcit,fil[4],fil[5],fil[6],fil[7],fil[8],fil[9])
		
		 }
	})
	
}

function IngresoCitacion()
{
	var ano =<?php echo $_ANO ?>;
	var curso =<?php echo isset($_GET['crs'])?$_GET['crs']:$_CURSO ?>;
	var alumno =<?php echo $_GET['alumno'] ?>;
	var rut_apo=$("#h_rut_responsable").val();
	var parametros ="funcion=28&curso="+curso+"&ano="+ano+"&rut_alumno="+alumno+"&rut_apo="+rut_apo;
	//console.log(parametros);
	
	$.ajax({
		url:'cont_ficha_alumno.php',
		data:parametros,
		type:'POST',
		success:function(data){
			$("#citacion").html(data);
			$("#citacion").dialog({
				autoOpen:true,
				width: "740px",
  				maxWidth: "550px",
				show: {
				effect: "blind",
				duration: 1000
				},
				hide: {
				effect: "explode",
				duration: 1000
				},
				
    buttons: {
	 "Guardar": function(){
		guarda_Cita();
		 $(this).dialog("close");
		 } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	} 
				});
			//console.log(data);
			/*if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				$("#tabla").html(data);	
			}*/
		}
	})
}   
function IngresoPatologia(){
	$("#formulario_clas").html('<br><table><tr><td width="180"><label>Nombre:</label></td><td width="174"><input name="nombre_clas" id="nombre_clas" type="text" size="15" maxlength="30" /></td></tr></table>');
		   
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
	
var parametros = "funcion=29&nombre="+$("#nombre_clas").val();
  $.ajax({
	url:"cont_ficha_alumno.php",
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
	
var parametros="funcion=30";
	$.ajax({
	url:'cont_ficha_alumno.php',
	data:parametros,
	type:'POST',
	success:function(data){
		console.log(data);
		
	//alert(data);
		if(data==0){
		alert("Error al Cargar");
		}else{
			$('#asuntoCI').html(data);
			
			}
		 }
	 })
} // fin funcion cargartabla
	
	function guarda_Cita(){
		var ano 	= <?php echo $_ANO ?>;
		var curso 	= $("#crs").val();
		var apoderado 	= $("#cmbAPODERADOI").val();
		var fecha 	= $("#txtFECHAS").val();
		var hora= $("#txtHORAINGRESO").val();
		var mensaje = utf8_encode($("#txtOBS").val());
		var asunto	= $("#cmbASUNTOI").val();
		var empleado	= $("#cmbEmpleadoCI").val();
		
		var parametros = "funcion=5&ano="+ano+"&curso="+curso+"&apoderado="+apoderado+"&fecha="+fecha+"&hora="+hora+"&mensaje="+mensaje+"&asunto="+asunto+"&empleado="+empleado;
		
		$.ajax({
		url:'../../citacion/cont_citacion.php',
		data:parametros,
		type:'POST',
		success:function(data){
			//console.log(data);
			<?php if($_COMUNICAPP!=0){?>
			var token = "RWR1SW1wdWxzYQ==";
			var url2 = "https://www.comunicapp.cl/api_partners/EnvioAlumnoEspecifico";
			var modo = "Alumno Especifico";
			var user_name="<?php echo ($_PERFIL==0)?"Admin":trim($_USUARIOENSESION); ?>";
			var user_type="<?php echo $cargouser?>;";
			var fecha2="<?php echo date("Y-m-d") ?>";
			var hora2="<?php echo date("H:i:s") ?>";
			var mensaje2="Citacion a establecimiento de "+$("#cmbEmpleadoCI option:selected").text().trim()+" el día "+fecha+" a las "+hora+" hrs. Motivo Citacion: "+mensaje;
			var tipo_mensaje=5;
			
			
			//alert(mensaje2);
			$.ajax({
            data: {'token': token, 'rbd':<?php echo $institucion ?>, 'curso':curso, 'alumnos':[<?php echo $_GET['alumno'] ?>],'user': empleado, 'fecha':fecha,'hora':hora,'modo':modo,'user_name':user_name, 'user_type':user_type,'texto':mensaje2},
            url: url2,
            xhrFields: {
                withCredentials: true
            },
            type: 'POST',
            success: function (response) {//resultado de la función
              //  console.log(response);
				guardaMensajeCitacion (token,modo,user_name,user_type,fecha2,hora2,mensaje2,<?php echo $_GET['crs'] ?>,<?php echo $_GET['alumno'] ?>,tipo_mensaje);
				
            }
        });
			<?php }?>
			alert("Citaci\xf3n cargada");
			
			cargaCitacionAll();
			/*if(data==0){
				alert("ERROR DE SISTEMA");	
			}else{
				listado();
			}*/
		}
		})
	}
	
<?php if($_COMUNICAPP==17){?>
function guardaMensajeCitacion(token,modo,user_name,user_type,fecha2,hora2,mensaje2,curso,alumno,tipo_mensaje){

var user2 = <?php echo ($_PERFIL==0)?0:$_NOMBREUSUARIO ?>;

var parametros="funcion=31&token="+token+"&modo="+modo+"&user_name="+user2+"&user_type="+user_type+"&fecha="+fecha2+"&hora="+hora2+"&mensaje="+mensaje2+"&curso="+curso+"&alumno="+alumno+"&tipo_mensaje="+tipo_mensaje;

$.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
			console.log(data);
		
	   }
	})

	
}
<?php }?>
</SCRIPT>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">


<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <? include("../../../../../../cabecera/menu_superior.php"); ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral=3; include("../../../../../../menus/menu_lateral.php"); ?>
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  <br>
	 <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
     
     <div id="gif_sige" style="text-align:right"><!--<img src="../../../../../../images/Optimizando_Modulo2.gif">&nbsp;&nbsp;--><img src="../../../../../clases/soap/gif_sige.gif"></div>
     <br>
     
      <table width="100%" align="center">
       <tr class="tableindex">
        <td  align="center"><strong>FICHA DEL ALUMNO&nbsp;</strong><div style="size:10; float:inherit" id="ano_acad"></div></td>
       </tr>
       <tr>
       <td>
<div id="foto_alumno" style="width:80; height:90; float:right"  >
<img src="../../../../../../infousuario/images/<?=trim($alumno)  ?>" width="80" height="90"></div>
</td>
       </tr>
    </table>
	
<div id="modulodatos" align="center" ></div>
<div id="dialog_rut" align="center" title="Modifica Rut Alumno" ></div>
<div id="valida_rut"></div>
<div id="dialog_entr">
 <div class="print"></div>
 <div id="citacion"></div>
  <div id="formulario_clas"></div>
</div>

     <!-- FIN DEL NUEVO CÓDIGO -->
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
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>

</body>
</html>
<?
pg_close($conn);
pg_close($connection);
?>