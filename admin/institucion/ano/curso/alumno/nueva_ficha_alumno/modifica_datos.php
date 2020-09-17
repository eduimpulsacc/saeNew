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
$rs_trabaja = $obj_fichaAlumno->traeNombreEmp($_INSTIT);

?>

<style type="text/css">
	div.ui-datepicker{
	font-size:12px;
	}
</style>

<script>



$(document).ready(function() {
	
	$('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');			
          });
	
	datos_familiar_mod();
	$("#fecha_nac").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>",
	showOn: 'both',
	//buttonImage: '../../../../../clases/jquery-ui-1.8.14.custom/development-bundle/demos/datepicker/images/calendar.gif',
	});
	$.datepicker.regional['es']	
	
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
	
	var alumno_sep = $('#hidden_sep').val();
	//alert(tipo_nacionalidad);
    if(alumno_sep==1)
    {
        document.getElementById('al_sep1').checked=true;
        document.getElementById('al_sep0').checked=false;
    }
    else
    {
       document.getElementById('al_sep1').checked=false;
       document.getElementById('al_sep0').checked=true;
    }
	
	var alumno_retos = $('#hidden_retos').val();
	//alert(tipo_nacionalidad);
    if(alumno_retos==1)
    {
        document.getElementById('al_retos1').checked=true;
        document.getElementById('al_retos0').checked=false;
    }
    else
    {
       document.getElementById('al_retos1').checked=false;
       document.getElementById('al_retos0').checked=true;
    }
	
	var alumno_puente = $('#hidden_puente').val();
	//alert(tipo_nacionalidad);
    if(alumno_puente==1)
    {
        document.getElementById('al_puente1').checked=true;
        document.getElementById('al_puente0').checked=false;
    }
    else
    {
       document.getElementById('al_puente1').checked=false;
       document.getElementById('al_puente0').checked=true;
    }
	
	var alumno_fc = $('#hidden_fc').val();
	//alert(tipo_nacionalidad);
    if(alumno_fc==1)
    {
        document.getElementById('al_fc1').checked=true;
        document.getElementById('al_fc0').checked=false;
    }
    else
    {
       document.getElementById('al_fc1').checked=false;
       document.getElementById('al_fc0').checked=true;
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
	
	
	
	
	var enfermedad = $('#hidden_enfermedad').val();
	//alert(tipo_nacionalidad);
    if(enfermedad!="ninguna")
    {
        document.getElementById('enfermedad1').checked=true;
        document.getElementById('enfermedad0').checked=false;
		$('#txtENFERMEDAD').removeAttr("disabled");
		$('#txtENFERMEDAD').val(''+enfermedad+'');
    }
    else
    {
       document.getElementById('enfermedad1').checked=false;
       document.getElementById('enfermedad0').checked=true;
	   $('#txtCIRUGIA').val("ninguna");
    }
	
	
	var cirugia = $('#hidden_cirugia').val();
	//alert(tipo_nacionalidad);
    if(cirugia!="ninguna")
    {
        document.getElementById('cirugia1').checked=true;
        document.getElementById('cirugia0').checked=false;
		$('#txtCIRUGIA').removeAttr("disabled");
		$('#txtCIRUGIA').val(''+cirugia+'');
    }
    else
    {
       document.getElementById('cirugia1').checked=false;
       document.getElementById('cirugia0').checked=true;
	   $('#txtCIRUGIA').val("ninguna");
    }
	
	
	var medicamento = $('#hidden_medicamento').val();
	//alert(tipo_nacionalidad);
    if(medicamento!="ninguna")
    {
        document.getElementById('medicamento1').checked=true;
        document.getElementById('medicamento0').checked=false;
		$('#txtMEDICAMENTO').removeAttr("disabled");
		$('#txtMEDICAMENTO').val(''+medicamento+'');
    }
    else
    {
       document.getElementById('medicamento1').checked=false;
       document.getElementById('medicamento0').checked=true;
	   $('#txtMEDICAMENTO').val("ninguna");
    }
	
	var alergia = $('#hidden_alergia').val();
	//alert(tipo_nacionalidad);
    if(alergia!="ninguna")
    {
        document.getElementById('alergia1').checked=true;
        document.getElementById('alergia0').checked=false;
		$('#txtALERGIA').removeAttr("disabled");
		$('#txtALERGIA').val(''+alergia+'');
    }
    else
    {
       document.getElementById('alergia1').checked=false;
       document.getElementById('alergia0').checked=true;
	   $('#txtALERGIA').val("ninguna");
    }
	
	var fisica = $('#hidden_fisica').val();
	//alert(tipo_nacionalidad);
    if(fisica!="ninguna")
    {
        document.getElementById('fisica1').checked=true;
        document.getElementById('fisica0').checked=false;
		$('#txtFISICA').removeAttr("disabled");
		$('#txtFISICA').val(''+fisica+'');
    }
    else
    {
       document.getElementById('fisica1').checked=false;
       document.getElementById('fisica0').checked=true;
	   $('#txtFISICA').val("ninguna");
    }
	
	
	var fiebre = $('#hidden_fiebre').val();
	//alert(tipo_nacionalidad);
    if(fiebre!="ninguna")
    {
        document.getElementById('fiebre1').checked=true;
        document.getElementById('fiebre0').checked=false;
		$('#txtFIEBRE').removeAttr("disabled");
		$('#txtFIEBRE').val(''+fiebre+'');
    }
    else
    {
       document.getElementById('fiebre1').checked=false;
       document.getElementById('fiebre0').checked=true;
	   $('#txtFIEBRE').val("ninguna");
    }
	
	
	var seguro = $('#hidden_seguro').val();
	//alert(tipo_nacionalidad);
    if(seguro!="ninguna")
    {
        document.getElementById('seguro1').checked=true;
        document.getElementById('seguro0').checked=false;
		$('#txtSEGURO').removeAttr("disabled");
		$('#txtSEGURO').val(''+seguro+'');
    }
    else
    {
       document.getElementById('seguro1').checked=false;
       document.getElementById('seguro0').checked=true;
	   $('#txtSEGURO').val("ninguna");
    }
	
	
	var aut_emergencia = $('#hidden_aut_emergencia').val();
	//alert(tipo_nacionalidad);
    if(aut_emergencia==1)
    {
        document.getElementById('aut_emergencia1').checked=true;
        document.getElementById('aut_emergencia0').checked=false;
    }
    else
    {
       document.getElementById('aut_emergencia1').checked=false;
       document.getElementById('aut_emergencia0').checked=true;
    }
	
	
	var viaja_furgon = $('#hidden_viaja_furgon').val();
	//alert(tipo_nacionalidad);
    if(viaja_furgon==1)
    {
        document.getElementById('viaja_furgon1').checked=true;
        document.getElementById('viaja_furgon0').checked=false;
    }
    else
    {
       document.getElementById('viaja_furgon1').checked=false;
       document.getElementById('viaja_furgon0').checked=true;
    }
	
	var opta_religion = $('#hidden_opta_religion').val();
	//alert(tipo_nacionalidad);
    if(opta_religion==1)
    {
        document.getElementById('opta_religion1').checked=true;
        document.getElementById('opta_religion0').checked=false;
    }
    else
    {
       document.getElementById('opta_religion1').checked=false;
       document.getElementById('opta_religion0').checked=true;
    }
	
	var ed_diferencial = $('#hidden_ed_diferencial').val();
	//alert(tipo_nacionalidad);
    if(ed_diferencial==1)
    {
        document.getElementById('ed_diferencial1').checked=true;
        document.getElementById('ed_diferencial0').checked=false;
    }
    else
    {
       document.getElementById('ed_diferencial1').checked=false;
       document.getElementById('ed_diferencial0').checked=true;
    }
	
	var al_integrado = $('#hidden_al_integrado').val();
	//alert(tipo_nacionalidad);
    if(al_integrado==1)
    {
        document.getElementById('al_integrado1').checked=true;
        document.getElementById('al_integrado0').checked=false;
    }
    else
    {
       document.getElementById('al_integrado1').checked=false;
       document.getElementById('al_integrado0').checked=true;
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
	
	//pie
	var ben_pie = $('#hidden_ben_pie').val();
    if(ben_pie==1)
    {
        document.getElementById('ben_pie1').checked=true;
        document.getElementById('ben_pie0').checked=false;
    }
    else
    {
       document.getElementById('ben_pie1').checked=false;
       document.getElementById('ben_pie0').checked=true;
    }
	
	//sep
	var ben_sep = $('#hidden_ben_sep').val();
    if(ben_sep==1)
    {
        document.getElementById('ben_sep1').checked=true;
        document.getElementById('ben_sep0').checked=false;
    }
    else
    {
       document.getElementById('ben_sep1').checked=false;
       document.getElementById('ben_sep0').checked=true;
    }
	
	//puente
	var ben_puente = $('#hidden_ben_puente').val();
    if(ben_puente==1)
    {
        document.getElementById('ben_puente1').checked=true;
        document.getElementById('ben_puente0').checked=false;
    }
    else
    {
       document.getElementById('ben_puente1').checked=false;
       document.getElementById('ben_puente0').checked=true;
    }
	
	
	
	var tip_especialista=$('#hidden_sistema_salud').val();
	if(tip_especialista==""){
		tip_especialista=0;
		}
		
	$("#cmbESPEC option[value="+tip_especialista+"]").attr("selected",true);


	var tip_sancion=$('#hidden_sancion').val();
	if(tip_sancion==""){
		tip_sancion=0;
		}
	$("#cmbSANCION option[value="+tip_sancion+"]").attr("selected",true);
	
	
	var condicionalidad=$('#hidden_condicionalidad').val();
	if(condicionalidad==""){
		condicionalidad=0;
		}
	$("#cmb_condicional option[value="+condicionalidad+"]").attr("selected",true);
	
	
	
	var pdental = $('#hidden_pdentales').val();
    if(pdental==1)
    {
        document.getElementById('probdentales1').checked=true;
        document.getElementById('probdentales0').checked=false;
    }
    else
    {
       document.getElementById('probdentales1').checked=false;
       document.getElementById('probdentales0').checked=true;
    }
	
	//alert(txt_id_curso);
	
	var cdental = $('#hidden_controldental').val();
    if(pdental==1)
    {
        document.getElementById('CONTROLDENTAL1').checked=true;
        document.getElementById('CONTROLDENTAL0').checked=false;
    }
    else
    {
       document.getElementById('CONTROLDENTAL1').checked=false;
       document.getElementById('CONTROLDENTAL0').checked=true;
    }
	
	
	var famenfermo = $('#hidden_famenfermo').val();
    if(famenfermo==1)
    {
        document.getElementById('FAMILIARENFERMO1').checked=true;
        document.getElementById('FAMILIARENFERMO0').checked=false;
    }
    else
    {
       document.getElementById('FAMILIARENFERMO1').checked=false;
       document.getElementById('FAMILIARENFERMO0').checked=true;
    }
	
	
	var jefeaporta = $('#hidden_jefeaporta').val();
    if(jefeaporta==1)
    {
        document.getElementById('jefe_aporta1').checked=true;
        document.getElementById('jefe_aporta0').checked=false;
    }
    else
    {
       document.getElementById('jefe_aporta1').checked=false;
       document.getElementById('jefe_aporta0').checked=true;
    }
	
	
		var espaciojuego = $('#hidden_espaciojuego').val();
    if(espaciojuego==1)
    {
        document.getElementById('espacio_juego1').checked=true;
        document.getElementById('espacio_juego0').checked=false;
    }
    else
    {
       document.getElementById('espacio_juego1').checked=false;
       document.getElementById('espacio_juego0').checked=true;
    }
	
	
	var espacioestudio = $('#hidden_espacioestudio').val();
    if(espaciojuego==1)
    {
        document.getElementById('espacio_estudio1').checked=true;
        document.getElementById('espacio_estudio0').checked=false;
    }
    else
    {
       document.getElementById('espacio_estudio1').checked=false;
       document.getElementById('espacio_estudio0').checked=true;
    }
	
	
		var hizojardin = $('#hidden_hizojardin').val();
    if(hizojardin==1)
    {
        document.getElementById('hizo_jardin1').checked=true;
        document.getElementById('hizo_jardin0').checked=false;
    }
    else
    {
       document.getElementById('hizo_jardin1').checked=false;
       document.getElementById('hizo_jardin0').checked=true;
    }
	
	
	var neuro = $('#hidden_neurologo').val();
    if(neuro==1)
    {
        document.getElementById('bool_neurologo1').checked=true;
        document.getElementById('bool_neurologo0').checked=false;
    }
    else
    {
       document.getElementById('bool_neurologo1').checked=false;
        document.getElementById('bool_neurologo0').checked=true;
    }
	
	
	
	var psicop = $('#hidden_psicopedagogo').val();
    if(psicop==1)
    {
        document.getElementById('bool_psicopedagogo1').checked=true;
        document.getElementById('bool_psicopedagogo0').checked=false;
    }
    else
    {
       document.getElementById('bool_psicopedagogo1').checked=false;
        document.getElementById('bool_psicopedagogo0').checked=true;
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
	
	
	var otrot = $('#hidden_otrotratamiento').val();
    if(otrot==1)
    {
        document.getElementById('bool_otrotratamiento1').checked=true;
        document.getElementById('bool_otrotratamiento0').checked=false;
    }
    else
    {
       document.getElementById('bool_otrotratamiento1').checked=false;
        document.getElementById('bool_otrotratamiento0').checked=true;
    }
	
	
	var actual = $('#hidden_tratactual').val();
    if(actual==1)
    {
        document.getElementById('bool_tratactual1').checked=true;
        document.getElementById('bool_tratactual0').checked=false;
    }
    else
    {
       document.getElementById('bool_tratactual1').checked=false;
        document.getElementById('bool_tratactual0').checked=true;
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
	
	
	
	//alert(tipo_nacionalidad);
	var tluz=$('#hidden_tieneluz').val();
    if(tluz==1)
    {
        document.getElementById('bool_tieneluz1').checked=true;
        document.getElementById('bool_tieneluz0').checked=false;
    }
    else
    {
       document.getElementById('bool_tieneluz1').checked=false;
       document.getElementById('bool_tieneluz0').checked=true;
    }
	
	
	var tagua=$('#hidden_tieneagua').val();
    if(tagua==1)
    {
        document.getElementById('bool_tieneagua1').checked=true;
        document.getElementById('bool_tieneagua0').checked=false;
    }
    else
    {
       document.getElementById('bool_tieneagua1').checked=false;
       document.getElementById('bool_tieneagua0').checked=true;
    }
	
	var talcantarilla=$('#hidden_tienealcantarillado').val();
    if(talcantarilla==1)
    {
        document.getElementById('bool_tienealcantarillado1').checked=true;
        document.getElementById('bool_tienealcantarillado0').checked=false;
    }
    else
    {
       document.getElementById('bool_tienealcantarillado1').checked=false;
       document.getElementById('bool_tienealcantarillado0').checked=true;
    }
	
	
	var rsolo=$('#hidden_retirosolo').val();
    if(rsolo==1)
    {
        document.getElementById('bool_retirosolo1').checked=true;
        document.getElementById('bool_retirosolo0').checked=false;
    }
    else
    {
       document.getElementById('bool_retirosolo1').checked=false;
       document.getElementById('bool_retirosolo0').checked=true;
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
	
	
	if(document.getElementById('nacionalidad_1').checked==true && $('#pais_origen').val()==0)
	{
		 alert("Seleccione Pais origen");
		   $('#pais_origen').focus();
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
	

    var separa_ = $('#select_provincias').val().split(',');
	
	var rut_alumno = <?=$rut_alumno;?>;
	var dig_rut = $('#dig_rut').val();	
	var nombre_alum = $('#nombre_alu').val();
	var ape_pat = $('#ape_pat').val();
	var ape_mat = $('#ape_mat').val();
	var fecha_nac = $('#fecha_nac').val();
	var sexo = $("input[name='sexo']:checked").val();		
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
	var celular = $('#txt_celular').val();
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
	var rut_retira = $('#rut_retira').val();
	if(rut_retira!=""  ){
	var nuevo_rut = rut_retira.split('.');
    var rut_sinpuntos = nuevo_rut[0]+nuevo_rut[1]+nuevo_rut[2];
	}else{
	var rut_sinpuntos="-";	
	}
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

var txt_eleccion = $('#txt_eleccion').val();
var bool_cambioropa = $("input[name='bool_cambioropa']:checked").val();
var bool_tomafoto = $("input[name='bool_tomafoto']:checked").val();
var bool_facebook = $("input[name='bool_facebook']:checked").val();

var estilo_aprendizaje = $('#estilo_aprendizaje').val();

var enc_matricula = $('#cmbENCMATRICULA').val();

if($("input[name='nacionalidad']:checked").val()==2){
var pais_origen = 46;
}else{
	var pais_origen = $('#pais_origen').val();
}

var pasaporte = $('#pasaporte').val();


var bool_bautismo = ($("input[name='bool_bautismo']").is(':checked'))?1:0;

var bool_pcomunion = ($("input[name='bool_pcomunion']").is(':checked'))?1:0;

var bool_confirmacion = ($("input[name='bool_confirmacion']").is(':checked'))?1:0;

var bool_psiquiatra = $("input[name='bool_psiquiatra']:checked").val();

var bool_fonoaudiologo = $("input[name='bool_fonoaudiologo']:checked").val();

var bool_pvision = $("input[name='bool_pvision']:checked").val();

var bool_paudicion = $("input[name='bool_paudicion']:checked").val();

var bool_pcolumna = $("input[name='bool_pcolumna']:checked").val();

var bool_gdiferencial = $("input[name='bool_gdiferencial']:checked").val();

var aut_vacuna = $("input[name='aut_vacuna']:checked").val();

var txt_subsidio = $('#txt_subsidio').val();


var rut_retira2 = $('#rut_retira2').val();
	if(rut_retira2!="" && rut_retira2!="-"  ){
	var nuevo_rut2 = rut_retira2.split('.');
    var rut_sinpuntos2 = nuevo_rut2[0]+nuevo_rut2[1]+nuevo_rut2[2];
	}else{
	var rut_sinpuntos2="-";	
	}
	/***********************************************************************************************/
	
	var nombre_retira2 = $('#nombre_retira2').val();
	var parentesco_retira2 = $('#parentesco_retira2').val();
	var telefono_retira2 = $('#telefono_retira2').val();
	var cel_retira2 = $('#cel_retira2').val();


var rut_retira3 = $('#rut_retira3').val();
	if(rut_retira3!="" && rut_retira3!="-"  ){
	var nuevo_rut3 = rut_retira3.split('.');
    var rut_sinpuntos3 = nuevo_rut3[0]+nuevo_rut3[1]+nuevo_rut3[2];
	}else{
	var rut_sinpuntos3="-";	
	}
	/***********************************************************************************************/
	
	var nombre_retira3 = $('#nombre_retira3').val();
	var parentesco_retira3 = $('#parentesco_retira3').val();
	var telefono_retira3 = $('#telefono_retira3').val();
	var cel_retira3 = $('#cel_retira3').val();
	var txt_etnia = $('#txt_etnia').val();

	var num_mat = $('#num_mat').val();
	var txt_causajuzgado = $('#txt_causajuzgado').val();
	
	var txt_fichaps = $('#txt_fichaps').val();
	var ben_prog_prot_social = $('#ben_prog_prot_social').val();
	
	var bool_deporte = $("input[name='bool_deporte']:checked").val();
	var txt_deporte = $('#txt_deporte').val();

		
	var funcion = 4;
	
	
	var parametros='funcion='+funcion+'&rut_alumno='+rut_alumno+'&dig_rut='+dig_rut+'&nombre_alum='+nombre_alum+'&ape_pat='+ape_pat+'&ape_mat='+ape_mat+'&fecha_nac='+fecha_nac+'&sexo='+sexo+'&nacionalidad='+nacionalidad+'&alum_emb='+alum_emb+'&alum_ind='+alum_ind+'&proced_alum='+proced_alum+'&con_quien_vive='+con_quien_vive+'&txt_calle='+txt_calle+'&txt_nro='+txt_nro+'&txt_block='+txt_block+'&txt_depto='+txt_depto+'&txt_villa='+txt_villa+'&txt_fono='+txt_fono+'&txt_email='+txt_email+'&region='+region+'&provincia='+provincia+'&comuna='+comuna+'&curso_rep='+curso_rep+'&especialista='+especialista+'&al_pie='+al_pie+'&al_sep='+al_sep+'&al_retos='+al_retos+'&al_puente='+al_puente+'&al_fc='+al_fc+'&cmbSANCION='+cmbSANCION+'&txtENFERMEDAD='+txtENFERMEDAD+'&txtCIRUGIA='+txtCIRUGIA+'&txtMEDICAMENTO='+txtMEDICAMENTO+'&txtALERGIA='+txtALERGIA+'&txtFISICA='+txtFISICA+'&txtFIEBRE='+txtFIEBRE+'&txtSEGURO='+txtSEGURO+'&aut_emergencia='+aut_emergencia+'&rut_sinpuntos='+rut_sinpuntos+'&nombre_retira='+nombre_retira+'&parentesco_retira='+parentesco_retira+'&telefono_retira='+telefono_retira+'&cel_retira='+cel_retira+'&viaja_furgon='+viaja_furgon+'&nombre_tio='+nombre_tio+'&fono_furgon='+fono_furgon+'&fecham='+fecham+'&alumno_ret='+alumno_ret+'&fechar='+fechar+'&motivo_r='+motivo_r+'&cmb_condicional='+cmb_condicional+'&opta_religion='+opta_religion+'&ed_diferencial='+ed_diferencial+'&al_integrado='+al_integrado+'&id_curso='+id_curso+'&nro_ano='+nro_ano+'&id_ano='+id_ano+'&datos_interes='+datos_interes+'&observacion='+observacion+'&observacion_salud='+observacion_salud+'&ret='+ret+'&cmbMOTIVO='+cmbMOTIVO+"&religion="+religion+"&telefono_recado="+telefono_recado+"&tipo_parto="+tipo_parto+"&edad_madre_nace="+edad_madre_nace+"&peso_nace="+peso_nace+"&talla_nace="+talla_nace+"&s_salud="+s_salud+"&probdentales="+probdentales+"&controldental="+controldental+"&controlsano="+controlsano+"&famenfermo="+famenfermo+"&jefe_hogar="+jefe_hogar+"&ocup_jefehogar="+ocup_jefehogar+"&num_grupofamiliar="+num_grupofamiliar+"&ingresos="+ingresos+"&tipo_vivienda="+tipo_vivienda+"&cant_dormitorios="+cant_dormitorios+"&cant_banos="+cant_banos+"&espacio_juego="+espacio_juego+"&espacio_estudio="+espacio_estudio+"&hizo_jardin="+hizo_jardin+"&carinoso="+carinoso+"&sociable="+sociable+"&curioso="+curioso+"&org_participa="+org_participa+"&con_quien_estudia="+con_quien_estudia+"&obse_general="+obse_general+"&figura_paterna="+figura_paterna+"&jefe_aporta="+jefe_aporta+"&bool_neurologo="+bool_neurologo+"&bool_psicopedagogo="+bool_psicopedagogo+"&bool_psicologo="+bool_psicologo+"&bool_tieneluz="+bool_tieneluz+"&bool_tieneagua="+bool_tieneagua+"&bool_tienealcantarillado="+bool_tienealcantarillado+"&bool_retirosolo="+bool_retirosolo+"&bool_otratamiento="+bool_otratamiento+"&bool_tratactual="+bool_tratactual+"&bool_tastornosaprendizaje="+bool_tastornosaprendizaje+"&material_vivienda="+material_vivienda+"&estado_vivienda="+estado_vivienda+"&txt_otratamiendo="+txt_otratamiendo+"&txt_tratactual="+txt_tratactual+"&txt_trastornosaprendizaje="+txt_trastornosaprendizaje+"&cant_hermanos="+cant_hermanos+"&num_hermano="+num_hermano+"&txt_eleccion="+txt_eleccion+"&bool_cambioropa="+bool_cambioropa+"&bool_tomafoto="+bool_tomafoto+"&bool_facebook="+bool_facebook+"&pais_origen="+pais_origen+"&pasaporte="+pasaporte+"&estilo_aprendizaje="+estilo_aprendizaje+"&celular="+celular+"&enc_matricula="+enc_matricula+'&rut_sinpuntos2='+rut_sinpuntos2+'&nombre_retira2='+nombre_retira2+'&parentesco_retira2='+parentesco_retira2+'&telefono_retira2='+telefono_retira2+'&cel_retira2='+cel_retira2+'&rut_sinpuntos3='+rut_sinpuntos3+'&nombre_retira3='+nombre_retira3+'&parentesco_retira3='+parentesco_retira3+'&telefono_retira3='+telefono_retira3+'&cel_retira3='+cel_retira3+"&txt_etnia="+txt_etnia+"&bool_bautismo="+bool_bautismo+"&bool_pcomunion="+bool_pcomunion+"&bool_confirmacion="+bool_confirmacion+"&bool_psiquiatra="+bool_psiquiatra+"&bool_fonoaudiologo="+bool_fonoaudiologo+"&bool_pvision="+bool_pvision+"&bool_paudicion="+bool_paudicion+"&bool_pcolumna="+bool_pcolumna+"&bool_gdiferencial="+bool_gdiferencial+"&aut_vacuna="+aut_vacuna+"&num_mat="+num_mat+"&txt_subsidio="+txt_subsidio+"&txt_causajuzgado="+txt_causajuzgado+"&txt_fichaps="+txt_fichaps+"&ben_prog_prot_social="+ben_prog_prot_social+"&bool_deporte="+bool_deporte+"&txt_deporte="+txt_deporte;	
	
	
	//console.log(parametros);
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
			window.location='ficha_alumno.php?alumno='+rut_alumno+'&r='+alumno_ret+"&crs="+id_curso;
			}else{
			alert("Error al Modificar");	
			}
	    }
	});
  }
}


 function datos_familiar_mod()
{
	var rut_alumno = "<?=$rut_alumno;?>";
	var funcion = 9;
	
	var parametros = 'funcion='+funcion+'&rut_alumno='+rut_alumno;
	
		//alert(parametros);
		
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 //alert(data);
	    $("#sel_familiar").html(data);
		//$("#sel_familiar option[value="+rut_alumno+"]").attr("selected",true);
	   }
	})		
}

function modifica_familiar()
  {
		 
	$('#eva_destino *').attr('selected','selected');
		 
	 if($('#nombre_apo').val()==""){
	 alert("Ingrese Nombre");
	 $('#nombre_apo').focus();
	return false;
	}
	
	if($('#ape_pat_apo').val()==""){
	  alert("Ingrese Apellido Paterno");
	  $('#ape_pat_apo').focus();
	return false;
	}		
	
	if($('#ape_mat_apo').val()==""){
	  alert("Ingrese Apellido Materno");
	  $('#ape_mat_apo').focus();
	return false;
	}		
	
	 <?php 
	/*if($('#fecha_nac2').val()==""){
	  alert("Ingrese Fecha Nacimiento");
	  $('#fecha_nac2').focus();
	//return false;
	}	*/
	
	  ?>
	if($("#chk_apoderado").is(':checked')){
		var relacion_apo = 1
		}else{
			 relacion_apo = 2;	
		}
	
	
	var rut_apo = $('#txt_rut_apo').val();
	var nombre_apo = $('#nombre_apo').val();
	var ape_pat_apo = $('#ape_pat_apo').val();
	var ape_mat_apo = $('#ape_mat_apo').val();
	var fecha_nac_apo = $('#fecha_nac2').val();
	var sexo_apo = $("input[name='sexo_']:checked").val();		
	var nacionalidad_apo = $("input[name='nacionalidad']:checked").val();
    
	var txt_calle_apo = $('#txt_calle_apo').val();
	var txt_nro_apo = $('#txt_nro_apo').val();
	var txt_block_apo = $('#txt_block_apo').val();
	var txt_depto_apo = $('#txt_depto_apo').val();
	var txt_villa_apo = $('#txt_villa_apo').val();
	var txt_fono_apo = $('#txt_fono_apo').val();
	var txt_celular_apo = $('#txt_celular_apo').val();
	var txt_email_apo = $('#txt_email_apo').val();
	var comuna_apo = $('#select_comunas_e').val();
	
	
	var txt_niv_edu_apo = $('#txt_niv_edu_apo').val();
	var txt_ocupacion_apo = $('#txt_ocupacion_apo').val();
	var txt_religion_apo = $('#txt_religion_apo').val();
	var select_sistema_salud_apo = $('#select_sistema_salud_apo').val(); 
	var txt_profesion_apo = $('#txt_profesion_apo').val();
	
	
	if($("#chk_apoderado").is(':checked')){
			var chk_apoderado=1;
		}else{
			var chk_apoderado=0;
	}  
	if($("#chk_sostenedor").is(':checked')){
			var chk_sostenedor=1;
		}else{
			var chk_sostenedor=0;
	}  		
	
	var rut_alumno = $('#txt_rut_alumnoe').val();
	

	var edad_primer_parto = $('#txtEDADPRIMERPARTO').val();
	var ultimo_ano_aprobado	= $('#cmbULTIMOANO').val();
	
	var estado_civil	= $('#cmbESTADOCIVIL').val();
	var tipo_trabajo	= $('#cmbTIPOTRABAJOM').val();
	
	
	var grup=[];
	
 $('#eva_destino :selected').map(function(){
    grup.push($(this).val());
  })
	
	var region_apo = $('#select_region_apo_e').val();
	var ciudad_apo = $('#select_provincias_e').val();
	ciudad_apo  = ciudad_apo.split(",");
	ciudad_apo = ciudad_apo[0];
	
	var pais_origen_apo = ($('#pais_origen_apo').val()>0)?$('#pais_origen_apo').val():46;
	
	
		
	var funcion = 11;
	
	var parametros='funcion='+funcion+'&rut_apo='+rut_apo+'&nombre_apo='+nombre_apo+'&ape_pat_apo='+ape_pat_apo+'&ape_mat_apo='+ape_mat_apo+'&fecha_nac_apo='+fecha_nac_apo+'&sexo_apo='+sexo_apo+'&nacionalidad_apo='+nacionalidad_apo+'&txt_calle_apo='+txt_calle_apo+'&txt_nro_apo='+txt_nro_apo+'&txt_block_apo='+txt_block_apo+'&txt_depto_apo='+txt_depto_apo+'&txt_villa_apo='+txt_villa_apo+'&txt_fono_apo='+txt_fono_apo+'&txt_celular_apo='+txt_celular_apo+'&txt_email_apo='+txt_email_apo+'&comuna_apo='+comuna_apo+'&txt_niv_edu_apo='+txt_niv_edu_apo+'&txt_ocupacion_apo='+txt_ocupacion_apo+'&txt_religion_apo='+txt_religion_apo+'&select_sistema_salud_apo='+select_sistema_salud_apo+'&relacion_apo='+relacion_apo+"&chk_apoderado="+chk_apoderado+"&chk_sostenedor="+chk_sostenedor+"&rut_alumno="+rut_alumno+"&txt_profesion_apo="+txt_profesion_apo+"&edad_primer_parto="+edad_primer_parto+"&ultimo_ano_aprobado="+ultimo_ano_aprobado+"&grup="+grup+"&estado_civil="+estado_civil+"&tipo_trabajo="+tipo_trabajo+"&region_apo="+region_apo+"&ciudad_apo="+ciudad_apo+"&pais_origen_apo="+pais_origen_apo;
	
	
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
  
  function elimina_familiar()
  {
	  var funcion =14;
	  var rut_apo = $('#select_familiar').val()
	  var rut_alumno= "<?=$rut_alumno?>";
	  //alert(rut_apo);
	  //alert(rut_alumno);
	  
	  var parametros='funcion='+funcion+'&rut_apo='+rut_apo+'&rut_alumno='+rut_alumno;
	  
	  if(confirm("Con Esto Eliminara al usuario y la relacion")){
	  $.ajax({
	  url:'cont_ficha_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	// alert(data);
	  if(data==1){
		 alert("Datos Eliminados"); 
		 cargaTabs();
		  }else{
		 alert("Error al Eliminar");
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
function limpia_rut2()
{
	$('#rut_retira2').val("");
}
function limpia_rut3()
{
	$('#rut_retir3').val("");
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
 
 function formatea_rut2(rut)
{
	
  var formato_r = formato_rut2(rut)	
  
  var rut_con_formato = $('#rut_retira2').val();
 
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
		$('#rut_retira2').val("")
		return false;
			
		}
 }
 
 function formato_rut2(rut)
{
   var sRut1 = rut;
   //contador de para saber cuando insertar el . o la -
   var nPos = 0;
 
   //Guarda el rut invertido con los puntos y el guión agregado
   var sInvertido = "";
 
   //Guarda el resultado final del rut como debe ser
   var sRut = "";
 
   for(var i = sRut1.length - 1; i >= 0; i-- )
   {
        
           sInvertido += sRut1.charAt(i);
           if (i == sRut1.length - 1 )
               sInvertido += "-";
           else if (nPos == 3)
           {
               sInvertido += ".";
               nPos = 0;
           }
           nPos++;       
   }
 
   for(var j = sInvertido.length - 1; j >= 0; j-- )
   {
           if (sInvertido.charAt(sInvertido.length - 1) != ".")
                sRut += sInvertido.charAt(j);
           else if (j != sInvertido.length - 1 )
               sRut += sInvertido.charAt(j);
        
   }
   //Pasamos al campo el valor formateado
   //return sRut;
   rut_retira2.value = sRut.toUpperCase();
}
 
 function formatea_rut3(rut)
{
	
  var formato_r = formato_rut3(rut)	
  
  var rut_con_formato = $('#rut_retira3').val();
 
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
		$('#rut_retira3').val("")
		return false;
			
		}
 }
 function formato_rut3(rut)
{
   var sRut1 = rut;
   //contador de para saber cuando insertar el . o la -
   var nPos = 0;
 
   //Guarda el rut invertido con los puntos y el guión agregado
   var sInvertido = "";
 
   //Guarda el resultado final del rut como debe ser
   var sRut = "";
 
   for(var i = sRut1.length - 1; i >= 0; i-- )
   {
        
           sInvertido += sRut1.charAt(i);
           if (i == sRut1.length - 1 )
               sInvertido += "-";
           else if (nPos == 3)
           {
               sInvertido += ".";
               nPos = 0;
           }
           nPos++;       
   }
 
   for(var j = sInvertido.length - 1; j >= 0; j-- )
   {
           if (sInvertido.charAt(sInvertido.length - 1) != ".")
                sRut += sInvertido.charAt(j);
           else if (j != sInvertido.length - 1 )
               sRut += sInvertido.charAt(j);
        
   }
   //Pasamos al campo el valor formateado
   //return sRut;
   rut_retira3.value = sRut.toUpperCase();
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
		<li value="2"><a href="#familiar" onclick="cambia_titulos(2)" >Familiar</a></li>
		<!--<li value="3"><a href="#academico" onclick="cambia_titulos(3)" >Academico</a></li>-->
        <li value="5"><a href="#becas" onclick="cambia_titulos(5)" >Becas</a></li>
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
    <input type="button" class="botonXX" title="Modificar" value="Modificar" onClick="MM_openBrWindow('modifica_rut.php?ract=<?=$string;?>&amp;dact=<?=$fila['dig_rut'] ?>&amp;cu=<?=$fila_matricula['id_curso'] ?>&amp;rr=<?=$fila_matricula['bool_ar'] ?>','','toolbar=no,location=no,resizable=yes,width=500,height=300')">
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
    <td class="cuadro01"><input type="text" name="fecha_nac" id="fecha_nac" value="<?=CambioFechaDisplay($fila['fecha_nac'])?>" /></td>
    <td class="cuadro01">
    <input type="hidden" id="tipo_sexo" name="tipo_sexo" value="<?=$fila['sexo']?>" />
                         F:<input type="radio" name="sexo" id="sexo0" value="1"/>
    					 M:<input type="radio" name="sexo" id="sexo1" value="2"/></td>
                         
    <td class="cuadro01">
    					 Chilena :<input type="radio" name="nacionalidad" id="nacionalidad_2" value="2" onclick="nacio()" />
                         Extranjera :
                         <input type="radio" name="nacionalidad" id="nacionalidad_1" value="1" onclick="nacio()" />
                         
    
    <input type="hidden" name="tipo_nacionalidad" id="tipo_nacionalidad" value="<?=$fila['nacionalidad']?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Pa&iacute;s origen de Estudiante</td>
    <td class="cuadro02">Alunmo(a) Ind&iacute;gena</td>
    <td class="cuadro02">Religion</td>
    </tr>
    
    <tr>
    <td class="cuadro01">
    <?php $lista_paises = $obj_fichaAlumno->pOrigen(); ?>
    <select name="pais_origen" id="pais_origen" >
    <option value="0">Seleccione pa&iacute;s origen</option>
    <?php for($pa=0;$pa<pg_numrows($lista_paises);$pa++){
		$fila_pais = pg_fetch_array($lista_paises,$pa);
		?>
     <option value="<?php echo $fila_pais['id'] ?>" <?php echo ($fila['pais_origen']==$fila_pais['id'])?"selected":"" ?>><?php echo $fila_pais['nombre'] ?></option>
    <?php }?>
    </select>
    
    </td>
    
    <td class="cuadro01">No:<input type="radio" name="alum_ind" id="alum_ind_0" value="0" />
    					 Si:<input type="radio" name="alum_ind" id="alum_ind_1" value="1" />	
	<input type="hidden" id="tip_alum" value="<?=$fila_matricula['bool_aoi']?>" /></td>
    <td class="cuadro01"><input type="text" name="religion" id="religion" value="<? echo trim($fila['religion'])?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Procedencia del Alumno</td>
    <td class="cuadro02">Alumna Embarazada</td>
    <td class="cuadro02">Con quien vive</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="proced_alum" id="proced_alum" value="<?=$fila['c_procedencia']?>" /></td>
    <td class="cuadro01">o:
      <input type="radio" name="alum_emb" id="alum_emb_0" value="0" />
Si:
<input type="radio" name="alum_emb" id="alum_emb_1" value="1" />
<input type="hidden" id="tipo_alum_emb" value="<?=$fila_matricula['bool_ae']?>" /></td>
    <td class="cuadro01"><input type="text" name="con_quien_vive" id="con_quien_vive" value="<?=$fila['cq_vive']?>" /></td>
    </tr>
    <tr>
      <td class="cuadro02">Etnia o Pueblo Originario</td>
      <td class="cuadro02">Elecci&oacute;n</td>
      <td class="cuadro02">N&deg; Pasaporte</td>
    </tr>
    <tr>
      <td class="cuadro01">
      <?php $rs_etnia = $obj_fichaAlumno->getEtnia();?>
      <select name="txt_etnia" id="txt_etnia">
      <option value="">Seleccione</option>
      <?php for($e=0;$e<pg_numrows($rs_etnia);$e++){
		$fila_etnia = pg_fetch_array($rs_etnia,$e);
		?>
      <option value="<?php echo $fila_etnia['nombre'] ?>" <? echo trim($fila['txt_etnia'])==$fila_etnia['nombre']?"selected":""?>><?php echo $fila_etnia['nombre'] ?></option>
      <?php }?>
     
    </select></td>
      <td class="cuadro01">
        <input type="text" name="txt_eleccion" id="txt_eleccion" value="<?=$fila_matricula['txt_eleccion']?>" />
     </td>
      <td class="cuadro01">
        <input type="text" name="pasaporte" id="pasaporte" value="<? echo trim($fila['pasaporte'])?>" />
      </td>
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
    <td class="cuadro02">Celular</td>
    </tr>
    
    <tr>
    <td class="cuadro01"><input type="text" name="txt_depto" id="txt_depto" value="<?=trim($fila['depto'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_villa" id="txt_villa" value="<?=trim($fila['villa'])?>" /></td>
    <td class="cuadro01"><input type="text" name="txt_celular" id="txt_celular" value="<?=trim($fila['celular'])?>" /></td>
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
    <td class="cuadro02">Fecha matr&iacute;cula</td>
    <td class="cuadro02">N&deg; matr&iacute;cula</td>
    <td class="cuadro02">Curso</td>
    </tr>
    <tr>
    <td class="cuadro01"><input type="text" id="fecham" name="fecham" value="<? echo CambioFechaDisplay($fila_matricula['fecha']);?>" /></td>
    <td class="cuadro01"><input name="num_mat" type="text" id="num_mat" value="<? echo intval($fila_matricula['num_mat'])?>" /></td>
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
      <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2" class="cuadro01"><textarea name="motivo_r" id="motivo_r"  style="width:350px;border:1; border-collapse:collapse;"><? echo $fila_matricula['motivo_retiro'];?></textarea></td>
      <td class="cuadro01">&nbsp;</td>
    </tr>
    
    <tr>
    <td class="cuadro02">Ha repetido curso</td>
    <td class="cuadro02">Esta en tratamiento con especialista</td>
    <td class="cuadro02">Pertenece al programa de integracion escolar (PIE) </td>
    </tr>
    <tr>
    <td class="cuadro01">Si<input type="radio" name="curso_rep" id="curso_rep1" value="1" >
						 No<input type="radio" name="curso_rep" id="curso_rep0" value="0" >	
                         <input type="hidden" id="repite_curso" value="<? echo $fila_matricula['curso_rep'];?>" />
	</td>
    <td class="cuadro01">
						
	
	<input type="hidden" id="hidden_sistema_salud" value="<?=$fila_matricula['trat_especialista'];?>" />
    <select name="cmbESPEC" id="cmbESPEC">
    	<option value="0">NO</option>
        <option value="1">SI,PSICOLOGO</option>
        <option value="2">SI,PSIQUIATRA</option>
        <option value="3">SI,FONOAUDILOGO</option>
        <option value="4">SI,PSICOPEDAGOGO</option>
    </select>
    
    </td>
    <td class="cuadro01">Si<input type="radio" name="al_pie" id="al_pie1" value="1"/>
    					 No<input type="radio" name="al_pie" id="al_pie0" value="0"/>
	<input type="hidden" id="hidden_pie" value="<? echo $fila_matricula['ben_pie'];?>" /></td>
    </tr>
    
      <tr>
    <td class="cuadro02">Pertenece a subvencion preferencial (SEP)</td>
    <td class="cuadro02">Clasificado(a) con retos multiples</td>
    <td class="cuadro02">Beca Puente </td>
    </tr>
    <tr>
    <td class="cuadro01">Si<input type="radio" name="al_sep" id="al_sep1" value="1"/>
    					 No<input type="radio" name="al_sep" id="al_sep0" value="0"/>
	<input type="hidden" id="hidden_sep" value="<? echo $fila_matricula['ben_sep'];?>" />
	</td>
    <td class="cuadro01">Si<input type="radio" name="al_retos" id="al_retos1" value="1"/>
    					 No<input type="radio" name="al_retos" id="al_retos0" value="0" />
	<input type="hidden" id="hidden_retos" value="<? echo $fila_matricula['bool_retos'];?>" />
	</td>
    
    <td class="cuadro01">Si<input type="radio" name="al_puente" id="al_puente1" value="1" />
    					 No<input type="radio" name="al_puente" id="al_puente0" value="0" />
	<input type="hidden" id="hidden_puente" value="<? echo $fila_matricula['ben_puente'];?>" />
	
	</td>
    </tr>
    
    <tr>
    <td class="cuadro02">Financiamiento compartido</td>
    <td class="cuadro02">Presenta sanci&oacute;n</td>
    <td class="cuadro02">Condicionalidad</td>
    </tr>
    <tr>
    <td class="cuadro01">Si<input type="radio" name="al_fc" id="al_fc1" value="1" />
    					 No<input type="radio" name="al_fc" id="al_fc0" value="0" />
	<input type="hidden" id="hidden_fc" value="<? echo $fila_matricula['bool_fci'];?>" />
	
	</td>
    <td class="cuadro01">
	 <select name="cmbSANCION" id="cmbSANCION">
    	<option value="0">NO</option>
        <option value="1">SI, DISCIPLINA</option>
        <option value="2">SI, RENDIMIENTO</option>
    </select>
	<input type="hidden" id="hidden_sancion" value="<? echo $fila_matricula['sancion'];?>"/>
    </td>
    <td class="cuadro01"><select name="cmb_condicional" id="cmb_condicional">
    <option value="0" selected>Seleccione</option>
    <option value="1" >Rendimiento</option>
    <option value="2" >Diciplina</option>
    <option value="3" >Otro</option>
    <option value="4" >Observaciones</option>
</select>
<input type="hidden" id="hidden_condicionalidad" value="<? echo $fila_matricula['condicionalidad'];?>"/>
</td>
    </tr>
    
    <tr>
    <td class="cuadro02">Religion</td>
    <td class="cuadro02">Ev. Diferencial</td>
    <td class="cuadro02">Integrado</td>
    </tr>
    <tr>
    <td class="cuadro01">Si<input type="radio" name="opta_religion" id="opta_religion1" value="1" />
    					 No<input type="radio" name="opta_religion" id="opta_religion0" value="0" />
	<input type="hidden" id="hidden_opta_religion" value="<? echo $fila_matricula['bool_rg'];?>" />
	
	</td>
    <td class="cuadro01">Si<input type="radio" name="ed_diferencial" id="ed_diferencial1" value="1" />
    					 No<input type="radio" name="ed_diferencial" id="ed_diferencial0" value="0" />
	<input type="hidden" id="hidden_ed_diferencial" value="<? echo $fila_matricula['bool_ed'];?>" />
	</td>
    <td class="cuadro01">Si<input type="radio" name="al_integrado" id="al_integrado1" value="1" />
    					 No<input type="radio" name="al_integrado" id="al_integrado0" value="0" />
	<input type="hidden" id="hidden_al_integrado" value="<? echo $fila_matricula['bool_i'];?>" />
	</td>
    </tr>
      <tr>
      <td class="cuadro02">Estilo de aprendizaje</td>
      <td class="cuadro02">Encargado Matr&iacute;cula</td>
      <td class="cuadro02">Grupo diferencial</td>
    </tr>
    <tr>
      <td class="cuadro01">
      <select name="estilo_aprendizaje" id="estilo_aprendizaje">
      <option value="0" selected>Seleccione</option>
      <?php 
	  $rs_estilo = $obj_fichaAlumno->estilo_aprendizaje_todos();
	  for($es=0;$es<pg_numrows($rs_estilo);$es++){
		  $fila_estilo = pg_fetch_array($rs_estilo,$es);
	  ?>
        <option value="<?php echo $fila_estilo['id_estilo'] ?>" <?php echo ($fila_matricula['estilo_aprendizaje']==$fila_estilo['id_estilo'])?"selected":"" ?>><?php echo $fila_estilo['nombre'] ?></option>
      <?php }?>
      </select></td>
      <td class="cuadro01">
      
      <select name="cmbENCMATRICULA" id="cmbENCMATRICULA">
    <option value="0">Seleccione</option>
    <?php for($ft=0;$ft<pg_numrows($rs_trabaja);$ft++){
		$fila_trabaja = pg_fetch_array($rs_trabaja,$ft);
		?>
    <option value="<?php echo $fila_trabaja['rut_emp'] ?>"  <?php echo ($fila_trabaja['rut_emp']==$fila_matricula['enc_matricula'])?"selected":""; ?>><?php echo $fila_trabaja['ape_pat'] ?> <?php echo $fila_trabaja['ape_mat'] ?>, <?php echo $fila_trabaja['nombre_emp'] ?></option>
    <?php }?>
    </select></td>
      <td class="cuadro01"><input name="bool_gdiferencial" type="radio" id="bool_gdiferencial0" <? echo ($fila_matricula['bool_gdiferencial']==0)?"checked":"";?> value="0" />
NO
  <input type="radio" name="bool_gdiferencial" id="bool_gdiferencial1" value="1" <? echo ($fila_matricula['bool_gdiferencial']==1)?"checked":"";?> />
SI </td>
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
    <td class="cuadro02">Sufre alguna enfermedad</td>
    <td class="cuadro02">Ha sido sometido(a) a cirugia</td>
    <td class="cuadro02">Toma algun Medicamento Periodicamente </td>
    </tr>
    <tr>
    <td class="cuadro01">
	<input name="ENFERMEDAD" type="radio" id="enfermedad0" onClick="limpia(this.name)" value="0" checked>NO 
    <input type="radio" name="ENFERMEDAD" id="enfermedad1" value="1" onClick="limpia(this.name)">SI&nbsp;&nbsp;&nbsp;
    <input type="text" name="txtENFERMEDAD" id="txtENFERMEDAD" disabled >
	<input type="hidden" id="hidden_enfermedad" value="<? echo $fila_matricula['enfermedad'];?>" />
    
    </td>
    <td class="cuadro01">
	<input type="radio" name="CIRUGIA" id="cirugia0" onClick="limpia(this.name)" value="0" /> NO
    <input type="radio" name="CIRUGIA" id="cirugia1" onClick="limpia(this.name)" value="1" /> SI&nbsp;&nbsp;&nbsp;
    <input type="text" name="txtCIRUGIA" id="txtCIRUGIA" disabled >	
	<input type="hidden" id="hidden_cirugia" value="<? echo $fila_matricula['cirugia'];?>" /></td>
    
    <td class="cuadro01">
	<input type="radio" name="MEDICAMENTO" id="medicamento0" onClick="limpia(this.name)" value="0" />NO
   	<input type="radio" name="MEDICAMENTO" id="medicamento1" onClick="limpia(this.name)" value="1" />SI&nbsp;&nbsp;&nbsp;
    <input type="text" name="txtMEDICAMENTO" id="txtMEDICAMENTO" disabled="disabled" />
	<input type="hidden" id="hidden_medicamento" value="<? echo $fila_matricula['medicamento'];?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">presenta alguna alergia</td>
    <td class="cuadro02">Tiene Impedimentos para realizar Educacion Fisica</td>
    <td class="cuadro02">Puede tomar algun medicamento</td>
    </tr>
    <tr>
    <td class="cuadro01">
    <input type="radio" name="ALERGIA" id="alergia0" onClick="limpia(this.name)" value="0" />NO
   	<input type="radio" name="ALERGIA" id="alergia1" onClick="limpia(this.name)" value="1" />SI&nbsp;&nbsp;&nbsp;
    <input type="text" name="txtMALERGIA" id="txtALERGIA" disabled="disabled" />
	<input type="hidden" id="hidden_alergia" value="<? echo $fila_matricula['alergia'];?>" />
	</td>
    
    <td class="cuadro01">
	<input type="radio" name="FISICA" id="fisica0" onClick="limpia(this.name)" value="0" />NO
   	<input type="radio" name="FISICA" id="fisica1" onClick="limpia(this.name)" value="1" />SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" name="txtFISICA" id="txtFISICA" disabled="disabled" />
	<input type="hidden" id="hidden_fisica" value="<? echo $fila_matricula['fisica'];?>" />
	
	</td>
    <td class="cuadro01">
	<input type="radio" name="FIEBRE" id="fiebre0" onClick="limpia(this.name)" value="0" />NO
   	<input type="radio" name="FIEBRE" id="fiebre1" onClick="limpia(this.name)" value="1" />SI&nbsp;&nbsp;&nbsp;
    <input type="text" name="txtFIEBRE" id="txtFIEBRE" disabled="disabled" />
	<input type="hidden" id="hidden_fiebre" value="<? echo $fila_matricula['fiebre'];?>" />
	
	</td>
    </tr>
    
    <tr>
    <td class="cuadro02">Cuenta con algun seguro distinto al escolar</td>
    <td class="cuadro02">Tipo de Parto</td>
    <td class="cuadro02">Edad madre al momento del parto (alumno)</td>
    </tr>
    <tr>
    <td class="cuadro01">
	<input type="radio" name="SEGURO" id="seguro0" onClick="limpia(this.name)" value="0" />NO
   	<input type="radio" name="SEGURO" id="seguro1" onClick="limpia(this.name)" value="1" />SI&nbsp;&nbsp;&nbsp;
    <input type="text" name="txtSEGURO" id="txtSEGURO" disabled="disabled" />
	<input type="hidden" id="hidden_seguro" value="<? echo $fila_matricula['seguro'];?>" />
	
	</td>
    <td class="cuadro01"><select name="cmbTIPOPARTO" id="cmbTIPOPARTO" >
      <option value="0">Seleccione</option>
      <option value="1" <?php if($fila['tipo_parto']==1)echo "selected";?>>NORMAL</option>
      <option value="2"  <?php if($fila['tipo_parto']==2)echo "selected";?>>CESAREA</option>
    </select></td>
    <td class="cuadro01"><input type="text" name="edad_madre_nace" id="edad_madre_nace" value="<?php echo $fila['edad_madre_nace'] ?>" /></td>
    </tr>
    <tr>
      <td class="cuadro02">Peso al nacer</td>
      <td class="cuadro02">Talla al nacer</td>
      <td class="cuadro02">Sistema de salud</td>
    </tr>
    <tr>
      <td class="cuadro01"><input type="text" name="peso_nace" id="peso_nace" value="<?php echo $fila['peso_nace'] ?>" /></td>
      <td class="cuadro01"><input type="text" name="talla_nace" id="talla_nace" value="<?php echo $fila['talla_nace'] ?>" /></td>
      <td class="cuadro01"><select name="cmbSALUDP2" id="cmbSALUDP2" style="text-transform:uppercase">
        <option value="0">SELECCIONE...</option>
        <?php  for($i=0;$i<pg_numrows($regis_sis_salud);$i++){
		 $fila_salud=pg_fetch_array($regis_sis_salud,$i);
		 ?>
        <option value="<?php echo $fila_salud['id_sistema_salud'] ?>" <?php if($fila['s_salud']==$fila_salud['id_sistema_salud'])echo "selected";?> ><?php echo $fila_salud['sistema_salud'] ?></option>
        <?php }?>
      </select></td>
    </tr>
    <tr>
      <td class="cuadro02">Presenta problemas dentales</td>
      <td class="cuadro02">Se encuentra en control Dental</td>
      <td class="cuadro02">Fecha ultimo control sano</td>
    </tr>
    <tr>
      <td class="cuadro01"><input name="probdentales" type="radio" id="probdentales0"  value="0" />
NO
  <input type="radio" name="probdentales" id="probdentales1" value="1" />
SI 
<input name="hidden_pdentales" type="hidden" id="hidden_pdentales" value="<? echo $fila_matricula['bool_pdentales'];?>" /></td>
      <td class="cuadro01"><input name="CONTROLDENTAL" type="radio" id="CONTROLDENTAL0" onclick="limpia(this.name)" value="0" />
NO
  <input type="radio" name="CONTROLDENTAL" id="CONTROLDENTAL1" value="1" />
SI 
<input name="hidden_controldental" type="hidden" id="hidden_controldental" value="<? echo $fila_matricula['bool_controldental'];?>" /></td>
      <td class="cuadro01"><input type="text" name="txtCONTROLSANO" id="txtCONTROLSANO" value="<? echo $fila_matricula['controlsano'];?>" /> </td>
    </tr>
    <tr>
      <td class="cuadro02">familiares con problemas de salud o discapacidad diagnosticada</td>
      <td class="cuadro02">Ha estado en tratamiento neurol&oacute;gico</td>
      <td class="cuadro02">Ha estado en tratamiento con psicopedagogo</td>
    </tr>
    <tr>
      <td class="cuadro01"><input name="FAMILIARENFERMO" type="radio" id="FAMILIARENFERMO0" onclick="limpia(this.name)" value="0" />
NO
  <input type="radio" name="FAMILIARENFERMO" id="FAMILIARENFERMO1" value="1" onclick="limpia(this.name)" />
SI 
<input name="hidden_famenfermo" type="hidden" id="hidden_famenfermo" value="<? echo $fila_matricula['bool_famenfermo'];?>" /></td>
      <td class="cuadro01"><input name="hidden_neurologo" type="hidden" id="hidden_neurologo" value="<? echo $fila_matricula['bool_neurologo'];?>" />
        <input name="bool_neurologo" type="radio" id="bool_neurologo0" onclick="limpia(this.name)" value="0" />
NO
<input type="radio" name="bool_neurologo" id="bool_neurologo1" value="1" onclick="limpia(this.name)" />
SI </td>
      <td class="cuadro01"><input name="hidden_psicopedagogo" type="hidden" id="hidden_psicopedagogo" value="<? echo $fila_matricula['bool_psicopedagogo'];?>" />
        <input name="bool_psicopedagogo" type="radio" id="bool_psicopedagogo0" onclick="limpia(this.name)" value="0" />
NO
<input type="radio" name="bool_psicopedagogo" id="bool_psicopedagogo1" value="1" onclick="limpia(this.name)" />
SI </td>
    </tr>
     <tr>
      <td class="cuadro02">hHa estado en tratamiento psicol&oacute;gico</td>
      <td class="cuadro02">Ha estado en otra clase de tratamientos</td>
      <td class="cuadro02">En la actualidad se encuentra en tratamiento</td>
    </tr>
    <tr>
      <td class="cuadro01"><input name="hidden_psicologo" type="hidden" id="hidden_psicologo" value="<? echo $fila_matricula['bool_psicologo'];?>" />
        <input name="bool_psicologo" type="radio" id="bool_psicologo0" onclick="limpia(this.name)" value="0" checked="CHECKED" />
NO
<input type="radio" name="bool_psicologo" id="bool_psicologo1" value="1" onclick="limpia(this.name)" />
SI </td>
      <td class="cuadro01"><input name="hidden_otrotratamiento" type="hidden" id="hidden_otrotratamiento" value="<? echo $fila_matricula['bool_otratamiento'];?>" />
        <input name="bool_otratamiento" type="radio" id="bool_otrotratamiento0" onclick="limpia(this.name)" value="0" />
NO
<input type="radio" name="bool_otratamiento" id="bool_otrotratamiento1" value="1" onclick="limpia(this.name)" />
SI 
<input type="text" name="txt_otratamiendo" id="txt_otratamiendo"  value="<? echo $fila_matricula['txt_otratamiendo'];?>"/></td>
      <td class="cuadro01"><input name="hidden_tratactual" type="hidden" id="hidden_tratactual" value="<? echo $fila_matricula['bool_tratactual'];?>" />
        <input name="bool_tratactual" type="radio" id="bool_tratactual0" onclick="limpia(this.name)" value="0" />
NO
<input type="radio" name="bool_tratactual" id="bool_tratactual1" value="1" onclick="limpia(this.name)" />
SI 
<input type="text" name="txt_tratactual" id="txt_tratactual" value="<? echo $fila_matricula['txt_tratactual'];?>" /></td>
    </tr>
    	 <tr>
      <td class="cuadro02">Posee antedecentes de trastornos de aprendizaje, d&eacute;ficit atencional, otros</td>
      <td class="cuadro02">Ha estado en tratamiento psiqui&aacute;trico</td>
      <td class="cuadro02">Ha estado en tratamiento con fonoaud&oacute;logo</td>
    </tr>
    <tr>
      <td class="cuadro01"><input name="hidden_trastornoaprendizaje" type="hidden" id="hidden_trastornoaprendizaje" value="<? echo $fila_matricula['bool_tastornosaprendizaje'];?>" />
        <input name="bool_tastornosaprendizaje" type="radio" id="bool_tastornosaprendizaje0" onclick="limpia(this.name)" value="0" checked="checked" />
NO
<input type="radio" name="bool_tastornosaprendizaje" id="bool_tastornosaprendizaje1" value="1" onclick="limpia(this.name)" />
SI 
<input type="text" name="txt_trastornosaprendizaje" id="txt_trastornosaprendizaje" value="<? echo $fila_matricula['txt_tastornosaprendizaje'];?>" /></td>
      <td class="cuadro01"><input name="bool_psiquiatra" type="radio" id="bool_psiquiatra0" value="0" <? echo ($fila_matricula['bool_psiquiatra']==0)?"checked":"";?> />
NO
  <input type="radio" name="bool_psiquiatra" id="bool_psiquiatra1" value="1" <? echo ($fila_matricula['bool_psiquiatra']==1)?"checked":"";?> />
SI </td>
      <td class="cuadro01"><input name="bool_fonoaudiologo" type="radio" id="bool_fonoaudiologo0" value="0" <? echo ($fila_matricula['bool_fonoaudiologo']==0)?"checked":"";?> />
NO
  <input type="radio" name="bool_fonoaudiologo" id="bool_fonoaudiologo1" value="1" <? echo ($fila_matricula['bool_fonoaudiologo']==1)?"checked":"";?> />
SI </td>
    </tr>
   <tr>
      <td class="cuadro02">Presenta problemas de visi&oacute;n</td>
      <td class="cuadro02">Presenta problemas de audici&oacute;n</td>
      <td class="cuadro02">Presenta problemas a la columna</td>
    </tr>
    <tr>
      <td class="cuadro01"><input name="bool_pvision" type="radio" id="bool_pvision0" <? echo ($fila_matricula['bool_pvision']==0)?"checked":"";?> value="0" />
NO
  <input type="radio" name="bool_pvision" id="bool_pvision1" value="1" <? echo ($fila_matricula['bool_pvision']==1)?"checked":"";?> />
SI </td>
      <td class="cuadro01"><input name="bool_paudicion" type="radio" id="bool_paudicion0" <? echo ($fila_matricula['bool_paudicion']==0)?"checked":"";?> value="0"  />
NO
  <input type="radio" name="bool_paudicion" id="bool_paudicion1" value="1" <? echo ($fila_matricula['bool_paudicion']==1)?"checked":"";?> />
SI</td>
      <td class="cuadro01"><input name="bool_pcolumna" type="radio" id="bool_pcolumna0" <? echo ($fila_matricula['bool_pcolumna']==0)?"checked":"";?> value="0" />
NO
  <input type="radio" name="bool_pcolumna" id="bool_pcolumna" value="1" <? echo ($fila_matricula['bool_pcolumna']==1)?"checked":"";?> />
SI </td>
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
    <td class="cuadro02">Jefe de Hogar</td>
    <td class="cuadro02">Ocupaci&oacute;n Jefe de Hogar</td>
    <td class="cuadro02">Integrantes grupo familiar</td>
    </tr>
    <tr>
    <td class="cuadro01"><input type="text" name="jefe_hogar" id="jefe_hogar" value="<?php echo $fila_matricula['jefe_hogar'] ?>" /></td>
    <td class="cuadro01"><input type="text" name="ocup_jefehogar" id="ocup_jefehogar" value="<?php echo $fila_matricula['ocup_jefehogar'] ?>" /></td>
    <td class="cuadro01"><input type="text" name="num_grupofamiliar" id="num_grupofamiliar" value="<?php echo $fila_matricula['num_grupofamiliar'] ?>" class="solo-numero" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Total Ingresos</td>
    <td class="cuadro02">Tipo de Vivienda</td>
    <td class="cuadro02">Cantidad Dormitorios</td>
    </tr>
    <tr>
    <td class="cuadro01"><input type="text" name="ingresos" id="ingresos" value="<?php echo $fila_matricula['ingresos'] ?>" class="solo-numero" /></td>
    <td class="cuadro01"><select name="cmbTIPOVIVIENDA" id="cmbTIPOVIVIENDA">
      <option value="0">SELECCIONE...</option>
      <option value="1" <?php if($fila_matricula['tipo_vivienda']==1)echo "selected";?>>PROPIA</option>
      <option value="2" <?php if($fila_matricula['tipo_vivienda']==2)echo "selected";?>>ARRENDADA</option>
      <option value="3" <?php if($fila_matricula['tipo_vivienda']==3)echo "selected";?>>ALLEGADOS</option>
    </select></td>
    <td class="cuadro01"><input type="text" name="cant_dormitorios" id="cant_dormitorios" value="<?php echo $fila_matricula['cant_dormitorios'] ?>"  class="solo-numero"/></td>
    </tr>
    <tr>
      <td class="cuadro02">Material vivienda</td>
      <td class="cuadro02">Estado vivienda</td>
      <td class="cuadro02">Vivienda tiene luz</td>
    </tr>
    <tr>
      <td class="cuadro01"><input type="text" name="material_vivienda" id="material_vivienda" value="<?php echo $fila_matricula['material_vivienda'] ?>" /></td>
      <td class="cuadro01"><input type="text" name="estado_vivienda" id="estado_vivienda" value="<?php echo $fila_matricula['estado_vivienda'] ?>" /></td>
      <td class="cuadro01">
<input name="bool_tieneluz" type="radio" id="bool_tieneluz0" onclick="limpia(this.name)" value="0" />
NO
  
  
<input type="radio" name="bool_tieneluz" id="bool_tieneluz1" value="1" />
SI
<input name="hidden_tieneluz" type="hidden" id="hidden_tieneluz" value="<? echo $fila_matricula['bool_controldental'];?>" /></td>
    </tr>
     <tr>
      <td class="cuadro02">vivienda tiene agua</td>
      <td class="cuadro02">Vivienda tiene alcantarillado</td>
      <td class="cuadro02">Subsidio &uacute;nico</td>
    </tr>
    <tr>
      <td class="cuadro01"><input name="bool_tieneagua" type="radio" id="bool_tieneagua0" onclick="limpia(this.name)" value="0" />NO
<input type="radio" name="bool_tieneagua" id="bool_tieneagua1" value="1" />SI

<input name="hidden_tieneagua" type="hidden" id="hidden_tieneluz2" value="<? echo $fila_matricula['bool_controldental'];?>" /></td>
      <td class="cuadro01"><input name="bool_tienealcantarillado" type="radio" id="bool_tienealcantarillado0" onclick="limpia(this.name)" value="0" />
        NO
          <input type="radio" name="bool_tienealcantarillado" id="bool_tienealcantarillado1" value="1" />
          SI
          <input name="hidden_tienealcantarillado" type="hidden" id="hidden_alcantarillado" value="<? echo $fila_matricula['bool_tienealcantarillado'];?>" /></td>
      <td class="cuadro01">
        <input type="text" name="txt_subsidio" id="txt_subsidio"  value="<? echo $fila_matricula['txt_subsidio'];?>"/>
     </td>
    </tr>
    <tr>
    <td class="cuadro02">Cantidad Ba&ntilde;os</td>
     
    <td class="cuadro02">Tiene Espacio para Jugar</td>
    <td class="cuadro02">Tiene Espacio para Estudiar</td>
    </tr>
    <tr>
    <td class="cuadro01"><input type="text" name="cant_banos" id="cant_banos" value="<?php echo $fila_matricula['cant_banos'] ?>" /></td>
    <td class="cuadro01"><input name="espacio_juego" type="radio" id="espacio_juego0" value="0" checked="checked" />
NO
  <input type="radio" name="espacio_juego" id="espacio_juego1" value="1" />
SI
<input name="hidden_espaciojuego" type="hidden" id="hidden_espaciojuego" value="<? echo $fila_matricula['bool_espacio_juego'];?>" /></td>
    <td class="cuadro01"><input name="espacio_estudio" type="radio" id="espacio_estudio0" value="0" checked="checked" />
NO
  <input type="radio" name="espacio_estudio" id="espacio_estudio1" value="1" />
SI
<input name="hidden_espacioestudio" type="hidden" id="hidden_espacioestudio" value="<? echo $fila_matricula['bool_espacio_estudio'];?>" /></td>
    </tr>
    <tr>
      <td class="cuadro02">Figura Paterna</td>
      <td class="cuadro02">Aporta dinero al hogar</td>
      <td class="cuadro02">Hizo Jardin / Prekinder</td>
    </tr>
    <tr>
      <td class="cuadro01"><input type="text" name="figura_paterna" id="figura_paterna" value="<?php echo $fila_matricula['figura_paterna'] ?>" /></td>
      <td class="cuadro01"><input name="jefe_aporta" type="radio" id="jefe_aporta0" value="0" checked="checked" />
NO
  <input type="radio" name="jefe_aporta" id="jefe_aporta1" value="1" />
SI
<input name="hidden_jefeaporta" type="hidden" id="hidden_jefeaporta" value="<? echo $fila_matricula['bool_aporta_figura_paterna'];?>" /></td>
      <td class="cuadro01"><input name="hizo_jardin" type="radio" id="hizo_jardin0" value="0" checked="checked" />
NO
  <input type="radio" name="hizo_jardin" id="hizo_jardin1" value="1" />
SI
<input name="hidden_hizojardin" type="hidden" id="hidden_hizojardin" value="<? echo $fila_matricula['bool_hizo_jardin'];?>" /></td>
    </tr>
    <tr>
      <td class="cuadro02">Cuan Cari&ntilde;oso es</td>
      <td class="cuadro02">Cuan sociable es</td>
      <td class="cuadro02">Cuan curioso es</td>
    </tr>
    <tr>
      <td class="cuadro01"><select name="cmbCARINOSO" id="cmbCARINOSO">
        <option value="0">SELECCIONE...</option>
        <option value="1" <?php if($fila_matricula['carinoso']==1)echo "selected";?>>SIEMPRE</option>
        <option value="2" <?php if($fila_matricula['carinoso']==2)echo "selected";?>>FRECUENTEMENTE</option>
        <option value="3" <?php if($fila_matricula['carinoso']==3)echo "selected";?>>RARAS  VECES</option>
        <option value="4" <?php if($fila_matricula['carinoso']==4)echo "selected";?>>CASI NUNCA</option>
        <option value="5" <?php if($fila_matricula['carinoso']==1)echo "selected";?>>NUNCA</option>
      </select></td>
      <td class="cuadro01"><select name="cmbSOCIABLE" id="cmbSOCIABLE">
        <option value="0">SELECCIONE...</option>
        <option value="1" <?php if($fila_matricula['sociable']==1)echo "selected";?>>SIEMPRE</option>
        <option value="2"  <?php if($fila_matricula['sociable']==2)echo "selected";?>>FRECUENTEMENTE</option>
        <option value="3"  <?php if($fila_matricula['sociable']==3)echo "selected";?>>RARAS  VECES</option>
        <option value="4"  <?php if($fila_matricula['sociable']==4)echo "selected";?>>CASI NUNCA</option>
        <option value="5"  <?php if($fila_matricula['sociable']==5)echo "selected";?>>NUNCA</option>
      </select></td>
      <td class="cuadro01"><select name="cmbCURIOSO" id="cmbCURIOSO">
        <option value="0">SELECCIONE...</option>
        <option value="1"  <?php if($fila_matricula['curioso']==1)echo "selected";?>>SIEMPRE</option>
        <option value="2" <?php if($fila_matricula['curioso']==2)echo "selected";?>>FRECUENTEMENTE</option>
        <option value="3" <?php if($fila_matricula['curioso']==3)echo "selected";?>>RARAS  VECES</option>
        <option value="4" <?php if($fila_matricula['curioso']==4)echo "selected";?>>CASI NUNCA</option>
        <option value="5" <?php if($fila_matricula['curioso']==5)echo "selected";?>>NUNCA</option>
      </select></td>
    </tr>
    <tr>
      <td class="cuadro02">Organizaciones en que Participa</td>
      <td class="cuadro02">Con quien estudia</td>
      <td class="cuadro02">N&uacute;mero de hermanos</td>
    </tr>
    <tr>
      <td class="cuadro01"><input type="text" name="org_participa" id="org_participa" value="<?php echo $fila_matricula['org_participa'] ?>" /></td>
      <td class="cuadro01"><input type="text" name="con_quien_estudia" id="con_quien_estudia" value="<?php echo $fila_matricula['con_quien_estudia'] ?>" /></td>
      <td class="cuadro01"><input name="cant_hermanos" type="text" id="cant_hermanos" value="<?php echo $fila['cant_hermanos'] ?>" size="3" class="solo-numero" /></td>
    </tr>
      <td class="cuadro02">Num. Causa Juzgado Familia</td>
      <td class="cuadro02">Num. Ficha Protecci&oacute;n social</td>
      <td class="cuadro02">Beneficios programa social</td>
    </tr>
    <tr>
      <td class="cuadro01">
        <input name="txt_causajuzgado" type="text" id="txt_causajuzgado" value="<?php echo $fila_matricula['txt_causajuzgado'] ?>" /></td>
      <td class="cuadro01">
        <input name="txt_fichaps" type="text" id="txt_fichaps" value="<?php echo $fila_matricula['txt_fichaps'] ?>" /></td>
      <td class="cuadro01">
        <input name="ben_prog_prot_social" type="text" id="ben_prog_prot_social" value="<?php echo $fila_matricula['ben_prog_prot_social'] ?>" /></td>
    </tr>
     <tr>
      <td class="cuadro02">Lugar que ocupa entre los hermanos (n&uacute;mero)</td>
      <td colspan="2" class="cuadro02">Sacramentos recibidos</td>
      </tr>
    <tr>
      <td class="cuadro01"><input name="num_hermano" type="text" id="num_hermano" value="<?php echo $fila['num_hermano'] ?>" size="3" class="solo-numero" /></td>
      <td colspan="2" class="cuadro01"><input name="bool_bautismo" type="checkbox" id="bool_bautismo" value="1"  <? echo ($fila['bool_bautismo']==1)?"checked":"";?>>
     Bautismo 
       <input name="bool_pcomunion" type="checkbox" id="bool_pcomunion" value="1"  <? echo ($fila['bool_pcomunion']==1)?"checked":"";?>>
P. Comuni&oacute;n
<input name="bool_confirmacion" type="checkbox" id="bool_confirmacion" value="1"  <? echo ($fila['bool_confirmacion']==1)?"checked":"";?>>
Confirmaci&oacute;n</td>
      </tr>
     <tr>
       <td class="cuadro02" colspan="3">Practica alg&uacute;n deporte</td>
       </tr>
     <tr>
       <td class="cuadro01" colspan="3"><input name="hidden_bool_deporte" type="hidden" id="hidden_bool_deporte" value="<? echo $fila['bool_deporte'];?>" />
         <input name="bool_deporte" type="radio" id="bool_deporte1" onclick="document.getElementById('txt_deporte').value=''" value="0" <? echo ($fila['bool_deporte']==0)?"checked":"";?> />
NO
<input type="radio" name="bool_deporte" id="bool_deporte0" value="1" onclick="limpia(this.name)"  <? echo ($fila['bool_deporte']==1)?"checked":"";?> />
SI
<input type="text" name="txt_deporte" id="txt_deporte" value="<? echo $fila['txt_deporte'];?>" /></td>
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
    <TR>
    <TD colspan="7"><div id="titulo" class="tableindex">EMERGENCIAS Y RETIROS</div>
    </TD>
    </TR>
    
    <tr>
    <td colspan="3" class="cuadro02">Autoriza al Establecimiento a sacar a su pupilo en caso de emergencia de salud</td>
   
    </tr>
    <tr>
    <td width="34%" class="cuadro01">Si<input type="radio" name="aut_emergencia" id="aut_emergencia1" value="1" />
    					             No<input type="radio" name="aut_emergencia" id="aut_emergencia0" value="0" />
	<input type="hidden" id="hidden_aut_emergencia" value="<? echo $fila_matricula['autoriza_emergencia'];?>" />
	</td>
    <td width="31%" class="cuadro01">&nbsp;</td>
    <td width="35%" class="cuadro01">&nbsp;</td>
    </tr>
     <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
    <tr class="tablatit2-1" >
    <td  colspan="3">
    PERSONAS AUTORIZADAS PARA RETIRAR EL ALUMNO, EN CASO DE NO SER LOS PADRES O APODERADOS
    </td>
    </tr>
    <tr>
      <td colspan="3" class="cuadro02">Persona Autorizada n&deg;1</td>
      </tr>
    <tr>
    <td class="cuadro02">Rut (Sin gui&oacute;n)</td>
    <td class="cuadro02">Nombre</td>
    <td class="cuadro02">Parentesco</td>
    </tr>
    <tr>
    <td class="cuadro01">
      <input type="text" id="rut_retira" name="rut_retira" maxlength="9"  onclick="limpia_rut()" onblur="formatea_rut(this.value)" value="<?
	if($fila_matricula['rut_retira']=="-"){
		echo trim($fila_matricula['rut_retira']="");
		}elseif($fila_matricula['rut_retira']==""){
			echo "";
		}else{
	
	$separarut=explode('-',$fila_matricula['rut_retira']); 
	 $separarut[0];
	 $separarut[1];
	$rut_puntos=number_format($separarut[0],0, '', '.');
	echo $rutformateado = trim($rut_puntos.'-'.$separarut[1]);
	//echo $fila_matricula['rut_retira'];
		}
	
	?>" />
   </td>
    <td class="cuadro01">
	<input type="text" name="nombre_retira" id="nombre_retira" value="<? echo $fila_matricula['nombre_retira'];?>" /></td>
    <td class="cuadro01">
	<input type="text" name="parentesco_retira" id="parentesco_retira" value="<? echo $fila_matricula['parentesco_retira'];?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Telefono</td>
    <td class="cuadro02">Celular</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
    <td class="cuadro01">
	<input type="text" name="telefono_retira" id="telefono_retira" value="<? echo $fila_matricula['fono_retira'];?>" /></td>
    <td class="cuadro01">
	<input type="text" name="cel_retira" id="cel_retira" value="<? echo $fila_matricula['celular_retira'];?>" /></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3" class="cuadro01">&nbsp;</td>
      </tr>
      <tr>
      <td colspan="3" class="cuadro02">Persona Autorizada n&deg;2</td>
      </tr>
    <tr>
    <td class="cuadro02">Rut</td>
    <td class="cuadro02">Nombre</td>
    <td class="cuadro02">Parentesco</td>
    </tr>
    <tr>
    <td class="cuadro01"><input type="text" id="rut_retira2" name="rut_retira2" maxlength="9" onblur="formatea_rut2(this.value)"  onclick="limpia_rut2()" value="<?
	if($fila_matricula['rut_retira2']=="-"){
		echo trim($fila_matricula['rut_retira2']="");
		}elseif($fila_matricula['rut_retira2']==""){
			echo "";
		}else{
	
	$separarut=explode('-',$fila_matricula['rut_retira2']); 
	 $separarut[0];
	 $separarut[1];
	$rut_puntos=number_format($separarut[0],0, '', '.');
	echo $rutformateado = trim($rut_puntos.'-'.$separarut[1]);
	//echo $fila_matricula['rut_retira2'];
		}
	
	?>" /></td>
    <td class="cuadro01"><input type="text" name="nombre_retira2" id="nombre_retira2" value="<? echo $fila_matricula['nombre_retira2'];?>" /></td>
    <td class="cuadro01"><input type="text" name="parentesco_retira2" id="parentesco_retira2" value="<? echo $fila_matricula['parentesco_retira2'];?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Telefono</td>
    <td class="cuadro02">Celular</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
    <td class="cuadro01"><input type="text" name="telefono_retira2" id="telefono_retira2" value="<? echo $fila_matricula['fono_retira2'];?>" /></td>
    <td class="cuadro01">
      <input type="text" name="cel_retira2" id="cel_retira2" value="<? echo $fila_matricula['celular_retira2'];?>" /></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="3" class="cuadro01">&nbsp;</td>
      </tr>
      <tr>
      <td colspan="3" class="cuadro02">Persona Autorizada n&deg;3</td>
      </tr>
    <tr>
    <td class="cuadro02">Rut</td>
    <td class="cuadro02">Nombre</td>
    <td class="cuadro02">Parentesco</td>
    </tr>
    <tr>
    <td class="cuadro01"><input type="text" id="rut_retira3" name="rut_retira3" maxlength="9" onblur="formatea_rut3(this.value)"  onclick="limpia_rut3()" value="<?
	if($fila_matricula['rut_retira3']=="-"){
		echo trim($fila_matricula['rut_retira3']="");
		}elseif($fila_matricula['rut_retira3']==""){
			echo "";
		}else{
	
	$separarut=explode('-',$fila_matricula['rut_retira3']); 
	 $separarut[0];
	 $separarut[1];
	$rut_puntos=number_format($separarut[0],0, '', '.');
	echo $rutformateado = trim($rut_puntos.'-'.$separarut[1]);
	//echo $fila_matricula['rut_retira3'];
		}
	
	?>" /></td>
    <td class="cuadro01"><input type="text" name="nombre_retira3" id="nombre_retira3" value="<? echo $fila_matricula['nombre_retira3'];?>" /></td>
    <td class="cuadro01"><input type="text" name="parentesco_retira3" id="parentesco_retira3" value="<? echo $fila_matricula['parentesco_retira3'];?>" /></td>
    </tr>
    
    <tr>
    <td class="cuadro02">Telefono</td>
    <td class="cuadro02">Celular</td>
    <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
    <td class="cuadro01"><input type="text" name="telefono_retira3" id="telefono_retira3" value="<? echo $fila_matricula['fono_retira3'];?>" /></td>
    <td class="cuadro01"><input type="text" name="cel_retira3" id="cel_retira3" value="<? echo $fila_matricula['celular_retira3'];?>" /></td>
    <td class="cuadro01">&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="3" class="cuadro01">&nbsp;</td>
      </tr>
    <tr>
    <td class="cuadro02">Viaja en transporte escolar</td>
    <td class="cuadro02">Nombre tio(a)</td>
    <td class="cuadro02">Teléfono</td>
    </tr>
    <tr>
    <td class="cuadro01">Si<input type="radio" name="viaja_furgon" id="viaja_furgon1" value="1" />
    				     No<input type="radio" name="viaja_furgon" id="viaja_furgon0" value="0" />
	<input name="hidden_viaja_furgon" type="hidden" id="hidden_viaja_furgon" value="<? echo $fila_matricula['bool_retirosolo'];?>" />
	
</td>
    <td class="cuadro01">
	<input type="text" name="nombre_tio" id="nombre_tio" value="<? echo $fila_matricula['nombre_tio'];?>" /></td>
    <td class="cuadro01">
	<input type="text" name="fono_furgon" id="fono_furgon" value="<? echo $fila_matricula['fono_furgon'];?>" /></td>
    </tr>
     <tr>
      <td class="cuadro02">Apoderado autoriza a alumno a retirarse solo del colegio</td>
      <td class="cuadro02">&nbsp;</td>
      <td class="cuadro02">&nbsp;</td>
    </tr>
    <tr>
      <td class="cuadro01">Si
        <input type="radio" name="bool_retirosolo" id="bool_retirosolo1" value="1" />
No
<input type="radio" name="bool_retirosolo" id="bool_retirosolo0" value="0" />
<input type="hidden" id="hidden_retirosolo" value="<? echo $fila_matricula['bool_retirosolo'];?>" /></td>
      <td class="cuadro01">&nbsp;</td>
      <td class="cuadro01">&nbsp;</td>
    </tr>
   </table>
   <br>
    <table width="100%" BORDER="1" CELLPADDING=0 CELLSPACING=0 style="border-collapse:collapse"  >
    <TR>
    <TD colspan="4"><div id="titulo" class="tableindex">AUTORIZACIONES</div>
    </TD>
    </TR>
    <TR  class="cuadro02">
      <TD valign="top">Cambiar de ropa en caso de ser necesario</TD>
      <TD valign="top" >Tomar fotograf&iacute;as/videos en actividades escolares</TD>
      <TD valign="top">Compartir fotograf&iacute;as en Facebook Escuela</TD>
      <TD valign="top">Aplicar vacunas en el establecimiento</TD>
    </TR>
    <TR  class="cuadro01">
      <TD>&nbsp; Si<input type="radio" name="bool_cambioropa" id="bool_cambioropa1" value="1" <?php echo ($fila_matricula['bool_cambioropa']==1)?"checked":"" ?> />
No
<input type="radio" name="bool_cambioropa" id="bool_cambioropa0" value="0" <?php echo ($fila_matricula['bool_cambioropa']==0)?"checked":"" ?> /></TD>
      <TD>&nbsp; Si<input type="radio" name="bool_tomafoto" id="bool_tomafoto1" value="1" <?php echo ($fila_matricula['bool_tomafoto']==1)?"checked":"" ?> />
No
<input type="radio" name="bool_tomafoto" id="bool_tomafoto0" value="0" <?php echo ($fila_matricula['bool_tomafoto']==0)?"checked":"" ?> /></TD>
     
      <TD>&nbsp; Si<input type="radio" name="bool_facebook" id="bool_facebook1" value="1" <?php echo ($fila_matricula['bool_facebook']==1)?"checked":"" ?> />
No
<input type="radio" name="bool_facebook" id="bool_facebook0" value="0" <?php echo ($fila_matricula['bool_facebook']==0)?"checked":"" ?> />

</TD>
      <TD>&nbsp; Si
        <input type="radio" name="aut_vacuna" id="aut_vacuna1" value="1" <?php echo ($fila_matricula['aut_vacuna']==1)?"checked":"" ?> />
No
<input type="radio" name="aut_vacuna" id="aut_vacuna0" value="0" <?php echo ($fila_matricula['aut_vacuna']==0)?"checked":"" ?> /></TD>
    </TR>
    
    </table>
   <br>
     <?php
     } 
	  ?>
     </div>
    
    <div id="familiar">
    
    <div id="ver_familiar">
    <table width="100%">
    <tr>
    <td class="cuadro01"><div id="sel_familiar"><select size="1px" ><option value="0">Seleccione Familiar</option></select></div></td>
    <td class="cuadro01"><div id="div_mofificar" style="float:right;">&nbsp;<input type="button" class="botonXX" id="btn_mofificar" value="Modificar" onclick="modifica_familiar()" />
    <input type="button" class="botonXX" id="btn_eliminar" value="Eliminar" onclick="elimina_familiar()" />
     <input type="button" class="botonXX" title="Cancelar" value="Cancelar" onclick="volver_home()" ></div>
      </td>
    </tr>
    </table>
    </div>
    
     <div id="tabla_mod_familiar">   
		
	</div>	
    </div>  
       
    <!--<div id="academico">
    <h3>academica</h3>
    </div> -->
    
    <div id="becas" style="width:100%; margin-left:-23px">
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

