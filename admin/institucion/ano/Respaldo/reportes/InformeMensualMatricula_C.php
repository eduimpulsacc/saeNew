<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');


	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$reporte		= $c_reporte;
	$docente		= 5; //Codigo Docente
	
     
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script>
	function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
	</script>
	
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'RegistroMatricula.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
									
</script>
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="top"><table width="100%"><tr><td><?
				include("../../../../cabecera/menu_superior.php");
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
						include("../../../../menus/menu_lateral.php");
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
                                  <td>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES --><!-- FIN CODIGO DE BOTONES -->
                                

<!-- INICIO FORMULARIO DE BUSQUEDA -->
<?

?>
<form method "post" action="printInformeMensualMatricula_C.php" target="_blank" name="form">
<input type="hidden" name="c_reporte" value="<?=$reporte;?>">
<? 

$ob_motor = new MotorBusqueda();
$ob_motor->ano = $ano;
$resultado = $ob_motor ->Ensenanza($conn);

//------------------

?>
<center>
<table width="709" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="705">
	<table width="705" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="701" class="tableindex">Total de Matriculados del establecimiento en el mes </td>
  </tr>
  <tr class="cuadro01">
    <td >Seleccione Mes 
      <select name="cmb_mes" >
        <option value="0">--Seleccione Mes--</option>
		<option value="3">Marzo</option>
		<option value="4">Abril</option>
		<option value="5">Mayo</option>
		<option value="6">Junio</option>
		<option value="7">Julio</option>
		<option value="8">Agosto</option>
		<option value="9">Septiembre</option>
		<option value="10">Octubre</option>
		<option value="11">Noviembre</option>
		<option value="12">Diciembre</option>
      </select></td>
  </tr>
  <tr class="cuadro01">
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td height="27">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="cuadro01">
	  
	    <div align="center">
	      <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Imprimir Informe">
	      <input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
	    </div>
	    <div align="right"></div></td>
    </tr>
</table>	</td>
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
                        </table>
						
					</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table>
               </td>
              </tr>
            </table>
          </td>

         
          <td width="53" height="1024" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
