<?php 
require("../../../util/header.php");
require("../clases.php");

session_start();
$_POSP=3; 
$tipof=2;

$ob_prestamo = new Reporte();

//$actualiza = $ob_prestamo->ActualizaRegistro($conn,$_ANO);
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
<script>

function act(paso){
	 var tipo = $("input[name='radio']:checked").val();
	 
	 
	  if(tipo==0){
		$('#form').attr('action', 'printPrestamoUsuario.php');
	 }
	 else if(tipo==1){
		$('#form').attr('action', 'printPrestamoLibro.php');
	 }
	  else if(tipo==2){
		$('#form').attr('action', 'printPrestamoTodo.php');
	 }
	 
	 if(paso==0){
		 $('#form').submit();
	 }
	
	 
	
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
        <form method="post"  name="form" target="_blank" id="form">
         <table width="75%" border="0" cellpadding="3" align="center">
              <tr>
                <td  class="titulos-respaldo">REPORTE PRESTAMO LIBROS</td>
            </tr>
            <tr><td > <? include("../filtro/filtro.php"); ?></td></tr>
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
    <td colspan="2"><? include("../../../cabecera_new/footer2.html");?></td>
  </tr>
  <tr>
    <td colspan="2"></td>
  </tr>
</table>



</body>

</html>
