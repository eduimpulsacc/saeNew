<? 
require('../../../util/header.inc');
require_once("includes/widgets/widgets_start.php");
$institucion	=$_INSTIT;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function muestra_tabla(tabla,span){
	t=document.getElementById(tabla);
	span2=document.getElementById(span);
	temp=document.getElementById(tabla);
	document.getElementById('personal').style.display='none';
	document.getElementById('docente').style.display='none';
	document.getElementById('curriculum').style.display='none';
	document.getElementById('accesoweb').style.display='none';
	document.getElementById('grupos').style.display='none';
	document.getElementById('pesta1').className='span_normal';
	document.getElementById('pesta2').className='span_normal';
	document.getElementById('pesta3').className='span_normal';
	document.getElementById('pesta4').className='span_normal';
	document.getElementById('pesta5').className='span_normal';
	t.style.display="";
	span2.className='span_seleccionado';
}

function uno(span){
	document.getElementById('habilitado').style.display='block';
    document.getElementById('autorizacion').style.display='none';	
}

function dos(span){
	document.getElementById('habilitado').style.display='none';
	document.getElementById('autorizacion').style.display='block';	
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
//-->
</script>
<script type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<SCRIPT language="JavaScript" src="chkform.js"></SCRIPT>
 <script language="javascript" type="text/javascript">
<!--
function getElementObject(elementID) {
         var elemObj = null;
         if (document.getElementById) {
            elemObj = document.getElementById(elementID);
         }
         return elemObj;
       } 

       function mostrar_ocultar(obj){
          a=getElementObject(obj);
	      if (a.style.display==""){
		     a.style.display="none";
	      }else{
		     a.style.display="";
	      }
	   }

       function chekear(obj){
	     //a=getElementObject(obj);
	     a=window.document.frm.cod_subsector;
	     largo=	window.document.frm.cod_subsector.length;
		for (i=0;i<largo;i++)	{
	       if (a[i].checked==true){
		      a[i].checked=false;
	       }else{
		      a[i].checked=true;
		   }
        }
       }	
	function SwitchMenuAnotacion(obj){  
   	var el = document.getElementById(obj);
	var ar = document.getElementById("masterdiv3").getElementsByTagName("span"); //DynamicDrive.com change
}

<!-- VALIDACIONES A FORMULARIOS -->
function valida_nuevo_empleado(f){
     if (f.rut.value==""){
	     alert('Debe ingresar su rut, en campo Rut');
		 f.rut.focus();
		 return false;
	 }
	 if (f.dig.value==""){
	     alert('Debe ingresar dígito verificador de rut');
		 f.dig.focus();
		 return false;
	 }
	 if (f.nombres.value==""){
	     alert('Debe ingresar nombre de empleado, en campo nombre');
		 f.nombres.focus();
		 return false;
	 }
	 if (f.ape_pat.value==""){
	     alert('Debe ingresar apellido paterno');
		 f.ape_pat.focus();
		 return false;
	 }
	 if (f.ape_mat.value==""){
	     alert('Debe ingresar apellido materno');
		 f.ape_mat.focus();
		 return false;
	 }
	 if (f.region.value==0){
	     alert('Debe seleccionar una Región');
		 f.region.focus();
		 return false;
	 }
	 if (f.provincia.value==0){
	     alert('Debe seleccionar una Provincia');
		 f.provincia.focus();
		 return false;
	 }
	 if (f.comuna.value==0){
	     alert('Debe seleccionar una Comuna');
		 f.comuna.focus();
		 return false;
	 }else{
	     guarda_pesta_1(f);
	 
	 }
}

function valida_rut(f){
		if(!chkVacio(f.rut,'Ingresar RUT.')){
		    f.rut.focus();
			return false;
		};

		if(!nroOnly(f.rut,'Se permiten sólo números en el RUT.')){
		    f.rut.focus();
			return false;
		};	

		if(!chkVacio(f.dig,'Ingresar dígito verificador del RUT.')){
		    f.dig.focus();
			return false;
		};	

		if(!chkCod(f.rut,f.dig,'RUT inválido.')){
		    f.dig.focus();
			return false;
		}
}

function graba_habilitaciones(f){
    if (f.fecha_hab.value==""){
	     alert('Debe ingresar fecha de habilitación');
		 f.fecha_hab.focus();
		 return false;
	 }
	 if (f.resolucion.value==""){
	     alert('Debe ingresar número de resolución');
		 f.resolucion.focus();
		 return false;
	 }
	 if (f.inscripcion.value==""){
	     alert('Debe ingresar número de inscripción');
		 f.inscripcion.focus();
		 return false;
	 }
	 if (f.subsectores.value==0){
	     alert('Debe seleccionar un subsector');
		 f.subsectores.focus();
		 return false;
	 }
	 if (f.cmb_tipoensenanza.value==0){
	     alert('Debe seleccionar tipo de enseñanza');
		 f.cmb_tipoensenanza.focus();
		 return false;
	 }else{
		 guarda_pesta_2_hab(f);
	 }   
}

function guarda_pesta_2_hab(f){
   /*
   document.getElementById("da_fecha_hab").style.display='none';
   document.getElementById("da_resolucion").style.display='none';
   document.getElementById("da_inscripcion").style.display='none';
   document.getElementById("da_subsectores").style.display='none';
   document.getElementById("da_tipoensenanza").style.display='none';
   document.getElementById("da_cursos").style.display='none';    
   document.getElementById("da_tipo_autoriz").style.display='none'; 
   */
   /// enviar a grabar por Ajax
      
   f.fecha_hab.value = "";
   f.resolucion.value = "";
   f.inscripcion.value = "";
   f.subsectores.value = 0;
   f.cmb_tipoensenanza.value=0;
   f.c1b.checked=f.checkaux.checked;
   f.c2b.checked=f.checkaux.checked;
   f.c3b.checked=f.checkaux.checked;
   f.c4b.checked=f.checkaux.checked;
   f.c5b.checked=f.checkaux.checked;
   f.c6b.checked=f.checkaux.checked;
   f.c7b.checked=f.checkaux.checked;
   f.c8b.checked=f.checkaux.checked;
   f.c1m.checked=f.checkaux.checked;
   f.c2m.checked=f.checkaux.checked;
   f.c3m.checked=f.checkaux.checked;
   f.c4m.checked=f.checkaux.checked;
      
   /*   
   document.getElementById("da_fecha_hab").style.display='block';
   document.getElementById("da_resolucion").style.display='block';
   document.getElementById("da_inscripcion").style.display='block';
   document.getElementById("da_subsectores").style.display='block';
   document.getElementById("da_tipoensenanza").style.display='block';
   document.getElementById("da_cursos").style.display='block';
   document.getElementById("da_tipo_autoriz").style.display='block';	   
   */
}

function graba_aut_doc(f){
   var check1 = f.check1.value;
   var check2 = f.check2.value;
   var check3 = f.check3.value;
   f.check1.disabled="disabled";
   f.check2.disabled="disabled";
   f.check3.disabled="disabled";
   document.getElementById("d_n_res").style.display='none';
   document.getElementById("d_fecha_res").style.display='none';
   document.getElementById("d_titulo1").style.display='none';
   document.getElementById("d_institucion1").style.display='none';
   document.getElementById("d_campo_ano1").style.display='none';
   document.getElementById("d_titulo2").style.display='none';
   document.getElementById("d_institucion2").style.display='none';
   document.getElementById("d_campo_ano2").style.display='none';
   document.getElementById("d_titulo3").style.display='none';
   document.getElementById("d_institucion3").style.display='none';
   document.getElementById("d_campo_ano3").style.display='none';
   document.getElementById("d_postitulo1").style.display='none';
   document.getElementById("d_postitulo2").style.display='none';
   document.getElementById("d_posgrado1").style.display='none';
   document.getElementById("d_posgrado2").style.display='none';
   document.getElementById("d_curso1").style.display='none';
   document.getElementById("d_campo_ano_curso1").style.display='none';
   document.getElementById("d_horas1").style.display='none';
   document.getElementById("d_curso2").style.display='none';
   document.getElementById("d_campo_ano_curso2").style.display='none';
   document.getElementById("d_horas2").style.display='none';
   document.getElementById("d_curso3").style.display='none';
   document.getElementById("d_campo_ano_curso3").style.display='none';
   document.getElementById("d_horas3").style.display='none';
   document.getElementById("d_curso4").style.display='none';
   document.getElementById("d_campo_ano_curso4").style.display='none';
   document.getElementById("d_horas4").style.display='none';
   document.getElementById("d_resumen_est").style.display='none'; 
   
   var n_res = f.n_res.value;
   var fecha_res = f.fecha_res.value;
   var titulo1 = f.titulo1.value;
   var institucion1 = f.institucion1.value;
   var campo_ano1 = f.campo_ano1.value;
   var titulo2 = f.titulo2.value;
   var institucion2 = f.institucion2.value;
   var campo_ano2 = f.campo_ano2.value;
   var titulo3 = f.titulo3.value;
   var institucion3 = f.institucion3.value;
   var campo_ano3 = f.campo_ano3.value;
   var postitulo1 = f.postitulo1.value;
   var postitulo2 = f.postitulo2.value;
   var posgrado1 = f.posgrado1.value;
   var posgrado2 = f.posgrado2.value;
   var curso1 = f.curso1.value;
   var campo_ano_curso1 = f.campo_ano_curso1.value;
   var horas1 = f.horas1.value;
   var curso2 = f.curso2.value;
   var campo_ano_curso2 = f.campo_ano_curso2.value;
   var horas2 = f.horas2.value;
   var curso3 = f.curso3.value;
   var campo_ano_curso3 = f.campo_ano_curso3.value;
   var horas3 = f.horas3.value;
   var curso4 = f.curso4.value;
   var campo_ano_curso4 = f.campo_ano_curso4.value;
   var horas4 = f.horas4.value;
   var resumen_est = f.resumen_est.value;
   
   document.getElementById("d_n_res").innerHTML=n_res;
   document.getElementById("d_n_res").style.display='block';   
   document.getElementById("d_fecha_res").innerHTML=fecha_res;
   document.getElementById("d_fecha_res").style.display='block';   
   document.getElementById("d_titulo1").innerHTML=titulo1;
   document.getElementById("d_titulo1").style.display='block';   
   document.getElementById("d_institucion1").innerHTML=institucion1;
   document.getElementById("d_institucion1").style.display='block';   
   document.getElementById("d_campo_ano1").innerHTML=campo_ano1;
   document.getElementById("d_campo_ano1").style.display='block';   
   document.getElementById("d_titulo2").innerHTML=titulo2;
   document.getElementById("d_titulo2").style.display='block';   
   document.getElementById("d_institucion2").innerHTML=institucion2;
   document.getElementById("d_institucion2").style.display='block';   
   document.getElementById("d_campo_ano2").innerHTML=campo_ano2;
   document.getElementById("d_campo_ano2").style.display='block';   
   document.getElementById("d_titulo3").innerHTML=titulo3;
   document.getElementById("d_titulo3").style.display='block';   
   document.getElementById("d_institucion3").innerHTML=institucion3;
   document.getElementById("d_institucion3").style.display='block';   
   document.getElementById("d_campo_ano3").innerHTML=campo_ano3;
   document.getElementById("d_campo_ano3").style.display='block';   
   document.getElementById("d_postitulo1").innerHTML=postitulo1;
   document.getElementById("d_postitulo1").style.display='block';   
   document.getElementById("d_postitulo2").innerHTML=postitulo2;
   document.getElementById("d_postitulo2").style.display='block';   
   document.getElementById("d_posgrado1").innerHTML=posgrado1;
   document.getElementById("d_posgrado1").style.display='block';   
   document.getElementById("d_posgrado2").innerHTML=posgrado2;
   document.getElementById("d_posgrado2").style.display='block';   
   document.getElementById("d_curso1").innerHTML=curso1;
   document.getElementById("d_curso1").style.display='block';   
   document.getElementById("d_campo_ano_curso1").innerHTML=campo_ano_curso1;
   document.getElementById("d_campo_ano_curso1").style.display='block';   
   document.getElementById("d_horas1").innerHTML=horas1;
   document.getElementById("d_horas1").style.display='block';   
   document.getElementById("d_curso2").innerHTML=curso2;
   document.getElementById("d_curso2").style.display='block';   
   document.getElementById("d_campo_ano_curso2").innerHTML=campo_ano_curso2;
   document.getElementById("d_campo_ano_curso2").style.display='block';   
   document.getElementById("d_horas2").innerHTML=horas2;
   document.getElementById("d_horas2").style.display='block';   
   document.getElementById("d_curso3").innerHTML=curso3;
   document.getElementById("d_curso3").style.display='block';   
   document.getElementById("d_campo_ano_curso3").innerHTML=campo_ano_curso3;
   document.getElementById("d_campo_ano_curso3").style.display='block';   
   document.getElementById("d_horas3").innerHTML=horas3;
   document.getElementById("d_horas3").style.display='block';   
   document.getElementById("d_curso4").innerHTML=curso4;
   document.getElementById("d_curso4").style.display='block';   
   document.getElementById("d_campo_ano_curso4").innerHTML=campo_ano_curso4;
   document.getElementById("d_campo_ano_curso4").style.display='block';   
   document.getElementById("d_horas4").innerHTML=horas4;
   document.getElementById("d_horas4").style.display='block';
   document.getElementById("d_resumen_est").innerHTML=resumen_est;
   document.getElementById("d_resumen_est").style.display='block';    
   
   var ajax2=nuevoAjax();
      
   ajax2.open("GET", "ing_aut_doc.php?nu_resol="+n_res+"&fecha_resol="+fecha_res+"&titulo1="+titulo1+"&institucion1="+institucion1+"&campo_ano1="+campo_ano1+"&titulo2="+titulo2+"&institucion2="+institucion2+"&campo_ano2="+campo_ano2+"&titulo3="+titulo3+"&institucion3="+institucion3+"&campo_ano3="+campo_ano3+"&postitulo1="+postitulo1+"&postitulo2="+postitulo2+"&posgrado1="+posgrado1+"&posgrado2="+posgrado2+"&curso1="+curso1+"&campo_ano_curso1="+campo_ano_curso1+"&horas1="+horas1+"&curso2="+curso2+"&campo_ano_curso2="+campo_ano_curso2+"&horas2="+horas2+"&curso3="+curso3+"&campo_ano_curso3="+campo_ano_curso3+"&horas3="+horas3+"&curso4="+curso4+"&campo_ano_curso4="+campo_ano_curso4+"&horas4="+horas4+"&resumen_est="+resumen_est+"&check1="+check1+"&check2="+check2+"&check3="+check3, true);
     
   ajax2.send(null);
}

function m_o_pesta2(valor){
   if (valor==1){
      document.getElementById("autorizacion_doc").style.display='none';
	  document.getElementById("habilitaciones").style.display='block';
	  document.getElementById("da_checkaux").style.display='none';
   }
   if (valor==2){
      document.getElementById("habilitaciones").style.display='none';
	  document.getElementById("autorizacion_doc").style.display='block';   
   }

}

function enviapag(form){
    form.action = 'pag_empleado.php?pesta=2&m1=1';
	form.submit(true);
}


function guarda_pesta_1(f){
    
    document.getElementById("div_rut").style.display='none';
	document.getElementById("div_boton_nuevo_empleado").style.display='none';
	document.getElementById("div_nacionalidad").style.display='none';
	document.getElementById("div_nombres").style.display='none';
	document.getElementById("div_ape_pat").style.display='none';
	document.getElementById("div_ape_mat").style.display='none';
	document.getElementById("div_telefono").style.display='none';
	document.getElementById("div_telefono2").style.display='none';
	document.getElementById("div_telefono3").style.display='none';
	document.getElementById("div_email").style.display='none';
	document.getElementById("div_sexo").style.display='none';
	document.getElementById("div_fecha_nac").style.display='none';
	document.getElementById("div_fecha_ing").style.display='none';
	document.getElementById("div_afp").style.display='none';
	document.getElementById("div_salud").style.display='none';
	document.getElementById("div_horas").style.display='none';
	document.getElementById("div_estado_civil").style.display='none';
	document.getElementById("div_atencion").style.display='none';
	document.getElementById("div_calle").style.display='none';
	document.getElementById("div_nro").style.display='none';
	document.getElementById("div_dpto").style.display='none';
	document.getElementById("div_block").style.display='none';
	document.getElementById("div_villa_pob").style.display='none';
	document.getElementById("div_region").style.display='none';
	document.getElementById("div_provincia").style.display='none';
	document.getElementById("div_comuna").style.display='none';
	document.getElementById("direccion_region").style.display='none';
		
	var dig = f.dig.value;	
	var rut_aux = f.rut.value;
	var valor_div_rut=f.rut.value+"-"+f.dig.value;
	document.getElementById("div_rut").innerHTML=valor_div_rut;
	document.getElementById("div_rut").style.display='block';
	var valor_div_nacionalidad=f.nacionalidad.value;
	
	var valor_div_nombres=f.nombres.value;
	document.getElementById("div_nombres").innerHTML=valor_div_nombres;
	document.getElementById("div_nombres").style.display='block';
	var valor_div_ape_pat=f.ape_pat.value;
	document.getElementById("div_ape_pat").innerHTML=valor_div_ape_pat;
	document.getElementById("div_ape_pat").style.display='block';
	var valor_div_ape_mat=f.ape_mat.value;
	document.getElementById("div_ape_mat").innerHTML=valor_div_ape_mat;
	document.getElementById("div_ape_mat").style.display='block';
	var valor_div_telefono=f.telefono.value;
	document.getElementById("div_telefono").innerHTML=valor_div_telefono;
	document.getElementById("div_telefono").style.display='block';
	var valor_div_telefono2=f.telefono2.value;
	document.getElementById("div_telefono2").innerHTML=valor_div_telefono2;
	document.getElementById("div_telefono2").style.display='block';
	var valor_div_telefono3=f.telefono3.value;
	document.getElementById("div_telefono3").innerHTML=valor_div_telefono3;
	document.getElementById("div_telefono3").style.display='block';
	var valor_div_email=f.email.value;
	document.getElementById("div_email").innerHTML=valor_div_email;
	document.getElementById("div_email").style.display='block';
	var valor_div_sexo=f.sexo.value;
	
	var valor_div_fecha_nac=f.fecha_nac.value;
	document.getElementById("div_fecha_nac").innerHTML=valor_div_fecha_nac;
	document.getElementById("div_fecha_nac").style.display='block';
	var valor_div_fecha_ing=f.fecha_ing.value;
	document.getElementById("div_fecha_ing").innerHTML=valor_div_fecha_ing;
	document.getElementById("div_fecha_ing").style.display='block';
	var valor_div_afp=f.afp.value;
	document.getElementById("div_afp").innerHTML=valor_div_afp;
	document.getElementById("div_afp").style.display='block';
	var valor_div_salud=f.salud.value;
	document.getElementById("div_salud").innerHTML=valor_div_salud;
	document.getElementById("div_salud").style.display='block';
	var valor_div_horas=f.horas.value;
	document.getElementById("div_horas").innerHTML=valor_div_horas;
	document.getElementById("div_horas").style.display='block';
	var valor_div_estado_civil=f.estado_civil.value;
		
	var valor_div_atencion=f.atencion.value;
	document.getElementById("div_atencion").innerHTML=valor_div_atencion;
	document.getElementById("div_atencion").style.display='block';
	var valor_div_calle=f.calle.value;
	document.getElementById("div_calle").innerHTML=valor_div_calle;
	document.getElementById("div_calle").style.display='block';
	var valor_div_nro=f.nro.value;
	document.getElementById("div_nro").innerHTML=valor_div_nro;
	document.getElementById("div_nro").style.display='block';
	var valor_div_dpto=f.dpto.value;
	document.getElementById("div_dpto").innerHTML=valor_div_dpto;
	document.getElementById("div_dpto").style.display='block';
	var valor_div_block=f.block.value;
	document.getElementById("div_block").innerHTML=valor_div_block;
	document.getElementById("div_block").style.display='block';
	var valor_div_villa_pob=f.villa_pob.value;
	document.getElementById("div_villa_pob").innerHTML=valor_div_villa_pob;
	document.getElementById("div_villa_pob").style.display='block';
	var valor_div_region=f.region.value;
	document.getElementById("div_region").innerHTML=valor_div_region;
	document.getElementById("div_region").style.display='block';	
	var valor_div_provincia=f.provincia.value;
	document.getElementById("div_provincia").innerHTML=valor_div_provincia;
	document.getElementById("div_provincia").style.display='block';
	var valor_div_comuna=f.comuna.value;
	document.getElementById("div_comuna").innerHTML=valor_div_comuna;
	document.getElementById("div_comuna").style.display='block';
	
	
	document.getElementById("div_boton_nuevo_empleado").innerHTML="Ingreso de información exitosa.";
	document.getElementById("div_boton_nuevo_empleado").style.display='block';
	
	
	var ajax=nuevoAjax();
		ajax.open("GET", "ing_nuevo_emp.php?rut_emp="+rut_aux+"&nombre_emp="+valor_div_nombres+"&dig="+dig+"&nacionalidad="+valor_div_nacionalidad+"&ape_pat="+valor_div_ape_pat+"&ape_mat="+valor_div_ape_mat+"&telefono="+valor_div_telefono+"&telefono3="+valor_div_telefono3+"&email="+valor_div_email+"&sexo="+valor_div_sexo+"&fecha_nac="+valor_div_fecha_nac+"&fecha_ing="+valor_div_fecha_ing+"&afp="+valor_div_afp+"&salud="+valor_div_salud+"&horas="+valor_div_horas+"&estado_civil="+valor_div_estado_civil+"&atencion="+valor_div_atencion+"&calle="+valor_div_calle+"&nro="+valor_div_nro+"&dpto="+valor_div_dpto+"&block="+valor_div_block+"&villa_pob="+valor_div_villa_pob+"&region="+valor_div_region+"&provincia="+valor_div_provincia+"&comuna="+valor_div_comuna+"&telefono2="+valor_div_telefono2, true);
		ajax.send(null);
		
	if (f.nacionalidad.value==2){
	   valor_div_nacionalidad = "Chilena";
	}
	if (f.nacionalidad.value==1){
	   valor_div_nacionalidad = "Extranjera";
	}
	document.getElementById("div_nacionalidad").innerHTML=valor_div_nacionalidad;
	document.getElementById("div_nacionalidad").style.display='block';	
	
	if (f.sexo.value==1){
	    valor_div_sexo="Masculino";
	}
	if (f.sexo.value==2){
	    valor_div_sexo="Femenino";
	}	
	document.getElementById("div_sexo").innerHTML=valor_div_sexo;
	document.getElementById("div_sexo").style.display='block';	
	
	if (f.estado_civil.value==1){
	    valor_div_estado_civil="Soltero(a)";
	}
	if (f.estado_civil.value==2){
	    valor_div_estado_civil="Casado(a)";
	}
	if (f.estado_civil.value==3){
	    valor_div_estado_civil="Viudo(a)";
	}	
	document.getElementById("div_estado_civil").innerHTML=valor_div_estado_civil;
	document.getElementById("div_estado_civil").style.display='block';
		
			
	///ajax.open("GET", "ingreso_sin_recargar_proceso.php?dato="+valorInput+"&actualizar="+idInput, true);
       
}

function nuevoAjax(){ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objeto AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 
	return xmlhttp; 
} 


function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function slctr(texto,valor){
	this.texto = texto
	this.valor = valor
}

/* AQUI LAS PROVINCIAS Y SUS COMUNAS*/
<?
$sql_REG  = "SELECT * FROM REGION ORDER BY COD_REG ASC";
$res_REG	= @pg_Exec($conn,$sql_REG);
$num_REG  = @pg_numrows($res_REG);	

for ($i=0; $i < $num_REG; $i++){
    $fil_REG = @pg_fetch_array($res_REG,$i);
    $nom_reg = $fil_REG['nom_reg'];
    $cod_reg = $fil_REG['cod_reg'];
    ?>
    var  region<?=$cod_reg?>=new Array()
    <?	 
	//////////////////////////////////////////
	$sql_prov  = "SELECT * FROM PROVINCIA WHERE COD_REG='$cod_reg' ORDER BY NOM_PRO ASC";
	$res_prov  = @pg_Exec($conn,$sql_prov);
	$num_prov  = @pg_numrows($res_prov);
	?>
	region<?=$cod_reg?>[0] = new slctr('- -Seleccione Provincia- -',0)
	<?
	for ($j=0; $j < $num_prov; $j++){
		$fil_prov = @pg_fetch_array($res_prov,$j);
		$nom_pro = $fil_prov['nom_pro'];
		$cor_pro = $fil_prov['cor_pro']; 		 
		?> 
		region<?=$cod_reg?>[<?=$j + 1 ?>] = new slctr("<?=trim($nom_pro)?>",'reg<?=$cod_reg?>prov<?=$cor_pro?>')
		<?
		?>
		var reg<?=$cod_reg?>prov<?=$cor_pro?>=new Array()
		<?
		///////////////////////////////////////
		$sql_COM = "SELECT * FROM COMUNA WHERE COD_REG='$cod_reg' AND COR_PRO='$cor_pro' ORDER BY NOM_COM ASC";
	    $res_COM = @pg_Exec($conn,$sql_COM);
	    $num_COM = pg_numrows($res_COM);
		?>
		reg<?=$cod_reg?>prov<?=$cor_pro?>[0] = new slctr('- -Seleccione Comuna- -',0)
		<?
		for ($k=0; $k < $num_COM; $k++){
		    $fil_COM = @pg_fetch_array($res_COM,$k);
			$nom_com = $fil_COM['nom_com'];
			$cor_com = $fil_COM['cor_com'];
			?>
			reg<?=$cod_reg?>prov<?=$cor_pro?>[<?=$k + 1 ?>] = new slctr("<?=trim($nom_com)?>",<?=$cor_com?>)
			<?
		}		  
	}	
}	
?>
function slctryole(cual,donde){
	if(cual.selectedIndex != 0){
		donde.length=0
		cual = eval(cual.value)
		for(m=0;m<cual.length;m++){
			var nuevaOpcion = new Option(cual[m].texto);
			donde.options[m] = nuevaOpcion;
			if(cual[m].valor != null){
				donde.options[m].value = cual[m].valor
			}
			else{
				donde.options[m].value = cual[m].texto
			}
		}
	}
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}

function sel_ensenanza(f){
    if (f.cmb_tipoensenanza.value>300){
	    document.getElementById("media").style.display='block';
		document.getElementById("basica").style.display='none';
	}else{
	    document.getElementById("basica").style.display='block';
	    document.getElementById("media").style.display='none';
	}	     
}
</script>
<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
<SCRIPT language="JavaScript">
  document.getElementById("habilitaciones").style.display='none';
</SCRIPT>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo3 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="
<?

   if (($pesta == "") or ($pesta == NULL) or ($pesta == " ") or ($pesta == 1) or (!isset($pesta))){ ?>
      muestra_tabla('personal','pesta1'); <?
   } 
   if ($pesta == 2){ ?>
      muestra_tabla('docente','pesta2');
	  <?
	  if ($m1==1){ ?>
	       uno();
		   
	<? }else{ ?>
	       dos();
	<? }
		  
   }
   if ($pesta == 3){ ?>
      muestra_tabla('curriculum','pesta3'); <?
	  
   }	   
   
   
   if ($pesta == 4){ ?>
      muestra_tabla('accesoweb','pesta4'); <?
   }
   if ($pesta == 5){ ?>
      muestra_tabla('grupos','pesta5'); <?
   }   

 ?>">
<? 
include('../../../util/rpc.php3');
?> 
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top">	
	  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="90%"  align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3">
				<table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
                    <tr> 
					
                      <td width="20%" height="363" align="left" valign="top"> 
                      <?  include("../../../menus/menu_lateral.php"); ?></td>
                      <td width="100%" align="left" valign="top"><br>
                        <table width="706" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td bgcolor="#FFFFFF"><div align="center"><a href="javascript:;" onClick="muestra_tabla('personal','pesta1');"><span id="pesta1" class="span_normal" ><img src="images/bot_personal.jpg" width="133" height="20" border="0"></span></a></div></td>
                          <td bgcolor="#FFFFFF"><div align="center"><a href="javascript:;" onClick="muestra_tabla('docente','pesta2');"><span id="pesta2" class="span_normal" ><img src="images/bot_autorizdoc.jpg" width="138" height="20" border="0"></span></a></div></td>
                          <td bgcolor="#FFFFFF"><div align="center"><a href="javascript:;" onClick="muestra_tabla('curriculum','pesta3');"><span id="pesta3" class="span_normal" ><img src="images/bot_curriculum.jpg" width="137" height="20" border="0"></span></a></div></td>
                          <td bgcolor="#FFFFFF"><div align="center"><a href="javascript:;" onClick="muestra_tabla('accesoweb','pesta4');"><span id="pesta4" class="span_normal" ><img src="images/bot_accesoweb.jpg" width="138" height="20" border="0"></span></a></div></td>
                          <td bgcolor="#FFFFFF"><div align="center"><a href="javascript:;" onClick="muestra_tabla('grupos','pesta5');"><span id="pesta5" class="span_normal" ><img src="images/bot_grupos.jpg" width="139" height="20" border="0"></span></a></div></td>
                        </tr>
                        </table>  
						<form name="form_new_emp" method="post" action="">                     
						 <table width="706" border="1" align="center" id="personal" >
                          <tr>
                            <td class="tableindex">
							
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td>Personal </td>
                                <td>
												  
								  <div align="right" id="div_boton_nuevo_empleado">
                                  <input type="button" class="botonXX" name="Submit" value="Ingresar nuevo empleado" onClick="return valida_nuevo_empleado(this.form);"></div></td>
                              </tr>
                            </table>
							</td>
                          </tr>
                          <tr>
                            <td><table width="100%" border="1" cellpadding="2" cellspacing="1">
                              <tr>
                                <td colspan="4" class="cuadro02">Datos Personales </td>
                                </tr>
                              <tr>
                                <td width="20%" class="cuadro02">Rut</td>
                                <td width="30%" class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1">
								<div id="div_rut">
								<label>
						        <input name="rut" type="text" id="rut" size="10">
                                - 
                                <input name="dig" type="text" id="dig" size="1" maxlength="1">
                                </label>
								</div>
								</td>
                                <td width="20%" class="cuadro02">Nacionalidad</td>
                                <td width="30%" class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1">
								<div id="div_nacionalidad">
								<label>
                                  <select name="nacionalidad" id="nacionalidad">
                                     <option value="2" selected="selected">Chilena </option>
									 <option value="1">Extranjera </option>
								  </select>
                                </label>
								</div>
								</td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Nombres</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_nombres"><input name="nombres" type="text" id="nombres" size="30" onFocus="valida_rut(this.form); return;"></div></td>
                                <td class="cuadro02">Apellido Paterno </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_ape_pat"><input name="ape_pat" type="text" id="ape_pat" size="30"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Apellido Materno </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_ape_mat"><input name="ape_mat" type="text" id="ape_mat" size="30"></div></td>
                                <td class="cuadro02">Tel&eacute;fono</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_telefono"><input name="telefono" type="text" id="telefono" size="30"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Tel&eacute;fono 2 </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_telefono2"><input name="telefono2" type="text" id="telefono2" size="30"></div></td>
                                <td class="cuadro02">Tel&eacute;fono 3 </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_telefono3"><input name="telefono3" type="text" id="telefono3" size="30"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">E-mail</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_email"><input name="email" type="text" id="email" size="30"></div></td>
                                <td class="cuadro02">Sexo</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1">
								<div id="div_sexo">
								<label>
                                  <select name="sexo" id="sexo">
								     <option value="1">Masculino</option>
									 <option value="2">Femenino</option>
                                  </select>
                                </label>
								</div>
								</td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Fecha de Nacimiento </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_fecha_nac">
								<input name="fecha_nac" type="widget" id="fecha_nac" size="12" maxlength="10"  subtype="wcalendar" format="%d-%m-%Y" skin="blue" language="es" label="..." mondayfirst="true" singleclick="true"  readonly="true" value=""/>								
								</div></td>
                                <td class="cuadro02">Fecha de Ingreso </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_fecha_ing"><input name="fecha_ing" type="widget" id="fecha_ing" size="12" maxlength="10"  subtype="wcalendar" format="%d-%m-%Y" skin="blue" language="es" label="..." mondayfirst="true" singleclick="true"  readonly="true" value=""/></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Previsi&oacute;n (AFP) </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_afp"><input name="afp" type="text" id="afp" size="30"></div></td>
                                <td class="cuadro02">Sistema Salud </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_salud"><input name="salud" type="text" id="salud" size="30"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Horas Pste. a&ntilde;o </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_horas"><input name="horas" type="text" id="horas" size="5"></div></td>
                                <td class="cuadro02">Estado Civil </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1">
								<div id="div_estado_civil">
								<label>
                                  <select name="estado_civil" id="estado_civil">
								       <option value="1">Soltero(a)</option>
									   <option value="2">Casado(a)</option>
									   <option value="3">Viudo(a)</option>
                                  </select>
                                </label>
								</div>
								</td>
                              </tr>
                              <tr>
                                <td class="cuadro02">D&iacute;a y hora atenci&oacute;n </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_atencion"><input name="atencion" type="text" id="atencion" size="30"></div></td>
                                <td><img src="images/cuadro_ficticeo.jpg" width="1" height="1"></td>
                                <td><img src="images/cuadro_ficticeo.jpg" width="1" height="1"></td>
                              </tr>
                              <tr>
                                <td colspan="4" class="cuadro02">Direcci&oacute;n</td>
                                </tr>
                              <tr>
                                <td class="cuadro02">Calle</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_calle"><input name="calle" type="text" id="calle" size="30"></div></td>
                                <td class="cuadro02">Nro.</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_nro"><input name="nro" type="text" id="nro" size="30"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Dpto.</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_dpto"><input name="dpto" type="text" id="dpto" size="30"></div></td>
                                <td class="cuadro02">Blcok</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_block"><input name="block" type="text" id="block" size="30"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Villa, Poblaci&oacute;n </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="div_villa_pob"><input name="villa_pob" type="text" id="villa_pob" size="30"></div></td>
                                <td><img src="images/cuadro_ficticeo.jpg" width="1" height="1"></td>
                                <td><img src="images/cuadro_ficticeo.jpg" width="1" height="1"></td>
                              </tr>
                              <tr>
                                <td colspan="4">
                                  <div id="direccion_region">
								  <table width="100%" border="1">
                                    <tr>
                                      <td width="15%" class="cuadro02">Regi&oacute;n</td>
                                      <td width="19%" class="cuadro02">Provincia</td>
                                      <td width="66%" class="cuadro02">Comuna</td>
                                    </tr>
                                    <tr>
                                      <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1">
									  <div id="div_region">
									  <label>
									  <?
									  $sql_REG  = "SELECT * FROM REGION ORDER BY COD_REG ASC";
		                              $res_REG	= @pg_Exec($conn,$sql_REG);
		                              $num_REG  = @pg_numrows($res_REG);									  
									  ?>								  
									   <select name="region" onChange="slctryole(this,this.form.provincia)">
										<option>- - Seleccionar - -</option>
										<?
										 for($i=0 ; $i < $num_REG; $i++){
										    $fil_REG = @pg_fetch_array($res_REG,$i);
											$nom_reg = $fil_REG['nom_reg'];
										    $cod_reg = $fil_REG['cod_reg'];
											?> 
										    <option value="region<?=trim($cod_reg)?>"><?=trim($nom_reg)?></option>
										    <?
										 }
										 ?>	
										
									  </select>
									  </label>
									  </div>
									  </td>
                                      <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1">
									  <div id="div_provincia">
									  <label>
									  <select name="provincia" onChange="slctryole(this,this.form.comuna)">
										<option>- - - - - -</option>
									  </select>
									  </label>
									  </div>
									  </td>
                                      <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1">
									  <div id="div_comuna">
									  <label>
									  <select name="comuna">
										<option>- - - - - -</option>
									  </select>
									  </label>
									  </div>
									  </td>
                                    </tr>
                                  </table>
								  </div>
								  
								  </td>
                                </tr>
                            </table></td>
                          </tr>
                        </table>
						</form>					
						
						
						
						
						<table width="706" border="1" align="center" id="docente">
                           <tr>
                             <td width="50%"><label>
                               <input type="submit" name="Submit2" value="Habilitaciones" onClick="m_o_pesta2(1);" class="botonXX">
                             </label></td>
                             <td width="50%"><div align="right">
                               <label>
                               <input type="submit" name="Submit3" value="Autorizaci&oacute;n docencia" onClick="m_o_pesta2(2);" class="botonXX">
                               </label>
                             </div></td>
                           </tr>
                        </table>
						
						
						<div id="autorizacion_doc">
						<form name="form_aut_doc" method="post" action="">
						<table width="706" border="1" align="center">
						  <tr>
                            <td class="tableindex">
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td>Autorización Docencia</td>
                                <td>												  
								  <div align="right" id="div_boton">
                                  <input type="button" class="botonXX" name="Submit" value="Grabar informaci&oacute;n" onClick="return graba_aut_doc(this.form);">
								  </div></td>
                               </tr>
                            </table>
							</td>
                          </tr>
                          <tr>
                            <td class="cuadro02">&nbsp;Autorización ejercicio docente</td>
                          </tr>
                          <tr>
                            <td><table width="100%" border="1" cellpadding="2" cellspacing="1">
                              <tr>
                                <td width="20%" class="cuadro02">N&ordm; Resoluci&oacute;n </td>
                                <td width="30%" class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_n_res"><input name="n_res" type="text" size="10"></div>
                                </td>
                                <td width="20%" class="cuadro02">Fecha</td>
                                <td width="30%" class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_fecha_res"><input name="fecha_res" type="widget" id="fecha_res" size="12" maxlength="10"  subtype="wcalendar" format="%d-%m-%Y" skin="blue" language="es" label="..." mondayfirst="true" singleclick="true"  readonly="true" value=""/></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Nivel</td>
                                <td colspan="3" class="cuadro01"><table width="100%" border="1">
                                  <tr>
                                    <td><font face="arial, geneva, helvetica" size=1 color=#000000><strong>
									<input type="checkbox" name="check1" value="1">              
                                    HABILITADO 
                                    <input type="checkbox" name="check2" value="1">
                                    TITULADO EN EDUCACION 
                                    <input type="checkbox" name="check3" value="1">
                                    TITULADO EN OTRAS AREAS </strong></font></td>
                                  </tr>
                                </table></td>
                                </tr>
                              <tr>
                                <td class="cuadro02">T&iacute;tulo 1</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_titulo1"><input name="titulo1" type="text" size="30"></div></td>
                                <td class="cuadro02">Instituci&oacute;n</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_institucion1"><input name="institucion1" type="text" size="30"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">A&ntilde;o</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_campo_ano1"><input name="campo_ano1" type="text" size="10"></div></td>
                                <td class="cuadro01">&nbsp;</td>
                                <td class="cuadro01">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="cuadro02">T&iacute;tulo 2 </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_titulo2"><input name="titulo2" type="text" size="30"></div></td>
                                <td class="cuadro02">Instituci&oacute;n</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_institucion2"><input name="institucion2" type="text" size="30"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">A&ntilde;o</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_campo_ano2"><input name="campo_ano2" type="text" size="10"></div></td>
                                <td class="cuadro01">&nbsp;</td>
                                <td class="cuadro01">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="cuadro02">T&iacute;tulo 3 </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_titulo3"><input name="titulo3" type="text" size="30"></div></td>
                                <td class="cuadro02">Instituci&oacute;n</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_institucion3"><input name="institucion3" type="text" size="30"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">A&ntilde;o</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_campo_ano3"><input name="campo_ano3" type="text" size="10"></div></td>
                                <td class="cuadro01">&nbsp;</td>
                                <td class="cuadro01">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Postitulo 1 </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_postitulo1"><input name="postitulo1" type="text" size="30"></div></td>
                                <td class="cuadro02">Post&iacute;tulo 2 </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_postitulo2"><input name="postitulo2" type="text" size="30"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Posgrado 1 </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_posgrado1"><input name="posgrado1" type="text" size="30"></div></td>
                                <td class="cuadro02">Posgrado 2 </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_posgrado2"><input name="posgrado2" type="text" size="30"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Curso 1 </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_curso1"><input name="curso1" type="text" size="30"></div></td>
                                <td class="cuadro02">A&ntilde;o</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_campo_ano_curso1"><input name="campo_ano_curso1" type="text" size="10"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Horas</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_horas1"><input name="horas1" type="text" size="10"></div></td>
                                <td class="cuadro01">&nbsp;</td>
                                <td class="cuadro01">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Curso 2 </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_curso2"><input name="curso2" type="text" size="30"></div></td>
                                <td class="cuadro02">A&ntilde;o</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_campo_ano_curso2"><input name="campo_ano_curso2" type="text" size="10"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Horas</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_horas2"><input name="horas2" type="text" size="10"></div></td>
                                <td class="cuadro01">&nbsp;</td>
                                <td class="cuadro01">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Curso 3 </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_curso3"><input name="curso3" type="text" size="30"></div></td>
                                <td class="cuadro02">A&ntilde;o</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_campo_ano_curso3"><input name="campo_ano_curso3" type="text" size="10"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Horas</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_horas3"><input name="horas3" type="text" size="10"></div></td>
                                <td class="cuadro01">&nbsp;</td>
                                <td class="cuadro01">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Curso 4 </td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_curso4"><input name="curso4" type="text" size="30"></div></td>
                                <td class="cuadro02">A&ntilde;o</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_campo_ano_curso4"><input name="campo_ano_curso4" type="text" size="10"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Horas</td>
                                <td class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_horas4"><input name="horas4" type="text" size="10"></div></td>
                                <td class="cuadro01">&nbsp;</td>
                                <td class="cuadro01">&nbsp;</td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Resumen Estudios </td>
                                <td colspan="3" class="cuadro01"><img src="images/cuadro_ficticeo.jpg" width="1" height="1"><div id="d_resumen_est"><textarea name="resumen_est" cols="67" rows="5"></textarea></div></td>
                                </tr>                              
                            </table></td>
                          </tr>
                        </table>
						</form>
						</div>
						
						
						<div id="habilitaciones">
						<form name="form_aut_doc" method="post" action="">
						<table width="706" border="1" align="center">
						  <tr>
                            <td class="tableindex">
							
							
							<?
						   $q1 = "select * from habilitaciones where id_ano = '".trim($_ANO)."' and rut_emp = '".trim($_EMPLEADO)."'"; 
						   $r1 = pg_Exec($conn,$q1);
						   $n1 = pg_numrows($r1);
						
						   if ($n1>0){ ?>						
							<div id="da_hab_ingresadas">
							 <table width="100%" border="0" cellspacing="1" cellpadding="3">
							     <tr>
								   <td colspan="7" class="tableindex">HABILITACIONES INGRESADAS </td>
								   </tr>
								 <tr>
								   <td width="12%" class="cuadro02"><div align="center">Fecha</div></td>
								   <td width="7%" class="cuadro02"><div align="center">Nro. Resol. </div></td>
								   <td width="7%" class="cuadro02"><div align="center">Nro. Insc. </div></td>
								   <td width="14%" class="cuadro02"><div align="center">Tipo Autriz. </div></td>
								   <td width="10%" class="cuadro02"><div align="center">Subsector</div></td>
								   <td width="40%" class="cuadro02"><div align="center">Cursos</div></td>
								   <td width="10%" class="cuadro02"><div align="center">Eliminar</div></td>
								 </tr>
								 <?
								$arreglo_temp=array();					 
								 
								 $i = 0;
								 while ($i < $n1){ 
								     $f1 = pg_fetch_array($r1,$i);
									 $id_aux        =  $f1['id_aux'];
									 $fecha2        =  $f1['fecha'];
									 $resolucion    =  $f1['resolucion'];
									 $inscripcion   =  $f1['inscripcion'];
									 $tipo_aut      =  $f1['tipo_aut'];
									 $cod_subsector =  $f1['cod_subsector'];
									 $tipo_ense     =  $f1['tipo_ense'];
									 $c1            =  $f1['c1'];
									 $c2            =  $f1['c2'];
									 $c3            =  $f1['c3'];
									 $c4            =  $f1['c4'];
									 $c5            =  $f1['c5'];
									 $c6            =  $f1['c6'];
									 $c7            =  $f1['c7'];
									 $c8            =  $f1['c8'];
									 $EP            =  $f1['EP'];
									 $EDA           =  $f1['EDA'];
									 $EDM           =  $f1['EDM'];
									 $EDV           =  $f1['EDV'];
									 $EAL           =  $f1['EAL'];
									 $ETM           =  $f1['ETM'];
									 $EA            =  $f1['EA'];								 
									 $dd = substr($fecha2,8,2);
									 $mm = substr($fecha2,5,2);
									 $aa = substr($fecha2,0,4);									 
									 $fecha2 = "$dd-$mm-$aa";				 
									 
									 if ($tipo_aut==1){
									     $tipo_aut="Indefinida";
									 }else{
									     $tipo_aut="Temporal";
									 } 								 	 								
									
									 ?>
									 <tr>
									   <td class="cuadro01">&nbsp;
									     
									       <div align="center">
									         <?=$fecha2 ?>
									         </div></td>
									   <td class="cuadro01">&nbsp;
									     
									       <div align="center">
									         <?=$resolucion ?>
									         </div></td>
									   <td class="cuadro01">&nbsp;
									     
									       <div align="center">
									         <?=$inscripcion ?>
									         </div></td>
									   <td class="cuadro01">&nbsp;
									     
									       <div align="center">
									         <?=$tipo_aut ?>
									         </div></td>										 
										<?
										// aqui agrego los subsectores asociados para esta institucion, para este año.
										$b2 = "select * from subsector where cod_subsector = '$cod_subsector'"; 
										$r2 = @pg_Exec($conn,$b2);
										$f2 = @pg_fetch_array($r2);
										$nombre_subsector = $f2['nombre'];
										?>												 
									   <td class="cuadro01">&nbsp;									     
									       <div align="center">
									         <? echo "$cod_subsector - $nombre_subsector"; ?>
									         </div></td>
									   <td class="cuadro01">
									   <div align="center">&nbsp;
									   
										  <table width="100%" border="1" cellspacing="0" cellpadding="0">
										   <tr>
										   	<? if ($c1==1){ ?>
											     <td class="cuadro02"><div align="center">1&ordm; </div></td>											 
											<? } ?>
											<? if ($c2==1){ ?> 
											     <td class="cuadro02"><div align="center">2&ordm;</div></td>											
											<? } ?>
											<? if ($c3==1){ ?>
											     <td class="cuadro02"><div align="center">3&ordm;</div></td>											 
										    <? } ?>
											<? if ($c4==1){ ?> 
											     <td class="cuadro02"><div align="center">4&ordm;</div></td>											
											<? } ?>
											<? if ($c5==1){ ?>
											     <td class="cuadro02"><div align="center">5&ordm;</div></td>												
											<? } ?>
											<? if ($c6==1){ ?>
											     <td class="cuadro02"><div align="center">6&ordm;</div></td>
											<? } ?>
											<? if ($c7==1){ ?>
											     <td class="cuadro02"><div align="center">7&ordm;</div></td>
											<? } ?>
											<? if ($c8==1){ ?>
											     <td class="cuadro02"><div align="center">8&ordm;</div></td>												 											 		 		 		 
										    <? } ?>
											
											
											
											<? if ($EP==1){ ?>
											     <? } ?>
											<? if ($EDA==1){ ?>
											     <? } ?>
											<? if ($EDM==1){ ?>
											     <? } ?>
											<? if ($EDV==1){ ?>
											     <? } ?>
											<? if ($EAL==1){ ?>
											     <? } ?>
											<? if ($ETM==1){ ?>
											     <? } ?>
											<? if ($EA==1){ ?>
											     <? } ?>
										   </tr>
										 </table>
									    </div></td>
									   <td class="cuadro01"><div align="center">
									     <label>
									     <input name="Submit3" type="submit" onClick="MM_goToURL('parent','procesoEmpleado.php3?id_aux=<?=$id_aux ?>&eli=1&pesta=2');return document.MM_returnValue" value="E">
									     </label>
									   </div></td>
									 </tr>
							         <?
									 //// codigo nuevo para llenar el arreglo cod_subsecto[]
									 $arreglo_temp[]=$cod_subsector;									 
									 
									 $i++;
								 } 
								 ?>									  		 
							   </table>
							   </div><br><br>
							   <? } ?>
							   
							   
							   
							
							
							
							
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td>Habilitaciones</td>
                                <td>												  
								  <div align="right" id="div_boton">
                                  <input type="button" class="botonXX" name="Submit" value="Grabar informaci&oacute;n" onClick="return graba_habilitaciones(this.form);">
								  </div></td>
                               </tr>
                            </table>
							</td>
                          </tr>
                          <tr>
                            <td class="cuadro02">&nbsp;Habilitaciones</td>
                          </tr>
                          <tr>
                            <td valign="top"><table width="100%" border="1" cellpadding="2" cellspacing="1">
                              <tr>
                                <td width="20%" class="cuadro02">Fecha</td>
                                <td class="cuadro01">
                                  <div id="da_fecha_hab">
								  <input name="fecha_hab" type="widget" id="fecha_hab" size="12" maxlength="10"  subtype="wcalendar" format="%d-%m-%Y" skin="blue" language="es" label="..." mondayfirst="true" singleclick="true"  readonly="true" value=""/>
                                  </div>
								</td>
                              </tr>
                              <tr>
                                <td class="cuadro02">Resoluci&oacute;n</td>
                                <td class="cuadro01"><div id="da_resolucion"><input type="text" name="resolucion"></div></td>
                              </tr>
                              <tr>
                                <td class="cuadro02">N&uacute;mero Inscripci&oacute;n </td>
                                <td class="cuadro01"><div id="da_inscripcion"><input type="text" name="inscripcion"></div></td>
                              </tr>
							<?
							// aqui agrego los subsectores asociados para esta institucion, para este año.
							$q1 = "select * from subsector where cod_subsector in (select cod_subsector from ramo where id_ramo in (select id_ramo from curso where id_curso in (select id_curso from matricula where rdb = '".trim($_INSTIT)."' and id_ano = '".trim($_ANO)."'))) order by nombre"; 
                            $r1 = @pg_Exec($conn,$q1);
							$n1 = @pg_numrows($r1);
							?>
							  
                              <tr>
                                <td class="cuadro02">Subsector</td>
                                <td class="cuadro01">
								<div id="da_subsectores">
                                  <select name="subsectores">
								    <option value="0">Seleccione subsector </option>
									   <?
									   $i = 0;
									   while ($i < $n1){
											$f1 = @pg_fetch_array($r1,$i);
											$cod_subsector = $f1['cod_subsector'];
											$nombre        = $f1['nombre'];
											if ($cod_subsector!=2338 and $cod_subsector!=2339){
											?>
											<option value="<?=$cod_subsector ?>" <? if ($cod_subsector==$cmb_subsector){ ?> selected="selected" <? } ?>><? echo "$nombre - $cod_subsector"; ?></option>
											<?
											}
											$i++;
										}
										?>	
                                  </select>
								  </div>
                                </td>
                              </tr>
							  <?
							 // aqui tomo los tipos de enseñanza 
							 $q1 = "select * from tipo_ensenanza where cod_tipo in (select cod_tipo from plan_tipo where cod_decreto in (select cod_decreto from plan_estudio where cod_decreto in (select cod_decreto from plan_inst where rdb = '".trim($_INSTIT)."')))";        
							 $r1 = @pg_Exec($conn,$q1);
							 $n1 = @pg_numrows($r1);
							 ?>  
							  
                              <tr>
                                <td class="cuadro02">Tipo de Ense&ntilde;anza </td>
                                <td class="cuadro01">
                                 <div id="da_tipoensenanza">
								  <select name="cmb_tipoensenanza" onChange="sel_ensenanza(this.form);">
								  <option value="0">Seleccione tipo de enseñanza</option>
								    <?
								   $i = 0;
								   while ($i < $n1){
									   $f1 = @pg_fetch_array($r1,$i);
									   $cod_tipo    = $f1['cod_tipo'];
									   $nombre_tipo = $f1['nombre_tipo'];									   
									   if ($cod_tipo==110 or $cod_tipo==310 or $cod_tipo==410 or $cod_tipo==510 or $cod_tipo==610 or $cod_tipo==710){
									        ?>
										    <option value="<?=$cod_tipo ?>" <? if ($cod_tipo == $cmb_tipoensenanza){ ?> selected="selected" <? } ?>><?=$nombre_tipo ?></option>
										    <?
									   }									   
									   $i++;
								   }
								   ?>	
                                  </select>
								 </div> 
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2" class="cuadro02"><div align="center">Cursos
                                 <div id="da_checkaux">
                                  <input name="checkaux" type="checkbox" id="checkaux" value="0">
                                 </div> 
                                </div>
								<br><br>
								<div id="da_cursos">
								  <div id="basica">
								    																		 
									 <table width="100%" border="1" cellspacing="0" cellpadding="0">
									   <tr>
										 <td class="cuadro02"><div align="center">1&ordm; </div></td>
										 <td class="cuadro01"><label>
											 <div align="center">
											   <input name="c1b" type="checkbox" id="c1b" value="1">
											 </div>
											 </label>                                     </td>
										 <td class="cuadro02"><div align="center">2&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c2b" type="checkbox" id="c2b" value="1">
												 </div></td>
										 <td class="cuadro02"><div align="center">3&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c3b" type="checkbox" id="c3b" value="1">
												 </div></td>
										 <td class="cuadro02"><div align="center">4&ordm;</div></td>
										 <td class="cuadro01">
										     <div align="center">
										       <input name="c4b" type="checkbox" id="c4b" value="1">
											     </div></td>											 
										<td class="cuadro02"><div align="center">5&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c5b" type="checkbox" id="c5b" value="1">
												 </div></td>
										<td class="cuadro02"><div align="center">6&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c6b" type="checkbox" id="c6b" value="1">
												 </div></td>
										<td class="cuadro02"><div align="center">7&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c7b" type="checkbox" id="c7b" value="1">
												 </div></td>
										  <td class="cuadro02"><div align="center">8&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c8b" type="checkbox" id="c8b" value="1">
												 </div></td>																		 
									   </tr>
									 </table>		
								</div>	 						 
							  
							    <div id="media">	
							         <table width="100%" border="1" cellspacing="0" cellpadding="0">
									   <tr>
										 <td class="cuadro02"><div align="center">1&ordm; </div></td>
										 <td class="cuadro01"><label>
											 <div align="center">
											   <input name="c1m" type="checkbox" id="c1m" value="1">
											 </div>
											 </label>                                     </td>
										 <td class="cuadro02"><div align="center">2&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c2m" type="checkbox" id="c2m" value="1">
												 </div></td>
										 <td class="cuadro02"><div align="center">3&ordm;</div></td>
										 <td class="cuadro01">
											 <div align="center">
											   <input name="c3m" type="checkbox" id="c3m" value="1">
												 </div></td>
										 <td class="cuadro02"><div align="center">4&ordm;</div></td>
										 <td class="cuadro01">
										     <div align="center">
										       <input name="c4m" type="checkbox" id="c4m" value="1">
											     </div></td>																							 
									   </tr>
									 </table>
									 
								</div>	 
							    </div>								
								</td>
                                </tr>
                              <tr>
                                <td class="cuadro02">Tipo de Autorizaci&oacute;n </td>
                                <td class="cuadro01">
								
								<div id="da_tipo_autoriz">
								<table width="100%" border="1">
                                  <tr>
                                    <td class="cuadro02">Temporal</td>
                                    <td class="cuadro02">Indifinida</td>
                                  </tr>
                                  <tr>
                                    <td class="cuadro01"><div align="center">
                                      <label>
                                      <input name="tipo_autoriz" type="radio" value="1" checked="checked">
                                      </label>
                                    </div></td>
                                    <td class="cuadro01"><div align="center">
                                      <label>
                                      <input name="tipo_autoriz" type="radio" value="2">
                                      </label>
                                    </div></td>
                                  </tr>
                                </table>
								</div>
								</td>
                              </tr>
                              
                            </table></td>
                          </tr>
                        </table>
						</form>
						</div>
						
						
						
						
						<table width="706" border="1" align="center" id="curriculum"> 
						  <tr>
                            <td>Curriculum</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
						<table width="706" border="1" align="center" id="accesoweb">
                          <tr>
                            <td>Acceso Web</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
						<table width="706" border="1" align="center" id="grupos">
                          <tr>
                            <td>Grupos</td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
					  </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
<? pg_close($conn);?>
</body>
</html>
<? require_once("includes/widgets/widgets_end.php");?>