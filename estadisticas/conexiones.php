<?php 
	require('../util/header.inc');
	
	
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="widgets/calendar-brown.css" title="green"/>
<script language="javascript" src="Calendario/javascripts.js"></script>
<script language="JavaScript" src="widgets/calendar.js"></script>
<script language="JavaScript" src="widgets/calendar-setup.js"></script>
<script language="JavaScript" src="widgets/lang/calendar-es.js"></script>
<SCRIPT type="text/javascript" src="estadisticas/js/mootools.js"></SCRIPT>
<SCRIPT type="text/javascript" src="estadisticas/js/moodalbox.js"></SCRIPT>
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
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<script language="javascript">
function visible(){
	if(document.form.rd_periodo[0].checked==true){
		document.form.cmbMES.style.visibility='visible';
		capa0.style.display='none';
		capa1.style.display='none';
	}else if(document.form.rd_periodo[1].checked==true){
		document.form.cmbMES.style.visibility='hidden';
		capa0.style.display='block';
		capa1.style.display='none';
	}else if(document.form.rd_periodo[2].checked==true){
		document.form.cmbMES.style.visibility='hidden';
		capa0.style.display='none';
		capa1.style.display='block';
	}
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
	  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <?
			include("../cabecera/menu_superior.php");
			?>	
				  
              </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						include("../menus/menu_lateral.php");
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
								  <!-- INGRESO DE NUEVO CÓDIGO A LA PLANTILLA -->
								  <form name="form" action="InformeConexiones.php" method="post" target="_blank" >
									<table width="650" border="0" align="center" cellpadding="5">
									  <tr>
										<td colspan="2" class="tableindex">BUSCADOR AVANZADO </td>
									  </tr>
									  <tr>
										<td  class="textosimple"><input name="rd_periodo" type="radio" value="1" onClick="visible(this)">
									    Mes</td>
										<td><div align="left">
										  <select name="cmbMES" style="visibility:hidden">
										    <option value="0">seleccione</option>
										    <option value="1">Enero</option>
										    <option value="2">Febrero</option>
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
									      </select>
                                        </div></td>
									  </tr>
									  <tr>
										<td  class="textosimple"><input name="rd_periodo" type="radio" value="2" onClick="visible(this)">
									    Fecha</td>
										<td>
                                        <div id="capa0" style="display:none">
										  <div align="left">
										    <input name="txtFECHA" size="12" maxlength="10"/>
										    <input name="cal1" type="image" src="calendario.gif" class="botadd" id="cal1" value="." height="20" width="20" >
									        </div>
                                        </div>		
                                        <div align="left">
                                          <script type="text/javascript">
									Calendar.setup({
										inputField     :    "txtFECHA",      // id of the input field
										ifFormat       :    "%d/%m/%Y",  // format of the input field (even if hidden, this format will be honored)
										button         :    "cal1",  // trigger button (well, IMG in our case)
										align          :    "Bl",           // alignment (defaults to "Bl")
										singleClick    :    true,
										mondayFirst	   :    true
									});
									    </script>
                                            </div></td>
									  </tr>
									  <tr>
									    <td  class="textosimple"><input name="rd_periodo" type="radio" value="3"  onClick="visible(this)">
								        Rango Fecha </td>
									    <td>
										<div id="capa1" style="display:none">
										  <div align="left">
										    <input name="txtDESDE" type="text" id="txtDESDE" size="12." maxlength="10"> 
										    <input name="cal2" type="image" src="calendario.gif" class="botadd" id="cal2" value="." height="20" width="20">
										    
										          <script type="text/javascript">
									Calendar.setup({
										inputField     :    "txtDESDE",      // id of the input field
										ifFormat       :    "%d/%m/%Y",  // format of the input field (even if hidden, this format will be honored)
										button         :    "cal2",  // trigger button (well, IMG in our case)
										align          :    "Bl",           // alignment (defaults to "Bl")
										singleClick    :    true,
										mondayFirst	   :    true
									});
									    </script>
										    -- 
										    <input name="txtHASTA" type="text" id="txtHASTA" size="12" maxlength="10">
										    <input name="cal3" type="image" src="calendario.gif" class="botadd" id="cal3" value="." height="20" width="20">
										            <script type="text/javascript">
									Calendar.setup({
										inputField     :    "txtHASTA",      // id of the input field
										ifFormat       :    "%d/%m/%Y",  // format of the input field (even if hidden, this format will be honored)
										button         :    "cal3",  // trigger button (well, IMG in our case)
										align          :    "Bl",           // alignment (defaults to "Bl")
										singleClick    :    true,
										mondayFirst	   :    true
									});
									      </script>
									            </div>
										</div>										  </td>
								      </tr>
									  <tr>
										<td>&nbsp;</td>
										<td><input type="submit" name="Submit" value="BUSCAR" class="botonXX"></td>
									  </tr>
									</table>
								  </form>
								  
								  <!-- FIN DEL NUEVO CODIGO DE LA PLANTILLA -->                                  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>