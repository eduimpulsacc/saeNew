<?php require('../../../../util/header.inc');
if ($_PLANTILLA==""){
	$_PLANTILLA	=$plantilla;
	if (!session_is_registered('_PLANTILLA')){
		session_register('_PLANTILLA');
	}
}
$area		=$_AREA;
$concepto	=$_CONCEPTO;
$_POSP = 4;
$_bot = 7;


//exit;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
	function valida(form){
		if(form.txtplantilla.value=="") {alert("DEBE COMPLETAR DATOS DE PLANTILLA"); var sale=0;}
		if(form.txtarea.value=="") {alert("DEBE COMPLETAR DATOS DE AREAS"); var sale=0;}
		//if(form.txtconcepto.value=="") {alert("DEBE COMPLETAR DATOS DE CONCEPTOS DE EVALUACIÓN"); var sale=0;}
		if (sale!=0){
			form.sgte.target="self";
			form.action="plantillaPaso2.php";
			form.submit(true);
		}
	}

</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="90" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral = 2;
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
								  <br>
							 <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
							
							
							<?php if($_PERFIL!=17){?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      
	  <?
						 include("../../../../cabecera/menu_inferior.php");
						 ?>
	  
	  
	  
	  
	   </td>
  </tr>
</table>
<?php } ?>

<form action="plantillaPaso2.php" method="post">
  <table width="520" border="0" align="center">
    <tr> 
      <td colspan="3" class="tableindex"><div align="center">CREAR PLANTILLA DE INFORME</div></td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp; </td>
    </tr>
    <tr> 
      <td colspan="3"><font size="2" face="Arial, Helvetica, sans-serif">1ro.- 
        Datos Plantilla</font></td>
    </tr>
    <tr> 
      <td colspan="3"> 
        <?php 
		if($_PLANTILLA!=""){
			$srcP="creaPlantilla.php?creada=1&plantilla=$_PLANTILLA";
		}else{
			$srcP="creaPlantilla.php";
		}
		?>
        <fieldset style="border-color:#003b85">
        <legend><font size="2" face="Arial, Helvetica, sans-serif"><strong>Plantilla</strong></font></legend>
		<iframe id="iframe0" name="iframe0" src="<?php echo $srcP; ?>" frameborder="0" style="width:100%; height:220%;"></iframe>
        </fieldset>
        &nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3">&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="3" bordercolor="#003b85"><font size="2" face="Arial, Helvetica, sans-serif"> 
        2do.- Crear las Areas de Evaluaci&oacute;n.</font> </td>
    </tr>
    <tr> 
      <td> 
        <?php 
		if($area!=""){
			$srcA="../areaModifica/creaArea.php?creada=1&plantilla=$_PLANTILLA";
		}else{
			$srcA="../areaModifica/area.php";
		}
		?>
        <fieldset style="border-color:#003b85">
        <legend><font size="2" face="Arial, Helvetica, sans-serif"><strong>Areas</strong></font></legend>
        <iframe id="iframe0" name="iframe0" src="<?php echo $srcA; ?>" frameborder="0" style="width:100%; height:100%;"></iframe>
        &nbsp; 
        </fieldset></td>
    </tr>
    <tr> 
      <td>&nbsp; </td>
    </tr>
<!--     <tr> 
      <td colspan="3"><font size="2" face="Arial, Helvetica, sans-serif"> 3ro.- 
        Crear los Conceptos Evaluativos.(S&Oacute;LO SI NECESITA AGREGAR)</font></td>
    </tr>
    <tr> 
	 
      <td colspan="3" bordercolor="#003b85">
	  <?php 
		/*if($concepto!=""){
			$srcC="../conceptoModifica/creaConcepto.php?creada=1";
		}else{
			$srcC="../conceptoModifica/creaConcepto.php";
		}*/
		?>
		<fieldset style="border-color:#003b85">
        <legend><font size="2" face="Arial, Helvetica, sans-serif"><strong>Conceptos</strong></font></legend>
        <iframe id="iframe0" name="iframe0" src="<?php //echo $srcC; ?>" frameborder="0" style="width:100%; height:100%;"></iframe>
        &nbsp; </fieldset></td>
    </tr>
    <tr> 
 -->      <td colspan="3">
	    <input type="hidden" name="txtplantilla" value="<?php echo $_PLANTILLA?>">
        <input type="hidden" name="txtarea" value="<?php echo $_AREA?>">
<!--         <input type="hidden" name="txtconcepto" value="<?php //echo $_CONCEPTO?>">
 -->		</td>
    </tr>
    <tr> 
      <td colspan="3" align="right">
<input class="botonXX"  type="button" name="sgte" value="SIGUIENTE >>" onClick="valida(this.form)"></td>
    </tr>
    <tr> 
      <td colspan="3" align="right">&nbsp; </td>
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
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="90" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
