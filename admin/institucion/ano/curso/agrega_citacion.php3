<?php 	require('../../../../util/header.inc');?>
<?php 
    
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$cmb_curso=$_REQUEST["cmb_curso"];
	$_PERFIL;
	$_POSP          =4;
	$_MDINAMICO     =1;
	if($_PERFIL==26)
	{
		$_MDINAMICO     =0;		
	}	
	?>

	  		<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
     function enviapag(form){
		    var curso; 
			curso=document.form.cmb_curso.value;
			
 			if (document.form.cmb_curso.value!=0){
			    document.form.cmb_curso.target="self";
				pag="citacion.php3"
				document.form.action = pag;
				document.form.submit(true);	
			}		
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
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	color: #FF0000;
}
.Estilo3 {color: #FF0000}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral=2; include ("../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top"><!-- inicio codigo nuevo -->
								  
		  
								  
								  
			 <FORM method="post" name="form" action="procesa_citacion.php">
	
	        <input type="hidden" value="<?=$institucion ?>" name="rdb">
			<input type="hidden" value="<?=$ano ?>" name="ano">
	         
			<TABLE WIDTH=85% BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
			<TR>
				<TD colspan="2" align="center" class="tableindex"><center>CITACI&Oacute;N APODERADOS</center></TD>
			</TR>
			<TR height=15>
				
      <TD width="27%" height="36" class="textosimple">FECHA&nbsp;</TD>
	  <TD width="73%" textosimple><input name="fecha" type="text" id="fecha">
	    (AAAA-MM-DD)</TD>
			</TR>
			
			<TR height=15>
				
      <TD width="27%" height="40" class="textosimple">ASISTE A LA CITACION:</TD>
	  <TD width="73%">    <select name="cmb_confirm" class="ddlb_x">
	  								<option selected>Elegir Opci�n</option>
								  <option value=0 >No</option>
								  <option value=1 >Si</option>
						</select>
								  </TD>
			</TR>
			
			<TR height=15>
				
      <TD width="27%" class="textosimple" valign="top">OBSERVACI&Oacute;N:</TD>
	  <TD width="73%"><textarea name="txtobservacion" cols="35" rows="7" id="txtobservacion"></textarea></TD>
			</TR>
			<tr>
			<td colspan="3">&nbsp;</td>
			</tr>
			<TR height=15>
			  <TD colspan="2" align="center"><input type="submit" name="Submit" value="Enviar" class="botonXX"></TD>
			  </TR>
			
			
			
	  </TABLE>
	</FORM>
								  
								  
								  
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>"><font face="arial, geneva, helvetica" size=2><strong><?php echo trim($fCurso2['nro_ano']); ?></strong></font></td>
        </tr>
      </table></td>
  </tr>
</table>
<? pg_close($conn); ?>
</body>
</html>