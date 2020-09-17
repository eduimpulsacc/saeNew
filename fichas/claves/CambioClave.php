<?php 
require('../../util/header.inc');


	//--------------------------------
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
    $alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$_POSP          =2;
	//-------------------------------
	$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
	$result =@pg_Exec($conn,$qry);
	$fila = @pg_fetch_array($result,0);	
	$nro_ano=$fila['nro_ano'];

	$sql="SELECT nombre_alu ||' '|| ape_pat ||' '|| ape_mat AS nombre FROM alumno WHERE rut_alumno=".$alumno;
	$rs_alumno = pg_exec($conn,$sql);
	$nombre_alumno = pg_result($rs_alumno,0);
	
	
	
?>
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link rel="stylesheet" type="text/css" href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css">
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script language="JavaScript" type="text/JavaScript">



$(document).ready(function(){
	inicio();
	
});

function inicio(){
	var parametros ="funcion=1";

	$.ajax({
	  url:'cont_clave.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
		// alert(data);
		$("#tabla").html(data);
		  }
	  })	
}

function guardar(){
	
	if($("#txtNEWCLAVE").val()==$("#txtNEWCLAVE2").val()){
		var claveANT = $("#txtCLAVE").val();
		var claveNEW = $("#txtNEWCLAVE").val();	
		var claveNEW2 = $("#txtNEWCLAVE2").val();
		var usuario = <?=$_NOMBREUSUARIO;?>;
		var parametros ="funcion=2&usuario="+usuario+"&claveant="+claveANT+"&clavenew="+claveNEW+"&clavenew2="+claveNEW2;
		
		$.ajax({
		  url:'cont_clave.php',
		  data:parametros,
		  type:'POST',
		  success:function(data){
			 //console.log(data);
			 //alert(data);
			if(data==1){
				alert("CLAVE MODIFICADA CORRECTAMENTE");
				inicio();
				
			}else{
				alert("ERRROR AL MODIFICAR");
			}
			  }
		  })	
	}else{
		alert("CLAVES NO COINCIDEN");
		$("#txtNEWCLAVE").val("");		
		$("#txtNEWCLAVE2").val("");
		$("#txtNEWCLAVE").focus();
	}
}
function valida(){

	var claveANT = $("#txtCLAVE").val();
	var usuario = <?=$_NOMBREUSUARIO;?>;
	var parametros ="funcion=3&usuario="+usuario+"&claveant="+claveANT;
	//alert(parametros);	
	$.ajax({
	  url:'cont_clave.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		if(data==0){
			alert("CLAVE NO CORRESPONDE");
			$("#txtCLAVE").val("");
			$("#txtCLAVE").focus();
		
		}
		  }
	  })	
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" width="50" height="" rowspan="3" background="../../cortes/<?=$institucion;?>/fondo_01_reca.jpg"></td>
    <td colspan="2" height="50" valign="top"><? include("../../cabecera_new/head_sae.php"); ?></td>
    <td width="50" rowspan="3" background="../../cortes/<?=$institucion;?>/fomdo_02_reca.jpg">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" height="25%" width="%"> <? include("../../menu_new/menu_alu_apo.php"); ?></td>
    <td valign="top" height="50%" ><br>

    <table width="95%" border="0" class="cajaborde" align="center">
  <tr>
    <td>&nbsp;
    <div id="tabla">&nbsp;</div>
    
    <br>
    <img src="../../cortes/10774/sombra.png" width="885" height="32">
	</td>
  </tr>
</table><br>


    </td>
  </tr>
  <tr>
    <td colspan="2" align="center" height="89">&nbsp;<img src="../../cabecera_new/img/abajo.jpg" width="1140" height="89" border="0" /></td>
  </tr>
</table>

</body>
</html>
