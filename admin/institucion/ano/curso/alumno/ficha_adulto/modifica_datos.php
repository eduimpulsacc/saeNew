<?php
include_once('cont_ficha_alumno.php');

if($_PERFIL==0)echo $_ANO;
	//print_r($_POST);
    $rut_alumno			=  $_POST['rutusuario'];
	$id_ano =$_ANO;
	$curso =  $_POST['curso'];
	$string = base64_encode($rut_alumno);
	
	$ret = $_POST['ret'];
	
$obj_fichaAlumno = new FichaAlumno($conn);

$rs_nro_ano = $obj_fichaAlumno->Ano_academico($id_ano);
$nro_ano = pg_result($rs_nro_ano,0); 

$regis_sis_salud = $obj_fichaAlumno->get_sistema_salud();

?>

<style type="text/css">
	div.ui-datepicker{
	font-size:12px;
	}
</style>
<script>



$(document).ready(function() {
	//datos_familiar_mod();
	$("#fecha_nac").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>",
	showOn: 'both',
	onSelect: function(dateText){
		calcular_edad() ;
		}
	//buttonImage: '../../../../../clases/jquery-ui-1.8.14.custom/development-bundle/demos/datepicker/images/calendar.gif',
	});
	$.datepicker.regional['es']	
	
	
	 //obligar a solo numeros
		 $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
          });
		  
		  
		  //obligo a todos los campos a escribir en mayuscula
	$('input[type=text],textarea').keyup(function (){
           // this.value = (this.value + '').replace(/[^0-9]/g, '');
            this.value = (this.value + '').toUpperCase();
          });
	
	
	
	
	function calcular_edad() {
		
	var fecha =  $("#fecha_nac").val();
		
	var array_fecha = fecha.split("-");
    var dateString = array_fecha[2]+"/"+array_fecha[1]+"/"+array_fecha[0];
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
	 $("#txt_edad").val(age);
	
}
	
	
	$("#fecham").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
	//buttonImage: 'img/Calendario.PNG',
	});
	
	$("#fechar").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
	//buttonImage: 'img/Calendario.PNG',
	});
	
	$("#txtCONTROLSANO").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
	//buttonImage: 'img/Calendario.PNG',
	});
	
	
	
	$(function() {
		$( "#tabs" ).tabs(2);
	});
	
	cambia_titulos(1);
	get_region();
	get_provincias($('#txt_region').val(),1);
	get_comunas($('#txt_provincia').val(),$('#txt_region').val())
	get_cursos()
	
	/*************redio sexo******************/
    var sexo = $('#tipo_sexo').val();
    if(sexo==1)
    {
        document.getElementById('sexo0').checked=true;
        document.getElementById('sexo1').checked=false;
    }
    else
    {
       document.getElementById('sexo0').checked=false;
       document.getElementById('sexo1').checked=true;
    }
	
	/******************radio nacionalidad**********************************/
	var tipo_nacionalidad = $('#tipo_nacionalidad').val();
	//alert(tipo_nacionalidad);
    if(tipo_nacionalidad==2)
    {
        document.getElementById('nacionalidad_2').checked=true;
        document.getElementById('nacionalidad_1').checked=false;
    }
    else
    {
       document.getElementById('nacionalidad_2').checked=false;
       document.getElementById('nacionalidad_1').checked=true;
    }
	
	/*****************radio alumna embarazada****************************************/
	var tipo_alum_emb = $('#tipo_alum_emb').val();
	//alert(tipo_nacionalidad);
    if(tipo_alum_emb==0)
    {
        document.getElementById('alum_emb_0').checked=true;
        document.getElementById('alum_emb_1').checked=false;
    }
    else
    {
       document.getElementById('alum_emb_0').checked=false;
       document.getElementById('alum_emb_1').checked=true;
    }
	
	/********************alumno indigena************************************************************/
	var tipo_alum_ind = $('#tipo_alum_ind').val();
	//alert(tipo_nacionalidad);
    if(tipo_alum_emb==0)
    {
        document.getElementById('alum_ind_0').checked=true;
        document.getElementById('alum_ind_1').checked=false;
    }
    else
    {
       document.getElementById('alum_ind_0').checked=false;
       document.getElementById('alum_ind_1').checked=true;
    }
	
	
	var repite_curso = $('#repite_curso').val();
	//alert(tipo_nacionalidad);
    if(repite_curso==1)
    {
        document.getElementById('curso_rep1').checked=true;
        document.getElementById('curso_rep0').checked=false;
    }
    else
    {
       document.getElementById('curso_rep1').checked=false;
       document.getElementById('curso_rep0').checked=true;
    }
	
	
	 var alumno_pie = $('#hidden_pie').val();
	//alert(tipo_nacionalidad);
    if(alumno_pie==1)
    {
        document.getElementById('al_pie1').checked=true;
        document.getElementById('al_pie0').checked=false;
    }
    else
    {
       document.getElementById('al_pie1').checked=false;
       document.getElementById('al_pie0').checked=true;
    }
	
	
	var alumno_ret = $('#alumno_retirado').val();
	
	//alert(tipo_nacionalidad);
    if(alumno_ret==1)
    {
        document.getElementById('alumno_ret1').checked=true;
        document.getElementById('alumno_ret0').checked=false;
    }
    else
    {
       document.getElementById('alumno_ret1').checked=false;
       document.getElementById('alumno_ret0').checked=true;
    }
	
	
	
	
	
	
	
	
	var junaeb = $('#hidden_junaeb').val();
    if(junaeb==1)
    {
        document.getElementById('junaeb1').checked=true;
        document.getElementById('junaeb0').checked=false;
    }
    else
    {
       document.getElementById('junaeb1').checked=false;
       document.getElementById('junaeb0').checked=true;
    }
	
	var chile_sol = $('#hidden_chile_sol').val();
    if(chile_sol==1)
    {
        document.getElementById('chile_sol1').checked=true;
        document.getElementById('chile_sol0').checked=false;
    }
    else
    {
       document.getElementById('chile_sol1').checked=false;
       document.getElementById('chile_sol0').checked=true;
    }
	
	var beca_muni = $('#hidden_beca_muni').val();
    if(beca_muni==1)
    {
        document.getElementById('beca_muni1').checked=true;
        document.getElementById('beca_muni0').checked=false;
    }
    else
    {
       document.getElementById('beca_muni1').checked=false;
       document.getElementById('beca_muni0').checked=true;
    }
	
	var compar_inst = $('#hidden_compar_inst').val();
    if(compar_inst==1)
    {
        document.getElementById('compar_inst1').checked=true;
        document.getElementById('compar_inst0').checked=false;
    }
    else
    {
       document.getElementById('compar_inst1').checked=false;
       document.getElementById('compar_inst0').checked=true;
    }
	
	var cpadre = $('#hidden_cpadre').val();
    if(cpadre==1)
    {
        document.getElementById('cpadre1').checked=true;
        document.getElementById('cpadre0').checked=false;
    }
    else
    {
       document.getElementById('cpadre1').checked=false;
       document.getElementById('cpadre0').checked=true;
    }
	
	var bec_seguro = $('#hidden_bec_seguro').val();
    if(bec_seguro==1)
    {
        document.getElementById('bec_seguro1').checked=true;
        document.getElementById('bec_seguro0').checked=false;
    }
    else
    {
       document.getElementById('bec_seguro1').checked=false;
       document.getElementById('bec_seguro0').checked=true;
    }
	
	var bec_otros = $('#hidden_bec_otros').val();
    if(bec_otros==1)
    {
        document.getElementById('bec_otros1').checked=true;
        document.getElementById('bec_otros0').checked=false;
    }
    else
    {
       document.getElementById('bec_otros1').checked=false;
       document.getElementById('bec_otros0').checked=true;
    }
	
	
	
	
	
	
	
	var psicol = $('#hidden_psicologo').val();
    if(psicol==1)
    {
        document.getElementById('bool_psicologo1').checked=true;
        document.getElementById('bool_psicologo0').checked=false;
    }
    else
    {
       document.getElementById('bool_psicologo1').checked=false;
        document.getElementById('bool_psicologo0').checked=true;
    }
	
	
	
	
	
	var trastorno = $('#hidden_trastornoaprendizaje').val();
    if(trastorno==1)
    {
        document.getElementById('bool_tastornosaprendizaje1').checked=true;
        document.getElementById('bool_tastornosaprendizaje0').checked=false;
    }
    else
    {
       document.getElementById('bool_tastornosaprendizaje1').checked=false;
        document.getElementById('bool_tastornosaprendizaje0').checked=true;
    }
	
	
	
	
	//datos_familiar_mod();
	$('#div_mofificar').hide();
	
	
 });
 
 
 function validar_email(valor)
    {
        // creamos nuestra regla con expresiones regulares.
        var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        // utilizamos test para comprobar si el parametro valor cumple la regla
        if(filter.test(valor))
            return true;
        else
            return false;
    }
 

function verifica_email(mail){
		
	if($("#txt_email").val() == '')
        {
            alert("Ingrese un email");
        }else if(validar_email($("#txt_email").val()))
        {
            alert("Email valido");
        }else
        {
            alert("El email no es valido");
			$("#txt_email").val("");
        }		
			
	}
	
	
	
function get_region()
{
   var cod_region = $('#txt_region').val();		
   var funcion = 1;
		
	var parametros='funcion='+funcion+'&cod_region='+cod_region;	
	//alert (parametros);	
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // alert(data);
	    $("#div_region").html(data);
		$("#select_regiones option[value="+cod_region+"]").attr("selected",true);
	   }
	})	
}	

function get_provincias(cod_reg,x)
{
   
   var funcion = 2;
   var cod_prov = $('#txt_provincia').val()+ ',' +cod_reg;
   //alert(cod_prov);
	var parametros='funcion='+funcion+'&cod_reg='+cod_reg;	
	//alert (parametros);	
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  alert(data);
	    $("#div_provincia").html(data);
		if(x==1){
		$("#select_provincias option[value="+cod_prov+"]").attr("selected",true);
		}
		//else{
	//	$("#select_provincias option[value=0]").attr("selected",true);	
		//}
		//$("#select_comunas option[value=0]").attr("selected",true);
		
	   }
	})	
}	

function get_comunas(cod_prov,cod_reg)
{
	var cod_com = $('#txt_comuna').val();
	//alert (cod_com);
	if(cod_reg == undefined){
		
		var separa = cod_prov.split(',');
		var cod_prov=separa[0];
		var cod_reg=separa[1];
		}
	
   var funcion = 3;
		
	var parametros='funcion='+funcion+'&cod_reg='+cod_reg+'&cod_prov='+cod_prov;	
	//alert (parametros);	
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  alert(data);
	    $("#div_comuna").html(data);
		//$('#select_comunas option[value='+cod_com+']').attr('selected', 'selected');;
		document.getElementById('select_comunas').value = cod_com;
		
	   }
	})	
}	

	function get_cursos(){
		
		
		var id_ano = "<?=$id_ano?>";
		var id_curso=$('#txt_id_curso').val();
		var funcion = 23;
		
		var parametros='funcion='+funcion+'&id_ano='+id_ano;	
	//alert (parametros);	
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// alert(data);
	    $("#combo_curso").html(data);

	$("#select_cursos option[value="+id_curso+"]").attr("selected",true);	

	   }
	})	
 }

function guardar_datos()
{
	if($('#nombre_alu').val()==""){
		
	  alert("Ingrese Nombre");
	  $('#nombre_alu').focus();
	return false;
	}
	
	if($('#ape_pat').val()==""){
	  alert("Ingrese Apellido Paterno");
	  $('#ape_pat').focus();
	return false;
	}		
	
	if($('#ape_mat').val()==""){
	  alert("Ingrese Apellido Materno");
	  $('#ape_mat').focus();
	return false;
	}		
	
	if($('#fecha_nac').val()==""){
	  alert("Ingrese Fecha Nacimiento");
	  $('#fecha_nac').focus();
	return false;
	}	
	
	if($('#fecham').val()==""){
	  alert("Ingrese Fecha Matricula");
	  $('#fecham').focus();
	return false;
	}	
	
	if($('#select_comunas').val()==0){
	  alert("Ingrese Comuna");
	  $('#select_comunas').focus();
	return false;
	}
	
	if(document.getElementById('alumno_ret1').checked==true && $('#fechar').val()=="")
	{
		 alert("Seleccione fecha Retiro");
		   $('#fechar').focus();
		  return false;
		}
	
	if(document.getElementById('alumno_ret1').checked==true && document.getElementById('cmbMOTIVO').value==0 ){
		
		  alert("Seleccione Motivo Retiro");
		   $('#cmbMOTIVO').focus();
		   return false;
	
		}
	
	
	//alert(tipo_nacionalidad);
    if(document.getElementById('alumno_ret1').checked==true &&  document.getElementById('cmbMOTIVO').value==5 && $('#motivo_r').val()==""){
		
		  alert("Describa Motivos Retiro");
		  $('#motivo_r').focus();
		  return false;
	
		}
	

var alumno_ret= $("input[name='alumno_ret']:checked").val();


    var separa_ = $('#select_provincias').val().split(',');
	
	var rut_alumno = <?=$rut_alumno;?>;
	var dig_rut = $('#dig_rut').val();	
	var nombre_alum = $('#nombre_alu').val();
	var ape_pat = $('#ape_pat').val();
	var ape_mat = $('#ape_mat').val();
	var fecha_nac = $('#fecha_nac').val();
	var sexo = $("input[name='sexo']:checked").val();		
	
	
	if(sexo==1){
	var bool_padre=$("input[name='bool_padre']:checked").val();
	var bool_madre=0	
	}
	
	else if(sexo==2){
	var bool_padre=0;
	var bool_madre=$("input[name='bool_madre']:checked").val();
	}
	
	var nacionalidad = $("input[name='nacionalidad']:checked").val();
	var alum_emb = $("input[name='alum_emb']:checked").val();
	var alum_ind = $("input[name='alum_ind']:checked").val();
	var proced_alum = $('#proced_alum').val();
	var con_quien_vive =$('#con_quien_vive').val();
	var txt_calle = $('#txt_calle').val();
	var txt_nro = $('#txt_nro').val();
	var txt_block = $('#txt_block').val();
	var txt_depto = $('#txt_depto').val();
	var txt_villa = $('#txt_villa').val();
	var txt_fono = $('#txt_fono').val();
	var txt_email = $('#txt_email').val();
	var region = $('#select_regiones').val();
	var provincia = separa_[0];
	var comuna = $('#select_comunas').val();
	
	var id_curso = $('#select_cursos').val();
	
	
	
	var curso_rep = $("input[name='curso_rep']:checked").val();
	var especialista = $('#cmbESPEC').val();
	var al_pie = $("input[name='al_pie']:checked").val();
	
	var al_sep = $("input[name='al_sep']:checked").val();
	var al_retos = $("input[name='al_retos']:checked").val();
	var al_puente = $("input[name='al_puente']:checked").val();
	var al_fc = $("input[name='al_fc']:checked").val();
	var cmbSANCION = $('#cmbSANCION').val();
	var txtENFERMEDAD = $('#txtENFERMEDAD').val();
	var txtCIRUGIA = $('#txtCIRUGIA').val();
	var txtMEDICAMENTO = $('#txtMEDICAMENTO').val();
	var txtALERGIA = $('#txtALERGIA').val();
	var txtFISICA = $('#txtFISICA').val();
	var txtFIEBRE = $('#txtFIEBRE').val();
	var txtSEGURO = $('#txtSEGURO').val();
	var aut_emergencia = $("input[name='aut_emergencia']:checked").val();
	var cmbMOTIVO = $('#cmbMOTIVO').val();
	
	
	/*******************FORMATEAR RUT PARA GUARDAR SOLO CON GUION*************************************/
	var rut_retira = "-"
	
	var rut_sinpuntos="-";	
	
	/***********************************************************************************************/
	
	var nombre_retira = $('#nombre_retira').val();
	var parentesco_retira = $('#parentesco_retira').val();
	var telefono_retira = $('#telefono_retira').val();
	var cel_retira = $('#cel_retira').val();
	var viaja_furgon = $("input[name='viaja_furgon']:checked").val();
	var nombre_tio = $('#nombre_tio').val();
	var fono_furgon = $('#fono_furgon').val();
	
	
	var fecham = $('#fecham').val();
	var alumno_ret = $("input[name='alumno_ret']:checked").val();
	var fechar = $('#fechar').val();
	var motivo_r = $('#motivo_r').val();
	var cmb_condicional = $('#cmb_condicional').val();
	var opta_religion = $("input[name='opta_religion']:checked").val();
	var ed_diferencial = $("input[name='ed_diferencial']:checked").val();
	var al_integrado = $("input[name='al_integrado']:checked").val();
	var nro_ano = "<?=$nro_ano;?>";
	var id_ano = "<?=$id_ano?>";
	var ret = "<?=$ret?>";
	
	var datos_interes= $('#datos_interes').val();
	var observacion= $('#observacion').val();
	var observacion_salud= $('#observacion_salud').val();
	
	
	
	
	var religion = $('#religion').val();
	
	var telefono_recado= $('#telefono_recado').val();
	
	var tipo_parto = $('#cmbTIPOPARTO').val();
	
	var edad_madre_nace = $('#edad_madre_nace').val();
	
	var peso_nace = $('#peso_nace').val();
	
	var talla_nace = $('#talla_nace').val();
	
	var s_salud = $('#cmbSALUDP2').val();
	
	var controlsano = $('#txtCONTROLSANO').val();
	
	var jefe_hogar = $('#jefe_hogar').val(); 
	
	var ocup_jefehogar = $('#ocup_jefehogar').val();
	
	var num_grupofamiliar = $('#num_grupofamiliar').val(); 
	
	var ingresos = $('#ingresos').val(); 
	
	var tipo_vivienda = $('#cmbTIPOVIVIENDA').val(); 
	
	var cant_dormitorios = $('#cant_dormitorios').val(); 
	
	var cant_banos = $('#cant_banos').val(); 
	
	var carinoso = $('#cmbCARINOSO').val();
	
	var sociable = $('#cmbSOCIABLE').val();
	
	var curioso = $('#cmbCURIOSO').val();
	
	var org_participa = $('#org_participa').val();
	
	var con_quien_estudia = $('#con_quien_estudia').val();
	
	var obse_general = $('#obse_general').val();
	
	var figura_paterna = $('#figura_paterna').val();
	
	var figura_paterna = $('#figura_paterna').val();
	
	var probdentales = $("input[name='probdentales']:checked").val();
var controldental = $("input[name='CONTROLDENTAL']:checked").val();
var famenfermo = $("input[name='FAMILIARENFERMO']:checked").val();
var espacio_juego = $("input[name='espacio_juego']:checked").val();
var espacio_estudio = $("input[name='espacio_estudio']:checked").val();
var hizo_jardin = $("input[name='hizo_jardin']:checked").val();
var jefe_aporta = $("input[name='jefe_aporta']:checked").val();


var bool_neurologo = $("input[name='bool_neurologo']:checked").val();
var bool_psicopedagogo = $("input[name='bool_psicopedagogo']:checked").val();
var bool_psicologo = $("input[name='bool_psicologo']:checked").val();
var bool_tieneluz = $("input[name='bool_tieneluz']:checked").val();
var bool_tieneagua = $("input[name='bool_tieneagua']:checked").val();	
var bool_tienealcantarillado = $("input[name='bool_tienealcantarillado']:checked").val();	

var bool_retirosolo = $("input[name='bool_retirosolo']:checked").val();	

var bool_otratamiento = $("input[name='bool_otratamiento']:checked").val();	
var bool_tratactual = $("input[name='bool_tratactual']:checked").val();	
var bool_tastornosaprendizaje = $("input[name='bool_tastornosaprendizaje']:checked").val();

var material_vivienda = $('#material_vivienda').val();	
var estado_vivienda = $('#estado_vivienda').val();

var txt_otratamiendo = $('#txt_otratamiendo').val();

var txt_tratactual = $('#txt_tratactual').val();
var txt_trastornosaprendizaje = $('#txt_trastornosaprendizaje').val();

var cant_hermanos = $('#cant_hermanos').val();

var num_hermano = $('#num_hermano').val();

var txt_etnia =$('#txt_ETNIA').val();

var txt_etnia =$('#txt_ETNIA').val();

var cant_hijos =$('#txt_CANTHIJOS').val();

var txt_edad=$('#txt_edad').val();

var bool_trabajo=$("input[name='bool_trabaja']:checked").val();

var lugar_trabajo=$('#txt_lugartrabajo').val();

var txt_anosrepetidos=$('#txtANOREPETIDO').val();

var txt_anosretiro=$('#txtANORETIRADO').val();

var txt_causaretiroant=$('#txtCAUSARETIROANT').val();

		
var bool_examenvalidacion=$("input[name='bool_examenvalidacion']:checked").val();


var txt_enfcronica=$('#txt_enfcronica').val();

var bool_discapacidad=$("input[name='bool_discapacidad']:checked").val();

var txt_discapacidad=$('#txt_discapacidad').val();

bool_carnetdiscapacidad=$("input[name='bool_carnetdiscapacidad']:checked").val();

var txt_centroatencion=$('#txt_centroatencion').val();


var txt_contactoemergencia=$('#txt_contactoemergencia').val();
var txt_fonocontactoemergencia=$('#txt_fonocontactoemergencia').val();
var txt_tutor=$('#txt_tutor').val();
var txt_fonotutor=$('#txt_fonotutor').val();

var tramo_salud=$('#tramo_salud').val();

var bool_ccc=$("input[name='bool_ccc']:checked").val();

var txt_fichaps=$('#txt_fichaps').val();

var bool_vif=$("input[name='bool_vif']:checked").val();

var bool_saludmental=$("input[name='bool_saludmental']:checked").val();

var bool_drogas=$("input[name='bool_drogas']:checked").val();

var bool_sename=$("input[name='bool_sename']:checked").val();

var bool_sernam=$("input[name='bool_sernam']:checked").val();



	var funcion = 4;
	
	
	var parametros='funcion='+funcion+'&rut_alumno='+rut_alumno+'&dig_rut='+dig_rut+'&nombre_alum='+nombre_alum+'&ape_pat='+ape_pat+'&ape_mat='+ape_mat+'&fecha_nac='+fecha_nac+'&sexo='+sexo+'&nacionalidad='+nacionalidad+'&alum_emb='+alum_emb+'&alum_ind='+alum_ind+'&proced_alum='+proced_alum+'&con_quien_vive='+con_quien_vive+'&txt_calle='+txt_calle+'&txt_nro='+txt_nro+'&txt_block='+txt_block+'&txt_depto='+txt_depto+'&txt_villa='+txt_villa+'&txt_fono='+txt_fono+'&txt_email='+txt_email+'&region='+region+'&provincia='+provincia+'&comuna='+comuna+'&curso_rep='+curso_rep+'&especialista='+especialista+'&al_pie='+al_pie+'&al_sep='+al_sep+'&al_retos='+al_retos+'&al_puente='+al_puente+'&al_fc='+al_fc+'&cmbSANCION='+cmbSANCION+'&txtENFERMEDAD='+txtENFERMEDAD+'&txtCIRUGIA='+txtCIRUGIA+'&txtMEDICAMENTO='+txtMEDICAMENTO+'&txtALERGIA='+txtALERGIA+'&txtFISICA='+txtFISICA+'&txtFIEBRE='+txtFIEBRE+'&txtSEGURO='+txtSEGURO+'&aut_emergencia='+aut_emergencia+'&rut_sinpuntos='+rut_sinpuntos+'&nombre_retira='+nombre_retira+'&parentesco_retira='+parentesco_retira+'&telefono_retira='+telefono_retira+'&cel_retira='+cel_retira+'&viaja_furgon='+viaja_furgon+'&nombre_tio='+nombre_tio+'&fono_furgon='+fono_furgon+'&fecham='+fecham+'&alumno_ret='+alumno_ret+'&fechar='+fechar+'&motivo_r='+motivo_r+'&cmb_condicional='+cmb_condicional+'&opta_religion='+opta_religion+'&ed_diferencial='+ed_diferencial+'&al_integrado='+al_integrado+'&id_curso='+id_curso+'&nro_ano='+nro_ano+'&id_ano='+id_ano+'&datos_interes='+datos_interes+'&observacion='+observacion+'&observacion_salud='+observacion_salud+'&ret='+ret+'&cmbMOTIVO='+cmbMOTIVO+"&religion="+religion+"&telefono_recado="+telefono_recado+"&tipo_parto="+tipo_parto+"&edad_madre_nace="+edad_madre_nace+"&peso_nace="+peso_nace+"&talla_nace="+talla_nace+"&s_salud="+s_salud+"&probdentales="+probdentales+"&controldental="+controldental+"&controlsano="+controlsano+"&famenfermo="+famenfermo+"&jefe_hogar="+jefe_hogar+"&ocup_jefehogar="+ocup_jefehogar+"&num_grupofamiliar="+num_grupofamiliar+"&ingresos="+ingresos+"&tipo_vivienda="+tipo_vivienda+"&cant_dormitorios="+cant_dormitorios+"&cant_banos="+cant_banos+"&espacio_juego="+espacio_juego+"&espacio_estudio="+espacio_estudio+"&hizo_jardin="+hizo_jardin+"&carinoso="+carinoso+"&sociable="+sociable+"&curioso="+curioso+"&org_participa="+org_participa+"&con_quien_estudia="+con_quien_estudia+"&obse_general="+obse_general+"&figura_paterna="+figura_paterna+"&jefe_aporta="+jefe_aporta+"&bool_neurologo="+bool_neurologo+"&bool_psicopedagogo="+bool_psicopedagogo+"&bool_psicologo="+bool_psicologo+"&bool_tieneluz="+bool_tieneluz+"&bool_tieneagua="+bool_tieneagua+"&bool_tienealcantarillado="+bool_tienealcantarillado+"&bool_retirosolo="+bool_retirosolo+"&bool_otratamiento="+bool_otratamiento+"&bool_tratactual="+bool_tratactual+"&bool_tastornosaprendizaje="+bool_tastornosaprendizaje+"&material_vivienda="+material_vivienda+"&estado_vivienda="+estado_vivienda+"&txt_otratamiendo="+txt_otratamiendo+"&txt_tratactual="+txt_tratactual+"&txt_trastornosaprendizaje="+txt_trastornosaprendizaje+"&cant_hermanos="+cant_hermanos+"&num_hermano="+num_hermano+"&bool_padre="+bool_padre+"&bool_madre="+bool_madre+"&txt_etnia="+txt_etnia+"&cant_hijos="+cant_hijos+"&txt_edad="+txt_edad+"&bool_trabajo="+bool_trabajo+"&lugar_trabajo="+lugar_trabajo+"&txt_anosrepetidos="+txt_anosrepetidos+"&txt_anosretiro="+txt_anosretiro+"&txt_causaretiroant="+txt_causaretiroant+"&bool_examenvalidacion="+bool_examenvalidacion+"&txt_enfcronica="+txt_enfcronica+"&bool_discapacidad="+bool_discapacidad+"&txt_discapacidad="+txt_discapacidad+"&bool_carnetdiscapacidad="+bool_carnetdiscapacidad+"&txt_centroatencion="+txt_centroatencion+"&txt_contactoemergencia="+txt_contactoemergencia+"&txt_tutor="+txt_tutor
+"&txt_fonotutor="+txt_fonotutor+"&tramo_salud="+tramo_salud+"&bool_ccc="+bool_ccc+"&txt_fichaps="+txt_fichaps+"&bool_vif="+bool_vif
+"&bool_saludmental="+bool_saludmental
+"&bool_drogas="+bool_drogas
+"&bool_sename="+bool_sename
+"&bool_sernam="+bool_sernam	



	;
	

	
	//alert(parametros);
	//return false;
	if(confirm("Seguro desea guardar")){
	$.ajax({
			url:'cont_ficha_alumno.php',
			data:parametros,
			type:'POST',
			
			success:function(data){
			//alert(data);
			//document.writeln(data);
			console.log(data);
			if(data==1){
			alert("Datos Modificados");
			//volver_home();
			//cargaTabs();
			//window.location='../listarAlumnos.php3?menu=6&categoria=3&item=2&nw=1';
			window.location='ficha_alumno.php?alumno='+rut_alumno+'&r='+alumno_ret;
			}else{
			alert("Error al Modificar");	
			}
	    }
	});
  }
}




function guardar_datos_documentos(){
var funcion=25;

var bool_traecertificados=$("input[name='bool_traecertificados']:checked").val();

var bool_traecertificadosant=$("input[name='bool_traecertificadosant']:checked").val();

var nivel_certificado=$('#nivel_certificado').val();

var bool_secreduc=$("input[name='bool_secreduc']:checked").val();

var plazo_autorizacion=$('#plazo_autorizacion').val();
var bool_manualconvivencia=$("input[name='bool_manualconvivencia']:checked").val();

var txtaporteCGP=$('#txtaporteCGP').val();

var bool_pagomatricula=$("input[name='bool_pagomatricula']:checked").val();

var abono_matricula=$('#abono_matricula').val();
var numboleta=$('#txtNUMBOLETA').val();

var bool_exentomatricula=$("input[name='bool_exentomatricula']:checked").val();

var rut_alumno = <?=$rut_alumno;?>;

var id_ano=<?=$id_ano;?>

var parametros='funcion='+funcion+"&bool_traecertificados="+bool_traecertificados+"&bool_traecertificadosant="+bool_traecertificadosant+"&nivel_certificado="+nivel_certificado+"&bool_secreduc="+bool_secreduc+"&plazo_autorizacion="+plazo_autorizacion+"&txtaporteCGP="+txtaporteCGP+"&bool_pagomatricula="+bool_pagomatricula+"&abono_matricula="+abono_matricula+"&numboleta="+numboleta+"&bool_exentomatricula="+bool_exentomatricula+"&rut_alumno="+rut_alumno+"&id_ano="+id_ano+"&bool_manualconvivencia="+bool_manualconvivencia;


 if(confirm("Acepte para Modificar")){
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	 console.log(data);
	  if(data==1){
		 alert("Datos Modificados"); 
		 cargaTabs();
		  }else{
		 alert("Error al Modificar");
	   }		    
	  }
	})
   }
}




  function limpia(campo){
	
	//alert(campo);
    var nombre_txt = "txt"+campo;
	var nombre_txt2 = "txt_"+campo;

	if($("input[name="+campo+"]:checked").val()==0){
		$('#'+nombre_txt+'').val("ninguna");
		$('#'+nombre_txt2+'').val("ninguna");
	}
	
	if($("input[name="+campo+"]:checked").val()==1){
		$('#'+nombre_txt+'').val("");
		$('#'+nombre_txt+'').removeAttr("disabled");
		$('#'+nombre_txt+'').focus();
	}
	
	
}



function limpia_rut()
{
	$('#rut_retira').val("");
}

function formatea_rut(rut)
{
	
  var formato_r = formato_rut(rut)	
  
  var rut_con_formato = $('#rut_retira').val();
 
     var nuevo_rut = rut_con_formato.split('.');
     var rut_sinpuntos = nuevo_rut[0]+nuevo_rut[1]+nuevo_rut[2];
     var rut_singuion = rut_sinpuntos.split('-');
     var rut = rut_singuion[0]
	 var dig_rut=rut_singuion[1];
	// alert(rut);
	// alert(dig_rut);
	var validar_rut = Valida_Rut(rut,dig_rut);
	//alert(validar_rut)
	
	if(validar_rut==1){
		alert("rut correcto");
		}else{
		alert("Rut Incorrecto");
		$('#rut_retira').val("")
		return false;
			
		}
 }
 
 function guardar_datos_becas()
 {
	var rut_alumno = "<?=$rut_alumno;?>"; 
	var junaeb = $("input[name='junaeb']:checked").val();	 
	var chile_sol = $("input[name='chile_sol']:checked").val();
	var beca_muni = $("input[name='beca_muni']:checked").val();
	var compar_inst = $("input[name='compar_inst']:checked").val();
	var cpadre = $("input[name='cpadre']:checked").val();
	var bec_seguro = $("input[name='bec_seguro']:checked").val();
    var bec_otros = $("input[name='bec_otros']:checked").val();
	
	var ben_pie = $("input[name='ben_pie']:checked").val();
	var ben_sep = $("input[name='ben_sep']:checked").val();
	var ben_puente = $("input[name='ben_puente']:checked").val();
	var cant_becas = $("input[name='cant_becas_ins']").val();
	
	var arr_becas_alu="";
	var anioe = <?php echo $id_ano ?>
	
	for(x=0;x<cant_becas;x++){
		var beca_ins = $("input[name='beca_ins"+x+"']").val();
		
		if($("#beca_ins"+x+"_1").is(':checked')){
			var beca_ins_alum=1;
		}else if($("#beca_ins"+x+"_0").is(':checked')){
			var beca_ins_alum=0;
		} 
		
		var valactbeca = $("input[name='hidden_beca_ins"+x+"']").val();
		
		arr_becas_alu+="/"+beca_ins+"_"+beca_ins_alum+"_"+valactbeca;
	}
	arr_becas_alu = cant_becas+"-"+anioe+"-"+arr_becas_alu;
	
	//alert(arr_becas_alu);
	var funcion=16;
	
	var parametros='funcion='+funcion+'&rut_alumno='+rut_alumno+'&junaeb='+junaeb+'&chile_sol='+chile_sol+'&beca_muni='+beca_muni+'&compar_inst='+compar_inst+'&cpadre='+cpadre+'&bec_seguro='+bec_seguro+'&bec_otros='+bec_otros+'&ben_pie='+ben_pie+'&ben_sep='+ben_sep+'&ben_puente='+ben_puente+"&arr_becas_alu="+arr_becas_alu;
	
	  if(confirm("Acepte para Modificar")){
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	// console.log(data);
	  if(data==1){
		 alert("Datos Modificados"); 
		 cargaTabs();
		  }else{
		 alert("Error al Modificar");
	   }		    
	  }
	})
   }
	
 }

function borra_fecha()
{
	$('#fechar').val("");	
	$('#motivo_r').val("");
	$('#cmbMOTIVO').find('option:first').attr('selected', 'selected').parent('select');
	$('#motivo_r').attr('readonly','readonly');
		
}

function activa_fecha()
{
	
	$('#motivo_r').removeAttr('readonly');
		
}

</script>




<form name="Formulariolista" id="Formulariolista" >
<div id="titulo" class="tableindex">titulo</div>

<div id="tabs">

	<ul>
		<li value="1" ><a href="#personal" onclick="cambia_titulos(1)" >Personal</a></li>
		<!--<li value="3"><a href="#academico" onclick="cambia_titulos(3)" >Academico</a></li>-->
        <li value="5"><a href="#becas" onclick="cambia_titulos(5)" >Becas</a></li>
        <li value="8"><a href="#documentos" onclick="cambia_titulos(8)" >Documentos</a></li>
        <!--<li value="6"><a href="#Grupos" onclick="cambia_titulos(6)" >Grupos</a></li>-->
<!--        <li value="7"><a href="#Entrevistas" onclick="cambia_titulos(7)" >Entrevistas</a></li>
-->      </ul>
      

    <div id="personal" style="width:100%; margin-left:-23px">
  
	<table width="100%">
    <tr class="cuadro01">
  
    <td width="1069" align="right" ><input type="button" class="botonXX" title="Cancelar" value="Cancelar" onclick="volver_home()" ></td>
    <td width="68"><input type="button" class="botonXX" title="Guarda Datos" value="Guardar" onclick="guardar_datos()" ></td>
      <td width="70">&nbsp;</td>
    </tr>
    
    </table> 
    <br>
    <table width="100%">
    <tr>
    <td class="cuadro01">Curso: <?=CursoPalabra($curso,0,$conn);?></td>
    </tr>
    </table>

    <?php
    $regis = $obj_fichaAlumno->datos_alumno($rut_alumno);
	$regis_matricula=$obj_fichaAlumno->datosMatricula($rut_alumno,$id_ano,$curso,$ret);	
	
		for($i=0;$i<pg_num_rows($regis);$i++){
			$fila=pg_fetch_array($regis);
			$dig_rut = $fila['dig_rut'];
			
			
			echo "<pre>";
				//print_r($fila);
				echo "</pre>";
			
			$cod_reg = $fila['region'];
			$cod_prov = $fila['ciudad'];
			$cod_com = $fila['comuna'];
				
			$relacion=$fila['relacion'];	
			
				$fila_matricula=pg_fetch_array($regis_matricula,$i);
				echo "<pre>";
				//print_r($fila_matricula);
				echo "</pre>";
				
	$regis_region = $obj_fichaAlumno->get_region($cod_reg);
	$region = pg_result($regis_region,1);
	
	
	$regis_prov = $obj_fichaAlumno->get_provincia($cod_reg,$cod_prov);
	$provincia = pg_result($regis_prov,2);		
	
	$regis_com = $obj_fichaAlumno->get_comuna($cod_com,$cod_prov,$cod_reg);
	$comuna = pg_result($regis_com,3);
	
	
	if($fila['edad_madre_nace']==0){
	$fila['edad_madre_nace']="";
}else{
	$fila['edad_madre_nace']=$fila['edad_madre_nace'];
	}	
	
	if($fila['peso_nace']==0){
	$fila['peso_nace']="";
}else{
	$fila['peso_nace']=$fila['peso_nace'];
	}		
	
	if($fila['talla_nace']=="" || $fila['talla_nace']==0 ){
	$fila['talla_nace']="";
}else{
	$fila['talla_nace']=$fila['talla_nace'];
	}	
	
	
	if ($fila_matricula['controlsano']!='1111-11-11' && $fila_matricula['controlsano']!='0000-00-00' && $fila_matricula['controlsano']!=null){
			$fila_matricula['controlsano']=CambioFechaDisplay($fila_matricula['controlsano']);
		}else{
			$fila_matricula['controlsano']="";
			}
	
	?>		

    <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    <tr>
    <TD colspan=8 class="cuadro02">RUT</TD>
    </tr>
    <tr>
    <td colspan="7" class="cuadro01"><?=$fila['rut_alumno'].'-'.$dig_rut?>
    <input type="hidden" name="dig_rut" id="dig_rut" value="<?=$dig_rut?>" />
    <input type="button" class="botonXX" title="Modificar" value="Modificar" onClick="MM_openBrWindow('modifica_rut.php?ract=<?=$string;?>&amp;dact=<?=$fila['dig_rut'] ?>','','toolbar=no,location=no,resizable=yes,width=500,height=300')">
    </td>
    </tr>
    
    <tr>
    <td class="cuadro02">Nombre</td>
    <td class="cuadro02">Apellido Paterno</td>
    <td class="cuadro02">Apellido Materno</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="nombre_alu" id="nombre_alu" value="<? echo trim($fila['nombre_alu'])?>"/></td>
    <td class="cuadro01"><input type="text" name="ape_pat" id="ape_pat" value="<? echo trim($fila['ape_pat'])?>" /></td>
    <td class="cuadro01"><input type="text" name="ape_mat" id="ape_mat" value="<? echo trim($fila['ape_mat'])?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Fecha Nacimiento</td>
    <td class="cuadro02">Sexo</td>
    <td class="cuadro02">Nacionalidad</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="fecha_nac" id="fecha_nac" value="<?=CambioFechaDisplay($fila['fecha_nac'])?>" onChange="calcular_edad()" /></td>
    <td class="cuadro01">
    <input type="hidden" id="tipo_sexo" name="tipo_sexo" value="<?=$fila['sexo']?>" />
                         F:<input type="radio" name="sexo" id="sexo0" value="1"/>
    					 M:<input type="radio" name="sexo" id="sexo1" value="2"/></td>
                         
    <td class="cuadro01">
    					 Chilena :<input type="radio" name="nacionalidad" id="nacionalidad_2" value="2" />
                         Extranjera :
                         <input type="radio" name="nacionalidad" id="nacionalidad_1" value="1" />
                         
    
    <input type="hidden" name="tipo_nacionalidad" id="tipo_nacionalidad" value="<?=$fila['nacionalidad']?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Alumna Embarazada </td>
    <td class="cuadro02">Alunm@ Indigena</td>
    <td class="cuadro02">Etnia</td>
    </tr>
    
    <tr>
    <td class="cuadro01">No:<input type="radio" name="alum_emb" id="alum_emb_0" value="0" />
    					 Si:<input type="radio" name="alum_emb" id="alum_emb_1" value="1" />	
	<input type="hidden" id="tipo_alum_emb" value="<?=$fila_matricula['bool_ae']?>" />
    
        
	 <input name="txtmesembarazo" type="text" id="txtmesembarazo" size="3" /> 
	 (meses)</td>
    
    <td class="cuadro01">No:<input type="radio" name="alum_ind" id="alum_ind_0" value="0" />
    					 Si:<input type="radio" name="alum_ind" id="alum_ind_1" value="1" />	
	<input type="hidden" id="tip_alum" value="<?=$fila_matricula['bool_aoi']?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_ETNIA" id="txt_ETNIA"  value="<?=$fila['txt_etnia']?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Procedencia del Alumno</td>
    <td class="cuadro02">Con quien vive</td>
    <td class="cuadro02">Estado Civil</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="proced_alum" id="proced_alum" value="<?=$fila['c_procedencia']?>" /></td>
    <td class="cuadro01"><input type="text" name="con_quien_vive" id="con_quien_vive" value="<?=$fila['cq_vive']?>" /></td>
    <td class="cuadro01"><select name="cmb_estadocivil" id="cmb_estadocivil">
      <option value="0">seleccione...</option>
      <option value="1" <?php echo ($fila['estado_civil']==1)?"selected":""?> >SOLTERO(A)</option>
      <option value="2" <?php echo ($fila['estado_civil']==2)?"selected":""?>>CASADO(A)</option>
      <option value="3" <?php echo ($fila['estado_civil']==3)?"selected":""?>>VIUDO(A)</option>
      <option value="4" <?php echo ($fila['estado_civil']==4)?"selected":""?>>DIVORCIADO(A)</option>
      <option value="5" <?php echo ($fila['estado_civil']==5)?"selected":""?>>OTRO</option>
    </select></td>
    </tr>
     <tr>
    	   <td class="cuadro02">Es Padre / Madre</td>
    	   <td class="cuadro02">Hijos</td>
    	   <td class="cuadro02">Trabaja</td>
  	   </tr>
    <tr>
      <td class="cuadro01">
      <?php if ($fila['sexo']==1){?>
      <input type="hidden" name="espadre" id="espadre" value="<?php echo $fila['bool_padre'] ?>"/>
      <input name="bool_padre" type="radio" id="bool_padre0" value="0" <?php echo ($fila['bool_padre']==0)?"checked":""; ?> >
      NO
      
        <input type="radio" name="bool_padre" id="bool_padre1" value="1" <?php echo ($fila['bool_padre']==1)?"checked":""; ?>>
        SI 
      <?php }if ($fila['sexo']==2){?>
     
      <input type="hidden" name="esmadre" id="esmadre"  value="<?php echo $fila['bool_madre'] ?>"/>
      <input name="bool_madre" type="radio" id="bool_madre0" value="0" <?php echo ($fila['bool_madre']==0)?"checked":""; ?> >
      NO
      
        <input type="radio" name="bool_madre" id="bool_madre1" value="1" <?php echo ($fila['bool_madre']==1)?"checked":""; ?>>
        SI 
       <?php }?>
      &nbsp;</td>
      <td class="cuadro01"><input name="txt_CANTHIJOS" type="text" id="txt_CANTHIJOS" maxlength="10" class="solo-numero" value="<?=$fila['cant_hijos']?>" /></td>
      <td class="cuadro01">No:
        <input type="radio" name="bool_trabaja" id="bool_trabaja0" value="0" <?php echo ($fila_matricula['bool_trabajo']==0)?"checked":"" ?>/>
Si:
<input type="radio" name="bool_trabaja" id="bool_trabaja1" value="1" <?php echo ($fila_matricula['bool_trabajo']==1)?"checked":"" ?> />
</td>
    </tr>
     <tr>
    	   <td class="cuadro02">Lugar de trabajo</td>
    	   <td class="cuadro02">Edad</td>
    	   <td class="cuadro02">Religion</td>
  	   </tr>
    <tr>
      <td class="cuadro01"><input type="text" name="txt_lugartrabajo" id="txt_lugartrabajo" onchange="conMayusculas(this)"  value="<?php echo $fila_matricula['lugar_trabajo'] ?>" /></td>
      <td class="cuadro01"><input name="txt_edad" type="text" id="txt_edad" size="2" readonly="readonly" value="<?=$fila['edad']?>"/></td>
      <td class="cuadro01"><input type="text" name="religion" id="religion" value="<? echo trim($fila['religion'])?>" /></td>
    </tr>
     <tr>
    	   <td class="cuadro02">Datos de Interes</td>
    	   <td class="cuadro02">&nbsp;</td>
    	   <td class="cuadro02">&nbsp;</td>
  	   </tr>
    <tr>
      <td class="cuadro01"><textarea name="datos_interes" id="datos_interes"  style="width:350px;border:1; border-collapse:collapse;"><? echo $fila_matricula['datos_interes'];?></textarea></td>
      <td class="cuadro01">&nbsp;</td>
      <td class="cuadro01">&nbsp;</td>
    </tr>
    </table>
    <br />
    <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
      <TR>
    <TD colspan="7"><div id="titulo" class="tableindex">DIRECCION</div>
    </TD></TR>

    <tr>
    <td class="cuadro02">Calle</td>
    <td class="cuadro02">Numero</td>
    <td class="cuadro02">Block</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_calle" id="txt_calle" size="50" value="<?=trim($fila['calle'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_nro" id="txt_nro" value="<?=trim($fila['nro'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_block" id="txt_block" value="<?=trim($fila['block'])?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Depto</td>
    <td class="cuadro02">Villa/Poblacion</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_depto" id="txt_depto" value="<?=trim($fila['depto'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_villa" id="txt_villa" value="<?=trim($fila['villa'])?>" /></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
    
    <tr>
    <td class="cuadro02">Telefono</td>
    <td class="cuadro02">Telefono recados</td>
    <td class="cuadro02">Email</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_fono" id="txt_fono" value="<?=trim($fila['telefono'])?>" /></td>
    <td class="cuadro01"><input type="text" name="telefono_recado" id="telefono_recado" value="<?=trim($fila['telefono_recado'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_email"  id="txt_email" value="<?=trim($fila['email'])?>" /></td>
    </tr>
    
      <tr>
    <td class="cuadro02">Region</td>
    <td class="cuadro02">Provincia</td>
    <td class="cuadro02">Comuna</td>
    </tr>
    
    <tr>
    <td class="cuadro01">
    <input type="hidden" id="txt_region" value="<?=$cod_reg;?>"/>
    <div id="div_region"></div></td>
    <td class="cuadro01">
    <input type="hidden" id="txt_provincia" value="<?=$cod_prov;?>"/>
    <div id="div_provincia"></div></td>
    <td class="cuadro01">
    <input type="hidden" id="txt_comuna" name="txt_comuna" value="<?=$cod_com;?>" />
    <div id="div_comuna"></div></td>
    </tr>
  </table>
  
    <br />
     <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    <TR>
    <TD colspan="7"><div id="titulo" class="tableindex">ANTECEDENTES ACADEMICOS</div>
    </TD>
    </TR>
    
    <tr>
    <td class="cuadro02">Fecha Matricula</td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">Curso</td>
    </tr>
    <tr>
    <td class="cuadro01"><input type="text" id="fecham" name="fecham" value="<? echo CambioFD($fila_matricula['fecha']);?>" /></td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">
    <input type="hidden" id="txt_id_curso" value="<?=$curso;?>"/>
    <div id="combo_curso"></div>
    
    </td>
    </tr>
    
      <tr>
    <td class="cuadro02">Retirado</td>
    <td class="cuadro02">Fecha Retiro</td>
    <td class="cuadro02">Motivo</td>
    </tr>
    <tr>
    <td class="cuadro01">Si<input type="radio" name="alumno_ret" id="alumno_ret1" value="1" onclick="activa_fecha()" >
						 No<input type="radio" name="alumno_ret" id="alumno_ret0" value="0" onclick="borra_fecha()" >	
            <input type="hidden" id="alumno_retirado" value="<? echo $fila_matricula['bool_ar'];?>" />
    </td>
    <td class="cuadro01"><input type="text" name="fechar" id="fechar" value="<? echo CambioFechaDisplay($fila_matricula['fecha_retiro']);?>" /></td>
    <td class="cuadro01">
    <select name="cmbMOTIVO" id="cmbMOTIVO">
    <option value="0" >Seleccione</option>
    <option value="1" <?php echo ($fila_matricula['tipo_retiro']==1)?"selected":"" ?>>Cambio de Domicilio</option>
    <option value="2" <?php echo ($fila_matricula['tipo_retiro']==2)?"selected":"" ?>>Traslado de establecimiento</option>
    <option value="3" <?php echo ($fila_matricula['tipo_retiro']==3)?"selected":"" ?>>Deserci&oacute;n</option>
    <option value="4" <?php echo ($fila_matricula['tipo_retiro']==4)?"selected":"" ?>>Motivos de salud</option>
    <option value="5" <?php echo ($fila_matricula['tipo_retiro']==5)?"selected":"" ?>>Otros</option>
    
    </select>
    </td>
    </tr>
    <tr>
      <td colspan="2" class="cuadro02">Detalle motivo retiro</td>
      <td class="cuadro02">Ha repetido curso</td>
    </tr>
    <tr>
      <td colspan="2" class="cuadro01"><textarea name="motivo_r" id="motivo_r"  style="width:350px;border:1; border-collapse:collapse;"><? echo $fila_matricula['motivo_retiro'];?></textarea></td>
      <td class="cuadro01">Si
        <input type="radio" name="curso_rep" id="curso_rep1" value="1" />
No
<input type="radio" name="curso_rep" id="curso_rep0" value="0" />
<input type="hidden" id="repite_curso" value="<? echo $fila_matricula['curso_rep'];?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">A&ntilde;os repetidos</td>
    <td class="cuadro02">A&ntilde;os retirado</td>
    <td class="cuadro02">Estudio a&ntilde;o anterior</td>
    </tr>
    <tr>
    <td class="cuadro01"><input name="txtANOREPETIDO" type="text" id="txtANOREPETIDO" value="<? echo $fila_matricula['txt_anosrepetidos'];?>" /></td>
    <td class="cuadro01"><input name="txtANORETIRADO" type="text" id="txtANORETIRADO" value="<? echo $fila_matricula['txt_anosretiro'];?>" /></td>
    <td class="cuadro01">
      <input name="bool_estudioanoant" type="radio" id="bool_estudioanoant0" value="0"<?php echo ($fila_matricula['bool_estudio_anoant']==0)?"checked":""; ?> />
NO
<input type="radio" name="bool_estudioanoant" id="bool_estudioanoant" value="1"  <?php echo ($fila_matricula['bool_estudio_anoant']==1)?"checked":""; ?>/>
SI</td>
    </tr>
    
      <tr>
    <td class="cuadro02">Causa  retiro a&ntilde;os anteriores</td>
    <td class="cuadro02">Pertenece al programa de integracion escolar (PIE) </td>
    <td class="cuadro02">Requiere examen validaci&oacute;n de estudios</td>
    </tr>
    <tr>
    <td class="cuadro01"><input name="txtCAUSARETIROANT" type="text" id="txtCAUSARETIROANT" /></td>
    <td class="cuadro01">Si
        <input type="radio" name="al_pie" id="al_pie1" value="1"/>
No
<input type="radio" name="al_pie" id="al_pie0" value="0"/>
<input type="hidden" id="hidden_pie" value="<? echo $fila_matricula['ben_pie'];?>" />
    </td>
    
    <td class="cuadro01"><input name="bool_examenvalidacion" type="radio" id="bool_examenvalidacion0" value="0" <?php echo ($fila_matricula['bool_examenvalidacion']==0)?"checked":""; ?> />
      NO
        <input type="radio" name="bool_examenvalidacion" id="bool_examenvalidacion1" value="1"<?php echo ($fila_matricula['bool_examenvalidacion']==1)?"checked":""; ?> />
        SI</td>
    </tr>
    
    <tr>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
     <tr>
       <td class="cuadro02" colspan="2">Observaciones</td>
       <td class="cuadro02">&nbsp;</td>
     </tr>
     <tr>
    <td class="cuadro01" colspan="2"><textarea name="observacion" id="observacion"  style="width:350px;border:1; border-collapse:collapse;"><? echo $fila_matricula['observacion'];?></textarea></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
    
    
    
  </table>  
  <br />
    <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    <TR>
    <TD colspan="7"><div id="titulo" class="tableindex">ANTECEDENTES DE SALUD</div>
    </TD>
    </TR>
    <tr>
      <td class="cuadro02">Sistema de salud</td>
      <td class="cuadro02">Ha estado en tratamiento psicol&oacute;gico</td>
      <td class="cuadro02">Posee problemas de apendizaje</td>
    </tr>
    <tr>
      <td class="cuadro01"><select name="cmbSALUDP2" id="cmbSALUDP2" style="text-transform:uppercase">
        <option value="0">SELECCIONE...</option>
        <?php  for($i=0;$i<pg_numrows($regis_sis_salud);$i++){
		 $fila_salud=pg_fetch_array($regis_sis_salud,$i);
		 ?>
        <option value="<?php echo $fila_salud['id_sistema_salud'] ?>" <?php if($fila['s_salud']==$fila_salud['id_sistema_salud'])echo "selected";?> ><?php echo $fila_salud['sistema_salud'] ?></option>
        <?php }?>
      </select></td>
      <td class="cuadro01"><input name="hidden_psicologo" type="hidden" id="hidden_psicologo" value="<? echo $fila_matricula['bool_psicologo'];?>" />
        <input name="bool_psicologo" type="radio" id="bool_psicologo0" onclick="limpia(this.name)" value="0" />
NO
<input type="radio" name="bool_psicologo" id="bool_psicologo1" value="1" onclick="limpia(this.name)" />
SI </td>
      <td class="cuadro01"><input name="hidden_trastornoaprendizaje" type="hidden" id="hidden_trastornoaprendizaje" value="<? echo $fila_matricula['bool_tastornosaprendizaje'];?>" />
        <input name="bool_tastornosaprendizaje" type="radio" id="bool_tastornosaprendizaje0" onclick="limpia(this.name)" value="0" />
NO
<input type="radio" name="bool_tastornosaprendizaje" id="bool_tastornosaprendizaje1" value="1" onclick="limpia(this.name)" />
SI
<input type="text" name="txt_trastornosaprendizaje" id="txt_trastornosaprendizaje" value="<? echo $fila_matricula['txt_tastornosaprendizaje'];?>" /></td>
    </tr>
    <tr>
      <td class="cuadro02">Enfermedad cr&oacute;nica</td>
      <td class="cuadro02">Posee Discapacidad</td>
      <td class="cuadro02">Carnet de Discapacidad</td>
    </tr>
    <tr>
      <td class="cuadro01"><input name="cronica" type="radio" id="cronica0" onclick="limpia(this.name)" value="0" <?php echo (trim($fila_matricula['txt_enfcronica'])=="Null")?"checked":"" ?> />
NO
<input type="radio" name="cronica" id="cronica1" value="1" onclick="limpia(this.name)" <?php echo ( trim($fila_matricula['txt_enfcronica'])!="Null")?"checked":"" ?>/>
SI
<input type="text" name="txt_enfcronica" id="txt_enfcronica" value="<? echo $fila_matricula['txt_enfcronica'];?>" /></td>
      <td class="cuadro01"><input name="bool_discapacidad" type="radio" id="bool_discapacidad0" onclick="limpia(this.name)" value="0" <?php echo ($fila_matricula['bool_discapacidad']==0)?"checked":"" ?> />
NO
  <input type="radio" name="bool_discapacidad" id="bool_discapacidad1" value="1" onclick="limpia(this.name)" <?php echo ($fila_matricula['bool_discapacidad']==1)?"checked":"" ?>/>
SI <select name="txt_discapacidad" id="txt_discapacidad">
      <option value="0" <?php echo ($fila_matricula['bool_discapacidad']==0)?"selected":"" ?> >seleccione</option>
      <option value="VISUAL" <?php echo (trim($fila_matricula['txt_discapacidad'])=="VISUAL" )?"selected":"" ?>>VISUAL</option>
      <option value="AUDITIVA" <?php echo (trim($fila_matricula['txt_discapacidad'])=="AUDITIVA" )?"selected":"" ?>>AUDITIVA</option>
      <option value="MOTRIZ" <?php echo (trim($fila_matricula['txt_discapacidad'])=="MOTRIZ" )?"selected":"" ?>>MOTRIZ</option>
      <option value="INTELECTUAL" <?php echo ( trim($fila_matricula['txt_discapacidad'])=="INTELECTUAL" )?"selected":"" ?>>INTELECTUAL</option>
      <option value="TGD"  <?php echo (trim($fila_matricula['txt_discapacidad'])=="TGD" )?"selected":"" ?> >TGD</option>
      <option value="OTRAS" <?php echo (trim($fila_matricula['txt_discapacidad'])=="OTRAS" )?"selected":"" ?>>OTRAS</option>
    </select></td>
      <td class="cuadro01"><input name="bool_carnetdiscapacidad" type="radio" id="bool_carnetdiscapacidad0" onclick="limpia(this.name)" value="0" <?php echo ($fila_matricula['bool_carnetdiscapacidad']==0)?"checked":"" ?> />
NO
  <input type="radio" name="bool_carnetdiscapacidad" id="bool_carnetdiscapacidad1" value="1" onclick="limpia(this.name)"  <?php echo ($fila_matricula['bool_carnetdiscapacidad']==1)?"checked":"" ?>/>
SI </td>
    </tr>
    <tr>
      <td class="cuadro02">Centro de atenci&oacute;n</td>
      <td class="cuadro02">&nbsp;</td>
      <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
      <td class="cuadro01"><input type="text" name="txt_centroatencion" id="txt_centroatencion" value="<? echo $fila_matricula['txt_centroatencion'];?>" /></td>
      <td class="cuadro01">&nbsp;</td>
      <td class="cuadro01">&nbsp;</td>
    </tr>
     <tr>
       <td class="cuadro02" colspan="2">Observaciones de Salud</td>
       <td class="cuadro02">&nbsp;</td>
     </tr>
     <tr>
    <td class="cuadro01" colspan="2"><textarea name="observacion_salud" id="observacion_salud"  style="width:350px;border:1; border-collapse:collapse;"><? echo $fila_matricula['observacion_salud'];?></textarea></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
   </table>
   <br>
 <!------------------------------------>
   <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    <TR>
    <TD colspan="7"><div id="titulo" class="tableindex">ANTECEDENTES GENERALES</div>
    </TD>
    </TR>
    
    <tr>
    <td class="cuadro02">Num. personas dependientes del estudiante</td>
    <td class="cuadro02">Total Ingresos Familiar</td>
    <td class="cuadro02">Tramo sistema de Salud</td>
    </tr>
    <tr>
    <td class="cuadro01"><input type="text" name="num_grupofamiliar" id="num_grupofamiliar" value="<?php echo $fila_matricula['num_grupofamiliar'] ?>" /></td>
    <td class="cuadro01"><input type="text" name="ingresos" id="ingresos" value="<?php echo $fila_matricula['ingresos'] ?>" /></td>
    <td class="cuadro01"><input type="text" name="tramo_salud" id="tramo_salud" value="<?php echo $fila_matricula['tramo_salud'] ?>" /></td>
    </tr>
    <tr>
      <td class="cuadro02">Chile Crece Contigo</td>
      <td class="cuadro02">Ficha Protección social</td>
      <td class="cuadro02">Programa Violencia Intrafamiliar</td>
    </tr>
    <tr>
      <td class="cuadro01"><input name="bool_ccc" type="radio" id="bool_ccc0" value="0" <?php echo ( trim($fila_matricula['bool_ccc'])==0)?"checked":"" ?>/>
NO
  <input type="radio" name="bool_ccc" id="bool_ccc1" value="1" <?php echo ( trim($fila_matricula['bool_ccc'])==1)?"checked":"" ?>/>
SI</td>
      <td class="cuadro01"><input type="text" name="txt_fichaps" id="txt_fichaps" value="<?php echo $fila_matricula['ingresos'] ?>"  /></td>
      <td class="cuadro01"><input name="bool_vif" type="radio" id="bool_vif0" value="0"  <?php echo ( trim($fila_matricula['bool_vif'])==0)?"checked":"" ?>/>
NO
  <input type="radio" name="bool_vif" id="bool_vif1" value="1" <?php echo ( trim($fila_matricula['bool_vif'])==1)?"checked":"" ?>/>
SI</td>
    </tr>
    <tr>
      <td class="cuadro02">Programa Salud Mental</td>
      <td class="cuadro02">Programa Consumo Drogas</td>
      <td class="cuadro02">Programa SENAME</td>
    </tr>
     <tr>
      <td class="cuadro01"><input name="bool_saludmental" type="radio" id="bool_saludmental0" value="0" <?php echo ( trim($fila_matricula['bool_saludmental'])==0)?"checked":"" ?> />
NO
  <input type="radio" name="bool_saludmental" id="bool_saludmental1" value="1" <?php echo ( trim($fila_matricula['bool_saludmental'])==1)?"checked":"" ?> />
SI</td>
      <td class="cuadro01"><input name="bool_drogas" type="radio" id="bool_drogas0" value="0" <?php echo ( trim($fila_matricula['bool_drogas'])==0)?"checked":"" ?>/>
NO
  <input type="radio" name="bool_drogas" id="bool_drogas1" value="1" <?php echo ( trim($fila_matricula['bool_drogas'])==1)?"checked":"" ?> />
SI</td>
      <td class="cuadro01"><input name="bool_sename" type="radio" id="bool_sename0" value="0" <?php echo ( trim($fila_matricula['bool_sename'])==0)?"checked":"" ?>/>
NO
  <input type="radio" name="bool_sename" id="bool_sename1" value="1" <?php echo ( trim($fila_matricula['bool_sename']==1))?"checked":"" ?> />
SI</td>
    </tr>
    <tr>
      <td class="cuadro02">Programa SERNAM</td>
      <td class="cuadro02">&nbsp;</td>
      <td class="cuadro02">&nbsp;</td>
    </tr>
     <tr>
      <td class="cuadro01"><input name="bool_sernam" type="radio" id="bool_sernam0" value="0" <?php echo ( trim($fila_matricula['bool_sernam'])==0)?"checked":"" ?> />
NO
  <input type="radio" name="bool_sernam" id="bool_sernam1" value="1" <?php echo ( trim($fila_matricula['bool_sernam'])==1)?"checked":"" ?> />
SI</td>
      <td class="cuadro01">&nbsp;</td>
      <td class="cuadro01">&nbsp;</td>
    </tr>

     <tr>
       <td class="cuadro02" colspan="2">Observaciones Generales</td>
       <td class="cuadro02">&nbsp;</td>
     </tr>
    
    <tr>
    <td class="cuadro01" colspan="2"><textarea name="obse_general" id="obse_general"  style="width:350px;border:1; border-collapse:collapse;"><? echo $fila_matricula['obse_general'];?></textarea></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
   </table>
   <!------------------------------------>
   <br>
    <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    
    </TR>
    <tr class="tablatit2-1" >
      <td  colspan="3">CONTACTO</td>
    </tr>
    
    <tr>
    <td width="51%" class="cuadro02">Contacto en caso de Emergencia</td>
    <td width="49%" class="cuadro02">Fono</td>
    
    </tr>
    <tr>
    <td class="cuadro01"><input name="txt_contactoemergencia" type="text" id="txt_contactoemergencia" size="30" value="<?php echo $fila_matricula['txt_contactoemergencia'] ?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_fonocontactoemergencia" id="txt_fonocontactoemergencia" value="<?php echo $fila_matricula['txt_fonocontactoemergencia'] ?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Nombre Apoderado/Tutor</td>
    <td class="cuadro02">Fono</td>
    </tr>
    <tr>
    <td class="cuadro01"><input name="txt_tutor" type="text" id="txt_tutor" size="30" value="<?php echo $fila_matricula['txt_tutor'] ?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_fonotutor" id="txt_fonotutor" value="<?php echo $fila_matricula['txt_fonotutor'] ?>" /></td>
    </tr>
   </table>
     <?php
     } 
	  ?>
    </div>

    <!--<div id="academico">
    <h3>academica</h3>
    </div> -->
    
    <div id="becas" style="width:100%;  margin-left:-23px">
    <table width="100%">
    <tr class="cuadro01">
    <td width="1069" align="right" ><input type="button" class="botonXX" title="Cancelar" value="Cancelar" onclick="volver_home()" ></td>
    <td width="68"><input type="button" class="botonXX" title="Guarda Datos" value="Guardar" onclick="guardar_datos_becas()" ></td>
      <td width="70">&nbsp;</td>
    </tr>
    </table> 
	<div id="espacio">&nbsp;</div>
    <?
	 $regis_matricula=$obj_fichaAlumno->datosMatricula($rut_alumno,$id_ano,$curso,$ret);	

		for($e=0;$e < pg_num_rows($regis_matricula);$e++)
		    {
			$fila = pg_fetch_array($regis_matricula,$e);
		
		$rs_becas =	$obj_fichaAlumno->Becas_ins($id_ano);
	   
	   ?>
     <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
   
    <tr>
    <td class="cuadro02">Alimentaci&oacute;n JUNAEB</td>
    <td class="cuadro02">Chile Solidario</td>
    <td class="cuadro02">Municipal </td>
    </tr>
    
    <tr>
    <td class="cuadro01">SI:<input type="radio" name="junaeb" id="junaeb1" value="1"/>
                         NO:<input type="radio" name="junaeb" id="junaeb0" value="0"/>
     <input type="hidden" id="hidden_junaeb" name="hidden_junaeb" value="<?=$fila['bool_baj']?>" />
	</td>
    <td class="cuadro01">SI:<input type="radio" name="chile_sol" id="chile_sol1" value="1"/>
                         NO:<input type="radio" name="chile_sol" id="chile_sol0" value="0"/>
     <input type="hidden" id="hidden_chile_sol" name="hidden_chile_sol" value="<?=$fila['bool_bchs']?>" />
	</td>
    <td class="cuadro01">SI:<input type="radio" name="beca_muni" id="beca_muni1" value="1"/>
                         NO:<input type="radio" name="beca_muni" id="beca_muni0" value="0"/>
     <input type="hidden" id="hidden_beca_muni" name="hidden_beca_muni" value="<?=$fila['bool_mun']?>" />
	</td>
    </tr>
    
    <tr>
    <td class="cuadro02">Financiamiento compartido de la Instituci&oacute;n</td>
    <td class="cuadro02">C. de Padres</td>
    <td class="cuadro02">Seguro</td>
    </tr>
    
    <tr>
    <td class="cuadro01">SI:<input type="radio" name="compar_inst" id="compar_inst1" value="1"/>
                         NO:<input type="radio" name="compar_inst" id="compar_inst0" value="0"/>
     <input type="hidden" id="hidden_compar_inst" name="hidden_compar_inst" value="<?=$fila['bool_fci']?>" />
	</td>
    <td class="cuadro01">SI:<input type="radio" name="cpadre" id="cpadre1" value="1"/>
                         NO:<input type="radio" name="cpadre" id="cpadre0" value="0"/>
     <input type="hidden" id="hidden_cpadre" name="hidden_cpadre" value="<?=$fila['bool_cpadre']?>" />
	</td>
    <td class="cuadro01">SI:<input type="radio" name="bec_seguro" id="bec_seguro1" value="1"/>
                         NO:<input type="radio" name="bec_seguro" id="bec_seguro0" value="0"/>
     <input type="hidden" id="hidden_bec_seguro" name="hidden_bec_seguro" value="<?=$fila['bool_seg']?>" />
	</td>
    
    </tr>
    
    <tr>
      <td class="cuadro02">Beneficiario PIE</td>
      <td class="cuadro02">Beneficiario SEP</td>
      <td class="cuadro02">Programa PUENTE</td>
    </tr>
    <tr>
      <td class="cuadro01">SI:<input type="radio" name="ben_pie" id="ben_pie1" value="1"/>
                         NO:<input type="radio" name="ben_pie" id="ben_pie0" value="0"/>
     <input type="hidden" id="hidden_ben_pie" name="hidden_ben_pie" value="<?=$fila['ben_pie']?>" /></td>
      
      <td class="cuadro01">SI:<input type="radio" name="ben_sep" id="ben_sep1" value="1"/>
                         NO:<input type="radio" name="ben_sep" id="ben_sep0" value="0"/>
     <input type="hidden" id="hidden_ben_sep" name="hidden_ben_sep" value="<?=$fila['ben_sep']?>" /></td>
      
      <td class="cuadro01">SI:<input type="radio" name="ben_puente" id="ben_puente1" value="1"/>
                         NO:<input type="radio" name="ben_puente" id="ben_puente0" value="0"/>
     <input type="hidden" id="hidden_ben_puente" name="hidden_ben_puente" value="<?=$fila['ben_puente']?>" /></td>
    </tr>
    <tr>
    <td colspan="3" class="cuadro02">Otras</td>
    </tr>
    
    <tr>
    <td class="cuadro01">SI:<input type="radio" name="bec_otros" id="bec_otros1" value="1"/>
                         NO:<input type="radio" name="bec_otros" id="bec_otros0" value="0"/>
     <input type="hidden" id="hidden_bec_otros" name="hidden_bec_otros" value="<?=$fila['bool_otros']?>" />
	</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
    </table>
    <br />
    <table width="100%" border="1" style="border-collapse:collapse">
    <tr>
    <td class="cuadro02">Becas de la Instituci&oacute;n</td>
    <td class="cuadro02"><input name="cant_becas_ins" id="cant_becas_ins" type="hidden" value="<?=pg_num_rows($rs_becas);?>" /></td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    
     <?php
    	for($i=0;$i < pg_num_rows($rs_becas);$i++)
		{
			$fila_b = pg_fetch_array($rs_becas,$i);
			$id_beca = $fila_b['id_beca'];
		
		?>
    <tr>    
    <td width="21%" class="cuadro01">
    <? echo $fila_b['nomb_beca'];?>
    </td>
    <td width="30%" class="cuadro01">
    <?php
    $rs_becas_al =$obj_fichaAlumno->Becas_alumno($id_beca,$rut_alumno);
	$www = pg_num_rows($rs_becas_al);
	
	?>
    SI:<input type="radio" name="beca_ins<?php echo $i ?>" id="beca_ins<?php echo $i ?>_1" value="<?php echo $id_beca ?>" <?php echo ($www>0)?"checked":"" ?>/>
                         NO:<input type="radio" name="beca_ins<?php echo $i ?>" id="beca_ins<?php echo $i ?>_0" value="<?php echo $id_beca ?>"  <?php echo ($www==0)?"checked":"" ?>/>
     <input type="hidden" id="hidden_beca_ins<?php echo $i ?>" name="hidden_beca_ins<?php echo $i ?>" value="<?=$www?>" />
    </td>
    <td width="49%">&nbsp;</td>
     </tr>
	<?
	}	
	?>
    </table>
    <?
	  }
	  ?>
    </div>
 <div id="documentos">
   <table width="100%">
    <tr class="cuadro01">
    <td width="1069" align="right" ><input type="button" class="botonXX" title="Cancelar" value="Cancelar" onclick="volver_home()" ></td>
    <td width="68"><input type="button" class="botonXX" title="Guarda Datos" value="Guardar" onclick="guardar_datos_documentos()" ></td>
      <td width="70">&nbsp;</td>
    </tr>
    </table><br />
<br />
<table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
      <TD colspan="6"><div id="titulo" class="tableindex">Documentos entregados por el alumno</div>
    </TD></TR>
       <tr>
    <td class="cuadro02">Certificado de Nacimiento</td>
    <td class="cuadro02">Certificado de Notas</td>
    <td class="cuadro02">Nivel </td>
    </tr>
      <tr>
    <td class="cuadro01">
     <input name="bool_traecertificados" type="radio" id="bool_traecertificado0" onclick="limpia(this.name)" value="0"  <?php echo ($fila_matricula['bool_traecertificados']==0)?"checked":"" ?>/>
NO
<input type="radio" name="bool_traecertificados" id="bool_traecertificado1" value="1" onclick="limpia(this.name)"  <?php echo ($fila_matricula['bool_traecertificados']==1)?"checked":"" ?>/>
SI </td>
    <td class="cuadro01"><input name="bool_traecertificadosant" type="radio" id="bool_tracecertificadoanterior0" onclick="limpia(this.name)" value="0"  <?php echo ($fila_matricula['bool_traecertificadosant']==0)?"checked":"" ?>/>
NO
<input type="radio" name="bool_traecertificadosant" id="bool_tracecertificadoanterior1" value="1" onclick="limpia(this.name)"   <?php echo ($fila_matricula['bool_traecertificadosant']==1)?"checked":"" ?>/>
SI&nbsp;</td>
    <td class="cuadro01">
      <input type="text" name="nivel_certificado" id="nivel_certificado" value="<?php echo $fila_matricula['nivel_certificado'] ?>"/></td>
    </tr>
     <tr>
    <td class="cuadro02">Autor. Secreduc</td>
    <td class="cuadro02">Plazo Fecha</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
      <tr>
    <td class="cuadro01"><input name="bool_secreduc" type="radio" id="bool_secreduc0" onclick="limpia(this.name)" value="0"  <?php echo ($fila_matricula['bool_secreduc']==0)?"checked":"" ?> />
NO
<input type="radio" name="bool_secreduc" id="bool_secreduc1" value="1" onclick="limpia(this.name)"  <?php echo ($fila_matricula['bool_secreduc']==1)?"checked":"" ?> />
SI </td>
    <td class="cuadro01"><input name="plazo_autorizacion" type="text" id="plazo_autorizacion" size="10" value="<?php echo $fila_matricula['plazo_autorizacion'] ?>"  /></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
     <tr>
    <td class="cuadro02">Manual de convivencia</td>
    <td class="cuadro02">Aporte Voluntario CCA</td>
    <td class="cuadro02">Pago Matr&iacute;cula </td>
    </tr>
      <tr>
    <td class="cuadro01"><input name="bool_manualconvivencia" type="radio" id="bool_manualconvivencia0" onclick="limpia(this.name)" value="0"  <?php echo ($fila_matricula['bool_manualconvivencia']==0)?"checked":"" ?> />
NO
<input type="radio" name="bool_manualconvivencia" id="bool_manualconvivencia1" value="1" onclick="limpia(this.name)"  <?php echo ($fila_matricula['bool_manualconvivencia']==1)?"checked":"" ?>/>
SI </td>
    <td class="cuadro01">
      <input name="txtaporteCGP" id="txtaporteCGP" type="text" size="5"  value="<?php echo $fila_matricula['apvol_cgp'] ?>" /></td>
    <td class="cuadro01"><input name="bool_pagomatricula" type="radio" id="bool_pagomatricula0" onclick="limpia(this.name)" value="0"  <?php echo ($fila_matricula['bool_pagomatricula']==0)?"checked":"" ?>/>
NO
<input type="radio" name="bool_pagomatricula" id="bool_pagomatricula1" value="1" onclick="limpia(this.name)" <?php echo ($fila_matricula['bool_pagomatricula']==1)?"checked":"" ?>/>
SI </td>
    </tr>
     <tr>
    <td class="cuadro02">Abono</td>
    <td class="cuadro02">Nro. Boleta</td>
    <td class="cuadro02">Exento Matr&iacute;cula</td>
    </tr>
      <tr>
    <td class="cuadro01">
      <input type="text" name="abono_matricula" id="abono_matricula" value="<?php echo $fila_matricula['abono_matricula'] ?>" /></td>
    <td class="cuadro01">      <input name="txtNUMBOLETA" id="txtNUMBOLETA" type="text" size="5" maxlength="1" value="<?php echo $fila_matricula['numboleta'] ?>
" /></td>
    <td class="cuadro01"><input name="bool_exentomatricula" type="radio" id="bool_exentomatricula0" onclick="limpia(this.name)" value="0" <?php echo ($fila_matricula['bool_exentomatricula']==0)?"checked":"" ?> />
NO
<input type="radio" name="bool_exentomatricula" id="bool_exentomatricula1" value="1" onclick="limpia(this.name)" <?php echo ($fila_matricula['bool_exentomatricula']==1)?"checked":"" ?> />
SI </td>
    </tr>
     <tr>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
      <tr>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
     </table>
    </div>
   <!-- <div id="Grupos">
    <h3>Grupos</h3>
    </div>-->
    
  <!--  <div id="Entrevistas">
    <h3>Entrvistas</h3>
    </div>-->
    
      
      
</div>



</form>

<?
pg_close($conn);
pg_close($connection);
?>

