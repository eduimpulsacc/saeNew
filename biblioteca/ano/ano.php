<?php 
require("../../util/header.php");
session_start();
$_POSP=3; 
//echo "->".$_ANO;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<link href="../../menu_new/head.css" rel="stylesheet" type="text/css" />
<link href="../../cabecera_new/css.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../../menu_new/css/styles.css">
<link href="../../cortes/0/estilos.css" rel="stylesheet" type="text/css"> 
<link href="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.css" rel="stylesheet" type="text/css"> 
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
<script type="text/javascript" src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>


<script type="text/javascript">
$( document ).ready(function() {
   listaAnos();
});

function listaAnos(){
var funcion=1;
var rdb= <?php echo $_INSTIT; ?>;
var parametros = "funcion="+funcion+"&rdb="+rdb;
	  $.ajax({
			url:"cont_ano.php",
			data:parametros,
			type:'POST',
			success:function(data){
			//console.log(data);
					if(data == 0){
					   alert("Error al cargar");
					}else{
					 $("#tabla").html(data);
					}
		        }
		    })

}

function seteaAno(ano,nro_ano){
var funcion=2;
var rdb= <?php echo $_INSTIT; ?>;
var parametros = "funcion="+funcion+"&rdb="+rdb+"&ano="+ano+"&nro_ano="+nro_ano;
if(confirm("\u00BFSeguro que desea cambiar el a\u00F1o de trabajo?")){
  $.ajax({
			url:"cont_ano.php",
			data:parametros,
			type:'POST',
			success:function(data){
			//console.log(data);
			alert("A\u00F1o "+nro_ano+" queda como abierto");
			location.reload();
					
		        }
		    })
}
}
</script>


<title>SISTEMA SAE:====> BIBLIOTECA</title>
</head>

<body leftmargin="0" marginheight="0" rightmargin="0" marginwidth="0" >

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="3" valign="top" background="../../cortes/<?=$_INSTIT;?>/fondo_01_reca.jpg" width="50"  height="900"></td>
    <td colspan="2" align="left" valign="top" height="70"><? include("../../cabecera_new/head.php");?></td>
    <td rowspan="3" background="../../cortes/<?=$_INSTIT;?>/fomdo_02_reca.jpg" width="53" height="900"></td>
  </tr>
  <tr>
    <td valign="top" align="left"><? include("../../menu_new/menu_biblio.php");?></td>
    <td valign="top" align="center"><br />
    <table width="95%" border="0" cellpadding="0" cellspacing="0" class="cajaborde" >
    <tr>
    	<td width="5%" colspan="4"><br /><div id="tabla">&nbsp;</div></td>
    </tr>
    </table>
	
</td>
  </tr>
  <tr>
    <td colspan="2" valign="bottom"><? include("../../cabecera_new/footer.html");?></td>
  </tr>
</table>


</body>

</html>
