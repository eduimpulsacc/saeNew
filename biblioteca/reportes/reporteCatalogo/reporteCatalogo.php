<?php 
require("../../../util/header.php");
session_start();
$_POSP=3; 
$tipof=4;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin1" />
<link  rel="shortcut icon" href="../../../images/icono_sae_33.png">
<link href="../../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../../cabecera_new/css2.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../../menu_new/css/styles.css">
<link href="../../../cortes/<?=$_INSTIT;?>/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../admin/clases/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script>

<script>

function act(paso){
	 var tipo = $("input[name='radio']:checked").val();
	 
	 
	  if(tipo==0){
		$('#form').attr('action', 'printDevUsuario.php');
	 }
	 else if(tipo==1){
		$('#form').attr('action', 'printDevLibro.php');
	 }
	 
	 if(paso==0){
		 $('#form').submit();
	 }
	
	 
	
}

function cargaC(){
var funcion=5;
var tipo=$("#cmb_tipo").val();
var parametros = "funcion="+funcion+"&tipo="+tipo;
	
	$.ajax({
	  url:'../filtro/cont_filtro.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#cmb").html(data);
		  }
	  })
}

</script>
<title>SISTEMA SAE:====> PLANIFICACION</title>
</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
   	<td rowspan="3" valign="top" background="../../../cortes/<?=$_INSTIT;?>/fondo_01_reca.jpg" width="50"  height="900"></td>
   	<td colspan="2" align="center" valign="top" height="70"><? include("../../../cabecera_new/head_biblio.php");?></td>
    <td rowspan="3" background="../../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td valign="top" align="left"><? include("../../../menu_new/menu_biblio.php");?></td>
    <td valign="top" align="center"><br />
    <table width="95%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
      <tr>
        <td width="5%" colspan="4"><br />
        <form method="post"  name="form" action="printReporteCatalogo.php" target="_blank" id="form">
         <table width="75%" border="0" cellpadding="3" align="center">
              <tr>
                <td  class="titulos-respaldo">CAT&Aacute;LOGO LIBROS</td>
            </tr>
            <tr><td >   
            <table width="100%" border="0" cellpadding="3" align="center">
              <tr>
                <td width="14%" class="cuadro02">Filtrar por</td>
                <td width="3%" align="center" class="cuadro02">:</td>
                <td width="22%" class="cuadro01"><select name="cmb_tipo" id="cmb_tipo" onchange="cargaC();">
                  <option value="0" selected="selected">Todos</option>
                  <option value="1">Categor&iacute;a</option>
                  <option value="2">Editorial</option>
                  <option value="3">Autor</option>
                </select></td>
                <td width="61%" class="cuadro01"><div id="cmb"><select name="cmb_fil" id="cmb_fil" onchange="cargaC();">
                  <option value="0" selected="selected">Todos</option>
                 
                </select></div></td>
              </tr>
              <tr><td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr><td colspan="4" align="right"><input type="submit" name="button" id="button" value="Enviar Datos" ></td>
                </tr>
              
             </table>
              
              </td></tr>
            <tr>
            </tr>
            </table>
       
        </form>
                                  <br />


        
        </td>
      </tr>
      </table>
    
    </td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
</table>
<? include("../../../cabecera_new/footer2.html");?>



</body>

</html>
