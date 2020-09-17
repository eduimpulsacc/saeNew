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
	
	$sql_pais="select * from paises";
	$rs_paises =pg_exec($conn,$sql_pais);
	
	//ENCARGADO MATRICULA
	$sql_trabaja ="select DISTINCT(e.rut_emp), e.ape_pat,e.ape_mat,e.nombre_emp from empleado e inner join trabaja t on t.rut_emp = e.rut_emp where rdb=$institucion and t.bool_er=0 order by e.rut_emp ; ";
	$rs_trabaja = pg_exec($conn,$sql_trabaja);
	
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
<?php //if($_PERFIL==0){?>
<link rel="stylesheet" type="text/css" href="../../../clases/jqueryui/jquery-ui-1.8.6.custom.css">
<script language="javascript" src="../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script language="javascript" src="../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script language="javascript" src="../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>



<?php // }else{?>
<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>-->
<?php //}?>

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
	//alert(campo)
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
	 	
		
		
		//obligar a solo numeros
		 $('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
          });
		
		
	$("#txtFECHA").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
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
	  url:'procesoMatriculaNueva.php',
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
			$('#txtCELULAR').val($('#celular_hidden').val());

			
			var comuna = $('#comuna_hidden').val();
			$("#cmbCOMUNA option[value="+comuna+"]").attr("selected",true);
			
			var nacionalidad = $('#nac_hidden').val();
			$("#cmbNACIONALIDAD option[value="+nacionalidad+"]").attr("selected",true);
			
			var sexo = $('#sexo_hidden').val();
			$("#cmbGENERO option[value="+sexo+"]").attr("selected",true);
			
			var porigen = $('#porigen_hidden').val();
			$("#cmbPAISORIGEN option[value="+porigen+"]").attr("selected",true);
			//alert("Existen datos en Sistema");
			
			var etnia = $('#etnia_hidden').val();
			$("#txt_etnia option[value="+etnia+"]").attr("selected",true);
			
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
	  
	  if( $('#cmbNACIONALIDAD').val()==1 && $('#cmbPAISORIGEN').val()==0){
		 alert("Seleccione Pais de origen");
		 document.form.cmbPAISORIGEN.focus();
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
	  
	  form.action="procesoMatriculaNueva.php";
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
	  
	   if( $('#cmbNACIONALIDAD').val()==1 && $('#cmbPAISORIGEN').val()==0){
		 alert("Seleccione Pais de origen");
		 document.form.cmbPAISORIGEN.focus();
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
	$(".dsuplente").show();
	 }else
	 {$(".dsuplente").hide();}
	}
 
 
 function cambiaficha(){
	var curso = $("#cmbCURSO").val();
	var funcion=0;
	//alert(curso);
	//$("#tipens").val(curso);
	
	$.ajax({
				url:"calculoEnse.php",
				data:"curso="+curso+"&funcion="+funcion,
				type:'POST',
				success:function(data){
				//$('#alcurso').html(data);
				//alert(data);
				
				if(data == 165 || data == 167 || data == 360  || data == 363 || data == 436 || data == 563 || data == 763 || data == 863 || data == 963 ){
					window.location = 'nueva_ficha4.php?curso='+curso
				}
				
		  }
		});  
	
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
		
		 <input type="button" name="GUARDAR" id="GUARDAR" value="GUARDAR E IMPRIMIR" class="botonXX" onClick="valida2(this.form)">
    
          
         
           <input type="button" name="GUARDAR2" id="GUARDAR2" value="GUARDAR" class="botonXX" onClick="valida(this.form)">
           <input type="button" name="VOLVER" id="VOLVER" value="VOLVER" class="botonXX" onClick="window.location='listarMatricula.php3'"></td>
       </tr>
     </table>
     <br>
     <table width="650" border="0" align="center">
       <tr>
    <td align="center" class="tableindex"><strong>FICHA DEL ALUMNO <?=$nro_ano;?></strong></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  
  <tr>
    <td width="150" class="cuadro02">CURSO :</td>
    <td class="cuadro01">
    <select name="cmbCURSO" id="cmbCURSO" onChange="cambiaficha();cuentaMatr()">
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
    <td width="488" class="cuadro01"><input name="txtFECHAMAT" type="text" id="txtFECHAMAT" size="10" maxlength="10" value="" > 
    (utilizar calendario para ingreso de fecha)</td>
  </tr>
  <tr>
    <td class="cuadro02">ENCARGADO MATRICULA</td>
    <td class="cuadro01">
    <select name="cmbENCMATRICULA" id="cmbENCMATRICULA">
    <option value="0">Seleccione</option>
    <?php for($ft=0;$ft<pg_numrows($rs_trabaja);$ft++){
		$fila_trabaja = pg_fetch_array($rs_trabaja,$ft);
		?>
    <option value="<?php echo $fila_trabaja['rut_emp'] ?>"><?php echo $fila_trabaja['ape_pat'] ?> <?php echo $fila_trabaja['ape_mat'] ?>,<?php echo $fila_trabaja['nombre_emp'] ?></option>
    <?php }?>
    </select></td>
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
    <td width="121" class="cuadro02">R.U.T.</td>
    <td class="cuadro01"><input name="txtRUT" id="txtRUT" type="text" size="10" maxlength="9" onClick="borra_dig()"> - <input name="txtDIGRUT" id="txtDIGRUT" type="text" size="5" maxlength="1" onBlur="valida_rut()"></td>
    <td class="cuadro02">N&deg; PASAPORTE</td>
    <td class="cuadro01"><input name="txtPASAPORTE" id="txtPASAPORTE" type="text" onChange="conMayusculas(this)" ></td>
   
  </tr>
  <tr>
    <td width="25%" class="cuadro02">NOMBRE</td>
    <td width="25%"class="cuadro01"><input name="txtNOMBRE" id="txtNOMBRE" type="text" onChange="conMayusculas(this)"></td>
    <td width="25%" class="cuadro02">APELLIDO PATERNO</td>
    <td width="25%" class="cuadro01"><input name="txtAPEPAT" id="txtAPEPAT" type="text" onChange="conMayusculas(this)" ></td>
  </tr>
  <tr>
    <td width="121" class="cuadro02"> APELLIDO MATERNO</td>
    <td width="197" class="cuadro01"><input name="txtAPEMAT" id="txtAPEMAT" type="text" onChange="conMayusculas(this)" ></td>
    <td width="168" class="cuadro02">FECHA DE NAC.</td>
    <td class="cuadro01"><input name="txtFECHA" type="text" id="txtFECHA" size="10" maxlength="10" value="" readonly></td>
  </tr>
  <tr>
    <td width="121" class="cuadro02">DIRECCIÓN</td>
    <td width="197" class="cuadro01"><input name="txtDIRECCION" type="text" id="txtDIRECCION" onChange="conMayusculas(this)" maxlength="50"></td>
    <td width="168" class="cuadro02">COMUNA</td>
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
    <td class="cuadro02">SECTOR</td>
    <td class="cuadro01"><input type="text" name="txtSECTOR" id="txtSECTOR"></td>
    <td class="cuadro02">TELEFONO</td>
    <td class="cuadro01"><input name="txtFONO" id="txtFONO" type="text"></td>
  </tr>
  <tr>
    <td class="cuadro02">TELEFONO RECADOS</td>
    <td class="cuadro01"><input name="txtFONORECADOS" id="txtFONORECADOS" type="text"></td>
    <td class="cuadro02">CELULAR</td>
    <td class="cuadro01"><input name="txtCELULAR" id="txtCELULAR" type="text"></td>
  </tr> 
  <tr> 
    <td width="121" class="cuadro02">GENERO</td> 
    <td width="197" class="cuadro01"><select name="cmbGENERO" id="cmbGENERO">
      <option value="2">MASCULINO</option>
      <option value="1">FEMENINO</option>
    </select></td> 
    <td width="168" class="cuadro02">PA&Iacute;S DE ORIGEN</td> 
    <td class="cuadro01"><select name="cmbPAISORIGEN" id="cmbPAISORIGEN">
      <option value="0">Seleccione</option>
      <?php for($pa=0;$pa<pg_numrows($rs_paises);$pa++){
		  $fpa = pg_fetch_array($rs_paises,$pa);
		  ?>
      <option value="<?php echo $fpa['id'] ?>"><?php echo $fpa['nombre'] ?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td class="cuadro02">NACIONALIDAD</td>
    <td class="cuadro01"><select name="cmbNACIONALIDAD" id="cmbNACIONALIDAD" >
      <option value="2">CHILENA</option>
      <option value="1">EXTRANJERA</option>
    </select></td>
    <td class="cuadro02">PESO AL NACER</td>
    <td class="cuadro01"><input name="txtPESONACE" type="text" id="txtPESONACE" maxlength="10"></td>
  </tr>
  <tr>
    <td class="cuadro02">TALLA AL NACER</td>
    <td class="cuadro01"><input name="txtTALLANACE" type="text" id="txtTALLANACE" size="10" maxlength="10"></td>
    <td class="cuadro02">EDAD MADRE MOMENTO PARTO ALUMNO:</td>
    <td class="cuadro01"><input name="txtEDADPARTOLAUMNO" type="text" id="txtEDADPARTOLAUMNO" size="10" maxlength="10"></td>
  </tr>
  <tr>
    <td class="cuadro02">TIPO DE PARTO</td>
    <td class="cuadro01"><select name="cmbTIPOPARTO" id="cmbTIPOPARTO" >
      <option value="1">NORMAL</option>
      <option value="2">CESAREA</option>
    </select></td>
    <td class="cuadro02">LUGAR QUE OCUPA ENTRE LOS HERMANOS</td>
    <td class="cuadro01"><input name="num_hermano" type="text" id="num_hermano" size="10" maxlength="10" class="solo-numero"></td>
  </tr>
  <tr>
    <td class="cuadro02">CANTIDAD HERMANOS</td>
    <td class="cuadro01"><input name="cant_hermanos" type="text" id="cant_hermanos" size="10" maxlength="10" class="solo-numero"></td>
    <td class="cuadro02">RELIGION</td>
    <td class="cuadro01"><input type="text" name="religion" id="religion"></td>
  </tr>
  <tr>
   <td class="cuadro02">ETNIA</td>
    <td class="cuadro01">
    <select name="txt_etnia" id="txt_etnia">
    <option value="">Seleccione</option>
    <?php for($e=0;$e<pg_numrows($rs_etnia);$e++){
		$fila_etnia = pg_fetch_array($rs_etnia,$e);
		?>
     <option value="<?php echo $fila_etnia['nombre'] ?>"><?php echo $fila_etnia['nombre'] ?></option>
    <?php }?>
    
    </select></td>
    <td class="cuadro02">&nbsp;</td>
    <td class="cuadro01"><label for="religion"></label></td>
  </tr>
  <tr>
    <td width="121" class="cuadro02">DATOS DE INTERES</td>
    
    <td class="cuadro01" colspan="3">
      <textarea name="datos_de_interes" id="datos_de_interes"  style="width:350px;border:1; border-collapse:collapse;"></textarea>
      </td>
  </tr>

</table>


<table width="650" border="0" align="center">
  <tr> </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1"><strong><em>INFORMACIÓN DE LA MADRE</em></strong></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td width="150" class="cuadro02">R.U.T:</td>
    <td class="cuadro01">
      <input name="txtRUTM" type="text" id="txtRUTM" size="10" maxlength="9">
-
<input name="txtDIGRUTM" type="text" id="txtDIGRUTM" size="5" maxlength="1" onBlur="valida_rut_madre()">
   </td>
    <td class="cuadro02">ESTADO CIVIL</td>
    <td class="cuadro01"><select name="cmbESTADOCIVILM" id="cmbESTADOCIVILM">
      <option value="0">seleccione...</option>
      <option value="1">SOLTERO(A)</option>
      <option value="2">CASADO(A)</option>
      <option value="3">VIUDO(A)</option>
      <option value="4">DIVORCIADO(A)</option>
      <option value="5">OTRO</option>
    </select></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">NOMBRE :</td>
    <td width="200" class="cuadro01"><input name="txtNOMBREM" id="txtNOMBREM" type="text" onChange="conMayusculas(this)"></td>
    <td width="150" class="cuadro02">APELLIDO PATERNO:</td>
    <td width="159" class="cuadro01"><input name="txtAPEPATM" id="txtAPEPATM" type="text" onChange="conMayusculas(this)"></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">APELLIDO MATERNO:</td>
    <td width="200" class="cuadro01"><input name="txtAPEMATM" id="txtAPEMATM" type="text" onChange="conMayusculas(this)"></td>
    <td width="150" class="cuadro02">FECHA NAC:</td>
    <td class="cuadro01"><input name="txtFECHAMADRE" type="text" id="txtFECHAMADRE" size="10" maxlength="10"></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">DIRECCIÓN:</td>
    <td class="cuadro01"><input name="txtDIRECCIONM" type="text" onChange="conMayusculas(this)"></td>
    <td class="cuadro02">COMUNA:</td>
    <td class="cuadro01"><select name="cmbCOMUNAM" id="cmbCOMUNAM">
      <option value="0">seleccione...</option>
      <? for($i=0;$i<pg_numrows($rs_comuna);$i++){
			$fila_com = pg_fetch_array($rs_comuna,$i);?>
      <option value="<?=$fila_com['cod_reg'].",".$fila_com['cor_pro'].",".$fila_com['cor_com'];?>"><?=$fila_com['nom_com'];?></option> 
      
      <? } ?>
      </select></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">TELEFONOS:</td>
    <td class="cuadro01"><input type="text" name="txtFONOM" id="txtFONOM"></td>
    <td class="cuadro02">CELULAR:</td>
    <td class="cuadro01"><input type="text" name="txtCELULARM" id="txtCELULARM"></td>
  </tr>
  <tr>
    <td class="cuadro02">SEXO</td>
    <td class="cuadro01"><select name="cmbSEXOMADRE" id="cmbSEXOMADRE" >
    <option value="1">FEMENINO</option>
     <option value="2">MASCULINO</option>
      </select></td>
    <td class="cuadro02">&nbsp;</td>
    <td colspan="2" class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">NACIONALIDAD</td>
    <td class="cuadro01"><select name="cmbNACIONALIDADMADRE" id="cmbNACIONALIDADMADRE" >
      <option value="2">CHILENA</option>
      <option value="1">EXTRANJERA</option>
    </select></td>
    <td class="cuadro02">PAIS ORIGEN</td>
    <td colspan="2" class="cuadro01"><select name="cmbPAISORIGENMADRE" id="cmbPAISORIGENMADRE" style="width:148px">
      <option value="0">Seleccione</option>
      <?php for($pa=0;$pa<pg_numrows($rs_paises);$pa++){
		  $fpa = pg_fetch_array($rs_paises,$pa);
		  ?>
      <option value="<?php echo $fpa['id'] ?>"><?php echo $fpa['nombre'] ?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">E-MAIL</td>
    <td class="cuadro01"><input type="text" name="txtMAILM" id="txtMAILM" onChange="conMayusculas(this)"></td>
    <td class="cuadro02">RELIGION</td>
    <td class="cuadro01"><input type="text" name="txtRELIGIONM" id="txtRELIGIONM" onChange="conMayusculas(this)"></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">OCUPACIÓN ACTUAL:</td>
    <td class="cuadro01"><input type="text" name="txtOCUPACIONM" id="txtOCUPACIONM" onChange="conMayusculas(this)"></td>
    <td class="cuadro02">ESTUDIOS:</td>
    <td class="cuadro01"><input type="text" name="txtESTUDIOSM" id="txtESTUDIOSM" onChange="conMayusculas(this)"></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">SISTEMA DE SALUD</td>
    <td class="cuadro01">
	<select name="cmbSALUDM" id="cmbSALUDM" style="text-transform:uppercase">
    	<option value="0">seleccione...</option>
     <?php  for($i=0;$i<pg_numrows($rs_salud);$i++){
		 $fila_salud=pg_fetch_array($rs_salud,$i);
		 ?>
     <option value="<?php echo $fila_salud['id_sistema_salud'] ?>"><?php echo $fila_salud['sistema_salud'] ?></option>
     <?php }?>
    </select>
    </td>
    <td class="cuadro02">ULTIMO A&Ntilde;O APROBADO:</td>
    <td class="cuadro01"><label for="cmbULTIMOANOMADRE"></label>
      <select name="cmbULTIMOANOMADRE" id="cmbULTIMOANOMADRE">
         <option value="1ro BASICO" selected="selected">1ro BASICO</option>
        <option value="2do BASICO">2do BASICO</option>
        <option value="3ro BASICO">3ro BASICO</option>
        <option value="4to BASICO">4to BASICO</option>
        <option value="5to BASICO">5to BASICO</option>
        <option value="6to BASICO">6to BASICO</option>
        <option value="7mo BASICO">7mo BASICO</option>
        <option value="8vo BASICO">8vo BASICO</option>
        <option value="1ro MEDIO">1ro MEDIO</option>
        <option value="2do MEDIO">2do MEDIO</option>
        <option value="3ro MEDIO">3ro MEDIO</option>
        <option value="4to MEDIO">4to MEDIO</option>
        <option value="5to MEDIO">5to MEDIO</option>
        <option value="SUPERIOR">ENSEÑANZA SUPERIOR</option>
      </select></td>
  </tr>
  <tr>
    <td class="cuadro02">EDAD AL PRIMER PARTO</td>
    <td class="cuadro01"><input name="txtEDADPRIMERPARTO" type="text" id="txtEDADPRIMERPARTO" size="10" maxlength="10"></td>
    <td class="cuadro02">LUGAR DE TRABAJO</td>
    <td class="cuadro01"><input type="text" name="txtLUGARTRABAJOM" id="txtLUGARTRABAJOM" onChange="conMayusculas(this)"></td>
  </tr>
  <tr>
    <td class="cuadro02">TIPO TRABAJO</td>
    <td colspan="3" class="cuadro01"><select name="cmbTIPOTRABAJOM" id="cmbTIPOTRABAJOM">
      <option value="0">seleccione...</option>
      <option value="1">JORNADA COMPLETA</option>
      <option value="2">JORNADA PARCIAL</option>
      <option value="3">NO TRABAJA EN ESTE MOMENTO</option>
      <option value="4">NO ESTA TRABAJANDO PERO ESTA EN BUSQUEDA</option>
      <option value="5">OTRO</option>
    </select></td>
    </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1"><strong><em>INFORMACIÓN DEL PADRE</em></strong></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="cuadro02">R.U.T</td>
    <td  class="cuadro01"><input name="txtRUTP" type="text" id="txtRUTP" size="10" maxlength="9">
-
  <input name="txtDIGRUTP" type="text" id="txtDIGRUTP" size="5" maxlength="1" onBlur="valida_rut_padre()"></td>
    <td  class="cuadro02">ESTADO CIVIL</td>
    <td  class="cuadro01"><select name="cmbESTADOCIVILP" id="cmbESTADOCIVILP">
      <option value="0">seleccione...</option>
      <option value="1">SOLTERO(A)</option>
      <option value="2">CASADO(A)</option>
      <option value="3">VIUDO(A)</option>
      <option value="4">DIVORCIADO(A)</option>
      <option value="5">OTRO</option>
    </select></td>
    
  </tr>
  <tr>
    <td class="cuadro02">NOMBRES</td>
    <td class="cuadro01"><input name="txtNOMBREP" id="txtNOMBREP" type="text" onChange="conMayusculas(this)"></td>
    <td class="cuadro02">APELLIDO PATERNO</td>
    <td class="cuadro01"><input name="txtAPEPATP" id="txtAPEPATP"  type="text" onChange="conMayusculas(this)"></td>
  </tr>
  <tr>
    <td class="cuadro02">APELLIDO MATERNO</td>
    <td class="cuadro01"><input name="txtAPEMATP" id="txtAPEMATP" type="text" onChange="conMayusculas(this)"></td>
    <td class="cuadro02">FECHA NAC.</td>
    <td class="cuadro01"><input name="txtFECHAPADRE" type="text" id="txtFECHAPADRE" size="10" maxlength="10"></td>
  </tr>
  <tr>
    <td class="cuadro02">DIRECCIÓN</td>
    <td class="cuadro01"><input name="txtDIRECCIONP" type="text" id="txtDIRECCIONP" onChange="conMayusculas(this)"></td>
    <td class="cuadro02">COMUNA</td>
    <td class="cuadro01"><select name="cmbCOMUNAP" id="cmbCOMUNAP">
      <option value="0">SELECCIONE...</option>
      <? for($i=0;$i<pg_numrows($rs_comuna);$i++){
			$fila_com = pg_fetch_array($rs_comuna,$i);?>
      <option value="<?=$fila_com['cod_reg'].",".$fila_com['cor_pro'].",".$fila_com['cor_com'];?>">
        <?=$fila_com['nom_com'];?>
        </option>
      <? } ?>
    </select></td>
  </tr>
  <tr>
    <td class="cuadro02">TELEFONOS</td>
    <td class="cuadro01"><input name="txtFONOP" type="text" id="txtFONOP"></td>
    <td class="cuadro02">CELULAR</td>
    <td class="cuadro01"><input type="text" name="txtCELULARP" id="txtCELULARP"></td>
  </tr>
   <tr>
    <td class="cuadro02">SEXO</td>
    <td class="cuadro01"><select name="cmbSEXOPADRE" id="cmbSEXOPADRE" >
      <option value="2">MASCULINO</option>
      <option value="1">FEMENINO</option>
    </select></td>
    <td class="cuadro02">&nbsp;</td>
    <td colspan="2" class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">NACIONALIDAD</td>
    <td class="cuadro01"><select name="cmbNACIONALIDADPADRE" id="cmbNACIONALIDADPADRE" >
      <option value="2">CHILENA</option>
      <option value="1">EXTRANJERA</option>
    </select></td>
    <td class="cuadro02">PAIS ORIGEN</td>
    <td colspan="2" class="cuadro01"><select name="cmbPAISORIGENPADRE" id="cmbPAISORIGENPADRE" style="width:148px">
      <option value="0">Seleccione</option>
      <?php for($pa=0;$pa<pg_numrows($rs_paises);$pa++){
		  $fpa = pg_fetch_array($rs_paises,$pa);
		  ?>
      <option value="<?php echo $fpa['id'] ?>"><?php echo $fpa['nombre'] ?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td  class="cuadro02">E-MAIL</td>
    <td class="cuadro01"><input name="txtMAILP" type="text" id="txtMAILP"></td>
    <td class="cuadro02">ESTUDIOS</td>
    <td  class="cuadro01"><input type="text" name="txtESTUDIOSP" id="txtESTUDIOSP"></td>
  </tr>
   <tr>
    <td class="cuadro02">SEXO</td>
    <td class="cuadro01"><select name="cmbSEXOPADRE" id="cmbSEXOPADRE" >
      <option value="2">MASCULINO</option>
      <option value="1">FEMENINO</option>
    </select></td>
    <td class="cuadro02">&nbsp;</td>
    <td colspan="2" class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02"><p>OCUPACIÓN ACTUAL</p></td>
    <td class="cuadro01"><input name="txtOCUPACIONP" type="text" id="txtOCUPACIONP"></td>
    <td class="cuadro02">RELIGION</td>
    <td class="cuadro01"><input type="text" name="txtRELIGIONP" id="txtRELIGIONP"></td>
  </tr>
  <tr>
    <td class="cuadro02">SISTEMA DE SALUD</td>
    <td class="cuadro01"><select name="cmbSALUDP" id="cmbSALUDP" style="text-transform:uppercase">
      <option value="0">SELECCIONE...</option>
      <?php  for($i=0;$i<pg_numrows($rs_salud);$i++){
		 $fila_salud=pg_fetch_array($rs_salud,$i);
		 ?>
      <option value="<?php echo $fila_salud['id_sistema_salud'] ?>" ><?php echo $fila_salud['sistema_salud'] ?></option>
      <?php }?>
    </select></td>
    <td class="cuadro02">ULTIMO A&Ntilde;O APROBADO</td>
    <td  class="cuadro01"><select name="cmbULTIMOANOPADRE" id="cmbULTIMOANOPADRE">
      <option value="1ro BASICO" selected="selected">1ro BASICO</option>
        <option value="2do BASICO">2do BASICO</option>
        <option value="3ro BASICO">3ro BASICO</option>
        <option value="4to BASICO">4to BASICO</option>
        <option value="5to BASICO">5to BASICO</option>
        <option value="6to BASICO">6to BASICO</option>
        <option value="7mo BASICO">7mo BASICO</option>
        <option value="8vo BASICO">8vo BASICO</option>
        <option value="1ro MEDIO">1ro MEDIO</option>
        <option value="2do MEDIO">2do MEDIO</option>
        <option value="3ro MEDIO">3ro MEDIO</option>
        <option value="4to MEDIO">4to MEDIO</option>
        <option value="5to MEDIO">5to MEDIO</option>
        <option value="SUPERIOR">ENSEÑANZA SUPERIOR</option>
    </select></td>
    </tr>
  <tr>
    <td class="cuadro02">LUGAR DE TRABAJO</td>
    <td class="cuadro01"><input type="text" name="txtLUGARTRABAJOP" id="txtLUGARTRABAJOP" onChange="conMayusculas(this)"></td>
    <td class="cuadro02">TIPO TRABAJO</td>
    <td colspan="2" class="cuadro01"><select name="cmbTIPOTRABAJOP" id="cmbTIPOTRABAJOP">
      <option value="0">seleccione...</option>
      <option value="1">JORNADA COMPLETA</option>
      <option value="2">JORNADA PARCIAL</option>
      <option value="3">NO TRABAJA EN ESTE MOMENTO</option>
      <option value="4">NO ESTA TRABAJANDO PERO ESTA EN BUSQUEDA</option>
      <option value="5">OTRO</option>
    </select></td>
  </tr>
  <tr>
    <td class="cuadro02">NACIONALIDAD</td>
    <td class="cuadro01">&nbsp;</td>
    <td class="cuadro02">&nbsp;</td>
    <td colspan="2" class="cuadro01">&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1"><strong><em>APODERADOS</em></strong></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td width="73" class="cuadro02">TITULAR:</td>
    <td width="75" class="cuadro01"><input type="radio" name="rdAPODERADO" id="rdAPODERADO" value="1" checked>
      MADRE 
        <input type="radio" name="rdAPODERADO" id="rdAPODERADO" value="2">
        PADRE 
        </td>
    </tr>
  <tr>
    <td class="cuadro02">SUPLENTE</td>
    <td class="cuadro01"><input type="radio" name="suplente" id="suplente0" value="1"  onClick="datosuplente(0)">
MADRE
  <input type="radio" name="suplente" id="suplente1" value="2" checked  onClick="datosuplente(0)">
PADRE
<input type="radio" name="suplente" id="suplente2" value="3" onClick="datosuplente(1)">
OTRO</td>
    </tr>
  <tr style="border:0">
    <td colspan="2" class="dsuplente" >
   <table width="660" border="0">
  <tr>
    <td width="150" class="cuadro02">RUT</td>
    <td width="150"  class="cuadro01"><input name="txtRUTSUPLENTE" id="txtRUTSUPLENTE" type="text" size="10" maxlength="9" >
-
  <input name="txtDIGRUTSUPLENTE" id="txtDIGRUTSUPLENTE" type="text" size="5" maxlength="1" onBlur="valida_rut_suplente()"></td>
    <td width="150"  class="cuadro02">NOMBRES</td>
    <td class="cuadro01" ><input name="txtNOMBRESU" type="text" id="txtNOMBRESU"></td>
  </tr>
  <tr>
    <td class="cuadro02">APELLIDO PATERNO</td>
    <td  class="cuadro01"><input name="txtAPEPATSUP" type="text" id="txtAPEPATSUP"></td>
    <td  class="cuadro02">APELLIDO MATERNO</td>
    <td class="cuadro01" ><input name="txtAPEMATSUP" type="text" id="txtAPEMATSUP"></td>
  </tr>
  <tr>
    <td class="cuadro02">PARENTESCO</td>
    <td  class="cuadro01"><input name="txtPARENTEZCOSUP" type="text" id="txtPARENTEZCOSUP"></td>
    <td  class="cuadro02">COMUNA</td>
    <td class="cuadro01" ><select name="cmbCOMUNASUP" id="cmbCOMUNASUP">
      <option value="0">SELECCIONE...</option>
      <? for($i=0;$i<pg_numrows($rs_comuna);$i++){
			$fila_com = pg_fetch_array($rs_comuna,$i);?>
      <option value="<?=$fila_com['cod_reg'].",".$fila_com['cor_pro'].",".$fila_com['cor_com'];?>">
        <?=$fila_com['nom_com'];?>
        </option>
      <? } ?>
    </select></td>
  </tr>
   <tr>
    <td class="cuadro02">NACIONALIDAD</td>
    <td class="cuadro01"><select name="cmbNACIONALIDADOTRO" id="cmbNACIONALIDADOTRO" >
      <option value="2">CHILENA</option>
      <option value="1">EXTRANJERA</option>
    </select></td>
    <td class="cuadro02">PAIS ORIGEN</td>
    <td colspan="2" class="cuadro01"><select name="cmbPAISORIGENOTRO" id="cmbPAISORIGENOTRO" style="width:148px">
      <option value="0">Seleccione</option>
      <?php for($pa=0;$pa<pg_numrows($rs_paises);$pa++){
		  $fpa = pg_fetch_array($rs_paises,$pa);
		  ?>
      <option value="<?php echo $fpa['id'] ?>"><?php echo $fpa['nombre'] ?></option>
      <?php }?>
    </select></td>
  </tr>
    <td class="cuadro02">SEXO</td>
    <td class="cuadro01"><select name="cmbSEXOSUP" id="cmbSEXOSUP" >
      <option value="2">MASCULINO</option>
      <option value="1">FEMENINO</option>
    </select></td>
    <td class="cuadro02">&nbsp;</td>
    <td colspan="2" class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">DIRECCI&Oacute;N</td>
    <td  class="cuadro01"><input name="txtDIRECCIONSUP" type="text" id="txtDIRECCIONSUP"></td>
    <td  class="cuadro02">OCUPACI&Oacute;N ACTUAL</td>
    <td class="cuadro01" ><input type="text" name="txtOCUPACIONSUP" id="txtOCUPACIONSUP" onChange="conMayusculas(this)"></td>
  </tr>
  <tr>
    <td class="cuadro02">TELEFONO</td>
    <td  class="cuadro01"><input name="txtFONOSUP" type="text" id="txtFONOSUP"></td>
    <td  class="cuadro02">LUGAR DE TRABAJO</td>
    <td class="cuadro01" ><input type="text" name="txtLUGARTRABAJOSUP" id="txtLUGARTRABAJOSUP" onChange="conMayusculas(this)"></td>
  </tr>
  <tr>
    <td class="cuadro02">E-MAIL</td>
    <td  class="cuadro01"><input name="txtMAILSUP" type="text" id="txtMAILSUP"></td>
    <td  class="cuadro02">ULTIMO A&Ntilde;O APROBADO</td>
    <td class="cuadro01" ><select name="cmbULTIMOANOSUP" id="cmbULTIMOANOSUP">
      <option value="1ro BASICO" selected="selected">1ro BASICO</option>
      <option value="2do BASICO">2do BASICO</option>
      <option value="3ro BASICO">3ro BASICO</option>
      <option value="4to BASICO">4to BASICO</option>
      <option value="5to BASICO">5to BASICO</option>
      <option value="6to BASICO">6to BASICO</option>
      <option value="7mo BASICO">7mo BASICO</option>
      <option value="8vo BASICO">8vo BASICO</option>
      <option value="1ro MEDIO">1ro MEDIO</option>
      <option value="2do MEDIO">2do MEDIO</option>
      <option value="3ro MEDIO">3ro MEDIO</option>
      <option value="4to MEDIO">4to MEDIO</option>
      <option value="5to MEDIO">5to MEDIO</option>
      <option value="SUPERIOR">ENSE&Ntilde;ANZA SUPERIOR</option>
    </select></td>
  </tr>
   </table>

</td>

    </tr>
 
  <tr>
    <td class="cuadro02">ALUMNO CON QUIEN VIVE</td>
    <td class="cuadro01"><input type="text" name="txtCONQUIENVIVE" id="txtCONQUIENVIVE"></td>
    </tr>
  <tr>
    <td class="cuadro02">SITUACION CONYUGAL DE LOS PADRES</td>
    <td class="cuadro01">
      <select name="cmbESTADO" id="cmbESTADO">
        <option value="0">Seleccione..</option>
        <option value="1">Casado(a)</option>
        <option value="2">Separado(a)</option>
        <option value="3">Divorciado(a)</option>
        <option value="4">Viudo(a)</option>
        <option value="5">Convivientes</option>
      </select>
    </td>
    </tr>
</table><br>
<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1"><strong><em>INFORMACIÓN GENERAL</em></strong></td>
  </tr>
</table><br>
<table width="650" border="0" align="center">
 <tr>
    <td width="150" class="cuadro02">JEFE DE HOGAR</td>
    <td width="150" class="cuadro01"><label for="txtCONQUIENESTUDIA">
      <input type="text" name="txtJEFEHOGAR" id="txtJEFEHOGAR">
    </label></td>
    <td width="150" class="cuadro02">OCUPACION JEFE DE HOGAR</td>
    <td width="150" class="cuadro01"><input type="text" name="txtOCUPJEFEHOGAR" id="txtOCUPJEFEHOGAR"></td>
  </tr>
 <tr>
   <td class="cuadro02">NRO GRUPO FAMILIAR</td>
   <td class="cuadro01"><input type="text" name="txtNUMGRUPOFAMILAR" id="txtNUMGRUPOFAMILAR"></td>
   <td class="cuadro02">VIVIENDA</td>
   <td class="cuadro01"><select name="cmbTIPOVIVIENDA" id="cmbTIPOVIVIENDA">
   <option value="0">SELECCIONE...</option>
   <option value="1">PROPIA</option>
   <option value="2">ARRENDADA</option>
   <option value="3">ALLEGADOS</option>
   </select></td>
 </tr>
 <tr>
   <td class="cuadro02">MATERIAL VIVIENDA</td>
   <td class="cuadro01"><input type="text" name="material_vivienda" id="material_vivienda"></td>
   <td class="cuadro02">ESTADO VIVIENDA</td>
   <td class="cuadro01"><input type="text" name="estado_vivienda" id="estado_vivienda"></td>
 </tr>
 <tr>
   <td class="cuadro02">VIVIENDA TIENE LUZ</td>
   <td class="cuadro01"><input name="bool_tieneluz" type="radio"  value="0" checked>
NO
  <input type="radio" name="bool_tieneluz"  value="1">
SI</td>
   <td class="cuadro02">VIVIENDA TIENE AGUA</td>
   <td class="cuadro01"><input name="bool_tieneagua" type="radio"  value="0" checked>
NO
  <input type="radio" name="bool_tieneagua"  value="1">
SI</td>
 </tr>
 <tr>
   <td class="cuadro02">VIVIENDA TIENE ALCANTARILLADO</td>
   <td class="cuadro01"><input name="bool_tienealcantarillado" type="radio"  value="0" checked>
NO
  <input type="radio" name="bool_tienealcantarillado"  value="1">
SI</td>
   <td class="cuadro02">N&deg; FICHA PROTECCI&Oacute;N SOCIAL</td>
   <td class="cuadro01"><input type="text" name="txt_fichaps" id="txt_fichaps"></td>
 </tr>
 <tr>
   <td class="cuadro02">TOTAL DE INGRESOS<br>(n&uacute;mero)</td>
   <td class="cuadro01"><input type="text" name="txtINGRESOGRUPO" id="txtINGRESOGRUPO" class="solo-numero"></td>
   <td class="cuadro02">SISTEMA DE SALUD</td>
   <td class="cuadro01"><label for="cmbTIPOVIVIENDA">
     <select name="cmbSALUDP2" id="cmbSALUDP2" style="text-transform:uppercase">
       <option value="0">SELECCIONE...</option>
       <?php  for($i=0;$i<pg_numrows($rs_salud);$i++){
		 $fila_salud=pg_fetch_array($rs_salud,$i);
		 ?>
       <option value="<?php echo $fila_salud['id_sistema_salud'] ?>" ><?php echo $fila_salud['sistema_salud'] ?></option>
       <?php }?>
     </select>
   </label></td>
 </tr>
 <tr>
   <td class="cuadro02">CANTIDAD DE DORMITORIOS</td>
   <td class="cuadro01"><input type="text" name="txtCANTDORM" id="txtCANTDORM"></td>
   <td class="cuadro02">CANTIDAD BA&Ntilde;OS</td>
   <td class="cuadro01"><input type="text" name="txtCANTBANO" id="txtCANTBANO"></td>
 </tr>
 <tr>
   <td class="cuadro02">EXISTE FIGURA PATERNA &iquest;QUIEN?</td>
   <td class="cuadro01"><input type="text" name="txtFIGPATERNA" id="txtFIGPATERNA"></td>
   <td class="cuadro02">APORTA INGRESOS</td>
   <td class="cuadro01"><input name="jefe_aporta" type="radio" id="jefe_aporta0" value="0" checked>
NO
  <input type="radio" name="jefe_aporta" id="jefe_aporta0" value="1">
SI</td>
 </tr>
 <tr>
   <td class="cuadro02">HAY ESPACIO PARA EL ESTUDIO</td>
   <td class="cuadro01"><input name="espacio_estudio" type="radio" id="espacio_estudio0" value="0" checked>
NO
  <input type="radio" name="espacio_estudio" id="espacio_estudio1" value="1">
SI</td>
   <td class="cuadro02">HAY ESPACIO PARA JUGAR</td>
   <td class="cuadro01"><input name="espacio_juego" type="radio" id="espacio_juego0" value="0" checked>
NO
  <input type="radio" name="espacio_juego" id="espacio_juego1" value="1">
SI</td>
 </tr>
 <tr>
   <td class="cuadro02">PARTICIPA EN ORGANIZACION &iquest;CUAL?</td>
   <td class="cuadro01"><input type="text" name="txtORGANIZACION" id="txtORGANIZACION"></td>
   <td class="cuadro02">HIZO JARDIN, PRE KINDER O KINDER</td>
   <td class="cuadro01"><label for="txtORGANIZACION">
     <input name="hizo_jardin" type="radio" id="hizo_jardin0" value="0" checked>
NO
<input type="radio" name="hizo_jardin" id="hizo_jardin1" value="1">
SI</label></td>
 </tr>
 <tr>
   <td class="cuadro02">CON QUIEN ESTUDIA</td>
   <td class="cuadro01"><label for="txtCONQUIENESTUDIA"></label>
     <input type="text" name="txtCONQUIENESTUDIA" id="txtCONQUIENESTUDIA"></td>
   <td class="cuadro02">CUAN CARI&Ntilde;OSO ES</td>
   <td class="cuadro01"><label for="cmbCARINOSO"></label>
     <select name="cmbCARINOSO" id="cmbCARINOSO">
     <option value="0">SELECCIONE...</option>
     <option value="1">SIEMPRE</option>
      <option value="2">FRECUENTEMENTE</option>
      <option value="3">RARAS  VECES</option>
       <option value="4">CASI NUNCA</option>
       <option value="5">NUNCA</option>
     </select></td>
 </tr>
 <tr>
   <td class="cuadro02">CUAN SOCIABLE ES</td>
   <td class="cuadro01"><label for="cmbSOCIABLE"></label>
     <select name="cmbSOCIABLE" id="cmbSOCIABLE">
     <option value="0">SELECCIONE...</option>
     <option value="1">SIEMPRE</option>
      <option value="2">FRECUENTEMENTE</option>
      <option value="3">RARAS  VECES</option>
       <option value="4">CASI NUNCA</option>
       <option value="5">NUNCA</option>
     </select></td>
   <td class="cuadro02">CUAN CURIOSO ES</td>
   <td class="cuadro01"><label for="cmbCURIOSO"></label>
     <select name="cmbCURIOSO" id="cmbCURIOSO">
     <option value="0">SELECCIONE...</option>
     <option value="1">SIEMPRE</option>
      <option value="2">FRECUENTEMENTE</option>
      <option value="3">RARAS  VECES</option>
       <option value="4">CASI NUNCA</option>
       <option value="5">NUNCA</option>
     </select></td>
 </tr>
 <tr>
   <td class="cuadro02">SUBSIDIO UNICO</td>
   <td class="cuadro01"><input type="text" name="txt_subsidio" id="txt_subsidio"></td>
   <td class="cuadro02">BENEFICIO PROGRAMA SOCIAL</td>
   <td class="cuadro01"><input type="text" name="ben_prog_prot_social" id="ben_prog_prot_social"></td>
 </tr>
 <tr>
   <td class="cuadro02">NUM. CAUSA JUZGADO FAMILIA</td>
   <td class="cuadro01"><input type="text" name="txt_causajuzgado" id="txt_causajuzgado"></td>
   <td class="cuadro02">&nbsp;</td>
   <td class="cuadro01">&nbsp;</td>
 </tr>
 <tr>
   <td class="cuadro02">SACRAMENTOS RECIBIDOS</td>
   <td colspan="3" class="cuadro01"><input name="bool_bautismo" type="checkbox" id="bool_bautismo" value="1">
     BAUTISMO 
       <input name="bool_pcomunion" type="checkbox" id="bool_pcomunion" value="1">
P. COMUNI&Oacute;N
<input name="bool_confirmacion" type="checkbox" id="bool_confirmacion" value="1">
CONFIRMACI&Oacute;N </td>
   </tr>
 
 <tr>
   <td class="cuadro02">OBSERVACIONES</td>
   <td colspan="3" class="cuadro01"><textarea name="obse_general" id="obse_general"  style="width:350px;border:1; border-collapse:collapse;"></textarea></td>
   </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1"><strong><em>ANTECEDENTES ACADEMICOS</em></strong></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td width="250" class="cuadro02">HA REPETIDO CURSO</td>
    <td width="149" class="cuadro01">
    	<input type="radio" name="rdCURSOREP" id="rdCURSOREP" value="0" checked>NO 
        <input type="radio" name="rdCURSOREP" id="rdCURSOREP" value="1">SI        
        <input name="txtCURSOREP" type="text" id="txtCURSOREP"></td>
  </tr>
  
  <tr>
    <td width="250" class="cuadro02">PROCEDENCIA</td>
    <td width="149" class="cuadro01">
    <input name="txtPROCEDENCIA" type="text" id="txtPROCEDENCIA"></td>
  </tr>
  <tr>
    <td class="cuadro02">ELECCI&Oacute;N</td>
    <td class="cuadro01"><input name="txtELECCION" type="text" id="txtELECCION"></td>
  </tr>
  
  <tr>
    <td width="250" class="cuadro02">ESTA EN TRATAMIENTO CON ESPECIALISTA</td>
    <td class="cuadro01">
    <select name="cmbESPEC" id="cmbESPEC">
    	<option value="0">NO</option>
        <option value="1">SI,PSICOLOGO</option>
        <option value="2">SI,PSIQUIATRA</option>
        <option value="3">SI,FONOAUDILOGO</option>
        <option value="4">SI,PSICOPEDAGOGO</option>
        
    </select>
    </td>
  </tr>
  
  
  
  <tr>
    <td width="250" class="cuadro02">PERTECENE AL PROGRAMA DE INTEGRACIÓN ESCOLAR (PIE) </td>
    <td class="cuadro01"><input name="PIE" type="radio" id="PIE" value="0" checked>
      NO
        <input type="radio" name="PIE" id="PIE" value="1">
        SI</td>
  </tr>
  <tr>
    <td class="cuadro02">PERTENECE A SUBVENCION PREFERENCIAL (SEP)</td>
    <td class="cuadro01"><input name="SEP" type="radio" id="SEP" value="0" checked>
NO
  <input type="radio" name="SEP" id="SEP" value="1">
SI</td>
  </tr>
  <tr>
    <td class="cuadro02">PERTENECE A PROGRAMA DE ALIMENTACION ESCOLAR (PAE)</td>
    <td class="cuadro01"><input name="alim" type="radio" id="ALIM" value="0" checked>
NO
  <input type="radio" name="alim" id="ALIM" value="1">
SI</td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO CALIFICADO CON RETOS MULTIPLES</td>
    <td class="cuadro01"><input name="RETOS" type="radio" id="RETOS" value="0" checked>
NO
  <input type="radio" name="RETOS" id="RETOS" value="1">
SI</td>
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
SI</td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO (A) CON BECA PUENTE</td>
    <td class="cuadro01"><input name="PUENTE" type="radio" id="PUENTE" value="0" checked>
NO
  <input type="radio" name="PUENTE" id="PUENTE" value="1">
SI</td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO(A) CON FINANCIMIENTO COMPARTIDO</td>
    <td class="cuadro01"><input name="FINANCIMIENTO" type="radio" id="FINANCIMIENTO" value="0" checked>
NO
  <input type="radio" name="FINANCIMIENTO" id="FINANCIMIENTO" value="1">
SI</td>
  </tr>
  <tr>
    <td class="cuadro02">GRUPO DIFERENCIAL</td>
    <td class="cuadro01"><input name="bool_gdiferencial" type="radio" id="bool_gdiferencial0" value="0" checked>
NO
  <input type="radio" name="bool_gdiferencial" id="bool_gdiferencial1" value="1">
SI</td>
  </tr>
  <tr>
    <td width="250" class="cuadro02">PRESENTA ALGUNA SANCION <?=$nro_ano_ant;?></td>
    <td class="cuadro01">
    <select name="cmbSANCION" id="cmbSANCION">
    	<option value="0">NO</option>
        <option value="1">SI, DISCIPLINA</option>
        <option value="2">SI, RENDIMIENTO</option>
    </select>
    </td>
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
    <td class="tablatit2-1"><strong><em>ANTECEDENTES DE SALUD</em></strong></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td width="350" class="cuadro02">EL ALUMNO(A) SUFRE ALGUNA ENFERMEDAD IMPORTANTE EN LA ACTULIDAD</td>
    <td width="100" class="cuadro01">
    	<input name="ENFERMEDAD" type="radio" id="ENFERMEDAD" onClick="limpia(this.name)" value="0" checked>NO 
        <input type="radio" name="ENFERMEDAD" id="ENFERMEDAD" value="1" onClick="limpia(this.name)">SI
    </td>
    <td class="cuadro01"><input type="text" name="txtENFERMEDAD" id="txtENFERMEDAD" disabled ></td>
  </tr>
  <tr>
    <td class="cuadro02">EL ALUMNO (A) HA SIDO SOMETIDO A ALGUNA CIRUGIA</td>
     <td width="100" class="cuadro01">
    	<input name="CIRUGIA" type="radio" id="CIRUGIA" onClick="limpia(this.name)" value="0" checked>NO 
        <input type="radio" name="CIRUGIA" id="CIRUGIA" value="1" onClick="limpia(this.name)">SI
    </td>
    <td class="cuadro01"><input type="text" name="txtCIRUGIA" id="txtCIRUGIA" disabled></td>
  </tr>
  <tr>
    <td class="cuadro02">EL ALUMNO (A) TOMA ALGUN MEDICAMENTO EN FORMA PERIODICA</td>
     <td width="100" class="cuadro01">
    	<input name="MEDICAMENTO" type="radio" id="MEDICAMENTO" onClick="limpia(this.name)" value="0" checked>NO 
        <input type="radio" name="MEDICAMENTO" id="MEDICAMENTO" value="1" onClick="limpia(this.name)">SI
    </td>
    <td class="cuadro01"><input type="text" name="textMEDICAMENTO" id="txtMEDICAMENTO" disabled></td>
  </tr>
  <tr>
    <td class="cuadro02">EL ALUMNO(A) PRESENTA ALGUNA ALERGIA</td>
     <td width="100" class="cuadro01">
    	<input name="ALERGIA" type="radio" id="ALERGIA" onClick="limpia(this.name)" value="0" checked>NO 
        <input type="radio" name="ALERGIA" id="ALERGIA" value="1" onClick="limpia(this.name)">SI
    </td>
    <td class="cuadro01"><input type="text" name="textALERGIA" id="txtALERGIA" disabled></td>
  </tr>
  <tr>
    <td class="cuadro02">EL ALUMNO (A) TIENE ALGUN IMPEDIMENTO PARA REALIZAR EDUCACION FISICA</td>
     <td width="100" class="cuadro01">
        <input name="FISICA" type="radio" id="FISICA" onClick="limpia(this.name)" value="0" checked>NO 
        <input type="radio" name="FISICA" id="FISICA" value="1" onClick="limpia(this.name)">SI
    </td>
    <td class="cuadro01"><input type="text" name="textFISICA" id="txtFISICA" disabled></td>
  </tr>
  <tr>
    <td class="cuadro02">EL ALUMNO(A) PUEDE TOMAR ALGUN MEDICAMENTE EN CASO DE FIEBRE</td>
     <td width="100" class="cuadro01">
    	<input name="FIEBRE" type="radio" id="FIEBRE" onClick="limpia(this.name)" value="0" checked>NO 
        <input type="radio" name="FIEBRE" id="FIEBRE" value="1" onClick="limpia(this.name)">SI
    </td>
    <td class="cuadro01"><input type="text" name="textFIEBRE" id="txtFIEBRE" disabled></td>
  </tr>
  <tr>
    <td class="cuadro02">EL ALUMNO(A) TIENE ALGUN SEGURO DISTINTO DEL ESCOLAR</td>
     <td width="100" class="cuadro01">
    	<input name="SEGURO" type="radio" id="SEGURO" onClick="limpia(this.name)" value="0" checked>NO 
        <input type="radio" name="SEGURO" id="SEGURO" value="1" onClick="limpia(this.name)">SI
    </td>
    <td class="cuadro01"><input type="text" name="textSEGURO" id="txtSEGURO" disabled ></td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO PRESENTA PROBLEMAS DENTALES</td>
    <td class="cuadro01"><input name="probdentales" type="radio" id="probdentales"  value="0" checked>
      NO
        <input type="radio" name="probdentales" id="probdentales" value="1" >
        SI </td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO ESTA EN CONTROL DENTAL</td>
    <td class="cuadro01"><input name="CONTROLDENTAL" type="radio" id="CONTROLDENTAL" onClick="limpia(this.name)" value="0" checked>
      NO
        <input type="radio" name="CONTROLDENTAL" id="CONTROLDENTAL" value="1" >
        SI </td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">ULTIMO CONTROL SANO</td>
    <td class="cuadro01"><input type="text" name="txtCONTROLSANO" id="txtCONTROLSANO"  ></td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">FAMILIAR CON PROBLEMA DE SALUD, ENFERMEDAD O DISCAPACIDAD DIAGNOSTICADA</td>
    <td class="cuadro01"><input name="FAMILIARENFERMO" type="radio" id="FAMILIARENFERMO" onClick="limpia(this.name)" value="0" checked>
      NO
        <input type="radio" name="FAMILIARENFERMO" id="FAMILIARENFERMO" value="1" onClick="limpia(this.name)">
        SI </td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO(A) HA ESTADO EN TRATAMIENTO NEUROL&Oacute;GICO</td>
    <td class="cuadro01"><input name="bool_neurologo" type="radio" id="bool_neuro0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_neurologo" id="bool_neuro1" value="1" onClick="limpia(this.name)">
SI </td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO(A) ESTADO EN TRATAMIENTO PSICOPEDAG&Oacute;GICO</td>
    <td class="cuadro01"><input name="bool_psicopedagogo" type="radio" id="bool_psicopedagogo0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_psicopedagogo" id="bool_psicopedagogo1" value="1" onClick="limpia(this.name)">
SI </td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO HA ESTADO EN TRATAMIENTO PSICOL&Oacute;GICO</td>
    <td class="cuadro01"><input name="bool_psicologo" type="radio" id="bool_psicologo0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_psicologo" id="bool_psicologo1" value="1" onClick="limpia(this.name)">
SI </td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO HA ESTADO EN TRATAMIENTO PSIQUI&Aacute;TRICO</td>
    <td class="cuadro01"><input name="bool_psiquiatra" type="radio" id="bool_psiquiatra0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_psiquiatra" id="bool_psiquiatra1" value="1" onClick="limpia(this.name)">
SI </td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO EN TRATAMIENTO CON FONOAUDI&Oacute;LOGO</td>
    <td class="cuadro01"><input name="bool_fonoaudiologo" type="radio" id="bool_fonoaudiologo0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_fonoaudiologo" id="bool_fonoaudiologo1" value="1" onClick="limpia(this.name)">
SI </td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO PRESENTA PROBLEMAS DE VISI&Oacute;N</td>
    <td class="cuadro01"><input name="bool_pvision" type="radio" id="bool_pvision0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_pvision" id="bool_pvision1" value="1" onClick="limpia(this.name)">
SI </td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO PRESENTA PROBLEMAS DE AUDICI&Oacute;N</td>
    <td class="cuadro01"><input name="bool_paudicion" type="radio" id="bool_paudicion0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_paudicion" id="bool_paudicion1" value="1" onClick="limpia(this.name)">
SI </td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO PRESENTA PROBLEMAS A LA COLUMNA</td>
    <td class="cuadro01"><input name="bool_pcolumna" type="radio" id="bool_pcolumna0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_pcolumna" id="bool_pcolumna" value="1" onClick="limpia(this.name)">
SI </td>
    <td class="cuadro01">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">ALUMNO HA ESTADO EN OTRA CLASE DE TRATAMIENTOS</td>
    <td class="cuadro01"><input name="bool_otratamiento" type="radio" id="bool_otrotratamiento0" onClick="document.getElementById('txt_otratamiento').value='ninguna';document.getElementById('txt_otratamiento').setAttribute('disabled','disabled')" value="0" checked>
NO
  <input type="radio" name="bool_otratamiento" id="bool_otrotratamiento1" value="1" onClick="document.getElementById('txt_otratamiento').removeAttribute('disabled');document.getElementById('txt_otratamiento').value=''">
SI </td>
    <td class="cuadro01"><input name="txt_otratamiento" type="text" disabled id="txt_otratamiento" value="ninguna"  ></td>
  </tr>
  <tr>
    <td class="cuadro02">EN LA ACTUALIDAD SE ENCUENTRA ENTRATAMIENTO</td>
    <td class="cuadro01"><input name="bool_tratactual" type="radio" id="bool_tratactual0" onClick="document.getElementById('txttratactual').value='ninguna';document.getElementById('txttratactual').setAttribute('disabled','disabled')" value="0" checked>
NO
  <input type="radio" name="bool_tratactual" id="bool_tratactual1" value="1" onClick="document.getElementById('txttratactual').removeAttribute('disabled');document.getElementById('txttratactual').value=''">
SI </td>
    <td class="cuadro01"><input name="txttratactual" type="text" disabled id="txttratactual" value="ninguna" ></td>
  </tr>
  <tr>
    <td class="cuadro02">POSEE ANTECEDENTES DE TRASTORNOS DE APRENDIZAJE, D&Eacute;FICIT ATENCIONAL, OTROS</td>
    <td class="cuadro01"><input name="bool_trastornosaprendizaje" type="radio" id="bool_trastornos0" onClick="document.getElementById('txt_trastornosaprendizaje').value='ninguna';document.getElementById('txt_trastornosaprendizaje').setAttribute('disabled','disabled')" value="0" checked>
NO
  <input type="radio" name="bool_trastornosaprendizaje" id="bool_trastornos1" value="1" onClick="document.getElementById('txt_trastornosaprendizaje').removeAttribute('disabled');document.getElementById('txt_trastornosaprendizaje').value=''">
SI </td>
    <td class="cuadro01"><input name="txt_trastornosaprendizaje" type="text" disabled id="txt_trastornosaprendizaje" value="ninguna" ></td>
  </tr>
  <tr>
    <td width="350" class="cuadro02">OBSERVACI&Oacute;N DE SALUD</td>
    
    <td class="cuadro01" colspan="2">
      <textarea name="observacion_salud" id="observacion_salud"  style="width:350px;border:1; border-collapse:collapse;"></textarea>
      </td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center" >
  <tr>
    <td class="tablatit2-1"><p><strong><em>HERMANOS EN EL ESTABLECIMIENTO  <input type="button" onClick="nuevaFila();" value="Insertar fila"/>
    </em></strong> (nota: si el alumno a matricular es el primero de los hermanos, dejar este campo en blanco)</p> </td>
  </tr>
</table>
<br />

<div>
<table width="650" border="0" align="center" id="filas">
 <tr >
    <td width="150" class="cuadro02">CURSO</td>
    <td width="150" class="cuadro02">ALUMNO</td>
    <td width="150" class="cuadro02">&nbsp;</td>
    
  </tr>
</table>
</div>
<br>

<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1"><strong><em>EMERGENCIAS Y RETIROS</em></strong></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td width="218" class="cuadro02">AUTORIZA AL ESTABLECIMIENTO A SACAR A SU PUPILO EN CASIO DE EMERGENCIA DE SALUD</td>
    <td width="488" class="cuadro01"><input type="radio" name="autoriza_emergencia" id="autoriza_emergencia" value="0" checked>NO 
        <input type="radio" name="autoriza_emergencia" id="autoriza_emergencia" value="1" >SI</td>
  </tr>
  <tr>
    <td class="cuadro02">APODERADO AUTORIZA L ALUMNO A RETIRARSE SOLO DEL ESTABLECIMIENTO</td>
    <td class="cuadro01"><input type="radio" name="bool_retirosolo" id="bool_retirosolo0" value="0" checked>
      NO
        <input type="radio" name="bool_retirosolo" id="bool_retirosolo1" value="1" >
        SI</td>
  </tr>
  <tr>
    <td colspan="2" class="cuadro02">PERSONAS AUTORIZADAS PARA RETIRAR EL ALUMNO, EN CASO DE NO SER LOS PADRES O APODERADOS</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0">
      <tr>
        <td colspan="6" class="cuadro02">PERSONA AUTORIZADA 1</td>
        </tr>
      <tr>
        <td width="17%" class="cuadro02">R.U.T</td>
        <td width="22%" class="cuadro01"><input type="text" name="txtRUTRETIRA" id="txtRUTRETIRA"></td>
        <td width="13%" class="cuadro02">NOMBRE</td>
        <td colspan="3" class="cuadro01"><input type="text" name="txtNOMBRERETIRA" id="txtNOMBRERETIRA"></td>
        </tr>
      <tr>
        <td class="cuadro02">PARENTESCO</td>
        <td class="cuadro01"><input type="text" name="txtPARENTESCORETIRA" id="txtPARENTESCORETIRA"></td>
        <td class="cuadro02">TELEFONO</td>
        <td width="19%" class="cuadro01"><input type="text" name="txtFONORETIRA" id="txtFONORETIRA"></td>
        <td width="12%" class="cuadro02">CELULAR</td>
        <td width="17%" class="cuadro01"><input type="text" name="txtCELULARRETIRA" id="txtCELULARRETIRA"></td>
      </tr>
    </table>
    <table width="100%" border="0">
      <tr>
        <td colspan="6" class="cuadro02">PERSONA AUTORIZADA 2</td>
        </tr>
      <tr>
        <td width="17%" class="cuadro02">R.U.T</td>
        <td width="22%" class="cuadro01"><input type="text" name="txtRUTRETIRA2" id="txtRUTRETIRA2"></td>
        <td width="13%" class="cuadro02">NOMBRE</td>
        <td colspan="3" class="cuadro01"><input type="text" name="txtNOMBRERETIRA2" id="txtNOMBRERETIRA2"></td>
        </tr>
      <tr>
        <td class="cuadro02">PARENTESCO</td>
        <td class="cuadro01"><input type="text" name="txtPARENTESCORETIRA2" id="txtPARENTESCORETIRA2"></td>
        <td class="cuadro02">TELEFONO</td>
        <td width="19%" class="cuadro01"><input type="text" name="txtFONORETIRA2" id="txtFONORETIRA2"></td>
        <td width="12%" class="cuadro02">CELULAR</td>
        <td width="17%" class="cuadro01"><input type="text" name="txtCELULARRETIRA2" id="txtCELULARRETIRA2"></td>
      </tr>
    </table>
    <table width="100%" border="0">
      <tr>
        <td colspan="6" class="cuadro02">PERSONA AUTORIZADA 3</td>
        </tr>
      <tr>
        <td width="17%" class="cuadro02">R.U.T</td>
        <td width="22%" class="cuadro01"><input type="text" name="txtRUTRETIRA3" id="txtRUTRETIRA3"></td>
        <td width="13%" class="cuadro02">NOMBRE</td>
        <td colspan="3" class="cuadro01"><input type="text" name="txtNOMBRERETIRA3" id="txtNOMBRERETIRA3"></td>
        </tr>
      <tr>
        <td class="cuadro02">PARENTESCO</td>
        <td class="cuadro01"><input type="text" name="txtPARENTESCORETIRA3" id="txtPARENTESCORETIRA3"></td>
        <td class="cuadro02">TELEFONO</td>
        <td width="19%" class="cuadro01"><input type="text" name="txtFONORETIRA3" id="txtFONORETIRA3"></td>
        <td width="12%" class="cuadro02">CELULAR</td>
        <td width="17%" class="cuadro01"><input type="text" name="txtCELULARRETIRA3" id="txtCELULARRETIRA3"></td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td colspan="2"><table width="650" border="0">
      <tr>
        <td width="37%" rowspan="2" class="cuadro02">VIAJA EN TRANSPORTE ESCOLAR</td>
        <td colspan="2" class="cuadro01"><input type="radio" name="TRANSPORTE" id="TRANSPORTE" value="0" checked>NO 
        <input type="radio" name="TRANSPORTE" id="TRANSPORTE" value="1" >SI</td>
        <td width="16%">&nbsp;</td>
        <td width="15%">&nbsp;</td>
      </tr>
      <tr>
        <td width="20%" class="cuadro02">NOMBRE TIO</td>
        <td width="12%"><input type="text" name="txtTIOFURGON" id="txtTIOFURGON"></td>
        <td class="cuadro02">TELEFONO</td>
        <td><input type="text" name="txtFONOFURGON" id="txtFONOFURGON"></td>
      </tr>
    </table></td>
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
    <td class="cuadro02">INFORME DE NOTAS SEMESTRE ANTERIOR</td>
    <td class="cuadro01"><input name="bool_traeinfnotas" type="radio" id="bool_traeinformeanterior0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_traeinfnotas" id="bool_traeinformeanterior1" value="1" onClick="limpia(this.name)">
SI </td>
  </tr>
  <tr>
    <td class="cuadro02">INFORME PERSONALIDAD A&Ntilde;OS ANTERIORES</td>
    <td class="cuadro01"><input name="bool_infperso" type="radio" id="bool_infperso0"  value="0" checked>
NO
  <input type="radio" name="bool_infperso" id="bool_infperso1" value="1" >
SI </td>
  </tr>
  <tr>
    <td class="cuadro02">CERTIFICADOS DE ESTUDIOS A&Ntilde;OS ANTERIORES</td>
    <td class="cuadro01"><input name="bool_traecertificadosant" type="radio" id="bool_tracecertificadoanterior0" onClick="limpia(this.name)" value="0" checked>
NO
  <input type="radio" name="bool_traecertificadosant" id="bool_tracecertificadoanterior1" value="1" onClick="limpia(this.name)">
SI </td>
  </tr>
  <tr>
    <td class="cuadro02">N&deg; BOLETA</td>
    <td class="cuadro01"><input name="txtNUMBOLETA" id="txtNUMBOLETA" type="text" size="5" maxlength="1" ></td>
  </tr>
  <tr>
    <td class="cuadro02">APORTE VOLUNTARIO CGP</td>
    <td class="cuadro01"><input name="txtaporteCGP" id="txtaporteCGP" type="text" size="5" maxlength="1" ></td>
  </tr>
  <tr>
    <td class="cuadro02">FOTOS (cantidad)</td>
    <td class="cuadro01"><input name="txtCANTFOTOS" id="txtCANTFOTOS" type="text" size="5" maxlength="1" ></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1" colspan="2"><strong><em>AUTORIZACIONES</em></strong></td>
  </tr>
  </table>
  <table width="650" border="0" align="center">
  <tr>
    <td width="325" class="cuadro02">CAMBIAR ROPA EN CASO DE SER NECESARIO</td>
    <td width="328" colspan="4" class="cuadro01"><input name="bool_cambioropa" type="radio" id="bool_cambioropa0"  value="0" checked>
NO
  <input type="radio" name="bool_cambioropa" id="bool_cambioropa1" value="1" >
SI </td>
  </tr>
  <tr>
    <td width="325" class="cuadro02">TOMAR FOTOGRAF&Iacute;AS/VIDEOS EN ACTIVIDADES ESCOLARES</td>
    <td colspan="4" class="cuadro01"><input name="bool_tomafoto" type="radio" id="bool_tomafoto0"  value="0" checked>
NO
  <input type="radio" name="bool_tomafoto" id="bool_tomafoto1" value="1" >
SI </td>
  </tr>
  <tr>
    <td width="325" class="cuadro02">COMPARTIR FOTOGRAF&Iacute;AS EN FACEBOOK DE LA ESCUELA</td>
    <td colspan="4" class="cuadro01"><input name="bool_facebook" type="radio" id="bool_facebook0"  value="0" checked>
NO
  <input type="radio" name="bool_facebook" id="bool_facebook1" value="1" >
SI </td>
  </tr>
  <tr>
    <td class="cuadro02">APLICAR VACUNAS EN EL ESTABLECIMIENTO</td>
    <td colspan="4" class="cuadro01"><input name="aut_vacuna" type="radio" id="aut_vacuna0"  value="0" checked>
NO
  <input type="radio" name="aut_vacuna" id="aut_vacuna1" value="1" >
SI </td>
  </tr>
  </table>

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
