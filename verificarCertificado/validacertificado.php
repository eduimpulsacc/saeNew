<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Validaci&oacute;n Certificados</title>
<link rel="stylesheet" type="text/css" href="styles.css"/>
<script type="text/javascript" src="../admin/clases/jquery/jquery.js"></script>
<script>
function certifica(){
	$("#msgr").html("");
	 
	var codigo = $("#codigo").val();
	if(codigo.length==0 || codigo==" "){
		alert("Ingrese c\u00F3digo de verificaci\u00F3n");
	}
	else{
		
		var parametros='funcion=1&codigo='+codigo;
	//alert(parametros);
		$.ajax({
	  url:'cont_validar.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// alert(data);
	    $("#msgr").html(data);
		 $(".tbl").html("");
		  }
	  })
	}
}
</script>

</head>

<body class="main">

<table  width="426" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
<img src="logo_colegio_accesos.png" width="386" height="102" /></td>
  </tr>
</table>
<br />
<table class="tbl" width="426" border="0" align="center" cellpadding="0" cellspacing="0">
 
  <tr>
    <td><h3 class="top-1 p0">Validaci&oacute;n de certificados</h3></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong><span id="lbl_etiqueta_fecha">Ingrese c&oacute;digo de verificaci&oacute;n</span></strong></td>
  </tr>
  <tr>
    <td><input name="codigo" type="text" id="codigo" size="50" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="button" name="button" class="button" value="Validar" onclick="certifica()" /></td>
  </tr>
  <tr>
    <td></td>
  </tr>
</table>
<div id="msgr"></div>
</body>
</html>