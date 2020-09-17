<?php 
	require('../../../../../util/header.inc');
	
	$_POSP   =5;
	
?>
<!doctype html>

<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
</HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="../../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>

<script type="text/javascript">

$(document).ready(function(){
	Inicio();
});

function Inicio(){
	var parametros="funcion=1";

	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#curso").html(data);
		NroAno();
		  }
	  })		
}

function NroAno(){
	var parametros="funcion=4";
	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#nroano").html(data);
		  }
	  })	
}
function BuscaAlumno(){
	var curso = $("#cmbCURSO").val();
	var parametros="funcion=2&curso="+curso;
	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#alumno").html(data);
		  }
	  })
		
}
function Listado(){
	var curso = $("#cmbCURSO").val();
	var alumno =$("#cmbALUMNO").val();
	var parametros="funcion=3&curso="+curso+"&alumno="+alumno;
	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#tabla").html(data);
		  }
	  })
}
function NuevoRetiro(){
	var curso =$("#cmbCURSO").val();
	var alumno=$("#cmbALUMNO").val();
	if(curso==0 || alumno==0){
		alert("DEBE SELECCIONAR ALUMNO A RETIRAR");	
	}
	var parametros="funcion=5&curso="+curso+"&alumno="+alumno;
	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#tabla").html(data);
		  }
	  })
	
}

function GuardarRetiro(){
	var ano =<?=$_ANO;?>;
	var curso =$("#cmbCURSO").val();
	var alumno=$("#cmbALUMNO").val();
	var fecha =$("#txtFECHAS").val();
	var hora_ingreso = $("#txtHORAINGRESO").val();
	var hora_regreso = $("#txtHORAREGESO").val();
	var empleado = $("#cmbEMPLEADO").val();
	var motivo = $("#txtMOTIVO").val();
	var retira = $("#txtRETIRA").val();
	
	var parametros="funcion=6&ano="+ano+"&curso="+curso+"&alumno="+alumno+"&fecha="+fecha+"&hora_ing="+hora_ingreso+"&hora_egr="+hora_regreso+"&empleado="+empleado+"&motivo="+motivo+"&retira="+retira;
	
	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==1){
			  Listado();
		  }else{
			alert("ERROR EN INGRESO");
		  }

		  }
	  })
}

function Eliminar(id){
	var parametros="funcion=7&id_retiro="+id;
	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==1){
			  Listado();
		  }else{
			alert("ERROR EN INGRESO");
		  }

		  }
	  })
		
}
function Modificar(id){
	var parametros="funcion=8&id_retiro="+id;
	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#tabla").html(data);
		  }
	  })
		
}

function ModificaRetiro(id){
	var ano =<?=$_ANO;?>;
	var curso =$("#cmbCURSO").val();
	var alumno=$("#cmbALUMNO").val();
	var fecha =$("#txtFECHAS").val();
	var hora_ingreso = $("#txtHORAINGRESO").val();
	var hora_regreso = $("#txtHORAREGESO").val();
	var empleado = $("#cmbEMPLEADO").val();
	var motivo = $("#txtMOTIVO").val();
	var retira = $("#txtRETIRA").val();
	
	var parametros="funcion=9&ano="+ano+"&curso="+curso+"&alumno="+alumno+"&fecha="+fecha+"&hora_ing="+hora_ingreso+"&hora_egr="+hora_regreso+"&empleado="+empleado+"&motivo="+motivo+"&retira="+retira+"&id_retiro="+id;
	
	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		   if(data==1){
			  Listado();
		  }else{
			alert("ERROR EN MODIFICACION");
		  }

		  }
	  })	
}

function VistaPrevia(id){
	var parametros="funcion=10&id_retiro="+id;
	$.ajax({
	  url:'cont_retiros.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 $("#vista").html(data);
		 $("#vista").dialog({ 
					autoOpen:true,
					width:700,
					height:300,
					modal:true,
					buttons: {
					    'Cerrar': function(){ $(this).dialog('close');}
					 }
			   });
		  }
	  })
		
}
</script>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?php $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="200" valign="top"><!-- inicio codigo antiguo -->
								  
						  			<table width="650" border="0" style="border-collapse:collapse" align="center">
                                      <tr>
                                        <td width="112" class="textonegrita">AÑO</td>
                                        <td width="27" class="textonegrita">&nbsp;:&nbsp;</td>
                                        <td width="497" class="textosimple">&nbsp;<div id="nroano"><?=$nro_ano;?></div></td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">CURSO</td>
                                        <td class="textonegrita">&nbsp;:&nbsp;</td>
                                        <td><div id="curso">
                                        <select name="cmbCURSO" id="cmbCURSO" onChange="BuscaAlumno()">
                                            <option value="0">seleccione...</option>
                                         </select>
                                        </div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td class="textonegrita">ALUMNO</td>
                                        <td class="textonegrita">&nbsp;:&nbsp;</td>
                                        <td>
                                        <div id="alumno">
                                        <select name="cmbALUMNO" id="cmbALUMNO">
                                            <option value="0">seleccione...</option>
                                        </select>
                                        </div>
                                        </td>
                                      </tr>
                                    </table>	
                                                                        
                                    <div id="tabla">&nbsp;</div>
                                    <div id="vista" title="Detalle de Retiro">&nbsp;</div>
			  
								  <!-- fin codigo -->
								   </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
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
