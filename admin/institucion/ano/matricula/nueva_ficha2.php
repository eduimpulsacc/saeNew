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
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../../../clases/jqueryui/jquery-ui-1.8.6.custom.css">
<script language="javascript" src="../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script language="javascript" src="../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script language="javascript" src="../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
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

	$("#txtFECHA").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
	//buttonImage: 'img/Calendario.PNG',
	});
	$.datepicker.regional['es']	
 

	$("#txtFECHAMAT").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
	//buttonImage: 'img/Calendario.PNG',
	});
	$.datepicker.regional['es']	
 

	$("#txtFECHAMADRE").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
	//buttonImage: 'img/Calendario.PNG',
	});
	$.datepicker.regional['es']	
   

	$("#txtFECHAPADRE").datepicker({
	showOn: 'both',
	changeYear:true,
	changeMonth:true,
	dateFormat: 'dd-mm-yy',
	yearRange: "1900:<?php echo date("Y") ?>"
	//buttonImage: 'img/Calendario.PNG',
	});
	$.datepicker.regional['es']	
	
	
	
	
	
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

			
			var comuna = $('#comuna_hidden').val();
			$("#cmbCOMUNA option[value="+comuna+"]").attr("selected",true);
			
			var nacionalidad = $('#nac_hidden').val();
			$("#cmbNACIONALIDAD option[value="+nacionalidad+"]").attr("selected",true);
			
			var sexo = $('#sexo_hidden').val();
			$("#cmbGENERO option[value="+sexo+"]").attr("selected",true);
			
			var etnia = $('#etnia_hidden').val();
			$("#txt_etnia option[value="+etnia+"]").attr("selected",true);
			
			alert("Existen datos en Sistema");
			}else{
				//alert("No Existen Datos");
				
				}			

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
		  
		  if($('#txtFECHAMADRE').val()=="")
		  {
			 alert("Ingrese Fecha de nacimiento");	
			 document.form.txtFECHAMADRE.focus();
		     return false;   
		  }
		  
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
		  
		  if($('#txtFECHAPADRE').val()=="")
		  {
			 alert("Ingrese Fecha de nacimiento");	
			 document.form.txtFECHAPADRE.focus();
		     return false;   
		  }
		  
		   if($('#cmbCOMUNAP').val()==0)
		  {
			 alert("Seleccione Comuna");	
			 document.form.cmbCOMUNAP.focus();
		     return false;   
		  }
	  }
	  document.form.method="POST";
	  document.form.submit();
	  form.action="procesoMatriculaNueva.php";
 }
 
 
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
 
</SCRIPT>
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
     <form name="form" id="form" action="procesoMatriculaNueva.php" >
     <table width="650" border="0" align="center">
       <tr>
         <td align="right">
         
		
          <? if($_CONVENIOID!="" || $_PERFIL==0){?>
				 <INPUT class="botonXX"  TYPE="submit" value="VALIDAR EN SIGE" name="btnGuardarSige" onClick="valida(this.form)" >          
		  <? } ?>
		<?php if($_PERFIL==0){ ?>
		 <input type="submit" name="GUARDAR" id="GUARDAR" value="GUARDAR E IMPRIMIR" class="botonXX">
          <? } ?>
          
         
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
    <select name="cmbCURSO" id="cmbCURSO">
    	<option value="0">seleccione...</option>
	<? for($i=0;$i<pg_numrows($rs_curso);$i++){
            $fila_c = pg_fetch_array($rs_curso,$i);
	?>
    <option value="<?=$fila_c['id_curso'];?>"><?=CursoPalabra($fila_c['id_curso'],0,$conn);?></option>					
    <? } ?>
			
    </select>
    </td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">NRO. MATRICULA :</td>
    <td class="cuadro01"><input name="txtNROMATRICULA" type="text" size="10" maxlength="4" value="<?=$nro_matricula;?>"></td>
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
    <td width="150" class="cuadro02">R.U.T.</td>
    <td colspan="4" class="cuadro01"><input name="txtRUT" id="txtRUT" type="text" size="10" maxlength="9" onClick="borra_dig()"> - <input name="txtDIGRUT" id="txtDIGRUT" type="text" size="5" maxlength="1" onBlur="valida_rut()"></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">NOMBRE</td>
    <td width="200"class="cuadro01"><input name="txtNOMBRE" id="txtNOMBRE" type="text" onChange="conMayusculas(this)"></td>
    <td width="150" class="cuadro02">APELLIDO PATERNO</td>
    <td width="65" class="cuadro01"><input name="txtAPEPAT" id="txtAPEPAT" type="text" onChange="conMayusculas(this)" ></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02"> APELLIDO MATERNO</td>
    <td width="200" class="cuadro01"><input name="txtAPEMAT" id="txtAPEMAT" type="text" onChange="conMayusculas(this)" ></td>
    <td width="150" class="cuadro02">FECHA DE NAC.</td>
    <td class="cuadro01"><input name="txtFECHA" type="text" id="txtFECHA" size="10" maxlength="10" readonly></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">DIRECCIÓN</td>
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
    <td width="150" class="cuadro02">TELEFONO</td> 
    <td width="200" class="cuadro01"><input name="txtFONO" id="txtFONO" type="text"></td> 
    <td width="150" class="cuadro02">NACIONALIDAD</td> 
    <td class="cuadro01"> 
    <select name="cmbNACIONALIDAD" id="cmbNACIONALIDAD" > 
        <option value="2">CHILENA</option>
        <option value="1">EXTRANJERA</option>
  	</select>
	</td>
  </tr>
  <tr>
    <td class="cuadro02">GENERO</td>
    <td class="cuadro01">
    	<select name="cmbGENERO" id="cmbGENERO">
    		<option value="2">MASCULINO</option>
            <option value="1">FEMENINO</option>
        </select>
    </td>
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
  </tr>
  
  <tr>
    <td width="250" class="cuadro02">DATOS DE INTERES</td>
    
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
    <td colspan="3" class="cuadro01">
      <input name="txtRUTM" type="text" id="txtRUTM" size="10" maxlength="9">
-
<input name="txtDIGRUTM" type="text" id="txtDIGRUTM" size="5" maxlength="1" onBlur="valida_rut_madre()">
   </td>
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
    <td width="150" class="cuadro02">E-MAIL</td>
    <td class="cuadro01"><input type="text" name="txtMAILM" id="txtMAILM" onChange="conMayusculas(this)"></td>
    <td class="cuadro02">ESTUDIOS:</td>
    <td class="cuadro01"><input type="text" name="txtESTUDIOSM" id="txtESTUDIOSM" onChange="conMayusculas(this)"></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">OCUPACIÓN ACTUAL:</td>
    <td class="cuadro01"><input type="text" name="txtOCUPACIONM" id="txtOCUPACIONM" onChange="conMayusculas(this)"></td>
    <td class="cuadro02">RELIGION</td>
    <td class="cuadro01"><input type="text" name="txtRELIGIONM" id="txtRELIGIONM" onChange="conMayusculas(this)"></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">SISTEMA DE SALUD</td>
    <td colspan="3" class="cuadro01">
	<select name="cmbSALUDM" id="cmbSALUDM" style="text-transform:uppercase">
    	<option value="0">seleccione...</option>
     <?php  for($i=0;$i<pg_numrows($rs_salud);$i++){
		 $fila_salud=pg_fetch_array($rs_salud,$i);
		 ?>
     <option value="<?php echo $fila_salud['id_sistema_salud'] ?>"><?php echo $fila_salud['sistema_salud'] ?></option>
     <?php }?>
    </select>
    </td>
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
    <td width="150" class="cuadro02">R.U.T</td>
    <td colspan="4"  class="cuadro01"><input name="txtRUTP" type="text" id="txtRUTP" size="10" maxlength="9">
-
  <input name="txtDIGRUTP" type="text" id="txtDIGRUTP" size="5" maxlength="1" onBlur="valida_rut_padre()"></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">NOMBRES</td>
    <td width="150" class="cuadro01"><input name="txtNOMBREP" id="txtNOMBREP" type="text" onChange="conMayusculas(this)"></td>
    <td width="150" class="cuadro02">APELLIDO PATERNO</td>
    <td width="150" class="cuadro01"><input name="txtAPEPATP" id="txtAPEPATP"  type="text" onChange="conMayusculas(this)"></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">APELLIDO MATERNO</td>
    <td width="150" class="cuadro01"><input name="txtAPEMATP" id="txtAPEMATP" type="text" onChange="conMayusculas(this)"></td>
    <td width="150" class="cuadro02">FECHA NAC.</td>
    <td width="150" class="cuadro01"><input name="txtFECHAPADRE" type="text" id="txtFECHAPADRE" size="10" maxlength="10"></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">DIRECCIÓN</td>
    <td width="150" class="cuadro01"><input name="txtDIRECCIONP" type="text" id="txtDIRECCIONP" onChange="conMayusculas(this)"></td>
    <td width="150" class="cuadro02">COMUNA</td>
    <td width="150" class="cuadro01"><select name="cmbCOMUNAP" id="cmbCOMUNAP">
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
    <td width="150" class="cuadro02">TELEFONOS</td>
    <td width="150" class="cuadro01"><input name="txtFONOP" type="text" id="txtFONOP"></td>
    <td width="150" class="cuadro02">CELULAR</td>
    <td width="150" class="cuadro01"><input type="text" name="txtCELULARP" id="txtCELULARP"></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02"><p>E-MAIL</p></td>
    <td width="150" class="cuadro01"><input name="txtMAILP" type="text" id="txtMAILP"></td>
    <td width="150" class="cuadro02">ESTUDIOS</td>
    <td width="150" class="cuadro01"><input type="text" name="txtESTUDIOSP" id="txtESTUDIOSP"></td>
  </tr>
  <tr>
    <td width="150" class="cuadro02">OCUPACIÓN ACTUAL</td>
    <td width="150" class="cuadro01"><input name="txtOCUPACIONP" type="text" id="txtOCUPACIONP"></td>
    <td width="150" class="cuadro02">RELIGION</td>
    <td colspan="2" class="cuadro01"><input type="text" name="txtRELIGIONP" id="txtRELIGIONP"></td>
    </tr>
  <tr>

    <td width="150" class="cuadro02">SISTEMA DE SALUD</td>
    <td colspan="3" class="cuadro01"><select name="cmbSALUDP" id="cmbSALUDP" style="text-transform:uppercase">
      <option value="0">SELECCIONE...</option>
         <?php  for($i=0;$i<pg_numrows($rs_salud);$i++){
		 $fila_salud=pg_fetch_array($rs_salud,$i);
		 ?>
     <option value="<?php echo $fila_salud['id_sistema_salud'] ?>" ><?php echo $fila_salud['sistema_salud'] ?></option>
     <?php }?>
    </select></td>
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
    <td class="cuadro02">TITULAR:</td>
    <td class="cuadro01"><input type="radio" name="rdAPODERADO" id="rdAPODERADO" value="1" checked>
      MADRE 
        <input type="radio" name="rdAPODERADO" id="rdAPODERADO" value="2">
        PADRE 
        </td>
    </tr>
  <tr>
    <td class="cuadro02">SUPLENTE</td>
    <td class="cuadro01"><input type="radio" name="suplente" id="suplente0" value="1">
MADRE
  <input type="radio" name="suplente" id="suplente1" value="2" checked>
PADRE
<input type="radio" name="suplente" id="suplente2" value="3">
OTRO</td>
    </tr>
  <tr>
    <td class="cuadro02">ALUMNO VIVE CON APODERADO</td>
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
    <td width="250" class="cuadro02">OBSERVACI&Oacute;N DE SALUD</td>
    
    <td class="cuadro01" colspan="2">
    <textarea name="observacion_salud" id="observacion_salud"  style="width:350px;border:1; border-collapse:collapse;"></textarea>
    </td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td class="tablatit2-1"><strong><em>EMERGENCIAS Y RETIROS</em></strong></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td width="476" class="cuadro02">AUTORIZA AL ESTABLECIMIENTO A SACAR A SU PUPILO EN CASIO DE EMERGENCIA DE SALUD</td>
    <td class="cuadro01"><input type="radio" name="AUTORIZA" id="AUTORIZA" value="0" checked>NO 
        <input type="radio" name="AUTORIZA" id="AUTORIZA" value="1" >SI</td>
  </tr>
  <tr>
    <td colspan="2" class="cuadro02">PERSONAS AUTORIZADAS PARA RETIRAR EL ALUMNO, EN CASO DE NO SER LOS PADRES O APODERADOS</td>
  </tr>
  <tr>
    <td colspan="2"><table width="100%" border="0">
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
    </table></td>
  </tr>
  
  <tr>
    <td colspan="2"><table width="100%" border="0">
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
