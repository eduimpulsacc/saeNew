<?
require('../../../../../../util/header.inc');
include('../../../../../clases/class_MotorBusqueda.php');
//setlocale("LC_ALL","es_ES");


	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$fin_ano		=$check_ano;
	$reporte		=$c_reporte;
	$_POSP = 6;
	$_bot = 8;
	
		
?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../../clases/jquery-ui-1.8.14.custom/development-bundle/ui/jquery.ui.core.js"></script>
<script type="text/javascript" src="../../../../../clases/jquery-ui-1.8.14.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="../../../../../clases/jquery-ui-1.8.14.custom/development-bundle/demos/demos.css">
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
//-->
</script>
<script>
$( document ).ready(function() {
    $( "#desde,#hasta" ).datepicker({
    'dateFormat':'dd/mm/yy',
	firstDay: 1,
	 changeMonth: true,
      changeYear: true,
	//yearRange: "2000:<?php echo date("Y") ?>",
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ]
		 
   
	
});
});
</script>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 36px;
	font-weight: bold;
}
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								 

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA --><center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
<!-- FIN CUERPO DE LA PAGINA -->
<!-- INICIO FORMULARIO DE BUSQUEDA -->
<form action="printcuentaDescargas.php" method="post" name="form" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<? 

$institucion	=$_INSTIT;
$ano			=$_ANO;

$ob_motor = new MotorBusqueda();
//$ob_motor ->ano = $ano;
$ob_motor ->rdb =$institucion;
$resultado_query_cue = $ob_motor ->Ano($conn);
?>
<center>
<table width="686" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="674">
	<table width="684" height="43" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="680" class="tableindex">Buscador Avanzado </span></td>
  </tr>
  <tr>
    <td height="27">
	<table width="684" border="0" cellspacing="0" cellpadding="0">
  <tr class="cuadro01">
    <td width="110" >Fecha Desde
    </td>
    <td width="327" class="cuadro01"><input type="text" name="desde" id="desde"></td>
    
    <td width="10">&nbsp;</td>
    <td width="237" align="center">
      <div align="center">
		<input name="cb_ok" class="botonXX"  type="submit" value="Buscar" onClick="javascript:location.reload();">
		<input name="cb_ok2" class="botonXX"  type="button" value="Volver" onClick="window.location='../../Menu_Reportes_new2.php'">										        
      </div>
      </td>
  </tr>
  <tr class="cuadro01">
    <td >Fecha Hasta</td>
    <td class="cuadro01"><input type="text" name="hasta" id="hasta"></td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
  </tr>
    </table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>
 
 
<!-- FIN FORMULARIO DE BUSQUEDA -->

                                  </td>
                                </tr>
                              </table>
 								  								  
								 
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>