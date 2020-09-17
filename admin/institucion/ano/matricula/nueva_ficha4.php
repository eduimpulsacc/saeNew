<?php require('../../../../util/header.inc');

	//echo "-->".pg_dbname();
	
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$_POSP = 4;
	$_bot = 6;
	if($Modo==1)
	{
		$frmModo = "mostrar";
	}
	
	
	
	$sql="SELECT cod_reg,cor_pro,cor_com,nom_com FROM comuna WHERE cod_reg in (SELECT region FROM institucion WHERE rdb=".$institucion.") ORDER BY nom_com ASC";
	$rs_comuna = pg_exec($conn,$sql);
	
	$sql="SELECT id_curso FROM curso WHERE id_ano=".$ano." ORDER BY ensenanza,grado_curso,letra_curso ASC";
	$rs_curso = pg_exec($conn,$sql);
	
	$sql="SELECT MAX(num_mat) FROM matricula WHERE id_ano=".$ano;
	$rs_matricula = pg_exec($conn,$sql);
	$nro_matricula = pg_result($rs_matricula,0) + 1;
	
	
	$sql ="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
	$rs_ano =pg_exec($conn,$sql);
	$nro_ano = pg_result($rs_ano,0);
	$nro_ano_ant = $nro_ano - 1;
	
	$sql_salud ="SELECT * FROM sistema_salud";
	$rs_salud =pg_exec($conn,$sql_salud);
	
	
	$sql_etnia = "select * from etnia";
	$rs_etnia = pg_exec($conn,$sql_etnia);

if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../index.php";
		 </script>

<? } ?>			
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<?php if($_PERFIL==0){?>

<!--<script language="javascript" src="../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>--><script type="text/javascript" src="../../../clases/jquery-ui-1.9.2.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script language="javascript" src="../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script language="javascript" src="../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->



<?php }else{?>
<script type="text/javascript" src="../../../clases/jquery-ui-1.9.2.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script language="javascript" src="../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script language="javascript" src="../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
	
<?php }?>
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

function conMayusculas(field) {
   field.value = field.value.toUpperCase()
}


function limpia(campo){
	
    var nombre_txt = "txt"+campo;

	if($("input[name="+campo+"]:checked").val()==0){
		$('#'+nombre_txt+'').val("ninguna");
	}
	
	if($("input[name="+campo+"]:checked").val()==1){
		$('#'+nombre_txt+'').val("");
		$('#'+nombre_txt+'').removeAttr("disabled");
		$('#'+nombre_txt+'').focus();
	}
}
//-->
</script>




<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
<SCRIPT language="JavaScript" src="../curso/alumno/nueva_ficha_alumno/valida_rut_simple.js"></SCRIPT>
 <script>
 
 </script>

<script language="javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}




 $(document).ready(function() {
	//  $( "#tabs" ).tabs();
	$(".dsuplente").css("display","none");
	  nuevaFila ();
	  
	  cuentaMatr();
	  
	  //obligar a solo numeros
		 $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
          });
		  
		  
		  //obligo a todos los campos a escribir en mayuscula
	$('input[type=text],textarea').keyup(function (){
           // this.value = (this.value + '').replace(/[^0-9]/g, '');
            this.value = (this.value + '').toUpperCase();
          });
	 	
	$("#txtFECHA").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>",
	onSelect: function(dateText){
		calcular_edad() ;
		}
	//buttonImage: 'img/Calendario.PNG',
	});
	//$.datepicker.regional['es']	
 

	$("#txtFECHAMAT").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
	//buttonImage: 'img/Calendario.PNG',
	});
	$.datepicker.regional['es']	
	
	$("#txtCONTROLSANO").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
	//buttonImage: 'img/Calendario.PNG',
	});
	//$.datepicker.regional['es']	
 

	$("#txtFECHAMADRE").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
	//buttonImage: 'img/Calendario.PNG',
	});
	//$.datepicker.regional['es']	
   

	$("#txtFECHAPADRE").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
	//buttonImage: 'img/Calendario.PNG',
	});
	//$.datepicker.regional['es']	
	
	/*
	$("#agregar").click(function(){
		$("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
	});
 	// Evento que selecciona la fila y la elimina 
	
*/
	
	
		$('#txtENFERMEDAD').val('ninguna');
		$('#txtCIRUGIA').val('ninguna');
		$('#txtMEDICAMENTO').val('ninguna');
		$('#txtALERGIA').val('ninguna');
		$('#txtFISICA').val('ninguna');
		$('#txtFIEBRE').val('ninguna');
		$('#txtSEGURO').val('ninguna');
		
	
	
 });
 
 
 function valida_rut()
 {
	 var rut = $('#txtRUT').val();
	 var dig_rut = $('#txtDIGRUT').val();
	 
	 var validar_rut = Valida_Rut(rut,dig_rut);
	 if(validar_rut==1){
		//alert("rut correcto");
		prueba_existencia();
		}else{
		alert("Rut Incorrecto");
		$('#txtRUT').val("")
		$('#txtDIGRUT').val("")
		return false;
	}
 }
 
 
 function prueba_existencia()
 {
	var funcion =1;
	var rut_alumno = $('#txtRUT').val();
	var id_ano = "<?=$ano?>";
	
	var parametros = 'funcion='+funcion+'&rut_alumno='+rut_alumno+'&id_ano='+id_ano;
	//alert(parametros);	
	
	 $.ajax({
	  url:'procesoMatriculaNueva3.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 //alert(data)
		  
		if(data!=0){
			$('#datos_alumEX').html(data);
			
			$('#txtNOMBRE').val($('#nombre_hidden').val());
			$('#txtAPEPAT').val($('#ape_pat_hidden').val());
			$('#txtAPEMAT').val($('#ape_mat_hidden').val());
			$('#txtFECHA').val($('#fecha_hidden').val());
			$('#txtDIRECCION').val($('#direccion_hidden').val());
			$('#txtFONO').val($('#fono_hidden').val());

			
			var comuna = $('#comuna_hidden').val();
			$("#cmbCOMUNA option[value="+comuna+"]").attr("selected",true);
			
			var nacionalidad = $('#nac_hidden').val();
			$("#cmbNACIONALIDAD option[value="+nacionalidad+"]").attr("selected",true);
			
			var sexo = $('#sexo_hidden').val();
			$("#cmbGENERO option[value="+sexo+"]").attr("selected",true);
			
			var estado_civil = $('#estado_civil_hidden').val();
			$("#cmb_estadocivil option[value="+estado_civil+"]").attr("selected",true);
			
			var edad = $('#edad_hidden').val();
			$("#txt_edad").val(edad);
			
			var email = $('#email_hidden').val();
			$("#txtEMAIL").val(email);
			
			var canthijos = $('#canthijos_hidden').val();
			$("#txt_CANTHIJOS").val(canthijos);
			
			$('#txtCELULAR').val($('#celular_hidden').val());
			
			var etnia = $('#etnia_hidden').val();
			$("#txt_ETNIA").val(etnia);
			
			var espadre = $('#padre_hidden').val();
			//alert(espadre);
			if(espadre==1){
				$("#bool_padre").attr('checked','checked');
			}
			else{
				$("#bool_padre2").prop("checked", true);
				
				}
			
				
			var esmadre = $('#madre_hidden').val();
			if(esmadre==1){
				$("#bool_madre").attr('checked','checked');
			}
			else{
				$("#bool_madre2").prop("checked", true);
				
				}
			
			
			
			calcular_edad();
			
			
			//alert("Existen datos en Sistema");
			
			var curso=$('#cmbCURSO').val();
			var param2="rut_alumno="+rut_alumno+"&curso="+curso+"&anio="+<?php echo $ano ?>;
			$.ajax({
					url:'valexiste.php',
					data:param2,
					type:'POST',
					success: function(data){
						//console.log(data);
							if(data==1){
							alert("Alumno ya se encuentra matriculado en este año");
							}
						}
					
				});
			}else{
				//alert("No Existen Datos");
				
				}			

	 }
  })
		 
 }
 
 var columnaActual = 0;
  function nuevaFila(){ 
  
  columnaActual= ++columnaActual;               
	
	  
  var fila ='<tr id="fila' + columnaActual	+ '"><td>';
  
 fila+='<select name="cmbCURSOHERMANO[]" id="cmbCURSOHERMANO' + columnaActual	+ '"  onchange="cargacurso(' + columnaActual	+ ')" >';
 fila+='<option value="0">seleccione...</option>';
 <?php for($i=0;$i<pg_numrows($rs_curso);$i++){
            $fila_c = pg_fetch_array($rs_curso,$i);?>
	    fila+='<option value="<?php echo $fila_c['id_curso'] ?>"><?php echo CursoPalabra($fila_c['id_curso'],0,$conn); ?></option>';
		<?php }?>

 fila+='</select></td>';

 fila+='<td><div id="alu' + columnaActual	+ '">';
 fila+='<select>';
 fila+='<option value="0">seleccione...</option>';
 fila+='</select>';
 fila+=' </div></td>';
 if(columnaActual>1){
 fila+='<td width="150" class="cuadro01" onClick="borrarFila(' + columnaActual + ')"><img src="../../../clases/img_jquery/iconos/Free_web_development_icons_by_kurumizawa/Colored/PNG/action_delete.png"></td></tr>';
 }else{
 fila+='<td width="150" class="cuadro01">&nbsp;</td></tr>';
}
		
		$("#filas").append(fila);
		}
		/* Elimina la fila indicada. */
		function borrarFila(indice)
		{
		$("#fila" + indice).remove ();
		}
		
		

function cargacurso(indice){
var curso = $("#cmbCURSOHERMANO"+indice+"").val();
var parametros ="curso="+curso+"&funcion=1&indice="+indice;
	$.ajax({
		url:'cursos.php',
		data:parametros,
		type:'POST',
		success: function(data){
		//	console.log(data);
				$("#alu"+indice+"").html(data);
			}
		
	})


}
		
 
 
 function valida_rut_madre()
 {
	 var rut = $('#txtRUTM').val();
	 var dig_rut = $('#txtDIGRUTM').val();
	 
	 var validar_rut = Valida_Rut(rut,dig_rut);
	 if(validar_rut==1){
		//alert("rut correcto");
		}else{
		alert("Rut Incorrecto");
		$('#txtRUTM').val("")
		$('#txtDIGRUTM').val("")
		return false;
	}
 }
 
 function valida_rut_padre()
 {
	 var rut = $('#txtRUTP').val();
	 var dig_rut = $('#txtDIGRUTP').val();
	 
	 var validar_rut = Valida_Rut(rut,dig_rut);
	 if(validar_rut==1){
		//alert("rut correcto");
		}else{
		alert("Rut Incorrecto");
		$('#txtRUTP').val("")
		$('#txtDIGRUTP').val("")
		return false;
	}
 }
 
  function valida_rut_suplente()
 {
	 var rut = $('#txtRUTSUPLENTE').val();
	 var dig_rut = $('#txtDIGRUTSUPLENTE').val();
	 
	 var validar_rut = Valida_Rut(rut,dig_rut);
	 if(validar_rut==1){
		//alert("rut correcto");
		}else{
		alert("Rut Incorrecto");
		$('#txtRUTSUPLENTE').val("")
		$('#txtDIGRUTSUPLENTE').val("")
		return false;
	}
 }
 
 
 function valida()
 {
	 
	 if($('#cmbCURSO').val()==0){
		 alert("Seleccione Curso");
		 document.form.cmbCURSO.focus();
		 return false; 
	 }
	 
	  if($('#txtFECHAMAT').val()==""){
		 alert("Seleccione Fecha");
		 document.form.txtFECHAMAT.focus();
		 return false; 
	 }
	 
	 if($('#txtRUT').val()==""){
		 alert("Escriba rut");
		 document.form.txtRUT.focus();
		 return false; 
	 }
	 
	  if($('#txtNOMBRE').val()==""){
		 alert("Escriba Nombre");
		 document.form.txtNOMBRE.focus();
		 return false; 
	  }
	  
	  if($('#txtAPEPAT').val()==""){
		 alert("Escriba apellido paterno");
		 document.form.txtAPEPAT.focus();
		 return false; 
	  }
	  
	  if($('#txtAPEMAT').val()==""){
		 alert("Escriba apellido materno");
		 document.form.txtAPEMAT.focus();
		 return false; 
	  }
	  
	  if($('#txtFECHA').val()==""){
		 alert("Escriba fecha nacimiento");
		 document.form.txtFECHA.focus();
		 return false; 
	  }
	  
	  if($('#txtDIRECCION').val()==""){
		 alert("Escriba direccion");
		 document.form.txtDIRECCION.focus();
		 return false; 
	  }
	  
	  if($('#cmbCOMUNA').val()==0){
		 alert("Seleccione Comuna");
		 document.form.cmbCOMUNA.focus();
		 return false; 
	  }
	  
	  if($('#txtFONO').val()==""){
		 alert("Escriba telefono de contacto");
		 document.form.txtFONO.focus();
		 return false; 
	  }
	  
	  
	  if($('#txtRUTM').val()!="")
	  {
		  if($('#txtNOMBREM').val()=="")
		  {
			 alert("Escriba nombre de la Madre");	
			 document.form.txtNOMBREM.focus();
		     return false;   
		  }
		  if($('#txtAPEPATM').val()=="")
		  {
			 alert("Escriba apellido paterno");	
			 document.form.txtAPEPATM.focus();
		     return false;   
		  }
		  
		  /*if($('#txtFECHAMADRE').val()=="")
		  {
			 alert("Ingrese Fecha de nacimiento");	
			 document.form.txtFECHAMADRE.focus();
		     return false;   
		  }*/
		  
		   if($('#txtAPEMATM').val()=="")
		  {
			 alert("Escriba apellido materno");	
			 document.form.txtAPEMATM.focus();
		     return false;   
		  }
		  
		  
		   if($('#cmbCOMUNAM').val()==0)
		  {
			 alert("Seleccione Comuna");	
			 document.form.cmbCOMUNAM.focus();
		     return false;   
		  }
	  }
	  
	    if($('#txtRUTP').val()!="")
	  {
		  if($('#txtNOMBREP').val()=="")
		  {
			 alert("Escriba nombre del Padre");	
			document.form.txtNOMBREP.focus();	
		     return false;   
		  }
		  
		  if($('#txtAPEPATP').val()=="")
		  {
			 alert("Escriba apellido paterno");	
			 document.form.txtAPEPATP.focus();
		     return false;   
		  }
		  
		  if($('#txtAPEMATP').val()=="")
		  {
			 alert("Escriba apellido materno");	
			 document.form.txtAPEMATP.focus();
		     return false;   
		  }
		  
		  /*if($('#txtFECHAPADRE').val()=="")
		  {
			 alert("Ingrese Fecha de nacimiento");	
			 document.form.txtFECHAPADRE.focus();
		     return false;   
		  }*/
		  
		   if($('#cmbCOMUNAP').val()==0)
		  {
			 alert("Seleccione Comuna");	
			 document.form.cmbCOMUNAP.focus();
		     return false;   
		  }
	  }
	  document.form.method="POST";
	  
	  form.action="procesoMatriculaNueva3.php";
	  document.form.submit();
 }
 
 /****************/
  function valida2()
 {
	 
	 if($('#cmbCURSO').val()==0){
		 alert("Seleccione Curso");
		 document.form.cmbCURSO.focus();
		 return false; 
	 }
	 
	  if($('#txtFECHAMAT').val()==""){
		 alert("Seleccione Fecha");
		 document.form.txtFECHAMAT.focus();
		 return false; 
	 }
	 
	 if($('#txtRUT').val()==""){
		 alert("Escriba rut");
		 document.form.txtRUT.focus();
		 return false; 
	 }
	 
	  if($('#txtNOMBRE').val()==""){
		 alert("Escriba Nombre");
		 document.form.txtNOMBRE.focus();
		 return false; 
	  }
	  
	  if($('#txtAPEPAT').val()==""){
		 alert("Escriba apellido paterno");
		 document.form.txtAPEPAT.focus();
		 return false; 
	  }
	  
	  if($('#txtAPEMAT').val()==""){
		 alert("Escriba apellido materno");
		 document.form.txtAPEMAT.focus();
		 return false; 
	  }
	  
	  if($('#txtFECHA').val()==""){
		 alert("Escriba fecha nacimiento");
		 document.form.txtFECHA.focus();
		 return false; 
	  }
	  
	  if($('#txtDIRECCION').val()==""){
		 alert("Escriba direccion");
		 document.form.txtDIRECCION.focus();
		 return false; 
	  }
	  
	  if($('#cmbCOMUNA').val()==0){
		 alert("Seleccione Comuna");
		 document.form.cmbCOMUNA.focus();
		 return false; 
	  }
	  
	  if($('#txtFONO').val()==""){
		 alert("Escriba telefono de contacto");
		 document.form.txtFONO.focus();
		 return false; 
	  }
	  
	  
	  if($('#txtRUTM').val()!="")
	  {
		  if($('#txtNOMBREM').val()=="")
		  {
			 alert("Escriba nombre de la Madre");	
			 document.form.txtNOMBREM.focus();
		     return false;   
		  }
		  if($('#txtAPEPATM').val()=="")
		  {
			 alert("Escriba apellido paterno");	
			 document.form.txtAPEPATM.focus();
		     return false;   
		  }
		  
		  /*if($('#txtFECHAMADRE').val()=="")
		  {
			 alert("Ingrese Fecha de nacimiento");	
			 document.form.txtFECHAMADRE.focus();
		     return false;   
		  }*/
		  
		   if($('#txtAPEMATM').val()=="")
		  {
			 alert("Escriba apellido materno");	
			 document.form.txtAPEMATM.focus();
		     return false;   
		  }
		  
		  
		   if($('#cmbCOMUNAM').val()==0)
		  {
			 alert("Seleccione Comuna");	
			 document.form.cmbCOMUNAM.focus();
		     return false;   
		  }
	  }
	  
	    if($('#txtRUTP').val()!="")
	  {
		  if($('#txtNOMBREP').val()=="")
		  {
			 alert("Escriba nombre del Padre");	
			document.form.txtNOMBREP.focus();	
		     return false;   
		  }
		  
		  if($('#txtAPEPATP').val()=="")
		  {
			 alert("Escriba apellido paterno");	
			 document.form.txtAPEPATP.focus();
		     return false;   
		  }
		  
		  if($('#txtAPEMATP').val()=="")
		  {
			 alert("Escriba apellido materno");	
			 document.form.txtAPEMATP.focus();
		     return false;   
		  }
		  
		  /*if($('#txtFECHAPADRE').val()=="")
		  {
			 alert("Ingrese Fecha de nacimiento");	
			 document.form.txtFECHAPADRE.focus();
		     return false;   
		  }*/
		  
		   if($('#cmbCOMUNAP').val()==0)
		  {
			 alert("Seleccione Comuna");	
			 document.form.cmbCOMUNAP.focus();
		     return false;   
		  }
	  }
	  document.form.method="POST";
	 
	  document.form.action="procesoMatriculaNueva2.php"; 
	  document.form.submit();
 }
 
 /********/
 
function borra_dig()
{
	$('#txtRUT').val("");
	$('#txtDIGRUT').val("");	
	$('#txtNOMBRE').val("");
	$('#txtAPEPAT').val("");
	$('#txtAPEMAT').val("");
	$('#txtDIRECCION').val("");
	$('#txtFONO').val("");
	$('#txtFECHA').val("");
	$("#cmbCOMUNA option[value=0]").attr("selected",true);
	$("#cmbNACIONALIDAD option[value=0]").attr("selected",true);
	$("#cmbGENERO option[value=0]").attr("selected",true);
}
 
 
 function datosuplente(valor){
	 if(valor==1){
	$(".dsuplente").css("display","block");
	 }else
	 {$(".dsuplente").css("display","none");}
	}
 
 
 function cambiaficha(){
	var curso = $("#cmbCURSO").val();
	var funcion=0;
	//alert(curso);
	//$("#tipens").val(curso);
	
	$.ajax({
				url:"calculoEnse.php",
				data:"curso="+curso,
				type:'POST',
				success:function(data){
				//$('#alcurso').html(data);
				//alert(data);
				
				if(data != 165 || data != 167 || data != 360  || data != 363 || data != 436 || data != 563 || data != 763 || data != 863 || data != 963 ){
					window.location = 'nueva_ficha3.php?curso='+curso;
					cuentaMatr();
				}
				
		  }
		});  
	
	}
	
	
	function calcular_edad() {
		
	var fecha =  $("#txtFECHA").val();
		
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

function cuentaMatr(){
		var cur =$('#cmbCURSO').val();
		var funcion=1;
		var parametros = "curso="+cur+"&funcion="+funcion;
		//alert(parametros);
		$.ajax({
				url:"calculoEnse.php",
				data:parametros,
				type:'POST',
				success:function(data){
				//	alert(data);
				$('#cma').html(data);
				//alert(data);
				
				
				
		  }
		}); 
	}
</SCRIPT>
 


<style type="text/css">
	div.ui-datepicker{
	font-size:12px;
	}
	
	#tabla{	border: solid 1px #333;	width: 300px; }
#tabla tbody tr{ background: #999; }
.fila-base{ display: none; } /* fila base oculta */
.eliminar{ cursor: pointer; color: #000; }
	
	textarea:focus, input[type=password]:focus, input[type=text]:focus, select :focus{
	border: 1px solid #79b7e7; background: #fff;
	outline: none; box-shadow: 0 1px 4px #c5c5a2;
	-webkit-box-shadow: 0 1px 4px #c5c5a2;
	-moz-box-shadow: 0 1px 4px #c5c5a2; }
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <? include("../../../../cabecera/menu_superior.php"); ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral=3; include("../../../../menus/menu_lateral.php"); ?>
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
     
     <div id="gif_sige" style="text-align:right"><img src="../../../clases/soap/gif_sige.gif"></div>
     <form name="form" id="form" action="" >
     <table width="650" border="0" align="center">
       <tr>
         <td align="right">
         
		
          <? if($_CONVENIOID!="" || $_PERFIL==0){?>
				 <INPUT class="botonXX"  TYPE="submit" value="VALIDAR EN SIGE" name="btnGuardarSige" onClick="valida(this.form)" >          
		  <? } ?>
		  <input type="button" name="GUARDAR2" id="GUARDAR2" value="GUARDAR" class="botonXX" onClick="valida(this.form)">
           <input type="button" name="VOLVER" id="VOLVER" value="VOLVER" class="botonXX" onClick="window.location='listarMatricula.php3'"></td>
       </tr>
     </table>
     <br>
     <table width="650" border="0" align="center">
       <tr>
    <td align="center" class="tableindex"><strong>FICHA DEL ALUMNO <?=$nro_ano;?> - EDUCACI&Oacute;N DE ADULTOS</strong></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  
  <tr>
    <td width="150" class="cuadro02">CURSO :</td>
    <td class="cuadro01">
    <select name="cmbCURSO" id="cmbCURSO" onChange="cambiaficha();cuentaMatr()" >
    	<option value="0">seleccione...</option>
	<? for($i=0;$i<pg_numrows($rs_curso);$i++){
            $fila_c = pg_fetch_array($rs_curso,$i);
	?>
    <option value="<?=$fila_c['id_curso'];?>" <?php echo ($curso==$fila_c['id_curso'])?"selected":"" ?>><?=CursoPalabra($fila_c['id_curso'],0,$conn);?></option>					
    <? } ?>
			
    </select></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">NRO. MATRICULA :</td>
    <td class="cuadro01"><input name="txtNROMATRICULA" type="text" size="10" maxlength="4" value="<?=$nro_matricula;?>"></td>
  </tr>
  <tr>
    <td class="cuadro02">MATRICULA CURSO:</td>
    <td class="cuadro01"><div id="cma">&nbsp;</div></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">FECHA DE MATRICULA:</td>
    <td width="488" class="cuadro01"><input name="txtFECHAMAT" type="text" id="txtFECHAMAT" size="10" maxlength="10" readonly> 
    (utilizar calendario para ingreso de fecha)</td>
  </tr>
</table>
<div id="datos_alumEX"></div>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1"><p><strong><em>DATOS PERSONALES</em></strong></p></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td width="250" class="cuadro02">R.U.T.</td>
    <td colspan="4" class="cuadro01"><input name="txtRUT" id="txtRUT" type="text" size="10" maxlength="9" onClick="borra_dig()"> - <input name="txtDIGRUT" id="txtDIGRUT" type="text" size="5" maxlength="1" onBlur="valida_rut()"></td>
  </tr>
  <tr>
    <td width="250" class="cuadro02">NOMBRES</td>
    <td width="200"class="cuadro01"><input name="txtNOMBRE" id="txtNOMBRE" type="text" onChange="conMayusculas(this)"></td>
    <td width="150" class="cuadro02">APELLIDO PATERNO</td>
    <td width="65" class="cuadro01"><input name="txtAPEPAT" id="txtAPEPAT" type="text" onChange="conMayusculas(this)" ></td>
  </tr>
  <tr>
    <td width="250" class="cuadro02"> APELLIDO MATERNO</td>
    <td width="200" class="cuadro01"><input name="txtAPEMAT" id="txtAPEMAT" type="text" onChange="conMayusculas(this)" ></td>
    <td width="150" class="cuadro02">FECHA DE NAC.</td>
    <td class="cuadro01"><input name="txtFECHA" type="text" id="txtFECHA" size="10" maxlength="10" readonly onChange="calcular_edad()"></td>
  </tr>
  <tr>
    <td class="cuadro02">EDAD</td>
    <td class="cuadro01"><input name="txt_edad" type="text" id="txt_edad" size="2" readonly></td>
    <td class="cuadro02">ESTADO CIVIL</td>
    <td class="cuadro01"><select name="cmb_estadocivil" id="cmb_estadocivil">
      <option value="0">seleccione...</option>
      <option value="1">SOLTERO(A)</option>
      <option value="2">CASADO(A)</option>
      <option value="3">VIUDO(A)</option>
      <option value="4">DIVORCIADO(A)</option>
      <option value="5">OTRO</option>
    </select></td>
  </tr>
  <tr>
    <td width="250" class="cuadro02">DIRECCIÓN</td>
    <td width="200" class="cuadro01"><input name="txtDIRECCION" type="text" id="txtDIRECCION" onChange="conMayusculas(this)" maxlength="50"></td>
    <td width="150" class="cuadro02">COMUNA</td>
    <td class="cuadro01">
    <select name="cmbCOMUNA" id="cmbCOMUNA">
    	<option value="0">seleccione...</option>
        <? for($i=0;$i<pg_numrows($rs_comuna);$i++){
			$fila_com = pg_fetch_array($rs_comuna,$i);?>
            <option value="<?=$fila_com['cod_reg'].",".$fila_com['cor_pro'].",".$fila_com['cor_com'];?>"><?=$fila_com['nom_com'];?></option> 
        
        <? } ?>
     </select>
    </td>  
  </tr> 
  <tr> 
    <td width="250" class="cuadro02">TELEFONO</td> 
    <td width="200" class="cuadro01"><input name="txtFONO" id="txtFONO" type="text"></td> 
    <td width="150" class="cuadro02">EMAIL</td> 
    <td class="cuadro01"><input name="txtEMAIL" id="txtEMAIL" type="text" onChange="conMayusculas(this)"></td>
  </tr>
  <tr>
    <td class="cuadro02">CELULAR</td>
    <td class="cuadro01"><input name="txtCELULAR" id="txtCELULAR" type="text"></td>
    <td class="cuadro02">NACIONALIDAD</td>
    <td class="cuadro01"><select name="cmbNACIONALIDAD" id="cmbNACIONALIDAD" >
      <option value="2">CHILENA</option>
      <option value="1">EXTRANJERA</option>
    </select></td>
  </tr>
  <tr>
    <td class="cuadro02">GENERO</td>
    <td class="cuadro01">
    	<select name="cmbGENERO" id="cmbGENERO">
    		<option value="2">MASCULINO</option>
            <option value="1">FEMENINO</option>
        </select>
    </td>
    <td class="cuadro02">ES MADRE</td>
    <td class="cuadro01"><input name="bool_madre" type="radio" id="bool_madre2" value="0" checked>
NO
  <input type="radio" name="bool_madre" id="bool_madre" value="1">
SI </td>
  </tr>
  <tr>
    <td class="cuadro02">ES PADRE</td>
    <td class="cuadro01"><input name="bool_padre" type="radio" id="bool_padre2" value="0" checked>
      NO
      
        <input type="radio" name="bool_padre" id="bool_padre" value="1">
        SI </td>
    <td class="cuadro02">ETNIA</td>
    <td class="cuadro01"><select name="txt_etnia" id="txt_etnia">
      <option value="">Seleccione</option>
      <?php for($e=0;$e<pg_numrows($rs_etnia);$e++){
		$fila_etnia = pg_fetch_array($rs_etnia,$e);
		?>
      <option value="<?php echo $fila_etnia['nombre'] ?>"><?php echo $fila_etnia['nombre'] ?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td class="cuadro02">HIJOS</td>
    <td class="cuadro01"><input name="txt_CANTHIJOS" type="text" id="txt_CANTHIJOS" maxlength="10" class="solo-numero"></td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td width="250" class="cuadro02">DATOS DE INTERES</td>
    
    <td class="cuadro01" colspan="3">
      <textarea name="datos_de_interes" id="datos_de_interes"  style="width:350px;border:1; border-collapse:collapse;"></textarea>
      </td>
  </tr>

</table>

<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1"><strong><em>ANTECEDENTES ACADEMICOS</em></strong></td>
  </tr>
</table>
<br>
<table width="650" border="0" align="center">
  <tr>
    <td width="250" class="cuadro02">HA REPETIDO CURSO</td>
    <td width="149" class="cuadro01">
    	<input type="radio" name="rdCURSOREP" id="rdCURSOREP" value="0" checked>NO 
        <input type="radio" name="rdCURSOREP" id="rdCURSOREP" value="1">SI        
        <input name="txtCURSOREP" type="text" id="txtCURSOREP"></td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO ORIGEN INDIGENA</td>
    <td class="cuadro01"><input name="INDIGENA" type="radio" id="INDIGENA" value="0" checked>
      NO
      <input type="radio" name="INDIGENA" id="INDIGENA" value="1">
      SI</td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNA EMBARAZADA</td>
    <td class="cuadro01"><input name="EMBARAZADA" type="radio" id="EMBARAZADA" value="0" checked>
NO
  <input type="radio" name="EMBARAZADA" id="EMBARAZADA" value="1">
SI MESES
<input name="txtmesembarazo" type="text" id="txtmesembarazo"></td>
  </tr>
  <tr>
    <td class="cuadro02">REQUIERE EXAMEN DE VALIDACION DE ESTUDIOS</td>
    <td class="cuadro01"> <input name="bool_examenvalidacion" type="radio" id="bool_examenvalidacion0" value="0" checked>NO
      <input type="radio" name="bool_examenvalidacion" id="bool_examenvalidacion1" value="1">SI</td>
  </tr>
  <tr>
    <td class="cuadro02">ESTUDIO <?php echo $nro_ano_ant ?></td>
    <td class="cuadro01"><input name="bool_estudioanoant" type="radio" id="bool_estudioanoant0" value="0" checked>NO
      <input type="radio" name="bool_estudioanoant" id="bool_estudioanoant" value="1">SI</td>
  </tr>
  <tr>
    <td class="cuadro02">A&Ntilde;OS REPETIDOS</td>
    <td class="cuadro01"><input name="txtANOREPETIDO" type="text" id="txtANOREPETIDO"></td>
  </tr>
  <tr>
    <td class="cuadro02">A&Ntilde;OS RETIRADOS</td>
    <td class="cuadro01"><input name="txtANORETIRADO" type="text" id="txtANORETIRADO"></td>
  </tr>
  <tr>
    <td class="cuadro02">CAUSA RETIRO</td>
    <td class="cuadro01"><input name="txtCAUSARETIROANT" type="text" id="txtCAUSARETIROANT"></td>
  </tr>
   <tr>
     <td width="250" class="cuadro02">OBSERVACI&Oacute;N</td>
     <td class="cuadro01">
       <textarea name="observacion" id="observacion"  style="width:350px;border:1; border-collapse:collapse;"></textarea>
       </td>
   </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1"><strong><em>APODERADO / TUTOR</em></strong></td>
  </tr>
</table>
<br>
<table width="650" border="0" align="center">
      <tr>
    <td width="250" class="cuadro02">NOMBRE EN CASO DE EMERGENCIA</td>
    <td width="200"class="cuadro01"><input type="text" name="txt_contactoemergencia" id="txt_contactoemergencia"></td>
    <td width="150" class="cuadro02">FONO</td>
    <td width="65" class="cuadro01"><input type="text" name="txt_fonocontactoemergencia" id="txt_fonocontactoemergencia"></td>
  </tr>
      <tr>
        <td class="cuadro02">NOMBRE APODERADO/TUTOR</td>
        <td class="cuadro01"><input type="text" name="txt_tutor" id="txt_tutor"></td>
        <td class="cuadro02">FONO</td>
        <td class="cuadro01"><input type="text" name="txt_fonotutor" id="txt_fonotutor"></td>
      </tr>
    </table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1"><strong><em>ANTECEDENTES DE SALUD</em></strong></td>
  </tr>
</table>
<br>
<table width="650" border="0" align="center">
<tr>
    <td class="cuadro02">PROBLEMA APRENDIZAJE</td>
    <td class="cuadro01"><input name="bool_trastornosaprendizaje" type="radio" id="bool_trastornos0" onClick="limpia(this.name)" value="0" checked>
      NO
      <input type="radio" name="bool_trastornosaprendizaje" id="bool_trastornos1" value="1" onClick="limpia(this.name)">
      SI </td>
    <td class="cuadro01"><input type="text" name="txt_trastornosaprendizaje" id="txt_trastornosaprendizaje" ></td>
  </tr>
<tr>
  <td class="cuadro02">ENFERMEDAD CRONICA</td>
  <td class="cuadro01"><input name="bool_cronica" type="radio" id="bool_cronica0" onClick="limpia(this.name)" value="0" checked>
    NO
    <input type="radio" name="bool_cronica" id="bool_cronica1" value="1" onClick="limpia(this.name)">
    SI </td>
  <td class="cuadro01"><input type="text" name="txt_cronica" id="txt_cronica" ></td>
  </tr>
  <tr>
    <td class="cuadro02">TRATAMIENTO PSICOL&Oacute;GICO</td>
    <td width="100" class="cuadro01"><input name="bool_psicologo" type="radio" id="bool_psicologo0" onClick="limpia(this.name)" value="0" checked>
      NO
      <input type="radio" name="bool_psicologo" id="bool_psicologo1" value="3" onClick="limpia(this.name)">
      SI </td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02"><p>POSEE DISCAPACIDAD</p></td>
    <td class="cuadro01"><input name="bool_discapacidad" type="radio" id="bool_discapacidad0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_discapacidad" id="bool_discapacidad1" value="1" onClick="limpia(this.name)">
SI </td>
    <td class="cuadro01"><select name="txt_discapacidad" id="txt_discapacidad">
      <option value="0" selected>seleccione</option>
      <option value="VISUAL">VISUAL</option>
      <option value="AUDITIVA">AUDITIVA</option>
      <option value="MOTRIZ">MOTRIZ</option>
      <option value="INTELECTUAL">INTELECTUAL</option>
      <option value="TGD">TGD</option>
      <option value="OTRAS">OTRAS</option>
    </select></td>
  </tr>
  <tr>
    <td class="cuadro02"><p>CARNET DISCAPACIDAD</p></td>
    <td class="cuadro01"><input name="bool_carnetdiscapacidad" type="radio" id="bool_carnetdiscapacidad0" onClick="limpia(this.name)" value="0" checked>
      NO
      <input type="radio" name="bool_carnetdiscapacidad" id="bool_carnetdiscapacidad1" value="1" onClick="limpia(this.name)">
      SI </td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">CENTRO DE ATENCION</td>
    <td class="cuadro01"><input type="text" name="txt_centroatencion" id="txt_centroatencion"></td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  
  <tr>
    <td width="350" class="cuadro02">OBSERVACI&Oacute;N DE SALUD</td>
    
    <td class="cuadro01" colspan="2">
      <textarea name="observacion_salud" id="observacion_salud"  style="width:350px;border:1; border-collapse:collapse;"></textarea>
      </td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1"><strong><em>INFORMACIÓN GENERAL</em></strong></td>
  </tr>
</table>
<br>
<table width="650" border="0" align="center">
 <tr>
   <td width="150" class="cuadro02">NUMERO DE PERSONAS QUE DEPENDEN DEL ESTUDIANTE</td>
   <td width="150" class="cuadro01"><input type="text" name="txtNUMGRUPOFAMILAR" id="txtNUMGRUPOFAMILAR"></td>
   <td width="150" class="cuadro02">N&deg; FICHA PROTECCI&Oacute;N SOCIAL</td>
   <td width="150" class="cuadro01"><input type="text" name="txt_fichaps" id="txt_fichaps"></td>
 </tr>
 <tr>
   <td class="cuadro02">TOTAL DE INGRESOS</td>
   <td class="cuadro01"><input type="text" name="txtINGRESOGRUPO" id="txtINGRESOGRUPO"></td>
   <td class="cuadro02">ALUMNO CON QUIEN VIVE</td>
   <td class="cuadro01"><input type="text" name="txtCONQUIENVIVE" id="txtCONQUIENVIVE"></td>
 </tr>
 <tr>
   <td class="cuadro02">SISTEMA DE SALUD</td>
   <td class="cuadro01"><select name="cmbSALUDP2" id="cmbSALUDP2" style="text-transform:uppercase">
     <option value="0">SELECCIONE...</option>
     <?php  for($i=0;$i<pg_numrows($rs_salud);$i++){
		 $fila_salud=pg_fetch_array($rs_salud,$i);
		 ?>
     <option value="<?php echo $fila_salud['id_sistema_salud'] ?>" ><?php echo $fila_salud['sistema_salud'] ?></option>
     <?php }?>
   </select></td>
   <td class="cuadro02">TRAMO</td>
   <td class="cuadro01"><input type="text" name="tramo_salud" id="tramo_salud"></td>
 </tr>
 <tr>
   <tr>
     <td class="cuadro02">PROYECTO INTEGRACION</td>
     <td class="cuadro01"><input name="bool_integracion" type="radio" id="bool_integracion0" value="0" checked>
NO
  <input type="radio" name="bool_integracion" id="bool_integracion1" value="1">
SI</td>
     <td class="cuadro02">BECA JUNAEB</td>
     <td class="cuadro01"><input name="bool_junaeb" type="radio" id="bool_junaeb0" value="0" checked>
NO
  <input type="radio" name="bool_junaeb" id="bool_junaeb1" value="1">
SI</td>
   </tr>
   <tr>
    <td class="cuadro02">CHILE CRECE CONTIGO</td>
    <td class="cuadro01"><input name="bool_ccc" type="radio" id="bool_ccc0" value="0" checked>
NO
  <input type="radio" name="bool_ccc" id="bool_ccc1" value="1">
SI</td>
   <td class="cuadro02">PROGRAMA PUENTE</td>
   <td class="cuadro01"><input name="PUENTE" type="radio" id="PUENTE" value="0" checked>
NO
  <input type="radio" name="PUENTE" id="PUENTE" value="1">
SI</td>
 </tr>
   <tr>
     <td class="cuadro02">CHILE SOLIDARIO</td>
     <td class="cuadro01"><input name="bool_bchs" type="radio" id="bool_bchs0" value="0" checked>
NO
  <input type="radio" name="bool_bchs" id="bool_bchs1" value="1">
SI</td>
     <td class="cuadro02">PROGRAMA VIOLENCIA INTRAFAMILAR</td>
     <td class="cuadro01"><input name="bool_vif" type="radio" id="bool_vif0" value="0" checked>
NO
  <input type="radio" name="bool_vif" id="bool_vif1" value="1">
SI</td>
   </tr>
   <tr>
     <td class="cuadro02">PROGRAMA SALUD MENTAL</td>
     <td class="cuadro01"><input name="bool_saludmental" type="radio" id="bool_saludmental0" value="0" checked>
NO
  <input type="radio" name="bool_saludmental" id="bool_saludmental1" value="1">
SI</td>
     <td class="cuadro02">PROGRAMA CONSUMO DROGAS</td>
     <td class="cuadro01"><input name="bool_drogas" type="radio" id="bool_drogas0" value="0" checked>
NO
  <input type="radio" name="bool_drogas" id="bool_drogas1" value="1">
SI</td>
   </tr>
   <tr>
     <td class="cuadro02">PROGRAMA SENAME</td>
     <td class="cuadro01"><input name="bool_sename" type="radio" id="bool_sename0" value="0" checked>
NO
  <input type="radio" name="bool_sename" id="bool_sename1" value="1">
SI</td>
     <td class="cuadro02">PROGRAMA SERNAM</td>
     <td class="cuadro01"><input name="bool_sernam" type="radio" id="bool_sernam0" value="0" checked>
NO
  <input type="radio" name="bool_sernam" id="bool_sernam1" value="1">
SI</td>
   </tr>
 
 <tr>
   <td class="cuadro02">OBSERVACIONES</td>
   <td colspan="3" class="cuadro01"><textarea name="obse_general" id="obse_general"  style="width:350px;border:1; border-collapse:collapse;"></textarea></td>
   </tr>
</table>
<br>

<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1" colspan="2"><strong><em>DOCUMENTOS</em></strong></td>
  </tr>
  </table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1" colspan="2"><strong><em>DOCUMENTOS ENTREGADOS POR EL APODERADO</em></strong></td>
  </tr>
  <tr>
    <td width="350" class="cuadro02">CERTIFICADO DE NACIMIENTO</td>
    <td width="367" class="cuadro01"><input name="bool_traecertificados" type="radio" id="bool_traecertificado0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_traecertificados" id="bool_traecertificado1" value="1" onClick="limpia(this.name)">
SI </td>
    
  </tr>
  <tr>
    <td class="cuadro02">CERTIFICADOS DE ESTUDIOS A&Ntilde;OS ANTERIORES</td>
    <td class="cuadro01"><input name="bool_traecertificadosant" type="radio" id="bool_tracecertificadoanterior0" onClick="limpia(this.name)" value="0" checked>
      NO
      <input type="radio" name="bool_traecertificadosant" id="bool_tracecertificadoanterior1" value="1" onClick="limpia(this.name)">
      SI&nbsp;&nbsp;NIVEL 
      <input type="text" name="nivel_certificado" id="nivel_certificado"></td>
  </tr>
  <tr>
    <td class="cuadro02">AUTORIZACION SECREDUC</td>
    <td class="cuadro01"><input name="bool_secreduc" type="radio" id="bool_secreduc0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_secreduc" id="bool_secreduc1" value="1" onClick="limpia(this.name)">
SI PLAZO FECHA
      <input name="plazo_autorizacion" type="text" id="plazo_autorizacion" size="10" readonly></td>
  </tr>
  <tr>
    <td class="cuadro02">MANUAL DE CONVIVENCIA</td>
    <td class="cuadro01"><input name="bool_manualconvivencia" type="radio" id="bool_manualconvivencia0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_manualconvivencia" id="bool_manualconvivencia1" value="1" onClick="limpia(this.name)">
SI </td>
  </tr>
  <tr>
    <td class="cuadro02">PAGO MATRICULA</td>
    <td class="cuadro01"><input name="bool_pagomatricula" type="radio" id="bool_pagomatricula0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_pagomatricula" id="bool_pagomatricula1" value="1" onClick="limpia(this.name)">
SI </td>
  </tr>
  <tr>
    <td class="cuadro02">ABONO</td>
    <td class="cuadro01"><input type="text" name="abono_matricula" id="abono_matricula"></td>
  </tr>
  <tr>
    <td class="cuadro02">N&deg; BOLETA</td>
    <td class="cuadro01"><input name="txtNUMBOLETA" id="txtNUMBOLETA" type="text" size="5" ></td>
  </tr>
  <tr>
    <td class="cuadro02">EXENTO MATRICULA</td>
    <td class="cuadro01"><input name="bool_exentomatricula" type="radio" id="bool_exentomatricula0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_exentomatricula" id="bool_exentomatricula1" value="1" onClick="limpia(this.name)">
SI </td>
  </tr>
  <tr>
    <td class="cuadro02">APORTE VOLUNTARIO CGA</td>
    <td class="cuadro01"><input name="txtaporteCGP" id="txtaporteCGP" type="text" size="5" ></td>
  </tr>
</table>
<br />
<br />

<br />

<br>
<br />
<br />
     </form>

     <!-- FIN DEL NUEVO CÓDIGO -->
	 							  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
