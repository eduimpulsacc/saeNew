<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 1;
	$nro_ano=date("Y");
	
		if (!$ano){?>
	<script>
	alert ('Es posible que no tenga un año Seleccionado\r\no simplemente no existe ningun año escolar para la institucion \r\n');
	window.location= '../listarAno.php3';
</script>	
	
	<? exit;
		
	}

?>		


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="../../../clases/jquery-ui-1.8.14.custom/development-bundle/demos/demos.css">
<script type="text/javascript" src="../../../clases/jquery-ui-1.8.14.custom/development-bundle/jquery-1.5.1.js"></script>

<script language="javascript">
$(document).ready(function() {
	
	 $( "#txtFECHAINIPS,#txtFECHAINISS,#txtFECHAINIPT,#txtFECHAINIST,#txtFECHAINITT,#txtFECHATERPS,#txtFECHATERSS,#txtFECHATERPT,#txtFECHATERST,#txtFECHATERTT" ).datepicker({
    'dateFormat':'dd-mm-yy',
	firstDay: 1,
	changeMonth: true,
	//changeYear: true,
	
    //buttonImage: "../../../clases/img_jquery/Calendario.PNG",
   // buttonImageOnly: true,
	//yearRange: "<?php echo $nro_ano ?>:<?php echo $nro_ano ?>",
	minDate: new Date('<?php echo $nro_ano ?>/01/01'),
	maxDate: new Date('<?php echo $nro_ano ?>/12/31'),
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

<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
	
<LINK REL="STYLESHEET" HREF="../../../../<?=$_ESTILO?>" TYPE="text/css">

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						$menu_lateral=2;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             
										
						
								  
							 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
									
									<table height="30" border="0" cellpadding="0" cellspacing="0">
 						 <tr> 
    <td height="30" align="center" valign="top"> 
      
	   
	  
	  
	   </td>
  </tr>
</table>
	<center>
		                              <table BORDER="0" CELLSPACING="1" CELLPADDING="3" width="80%">
                                        <TR height=15> 
                                          <TD COLSPAN=3> <TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 width="100%">
                                              <TR> 
                                                <TD width="28%" class="textonegrita"> AÑO ESCOLAR</TD>
                                                <TD width="3%" class="textonegrita"> :</TD>
                                                <TD width="32%" class="textonegrita"> <? echo $nro_ano;?></TD>
                                                <td width="37%" align="right"><input name="GUARDAR" type="button" class="botonXX" id="GUARDAR" value="GUARDAR"></td>
                                              </TR>
                                            </TABLE>
                                            </TD>
                                        </TR>
                                        <tr height="20"> 
                                          <td align="middle" colspan="3" class="tableindex">Per&iacute;odos Semestral</td>
                                        </tr>
                                        <tr > 
                                          <td align="center" class="tablatit2-1">NOMBRE </td>
                                          <td align="center" class="tablatit2-1">FECHA INICIO </td>
                                          <td align="center" class="tablatit2-1">FECHA TERMINO </td>
										 </tr>
                                      
                                      
                                      <TR>
                                          <td align="left" class="textosimple"> PRIMER SEMESTRE</td>
                                          <td align="center"><label for="textfield"></label>
                                            <INPUT type="text" name="txtFECHAINIPS" id="txtFECHAINIPS" size="10" maxlength="10" onChange="chkFecha(form.txtFECHAINIPS,'Fecha inicio invalida.');" readonly></td>
                                          <td align="center"><INPUT type="text" name="txtFECHATERPS" id="txtFECHATERPS" size=10 maxlength=10 onChange="chkFecha(form.txtFECHATERPS,'Fecha termino invalida.');" readonly></td>
                                          <td align="center">&nbsp;</td>
                                        
                                        </tr>
                                        <TR>
                                          <td align="left" class="textosimple">SEGUNDO SEMESTRE</td>
                                          <td align="center"><label for="textfield"></label>
                                            <INPUT type="text" name="txtFECHAINISS" id="txtFECHAINISS" size="10" maxlength="10" onChange="chkFecha(form.txtFECHAINISS,'Fecha inicio invalida.');" readonly></td>
                                          <td align="center"><INPUT type="text" name="txtFECHATERSS" id="txtFECHATERSS" size=10 maxlength=10 onChange="chkFecha(form.txtFECHATERSS,'Fecha termino invalida.');" readonly></td>
                                         
                                        
                                        </tr>
                                		
                                        <tr><td>&nbsp;</td></tr>
                                         <tr height="20"> 
                                          <td align="middle" colspan="3" class="tableindex">Per&iacute;odos Trimestral</td>
                                        </tr>
                                        <tr > 
                                          <td align="center" class="tablatit2-1">NOMBRE </td>
                                          <td align="center" class="tablatit2-1">FECHA INICIO </td>
                                          <td align="center" class="tablatit2-1">FECHA TERMINO </td>
										 </tr>
                                      
                                      
                                      <TR>
                                          <td align="left" class="textosimple"> PRIMER TRIMESTRE</td>
                                          <td align="center"><label for="textfield"></label>
                                            <INPUT type="text" name="txtFECHAINIPT" id="txtFECHAINIPT" size="10" maxlength="10" onChange="chkFecha(form.txtFECHAINIPT,'Fecha inicio invalida.');" readonly></td>
                                          <td align="center"><INPUT type="text" name="txtFECHATERPT" id="txtFECHATERPT" size=10 maxlength=10 onChange="chkFecha(form.txtFECHATERPT,'Fecha termino invalida.');" readonly></td>
                                          <td align="center">&nbsp;</td>
                                        
                                        </tr>
                                        <TR>
                                          <td align="left" class="textosimple">SEGUNDO TRIMESTRE</td>
                                          <td align="center"><label for="textfield"></label>
                                            <INPUT type="text" name="txtFECHAINIST" id="txtFECHAINIST" size="10" maxlength="10" onChange="chkFecha(form.txtFECHAINIST,'Fecha inicio invalida.');" readonly></td>
                                          <td align="center"><INPUT type="text" name="txtFECHATERST" id="txtFECHATERST" size=10 maxlength=10 onChange="chkFecha(form.txtFECHATERST,'Fecha termino invalida.');" readonly></td>
                                         
                                        
                                        </tr>
                                        <TR>
                                          <td align="left" class="textosimple">TERCER TRIMESTRE</td>
                                          <td align="center"><INPUT type="text" name="txtFECHAINITT" id="txtFECHAINITT" size="10" maxlength="10" onChange="chkFecha(form.txtFECHAINITT,'Fecha inicio invalida.');" readonly></td>
                                          <td align="center"><INPUT type="text" name="txtFECHATERTT" id="txtFECHATERTT" size=10 maxlength=10 onChange="chkFecha(form.txtFECHATERTT,'Fecha termino invalida.');" readonly></td>
                                        </tr>
                                      </table>
		                              <br>
	</center>
									
									
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
									
									
									
								  </td>
							    </tr>
							 </table>							  
								  
								  
								  
								  
		
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php");?></td>
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
<? pg_close ($conn);?>