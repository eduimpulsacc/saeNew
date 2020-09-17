
 <SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
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
</script>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<script language="JavaScript">
function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=300, height=266, top=85, left=140";
window.open(pagina,"",opciones);
}
</script> 


<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--link href="../../../estilos.css" rel="stylesheet" type="text/css"-->
<style type="text/css">
.cajaborde tr td form table tr td {
	text-align: center;
}
.m {	font-family: Verdana, Geneva, sans-serif;
}
.m {
	font-size: 11px;
	text-align: justify;
}
.cajaborde tr td form table tr td table tr th {
	text-align: left;
	font-family: Verdana, Geneva, sans-serif;
}
.cajaborde tr td form table tr td table tr td {
	text-align: left;
	font-family: Verdana, Geneva, sans-serif;
}
.cajaborde tr td table tr td table tr td {
	font-size: 12px;
}
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg','../cortes/b_home_r.jpg')">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100%" align="left" valign="top">
	   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <?
			   include("../cabecera/menu_superior2.php");
			   ?></td>
         </tr>
         <tr align="left" valign="top"> 
            <td height="83" colspan="3">
				   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td height="363" align="left" valign="top">
                        
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                              
                              
                              
                              
                              <table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td valign="top">
                                    
                                    <!-- AQUI VA TODA LA PROGRAMACIÓN  -->
                                    
                                  
                                     
                                      <TABLE WIDTH=100% BORDER=0 align="center" CELLPADDING=0 CELLSPACING=5 >
                                        <TR height=15>
                                          <TD align="center"><img src="/../../../../manual_html/images/cursos_3.jpg" width="728" height="516">
                                            <table width="100%" border="0" cellpadding="0" cellspacing="5">
                                              
                                            <tr>
                                                <th width="26%" scope="row">&nbsp;</th>
                                                <td width="73%">Al momento de MODIFICAR podemos configurar las aproximaciones de los promedios<br>
                                                  finales por cada subsector y el promedio general m&aacute;s examen si es configurado as&iacute;,<br>
                                                adem&aacute;s elegimos el profesor jefe, el encargado del acta.<br>
                                                Tambi&eacute;n incluimos las observaciones que se pueden agregar al acta y el puntaje<br>
                                                simce si se desea agregar, m&aacute;s el monto de subvenci&oacute;n por alumno y la capacidad<br>
                                                del curso.</td>
                                                <td width="1%">&nbsp;</td>
                                            </tr>
                                          </table></TD>
                                        </TR>			
                                      </TABLE> 
                                  
                                    
                                    
                                    <!-- FIN DE INGRESO DE CODIGO NUEVO --> 
                                    
                                    
                                  </td>
                                </tr>
                              </table>							  
                            </td>  
                          </tr>
                        </table>                      </td>
                     </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" class="piepagina"><? include("/../../cabecera/menu_inferior.php"); ?>
                        <DIV align="center">SAE&reg;:::::: SISTEMA DE ADMINISTRACI&Oacute;N Y GESTI&Oacute;N ESCOLAR</DIV></td>
                    </tr>
                  </table>
		    </td>
         </tr>
       </table>
    </td>

  </tr>
</table>

</td>
    <td width="53" align="left" valign="top" height="100%" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table> 

</body>
</html>
